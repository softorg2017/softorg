;
(function() {
    'use strict';

    function FastClick(layer, options) {
        var oldOnClick;
        options = options || {};
        this.trackingClick = false;
        this.trackingClickStart = 0;
        this.targetElement = null;
        this.touchStartX = 0;
        this.touchStartY = 0;
        this.lastTouchIdentifier = 0;
        this.touchBoundary = options.touchBoundary || 10;
        this.layer = layer;
        this.tapDelay = options.tapDelay || 200;
        this.tapTimeout = options.tapTimeout || 700;
        if (FastClick.notNeeded(layer)) { return; }

        function bind(method, context) { return function() { return method.apply(context, arguments); }; }
        var methods = ['onMouse', 'onClick', 'onTouchStart', 'onTouchMove', 'onTouchEnd', 'onTouchCancel'];
        var context = this;
        for (var i = 0, l = methods.length; i < l; i++) { context[methods[i]] = bind(context[methods[i]], context); }
        if (deviceIsAndroid) {
            layer.addEventListener('mouseover', this.onMouse, true);
            layer.addEventListener('mousedown', this.onMouse, true);
            layer.addEventListener('mouseup', this.onMouse, true);
        }
        layer.addEventListener('click', this.onClick, true);
        layer.addEventListener('touchstart', this.onTouchStart, false);
        layer.addEventListener('touchmove', this.onTouchMove, false);
        layer.addEventListener('touchend', this.onTouchEnd, false);
        layer.addEventListener('touchcancel', this.onTouchCancel, false);
        if (!Event.prototype.stopImmediatePropagation) {
            layer.removeEventListener = function(type, callback, capture) { var rmv = Node.prototype.removeEventListener; if (type === 'click') { rmv.call(layer, type, callback.hijacked || callback, capture); } else { rmv.call(layer, type, callback, capture); } };
            layer.addEventListener = function(type, callback, capture) { var adv = Node.prototype.addEventListener; if (type === 'click') { adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) { if (!event.propagationStopped) { callback(event); } }), capture); } else { adv.call(layer, type, callback, capture); } };
        }
        if (typeof layer.onclick === 'function') {
            oldOnClick = layer.onclick;
            layer.addEventListener('click', function(event) { oldOnClick(event); }, false);
            layer.onclick = null;
        }
    }
    var deviceIsWindowsPhone = navigator.userAgent.indexOf("Windows Phone") >= 0;
    var deviceIsAndroid = navigator.userAgent.indexOf('Android') > 0 && !deviceIsWindowsPhone;
    var deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent) && !deviceIsWindowsPhone;
    var deviceIsIOS4 = deviceIsIOS && (/OS 4_\d(_\d)?/).test(navigator.userAgent);
    var deviceIsIOSWithBadTarget = deviceIsIOS && (/OS [6-7]_\d/).test(navigator.userAgent);
    var deviceIsBlackBerry10 = navigator.userAgent.indexOf('BB10') > 0;
    FastClick.prototype.needsClick = function(target) {
        switch (target.nodeName.toLowerCase()) {
            case 'button':
            case 'select':
            case 'textarea':
                if (target.disabled) { return true; }
                break;
            case 'input':
                if ((deviceIsIOS && target.type === 'file') || target.disabled) { return true; }
                break;
            case 'label':
            case 'iframe':
            case 'video':
                return true;
        }
        return (/\bneedsclick\b/).test(target.className);
    };
    FastClick.prototype.needsFocus = function(target) {
        switch (target.nodeName.toLowerCase()) {
            case 'textarea':
                return true;
            case 'select':
                return !deviceIsAndroid;
            case 'input':
                switch (target.type) {
                    case 'button':
                    case 'checkbox':
                    case 'file':
                    case 'image':
                    case 'radio':
                    case 'submit':
                        return false;
                }
                return !target.disabled && !target.readOnly;
            default:
                return (/\bneedsfocus\b/).test(target.className);
        }
    };
    FastClick.prototype.sendClick = function(targetElement, event) {
        var clickEvent, touch;
        if (document.activeElement && document.activeElement !== targetElement) { document.activeElement.blur(); } touch = event.changedTouches[0];
        clickEvent = document.createEvent('MouseEvents');
        clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
        clickEvent.forwardedTouchEvent = true;
        targetElement.dispatchEvent(clickEvent);
    };
    FastClick.prototype.determineEventType = function(targetElement) { if (deviceIsAndroid && targetElement.tagName.toLowerCase() === 'select') { return 'mousedown'; } return 'click'; };
    FastClick.prototype.focus = function(targetElement) {
        var length;
        if (deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf('date') !== 0 && targetElement.type !== 'time' && targetElement.type !== 'month') {
            length = targetElement.value.length;
            targetElement.setSelectionRange(length, length);
        } else { targetElement.focus(); }
    };
    FastClick.prototype.updateScrollParent = function(targetElement) {
        var scrollParent, parentElement;
        scrollParent = targetElement.fastClickScrollParent;
        if (!scrollParent || !scrollParent.contains(targetElement)) {
            parentElement = targetElement;
            do {
                if (parentElement.scrollHeight > parentElement.offsetHeight) {
                    scrollParent = parentElement;
                    targetElement.fastClickScrollParent = parentElement;
                    break;
                }
                parentElement = parentElement.parentElement;
            } while (parentElement);
        }
        if (scrollParent) { scrollParent.fastClickLastScrollTop = scrollParent.scrollTop; }
    };
    FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) { if (eventTarget.nodeType === Node.TEXT_NODE) { return eventTarget.parentNode; } return eventTarget; };
    FastClick.prototype.onTouchStart = function(event) {
        var targetElement, touch, selection;
        if (event.targetTouches.length > 1) { return true; } targetElement = this.getTargetElementFromEventTarget(event.target);
        touch = event.targetTouches[0];
        if (deviceIsIOS) {
            selection = window.getSelection();
            if (selection.rangeCount && !selection.isCollapsed) { return true; }
            if (!deviceIsIOS4) {
                if (touch.identifier && touch.identifier === this.lastTouchIdentifier) { event.preventDefault(); return false; } this.lastTouchIdentifier = touch.identifier;
                this.updateScrollParent(targetElement);
            }
        }
        this.trackingClick = true;
        this.trackingClickStart = event.timeStamp;
        this.targetElement = targetElement;
        this.touchStartX = touch.pageX;
        this.touchStartY = touch.pageY;
        if ((event.timeStamp - this.lastClickTime) < this.tapDelay) { event.preventDefault(); }
        return true;
    };
    FastClick.prototype.touchHasMoved = function(event) {
        var touch = event.changedTouches[0],
            boundary = this.touchBoundary;
        if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) { return true; }
        return false;
    };
    FastClick.prototype.onTouchMove = function(event) {
        if (!this.trackingClick) { return true; }
        if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
            this.trackingClick = false;
            this.targetElement = null;
        }
        return true;
    };
    FastClick.prototype.findControl = function(labelElement) { if (labelElement.control !== undefined) { return labelElement.control; } if (labelElement.htmlFor) { return document.getElementById(labelElement.htmlFor); } return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea'); };
    FastClick.prototype.onTouchEnd = function(event) {
        var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;
        if (!this.trackingClick) { return true; }
        if ((event.timeStamp - this.lastClickTime) < this.tapDelay) { this.cancelNextClick = true; return true; }
        if ((event.timeStamp - this.trackingClickStart) > this.tapTimeout) { return true; } this.cancelNextClick = false;
        this.lastClickTime = event.timeStamp;
        trackingClickStart = this.trackingClickStart;
        this.trackingClick = false;
        this.trackingClickStart = 0;
        if (deviceIsIOSWithBadTarget) {
            touch = event.changedTouches[0];
            targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
            targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent;
        }
        targetTagName = targetElement.tagName.toLowerCase();
        if (targetTagName === 'label') { forElement = this.findControl(targetElement); if (forElement) { this.focus(targetElement); if (deviceIsAndroid) { return false; } targetElement = forElement; } } else if (this.needsFocus(targetElement)) {
            if ((event.timeStamp - trackingClickStart) > 100 || (deviceIsIOS && window.top !== window && targetTagName === 'input')) { this.targetElement = null; return false; } this.focus(targetElement);
            this.sendClick(targetElement, event);
            if (!deviceIsIOS || targetTagName !== 'select') {
                this.targetElement = null;
                event.preventDefault();
            }
            return false;
        }
        if (deviceIsIOS && !deviceIsIOS4) { scrollParent = targetElement.fastClickScrollParent; if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) { return true; } }
        if (!this.needsClick(targetElement)) {
            event.preventDefault();
            this.sendClick(targetElement, event);
        }
        return false;
    };
    FastClick.prototype.onTouchCancel = function() {
        this.trackingClick = false;
        this.targetElement = null;
    };
    FastClick.prototype.onMouse = function(event) {
        if (!this.targetElement) { return true; }
        if (event.forwardedTouchEvent) { return true; }
        if (!event.cancelable) { return true; }
        if (!this.needsClick(this.targetElement) || this.cancelNextClick) {
            if (event.stopImmediatePropagation) { event.stopImmediatePropagation(); } else { event.propagationStopped = true; } event.stopPropagation();
            event.preventDefault();
            return false;
        }
        return true;
    };
    FastClick.prototype.onClick = function(event) {
        var permitted;
        if (this.trackingClick) {
            this.targetElement = null;
            this.trackingClick = false;
            return true;
        }
        if (event.target.type === 'submit' && event.detail === 0) { return true; } permitted = this.onMouse(event);
        if (!permitted) { this.targetElement = null; }
        return permitted;
    };
    FastClick.prototype.destroy = function() {
        var layer = this.layer;
        if (deviceIsAndroid) {
            layer.removeEventListener('mouseover', this.onMouse, true);
            layer.removeEventListener('mousedown', this.onMouse, true);
            layer.removeEventListener('mouseup', this.onMouse, true);
        }
        layer.removeEventListener('click', this.onClick, true);
        layer.removeEventListener('touchstart', this.onTouchStart, false);
        layer.removeEventListener('touchmove', this.onTouchMove, false);
        layer.removeEventListener('touchend', this.onTouchEnd, false);
        layer.removeEventListener('touchcancel', this.onTouchCancel, false);
    };
    FastClick.notNeeded = function(layer) { var metaViewport; var chromeVersion; var blackberryVersion; var firefoxVersion; if (typeof window.ontouchstart === 'undefined') { return true; } chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]; if (chromeVersion) { if (deviceIsAndroid) { metaViewport = document.querySelector('meta[name=viewport]'); if (metaViewport) { if (metaViewport.content.indexOf('user-scalable=no') !== -1) { return true; } if (chromeVersion > 31 && document.documentElement.scrollWidth <= window.outerWidth) { return true; } } } else { return true; } } if (deviceIsBlackBerry10) { blackberryVersion = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/); if (blackberryVersion[1] >= 10 && blackberryVersion[2] >= 3) { metaViewport = document.querySelector('meta[name=viewport]'); if (metaViewport) { if (metaViewport.content.indexOf('user-scalable=no') !== -1) { return true; } if (document.documentElement.scrollWidth <= window.outerWidth) { return true; } } } } if (layer.style.msTouchAction === 'none' || layer.style.touchAction === 'manipulation') { return true; } firefoxVersion = +(/Firefox\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]; if (firefoxVersion >= 27) { metaViewport = document.querySelector('meta[name=viewport]'); if (metaViewport && (metaViewport.content.indexOf('user-scalable=no') !== -1 || document.documentElement.scrollWidth <= window.outerWidth)) { return true; } } if (layer.style.touchAction === 'none' || layer.style.touchAction === 'manipulation') { return true; } return false; };
    FastClick.attach = function(layer, options) { return new FastClick(layer, options); };
    if (typeof define === 'function' && typeof define.amd === 'object' && define.amd) { define(function() { return FastClick; }); } else if (typeof module !== 'undefined' && module.exports) {
        module.exports = FastClick.attach;
        module.exports.FastClick = FastClick;
    } else { window.FastClick = FastClick; }
}());;
(function() {
    var a, b, c, d, e, f, g, h, i, j;
    b = window.device, a = {}, window.device = a, d = window.document.documentElement, j = window.navigator.userAgent.toLowerCase(), a.ios = function() { return a.iphone() || a.ipod() || a.ipad() }, a.iphone = function() { return !a.windows() && e("iphone") }, a.ipod = function() { return e("ipod") }, a.ipad = function() { return e("ipad") }, a.android = function() { return !a.windows() && e("android") }, a.androidPhone = function() { return a.android() && e("mobile") }, a.androidTablet = function() { return a.android() && !e("mobile") }, a.blackberry = function() { return e("blackberry") || e("bb10") || e("rim") }, a.blackberryPhone = function() { return a.blackberry() && !e("tablet") }, a.blackberryTablet = function() { return a.blackberry() && e("tablet") }, a.windows = function() { return e("windows") }, a.windowsPhone = function() { return a.windows() && e("phone") }, a.windowsTablet = function() { return a.windows() && e("touch") && !a.windowsPhone() }, a.fxos = function() { return (e("(mobile;") || e("(tablet;")) && e("; rv:") }, a.fxosPhone = function() { return a.fxos() && e("mobile") }, a.fxosTablet = function() { return a.fxos() && e("tablet") }, a.meego = function() { return e("meego") }, a.cordova = function() { return window.cordova && "file:" === location.protocol }, a.nodeWebkit = function() { return "object" == typeof window.process }, a.mobile = function() { return a.androidPhone() || a.iphone() || a.ipod() || a.windowsPhone() || a.blackberryPhone() || a.fxosPhone() || a.meego() }, a.tablet = function() { return a.ipad() || a.androidTablet() || a.blackberryTablet() || a.windowsTablet() || a.fxosTablet() }, a.desktop = function() { return !a.tablet() && !a.mobile() }, a.television = function() {
        var a;
        for (television = ["googletv", "viera", "smarttv", "internet.tv", "netcast", "nettv", "appletv", "boxee", "kylo", "roku", "dlnadoc", "roku", "pov_tv", "hbbtv", "ce-html"], a = 0; a < television.length;) {
            if (e(television[a])) return !0;
            a++
        }
        return !1
    }, a.portrait = function() { return window.innerHeight / window.innerWidth > 1 }, a.landscape = function() { return window.innerHeight / window.innerWidth < 1 }, a.noConflict = function() { return window.device = b, this }, e = function(a) { return -1 !== j.indexOf(a) }, g = function(a) { var b; return b = new RegExp(a, "i"), d.className.match(b) }, c = function(a) {
        var b = null;
        g(a) || (b = d.className.replace(/^\s+|\s+$/g, ""), d.className = b + " " + a)
    }, i = function(a) { g(a) && (d.className = d.className.replace(" " + a, "")) }, a.ios() ? a.ipad() ? c("ios ipad tablet") : a.iphone() ? c("ios iphone mobile") : a.ipod() && c("ios ipod mobile") : a.android() ? c(a.androidTablet() ? "android tablet" : "android mobile") : a.blackberry() ? c(a.blackberryTablet() ? "blackberry tablet" : "blackberry mobile") : a.windows() ? c(a.windowsTablet() ? "windows tablet" : a.windowsPhone() ? "windows mobile" : "desktop") : a.fxos() ? c(a.fxosTablet() ? "fxos tablet" : "fxos mobile") : a.meego() ? c("meego mobile") : a.nodeWebkit() ? c("node-webkit") : a.television() ? c("television") : a.desktop() && c("desktop"), a.cordova() && c("cordova"), f = function() { a.landscape() ? (i("portrait"), c("landscape")) : (i("landscape"), c("portrait")) }, h = Object.prototype.hasOwnProperty.call(window, "onorientationchange") ? "orientationchange" : "resize", window.addEventListener ? window.addEventListener(h, f, !1) : window.attachEvent ? window.attachEvent(h, f) : window[h] = f, f(), "function" == typeof define && "object" == typeof define.amd && define.amd ? define(function() { return a }) : "undefined" != typeof module && module.exports ? module.exports = a : window.device = a
}).call(this);;
(function(b, c) {
    var $ = b.jQuery || b.Cowboy || (b.Cowboy = {}),
        a;
    $.throttle = a = function(e, f, j, i) {
        var h, d = 0;
        if (typeof f !== "boolean") {
            i = j;
            j = f;
            f = c
        }

        function g() {
            var o = this,
                m = +new Date() - d,
                n = arguments;

            function l() {
                d = +new Date();
                j.apply(o, n)
            }

            function k() { h = c }
            if (i && !h) { l() } h && clearTimeout(h);
            if (i === c && m > e) { l() } else { if (f !== true) { h = setTimeout(i ? k : l, i === c ? e - m : e) } }
        }
        if ($.guid) { g.guid = j.guid = j.guid || $.guid++ }
        return g
    };
    $.debounce = function(d, e, f) { return f === c ? a(d, e, false) : a(d, f, e !== false) }
})(this);;
jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing, { def: 'easeOutQuad', swing: function(x, t, b, c, d) { return jQuery.easing[jQuery.easing.def](x, t, b, c, d); }, easeInQuad: function(x, t, b, c, d) { return c * (t /= d) * t + b; }, easeOutQuad: function(x, t, b, c, d) { return -c * (t /= d) * (t - 2) + b; }, easeInOutQuad: function(x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t + b; return -c / 2 * ((--t) * (t - 2) - 1) + b; }, easeInCubic: function(x, t, b, c, d) { return c * (t /= d) * t * t + b; }, easeOutCubic: function(x, t, b, c, d) { return c * ((t = t / d - 1) * t * t + 1) + b; }, easeInOutCubic: function(x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t + b; return c / 2 * ((t -= 2) * t * t + 2) + b; }, easeInQuart: function(x, t, b, c, d) { return c * (t /= d) * t * t * t + b; }, easeOutQuart: function(x, t, b, c, d) { return -c * ((t = t / d - 1) * t * t * t - 1) + b; }, easeInOutQuart: function(x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b; return -c / 2 * ((t -= 2) * t * t * t - 2) + b; }, easeInQuint: function(x, t, b, c, d) { return c * (t /= d) * t * t * t * t + b; }, easeOutQuint: function(x, t, b, c, d) { return c * ((t = t / d - 1) * t * t * t * t + 1) + b; }, easeInOutQuint: function(x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b; return c / 2 * ((t -= 2) * t * t * t * t + 2) + b; }, easeInSine: function(x, t, b, c, d) { return -c * Math.cos(t / d * (Math.PI / 2)) + c + b; }, easeOutSine: function(x, t, b, c, d) { return c * Math.sin(t / d * (Math.PI / 2)) + b; }, easeInOutSine: function(x, t, b, c, d) { return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b; }, easeInExpo: function(x, t, b, c, d) { return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b; }, easeOutExpo: function(x, t, b, c, d) { return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b; }, easeInOutExpo: function(x, t, b, c, d) { if (t == 0) return b; if (t == d) return b + c; if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b; return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b; }, easeInCirc: function(x, t, b, c, d) { return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b; }, easeOutCirc: function(x, t, b, c, d) { return c * Math.sqrt(1 - (t = t / d - 1) * t) + b; }, easeInOutCirc: function(x, t, b, c, d) { if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b; return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b; }, easeInElastic: function(x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3; if (a < Math.abs(c)) { a = c; var s = p / 4; } else var s = p / (2 * Math.PI) * Math.asin(c / a); return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b; }, easeOutElastic: function(x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3; if (a < Math.abs(c)) { a = c; var s = p / 4; } else var s = p / (2 * Math.PI) * Math.asin(c / a); return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b; }, easeInOutElastic: function(x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d / 2) == 2) return b + c; if (!p) p = d * (.3 * 1.5); if (a < Math.abs(c)) { a = c; var s = p / 4; } else var s = p / (2 * Math.PI) * Math.asin(c / a); if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b; return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b; }, easeInBack: function(x, t, b, c, d, s) { if (s == undefined) s = 1.70158; return c * (t /= d) * t * ((s + 1) * t - s) + b; }, easeOutBack: function(x, t, b, c, d, s) { if (s == undefined) s = 1.70158; return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b; }, easeInOutBack: function(x, t, b, c, d, s) { if (s == undefined) s = 1.70158; if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b; return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b; }, easeInBounce: function(x, t, b, c, d) { return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b; }, easeOutBounce: function(x, t, b, c, d) { if ((t /= d) < (1 / 2.75)) { return c * (7.5625 * t * t) + b; } else if (t < (2 / 2.75)) { return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b; } else if (t < (2.5 / 2.75)) { return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b; } else { return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b; } }, easeInOutBounce: function(x, t, b, c, d) { if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b; return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b; } });;;
(function(f) { "use strict"; "function" === typeof define && define.amd ? define(["jquery"], f) : "undefined" !== typeof module && module.exports ? module.exports = f(require("jquery")) : f(jQuery) })(function($) {
    "use strict";

    function n(a) { return !a.nodeName || -1 !== $.inArray(a.nodeName.toLowerCase(), ["iframe", "#document", "html", "body"]) }

    function h(a) { return $.isFunction(a) || $.isPlainObject(a) ? a : { top: a, left: a } }
    var p = $.scrollTo = function(a, d, b) { return $(window).scrollTo(a, d, b) };
    p.defaults = { axis: "xy", duration: 0, limit: !0 };
    $.fn.scrollTo = function(a, d, b) {
        "object" === typeof d && (b = d, d = 0);
        "function" === typeof b && (b = { onAfter: b });
        "max" === a && (a = 9E9);
        b = $.extend({}, p.defaults, b);
        d = d || b.duration;
        var u = b.queue && 1 < b.axis.length;
        u && (d /= 2);
        b.offset = h(b.offset);
        b.over = h(b.over);
        return this.each(function() {
            function k(a) {
                var k = $.extend({}, b, { queue: !0, duration: d, complete: a && function() { a.call(q, e, b) } });
                r.animate(f, k)
            }
            if (null !== a) {
                var l = n(this),
                    q = l ? this.contentWindow || window : this,
                    r = $(q),
                    e = a,
                    f = {},
                    t;
                switch (typeof e) {
                    case "number":
                    case "string":
                        if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)) { e = h(e); break } e = l ? $(e) : $(e, q);
                    case "object":
                        if (e.length === 0) return;
                        if (e.is || e.style) t = (e = $(e)).offset()
                }
                var v = $.isFunction(b.offset) && b.offset(q, e) || b.offset;
                $.each(b.axis.split(""), function(a, c) {
                    var d = "x" === c ? "Left" : "Top",
                        m = d.toLowerCase(),
                        g = "scroll" + d,
                        h = r[g](),
                        n = p.max(q, c);
                    t ? (f[g] = t[m] + (l ? 0 : h - r.offset()[m]), b.margin && (f[g] -= parseInt(e.css("margin" + d), 10) || 0, f[g] -= parseInt(e.css("border" + d + "Width"), 10) || 0), f[g] += v[m] || 0, b.over[m] && (f[g] += e["x" === c ? "width" : "height"]() * b.over[m])) : (d = e[m], f[g] = d.slice && "%" === d.slice(-1) ? parseFloat(d) / 100 * n : d);
                    b.limit && /^\d+$/.test(f[g]) && (f[g] = 0 >= f[g] ? 0 : Math.min(f[g], n));
                    !a && 1 < b.axis.length && (h === f[g] ? f = {} : u && (k(b.onAfterFirst), f = {}))
                });
                k(b.onAfter)
            }
        })
    };
    p.max = function(a, d) {
        var b = "x" === d ? "Width" : "Height",
            h = "scroll" + b;
        if (!n(a)) return a[h] - $(a)[b.toLowerCase()]();
        var b = "client" + b,
            k = a.ownerDocument || a.document,
            l = k.documentElement,
            k = k.body;
        return Math.max(l[h], k[h]) - Math.min(l[b], k[b])
    };
    $.Tween.propHooks.scrollLeft = $.Tween.propHooks.scrollTop = {
        get: function(a) { return $(a.elem)[a.prop]() },
        set: function(a) {
            var d = this.get(a);
            if (a.options.interrupt && a._last && a._last !== d) return $(a.elem).stop();
            var b = Math.round(a.now);
            d !== b && ($(a.elem)[a.prop](b), a._last = this.get(a))
        }
    };
    return p
});;
(function(window, document, Math) {
    var rAF = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) { window.setTimeout(callback, 1000 / 60); };
    var utils = (function() {
        var me = {};
        var _elementStyle = document.createElement('div').style;
        var _vendor = (function() {
            var vendors = ['t', 'webkitT', 'MozT', 'msT', 'OT'],
                transform, i = 0,
                l = vendors.length;
            for (; i < l; i++) { transform = vendors[i] + 'ransform'; if (transform in _elementStyle) return vendors[i].substr(0, vendors[i].length - 1); }
            return false;
        })();

        function _prefixStyle(style) { if (_vendor === false) return false; if (_vendor === '') return style; return _vendor + style.charAt(0).toUpperCase() + style.substr(1); } me.getTime = Date.now || function getTime() { return new Date().getTime(); };
        me.extend = function(target, obj) { for (var i in obj) { target[i] = obj[i]; } };
        me.addEvent = function(el, type, fn, capture) { el.addEventListener(type, fn, !!capture); };
        me.removeEvent = function(el, type, fn, capture) { el.removeEventListener(type, fn, !!capture); };
        me.prefixPointerEvent = function(pointerEvent) { return window.MSPointerEvent ? 'MSPointer' + pointerEvent.charAt(7).toUpperCase() + pointerEvent.substr(8) : pointerEvent; };
        me.momentum = function(current, start, time, lowerMargin, wrapperSize, deceleration) {
            var distance = current - start,
                speed = Math.abs(distance) / time,
                destination, duration;
            deceleration = deceleration === undefined ? 0.0006 : deceleration;
            destination = current + (speed * speed) / (2 * deceleration) * (distance < 0 ? -1 : 1);
            duration = speed / deceleration;
            if (destination < lowerMargin) {
                destination = wrapperSize ? lowerMargin - (wrapperSize / 2.5 * (speed / 8)) : lowerMargin;
                distance = Math.abs(destination - current);
                duration = distance / speed;
            } else if (destination > 0) {
                destination = wrapperSize ? wrapperSize / 2.5 * (speed / 8) : 0;
                distance = Math.abs(current) + destination;
                duration = distance / speed;
            }
            return { destination: Math.round(destination), duration: duration };
        };
        var _transform = _prefixStyle('transform');
        me.extend(me, { hasTransform: _transform !== false, hasPerspective: _prefixStyle('perspective') in _elementStyle, hasTouch: 'ontouchstart' in window, hasPointer: !!(window.PointerEvent || window.MSPointerEvent), hasTransition: _prefixStyle('transition') in _elementStyle });
        me.isBadAndroid = (function() { var appVersion = window.navigator.appVersion; if (/Android/.test(appVersion) && !(/Chrome\/\d/.test(appVersion))) { var safariVersion = appVersion.match(/Safari\/(\d+.\d)/); if (safariVersion && typeof safariVersion === "object" && safariVersion.length >= 2) { return parseFloat(safariVersion[1]) < 535.19; } else { return true; } } else { return false; } })();
        me.extend(me.style = {}, { transform: _transform, transitionTimingFunction: _prefixStyle('transitionTimingFunction'), transitionDuration: _prefixStyle('transitionDuration'), transitionDelay: _prefixStyle('transitionDelay'), transformOrigin: _prefixStyle('transformOrigin') });
        me.hasClass = function(e, c) { var re = new RegExp("(^|\\s)" + c + "(\\s|$)"); return re.test(e.className); };
        me.addClass = function(e, c) {
            if (me.hasClass(e, c)) { return; }
            var newclass = e.className.split(' ');
            newclass.push(c);
            e.className = newclass.join(' ');
        };
        me.removeClass = function(e, c) {
            if (!me.hasClass(e, c)) { return; }
            var re = new RegExp("(^|\\s)" + c + "(\\s|$)", 'g');
            e.className = e.className.replace(re, ' ');
        };
        me.offset = function(el) {
            var left = -el.offsetLeft,
                top = -el.offsetTop;
            while (el = el.offsetParent) {
                left -= el.offsetLeft;
                top -= el.offsetTop;
            }
            return { left: left, top: top };
        };
        me.preventDefaultException = function(el, exceptions) { for (var i in exceptions) { if (exceptions[i].test(el[i])) { return true; } } return false; };
        me.extend(me.eventType = {}, { touchstart: 1, touchmove: 1, touchend: 1, mousedown: 2, mousemove: 2, mouseup: 2, pointerdown: 3, pointermove: 3, pointerup: 3, MSPointerDown: 3, MSPointerMove: 3, MSPointerUp: 3 });
        me.extend(me.ease = {}, {
            quadratic: { style: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)', fn: function(k) { return k * (2 - k); } },
            circular: { style: 'cubic-bezier(0.1, 0.57, 0.1, 1)', fn: function(k) { return Math.sqrt(1 - (--k * k)); } },
            back: { style: 'cubic-bezier(0.175, 0.885, 0.32, 1.275)', fn: function(k) { var b = 4; return (k = k - 1) * k * ((b + 1) * k + b) + 1; } },
            bounce: { style: '', fn: function(k) { if ((k /= 1) < (1 / 2.75)) { return 7.5625 * k * k; } else if (k < (2 / 2.75)) { return 7.5625 * (k -= (1.5 / 2.75)) * k + 0.75; } else if (k < (2.5 / 2.75)) { return 7.5625 * (k -= (2.25 / 2.75)) * k + 0.9375; } else { return 7.5625 * (k -= (2.625 / 2.75)) * k + 0.984375; } } },
            elastic: {
                style: '',
                fn: function(k) {
                    var f = 0.22,
                        e = 0.4;
                    if (k === 0) { return 0; }
                    if (k == 1) { return 1; }
                    return (e * Math.pow(2, -10 * k) * Math.sin((k - f / 4) * (2 * Math.PI) / f) + 1);
                }
            }
        });
        me.tap = function(e, eventName) {
            var ev = document.createEvent('Event');
            ev.initEvent(eventName, true, true);
            ev.pageX = e.pageX;
            ev.pageY = e.pageY;
            e.target.dispatchEvent(ev);
        };
        me.click = function(e) {
            var target = e.target,
                ev;
            if (!(/(SELECT|INPUT|TEXTAREA)/i).test(target.tagName)) {
                ev = document.createEvent('MouseEvents');
                ev.initMouseEvent('click', true, true, e.view, 1, target.screenX, target.screenY, target.clientX, target.clientY, e.ctrlKey, e.altKey, e.shiftKey, e.metaKey, 0, null);
                ev._constructed = true;
                target.dispatchEvent(ev);
            }
        };
        return me;
    })();

    function IScroll(el, options) {
        this.wrapper = typeof el == 'string' ? document.querySelector(el) : el;
        this.scroller = this.wrapper.children[0];
        this.scrollerStyle = this.scroller.style;
        this.options = { resizeScrollbars: true, mouseWheelSpeed: 20, snapThreshold: 0.334, disablePointer: !utils.hasPointer, disableTouch: utils.hasPointer || !utils.hasTouch, disableMouse: utils.hasPointer || utils.hasTouch, startX: 0, startY: 0, scrollY: true, directionLockThreshold: 5, momentum: true, bounce: true, bounceTime: 600, bounceEasing: '', preventDefault: true, preventDefaultException: { tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT)$/ }, HWCompositing: true, useTransition: true, useTransform: true, bindToWrapper: typeof window.onmousedown === "undefined" };
        for (var i in options) { this.options[i] = options[i]; } this.translateZ = this.options.HWCompositing && utils.hasPerspective ? ' translateZ(0)' : '';
        this.options.useTransition = utils.hasTransition && this.options.useTransition;
        this.options.useTransform = utils.hasTransform && this.options.useTransform;
        this.options.eventPassthrough = this.options.eventPassthrough === true ? 'vertical' : this.options.eventPassthrough;
        this.options.preventDefault = !this.options.eventPassthrough && this.options.preventDefault;
        this.options.scrollY = this.options.eventPassthrough == 'vertical' ? false : this.options.scrollY;
        this.options.scrollX = this.options.eventPassthrough == 'horizontal' ? false : this.options.scrollX;
        this.options.freeScroll = this.options.freeScroll && !this.options.eventPassthrough;
        this.options.directionLockThreshold = this.options.eventPassthrough ? 0 : this.options.directionLockThreshold;
        this.options.bounceEasing = typeof this.options.bounceEasing == 'string' ? utils.ease[this.options.bounceEasing] || utils.ease.circular : this.options.bounceEasing;
        this.options.resizePolling = this.options.resizePolling === undefined ? 60 : this.options.resizePolling;
        if (this.options.tap === true) { this.options.tap = 'tap'; }
        if (this.options.shrinkScrollbars == 'scale') { this.options.useTransition = false; } this.options.invertWheelDirection = this.options.invertWheelDirection ? -1 : 1;
        if (this.options.probeType == 3) { this.options.useTransition = false; } this.x = 0;
        this.y = 0;
        this.directionX = 0;
        this.directionY = 0;
        this._events = {};
        this._init();
        this.refresh();
        this.scrollTo(this.options.startX, this.options.startY);
        this.enable();
    }
    IScroll.prototype = {
        version: '5.2.0',
        _init: function() { this._initEvents(); if (this.options.scrollbars || this.options.indicators) { this._initIndicators(); } if (this.options.mouseWheel) { this._initWheel(); } if (this.options.snap) { this._initSnap(); } if (this.options.keyBindings) { this._initKeys(); } },
        destroy: function() {
            this._initEvents(true);
            clearTimeout(this.resizeTimeout);
            this.resizeTimeout = null;
            this._execEvent('destroy');
        },
        _transitionEnd: function(e) {
            if (e.target != this.scroller || !this.isInTransition) { return; } this._transitionTime();
            if (!this.resetPosition(this.options.bounceTime)) {
                this.isInTransition = false;
                this._execEvent('scrollEnd');
            }
        },
        _start: function(e) {
            if (utils.eventType[e.type] != 1) { var button; if (!e.which) { button = (e.button < 2) ? 0 : ((e.button == 4) ? 1 : 2); } else { button = e.button; } if (button !== 0) { return; } }
            if (!this.enabled || (this.initiated && utils.eventType[e.type] !== this.initiated)) { return; }
            if (this.options.preventDefault && !utils.isBadAndroid && !utils.preventDefaultException(e.target, this.options.preventDefaultException)) { e.preventDefault(); }
            var point = e.touches ? e.touches[0] : e,
                pos;
            this.initiated = utils.eventType[e.type];
            this.moved = false;
            this.distX = 0;
            this.distY = 0;
            this.directionX = 0;
            this.directionY = 0;
            this.directionLocked = 0;
            this.startTime = utils.getTime();
            if (this.options.useTransition && this.isInTransition) {
                this._transitionTime();
                this.isInTransition = false;
                pos = this.getComputedPosition();
                this._translate(Math.round(pos.x), Math.round(pos.y));
                this._execEvent('scrollEnd');
            } else if (!this.options.useTransition && this.isAnimating) {
                this.isAnimating = false;
                this._execEvent('scrollEnd');
            }
            this.startX = this.x;
            this.startY = this.y;
            this.absStartX = this.x;
            this.absStartY = this.y;
            this.pointX = point.pageX;
            this.pointY = point.pageY;
            this._execEvent('beforeScrollStart');
        },
        _move: function(e) {
            if (!this.enabled || utils.eventType[e.type] !== this.initiated) { return; }
            if (this.options.preventDefault) { e.preventDefault(); }
            var point = e.touches ? e.touches[0] : e,
                deltaX = point.pageX - this.pointX,
                deltaY = point.pageY - this.pointY,
                timestamp = utils.getTime(),
                newX, newY, absDistX, absDistY;
            this.pointX = point.pageX;
            this.pointY = point.pageY;
            this.distX += deltaX;
            this.distY += deltaY;
            absDistX = Math.abs(this.distX);
            absDistY = Math.abs(this.distY);
            if (timestamp - this.endTime > 300 && (absDistX < 10 && absDistY < 10)) { return; }
            if (!this.directionLocked && !this.options.freeScroll) { if (absDistX > absDistY + this.options.directionLockThreshold) { this.directionLocked = 'h'; } else if (absDistY >= absDistX + this.options.directionLockThreshold) { this.directionLocked = 'v'; } else { this.directionLocked = 'n'; } }
            if (this.directionLocked == 'h') { if (this.options.eventPassthrough == 'vertical') { e.preventDefault(); } else if (this.options.eventPassthrough == 'horizontal') { this.initiated = false; return; } deltaY = 0; } else if (this.directionLocked == 'v') { if (this.options.eventPassthrough == 'horizontal') { e.preventDefault(); } else if (this.options.eventPassthrough == 'vertical') { this.initiated = false; return; } deltaX = 0; } deltaX = this.hasHorizontalScroll ? deltaX : 0;
            deltaY = this.hasVerticalScroll ? deltaY : 0;
            newX = this.x + deltaX;
            newY = this.y + deltaY;
            if (newX > 0 || newX < this.maxScrollX) { newX = this.options.bounce ? this.x + deltaX / 3 : newX > 0 ? 0 : this.maxScrollX; }
            if (newY > 0 || newY < this.maxScrollY) { newY = this.options.bounce ? this.y + deltaY / 3 : newY > 0 ? 0 : this.maxScrollY; } this.directionX = deltaX > 0 ? -1 : deltaX < 0 ? 1 : 0;
            this.directionY = deltaY > 0 ? -1 : deltaY < 0 ? 1 : 0;
            if (!this.moved) { this._execEvent('scrollStart'); } this.moved = true;
            this._translate(newX, newY);
            if (timestamp - this.startTime > 300) {
                this.startTime = timestamp;
                this.startX = this.x;
                this.startY = this.y;
                if (this.options.probeType == 1) { this._execEvent('scroll'); }
            }
            if (this.options.probeType > 1) { this._execEvent('scroll'); }
        },
        _end: function(e) {
            if (!this.enabled || utils.eventType[e.type] !== this.initiated) { return; }
            if (this.options.preventDefault && !utils.preventDefaultException(e.target, this.options.preventDefaultException)) { e.preventDefault(); }
            var point = e.changedTouches ? e.changedTouches[0] : e,
                momentumX, momentumY, duration = utils.getTime() - this.startTime,
                newX = Math.round(this.x),
                newY = Math.round(this.y),
                distanceX = Math.abs(newX - this.startX),
                distanceY = Math.abs(newY - this.startY),
                time = 0,
                easing = '';
            this.isInTransition = 0;
            this.initiated = 0;
            this.endTime = utils.getTime();
            if (this.resetPosition(this.options.bounceTime)) { return; } this.scrollTo(newX, newY);
            if (!this.moved) { if (this.options.tap) { utils.tap(e, this.options.tap); } if (this.options.click) { utils.click(e); } this._execEvent('scrollCancel'); return; }
            if (this._events.flick && duration < 200 && distanceX < 100 && distanceY < 100) { this._execEvent('flick'); return; }
            if (this.options.momentum && duration < 300) {
                momentumX = this.hasHorizontalScroll ? utils.momentum(this.x, this.startX, duration, this.maxScrollX, this.options.bounce ? this.wrapperWidth : 0, this.options.deceleration) : { destination: newX, duration: 0 };
                momentumY = this.hasVerticalScroll ? utils.momentum(this.y, this.startY, duration, this.maxScrollY, this.options.bounce ? this.wrapperHeight : 0, this.options.deceleration) : { destination: newY, duration: 0 };
                newX = momentumX.destination;
                newY = momentumY.destination;
                time = Math.max(momentumX.duration, momentumY.duration);
                this.isInTransition = 1;
            }
            if (this.options.snap) {
                var snap = this._nearestSnap(newX, newY);
                this.currentPage = snap;
                time = this.options.snapSpeed || Math.max(Math.max(Math.min(Math.abs(newX - snap.x), 1000), Math.min(Math.abs(newY - snap.y), 1000)), 300);
                newX = snap.x;
                newY = snap.y;
                this.directionX = 0;
                this.directionY = 0;
                easing = this.options.bounceEasing;
            }
            if (newX != this.x || newY != this.y) { if (newX > 0 || newX < this.maxScrollX || newY > 0 || newY < this.maxScrollY) { easing = utils.ease.quadratic; } this.scrollTo(newX, newY, time, easing); return; } this._execEvent('scrollEnd');
        },
        _resize: function() {
            var that = this;
            clearTimeout(this.resizeTimeout);
            this.resizeTimeout = setTimeout(function() { that.refresh(); }, this.options.resizePolling);
        },
        resetPosition: function(time) {
            var x = this.x,
                y = this.y;
            time = time || 0;
            if (!this.hasHorizontalScroll || this.x > 0) { x = 0; } else if (this.x < this.maxScrollX) { x = this.maxScrollX; }
            if (!this.hasVerticalScroll || this.y > 0) { y = 0; } else if (this.y < this.maxScrollY) { y = this.maxScrollY; }
            if (x == this.x && y == this.y) { return false; } this.scrollTo(x, y, time, this.options.bounceEasing);
            return true;
        },
        disable: function() { this.enabled = false; },
        enable: function() { this.enabled = true; },
        refresh: function() {
            var rf = this.wrapper.offsetHeight;
            this.wrapperWidth = this.wrapper.clientWidth;
            this.wrapperHeight = this.wrapper.clientHeight;
            this.scrollerWidth = this.scroller.offsetWidth;
            this.scrollerHeight = this.scroller.offsetHeight;
            this.maxScrollX = this.wrapperWidth - this.scrollerWidth;
            this.maxScrollY = this.wrapperHeight - this.scrollerHeight;
            this.hasHorizontalScroll = this.options.scrollX && this.maxScrollX < 0;
            this.hasVerticalScroll = this.options.scrollY && this.maxScrollY < 0;
            if (!this.hasHorizontalScroll) {
                this.maxScrollX = 0;
                this.scrollerWidth = this.wrapperWidth;
            }
            if (!this.hasVerticalScroll) {
                this.maxScrollY = 0;
                this.scrollerHeight = this.wrapperHeight;
            }
            this.endTime = 0;
            this.directionX = 0;
            this.directionY = 0;
            this.wrapperOffset = utils.offset(this.wrapper);
            this._execEvent('refresh');
            this.resetPosition();
        },
        on: function(type, fn) { if (!this._events[type]) { this._events[type] = []; } this._events[type].push(fn); },
        off: function(type, fn) { if (!this._events[type]) { return; } var index = this._events[type].indexOf(fn); if (index > -1) { this._events[type].splice(index, 1); } },
        _execEvent: function(type) {
            if (!this._events[type]) { return; }
            var i = 0,
                l = this._events[type].length;
            if (!l) { return; }
            for (; i < l; i++) { this._events[type][i].apply(this, [].slice.call(arguments, 1)); }
        },
        scrollBy: function(x, y, time, easing) {
            x = this.x + x;
            y = this.y + y;
            time = time || 0;
            this.scrollTo(x, y, time, easing);
        },
        scrollTo: function(x, y, time, easing) {
            easing = easing || utils.ease.circular;
            this.isInTransition = this.options.useTransition && time > 0;
            var transitionType = this.options.useTransition && easing.style;
            if (!time || transitionType) {
                if (transitionType) {
                    this._transitionTimingFunction(easing.style);
                    this._transitionTime(time);
                }
                this._translate(x, y);
            } else { this._animate(x, y, time, easing.fn); }
        },
        scrollToElement: function(el, time, offsetX, offsetY, easing) {
            el = el.nodeType ? el : this.scroller.querySelector(el);
            if (!el) { return; }
            var pos = utils.offset(el);
            pos.left -= this.wrapperOffset.left;
            pos.top -= this.wrapperOffset.top;
            if (offsetX === true) { offsetX = Math.round(el.offsetWidth / 2 - this.wrapper.offsetWidth / 2); }
            if (offsetY === true) { offsetY = Math.round(el.offsetHeight / 2 - this.wrapper.offsetHeight / 2); } pos.left -= offsetX || 0;
            pos.top -= offsetY || 0;
            pos.left = pos.left > 0 ? 0 : pos.left < this.maxScrollX ? this.maxScrollX : pos.left;
            pos.top = pos.top > 0 ? 0 : pos.top < this.maxScrollY ? this.maxScrollY : pos.top;
            time = time === undefined || time === null || time === 'auto' ? Math.max(Math.abs(this.x - pos.left), Math.abs(this.y - pos.top)) : time;
            this.scrollTo(pos.left, pos.top, time, easing);
        },
        _transitionTime: function(time) {
            time = time || 0;
            var durationProp = utils.style.transitionDuration;
            this.scrollerStyle[durationProp] = time + 'ms';
            if (!time && utils.isBadAndroid) {
                this.scrollerStyle[durationProp] = '0.0001ms';
                var self = this;
                rAF(function() { if (self.scrollerStyle[durationProp] === '0.0001ms') { self.scrollerStyle[durationProp] = '0s'; } });
            }
            if (this.indicators) { for (var i = this.indicators.length; i--;) { this.indicators[i].transitionTime(time); } }
        },
        _transitionTimingFunction: function(easing) { this.scrollerStyle[utils.style.transitionTimingFunction] = easing; if (this.indicators) { for (var i = this.indicators.length; i--;) { this.indicators[i].transitionTimingFunction(easing); } } },
        _translate: function(x, y) {
            if (this.options.useTransform) { this.scrollerStyle[utils.style.transform] = 'translate(' + x + 'px,' + y + 'px)' + this.translateZ; } else {
                x = Math.round(x);
                y = Math.round(y);
                this.scrollerStyle.left = x + 'px';
                this.scrollerStyle.top = y + 'px';
            }
            this.x = x;
            this.y = y;
            if (this.indicators) { for (var i = this.indicators.length; i--;) { this.indicators[i].updatePosition(); } }
        },
        _initEvents: function(remove) {
            var eventType = remove ? utils.removeEvent : utils.addEvent,
                target = this.options.bindToWrapper ? this.wrapper : window;
            eventType(window, 'orientationchange', this);
            eventType(window, 'resize', this);
            if (this.options.click) { eventType(this.wrapper, 'click', this, true); }
            if (!this.options.disableMouse) {
                eventType(this.wrapper, 'mousedown', this);
                eventType(target, 'mousemove', this);
                eventType(target, 'mousecancel', this);
                eventType(target, 'mouseup', this);
            }
            if (utils.hasPointer && !this.options.disablePointer) {
                eventType(this.wrapper, utils.prefixPointerEvent('pointerdown'), this);
                eventType(target, utils.prefixPointerEvent('pointermove'), this);
                eventType(target, utils.prefixPointerEvent('pointercancel'), this);
                eventType(target, utils.prefixPointerEvent('pointerup'), this);
            }
            if (utils.hasTouch && !this.options.disableTouch) {
                eventType(this.wrapper, 'touchstart', this);
                eventType(target, 'touchmove', this);
                eventType(target, 'touchcancel', this);
                eventType(target, 'touchend', this);
            }
            eventType(this.scroller, 'transitionend', this);
            eventType(this.scroller, 'webkitTransitionEnd', this);
            eventType(this.scroller, 'oTransitionEnd', this);
            eventType(this.scroller, 'MSTransitionEnd', this);
        },
        getComputedPosition: function() {
            var matrix = window.getComputedStyle(this.scroller, null),
                x, y;
            if (this.options.useTransform) {
                matrix = matrix[utils.style.transform].split(')')[0].split(', ');
                x = +(matrix[12] || matrix[4]);
                y = +(matrix[13] || matrix[5]);
            } else {
                x = +matrix.left.replace(/[^-\d.]/g, '');
                y = +matrix.top.replace(/[^-\d.]/g, '');
            }
            return { x: x, y: y };
        },
        _initIndicators: function() {
            var interactive = this.options.interactiveScrollbars,
                customStyle = typeof this.options.scrollbars != 'string',
                indicators = [],
                indicator;
            var that = this;
            this.indicators = [];
            if (this.options.scrollbars) {
                if (this.options.scrollY) {
                    indicator = { el: createDefaultScrollbar('v', interactive, this.options.scrollbars), interactive: interactive, defaultScrollbars: true, customStyle: customStyle, resize: this.options.resizeScrollbars, shrink: this.options.shrinkScrollbars, fade: this.options.fadeScrollbars, listenX: false };
                    this.wrapper.appendChild(indicator.el);
                    indicators.push(indicator);
                }
                if (this.options.scrollX) {
                    indicator = { el: createDefaultScrollbar('h', interactive, this.options.scrollbars), interactive: interactive, defaultScrollbars: true, customStyle: customStyle, resize: this.options.resizeScrollbars, shrink: this.options.shrinkScrollbars, fade: this.options.fadeScrollbars, listenY: false };
                    this.wrapper.appendChild(indicator.el);
                    indicators.push(indicator);
                }
            }
            if (this.options.indicators) { indicators = indicators.concat(this.options.indicators); }
            for (var i = indicators.length; i--;) { this.indicators.push(new Indicator(this, indicators[i])); }

            function _indicatorsMap(fn) { if (that.indicators) { for (var i = that.indicators.length; i--;) { fn.call(that.indicators[i]); } } }
            if (this.options.fadeScrollbars) {
                this.on('scrollEnd', function() { _indicatorsMap(function() { this.fade(); }); });
                this.on('scrollCancel', function() { _indicatorsMap(function() { this.fade(); }); });
                this.on('scrollStart', function() { _indicatorsMap(function() { this.fade(1); }); });
                this.on('beforeScrollStart', function() { _indicatorsMap(function() { this.fade(1, true); }); });
            }
            this.on('refresh', function() { _indicatorsMap(function() { this.refresh(); }); });
            this.on('destroy', function() {
                _indicatorsMap(function() { this.destroy(); });
                delete this.indicators;
            });
        },
        _initWheel: function() {
            utils.addEvent(this.wrapper, 'wheel', this);
            utils.addEvent(this.wrapper, 'mousewheel', this);
            utils.addEvent(this.wrapper, 'DOMMouseScroll', this);
            this.on('destroy', function() {
                clearTimeout(this.wheelTimeout);
                this.wheelTimeout = null;
                utils.removeEvent(this.wrapper, 'wheel', this);
                utils.removeEvent(this.wrapper, 'mousewheel', this);
                utils.removeEvent(this.wrapper, 'DOMMouseScroll', this);
            });
        },
        _wheel: function(e) {
            if (!this.enabled) { return; } e.preventDefault();
            var wheelDeltaX, wheelDeltaY, newX, newY, that = this;
            if (this.wheelTimeout === undefined) { that._execEvent('scrollStart'); } clearTimeout(this.wheelTimeout);
            this.wheelTimeout = setTimeout(function() { if (!that.options.snap) { that._execEvent('scrollEnd'); } that.wheelTimeout = undefined; }, 400);
            if ('deltaX' in e) {
                if (e.deltaMode === 1) {
                    wheelDeltaX = -e.deltaX * this.options.mouseWheelSpeed;
                    wheelDeltaY = -e.deltaY * this.options.mouseWheelSpeed;
                } else {
                    wheelDeltaX = -e.deltaX;
                    wheelDeltaY = -e.deltaY;
                }
            } else if ('wheelDeltaX' in e) {
                wheelDeltaX = e.wheelDeltaX / 120 * this.options.mouseWheelSpeed;
                wheelDeltaY = e.wheelDeltaY / 120 * this.options.mouseWheelSpeed;
            } else if ('wheelDelta' in e) { wheelDeltaX = wheelDeltaY = e.wheelDelta / 120 * this.options.mouseWheelSpeed; } else if ('detail' in e) { wheelDeltaX = wheelDeltaY = -e.detail / 3 * this.options.mouseWheelSpeed; } else { return; } wheelDeltaX *= this.options.invertWheelDirection;
            wheelDeltaY *= this.options.invertWheelDirection;
            if (!this.hasVerticalScroll) {
                wheelDeltaX = wheelDeltaY;
                wheelDeltaY = 0;
            }
            if (this.options.snap) {
                newX = this.currentPage.pageX;
                newY = this.currentPage.pageY;
                if (wheelDeltaX > 0) { newX--; } else if (wheelDeltaX < 0) { newX++; }
                if (wheelDeltaY > 0) { newY--; } else if (wheelDeltaY < 0) { newY++; } this.goToPage(newX, newY);
                return;
            }
            newX = this.x + Math.round(this.hasHorizontalScroll ? wheelDeltaX : 0);
            newY = this.y + Math.round(this.hasVerticalScroll ? wheelDeltaY : 0);
            this.directionX = wheelDeltaX > 0 ? -1 : wheelDeltaX < 0 ? 1 : 0;
            this.directionY = wheelDeltaY > 0 ? -1 : wheelDeltaY < 0 ? 1 : 0;
            if (newX > 0) { newX = 0; } else if (newX < this.maxScrollX) { newX = this.maxScrollX; }
            if (newY > 0) { newY = 0; } else if (newY < this.maxScrollY) { newY = this.maxScrollY; } this.scrollTo(newX, newY, 0);
            if (this.options.probeType > 1) { this._execEvent('scroll'); }
        },
        _initSnap: function() {
            this.currentPage = {};
            if (typeof this.options.snap == 'string') { this.options.snap = this.scroller.querySelectorAll(this.options.snap); } this.on('refresh', function() {
                var i = 0,
                    l, m = 0,
                    n, cx, cy, x = 0,
                    y, stepX = this.options.snapStepX || this.wrapperWidth,
                    stepY = this.options.snapStepY || this.wrapperHeight,
                    el;
                this.pages = [];
                if (!this.wrapperWidth || !this.wrapperHeight || !this.scrollerWidth || !this.scrollerHeight) { return; }
                if (this.options.snap === true) {
                    cx = Math.round(stepX / 2);
                    cy = Math.round(stepY / 2);
                    while (x > -this.scrollerWidth) {
                        this.pages[i] = [];
                        l = 0;
                        y = 0;
                        while (y > -this.scrollerHeight) {
                            this.pages[i][l] = { x: Math.max(x, this.maxScrollX), y: Math.max(y, this.maxScrollY), width: stepX, height: stepY, cx: x - cx, cy: y - cy };
                            y -= stepY;
                            l++;
                        }
                        x -= stepX;
                        i++;
                    }
                } else {
                    el = this.options.snap;
                    l = el.length;
                    n = -1;
                    for (; i < l; i++) {
                        if (i === 0 || el[i].offsetLeft <= el[i - 1].offsetLeft) {
                            m = 0;
                            n++;
                        }
                        if (!this.pages[m]) { this.pages[m] = []; } x = Math.max(-el[i].offsetLeft, this.maxScrollX);
                        y = Math.max(-el[i].offsetTop, this.maxScrollY);
                        cx = x - Math.round(el[i].offsetWidth / 2);
                        cy = y - Math.round(el[i].offsetHeight / 2);
                        this.pages[m][n] = { x: x, y: y, width: el[i].offsetWidth, height: el[i].offsetHeight, cx: cx, cy: cy };
                        if (x > this.maxScrollX) { m++; }
                    }
                }
                this.goToPage(this.currentPage.pageX || 0, this.currentPage.pageY || 0, 0);
                if (this.options.snapThreshold % 1 === 0) {
                    this.snapThresholdX = this.options.snapThreshold;
                    this.snapThresholdY = this.options.snapThreshold;
                } else {
                    this.snapThresholdX = Math.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].width * this.options.snapThreshold);
                    this.snapThresholdY = Math.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].height * this.options.snapThreshold);
                }
            });
            this.on('flick', function() {
                var time = this.options.snapSpeed || Math.max(Math.max(Math.min(Math.abs(this.x - this.startX), 1000), Math.min(Math.abs(this.y - this.startY), 1000)), 300);
                this.goToPage(this.currentPage.pageX + this.directionX, this.currentPage.pageY + this.directionY, time);
            });
        },
        _nearestSnap: function(x, y) {
            if (!this.pages.length) { return { x: 0, y: 0, pageX: 0, pageY: 0 }; }
            var i = 0,
                l = this.pages.length,
                m = 0;
            if (Math.abs(x - this.absStartX) < this.snapThresholdX && Math.abs(y - this.absStartY) < this.snapThresholdY) { return this.currentPage; }
            if (x > 0) { x = 0; } else if (x < this.maxScrollX) { x = this.maxScrollX; }
            if (y > 0) { y = 0; } else if (y < this.maxScrollY) { y = this.maxScrollY; }
            for (; i < l; i++) { if (x >= this.pages[i][0].cx) { x = this.pages[i][0].x; break; } } l = this.pages[i].length;
            for (; m < l; m++) { if (y >= this.pages[0][m].cy) { y = this.pages[0][m].y; break; } }
            if (i == this.currentPage.pageX) { i += this.directionX; if (i < 0) { i = 0; } else if (i >= this.pages.length) { i = this.pages.length - 1; } x = this.pages[i][0].x; }
            if (m == this.currentPage.pageY) { m += this.directionY; if (m < 0) { m = 0; } else if (m >= this.pages[0].length) { m = this.pages[0].length - 1; } y = this.pages[0][m].y; }
            return { x: x, y: y, pageX: i, pageY: m };
        },
        goToPage: function(x, y, time, easing) {
            easing = easing || this.options.bounceEasing;
            if (x >= this.pages.length) { x = this.pages.length - 1; } else if (x < 0) { x = 0; }
            if (y >= this.pages[x].length) { y = this.pages[x].length - 1; } else if (y < 0) { y = 0; }
            var posX = this.pages[x][y].x,
                posY = this.pages[x][y].y;
            time = time === undefined ? this.options.snapSpeed || Math.max(Math.max(Math.min(Math.abs(posX - this.x), 1000), Math.min(Math.abs(posY - this.y), 1000)), 300) : time;
            this.currentPage = { x: posX, y: posY, pageX: x, pageY: y };
            this.scrollTo(posX, posY, time, easing);
        },
        next: function(time, easing) {
            var x = this.currentPage.pageX,
                y = this.currentPage.pageY;
            x++;
            if (x >= this.pages.length && this.hasVerticalScroll) {
                x = 0;
                y++;
            }
            this.goToPage(x, y, time, easing);
        },
        prev: function(time, easing) {
            var x = this.currentPage.pageX,
                y = this.currentPage.pageY;
            x--;
            if (x < 0 && this.hasVerticalScroll) {
                x = 0;
                y--;
            }
            this.goToPage(x, y, time, easing);
        },
        _initKeys: function(e) {
            var keys = { pageUp: 33, pageDown: 34, end: 35, home: 36, left: 37, up: 38, right: 39, down: 40 };
            var i;
            if (typeof this.options.keyBindings == 'object') { for (i in this.options.keyBindings) { if (typeof this.options.keyBindings[i] == 'string') { this.options.keyBindings[i] = this.options.keyBindings[i].toUpperCase().charCodeAt(0); } } } else { this.options.keyBindings = {}; }
            for (i in keys) { this.options.keyBindings[i] = this.options.keyBindings[i] || keys[i]; } utils.addEvent(window, 'keydown', this);
            this.on('destroy', function() { utils.removeEvent(window, 'keydown', this); });
        },
        _key: function(e) {
            if (!this.enabled) { return; }
            var snap = this.options.snap,
                newX = snap ? this.currentPage.pageX : this.x,
                newY = snap ? this.currentPage.pageY : this.y,
                now = utils.getTime(),
                prevTime = this.keyTime || 0,
                acceleration = 0.250,
                pos;
            if (this.options.useTransition && this.isInTransition) {
                pos = this.getComputedPosition();
                this._translate(Math.round(pos.x), Math.round(pos.y));
                this.isInTransition = false;
            }
            this.keyAcceleration = now - prevTime < 200 ? Math.min(this.keyAcceleration + acceleration, 50) : 0;
            switch (e.keyCode) {
                case this.options.keyBindings.pageUp:
                    if (this.hasHorizontalScroll && !this.hasVerticalScroll) { newX += snap ? 1 : this.wrapperWidth; } else { newY += snap ? 1 : this.wrapperHeight; }
                    break;
                case this.options.keyBindings.pageDown:
                    if (this.hasHorizontalScroll && !this.hasVerticalScroll) { newX -= snap ? 1 : this.wrapperWidth; } else { newY -= snap ? 1 : this.wrapperHeight; }
                    break;
                case this.options.keyBindings.end:
                    newX = snap ? this.pages.length - 1 : this.maxScrollX;
                    newY = snap ? this.pages[0].length - 1 : this.maxScrollY;
                    break;
                case this.options.keyBindings.home:
                    newX = 0;
                    newY = 0;
                    break;
                case this.options.keyBindings.left:
                    newX += snap ? -1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.up:
                    newY += snap ? 1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.right:
                    newX -= snap ? -1 : 5 + this.keyAcceleration >> 0;
                    break;
                case this.options.keyBindings.down:
                    newY -= snap ? 1 : 5 + this.keyAcceleration >> 0;
                    break;
                default:
                    return;
            }
            if (snap) { this.goToPage(newX, newY); return; }
            if (newX > 0) {
                newX = 0;
                this.keyAcceleration = 0;
            } else if (newX < this.maxScrollX) {
                newX = this.maxScrollX;
                this.keyAcceleration = 0;
            }
            if (newY > 0) {
                newY = 0;
                this.keyAcceleration = 0;
            } else if (newY < this.maxScrollY) {
                newY = this.maxScrollY;
                this.keyAcceleration = 0;
            }
            this.scrollTo(newX, newY, 0);
            this.keyTime = now;
        },
        _animate: function(destX, destY, duration, easingFn) {
            var that = this,
                startX = this.x,
                startY = this.y,
                startTime = utils.getTime(),
                destTime = startTime + duration;

            function step() {
                var now = utils.getTime(),
                    newX, newY, easing;
                if (now >= destTime) {
                    that.isAnimating = false;
                    that._translate(destX, destY);
                    if (!that.resetPosition(that.options.bounceTime)) { that._execEvent('scrollEnd'); }
                    return;
                }
                now = (now - startTime) / duration;
                easing = easingFn(now);
                newX = (destX - startX) * easing + startX;
                newY = (destY - startY) * easing + startY;
                that._translate(newX, newY);
                if (that.isAnimating) { rAF(step); }
                if (that.options.probeType == 3) { that._execEvent('scroll'); }
            }
            this.isAnimating = true;
            step();
        },
        handleEvent: function(e) {
            switch (e.type) {
                case 'touchstart':
                case 'pointerdown':
                case 'MSPointerDown':
                case 'mousedown':
                    this._start(e);
                    break;
                case 'touchmove':
                case 'pointermove':
                case 'MSPointerMove':
                case 'mousemove':
                    this._move(e);
                    break;
                case 'touchend':
                case 'pointerup':
                case 'MSPointerUp':
                case 'mouseup':
                case 'touchcancel':
                case 'pointercancel':
                case 'MSPointerCancel':
                case 'mousecancel':
                    this._end(e);
                    break;
                case 'orientationchange':
                case 'resize':
                    this._resize();
                    break;
                case 'transitionend':
                case 'webkitTransitionEnd':
                case 'oTransitionEnd':
                case 'MSTransitionEnd':
                    this._transitionEnd(e);
                    break;
                case 'wheel':
                case 'DOMMouseScroll':
                case 'mousewheel':
                    this._wheel(e);
                    break;
                case 'keydown':
                    this._key(e);
                    break;
                case 'click':
                    if (this.enabled && !e._constructed) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    break;
            }
        }
    };

    function createDefaultScrollbar(direction, interactive, type) {
        var scrollbar = document.createElement('div'),
            indicator = document.createElement('div');
        if (type === true) {
            scrollbar.style.cssText = 'position:absolute;z-index:9999';
            indicator.style.cssText = '-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.9);border-radius:3px';
        }
        indicator.className = 'iScrollIndicator';
        if (direction == 'h') {
            if (type === true) {
                scrollbar.style.cssText += ';height:7px;left:2px;right:2px;bottom:0';
                indicator.style.height = '100%';
            }
            scrollbar.className = 'iScrollHorizontalScrollbar';
        } else {
            if (type === true) {
                scrollbar.style.cssText += ';width:7px;bottom:2px;top:2px;right:1px';
                indicator.style.width = '100%';
            }
            scrollbar.className = 'iScrollVerticalScrollbar';
        }
        scrollbar.style.cssText += ';overflow:hidden';
        if (!interactive) { scrollbar.style.pointerEvents = 'none'; } scrollbar.appendChild(indicator);
        return scrollbar;
    }

    function Indicator(scroller, options) {
        this.wrapper = typeof options.el == 'string' ? document.querySelector(options.el) : options.el;
        this.wrapperStyle = this.wrapper.style;
        this.indicator = this.wrapper.children[0];
        this.indicatorStyle = this.indicator.style;
        this.scroller = scroller;
        this.options = { listenX: true, listenY: true, interactive: false, resize: true, defaultScrollbars: false, shrink: false, fade: false, speedRatioX: 0, speedRatioY: 0 };
        for (var i in options) { this.options[i] = options[i]; } this.sizeRatioX = 1;
        this.sizeRatioY = 1;
        this.maxPosX = 0;
        this.maxPosY = 0;
        if (this.options.interactive) {
            if (!this.options.disableTouch) {
                utils.addEvent(this.indicator, 'touchstart', this);
                utils.addEvent(window, 'touchend', this);
            }
            if (!this.options.disablePointer) {
                utils.addEvent(this.indicator, utils.prefixPointerEvent('pointerdown'), this);
                utils.addEvent(window, utils.prefixPointerEvent('pointerup'), this);
            }
            if (!this.options.disableMouse) {
                utils.addEvent(this.indicator, 'mousedown', this);
                utils.addEvent(window, 'mouseup', this);
            }
        }
        if (this.options.fade) {
            this.wrapperStyle[utils.style.transform] = this.scroller.translateZ;
            var durationProp = utils.style.transitionDuration;
            this.wrapperStyle[durationProp] = utils.isBadAndroid ? '0.0001ms' : '0ms';
            var self = this;
            if (utils.isBadAndroid) { rAF(function() { if (self.wrapperStyle[durationProp] === '0.0001ms') { self.wrapperStyle[durationProp] = '0s'; } }); } this.wrapperStyle.opacity = '0';
        }
    }
    Indicator.prototype = {
        handleEvent: function(e) {
            switch (e.type) {
                case 'touchstart':
                case 'pointerdown':
                case 'MSPointerDown':
                case 'mousedown':
                    this._start(e);
                    break;
                case 'touchmove':
                case 'pointermove':
                case 'MSPointerMove':
                case 'mousemove':
                    this._move(e);
                    break;
                case 'touchend':
                case 'pointerup':
                case 'MSPointerUp':
                case 'mouseup':
                case 'touchcancel':
                case 'pointercancel':
                case 'MSPointerCancel':
                case 'mousecancel':
                    this._end(e);
                    break;
            }
        },
        destroy: function() {
            if (this.options.fadeScrollbars) {
                clearTimeout(this.fadeTimeout);
                this.fadeTimeout = null;
            }
            if (this.options.interactive) {
                utils.removeEvent(this.indicator, 'touchstart', this);
                utils.removeEvent(this.indicator, utils.prefixPointerEvent('pointerdown'), this);
                utils.removeEvent(this.indicator, 'mousedown', this);
                utils.removeEvent(window, 'touchmove', this);
                utils.removeEvent(window, utils.prefixPointerEvent('pointermove'), this);
                utils.removeEvent(window, 'mousemove', this);
                utils.removeEvent(window, 'touchend', this);
                utils.removeEvent(window, utils.prefixPointerEvent('pointerup'), this);
                utils.removeEvent(window, 'mouseup', this);
            }
            if (this.options.defaultScrollbars) { this.wrapper.parentNode.removeChild(this.wrapper); }
        },
        _start: function(e) {
            var point = e.touches ? e.touches[0] : e;
            e.preventDefault();
            e.stopPropagation();
            this.transitionTime();
            this.initiated = true;
            this.moved = false;
            this.lastPointX = point.pageX;
            this.lastPointY = point.pageY;
            this.startTime = utils.getTime();
            if (!this.options.disableTouch) { utils.addEvent(window, 'touchmove', this); }
            if (!this.options.disablePointer) { utils.addEvent(window, utils.prefixPointerEvent('pointermove'), this); }
            if (!this.options.disableMouse) { utils.addEvent(window, 'mousemove', this); } this.scroller._execEvent('beforeScrollStart');
        },
        _move: function(e) {
            var point = e.touches ? e.touches[0] : e,
                deltaX, deltaY, newX, newY, timestamp = utils.getTime();
            if (!this.moved) { this.scroller._execEvent('scrollStart'); } this.moved = true;
            deltaX = point.pageX - this.lastPointX;
            this.lastPointX = point.pageX;
            deltaY = point.pageY - this.lastPointY;
            this.lastPointY = point.pageY;
            newX = this.x + deltaX;
            newY = this.y + deltaY;
            this._pos(newX, newY);
            if (this.scroller.options.probeType == 1 && timestamp - this.startTime > 300) {
                this.startTime = timestamp;
                this.scroller._execEvent('scroll');
            } else if (this.scroller.options.probeType > 1) { this.scroller._execEvent('scroll'); } e.preventDefault();
            e.stopPropagation();
        },
        _end: function(e) {
            if (!this.initiated) { return; } this.initiated = false;
            e.preventDefault();
            e.stopPropagation();
            utils.removeEvent(window, 'touchmove', this);
            utils.removeEvent(window, utils.prefixPointerEvent('pointermove'), this);
            utils.removeEvent(window, 'mousemove', this);
            if (this.scroller.options.snap) {
                var snap = this.scroller._nearestSnap(this.scroller.x, this.scroller.y);
                var time = this.options.snapSpeed || Math.max(Math.max(Math.min(Math.abs(this.scroller.x - snap.x), 1000), Math.min(Math.abs(this.scroller.y - snap.y), 1000)), 300);
                if (this.scroller.x != snap.x || this.scroller.y != snap.y) {
                    this.scroller.directionX = 0;
                    this.scroller.directionY = 0;
                    this.scroller.currentPage = snap;
                    this.scroller.scrollTo(snap.x, snap.y, time, this.scroller.options.bounceEasing);
                }
            }
            if (this.moved) { this.scroller._execEvent('scrollEnd'); }
        },
        transitionTime: function(time) {
            time = time || 0;
            var durationProp = utils.style.transitionDuration;
            this.indicatorStyle[durationProp] = time + 'ms';
            if (!time && utils.isBadAndroid) {
                this.indicatorStyle[durationProp] = '0.0001ms';
                var self = this;
                rAF(function() { if (self.indicatorStyle[durationProp] === '0.0001ms') { self.indicatorStyle[durationProp] = '0s'; } });
            }
        },
        transitionTimingFunction: function(easing) { this.indicatorStyle[utils.style.transitionTimingFunction] = easing; },
        refresh: function() {
            this.transitionTime();
            if (this.options.listenX && !this.options.listenY) { this.indicatorStyle.display = this.scroller.hasHorizontalScroll ? 'block' : 'none'; } else if (this.options.listenY && !this.options.listenX) { this.indicatorStyle.display = this.scroller.hasVerticalScroll ? 'block' : 'none'; } else { this.indicatorStyle.display = this.scroller.hasHorizontalScroll || this.scroller.hasVerticalScroll ? 'block' : 'none'; }
            if (this.scroller.hasHorizontalScroll && this.scroller.hasVerticalScroll) {
                utils.addClass(this.wrapper, 'iScrollBothScrollbars');
                utils.removeClass(this.wrapper, 'iScrollLoneScrollbar');
                if (this.options.defaultScrollbars && this.options.customStyle) { if (this.options.listenX) { this.wrapper.style.right = '8px'; } else { this.wrapper.style.bottom = '8px'; } }
            } else {
                utils.removeClass(this.wrapper, 'iScrollBothScrollbars');
                utils.addClass(this.wrapper, 'iScrollLoneScrollbar');
                if (this.options.defaultScrollbars && this.options.customStyle) { if (this.options.listenX) { this.wrapper.style.right = '2px'; } else { this.wrapper.style.bottom = '2px'; } }
            }
            var r = this.wrapper.offsetHeight;
            if (this.options.listenX) {
                this.wrapperWidth = this.wrapper.clientWidth;
                if (this.options.resize) {
                    this.indicatorWidth = Math.max(Math.round(this.wrapperWidth * this.wrapperWidth / (this.scroller.scrollerWidth || this.wrapperWidth || 1)), 8);
                    this.indicatorStyle.width = this.indicatorWidth + 'px';
                } else { this.indicatorWidth = this.indicator.clientWidth; } this.maxPosX = this.wrapperWidth - this.indicatorWidth;
                if (this.options.shrink == 'clip') {
                    this.minBoundaryX = -this.indicatorWidth + 8;
                    this.maxBoundaryX = this.wrapperWidth - 8;
                } else {
                    this.minBoundaryX = 0;
                    this.maxBoundaryX = this.maxPosX;
                }
                this.sizeRatioX = this.options.speedRatioX || (this.scroller.maxScrollX && (this.maxPosX / this.scroller.maxScrollX));
            }
            if (this.options.listenY) {
                this.wrapperHeight = this.wrapper.clientHeight;
                if (this.options.resize) {
                    this.indicatorHeight = Math.max(Math.round(this.wrapperHeight * this.wrapperHeight / (this.scroller.scrollerHeight || this.wrapperHeight || 1)), 8);
                    this.indicatorStyle.height = this.indicatorHeight + 'px';
                } else { this.indicatorHeight = this.indicator.clientHeight; } this.maxPosY = this.wrapperHeight - this.indicatorHeight;
                if (this.options.shrink == 'clip') {
                    this.minBoundaryY = -this.indicatorHeight + 8;
                    this.maxBoundaryY = this.wrapperHeight - 8;
                } else {
                    this.minBoundaryY = 0;
                    this.maxBoundaryY = this.maxPosY;
                }
                this.maxPosY = this.wrapperHeight - this.indicatorHeight;
                this.sizeRatioY = this.options.speedRatioY || (this.scroller.maxScrollY && (this.maxPosY / this.scroller.maxScrollY));
            }
            this.updatePosition();
        },
        updatePosition: function() {
            var x = this.options.listenX && Math.round(this.sizeRatioX * this.scroller.x) || 0,
                y = this.options.listenY && Math.round(this.sizeRatioY * this.scroller.y) || 0;
            if (!this.options.ignoreBoundaries) {
                if (x < this.minBoundaryX) {
                    if (this.options.shrink == 'scale') {
                        this.width = Math.max(this.indicatorWidth + x, 8);
                        this.indicatorStyle.width = this.width + 'px';
                    }
                    x = this.minBoundaryX;
                } else if (x > this.maxBoundaryX) {
                    if (this.options.shrink == 'scale') {
                        this.width = Math.max(this.indicatorWidth - (x - this.maxPosX), 8);
                        this.indicatorStyle.width = this.width + 'px';
                        x = this.maxPosX + this.indicatorWidth - this.width;
                    } else { x = this.maxBoundaryX; }
                } else if (this.options.shrink == 'scale' && this.width != this.indicatorWidth) {
                    this.width = this.indicatorWidth;
                    this.indicatorStyle.width = this.width + 'px';
                }
                if (y < this.minBoundaryY) {
                    if (this.options.shrink == 'scale') {
                        this.height = Math.max(this.indicatorHeight + y * 3, 8);
                        this.indicatorStyle.height = this.height + 'px';
                    }
                    y = this.minBoundaryY;
                } else if (y > this.maxBoundaryY) {
                    if (this.options.shrink == 'scale') {
                        this.height = Math.max(this.indicatorHeight - (y - this.maxPosY) * 3, 8);
                        this.indicatorStyle.height = this.height + 'px';
                        y = this.maxPosY + this.indicatorHeight - this.height;
                    } else { y = this.maxBoundaryY; }
                } else if (this.options.shrink == 'scale' && this.height != this.indicatorHeight) {
                    this.height = this.indicatorHeight;
                    this.indicatorStyle.height = this.height + 'px';
                }
            }
            this.x = x;
            this.y = y;
            if (this.scroller.options.useTransform) { this.indicatorStyle[utils.style.transform] = 'translate(' + x + 'px,' + y + 'px)' + this.scroller.translateZ; } else {
                this.indicatorStyle.left = x + 'px';
                this.indicatorStyle.top = y + 'px';
            }
        },
        _pos: function(x, y) {
            if (x < 0) { x = 0; } else if (x > this.maxPosX) { x = this.maxPosX; }
            if (y < 0) { y = 0; } else if (y > this.maxPosY) { y = this.maxPosY; } x = this.options.listenX ? Math.round(x / this.sizeRatioX) : this.scroller.x;
            y = this.options.listenY ? Math.round(y / this.sizeRatioY) : this.scroller.y;
            this.scroller.scrollTo(x, y);
        },
        fade: function(val, hold) {
            if (hold && !this.visible) { return; } clearTimeout(this.fadeTimeout);
            this.fadeTimeout = null;
            var time = val ? 250 : 500,
                delay = val ? 0 : 300;
            val = val ? '1' : '0';
            this.wrapperStyle[utils.style.transitionDuration] = time + 'ms';
            this.fadeTimeout = setTimeout((function(val) {
                this.wrapperStyle.opacity = val;
                this.visible = +val;
            }).bind(this, val), delay);
        }
    };
    IScroll.utils = utils;
    if (typeof module != 'undefined' && module.exports) { module.exports = IScroll; } else if (typeof define == 'function' && define.amd) { define(function() { return IScroll; }); } else { window.IScroll = IScroll; }
})(window, document, Math);;
! function(factory) { "function" == typeof define && define.amd && define.amd.jQuery ? define(["jquery"], factory) : factory("undefined" != typeof module && module.exports ? require("jquery") : jQuery) }(function($) {
    "use strict";

    function init(options) {
        return !options || void 0 !== options.allowPageScroll || void 0 === options.swipe && void 0 === options.swipeStatus || (options.allowPageScroll = NONE), void 0 !== options.click && void 0 === options.tap && (options.tap = options.click), options || (options = {}), options = $.extend({}, $.fn.swipe.defaults, options), this.each(function() {
            var $this = $(this),
                plugin = $this.data(PLUGIN_NS);
            plugin || (plugin = new TouchSwipe(this, options), $this.data(PLUGIN_NS, plugin))
        })
    }

    function TouchSwipe(element, options) {
        function touchStart(jqEvent) {
            if (!(getTouchInProgress() || $(jqEvent.target).closest(options.excludedElements, $element).length > 0)) {
                var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent;
                if (!event.pointerType || "mouse" != event.pointerType || 0 != options.fallbackToMouseEvents) {
                    var ret, touches = event.touches,
                        evt = touches ? touches[0] : event;
                    return phase = PHASE_START, touches ? fingerCount = touches.length : options.preventDefaultEvents !== !1 && jqEvent.preventDefault(), distance = 0, direction = null, currentDirection = null, pinchDirection = null, duration = 0, startTouchesDistance = 0, endTouchesDistance = 0, pinchZoom = 1, pinchDistance = 0, maximumsMap = createMaximumsData(), cancelMultiFingerRelease(), createFingerData(0, evt), !touches || fingerCount === options.fingers || options.fingers === ALL_FINGERS || hasPinches() ? (startTime = getTimeStamp(), 2 == fingerCount && (createFingerData(1, touches[1]), startTouchesDistance = endTouchesDistance = calculateTouchesDistance(fingerData[0].start, fingerData[1].start)), (options.swipeStatus || options.pinchStatus) && (ret = triggerHandler(event, phase))) : ret = !1, ret === !1 ? (phase = PHASE_CANCEL, triggerHandler(event, phase), ret) : (options.hold && (holdTimeout = setTimeout($.proxy(function() { $element.trigger("hold", [event.target]), options.hold && (ret = options.hold.call($element, event, event.target)) }, this), options.longTapThreshold)), setTouchInProgress(!0), null)
                }
            }
        }

        function touchMove(jqEvent) {
            var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent;
            if (phase !== PHASE_END && phase !== PHASE_CANCEL && !inMultiFingerRelease()) {
                var ret, touches = event.touches,
                    evt = touches ? touches[0] : event,
                    currentFinger = updateFingerData(evt);
                if (endTime = getTimeStamp(), touches && (fingerCount = touches.length), options.hold && clearTimeout(holdTimeout), phase = PHASE_MOVE, 2 == fingerCount && (0 == startTouchesDistance ? (createFingerData(1, touches[1]), startTouchesDistance = endTouchesDistance = calculateTouchesDistance(fingerData[0].start, fingerData[1].start)) : (updateFingerData(touches[1]), endTouchesDistance = calculateTouchesDistance(fingerData[0].end, fingerData[1].end), pinchDirection = calculatePinchDirection(fingerData[0].end, fingerData[1].end)), pinchZoom = calculatePinchZoom(startTouchesDistance, endTouchesDistance), pinchDistance = Math.abs(startTouchesDistance - endTouchesDistance)), fingerCount === options.fingers || options.fingers === ALL_FINGERS || !touches || hasPinches()) {
                    if (direction = calculateDirection(currentFinger.start, currentFinger.end), currentDirection = calculateDirection(currentFinger.last, currentFinger.end), validateDefaultEvent(jqEvent, currentDirection), distance = calculateDistance(currentFinger.start, currentFinger.end), duration = calculateDuration(), setMaxDistance(direction, distance), ret = triggerHandler(event, phase), !options.triggerOnTouchEnd || options.triggerOnTouchLeave) {
                        var inBounds = !0;
                        if (options.triggerOnTouchLeave) {
                            var bounds = getbounds(this);
                            inBounds = isInBounds(currentFinger.end, bounds)
                        }!options.triggerOnTouchEnd && inBounds ? phase = getNextPhase(PHASE_MOVE) : options.triggerOnTouchLeave && !inBounds && (phase = getNextPhase(PHASE_END)), phase != PHASE_CANCEL && phase != PHASE_END || triggerHandler(event, phase)
                    }
                } else phase = PHASE_CANCEL, triggerHandler(event, phase);
                ret === !1 && (phase = PHASE_CANCEL, triggerHandler(event, phase))
            }
        }

        function touchEnd(jqEvent) {
            var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent,
                touches = event.touches;
            if (touches) { if (touches.length && !inMultiFingerRelease()) return startMultiFingerRelease(event), !0; if (touches.length && inMultiFingerRelease()) return !0 }
            return inMultiFingerRelease() && (fingerCount = fingerCountAtRelease), endTime = getTimeStamp(), duration = calculateDuration(), didSwipeBackToCancel() || !validateSwipeDistance() ? (phase = PHASE_CANCEL, triggerHandler(event, phase)) : options.triggerOnTouchEnd || options.triggerOnTouchEnd === !1 && phase === PHASE_MOVE ? (options.preventDefaultEvents !== !1 && jqEvent.preventDefault(), phase = PHASE_END, triggerHandler(event, phase)) : !options.triggerOnTouchEnd && hasTap() ? (phase = PHASE_END, triggerHandlerForGesture(event, phase, TAP)) : phase === PHASE_MOVE && (phase = PHASE_CANCEL, triggerHandler(event, phase)), setTouchInProgress(!1), null
        }

        function touchCancel() { fingerCount = 0, endTime = 0, startTime = 0, startTouchesDistance = 0, endTouchesDistance = 0, pinchZoom = 1, cancelMultiFingerRelease(), setTouchInProgress(!1) }

        function touchLeave(jqEvent) {
            var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent;
            options.triggerOnTouchLeave && (phase = getNextPhase(PHASE_END), triggerHandler(event, phase))
        }

        function removeListeners() { $element.unbind(START_EV, touchStart), $element.unbind(CANCEL_EV, touchCancel), $element.unbind(MOVE_EV, touchMove), $element.unbind(END_EV, touchEnd), LEAVE_EV && $element.unbind(LEAVE_EV, touchLeave), setTouchInProgress(!1) }

        function getNextPhase(currentPhase) {
            var nextPhase = currentPhase,
                validTime = validateSwipeTime(),
                validDistance = validateSwipeDistance(),
                didCancel = didSwipeBackToCancel();
            return !validTime || didCancel ? nextPhase = PHASE_CANCEL : !validDistance || currentPhase != PHASE_MOVE || options.triggerOnTouchEnd && !options.triggerOnTouchLeave ? !validDistance && currentPhase == PHASE_END && options.triggerOnTouchLeave && (nextPhase = PHASE_CANCEL) : nextPhase = PHASE_END, nextPhase
        }

        function triggerHandler(event, phase) { var ret, touches = event.touches; return (didSwipe() || hasSwipes()) && (ret = triggerHandlerForGesture(event, phase, SWIPE)), (didPinch() || hasPinches()) && ret !== !1 && (ret = triggerHandlerForGesture(event, phase, PINCH)), didDoubleTap() && ret !== !1 ? ret = triggerHandlerForGesture(event, phase, DOUBLE_TAP) : didLongTap() && ret !== !1 ? ret = triggerHandlerForGesture(event, phase, LONG_TAP) : didTap() && ret !== !1 && (ret = triggerHandlerForGesture(event, phase, TAP)), phase === PHASE_CANCEL && touchCancel(event), phase === PHASE_END && (touches ? touches.length || touchCancel(event) : touchCancel(event)), ret }

        function triggerHandlerForGesture(event, phase, gesture) {
            var ret;
            if (gesture == SWIPE) {
                if ($element.trigger("swipeStatus", [phase, direction || null, distance || 0, duration || 0, fingerCount, fingerData, currentDirection]), options.swipeStatus && (ret = options.swipeStatus.call($element, event, phase, direction || null, distance || 0, duration || 0, fingerCount, fingerData, currentDirection), ret === !1)) return !1;
                if (phase == PHASE_END && validateSwipe()) {
                    if (clearTimeout(singleTapTimeout), clearTimeout(holdTimeout), $element.trigger("swipe", [direction, distance, duration, fingerCount, fingerData, currentDirection]), options.swipe && (ret = options.swipe.call($element, event, direction, distance, duration, fingerCount, fingerData, currentDirection), ret === !1)) return !1;
                    switch (direction) {
                        case LEFT:
                            $element.trigger("swipeLeft", [direction, distance, duration, fingerCount, fingerData, currentDirection]), options.swipeLeft && (ret = options.swipeLeft.call($element, event, direction, distance, duration, fingerCount, fingerData, currentDirection));
                            break;
                        case RIGHT:
                            $element.trigger("swipeRight", [direction, distance, duration, fingerCount, fingerData, currentDirection]), options.swipeRight && (ret = options.swipeRight.call($element, event, direction, distance, duration, fingerCount, fingerData, currentDirection));
                            break;
                        case UP:
                            $element.trigger("swipeUp", [direction, distance, duration, fingerCount, fingerData, currentDirection]), options.swipeUp && (ret = options.swipeUp.call($element, event, direction, distance, duration, fingerCount, fingerData, currentDirection));
                            break;
                        case DOWN:
                            $element.trigger("swipeDown", [direction, distance, duration, fingerCount, fingerData, currentDirection]), options.swipeDown && (ret = options.swipeDown.call($element, event, direction, distance, duration, fingerCount, fingerData, currentDirection))
                    }
                }
            }
            if (gesture == PINCH) {
                if ($element.trigger("pinchStatus", [phase, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData]), options.pinchStatus && (ret = options.pinchStatus.call($element, event, phase, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData), ret === !1)) return !1;
                if (phase == PHASE_END && validatePinch()) switch (pinchDirection) {
                    case IN:
                        $element.trigger("pinchIn", [pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData]), options.pinchIn && (ret = options.pinchIn.call($element, event, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData));
                        break;
                    case OUT:
                        $element.trigger("pinchOut", [pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData]), options.pinchOut && (ret = options.pinchOut.call($element, event, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom, fingerData))
                }
            }
            return gesture == TAP ? phase !== PHASE_CANCEL && phase !== PHASE_END || (clearTimeout(singleTapTimeout), clearTimeout(holdTimeout), hasDoubleTap() && !inDoubleTap() ? (doubleTapStartTime = getTimeStamp(), singleTapTimeout = setTimeout($.proxy(function() { doubleTapStartTime = null, $element.trigger("tap", [event.target]), options.tap && (ret = options.tap.call($element, event, event.target)) }, this), options.doubleTapThreshold)) : (doubleTapStartTime = null, $element.trigger("tap", [event.target]), options.tap && (ret = options.tap.call($element, event, event.target)))) : gesture == DOUBLE_TAP ? phase !== PHASE_CANCEL && phase !== PHASE_END || (clearTimeout(singleTapTimeout), clearTimeout(holdTimeout), doubleTapStartTime = null, $element.trigger("doubletap", [event.target]), options.doubleTap && (ret = options.doubleTap.call($element, event, event.target))) : gesture == LONG_TAP && (phase !== PHASE_CANCEL && phase !== PHASE_END || (clearTimeout(singleTapTimeout), doubleTapStartTime = null, $element.trigger("longtap", [event.target]), options.longTap && (ret = options.longTap.call($element, event, event.target)))), ret
        }

        function validateSwipeDistance() { var valid = !0; return null !== options.threshold && (valid = distance >= options.threshold), valid }

        function didSwipeBackToCancel() { var cancelled = !1; return null !== options.cancelThreshold && null !== direction && (cancelled = getMaxDistance(direction) - distance >= options.cancelThreshold), cancelled }

        function validatePinchDistance() { return null !== options.pinchThreshold ? pinchDistance >= options.pinchThreshold : !0 }

        function validateSwipeTime() { var result; return result = options.maxTimeThreshold ? !(duration >= options.maxTimeThreshold) : !0 }

        function validateDefaultEvent(jqEvent, direction) {
            if (options.preventDefaultEvents !== !1)
                if (options.allowPageScroll === NONE) jqEvent.preventDefault();
                else {
                    var auto = options.allowPageScroll === AUTO;
                    switch (direction) {
                        case LEFT:
                            (options.swipeLeft && auto || !auto && options.allowPageScroll != HORIZONTAL) && jqEvent.preventDefault();
                            break;
                        case RIGHT:
                            (options.swipeRight && auto || !auto && options.allowPageScroll != HORIZONTAL) && jqEvent.preventDefault();
                            break;
                        case UP:
                            (options.swipeUp && auto || !auto && options.allowPageScroll != VERTICAL) && jqEvent.preventDefault();
                            break;
                        case DOWN:
                            (options.swipeDown && auto || !auto && options.allowPageScroll != VERTICAL) && jqEvent.preventDefault();
                            break;
                        case NONE:
                    }
                }
        }

        function validatePinch() {
            var hasCorrectFingerCount = validateFingers(),
                hasEndPoint = validateEndPoint(),
                hasCorrectDistance = validatePinchDistance();
            return hasCorrectFingerCount && hasEndPoint && hasCorrectDistance
        }

        function hasPinches() { return !!(options.pinchStatus || options.pinchIn || options.pinchOut) }

        function didPinch() { return !(!validatePinch() || !hasPinches()) }

        function validateSwipe() {
            var hasValidTime = validateSwipeTime(),
                hasValidDistance = validateSwipeDistance(),
                hasCorrectFingerCount = validateFingers(),
                hasEndPoint = validateEndPoint(),
                didCancel = didSwipeBackToCancel(),
                valid = !didCancel && hasEndPoint && hasCorrectFingerCount && hasValidDistance && hasValidTime;
            return valid
        }

        function hasSwipes() { return !!(options.swipe || options.swipeStatus || options.swipeLeft || options.swipeRight || options.swipeUp || options.swipeDown) }

        function didSwipe() { return !(!validateSwipe() || !hasSwipes()) }

        function validateFingers() { return fingerCount === options.fingers || options.fingers === ALL_FINGERS || !SUPPORTS_TOUCH }

        function validateEndPoint() { return 0 !== fingerData[0].end.x }

        function hasTap() { return !!options.tap }

        function hasDoubleTap() { return !!options.doubleTap }

        function hasLongTap() { return !!options.longTap }

        function validateDoubleTap() { if (null == doubleTapStartTime) return !1; var now = getTimeStamp(); return hasDoubleTap() && now - doubleTapStartTime <= options.doubleTapThreshold }

        function inDoubleTap() { return validateDoubleTap() }

        function validateTap() { return (1 === fingerCount || !SUPPORTS_TOUCH) && (isNaN(distance) || distance < options.threshold) }

        function validateLongTap() { return duration > options.longTapThreshold && DOUBLE_TAP_THRESHOLD > distance }

        function didTap() { return !(!validateTap() || !hasTap()) }

        function didDoubleTap() { return !(!validateDoubleTap() || !hasDoubleTap()) }

        function didLongTap() { return !(!validateLongTap() || !hasLongTap()) }

        function startMultiFingerRelease(event) { previousTouchEndTime = getTimeStamp(), fingerCountAtRelease = event.touches.length + 1 }

        function cancelMultiFingerRelease() { previousTouchEndTime = 0, fingerCountAtRelease = 0 }

        function inMultiFingerRelease() {
            var withinThreshold = !1;
            if (previousTouchEndTime) {
                var diff = getTimeStamp() - previousTouchEndTime;
                diff <= options.fingerReleaseThreshold && (withinThreshold = !0)
            }
            return withinThreshold
        }

        function getTouchInProgress() { return !($element.data(PLUGIN_NS + "_intouch") !== !0) }

        function setTouchInProgress(val) { $element && (val === !0 ? ($element.bind(MOVE_EV, touchMove), $element.bind(END_EV, touchEnd), LEAVE_EV && $element.bind(LEAVE_EV, touchLeave)) : ($element.unbind(MOVE_EV, touchMove, !1), $element.unbind(END_EV, touchEnd, !1), LEAVE_EV && $element.unbind(LEAVE_EV, touchLeave, !1)), $element.data(PLUGIN_NS + "_intouch", val === !0)) }

        function createFingerData(id, evt) { var f = { start: { x: 0, y: 0 }, last: { x: 0, y: 0 }, end: { x: 0, y: 0 } }; return f.start.x = f.last.x = f.end.x = evt.pageX || evt.clientX, f.start.y = f.last.y = f.end.y = evt.pageY || evt.clientY, fingerData[id] = f, f }

        function updateFingerData(evt) {
            var id = void 0 !== evt.identifier ? evt.identifier : 0,
                f = getFingerData(id);
            return null === f && (f = createFingerData(id, evt)), f.last.x = f.end.x, f.last.y = f.end.y, f.end.x = evt.pageX || evt.clientX, f.end.y = evt.pageY || evt.clientY, f
        }

        function getFingerData(id) { return fingerData[id] || null }

        function setMaxDistance(direction, distance) { direction != NONE && (distance = Math.max(distance, getMaxDistance(direction)), maximumsMap[direction].distance = distance) }

        function getMaxDistance(direction) { return maximumsMap[direction] ? maximumsMap[direction].distance : void 0 }

        function createMaximumsData() { var maxData = {}; return maxData[LEFT] = createMaximumVO(LEFT), maxData[RIGHT] = createMaximumVO(RIGHT), maxData[UP] = createMaximumVO(UP), maxData[DOWN] = createMaximumVO(DOWN), maxData }

        function createMaximumVO(dir) { return { direction: dir, distance: 0 } }

        function calculateDuration() { return endTime - startTime }

        function calculateTouchesDistance(startPoint, endPoint) {
            var diffX = Math.abs(startPoint.x - endPoint.x),
                diffY = Math.abs(startPoint.y - endPoint.y);
            return Math.round(Math.sqrt(diffX * diffX + diffY * diffY))
        }

        function calculatePinchZoom(startDistance, endDistance) { var percent = endDistance / startDistance * 1; return percent.toFixed(2) }

        function calculatePinchDirection() { return 1 > pinchZoom ? OUT : IN }

        function calculateDistance(startPoint, endPoint) { return Math.round(Math.sqrt(Math.pow(endPoint.x - startPoint.x, 2) + Math.pow(endPoint.y - startPoint.y, 2))) }

        function calculateAngle(startPoint, endPoint) {
            var x = startPoint.x - endPoint.x,
                y = endPoint.y - startPoint.y,
                r = Math.atan2(y, x),
                angle = Math.round(180 * r / Math.PI);
            return 0 > angle && (angle = 360 - Math.abs(angle)), angle
        }

        function calculateDirection(startPoint, endPoint) { if (comparePoints(startPoint, endPoint)) return NONE; var angle = calculateAngle(startPoint, endPoint); return 45 >= angle && angle >= 0 ? LEFT : 360 >= angle && angle >= 315 ? LEFT : angle >= 135 && 225 >= angle ? RIGHT : angle > 45 && 135 > angle ? DOWN : UP }

        function getTimeStamp() { var now = new Date; return now.getTime() }

        function getbounds(el) {
            el = $(el);
            var offset = el.offset(),
                bounds = { left: offset.left, right: offset.left + el.outerWidth(), top: offset.top, bottom: offset.top + el.outerHeight() };
            return bounds
        }

        function isInBounds(point, bounds) { return point.x > bounds.left && point.x < bounds.right && point.y > bounds.top && point.y < bounds.bottom }

        function comparePoints(pointA, pointB) { return pointA.x == pointB.x && pointA.y == pointB.y }
        var options = $.extend({}, options),
            useTouchEvents = SUPPORTS_TOUCH || SUPPORTS_POINTER || !options.fallbackToMouseEvents,
            START_EV = useTouchEvents ? SUPPORTS_POINTER ? SUPPORTS_POINTER_IE10 ? "MSPointerDown" : "pointerdown" : "touchstart" : "mousedown",
            MOVE_EV = useTouchEvents ? SUPPORTS_POINTER ? SUPPORTS_POINTER_IE10 ? "MSPointerMove" : "pointermove" : "touchmove" : "mousemove",
            END_EV = useTouchEvents ? SUPPORTS_POINTER ? SUPPORTS_POINTER_IE10 ? "MSPointerUp" : "pointerup" : "touchend" : "mouseup",
            LEAVE_EV = useTouchEvents ? SUPPORTS_POINTER ? "mouseleave" : null : "mouseleave",
            CANCEL_EV = SUPPORTS_POINTER ? SUPPORTS_POINTER_IE10 ? "MSPointerCancel" : "pointercancel" : "touchcancel",
            distance = 0,
            direction = null,
            currentDirection = null,
            duration = 0,
            startTouchesDistance = 0,
            endTouchesDistance = 0,
            pinchZoom = 1,
            pinchDistance = 0,
            pinchDirection = 0,
            maximumsMap = null,
            $element = $(element),
            phase = "start",
            fingerCount = 0,
            fingerData = {},
            startTime = 0,
            endTime = 0,
            previousTouchEndTime = 0,
            fingerCountAtRelease = 0,
            doubleTapStartTime = 0,
            singleTapTimeout = null,
            holdTimeout = null;
        try { $element.bind(START_EV, touchStart), $element.bind(CANCEL_EV, touchCancel) } catch (e) { $.error("events not supported " + START_EV + "," + CANCEL_EV + " on jQuery.swipe") } this.enable = function() { return this.disable(), $element.bind(START_EV, touchStart), $element.bind(CANCEL_EV, touchCancel), $element }, this.disable = function() { return removeListeners(), $element }, this.destroy = function() { removeListeners(), $element.data(PLUGIN_NS, null), $element = null }, this.option = function(property, value) {
            if ("object" == typeof property) options = $.extend(options, property);
            else if (void 0 !== options[property]) {
                if (void 0 === value) return options[property];
                options[property] = value
            } else {
                if (!property) return options;
                $.error("Option " + property + " does not exist on jQuery.swipe.options")
            }
            return null
        }
    }
    var VERSION = "1.6.18",
        LEFT = "left",
        RIGHT = "right",
        UP = "up",
        DOWN = "down",
        IN = "in",
        OUT = "out",
        NONE = "none",
        AUTO = "auto",
        SWIPE = "swipe",
        PINCH = "pinch",
        TAP = "tap",
        DOUBLE_TAP = "doubletap",
        LONG_TAP = "longtap",
        HORIZONTAL = "horizontal",
        VERTICAL = "vertical",
        ALL_FINGERS = "all",
        DOUBLE_TAP_THRESHOLD = 10,
        PHASE_START = "start",
        PHASE_MOVE = "move",
        PHASE_END = "end",
        PHASE_CANCEL = "cancel",
        SUPPORTS_TOUCH = "ontouchstart" in window,
        SUPPORTS_POINTER_IE10 = window.navigator.msPointerEnabled && !window.navigator.pointerEnabled && !SUPPORTS_TOUCH,
        SUPPORTS_POINTER = (window.navigator.pointerEnabled || window.navigator.msPointerEnabled) && !SUPPORTS_TOUCH,
        PLUGIN_NS = "TouchSwipe",
        defaults = { fingers: 1, threshold: 75, cancelThreshold: null, pinchThreshold: 20, maxTimeThreshold: null, fingerReleaseThreshold: 250, longTapThreshold: 500, doubleTapThreshold: 200, swipe: null, swipeLeft: null, swipeRight: null, swipeUp: null, swipeDown: null, swipeStatus: null, pinchIn: null, pinchOut: null, pinchStatus: null, click: null, tap: null, doubleTap: null, longTap: null, hold: null, triggerOnTouchEnd: !0, triggerOnTouchLeave: !1, allowPageScroll: "auto", fallbackToMouseEvents: !0, excludedElements: ".noSwipe", preventDefaultEvents: !0 };
    $.fn.swipe = function(method) {
        var $this = $(this),
            plugin = $this.data(PLUGIN_NS);
        if (plugin && "string" == typeof method) {
            if (plugin[method]) return plugin[method].apply(plugin, Array.prototype.slice.call(arguments, 1));
            $.error("Method " + method + " does not exist on jQuery.swipe")
        } else if (plugin && "object" == typeof method) plugin.option.apply(plugin, arguments);
        else if (!(plugin || "object" != typeof method && method)) return init.apply(this, arguments);
        return $this
    }, $.fn.swipe.version = VERSION, $.fn.swipe.defaults = defaults, $.fn.swipe.phases = { PHASE_START: PHASE_START, PHASE_MOVE: PHASE_MOVE, PHASE_END: PHASE_END, PHASE_CANCEL: PHASE_CANCEL }, $.fn.swipe.directions = { LEFT: LEFT, RIGHT: RIGHT, UP: UP, DOWN: DOWN, IN: IN, OUT: OUT }, $.fn.swipe.pageScroll = { NONE: NONE, HORIZONTAL: HORIZONTAL, VERTICAL: VERTICAL, AUTO: AUTO }, $.fn.swipe.fingers = { ONE: 1, TWO: 2, THREE: 3, FOUR: 4, FIVE: 5, ALL: ALL_FINGERS }
});;
! function(a) { "use strict"; "function" == typeof define && define.amd ? define(["jquery"], a) : "undefined" != typeof exports ? module.exports = a(require("jquery")) : a(jQuery) }(function(a) {
    "use strict";
    var b = window.Slick || {};
    b = function() {
        function c(c, d) {
            var f, e = this;
            e.defaults = { accessibility: !0, adaptiveHeight: !1, appendArrows: a(c), appendDots: a(c), arrows: !0, asNavFor: null, prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>', nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>', autoplay: !1, autoplaySpeed: 3e3, centerMode: !1, centerPadding: "50px", cssEase: "ease", customPaging: function(b, c) { return a('<button type="button" data-role="none" role="button" tabindex="0" />').text(c + 1) }, dots: !1, dotsClass: "slick-dots", draggable: !0, easing: "linear", edgeFriction: .35, fade: !1, focusOnSelect: !1, infinite: !0, initialSlide: 0, lazyLoad: "ondemand", mobileFirst: !1, pauseOnHover: !0, pauseOnFocus: !0, pauseOnDotsHover: !1, respondTo: "window", responsive: null, rows: 1, rtl: !1, slide: "", slidesPerRow: 1, slidesToShow: 1, slidesToScroll: 1, speed: 500, swipe: !0, swipeToSlide: !1, touchMove: !0, touchThreshold: 5, useCSS: !0, useTransform: !0, variableWidth: !1, vertical: !1, verticalSwiping: !1, waitForAnimate: !0, zIndex: 1e3 }, e.initials = { animating: !1, dragging: !1, autoPlayTimer: null, currentDirection: 0, currentLeft: null, currentSlide: 0, direction: 1, $dots: null, listWidth: null, listHeight: null, loadIndex: 0, $nextArrow: null, $prevArrow: null, slideCount: null, slideWidth: null, $slideTrack: null, $slides: null, sliding: !1, slideOffset: 0, swipeLeft: null, $list: null, touchObject: {}, transformsEnabled: !1, unslicked: !1 }, a.extend(e, e.initials), e.activeBreakpoint = null, e.animType = null, e.animProp = null, e.breakpoints = [], e.breakpointSettings = [], e.cssTransitions = !1, e.focussed = !1, e.interrupted = !1, e.hidden = "hidden", e.paused = !0, e.positionProp = null, e.respondTo = null, e.rowCount = 1, e.shouldClick = !0, e.$slider = a(c), e.$slidesCache = null, e.transformType = null, e.transitionType = null, e.visibilityChange = "visibilitychange", e.windowWidth = 0, e.windowTimer = null, f = a(c).data("slick") || {}, e.options = a.extend({}, e.defaults, d, f), e.currentSlide = e.options.initialSlide, e.originalSettings = e.options, "undefined" != typeof document.mozHidden ? (e.hidden = "mozHidden", e.visibilityChange = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (e.hidden = "webkitHidden", e.visibilityChange = "webkitvisibilitychange"), e.autoPlay = a.proxy(e.autoPlay, e), e.autoPlayClear = a.proxy(e.autoPlayClear, e), e.autoPlayIterator = a.proxy(e.autoPlayIterator, e), e.changeSlide = a.proxy(e.changeSlide, e), e.clickHandler = a.proxy(e.clickHandler, e), e.selectHandler = a.proxy(e.selectHandler, e), e.setPosition = a.proxy(e.setPosition, e), e.swipeHandler = a.proxy(e.swipeHandler, e), e.dragHandler = a.proxy(e.dragHandler, e), e.keyHandler = a.proxy(e.keyHandler, e), e.instanceUid = b++, e.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, e.registerBreakpoints(), e.init(!0)
        }
        var b = 0;
        return c
    }(), b.prototype.activateADA = function() {
        var a = this;
        a.$slideTrack.find(".slick-active").attr({ "aria-hidden": "false" }).find("a, input, button, select").attr({ tabindex: "0" })
    }, b.prototype.addSlide = b.prototype.slickAdd = function(b, c, d) {
        var e = this;
        if ("boolean" == typeof c) d = c, c = null;
        else if (0 > c || c >= e.slideCount) return !1;
        e.unload(), "number" == typeof c ? 0 === c && 0 === e.$slides.length ? a(b).appendTo(e.$slideTrack) : d ? a(b).insertBefore(e.$slides.eq(c)) : a(b).insertAfter(e.$slides.eq(c)) : d === !0 ? a(b).prependTo(e.$slideTrack) : a(b).appendTo(e.$slideTrack), e.$slides = e.$slideTrack.children(this.options.slide), e.$slideTrack.children(this.options.slide).detach(), e.$slideTrack.append(e.$slides), e.$slides.each(function(b, c) { a(c).attr("data-slick-index", b) }), e.$slidesCache = e.$slides, e.reinit()
    }, b.prototype.animateHeight = function() {
        var a = this;
        if (1 === a.options.slidesToShow && a.options.adaptiveHeight === !0 && a.options.vertical === !1) {
            var b = a.$slides.eq(a.currentSlide).outerHeight(!0);
            a.$list.animate({ height: b }, a.options.speed)
        }
    }, b.prototype.animateSlide = function(b, c) {
        var d = {},
            e = this;
        e.animateHeight(), e.options.rtl === !0 && e.options.vertical === !1 && (b = -b), e.transformsEnabled === !1 ? e.options.vertical === !1 ? e.$slideTrack.animate({ left: b }, e.options.speed, e.options.easing, c) : e.$slideTrack.animate({ top: b }, e.options.speed, e.options.easing, c) : e.cssTransitions === !1 ? (e.options.rtl === !0 && (e.currentLeft = -e.currentLeft), a({ animStart: e.currentLeft }).animate({ animStart: b }, { duration: e.options.speed, easing: e.options.easing, step: function(a) { a = Math.ceil(a), e.options.vertical === !1 ? (d[e.animType] = "translate(" + a + "px, 0px)", e.$slideTrack.css(d)) : (d[e.animType] = "translate(0px," + a + "px)", e.$slideTrack.css(d)) }, complete: function() { c && c.call() } })) : (e.applyTransition(), b = Math.ceil(b), e.options.vertical === !1 ? d[e.animType] = "translate3d(" + b + "px, 0px, 0px)" : d[e.animType] = "translate3d(0px," + b + "px, 0px)", e.$slideTrack.css(d), c && setTimeout(function() { e.disableTransition(), c.call() }, e.options.speed))
    }, b.prototype.getNavTarget = function() {
        var b = this,
            c = b.options.asNavFor;
        return c && null !== c && (c = a(c).not(b.$slider)), c
    }, b.prototype.asNavFor = function(b) {
        var c = this,
            d = c.getNavTarget();
        null !== d && "object" == typeof d && d.each(function() {
            var c = a(this).slick("getSlick");
            c.unslicked || c.slideHandler(b, !0)
        })
    }, b.prototype.applyTransition = function(a) {
        var b = this,
            c = {};
        b.options.fade === !1 ? c[b.transitionType] = b.transformType + " " + b.options.speed + "ms " + b.options.cssEase : c[b.transitionType] = "opacity " + b.options.speed + "ms " + b.options.cssEase, b.options.fade === !1 ? b.$slideTrack.css(c) : b.$slides.eq(a).css(c)
    }, b.prototype.autoPlay = function() {
        var a = this;
        a.autoPlayClear(), a.slideCount > a.options.slidesToShow && (a.autoPlayTimer = setInterval(a.autoPlayIterator, a.options.autoplaySpeed))
    }, b.prototype.autoPlayClear = function() {
        var a = this;
        a.autoPlayTimer && clearInterval(a.autoPlayTimer)
    }, b.prototype.autoPlayIterator = function() {
        var a = this,
            b = a.currentSlide + a.options.slidesToScroll;
        a.paused || a.interrupted || a.focussed || (a.options.infinite === !1 && (1 === a.direction && a.currentSlide + 1 === a.slideCount - 1 ? a.direction = 0 : 0 === a.direction && (b = a.currentSlide - a.options.slidesToScroll, a.currentSlide - 1 === 0 && (a.direction = 1))), a.slideHandler(b))
    }, b.prototype.buildArrows = function() {
        var b = this;
        b.options.arrows === !0 && (b.$prevArrow = a(b.options.prevArrow).addClass("slick-arrow"), b.$nextArrow = a(b.options.nextArrow).addClass("slick-arrow"), b.slideCount > b.options.slidesToShow ? (b.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), b.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), b.htmlExpr.test(b.options.prevArrow) && b.$prevArrow.prependTo(b.options.appendArrows), b.htmlExpr.test(b.options.nextArrow) && b.$nextArrow.appendTo(b.options.appendArrows), b.options.infinite !== !0 && b.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : b.$prevArrow.add(b.$nextArrow).addClass("slick-hidden").attr({ "aria-disabled": "true", tabindex: "-1" }))
    }, b.prototype.buildDots = function() {
        var c, d, b = this;
        if (b.options.dots === !0 && b.slideCount > b.options.slidesToShow) {
            for (b.$slider.addClass("slick-dotted"), d = a("<ul />").addClass(b.options.dotsClass), c = 0; c <= b.getDotCount(); c += 1) d.append(a("<li />").append(b.options.customPaging.call(this, b, c)));
            b.$dots = d.appendTo(b.options.appendDots), b.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
        }
    }, b.prototype.buildOut = function() {
        var b = this;
        b.$slides = b.$slider.children(b.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), b.slideCount = b.$slides.length, b.$slides.each(function(b, c) { a(c).attr("data-slick-index", b).data("originalStyling", a(c).attr("style") || "") }), b.$slider.addClass("slick-slider"), b.$slideTrack = 0 === b.slideCount ? a('<div class="slick-track"/>').appendTo(b.$slider) : b.$slides.wrapAll('<div class="slick-track"/>').parent(), b.$list = b.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent(), b.$slideTrack.css("opacity", 0), (b.options.centerMode === !0 || b.options.swipeToSlide === !0) && (b.options.slidesToScroll = 1), a("img[data-lazy]", b.$slider).not("[src]").addClass("slick-loading"), b.setupInfinite(), b.buildArrows(), b.buildDots(), b.updateDots(), b.setSlideClasses("number" == typeof b.currentSlide ? b.currentSlide : 0), b.options.draggable === !0 && b.$list.addClass("draggable")
    }, b.prototype.buildRows = function() {
        var b, c, d, e, f, g, h, a = this;
        if (e = document.createDocumentFragment(), g = a.$slider.children(), a.options.rows > 1) {
            for (h = a.options.slidesPerRow * a.options.rows, f = Math.ceil(g.length / h), b = 0; f > b; b++) {
                var i = document.createElement("div");
                for (c = 0; c < a.options.rows; c++) {
                    var j = document.createElement("div");
                    for (d = 0; d < a.options.slidesPerRow; d++) {
                        var k = b * h + (c * a.options.slidesPerRow + d);
                        g.get(k) && j.appendChild(g.get(k))
                    }
                    i.appendChild(j)
                }
                e.appendChild(i)
            }
            a.$slider.empty().append(e), a.$slider.children().children().children().css({ width: 100 / a.options.slidesPerRow + "%", display: "inline-block" })
        }
    }, b.prototype.checkResponsive = function(b, c) {
        var e, f, g, d = this,
            h = !1,
            i = d.$slider.width(),
            j = window.innerWidth || a(window).width();
        if ("window" === d.respondTo ? g = j : "slider" === d.respondTo ? g = i : "min" === d.respondTo && (g = Math.min(j, i)), d.options.responsive && d.options.responsive.length && null !== d.options.responsive) {
            f = null;
            for (e in d.breakpoints) d.breakpoints.hasOwnProperty(e) && (d.originalSettings.mobileFirst === !1 ? g < d.breakpoints[e] && (f = d.breakpoints[e]) : g > d.breakpoints[e] && (f = d.breakpoints[e]));
            null !== f ? null !== d.activeBreakpoint ? (f !== d.activeBreakpoint || c) && (d.activeBreakpoint = f, "unslick" === d.breakpointSettings[f] ? d.unslick(f) : (d.options = a.extend({}, d.originalSettings, d.breakpointSettings[f]), b === !0 && (d.currentSlide = d.options.initialSlide), d.refresh(b)), h = f) : (d.activeBreakpoint = f, "unslick" === d.breakpointSettings[f] ? d.unslick(f) : (d.options = a.extend({}, d.originalSettings, d.breakpointSettings[f]), b === !0 && (d.currentSlide = d.options.initialSlide), d.refresh(b)), h = f) : null !== d.activeBreakpoint && (d.activeBreakpoint = null, d.options = d.originalSettings, b === !0 && (d.currentSlide = d.options.initialSlide), d.refresh(b), h = f), b || h === !1 || d.$slider.trigger("breakpoint", [d, h])
        }
    }, b.prototype.changeSlide = function(b, c) {
        var f, g, h, d = this,
            e = a(b.currentTarget);
        switch (e.is("a") && b.preventDefault(), e.is("li") || (e = e.closest("li")), h = d.slideCount % d.options.slidesToScroll !== 0, f = h ? 0 : (d.slideCount - d.currentSlide) % d.options.slidesToScroll, b.data.message) {
            case "previous":
                g = 0 === f ? d.options.slidesToScroll : d.options.slidesToShow - f, d.slideCount > d.options.slidesToShow && d.slideHandler(d.currentSlide - g, !1, c);
                break;
            case "next":
                g = 0 === f ? d.options.slidesToScroll : f, d.slideCount > d.options.slidesToShow && d.slideHandler(d.currentSlide + g, !1, c);
                break;
            case "index":
                var i = 0 === b.data.index ? 0 : b.data.index || e.index() * d.options.slidesToScroll;
                d.slideHandler(d.checkNavigable(i), !1, c), e.children().trigger("focus");
                break;
            default:
                return
        }
    }, b.prototype.checkNavigable = function(a) {
        var c, d, b = this;
        if (c = b.getNavigableIndexes(), d = 0, a > c[c.length - 1]) a = c[c.length - 1];
        else
            for (var e in c) { if (a < c[e]) { a = d; break } d = c[e] }
        return a
    }, b.prototype.cleanUpEvents = function() {
        var b = this;
        b.options.dots && null !== b.$dots && a("li", b.$dots).off("click.slick", b.changeSlide).off("mouseenter.slick", a.proxy(b.interrupt, b, !0)).off("mouseleave.slick", a.proxy(b.interrupt, b, !1)), b.$slider.off("focus.slick blur.slick"), b.options.arrows === !0 && b.slideCount > b.options.slidesToShow && (b.$prevArrow && b.$prevArrow.off("click.slick", b.changeSlide), b.$nextArrow && b.$nextArrow.off("click.slick", b.changeSlide)), b.$list.off("touchstart.slick mousedown.slick", b.swipeHandler), b.$list.off("touchmove.slick mousemove.slick", b.swipeHandler), b.$list.off("touchend.slick mouseup.slick", b.swipeHandler), b.$list.off("touchcancel.slick mouseleave.slick", b.swipeHandler), b.$list.off("click.slick", b.clickHandler), a(document).off(b.visibilityChange, b.visibility), b.cleanUpSlideEvents(), b.options.accessibility === !0 && b.$list.off("keydown.slick", b.keyHandler), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().off("click.slick", b.selectHandler), a(window).off("orientationchange.slick.slick-" + b.instanceUid, b.orientationChange), a(window).off("resize.slick.slick-" + b.instanceUid, b.resize), a("[draggable!=true]", b.$slideTrack).off("dragstart", b.preventDefault), a(window).off("load.slick.slick-" + b.instanceUid, b.setPosition), a(document).off("ready.slick.slick-" + b.instanceUid, b.setPosition)
    }, b.prototype.cleanUpSlideEvents = function() {
        var b = this;
        b.$list.off("mouseenter.slick", a.proxy(b.interrupt, b, !0)), b.$list.off("mouseleave.slick", a.proxy(b.interrupt, b, !1))
    }, b.prototype.cleanUpRows = function() {
        var b, a = this;
        a.options.rows > 1 && (b = a.$slides.children().children(), b.removeAttr("style"), a.$slider.empty().append(b))
    }, b.prototype.clickHandler = function(a) {
        var b = this;
        b.shouldClick === !1 && (a.stopImmediatePropagation(), a.stopPropagation(), a.preventDefault())
    }, b.prototype.destroy = function(b) {
        var c = this;
        c.autoPlayClear(), c.touchObject = {}, c.cleanUpEvents(), a(".slick-cloned", c.$slider).detach(), c.$dots && c.$dots.remove(), c.$prevArrow && c.$prevArrow.length && (c.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), c.htmlExpr.test(c.options.prevArrow) && c.$prevArrow.remove()), c.$nextArrow && c.$nextArrow.length && (c.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), c.htmlExpr.test(c.options.nextArrow) && c.$nextArrow.remove()), c.$slides && (c.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function() { a(this).attr("style", a(this).data("originalStyling")) }), c.$slideTrack.children(this.options.slide).detach(), c.$slideTrack.detach(), c.$list.detach(), c.$slider.append(c.$slides)), c.cleanUpRows(), c.$slider.removeClass("slick-slider"), c.$slider.removeClass("slick-initialized"), c.$slider.removeClass("slick-dotted"), c.unslicked = !0, b || c.$slider.trigger("destroy", [c])
    }, b.prototype.disableTransition = function(a) {
        var b = this,
            c = {};
        c[b.transitionType] = "", b.options.fade === !1 ? b.$slideTrack.css(c) : b.$slides.eq(a).css(c)
    }, b.prototype.fadeSlide = function(a, b) {
        var c = this;
        c.cssTransitions === !1 ? (c.$slides.eq(a).css({ zIndex: c.options.zIndex }), c.$slides.eq(a).animate({ opacity: 1 }, c.options.speed, c.options.easing, b)) : (c.applyTransition(a), c.$slides.eq(a).css({ opacity: 1, zIndex: c.options.zIndex }), b && setTimeout(function() { c.disableTransition(a), b.call() }, c.options.speed))
    }, b.prototype.fadeSlideOut = function(a) {
        var b = this;
        b.cssTransitions === !1 ? b.$slides.eq(a).animate({ opacity: 0, zIndex: b.options.zIndex - 2 }, b.options.speed, b.options.easing) : (b.applyTransition(a), b.$slides.eq(a).css({ opacity: 0, zIndex: b.options.zIndex - 2 }))
    }, b.prototype.filterSlides = b.prototype.slickFilter = function(a) {
        var b = this;
        null !== a && (b.$slidesCache = b.$slides, b.unload(), b.$slideTrack.children(this.options.slide).detach(), b.$slidesCache.filter(a).appendTo(b.$slideTrack), b.reinit())
    }, b.prototype.focusHandler = function() {
        var b = this;
        b.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*:not(.slick-arrow)", function(c) {
            c.stopImmediatePropagation();
            var d = a(this);
            setTimeout(function() { b.options.pauseOnFocus && (b.focussed = d.is(":focus"), b.autoPlay()) }, 0)
        })
    }, b.prototype.getCurrent = b.prototype.slickCurrentSlide = function() { var a = this; return a.currentSlide }, b.prototype.getDotCount = function() {
        var a = this,
            b = 0,
            c = 0,
            d = 0;
        if (a.options.infinite === !0)
            for (; b < a.slideCount;) ++d, b = c + a.options.slidesToScroll, c += a.options.slidesToScroll <= a.options.slidesToShow ? a.options.slidesToScroll : a.options.slidesToShow;
        else if (a.options.centerMode === !0) d = a.slideCount;
        else if (a.options.asNavFor)
            for (; b < a.slideCount;) ++d, b = c + a.options.slidesToScroll, c += a.options.slidesToScroll <= a.options.slidesToShow ? a.options.slidesToScroll : a.options.slidesToShow;
        else d = 1 + Math.ceil((a.slideCount - a.options.slidesToShow) / a.options.slidesToScroll);
        return d - 1
    }, b.prototype.getLeft = function(a) {
        var c, d, f, b = this,
            e = 0;
        return b.slideOffset = 0, d = b.$slides.first().outerHeight(!0), b.options.infinite === !0 ? (b.slideCount > b.options.slidesToShow && (b.slideOffset = b.slideWidth * b.options.slidesToShow * -1, e = d * b.options.slidesToShow * -1), b.slideCount % b.options.slidesToScroll !== 0 && a + b.options.slidesToScroll > b.slideCount && b.slideCount > b.options.slidesToShow && (a > b.slideCount ? (b.slideOffset = (b.options.slidesToShow - (a - b.slideCount)) * b.slideWidth * -1, e = (b.options.slidesToShow - (a - b.slideCount)) * d * -1) : (b.slideOffset = b.slideCount % b.options.slidesToScroll * b.slideWidth * -1, e = b.slideCount % b.options.slidesToScroll * d * -1))) : a + b.options.slidesToShow > b.slideCount && (b.slideOffset = (a + b.options.slidesToShow - b.slideCount) * b.slideWidth, e = (a + b.options.slidesToShow - b.slideCount) * d), b.slideCount <= b.options.slidesToShow && (b.slideOffset = 0, e = 0), b.options.centerMode === !0 && b.options.infinite === !0 ? b.slideOffset += b.slideWidth * Math.floor(b.options.slidesToShow / 2) - b.slideWidth : b.options.centerMode === !0 && (b.slideOffset = 0, b.slideOffset += b.slideWidth * Math.floor(b.options.slidesToShow / 2)), c = b.options.vertical === !1 ? a * b.slideWidth * -1 + b.slideOffset : a * d * -1 + e, b.options.variableWidth === !0 && (f = b.slideCount <= b.options.slidesToShow || b.options.infinite === !1 ? b.$slideTrack.children(".slick-slide").eq(a) : b.$slideTrack.children(".slick-slide").eq(a + b.options.slidesToShow), c = b.options.rtl === !0 ? f[0] ? -1 * (b.$slideTrack.width() - f[0].offsetLeft - f.width()) : 0 : f[0] ? -1 * f[0].offsetLeft : 0, b.options.centerMode === !0 && (f = b.slideCount <= b.options.slidesToShow || b.options.infinite === !1 ? b.$slideTrack.children(".slick-slide").eq(a) : b.$slideTrack.children(".slick-slide").eq(a + b.options.slidesToShow + 1), c = b.options.rtl === !0 ? f[0] ? -1 * (b.$slideTrack.width() - f[0].offsetLeft - f.width()) : 0 : f[0] ? -1 * f[0].offsetLeft : 0, c += (b.$list.width() - f.outerWidth()) / 2)), c
    }, b.prototype.getOption = b.prototype.slickGetOption = function(a) { var b = this; return b.options[a] }, b.prototype.getNavigableIndexes = function() {
        var e, a = this,
            b = 0,
            c = 0,
            d = [];
        for (a.options.infinite === !1 ? e = a.slideCount : (b = -1 * a.options.slidesToScroll, c = -1 * a.options.slidesToScroll, e = 2 * a.slideCount); e > b;) d.push(b), b = c + a.options.slidesToScroll, c += a.options.slidesToScroll <= a.options.slidesToShow ? a.options.slidesToScroll : a.options.slidesToShow;
        return d
    }, b.prototype.getSlick = function() { return this }, b.prototype.getSlideCount = function() { var c, d, e, b = this; return e = b.options.centerMode === !0 ? b.slideWidth * Math.floor(b.options.slidesToShow / 2) : 0, b.options.swipeToSlide === !0 ? (b.$slideTrack.find(".slick-slide").each(function(c, f) { return f.offsetLeft - e + a(f).outerWidth() / 2 > -1 * b.swipeLeft ? (d = f, !1) : void 0 }), c = Math.abs(a(d).attr("data-slick-index") - b.currentSlide) || 1) : b.options.slidesToScroll }, b.prototype.goTo = b.prototype.slickGoTo = function(a, b) {
        var c = this;
        c.changeSlide({ data: { message: "index", index: parseInt(a) } }, b)
    }, b.prototype.init = function(b) {
        var c = this;
        a(c.$slider).hasClass("slick-initialized") || (a(c.$slider).addClass("slick-initialized"), c.buildRows(), c.buildOut(), c.setProps(), c.startLoad(), c.loadSlider(), c.initializeEvents(), c.updateArrows(), c.updateDots(), c.checkResponsive(!0), c.focusHandler()), b && c.$slider.trigger("init", [c]), c.options.accessibility === !0 && c.initADA(), c.options.autoplay && (c.paused = !1, c.autoPlay())
    }, b.prototype.initADA = function() {
        var b = this;
        b.$slides.add(b.$slideTrack.find(".slick-cloned")).attr({ "aria-hidden": "true", tabindex: "-1" }).find("a, input, button, select").attr({ tabindex: "-1" }), b.$slideTrack.attr("role", "listbox"), b.$slides.not(b.$slideTrack.find(".slick-cloned")).each(function(c) { a(this).attr({ role: "option", "aria-describedby": "slick-slide" + b.instanceUid + c }) }), null !== b.$dots && b.$dots.attr("role", "tablist").find("li").each(function(c) { a(this).attr({ role: "presentation", "aria-selected": "false", "aria-controls": "navigation" + b.instanceUid + c, id: "slick-slide" + b.instanceUid + c }) }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar"), b.activateADA()
    }, b.prototype.initArrowEvents = function() {
        var a = this;
        a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.off("click.slick").on("click.slick", { message: "previous" }, a.changeSlide), a.$nextArrow.off("click.slick").on("click.slick", { message: "next" }, a.changeSlide))
    }, b.prototype.initDotEvents = function() {
        var b = this;
        b.options.dots === !0 && b.slideCount > b.options.slidesToShow && a("li", b.$dots).on("click.slick", { message: "index" }, b.changeSlide), b.options.dots === !0 && b.options.pauseOnDotsHover === !0 && a("li", b.$dots).on("mouseenter.slick", a.proxy(b.interrupt, b, !0)).on("mouseleave.slick", a.proxy(b.interrupt, b, !1))
    }, b.prototype.initSlideEvents = function() {
        var b = this;
        b.options.pauseOnHover && (b.$list.on("mouseenter.slick", a.proxy(b.interrupt, b, !0)), b.$list.on("mouseleave.slick", a.proxy(b.interrupt, b, !1)))
    }, b.prototype.initializeEvents = function() {
        var b = this;
        b.initArrowEvents(), b.initDotEvents(), b.initSlideEvents(), b.$list.on("touchstart.slick mousedown.slick", { action: "start" }, b.swipeHandler), b.$list.on("touchmove.slick mousemove.slick", { action: "move" }, b.swipeHandler), b.$list.on("touchend.slick mouseup.slick", { action: "end" }, b.swipeHandler), b.$list.on("touchcancel.slick mouseleave.slick", { action: "end" }, b.swipeHandler), b.$list.on("click.slick", b.clickHandler), a(document).on(b.visibilityChange, a.proxy(b.visibility, b)), b.options.accessibility === !0 && b.$list.on("keydown.slick", b.keyHandler), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().on("click.slick", b.selectHandler), a(window).on("orientationchange.slick.slick-" + b.instanceUid, a.proxy(b.orientationChange, b)), a(window).on("resize.slick.slick-" + b.instanceUid, a.proxy(b.resize, b)), a("[draggable!=true]", b.$slideTrack).on("dragstart", b.preventDefault), a(window).on("load.slick.slick-" + b.instanceUid, b.setPosition), a(document).on("ready.slick.slick-" + b.instanceUid, b.setPosition)
    }, b.prototype.initUI = function() {
        var a = this;
        a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.show(), a.$nextArrow.show()), a.options.dots === !0 && a.slideCount > a.options.slidesToShow && a.$dots.show()
    }, b.prototype.keyHandler = function(a) {
        var b = this;
        a.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === a.keyCode && b.options.accessibility === !0 ? b.changeSlide({ data: { message: b.options.rtl === !0 ? "next" : "previous" } }) : 39 === a.keyCode && b.options.accessibility === !0 && b.changeSlide({ data: { message: b.options.rtl === !0 ? "previous" : "next" } }))
    }, b.prototype.lazyLoad = function() {
        function g(c) {
            a("img[data-lazy]", c).each(function() {
                var c = a(this),
                    d = a(this).attr("data-lazy"),
                    e = document.createElement("img");
                e.onload = function() { c.animate({ opacity: 0 }, 100, function() { c.attr("src", d).animate({ opacity: 1 }, 200, function() { c.removeAttr("data-lazy").removeClass("slick-loading") }), b.$slider.trigger("lazyLoaded", [b, c, d]) }) }, e.onerror = function() { c.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), b.$slider.trigger("lazyLoadError", [b, c, d]) }, e.src = d
            })
        }
        var c, d, e, f, b = this;
        b.options.centerMode === !0 ? b.options.infinite === !0 ? (e = b.currentSlide + (b.options.slidesToShow / 2 + 1), f = e + b.options.slidesToShow + 2) : (e = Math.max(0, b.currentSlide - (b.options.slidesToShow / 2 + 1)), f = 2 + (b.options.slidesToShow / 2 + 1) + b.currentSlide) : (e = b.options.infinite ? b.options.slidesToShow + b.currentSlide : b.currentSlide, f = Math.ceil(e + b.options.slidesToShow), b.options.fade === !0 && (e > 0 && e--, f <= b.slideCount && f++)), c = b.$slider.find(".slick-slide").slice(e, f), g(c), b.slideCount <= b.options.slidesToShow ? (d = b.$slider.find(".slick-slide"), g(d)) : b.currentSlide >= b.slideCount - b.options.slidesToShow ? (d = b.$slider.find(".slick-cloned").slice(0, b.options.slidesToShow), g(d)) : 0 === b.currentSlide && (d = b.$slider.find(".slick-cloned").slice(-1 * b.options.slidesToShow), g(d))
    }, b.prototype.loadSlider = function() {
        var a = this;
        a.setPosition(), a.$slideTrack.css({ opacity: 1 }), a.$slider.removeClass("slick-loading"), a.initUI(), "progressive" === a.options.lazyLoad && a.progressiveLazyLoad()
    }, b.prototype.next = b.prototype.slickNext = function() {
        var a = this;
        a.changeSlide({ data: { message: "next" } })
    }, b.prototype.orientationChange = function() {
        var a = this;
        a.checkResponsive(), a.setPosition()
    }, b.prototype.pause = b.prototype.slickPause = function() {
        var a = this;
        a.autoPlayClear(), a.paused = !0
    }, b.prototype.play = b.prototype.slickPlay = function() {
        var a = this;
        a.autoPlay(), a.options.autoplay = !0, a.paused = !1, a.focussed = !1, a.interrupted = !1
    }, b.prototype.postSlide = function(a) {
        var b = this;
        b.unslicked || (b.$slider.trigger("afterChange", [b, a]), b.animating = !1, b.setPosition(), b.swipeLeft = null, b.options.autoplay && b.autoPlay(), b.options.accessibility === !0 && b.initADA())
    }, b.prototype.prev = b.prototype.slickPrev = function() {
        var a = this;
        a.changeSlide({ data: { message: "previous" } })
    }, b.prototype.preventDefault = function(a) { a.preventDefault() }, b.prototype.progressiveLazyLoad = function(b) {
        b = b || 1;
        var e, f, g, c = this,
            d = a("img[data-lazy]", c.$slider);
        d.length ? (e = d.first(), f = e.attr("data-lazy"), g = document.createElement("img"), g.onload = function() { e.attr("src", f).removeAttr("data-lazy").removeClass("slick-loading"), c.options.adaptiveHeight === !0 && c.setPosition(), c.$slider.trigger("lazyLoaded", [c, e, f]), c.progressiveLazyLoad() }, g.onerror = function() { 3 > b ? setTimeout(function() { c.progressiveLazyLoad(b + 1) }, 500) : (e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), c.$slider.trigger("lazyLoadError", [c, e, f]), c.progressiveLazyLoad()) }, g.src = f) : c.$slider.trigger("allImagesLoaded", [c])
    }, b.prototype.refresh = function(b) {
        var d, e, c = this;
        e = c.slideCount - c.options.slidesToShow, !c.options.infinite && c.currentSlide > e && (c.currentSlide = e), c.slideCount <= c.options.slidesToShow && (c.currentSlide = 0), d = c.currentSlide, c.destroy(!0), a.extend(c, c.initials, { currentSlide: d }), c.init(), b || c.changeSlide({ data: { message: "index", index: d } }, !1)
    }, b.prototype.registerBreakpoints = function() {
        var c, d, e, b = this,
            f = b.options.responsive || null;
        if ("array" === a.type(f) && f.length) {
            b.respondTo = b.options.respondTo || "window";
            for (c in f)
                if (e = b.breakpoints.length - 1, d = f[c].breakpoint, f.hasOwnProperty(c)) {
                    for (; e >= 0;) b.breakpoints[e] && b.breakpoints[e] === d && b.breakpoints.splice(e, 1), e--;
                    b.breakpoints.push(d), b.breakpointSettings[d] = f[c].settings
                }
            b.breakpoints.sort(function(a, c) { return b.options.mobileFirst ? a - c : c - a })
        }
    }, b.prototype.reinit = function() {
        var b = this;
        b.$slides = b.$slideTrack.children(b.options.slide).addClass("slick-slide"), b.slideCount = b.$slides.length, b.currentSlide >= b.slideCount && 0 !== b.currentSlide && (b.currentSlide = b.currentSlide - b.options.slidesToScroll), b.slideCount <= b.options.slidesToShow && (b.currentSlide = 0), b.registerBreakpoints(), b.setProps(), b.setupInfinite(), b.buildArrows(), b.updateArrows(), b.initArrowEvents(), b.buildDots(), b.updateDots(), b.initDotEvents(), b.cleanUpSlideEvents(), b.initSlideEvents(), b.checkResponsive(!1, !0), b.options.focusOnSelect === !0 && a(b.$slideTrack).children().on("click.slick", b.selectHandler), b.setSlideClasses("number" == typeof b.currentSlide ? b.currentSlide : 0), b.setPosition(), b.focusHandler(), b.paused = !b.options.autoplay, b.autoPlay(), b.$slider.trigger("reInit", [b])
    }, b.prototype.resize = function() {
        var b = this;
        a(window).width() !== b.windowWidth && (clearTimeout(b.windowDelay), b.windowDelay = window.setTimeout(function() { b.windowWidth = a(window).width(), b.checkResponsive(), b.unslicked || b.setPosition() }, 50))
    }, b.prototype.removeSlide = b.prototype.slickRemove = function(a, b, c) { var d = this; return "boolean" == typeof a ? (b = a, a = b === !0 ? 0 : d.slideCount - 1) : a = b === !0 ? --a : a, d.slideCount < 1 || 0 > a || a > d.slideCount - 1 ? !1 : (d.unload(), c === !0 ? d.$slideTrack.children().remove() : d.$slideTrack.children(this.options.slide).eq(a).remove(), d.$slides = d.$slideTrack.children(this.options.slide), d.$slideTrack.children(this.options.slide).detach(), d.$slideTrack.append(d.$slides), d.$slidesCache = d.$slides, void d.reinit()) }, b.prototype.setCSS = function(a) {
        var d, e, b = this,
            c = {};
        b.options.rtl === !0 && (a = -a), d = "left" == b.positionProp ? Math.ceil(a) + "px" : "0px", e = "top" == b.positionProp ? Math.ceil(a) + "px" : "0px", c[b.positionProp] = a, b.transformsEnabled === !1 ? b.$slideTrack.css(c) : (c = {}, b.cssTransitions === !1 ? (c[b.animType] = "translate(" + d + ", " + e + ")", b.$slideTrack.css(c)) : (c[b.animType] = "translate3d(" + d + ", " + e + ", 0px)", b.$slideTrack.css(c)))
    }, b.prototype.setDimensions = function() {
        var a = this;
        a.options.vertical === !1 ? a.options.centerMode === !0 && a.$list.css({ padding: "0px " + a.options.centerPadding }) : (a.$list.height(a.$slides.first().outerHeight(!0) * a.options.slidesToShow), a.options.centerMode === !0 && a.$list.css({ padding: a.options.centerPadding + " 0px" })), a.listWidth = a.$list.width(), a.listHeight = a.$list.height(), a.options.vertical === !1 && a.options.variableWidth === !1 ? (a.slideWidth = Math.ceil(a.listWidth / a.options.slidesToShow), a.$slideTrack.width(Math.ceil(a.slideWidth * a.$slideTrack.children(".slick-slide").length))) : a.options.variableWidth === !0 ? a.$slideTrack.width(5e3 * a.slideCount) : (a.slideWidth = Math.ceil(a.listWidth), a.$slideTrack.height(Math.ceil(a.$slides.first().outerHeight(!0) * a.$slideTrack.children(".slick-slide").length)));
        var b = a.$slides.first().outerWidth(!0) - a.$slides.first().width();
        a.options.variableWidth === !1 && a.$slideTrack.children(".slick-slide").width(a.slideWidth - b)
    }, b.prototype.setFade = function() {
        var c, b = this;
        b.$slides.each(function(d, e) { c = b.slideWidth * d * -1, b.options.rtl === !0 ? a(e).css({ position: "relative", right: c, top: 0, zIndex: b.options.zIndex - 2, opacity: 0 }) : a(e).css({ position: "relative", left: c, top: 0, zIndex: b.options.zIndex - 2, opacity: 0 }) }), b.$slides.eq(b.currentSlide).css({ zIndex: b.options.zIndex - 1, opacity: 1 })
    }, b.prototype.setHeight = function() {
        var a = this;
        if (1 === a.options.slidesToShow && a.options.adaptiveHeight === !0 && a.options.vertical === !1) {
            var b = a.$slides.eq(a.currentSlide).outerHeight(!0);
            a.$list.css("height", b)
        }
    }, b.prototype.setOption = b.prototype.slickSetOption = function() {
        var c, d, e, f, h, b = this,
            g = !1;
        if ("object" === a.type(arguments[0]) ? (e = arguments[0], g = arguments[1], h = "multiple") : "string" === a.type(arguments[0]) && (e = arguments[0], f = arguments[1], g = arguments[2], "responsive" === arguments[0] && "array" === a.type(arguments[1]) ? h = "responsive" : "undefined" != typeof arguments[1] && (h = "single")), "single" === h) b.options[e] = f;
        else if ("multiple" === h) a.each(e, function(a, c) { b.options[a] = c });
        else if ("responsive" === h)
            for (d in f)
                if ("array" !== a.type(b.options.responsive)) b.options.responsive = [f[d]];
                else {
                    for (c = b.options.responsive.length - 1; c >= 0;) b.options.responsive[c].breakpoint === f[d].breakpoint && b.options.responsive.splice(c, 1), c--;
                    b.options.responsive.push(f[d])
                }
        g && (b.unload(), b.reinit())
    }, b.prototype.setPosition = function() {
        var a = this;
        a.setDimensions(), a.setHeight(), a.options.fade === !1 ? a.setCSS(a.getLeft(a.currentSlide)) : a.setFade(), a.$slider.trigger("setPosition", [a])
    }, b.prototype.setProps = function() {
        var a = this,
            b = document.body.style;
        a.positionProp = a.options.vertical === !0 ? "top" : "left", "top" === a.positionProp ? a.$slider.addClass("slick-vertical") : a.$slider.removeClass("slick-vertical"), (void 0 !== b.WebkitTransition || void 0 !== b.MozTransition || void 0 !== b.msTransition) && a.options.useCSS === !0 && (a.cssTransitions = !0), a.options.fade && ("number" == typeof a.options.zIndex ? a.options.zIndex < 3 && (a.options.zIndex = 3) : a.options.zIndex = a.defaults.zIndex), void 0 !== b.OTransform && (a.animType = "OTransform", a.transformType = "-o-transform", a.transitionType = "OTransition", void 0 === b.perspectiveProperty && void 0 === b.webkitPerspective && (a.animType = !1)), void 0 !== b.MozTransform && (a.animType = "MozTransform", a.transformType = "-moz-transform", a.transitionType = "MozTransition", void 0 === b.perspectiveProperty && void 0 === b.MozPerspective && (a.animType = !1)), void 0 !== b.webkitTransform && (a.animType = "webkitTransform", a.transformType = "-webkit-transform", a.transitionType = "webkitTransition", void 0 === b.perspectiveProperty && void 0 === b.webkitPerspective && (a.animType = !1)), void 0 !== b.msTransform && (a.animType = "msTransform", a.transformType = "-ms-transform", a.transitionType = "msTransition", void 0 === b.msTransform && (a.animType = !1)), void 0 !== b.transform && a.animType !== !1 && (a.animType = "transform", a.transformType = "transform", a.transitionType = "transition"), a.transformsEnabled = a.options.useTransform && null !== a.animType && a.animType !== !1
    }, b.prototype.setSlideClasses = function(a) {
        var c, d, e, f, b = this;
        d = b.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), b.$slides.eq(a).addClass("slick-current"), b.options.centerMode === !0 ? (c = Math.floor(b.options.slidesToShow / 2), b.options.infinite === !0 && (a >= c && a <= b.slideCount - 1 - c ? b.$slides.slice(a - c, a + c + 1).addClass("slick-active").attr("aria-hidden", "false") : (e = b.options.slidesToShow + a, d.slice(e - c + 1, e + c + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === a ? d.eq(d.length - 1 - b.options.slidesToShow).addClass("slick-center") : a === b.slideCount - 1 && d.eq(b.options.slidesToShow).addClass("slick-center")), b.$slides.eq(a).addClass("slick-center")) : a >= 0 && a <= b.slideCount - b.options.slidesToShow ? b.$slides.slice(a, a + b.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : d.length <= b.options.slidesToShow ? d.addClass("slick-active").attr("aria-hidden", "false") : (f = b.slideCount % b.options.slidesToShow, e = b.options.infinite === !0 ? b.options.slidesToShow + a : a, b.options.slidesToShow == b.options.slidesToScroll && b.slideCount - a < b.options.slidesToShow ? d.slice(e - (b.options.slidesToShow - f), e + f).addClass("slick-active").attr("aria-hidden", "false") : d.slice(e, e + b.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false")), "ondemand" === b.options.lazyLoad && b.lazyLoad()
    }, b.prototype.setupInfinite = function() {
        var c, d, e, b = this;
        if (b.options.fade === !0 && (b.options.centerMode = !1), b.options.infinite === !0 && b.options.fade === !1 && (d = null, b.slideCount > b.options.slidesToShow)) {
            for (e = b.options.centerMode === !0 ? b.options.slidesToShow + 1 : b.options.slidesToShow, c = b.slideCount; c > b.slideCount - e; c -= 1) d = c - 1, a(b.$slides[d]).clone(!0).attr("id", "").attr("data-slick-index", d - b.slideCount).prependTo(b.$slideTrack).addClass("slick-cloned");
            for (c = 0; e > c; c += 1) d = c, a(b.$slides[d]).clone(!0).attr("id", "").attr("data-slick-index", d + b.slideCount).appendTo(b.$slideTrack).addClass("slick-cloned");
            b.$slideTrack.find(".slick-cloned").find("[id]").each(function() { a(this).attr("id", "") })
        }
    }, b.prototype.interrupt = function(a) {
        var b = this;
        a || b.autoPlay(), b.interrupted = a
    }, b.prototype.selectHandler = function(b) {
        var c = this,
            d = a(b.target).is(".slick-slide") ? a(b.target) : a(b.target).parents(".slick-slide"),
            e = parseInt(d.attr("data-slick-index"));
        return e || (e = 0), c.slideCount <= c.options.slidesToShow ? (c.setSlideClasses(e), void c.asNavFor(e)) : void c.slideHandler(e)
    }, b.prototype.slideHandler = function(a, b, c) {
        var d, e, f, g, j, h = null,
            i = this;
        return b = b || !1, i.animating === !0 && i.options.waitForAnimate === !0 || i.options.fade === !0 && i.currentSlide === a || i.slideCount <= i.options.slidesToShow ? void 0 : (b === !1 && i.asNavFor(a), d = a, h = i.getLeft(d), g = i.getLeft(i.currentSlide), i.currentLeft = null === i.swipeLeft ? g : i.swipeLeft, i.options.infinite === !1 && i.options.centerMode === !1 && (0 > a || a > i.getDotCount() * i.options.slidesToScroll) ? void(i.options.fade === !1 && (d = i.currentSlide, c !== !0 ? i.animateSlide(g, function() { i.postSlide(d) }) : i.postSlide(d))) : i.options.infinite === !1 && i.options.centerMode === !0 && (0 > a || a > i.slideCount - i.options.slidesToScroll) ? void(i.options.fade === !1 && (d = i.currentSlide, c !== !0 ? i.animateSlide(g, function() { i.postSlide(d) }) : i.postSlide(d))) : (i.options.autoplay && clearInterval(i.autoPlayTimer), e = 0 > d ? i.slideCount % i.options.slidesToScroll !== 0 ? i.slideCount - i.slideCount % i.options.slidesToScroll : i.slideCount + d : d >= i.slideCount ? i.slideCount % i.options.slidesToScroll !== 0 ? 0 : d - i.slideCount : d, i.animating = !0, i.$slider.trigger("beforeChange", [i, i.currentSlide, e]), f = i.currentSlide, i.currentSlide = e, i.setSlideClasses(i.currentSlide), i.options.asNavFor && (j = i.getNavTarget(), j = j.slick("getSlick"), j.slideCount <= j.options.slidesToShow && j.setSlideClasses(i.currentSlide)), i.updateDots(), i.updateArrows(), i.options.fade === !0 ? (c !== !0 ? (i.fadeSlideOut(f), i.fadeSlide(e, function() { i.postSlide(e) })) : i.postSlide(e), void i.animateHeight()) : void(c !== !0 ? i.animateSlide(h, function() { i.postSlide(e) }) : i.postSlide(e))))
    }, b.prototype.startLoad = function() {
        var a = this;
        a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && (a.$prevArrow.hide(), a.$nextArrow.hide()), a.options.dots === !0 && a.slideCount > a.options.slidesToShow && a.$dots.hide(), a.$slider.addClass("slick-loading")
    }, b.prototype.swipeDirection = function() { var a, b, c, d, e = this; return a = e.touchObject.startX - e.touchObject.curX, b = e.touchObject.startY - e.touchObject.curY, c = Math.atan2(b, a), d = Math.round(180 * c / Math.PI), 0 > d && (d = 360 - Math.abs(d)), 45 >= d && d >= 0 ? e.options.rtl === !1 ? "left" : "right" : 360 >= d && d >= 315 ? e.options.rtl === !1 ? "left" : "right" : d >= 135 && 225 >= d ? e.options.rtl === !1 ? "right" : "left" : e.options.verticalSwiping === !0 ? d >= 35 && 135 >= d ? "down" : "up" : "vertical" }, b.prototype.swipeEnd = function(a) {
        var c, d, b = this;
        if (b.dragging = !1, b.interrupted = !1, b.shouldClick = b.touchObject.swipeLength > 10 ? !1 : !0, void 0 === b.touchObject.curX) return !1;
        if (b.touchObject.edgeHit === !0 && b.$slider.trigger("edge", [b, b.swipeDirection()]), b.touchObject.swipeLength >= b.touchObject.minSwipe) {
            switch (d = b.swipeDirection()) {
                case "left":
                case "down":
                    c = b.options.swipeToSlide ? b.checkNavigable(b.currentSlide + b.getSlideCount()) : b.currentSlide + b.getSlideCount(), b.currentDirection = 0;
                    break;
                case "right":
                case "up":
                    c = b.options.swipeToSlide ? b.checkNavigable(b.currentSlide - b.getSlideCount()) : b.currentSlide - b.getSlideCount(), b.currentDirection = 1
            }
            "vertical" != d && (b.slideHandler(c), b.touchObject = {}, b.$slider.trigger("swipe", [b, d]))
        } else b.touchObject.startX !== b.touchObject.curX && (b.slideHandler(b.currentSlide), b.touchObject = {})
    }, b.prototype.swipeHandler = function(a) {
        var b = this;
        if (!(b.options.swipe === !1 || "ontouchend" in document && b.options.swipe === !1 || b.options.draggable === !1 && -1 !== a.type.indexOf("mouse"))) switch (b.touchObject.fingerCount = a.originalEvent && void 0 !== a.originalEvent.touches ? a.originalEvent.touches.length : 1, b.touchObject.minSwipe = b.listWidth / b.options.touchThreshold, b.options.verticalSwiping === !0 && (b.touchObject.minSwipe = b.listHeight / b.options.touchThreshold), a.data.action) {
            case "start":
                b.swipeStart(a);
                break;
            case "move":
                b.swipeMove(a);
                break;
            case "end":
                b.swipeEnd(a)
        }
    }, b.prototype.swipeMove = function(a) { var d, e, f, g, h, b = this; return h = void 0 !== a.originalEvent ? a.originalEvent.touches : null, !b.dragging || h && 1 !== h.length ? !1 : (d = b.getLeft(b.currentSlide), b.touchObject.curX = void 0 !== h ? h[0].pageX : a.clientX, b.touchObject.curY = void 0 !== h ? h[0].pageY : a.clientY, b.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(b.touchObject.curX - b.touchObject.startX, 2))), b.options.verticalSwiping === !0 && (b.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(b.touchObject.curY - b.touchObject.startY, 2)))), e = b.swipeDirection(), "vertical" !== e ? (void 0 !== a.originalEvent && b.touchObject.swipeLength > 4 && a.preventDefault(), g = (b.options.rtl === !1 ? 1 : -1) * (b.touchObject.curX > b.touchObject.startX ? 1 : -1), b.options.verticalSwiping === !0 && (g = b.touchObject.curY > b.touchObject.startY ? 1 : -1), f = b.touchObject.swipeLength, b.touchObject.edgeHit = !1, b.options.infinite === !1 && (0 === b.currentSlide && "right" === e || b.currentSlide >= b.getDotCount() && "left" === e) && (f = b.touchObject.swipeLength * b.options.edgeFriction, b.touchObject.edgeHit = !0), b.options.vertical === !1 ? b.swipeLeft = d + f * g : b.swipeLeft = d + f * (b.$list.height() / b.listWidth) * g, b.options.verticalSwiping === !0 && (b.swipeLeft = d + f * g), b.options.fade === !0 || b.options.touchMove === !1 ? !1 : b.animating === !0 ? (b.swipeLeft = null, !1) : void b.setCSS(b.swipeLeft)) : void 0) }, b.prototype.swipeStart = function(a) { var c, b = this; return b.interrupted = !0, 1 !== b.touchObject.fingerCount || b.slideCount <= b.options.slidesToShow ? (b.touchObject = {}, !1) : (void 0 !== a.originalEvent && void 0 !== a.originalEvent.touches && (c = a.originalEvent.touches[0]), b.touchObject.startX = b.touchObject.curX = void 0 !== c ? c.pageX : a.clientX, b.touchObject.startY = b.touchObject.curY = void 0 !== c ? c.pageY : a.clientY, void(b.dragging = !0)) }, b.prototype.unfilterSlides = b.prototype.slickUnfilter = function() {
        var a = this;
        null !== a.$slidesCache && (a.unload(), a.$slideTrack.children(this.options.slide).detach(), a.$slidesCache.appendTo(a.$slideTrack), a.reinit())
    }, b.prototype.unload = function() {
        var b = this;
        a(".slick-cloned", b.$slider).remove(), b.$dots && b.$dots.remove(), b.$prevArrow && b.htmlExpr.test(b.options.prevArrow) && b.$prevArrow.remove(), b.$nextArrow && b.htmlExpr.test(b.options.nextArrow) && b.$nextArrow.remove(), b.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, b.prototype.unslick = function(a) {
        var b = this;
        b.$slider.trigger("unslick", [b, a]), b.destroy()
    }, b.prototype.updateArrows = function() {
        var b, a = this;
        b = Math.floor(a.options.slidesToShow / 2), a.options.arrows === !0 && a.slideCount > a.options.slidesToShow && !a.options.infinite && (a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === a.currentSlide ? (a.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : a.currentSlide >= a.slideCount - a.options.slidesToShow && a.options.centerMode === !1 ? (a.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : a.currentSlide >= a.slideCount - 1 && a.options.centerMode === !0 && (a.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, b.prototype.updateDots = function() {
        var a = this;
        null !== a.$dots && (a.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), a.$dots.find("li").eq(Math.floor(a.currentSlide / a.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
    }, b.prototype.visibility = function() {
        var a = this;
        a.options.autoplay && (document[a.hidden] ? a.interrupted = !0 : a.interrupted = !1)
    }, a.fn.slick = function() {
        var f, g, a = this,
            c = arguments[0],
            d = Array.prototype.slice.call(arguments, 1),
            e = a.length;
        for (f = 0; e > f; f++)
            if ("object" == typeof c || "undefined" == typeof c ? a[f].slick = new b(a[f], c) : g = a[f].slick[c].apply(a[f].slick, d), "undefined" != typeof g) return g;
        return a
    }
});;
if ("undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery"); + function(a) { "use strict"; var b = a.fn.jquery.split(" ")[0].split("."); if (b[0] < 2 && b[1] < 9 || 1 == b[0] && 9 == b[1] && b[2] < 1) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher") }(jQuery), + function(a) {
    "use strict";

    function b() {
        var a = document.createElement("bootstrap"),
            b = { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd otransitionend", transition: "transitionend" };
        for (var c in b)
            if (void 0 !== a.style[c]) return { end: b[c] };
        return !1
    }
    a.fn.emulateTransitionEnd = function(b) {
        var c = !1,
            d = this;
        a(this).one("bsTransitionEnd", function() { c = !0 });
        var e = function() { c || a(d).trigger(a.support.transition.end) };
        return setTimeout(e, b), this
    }, a(function() { a.support.transition = b(), a.support.transition && (a.event.special.bsTransitionEnd = { bindType: a.support.transition.end, delegateType: a.support.transition.end, handle: function(b) { return a(b.target).is(this) ? b.handleObj.handler.apply(this, arguments) : void 0 } }) })
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var c = a(this),
                e = c.data("bs.alert");
            e || c.data("bs.alert", e = new d(this)), "string" == typeof b && e[b].call(c)
        })
    }
    var c = '[data-dismiss="alert"]',
        d = function(b) { a(b).on("click", c, this.close) };
    d.VERSION = "3.3.4", d.TRANSITION_DURATION = 150, d.prototype.close = function(b) {
        function c() { g.detach().trigger("closed.bs.alert").remove() }
        var e = a(this),
            f = e.attr("data-target");
        f || (f = e.attr("href"), f = f && f.replace(/.*(?=#[^\s]*$)/, ""));
        var g = a(f);
        b && b.preventDefault(), g.length || (g = e.closest(".alert")), g.trigger(b = a.Event("close.bs.alert")), b.isDefaultPrevented() || (g.removeClass("in"), a.support.transition && g.hasClass("fade") ? g.one("bsTransitionEnd", c).emulateTransitionEnd(d.TRANSITION_DURATION) : c())
    };
    var e = a.fn.alert;
    a.fn.alert = b, a.fn.alert.Constructor = d, a.fn.alert.noConflict = function() { return a.fn.alert = e, this }, a(document).on("click.bs.alert.data-api", c, d.prototype.close)
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.button"),
                f = "object" == typeof b && b;
            e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b)
        })
    }
    var c = function(b, d) { this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1 };
    c.VERSION = "3.3.4", c.DEFAULTS = { loadingText: "loading..." }, c.prototype.setState = function(b) {
        var c = "disabled",
            d = this.$element,
            e = d.is("input") ? "val" : "html",
            f = d.data();
        b += "Text", null == f.resetText && d.data("resetText", d[e]()), setTimeout(a.proxy(function() { d[e](null == f[b] ? this.options[b] : f[b]), "loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c)) }, this), 0)
    }, c.prototype.toggle = function() {
        var a = !0,
            b = this.$element.closest('[data-toggle="buttons"]');
        if (b.length) { var c = this.$element.find("input"); "radio" == c.prop("type") && (c.prop("checked") && this.$element.hasClass("active") ? a = !1 : b.find(".active").removeClass("active")), a && c.prop("checked", !this.$element.hasClass("active")).trigger("change") } else this.$element.attr("aria-pressed", !this.$element.hasClass("active"));
        a && this.$element.toggleClass("active")
    };
    var d = a.fn.button;
    a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function() { return a.fn.button = d, this }, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function(c) {
        var d = a(c.target);
        d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), c.preventDefault()
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function(b) { a(b.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(b.type)) })
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.carousel"),
                f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b),
                g = "string" == typeof b ? b : f.slide;
            e || d.data("bs.carousel", e = new c(this, f)), "number" == typeof b ? e.to(b) : g ? e[g]() : f.interval && e.pause().cycle()
        })
    }
    var c = function(b, c) { this.$element = a(b), this.$indicators = this.$element.find(".carousel-indicators"), this.options = c, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", a.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", a.proxy(this.pause, this)).on("mouseleave.bs.carousel", a.proxy(this.cycle, this)) };
    c.VERSION = "3.3.4", c.TRANSITION_DURATION = 600, c.DEFAULTS = { interval: 5e3, pause: "hover", wrap: !0, keyboard: !0 }, c.prototype.keydown = function(a) {
        if (!/input|textarea/i.test(a.target.tagName)) {
            switch (a.which) {
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            a.preventDefault()
        }
    }, c.prototype.cycle = function(b) { return b || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(a.proxy(this.next, this), this.options.interval)), this }, c.prototype.getItemIndex = function(a) { return this.$items = a.parent().children(".item"), this.$items.index(a || this.$active) }, c.prototype.getItemForDirection = function(a, b) {
        var c = this.getItemIndex(b),
            d = "prev" == a && 0 === c || "next" == a && c == this.$items.length - 1;
        if (d && !this.options.wrap) return b;
        var e = "prev" == a ? -1 : 1,
            f = (c + e) % this.$items.length;
        return this.$items.eq(f)
    }, c.prototype.to = function(a) {
        var b = this,
            c = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        return a > this.$items.length - 1 || 0 > a ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function() { b.to(a) }) : c == a ? this.pause().cycle() : this.slide(a > c ? "next" : "prev", this.$items.eq(a))
    }, c.prototype.pause = function(b) { return b || (this.paused = !0), this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this }, c.prototype.next = function() { return this.sliding ? void 0 : this.slide("next") }, c.prototype.prev = function() { return this.sliding ? void 0 : this.slide("prev") }, c.prototype.slide = function(b, d) {
        var e = this.$element.find(".item.active"),
            f = d || this.getItemForDirection(b, e),
            g = this.interval,
            h = "next" == b ? "left" : "right",
            i = this;
        if (f.hasClass("active")) return this.sliding = !1;
        var j = f[0],
            k = a.Event("slide.bs.carousel", { relatedTarget: j, direction: h });
        if (this.$element.trigger(k), !k.isDefaultPrevented()) {
            if (this.sliding = !0, g && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var l = a(this.$indicators.children()[this.getItemIndex(f)]);
                l && l.addClass("active")
            }
            var m = a.Event("slid.bs.carousel", { relatedTarget: j, direction: h });
            return a.support.transition && this.$element.hasClass("slide") ? (f.addClass(b), f[0].offsetWidth, e.addClass(h), f.addClass(h), e.one("bsTransitionEnd", function() { f.removeClass([b, h].join(" ")).addClass("active"), e.removeClass(["active", h].join(" ")), i.sliding = !1, setTimeout(function() { i.$element.trigger(m) }, 0) }).emulateTransitionEnd(c.TRANSITION_DURATION)) : (e.removeClass("active"), f.addClass("active"), this.sliding = !1, this.$element.trigger(m)), g && this.cycle(), this
        }
    };
    var d = a.fn.carousel;
    a.fn.carousel = b, a.fn.carousel.Constructor = c, a.fn.carousel.noConflict = function() { return a.fn.carousel = d, this };
    var e = function(c) {
        var d, e = a(this),
            f = a(e.attr("data-target") || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""));
        if (f.hasClass("carousel")) {
            var g = a.extend({}, f.data(), e.data()),
                h = e.attr("data-slide-to");
            h && (g.interval = !1), b.call(f, g), h && f.data("bs.carousel").to(h), c.preventDefault()
        }
    };
    a(document).on("click.bs.carousel.data-api", "[data-slide]", e).on("click.bs.carousel.data-api", "[data-slide-to]", e), a(window).on("load", function() {
        a('[data-ride="carousel"]').each(function() {
            var c = a(this);
            b.call(c, c.data())
        })
    })
}(jQuery), + function(a) {
    "use strict";

    function b(b) { var c, d = b.attr("data-target") || (c = b.attr("href")) && c.replace(/.*(?=#[^\s]+$)/, ""); return a(d) }

    function c(b) {
        return this.each(function() {
            var c = a(this),
                e = c.data("bs.collapse"),
                f = a.extend({}, d.DEFAULTS, c.data(), "object" == typeof b && b);
            !e && f.toggle && /show|hide/.test(b) && (f.toggle = !1), e || c.data("bs.collapse", e = new d(this, f)), "string" == typeof b && e[b]()
        })
    }
    var d = function(b, c) { this.$element = a(b), this.options = a.extend({}, d.DEFAULTS, c), this.$trigger = a('[data-toggle="collapse"][href="#' + b.id + '"],[data-toggle="collapse"][data-target="#' + b.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle() };
    d.VERSION = "3.3.4", d.TRANSITION_DURATION = 350, d.DEFAULTS = { toggle: !0 }, d.prototype.dimension = function() { var a = this.$element.hasClass("width"); return a ? "width" : "height" }, d.prototype.show = function() {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var b, e = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
            if (!(e && e.length && (b = e.data("bs.collapse"), b && b.transitioning))) {
                var f = a.Event("show.bs.collapse");
                if (this.$element.trigger(f), !f.isDefaultPrevented()) {
                    e && e.length && (c.call(e, "hide"), b || e.data("bs.collapse", null));
                    var g = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var h = function() { this.$element.removeClass("collapsing").addClass("collapse in")[g](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse") };
                    if (!a.support.transition) return h.call(this);
                    var i = a.camelCase(["scroll", g].join("-"));
                    this.$element.one("bsTransitionEnd", a.proxy(h, this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])
                }
            }
        }
    }, d.prototype.hide = function() {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var b = a.Event("hide.bs.collapse");
            if (this.$element.trigger(b), !b.isDefaultPrevented()) {
                var c = this.dimension();
                this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var e = function() { this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse") };
                return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(e, this)).emulateTransitionEnd(d.TRANSITION_DURATION) : e.call(this)
            }
        }
    }, d.prototype.toggle = function() { this[this.$element.hasClass("in") ? "hide" : "show"]() }, d.prototype.getParent = function() {
        return a(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(a.proxy(function(c, d) {
            var e = a(d);
            this.addAriaAndCollapsedClass(b(e), e)
        }, this)).end()
    }, d.prototype.addAriaAndCollapsedClass = function(a, b) {
        var c = a.hasClass("in");
        a.attr("aria-expanded", c), b.toggleClass("collapsed", !c).attr("aria-expanded", c)
    };
    var e = a.fn.collapse;
    a.fn.collapse = c, a.fn.collapse.Constructor = d, a.fn.collapse.noConflict = function() { return a.fn.collapse = e, this }, a(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function(d) {
        var e = a(this);
        e.attr("data-target") || d.preventDefault();
        var f = b(e),
            g = f.data("bs.collapse"),
            h = g ? "toggle" : e.data();
        c.call(f, h)
    })
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        b && 3 === b.which || (a(e).remove(), a(f).each(function() {
            var d = a(this),
                e = c(d),
                f = { relatedTarget: this };
            e.hasClass("open") && (e.trigger(b = a.Event("hide.bs.dropdown", f)), b.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger("hidden.bs.dropdown", f)))
        }))
    }

    function c(b) {
        var c = b.attr("data-target");
        c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));
        var d = c && a(c);
        return d && d.length ? d : b.parent()
    }

    function d(b) {
        return this.each(function() {
            var c = a(this),
                d = c.data("bs.dropdown");
            d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c)
        })
    }
    var e = ".dropdown-backdrop",
        f = '[data-toggle="dropdown"]',
        g = function(b) { a(b).on("click.bs.dropdown", this.toggle) };
    g.VERSION = "3.3.4", g.prototype.toggle = function(d) {
        var e = a(this);
        if (!e.is(".disabled, :disabled")) {
            var f = c(e),
                g = f.hasClass("open");
            if (b(), !g) {
                "ontouchstart" in document.documentElement && !f.closest(".navbar-nav").length && a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click", b);
                var h = { relatedTarget: this };
                if (f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented()) return;
                e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger("shown.bs.dropdown", h)
            }
            return !1
        }
    }, g.prototype.keydown = function(b) {
        if (/(38|40|27|32)/.test(b.which) && !/input|textarea/i.test(b.target.tagName)) {
            var d = a(this);
            if (b.preventDefault(), b.stopPropagation(), !d.is(".disabled, :disabled")) {
                var e = c(d),
                    g = e.hasClass("open");
                if (!g && 27 != b.which || g && 27 == b.which) return 27 == b.which && e.find(f).trigger("focus"), d.trigger("click");
                var h = " li:not(.disabled):visible a",
                    i = e.find('[role="menu"]' + h + ', [role="listbox"]' + h);
                if (i.length) {
                    var j = i.index(b.target);
                    38 == b.which && j > 0 && j--, 40 == b.which && j < i.length - 1 && j++, ~j || (j = 0), i.eq(j).trigger("focus")
                }
            }
        }
    };
    var h = a.fn.dropdown;
    a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function() { return a.fn.dropdown = h, this }, a(document).on("click.bs.dropdown.data-api", b).on("click.bs.dropdown.data-api", ".dropdown form", function(a) { a.stopPropagation() }).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f, g.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="menu"]', g.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="listbox"]', g.prototype.keydown)
}(jQuery), + function(a) {
    "use strict";

    function b(b, d) {
        return this.each(function() {
            var e = a(this),
                f = e.data("bs.modal"),
                g = a.extend({}, c.DEFAULTS, e.data(), "object" == typeof b && b);
            f || e.data("bs.modal", f = new c(this, g)), "string" == typeof b ? f[b](d) : g.show && f.show(d)
        })
    }
    var c = function(b, c) { this.options = c, this.$body = a(document.body), this.$element = a(b), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function() { this.$element.trigger("loaded.bs.modal") }, this)) };
    c.VERSION = "3.3.4", c.TRANSITION_DURATION = 300, c.BACKDROP_TRANSITION_DURATION = 150, c.DEFAULTS = { backdrop: !0, keyboard: !0, show: !0 }, c.prototype.toggle = function(a) { return this.isShown ? this.hide() : this.show(a) }, c.prototype.show = function(b) {
        var d = this,
            e = a.Event("show.bs.modal", { relatedTarget: b });
        this.$element.trigger(e), this.isShown || e.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', a.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function() { d.$element.one("mouseup.dismiss.bs.modal", function(b) { a(b.target).is(d.$element) && (d.ignoreBackdropClick = !0) }) }), this.backdrop(function() {
            var e = a.support.transition && d.$element.hasClass("fade");
            d.$element.parent().length || d.$element.appendTo(d.$body), d.$element.show().scrollTop(0), d.adjustDialog(), e && d.$element[0].offsetWidth, d.$element.addClass("in").attr("aria-hidden", !1), d.enforceFocus();
            var f = a.Event("shown.bs.modal", { relatedTarget: b });
            e ? d.$dialog.one("bsTransitionEnd", function() { d.$element.trigger("focus").trigger(f) }).emulateTransitionEnd(c.TRANSITION_DURATION) : d.$element.trigger("focus").trigger(f)
        }))
    }, c.prototype.hide = function(b) { b && b.preventDefault(), b = a.Event("hide.bs.modal"), this.$element.trigger(b), this.isShown && !b.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), a(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", a.proxy(this.hideModal, this)).emulateTransitionEnd(c.TRANSITION_DURATION) : this.hideModal()) }, c.prototype.enforceFocus = function() { a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function(a) { this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.trigger("focus") }, this)) }, c.prototype.escape = function() { this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", a.proxy(function(a) { 27 == a.which && this.hide() }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal") }, c.prototype.resize = function() { this.isShown ? a(window).on("resize.bs.modal", a.proxy(this.handleUpdate, this)) : a(window).off("resize.bs.modal") }, c.prototype.hideModal = function() {
        var a = this;
        this.$element.hide(), this.backdrop(function() { a.$body.removeClass("modal-open"), a.resetAdjustments(), a.resetScrollbar(), a.$element.trigger("hidden.bs.modal") })
    }, c.prototype.removeBackdrop = function() { this.$backdrop && this.$backdrop.remove(), this.$backdrop = null }, c.prototype.backdrop = function(b) {
        var d = this,
            e = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var f = a.support.transition && e;
            if (this.$backdrop = a('<div class="modal-backdrop ' + e + '" />').appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", a.proxy(function(a) { return this.ignoreBackdropClick ? void(this.ignoreBackdropClick = !1) : void(a.target === a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide())) }, this)), f && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !b) return;
            f ? this.$backdrop.one("bsTransitionEnd", b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : b()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var g = function() { d.removeBackdrop(), b && b() };
            a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : g()
        } else b && b()
    }, c.prototype.handleUpdate = function() { this.adjustDialog() }, c.prototype.adjustDialog = function() {
        var a = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({ paddingLeft: !this.bodyIsOverflowing && a ? this.scrollbarWidth : "", paddingRight: this.bodyIsOverflowing && !a ? this.scrollbarWidth : "" })
    }, c.prototype.resetAdjustments = function() { this.$element.css({ paddingLeft: "", paddingRight: "" }) }, c.prototype.checkScrollbar = function() {
        var a = window.innerWidth;
        if (!a) {
            var b = document.documentElement.getBoundingClientRect();
            a = b.right - Math.abs(b.left)
        }
        this.bodyIsOverflowing = document.body.clientWidth < a, this.scrollbarWidth = this.measureScrollbar()
    }, c.prototype.setScrollbar = function() {
        var a = parseInt(this.$body.css("padding-right") || 0, 10);
        this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", a + this.scrollbarWidth)
    }, c.prototype.resetScrollbar = function() { this.$body.css("padding-right", this.originalBodyPad) }, c.prototype.measureScrollbar = function() {
        var a = document.createElement("div");
        a.className = "modal-scrollbar-measure", this.$body.append(a);
        var b = a.offsetWidth - a.clientWidth;
        return this.$body[0].removeChild(a), b
    };
    var d = a.fn.modal;
    a.fn.modal = b, a.fn.modal.Constructor = c, a.fn.modal.noConflict = function() { return a.fn.modal = d, this }, a(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function(c) {
        var d = a(this),
            e = d.attr("href"),
            f = a(d.attr("data-target") || e && e.replace(/.*(?=#[^\s]+$)/, "")),
            g = f.data("bs.modal") ? "toggle" : a.extend({ remote: !/#/.test(e) && e }, f.data(), d.data());
        d.is("a") && c.preventDefault(), f.one("show.bs.modal", function(a) { a.isDefaultPrevented() || f.one("hidden.bs.modal", function() { d.is(":visible") && d.trigger("focus") }) }), b.call(f, g, this)
    })
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.tooltip"),
                f = "object" == typeof b && b;
            (e || !/destroy|hide/.test(b)) && (e || d.data("bs.tooltip", e = new c(this, f)), "string" == typeof b && e[b]())
        })
    }
    var c = function(a, b) { this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.init("tooltip", a, b) };
    c.VERSION = "3.3.4", c.TRANSITION_DURATION = 150, c.DEFAULTS = { animation: !0, placement: "top", selector: !1, template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', trigger: "hover focus", title: "", delay: 0, html: !1, container: !1, viewport: { selector: "body", padding: 0 } }, c.prototype.init = function(b, c, d) {
        if (this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), this.$viewport = this.options.viewport && a(this.options.viewport.selector || this.options.viewport), this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
        for (var e = this.options.trigger.split(" "), f = e.length; f--;) {
            var g = e[f];
            if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));
            else if ("manual" != g) {
                var h = "hover" == g ? "mouseenter" : "focusin",
                    i = "hover" == g ? "mouseleave" : "focusout";
                this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = a.extend({}, this.options, { trigger: "manual", selector: "" }) : this.fixTitle()
    }, c.prototype.getDefaults = function() { return c.DEFAULTS }, c.prototype.getOptions = function(b) { return b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = { show: b.delay, hide: b.delay }), b }, c.prototype.getDelegateOptions = function() {
        var b = {},
            c = this.getDefaults();
        return this._options && a.each(this._options, function(a, d) { c[a] != d && (b[a] = d) }), b
    }, c.prototype.enter = function(b) { var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type); return c && c.$tip && c.$tip.is(":visible") ? void(c.hoverState = "in") : (c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "in", c.options.delay && c.options.delay.show ? void(c.timeout = setTimeout(function() { "in" == c.hoverState && c.show() }, c.options.delay.show)) : c.show()) }, c.prototype.leave = function(b) { var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type); return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void(c.timeout = setTimeout(function() { "out" == c.hoverState && c.hide() }, c.options.delay.hide)) : c.hide() }, c.prototype.show = function() {
        var b = a.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(b);
            var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (b.isDefaultPrevented() || !d) return;
            var e = this,
                f = this.tip(),
                g = this.getUID(this.type);
            this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");
            var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement,
                i = /\s?auto?\s?/i,
                j = i.test(h);
            j && (h = h.replace(i, "") || "top"), f.detach().css({ top: 0, left: 0, display: "block" }).addClass(h).data("bs." + this.type, this), this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element);
            var k = this.getPosition(),
                l = f[0].offsetWidth,
                m = f[0].offsetHeight;
            if (j) {
                var n = h,
                    o = this.options.container ? a(this.options.container) : this.$element.parent(),
                    p = this.getPosition(o);
                h = "bottom" == h && k.bottom + m > p.bottom ? "top" : "top" == h && k.top - m < p.top ? "bottom" : "right" == h && k.right + l > p.width ? "left" : "left" == h && k.left - l < p.left ? "right" : h, f.removeClass(n).addClass(h)
            }
            var q = this.getCalculatedOffset(h, k, l, m);
            this.applyPlacement(q, h);
            var r = function() {
                var a = e.hoverState;
                e.$element.trigger("shown.bs." + e.type), e.hoverState = null, "out" == a && e.leave(e)
            };
            a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", r).emulateTransitionEnd(c.TRANSITION_DURATION) : r()
        }
    }, c.prototype.applyPlacement = function(b, c) {
        var d = this.tip(),
            e = d[0].offsetWidth,
            f = d[0].offsetHeight,
            g = parseInt(d.css("margin-top"), 10),
            h = parseInt(d.css("margin-left"), 10);
        isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top = b.top + g, b.left = b.left + h, a.offset.setOffset(d[0], a.extend({ using: function(a) { d.css({ top: Math.round(a.top), left: Math.round(a.left) }) } }, b), 0), d.addClass("in");
        var i = d[0].offsetWidth,
            j = d[0].offsetHeight;
        "top" == c && j != f && (b.top = b.top + f - j);
        var k = this.getViewportAdjustedDelta(c, b, i, j);
        k.left ? b.left += k.left : b.top += k.top;
        var l = /top|bottom/.test(c),
            m = l ? 2 * k.left - e + i : 2 * k.top - f + j,
            n = l ? "offsetWidth" : "offsetHeight";
        d.offset(b), this.replaceArrow(m, d[0][n], l)
    }, c.prototype.replaceArrow = function(a, b, c) { this.arrow().css(c ? "left" : "top", 50 * (1 - a / b) + "%").css(c ? "top" : "left", "") }, c.prototype.setContent = function() {
        var a = this.tip(),
            b = this.getTitle();
        a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right")
    }, c.prototype.hide = function(b) {
        function d() { "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), b && b() }
        var e = this,
            f = a(this.$tip),
            g = a.Event("hide.bs." + this.type);
        return this.$element.trigger(g), g.isDefaultPrevented() ? void 0 : (f.removeClass("in"), a.support.transition && f.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), this.hoverState = null, this)
    }, c.prototype.fixTitle = function() {
        var a = this.$element;
        (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "")
    }, c.prototype.hasContent = function() { return this.getTitle() }, c.prototype.getPosition = function(b) {
        b = b || this.$element;
        var c = b[0],
            d = "BODY" == c.tagName,
            e = c.getBoundingClientRect();
        null == e.width && (e = a.extend({}, e, { width: e.right - e.left, height: e.bottom - e.top }));
        var f = d ? { top: 0, left: 0 } : b.offset(),
            g = { scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop() },
            h = d ? { width: a(window).width(), height: a(window).height() } : null;
        return a.extend({}, e, g, h, f)
    }, c.prototype.getCalculatedOffset = function(a, b, c, d) { return "bottom" == a ? { top: b.top + b.height, left: b.left + b.width / 2 - c / 2 } : "top" == a ? { top: b.top - d, left: b.left + b.width / 2 - c / 2 } : "left" == a ? { top: b.top + b.height / 2 - d / 2, left: b.left - c } : { top: b.top + b.height / 2 - d / 2, left: b.left + b.width } }, c.prototype.getViewportAdjustedDelta = function(a, b, c, d) {
        var e = { top: 0, left: 0 };
        if (!this.$viewport) return e;
        var f = this.options.viewport && this.options.viewport.padding || 0,
            g = this.getPosition(this.$viewport);
        if (/right|left/.test(a)) {
            var h = b.top - f - g.scroll,
                i = b.top + f - g.scroll + d;
            h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i)
        } else {
            var j = b.left - f,
                k = b.left + f + c;
            j < g.left ? e.left = g.left - j : k > g.width && (e.left = g.left + g.width - k)
        }
        return e
    }, c.prototype.getTitle = function() {
        var a, b = this.$element,
            c = this.options;
        return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title)
    }, c.prototype.getUID = function(a) { do a += ~~(1e6 * Math.random()); while (document.getElementById(a)); return a }, c.prototype.tip = function() { return this.$tip = this.$tip || a(this.options.template) }, c.prototype.arrow = function() { return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow") }, c.prototype.enable = function() { this.enabled = !0 }, c.prototype.disable = function() { this.enabled = !1 }, c.prototype.toggleEnabled = function() { this.enabled = !this.enabled }, c.prototype.toggle = function(b) {
        var c = this;
        b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c))), c.tip().hasClass("in") ? c.leave(c) : c.enter(c)
    }, c.prototype.destroy = function() {
        var a = this;
        clearTimeout(this.timeout), this.hide(function() { a.$element.off("." + a.type).removeData("bs." + a.type) })
    };
    var d = a.fn.tooltip;
    a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function() { return a.fn.tooltip = d, this }
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.popover"),
                f = "object" == typeof b && b;
            (e || !/destroy|hide/.test(b)) && (e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]())
        })
    }
    var c = function(a, b) { this.init("popover", a, b) };
    if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");
    c.VERSION = "3.3.4", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, { placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>' }), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function() { return c.DEFAULTS }, c.prototype.setContent = function() {
        var a = this.tip(),
            b = this.getTitle(),
            c = this.getContent();
        a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide()
    }, c.prototype.hasContent = function() { return this.getTitle() || this.getContent() }, c.prototype.getContent = function() {
        var a = this.$element,
            b = this.options;
        return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content)
    }, c.prototype.arrow = function() { return this.$arrow = this.$arrow || this.tip().find(".arrow") };
    var d = a.fn.popover;
    a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function() { return a.fn.popover = d, this }
}(jQuery), + function(a) {
    "use strict";

    function b(c, d) { this.$body = a(document.body), this.$scrollElement = a(a(c).is(document.body) ? window : c), this.options = a.extend({}, b.DEFAULTS, d), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", a.proxy(this.process, this)), this.refresh(), this.process() }

    function c(c) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.scrollspy"),
                f = "object" == typeof c && c;
            e || d.data("bs.scrollspy", e = new b(this, f)), "string" == typeof c && e[c]()
        })
    }
    b.VERSION = "3.3.4", b.DEFAULTS = { offset: 10 }, b.prototype.getScrollHeight = function() { return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight) }, b.prototype.refresh = function() {
        var b = this,
            c = "offset",
            d = 0;
        this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), a.isWindow(this.$scrollElement[0]) || (c = "position", d = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function() {
            var b = a(this),
                e = b.data("target") || b.attr("href"),
                f = /^#./.test(e) && a(e);
            return f && f.length && f.is(":visible") && [
                [f[c]().top + d, e]
            ] || null
        }).sort(function(a, b) { return a[0] - b[0] }).each(function() { b.offsets.push(this[0]), b.targets.push(this[1]) })
    }, b.prototype.process = function() {
        var a, b = this.$scrollElement.scrollTop() + this.options.offset,
            c = this.getScrollHeight(),
            d = this.options.offset + c - this.$scrollElement.height(),
            e = this.offsets,
            f = this.targets,
            g = this.activeTarget;
        if (this.scrollHeight != c && this.refresh(), b >= d) return g != (a = f[f.length - 1]) && this.activate(a);
        if (g && b < e[0]) return this.activeTarget = null, this.clear();
        for (a = e.length; a--;) g != f[a] && b >= e[a] && (void 0 === e[a + 1] || b < e[a + 1]) && this.activate(f[a])
    }, b.prototype.activate = function(b) {
        this.activeTarget = b, this.clear();
        var c = this.selector + '[data-target="' + b + '"],' + this.selector + '[href="' + b + '"]',
            d = a(c).parents("li").addClass("active");
        d.parent(".dropdown-menu").length && (d = d.closest("li.dropdown").addClass("active")), d.trigger("activate.bs.scrollspy")
    }, b.prototype.clear = function() { a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active") };
    var d = a.fn.scrollspy;
    a.fn.scrollspy = c, a.fn.scrollspy.Constructor = b, a.fn.scrollspy.noConflict = function() { return a.fn.scrollspy = d, this }, a(window).on("load.bs.scrollspy.data-api", function() {
        a('[data-spy="scroll"]').each(function() {
            var b = a(this);
            c.call(b, b.data())
        })
    })
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.tab");
            e || d.data("bs.tab", e = new c(this)), "string" == typeof b && e[b]()
        })
    }
    var c = function(b) { this.element = a(b) };
    c.VERSION = "3.3.4", c.TRANSITION_DURATION = 150, c.prototype.show = function() {
        var b = this.element,
            c = b.closest("ul:not(.dropdown-menu)"),
            d = b.data("target");
        if (d || (d = b.attr("href"), d = d && d.replace(/.*(?=#[^\s]*$)/, "")), !b.parent("li").hasClass("active")) {
            var e = c.find(".active:last a"),
                f = a.Event("hide.bs.tab", { relatedTarget: b[0] }),
                g = a.Event("show.bs.tab", { relatedTarget: e[0] });
            if (e.trigger(f), b.trigger(g), !g.isDefaultPrevented() && !f.isDefaultPrevented()) {
                var h = a(d);
                this.activate(b.closest("li"), c), this.activate(h, h.parent(), function() { e.trigger({ type: "hidden.bs.tab", relatedTarget: b[0] }), b.trigger({ type: "shown.bs.tab", relatedTarget: e[0] }) })
            }
        }
    }, c.prototype.activate = function(b, d, e) {
        function f() { g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), h ? (b[0].offsetWidth, b.addClass("in")) : b.removeClass("fade"), b.parent(".dropdown-menu").length && b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), e && e() }
        var g = d.find("> .active"),
            h = e && a.support.transition && (g.length && g.hasClass("fade") || !!d.find("> .fade").length);
        g.length && h ? g.one("bsTransitionEnd", f).emulateTransitionEnd(c.TRANSITION_DURATION) : f(), g.removeClass("in")
    };
    var d = a.fn.tab;
    a.fn.tab = b, a.fn.tab.Constructor = c, a.fn.tab.noConflict = function() { return a.fn.tab = d, this };
    var e = function(c) { c.preventDefault(), b.call(a(this), "show") };
    a(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', e).on("click.bs.tab.data-api", '[data-toggle="pill"]', e)
}(jQuery), + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.affix"),
                f = "object" == typeof b && b;
            e || d.data("bs.affix", e = new c(this, f)), "string" == typeof b && e[b]()
        })
    }
    var c = function(b, d) { this.options = a.extend({}, c.DEFAULTS, d), this.$target = a(this.options.target).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this)), this.$element = a(b), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition() };
    c.VERSION = "3.3.4", c.RESET = "affix affix-top affix-bottom", c.DEFAULTS = { offset: 0, target: window }, c.prototype.getState = function(a, b, c, d) {
        var e = this.$target.scrollTop(),
            f = this.$element.offset(),
            g = this.$target.height();
        if (null != c && "top" == this.affixed) return c > e ? "top" : !1;
        if ("bottom" == this.affixed) return null != c ? e + this.unpin <= f.top ? !1 : "bottom" : a - d >= e + g ? !1 : "bottom";
        var h = null == this.affixed,
            i = h ? e : f.top,
            j = h ? g : b;
        return null != c && c >= e ? "top" : null != d && i + j >= a - d ? "bottom" : !1
    }, c.prototype.getPinnedOffset = function() {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(c.RESET).addClass("affix");
        var a = this.$target.scrollTop(),
            b = this.$element.offset();
        return this.pinnedOffset = b.top - a
    }, c.prototype.checkPositionWithEventLoop = function() { setTimeout(a.proxy(this.checkPosition, this), 1) }, c.prototype.checkPosition = function() {
        if (this.$element.is(":visible")) {
            var b = this.$element.height(),
                d = this.options.offset,
                e = d.top,
                f = d.bottom,
                g = a(document.body).height();
            "object" != typeof d && (f = e = d), "function" == typeof e && (e = d.top(this.$element)), "function" == typeof f && (f = d.bottom(this.$element));
            var h = this.getState(g, b, e, f);
            if (this.affixed != h) {
                null != this.unpin && this.$element.css("top", "");
                var i = "affix" + (h ? "-" + h : ""),
                    j = a.Event(i + ".bs.affix");
                if (this.$element.trigger(j), j.isDefaultPrevented()) return;
                this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix", "affixed") + ".bs.affix")
            }
            "bottom" == h && this.$element.offset({ top: g - b - f })
        }
    };
    var d = a.fn.affix;
    a.fn.affix = b, a.fn.affix.Constructor = c, a.fn.affix.noConflict = function() { return a.fn.affix = d, this }, a(window).on("load", function() {
        a('[data-spy="affix"]').each(function() {
            var c = a(this),
                d = c.data();
            d.offset = d.offset || {}, null != d.offsetBottom && (d.offset.bottom = d.offsetBottom), null != d.offsetTop && (d.offset.top = d.offsetTop), b.call(c, d)
        })
    })
}(jQuery);;
(function($) {
    var supportsOrientationChange = "onorientationchange" in window,
        orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
    if (!window.location.origin) { window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : ''); }

    function isLocalStorageNameSupported() {
        var testKey = 'test',
            storage = window.sessionStorage;
        try {
            storage.setItem(testKey, '1');
            storage.removeItem(testKey);
            return true;
        } catch (error) { return false; }
    }
    String.prototype.capitalize = function() { return this.charAt(0).toUpperCase() + this.slice(1); }
    if ($('html').hasClass('iphone')) { var iphone4 = (window.screen.height == (960 / 2)); var iphone5 = (window.screen.height == (1136 / 2)); if (iphone4) { $('html').addClass('iphone4'); } if (iphone5) { $('html').addClass('iphone5'); } }

    function iOSversion() { if (/iP(hone|od|ad)/.test(navigator.platform)) { var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/); return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)]; } }
    var isAndroid = /Android/i.test(navigator.userAgent) || ($('html').is('.touch') && !$('html').is('.ios'));
    if (isAndroid) { $('html').addClass('android'); }
})(jQuery);;
(function() {
    var b, f;
    b = this.jQuery || window.jQuery;
    f = b(window);
    b.fn.stick_in_parent = function(d) {
        var A, w, J, n, B, K, p, q, k, E, t;
        null == d && (d = {});
        t = d.sticky_class;
        B = d.inner_scrolling;
        E = d.recalc_every;
        k = d.parent;
        q = d.offset_top;
        p = d.spacer;
        w = d.bottoming;
        null == q && (q = 0);
        null == k && (k = void 0);
        null == B && (B = !0);
        null == t && (t = "is_stuck");
        A = b(document);
        null == w && (w = !0);
        J = function(a, d, n, C, F, u, r, G) {
            var v, H, m, D, I, c, g, x, y, z, h, l;
            if (!a.data("sticky_kit")) {
                a.data("sticky_kit", !0);
                I = A.height();
                g = a.parent();
                null != k && (g = g.closest(k));
                if (!g.length) throw "failed to find stick parent";
                v = m = !1;
                (h = null != p ? p && a.closest(p) : b("<div />")) && h.css("position", a.css("position"));
                x = function() { var c, f, e; if (!G && (I = A.height(), c = parseInt(g.css("border-top-width"), 10), f = parseInt(g.css("padding-top"), 10), d = parseInt(g.css("padding-bottom"), 10), n = g.offset().top + c + f, C = g.height(), m && (v = m = !1, null == p && (a.insertAfter(h), h.detach()), a.css({ position: "", top: "", width: "", bottom: "" }).removeClass(t), e = !0), F = a.offset().top - (parseInt(a.css("margin-top"), 10) || 0) - q, u = a.outerHeight(!0), r = a.css("float"), h && h.css({ width: a.outerWidth(!0), height: u, display: a.css("display"), "vertical-align": a.css("vertical-align"), "float": r }), e)) return l() };
                x();
                if (u !== C) return D = void 0, c = q, z = E, l = function() { var b, l, e, k; if (!G && (e = !1, null != z && (--z, 0 >= z && (z = E, x(), e = !0)), e || A.height() === I || x(), e = f.scrollTop(), null != D && (l = e - D), D = e, m ? (w && (k = e + u + c > C + n, v && !k && (v = !1, a.css({ position: "fixed", bottom: "", top: c }).trigger("sticky_kit:unbottom"))), e < F && (m = !1, c = q, null == p && ("left" !== r && "right" !== r || a.insertAfter(h), h.detach()), b = { position: "", width: "", top: "" }, a.css(b).removeClass(t).trigger("sticky_kit:unstick")), B && (b = f.height(), u + q > b && !v && (c -= l, c = Math.max(b - u, c), c = Math.min(q, c), m && a.css({ top: c + "px" })))) : e > F && (m = !0, b = { position: "fixed", top: c }, b.width = "border-box" === a.css("box-sizing") ? a.outerWidth() + "px" : a.width() + "px", a.css(b).addClass(t), null == p && (a.after(h), "left" !== r && "right" !== r || h.append(a)), a.trigger("sticky_kit:stick")), m && w && (null == k && (k = e + u + c > C + n), !v && k))) return v = !0, "static" === g.css("position") && g.css({ position: "relative" }), a.css({ position: "absolute", bottom: d, top: "auto" }).trigger("sticky_kit:bottom") }, y = function() { x(); return l() }, H = function() {
                    G = !0;
                    f.off("touchmove", l);
                    f.off("scroll", l);
                    f.off("resize", y);
                    b(document.body).off("sticky_kit:recalc", y);
                    a.off("sticky_kit:detach", H);
                    a.removeData("sticky_kit");
                    a.css({ position: "", bottom: "", top: "", width: "" });
                    g.position("position", "");
                    if (m) return null == p && ("left" !== r && "right" !== r || a.insertAfter(h), h.remove()), a.removeClass(t)
                }, f.on("touchmove", l), f.on("scroll", l), f.on("resize", y), b(document.body).on("sticky_kit:recalc", y), a.on("sticky_kit:detach", H), setTimeout(l, 0)
            }
        };
        n = 0;
        for (K = this.length; n < K; n++) d = this[n], J(b(d));
        return this
    }
}).call(this);;
(function($) {
    if (!window.location.origin) { window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : ''); }

    function isLocalStorageNameSupported() {
        var testKey = 'test',
            storage = window.sessionStorage;
        try {
            storage.setItem(testKey, '1');
            storage.removeItem(testKey);
            return true;
        } catch (error) { return false; }
    }
    String.prototype.capitalize = function() { return this.charAt(0).toUpperCase() + this.slice(1); }
    if ($('html').hasClass('iphone')) { var iphone4 = (window.screen.height == (960 / 2)); var iphone5 = (window.screen.height == (1136 / 2)); if (iphone4) { $('html').addClass('iphone4'); } if (iphone5) { $('html').addClass('iphone5'); } }

    function iOSversion() { if (/iP(hone|od|ad)/.test(navigator.platform)) { var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/); return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)]; } }
    var isAndroid = /Android/i.test(navigator.userAgent) || ($('html').is('.touch') && !$('html').is('.ios'));
    if (isAndroid) { $('html').addClass('android'); }
    var isDesktop = $('html').hasClass('desktop');

    function frontpage_sticky() {
        var $nav_hero;
        if ($('.wrapper-main-content .container-fluid > div:first-child .hero-product-container').length > 0) { $nav_hero = $('.wrapper-main-content .container-fluid > div:first-child .hero-product-container'); } else if ($('.wrapper-main-content .container-fluid > div:first-child .top-img-md').length > 0) { $nav_hero = $('.wrapper-main-content .container-fluid > div:first-child .top-img-md'); } else { $nav_hero = $('.wrapper-main-content .container-fluid > div:first-child.slide-to-top') }
        var hero_height = $nav_hero.outerHeight();
        var scroll_top = $(window).scrollTop();
        if (scroll_top >= hero_height) {
            $('.top').addClass('resized');
            $('html').addClass('resized');
        } else {
            $('.top').removeClass('resized');
            $('html').removeClass('resized open-extra-menu');
        }
    }
    $(window).on('scroll.open-extra-menu', function() {
        var y = $(this).scrollTop();
        if ($('body').hasClass('front-page') || $('body').hasClass('kitchen-page')) { frontpage_sticky(); } else if (!$('body').hasClass('story-page')) {
            if (y >= 20) {
                $('.top').addClass('resized');
                $('html').addClass('resized').removeClass('open-extra-menu');
            } else {
                $('.top').removeClass('resized');
                $('html').removeClass('resized open-extra-menu');
            }
        }
    })

    function adminNavHasTwoLines() { var $navbar_administration = $('body.navbar-administration').length ? $('body.navbar-administration') : null; if ($navbar_administration) { var padding_top = parseInt($navbar_administration.css('padding-top')); return (parseInt(padding_top) > 79); } }

    function processMenu() {
        $('.btn-menu-burger').click(function(e) {
            e.preventDefault();
            if ($(window).width() > 1023) {
                $('.top-wrapper').addClass('expanded');
                $(this).addClass('un-active');
                $('html').addClass('open-extra-menu');
            } else {
                if ($('body').hasClass('category-list-page') || $('body').hasClass('product-list-page')) {
                    $('.tray-menu ul').removeClass('menu-current menu-in' + ' menu-out');
                    $('.tray-menu .submenu-1').addClass('menu-current menu-in');
                } else if ($('body').hasClass('page-stories')) {
                    $('.tray-menu ul').removeClass('menu-current menu-in' + ' menu-out');
                    $('.tray-menu .submenu-2').addClass('menu-current menu-in');
                }
                $('body').toggleClass('open-tray-menu');
            }
        })
        $('body').on('click touchstart', '.tray-menu--mask', function() { $('body').removeClass('open-tray-menu'); });
        $('.btn-icon-close').click(function(e) {
            e.preventDefault();
            $('html').removeClass('open-extra-menu');
            $('.top-wrapper').removeClass('expanded');
            $('.btn-menu-burger').removeClass('un-active')
        })
        $(window).on('load resize.heightOfAdminNav', function() { if (adminNavHasTwoLines()) { $('body').addClass('admin-2-lines'); } else { $('body').removeClass('admin-2-lines'); } })
    }

    function processMenuColour() {
        if ($('body').hasClass('front-page') || $('body').hasClass('kitchen-page')) {
            var _color_top_md = 'white';
            if ($('.wrapper-main-content > .container-fluid > div:first-child > div > .top-img-md').length > 0) {
                _color_top_md = $('.wrapper-main-content > .container-fluid > div:first-child > div > .top-img-md').find('.top-img-md--content').hasClass('dark_grey') ? 'dark-grey' : 'white';
                $('body').addClass('menu-' + _color_top_md);
            }
            if ($('.wrapper-main-content > .container-fluid > div:first-child > div > .hero-product-container').length > 0) {
                _color_top_md = $('.wrapper-main-content > .container-fluid > div:first-child > div > .hero-product-container').find('.hero-product-description').hasClass('dark_grey') ? 'dark-grey' : 'white';
                $('body').addClass('menu-' + _color_top_md);
            }
            if ($('.wrapper-main-content > .container-fluid > div:first-child > div > .hero-story-container').length > 0) {
                _color_top_md = $('.wrapper-main-content > .container-fluid > div:first-child > div > .hero-story-container').find('.hero-story-description').hasClass('dark_grey') ? 'dark-grey' : 'white';
                $('body').addClass('menu-' + _color_top_md);
            }
        }
    }

    function openSecondMenu() {
        if ($(window).width() >= 1024 && !$('body').hasClass('front')) {
            var $second_menu = $('.top.extra .right');
            if ($second_menu.find('.active').length) {
                $('body').addClass('on-page-second-menu');
                $('.top-wrapper').addClass('expanded');
                $('html').addClass('open-extra-menu')
            }
        }
    }
    jQuery(function($) { processMenu(); })
    var didScroll;

    function hasScrolled() {
        $('.top-wrapper').removeClass('expanded');
        $('.hamburger-btn').removeClass('btn-none')
    }
    $(window).scroll(function(event) { didScroll = true; });
    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
    $(document).ready(function() {
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        var nVer = navigator.appVersion;
        var nAgt = navigator.userAgent;
        var browserName = navigator.appName;
        var fullVersion = '' + parseFloat(navigator.appVersion);
        var majorVersion = parseInt(navigator.appVersion, 10);
        var nameOffset, verOffset, ix;
        if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
            browserName = "Firefox";
            fullVersion = nAgt.substring(verOffset + 8);
            $('html').addClass('firefox');
        } else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
            browserName = "Safari";
            fullVersion = nAgt.substring(verOffset + 7);
            if ((verOffset = nAgt.indexOf("Version")) != -1) fullVersion = nAgt.substring(verOffset + 8);
            if (parseInt(fullVersion) <= 8) { $('html').addClass('safari-8'); }
        } else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
            browserName = "Microsoft Internet Explorer";
            fullVersion = nAgt.substring(verOffset + 5);
            if (parseInt(fullVersion) <= 10) { $('html').addClass('ie-10'); }
        } else if (!!navigator.userAgent.match(/Trident\/7\./)) { $('html').addClass('ie-11'); } processMenuColour();
        if ($(document).find('.leftmenu')) { $('html').addClass('has-left-menu'); } else { $('html').removeClass('has-left-menu'); } $('a[href*="#"]:not([href="#"]):not([href*="#!"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) { $('html, body').animate({ scrollTop: $('body').hasClass('category-list-page') ? target.offset().top - 84 : target.offset().top }, 1000); return false; }
            }
        });
        var resizeContainer = function() { $('li', '.product-list').each(function() { if ($(this).find('.line').outerHeight() > 20) { $(this).find('.container').css({ 'max-height': 'calc(100% - 74px)' }); } else { $(this).find('.container').css({ 'max-height': '' }); } }); };
        if ($('html').hasClass('safari-8')) {
            resizeContainer();
            $(window).on(orientationEvent, function() { resizeContainer(); });
        }
        if ($('body').find('.slider-gallery').length) { $('.slider-gallery').each(function() { var gallery = new Gallery($(this)); }); }

        function isEmpty(obj) { for (var prop in obj) { if (obj.hasOwnProperty(prop)) return false; } return true; }

        function onClick_city($li, $store_location, type) {
            if ($li.closest('.locator-box').hasClass('city')) {
                var city = $li.data('value');
                var city_name = $li.text();
                var country = $store_location.find('.locator-box.country li.chosen').data('value');
                var lang = $('html').attr('lang');
                $.ajax({
                    url: "/" + lang + "/store-locator/load-store/",
                    method: "GET",
                    data: { country: country, city: city, type: type },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $store_location.find('.filter-locator ul').remove();
                            $store_location.find('.filter-locator').append($('<ul />'));
                            $store_location.find('.filter-locator ul').append(data.html);
                        }
                        $li.parent().find('li').removeClass('chosen');
                        $li.addClass('chosen');
                        $li.parent().prev().find(".text").html(city_name);
                        $li.parent().parent().removeClass('open');
                        $li.parent().next().find('option').each(function() { $(this).attr('selected', false); if ($(this).attr('value') == select_val) { $(this).attr('selected', true); } });
                    },
                    error: function(jqXHR, textStatus, errorThrown) { console.log('error'); }
                });
            }
        }

        function storegenerateCity(json_data, $store_location, type) {
            var $ul = $('<ul />');
            if (!isEmpty(json_data)) {
                var obj_data = json_data;
                $store_location.find('.locator-box.city ul').remove();
                $.each(obj_data, function(index, city) {
                    if (index == 0) { var $li = $('<li data-value="' + city.id + '"><span>' + city.value + '</span></li>'); }
                    var $li = $('<li data-value="' + city.id + '"><span>' + city.value + '</span></li>');
                    $li.on('click', function() { onClick_city($(this), $store_location, type) });
                    $ul.append($li);
                });
            }
            return $ul;
        }
        if ($(document).find('.store-locator').length) {
            $('.store-locator').each(function(ind, ele) {
                $(this).addClass('store-locator--' + ind);
                var _store_locator = $('.store-locator--' + ind);
                var _drop_boxes = _store_locator.find('.drop-box');
                var _type = _store_locator.data('type');
                _drop_boxes.each(function(i, e) {
                    $(this).find('label').on('click', function(e) {
                        _store_locator.find('.drop-box').not($(this).parent()).removeClass('open');
                        $(this).parent().toggleClass('open');
                        setTimeout(function() { set_margin_bottom_wrapper_scroll(); if (typeof set_margin_bottom_app_container != 'undefined') { set_margin_bottom_app_container(); } }, 0);
                    });
                    $(this).find('ul li').on('click', function() {
                        if ($(this).closest('.locator-box').hasClass('country')) {
                            var code = $(this).data('value');
                            var lang = $('html').attr('lang');
                            _store_locator.find('.filter-locator ul').remove();
                            _store_locator.find('.locator-box.city label .text').text('');
                            $.ajax({
                                url: "/" + lang + "/store-locator/load-city/",
                                method: "GET",
                                data: { country: code, type: _type },
                                dataType: "json",
                                success: function(data) {
                                    if (data) {
                                        _store_locator.find('.locator-box.city label').after(storegenerateCity(data.list_citites, _store_locator, _type));
                                        _store_locator.find('.filter-locator ul').remove();
                                        _store_locator.find('.filter-locator').append($('<ul />'));
                                        _store_locator.find('.filter-locator ul').append(data.html);
                                    }
                                    setTimeout(function() { set_margin_bottom_wrapper_scroll(); if (typeof set_margin_bottom_app_container != 'undefined') { set_margin_bottom_app_container(); } }, 0);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('error');
                                    setTimeout(function() { set_margin_bottom_wrapper_scroll(); if (typeof set_margin_bottom_app_container != 'undefined') { set_margin_bottom_app_container(); } }, 0);
                                }
                            });
                        }
                        var select_html = $(this).html();
                        var select_val = $(this).attr('data-value');
                        $(this).parent().find('li').removeClass('chosen');
                        $(this).addClass('chosen');
                        $(this).parent().prev().find(".text").html(select_html);
                        $(this).parent().parent().removeClass('open');
                        $(this).parent().next().find('option').each(function() { $(this).attr('selected', false); if ($(this).attr('value') == select_val) { $(this).attr('selected', true); } });
                    });
                });
            });
        }
        $(document).on('click', function(e) { if (e.target.className != '.drop-box' && !$('.drop-box').find(e.target).length) { $(".drop-box").removeClass("open"); } });
        $('.add-to-cart').on('click', function() {
            var $btn_add_to_card = $(this);
            $btn_add_to_card.addClass('active');
            setTimeout(function() { $btn_add_to_card.removeClass('active'); }, 5000);
        });
        $('[fade-onload]').css('opacity', 1);

        function fadeOnScroll() {
            $('[fade-onscroll]').each(function() { var thisOffsetTop = $(this).offset().top; var scrollTop = $(window).scrollTop(); var viewportHeight = window.innerHeight; if (scrollTop > (thisOffsetTop - (viewportHeight * 0.5))) { $(this).css('opacity', 1); } });
            $('.fade-onscroll').each(function() { var thisOffsetTop = $(this).offset().top; var scrollTop = $(window).scrollTop(); var viewportHeight = window.innerHeight; if (scrollTop > (thisOffsetTop - (viewportHeight * 0.5))) { $(this).addClass('in-view'); } });
            if (($('body').hasClass('front-page') || $('body').hasClass('product-page')) && $('.product-list').length > 0) { $('.product-list').each(function() { var thisOffsetTop = $(this).offset().top; var scrollTop = $(window).scrollTop(); var viewportHeight = window.innerHeight; if (scrollTop > (thisOffsetTop - (viewportHeight * 0.5))) { $(this).find('.item').addClass('in-view'); } }); }
        }
        $(window).on('scroll.fadeIn', function() { fadeOnScroll(); });

        function browser_scroll_reached_to_bottom(el, includeMargin) { var winHeight = $(window).height(); var scrollTop = $(window).scrollTop(); var offsetE = $(el).offset().top + (includeMargin ? $(el).outerHeight(true) : $(el).height()) - winHeight; return (scrollTop >= offsetE); }

        function browser_scroll_reached_to_bottom_with_offset(el) {
            var winHeight = $(window).height();
            var scrollTop = $(window).scrollTop();
            var offsetE = $(el).offset().top + $(el).height() - winHeight;
            console.log(scrollTop + 'scrollTop')
            console.log(offsetE + 'offsetE');
            return (scrollTop >= offsetE);
        }

        function set_height_sidebar(selector_sidebar) { var $sidebar = $(selector_sidebar); var topMenu = $('.top-wrapper').outerHeight(); var winHeight = $(window).height(); if ($('html').hasClass('resized')) { $sidebar.height(winHeight - topMenu); } }

        function set_margin_bottom_wrapper_scroll() { if ($(document).find('.wrapper-fix').length && $(window).width() > 1023) { var $wrapper_fix = $(document).find('.wrapper-fix'); var paddingTop = $wrapper_fix.outerHeight(); if (!$('body').hasClass('page-checkout-complete')) { $('.wrapper-main-content').css({ 'margin-bottom': paddingTop + 'px' }); } } }

        function set_sidebar_position_un_fixed() {
            $('.sidebar').removeClass('fixed');
            $('.wrapper-fix').css({ '-webkit-transform': '', 'opacity': '1' })
        }

        function set_sidebar_position_fixed() { $('.sidebar').addClass('fixed'); }

        function set_position_left_sidebar(selector) {
            if (browser_scroll_reached_to_bottom(selector)) {
                set_sidebar_position_un_fixed();
                $('.wrapper-fix').each(function() {
                    $(this).find('.hero-story-container').addClass('in-view');
                    $(this).find('.mod-stories-thumb li.item-text-on-img').addClass('in-view');
                });
            } else { set_sidebar_position_fixed(); }
        }
        set_margin_bottom_wrapper_scroll();
        $(window).on('scroll.bottom_of_product_list', function() {
            if ($('body').hasClass('category-list-page') || $('body').hasClass('product-list-page')) { set_position_left_sidebar('#product-list'); }
            if ($('body').hasClass('product-page') && $('.product-four-column').length > 0) {
                if (browser_scroll_reached_to_bottom('.product-four-column')) {
                    $('.wrapper-fix').css({ '-webkit-transform': '' })
                    $('.wrapper-fix').each(function() { $(this).find('.hero-story-container').addClass('in-view'); });
                } else {}
            }
        });
        $(window).on('scroll.bottom_of_pages_content', function() { if ($('body').hasClass('has-hero-story')) { if (browser_scroll_reached_to_bottom('.wrapper-scroll')) { $('.wrapper-fix').each(function() { $(this).find('.hero-story-container').addClass('in-view'); }); } } if ($('body').hasClass('pages')) { if (browser_scroll_reached_to_bottom('.wrapper-scroll')) { set_sidebar_position_un_fixed(); } else { set_sidebar_position_fixed(); } } })
        $('.menu-level').on('click', 'a', function(event) {
            var current = $(this).closest('.menu-level');
            var submenu = event.target.getAttribute('data-submenu');
            var submenuEl = $('ul.menu-level.' + submenu);
            if ($(this).hasClass('btn-back')) {
                event.preventDefault();
                current.addClass('menu-out');
                setTimeout(function() {
                    current.removeClass('menu-in');
                    $('.main').removeClass('menu-out menu-current').addClass('menu-in');
                }, 500);
            }
            if (submenu) {
                event.preventDefault();
                current.addClass('menu-out');
                setTimeout(function() {
                    current.removeClass('menu-in');
                    submenuEl.removeClass('menu-out menu-current').addClass('menu-in');
                }, 500);
            }
        });
        var canAutoPlay = isDesktop;

        function toggleVideo(video) { var $video = video; if ($video[0].paused) { $video[0].play(); } else { $video[0].pause(); } } $('.top-img-md--video').on('click', 'video', function(e, selector, data) {
            e.preventDefault();
            toggleVideo($(this));
        });
        // Modernizr.on('videoautoplay', function(result) { if (result) { canAutoPlay = true; } else { canAutoPlay = false; if (typeof iOSversion() != "undefined" && iOSversion()[0] >= 10) { canAutoPlay = true;
        //             $('html').removeClass('no-videoautoplay').addClass('videoautoplay'); } else if (typeof iOSversion() != "undefined" && iOSversion()[0] < 10) { canAutoPlay = false;
        //             $('html').addClass('no-play-video'); } } });
        $('.checkout-page--cart-step .frm-btn-submit').on('click', function() { $('.edit-checkout').trigger('click'); });
        if ($('#user-login').length || $('#user-pass').length) { $('.form-item').each(function() { if ($(this).find('input').hasClass('error')) { $(this).addClass('error'); } }); } $("select#edit-country--2 option[value=" + active_country + "]").attr('selected', 'selected');
        if ($('select#edit-country--2').length) {
            var self2 = $('select#edit-country--2');
            var $div = $('<div class="dropdown-country-d"></div>');
            var $ul = $('<ul></ul>');
            $div.append($ul);
            self2.children('option').each(function() {
                var $li = $('<li>' + $(this).text() + '</li>');
                if ($(this).prop('selected')) { $li.addClass('chosen'); } $ul.append($li);
                $li.on('click', function() {
                    $(this).parent().find('li').removeClass('chosen');
                    $(this).addClass('chosen');
                    self2.children().removeAttr('selected');
                    self2.children().eq($(this).index()).attr('selected', 'selected');
                    setTimeout(function() { self2.change(); }, 1000);
                    if ($('#number-item-in-cart').html() != '' && parseInt($('#number-item-in-cart').html()) > 0) {
                        $(this).closest('.list-country').hide();
                        $(this).closest('.list-country').next(".notification").show();
                    } else { $("form#e-common-form-change-country--2").submit(); }
                });
            });
            $(".list-country .popup-content").append($div);
        }
        $(".popup-container .notification .button").on("click", function() { $("form#e-common-form-change-country--2").submit(); });
        $("select#edit-country option[value=" + active_country + "]").attr('selected', 'selected');
        if ($('select#edit-country').length) {
            var self = $('select#edit-country');
            var $div = $('<div class="dropdown-country-m"></div>');
            var $ul = $('<ul></ul>');
            $div.append($ul);
            self.children('option').each(function() {
                var $li = $('<li><a href="#" data-submenu="submenu-5">' + $(this).text() + '</a></li>');
                if ($(this).prop('selected')) { $li.addClass('chosen'); } $ul.append($li);
                $li.on('click', function() {
                    self.children().removeAttr('selected');
                    if ($('#number-item-in-cart').html() != '' && parseInt($('#number-item-in-cart').html()) > 0) { $li.removeAttr('data-submenu'); } else { $li.removeAttr('data-submenu').attr('data-submenu', 'submenu-5'); } self.children().eq($(this).index()).attr('selected', 'selected');
                    setTimeout(function() { self.change(); }, 1000);
                    if ($('#number-item-in-cart').html() != '' && parseInt($('#number-item-in-cart').html()) > 0) {
                        $(this).closest('.list-country').hide();
                        $(this).closest('.list-country').next(".notification").show();
                    } else { $("form#e-common-form-change-country").submit(); }
                });
            });
            $(".tray-menu .submenu-4").append($div);
        }
        $(".submenu-5 .notification .button").on("click", function() { $("form#e-common-form-change-country").submit(); });
        $(".submenu-5 .notification a.underline").on("click", function() { $(".submenu-5 .btn-back").trigger("click"); });
        $(document).on('click', '.footer .bt-scroll-top', function() { $(window).scrollTo(0, 1000); });

        function process_animate_for_hero_story_in_bottom() { if ($(window).width() > 1023) { if ($('body').hasClass('product-page') && $('.pulled-story').length > 0) { $('.pulled-story').insertAfter('.wrapper-main-content'); } $(window).scroll(function() { var h_body = $("body").outerHeight(); if ($('.wrapper-fix').length > 0) { $('body').addClass('has-wrapper-fix'); if (!$('body').hasClass('load-footer') && browser_scroll_reached_to_bottom('.wrapper-main-content', 'includeMargin')) { $('body').addClass("load-footer"); } else if ($('body').hasClass('load-footer') && !browser_scroll_reached_to_bottom('.wrapper-main-content', 'includeMargin')) { setTimeout(function() { $('body').removeClass("load-footer"); }, 10); } } else { $('body').removeClass('has-wrapper-fix'); } }); } }
        if ($('.wrapper-fix').length > 0) { $('body').addClass('has-wrapper-fix'); } else { $('body').removeClass('has-wrapper-fix'); } process_animate_for_hero_story_in_bottom();
        var footer = document.querySelector(".footer");

        function getDocHeight() { var D = document; return Math.max(D.body.scrollHeight, D.documentElement.scrollHeight, D.body.offsetHeight, D.documentElement.offsetHeight, D.body.clientHeight, D.documentElement.clientHeight); }

        function animation_footer_slide_bottom_to_top() {
            if (!$('body').hasClass('story-page')) {
                if (($(window).scrollTop() + $(window).height() > getDocHeight() - 100 && !$('html').hasClass('desktop')) || ($(window).scrollTop() + $(window).height() == getDocHeight() && $('html').hasClass('desktop'))) {
                    setTimeout(function() {
                        if (footer) { footer.classList.add("visible"); }
                        if ($('.wrapper-fix').length > 0 && $('.wrapper-scroll').length > 0) {
                            $('.wrapper-fix').addClass('load-footer');
                            $('.wrapper-scroll').addClass('load-footer');
                        } else if ($('.wrapper-main-content > div > .wrapper-content:first-child').length > 0) { $('.wrapper-content').addClass('load-footer'); } else { $('.wrapper-main-content').addClass('load-footer'); }
                    }, 1000);
                }
            }
        }
        var lastScrollTop = 0;
        $("#cookie .button").on("click touch", function() {
            $.ajax({
                url: "/accept_cookie",
                success: function(result) {
                    if (result == '') {
                        $("#cookie").addClass("close");
                        $("body").removeClass("has-cookie");
                    }
                }
            });
        });
    });
    (function() {
        var privateVar = "This is own gallery";
        this.Gallery = function($slider_gallery_module) {
            this.currentIndex = 0;
            this.$wrapGalleryDesk = $slider_gallery_module.find('.wrapper-gallery-desktop');
            this.$scrollerDesk = this.$wrapGalleryDesk.find('.scroller');
            this.$wrapGalleryMobile = null;
            this.$scrollerMobile = null;
            this.$wrapGalleryDesk.after($('<div class="slider-module slider wrapper-gallery-mobile" />'));
            this.$wrapGalleryMobile = $slider_gallery_module.find('.wrapper-gallery-mobile');
            this.$wrapGalleryMobile.append(this.$scrollerDesk.clone());
            this.$scrollerMobile = this.$wrapGalleryMobile.find('.scroller');
            this.processDesktop = this.processDesktop.bind(this);
            this.processMobile = this.processMobile.bind(this);
            this.handleNavMouseClick = this.handleNavMouseClick.bind(this);
            this.prevAnimation = this.prevAnimation.bind(this);
            this.nextAnimation = this.nextAnimation.bind(this);
            this.processDesktop();
            this.processMobile();
        };

        function extendDefaults(source, properties) { var property; for (property in properties) { if (properties.hasOwnProperty(property)) { source[property] = properties[property]; } } return source; } Gallery.prototype.processDesktop = function() {
            function setIndex($scroller) {
                var _scroller = $scroller;
                var _li = _scroller.find('.item');
                var maxInd = 50;
                _li.each(function(index, ele) {
                    $(ele).css('z-index', maxInd);
                    maxInd--;
                    $(ele).find('.super-img').each(function(index_x, ele_x) { if (_li.hasClass('has-two-imgs')) { if (index_x > 0) { $(ele_x).css({ 'z-index': -1, 'position': 'relative' }); } } })
                });
            }
            setIndex(this.$scrollerDesk);
            this.$scrollerDesk.find('.item:first-child').addClass('active');
            this.$prev = this.$wrapGalleryDesk.find('.left');
            this.$next = this.$wrapGalleryDesk.find('.right');
            this.$prev.on('click', this.handleNavMouseClick);
            this.$next.on('click', this.handleNavMouseClick);
            this.sumItemsD = this.$scrollerDesk.find('.item').length;
            this.currentIndexD = 1;
            this.generateIndicator(this.sumItemsD, this.$wrapGalleryDesk);
        };
        Gallery.prototype.processMobile = function() {
            this.cloneItemGallery(this.$scrollerMobile);
            var configSlide = { scrollX: true, scrollY: false, momentum: false, snap: '.item', keyBindings: true, eventPassthrough: true, disableMouse: true, disableTouch: true };
            this.sumItemsM = this.$scrollerMobile.find('.item').length;
            this.galleryMobile = new IScroll('.wrapper-gallery-mobile', configSlide);
            this.resetSlidersWidth('.wrapper-gallery-mobile');
            this.galleryMobile.refresh();
            var addActionFor = function(galleryM) {
                $('.wrapper-gallery-mobile').find('.item').each(function(index, ele) {
                    var item = $(this);
                    item.find('.wrap').swipe({
                        swipeLeft: function(event, direction, distance, duration, fingerCount) {
                            direction = 'left';
                            console.log(direction);
                            galleryM.next();
                        },
                        swipeRight: function(event, direction, distance, duration, fingerCount) {
                            direction = 'right';
                            console.log(direction);
                            galleryM.prev();
                        },
                        tap: function() { direction = 'tap'; }
                    });
                });
            }
            addActionFor(this.galleryMobile);
            this.galleryMobile.refresh();
            this.generateIndicatorMobile(this.sumItemsM, this.$wrapGalleryMobile);
        };
        Gallery.prototype.generateIndicatorMobile = function(sum, $wrap) {
            var cList = $('<ul/>');
            for (var i = 1; i <= sum; i++) { cList.append($('<li data-ind="' + i + '"></li>').append(function() { return $('<a data-ind="' + i + '"></a>'); })); } $wrap.find('.indicator').append(cList);
            $wrap.find('.indicator ul li:nth-child(1)').addClass('active');
            this.galleryMobile.on('scrollEnd', function() {
                var ind = this.currentPage.pageX + 1;
                $wrap.find('.indicator li').removeClass('active');
                $wrap.find('.indicator li:nth-child(' + ind + ')').addClass('active');
            })
            $wrap.find('.indicator').on('click', 'li', function(evt) {
                var ind = $(evt.currentTarget).data('ind');
                this.galleryMobile.scrollToElement('.wrapper-gallery-mobile' + ' .scroller .item:nth-child(' + ind + ')');
                this.galleryMobile.currentPage.pageX = ind - 1;
            }.bind(this));
        };
        Gallery.prototype.generateIndicator = function(sum, $wrap) {
            if ($wrap.find('.item').length <= 1) { return; }
            var cList = $('<ul/>');
            for (var i = 1; i <= sum; i++) { cList.append($('<li data-ind="' + i + '"></li>').append(function() { return $('<a data-ind="' + i + '"></a>'); })); } $wrap.find('.indicator').append(cList);
            $wrap.find('.indicator ul li:nth-child(1)').addClass('active');
            $wrap.find('.indicator').on('click', 'li', function(evt) { var ind = $(evt.currentTarget).data('ind'); if (ind > this.currentIndexD) { this.nextAnimation(true, ind); } else if (ind < this.sumItemsD) { this.prevAnimation(true, ind); } }.bind(this));
        };
        Gallery.prototype.handleNavMouseClick = function(evt) {
            if (evt) {
                evt.preventDefault();
                if ($(evt.currentTarget).hasClass('controls__nav--prev')) {
                    this.prevAnimation();
                    this.prevD();
                } else { this.nextAnimation(); }
            }
        };
        Gallery.prototype.nextD = function() { if (this.currentIndexD < this.sumItemsD) { this.goTo(this.currentIndexD + 1); } }
        Gallery.prototype.prevD = function() { if (this.currentIndexD > 1) { this.goTo(this.currentIndexD - 1); } }
        Gallery.prototype.goTo = function(index) {
            this.currentIndexD = index;
            this.$wrapGalleryDesk.find('.indicator li').removeClass('active');
            this.$wrapGalleryDesk.find('.indicator li:nth-child(' + index + ')').addClass('active');
        };
        Gallery.prototype.prevAnimation = function(directive, to) {
            this.currentIndexD = this.currentIndexD || 1;
            var cur_nth = this.currentIndexD;
            var prev_nth = this.currentIndexD - 1;
            var $current = this.$scrollerDesk.find('.item:nth-child(' + cur_nth + ')');
            var $prev = this.$scrollerDesk.find('.item:nth-child(' + prev_nth + ')');
            if (typeof directive != 'undefined' && to && this.currentIndexD != to) {
                $prev = this.$scrollerDesk.find('.item:nth-child(' + to + ')');
                this.goTo(to);
            }
            $current.removeClass('in');
            $prev.addClass('in active').removeClass('out');
            setTimeout(function() { if (this.currentIndexD != 1) { $current.removeClass('active'); } }.bind(this), 500);
        };
        Gallery.prototype.nextAnimation = function(directive, to) {
            var cur_nth = this.currentIndexD;
            var next_nth = this.currentIndexD + 1;
            var $current = this.$scrollerDesk.find('.item:nth-child(' + cur_nth + ')');
            var $next = this.$scrollerDesk.find('.item:nth-child(' + next_nth + ')');
            if (typeof directive != 'undefined' && to) {
                $next = this.$scrollerDesk.find('.item:nth-child(' + to + ')');
                this.goTo(to);
            } else if ($next) { this.nextD(); }
            if ($next.length) {
                $next.addClass('active');
                $current.removeClass('in').addClass('out');
                setTimeout(function() { $current.removeClass('active'); }, 500);
            } else {
                this.prevAnimation();
                this.prevD();
            }
        };
        Gallery.prototype.cloneItemGallery = function(wrapper) {
            var $_item = wrapper.find('.item');
            $_item.each(function(index, ele) {
                var len = $(ele).find('.super-img').length;
                if (len > 1) {
                    var wrap = $('<div class="wrap" />').append($(ele).find('.super-img:nth-child(2)').clone().removeClass('right'));
                    var li = $('<li class="item hidden-desktop" />').append(wrap);
                    li.insertAfter($(ele));
                } else {
                    if ($(this).find('.img-mobile').length > 0) {
                        var $li = $(this);
                        $(this).find('.wrap .left').css({ 'background-image': 'url("' + $li.find(".img-mobile").attr("src") + '")' })
                    }
                }
            });
            wrapper.closest('.wrapper-gallery-mobile').append($('<div class="indicator" />'));
        }
        Gallery.prototype.resetSlidersWidth = function(selector_slider) {
            var setWidth = function(ele) {
                var $li = ele.find('.item');
                var sliderWidth;
                var liWidth = 0;
                $li.each(function() { liWidth += $(this).outerWidth(); });
                sliderWidth = liWidth;
                ele.children('.scroller').width(sliderWidth);
            };
            $(selector_slider).each(function() { setWidth($(this)); });
        };
    }());
    $('.ctools-use-modal').on('click', function() { $('html').addClass('lock'); });
    customPopup();

    function customPopup() {
        $('.open-popup').on('click touch', function(e) {
            e.preventDefault();
            $('.popup-container, .overlay').removeClass('in');
            var $this = $(this),
                target = $this.attr('data-target');
            $('#' + target + ', .overlay').toggleClass('in');
            var popup_content = $('#' + target);
            var popup_box = popup_content.find('.popup-box:first-child');
            var old_scroll = -1;
            $('html').addClass('lock');
            popup_content.css({ 'height': popup_content.height() % 2 == 0 ? popup_content.height() : popup_content.height() + 1 + 'px', 'overflow': 'hidden' });
            if (popup_content.find('.popup-content').height() + 160 < popup_content.height()) { popup_content.addClass('no-long'); } popup_box.on('scroll', function() { if (popup_box[0].clientHeight + popup_box.scrollTop() == popup_box[0].scrollHeight) { popup_content.addClass('no-long'); } else { popup_content.removeClass('no-long'); } });
        });
        $('.close-popup').on('click touch', function() {
            var $this = $(this);
            $this.closest('.popup-container').removeClass('in');
            $('.overlay').removeClass('in')
            $('html').removeClass('lock');
        });
        $('.popup-container').on('click touch', function(e) { e.stopPropagation(); });
        $('.overlay').on('click touch', function() {
            $('.popup-container, .overlay').removeClass('in');
            $('html').removeClass('lock');
        });
        $(window).on('keyup', function(e) {
            if (e.keyCode == 27) {
                $('.popup-container, .overlay').removeClass('in');
                $('html').removeClass('lock');
            }
        })
        $(".popup-container .notification .close-noti, .popup-container .notification a.underline").on("click", function() {
            $(this).closest('.notification').hide();
            $(this).closest('.notification').prev(".list-country").show();
        });
    }
    var activeAddToCartFormItem = '';
    var addToCartButtonProgress = true;
    var productVariantChanged = false;
    Drupal.behaviors.vippAddToCartForm = {
        attach: function(context, settings) {
            $('.attribute-widgets > .form-item > label').addClass('loaded');
            if (activeAddToCartFormItem) {
                var arrActiveAddToCartFormItemClass = activeAddToCartFormItem.split(' ');
                var activeAddToCartFormItemClass = '.' + arrActiveAddToCartFormItemClass.join('.');
                $('.attribute-widgets > ' + activeAddToCartFormItemClass + ' > label').removeClass('loaded');
            }
            $('.commerce-add-to-cart label span, .commerce-add-to-cart .detail-tool').remove();
            $('select[id*=edit-attributes-field]').each(function() {
                var self = this;
                var $label = $('label[for=' + $(self).attr('id') + ']');
                var $div = $('<div class="detail-tool" data-select="' + $(this).attr('id') + '"></div>');
                var $ul = $('<ul class="dropdown-list"></ul>');
                $div.append($ul);
                $(this).children('option').each(function() {
                    var self2 = this;
                    var color = $(self2).attr("data-color");
                    var border_color = color;
                    switch (color) {
                        case '#d3d3d3':
                            border_color = '#8e8e8e';
                            break;
                        case '#FFFFFF':
                            border_color = '#a0a0a0';
                            break;
                    }
                    var $li = $('<li><span class="dot" style="background-color: ' + color + '; border-color: ' + border_color + '"></span><span>' + $(this).text() + '</span></li>');
                    if ($(this).prop('selected')) {
                        $li.addClass('chosen');
                        $label.append('<span class="text"><span class="dot" style="background-color: ' + color + '; border-color: ' + border_color + '"></span><span>' + $(this).text() + '</span></span><span class="icon-arrow-down"></span>');
                        if ($label.children('.text').length) { $label.find('.text span:nth-child(2)').text($(self2).text()); } else { $label.append('<span class="text"><span class="dot" style="background-color: ' + color + '; border-color: ' + border_color + '"></span><span>' + $(self2).text() + '</span></span><span class="icon-arrow-down"></span>'); }
                    }
                    $ul.append($li);
                    $li.on('click', function() {
                        $(this).parent().find('li').removeClass('chosen');
                        $(this).addClass('chosen');
                        $(self).children().removeAttr('selected');
                        $(self).children().eq($(this).index()).attr('selected', 'selected');
                        $(this).closest('.detail-tool').removeClass('open');
                        var $formitem = $(this).parents('.form-item');
                        $formitem.children('label').removeClass('open loaded');
                        activeAddToCartFormItem = $formitem.attr('class');
                        setTimeout(function() {
                            $(self).change();
                            productVariantChanged = true;
                        }, 300);
                    });
                });
                $(this).after($div);
            });
            setTimeout(function() { $('.attribute-widgets .form-item:not(.form-type-radio) > label').addClass('loaded'); }, 10);
            $(document).off('click.cart-label').on('click.cart-label', '.commerce-add-to-cart label', function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $('.detail-tool[data-select=' + $(this).attr('for') + ']').toggleClass('open');
            });
            if (!$('#add-to-cart .ajax-added').length) { $('#add-to-cart').append('<div class="ajax-added">' + Drupal.t('Added to cart') + '</div>'); }
        }
    }
    $.fn.setNumberForlist = function() { return this.each(function() { $(this).find('li').each(function(ind) { $(this).attr('data-number', ind + 1); }); }); };
    $.fn.hasScrollBar = function() { console.log($(this)); return this.get(0).scrollHeight > this.height(); };
    $('.text-cont ol').setNumberForlist();
    $(document).ready(function() { $('.kitchen-tool .text-on-md--bg img:visible').each(function() { $(this).one('load', function() { $(this).parent().addClass('loaded'); }).each(function() { if (this.complete) $(this).load(); }); }); });
})(jQuery);;
(function($) {
    $(document).ready(function() {
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        var observeDOM = (function() {
            var MutationObserver = window.MutationObserver || window.WebKitMutationObserver,
                eventListenerSupported = window.addEventListener;
            return function(obj, callback) {
                if (MutationObserver) {
                    var obs = new MutationObserver(function(mutations, observer) { if (mutations[0].addedNodes.length || mutations[0].removedNodes.length) callback(); });
                    obs.observe(obj, { childList: true, subtree: true });
                } else if (eventListenerSupported) {
                    obj.addEventListener('DOMNodeInserted', callback, false);
                    obj.addEventListener('DOMNodeRemoved', callback, false);
                }
            }
        })();
        $.fn.isOnScreen = function() {
            var viewport = {};
            viewport.top = $(window).scrollTop();
            viewport.bottom = viewport.top + $(window).height();
            var bounds = {};
            bounds.top = this.offset().top;
            bounds.bottom = bounds.top + this.outerHeight();
            return ((viewport.top <= bounds.top + this.outerHeight()) && (viewport.bottom >= bounds.bottom));
        };
        var $product_info_md = $('.module-product-info');
        var old_scroll_position = 0;

        function resizeHeightProduct() {
            if ($(window).width() < 1023) {
                var _height = $(window).height();
                _height = _height - 60 - 75;
                $product_info_md.find('.wrapper-gallery .scroller li').css({ 'height': _height + 'px', });
            } else { $product_info_md.find('.wrapper-gallery .scroller li').css({ 'height': '', }); }
        }

        function browser_scroll_reached_to_bottom(el) { var winHeight = $(window).height(); var scrollTop = $(window).scrollTop(); var offsetE = $(el).offset().top + $(el).height() - winHeight; return (scrollTop - offsetE > 30); }

        function toggle_gallery() {
            $product_info_md.find('.wrapper-gallery').toggleClass('expanded');
            $product_info_md.closest('.col-md-9').toggleClass('expanded');
            $product_info_md.find('.product-info-wrapper').toggleClass('rightOut');
            if ($('body').hasClass('zoom-expanded')) { $('body').scrollTo('200'); } $('body').toggleClass('zoom-expanded');
        }

        function initZoomFunction() {
            $product_info_md.find('.wrapper-gallery .scroller-gallery').on('click', function() {
                $product_info_md.find('.scroller.scroller-gallery').removeAttr('style');
                toggle_gallery();
            });
        }

        function fixed_position_of_detail_product() {
            if ($('body').hasClass('product-page') && $('html').hasClass('desktop')) {
                if (browser_scroll_reached_to_bottom($product_info_md.find('.wrapper-gallery').selector)) {
                    var _height = $product_info_md.find('.wrapper-gallery').outerHeight();
                    $product_info_md.find('.indicator ul').addClass('fixed show');
                } else {
                    $product_info_md.find('.indicator ul').addClass('show');
                    $product_info_md.find('.indicator ul').removeClass('fixed');
                }
            }
        }

        function set_top_wrapper_img() {
            if ($(window).width() > 1023) {
                if ($('body').hasClass('product-page') && $('.module-product-info').length > 0) {
                    var _height_wrapper = $('#module-product-info__gallery li').outerHeight();
                    $('#module-product-info__gallery li').each(function() { var _height_item = $(this).find('.wrapper-img').outerHeight(); if ((_height_wrapper * 0.45) - (_height_item / 2) > 0) { $(this).find('.wrapper-img').css({}); } else { $(this).find('.wrapper-img').css({}); } });
                }
            } else { $('#module-product-info__gallery li .wrapper-img').removeAttr('style'); }
        }

        function set_top_wrapper_info() {
            if ($(window).width() > 1023) {
                if ($('body').hasClass('product-page') && $('.module-product-info').length > 0) {
                    var _height_wrapper = $('.product-info-wrapper > div:first-child').outerHeight();
                    var _height_info = $('.product-info-wrapper > div:first-child > div').outerHeight();
                    $('#module-product-info .product-info-wrapper > div:first-child > div').css({ 'bottom': (_height_wrapper * 0.55) - (_height_info / 2) + 'px', 'position': 'absolute' });
                }
            } else { $('#module-product-info .product-info-wrapper > div:first-child > div').removeAttr('style'); }
        }

        function roundingHeightInfoBlock() {}

        function editQuantityChangeManual() { if ($('body').hasClass('product-page')) { $('input[id*="edit-quantity"]').on('change', function() { var limit_quantity = parseFloat($('input.limit-quantity[type="hidden"]').val()); var new_quantity = $(this).val(); if (new_quantity > limit_quantity) { $(this).val(limit_quantity); } }); } } editQuantityChangeManual();
        initZoomFunction();
        fixed_position_of_detail_product();
        $(window).on('scroll.bottom_of_product_list load', function() { fixed_position_of_detail_product(); });
        $(window).on(orientationEvent + ' load', function() {
            resizeHeightProduct();
            set_top_wrapper_img();
        })
        if ($(document).find('.module-product-info .wrapper-gallery').length) {
            var galleryProduct = new GalleryProduct();
            observeDOM(document.getElementById('module-product-info'), function() {
                if ($('#dom-changed').val() == "1") {
                    $('#dom-changed').val('0');
                    galleryProduct.resize();
                    $product_info_md = $('.module-product-info');
                    initZoomFunction();
                }
            });
            if ($(window).width() > 1023) {
                if ($('.product-info__flag').length > 0) {
                    var _height_information_block = $('.product-info__flag > div').height() + 284;
                    var _width_information_block = $('.product-info__flag > div').width();
                    var _height_wrapper_info = _height_information_block < $(window).height() ? $(window).height() : _height_information_block;
                    $('.product-info-wrapper').css('height', _height_wrapper_info + 'px');
                    var mask = $('<div class="mask" />').css({ 'position': 'absolute', 'height': _height_wrapper_info + 'px', 'bottom': '0', 'width': _width_information_block + 'px', 'pointer-events': 'none' });
                    mask.appendTo($('.module-product-info'));
                    $('.product-info-wrapper').css({ 'position': 'fixed', 'top': 0, 'bottom': 'auto' });
                    if ($('.product-info__flag').height() % 2 != 0) { $('.product-info__flag').css({ 'height': $('.product-info__flag').height() + 1 + 'px' }); }
                }
                var firstscroll = 0;
                $(window).off('scroll.galleryDesktop').on('scroll.galleryDesktop', function() { var scrollTop = $(window).scrollTop(); if (firstscroll == 0) { firstscroll = scrollTop; } var offset_info = $('.mask').offset().top; if (scrollTop - offset_info <= 0) { $('.product-info-wrapper').css({ 'position': 'fixed', 'top': 0, 'bottom': 'auto' }); } else { $('.product-info-wrapper').css({ 'position': 'absolute', 'top': 'auto', 'bottom': 0 }); } })
            } else {
                $('.product-info-wrapper').removeAttr('style');
                $(window).off('scroll.galleryDesktop');
            }
        }
        Drupal.behaviors.editQuantityOnProductPage = { attach: function(context, settings) { editQuantityChangeManual(); } }
        Drupal.behaviors.setTopImgWrapper = { attach: function(context, settings) { if ($('body').hasClass('product-page')) { set_top_wrapper_img(); } } }
    });
    (function() {
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        var privateSlider = 'This is slider in product information';

        function inView(element) {
            var topOfElement = element.offset().top;
            var bottomOfElement = element.offset().top + element.outerHeight(true);
            var scrollTopPosition = $(window).scrollTop() + $(window).height();
            var windowScrollTop = $(window).scrollTop()
            if (windowScrollTop > topOfElement && windowScrollTop < bottomOfElement) { return 1; } else if (windowScrollTop > bottomOfElement && windowScrollTop > topOfElement) { return 0; } else if (scrollTopPosition < topOfElement && scrollTopPosition < bottomOfElement) { return 0; } else if (scrollTopPosition < bottomOfElement && scrollTopPosition > topOfElement) { return 0; } else { return 1; }
        }
        this.GalleryProduct = function() {
            this.currentIndex = 0;
            this.moduleProductInfo = $('.module-product-info');
            this.gallery = this.moduleProductInfo.find('.wrapper-gallery');
            this.item = this.gallery.find('.item').length;
            if (this.item == 1) { this.moduleProductInfo.closest('.block').addClass('has-fold'); } this.indicator = this.gallery.find('.indicator');
            this.resize = this.resize.bind(this);
            this.generateIndicator = this.generateIndicator.bind(this);
            this.component = null;
            $(window).on('load ' + orientationEvent, this.resize);
            $(window).on('scroll.scrollGalleryinDesktop', function() {
                if ($(window).width() >= 1024) {
                    var _self = this;
                    if ($(window).scrollTop() < 84) {
                        _self.indicator.find('li').removeClass('active');
                        _self.indicator.find('ul li:eq(0)').addClass('active');
                        return false;
                    }
                    this.gallery.find('.item').each(function(index, value) {
                        if (inView($(this))) {
                            _self.indicator.find('li').removeClass('active');
                            _self.indicator.find('ul li:eq(' + index + ')').addClass('active');
                        }
                    });
                }
            }.bind(this))
        };
        GalleryProduct.prototype.resize = function() {
            this.initOnMobile();
            this.indicator.on('click', 'li', function(evt) {
                var ind = $(evt.currentTarget).data('ind');
                if ($(window).width() >= 1024) {
                    $('html, body').animate({ scrollTop: this.gallery.find('.item:nth-child(' + ind + ')').offset().top }, 500);
                    this.gallery.find('.indicator li').removeClass('active');
                    this.gallery.find('.indicator li:nth-child(' + ind + ')').addClass('active');
                } else {
                    this.component.scrollToElement('.module-product-info .wrapper-gallery' + ' .scroller .item:nth-child(' + ind + ')');
                    this.component.currentPage.pageX = ind - 1;
                }
            }.bind(this));
            this.item = this.gallery.find('.item').length;
            this.generateIndicator(this.item, this.gallery);
        }
        GalleryProduct.prototype.resetSlidersWidth = function(selector_slider) {
            var setWidth = function(ele) {
                var $li = ele.find('.item');
                var sliderWidth;
                var liWidth = 0;
                var wi = ele.outerWidth();
                $li.each(function() { liWidth += $(this).outerWidth(); });
                sliderWidth = liWidth;
                ele.children('.scroller').width(sliderWidth);
            };
            $(selector_slider).each(function() { setWidth($(this)); });
        };
        GalleryProduct.prototype.initOnDesktop = function() {
            this.component = null;
            this.gallery.attr("style", "");
            var configDesktop = { snap: '.item', snapSpeed: 400, momentum: false, keyBindings: true, mouseWheel: true, };
            this.component = new IScroll('.wrapper-gallery', configDesktop)
        }
        GalleryProduct.prototype.initOnMobile = function() {
            var configMobile = { scrollX: true, scrollY: false, momentum: false, snap: '.item', keyBindings: true, eventPassthrough: true, disableMouse: true, disableTouch: true }
            this.component = new IScroll('.wrapper-gallery', configMobile);
            this.resetSlidersWidth('.wrapper-gallery');
            this.component.refresh();
            var addActionFor = function(galleryM) {
                $('.wrapper-gallery').find('.item').each(function(index, ele) {
                    var item = $(this);
                    item.find('.wrapper-img').swipe({
                        swipeLeft: function(event, direction, distance, duration, fingerCount) {
                            direction = 'left';
                            galleryM.next();
                        },
                        swipeRight: function(event, direction, distance, duration, fingerCount) {
                            direction = 'right';
                            galleryM.prev();
                        },
                        tap: function() { direction = 'tap'; }
                    });
                });
            }
            addActionFor(this.component);
            this.component.refresh();
        }
        GalleryProduct.prototype.generateIndicator = function(sum, selector) {
            selector.find('.indicator ul').html('');
            if (sum > 1) {
                for (var i = 1; i <= sum; i++) { selector.find('.indicator ul').append($('<li data-ind="' + i + '"></li>').append(function() { return $('<a data-ind="' + i + '"></a>'); })); } selector.find('.indicator ul li:nth-child(1)').addClass('active');
                this.component.on('scrollEnd', function() {
                    var ind = this.currentPage.pageX + 1;
                    selector.find('.indicator li').removeClass('active');
                    selector.find('.indicator li:nth-child(' + ind + ')').addClass('active');
                })
            } else { selector.find('.indicator').empty(); }
        }
    }());
})(jQuery);;
(function($) {
    $(document).ready(function() {
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        $(window).on(orientationEvent, function() { $('.product-list .item .mo+.line span:first-child').each(function() { $(this).removeClass('one-line'); var h_name_product = $(this).height(); if (h_name_product <= 14) { $(this).addClass('one-line'); } else { $(this).removeClass('one-line'); } }); }).trigger(orientationEvent);

        function process_size_item_products_list() {
            $('ul.product-list li').each(function() {
                var _container = $(this).find('.container');
                var _size;
                if (_container.hasClass('landscape')) { _size = $(this).find('.container').outerHeight(); } else { _size = $(this).find('.container').outerWidth(); }
                if ($('body').hasClass('category-list-page')) { if ($(this).hasClass('landscape')) { _size = $(this).find('.container').outerHeight(); } else { _size = $(this).find('.container').outerWidth(); } } $(this).find('.container .img-wrapper').css({ 'width': _size + 'px', 'height': _size + 'px', 'position': 'relative' });
                _container.addClass('loaded');
            });
        }
        $(document).ready(function() { process_size_item_products_list(); });
        $(window).on(orientationEvent, function() { process_size_item_products_list(); });
    });
})(jQuery);;
(function($) {
    $(document).ready(function() {
        $('.view-detail-cart .thead-title').on('click', function() { $(this).toggleClass('open'); });
        $('.block-sign-in .title-sign span:nth-child(2)').on('click', function() { $(this).closest('.block-sign-in').addClass('open'); });
        $('.block-billing-address').hide();
        $('#checkbox1').on('click', function() { if ($(this).is(':checked')) { $('.block-billing-address').show(); } else { $('.block-billing-address').hide(); } });

        function changeQuantity() {
            $('.quantity-box span, .form-item-quantity span, [class*="form-item-edit-quantity"] span').on('click touch', function(e) {
                console.log("gdshasg");
                e.preventDefault();
                var $this = $(this),
                    target = $this.siblings('input'),
                    get_value = parseInt(target.val());
                if ($this.hasClass('minus')) { if (get_value >= 2) { get_value -= 1; } }
                if ($this.hasClass('plus')) { get_value += 1; } target.val(get_value);
            });
        }

        function editQuantityOnCartPage() { if ($('body').hasClass('checkout-page--cart-step')) { $('input[id*="edit-edit-quantity"]').on('change', function() { var limit_quantity = parseFloat($(this).closest('.col-quantity').find('.limit-quatity').text()); var new_quantity = $(this).val(); if (new_quantity > limit_quantity) { $(this).val(limit_quantity); } }); } } editQuantityOnCartPage();
        Drupal.behaviors.editQuantityOnProductPage = { attach: function(context, settings) { editQuantityOnCartPage(); } }
        $('.view-content-cart .cont-item', 'body.checkout-page--cart-step').each(function() { var $this = $(this); var $col_description = $this.find('.col-description'); if (!$col_description.find('.color-product').length) { $col_description.addClass('no-colour'); } });
    });
})(jQuery);;
(function($) {
    var supportsOrientationChange = "onorientationchange" in window,
        orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
    var $carousel = $('.images-slider');

    function showSliderScreen($widthScreen) { if ($widthScreen < 1024) { if (!$carousel.hasClass('slick-initialized')) { $carousel.slick({ infinite: false, centerMode: true, slidesToShow: 1, slidesToScroll: 1, arrows: false, dots: false, variableWidth: true, centerPadding: '0' }); } } else { if ($carousel.hasClass('slick-initialized')) { setTimeout(function() { $carousel.slick('unslick'); }, 500); } } }
    var widthScreen = $(window).width();
    $(window).ready(showSliderScreen(widthScreen)).resize(function() {
        var widthScreen = $(window).width();
        showSliderScreen(widthScreen);
    });

    function inView(element) {
        var topOfElement = element.offset().top;
        var bottomOfElement = element.offset().top + element.outerHeight(true);
        var scrollTopPosition = $(window).scrollTop() + $(window).height();
        var windowScrollTop = $(window).scrollTop()
        if (windowScrollTop > topOfElement && windowScrollTop < bottomOfElement) { return 1; } else if (windowScrollTop > bottomOfElement && windowScrollTop > topOfElement) { return 0; } else if (scrollTopPosition < topOfElement && scrollTopPosition < bottomOfElement) { return 0; } else if (scrollTopPosition < bottomOfElement && scrollTopPosition > topOfElement) { return 0; } else { return 1; }
    }

    function process_multi_videos_on_page() {
        if ($(window).width() < 1024) {
            $('video:visible').each(function(index, value) {
                var _self = $(this);
                _self[0].pause();
            });
            $(window).on('scroll touchmove', function(event) {
                $('video:visible').each(function(index, value) {
                    var _self = $(this);
                    if (inView(_self)) {
                        $('video:visible')[0].pause();
                        _self[0].play();
                    } else { _self[0].pause(); }
                });
            });
            $(window).on('load', function() {
                $('video:visible').each(function(index, value) {
                    var _self = $(this);
                    _self[0].pause()
                });
                if ($('video:eq(0)').length) { setTimeout(function() { $('video:visible:eq(0)')[0].play(); }, 300); }
            });
        }
    }

    function process_sidebar_in_content_pages() {
        var sidebar = $('.sidebar-pages');
        var sidebar_mb = $('.sidebar-mb:hidden');
        var item_active;
        if ($(window).width() >= 1024) {
            if (sidebar.length) {
                item_active = sidebar.find('.active');
                if (item_active.length) {
                    if (item_active.closest('ul').hasClass('child-levels')) {
                        sidebar.find('.child-levels').hide();
                        item_active.closest('ul').show();
                    } else {
                        sidebar.find('.child-levels').hide();
                        item_active.next('.child-levels').show();
                    }
                }
            }
        } else {
            if (sidebar_mb.length) {
                item_active = sidebar_mb.find('.active');
                if (item_active.length) {
                    sidebar_mb.show();
                    if (item_active.closest('ul').hasClass('child-levels')) {
                        item_active.closest('ul').closest('li').addClass('parent_active');
                        sidebar_mb.find('.child-levels').hide();
                        item_active.closest('ul').show();
                        sidebar_mb.find('.col-xs-12 > ul:first-child > li:not(.parent_active)').hide();
                    } else {
                        item_active.closest('li').addClass('parent_active');
                        sidebar_mb.find('.child-levels').hide();
                        item_active.next('.child-levels').show();
                        sidebar_mb.find('.col-xs-12 > ul:first-child > li:not(.parent_active)').hide();
                    }
                }
            }
        }
    }

    function process_vertical_center_text_on_img() { var text_on_img = $('.text-on-md'); if (text_on_img.length) { text_on_img.each(function() { var _self = $(this); var _text = _self.find('div[class*="_center"]'); if ($(window).width() < 1024) { _text.css({ 'padding-top': '' }); } else { _text.css({ 'padding-top': (_self.outerHeight() - _text.height()) / 2 + 'px' }); } }); } } $('.bg-overlay').on('click', function(ev) {
        $(this).closest('.embed-video').addClass('show-video');
        $("#video")[0].src += "&autoplay=1";
        ev.preventDefault();
    });
    $('.country ul li').on('click', function() {
        $('.city').addClass('show-city');
        $('.filter-locator').addClass('show-filter');
        var _heightFilter = $('.filter-locator').height();
        if (_heightFilter >= 762) { $('.filter-locator').css({ 'max-height': '762px', 'overflow': 'hidden', 'overflow-y': 'scroll' }) }
    });
    $('#edit-commerce-shipping-shipping-service').on('click', 'input[type="radio"]', function() {
        $('#edit-commerce-shipping-shipping-service').find('.form-item').removeClass('checked');
        $(this).closest('.form-item').addClass('checked');
    });
    $('document').ready(function() {
        process_sidebar_in_content_pages();
        $('#edit-commerce-shipping-shipping-service .form-item input[type="radio"]:checked').closest('.form-item').addClass('checked');
        var _height = 0;
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
        var text_n_img_slider_mds = $('.text-n-img-slider-md');
        (text_n_img_slider_mds.length > 0) && (init_text_n_img_slider_md(text_n_img_slider_mds));
        var video_embed_mds = $('.img-video-embed');
        (video_embed_mds.length > 0) && (init_video_embed_md(video_embed_mds));

        function init_text_n_img_slider_md(modules) {
            modules.each(function(ind, element) {
                $(this).data('ind', ind);
                new TextnImageModule(this);
            });
        }

        function init_video_embed_md(modules) {
            modules.each(function(ind, ele) {
                $(this).data('ind', ind);
                new VideoEmbed(this);
            });
        }

        function getMaxHeight($ele_base) { return $ele_base[0].getBoundingClientRect().height; }

        function proceesOnPageHasTopFixed() {
            if ($('.top-story-md').length) {
                var _row = $('<div class="row" />');
                var _col_xs_14 = $('<div class="col-xs-14" />');
                _col_xs_14.append(_row);
                var _row_module = $('.top-story-md').find('.top-story-md--content').clone();
                $('.top-story-md').find('.top-story-md--content').css({ 'display': 'none' });
                _row_module.append(_row);
                _row_module.insertBefore('.wrapper-main-content');
                var previousScroll = 0;
                var scroll_direction = 'up';
                var maxScroll = 0;
                $(window).on(orientationEvent, function() { maxScroll = 0; });
                $(window).on('scroll.page-has-top-block-fixed', function() {
                    maxScroll = maxScroll ? maxScroll : $(document).height() - $(window).height();
                    if ($(window).scrollTop() == 0) { maxScroll = $(document).height() - $(window).height(); }
                    var currentScroll = $(this).scrollTop();
                    if (currentScroll > previousScroll) { scroll_direction = 'down'; } else { scroll_direction = 'up'; } previousScroll = currentScroll;
                    var _wrapper_main_content = $('.wrapper-main-content');
                    if (maxScroll < $('.top-story-md--content').outerHeight()) {
                        if ($(window).scrollTop() == maxScroll) {
                            _wrapper_main_content.css({ 'top': $('.top-story-md--content').outerHeight() + 'px' }).addClass('scroll');
                            $('.top').addClass('resized');
                            $('html').addClass('resized');
                            $(window).scrollTo($('.top-story-md').offset().top);
                        } else if ((scroll_direction == 'up' && $(window).scrollTop() - $('.top-story-md').outerHeight() == 0) || $(window).scrollTop() < maxScroll) {
                            _wrapper_main_content.css({ 'top': '' }).removeClass('scroll');
                            $('.top').removeClass('resized');
                            $('html').removeClass('resized');
                        }
                    } else {
                        if ($(window).scrollTop() >= $('.top-story-md--content').outerHeight()) {
                            _wrapper_main_content.css({ 'top': $('.top-story-md--content').outerHeight() + 'px' }).addClass('scroll');
                            $('.top').addClass('resized');
                            $('html').addClass('resized');
                        } else {
                            _wrapper_main_content.css({ 'top': '' }).removeClass('scroll');
                            $('.top').removeClass('resized');
                            $('html').removeClass('resized');
                        }
                    }
                });
            }
        }
        if ($('body').hasClass('story-page') || $('body').hasClass('node-type-hotel')) {
            proceesOnPageHasTopFixed();
            $(window).on('load ' + orientationEvent, function() {
                setTimeout(function() {
                    $('.footer').appendTo('.wrapper-main-content');
                    $('body').css({ 'height': '' });
                    var _content_height = $('.wrapper-main-content').outerHeight();
                    $('body').css({ 'height': _content_height + 'px' });
                    $('.top.primary').removeClass('sticky');
                    setTimeout(function() { $('body').addClass('show-top-story'); }, 1000);
                }, 500);
            });
        }
        if ($('body').hasClass('page-stories')) {
            function setMaxHeight($list) {
                var _maxHeight;
                if ($list.find('.story-item').length > 1) { _maxHeight = getMaxHeight($list.find('.story-item:nth-child(2)')) + 'px'; } else { _maxHeight = getMaxHeight($list.find('.story-item:nth-child(1)')) + 'px'; }
                if ($list.find('.story-item').length) {
                    $list.find('.story-item:nth-child(7n+1)').each(function() { $(this).find('.story-item__thumb-desktop').css({ 'padding-top': _maxHeight }); });
                    $list.find('.story-item:nth-child(7n+4), .story-item:nth-child(7n+5), .story-item:nth-child(7n+6)').each(function() { $(this).find('.story-item__thumb-mobile').css({ 'padding-top': _maxHeight }); });
                }
            }

            function getStoriesById($ele, $cls_chosen) {
                $ele.closest('ul').find('li').removeClass($cls_chosen);
                $ele.closest('li').addClass($cls_chosen);
                var url_ajax = $('#link-ajax-story').val();
                var _id = $ele.attr('data-cate-id') != '0' ? '?id=' + $ele.attr('data-cate-id') : '';
                $.ajax({
                    url: url_ajax + _id,
                    dataType: "json",
                    success: function(result) {
                        if (result) {
                            var _old_height = $('.stories-list .story-item:first-child').outerHeight();
                            $('.stories-list').empty().html(result.html);
                            $(window).scrollTop(0);
                            if (result.html != '') {
                                $('.stories-list .story-item').css({ 'opacity': '0' });
                                if ($('.stories-list .story-item').length > 0) {
                                    setMaxHeight($('.stories-list'));
                                    _height = $('body.page-stories .stories-list').outerHeight();
                                    $('.stories-list .story-item').css({ 'opacity': '1' });
                                }
                            } else { $('.stories-list').css('min-height', _old_height + 'px'); }
                        }
                    }
                });
            }
            if ($('.stories-list .story-item').length) { setMaxHeight($('.stories-list')); } $(window).on('load.stories-page', function() {
                _height = $('body.page-stories .stories-list').outerHeight();
                $('li a', '.stories-filter').on('click', function(e) {
                    if ($('body').hasClass('page-stories')) {
                        e.preventDefault();
                        getStoriesById($(this), 'active');
                    }
                });
                $('li.cate-stories a', '.tray-menu--submenu.submenu-2').on('click touch', function(e) {
                    if ($('body').hasClass('page-stories')) {
                        e.preventDefault();
                        $('body').removeClass('open-tray-menu');
                        getStoriesById($(this), 'chosen');
                        $(this).closest('.submenu-2').find('li a').removeClass('active');
                        $(this).addClass('active');
                    }
                });
            })
            $(window).on('resize.sizeHeightStory', function() { if ($(window).width() > 1023) { setMaxHeight($('.stories-list')); } else { $('.stories-list .story-item').each(function() { $(this).find('.story-item__thumb-desktop').css('padding-top', '') }); } })
            $(window).on('scroll.stories-page', function() { if ($(window).scrollTop() + $(window).height() >= _height && $(document).height() - $(window).scrollTop() - $(window).height() <= 60) { $('body').addClass('no-fixed-filter'); } else { $('body').removeClass('no-fixed-filter'); } })
        }

        function resizeHalfSize() {
            var mod_storie_thumbs = $('.mod-stories-thumb', 'body.node-type-hotel-list-page, .node-type-hotel');
            mod_storie_thumbs.each(function() {
                var items = $(this).find('li');
                items.each(function() { $(this).css({ 'height': $(this).height() }) });
            });
        }

        function checkMaxHeightTextNSlider() { if ($('.text-n-img-slider-md--slide').length > 0) { var md_text_n_img_sliders = $('.text-n-img-slider-md--slide'); if ($(window).width() < 1024) { md_text_n_img_sliders.find('.img-comp').removeAttr('style'); return; } md_text_n_img_sliders.each(function() { var el = $(this); if (el.find('.text-comp').height() > el.find('.img-comp .img-comp-wrapper').height()) { el.find('.img-comp').css({ 'height': el.find('.text-comp').height() }); } else { el.find('.img-comp').css({ 'height': '' }); } }); } } $(window).on('load resize', function() {
            if ($('body').hasClass('node-type-hotel-list-page') || $('body').hasClass('node-type-hotel')) { resizeHalfSize(); return; }
            if ($('body').hasClass('node-type-hotel')) { setTimeout(function() { checkMaxHeightTextNSlider(); }, 200); }
            if ($('.mod-stories-thumb').length > 0) {
                $('.mod-stories-thumb').each(function() {
                    if ($(this).find('li').length == 2) {
                        if ($(window).width() >= 768) {
                            var _w = $(this).find('li:nth-child(2)')[0].getBoundingClientRect().width;
                            _w = 4 / 3 * _w;
                            $(this).find('li:nth-child(2)').css({ 'padding-top': _w + 'px' });
                            var _height = getMaxHeight($(this).find('li:nth-child(2)'));
                            $(this).find('li').addClass('not-padding').css({ 'padding-top': _w + 'px' });
                        } else { $(this).find('li').removeClass('not-padding').css({ 'padding-top': '' }); }
                    }
                });
            }
        });
        $(window).on('resize.displaySidebarMenu', function() { process_sidebar_in_content_pages(); })
    });
    $(window).on('load resize', function() { process_vertical_center_text_on_img(); });
    this.TextnImageModule = function(module) {
        this.moduleEle = $(module);
        this.moduleIndx = this.moduleEle.data('ind');
        this.wrapper_slide = this.moduleEle.find('.wrapper').addClass('module-' + this.moduleIndx);
        this.wrapper_slide = this.moduleEle.find('.wrapper.module-' + this.moduleIndx);
        this.items_text = this.wrapper_slide.find('.text-comp');
        this.items_img = this.wrapper_slide.find('.img-comp');
        this.resize = this.resize.bind(this);
        this.initPaging = this.initPaging.bind(this);
        this.indicator = this.moduleEle.find('.slick-indicator');
        this.auto = this.moduleEle.data('autoplay');
        this.scroller = this.moduleEle.find('.wrapper');
        if (this.auto == '1') { this.scroller.slick({ autoplay: true, autoplaySpeed: 2000, speed: 500, fade: true, cssEase: 'ease' }); } else { this.scroller.slick({ infinite: false, fade: true, cssEase: 'ease' }); } this.scroller.on('afterChange', function(event, slick, currentSlide, nextSlide) {
            if ($(slick.$slides.get(currentSlide)).find('video').length) { if (inView($(slick.$slides.get(currentSlide)).find('video'))) { $(slick.$slides.get(currentSlide)).find('video')[0].play(); } }
            var _self = this;
            _self.wrapper_slide.find('.paging li').removeClass('slick-active');
            _self.wrapper_slide.find('.paging').each(function() { $(this).find('li').each(function(idx, val) { if (idx == currentSlide) { $(this).addClass('slick-active'); } }); });
        }.bind(this));
        this.scroller.on('beforeChange', function(event, slick, currentSlide, nextSlide) {});
        if (this.scroller.find('.text-n-img-slider-md--slide:first-child video').length) { this.scroller.find('.text-n-img-slider-md--slide:first-child video').get(0).pause(); } $(window).on('load', this.resize);
    };
    TextnImageModule.prototype.resize = function() { this.initPaging(); };
    TextnImageModule.prototype.initPaging = function() {
        var $ul = $('<ul class="paging slick-dots" />');
        var _self = this;
        if (_self.wrapper_slide.find('.text-n-img-slider-md--slide').length <= 1) { return; } _self.wrapper_slide.find('.text-n-img-slider-md--slide').each(function(index, value) {
            var $li = $('<li data-idx="' + index + '"><button>' + index + '</button></li>');
            if (index == 0) { $li.addClass('slick-active'); } $li.on('click', function() {
                _self.scroller[0].slick.slickGoTo(index);
                _self.wrapper_slide.find('.paging li').removeClass('slick-active');
                _self.wrapper_slide.find('.paging').each(function() { $(this).find('li').each(function(idx, val) { if (idx == index) { $(this).addClass('slick-active'); } }); });
            });
            $li.appendTo($ul);
        });
        _self.items_img.each(function() { $ul.clone(true, true).appendTo($(this)); });
        _self.items_text.each(function() { $ul.clone(true, true).appendTo($(this)); });
        _self.items_img.each(function() {
            $(this).find('.img-comp__nav-left').on('click', function() { _self.scroller.slick('slickPrev'); });
            $(this).find('.img-comp__nav-right').on('click', function() { _self.scroller.slick('slickNext'); });
        });
        _self.wrapper_slide.addClass('created');
    };
    this.VideoEmbed = function(module) {
        this.moduleEle = $(module);
        this.wrap_embed = this.moduleEle.find('.wrap.embed-video');
        this.video_poster = this.wrap_embed.find('.video-poster');
        this.embedID = this.moduleEle.data('embed-id');
        this.videoStarted = false;
        this.playEmbedVideo = this.playEmbedVideo.bind(this);
        if (!this.videoStarted) { this.wrap_embed.find('.iframe-wrap iframe').css({ 'display': 'none' }); } this.video_poster.on('click', function(evt) {
            evt.preventDefault();
            if (this.videoStarted) {
                this.video_poster.css({ 'display': 'none' });
                this.wrap_embed.find('.iframe-wrap iframe').css({ 'display': 'block' });
            }
            this.playEmbedVideo();
        }.bind(this));
        $(window).on('load', function() {}.bind(this))
    }
    VideoEmbed.prototype.playEmbedVideo = function() {
        this.videoStarted = true;
        this.srcEmbed = 'https://www.youtube.com/embed/' + this.embedID + '?autoplay=1&showinfo=0&loop=1&playsinline=1&controls=1';
        this.wrap_embed.find('.iframe-wrap iframe').attr('src', this.srcEmbed);
        this.wrap_embed.find('.iframe-wrap iframe').click();
        this.video_poster.css({ 'display': 'none' });
        this.wrap_embed.find('.iframe-wrap iframe').css({ 'display': 'block' });
    };

    function scrollIntoView() {
        var parent = $('.wrapper-video');
        if ($('html').hasClass('videoautoplay')) {
            parent.each(function() {
                var $video = $(this).find('video');
                $video[0].play();
            });
            return;
        }
        parent.each(function() {
            var $video = $(this).find('video');
            var src = $(this).find('.url_video').text();
            var type = $(this).find('.type').text();
            // var isInView = isScrolledIntoView(window, $video[0]);
            // if (isInView) {
            //     if ($video.children('source').length) {
            //         console.log('in view');
            //         var nopromise = { catch: new Function() };
            //         ($video[0].play() || nopromise).catch(function() {});
            //         console.log(1);
            //     } else {
            //         $video.html('<source src="' + src + '" type="video/' + type + '">');
            //         $video[0].muted = true;
            //         $video[0].load();
            //         console.log(2);
            //     }
            // } else {
            //     console.log(111);
            //     if ($video.children('source').length) { $video[0].pause(); }
            // }
        });
    }

    // function isScrolledIntoView(container, elem) { var docViewTop = $(container).scrollTop(); var docViewBottom = docViewTop + $(container).height(); var elemTop = $(elem).offset().top; var elemBottom = elemTop + $(elem).height(); return ((elemTop <= docViewBottom) && (elemBottom >= docViewTop)); } 
    $(document).ready(function() {
        if ($('html').hasClass('videoautoplay')) return;
        // var $wrapper_videos = $('.wrapper-video');
        // $wrapper_videos.each(function() {
        //     var $video = $(this).children('video');
        //     var src = $(this).find('.url_video').text();
        //     var type = $(this).find('.type').text();
        //     $video.prop('muted', true);
        //     $video.off('loadeddata').on('loadeddata', function() { console.log('loaded'); });
        //     $video.find('source').attr('src', src);
        //     $video[0].muted = true;
        //     $video.load();
        // });
        $(window).scroll(scrollIntoView);
    });
    Drupal.behaviors.renderShippingDropdown = {
        attach: function(context, settings) {
            if ($('body.checkout-page--cart-step').length) {
                var shipping_country = $(document, context).find('#edit-shipping-country');
                var shipping_select_temp = $(document, context).find('.shipping-select-box');
                var shipping_dt_a = $(document, context).find('dt a');
                var shipping_ul = shipping_select_temp.find('dd ul');
                shipping_dt_a.find('span').html(shipping_country.find('option:selected').text());
                shipping_dt_a.click(function(e) {
                    if ($(window).width() > 1023) { $('.open-popup').trigger('click'); } else {
                        $('.tray-menu ul').removeClass('menu-current menu-in' + ' menu-out');
                        $('.tray-menu .submenu-4').addClass('menu-current menu-in');
                        $('body').toggleClass('open-tray-menu');
                    }
                });

                function selectShipping(value, eSelect) {
                    eSelect.val(value).change();
                    shipping_ul.removeClass('open');
                }
                shipping_ul.empty();
                var options = shipping_country.find('option');
                var list_li = $.map(options, function(option, index) { return { 'txt': option.innerHTML, 'value': option.value }; });
                $.each(list_li, function(ind, ele) { var li = $('<li/>').appendTo(shipping_ul); var aa = $('<a/>').attr('data-value', ele.value).text(ele.txt).click(function(ev) {}).appendTo(li); });
            }
        }
    };
    Drupal.ajax = Drupal.ajax || {};
    Drupal.behaviors.renderCountryDropdown = {
        attach: function(context, settings) {
            if ($('body.checkout-page--info-detail-step, body.page-user').length) {
                var $select = $('select.country, select.country_temp', context);
                if ($select.length > 0) {
                    $select.each(function() {
                        var self = this;
                        var parent = $(self).closest('.form-item');
                        var $label = $(self).prev();
                        if (!$label.find('.country').length) { $('<span class="country"></span>').appendTo($label); } $label.find('.country').html($(self).find('option:selected').text());
                        var options = $(self).find('option');
                        var list_li = $.map(options, function(option, index) { return { 'txt': option.innerHTML, 'value': option.value }; });
                        if (parent.find('ul.dropdown-country').length) { parent.find('ul.dropdown-country').remove(); }
                        var $ul = $('<ul/>').addClass('dropdown-country');
                        $label.click(function() { $ul.toggleClass('open'); })
                        $.each(list_li, function(ind, ele) {
                            var li = $('<li/>').appendTo($ul);
                            var aa = $('<a/>').attr('data-value', ele.value).click(function(e) {
                                e.preventDefault();
                                $(self).val(ele.value).trigger('change');
                            }).text(ele.txt).appendTo(li);
                        });
                        $(self).after($ul);
                        $(self).css({ 'display': 'none' });
                    });
                }
            }
        }
    };
    Drupal.behaviors.renderStateDropdown = {
        attach: function(context, settings) {
            if ($('body.checkout-page--info-detail-step, body.page-user').length) {
                var $select = $('select.state', context);
                if ($select.length > 0) {
                    $select.each(function() {
                        var self = this;
                        var parent = $(self).closest('.form-item');
                        var $label = $(self).prev();
                        if (!$label.find('.state').length) { $('<span class="state"></span>').appendTo($label); }
                        if ($('body').hasClass('page-user')) { parent.insertAfter($(self).closest('.locality-block').next()); } $label.find('.state').html($(self).find('option:selected').text());
                        var options = $(self).find('option');
                        var list_li = $.map(options, function(option, index) { return { 'txt': option.innerHTML, 'value': option.value }; });
                        if (parent.find('ul.dropdown-state').length) { parent.find('ul.dropdown-state').remove(); }
                        var $ul = $('<ul/>').addClass('dropdown-state');
                        $label.click(function() { $ul.toggleClass('open'); })
                        $.each(list_li, function(ind, ele) {
                            var li = $('<li/>').appendTo($ul);
                            var aa = $('<a/>').attr('data-value', ele.value).click(function(e) {
                                e.preventDefault();
                                $(self).val(ele.value).trigger('change');
                                $label.find('span.state').html(ele.txt);
                                $ul.removeClass('open');
                            }).text(ele.txt).appendTo(li);
                        });
                        $(self).after($ul);
                        $(self).css({ 'display': 'none' });
                    });
                }
            }
        }
    };
})(jQuery);;
(function($) {
    $.fn.regex = function(pattern, fn, fn_a) { var fn = fn || $.fn.text; return this.filter(function() { return pattern.test(fn.apply($(this), fn_a)); }); };
    $(document).ready(function() {
        var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

        function add_wrapper_input_in_edit_user_frm() { if ($('form[id*="user-profile-form"]').length > 0) { $('input', 'form[id*="user-profile-form"]').each(function() { if (!$(this).closest('.wrapper-input').length) { $(this).wrap('<div class="wrapper-input"></div>'); } if ($(this).hasClass('error')) { $(this).closest('.form-item').css({ 'border-color': '#c90000' }); } }); } }

        function add_wrapper_input_password() {
            if ($('form[id*="user-profile-form"]').length > 0) {
                $('input', '#user-profile-form').each(function() {
                    if ($(this).attr('type') == 'password') {
                        $(this).closest('.form-item').append('<div class="wrapper-password"></div>');
                        $(this).closest('.form-item').find('label, .wrapper-input').appendTo($(this).closest('.form-item').find('.wrapper-password'));
                    }
                })
            }
        }

        function add_wrapper_input_in_cart_info() {
            if ($('body').hasClass('checkout-page--info-detail-step') && $('#commerce-checkout-form-checkout').length) {
                $('input[type="text"]', '#commerce-checkout-form-checkout').each(function() {
                    if (!$(this).closest('.wrapper-input').length) {
                        $(this).wrap('<div class="wrapper-input"></div>');
                        var wrapper_input = $(this).closest('.wrapper-input');
                        wrapper_input.parent().addClass('border-input');
                    }
                    if ($(this).hasClass('vat-number')) { $(this).closest('.border-input').find('.description').insertAfter($(this).closest('.border-input')); }
                });
                $('select.country, select.country_temp, select.state').each(function() { $(this).closest('div').addClass('border-input'); });
            }
        }

        function check_shipping_type_selected() {
            if ($('#commerce-shipping-service-ajax-wrapper').length > 0) {
                var wrapper_frm = $('#commerce-shipping-service-ajax-wrapper');
                wrapper_frm.find('input[type="radio"]').each(function(e) {
                    if ($(this).attr('checked') == "checked") { $(this).closest('.form-item').addClass('checked'); } $(this).on('click', function() {
                        wrapper_frm.find('.checked input[type="radio"]').removeAttr("checked");
                        wrapper_frm.find('.form-item').removeClass('checked');
                        $(this).closest('.form-item').addClass('checked');
                        $(this).prop("checked", true);
                    })
                });
            }
        }

        function orderStateAndCountryField() {
            if ($('body').hasClass('checkout-page--info-detail-step')) {
                if ($('.locality-block').length > 0) {
                    $('.locality-block').each(function() {
                        var _locality_block = $(this);
                        _locality_block.next().after(_locality_block.find('> div:nth-child(2)'));
                    });
                }
            }
        }
        orderStateAndCountryField();
        add_wrapper_input_in_edit_user_frm();
        add_wrapper_input_password();
        add_wrapper_input_in_cart_info();
        Drupal.behaviors.addWrapperInputInEditUser = {
            attach: function(context, settings) {
                setTimeout(function() {
                    add_wrapper_input_in_edit_user_frm();
                    add_wrapper_input_in_cart_info();
                    check_shipping_type_selected();
                }, 500);
            }
        }
        Drupal.behaviors.reOrderStatesField = { attach: function(context, settings) { orderStateAndCountryField(); } }
    });
})(jQuery);;
(function($) {
    Drupal.behaviors.validateForm = {
        attach: function(context, settings) {
            $('input', '#edit-account-login').each(function() {
                var _this = $(this);
                if (_this.hasClass('form-text required has-error')) { _this.closest('.form-item-account-login-mail').addClass('has-error'); }
                if (_this.is('#edit-account-login-mail') && _this.closest('.form-item-account-login-mail')) {
                    _this.closest('.form-item-account-login-mail').next('.error-message').remove();
                    _this.closest('.form-item-account-login-mail').after($('<span class="error-message"></span>'));
                    _this.on('change', function() {
                        var email = _this.val();
                        if (!validateEmail(email)) {
                            _this.closest('.form-item-account-login-mail').next('.error-message').text('The e-mail address you have entered is not valid. You need to include an @- sign.');
                            _this.closest('.border-input').addClass('has-error');
                        } else {
                            _this.closest('.has-error').removeClass('has-error');
                            _this.closest('.form-item-account-login-mail').next('.error-message').remove();
                        }
                    });
                }
            });
            $('input', '#edit-customer-profile-shipping').each(function() {
                var _this = $(this);
                if (_this.hasClass('name-block form-text required')) { if (_this.hasClass('error')) { _this.closest('.addressfield-container-inline.name-block').addClass('has-error'); } }
                if (_this.hasClass('thoroughfare form-text required')) { if (_this.hasClass('error')) { _this.closest('.form-item').addClass('has-error'); } }
                if (_this.hasClass('locality')) { if (_this.hasClass('error')) { _this.closest('.form-item').addClass('has-error'); } } _this.on('change', function() {
                    if (_this.hasClass('required') && !_this.is('#edit-account-login-mail')) {
                        if (emptyInput(_this)) {
                            _this.closest('.has-error').removeClass('has-error');
                            _this.closest('.has-error').removeClass('has-error');
                        } else { _this.closest('.border-input').addClass('has-error'); }
                    }
                })
            });
            $('select', '#edit-customer-profile-shipping').each(function() { var _this = $(this); if (_this.hasClass('error')) { _this.closest('.form-type-select').addClass('has-error'); } _this.on('change', function() { if (_this.hasClass('required') && _this.find(":selected").val() == '') { _this.closest('.form-type-select').addClass('has-error'); } else { _this.closest('.form-type-select').removeClass('has-error'); } }); });
            $('input', '#customer-profile-billing-ajax-wrapper').each(function() {
                var _this = $(this);
                _this.on('change', function() {
                    if (_this.hasClass('required') && !_this.is('#edit-account-login-mail')) {
                        if (emptyInput(_this)) {
                            _this.closest('.has-error').removeClass('has-error');
                            _this.closest('.has-error').removeClass('has-error');
                        } else { _this.closest('.border-input').addClass('has-error'); }
                    }
                })
            });
            $('select', '#customer-profile-billing-ajax-wrapper').each(function() { var _this = $(this); if (_this.hasClass('error')) { _this.closest('.form-type-select').addClass('has-error'); } _this.on('change', function() { if (_this.hasClass('required') && _this.find(":selected").val() == '') { _this.closest('.form-type-select').addClass('has-error'); } else { _this.closest('.form-type-select').removeClass('has-error'); } }); });

            function checkHasError() {
                var hasError = 0;
                $('input.required, select.required', '#commerce-checkout-form-checkout').each(function() {
                    if ($('#commerce-checkout-form-checkout').find('.has-error').length > 0) { hasError++; }
                    if ($(this).val() == '') {
                        if ($(this).closest('.addressfield-container-inline.name-block').length) {
                            $(this).closest('.addressfield-container-inline.name-block').addClass('has-error');
                            hasError++;
                        }
                        if ($(this).closest('.form-item.form-type-textfield').length) {
                            $(this).closest('.form-item.form-type-textfield').addClass('has-error');
                            hasError++;
                        }
                    }
                    if ($(this).closest('.form-item.form-type-select').length) {
                        if ($(this).find(':selected').val() == '') {
                            $(this).closest('.form-item.form-type-select').addClass('has-error');
                            hasError++;
                        }
                    }
                });
                return hasError;
            }
            if ($('body').hasClass('checkout-page--info-detail-step')) {
                $('.checkout-page--info-detail-step .frm-btn-submit').on('click', function(e) { e.preventDefault(); if (!checkHasError()) { $('#edit-continue').trigger('click'); } else { $('#error').addClass('open'); } })
                $('.checkout-page--info-detail-step').on('click', '.back-btn, .view-detail-cart .f-right > a', function(e) {
                    e.preventDefault();
                    $('#edit-cancel').trigger('click');
                })
            }
            if ($('body').hasClass('checkout-page--order-summary-step')) {
                $('.checkout-page--order-summary-step .back-btn').on('click', function(e) {
                    e.preventDefault();
                    $('#edit-back').trigger('click');
                })
                $('.checkout-page--order-summary-step .frm-btn-submit').on('click', function(e) {
                    e.preventDefault();
                    $('#edit-continue').trigger('click');
                })
            }
        }
    }

    function validateEmail(email) { var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; return re.test(email); }

    function checkEmail($inputEmail) { var emailTxt = typeof $inputEmail != 'undefined' ? $.trim($inputEmail.val()) : ''; if (!validateEmail(emailTxt)) { $inputEmail.parent().next().text('The e-mail address you have entered is not valid. You need to include an @- sign.'); return false; } else { $inputEmail.parent().next('span').remove(); return true; } }

    function numberValidate($inputNumber) { if ($inputNumber == '') return true; var valNumber = typeof $inputNumber != 'undefined' ? $.trim($inputNumber.val()) : ''; return $.isNumeric(valNumber); }

    function emptyInput($emptyInput) { var _inputField = typeof $emptyInput != 'undefined' ? $.trim($emptyInput.val()) : ''; return _inputField; } $(document).ready(function() {
        if ($('body').hasClass('page-user-edit')) {
            $('form.form-normal-user > div:first-child').children().each(function(e) {
                var id_frm = $(this)[0].id;
                if (id_frm == '' || typeof id_frm == 'undefined') { return true; } else {
                    switch (id_frm) {
                        case 'edit-account':
                            $(this).find('input').each(function() { var $input = $(this); if ($input.hasClass('error')) { $input.closest('.form-item').addClass('has-error'); } });
                            break;
                        case 'edit-field-shipping-info':
                        case 'edit-field-billing-info':
                            $(this).find('input').each(function() { var $input = $(this); if ($input.hasClass('name-block') && $input.hasClass('error')) { $input.closest('.addressfield-container-inline.name-block').addClass('has-error'); } else if ($input.hasClass('error')) { $input.closest('.form-item').addClass('has-error'); } });
                            $(this).find('select').each(function() { var $select = $(this); if (!$select.find(':selected').val()) { $select.closest('.form-item').addClass('has-error'); } });
                            break;
                        case 'edit-field-phone-number':
                            $(this).insertAfter($('#edit-field-shipping-info'));
                            break;
                    }
                }
            });
            $('.form-type-password').each(function() {
                var $this = $(this);
                $this.find('> :first-child').insertAfter($this.find('> :nth-child(2)'));
                if ($(window).width() < 1024) { $this.find('input.password-confirm').on('keydown', function() { $(this).closest('.form-item').addClass('add-margin'); }); }
            });
        }
        if ($('body').hasClass('not-logged-in') && $('.error_message').length > 0) { $('.error_message').insertBefore($('#user-login .form-item-name')); }
    });
})(jQuery);;
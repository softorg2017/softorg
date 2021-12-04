(function(b, a) {
        b.prototype.mouseRight = function(c, h) {
            var f, d, e, g;
            e = this;
            f = {
                menu: [{}, ],
                ele: "wrap-ms-right",
                ele_item: "ms-item",
            };
            d = b.extend({}, f, c);
            b(this).each(function() {
                (function i() {
                        var n = b("<div></div>");
                        n.attr("class", d.ele);
                        for (var m = 0; m < d.menu.length; m++) {
                            var k = b("<li></li>");
                            k.addClass(d.ele_item);
                            var l = b("<i></i>");
                            k.attr("data-item", m);
                            l.addClass(d.menu[m].icon);
                            l.attr("data-item", m);
                            l.appendTo(k);
                            k.appendTo(n);
                            l.after("&nbsp; " + d.menu[m].itemName)
                        }
                        n.prependTo("body");
                        var j = b("<div></div>");
                        j.attr("class", "shade");
                        j.prependTo("body")
                    }
                )();
                a.oncontextmenu = function() {
                    return false
                }
                ;
                b(this).mousedown(function(j) {
                    if (j.which === 3) {
                        b("." + d.ele).css({
                            "display": "block",
                            "top": j.pageY + "px",
                            "left": j.pageX + "px"
                        })
                    }
                });
                b("." + d.ele).click(function(l) {
                    var j = parseInt(b(l.target).attr("data-item"));
                    for (var k = 0; k < d.menu.length; k++) {
                        if (j == k) {
                            d.menu[k].callback();
                            b("." + d.ele).css({
                                "display": "none"
                            })
                        }
                    }
                });
                b(".shade").click(function() {
                    b("." + d.ele).css({
                        "display": "none"
                    })
                })
            });
            return this
        }
    }
)(jQuery, window);

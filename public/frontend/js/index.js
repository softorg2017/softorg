/**
 * @description javascript for
 * @author TuzK1ss
 * @date 15/12/3.
 */

(function (root, factory) {
    'use strict';

    if (typeof define === 'function' && define.amd) {
        require(['jquery'], factory);
    } else if (typeof module === 'object') {
        module.exports = factory(require('jquery'));
    } else {
        root.lean = factory(jQuery);
    }

})(this, function ($) {
    'use strict';

    var _lean = {
        $body : $('body'),
        $nav : $('#nav'),
        $navCurrent : $('#nav_current'),
        $section : $('.section'),
        $navS : $('#nav_s'),

        sectionIdArr : ['index', 'introduction', 'business', 'idea', 'contrast', 'advantage', 'case', 'about', 'footer'],
        loadTopArr : [0],
        loadHeightArr : [],
        lastActiveIndex : 0,
        lastScrollTop: 0,
        moveDisabled : false,
        initialize : function () {
            console.log('lean initialize ...');

            var _this = this;

            _this.bindingNavLink()
                .initializeFullPage()
                //.bindingBodyScroll()
                .bindIndexNext()
                .bindNavSEvent()
                .bindNavSLinkEvent()
                .bindPartnerHide();
        },
        bindingNavLink : function () {
            var _this = this,
                index = 0;

            _this.$nav.on('click', '.js-nav-link', function () {
                index = $(this).parent().index();
                index ++;

                if (index  > 4) {
                    index --;
                }


                $.fn.fullpage.moveTo(index);
            });

            return _this;
        },

        initializeFullPage : function () {
            var _this = this,
                $load;

            $('#fullpage').fullpage({
                sectionSelector: '.section',
                slideSelector: '.slide',
                slidesNavigation: true,
                slidesNavPosition: 'bottom',
                onLeave: function(index, nextIndex, direction){

                    //console.log(index, nextIndex);
                    $load = $('.loaded');
                    setTimeout(function () {
                        _this.activeNavLink(nextIndex - 1);

                        _this.$section.eq(nextIndex - 1).addClass('loaded');
                    }, 200);

                    setTimeout(function() {
                        $load.removeClass('loaded');
                    }, 410);
                }
            });

            return _this;
        },

        bindIndexNext : function () {
            var _this = this;
            $('#index_next').on('click', function () {
                $('.js-nav-link').eq(1).trigger('click');
            });

            return _this;
        },
        activeNavLink : function (index) {
            var _this = this,
                $nLink =  _this.$nav.find('.js-nav-link').eq(index),
                id = $nLink.attr('data-scroll-id'),
                text = $nLink.attr('data-text'),
                black = parseInt($nLink.attr('data-black'), 10),
                $parent = $nLink.parent();


            if (!$parent.hasClass('active')) {

                _this.$nav.find('li.active').removeClass('active');

                _this.$navCurrent.addClass('active');

                if (text) {
                    $parent.addClass('active');

                    setTimeout(function (){
                        _this.$navCurrent.addClass('changed');
                        _this.$navCurrent.find('a').html(text);

                        if (black) {
                            _this.$nav.addClass('black');
                            _this.$navS.addClass('black');
                        } else {
                            _this.$nav.removeClass('black');
                            _this.$navS.removeClass('black');
                        }
                    }, 150);

                } else {
                    setTimeout(function (){
                        _this.$navCurrent.find('a').html('');
                        _this.$navCurrent.removeClass('changed');
                        _this.$navS.removeClass('black');

                        if (black) {
                            _this.$nav.addClass('black');
                        } else {
                            _this.$nav.removeClass('black');
                        }
                    }, 150);
                }

                setTimeout(function () {
                    _this.$navCurrent.removeClass('active');
                }, 610);

            }
        },
        bindNavSEvent : function () {
            var _this = this;

            $('#nav_s_btn').tap(function () {
               _this.$navS.toggleClass('active');
            });
            return _this;
        },
        bindNavSLinkEvent :function () {
            var _this = this,
                index;

            _this.$navS.on('click', '.js-nav-s-link', function () {
                index = $(this).parent().index();

                _this.$navS.removeClass('active');

                $.fn.fullpage.moveTo(++index);
            });

            return _this;
        },
        bindPartnerHide : function () {
            var _this = this;

            $('#introduction_logo_container').tap(function (e) {

                $('body').width() < 500 &&  $('#introduction_logo_container').toggleClass('hide');
            });

            return _this;
        }
    };

    return _lean.initialize();
});
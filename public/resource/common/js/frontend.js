!function(){
    "use strict";

    var o={
            Android:function(){ return navigator.userAgent.match(/Android/i)},
            BlackBerry:function(){ return navigator.userAgent.match(/BlackBerry/i)},
            iOS:function(){ return navigator.userAgent.match(/iPhone|iPad|iPod/i)},
            Opera:function(){ return navigator.userAgent.match(/Opera Mini/i)},
            Windows:function(){ return navigator.userAgent.match(/IEMobile/i)},
            any:function(){ return o.Android()||o.BlackBerry()||o.iOS()||o.Opera()||o.Windows()}
        },

        t=function(){
            $(".js-backtotop").on("click", function(o){ o.preventDefault(),
                $("html,body").animate({scrollTop:$("body").offset().top}, 700, "easeInOutExpo")
            })
        },

        e=function(){
            $(".js-next").on("click", function(o){o.preventDefault(),
                $("html,body").animate({scrollTop:$($.attr(this, "href")).offset().top}, 700, "easeInOutExpo")}),
                $(window).scroll(function(){
                    $(this).scrollTop()>10?$(".js-next").addClass("probootstrap-sleep"):$(".js-next").removeClass("probootstrap-sleep")})
        },

        a=function(){
            $(".header-burger-menu").on("click", function(o){
                o.preventDefault(),
                    $("body").hasClass("show") ?
                        (
                            $(".header-burger-menu").removeClass("active"),$("body").removeClass("show")
                        )
                        :
                        (
                            $(".header-burger-menu").addClass("active"),$("body").addClass("show")
                        )
            }),
                $(window).width()>991 ?
                    (
                        $("body").removeClass("mobile-menu-active"),
                            $(".header-burger-menu").removeClass("active")):$("body").addClass("mobile-menu-active"),

                        $(window).resize(function(){
                            $(window).width()>991 ?
                            (
                                console.log("resizing"),
                                $("body").removeClass("mobile-menu-active"),$(".header-burger-menu").removeClass("active")
                            )
                            :
                            $("body").addClass("mobile-menu-active")
                        }
                    ),
                $(document).click(function(o){
                    var t=$(".probootstrap-nav,.header-burger-menu");
                    t.is(o.target)||0!==t.has(o.target).length || $("body").hasClass("show") &&
                    ($("body").removeClass("show"),$(".header-burger-menu").removeClass("active"))
                })
        },

        n=function(){
            $(".js-probootstrap-search").on("click", function(){
                $("#probootstrap-search").addClass("active"), setTimeout(function(){
                    $("#probootstrap-search").find("#search").focus().select()
                }, 500)
            }),
                $(".js-probootstrap-close").on("click", function(){
                    $("#probootstrap-search").removeClass("active")
                })
        },

        i=function(){
            o.any()||$(".probootstrap-navbar .navbar-nav li.dropdown").hover(function(){
                    $(this).find("> .dropdown-menu").stop(!0, !0).delay(200).fadeIn(500).addClass("animated-fast fadeInUp")},
                function(){
                    $(this).find("> .dropdown-menu").stop(!0, !0).fadeOut(200).removeClass("animated-fast fadeInUp")
            })
        },

        s=function(){
            var o=$(".owl-carousel-carousel");
            o.owlCarousel({
                items:3, loop:!0, margin:20, nav:!1, dots:!0, smartSpeed:800, autoHeight:!0,
                navText:["<i class='icon-keyboard_arrow_left owl-direction'></i>", "<i class='icon-keyboard_arrow_right owl-direction'></i>"],
                responsive:{
                    0:{items:1},
                    400:{items:1},
                    600:{items:2},
                    1e3:{items:3}}}),
                (o=$(".owl-carousel-fullwidth")).owlCarousel({items:1, loop:!0, margin:20, nav:!1, dots:!0, smartSpeed:800, autoHeight:!0, autoplay:!0,
                    navText:["<i class='icon-keyboard_arrow_left owl-direction'></i>", "<i class='icon-keyboard_arrow_right owl-direction'></i>"]}),
                (o=$(".owl-work")).owlCarousel({stagePadding:150, loop:!0, margin:20, nav:!0, dots:!1, mouseDrag:!1, autoWidth:!0, autoHeight:!0, autoplay:!0, autoplayTimeout:2e3, autoplayHoverPause:!0,
                    navText:["<i class='icon-chevron-thin-left'></i>","<i class='icon-chevron-thin-right'></i>"],
                    responsive:{
                        0:{ items:1, stagePadding:10},
                        500:{ items:2, stagePadding:20},
                        600:{ items:2, stagePadding:40},
                        800:{ items:2, stagePadding:100},
                        1100:{ items:3},
                        1400:{ items:4}}})
        },

        r=function(){
            $(".flexslider").flexslider({ animation:"fade", prevText:"", nextText:"", slideshow:!0})
        },

        d=function(){
            var o=0;
            $(".probootstrap-animate").waypoint(function(t){
                    "down"!==t||$(this.element).hasClass("probootstrap-animated")||(o++,
                        $(this.element).addClass("item-animate"),
                        setTimeout(function(){
                            $("body .probootstrap-animate.item-animate").each(function(o){
                                var t=$(this);
                                setTimeout(function(){
                                    var o=t.data("animate-effect");
                                    "fadeIn"===o?t.addClass("fadeIn probootstrap-animated"):"fadeInLeft"===o?t.addClass("fadeInLeft probootstrap-animated"):"fadeInRight"===o?t.addClass("fadeInRight probootstrap-animated"):t.addClass("fadeInUp probootstrap-animated"), t.removeClass("item-animate")},200*o, "easeInOutExpo")})},100))},
                {offset:"95%"})
        },

        p=function(){
            $(".js-counter").countTo({
                formatter:function(o,t){
                    return o.toFixed(t.decimals)
                }
            })
        },

        l=function(){
            $("#probootstrap-counter").length>0&&$("#probootstrap-counter").waypoint(function(o){"down"!==o||$(this.element).hasClass("probootstrap-animated")||(setTimeout(p, 400),
                $(this.element).addClass("probootstrap-animated"))}, {offset:"90%"})
        },

        c=function(){
            $(".image-popup").magnificPopup({
                type:"image", removalDelay:300, mainClass:"mfp-with-zoom", gallery:{enabled:!0},
                zoom:{enabled:!0, duration:300, easing:"ease-in-out", opener:function(o){return o.is("img")?o:o.find("img")}}}),
                $(".with-caption").magnificPopup({type:"image",closeOnContentClick:!0, closeBtnInside:!1, mainClass:"mfp-with-zoom mfp-img-mobile", image:{ verticalFit:!0, titleSrc:function(o){return o.el.attr("title")+' &middot; <a class="image-source-link" href="'+o.el.attr("data-source")+'" target="_blank">image source</a>'}},zoom:{enabled:!0}}),
                $(".popup-youtube,.popup-vimeo,.popup-gmaps").magnificPopup({disableOn:700, type:"iframe", mainClass:"mfp-fade", removalDelay:160, preloader:!1,fixedContentPos:!1})
        },

        u=function(){o.any()||$(window).stellar()},

        m=function(){
            $(".progress-bar-s2").length>0 &&
            (
                $(".progress-bar-s2").appear(),
                $(document.body).on("appear", ".progress-bar-s2", function(){
                    var o=$(this);
                    if(!o.hasClass("appeared")){
                        var t=o.data("percent");
                        o.append("<span>"+t+"%</span>").css("width", t+"%").addClass("appeared")
                    }
                })
            )
        };


    // $(document).ready(function(){ i(), l(), d(), t(), n(), c(), u(), m(), a(), e() }),
    // $(window).load(function(){ s(), r() })
    $(document).ready(function(){ a() })

}();

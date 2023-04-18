<script>
    $(function() {

//        $('article').readmore({
//            speed: 150,
//            moreLink: '<a href="#">展开更多</a>',
//            lessLink: '<a href="#">收起</a>'
//        });

        $('.lightcase-image').lightcase({
            maxWidth: 9999,
            maxHeight: 9999
        });

        var viewportSize = $(window).height();
        var lazy_load = function(){
            var scrollTop = $(window).scrollTop();
            $("img").each(function(){
                var _this = $(this);
                var x = viewportSize + scrollTop + _this.position().top;
                if(x>0){
                    _this.attr("src",_this.attr("data-src"));
                }
            })
        };
//        setInterval(lazy_load,1000);

    });
</script>
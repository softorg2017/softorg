$(function() {

    // 监听鼠标移动事件
    $(document).on("mousewheel DOMMouseScroll", function (event) {

        var $wheelDelta = event.originalEvent.wheelDelta;
        var delta = (event.originalEvent.wheelDelta && (event.originalEvent.wheelDelta > 0 ? 1 : -1)) ||  // chrome & ie
            (event.originalEvent.detail && (event.originalEvent.detail > 0 ? -1 : 1));              // firefox

        // console.log(event.originalEvent.wheelDelta);
        if (delta > 0)
        {
            // console.log("up ++++"); // 向上滚
            if($wheelDelta > 0)
            {
                $('.main-header').removeClass('down');
                $('.main-header').addClass('up');

                $(".main-header .navbar2").hide();
                $(".main-header .navbar1").show();

                // $(".main-header .navbar1").animate({
                //     top:'50px',function(){
                //     }
                // });

                // $(".main-header .navbar1").slideDown(1000,function(){
                //     console.log('up');
                //     // $(".main-header .navbar1").hide();
                // });
            }
        }
        else if (delta < 0)
        {
            // console.log("down ++++"); // 向下滚
            if($(document).scrollTop() > 90)
            {
                $('.main-header').removeClass('up');
                $('.main-header').addClass('down');

                $(".main-header .navbar1").hide();
                $(".main-header .navbar2").show();

                // $(".main-header .navbar1").animate({
                //     top:'-50px',function(){
                //         $(".main-header .navbar1").hide();
                //     }
                // });
                // $(".main-header .navbar2").show();
                // $(".main-header .navbar2").animate({
                //     top:'-50px',function(){
                //     }
                // });

                // $(".main-header .navbar1").hide();
                // $(".main-header .navbar2").slideDown(1000,function(){
                //     console.log('down');
                //     // $(".main-header .navbar1").hide();
                // });
            }
        }
    });

    $(window).scroll(function() {

        if($(document).scrollTop() <= 0)
        {
            // console.log("滚动条已经到达顶部为0");
        }

        if($(document).scrollTop() > 60)
        {
            console.log('$(window).height() = ' + $(window).height());
            console.log('$(document).height() = ' + $(document).height());
            console.log($('.fixed-to-top').height());
            $('.fixed-to-top').height();
            // $(".fixed-to-top").addClass('fixed');
        }

        if($(document).scrollTop() <= 60)
        {
            // $(".fixed-to-top").removeClass('fixed');
        }

        if($(document).scrollTop() >= $(document).height() - $(window).height())
        {
            // console.log("滚动条已经到达底部为" + $(document).scrollTop());
        }

        console.log('$(document).scrollTop() = ' + $(document).scrollTop());
        console.log('$("#content-container").scrollTop() = ' + $('#content-container').scrollTop());
    });



    // 全部展开
    $(".main-body").on('click', '.fold-down', function () {
        $('.recursion-row').each( function () {
            $(this).show();
            $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
        });
    });
    // 全部收起
    $(".main-body").on('click', '.fold-up', function () {
        $('.recursion-row').each( function () {
            if($(this).attr('data-level') != 0) $(this).hide();
            $(this).find('.recursion-fold').removeClass('fa-minus-square').addClass('fa-plus-square');
        });
    });
    // 收起
    $(".main-body").off("click", ".recursion-row .fa-minus-square").on('click', '.recursion-row .fa-minus-square', function () {
        var $$this_row = $(this).parents('.recursion-row');
        var $this_level = $$this_row.attr('data-level');
        $$this_row.nextUntil('.recursion-row[data-level='+$this_level+']').each( function () {
            if($(this).attr('data-level') <= $this_level ) return false;
            $(this).hide();
        });
        $(this).removeClass('fa-minus-square').addClass('fa-plus-square');
    });
    // 展开
    $(".main-body").off("click", ".recursion-row .fa-plus-square").on('click', '.recursion-row .fa-plus-square', function () {
        var $$this_row = $(this).parents('.recursion-row');
        var $this_level = $$this_row.attr('data-level');
        $$this_row.nextUntil('.recursion-row[data-level='+$this_level+']').each( function () {
            if($(this).attr('data-level') <= $this_level ) return false;
            $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).show();
        });
        $(this).removeClass('fa-plus-square').addClass('fa-minus-square');
    });

});


// 初始化展开
function fold_init()
{

    var $item_active = $('.side-menu .recursion-item.active');
    if($item_active.length > 0)
    {
        console.log(1);
        var item_a = $item_active.find('a').clone();
        $('.prev-content').find('.a-box').html('已经是封页了');

        var content_first = $('.side-menu .recursion-row').first();
        $('.next-content').find('.a-box').html(content_first.find('a').clone());
    }

    $(".recursion-row .active").each(function() {

        console.log(2);
        var $this_row = $(this).parents('.recursion-row');
        var this_level = $this_row.attr('data-level');
        $this_row.find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

        var prev_row = $this_row.prev(".recursion-row");
        var next_row = $this_row.next(".recursion-row");

        if(prev_row.length == 0)
        {
            var item_a = $('.side-menu .recursion-item').find('a').clone();
            $('.prev-content').find('.a-box').html(item_a);
            $('.prev-content').find('.a-box').html('已经是封页了');
        }
        else
        {
            $('.prev-content').find('.a-box').html(prev_row.find('a').clone());
        }

        if(next_row.length == 0)
        {
            $('.next-content').find('.a-box').html('已经是最后了');
        }
        else
        {
            $('.next-content').find('.a-box').html(next_row.find('a').clone());
        }


        // console.log(prev_row);

        if(this_level == 0)
        {
            $this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
                if($(this).attr('data-level') <= this_level ) return false;
                $(this).show();
                $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
            });
        }
        else if(this_level > 0)
        {
            $this_row.prevUntil().each( function ()
            {
                if( $(this).attr('data-level') == 0 )
                {
                    $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

                    $(this).nextUntil('.recursion-row[data-level=0]').show();
                    $(this).nextUntil('.recursion-row[data-level=0]').find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                    return false;
                }
            });
        }

    });

}
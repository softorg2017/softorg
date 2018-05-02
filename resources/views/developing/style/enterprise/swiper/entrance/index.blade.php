<html lang="en"><head>
    <meta charset="utf-8">
    <title>Swiper demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <!-- Link Swiper's CSS -->
    <link href="https://cdn.bootcss.com/Swiper/4.2.2/css/swiper.min.css" rel="stylesheet">

    <!-- Demo styles -->
    <style>
        html, body {
            position: relative;
            height: 100%;
        }
        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color:#000;
            margin: 0;
            padding: 0;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>
</head>
<body>
<!-- Swiper -->
<div class="swiper-container swiper-container-vertical">
    <div class="swiper-wrapper">
        <div class="swiper-slide">首页</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div>
        <div class="swiper-slide">联系我们</div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 6"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 7"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 8"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 9"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 10"></span>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

<!-- Swiper JS -->
<script src="https://cdn.bootcss.com/Swiper/4.2.2/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        slidesPerView: 1,
        spaceBetween: 10,
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>


</body></html>
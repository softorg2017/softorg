<!DOCTYPE html>
<!-- saved from url=(0068)http://demo.sc.chinaz.com//Files/DownLoad/webjs1/201406/jiaoben2495/ -->
<html>

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=GBK">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- IE testing -->
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">-->
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=9">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex">
        <title>jQuery</title>
        <link rel="stylesheet" type="text/css" href="{{asset('templates/themes/match-height/zzsc.css')}}">
        <script type="text/javascript" src="{{asset('templates/themes/match-height/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('templates/themes/match-height/jquery.matchHeight.js')}}"></script>
        <script type="text/javascript">
            (function() {

                /* matchHeight example */

                $(function() {
                    // apply your matchHeight on DOM ready (they will be automatically re-applied on load or resize)

                    // get test settings
                    var byRow = $('body').hasClass('test-rows');

                    // apply matchHeight to each item container's items
                    $('.items-container').each(function() {
                        $(this).children('.item').matchHeight(byRow);
                    });

                    // example of removing matchHeight
                    $('.test-remove').click(function() {
                        $('.items-container').each(function() {
                            $(this).children('.item').matchHeight('remove');
                        });
                    });
                });

            })();
        </script>
    </head>

    <body class="test-match-height test-rows test-responsive test-border-box test-margin test-padding">
        <div class="container">
            <div class="controls">
                <div class="checkbox">
                    <label>
                        <input class="option" type="checkbox" value="test-padding" checked="">
                        padding
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="option" type="checkbox" value="test-margin" checked="">
                        margin
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="option" type="checkbox" value="test-border" checked="">
                        border
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="option" type="checkbox" value="test-border-box" checked="">
                        border-box
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="option" type="checkbox" value="test-rows" checked="">
                        by row
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="test-remove" type="submit" value="remove matchHeight">
                    </label>
                </div>
            </div>

            <div class="items-container">
                <div class="item item-0" style="height: 157px;">
                    <h2>Lorem ipsum</h2>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam.</p>
                    <p>Aenean semper felis ipsum, vulputate consequat dui elementum vel.</p>
                </div>
                <div class="item item-1" style="height: 172px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis. Phasellus hendrerit erat sed porta imperdiet. Vivamus viverra ipsum tortor, et congue mauris porttitor ut.</p>
                </div>
                <div class="item item-2" style="height: 129px;">
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <p>Aenean semper felis ipsum, vulputate consequat dui elementum vel. Nullam odio eros, sagittis vitae lectus id, pretium viverra lectus. Etiam auctor dolor non dui ultricies pulvinar.</p>
                </div>

                <div class="item item-3" style="height: 100px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Aenean semper.</p>
                </div>
                <div class="item item-4" style="height: 136px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis.</p>
                </div>
                <div class="item item-5" style="height: 138px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Aenean semper felis ipsum, vulputate consequat dui elementum vel.</p>
                </div>
                <div class="item item-6" style="height: 140px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                </div>
                <div class="item item-7" style="height: 178px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam.</p>
                </div>

                <div class="item item-8" style="height: 107px;">
                    <img src="{{url('templates/themes/match-height/666')}}" alt="a test image">
                </div>
                <div class="item item-9" style="height: 120px;">
                    <img src="{{url('templates/themes/match-height/666(1)')}}" alt="a test image">
                </div>
                <div class="item item-10" style="height: 129px;">
                    <img src="{{url('templates/themes/match-height/666(2)')}}" alt="a test image">
                </div>
                <div class="item item-11" style="height: 138px;">
                    <img src="{{url('templates/themes/match-height/666(3)')}}" alt="a test image">
                </div>
            </div>

            <div class="items-container big-items">
                <div class="item item-0" style="height: 316px;">
                    <h3>Lorem ipsum dolor</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam.</p>
                    <p>Aenean semper felis ipsum, vulputate consequat dui elementum vel.</p>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis. Phasellus hendrerit erat sed porta imperdiet. Vivamus viverra ipsum tortor, et congue mauris porttitor ut.</p>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis.</p>
                </div>
                <div class="item item-1" style="height: 606px;">
                    <div class="items-container">
                        <div class="item item-2" style="height: 58px;">
                            <p>Aenean</p>
                        </div>
                        <div class="item item-3" style="height: 58px;">
                            <p>Lorem</p>
                        </div>
                        <div class="item item-4" style="height: 58px;">
                            <p>Phasellus</p>
                        </div>
                        <div class="item item-5" style="height: 96px;">
                            <p>Aenean semper felis ipsum, vulputate consequat dui elementum vel.</p>
                        </div>
                        <div class="item item-6" style="height: 116px;">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                        <div class="item item-7" style="height: 136px;">
                            <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-test-items">
                <div class="item item-0" data-match-height="items-a" style="height: 172px;">
                    <h3>data-match-height="items-a"</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis. Phasellus hendrerit erat sed porta imperdiet. Vivamus viverra ipsum tortor, et congue mauris porttitor ut.</p>
                </div>
                <div class="item item-1" data-match-height="items-a" style="height: 136px;">
                    <h3>data-match-height="items-a"</h3>
                    <p>Phasellus ut nibh fermentum, vulputate urna vel, semper diam. Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis.</p>
                </div>
                <div class="item item-2" data-mh="items-b" style="height: 100px;">
                    <h3>data-mh="items-b"</h3>
                    <p>In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis.</p>
                </div>
                <div class="item item-3" data-mh="items-b" style="height: 118px;">
                    <h3>data-mh="items-b"</h3>
                    <p>Nunc sollicitudin felis ut pellentesque fermentum. In erat mi, pulvinar sit amet tincidunt vitae, gravida id felis.</p>
                </div>
            </div>

            <div class="items-container fixed-items">
                <div class="item item-0" style="height: 150px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-1" style="height: 190px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-2" style="height: 230px;">
                    <p>Fixed height</p>
                </div>
                <div class="item item-3" style="height: 250px;">
                    <p>Fixed height</p>
                </div>
            </div>



        </div>

    </body>

</html>
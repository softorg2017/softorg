<!DOCTYPE HTML>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>@yield('head_title')</title>

        <meta name="author" content="@yield('meta_author')" />
        <meta name="title" content="@yield('meta_title')" />
        <meta name="description" content="@yield('meta_description')" />
        <meta name="keywords" content="@yield('meta_keywords')" />

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Styles -->
        {{--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CPoppins:400,600" rel="stylesheet">--}}

        <!-- favicon and touch icons -->
        <link rel="shortcut icon" type="image/ico" href="{{ url('favicon.ico') }}">
        <link rel="shortcut icon" type="image/png" href="{{ url('favicon.png') }}">

        <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
        <link rel="icon" sizes="any" mask href="/favicon-64.png">

        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-64.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-64.png">
        <link rel="icon" type="image/png" sizes="196x196" href="/favicon-64.png">

        <link rel="apple-touch-icon" sizes="60x60" href="/favicon-64.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon-64.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon-64.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon-64.png">
        <link rel="apple-touch-icon" sizes="160x160" href="/favicon-64.png">
        <link rel="apple-touch-icon" sizes="192x192" href="/favicon-64.png">


        <!-- Bootstrap -->
        <link href="{{ asset('/templates/moban2030/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2030/plugins/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2030/plugins/slick-nav/slicknav.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2030/plugins/wow/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2030/assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/templates/moban2030/assets/css/theme.css') }}" rel="stylesheet">
        <link href="https://cdn.bootcss.com/layer/3.0.3/skin/default/layer.min.css" rel="stylesheet">
        {{--<link href="https://cdn.bootcss.com/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css" rel="stylesheet">--}}
        <link href="https://cdn.bootcss.com/lightcase/2.5.0/css/lightcase.min.css" rel="stylesheet">

        {{--<link href="{{ asset('/templates/moban2030/assets/others/common.css') }}" rel="stylesheet">--}}
        <link href="{{ asset('/common/css/common.css') }}" rel="stylesheet">
        <link href="{{ asset('/common/css/frontend.css') }}" rel="stylesheet">
        <link href="{{ asset('/common/css/animate/hover.css') }}" rel="stylesheet" media="all" />
        <link href="{{ asset('/common/css/animate/wicked.css') }}" rel="stylesheet" media="all" />


        @yield('custom-css')
        @yield('custom-style')

        {{--<script>--}}
            {{--var _hmt = _hmt || [];--}}
            {{--(function() {--}}
                {{--var hm = document.createElement("script");--}}
                {{--hm.src = "https://hm.baidu.com/hm.js?db38c4f99dac05fe97e03f26eef0d213";--}}
                {{--var s = document.getElementsByTagName("script")[0];--}}
                {{--s.parentNode.insertBefore(hm, s);--}}
            {{--})();--}}
        {{--</script>--}}

        {{--<script>--}}
            {{--(function(b,a,e,h,f,c,g,s){b[h]=b[h]||function(){(b[h].c=b[h].c||[]).push(arguments)};--}}
                {{--b[h].s=!!c;g=a.getElementsByTagName(e)[0];s=a.createElement(e);--}}
                {{--s.src="//s.union.360.cn/"+f+".js";s.defer=!0;s.async=!0;g.parentNode.insertBefore(s,g)--}}
            {{--})(window,document,"script","_qha",271423,false);--}}
        {{--</script>--}}

    </head>
    <body class="">

        {{--<div id="page-loader">--}}
            {{--<div class="loaders">--}}
                {{--<img src="{{ url('/templates/moban2030/assets/images/loader/3.gif') }}" alt="First Loader">--}}
                {{--<img src="{{ url('/templates/moban2030/assets/images/loader/4.gif') }}" alt="First Loader">--}}
            {{--</div>--}}
        {{--</div>--}}


        {{--header--}}
        @yield('component-header')


        {{--content--}}
        @yield('custom-content')


        {{--footer--}}
        @yield('component-footer')


        {{--bottom--}}
        {{--@include('frontend.component.bottom')--}}


        <a href="#top" id="scroll-top"><i class="fa fa-angle-up"></i></a>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('/templates/moban2030/assets/js/jquery.min.js') }}"></script>
        {{--<script src="{{ asset('/templates/moban2030/assets/js/jquery.migrate.js') }}"></script>--}}
        <script src="{{ asset('/templates/moban2030/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2030/plugins/slick-nav/jquery.slicknav.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2030/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2030/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        {{--<script src="{{ asset('/templates/moban2030/plugins/tweetie/tweetie.js') }}"></script>--}}
        <script src="{{ asset('/templates/moban2030/plugins/forms/jquery.form.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2030/plugins/forms/jquery.validate.min.js') }}"></script>
{{--        <script src="{{ asset('/templates/moban2030/plugins/modernizr/modernizr.custom.js') }}"></script>--}}
        <script src="{{ asset('/templates/moban2030/plugins/wow/wow.min.js') }}"></script>
        <script src="{{ asset('/templates/moban2030/plugins/zoom/zoom.js') }}"></script>
{{--        <script src="{{ asset('/templates/moban2030/plugins/mixitup/mixitup.min.js') }}"></script>--}}
        <!---<script src="http://ditu.google.cn/maps/api/js?key=AIzaSyD2MtZynhsvwI2B40juK6SifR_OSyj4aBA&libraries=places"></script>--->
{{--        <script src="{{ asset('/templates/moban2030/plugins/whats-nearby/source/WhatsNearby.js') }}"></script>--}}
        <script src="{{ asset('/templates/moban2030/assets/js/theme.js') }}"></script>
        <script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
        {{--<script src="https://cdn.bootcss.com/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>--}}
        <script src="https://cdn.bootcss.com/lightcase/2.5.0/js/lightcase.min.js"></script>

        <script src="{{ asset('/templates/moban2030/assets/others/common.js') }}"></script>


        <script src="{{ asset('/common/js/frontend.js') }}"></script>


        <script>
            $(function() {

                $("#bottom-bm-close").on('click', function () {
                    $('#bottom-bm-container').slideUp();
                });

                // 预约
                $("#btnSubmit").on('click', function() {

                    var form = $("#form-book-appointment");
                    var name = $("#book-name");
                    var name_val = name.val();
                    var mobile = $("#book-mobile");
                    var mobile_val = mobile.val();


                    if(name_val == "")
                    {
                        layer.msg("名字不能为空");
                        name.focus();
                        return false;
                    }

                    var filter=/^1[3|4|5|7|8][0-9]\d{8}$/;
                    if(!filter.test(mobile_val))
                    {
                        layer.msg("请输入正确的手机号!");
                        mobile.focus();
                        mobile.value="";
                        return false;
                    }

                    var options = {
                        url: "{{url('/message/grab/yy')}}",
                        type: "post",
                        dataType: "json",
                        // target: "#div2",
                        success: function (data) {
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg(data.msg);
                                name.val('');
                                mobile.val('');
                                {{--location.href = "{{url('/admin/item/list')}}";--}}
                                    return true;
                            }
                        }
                    };
                    form.ajaxSubmit(options);
                });


                // 抢专车券
                $("#grab-zc-submit").on('click', function() {

                    var form = $("#form-grab-zc");
                    var mobile = $("#grab-zc-mobile");
                    var mobile_val = mobile.val();

                    var filter=/^1[3|4|5|7|8][0-9]\d{8}$/;
                    if(!filter.test(mobile_val))
                    {
                        layer.msg("请输入正确的手机号!");
                        mobile.focus();
                        mobile.val('');
                        return false;
                    }

                    var options = {
                        url: "{{url('/message/grab/zc')}}",
                        type: "post",
                        dataType: "json",
                        // target: "#div2",
                        success: function (data) {
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg(data.msg);
                                mobile.val('');
                                {{--location.href = "{{url('/admin/item/list')}}";--}}
                                $('#grab-modal').modal('hide');
                                $('.modal-backdrop').hide();
                                return true;
                            }
                        }
                    };
                    form.ajaxSubmit(options);
                });


                // 询价
                $("#grab-item-submit").on('click', function() {

                    var form = $("#form-grab-item");
                    var name = $("grab-item-name");
                    var name_val = name.val();
                    var mobile = $("#grab-item-mobile");
                    var mobile_val = mobile.val();

                    if(name_val == "")
                    {
                        layer.msg("名字不能为空");
                        name.focus();
                        return false;
                    }

                    var filter=/^1[3|4|5|7|8][0-9]\d{8}$/;
                    if(!filter.test(mobile_val))
                    {
                        layer.msg("请输入正确的手机号!");
                        mobile.focus();
                        mobile.val('');
                        return false;
                    }

                    var options = {
                        url: "{{url('/message/grab/item')}}",
                        type: "post",
                        dataType: "json",
                        // target: "#div2",
                        success: function (data) {
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg(data.msg);
                                mobile.val('');
                                {{--location.href = "{{url('/admin/item/list')}}";--}}
                                $('#grab-modal').modal('hide');
                                $('.modal-backdrop').hide();
                                return true;
                            }
                        }
                    };
                    form.ajaxSubmit(options);
                });



                $("#grab-modal").on('click', '.icon-close', function () {
                    $('#grab-modal').hide();
                    $('#grab-modal').modal('hide');
                    $('.modal-backdrop').hide();
                });

            });
        </script>


        @yield('custom-js')
        @yield('custom-script')



    </body>
</html>

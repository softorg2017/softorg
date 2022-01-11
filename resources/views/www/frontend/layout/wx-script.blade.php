<script>

    var wx_config = {!! $wx_config or '' !!};

    console.log(wx_config.cache);

    var timestamp = Date.parse(new Date());
    var time = Date.parse(new Date());
//    console.log(timestamp / 1000 - wx_config.timestamp);
//    console.log(new Date(wx_config.timestamp * 1000).toLocaleString());

    $(function()
    {
//        var link = window.location.href;
        var link = location.href.split('#')[0];
        console.log(link);

        if(typeof wx != "undefined") wxFn();

        function wxFn() {

            wx.config({
                debug: false,
                appId: wx_config.app_id, // 必填，公众号的唯一标识
                timestamp: wx_config.timestamp, // 必填，生成签名的时间戳
                nonceStr: wx_config.nonce_str, // 必填，生成签名的随机串
                signature: wx_config.signature, // 必填，签名，见附录1
                jsApiList: [
                    'checkJsApi',
//                    'updateAppMessageShareData',
//                    'updateTimelineShareData',
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });

            wx.checkJsApi({
                jsApiList: [
                    'checkJsApi',
//                    'updateAppMessageShareData',
//                    'updateTimelineShareData',
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                success: function(res) {
                    // 以键值对的形式返回，可用的api值true，不可用为false
                    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                }
            });


            {{--wx.ready(function () {   //需在用户可能点击分享按钮前就先调用--}}

            {{--wx.updateAppMessageShareData({--}}
            {{--title: "@yield('wx_share_title')", // 分享标题--}}
            {{--desc: "@yield('wx_share_desc')", // 分享描述--}}
            {{--link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致--}}
            {{--imgUrl: $.trim("@yield('wx_share_imgUrl')"), // 分享图标--}}
            {{--success: function () {--}}
            {{--// 用户点击了分享后执行的回调函数--}}
            {{--console.log("updateAppMessageShareData");--}}
            {{--$.post(--}}
            {{--"/record/share",--}}
            {{--{--}}
            {{--'_token': $('meta[name="_token"]').attr('content'),--}}
            {{--'record_module': 1,--}}
            {{--'page_type': "{{ $page["type"] or '0' }}",--}}
            {{--'page_module': "{{ $page["module"] or '0' }}",--}}
            {{--'page_num': "{{ $page["num"] or '1' }}",--}}
            {{--'item_id': "{{ $page["item_id"] or '0' }}",--}}
            {{--'user_id': "{{ $page["user_id"] or '0' }}"--}}
            {{--},--}}
            {{--function(data) {--}}
            {{--if(!data.success) layer.msg(data.msg);--}}
            {{--},--}}
            {{--'json');--}}
            {{--}--}}
            {{--});--}}
            {{--wx.updateTimelineShareData({--}}
            {{--title: "@yield('wx_share_title')",--}}
            {{--desc: "@yield('wx_share_desc')",--}}
            {{--link: link,--}}
            {{--imgUrl: $.trim("@yield('wx_share_imgUrl')"),--}}
            {{--success: function () {--}}
            {{--// 用户点击了分享后执行的回调函数--}}
            {{--console.log("updateTimelineShareData");--}}
            {{--$.post(--}}
            {{--"/record/share",--}}
            {{--{--}}
            {{--'_token': $('meta[name="_token"]').attr('content'),--}}
            {{--'record_module': 2,--}}
            {{--'page_type': "{{ $page["type"] or '0' }}",--}}
            {{--'page_module': "{{ $page["module"] or '0' }}",--}}
            {{--'page_num': "{{ $page["num"] or '1' }}",--}}
            {{--'item_id': "{{ $page["item_id"] or '0' }}",--}}
            {{--'user_id': "{{ $page["user_id"] or '0' }}"--}}
            {{--},--}}
            {{--function(data) {--}}
            {{--if(!data.success) layer.msg(data.msg);--}}
            {{--},--}}
            {{--'json');--}}
            {{--}--}}
            {{--});--}}

            {{--});--}}

            //            wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
            //            });

            wx.ready(function() {

                wx.onMenuShareAppMessage({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 1,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareTimeline({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 2,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareQQ({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 1,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareQZone({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 2,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareWeibo({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        // 用户点击了分享后执行的回调函数
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });

            });
        }
    });

</script>
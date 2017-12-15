@extends('front.'.config('common.view.front.detail').'.layout.detail')

@section('website-name',$data->org->website_name)

{{--分享内容--}}
@section('share_title')【活动】{{$data->title or ''}}@endsection
@section('share_desc'){{$data->description or ''}}@endsection
@section('share_img')http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$data->org->logo or ''}}@endsection

@section('title')
    活动 - {{$data->title or ''}}
@endsection
@section('header','活动')
@section('description','活动')

@section('detail-name','活动')

@section('data-activit-time')
    <p style="margin:8px 0;">
        活动时间：<b>{{date("Y/n/j H:i",$data->start_time)}} - {{date("Y/n/j H:i",$data->end_time)}}</b>
    </p>

    {{--报名--}}
    @if($data->is_apply == 1)
        <p style="margin:8px 0;">
            报名时间：<b>{{date("Y/n/j H:i",$data->apply_start_time)}} - {{date("Y/n/j H:i",$data->apply_end_time)}}</b>

            @if(time() < $data->apply_start_time)
                （报名未开始）
            @elseif(time() >= $data->apply_start_time  && time() < $data->apply_end_time)
                （报名中） <a href="#apply-entrance">进入报名</a>
            @else
                （报名已结束）
            @endif
        </p>
    @endif

    {{--签到--}}
    @if($data->is_sign == 1)
        <p style="margin:8px 0;">
            签到时间：<b>{{date("Y/n/j H:i",$data->sign_start_time)}} - {{date("Y/n/j H:i",$data->sign_end_time)}}</b>

            @if(time() < $data->sign_start_time)
                （签到未开始）
            @elseif(time() >= $data->sign_start_time  && time() < $data->sign_end_time)
                （签到中） <a href="#sign-entrance">进入签到</a>
            @else
                （签到已结束）
            @endif
        </p>
    @endif
@endsection

@section('data-updated_at')
    {{date("Y-n-j H:i",strtotime($data->updated_at))}}
@endsection

@section('data-visit')
    阅读 {{$data->visit_num or ''}} &nbsp;
@endsection

@section('data-title')
    {{$data->title or ''}}
@endsection

@section('data-content')
    {!! $data->content or '' !!}
@endsection



@section('content')
    {{--4栏--}}
    <div class="row full wrapper-content product-column product-four-column slide-to-top">
        <div class="col-md-14">

            <input type="hidden" id="encode_id" value="{{$encode_id or 0}}">

            <div class="row full">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    <h2>{{$data->title or ''}}</h2>
                    <div class="text">@yield('data-updated_at') <span style="float: right;">@yield('data-visit')</span></div>
                    <div style="margin:16px 0;font-size:16px;">
                        @yield('data-activit-time')
                    </div>
                    <div class="text">{!! $data->content or '' !!}</div>
                </div>
            </div>

            <div class="row full" id="apply-entrance">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    &nbsp;
                </div>
            </div>

            @if(time() >= $data->apply_start_time  && time() < $data->apply_end_time)

                <div class="row full" style="margin-top:64px; border-top:1px solid #eee">
                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <h4><b>* 报名（注册用户通道）</b></h4>
                    </div>

                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <div class="row">
                            <button type="button" class="btn btn-primary" id="activity-apply-submit"><i class="fa fa-check"></i> 注册用户报名</button>
                            {{--<button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>--}}
                        </div>
                    </div>
                </div>

                <div class="row full" style="margin-top:32px;">

                    <form method="POST" action="" id="form-activity-apply">
                        <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3" style="border-top:1px solid #eee">

                            <h4><b>* 报名（非注册用户通道）</b></h4>

                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$encode_id or 0}}">
                            <input type="hidden" name="type" value="1">

                            {{--描述--}}
                            <div class="form-group">
                                <div class="row"><b>姓名</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row"><b>手机</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="mobile" value="">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<div class="row"><b>手机验证码</b></div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="row">--}}
                                    {{--<input type="text" class="form-control" name="mobile_vertification" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="row"><b>邮箱</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="email" value="">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<div class="row"><b>邮箱验证码</b></div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="row">--}}
                                    {{--<input type="text" class="form-control" name="email_vertification" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </form>

                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <div class="row">
                            <button type="button" class="btn btn-primary" id="activity-apply-mobile-submit"><i class="fa fa-check"></i> 非注册用户报名</button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row full" id="sign-entrance">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    &nbsp;
                </div>
            </div>

            @if(time() >= $data->sign_start_time  && time() < $data->sign_end_time)

                <div class="row full" style="margin-top:64px; border-top:1px solid #eee">
                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <h4><b>* 签到（注册用户）</b></h4>
                    </div>

                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <div class="row">
                            <button type="button" class="btn btn-success" id="activity-sign-submit"><i class="fa fa-check"></i> 注册用户签到</button>
                            {{--<button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>--}}
                        </div>
                    </div>
                </div>

                <div class="row full" style="margin-top:32px;">

                    <form method="POST" action="" id="form-activity-sign">
                        <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3" style="border-top:1px solid #eee">

                            <h4><b>* 签到（非注册用户）</b></h4>

                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$encode_id or 0}}">
                            <input type="hidden" name="type" value="1">

                            {{--描述--}}
                            <div class="form-group">
                                <div class="row"><b>姓名</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="name" value="">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<div class="row"><b>手机</b></div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="row">--}}
                                    {{--<input type="text" class="form-control" name="mobile" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="row"><b>手机验证码</b></div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="row">--}}
                                    {{--<input type="text" class="form-control" name="vertification" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="row"><b>邮箱</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="email" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row"><b>签到密码</b></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input type="text" class="form-control" name="vertification" value="">
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                        <div class="row">
                            <button type="button" class="btn btn-success" id="activity-sign-mobile-submit"><i class="fa fa-check"></i> 非注册用户签到</button>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection


@section('js')
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(function () {


            // 活动报名（注册用户）
            $("#activity-apply-submit").on('click', function() {
                $.post(
                    '/apply',
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        type: 2,
                        id: $("#encode_id").val()
                    },
                    function(data)
                    {
                        if(!data.success) layer.msg(data.msg);
                        else layer.msg("报名成功");
                    },
                    'json');
            });
            // 活动报名（非注册用户）
            $("#activity-apply-mobile-submit").on('click', function() {
                var form = $("#form-activity-apply");
                var options = {
                    url: "/apply",
                    type: "post",
                    dataType: "json",
                    // target: "#div2",
                    success: function (data) {
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            form.find("input:text").val("");
                            layer.msg("报名成功");
                        }
                    }
                };
                form.ajaxSubmit(options);
            });



            // 活动签到（注册用户）
            $("#activity-sign-submit").on('click', function() {
                $.post(
                    '/sign',
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        type: 2,
                        id: $("#encode_id").val()
                    },
                    function(data)
                    {
                        if(!data.success) layer.msg(data.msg);
                        else layer.msg("报名成功");
                    },
                    'json');
            });
            // 活动签到（非注册用户）
            $("#activity-sign-mobile-submit").on('click', function() {
                var form = $("#form-activity-sign");
                var options = {
                    url: "/sign",
                    type: "post",
                    dataType: "json",
                    // target: "#div2",
                    success: function (data) {
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            form.find("input:text").val("");
                            layer.msg("签到成功");
                        }
                    }
                };
                form.ajaxSubmit(options);
            });

        })
    </script>
@endsection

@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未轻博' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header') {{ $item->title or '' }} @endsection
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-item">
        <div class="main-body-left-container bg-white">


            <div class="box box-info form-container">

                <div class="box-header with-border" style="margin:16px 0;">
                    <h3 class="box-title"> {{ $title_text or '' }} </h3>
                </div>

                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
                    <div class="box-body">

                        {{ csrf_field() }}
                        <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
                        <input type="hidden" name="operate_id" value="{{ $operate_id or 0 }}" readonly>
                        <input type="hidden" name="operate_category" value="{{ $operate_category or 'item' }}" readonly>
                        <input type="hidden" name="operate_type" value="{{ $operate_type or 'item' }}" readonly>

                        {{--类别--}}
                        <div class="form-group form-category">
                            <label class="control-label col-md-2 _none">类别</label>
                            <div class="col-md-12 ">
                                <div class="btn-group">

                                    @if($operate == 'edit')
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="{{ $data->item_type or 0 }}" checked="checked">
                                                @if($data->item_type == 1) 文章
                                                @elseif($data->item_type == 9) 活动
                                                @elseif($data->item_type == 11) 书目
                                                @elseif($data->item_type == 18) 时间线
                                                @elseif($data->item_type == 22) 辩题
                                                @elseif($data->item_type == 29) 投票
                                                @endif
                                            </label>
                                        </button>
                                    @elseif($operate == 'create')
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="1" checked="checked"> 文章
                                            </label>
                                        </button>
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="9"> 活动
                                            </label>
                                        </button>
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="11"> 书目
                                            </label>
                                        </button>
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="18"> 时间线
                                            </label>
                                        </button>
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="22"> 辩题
                                            </label>
                                        </button>
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="item_type" value="29"> 投票
                                            </label>
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>


                        {{--时间选择器--}}
                        <div class="form-group activity-show time-show" style="display:none;">
                            <label class="control-label- col-md-2 _none-"><sup class="text-red">*</sup> 选择时间</label>
                            <div class="col-md-12 ">
                                <div class="col-md-6" style="padding-left:0;">
                                    <input type="text" readonly- class="form-control" name="start" placeholder="选择开始时间" value="@if(!empty($data->start_time)){{ date("Y-m-d H:i",$data->start_time) }}@endif">
                                </div>
                                <div class="col-md-6" style="padding-right:0;">
                                    <input type="text" readonly- class="form-control" name="end" placeholder="选择结束时间" value="@if(!empty($data->end_time)){{ date("Y-m-d H:i",$data->end_time) }}@endif">
                                </div>
                            </div>
                        </div>

                        {{--标题--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2"><sup class="text-red">*</sup> 标题</label>
                            <div class="col-md-12 ">
                                <div><input type="text" class="form-control" name="title" placeholder="请输入标题，必填" value="{{ $data->title or '' }}"></div>
                            </div>
                        </div>
                        {{--描述--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">描述</label>
                            <div class="col-md-12 ">
                                <textarea class="form-control" name="description" rows="3" placeholder="描述">{{ $data->description or '' }}</textarea>
                            </div>
                        </div>


                        {{--辩题--}}
                        <div class="form-group debate-show" style="display:none;">
                            <label class="control-label col-md-2 _none"><sup class="text-red">*</sup> 正方观点</label>
                            <div class="col-md-12 ">
                                <div><input type="text" class="form-control" name="custom[positive]" placeholder="正方观点，必填" value="{{ $data->custom->positive or '' }}"></div>
                            </div>
                        </div>
                        <div class="form-group debate-show" style="display:none;">
                            <label class="control-label col-md-2 _none"><sup class="text-red">*</sup> 反方观点</label>
                            <div class="col-md-12 ">
                                <div><input type="text" class="form-control" name="custom[negative]" placeholder="反方观点，必填" value="{{ $data->custom->negative or '' }}"></div>
                            </div>
                        </div>


                        {{--内容--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">图文详情</label>
                            <div class="col-md-12 ">
                                <div>
                                @include('UEditor::head')
                                <!-- 加载编辑器的容器 -->
                                    <script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>
                                    <!-- 实例化编辑器 -->
                                    <script type="text/javascript">
                                        var ue = UE.getEditor('container');
                                        ue.ready(function() {
                                            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        {{--cover 封面图片--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">封面图片</label>
                            <div class="col-md-12 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if(!empty($data->cover_pic))
                                            <img src="{{ url(env('DOMAIN_CDN').'/'.$data->cover_pic) }}" alt="" />
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                    </div>
                                    <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="cover" />
                                </span>
                                        <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                                    </div>
                                </div>
                                <div id="titleImageError" style="color: #a94442"></div>

                            </div>
                        </div>

                        {{--@if($operate == 'create')--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="control-label col-md-2">待办事</label>--}}
                        {{--<div class="col-md-12">--}}
                        {{--<div class="btn-group">--}}
                        {{--<button type="button" class="btn checkbox">--}}
                        {{--<label>--}}
                        {{--<input type="checkbox" name="is_working" value="1"> 添加到我的待办事--}}
                        {{--</label>--}}
                        {{--</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@endif--}}

                        {{--分享--}}
                        @if($operate == 'create')
                            <div class="form-group form-typ ">
                                <label class="control-label- col-md-2">分享</label>
                                <div class="col-md-12">
                                    <div class="btn-group">

                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="is_shared" value="11" checked="checked"> 仅自己可见
                                            </label>
                                        </button>
                                        {{--<button type="button" class="btn radio">--}}
                                        {{--<label>--}}
                                        {{--<input type="radio" name="is_shared" value="41"> 关注可见--}}
                                        {{--</label>--}}
                                        {{--</button>--}}
                                        <button type="button" class="btn radio">
                                            <label>
                                                <input type="radio" name="is_shared" value="100"> 所有人可见
                                            </label>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </form>

                <div class="box-footer">
                    <div class="row-" style="margin:16px 0-;">
                        <div class="col-md-12 col-md-offset-2-">
                            <button type="button" class="btn btn-primary" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                            <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <div class="main-body-section main-body-right-section section-wrapper">
        <div class="main-body-right-container fixed-to-top">

            @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-user', ['data'=>$item->owner])--}}
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-user', ['data'=>$user])--}}

        </div>
    </div>


    <div class="main-body-section main-body-right-section section-wrapper pull-right" style="clear:right;">

        {{--@if(!empty($user->ad))--}}
        {{--<div class="item-row margin-top-4px margin-bottom-2px pull-right">--}}
        {{--<strong>Ta的贴片广告</strong>--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-ad-paste', ['item'=>$user->ad])--}}

        {{--@if(count($user->pivot_sponsor_list))--}}
        {{--<div class="item-row margin-top-16px margin-bottom-2px pull-right">--}}
        {{--<strong>Ta的赞助商</strong>--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-sponsor', ['sponsor_list'=>$user->pivot_sponsor_list])--}}

    </div>

</div>
@endsection


@section('js')
<script>
    $(function() {

        var $item_type = $("input[name=item_type]").val();
        if($item_type == 9)
        {
            $('.activity-show').show();
            $('.time-show').show();
        }
        else if($item_type == 22)
        {
            $('.debate-show').show();
        }

        // 提交
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "/item/item-edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/mine/item-mine";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });


        // 【选择类别】
        $("#form-edit-item").on('click', "input[name=item_type]", function() {

            var $value = $(this).val();

            if($value == 9) {
                $('.activity-show').show();
                $('.time-show').show();

                // checkbox
//                if($("input[name=time_type]").is(':checked')) {
//                    $('.time-show').show();
//                } else {
//                    $('.time-show').hide();
//                }
                // radio
//                var $time_type = $("input[name=time_type]:checked").val();
//                if($time_type == 1) {
//                    $('.time-show').show();
//                } else {
//                    $('.time-show').hide();
//                }
            } else {
                $('.activity-show').hide();
            }

            if($value == 22) {
                $('.debate-show').show();
            } else {
                $('.debate-show').hide();
            }

        });


        // 【选择时间】
        $("#form-edit-item").on('click', "input[name=time_type]", function() {
            // checkbox
//            if($(this).is(':checked')) {
//                $('.time-show').show();
//            } else {
//                $('.time-show').hide();
//            }
            // radio
            var $value = $(this).val();
            if($value == 1) {
                $('.time-show').show();
            } else {
                $('.time-show').hide();
            }
        });


        $('input[name=start]').datetimepicker({
            format:"YYYY-MM-DD HH:mm"
        });
        $('input[name=end]').datetimepicker({
            format:"YYYY-MM-DD HH:mm"
        });

    });
</script>
@endsection

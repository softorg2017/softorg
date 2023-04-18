@extends(env('TEMPLATE_SUPER_ADMIN').'layout.layout')


@section('head_title')
    【Super】{{ $title_text }}
@endsection


@section('header', '')
@section('description', '超级管理员系统  - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/admin') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{ url($list_link) }}"><i class="fa fa-list"></i>{{ $list_text or '内容列表' }}</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">{{ $title_text or '' }}</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
                <div class="box-body">

                    {{csrf_field()}}
                    <input type="hidden" name="operate" value="{{ $operate or '' }}" readonly>
                    <input type="hidden" name="operate_id" value="{{ $operate_id or 0 }}" readonly>
                    <input type="hidden" name="category" value="{{ $category or 'item' }}" readonly>
                    <input type="hidden" name="type" value="{{ $type or 'item' }}" readonly>


                    {{--类别--}}
                    <div class="form-group form-category">
                        <label class="control-label col-md-2">类别</label>
                        <div class="col-md-8">
                            <div class="btn-group">

                                @if($operate == 'edit')
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="{{ $data->district_type or 0 }}" checked="checked">
                                                @if($data->district_type == 1) 国家
                                                @elseif($data->district_type == 2) 省
                                                @elseif($data->district_type == 3) 市
                                                @elseif($data->district_type == 4) 区/县
                                                @elseif($data->district_type == 21) 街道
                                                @elseif($data->district_type == 31) 社区
                                                @elseif($data->district_type == 41) 住宅小区
                                                @endif
                                            </label>
                                        </span>
                                    </button>
                                @elseif($operate == 'create')
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="2" checked="checked"> 省
                                            </label>
                                        </span>
                                    </button>
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="3"> 市
                                            </label>
                                        </span>
                                    </button>
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="4"> 区/县
                                            </label>
                                        </span>
                                    </button>
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="21"> 街道
                                            </label>
                                        </span>
                                    </button>
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="31"> 社区
                                            </label>
                                        </span>
                                    </button>
                                    <button type="button" class="btn">
                                        <span class="radio">
                                            <label>
                                                <input type="radio" name="district_type" value="41"> 住宅小区
                                            </label>
                                        </span>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>

                    {{--目录--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">所属</label>
                        <div class="col-md-8 ">
                            <select class="form-control" name="select2_parent_id" id="select2_parent">

                                @if($operate == 'edit')
                                    @if($data->parent)
                                        <option data-id="{{ $data->parent_id }}" value="{{ $data->parent_id }}">{{ $data->parent->name }}</option>
                                    @else
                                        <option data-id="0" value="0">未指定</option>
                                    @endif
                                @elseif($operate == 'create')
                                    <option data-id="0" value="0">未指定</option>
                                @endif
                                {{--@if(!empty($data->menu_id))--}}
                                {{--@foreach($menus as $v)--}}
                                {{--<option data-id="{{$v->id}}" @if($data->menu_id == $v->id) selected="selected" @endif>{{$v->title}}</option>--}}
                                {{--@endforeach--}}
                                {{--@else--}}
                                {{--@foreach($menus as $v)--}}
                                {{--<option data-id="{{$v->id}}">{{$v->title}}</option>--}}
                                {{--@endforeach--}}
                                {{--@endif--}}
                            </select>
                            {{--<input type="hidden" value="{{ $data->parent_id or 0 }}" name="parent_id" id="parent_id">--}}
                        </div>
                    </div>
                    {{--目录--}}
                    <div class="form-group _none">
                        <label class="control-label col-md-2">添加目录</label>
                        <div class="col-md-8 ">
                            <select name="select2_menus[]" id="select2_menus" multiple="multiple" style="width:100%;">
                                <option data-id="0">未分类</option>
                            </select>
                        </div>
                    </div>


                    {{--名称--}}
                    <div class="form-group">
                        <label class="control-label col-md-2"><sup class="text-red">*</sup> 名称</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="name" placeholder="名称" value="{{ $data->name or '' }}">
                        </div>
                    </div>

                    {{--编号--}}
                    <div class="form-group">
                        <label class="control-label col-md-2"><sup class="text-red">*</sup> 行政区划代码</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="district_number" placeholder="行政区划代码" value="{{ $data->district_number or '' }}">
                        </div>
                    </div>
                    {{--邮编--}}
                    <div class="form-group">
                        <label class="control-label col-md-2"><sup class="text-red">*</sup> 邮编</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="postcode" placeholder="编号" value="{{ $data->postcode or '' }}">
                        </div>
                    </div>
                    {{--电话区号--}}
                    <div class="form-group">
                        <label class="control-label col-md-2"><sup class="text-red">*</sup> 电话区号</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="area_code" placeholder="电话区号" value="{{ $data->area_code or '' }}">
                        </div>
                    </div>

                    {{--内容--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label col-md-2">内容详情</label>--}}
                        {{--<div class="col-md-8 ">--}}
                            {{--<div>--}}
                            {{--@include('UEditor::head')--}}
                            {{--<!-- 加载编辑器的容器 -->--}}
                                {{--<script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>--}}
                                {{--<!-- 实例化编辑器 -->--}}
                                {{--<script type="text/javascript">--}}
                                    {{--var ue = UE.getEditor('container');--}}
                                    {{--ue.ready(function() {--}}
                                        {{--ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');  // 此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}
                                    {{--});--}}
                                {{--</script>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--多图展示--}}
                    <div class="form-group _none">
                        <label class="control-label col-md-2">多图展示</label>
                        <div class="col-md-8 fileinput-group">
                            @if(!empty($data->custom2))
                                @foreach($data->custom2 as $img)
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ url(env('DOMAIN_CDN').'/'.$img->img) }}" alt="" />
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            @endif
                        </div>

                        <div class="col-md-8 col-md-offset-2 ">
                            <input id="multiple-images" type="file" class="file-" name="multiple_images[]" multiple >
                        </div>
                    </div>

                    {{--cover 封面图片--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">封面图片</label>
                        <div class="col-md-8 fileinput-group">

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

                    {{--attachment 附件--}}
                    <div class="form-group _none">
                        <label class="control-label col-md-2">附件</label>
                        <div class="col-md-8 fileinput-group">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <a target="_blank" href="/all/download-item-attachment?item-id={{ $data->id or 0 }}">
                                        {{ $data->attachment_name or '' }}
                                    </a>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail">
                                </div>
                                <div class="btn-tool-group">
                            <span class="btn-file">
                                <button class="btn btn-sm btn-primary fileinput-new">选择附件</button>
                                <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                <input type="file" name="attachment" />
                            </span>
                                    <span class="">
                                <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                            </span>
                                </div>
                            </div>
                            <div id="titleImageError" style="color: #a94442"></div>

                        </div>
                    </div>

                </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('custom-css')
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/select2/4.0.5/css/select2.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/select2-4.0.5.min.css') }}">
@endsection


@section('custom-script')
    {{--<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>--}}
    <script src="{{ asset('/lib/js/select2-4.0.5.min.js') }}"></script>
    <script>
        $(function() {

            $("#multiple-images").fileinput({
                allowedFileExtensions : [ 'jpg', 'jpeg', 'png', 'gif' ],
                showUpload: false
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
                locale: moment.locale('zh-cn'),
                format:"YYYY-MM-DD HH:mm"
            });
            $('input[name=end]').datetimepicker({
                locale: moment.locale('zh-cn'),
                format:"YYYY-MM-DD HH:mm"
            });

            // 添加or编辑
            $("#edit-item-submit").on('click', function() {
                var options = {
                    url: "{{ url('/admin/district/district-edit') }}",
                    type: "post",
                    dataType: "json",
                    // target: "#div2",
                    success: function (data) {
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.msg(data.msg);
                            location.href = "{{ url('/admin/district/district-list-for-all') }}";
                        }
                    }
                };
                $("#form-edit-item").ajaxSubmit(options);
            });

            $('#select2_parent').select2({
                ajax: {
                    url: "{{ url('/admin/district/district_select2_parent') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            type: $("input[name=district_type]:checked").val(), // search term
                            keyword: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {

                        params.page = params.page || 1;
//                    console.log(data);
                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 0,
                theme: 'classic'
            });
            {{--$('#select2_parent').val(['{{ $data->parent_id }}']).trigger('change');--}}

        });
    </script>
@endsection

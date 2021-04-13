@extends(env('TEMPLATE_DOC_ATOM').'layout.layout')


@section('head_title')
    {{ $title_text }} - 原子系统 - 如未科技
@endsection


@section('header', '')
@section('description', '原子系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/admin') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{ url($list_link) }}"><i class="fa fa-list"></i>{{ $list_text or '内容列表' }}</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
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


                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2"><sup class="text-red">*</sup> 名称</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="name" placeholder="名称" value="{{ $data->name or '' }}">
                    </div>
                </div>
                {{--标签--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标签</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="tag" placeholder="标签" value="{{ $data->tag or '' }}">
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <textarea class="form-control" name="description" rows="3" placeholder="描述">{{$data->description or ''}}</textarea>
                    </div>
                </div>

                {{--类别--}}
                <div class="form-group">
                    <label class="control-label col-md-2">类别</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="atom_category" placeholder="类别" value="{{ $data->atom_category or '' }}">
                    </div>
                </div>
                {{--作者--}}
                <div class="form-group">
                    <label class="control-label col-md-2">添加作者</label>
                    <div class="col-md-8 ">
                        <select name="peoples[]" id="people" data-tags="true" multiple="multiple" multiple style="width:100%;">
                            {{--<option value="{{  $data->people_id or 0 }}">{{  $data->people->name or '请选择作者' }}</option>--}}
                            @if(!empty($data->pivot_product_people))
                                @foreach($data->pivot_product_people as $p)
                                    <option value="{{ $p->id }}" selected="selected">{{ $p->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                {{--时间--}}
                <div class="form-group">
                    <label class="control-label col-md-2">时间</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="birth_time" placeholder="时间" value="{{ $data->birth_time or '' }}">
                    </div>
                </div>

                {{--链接地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">链接地址</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="link_url" placeholder="链接地址" value="{{ $data->link_url or '' }}">
                    </div>
                </div>

                {{--目录--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">目录</label>
                    <div class="col-md-8 ">
                        <select class="form-control" onchange="select_menu()">
                            <option data-id="0">未分类</option>
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
                        <input type="hidden" value="{{ $data->menu_id or 0 }}" name="menu_id-" id="menu-selected">
                    </div>
                </div>
                {{--目录--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">添加目录</label>
                    <div class="col-md-8 ">
                        <select name="menus[]" id="menus" multiple="multiple" style="width:100%;">
                            {{--<option value="{{$data->people_id or 0}}">{{$data->people->name or '请选择作者'}}</option>--}}
                        </select>
                    </div>
                </div>

                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">内容详情</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');  // 此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                            </script>
                        </div>
                    </div>
                </div>

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

                {{--启用--}}
                @if($operate == 'create')
                    <div class="form-group form-type _none">
                        <label class="control-label col-md-2">启用</label>
                        <div class="col-md-8">
                            <div class="btn-group">

                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="active" value="0" checked="checked"> 暂不启用
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="active" value="1"> 启用
                                        </label>
                                    </div>
                                </button>

                            </div>
                        </div>
                    </div>
                @endif

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
@include(env('TEMPLATE_DOC_ATOM').'entrance.item.item-edit-script')
@endsection

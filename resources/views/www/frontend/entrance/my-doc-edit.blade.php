@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title','编辑名片 - 如未科技')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




@section('sidebar')
    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar.sidebar-root')
@endsection
@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-root">
        <div class="main-body-left-container bg-white">

            <div class="box box-info form-container">

                <div class="box-header with-border" style="margin:8px 0;">
                    <h3 class="box-title"> {{ $title_text or '' }} </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>

                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-my-doc">
                    <div class="box-body">

                        {{ csrf_field() }}
                        <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
                        <input type="hidden" name="operate_id" value="{{ $operate_id or 0 }}" readonly>
                        <input type="hidden" name="operate_category" value="{{ $operate_category or 'user' }}" readonly>
                        <input type="hidden" name="operate_type" value="{{ $operate_type or 'user' }}" readonly>

                        {{--名称--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">轻博名</label>
                            <div class="col-md-12 ">
                                <input type="text" class="form-control" name="username" placeholder="请输入轻博名" value="{{ $data->username or '' }}">
                            </div>
                        </div>
                        {{--描述--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">描述</label>
                            <div class="col-md-12 ">
                                {{--<input type="text" class="form-control" name="description" placeholder="描述" value="{{ $data->description or '' }}">--}}
                                <textarea class="form-control" name="description" rows="3" cols="" placeholder="描述">{{ $data->description or '' }}</textarea>
                            </div>
                        </div>

                        {{--头像--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">头像</label>
                            <div class="col-md-12 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if(!empty($data->portrait_img))
                                            <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="" />
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                    </div>
                                    <div class="btn-tool-group">
                                        <span class="btn-file">
                                            <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                            <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                            <input type="file" name="portrait" />
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
                    <div class="row" style="margin:8px 0;">
                        <div class="col-md-8 col-md-offset-2-">
                            <button type="button" onclick="" class="btn btn-primary" id="edit-my-doc-submit"><i class="fa fa-check"></i>提交</button>
                            <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')

    </div>

</div>
@endsection


@section('style')
@endsection

@section('script')
<script>
    $(function() {

        $("#edit-my-doc-submit").on('click', function() {
            var options = {
                url: "/my-doc-edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/my-doc-list";
                    }
                }
            };
            $("#form-edit-my-doc").ajaxSubmit(options);
        });
    });
</script>
@endsection

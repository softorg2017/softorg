<div class="box box-warning" style="font-size:12px;">


    <div class="box-header with-border margin-top-16px margin-bottom-16px">
        <h3 class="box-title">内容结构</h3>
        <div class="pull-right">
            <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
        </div>
    </div>


    <div class="box-body" id="content-structure-list">
        <div class="col-md-12 col-md-offset-2-">
            <div class="input-group margin-top-4px margin-bottom-12px" data-id='{{ $data->id }}'>
                <span class="input-group-addon"><b>封面</b></span>
                <span class="form-control multi-ellipsis-1">{{ $data->title or '' }}</span>
                <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
            </div>
        </div>
        @foreach( $data->contents_recursion as $key => $content )
            <div class="col-md-12 col-md-offset-2-">
                <div class="input-group this-content" data-id='{{ $content->id }}' style="margin-top:4px; margin-left:{{ $content->level*34 }}px">

                    {{--排名--}}
                    <span class="input-group-addon _none" title="">
                        {{--@if($content->type == 1)--}}
                            {{--<i class="fa fa-list-ul"></i>--}}
                        {{--@else--}}
                            {{--<i class="fa fa-file-text"></i>--}}
                        {{--@endif--}}
                        <b>{{ $content->rank or '0' }}</b>
                    </span>

                    {{--标题--}}
                    <span class="form-control multi-ellipsis-1 this-content-title">{{ $content->title or '' }}</span>

                    {{--是否发布--}}
                    @if($content->is_published == 0)
                        <span class="input-group-addon btn publish-this-content"><b>待发布</b></span>
                    @else
                        <span class="input-group-addon btn disabled"><b class="text-green">已发布</b></span>
                    @endif

                    {{--是否启用--}}
                    @if($content->item_active == 0)
                        <span class="input-group-addon btn enable-this-content"><b>未启用</b></span>
                    @elseif($content->item_active == 1)
                        <span class="input-group-addon btn disable-this-content"><b class="text-green">已启用</b></span>
                    @else
                        <span class="input-group-addon btn enable-this-content"><b class="text-red">已禁用</b></span>
                    @endif

                    {{--添加新内容--}}
                    {{--@if($content->type == 1)--}}
                    <span class="input-group-addon btn create-follow-menu"><i class="fa fa-plus"></i></span>
                    {{--@endif--}}

                    {{--编辑--}}
                    @if($content->is_published == 0)
                        <span class="input-group-addon btn edit-this-content"><i class="fa fa-pencil"></i></span>
                    @else
                        <span class="input-group-addon btn disabled"><i class="fa fa-pencil"></i></span>
                    @endif

                    {{--移动--}}
                    <span class="input-group-addon btn this-content-move-show"><i class="icon ion-arrow-move"></i></span>

                    {{--删除--}}
                    <span class="input-group-addon btn delete-this-content"><i class="fa fa-trash"></i></span>

                </div>
            </div>
        @endforeach
    </div>


    <div class="box-footer">
        <div class="row margin-top-16px margin-bottom-16px">
            <div class="col-md-12 col-md-offset-2-">
                <button type="button" class="btn btn-success show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                <a href="{{ url('/item/'.$data->id) }}" target="_blank"><button type="button" class="btn btn-primary">预览</button></a>
                <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
            </div>
        </div>
    </div>


</div>




<div class="modal fade modal-main-body" id="modal-body-for-item-edit">
    <div class="col-md-8 col-md-offset-2 margin-top-64px margin-bottom-64px bg-white">


        <div class="box box-info form-container">


            <div class="box-header with-border margin-top-16px margin-bottom-16px">
                <h3 class="box-title">添加/编辑内容</h3>
                <div class="pull-right _none">
                    <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool _none" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool e-cancel-for-item-edit" data-widget="remove-">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>


            <div class="box-body">
            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-content">

                    {{ csrf_field() }}
                    <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
                    <input type="hidden" name="category" value="11" readonly>
                    <input type="hidden" name="item_type" value="11" readonly>
                    <input type="hidden" name="item_id" value="{{ $data->id or 0 }}" readonly>
                    <input type="hidden" name="content_id" value="{{ $content->id or 0 }}" readonly>

                    {{--类型--}}
                    <div class="form-group form-type _none">
                        <label class="control-label- col-md-2">类型</label>
                        <div class="col-md-12 ">
                            <div class="btn-group">
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type-" value="1" checked="checked"> 目录
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type-" value="2"> 内容
                                        </label>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{--目录--}}
                    <div class="form-group" id="form-menu-option">
                        <label class="control-label- col-md-2">所属目录</label>
                        <div class="col-md-12 ">
                            <select name="p_id" id="menu" class="form-control form-filter" style="width:100%;">

                                <option value="0">顶级目录</option>

                                @foreach( $data->contents_recursion as $key => $content )
                                    {{--@if($content->type == 1)--}}

                                    <option value="{{ $content->id or '' }}">
                                        @for ($i = 0; $i < $content->level; $i++)
                                            ·· &nbsp;
                                        @endfor
                                        {{ $content->title or '' }}
                                    </option>

                                    {{--@endif--}}
                                @endforeach

                            </select>
                        </div>
                    </div>
                    {{--排序--}}
                    {{--<div class="form-group" id="form-rank-option">--}}
                        {{--<label class="control-label- col-md-2">排序</label>--}}
                        {{--<div class="col-md-12 ">--}}
                            {{--<input type="text" class="form-control" name="rank" placeholder="默认排序" value="0">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--标题--}}
                    <div class="form-group">
                        <label class="control-label- col-md-2"><sup class="text-red">*</sup> 标题</label>
                        <div class="col-md-12 ">
                            <input type="text" class="form-control" name="title" placeholder="请输入标题，必填" value="">
                        </div>
                    </div>
                    {{--描述--}}
                    <div class="form-group">
                        <label class="control-label- col-md-2">描述</label>
                        <div class="col-md-12 ">
                            <textarea class="form-control" name="description" rows="3" placeholder="描述"></textarea>
                        </div>
                    </div>
                    {{--内容--}}
                    <div class="form-group">
                        <label class="control-label- col-md-2">图文详情</label>
                        <div class="col-md-12 ">
                            <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                                <script id="container" name="content" type="text/plain"></script>
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
                                <div class="fileinput-new thumbnail cover_img_container">
                                    <img class="cover_img" src="" alt="" />
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

            </form>
            </div>


            <div class="box-footer">
                <div class="row margin-top-16px margin-bottom-16px">
                    <div class="col-md-10 col-md-offset-2-">
                        <button type="button" class="btn btn-primary" id="edit-content-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default e-cancel-for-item-edit">取消</button>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>




<div class="modal fade modal-main-body" id="modal-body-for-item-move">
    <div class="col-md-6 col-md-offset-3" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;background:#fff;">


        <div class="box- box-info- form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">移动位置</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="modal-form-content-move">
                <div class="box-body">

                    {{ csrf_field() }}
                    <input type="hidden" name="content-move-operate" value="content-move" readonly>
                    <input type="hidden" name="content-move-id" value="0" readonly>

                    {{--类别--}}


                    {{--标题--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">标题</label>
                        <div class="col-md-9 control-label" style="text-align:left;">
                            <span class="content-move-title"></span>
                        </div>
                    </div>
                    {{--目录--}}
                    <div class="form-group" id="form-move-menu-option">
                        <label class="control-label col-md-2">目录</label>
                        <div class="col-md-9 ">
                            <select class="form-control form-filter" name="move_menu" id="content-move-menu" onChange="content_move_menu_change();">

                                <option value="0">顶级目录</option>

                                @foreach( $data->contents_recursion as $key => $content )
                                    {{--@if($content->type == 1)--}}

                                    <option value="{{ $content->id or '' }}" data-child="{{ $content->has_child or 0 }}">
                                        @for ($i = 0; $i < $content->level; $i++)
                                            ·· &nbsp;
                                        @endfor
                                        {{ $content->title or '' }}
                                    </option>

                                    {{--@endif--}}
                                @endforeach

                            </select>
                        </div>
                    </div>
                    {{--移动位置--}}
                    <div class="form-group" id="form-move-position-option">
                        <label class="control-label col-md-2">位置</label>
                        <div class="col-md-9 ">
                            <select class="form-control form-filter" name="move_position" id="content-move-position">

                                <option value="0" data-id="0">选择位置</option>

                                @foreach( $data->contents_recursion_menu as $key => $content )
                                    {{--@if($content->type == 1)--}}

                                    <option value="{{ $content["value"] or '' }}" data-id="{{ $content["id"] or 0 }}" data-p-id="{{ $content["p_id"] or 0 }}" data-direction="{{ $content["direction"] or 'after' }}">
                                        {{ $content["title"] or '' }}
                                    </option>

                                    {{--@endif--}}
                                @endforeach

                            </select>
                        </div>
                    </div>


                </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-9 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="content-move-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" id="content-move-cancel">取消</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
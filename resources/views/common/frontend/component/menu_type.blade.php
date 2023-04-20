<div class="box box-warning">


    <div class="box-header with-border margin-top-16px margin-bottom-16px">
        <h3 class="box-title">内容结构图</h3>
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
                        <span class="input-group-addon btn publish-this-content" title="点击发布"><b>待发布</b></span>
                    @else
                        <span class="input-group-addon btn disabled" title="已发布"><b class="text-green">已发布</b></span>
                    @endif

                    {{--是否启用--}}
                    @if($content->item_active == 0)
                        <span class="input-group-addon btn enable-this-content" title="点击启用"><b>未启用</b></span>
                    @elseif($content->item_active == 1)
                        <span class="input-group-addon btn disable-this-content" title="点击禁用"><b class="text-green">已启用</b></span>
                    @else
                        <span class="input-group-addon btn enable-this-content" title="点击启用"><b class="text-red">已禁用</b></span>
                    @endif

                    {{--添加新内容--}}
                    {{--@if($content->type == 1)--}}
                    <span class="input-group-addon btn create-follow-menu"><i class="fa fa-plus"></i></span>
                    {{--@endif--}}

                    {{--编辑--}}
                    @if($content->is_published == 0)
                        <span class="input-group-addon btn edit-this-content" title="编辑"><i class="fa fa-pencil"></i></span>
                    @else
                        <span class="input-group-addon btn disabled" title="不可编辑"><i class="fa fa-pencil"></i></span>
                    @endif

                    {{--移动--}}
                    <span class="input-group-addon btn this-content-move-show" title="移动位置"><i class="icon ion-arrow-move"></i></span>

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
<form action="" method="post" class="form-horizontal form-bordered" id="form-edit-content">

        {{csrf_field()}}
        <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
        <input type="hidden" name="category" value="18" readonly>
        <input type="hidden" name="item_category" value="1" readonly>
        <input type="hidden" name="item_type" value="18" readonly>
        <input type="hidden" name="item_id" value="{{ $data->id or 0 }}" readonly>
        <input type="hidden" name="content_id" value="{{ $content or 0 }}" readonly>

        {{--时间点--}}
        <div class="form-group" id="form-time-point-option">
            <label class="control-label col-md-2">时间点</label>
            <div class="col-md-8 ">
                <div><input type="text" class="form-control" name="time_point" placeholder="时间点" value=""></div>
            </div>
        </div>
        {{--标题--}}
        <div class="form-group">
            <label class="control-label col-md-2">标题</label>
            <div class="col-md-8 ">
                <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value=""></div>
            </div>
        </div>
        {{--描述--}}
        <div class="form-group">
            <label class="control-label col-md-2">描述</label>
            <div class="col-md-8 ">
                <div><textarea class="form-control" name="description" rows="3" placeholder="描述"></textarea></div>
            </div>
        </div>
        {{--内容--}}
        <div class="form-group">
            <label class="control-label col-md-2">详情</label>
            <div class="col-md-8 ">
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
            <label class="control-label col-md-2">封面图片</label>
            <div class="col-md-8 fileinput-group">

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
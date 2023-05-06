<div class="modal fade modal-main-body" id="modal-body-for-item-edit">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 margin-top-32px margin-bottom-64px bg-white">


        <div class="box box-info- form-container">


            <div class="box-header with-border margin-top-16px margin-bottom-16px">
                <h3 class="box-title">添加/编辑内容</h3>
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
                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">

                    {{ csrf_field() }}
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
                            <textarea class="form-control" name="description" rows="3" placeholder="描述">{!! $data->description or '' !!}</textarea>
                        </div>
                    </div>

                    {{--职位--}}
                    <div class="form-group item-option option-people">
                        <label class="control-label col-md-2">职业</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="major" placeholder="职业" value="{{ $data->major or '' }}">
                        </div>
                    </div>
                    {{--国别--}}
                    <div class="form-group item-option option-people">
                        <label class="control-label col-md-2">国别</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="nation" placeholder="国别" value="{{ $data->nation or '' }}">
                        </div>
                    </div>
                    {{--作者--}}
                    <div class="form-group item-option option-product">
                        <label class="control-label col-md-2">添加作者</label>
                        <div class="col-md-8 ">
                            <select name="peoples[]" id="select2-people" data-tags="true" multiple="multiple" multiple style="width:100%;">
                                {{--<option value="{{  $data->people_id or 0 }}">{{  $data->people->name or '请选择作者' }}</option>--}}
                                @if(!empty($data->pivot_product_people))
                                    @foreach($data->pivot_product_people as $p)
                                        <option value="{{ $p->id }}" selected="selected">{{ $p->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    {{--出生日期--}}
                    <div class="form-group item-option option-people option-product option-event">
                        <label class="control-label col-md-2">开始时间</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="birth_time" placeholder="出生日期/开始时间" value="{{ $data->birth_time or '' }}">
                        </div>
                    </div>
                    {{--逝世时间--}}
                    <div class="form-group item-option option-people option-event">
                        <label class="control-label col-md-2">结束时间</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="death_time" placeholder="逝世时间/结束时间" value="{{ $data->death_time or '' }}">
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
                        <label class="control-label col-md-2">图文详情</label>
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
                                <div class="fileinput-new thumbnail cover_img_container">
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

                </form>
            </div>


            <div class="box-footer">
                <div class="row margin-top-16px margin-bottom-16px">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default e-cancel-for-item-edit">取消</button>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
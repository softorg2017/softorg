@extends('admin.layout.layout')


@section('title','企业站')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-pin font-blue"></i>
                        <span class="caption-subject font-blue sbold uppercase"></span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <!--<label class="btn btn-outline grey-salsa btn-circle btn-sm active">
                                                        <input type="radio" name="options" class="toggle" id="option1">New</label>
                                                    <label class="btn btn-outline grey-salsa btn-circle btn-sm">
                                                        <input type="radio" name="options" class="toggle" id="option2">Returning</label>-->
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="return false">
                        {{--js生成的内容--}}
                        <div class="form-body">
                        </div>

                        {{--时间--}}
                        <div class="form-group">
                            <label class="control-label col-md-3">直播时间</label>
                            <div class="col-md-8 ">
                                <div class="margin-bottom-5"><input type="text" class="form-control" name="start_time" placeholder="请输入开始时间" value=""></div>
                                <div class="margin-bottom-5"><input type="text" class="form-control" name="end_time" placeholder="请输入结束时间" value=""></div>
                            </div>
                        </div>


                        {{--自定义--}}
                        {{--同期推荐--}}
                        <div class="form-group" type="">

                            <label class="control-label col-md-3" style="font-weight:bold;">同期推荐（生物谷）</label>
                            <div class="col-md-8"><input type="text" name="ad_href" class="form-control" placeholder="同期推荐链接" value=""  data-checked="1"></div>
                            <label class="control-label col-md-3">同期推荐图片</label>
                            <div class="col-md-8 fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:200px; height:150px;word-wrap:break-word;">
                                    <img src="http://res.cdn.bioon.com/{{$ad_picture or ''}}" />
                                </div>

                                <div>
                                <span class="btn red btn-outline btn-file">
                                    <span class="fileinput-new">选择图片</span>
                                    <span class="fileinput-exists">更改图片</span>
                                    <input type="file" placeholder=""  name="ad_picture" />
                                </span>
                                    {{--<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">删除图片</a>--}}
                                </div>
                            </div>
                        </div>

                        {{--赞助企业--}}
                        <div class="form-group sponsor-container" data-key= id="sponsor-mark">
                            <label class="control-label col-md-3" style="font-weight:bold;">赞助企业(生物谷)</label>
                            <div class="col-md-8">
                                <button type="button" onclick="" class="btn green sponsor-superaddition">追加</button>
                                <button type="button" onclick="" class="btn red sponsor-delete-all">全部删除</button>
                                <button type="button" onclick="" class="btn grey sponsor-show">显示</button>
                                <button type="button" onclick="" class="btn grey sponsor-hide">隐藏</button>
                                <input type="hidden" name="" data-checked="1" value="">
                            </div>
                        </div>

                        {{--隐藏字段--}}
                        <div class="form-group" style="display:none">
                            <div class="col-md-8"><input type="text" name="expert_id_sort" data-checked="1" id="multiple_val"></div>
                        </div>


                        <div class="form-actions">
                            <div class="row" style="margin: 15px 0;">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" data-checked="" data-url="" onclick="" class="btn green">
                                        <i class="fa fa-check"></i> Submit
                                    </button>
                                    <button type="button" onclick="history.go(-1);" class="btn grey-salsa btn-outline">Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@endsection
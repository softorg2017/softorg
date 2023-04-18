@extends('super.admin.layout.layout')

@section('title','机构列表')
@section('header','机构列表')
@section('description','机构列表')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">机构列表</h3>

                <div class="pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body datatable-body" id="org-main-body">
                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                    <tr role='row' class='heading'>
                        <th>#ID</th>
                        <th>名称</th>
                        <th>如未号</th>
                        <th>类型</th>
                        <th>产品</th>
                        <th>文章</th>
                        <th>活动</th>
                        <th>问卷</th>
                        <th>访问数</th>
                        <th>分享数</th>
                        <th>注册时间</th>
                        <th>修改时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success">搜索</button>
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">重置</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- datatable end -->
            </div>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-9">
                        <button type="button" onclick="" class="btn btn-primary"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection



@section('js')
<script>
    var TableDatatablesAjax = function () {
        var datatableAjax = function () {

            var dt = $('#datatable_ajax');
            var ajax_datatable = dt.DataTable({
                "aLengthMenu": [[20, 50, 200, 500, -1], ["20", "50", "200", "500", "全部"]],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    'url': '/super-admin/org/list',
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                    },
                },
                "pagingType": "simple_numbers",
                "order": [],
                "orderCellsTop": true,
                "columns": [
                    {
                        "data": "id",
                        'orderable': false,
                        render: function(val) {
                            return val == null ? '' : val;
                        }
                    },
                    {
                        'data': 'name',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/org/'+row.id+'">'+row.name+'</a>';
                        }
                    },
                    {
                        'data': 'website_name',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? '' : val;
                        }
                    },
                    {
                        'data': 'type',
                        'orderable': true,
                        render: function(val) {
                            return val == null ? '' : val;
                        }
                    },
                    {
                        'data': 'products_count',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'articles_count',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'activities_count',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'surveys_count',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'visit_num',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'share_num',
                        'orderable': false,
                        render: function(val) {
                            return val == null ? 0 : val;
                        }
                    },
                    {
                        'data': 'created_at',
                        'orderable': true,
                        render: function(data) {
                            newDate = new Date();
                            newDate.setTime(data * 1000);
//                            return newDate.toLocaleString('chinese',{hour12:false});
                            return newDate.toLocaleDateString();
                        }
                    },
                    {
                        'data': 'updated_at',
                        'orderable': true,
                        render: function(data) {
                            newDate = new Date();
                            newDate.setTime(data * 1000);
//                            return newDate.toLocaleString('chinese',{hour12:false});
                            return newDate.toLocaleDateString();
                        }
                    },
                    {
                        "data": "status",
                        'orderable': false,
                        render: function(val) {
                            return val == null ? '' : val;
                        }
                    },
                    {
                        'data': 'encode_id',
                        'orderable': false,
                        render: function(data, type, row, meta) {

                            var value = row.encode_id;

                            var apply_html= "";
                            if(row.is_apply == 1) apply_html = '<a href="/admin/apply/list?sort=activity&id='+value+'">报名列表</a></li>';

                            var sign_html= "";
                            if(row.is_sign == 1) sign_html = '<a href="/admin/sign/list?sort=activity&id='+value+'">签到列表</a></li>';

                            var html =
                                '<a class="btn btn-xs item-enable-submit" data-id="'+value+'">启用</a>'+
                                '<a class="btn btn-xs item-disable-submit" data-id="'+value+'">禁用</a>'+
                                '<a class="btn btn-xs item-download-qrcode-submit" data-id="'+value+'">下载二维码</a>'+
                                '<a class="btn btn-xs item-statistics-submit" data-id="'+value+'">流量统计</a>'+
                                {{--'<a class="btn btn-xs" href="/{{config('common.org.admin.prefix')}}/org/edit?id='+value+'">编辑</a>'+--}}
                                '<a class="btn btn-xs item-edit-submit" data-id="'+value+'">编辑</a>'+
                                '<a class="btn btn-xs item-delete-submit" data-id="'+value+'">删除</a>'+
                                '<a class="btn btn-xs item-login-submit" data-id="'+value+'">登录</a>';
                            return html;
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    ajax_datatable.$('.tooltips').tooltip({placement: 'top', html: true});
                    $("a.verify").click(function(event){
                        event.preventDefault();
                        var node = $(this);
                        var tr = node.closest('tr');
                        var nickname = tr.find('span.nickname').text();
                        var cert_name = tr.find('span.certificate_type_name').text();
                        var action = node.attr('data-action');
                        var certificate_id = node.attr('data-id');
                        var action_name = node.text();

                        var tpl = "{{trans('labels.crc.verify_user_certificate_tpl')}}";
                        layer.open({
                            'title': '警告',
                            content: tpl
                                    .replace('@action_name', action_name)
                                    .replace('@nickname', nickname)
                                    .replace('@certificate_type_name', cert_name),
                            btn: ['Yes', 'No'],
                            yes: function(index) {
                                layer.close(index);
                                $.post(
                                        '/admin/medsci/certificate/user/verify',
                                        {
                                            action: action,
                                            id: certificate_id,
                                            _token: '{{csrf_token()}}'
                                        },
                                        function(json){
                                            if(json['response_code'] == 'success') {
                                                layer.msg('操作成功!', {time: 3500});
                                                ajax_datatable.ajax.reload();
                                            } else {
                                                layer.alert(json['response_data'], {time: 10000});
                                            }
                                        }, 'json');
                            }
                        });
                    });
                },
                "language": { url: '/common/dataTableI18n' },
            });


            dt.on('click', '.filter-submit', function () {
                ajax_datatable.ajax.reload();
            });

            dt.on('click', '.filter-cancel', function () {
                $('textarea.form-filter, select.form-filter, input.form-filter', dt).each(function () {
                    $(this).val("");
                });

                $('select.form-filter').selectpicker('refresh');

                ajax_datatable.ajax.reload();
            });

        };
        return {
            init: datatableAjax
        }
    }();
    $(function () {
        TableDatatablesAjax.init();
    });
</script>
<script>
    $(function() {

        // 【下载二维码】
        $("#org-main-body").on('click', ".item-download-qrcode-submit", function() {
            var that = $(this);
            window.open("/{{config('common.super.admin.prefix')}}/download-qrcode?sort=org&id="+that.attr('data-id'));
        });

        // 【数据分析】
        $("#org-main-body").on('click', ".item-statistics-submit", function() {
            var that = $(this);
            window.open("/{{config('common.super.admin.prefix')}}/statistics/org?id="+that.attr('data-id'));
        });

        // 【登录】
        $("#org-main-body").on('click', ".item-login-submit", function() {
            var that = $(this);
            window.open("/{{config('common.super.admin.prefix')}}/org/login?id="+that.attr('data-id'));
        });

        // 【编辑】
        $("#org-main-body").on('click', ".item-edit-submit", function() {
            var that = $(this);
            {{--layer.msg("/{{config('common.super.admin.prefix')}}/item/edit?id="+that.attr('data-id'));--}}
                window.location.href = "/{{config('common.super.admin.prefix')}}/org/edit?id="+that.attr('data-id');
        });

        // 【删除】
        $("#org-main-body").on('click', ".item-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要删除该"机构"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url(config('common.org.admin.prefix').'/org/delete')}}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else location.reload();
                        },
                        'json'
                    );
                }
            });
        });

        // 【启用】 活动
        $("#org-main-body").on('click', ".item-enable-submit", function() {
            var that = $(this);
            layer.msg('确定启用该"机构"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url(config('common.org.admin.prefix').'/org/enable')}}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else location.reload();
                        },
                        'json'
                    );
                }
            });
        });

        // 【禁用】 活动
        $("#org-main-body").on('click', ".item-disable-submit", function() {
            var that = $(this);
            layer.msg('确定禁用该"机构"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url(config('common.org.admin.prefix').'/org/disable')}}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else location.reload();
                        },
                        'json'
                    );
                }
            });
        });

    });
</script>
@endsection

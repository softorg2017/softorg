@extends('super.admin.layout.layout')

@section('title','Organization.目录列表')
@section('header','Organization.目录列表')
@section('description','列表')
@section('breadcrumb')
    <li><a href="{{ url('/super-admin') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">内容列表</h3>

                <div class="pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body datatable-body" id="menu-main-body">
                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                    <tr role='row' class='heading'>
                        <th>#ID</th>
                        <th>标题</th>
                        <th>所属机构</th>
                        <th>访问数</th>
                        <th>创建时间</th>
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
                    'url': '/super-admin/org/menu/list',
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
                        'data': 'title',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/item/'+row.encode_id+'">'+row.title+'</a>';
                        }
                    },
                    {
                        'data': 'org_id',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/o/'+row.org.website_name+'">'+row.org.name+'</a>';
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
                        "data": "active",
                        'orderable': false,
                        render: function(val) {
                            return val == null ? '' : val;
                        }
                    },
                    {
                        'data': 'id',
                        'orderable': false,
                        render: function(data, type, row, meta) {

                            var value = row.id;

                            var html =
                                    '<div class="btn-group">'+
                                    '<button type="button" class="btn btn-sm btn-primary">操作</button>'+
                                    '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                    '<span class="caret"></span>'+
                                    '<span class="sr-only">Toggle Dropdown</span>'+
                                    '</button>'+
                                    '<ul class="dropdown-menu" role="menu">'+
                                    '<li><a href="/admin/item/edit?id='+value+'">编辑</a></li>'+
                                    '<li><a class="item-delete-submit" data-id="'+value+'" >删除</a></li>'+
                                    '<li><a class="item-enable-submit" data-id="'+value+'">启用</a></li>'+
                                    '<li><a class="item-disable-submit" data-id="'+value+'">禁用</a></li>'+
                                    '<li class="divider"></li>'+
                                    '<li><a href="#">Separated link</a></li>'+
                                    '</ul>'+
                                    '</div>';
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

        // 【删除】
        $("#menu-main-body").on('click', ".menu-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要删除该"目录"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/super/admin/org/menu/delete",
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

        // 【启用】
        $("#menu-main-body").on('click', ".menu-enable-submit", function() {
            var that = $(this);
            layer.msg('确定启用该"目录"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/super/admin/org/menu/enable",
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

        // 【禁用】
        $("#menu-main-body").on('click', ".menu-disable-submit", function() {
            var that = $(this);
            layer.msg('确定禁用该"目录"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/super/admin/org/menu/disable",
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

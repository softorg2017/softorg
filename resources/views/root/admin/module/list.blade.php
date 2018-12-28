@extends('root.admin.layout.layout')

@section('head_title','首页模块列表')
@section('header','首页模块列表')
@section('description','列表')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="{{url(config('outside.admin.prefix').'/admin/module/list')}}"><i class="fa "></i>首页模块列表</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">首页模块列表</h3>

                <div class="pull-right">
                    <a href="{{url(config('outside.admin.prefix').'/admin/module/create')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加首页模块</button>
                    </a>
                </div>
            </div>

            <div class="box-body" id="module-main-body">
                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                    <tr role='row' class='heading'>
                        <th>标题</th>
                        <th>类型</th>
                        <th>列数</th>
                        <th>目录</th>
                        <th>管理员</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
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
                    <div class="col-md-offset-0 col-md-9">
                        <button type="button" onclick="" class="btn btn-primary _none"><i class="fa fa-check"></i> 提交</button>
                        <a href="{{url('/admin/module/sort')}}">
                            <button type="button" onclick="" class="btn btn-primary"><i class="fa fa-sort"></i> 模块排序</button></a>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection



@section('custom-script')
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
                    'url': "{{url('/admin/module/list')}}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
//                        d.nickname 	= $('input[name="nickname"]').val();
//                        d.certificate_type_id = $('select[name="certificate_type_id"]').val();
//                        d.certificate_state = $('select[name="certificate_state"]').val();
//                        d.admin_name = $('input[name="admin_name"]').val();
//
//                        d.created_at_from = $('input[name="created_at_from"]').val();
//                        d.created_at_to = $('input[name="created_at_to"]').val();
//                        d.updated_at_from = $('input[name="updated_at_from"]').val();
//                        d.updated_at_to = $('input[name="updated_at_to"]').val();

                    },
                },
                "pagingType": "simple_numbers",
                "order": [],
                "orderCellsTop": true,
                "columns": [
                    {
                        'data': 'title',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        'data': 'type',
                        'orderable': true,
                        render: function(data, type, row, meta) {
                            if(data == 0) return '<small class="label bg-black disabled">未知</small>';
                            else if(data == 1) return '<small class="label bg-black disabled">(单)目录</small>';
                            else if(data == 2) return '<small class="label bg-black disabled">(多)目录</small>';
                            else if(data == 3) return '<small class="label bg-black disabled">(单)图片链接</small>';
                            else if(data == 4) return '<small class="label bg-black disabled">(多)图片链接</small>';
                            else if(data == 5) return '<small class="label bg-black disabled">图片轮播</small>';
                            else return '<small class="label bg-black disabled">其他</small>';
                        }
                    },
                    {
                        'data': 'column',
                        'orderable': true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        'data': 'pivot_menus',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            var html = '';
                            if(row.menu != null) {
                                html = '<a target="_blank" href="/org/menu/'+row.menu.encode_id+'">'+row.menu.title+'</a><br>';
                            } else {
                                $.each(data,function( key, val ) {
//                                console.log( key, val, this );
                                    html += '<a target="_blank" href="/org/menu/'+this.encode_id+'">'+this.title+'</a><br>';
                                });
                            }
                            return html;
                        }
                    },
                    {
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return row.admin == null ? '未知' : row.admin.nickname;
                        }
                    },
                    {
                        'data': 'active',
                        'orderable': false,
                        render: function(val) {
                            if(val == 0) return '<small class="label bg-teal">未启用</small>';
                            else if(val == 1) return '<small class="label bg-green">启</small>';
                            else return '<small class="label bg-red">禁</small>';
                        }
                    },
                    {
                        'data': 'created_at',
                        'orderable': true,
                        render: function(data) {
                            newDate = new Date();
                            newDate.setTime(data * 1000);
                            return newDate.toLocaleString('chinese',{hour12:false});
                        }
                    },
                    {
                        'data': 'updated_at',
                        'orderable': true,
                        render: function(data) {
                            newDate = new Date();
                            newDate.setTime(data * 1000);
                            return newDate.toLocaleString('chinese',{hour12:false});
                        }
                    },
                    {
                        'data': 'encode_id',
                        'orderable': false,
                        render: function(value) {
                            var html =
                                    '<div class="btn-group">'+
                                    '<button type="button" class="btn btn-sm btn-primary">操作</button>'+
                                    '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                    '<span class="caret"></span>'+
                                    '<span class="sr-only">Toggle Dropdown</span>'+
                                    '</button>'+
                                    '<ul class="dropdown-menu" role="menu">'+
                                    '<li><a href="/admin/module/edit?id='+value+'">编辑</a></li>'+
                                    '<li><a class="module-delete-submit" data-id="'+value+'" >删除</a></li>'+
                                    '<li><a class="module-enable-submit" data-id="'+value+'">启用</a></li>'+
                                    '<li><a class="module-disable-submit" data-id="'+value+'">禁用</a></li>'+
                                    {{--'<li><a href="/admin/statistics/module?id='+value+'">流量统计</a></li>'+--}}
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
        $("#module-main-body").on('click', ".module-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要删除该"目录"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "{{url('/admin/module/delete')}}",
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
        $("#module-main-body").on('click', ".module-enable-submit", function() {
            var that = $(this);
            layer.msg('确定启用该"目录"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url('/admin/module/enable')}}",
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
        $("#module-main-body").on('click', ".module-disable-submit", function() {
            var that = $(this);
            layer.msg('确定禁用该"目录"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url('/admin/module/disable')}}",
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

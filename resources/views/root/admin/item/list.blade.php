@extends('root.admin.layout.layout')

@section('head_title','内容列表 - 如哉网络')
@section('header','内容列表')
@section('description','内容列表')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/item/list')}}"><i class="fa "></i>内容列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">
                    @if($category == 'about') 关于企业列表
                    @elseif($category == 'cooperation') 合作加盟列表
                    @elseif($category == 'advantage') 选择我们列表
                    @elseif($category == 'cooperation') 合作加盟列表
                    @elseif($category == 'service') 业务列表
                    @elseif($category == 'product') 产品列表
                    @elseif($category == 'case')案例列表
                    @elseif($category == 'faq') 常见问题列表
                    @elseif($category == 'coverage') 资讯列表
                    @elseif($category == 'activity') 活动列表
                    @elseif($category == 'client') 客户列表
                    @else 全部内容
                    @endif
                </h3>
                <div class="pull-right">
                    @if($category == 'info')
                        <a href="{{url('/admin/item/create?category=info')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加基本信息</button>
                        </a>
                    @elseif($category == 'about')
                        <a href="{{url('/admin/item/create?category=about')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加关于企业</button>
                        </a>
                    @elseif($category == 'advantage')
                        <a href="{{url('/admin/item/create?category=advantage')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加选择我们</button>
                        </a>
                    @elseif($category == 'cooperation')
                        <a href="{{url('/admin/item/create?category=cooperation')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加合作加盟</button>
                        </a>
                    @elseif($category == 'service')
                        <a href="{{url('/admin/item/create?category=service')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加业务</button>
                        </a>
                    @elseif($category == 'product')
                        <a href="{{url('/admin/item/create?category=product')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加产品</button>
                        </a>
                    @elseif($category == 'case')
                        <a href="{{url('/admin/item/create?category=case')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加案例</button>
                        </a>
                    @elseif($category == 'faq')
                        <a href="{{url('/admin/item/create?category=faq')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加常见问题</button>
                        </a>
                    @elseif($category == 'coverage')
                        <a href="{{url('/admin/item/create?category=coverage')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加资讯</button>
                        </a>
                    @elseif($category == 'activity')
                        <a href="{{url('/admin/item/create?category=activity')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加活动</button>
                        </a>
                    @elseif($category == 'client')
                        <a href="{{url('/admin/item/create?category=client')}}">
                            <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加客户</button>
                        </a>
                    @else
                        {{--<a href="{{url('/admin/item/create')}}">--}}
                            {{--<button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加内容</button>--}}
                        {{--</a>--}}
                    @endif
                </div>
            </div>

            <div class="box-body" id="item-main-body">
                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                    <tr role='row' class='heading'>
                        <th>标题</th>
                        <th>所属类别</th>
                        <th>所属目录</th>
                        <th>管理员</th>
                        <th>浏览次数</th>
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
                    'url': "{{url('/admin/item/list')}}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.category = "{{ request()->input('category', '') }}";
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
                        "data": "encode_id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            var category = 'item';
//                            if(row.category == 0) category = 'custom';
//                            else if(row.category == 1) category = 'info';
//                            else if(row.category == 2) category = 'about';
//                            else if(row.category == 5) category = 'advantage';
//                            else if(row.category == 9) category = 'cooperation';
//                            else if(row.category == 11) category = 'product';
//                            else if(row.category == 21) category = 'case';
//                            else if(row.category == 31) category = 'faq';
//                            else if(row.category == 41) category = 'coverage';
//                            else if(row.category == 48) category = 'activity';
//                            else if(row.category == 51) category = 'client';
//                            else category = 'item';
                            category = 'item';
                            return '<a target="_blank" href="/'+category+'/'+row.id+'">'+row.title+'</a>';
                        }
                    },
                    {
                        'data': 'category',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(data == 0) return '<small class="label bg-teal">未分类</small>';
                            else if(data == 1) return '<small class="label bg-teal">基本信息</small>';
                            else if(data == 2) return '<small class="label btn-info">关于企业</small>';
                            else if(data == 5) return '<small class="label btn-info">选择我们</small>';
                            else if(data == 9) return '<small class="label bg-maroon">合作伙伴</small>';
                            else if(data == 11) return '<small class="label bg-primary">业务模块</small>';
                            else if(data == 12) return '<small class="label bg-olive">产品模块</small>';
                            else if(data == 21) return '<small class="label bg-orange">案例模块</small>';
                            else if(data == 31) return '<small class="label bg-olive">常见问题模块</small>';
                            else if(data == 41) return '<small class="label bg-olive">资讯模块</small>';
                            else if(data == 48) return '<small class="label bg-olive">活动模块</small>';
                            else if(data == 51) return '<small class="label bg-olive">客户模块</small>';
                            else return '未知模块';
                        }
                    },
                    // 单一目录
                    {
                        'data': 'menu_id',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return row.menu == null ? '未分类' : row.menu.title;
                        }
                    },
                    // 多目录
//                    {
//                        'data': 'pivot_menus',
//                        'orderable': false,
//                        render: function(data, type, row, meta) {
//                            var html = '';
//                            $.each(data,function( key, val ) {
//                                html += '<a href="/admin/menu/items?id='+this.encode_id+'">'+this.title+'</a><br>';
//                            });
//                            return html;
//                        }
//                    },
                    {
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return row.admin == null ? '未知' : row.admin.nickname;
                        }
                    },
                    {
                        'data': 'visit_num',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return data == null ? 0 : data;
                        }
                    },
                    {
                        'data': 'active',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(data == 0) return '<small class="label bg-teal">未启用</small>';
                            else if(data == 1) return '<small class="label bg-green">启</small>';
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
                                    '<li><a href="/admin/item/edit?id='+value+'">编辑</a></li>'+
                                    '<li><a class="item-delete-submit" data-id="'+value+'" >删除</a></li>'+
                                    '<li><a class="item-enable-submit" data-id="'+value+'">启用</a></li>'+
                                    '<li><a class="item-disable-submit" data-id="'+value+'">禁用</a></li>'+
                                    '<li><a href="/admin/statistics/item?id='+value+'">流量统计</a></li>'+
                                    '<li><a class="download-qrcode" data-id="'+value+'">下载二维码</a></li>'+
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
        $("#item-main-body").on('click', ".item-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要删除该"产品"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "{{url('/admin/item/delete')}}",
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
        $("#item-main-body").on('click', ".item-enable-submit", function() {
            var that = $(this);
            layer.msg('确定启用该"产品"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "{{url('/admin/item/enable')}}",
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
        $("#item-main-body").on('click', ".item-disable-submit", function() {
            var that = $(this);
            layer.msg('确定禁用该"产品"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "{{url('/admin/item/disable')}}",
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

        // 【下载】 二维码
        $("#item-main-body").on('click', ".download-qrcode", function() {
            var that = $(this);
            window.open('/admin/download_qrcode?sort=item&id='+that.attr('data-id'));
        });

    });
</script>
@endsection

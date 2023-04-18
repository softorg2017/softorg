@extends(env('TEMPLATE_DOC_HOME').'layout.layout')


@section('head_title','内容列表')


@section('header','内容列表')
@section('description','内容列表')
@section('breadcrumb')
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{ url('/home/item/list') }}"><i class="fa "></i>内容列表</a></li>
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
                    <a href="{{url('/home/item/create')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加内容</button>
                    </a>
                </div>
            </div>

            <div class="box-body" id="item-list-body">
                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                        <tr role='row' class='heading'>
                            <th>名称</th>
                            <th>类型</th>
                            <th>分享</th>
                            <th>浏览数</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>内容管理</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" name="title" /></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success filter-submit">搜索</button>
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
                    <div class="col-md-offset-0 col-md-10">
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
                    'url': '/home/item/item-list-all',
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.category = "{{ request()->input('category', '') }}";
                        d.title 	= $('input[name="title"]').val();
//                        d.major 	= $('input[name="major"]').val();
//                        d.nation 	= $('input[name="nation"]').val();
                    },
                },
                "pagingType": "simple_numbers",
                "order": [],
                "orderCellsTop": true,
                "columns": [
                    {
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/item/'+data+'">'+row.title+'</a>';
                        }
                    },
                    {
                        'data': 'item_type',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(data == 1) return '<small class="label bg-primary">文章</small>';
                            else if(data == 11) return '<small class="label bg-purple">书目</small>';
                            else if(data == 18) return '<small class="label bg-green">时间线</small>';
                            else if(data == 22) return '<small class="label bg-red">辩题</small>';
                            else return '<small class="label bg-red"></small>';
                        }
                    },
                    {
                        'data': 'is_shared',
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(data == 11) return '<small class="label bg-red">自己可见</small>';
                            else if(data == 41) return '<small class="label bg-purple">关注可见</small>';
                            else if(data == 100) return '<small class="label bg-green">所有人可见</small>';
                            else return '<small class="label bg-red"></small>';
                        }
                    },
                    {
                        'data': 'visit_num',
                        'orderable': true,
                        render: function(data, type, row, meta) {
                            return data;
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
                        render: function(data, type, row, meta) {
                            if(row.category == 11) {
                                return '<a href="/home/item/content/menutype?id='+data+'"><button type="button" class="btn btn-sm bg-purple">内容管理</button></a>';
                            }
                            else if(row.category == 18) {
                                return '<a href="/home/item/content/timeline?id='+data+'"><button type="button" class="btn btn-sm bg-purple">时间点管理</button></a>';
                            }
                            else {
                                return '<a href="/home/item/edit?id='+data+'"><button type="button" class="btn btn-sm bg-purple">编辑</button></li>';
                            }
                        }
                    },
                    {
                        'data': 'id',
                        'orderable': false,
                        render: function(data, type, row, meta) {

                            var $content_html = '';
                            if(row.item_type == 11) {
                                $content_html = '<a href="/home/item/content/menutype?id='+data+'">内容管理</a>';
                            }
                            else if(row.item_type == 18) {
                                $content_html = '<a href="/home/item/content/timeline?id='+data+'">时间点管理</a>';
                            }

                            var active_html = '';
                            if(row.active == 1) {
                                active_html = '<li><a class="item-disable-submit" data-id="'+data+'">禁用</a></li>';
                            } else {
                                active_html = '<li><a class="item-enable-submit" data-id="'+data+'">启用</a></li>';
                            }

                            var share_none_html = '<li><a class="item-share-submit" data-id="'+data+'" data-share="11">转为-仅自己可见</a></li>';
//                            var share_follow_html = '<li><a class="item-share-submit" data-id="'+data+'" data-share="41">转为-关注者可见</a></li>';
                            var share_follow_html = '';
                            var share_all_html = '<li><a class="item-share-submit" data-id="'+data+'" data-share="100">转为-所有人可见</a></li>';

                            var shared_html = '';
                            if(row.is_shared == 11) {
                                shared_html = share_follow_html + share_all_html;
                            } else if(row.is_shared == 41) {
                                shared_html = share_none_html + share_all_html;
                            } else if(row.is_shared == 100) {
                                shared_html = share_none_html + share_follow_html;
                            }

                            var menutype_html = '';
                            var timeline_html = '';
                            var edit_html = '';
                            if(row.category == 11) {
                                menutype_html = '<li><a href="/home/item/content/menutype?id='+data+'">内容管理</a></li>';
                            }
                            else if(row.category == 18) {
                                timeline_html = '<li><a href="/home/item/content/timeline?id='+data+'">管理时间点</a></li>';
                            }
                            else {
                                edit_html = '<li><a href="/home/item/edit?id='+data+'">编辑</a></li>';
                            }

                            var html =
                                '<div class="btn-group">'+
                                '<button type="button" class="btn btn-sm btn-primary">操作</button>'+
                                '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                '<span class="caret"></span>'+
                                '<span class="sr-only">Toggle Dropdown</span>'+
                                '</button>'+
                                '<ul class="dropdown-menu" role="menu">'+
//                                '<li><a href="/home/item/edit?id='+data+'">编辑</a></li>'+
//                                '<li><a href="/home/item/content?id='+data+'">内容管理</a></li>'+
                                $content_html+
                                edit_html+
                                menutype_html+
                                timeline_html+
                                shared_html+
//                                active_html+
//                                '<li><a href="/admin/statistics/page?module=2&id='+data+'">流量统计</a></li>'+
//                                '<li><a class="download-qrcode" data-id="'+data+'">下载二维码</a></li>'+
                                '<li><a class="item-delete-submit" data-id="'+data+'" >删除</a></li>'+
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
        $("#item-list-body").on('click', ".item-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要删除么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/home/item/delete",
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

        // 【分享】
        $("#item-list-body").on('click', ".item-share-submit", function() {
            var that = $(this);
            layer.msg(that.html(), {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/home/item/share",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:that.attr('data-id'),
                            is_shared:that.attr('data-share')
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
        $("#item-list-body").on('click', ".item-enable-submit", function() {
            var that = $(this);
            layer.msg('确定启用？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/home/item/enable",
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
        $("#item-list-body").on('click', ".item-disable-submit", function() {
            var that = $(this);
            layer.msg('确定禁用？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                            "/home/item/disable",
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
        $("#item-list-body").on('click', ".download-qrcode", function() {
            var that = $(this);
            window.open('/admin/download_qrcode?sort=table&id='+that.attr('data-id'));
        });

    });
</script>
@endsection

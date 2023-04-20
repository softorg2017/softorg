@extends(env('LW_TEMPLATE_DOC_HOME').'layout.layout')


@section('head_title','我的管理员')


@section('header','')
@section('description','我的管理员 - 轻博 - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>首页</a></li>
    {{--<li><a href="#"><i class="fa "></i>Here</a></li>--}}
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">我的管理员</h3>

                <div class="caption pull-right">
                    <i class="icon-pin font-blue"></i>
                    <span class="caption-subject font-blue sbold uppercase"></span>
                    <a href="{{ url('/home/user/relation-administrator') }}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加管理员</button>
                    </a>
                </div>

                <div class="pull-right _none">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body datatable-body item-main-body" id="item-main-body">


                <div class="row col-md-12 datatable-search-row">
                    <div class="input-group">

                        <input type="text" class="form-control form-filter item-search-keyup" name="username" placeholder="用户名" />

                        <button type="button" class="form-control btn btn-flat btn-success filter-submit" id="filter-submit">
                            <i class="fa fa-search"></i> 搜索
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-default filter-cancel">
                            <i class="fa fa-circle-o-notch"></i> 重置
                        </button>

                    </div>
                </div>


                <!-- datatable start -->
                <table class='table table-striped table-bordered' id='datatable_ajax'>
                    <thead>
                        <tr role='row' class='heading'>
                            <th>序号</th>
                            <th>ID</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>操作</th>
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
//                "aLengthMenu": [[20, 50, 200, 500, -1], ["20", "50", "200", "500", "全部"]],
                "aLengthMenu": [[40, 50, 200], ["40", "50", "200"]],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    'url': "{{ url('/home/user/my-administrator-list') }}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.username = $('input[name="username"]').val();
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
                        "width": "48px",
                        "title": "序号",
                        "data": null,
                        "targets": 0,
                        'orderable': false
                    },
                    {
                        'width':"48px",
                        "title": "ID",
                        "data": "id",
                        'orderable': true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "width": "96px",
                        "title": "类型",
                        "data": "relation_type",
                        'orderable': false,
                        render: function(data, type, row, meta) {
//                            return data;
                            if(data == 0)
                            {
                                return '<small class="btn-xs btn-primary">拥有者</small>';
                            }
                            else if(data == 1)
                            {
                                return '<small class="btn-xs btn-danger">超级管理员</small>';
                            }
                            else if(data == 9 || data == 11)
                            {
                                return '<small class="btn-xs btn-success">管理员</small>';
                            }
                            else return "--";
                        }
                    },
                    {
                        'className':"text-left",
                        'width':"",
                        "title": "管理员",
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/user/'+data+'">'+row.administrator.username+'</a>';
                        }
                    },
//                    {
//                        'data': 'menu_id',
//                        'orderable': false,
//                        render: function(data, type, row, meta) {
////                            return row.menu == null ? '未分类' : row.menu.title;
//                            if(row.menu == null) return '<small class="label btn-info">未分类</small>';
//                            else {
//                                return '<a href="/org-admin/item/menu?id='+row.menu.encode_id+'">'+row.menu.title+'</a>';
//                            }
//                        }
//                    },
//                    {
//                        'data': 'id',
//                        'orderable': false,
//                        render: function(data, type, row, meta) {
//                            return row.menu == null ? '未分类' : row.menu.title;
////                            var html = '';
////                            $.each(data,function( key, val ) {
////                                html += '<a href="/org-admin/item/menu?id='+this.id+'">'+this.title+'</a><br>';
////                            });
////                            return html;
//                        }
//                    },
                    {
                        "className": "font-12px",
                        "width": "112px",
                        "title": "创建时间",
                        'data': 'created_at',
                        'orderable': true,
                        render: function(data, type, row, meta) {
//                            return data;
//                            newDate = new Date();
//                            newDate.setTime(data * 1000);
//                            return newDate.toLocaleString('chinese',{hour12:false});
//                            return newDate.toLocaleDateString();
                            var $date = new Date(data*1000);
                            var $year = $date.getFullYear();
                            var $month = ('00'+($date.getMonth()+1)).slice(-2);
                            var $day = ('00'+($date.getDate())).slice(-2);
                            var $hour = ('00'+$date.getHours()).slice(-2);
                            var $minute = ('00'+$date.getMinutes()).slice(-2);
                            var $second = ('00'+$date.getSeconds()).slice(-2);
//                            return $year+'-'+$month+'-'+$day;
                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;
                        }
                    },
                    {
                        'width': "160px",
                        'title': "操作",
                        'data': 'id',
                        'orderable': false,
                        render: function(data, type, row, meta) {

                            // 二级代理权限
                            var $relation_type = "";
                            if(row.relation_type == 1)
                            {
                                $relation_type = '<a class="btn btn-xs btn-success item-super-remove-submit" data-id="'+data+'" >移除超级管理员</a>';
                            }
                            else if(row.relation_type == 9 || row.relation_type == 11)
                            {
                                $relation_type = '<a class="btn btn-xs btn-danger item-super-add-submit" data-id="'+data+'" >设为超级管理员</a>';
                            }

                            var html =
//                                '<a class="btn btn-xs item-enable-submit" data-id="'+value+'">启用</a>'+
//                                '<a class="btn btn-xs item-disable-submit" data-id="'+value+'">禁用</a>'+
//                                '<a class="btn btn-xs item-download-qrcode-submit" data-id="'+value+'">下载二维码</a>'+
//                                '<a class="btn btn-xs item-statistics-submit" data-id="'+value+'">流量统计</a>'+
                                {{--'<a class="btn btn-xs" href="/item/edit?id='+value+'">编辑</a>'+--}}
                                $relation_type+
                                '<a class="btn btn-xs bg-navy item-administrator-remove-submit" data-id="'+data+'" >删除</a>'+
                                '';
                            return html;
                        }
                    }
                ],
                "drawCallback": function (settings) {

                    let startIndex = this.api().context[0]._iDisplayStart;//获取本页开始的条数
                    this.api().column(0).nodes().each(function(cell, i) {
                        cell.innerHTML =  startIndex + i + 1;
                    });

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
@include(env('LW_TEMPLATE_DOC_HOME').'entrance.administrator.user-administrator-script')
@endsection

@extends(env('LW_TEMPLATE_SUPER_ADMIN').'layout.layout')


@section('head_title','【Super】轻博内容')


@section('header','')
@section('description','超级管理员后台系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/admin') }}"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info main-list-body">

            <div class="box-header with-border" style="margin:16px 0;">

                <h3 class="box-title">内容列表</h3>

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

                        <input type="text" class="form-control form-filter item-search-keyup" name="title" placeholder="标题" />

                        <button type="button" class="form-control btn btn-flat btn-success filter-submit" id="filter-submit">
                            <i class="fa fa-search"></i> 搜索
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-default filter-cancel">
                            <i class="fa fa-circle-o-notch"></i> 重置
                        </button>

                    </div>
                </div>

                <table class='table table-striped table-bordered table-hover' id='datatable_ajax'>
                    <thead>
                        <tr role='row' class='heading'>
                            <th>ID</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>


            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-offset-0 col-md-4 col-sm-8 col-xs-12">
                        {{--<button type="button" class="btn btn-primary"><i class="fa fa-check"></i> 提交</button>--}}
                        {{--<button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>--}}
                        <div class="input-group">
                            <span class="input-group-addon"><input type="checkbox" id="check-review-all"></span>
                            <select name="bulk-operat-status" class="form-control form-filter">
                                <option value ="0">请选择</option>
                                <option value ="封禁">封禁</option>
                                <option value ="删除">删除</option>
                                <option value ="永久删除">永久删除</option>
                            </select>
                            <span class="input-group-addon btn btn-default" id="operat-bulk-submit"><i class="fa fa-check"></i> 批量操作</span>
                            <span class="input-group-addon btn btn-default" id="delete-bulk-submit"><i class="fa fa-trash-o"></i> 批量删除</span>
                        </div>
                    </div>
                </div>
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
    </div>
</div>


<div class="modal fade" id="modal-body">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;background:#fff;">

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET-->
                <div class="box- box-info- form-container">

                    <div class="box-header with-border" style="margin:16px 0;">
                        <h3 class="box-title">内容详情</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-modal">
                        <div class="box-body">

                            {{csrf_field()}}
                            <input type="hidden" name="operate" value="work-order" readonly>
                            <input type="hidden" name="id" value="0" readonly>

                            {{--标题--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">标题</label>
                                <div class="col-md-8 ">
                                    <div><b class="item-detail-title"></b></div>
                                </div>
                            </div>
                            {{--内容--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">内容</label>
                                <div class="col-md-8 ">
                                    <div class="item-detail-content"></div>
                                </div>
                            </div>
                            {{--附件--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">附件</label>
                                <div class="col-md-8 ">
                                    <div class="item-detail-attachment"></div>
                                </div>
                            </div>
                            {{--说明--}}
                            <div class="form-group _none">
                                <label class="control-label col-md-2">说明</label>
                                <div class="col-md-8 control-label" style="text-align:left;">
                                    <span class="">这是一段说明。</span>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="box-footer">
                        <div class="row _none">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="button" class="btn btn-success" id="item-site-submit"><i class="fa fa-check"></i> 提交</button>
                                <button type="button" class="btn btn-default modal-cancel" id="item-site-cancel">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
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
                "aLengthMenu": [[50, 100, 200], ["50", "100", "200"]],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    'url': "{{ url('/admin/item/item-list-for-doc') }}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.keyword = $('input[name="keyword"]').val();
                        d.website = $('input[name="website"]').val();
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
                        "width": "32px",
                        "title": "选择",
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            return '<label><input type="checkbox" name="bulk-id" class="minimal" value="'+data+'"></label>';
                        }
                    },
                    {
                        "width": "32px",
                        "title": "序号",
                        "data": null,
                        "targets": 0,
                        'orderable': false
                    },
                    {
                        "className": "font-12px",
                        "width": "48px",
                        "title": "ID",
                        "data": "id",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "120px",
                        "title": "类型",
                        "data": "item_type",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            var $item_type_html = 'item';

                            if(data == 0) $item_type_html = 'item';
                            else if(data == 1) $item_type_html = '<small class="btn-xs bg-primary">文章</small>';
                            else if(data == 9) $item_type_html = '<small class="btn-xs bg-olive">活动</small>';
                            else if(data == 11)
                            {
                                if(row.item_id == 0)
                                {
                                    $item_type_html = '<small class="btn-xs bg-orange">书目.封面</small>';
                                }
                                else
                                {
                                    $item_type_html = '<small class="btn-xs bg-orange">书目.原子</small>';
                                }
                            }
                            else if(data == 18)
                            {
                                if(row.item_id == 0)
                                {
                                    $item_type_html = '<small class="btn-xs bg-purple">时间线.封面</small>';
                                }
                                else
                                {
                                    $item_type_html = '<small class="btn-xs bg-purple">时间线.原子</small>';
                                }
                            }
                            else if(data == 22) $item_type_html = '<small class="btn-xs bg-orange">辩题</small>';
                            else if(data == 29) $item_type_html = '<small class="btn-xs bg-maroon">投票</small>';
                            else $item_type_html = '<small class="btn-xs bg-black">有误</small>';

                            return $item_type_html;
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "",
                        "title": "标题",
                        "data": "title",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/item/'+row.id+'">'+data+'</a>';
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "120px",
                        "title": "拥有者",
                        "data": "owner_id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return row.owner == null ? '未知' : '<a target="_blank" href="/user/'+row.owner.id+'">'+row.owner.username+'</a>';
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "120px",
                        "title": "发布者",
                        "data": "creator_id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return row.creator == null ? '未知' : '<a target="_blank" href="/user/'+row.creator.id+'">'+row.creator.username+'</a>';
                        }
                    },
                    {
                        "width": "32px",
                        "title": "浏览",
                        "data": "visit_num",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "width": "32px",
                        "title": "分享",
                        "data": "share_num",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "className": "font-12px",
                        "width": "112px",
                        "title": "创建时间",
                        "data": 'created_at',
                        "orderable": true,
                        render: function(data, type, row, meta) {
//                            return data;
                            var $date = new Date(data*1000);
                            var $year = $date.getFullYear();
                            var $month = ('00'+($date.getMonth()+1)).slice(-2);
                            var $day = ('00'+($date.getDate())).slice(-2);
                            var $hour = ('00'+$date.getHours()).slice(-2);
                            var $minute = ('00'+$date.getMinutes()).slice(-2);
                            var $second = ('00'+$date.getSeconds()).slice(-2);
//                            return $year+'-'+$month+'-'+$day;
                            return $year+'-'+$month+'-'+$day+'&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;
                        }
                    },
                    {
                        "className": "font-12px",
                        "width": "112px",
                        "title": "修改时间",
                        "data": 'updated_at',
                        "orderable": true,
                        render: function(data, type, row, meta) {
//                            return data;
                            var $date = new Date(data*1000);
                            var $year = $date.getFullYear();
                            var $month = ('00'+($date.getMonth()+1)).slice(-2);
                            var $day = ('00'+($date.getDate())).slice(-2);
                            var $hour = ('00'+$date.getHours()).slice(-2);
                            var $minute = ('00'+$date.getMinutes()).slice(-2);
                            var $second = ('00'+$date.getSeconds()).slice(-2);
//                            return $year+'-'+$month+'-'+$day;
                            return $year+'-'+$month+'-'+$day+'&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;
                        }
                    },
                    {
                        "width": "64px",
                        "title": "状态",
                        "data": "active",
                        "orderable": false,
                        render: function(data, type, row, meta) {
//                            return data;
                            if(row.deleted_at != null)
                            {
                                return '<small class="btn-xs bg-black">已删除</small>';
                            }

                            if(row.item_status == 1)
                            {
                                if(data == 0)
                                {
                                    return '<small class="btn-xs bg-teal">待发布</small>';
                                }
                                else if(data == 1)
                                {
                                    return '<small class="btn-xs bg-olive">已发布</small>';
//                                if(row.is_read == 0) return '<small class="btn-xs bg-olive">未读</small>';
//                                else if(row.is_read == 1) return '<small class="btn-xs bg-primary">已读</small>';
//                                else return "--";
                                }
                                else if(data == 9)
                                {
                                    return '<small class="btn-xs bg-purple">已完成</small>';
                                }
                                else return "有误";
                            }
                            else
                            {
                                return '<small class="btn-xs btn-danger">已封禁</small>';
                            }
                        }
                    },
                    {
                        "width": "288px",
                        "title": "操作",
                        "data": 'id',
                        "orderable": false,
                        render: function(data, type, row, meta) {

                            if(row.item_status == 1)
                            {
                                $html_able = '<a class="btn btn-xs btn-danger item-admin-disable-submit" data-id="'+data+'">封禁</a>';
                            }
                            else
                            {
                                $html_able = '<a class="btn btn-xs btn-success item-admin-enable-submit" data-id="'+data+'">解禁</a>';
                            }

                            if(row.is_me == 1 && row.active == 0)
                            {
                                $html_publish = '<a class="btn btn-xs bg-olive item-publish-submit" data-id="'+data+'">发布</a>';
                            }
                            else
                            {
                                $html_publish = '<a class="btn btn-xs btn-default disabled" data-id="'+data+'">发布</a>';
                            }

                            var html =
                                    $html_able+
//                                    '<a class="btn btn-xs" href="/item/edit?id='+data+'">编辑</a>'+
                                    '<a class="btn btn-xs btn-primary item-edit-link" data-id="'+data+'">编辑</a>'+
                                    $html_publish+
                                    '<a class="btn btn-xs bg-navy item-admin-delete-submit" data-id="'+data+'">删除</a>'+
                                    '<a class="btn btn-xs bg-navy item-admin-delete-permanently-submit" data-id="'+data+'">永久删除</a>'+
//                                    '<a class="btn btn-xs bg-primary item-detail-show" data-id="'+data+'">查看详情</a>'+
                                    '<a class="btn btn-xs bg-purple item-statistic-submit" data-id="'+data+'">流量统计</a>'+
//                                    '<a class="btn btn-xs bg-olive item-download-qr-code-submit" data-id="'+data+'">下载二维码</a>'+
                                    '';
                            return html;

                        }
                    }
                ],
                "drawCallback": function (settings) {

                    let startIndex = this.api().context[0]._iDisplayStart;//获取本页开始的条数
                    this.api().column(1).nodes().each(function(cell, i) {
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
@include(env('LW_TEMPLATE_SUPER_ADMIN').'entrance.item.item-list-script')
@endsection

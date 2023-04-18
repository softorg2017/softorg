@extends(env('TEMPLATE_ADMIN').'admin.layout.layout')


@section('head_title','赞助商列表 - 管理员后台 - 如未科技')


@section('header','')
@section('description','赞助商列表 - 管理员后台 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">赞助商列表</h3>

                <div class="caption pull-right">
                    <i class="icon-pin font-blue"></i>
                    <span class="caption-subject font-blue sbold uppercase"></span>
                    <a href="{{ url('/admin/user/user-create') }}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-plus"></i> 添加组织/赞助商</button>
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

            <div class="box-body datatable-body" id="item-main-body">


                <div class="row col-md-12 datatable-search-row">
                    <div class="input-group">

                        <input type="text" class="form-control form-filter item-search-keyup" name="username" placeholder="代理商" />

                        <button type="button" class="form-control btn btn-flat btn-success filter-submit" id="filter-submit">
                            <i class="fa fa-search"></i> 搜索
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-default filter-cancel">
                            <i class="fa fa-circle-o-notch"></i> 重置
                        </button>

                    </div>
                </div>


                <!-- datatable start -->
                <table class='table table-striped- table-bordered- table-hover' id='datatable_ajax'>
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


<div class="modal fade" id="modal-password-body">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;background:#fff;">

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET-->
                <div class="box- box-info- form-container">

                    <div class="box-header with-border" style="margin:16px 0;">
                        <h3 class="box-title">修改密码</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <form action="" method="post" class="form-horizontal form-bordered" id="form-change-password-modal">
                        <div class="box-body">

                            {{csrf_field()}}
                            <input type="hidden" name="operate" value="change-password" readonly>
                            <input type="hidden" name="id" value="0" readonly>

                            {{--类别--}}


                            {{--用户ID--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">新密码</label>
                                <div class="col-md-8 control-label" style="text-align:left;">
                                    <input type="password" class="form-control form-filter" name="user-password" value="">
                                    6-20位英文、数值、下划线构成
                                </div>
                            </div>
                            {{--用户名--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">确认密码</label>
                                <div class="col-md-8 control-label" style="text-align:left;">
                                    <input type="password" class="form-control form-filter" name="user-password-confirm" value="">
                                </div>
                            </div>


                        </div>
                    </form>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="button" class="btn btn-success" id="item-change-password-submit"><i class="fa fa-check"></i> 提交</button>
                                <button type="button" class="btn btn-default" id="item-change-password-cancel">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
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
                        <h3 class="box-title">代理商充值</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-modal">
                    <div class="box-body">

                        {{csrf_field()}}
                        <input type="hidden" name="operate" value="recharge" readonly>
                        <input type="hidden" name="id" value="0" readonly>

                        {{--类别--}}


                        {{--用户ID--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">用户ID</label>
                            <div class="col-md-8 control-label" style="text-align:left;">
                                <span class="recharge-user-id"></span>
                            </div>
                        </div>
                        {{--用户名--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">用户名</label>
                            <div class="col-md-8 control-label" style="text-align:left;">
                                <span class="recharge-username"></span>
                            </div>
                        </div>
                        {{--真实姓名--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">充值金额</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="recharge-amount" placeholder="充值金额" value="">
                            </div>
                        </div>
                        {{--备注--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">备注</label>
                            <div class="col-md-8 ">
                                {{--<input type="text" class="form-control" name="description" placeholder="描述" value="">--}}
                                <textarea class="form-control" name="description" rows="3" cols="100%"></textarea>
                            </div>
                        </div>
                        {{--说明--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">说明</label>
                            <div class="col-md-8 control-label" style="text-align:left;">
                                <span class="">正数为充值，负数为退款，退款金额不能超过资金余额。</span>
                            </div>
                        </div>


                    </div>
                    </form>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="button" class="btn btn-success" id="item-recharge-submit"><i class="fa fa-check"></i> 提交</button>
                                <button type="button" class="btn btn-default" id="item-recharge-cancel">取消</button>
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
                "aLengthMenu": [[40, 50, 200], ["40", "50", "200"]],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    'url': "{{ url('/admin/user/user-sponsor-list') }}",
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
                        "title": "ID",
                        "data": "id",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "",
                        "title": "赞助商",
                        "data": "id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/user/'+data+'">'+row.username+'</a>';
                        }
                    },
                    {
                        "width": "72px",
                        "title": "用户类型",
                        "data": 'user_type',
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            if(data == 0) return 'item';
                            else if(data == 1) return '<small class="btn-xs bg-primary">个人用户</small>';
                            else if(data == 11) return '<small class="btn-xs bg-olive">组织</small>';
                            else if(data == 88) return '<small class="btn-xs bg-purple">赞助商</small>';
                            else return "有误";
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "96px",
                        "title": "手机号",
                        "data": "mobile",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "128px",
                        "title": "负责人",
                        "data": "id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            if(row.principal) {
                                return '<a target="_blank" href="/admin/user/agent?id='+data+'">'+row.principal.username+'</a>';
                            }
                            else return '--';
                        }
                    },
                    {
                        "width": "72px",
                        "title": "成员数",
                        "data": "id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            if(row.member_count && row.member_count > 0)
                            {
                                return '<a target="_blank" href="/admin/user/member?user-id='+data+'">'+row.member_count+'</a>';
                            }
                            else return '--';
                        }
                    },
                    {
                        "width": "72px",
                        "title": "粉丝数",
                        "data": "fund_total",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            if(row.fans_count && row.fans_count > 0)
                            {
                                return '<a target="_blank" href="/admin/user/fans?user-id='+data+'">'+row.fans_count+'</a>';
                            }
                            else return '--';
                        }
                    },
                    {
                        "width": "72px",
                        "title": "浏览数",
                        "data": "visit_num",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "width": "72px",
                        "title": "分享数",
                        "data": "share_num",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "width": "128px",
                        "title": "创建时间",
                        "data": "created_at",
                        "orderable": true,
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
                            return $year+'-'+$month+'-'+$day;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
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
                            if(row.user_status == 1)
                            {
                                return '<small class="btn-xs btn-success">正常</small>';
                            }
                            else
                            {
                                return '<small class="btn-xs btn-danger">已封禁</small>';
                            }
                        }
                    },
                    {
                        "width": "300px",
                        "title": "操作",
                        "data": "id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            if(row.user_status == 1)
                            {
                                $html_0 =
                                    '<a class="btn btn-xs btn-danger user-admin-disable-submit" data-id="'+data+'">封禁</a>'+
                                    '';
                            }
                            else
                            {
                                $html_0 =
                                    '<a class="btn btn-xs btn-success user-admin-enable-submit" data-id="'+data+'">解禁</a>'+
                                    '';
                            }

                            var html =
//                                '<a class="btn btn-xs btn-primary item-recharge-show" data-id="'+data+'">充值/退款</a>'+
                                $html_0+
                                '<a class="btn btn-xs btn-primary item-edit-submit" data-id="'+data+'">编辑</a>'+
                                '<a class="btn btn-xs bg-maroon item-change-password-show" data-id="'+data+'">修改密码</a>'+
                                '<a class="btn btn-xs bg-navy item-delete-submit" data-id="'+data+'" >删除</a>'+
                                '<a class="btn btn-xs bg-olive item-login-submit" data-id="'+data+'">登录</a>'+
                                '<a class="btn btn-xs bg-purple item-statistic-submit" data-id="'+data+'">流量统计</a>'+
//                                '<a class="btn btn-xs item-download-qr-code-submit" data-id="'+data+'">下载二维码</a>'+
                                '';
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
@include(env('TEMPLATE_ADMIN').'admin.entrance.user.user-script')
@endsection

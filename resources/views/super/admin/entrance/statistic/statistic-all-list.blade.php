@extends(env('TEMPLATE_ADMIN').'admin.layout.layout')


@section('head_title','记录列表 - 管理员后台系统 - 朝鲜族组织平台 - 如未科技')


@section('header','')
@section('description','管理员后台系统 - 朝鲜族组织平台 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info main-list-body">

            <div class="box-header with-border" style="margin:16px 0;">

                <h3 class="box-title">记录列表</h3>

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

                        <select class="form-control form-filter" name="open_device_type" style="width:96px;">
                            <option value ="0">设备</option>
                            <option value ="1">移动端</option>
                            <option value ="2">PC端</option>
                            <option value ="Others">其他</option>
                        </select>

                        <select class="form-control form-filter" name="open_system" style="width:96px;">
                            <option value ="0">系统</option>
                            <option value ="1">默认</option>
                            <option value ="Android">Android</option>
                            <option value ="iPhone">iPhone</option>
                            <option value ="iPad">iPad</option>
                            <option value ="Mac">Mac</option>
                            <option value ="Windows">Windows</option>
                            <option value ="Others">其他</option>
                        </select>

                        <select class="form-control form-filter" name="open_browser" style="width:80px;">
                            <option value ="0">浏览器</option>
                            <option value ="1">默认</option>
                            <option value ="Chrome">Chrome</option>
                            <option value ="Firefox">Firefox</option>
                            <option value ="Safari">Safari</option>
                            <option value ="Others">其他</option>
                        </select>

                        <select class="form-control form-filter" name="open_app" style="width:80px;">
                            <option value ="0">APP</option>
                            <option value ="1">默认</option>
                            <option value ="WeChat">WeChat</option>
                            <option value ="QQ">QQ</option>
                            <option value ="Alipay">Alipay</option>
                            <option value ="Others">其他</option>
                        </select>

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
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
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
                                <option value ="待审核">待审核</option>
                                <option value ="优化中">优化中</option>
                                <option value ="合作停">合作停</option>
                                <option value ="">被拒绝</option>
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
@endsection


@section('custom-script')
<script>
    var TableDatatablesAjax = function () {
        var datatableAjax = function () {

            var dt = $('#datatable_ajax');
            var ajax_datatable = dt.DataTable({
//                "aLengthMenu": [[20, 50, 200, 500, -1], ["20", "50", "200", "500", "全部"]],
                "aLengthMenu": [[50, 100, 200], ["50", "10", "200"]],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    'url': "{{ url('/admin/statistic/statistic-all-list') }}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.title = $('input[name="title"]').val();
                        d.open_device_type = $('select[name="open_device_type"]').val();
                        d.open_system = $('select[name="open_system"]').val();
                        d.open_browser = $('select[name="open_browser"]').val();
                        d.open_app = $('select[name="open_app"]').val();
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
                        "width": "48px",
                        "title": "操作",
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(row.record_type == 1)
                            {
                                return '<small class="btn-xs bg-primary">访问</small>';
                            }
                            else if(row.record_type == 2)
                            {
                                return '<small class="btn-xs bg-olive">分享</small>';
                            }
                            else if(row.record_type == 3)
                            {
                                return '<small class="btn-xs bg-purple">查询</small>';
                            }
                            else return "有误";

                        }
                    },
                    {
                        "width": "72px",
                        "title": "类型",
                        "data": "id",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(row.page_type == 1)
                            {
                                return '<small class="btn-xs bg-primary">平台</small>';
                            }
                            else if(row.page_type == 2)
                            {
                                if(row.page_module == 0) return 'user';
                                else if(row.page_module == 1) return '<small class="btn-xs bg-olive">U•首页</small>';
                                else if(row.page_module == 2) return '<small class="btn-xs bg-olive">U•介绍</small>';
                                else if(row.page_module == 9) return '<small class="btn-xs bg-olive">U•文章</small>';
                                else if(row.page_module == 11) return '<small class="btn-xs bg-olive">U•活动</small>';
                                else return "user page error";
                            }
                            else if(row.page_type == 3)
                            {
                                if(row.page_module == 0) return 'item';
                                else if(row.page_module == 1) return '<small class="btn-xs bg-purple">ITEM</small>';
                                else return "item page error";
                            }
                            else return "有误";

                        }
                    },
                    {
                        "className": "text-left",
                        "width": "",
                        "title": "页面",
                        "data": "creator_id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            if(row.record_type == 3)
                            {
                                return '<a target="_blank" href="/tag/'+row.title+'">'+"#"+row.title+'</a>';
                            }

                            if(row.page_type == 1)
                            {
                                if(row.page_module == 0) return 'platform';
                                else if(row.page_module == 1) return '<small class="btn-xs bg-primary">首页</small>';
                                else if(row.page_module == 2) return '<small class="btn-xs bg-primary">介绍页</small>';
                                else if(row.page_module == 9) return '<small class="btn-xs bg-primary">文章页</small>';
                                else if(row.page_module == 11) return '<small class="btn-xs bg-primary">活动页</small>';
                                else if(row.page_module == 33) return '<small class="btn-xs bg-primary">组织列表</small>';
                                else return "platform error";
                            }
                            else if(row.page_type == 2)
                            {
                                if(row.object)
                                {
                                    return '<a target="_blank" href="/user/'+row.object.id+'">'+row.object.username+'</a>';
                                }
                                else
                                {
                                    return "object_id.id="+row.object_id;
                                }
                            }
                            else if(row.page_type == 3)
                            {
                                if(row.item)
                                {
                                    return '<a target="_blank" href="/item/'+row.item.id+'">'+row.item.title+'</a>';
                                }
                                else
                                {
                                    return "item.id="+row.item_id+"，该内容已删除。";
                                }
                            }
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "",
                        "title": "访问者",
                        "data": "creator_id",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return row.creator == null
                                ? '<small class="btn-xs bg-black">游客</small>'
                                : '<a target="_blank" href="/user/'+row.creator.id+'">'+row.creator.username+'</a>';
                        }
                    },
                    {
                        "className": "",
                        "width": "64px",
                        "title": "移动端",
                        "data": "open_device_type",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            if(data == 1) return '<small class="btn-xs bg-primary">移动端</small>';
                            else if(data == 2) return '<small class="btn-xs bg-olive">PC端</small>';
                            else return '有误';
                        }
                    },
                    {
                        "className": "",
                        "width": "64px",
                        "title": "系统",
                        "data": "open_system",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            if(data == "Unknown") return '<small class="btn-xs bg-black">未知</small>';
                            else if(data == "Android") return '<small class="btn-xs bg-primary">安卓</small>';
                            else if(data == "iPhone") return '<small class="btn-xs bg-olive">苹果</small>';
                            else if(data == "iPad") return '<small class="btn-xs bg-olive">iPad</small>';
                            else if(data == "Mac") return '<small class="btn-xs bg-olive">Mac</small>';
                            else if(data == "Windows") return '<small class="btn-xs bg-purple">微软</small>';
                            else return data;
                        }
                    },
                    {
                        "className": "",
                        "width": "64px",
                        "title": "浏览器",
                        "data": "open_browser",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            if(data == "Unknown") return '<small class="btn-xs bg-black">未知</small>';
                            else return data;
                        }
                    },
                    {
                        "className": "",
                        "width": "64px",
                        "title": "APP",
                        "data": "open_app",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            if(data == "Unknown") return '<small class="btn-xs bg-black">未知</small>';
                            else if(data == "WeChat") return '<small class="btn-xs bg-olive">微信</small>';
                            else if(data == "QQ") return '<small class="btn-xs bg-orange">QQ</small>';
                            else if(data == "Alipay") return '<small class="btn-xs bg-primary">支付宝</small>';
                            else return data;
                        }
                    },
                    {
                        "className": "text-left",
                        "width": "88px",
                        "title": "IP",
                        "data": "ip",
                        "orderable": false,
                        render: function(data, type, row, meta) {

                            return '<a target="_blank" href="https://www.ip138.com/iplookup.asp?action=2&ip='+data+'">'+data+'</a>';

                            return data;
                        }
                    },
                    {
                        "className": "font-12px",
                        "width": "96px",
                        "title": "访问时间",
                        "data": 'created_at',
                        "orderable": true,
                        render: function(data, type, row, meta) {
//                            return data;
                            var $date = new Date(data*1000);
                            var $year = $date.getFullYear();
                            var $month = ($date.getMonth()+1);
                            var $day = $date.getDate();
//                            var $year = ('0000'+$date.getFullYear()).slice(-2);
//                            var $month = ('00'+($date.getMonth()+1)).slice(-2);
//                            var $day = ('00'+($date.getDate())).slice(-2);
                            var $hour = ('00'+$date.getHours()).slice(-2);
                            var $minute = ('00'+$date.getMinutes()).slice(-2);
                            var $second = ('00'+$date.getSeconds()).slice(-2);
//                            return $year+'-'+$month+'-'+$day;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;
                            return $year+'.'+$month+'.'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
                        }
                    },
                    {
                        "width": "112px",
                        "title": "操作",
                        "data": 'id',
                        "orderable": false,
                        render: function(data, type, row, meta) {

                            var html =
                                    '<a class="btn btn-xs bg-navy item-admin-delete-submit" data-id="'+data+'">删除</a>'+
                                    '<a class="btn btn-xs bg-primary item-detail-show" data-id="'+data+'">查看详情</a>'+
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
@include(env('TEMPLATE_ADMIN').'admin.entrance.statistic.statistic-script')
@endsection

@extends(env('LW_TEMPLATE_ATOM_ADMIN').'layout.layout')


@section('head_title')
    @if(in_array(env('APP_ENV'),['local','dev'])){{ $local or 'L.' }}@endif
    {{ $title_text or '全部内容' }} - 原子系统 - 如未科技
@endsection


@section('header','')
@section('description','全部内容 - 原子系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">

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


            <div class="box-body datatable-body item-main-body" id="datatable-for-item-list">

                <div class="row col-md-12 datatable-search-row">
                    <div class="input-group">

                        <input type="text" class="form-control form-filter item-search-keyup" name="name" placeholder="名称" />
                        {{--<input type="text" class="form-control form-filter item-search-keyup" name="title" placeholder="标题" />--}}
                        <input type="text" class="form-control form-filter item-search-keyup" name="tag" placeholder="标签" />

                        <select class="form-control form-filter" name="item-type" style="width:88px;">
                            <option value ="-1">全部</option>
                            <option value ="1">物</option>
                            <option value ="11">人</option>
                            <option value ="22">作品</option>
                            <option value ="33">事件</option>
                            <option value ="91">概念</option>
                        </select>


                        <button type="button" class="form-control btn btn-flat bg-teal filter-empty">
                            <i class="fa fa-remove"></i> 清空重选
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-success filter-submit" id="filter-submit">
                            <i class="fa fa-search"></i> 搜索
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-primary filter-refresh">
                            <i class="fa fa-circle-o-notch"></i> 刷新
                        </button>
                        <button type="button" class="form-control btn btn-flat btn-warning filter-cancel">
                            <i class="fa fa-undo"></i> 重置
                        </button>

                    </div>
                </div>

                <div class="tableArea">
                <table class='table table-striped table-bordered table-hover' id='datatable_ajax'>
                    <thead>
                        <tr role='row' class='heading'>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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


{{--详细-信息--}}
@include(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-modal-for-item-set')
@endsection




@section('custom-style')
    <style>
        .tableArea table { min-width:1360px; }

        .select2-container { height:100%; border-radius:0; float:left; }
        .select2-container .select2-selection--single { border-radius:0; }
    </style>
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
                    'url': "{{ url('/admin/item/item-list-for-all') }}",
                    "type": 'POST',
                    "dataType" : 'json',
                    "data": function (d) {
                        d._token = $('meta[name="_token"]').attr('content');
                        d.name = $('input[name="name"]').val();
                        d.title = $('input[name="title"]').val();
                        d.tag = $('input[name="tag"]').val();
                        d.major = $('input[name="major"]').val();
                        d.naiton = $('input[name="naiton"]').val();
                        d.select_classified = $('select[name="select-classified"]').val();
                        d.type = $('select[name="item-type"]').val();
                    },
                },
                "pagingType": "simple_numbers",
                "order": [],
                "orderCellsTop": true,
                // "autoWidth": true,
                "scrollX": true,
//                "scrollY": true,
                "showRefresh": true,
                "columns": [
                    {
                        "title": "ID",
                        "data": "id",
                        "className": "",
                        "width": "60px",
                        "orderable": true,
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "title": "操作",
                        "data": 'id',
                        "className": "",
                        "width": "80px",
                        "orderable": false,
                        render: function(data, type, row, meta) {

                            var $html_edit = '<a class="btn btn-xs btn-primary item-edit-link" data-id="'+data+'">编辑</a>';
                            var $html_detail = '<a class="btn btn-xs bg-primary item-detail-show" data-id="'+data+'">查看详情</a>';
                            var $html_delete = '';
                            var $html_publish = '';
                            var $html_able = '';

                            // 是否删除
                            if(row.deleted_at)
                            {
                                $html_delete = '<a class="btn btn-xs bg-olive item-restore-submit" data-id="'+data+'">恢复</a>';
                                $html_delete = '<li><a class="btn btn-xs item-restore-submit" data-id="'+data+'">恢复</a></li>';
                                $html_delete += '<li><a class="btn btn-xs item-delete-permanently-submit" data-id="'+data+'">永久删除</a></li>';
                            }
                            else
                            {
                                $html_delete = '<a class="btn btn-xs bg-navy item-delete-submit" data-id="'+data+'">删除</a>';
                                $html_delete = '<li><a class="btn btn-xs item-delete-submit" data-id="'+data+'">删除</a></li>';


                                // 是否发布
                                if(row.is_published == 0)
                                {
                                    $html_publish = '<li><a class="btn btn-xs item-publish-submit" data-id="'+data+'">发布</a></li>';
                                }
                                else
                                {
                                    // 是否启用
                                    if(row.item_status == 1)
                                    {
                                        $html_able = '<li><a class="btn btn-xs item-disable-submit" data-id="'+data+'">禁用</a></li>';
                                    }
                                    else
                                    {
                                        $html_able = '<li><a class="btn btn-xs item-enable-submit" data-id="'+data+'">启用</a></li>';
                                    }
                                }
                            }


                            var $more_html =
                                '<div class="btn-group">'+
                                '<button type="button" class="btn btn-xs btn-success btn-group-body item-edit-link" data-id="'+data+'">编辑</button>'+
                                '<button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true">'+
                                '<span class="caret"></span>'+
                                '<span class="sr-only">Toggle Dropdown</span>'+
                                '</button>'+
                                '<ul class="dropdown-menu" role="menu">'+
                                $html_publish+
                                $html_able+
                                $html_delete+
                                '<li class="divider"></li>'+
                                '<li><a href="#">Separate</a></li>'+
                                '</ul>'+
                                '</div>';

                            return $more_html;
                        }
                    },
                    {
                        "title": "状态",
                        "data": "item_status",
                        "className": "",
                        "width": "80px",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            // 是否删除
                            if(row.deleted_at != null)
                            {
                                return '<small class="btn-xs bg-black">已删除</small>';
                            }

                            // 是否发布
                            if(row.is_published == 0)
                            {
                                return '<small class="btn-xs bg-teal">待发布</small>';
                            }
                            else if(row.is_published == 1)
                            {

                                // 是否启用
                                if(row.item_status == 1)
                                {
                                    return '<small class="btn-xs bg-olive">启用</small>';

                                    // 是否完成
                                    if(row.is_completed == 1)
                                    {
                                        return '<small class="btn-xs bg-purple">已完成</small>';
                                    }
                                    else return "有误";
                                }
                                else
                                {
                                    return '<small class="btn-xs btn-danger">禁用</small>';
                                }

                            }
                            else return "有误";

                        }
                    },
                    {
                        "title": "类型",
                        "data": "item_type",
                        "className": "",
                        "width": "60px",
                        'orderable': false,
                        render: function(data, type, row, meta) {
                            if(data == 0) return 'item';
                            else if(data == 1) return '<small class="btn-xs bg-olive">物</small>';
                            else if(data == 11) return '<small class="btn-xs bg-primary">人</small>';
                            else if(data == 22) return '<small class="btn-xs bg-orange">作品</small>';
                            else if(data == 33) return '<small class="btn-xs bg-maroon">事件</small>';
                            else if(data == 91) return '<small class="btn-xs bg-purple">概念</small>';
                            else return "有误";
                        }
                    },
                    {
                        "title": "标题",
                        "data": "name",
                        "className": "text-left",
                        "width": "160px",
                        "orderable": false,
                        "fnCreatedCell": function (nTd, data, row, iRow, iCol) {
                            if(row.is_completed != 1 && row.item_status != 97)
                            {
                                $(nTd).addClass('modal-show-for-item-text-set');
                                $(nTd).attr('data-id',row.id).attr('data-name','标题');
                                $(nTd).attr('data-key','name').attr('data-value',data);
                                $(nTd).attr('data-column-name','标题');
                                $(nTd).attr('data-text-type','text');
                                if(data) $(nTd).attr('data-operate-type','edit');
                                else $(nTd).attr('data-operate-type','add');
                            }
                        },
                        render: function(data, type, row, meta) {
                            return '<a target="_blank" href="/item/'+row.id+'">'+data+'</a>';
                        }
                    },
                    {
                        "title": "标签",
                        "data": "tag",
                        "className": "text-left",
                        "width": "120px",
                        "orderable": false,
                        "fnCreatedCell": function (nTd, data, row, iRow, iCol) {
                            if(row.is_completed != 1 && row.item_status != 97)
                            {
                                $(nTd).addClass('modal-show-for-item-text-set');
                                $(nTd).attr('data-id',row.id).attr('data-name','标签');
                                $(nTd).attr('data-key','tag').attr('data-value',data);
                                $(nTd).attr('data-column-name','标签');
                                $(nTd).attr('data-text-type','text');
                                if(data) $(nTd).attr('data-operate-type','edit');
                                else $(nTd).attr('data-operate-type','add');
                            }
                        },
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "title": "描述",
                        "data": "sub_desc",
                        "className": "text-left",
                        "width": "",
                        "fnCreatedCell": function (nTd, data, row, iRow, iCol) {
                            console.log(data);
                            if(row.is_completed != 1 && row.item_status != 97)
                            {
                                $(nTd).addClass('modal-show-for-item-text-set');
                                $(nTd).attr('data-id',row.id).attr('data-name','描述');
                                $(nTd).attr('data-key','sub_desc').attr('data-value',data);
                                $(nTd).attr('data-column-name','描述');
                                $(nTd).attr('data-text-type','textarea');
                                if(data) $(nTd).attr('data-operate-type','edit');
                                else $(nTd).attr('data-operate-type','add');
                            }
                        },
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            // return data;
                            if(data) return data.replace(/\n/g,"<br/>");
                            else return data;
                        }
                    },
                    {
                        "title": "发布者",
                        "data": "creator_id",
                        "className": "",
                        "width": "60px",
                        "orderable": false,
                        render: function(data, type, row, meta) {
                            return row.creator == null ? '未知' : '<a target="_blank" href="/user/'+row.creator.id+'">'+row.creator.username+'</a>';
                        }
                    },
                    {
                        "title": "创建时间",
                        "data": 'created_at',
                        "className": "",
                        "width": "100px",
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
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;

                            return $year+'-'+$month+'-'+$day;
                        }
                    },
                    {
                        "className": "font-12px",
                        "width": "120px",
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
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
//                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute+':'+$second;

                            return $year+'-'+$month+'-'+$day+'&nbsp;&nbsp;'+$hour+':'+$minute;
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
@include(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-script')
@endsection

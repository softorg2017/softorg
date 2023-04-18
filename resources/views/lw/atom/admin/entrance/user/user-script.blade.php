<script>
    $(function() {

        // 【搜索】
        $(".item-main-body").on('click', ".filter-submit", function() {
            $('#datatable_ajax').DataTable().ajax.reload();
        });
        // 【重置】
        $(".item-main-body").on('click', ".filter-cancel", function() {
            $('textarea.form-filter, input.form-filter, select.form-filter').each(function () {
                $(this).val("");
            });

//                $('select.form-filter').selectpicker('refresh');
            $('select.form-filter option').attr("selected",false);
            $('select.form-filter').find('option:eq(0)').attr('selected', true);

            $('#datatable_ajax').DataTable().ajax.reload();
        });
        // 【查询】回车
        $(".item-main-body").on('keyup', ".item-search-keyup", function(event) {
            if(event.keyCode ==13)
            {
                $("#filter-submit").click();
            }
        });


        // 【下载二维码】
        $("#item-main-body").on('click', ".item-download-qr-code-submit", function() {
            var that = $(this);
            window.open("/download/qr-code?type=user&id="+that.attr('data-id'));
        });

        // 【数据分析】
        $("#item-main-body").on('click', ".item-statistic-submit", function() {
            var that = $(this);
            window.open("/admin/statistic/statistic-user?id="+that.attr('data-id'));
//            window.location.href = "/admin/statistic/statistic-user?id="+that.attr('data-id');
        });

        // 【编辑】
        $("#item-main-body").on('click', ".item-edit-submit", function() {
            var that = $(this);
            window.location.href = "/admin/user/user-edit?id="+that.attr('data-id');
        });




        // 显示【修改密码】
        $("#item-main-body").on('click', ".item-change-password-show", function() {
            var that = $(this);
            $('input[name=id]').val(that.attr('data-id'));
            $('input[name=user-password]').val('');
            $('input[name=user-password-confirm]').val('');
            $('#modal-password-body').modal('show');
        });
        // 【修改密码】取消
        $("#modal-password-body").on('click', "#item-change-password-cancel", function() {
            $('input[name=id]').val('');
            $('input[name=user-password]').val('');
            $('input[name=user-password-confirm]').val('');
            $('#modal-password-body').modal('hide');
        });
        // 【修改密码】提交
        $("#modal-password-body").on('click', "#item-change-password-submit", function() {
            var that = $(this);
            layer.msg('确定"修改"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    var options = {
                        url: "{{ url('/admin/user/change-password') }}",
                        type: "post",
                        dataType: "json",
                        // target: "#div2",
                        success: function (data) {
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg(data.msg);
                                $('#modal-password-body').modal('hide');
                            }
                        }
                    };
                    $("#form-change-password-modal").ajaxSubmit(options);
                }
            });
        });




        // 显示【充值】
        $("#item-main-body").on('click', ".item-recharge-show", function() {
            var that = $(this);
            $('input[name=id]').val(that.attr('data-id'));
            $('.recharge-user-id').html(that.attr('data-id'));
            $('.recharge-username').html(that.attr('data-name'));
            $('#modal-body').modal('show');
        });
        // 【充值】取消
        $("#modal-body").on('click', "#item-recharge-cancel", function() {
            $('.recharge-user-id').html('');
            $('.recharge-username').html('');
            $('#modal-body').modal('hide');
        });
        // 【充值】提交
        $("#modal-body").on('click', "#item-recharge-submit", function() {
            var that = $(this);
            layer.msg('确定"充值"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    var options = {
                        url: "{{ url('/admin/user/agent-recharge') }}",
                        type: "post",
                        dataType: "json",
                        // target: "#div2",
                        success: function (data) {
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg(data.msg);
                                location.reload();
                            }
                        }
                    };
                    $("#form-edit-modal").ajaxSubmit(options);
                }
            });
        });


        // 关闭【充值限制】
        $("#item-main-body").on('click', ".item-recharge-limit-close-submit", function() {
            var that = $(this);
            layer.msg('确定"关闭"么?', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/agent-recharge-limit-close') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate:"recharge-limit-close",
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg("操作完成");
                                location.reload();
                            }
                        },
                        'json'
                    );
                }
            });
        });
        // 开启【充值限制】
        $("#item-main-body").on('click', ".item-recharge-limit-open-submit", function() {
            var that = $(this);
            layer.msg('确定"开启"么?', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/agent-recharge-limit-open') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate:"recharge-limit-open",
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg("操作完成");
                                location.reload();
                            }
                        },
                        'json'
                    );
                }
            });
        });




        // 关闭【二级代理】
        $("#item-main-body").on('click', ".item-sub-agent-close-submit", function() {
            var that = $(this);
            layer.msg('确定"关闭二级代理"么?', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/agent-sub-agent-close') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate:"sub-agent-close",
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg("操作完成");
                                location.reload();
                            }
                        },
                        'json'
                    );
                }
            });
        });
        // 开启【二级代理】
        $("#item-main-body").on('click', ".item-sub-agent-open-submit", function() {
            var that = $(this);
            layer.msg('确定"开启二级代理"么?', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/agent-sub-agent-open') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate:"sub-agent-open",
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg("操作完成");
                                location.reload();
                            }
                        },
                        'json'
                    );
                }
            });
        });




        // 【登录】
        $("#item-main-body").on('click', ".item-login-submit", function() {
            var that = $(this);
            $.post(
                "{{ url('/admin/user/user-login') }}",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    id:that.attr('data-id')
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        console.log(data);
//                        window.open('/');
                        var temp_window=window.open();
                        if(data.data.user.user_type == 1) temp_window.location='/';
                        else if(data.data.user.user_type == 11) temp_window.location='/org';
                        else if(data.data.user.user_type == 88) temp_window.location='/sponsor';

                    }
                },
                'json'
            );
        });




        // 【删除】
        $("#item-main-body").on('click', ".item-delete-submit", function() {
            var that = $(this);
            layer.msg('确定"删除"么?', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/agent-delete') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:that.attr('data-id')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.msg("操作完成");
                                location.reload();
                            }
                        },
                        'json'
                    );
                }
            });
        });




        // 【启用】
        $("#item-main-body").on('click', ".user-admin-enable-submit", function() {
            var that = $(this);
            layer.msg('确定"封禁"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/user-admin-enable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "user-admin-enable",
                            id:that.attr('data-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                $('#datatable_ajax').DataTable().ajax.reload(null,false);
                            }
                        },
                        'json'
                    );
                }
            });
        });
        // 【禁用】
        $("#item-main-body").on('click', ".user-admin-disable-submit", function() {
            var that = $(this);
            layer.msg('确定"解封"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/user/user-admin-disable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "user-admin-disable",
                            id:that.attr('data-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                $('#datatable_ajax').DataTable().ajax.reload(null,false);
                            }
                        },
                        'json'
                    );
                }
            });
        });

    });
</script>
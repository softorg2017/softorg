<script>
    $(function() {

        // 【搜索】
        $("#datatable-for-item-list").on('click', ".filter-submit", function() {
            $('#datatable_ajax').DataTable().ajax.reload();
        });
        // 【刷新】
        $("#datatable-for-item-list").on('click', ".filter-refresh", function() {
            $('#datatable_ajax').DataTable().ajax.reload(null,false);
        });
        // 【重置】
        $("#datatable-for-item-list").on('click', ".filter-cancel", function() {
            $('textarea.form-filter, input.form-filter, select.form-filter').each(function () {
                $(this).val("");
            });

//            $('select.form-filter').selectpicker('refresh');
            $('select.form-filter option').attr("selected",false);
            $('select.form-filter').find('option:eq(0)').attr('selected', true);

            $('#datatable_ajax').DataTable().ajax.reload();
        });
        // 【清空重选】
        $("#datatable-for-item-list").on('click', ".filter-empty", function() {
            $("#datatable-for-item-list").find('textarea.form-filter, input.form-filter, select.form-filter').each(function () {
                $(this).val("");
            });
            $(".select2-container").val(-1).trigger("change");

//            $('select.form-filter').selectpicker('refresh');
            $("#datatable-for-item-list").find('select.form-filter option').attr("selected",false);
            $("#datatable-for-item-list").find('select.form-filter').find('option:eq(0)').attr('selected', true);
        });
        // 【查询】回车
        $("#datatable-for-item-list").on('keyup', ".item-search-keyup", function(event) {
            if(event.keyCode ==13)
            {
                $("#filter-submit").click();
            }
        });




        // 【下载二维码】
        $("#datatable-for-item-list").on('click', ".item-download-qr-code-submit", function() {
            var that = $(this);
            window.open("/download/qr-code?type=item&id="+that.attr('data-id'));
        });

        // 【数据分析】
        $("#datatable-for-item-list").on('click', ".item-statistic-submit", function() {
            var that = $(this);
            window.open("/admin/statistic/statistic-item?id="+that.attr('data-id'));
//            window.location.href = "/atom/statistic/statistic-item?id="+that.attr('data-id');
        });

        // 【编辑】
        $("#datatable-for-item-list").on('click', ".item-edit-link", function() {
            var that = $(this);
            window.location.href = "/admin/item/item-edit?id="+that.attr('data-id');
        });




        // 内容【获取详情】
        $("").on('click', ".item-detail-show", function() {
            var that = $(this);
            var $data = new Object();
            $.ajax({
                type:"post",
                dataType:'json',
                async:false,
                url: "{{ url('/admin/item/item-get') }}",
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    operate:"item-get",
                    id:that.attr('data-id')
                },
                success:function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        $data = data.data;
                    }
                }
            });
            $('input[name=id]').val(that.attr('data-id'));
            $('.item-user-id').html(that.attr('data-user-id'));
            $('.item-username').html(that.attr('data-username'));
            $('.item-title').html($data.title);
            $('.item-content').html($data.content);
            if($data.attachment_name)
            {
                var $attachment_html = $data.attachment_name+'&nbsp&nbsp&nbsp&nbsp'+'<a href="/all/download-item-attachment?item-id='+$data.id+'">下载</a>';
                $('.item-attachment').html($attachment_html);
            }
            $('#modal-body').modal('show');

        });

        // 内容【删除】
        $(".main-content").on('click', ".item-delete-submit", function() {
            var that = $(this);
            layer.msg('确定要"删除"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-delete') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-delete",
                            id:that.attr('data-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            {
                                $('#datatable_ajax').DataTable().ajax.reload(null,false);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 内容【恢复】
        $(".main-content").on('click', ".item-restore-submit", function() {
            var that = $(this);
            layer.msg('确定要"恢复"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-restore') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-restore",
                            id:that.attr('data-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            {
                                $('#datatable_ajax').DataTable().ajax.reload(null,false);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 内容【永久删除】
        $(".main-content").on('click', ".item-delete-permanently-submit", function() {
            var that = $(this);
            layer.msg('确定要"永久删除"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-delete-permanently') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-delete-permanently",
                            id:that.attr('data-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            {
                                $('#datatable_ajax').DataTable().ajax.reload(null,false);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 内容【推送】
        $(".main-content").on('click', ".item-publish-submit", function() {
            var that = $(this);
            layer.msg('确定要"发布"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-publish') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-publish",
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




        // 【启用】
        $(".main-content").on('click', ".item-enable-submit", function() {
            var that = $(this);
            layer.msg('确定"封禁"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-enable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-enable",
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
        $(".main-content").on('click', ".item-disable-submit", function() {
            var that = $(this);
            layer.msg('确定"解禁"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/admin/item/item-disable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-disable",
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






        // 【修改-文本-text-属性】【显示】
        $(".main-content").on('dblclick', ".modal-show-for-item-text-set", function() {
            var $that = $(this);
            $('.item-text-set-title').html($that.attr("data-id"));
            $('.item-text-set-column-name').html($that.attr("data-name"));
            $('input[name=item-text-set-item-id]').val($that.attr("data-id"));
            $('input[name=item-text-set-column-key]').val($that.attr("data-key"));
            $('input[name=item-text-set-operate-type]').val($that.attr('data-operate-type'));
            if($that.attr('data-text-type') == "textarea")
            {
                $('input[name=item-text-set-column-value]').val('').hide();
                $('textarea[name=item-textarea-set-column-value]').text($that.attr("data-value")).show();
                setTimeout(function() {
                    $('input[name=item-textarea-set-column-value]').focus();
                    $('input[name=item-textarea-set-column-value]')[0].setSelectionRange(-1, -1);
                }, 200);
            }
            else
            {
                $('textarea[name=item-textarea-set-column-value]').val('').hide();
                $('input[name=item-text-set-column-value]').val($that.attr("data-value")).show();
                setTimeout(function() {
                    $('input[name=item-text-set-column-value]').focus();
                    $('input[name=item-text-set-column-value]')[0].setSelectionRange(-1, -1);
                }, 200);
            }

            $('#item-submit-for-item-text-set').attr('data-text-type',$that.attr('data-text-type'));

            $('#modal-body-for-item-text-set').modal('show');
        });
        // 【修改-文本-text-属性】【取消】
        $(".main-content").on('click', "#item-cancel-for-item-text-set", function() {
            var that = $(this);
            $('#modal-body-for-item-text-set').modal('hide').on("hidden.bs.modal", function () {
                $("body").addClass("modal-open");
            });
            $('input[name=item-text-set-column-value]').val('');
            $('textarea[name=item-textarea-set-column-value]')[0].val('');
        });
        // 【修改-文本-text-属性】【提交】
        $(".main-content").on('click', "#item-submit-for-item-text-set", function() {
            var $that = $(this);
            var $column_key = $('input[name="item-text-set-column-key"]').val();
            if($that.attr('data-text-type') == "textarea")
            {
                var $column_value = $('textarea[name="item-textarea-set-column-value"]').val();
            }
            else
            {
                var $column_value = $('input[name="item-text-set-column-value"]').val();
            }

            // layer.msg('确定"提交"么？', {
            //     time: 0
            //     ,btn: ['确定', '取消']
            //     ,yes: function(index){
            //     }
            // });

            $.post(
                "{{ url('/admin/item/item-text-set') }}",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    operate: $('input[name="item-text-set-operate"]').val(),
                    item_id: $('input[name="item-text-set-item-id"]').val(),
                    operate_type: $('input[name="item-text-set-operate-type"]').val(),
                    column_key: $column_key,
                    column_value: $column_value,
                },
                function(data){

                    // layer.close(index);

                    if(!data.success)
                    {
                        layer.msg(data.msg);
//                            else location.reload();
                    }
                    else
                    {
                        $('#modal-body-for-item-text-set').modal('hide').on("hidden.bs.modal", function () {
                            $("body").addClass("modal-open");
                        });

                        $('input[name=item-text-set-column-value]').val('');
                        $('textarea[name=item-textarea-set-column-value]').text('');

//                                var $keyword_id = $("#set-rank-bulk-submit").attr("data-keyword-id");
////                                TableDatatablesAjax_inner.init($keyword_id);

                        $('#datatable_ajax').DataTable().ajax.reload();
//                                $('#datatable_ajax_inner').DataTable().ajax.reload();
                    }
                },
                'json'
            );

        });





    });










</script>
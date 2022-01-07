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

//            $('select.form-filter').selectpicker('refresh');
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
            window.open("/download/qr-code?type=item&id="+that.attr('data-id'));
        });

        // 【数据分析】
        $("#item-main-body").on('click', ".item-statistic-submit", function() {
            var that = $(this);
            window.open("/admin/statistic/statistic-item?id="+that.attr('data-id'));
//            window.location.href = "/admin/statistic/statistic-item?id="+that.attr('data-id');
        });

        // 【编辑】
        $(".main-body").on('click', ".item-edit-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');
            window.location.href = "/item/item-edit?item-id="+$item_option.attr('data-item-id');
        });

        // 【删除】
        $(".main-body").off("click",".item-delete-this").on('click', ".item-delete-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定要"删除"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-delete') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-delete",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 【恢复】
        $(".main-body").off("click",".item-restore-this").on('click', ".item-restore-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定要"恢复"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-restore') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-restore",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 【永久删除】
        $(".main-body").off("click",".item-delete-permanently-this").on('click', ".item-delete-permanently-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定要"永久删除"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-delete-permanently') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-delete-permanently",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                $item_option.remove();
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 【发布】
        $(".main-body").off("click",".item-publish-this").on('click', ".item-publish-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定要"发布"么？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-publish') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-publish",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );
                }
            });
        });

        // 【完成】
        $(".main-body").off("click",".item-complete-this").on('click', ".item-complete-this", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确认"完成"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){

                    $.post(
                        "/item/item-complete",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: 'item-complete',
                            item_id: $item_option.attr('data-item-id'),
                            type: 1
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );

                }
            });


        });

        // 【启用】
        $(".main-body").on('click', ".item-enable-submit", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定"启用"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-enable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-enable",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );
                }
            });
        });
        // 【禁用】
        $(".main-body").on('click', ".item-disable-submit", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            layer.msg('确定"禁用"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{ url('/item/item-disable') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-disable",
                            item_id: $item_option.attr('data-item-id')
                        },
                        function(data){
                            layer.close(index);
                            if(!data.success) layer.msg(data.msg);
                            else
                            {
                                layer.closeAll();
                                $item_option.replaceWith(data.data.item_html);
                            }
                        },
                        'json'
                    );
                }
            });
        });








        // 显示备注编辑窗口
        $(".main-body").off("click",".remark-toggle").on('click', ".remark-toggle", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            $item_option.find(".remark-container").toggle();
        });
        // 发布评论
        $(".main-body").off("click",".remark-submit").on('click', ".remark-submit", function() {
            var $this = $(this);
            var $item_option = $this.parents('.item-option');

            var form = $(this).parents('.item-remark-form');
            var options = {
                url: "/item/item-remark-edit",
                type: "post",
                dataType: "json",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.closeAll();
                        $item_option.replaceWith(data.data.item_html);
                    }
                }
            };
            form.ajaxSubmit(options);
        });


        // 查看评论
        $(".main-body").off("click",".comments-get").on('click', ".comments-get", function() {
            var that = $(this);
            var item_option = $(this).parents('.item-option');
            var getSort = that.attr('data-getSort');
            var getSupport = item_option.find('input[name=get-support]:checked').val();

            $.post(
                "/item/comment/get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id: item_option.attr('data-item-id'),
                    support: getSupport,
                    category: 11,
                    type: 0
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        item_option.find('.comment-list-container').html(data.data.html);

                        item_option.find('.comments-more').attr("data-getSort",getSort);
                        item_option.find('.comments-more').attr("data-maxId",data.data.max_id);
                        item_option.find('.comments-more').attr("data-minId",data.data.min_id);
                        item_option.find('.comments-more').attr("data-more",data.data.more);
                        if(data.data.more == 'more')
                        {
                            item_option.find('.comments-more').html("更多");
                        }
                        else if(data.data.more == 'none')
                        {
                            item_option.find('.comments-more').html("评论也是有底的！");
                        }
                    }
                },
                'json'
            );
        });
        // 更多评论
        $(".main-body").off("click",".comments-more").on('click', ".comments-more", function() {

            var that = $(this);
            var more = that.attr('data-more');
            var getSort = that.attr('data-getSort');
            var min_id = that.attr('data-minId');

            var item_option = $(this).parents('.item-option');

            if(more == 'more')
            {
                $.post(
                    "/item/comment/get",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        item_id: item_option.attr('data-item-id'),
                        min_id: min_id,
                        category: 11,
                        type: 0
                    },
                    function(data){
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            item_option.find('.comment-list-container').append(data.data.html);

                            item_option.find('.comments-more').attr("data-getSort",getSort);
                            item_option.find('.comments-more').attr("data-maxId",data.data.max_id);
                            item_option.find('.comments-more').attr("data-minId",data.data.min_id);
                            item_option.find('.comments-more').attr("data-more",data.data.more);
                            if(data.data.more == 'more')
                            {
                                item_option.find('.comments-more').html("更多");
                            }
                            else if(data.data.more == 'none')
                            {
                                item_option.find('.comments-more').html("我是有底的！");
                            }
                        }
                    },
                    'json'
                );
            }
            else if(more == 'none')
            {
                layer.msg('没有更多评论了', function(){});
            }
        });






        /*
         * 批量操作
         */
        // 【批量操作】全选or反选
        $(".main-list-body").on('click', '#check-review-all', function () {
            $('input[name="bulk-id"]').prop('checked',this.checked);//checked为true时为默认显示的状态
        });

        // 【批量操作】
        $(".main-list-body").on('click', '#operate-bulk-submit', function() {
            var $checked = [];
            $('input[name="bulk-id"]:checked').each(function() {
                $checked.push($(this).val());
            });

            layer.msg('确定"批量审核"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){

                    $.post(
                        "{{ url('/admin/item/item-operate-bulk') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "operate-bulk",
                            bulk_keyword_id: $checked,
                            bulk_keyword_status:$('select[name="bulk-operate-status"]').val()
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

        // 【批量删除】
        $(".main-list-body").on('click', '#delete-bulk-submit', function() {
            var $checked = [];
            $('input[name="bulk-id"]:checked').each(function() {
                $checked.push($(this).val());
            });

            layer.msg('确定"批量删除"么', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){

                    $.post(
                        "{{ url('/admin/item/item-delete-bulk') }}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            operate: "item-delete-bulk",
                            bulk_keyword_id: $checked
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




        // 内容【获取详情】
        $("#item-main-body").on('click', ".item-detail-show", function() {
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






    });
</script>
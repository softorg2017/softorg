<script>
    $(function() {

        window.UEDITOR_HOME_URL = "/laravel-u-editor/";

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




        // 【编辑】
        $(".main-content").on('click', ".item-edit-link", function() {
            var $that = $(this);
            window.location.href = "/home/item/item-edit?id="+that.attr('data-id');
        });

        // 【编辑】
        $(".main-content").on('click', ".item-edit-show", function() {
            var $that = $(this);
            var $id = $that.attr('data-id')
            $.post(
                "{{ url('/home/item/item-get?get-type=html') }}",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    operate: 'item-get',
                    item_id: $id
                },
                function(data){
                    // layer.close(index);
                    if(!data.success)
                    {
                        layer.msg(data.msg);
                    }
                    else
                    {
                        $('#modal-body-for-item-edit').find('.form-box').html(data.data.html);
                    }
                },
                'json'
            );
            $('#modal-body-for-item-edit').modal({backdrop:'static'});
            $('#modal-body-for-item-edit').modal('show');
            setTimeout(function(){
                UE.delEditor('item-edit-container');
                var ue = UE.getEditor('item-edit-container');
                // var editor = new UE.ui.Editor();
                // editor.render("item-edit-container",{
                //     initialFrameWidth : '100%',
                //     autoHeightEnabled: true,
                // });
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', $('meta[name="_token"]').attr('content'));
                });
            },500);

        });


        // $('#modal-body-for-item-edit').on('show.bs.modal', function () {
        //
        //     console.log(123);
        //     var ue = UE.getEditor('item-edit-container');
        //     ue.ready(function() {
        //         ue.execCommand('serverparam', '_token', $('meta[name="_token"]').attr('content'));
        //     });
        //
        // });



        // 【修改-文本-text-属性】【显示】
        $(".main-content").on('dblclick', ".modal-show-for-info-text-set", function() {
            var $that = $(this);
            $('.info-text-set-title').html($that.attr("data-id"));
            $('.info-text-set-column-name').html($that.attr("data-name"));
            $('input[name=info-text-set-order-id]').val($that.attr("data-id"));
            $('input[name=info-text-set-column-key]').val($that.attr("data-key"));
            $('input[name=info-text-set-operate-type]').val($that.attr('data-operate-type'));
            if($that.attr('data-text-type') == "textarea")
            {
                $('input[name=info-text-set-column-value]').val('').hide();
                $('textarea[name=info-textarea-set-column-value]').text($that.attr("data-value")).show();
            }
            else
            {
                $('textarea[name=info-textarea-set-column-value]').val('').hide();
                $('input[name=info-text-set-column-value]').val($that.attr("data-value")).show();
            }

            $('#item-submit-for-info-text-set').attr('data-text-type',$that.attr('data-text-type'));

            $('#modal-body-for-info-text-set').modal('show');
        });
        // 【修改-文本-text-属性】【取消】
        $(".main-content").on('click', ".e-cancel-for-item-edit", function() {
            var that = $(this);
            $('#modal-body-for-item-edit').modal('hide').on("hidden.bs.modal", function () {
                $("body").addClass("modal-open");
            });
        });
        // 【修改-文本-text-属性】【提交】
        $(".main-content").on('click', "#e-submit-for-item-edit", function() {
            var $that = $(this);

            // layer.msg('确定"提交"么？', {
            //     time: 0
            //     ,btn: ['确定', '取消']
            //     ,yes: function(index){
            //     }
            // });

            var $index = layer.load(1, {
                shade: [0.3, '#fff'],
                content: '<span class="loadtip">正在提交</span>',
                success: function (layer) {
                    layer.find('.layui-layer-content').css({
                        'padding-top': '40px',
                        'width': '100px',
                    });
                    layer.find('.loadtip').css({
                        'font-size':'20px',
                        'margin-left':'-18px'
                    });
                }
            });

            var options = {
                url: "/home/item/item-edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {

                    // layer.close(index);
                    layer.closeAll('loading');

                    if(!data.success)
                    {
                        layer.msg(data.msg);
                    }
                    else
                    {
                        layer.msg(data.msg);
                        $('#modal-body-for-item-edit').modal('hide').on("hidden.bs.modal", function () {
                            $("body").addClass("modal-open");
                        });
                        $('#datatable_ajax').DataTable().ajax.reload(null, false);
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);

        });








        // 内容【获取详情】
        $(".main-content").on('click', ".item-detail-show", function() {
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
                        "{{ url('/home/item/item-delete') }}",
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

    });
</script>
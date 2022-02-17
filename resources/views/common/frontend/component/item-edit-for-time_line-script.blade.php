<script>
    $(function() {

        // 【编辑】提交
        $("#edit-content-submit").on('click', function() {
            var options = {
                url: "/item/content-edit?item-type=time_line",
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
            $("#form-edit-content").ajaxSubmit(options);
        });




        // 【添加】新内容
        $(".show-create-content").on('click', function() {

            reset_form();

            $("#form-edit-content").find('input[name=rank]').val(0);
            $("#form-edit-content").find('.active-disable').hide();
            $("#form-edit-content").find('.active-none').show();
            $('#form-edit-content').find('.cover_img_container').html('');
            $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

            $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

        });





        // 【编辑】该内容
        $("#content-structure-list").on('click', '.edit-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var item_id = input_group.attr('data-id');

            var result;
            $.post(
                "/item/content-get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id:item_id
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        $("#form-edit-content").find('input[name=operate]').val("edit");
                        $("#form-edit-content").find('input[name=content_id]').val(data.data.id);
                        $("#form-edit-content").find('input[name=time_point]').val(data.data.time_point);

                        if(data.data.id == $("#form-edit-content").find('input[name=item_id]').val())
                        {
                            console.log('封面');
                            $("#form-edit-content").find('input[name=time_point]').val(0);
                            $("#form-time-point-option").hide();
                            $("#form-active-option").hide();
                        }
                        else
                        {
                            $("#form-time-point-option").show();
                            $("#form-active-option").show();
                        }

                        $("#form-edit-content").find('input[name=active]:checked').prop('checked','');
                        var $active = data.data.active;
                        $("#form-edit-content").find('.active-none').hide();
                        $("#form-edit-content").find('.active-disable').show();
                        if($active == 0) $("#form-edit-content").find('.active-none').show();
                        $("#form-edit-content").find('input[name=active][value='+$active+']').prop('checked','checked');

                        $("#form-edit-content").find('input[name=title]').val(data.data.title);
                        $("#form-edit-content").find('textarea[name=description]').val(data.data.description);

                        var content = data.data.content;
                        if(data.data.content == null) content = '';
                        var ue = UE.getEditor('container');
                        ue.setContent(content);

                        $("#form-edit-content").find('.cover_img_container').html(data.data.cover_img);

//                        var type = data.data.type;
//                        $("#form-edit-content").find('input[name=type]').prop('checked',null);
//                        $("#form-edit-content").find('input[name=type][value='+type+']').prop('checked',true);
//                        if(type == 1) $("#form-edit-content").find('.form-type').hide();
//                        else $("#form-edit-content").find('.form-type').show();

                        $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

                    }
                },
                'json'
            );

        });

        // 【删除】
        $("#content-structure-list").on('click', '.delete-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '确定要删除该"内容"么？';

            layer.msg(msg, {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-delete",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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


        // 【发布】
        $("#content-structure-list").on('click', ".publish-this-content", function() {
            var $that = $(this);
            var $input_group = $(this).parents('.input-group');
            var $id = $input_group.attr('data-id');
            var $msg = '发布该内容？';
            layer.msg($msg, {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-publish",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:$id
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
        $("#content-structure-list").on('click', ".enable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '启用该内容？';
            layer.msg('启用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-enable",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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
        $("#content-structure-list").on('click', ".disable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '禁用该内容？';
            layer.msg('禁用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-disable",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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




        // 取消添加or编辑
        $("#edit-modal").on('click', '.cancel-this-content', function () {
            $('#edit-ctn').html('');
            $('#edit-modal').modal('hide');
        });

        // 取消添加or编辑
        $("#edit-modal").on('click', '.create-this-content', function () {
            var options = {
                url: "/item/edits",
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
            $("#form-edit-content").ajaxSubmit(options);
        });

    });







    // 显示【移动】
    $("#content-structure-list").on('click', ".this-content-move-show", function() {
        var $that = $(this);
        var $this_content = $that.parents('.this-content');
        $('input[name=content-move-id]').val($this_content.attr('data-id'));
        $('.content-move-title').html($this_content.find('.this-content-title').html());

        $('#content-move-menu').find('option').prop('selected',null);
        $('#content-move-menu').find('option[value=0]').prop("selected", true);

//        $("#content-move-position").find('option').hide();
//        $("#content-move-position").find('option[value=0]').show();
//        $("#content-move-position").find('option[data-p-id=0]').show();
//        $('#content-move-position').find('option').prop('selected',null);
//        $('#content-move-position').find('option[value=0]').prop("selected", true);

        $('#modal-move-body').modal({show:true, backdrop:false});
//            $('.modal-backdrop').each(function() {
//                $(this).attr('id', 'id_' + Math.random());
//            });
    });
    // 【移动】取消
    $("#modal-move-body").on('click', "#content-move-cancel", function() {
        var $that = $(this);
        $('input[name=content-move-id]').val(0);
        $('.content-move-title').html('');

        $('#modal-move-body').modal('hide');
//            $("#modal-move-body").on("hidden.bs.modal", function () {
//                $("body").addClass("modal-open");
//            });
    });
    // 【移动】确认
    $("#modal-move-body").on('click', "#content-move-submit", function() {

        var $this_content_id = $('input[name=content-move-id]').val();

        var $move_menu = $('#content-move-menu');
        var $move_menu_id = $move_menu.find("option:selected").val();
        var $move_menu_has_child = $move_menu.find("option:selected").attr('data-child');

        var $move_position = $('#content-move-position');
        var $move_position_val = $move_position.find("option:selected").val();
        var $move_position_id = $move_position.find("option:selected").attr('data-id');
        var $move_position_direction = $move_position.find("option:selected").attr('data-direction');

//            layer.msg($move_menu_id + '-' + $move_position_id + '-' + $move_menu_has_child);

        if($move_position_id == -1)
        {
            layer.msg("请先选择位置！");
            return false;
        }

        if($move_menu_has_child == 1 && $move_position_id == 0)
        {
            layer.msg("请先选择位置！");
            return false;
        }

        if($move_position_id == $this_content_id)
        {
            layer.msg("没有改变位置！");
            return false;
        }


        $.post(
            "/item/content-move-time_line",
            {
                _token: $('meta[name="_token"]').attr('content'),
                content_id:$this_content_id,
                menu_id:$move_menu_id,
                position_id:$move_position_id,
                position_direction:$move_position_direction
            },
            function(data){
                if(!data.success) layer.msg(data.msg);
                else location.reload();
            },
            'json'
        );
    });




    // 【重置】编辑
    function reset_form()
    {
//        $("#form-edit-content").find('.form-type').show();

        $("#form-time-point-option").show();
        $("#form-active-option").show();

        $("#form-edit-content").find('input[name=operate]').val("create");
        $("#form-edit-content").find('input[name=id]').val("{{encode(0)}}");
        $("#form-edit-content").find('input[name=time_point]').val("");
        $("#form-edit-content").find('input[name=title]').val("");
        $("#form-edit-content").find('textarea[name=description]').val("");
        var ue = UE.getEditor('container');
        ue.setContent("");

        $("#form-edit-content").find('input[name=type]').prop('checked',null);
        $("#form-edit-content").find('input[name=type][value="1"]').prop('checked',true);

        $('#menu').find('option').prop('selected',null);
        $('#menu').find('option[value=0]').prop("selected", true);

        $("#form-edit-content").find('.active-disable').hide();
        $("#form-edit-content").find('.active-none').show();
        $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

    }
</script>
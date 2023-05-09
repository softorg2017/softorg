<script>
    $(function() {


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


        // 【添加】新内容
        $("body").off('click','.item-create-show').on('click', '.item-create-show', function () {

            var $that = $(this);
            var $type = $that.attr('data-type');

            $('#modal-body-for-item-edit').off("show.bs.modal").on("show.bs.modal", function() {

                form_reset_for_item_edit();

                $('.box-title').html('添加新内容');
                $("#form-edit-item").find('input[name=type]').val($type);

                $('.item-option').hide();
                if($type == 'people') $('.option-people').show();
                else if($type == 'product')
                {
                    $('.option-product').show();
                }
                else if($type == 'event') $('.envet').show();

                $("#form-edit-item").find('.active-disable').hide();
                $("#form-edit-item").find('.active-none').show();
                $('#form-edit-item').find('.cover_img_container').html('');
                $('#form-edit-item').find('input[name=item_active][value="0"]').prop('checked',true);

            }).modal({backdrop:'static-'},'show');
            // $("html, body").animate({ scrollTop: $("#form-edit-item").offset().top }, {duration: 500,easing: "swing"});

        });

        // 【编辑】该内容
        $("body").off('click','.item-edit-show').on('click', '.item-edit-show', function () {
            var $that = $(this);
            var $id = $that.attr('data-id');

            $('#modal-body-for-item-edit').off("show.bs.modal").on("show.bs.modal", function () {

                var result;
                $.post(
                    "/admin/item/item-get",
                    {
                        _token: $('meta[name="_token"]').attr('content'),
                        operate: 'item-get',
                        id: $id
                    },
                    function(data){
                        if(!data.success)
                        {
                            layer.msg(data.msg);
                        }
                        else
                        {
                            $('.box-title').html('编辑内容');
                            $("#form-edit-item").find('input[name=operate]').val("edit");
                            $("#form-edit-item").find('input[name=operate_id]').val(data.data.id);


                            $("#form-edit-item").find('input[name=name]').val(data.data.name);
                            $("#form-edit-item").find('input[name=title]').val(data.data.title);
                            $("#form-edit-item").find('textarea[name=description]').val(data.data.description);
                            $("#form-edit-item").find('textarea[name=keywords]').val(data.data.keywords);
                            $("#form-edit-item").find('input[name=tag]').val(data.data.tag);
                            $("#form-edit-item").find('input[name=major]').val(data.data.major);
                            $("#form-edit-item").find('input[name=nation]').val(data.data.nation);
                            $("#form-edit-item").find('input[name=birth_time]').val(data.data.birth_time);
                            $("#form-edit-item").find('input[name=death_time]').val(data.data.death_time);

                            var content = data.data.content;
                            if(data.data.content == null) content = '';
                            var ue = UE.getEditor('container');
                            ue.setContent(content);

                            $("#form-edit-item").find('.cover_img_container').html(data.data.cover_img);


                            $('#menu').find('option').prop('selected',null);
                            $('#menu').find('option[value='+data.data.p_id+']').prop("selected", true);
                            var selected_text = $('#menu').find('option[value='+data.data.p_id+']').text();
                            $("html, body").animate({ scrollTop: $("#form-edit-item").offset().top }, {duration: 500,easing: "swing"});

                        }
                    },
                    'json'
                );

            }).modal({backdrop:'static'},'show');

        });

        // 【编辑】取消
        $("body").off('click','.e-cancel-for-item-edit').on('click', ".e-cancel-for-item-edit", function() {
            var that = $(this);
            form_reset_for_item_edit();
            $('#modal-body-for-item-edit').on("hidden.bs.modal", function () {
            }).modal('hide');
        });

        // 【编辑】提交
        $("body").off('click','#edit-item-submit').on('click', "#edit-item-submit", function() {

            var $page_type = $("#body-root").attr('data-page-type');
            var $operate = $("#form-edit-item").find('input[name=operate]').val();

            var options = {
                url: "{{ url('/admin/item/item-edit') }}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success)
                    {
                        layer.msg(data.msg);
                    }
                    else
                    {
                        layer.msg(data.msg);
                        // location.reload();
                        if($page_type == 'list') $('#datatable_ajax').DataTable().ajax.reload(null,false);

                        form_reset_for_item_edit();

                        $('#modal-body-for-item-edit').on("hidden.bs.modal", function () {
                        }).modal('hide');
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });




        // $(".main-content").on('select2', "#select2-people", function() {
        $('#select2-people').select2({
            ajax: {
                url: "/admin/item/select2_people",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        keyword: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;
//                    console.log(data);
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            theme: 'classic'
        });


    });


    // 【重置】编辑
    function form_reset_for_item_edit()
    {
//        $("#form-edit-content").find('.form-type').show();

        $("#form-menu-option").show();
        $("#form-rank-option").show();
        $("#form-active-option").show();

        $("#form-edit-item").find('input[name=operate]').val("create");
        $("#form-edit-item").find('input[name=id]').val("{{ encode(0) }}");
        $("#form-edit-item").find('input[name=name]').val('');
        $("#form-edit-item").find('input[name=title]').val('');
        $("#form-edit-item").find('input[name=tag]').val('');
        $("#form-edit-item").find('textarea[name=description]').val('');

        var ue = UE.getEditor('container');
        ue.setContent("");

        $("#form-edit-item").find('input[name=type]').prop('checked',null);
        $("#form-edit-item").find('input[name=type][value="1"]').prop('checked',true);

        $('#menu').find('option').prop('selected',null);
        $('#menu').find('option[value=0]').prop("selected", true);

        $("#form-edit-item").find('.active-disable').hide();
        $("#form-edit-item").find('.active-none').show();
        $('#form-edit-item').find('input[name=item_active][value="0"]').prop('checked',true);

    }


</script>
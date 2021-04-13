<script>
    $(function() {

        $("#multiple-images").fileinput({
            allowedFileExtensions : [ 'jpg', 'jpeg', 'png', 'gif' ],
            showUpload: false
        });


        // 【选择时间】
        $("#form-edit-item").on('click', "input[name=time_type]", function() {
            // checkbox
//            if($(this).is(':checked')) {
//                $('.time-show').show();
//            } else {
//                $('.time-show').hide();
//            }
            // radio
            var $value = $(this).val();
            if($value == 1) {
                $('.time-show').show();
            } else {
                $('.time-show').hide();
            }
        });


        $('input[name=start]').datetimepicker({
            locale: moment.locale('zh-cn'),
            format:"YYYY-MM-DD HH:mm"
        });
        $('input[name=end]').datetimepicker({
            locale: moment.locale('zh-cn'),
            format:"YYYY-MM-DD HH:mm"
        });

        // 添加or编辑
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "{{ url('/atom/item/item-edit') }}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);

                        var $type = $('input[name=type]').val();
                        if($type == "object") location.href = "{{ url('/atom/item/item-object-list') }}";
                        else if($type == "people") location.href = "{{ url('/atom/item/item-people-list') }}";
                        else if($type == "product") location.href = "{{ url('/atom/item/item-product-list') }}";
                        else if($type == "event") location.href = "{{ url('/atom/item/item-event-list') }}";
                        else if($type == "conception") location.href = "{{ url('/atom/item/item-conception-list') }}";
                        else location.href = "{{ url('/atom/item/item-all-list') }}";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });

        $('#people').select2({
            ajax: {
                url: "/atom/item/select2_people",
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


        $('#menus').select2({
            ajax: {
                url: "{{url('/atom/item/select2_menus')}}",
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
</script>
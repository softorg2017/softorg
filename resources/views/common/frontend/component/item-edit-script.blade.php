<script>
    $(function() {

        var $item_type = $("input[name=item_type]").val();
        if($item_type == 9)
        {
            $('.activity-show').show();
            $('.time-show').show();
        }
        else if($item_type == 22)
        {
            $('.debate-show').show();
        }

        // 提交
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "/item/item-edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/mine/item-mine";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });


        // 【选择类别】
        $("#form-edit-item").on('click', "input[name=item_type]", function() {

            var $value = $(this).val();

            if($value == 9) {
                $('.activity-show').show();
                $('.time-show').show();

                // checkbox
//                if($("input[name=time_type]").is(':checked')) {
//                    $('.time-show').show();
//                } else {
//                    $('.time-show').hide();
//                }
                // radio
//                var $time_type = $("input[name=time_type]:checked").val();
//                if($time_type == 1) {
//                    $('.time-show').show();
//                } else {
//                    $('.time-show').hide();
//                }
            } else {
                $('.activity-show').hide();
            }

            if($value == 22) {
                $('.debate-show').show();
            } else {
                $('.debate-show').hide();
            }

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
            format:"YYYY-MM-DD HH:mm"
        });
        $('input[name=end]').datetimepicker({
            format:"YYYY-MM-DD HH:mm"
        });

    });
</script>

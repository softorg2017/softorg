
<div>你访问的页面没找到，<span id="time" style="color:#ff0018;">3</span> 秒钟自动跳到首页。</div>

<script src="{{ asset('/templates/moban2030/assets/js/jquery.min.js') }}"></script>
<script language="javascript" type="text/javascript">


    // Method 1 直接跳转
    {{--window.location.href="{{ url('/') }}";--}}


    // Method 2 指定时间后跳转
    {{--setTimeout(function() { window.location.href="{{ url('/') }}"; }, 5000);--}}


    // Method 3 指定时间后跳转，同时倒计时
    $(function () {
        setTimeout(ChangeTime, 1000);
    });

    function ChangeTime() {

        var time;
        time = $("#time").text();
        time = parseInt(time);
        time--;
        console.log(time);

        if (time <= 0) {
            window.location.href = "{{ url('/') }}";
        }
        else {
            $("#time").text(time);
            setTimeout(ChangeTime, 1000);
        }

    }


</script>
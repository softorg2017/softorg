<html>
    <head>
        <meta charset="utf-8">
        <title>kedou</title>

        <style>
            canvas {
                position: absolute;
                top: 0;
                left: 0;
            }
        </style>

    </head>
    <body>

    <canvas id="c" class="afdas"></canvas>


    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('common/js/animate/swimming-tadpole.js') }}"></script>
    <script>
        var cd = $(".afdas").get(0);
        var canvas = document.getElementById('c');
        console.log();
        swimming_tadpole(cd);
    </script>

    </body>
</html>
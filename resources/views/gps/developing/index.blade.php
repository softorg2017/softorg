@extends(env('TEMPLATE_GPS').'developing.layout.layout')


{{--html.head--}}
@section('head_title') 【GPS】developing @endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--header--}}
@section('component-header')
    @include(env('TEMPLATE_GPS').'developing.component.header')
@endsection


{{--footer--}}
@section('component-footer')
    @include(env('TEMPLATE_GPS').'developing.component.footer')
@endsection




{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include(env('TEMPLATE_GPS').'developing.component.banner-for-root')

    <div class="page-root">


        @include(env('TEMPLATE_GPS').'developing.module.module-1-0', ['data'=>$items])
        @include(env('TEMPLATE_GPS').'developing.module.module-product-1-1', ['items'=>$items])
        @include(env('TEMPLATE_GPS').'developing.module.module-product-1-2', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-product-2-1', ['items'=>$items])
        @include(env('TEMPLATE_GPS').'developing.module.module-product-2-2', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-faq-1', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-block-bar', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-left-right', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-article-list', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-recycle')

        @include(env('TEMPLATE_GPS').'developing.module.module-advantage-1')
        @include(env('TEMPLATE_GPS').'developing.module.module-advantage-2')

        @include(env('TEMPLATE_GPS').'developing.module.module-coverage', ['items'=>$items])

        @include(env('TEMPLATE_GPS').'developing.module.module-qrcode')
        @include(env('TEMPLATE_GPS').'developing.module.module-video')

        @include(env('TEMPLATE_GPS').'developing.module.module-client-1')


        @include(env('TEMPLATE_GPS').'developing.group.group-1', ['data'=>$item,'items'=>$items])


    </div>

@endsection




{{--custom-css&style--}}
@section('custom-css')
    <link rel="stylesheet" href="/templates/jiaoben2806/css/bellows.css">
    <link rel="stylesheet" href="/templates/jiaoben2806/css/bellows-theme.css">
    {{--<link rel="stylesheet" href="/templates/jiaoben2806/css/main.css">--}}
@endsection
@section('custom-style')
<style>
</style>
@endsection




{{--custom-js&script--}}
@section('custom-js')
    <script src="/templates/jiaoben2806/js/highlight.pack.js"></script>
    <script src="/templates/jiaoben2806/js/velocity.min.js"></script>
    <script src="/templates/jiaoben2806/js/bellows.js"></script>
@endsection
@section('custom-script')
<script>
    $(function() {

        $('.bellows').bellows();

    });
</script>
@endsection
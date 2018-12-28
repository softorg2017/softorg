@extends('root.frontend.layout.layout')


{{--html.head--}}
@section('head_title') 上海如哉网络科技有限公司 @endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--header--}}
@section('component-header')
    @include('root.frontend.component.header')
@endsection


{{--footer--}}
@section('component-footer')
    @include('root.frontend.component.footer')
@endsection




{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include('root.frontend.component.banner-for-root')

    <div class="page-root">

        @include('root.frontend.module.root-product-1', ['items'=>$product_items])

        @include('root.frontend.module.root-template-list', ['items'=>$service_items])

        {{--@include('root.frontend.module.root-recycle')--}}

        {{--@include('root.frontend.module.root-advantage-1')--}}

        @include('root.frontend.module.root-coverage', ['items'=>$coverage_items])

        {{--@include('root.frontend.module.root-qrcode')--}}

        @include('root.frontend.module.root-client', ['items'=>$client_items])

    </div>

@endsection




{{--style--}}
@section('custom-style')
<style>
</style>
@endsection




{{--style--}}
@section('custom-script')
<script>
</script>
@endsection
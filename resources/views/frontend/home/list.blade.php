@extends('frontend.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('/frontend/css/list_1.0.0.css')}}">
@endsection

@section('content')
    @include('frontend.layouts.header')

    <div class="list-banner mask"></div>

@endsection

@section('js')
    <script>
        $(function(){
            $('body').addClass('fp-viewing-0');
        })
    </script>

@endsection
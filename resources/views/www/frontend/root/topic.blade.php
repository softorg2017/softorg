@extends('frontend.layout.layout')

@section('title') {{ $data->title or '' }} @endsection
@section('header') {{ $data->title or '' }} @endsection
@section('description','')

@section('header_title')  @endsection

@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-sm-12 col-md-9 container-body-left">

            @include('frontend.component.topic')

        </div>

        <div class="col-sm-12 col-md-3 hidden-xs hidden-sm container-body-right">

        </div>
    </div>

@endsection



@section('style')
<style>
    .box-footer a {color:#777;cursor:pointer;}
    .box-footer a:hover {color:orange;cursor:pointer;}
    .comment-container {border-top:2px solid #ddd;}
    .comment-choice-container {border-top:2px solid #ddd;}
    .comment-choice-container .form-group { margin-bottom:0;}
    .comment-entity-container {border-top:2px solid #ddd;}
    .comment-piece {border-bottom:1px solid #eee;}
    .comment-piece:first-child {}
</style>
@endsection

@section('js')
<script>
    $(function() {
        $(".comments-get-default").click();
    });
</script>
@endsection

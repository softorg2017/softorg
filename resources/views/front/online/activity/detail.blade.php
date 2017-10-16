@extends('front.'.config('common.view.front.template').'.layout.detail')

@section('title','活动详情')
@section('header','活动详情')
@section('description','活动详情')

@section('index-url',url(config('common.website.front.prefix').'/'.$data->org->website_name))


@section('data-updated_at')
    {{$data->updated_at or ''}}
@endsection

@section('data—title')
    {{$data->title or ''}}
@endsection

@section('data-content')
    {!! $data->content or '' !!}
@endsection



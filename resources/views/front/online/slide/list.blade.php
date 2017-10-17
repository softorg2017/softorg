@extends('front.'.config('common.view.front.template').'.layout.list')

@section('title','幻灯片列表')
@section('header','幻灯片列表')
@section('description','幻灯片列表')

@section('index-url', url(config('common.website.front.prefix').'/'.$org->website_name))

@section('data-content')
    @foreach($org->slides as $v)
        <a  href="{{url('/slide?id='.encode($v->id))}}" class="project-item masonry-brick" data-images="{{asset('/frontend/images/bg_03.jpg')}}">
            <img class="img-responsive project-image" src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
            <div class="hover-mask">
                <h2 class="project-title">{{$v->title or ''}}</h2>
                <p>{{$v->description or ''}}</p>
            </div>
            <div class="sr-only project-description">
                {{$v->description or ''}}
            </div>
        </a>
    @endforeach
@endsection



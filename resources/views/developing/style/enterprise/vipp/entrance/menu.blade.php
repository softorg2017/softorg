@extends(config('common.org.view.frontend.online').'.layout.layout')


{{--html.head--}}
@section('head_title'){{$data->title or ''}}@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title',$menu->title)
@section('wx_share_desc'){{$data->description or '@'.$org->name}}@endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->logo}}@endsection

@section('wechat_share_website_name'){{$org->website_name or '0'}}@endsection
@section('wechat_share_page_id',encode($menu->id))
@section('wechat_share_sort',2)
@section('wechat_share_module',0)



{{--banner--}}
@section('banner-heading',$org->name)
@section('banner-heading-top') Welcome @endsection
@section('banner-heading-bottom'){{$org->slogan or ''}}@endsection
@section('banner-box-left','目录')
@section('banner-box-right','联系我们')



{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include(config('common.org.view.frontend.online').'.component.banner1')

    {{--main-content--}}
    <div class="row full wrapper-module-container">
        <div class="col-md-14">
            <div class="row full block-in">
                <div class="module-header-container">
                    <h3 class="menu-title">{{ $menu->title }}</h3>
                </div>
                <div class="module-block-container">
                    <div class="row full block-3-column">
                        @foreach($menu->items as $v)
                            <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}">
                                <li class="item-block" role="button">
                                    <div class="item-block-top">
                                        <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                    </div>
                                    <div class="item-block-bottom">
                                        <span class="block-title multi-ellipsis-1 z-index-9">{{$v->title or ''}}</span>
                                        @if(!empty($v->description))
                                            <p class="list-description description line-ellipsis-1">{{$v->description or ''}}</p>
                                        @endif
                                    </div>
                                </li>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')


@section('head_title') {{ $item->title or '朝鲜族组织平台' }} @endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title'){{ $item->title or '朝鲜族组织平台' }}@endsection
@section('wx_share_desc'){{ '@'.$item->owner->username }}@endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$item->owner->portrait_img) }}@endsection




@section('sidebar-toggle','_none')
@section('sidebar')

    {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.sidebar-item')--}}

@endsection




@section('header') {{ $item->title or '' }} @endsection
@section('description','')
@section('content')

    <div class="_none">
        <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left margin-bottom-8px bg-white">

            @include(env('TEMPLATE_DEFAULT').'frontend.component.item')

        </div>


        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-body-right pull-right">
            {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-user', ['data'=>$item->owner])--}}
            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-user', ['data'=>$user])
        </div>


        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-body-right pull-right" style="clear:right;">

            {{--@if(!empty($user->ad))--}}
                {{--<div class="item-row margin-top-4px margin-bottom-2px pull-right">--}}
                    {{--<strong>Ta的贴片广告</strong>--}}
                {{--</div>--}}
            {{--@endif--}}
            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-ad-paste', ['item'=>$user->ad])

            @if(count($user->pivot_sponsor_list))
            <div class="item-row margin-top-16px margin-bottom-2px pull-right">
                <strong>Ta的赞助商</strong>
            </div>
            @endif
            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-sponsor', ['sponsor_list'=>$user->pivot_sponsor_list])

        </div>

    </div>

@endsection



@section('style')
<style>
    .box-footer a {color:#777;cursor:pointer;}
    .box-footer a:hover {color:orange;cursor:pointer;}
    .comment-choice-container {border-top:2px solid #ddd;}
    .comment-choice-container .form-group { margin-bottom:0;}
</style>
@endsection

@section('js')
<script>
    $(function() {
        $(".comments-get-default").click();
    });
</script>
@endsection

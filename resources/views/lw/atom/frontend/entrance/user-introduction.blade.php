@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')

@section('head_title')
    简介 - {{ $data->username or '朝鲜族组织平台' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header','')
@section('description','')


@section('wx_share_title'){{ $data->username or '朝鲜族组织平台' }}@endsection
@section('wx_share_desc')欢迎来到我的主页@endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}@endsection




@section('sidebar')

    @include(env('TEMPLATE_DEFAULT').'frontend.component.sidebar-user')

@endsection




@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-body-right pull-right">

            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-user', ['data'=>$data])

            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-user-menu', ['data'=>$data])


        </div>


        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left">

            <div class="item-piece item-option topic-option">
                <div class="box-body item-row item-content-row">
                    <div class="item-row">
                        <h4>图文简介</h4>
                    </div>
                    <div class="item-row">
                        @if(!empty($data->introduction->content))
                            {!! $data->introduction->content or '' !!}
                        @else
                            <small>暂无简介</small>
                        @endif
                    </div>
                </div>
            </div>

            @include(env('TEMPLATE_DEFAULT').'frontend.component.user-list',['user_list'=>$data->pivot_org_list])
        </div>


        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-body-right pull-right" style="clear:right;">

            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-ad-paste', ['item'=>$data->ad])

            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-org', ['org_list'=>$data->pivot_org_list])

            @if($data->user_type == 88)
                @include(env('TEMPLATE_DEFAULT').'frontend.component.right-ad-list', ['ad_list'=>$data->ad_list,'ad_tag'=>'广告'])
            @endif

            @include(env('TEMPLATE_DEFAULT').'frontend.component.right-sponsor', ['sponsor_list'=>$data->pivot_sponsor_list])

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
        $('article').readmore({
            speed: 150,
            moreLink: '<a href="#">更多</a>',
            lessLink: '<a href="#">收起</a>'
        });
    });
</script>
@endsection

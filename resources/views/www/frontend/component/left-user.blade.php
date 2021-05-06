<div class="right-piece- box-body bg-white margin-bottom-4px section-user radius-2px">


    <div class="box box-widget widget-user" style="margin-bottom:0px;box-shadow:0 0;">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-aqua-active">
            {{--<h3 class="widget-user-username text-center">{{ $data->username or '' }}</h3>--}}
            {{--<h5 class="widget-user-desc">{{ $data->company or '暂无' }}</h5>--}}
            {{--<h5 class="widget-user-desc">{{ $data->position or '暂无' }}</h5>--}}
        </div>
        <div class="widget-user-image" style="position:relative;top:0;margin-top:-45px;">
            <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" class="img-circle" alt="User Image" style="border-radius:2px;">
        </div>
        <div class="" style="margin-bottom:24px;">
            {{--姓名--}}
            <h3 class="profile-username text-center" style="margin-top:8px;">
                @if(!empty($data->true_name))
                    {{ $data->true_name or '' }}
                @else
                    {{ $data->username or '' }}
                @endif
            </h3>

            {{--公司--}}
            @if(!empty($data->company))
                <p class="text-muted text-center" style="margin-bottom:4px;"><b>{{ $data->company or '暂无' }}</b></p>
            @endif
            {{--职位--}}
            @if(!empty($data->position))
                <p class="text-muted text-center" style="margin-bottom:4px;"><b>{{ $data->position or '暂无' }}</b></p>
            @endif
            {{--职位--}}
            @if(!empty($data->business_description))
                <p class="text-muted text-center" style="margin-bottom:4px;"><small>{{ $data->business_description or '暂无' }}</small></p>
            @endif
        </div>
        <div class="box-footer"  style="padding:4px;">
            <div class="row">
                <div class="col-xs-6 border-right">
                    <div class="description-block">
                        <h5 class="description-header">{{ $data->fans_num or 0 }}</h5>
                        <span class="description-text">粉丝</span>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header">{{ $data->visit_num or 0 }}</h5>
                        <span class="description-text">访问</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer _none">
            <div class="row">
                <div class="col-xs-6 col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">0</h5>
                        <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-xs-6 col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">0</h5>
                        <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-xs-6 col-sm-4 _none">
                    <div class="description-block">
                        <h5 class="description-header">0</h5>
                        <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>


    {{--<div class="box box-primary">--}}
        <div class="box-body box-profile">

            {{--头像--}}
            <a class="lightcase-image _none" href="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}">
                <img class="profile-user-img img-responsive img-circle" src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="User" style="border-radius:4px;">
            </a>

            {{--姓名--}}
            {{--<h3 class="profile-username text-center" style="margin-top:8px;">{{ $data->username or '' }}</h3>--}}

            {{--公司--}}
            {{--@if(!empty($data->company))--}}
                {{--<p class="text-muted text-center" style="margin-bottom:6px;"><b>{{ $data->company or '暂无' }}</b></p>--}}
            {{--@endif--}}

            {{--职位--}}
            {{--@if(!empty($data->company))--}}
                {{--<p class="text-muted text-center" style="margin-bottom:24px;"><b>{{ $data->position or '暂无' }}</b></p>--}}
            {{--@endif--}}



            <ul class="list-group list-group-unbordered">
                @if(!empty($data->contact_phone))
                    <li class="list-group-item">
                        <i class="fa fa-phone text-primary"></i>
                        <span class="text-muted">
                            <a href="tel:{{ $data->contact_phone or '' }}">{{ $data->contact_phone or '暂无' }}</a>
                        </span>
                    </li>
                @endif
                {{--邮箱--}}
                @if(!empty($data->email))
                    <li class="list-group-item">
                        <i class="fa fa-envelope text-primary"></i>
                        <span class="text-muted">{{ $data->email or '暂无' }}</span>
                    </li>
                @endif
                {{--微信--}}
                @if(!empty($data->wechat_id))
                    <li class="list-group-item">
                        @if(!empty($data->wechat_qr_code_img))
                            <a class="lightcase-image" href="{{ url(env('DOMAIN_CDN').'/'.$data->wechat_qr_code_img) }}">
                                <i class="fa fa-weixin text-primary"></i>
                                <span class="text-muted">{{ $data->wechat_id or '暂无' }}</span>
                                <i class="fa fa-qrcode text-danger" style="width:16px;font-weight:500;"></i>
                            </a>
                        @else
                            <i class="fa fa-weixin text-primary"></i>
                            <span class="text-muted">{{ $data->wechat_id or '暂无' }}</span>
                        @endif
                    </li>
                @endif
                {{--QQ--}}
                @if(!empty($data->QQ_number))
                    <li class="list-group-item">
                        <i class="fa fa-qq text-primary"></i>
                        <a class="" href="tencent://message/?uin={{ $data->QQ_number }}">
                            {{ $data->QQ_number or '暂无' }}
                        </a>
                    </li>
                @endif
                {{--微博--}}
                @if(!empty($data->weibo_name))
                    <li class="list-group-item">
                        @if(!empty($data->weibo_address))
                            <a target="_blank" href="{{ $data->weibo_address }}">
                                <i class="fa fa-weibo text-primary"></i>
                                <span class="">{{ $data->weibo_name or '暂无' }}</span>
                            </a>
                        @else
                            <i class="fa fa-weibo text-primary"></i>
                            <span class="text-muted">{{ $data->weibo_name or '暂无' }}</span>
                        @endif
                    </li>
                @endif
                {{--网站--}}
                @if(!empty($data->website))
                    <li class="list-group-item">
                        <i class="fa fa-globe text-primary"></i>
                        @if(!empty($data->website))
                            <a target="_blank" href="{{ $data->website or '' }}">
                                {{ $data->website or '暂无' }}
                            </a>
                        @else
                            <span class="text-muted">{{ $data->website or '暂无' }}</span>
                        @endif
                    </li>
                @endif
                {{--地址--}}
                @if(!empty($data->contact_address))
                    <li class="list-group-item">
                        <i class="fa fa-map-marker text-primary"></i>
                        <span class="text-muted">{{ $data->contact_address or '暂无' }}</span>
                    </li>
                @endif
                {{--<li class="list-group-item">--}}
                    {{--<b>Followers</b> <a class="pull-right">1,322</a>--}}
                {{--</li>--}}
                {{--<li class="list-group-item">--}}
                    {{--<b>Following</b> <a class="pull-right">543</a>--}}
                {{--</li>--}}
                {{--<li class="list-group-item">--}}
                    {{--<b>Friends</b> <a class="pull-right">13,287</a>--}}
                {{--</li>--}}
            </ul>

            {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}




            @if(!Auth::check())
                <a href="javascript:void(0);" class="btn btn-danger btn-block follow-add follow-add-it" data-user-id="{{ $data->id }}">
                    <i class="fa fa-star-o"></i>
                    <span class="">收藏名片</span>
                </a>
            @else
                @if(Auth::user()->id != $data->id)
                    @if($is_follow)
                        <a href="javascript:void(0);" class="btn btn-danger btn-block follow-remove follow-remove-it" data-user-id="{{ $data->id }}">
                            <i class="fa fa-star"></i>
                            <span class="">已收藏</span>
                        </a>
                    @else
                        <a href="javascript:void(0);" class="btn btn-danger btn-block follow-add follow-add-it" data-user-id="{{ $data->id }}">
                            <i class="fa fa-star-o"></i>
                            <span class="">收藏名片</span>
                        </a>
                    @endif
                @else
                    <a href="{{ url('/my-info/edit') }}" class="btn btn-default btn-block" data-user-id="{{ $data->id }}">
                        <i class="fa fa-edit"></i>
                        <span class="">编辑名片</span>
                    </a>
                    <a href="{{ url('/my-cards') }}" class="btn btn-primary btn-block">
                        <i class="fa fa-list-alt"></i>
                        <span class="">我的名片夹</span>
                    </a>
                @endif
            @endif



        </div>
    {{--</div>--}}


    <div class="item-container _none">
        <div class="panel-default box-default item-portrait-container">
            <a target="_blank" href="{{ url('/user/'.$data->id) }}">
                <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
            </a>
        </div>

        <div class="panel-default- box-default item-entity-container with-portrait">
            <div class="item-row item-title-row text-muted">
                <span class="item-user-portrait _none">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                </span>
                <span class="item-user-name">
                    <b><a href="{{ url('/user/'.$data->id) }}" class="text-hover-red font-sm">{{ $data->username or '' }}</a></b>
                </span>
            </div>
            <div class="item-row item-info-row text-muted">
                <span class="">粉丝 {{ $data->fans_num or 0 }}</span>
                <span class="">•</span>
                <span class="">访问 {{ $data->visit_num or 0 }}</span>
                {{--<span class="info-tags text-danger">作者</span>--}}
            </div>
        </div>


        <div class="item-row">

            @if(!empty($data->contact_phone))
                <div class="item-info-row margin-4px">
                    <i class="fa fa-phone text-primary"></i>
                    <span class="text-muted">{{ $data->contact_phone or '暂无' }}</span>
                </div>
            @endif
            @if(!empty($data->email))
            <div class="item-info-row margin-4px">
                <i class="fa fa-envelope text-primary"></i>
                <span class="text-muted">{{ $data->email or '暂无' }}</span>
            </div>
            @endif
            @if(!empty($data->wechat_id))
            <div class="item-info-row margin-4px">
                <i class="fa fa-weixin text-primary"></i>
                <span class="text-muted">{{ $data->wechat_id or '暂无' }}</span>
            </div>
            @endif
            @if(!empty($data->QQ_number))
            <div class="item-info-row margin-4px">
                <i class="fa fa-qq text-primary"></i>
                @if(!empty($data->QQ_number))
                    <a class="" href="tencent://message/?uin={{ $data->QQ_number }}">
                        {{ $data->QQ_number or '暂无' }}
                    </a>
                @else
                    <span class="text-muted">{{ $data->QQ_number or '暂无' }}</span>
                @endif
            </div>
            @endif
            @if(!empty($data->weibo_name))
                <div class="item-info-row margin-4px">
                    <i class="fa fa-weibo text-primary"></i>
                    <span class="text-muted">{{ $data->weibo_name or '暂无' }}</span>
                </div>
            @endif
            @if(!empty($data->website))
            <div class="item-info-row margin-4px">
                <i class="fa fa-globe text-primary"></i>
                @if(!empty($data->website))
                    <a target="_blank" href="{{ $data->website or '' }}">
                        {{ $data->website or '暂无' }}
                    </a>
                @else
                    <span class="text-muted">{{ $data->website or '暂无' }}</span>
                @endif
            </div>
            @endif
            @if(!empty($data->contact_address))
                <div class="item-info-row margin-4px">
                    <i class="fa fa-map-marker text-primary"></i>
                    <span class="text-muted">{{ $data->contact_address or '暂无' }}</span>
                </div>
            @endif
        </div>

        @if(!Auth::check())
        <div class="item-row">
            <div class="tool-inn tool-info follow-add follow-add-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                <i class="fa fa-star-o"></i>
                <span class="">收藏名片</span>
            </div>
        </div>
        @else
            @if(Auth::user()->id != $data->id)
            <div class="item-row">
                @if($is_follow)
                <div class="tool-inn tool-info follow-remove follow-remove-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                    <b><i class="fa fa-star"></i></b>
                    <span class="">已收藏</span>
                </div>
                @else
                <div class="tool-inn tool-info follow-add follow-add-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                    <i class="fa fa-star-o"></i>
                    <span class="">收藏名片</span>
                </div>
                @endif
            </div>
            @else
            <div class="item-row">
                <a href="{{ url('/my-info/edit') }}">
                    <div class="tool-inn tool-info" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                        <i class="fa fa-edit"></i>
                        <span class="">编辑名片</span>
                    </div>
                </a>
            </div>
            @endif
        @endif

    </div>

</div>


<div class="box-body bg-white margin-bottom-8px _none">

    <div class="margin">
        <i class="fa fa-user text-orange"></i>
        <b>{{ $data->username or '' }}</b>
    </div>

</div>
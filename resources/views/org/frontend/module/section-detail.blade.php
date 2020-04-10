{{--图片展示--}}
<section class="section-container bg-light bg-f">
    <div class="row">

        <header class="module-row module-header-container with-border-bottom text-center">
            <div class="wow slideInLeft module-title-row title-md _bold">
                @if(!empty($data->title)) {{ $data->title or '图文详情' }} @else 图文详情 @endif
            </div>
            @if(!empty($data->subtitle))
            <div class="wow slideInRight module-subtitle-row title-sm">
                 {{ $data->subtitle or '图文详情' }}
            </div>
            @endif
            <a class="pull-right print-btn _none" href="javascript:window.print()">Print This Property <i class="fa fa-print"></i></a>
        </header>

        <div class="module-row module-body-container property-contents" id="">
            {!! $data->content or '' !!}
        </div>

    </div>
</section>
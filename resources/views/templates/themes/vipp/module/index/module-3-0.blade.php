<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-all">

            <a target="_blank" href="@if(!empty($v->link)) {{url($data->link)}} @else javascript:void(0) @endif">
                <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$data->cover_pic }}" alt="">
            </a>

        </div>
    </div>
</div>

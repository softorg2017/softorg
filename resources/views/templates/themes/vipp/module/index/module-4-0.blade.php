<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-in">

            <div class="module-header-container">
                <span class="menu-title"><b>{{ $data->title }}</b></span>
            </div>


            <div class="module-block-container ">
                <div class="row full block-{{$data->column}}-column">

                    <div class="joint-box- joint-type-1">
                        <ul class="joint-cut-">

                            @foreach(json_decode($data->img_multiple) as $v)
                                <li class="joint-bin">
                                    <a target="_blank" href="@if(!empty($v->link)) {{url($v->link)}} @else javascript:void(0) @endif">
                                        <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="234">
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>

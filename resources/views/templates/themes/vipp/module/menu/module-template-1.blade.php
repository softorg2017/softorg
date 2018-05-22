<div class="row full wrapper-module-container module-4-0">
    <div class="col-md-14">
        <div class="row full block-in">


            <div class="module-header-container">
                <span class="menu-title"><b>网站模板</b></span>
            </div>

            <div class="module-block-container">
                <div class="row full block-4-column">

                    <div class="joint-box- joint-type-1">
                        <ul class="joint-cut-">

                            @foreach($datas as $v)
                                <li class="rectangle-container rectangle-2-3 wicked-barrelRoll-hover- grow">
                                    <a target="_blank" href="{{ url('/website/template/'.encode($v->id)) }}">
                                        <div class="rectangle-box">
                                            <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>

            {{ $datas->links() }}


        </div>
    </div>
</div>

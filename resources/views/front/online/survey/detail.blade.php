@extends('front.'.config('common.view.front.template').'.layout.detail')

@section('title','问卷详情')
@section('header','问卷详情')
@section('description','问卷详情')

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

@section('data-content-ext')
    @foreach($data->questions as $k => $v)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="detail-left">
                    <div class="detail-left-cont">
                        <div class="box-body question-container question-option" data-id="{{$v->encode_id or ''}}">
                            {{--标题--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <h4>
                                        <small></small><b>{{$v->title or ''}}</b>
                                        <small>
                                            @if($v->type == 1) (单行文本题)
                                            @elseif($v->type == 2) (多行文本题)
                                            @elseif($v->type == 3) (单选题)
                                            @elseif($v->type == 4) (下拉题)
                                            @elseif($v->type == 5) (多选题)
                                            @elseif($v->type == 6) (量标题)
                                            @endif
                                        </small>
                                    </h4>
                                </div>
                            </div>
                            {{--描述--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">{{$v->description or ''}}</div>
                            </div>
                            @if($v->type == 1) {{--单行文本题--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2"><input type="text" class="form-control"></div>
                            </div>
                            @elseif($v->type == 2) {{--单行文本题--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2"><textarea></textarea></div>
                            </div>
                            @elseif($v->type == 3) {{--单选题--}}
                            @foreach($v->options as $o)
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-2"><input type="radio" name="radio"> {{$o->title or ''}}</div>
                                </div>
                            @endforeach
                            @elseif($v->type == 4) {{--下拉题--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <select name="" id="">
                                        @foreach($v->options as $o)
                                            <option value="">{{$o->title or ''}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @elseif($v->type == 5) {{--多选题--}}
                            @foreach($v->options as $o)
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-2"><input type="checkbox" name="checkbox"> {{$o->title or ''}}</div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection



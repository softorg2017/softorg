@extends('frontend.course.layout')

@section('title') {{$data->title}} @endsection
@section('header')
    <a href="{{url('/course/'.$data->encode_id)}}">{{$data->title}}</a>
@endsection
@section('description')
    来自 <a href="{{url('/u/'.$data->user->encode_id)}}"><b>{{ $data->user->name }}</b></a>
@endsection
@section('breadcrumb')
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div style="display:none;">
    <input type="hidden" id="" value="{{$_encode or ''}}" readonly>
</div>

{{--内容--}}
<div class="row">
    <div class="col-md-12">
        <div class="box panel-default box-info">

            @if(!empty($content))
                <div class="box-header with-border panel-heading" style="margin:16px 0 8px;">
                    <h3 class="box-title">{{$content->title}}</h3>
                </div>

                @if(!empty($content->description))
                    <div class="box-body text-muted">
                        <div class="colo-md-12"> {!! $content->description or '' !!}  </div>
                    </div>
                @endif

                @if(!empty($content->content))
                    <div class="box-body">
                        <div class="colo-md-12"> {!! $content->content or '' !!}  </div>
                    </div>
                @endif
            @else
                <div class="box-header with-border panel-heading" style="margin:16px 0 8px;">
                    <h3 class="box-title">{{$data->title}}</h3>
                </div>

                @if(!empty($data->description))
                    <div class="box-body text-muted">
                        <div class="colo-md-12"> {!! $data->description or '' !!}  </div>
                    </div>
                @endif

                @if(!empty($data->content))
                    <div class="box-body">
                        <div class="colo-md-12"> {!! $data->content or '' !!}  </div>
                    </div>
                @endif
            @endif

            <div class="box-footer">
                &nbsp;
            </div>

        </div>
    </div>
</div>

@endsection


@section('js')
    <script>
        $(function() {

            xx();

            // 全部展开
            $(".sidebar").on('click', '.fold-down', function () {
                $('.recursion-row').each( function () {
                    $(this).show();
                    $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                });
            });

            // 全部收起
            $(".sidebar").on('click', '.fold-up', function () {
                $('.recursion-row').each( function () {
                    if($(this).attr('data-level') != 0) $(this).hide();
                    $(this).find('.recursion-fold').removeClass('fa-minus-square').addClass('fa-plus-square');
                });
            });

            // 收起
            $(".sidebar").on('click', '.recursion-row .fa-minus-square', function () {
                var this_row = $(this).parents('.recursion-row');
                var this_level = this_row.attr('data-level');
                this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
                    if($(this).attr('data-level') <= this_level ) return false;
                    $(this).hide();
                });
                $(this).removeClass('fa-minus-square').addClass('fa-plus-square');
            });

            // 展开
            $(".sidebar").on('click', '.recursion-row .fa-plus-square', function () {
                var this_row = $(this).parents('.recursion-row');
                var this_level = this_row.attr('data-level');
                this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
                    if($(this).attr('data-level') <= this_level ) return false;
                    $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                    $(this).show();
                });
                $(this).removeClass('fa-plus-square').addClass('fa-minus-square');
            });

        });

        function xx() {
            var this_row = $('.recursion-row .active').parents('.recursion-row');
            var this_level = this_row.attr('data-level');
            this_row.find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

            if(this_level == 0)
            {
                this_row.nextUntil('.recursion-row[data-level='+this_level+']').each( function () {
                    if($(this).attr('data-level') <= this_level ) return false;
                    $(this).show();
                    $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                });
            }
            else if(this_level > 0)
            {
                this_row.prevUntil().each( function () {
                    if( $(this).attr('data-level') == 0 )
                    {
                        $(this).find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');

                        $(this).nextUntil('.recursion-row[data-level=0]').show();
                        $(this).nextUntil('.recursion-row[data-level=0]').find('.recursion-fold').removeClass('fa-plus-square').addClass('fa-minus-square');
                        return false;
                    }
                });
            }
        }
    </script>
@endsection

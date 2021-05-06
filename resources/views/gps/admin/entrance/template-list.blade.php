@extends(env('TEMPLATE_GPS_ADMIN').'layout.layout')

@section('head_title','【GPS】模板')

@section('header','模板')
@section('description','模板')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Moban</b></h3>
            </div>

            <div class="box-body">

                <table class="table table-striped table-bordered- table-hover">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>

                    <tr>
                        <td><a target="_blank" href="{{ url('/template/test') }}">TEST</a></td>
                        <td></td>
                        <td><span class="label label-success">label-success</span></td>
                    </tr>

                    <tr>
                        <td><a target="_blank" href="{{ url('/template/metinfo') }}">metinfo</a></td>
                        <td></td>
                        <td><span class="label label-warning">label-warning</span></td>
                    </tr>
                    </tbody>
                </table>


                <br>

                <br>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Moban</b></h3>
            </div>

            <div class="box-body">

                <table class="table table-striped table-bordered- table-hover">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>

                    <tr>
                        <td><a target="_blank" href="{{ url('/template-library/moban3030/') }}">moban3030</a></td>
                        <td>徒步旅行俱乐部网站模板</td>
                        <td><span class="label label-success">label-success</span></td>
                    </tr>

                    <tr>
                        <td><a target="_blank" href="{{ url('/template-library/moban2889/') }}">moban2889</a></td>
                        <td>宽屏响应式业务网站模板</td>
                        <td><span class="label label-warning">label-warning</span></td>
                    </tr>
                    <tr>
                        <td>GPS</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td><span class="label label-primary">label-primary</span></td>
                    </tr>
                    <tr>
                        <td>ATOM</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td><span class="label label-danger">label-danger</span></td>
                    </tr>
                    </tbody>
                </table>

            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Jiaoben</b></h3>
            </div>

            <div class="box-body">

                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben1967/') }}">
                    jiaoben1967 - CSS3悬停特效合集Hover.css
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben1597/') }}">
                    jiaoben1597 - jQuery动画标签折叠式菜单
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben2495/') }}">
                    jiaoben2495 - jQuery等高排列插件matchHeight
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben5873/') }}">
                    jiaoben5873 - WickedCSS3动画库演示特效
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben825/') }}">
                    jiaoben825 - jq+css3悬停效果 jquery+css3缩略图悬停效果
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben1087/') }}">
                    jiaoben1087 - css3标题悬停效果 css3标题悬停突出网页特效
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben4404/') }}">
                    jiaoben4404 - CSS3卡片鼠标悬停滑动代码
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben5150/') }}">
                    jiaoben5150 - 鼠标经过CSS3按钮动画特效
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben871/') }}">
                    jiaoben871 - css3 3D下拉菜单 css3 3D翻转下拉菜单
                </a>
                <br>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/jiaoben4660/') }}">
                    jiaoben4660 - 鼠标滑过按钮展开CSS3动画特效
                </a>
                <br>

            </div>

            <div class="box-header with-border">
                <h3 class="box-title"><b>17sucai</b></h3>
            </div>

            <div class="box-body">

                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/template-library/17sucai-mouseRight/') }}">
                    17sucai - jQuery自定义鼠标右键菜单插件
                </a>

            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection
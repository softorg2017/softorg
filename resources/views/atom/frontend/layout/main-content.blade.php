{{--<!-- Content Wrapper. Contains page content -->--}}
<div class="content-wrapper main-body" style="margin-left:0;background:url(/bg.gif) repeat;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display:none;">
        <h1>
            @yield('header')
            <small>@yield('description')</small>
        </h1>
        <ol class="breadcrumb">
            @yield('breadcrumb')
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" id="content-container">
        @yield('content') {{--Your Page Content Here--}}
    </section>
    <!-- /.content -->
</div>
{{--<!-- /.content-wrapper -->--}}
{{--<!-- Content Wrapper. Contains page content -->--}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @yield('header')
            <small>@yield('description')</small>
        </h1>
        <ol class="breadcrumb">
            @yield('breadcrumb')
        </ol>
    </section>

    <!-- Main content -->
    <section class="content main-content">
        @yield('content') {{--Your Page Content Here--}}


        {{--添加&编辑--}}
        @include(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-modal-for-item-edit')


        {{--修改-基本-信息--}}
        @include(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-modal-for-item-set')
    </section>
    <!-- /.content -->
</div>
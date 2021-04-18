{{--基本信息--}}
<section class="section-container bg-light bg-f">
    <div class="row">

        <header class="module-row module-header-container with-border-bottom text-center">
            <div class="wow slideInLeft module-title-row title-md _bold"><b>基本信息</b></div>
            <div class="wow slideInRight module-subtitle-row title-sm">section-information-description</div>
            <a class="pull-right print-btn _none" href="javascript:window.print()">Print This Property <i class="fa fa-print"></i></a>
        </header>

        <div class="module-row module-body-container property-contents">

            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <label>品牌：</label>
                            <span>{{ $data->custom->brand or '' }}</span>
                        </td>
                        <td>
                            <label>型号：</label>
                            <span>{{ $data->custom->model or '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>品牌所属地：</label>
                            <span>{{ $data->custom->brand_place or '' }}</span>
                        </td>
                        <td>
                            <label>产地：</label>
                            <span>{{ $data->custom->production_place or '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>款式：</label>
                            <span>{{ $data->custom->style or '' }}</span>
                        </td>
                        <td>
                            <label>系列：</label>
                            <span>{{ $data->custom->series or '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>尺寸：</label>
                            <span>{{ $data->custom->size or '' }}</span>
                            {{--<span>{{ $data->custom->size or '' }} m<sup>2</sup></span>--}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>外观颜色：</label>
                            <span>{{ $data->custom->outer_color or '' }}</span>
                        </td>
                        <td>
                            <label>金属件颜色：</label>
                            <span>{{ $data->custom->metal_color or '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="details" style="width:100%;">
                            <label>描述：</label>
                            <span>{{ $data->custom->description or '' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</section>


<style>
    .property-contents table { width:100%; }
    .property-contents tbody { width:100%; }
    .property-contents tr { width:100%; min-height:32px; line-height:32px; border-bottom:1px dashed #eee; }
    .property-contents td { width:50%;float:left; }
</style>
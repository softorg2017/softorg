{{--<!-- START: QRCode -->--}}
<section class="module-container text-center bg-dark" id="module-qrcode" itemid="announcement-section">
    <div class="container full-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Module-QRCode 权威发布</div>
            <div class="wow slideInRight module-subtitle-row title-sm">发布最新钢琴知识，扫码关注官方微信！</div>
        </header>

        <a class="btn" href="javascript:void(0);">
            <img src="{{ url(config('company.info.wechat_qrcode')) }}" alt="ISO Button" style="width:128px;">
        </a>
        <a class="btn _none" href="javascript:void(0);">
            <img src="{{ url(config('company.info.wechat_qrcode')) }}" alt="Play Store Button">
        </a>


    </div>
</section>
{{--<!-- END -->--}}

<style>
    #module-qrcode { background:url(/common/images/announcement-bg.jpg) center no-repeat; }
    #module-qrcode:before { display:inline-block; content:" "; position:absolute; top:0; bottom:0; left:0; right:0; background:rgba(244,166,77,0.7);  z-index:0; }
</style>
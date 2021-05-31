@extends(env('TEMPLATE_GPS_ADMIN').'layout.layout')

@section('head_title','【G】导航')

@section('header','导航')
@section('description','导航')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-body">
                <div>
                    <a target="_blank" class="margin btn btn-sm btn-default">btn-default</a>
                    <a target="_blank" class="margin btn btn-sm btn-success">btn-success</a>
                    <a target="_blank" class="margin btn btn-sm btn-warning">btn-warning</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger">btn-danger</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary">btn-primary</a>
                    <a target="_blank" class="margin btn btn-sm btn-info">btn-info</a>
                </div>
                <div>
                    <a target="_blank" class="margin btn btn-sm bg-defult" href="/">bg-default</a>
                    <a target="_blank" class="margin btn btn-sm bg-success" href="/">bg-success</a>
                    <a target="_blank" class="margin btn btn-sm bg-warning" href="/">bg-warning</a>
                    <a target="_blank" class="margin btn btn-sm bg-danger" href="/">bg-danger</a>
                    <a target="_blank" class="margin btn btn-sm bg-primary" href="/">bg-primary</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="/">bg-info</a>

                    <a target="_blank" class="margin btn btn-sm bg-olive" href="/">bg-olive</a>
                    <a target="_blank" class="margin btn btn-sm bg-purple" href="/">bg-purple</a>
                    <a target="_blank" class="margin btn btn-sm bg-orange" href="/">bg-orange</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="/">bg-maroon</a>
                    <a target="_blank" class="margin btn btn-sm bg-teal" href="/">bg-teal</a>
                    <a target="_blank" class="margin btn btn-sm bg-navy" href="/">bg-navy</a>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="/">bg-black</a>
                    <a target="_blank" class="margin btn btn-sm bg-grey" href="/">bg-grey</a>
                </div>
            </div>


            <div class="box-header with-border">
                <h3 class="box-title"><b>LY.Product</b></h3>
            </div>

            <div class="box-body">
                <div>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://lookwit.com">Lookwit</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://gps.lookwit.com/admin/">GPS</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://super.lookwit.com/admin/">SUPER</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://org.lookwit.com/admin/">ORG</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://doc.lookwit.com/admin">DOC</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://atom.lookwit.com/admim">ATOM</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://super.lookwit.com/admin/sql/insert">Super.SQL.Insert</a>
                </div>
                <div>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://ruwei.com">Lookwit</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://gps.ruwei.com/admin/">GPS</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://super.ruwei.com/admin/">SUPER</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://org.ruwei.com/admin/">ORG</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://doc.ruwei.com/admin">DOC</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://atom.ruwei.com/admin">ATOM</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://super.ruwei.com/admin/sql/insert">Super.SQL.Insert</a>
                </div>
            </div>


            <div class="box-header with-border">
                <h3 class="box-title"><b>LY.Tools</b></h3>
            </div>

            <div class="box-body">

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://ecs.console.aliyun.com/#/server/i-bp10lxdukyo9gnku1t5a/detail?regionId=cn-hangzhou">ECS-HZ</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://116.62.214.223/public/ppma/index.php">HZ-phpMyAdmin</a>
                </div>
                <div>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://ecs.console.aliyun.com/#/server/i-j6cgq48vcu8aj97enzhz/detail?regionId=cn-hongkong">ECS-HK</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://47.52.149.252/phpMyAdmin/">HK-phpMyAdmin</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://live2.pub:8088/">邮件服务器 live2.pub:8088</a>
                    <a target="_blank" class="margin btn btn-sm btn-primary" href="http://cuilongyun.win:8088/">邮件服务器 cuilongyun.win:8088</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://beian.aliyun.com/order/index.htm">阿里备案</a>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://netcn.console.aliyun.com/core/domain/list">阿里域名</a>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://dysms.console.aliyun.com/dysms.htm">阿里短信</a>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://market.aliyun.com/developer">阿里云·开发者工具</a>
                    <a target="_blank" class="margin btn btn-sm bg-black" href="https://qiye.aliyun.com/">阿里企业邮箱</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://mail.163.com/">网易邮箱</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://open.weixin.qq.com/">微信·开放平台</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://mp.weixin.qq.com/">微信·公众平台</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://mp.weixin.qq.com/wiki?t=resource/res_main">微信·公众号·开发文档</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list">微信·开放平台·开发文档</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://mp.weixin.qq.com/debug/wxadoc/dev/">微信·小程序·开发文档</a>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="https://exmail.qq.com/cgi-bin/loginpage">腾讯企业邮箱</a>
                </div>

            </div>

        <div class="box-header with-border">
            <h3 class="box-title"><b>Super.SQL</b></h3>
        </div>

        <div class="box-body">
            <div>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://lookwit.com">lookwit</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softorg.cn/super-admin/">超级管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softorg.cn/org-admin/">机构管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softdoc.cn">softdoc</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://k-org.cn/">K-ORG</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/developing/style/gps">softorg.GPS</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/super/admin">企业站超级管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/org/register">企业站注册</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/org/admin">企业站后台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/o/softorg">企业站前台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/inside/admin">Inside后台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.cn/outside/admin">Outside后台</a>
            </div>
            <div>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://ruwei.com">lookwit</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softorg.com/super-admin/">超级管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softorg.com/org-admin/">机构管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softdoc.com">softdoc</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://k-org.com/">K-ORG</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/developing/style/gps">softorg.GPS</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/super/admin">企业站超级管理员</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/org/register">企业站注册</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/org/admin">企业站后台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/o/softorg">企业站前台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/inside/admin">Inside后台</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://softorg.com/outside/admin">Outside后台</a>
            </div>
        </div>

            <div class="box-body">
                <div>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://seo.shmitong.com">SEO</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://juafc.com">汉盟地产</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://shxmej.com">盛贝地产</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://tinymax.cn">JJ-MAX</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://keron-relo.com">Keron</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://yunfei-piano.com">云飞</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://seo.shmitong.com/">速效云</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://baixing.suxiaoyun.cn/">速效云-百姓网</a>
                </div>
                <div>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://seo.mitong.com">SEO</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://local-hanmeng.com">汉盟地产</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://local-shengbei.com">盛贝地产</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://local-jjmax.com">JJ-MAX</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://local-keron.com">Keron</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://local-yunfei.com">云飞</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://seo.mitong.com/">速效云</a>
                    <a target="_blank" class="margin btn btn-sm bg-blue" href="http://api.mitong.com/">速效云-百姓网</a>
                </div>
            </div>

            <div class="box-body">

                <div>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softpub.cn">作者与作品 softpub.cn</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softrow.cn">图表站 softrow.cn</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://softblog.cn">课栈三人行 softblog.cn</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://tinyline.cn">时间线 tinyline.cn</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://topicbus.cn">话题社 topicbus.cn</a>
                    <a target="_blank" class="margin btn btn-sm btn-danger" href="http://you2.pub">树洞 you2.pub</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/login">登录页</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/guest">游客页</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo.date:8088/admin">作品</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/Program/truncate">truncate</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/Program/relation_init">relation_init</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/test">qingbo.test</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/testLearning">qingbo.testLearning</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/testLaravel">qingbo.testLaravel</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://qingbo8.cn:8088/testProgram">qingbo.testProgram</a>
                </div>

            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border" style="margin:4px 0 16px">
                <h3 class="box-title">Developing</h3>
            </div>


            <div class="box-header with-border">
                <h3 class="box-title">Programming.Tools</h3>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-purple" href="https://github.com/">GitHub</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="https://gitlab.com/">GitLab</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="https://gitee.com/">Gitee</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.bootcss.com/">BootCSS</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.bootcdn.cn/">BootCDN</a>
                <a target="_blank" class="margin btn btn-sm bg-primary" href="https://oneinstack.com/">oneinstack</a>
                <a target="_blank" class="margin btn btn-sm bg-primary" href="https://oneinstack.com/docs/lampstack-image-guide/">LAMP环境镜像使用手册</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://github.com/zusaleshi">donghai</a>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://expo.bootcss.com/">BootCSS.expo</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://echarts.baidu.com/index.html">echarts</a>
                <a target="_blank" class="margin btn btn-sm bg-primary" href="https://adminlte.io/themes/AdminLTE/index.html">AdminLTE</a>
                <a target="_blank" class="margin btn btn-sm bg-primary" href="https://adminlte.io/themes/AdminLTE/pages/UI/icons.html">Icons</a>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-danger" href="https://laravel.com/docs/5.5">Docs5.5(English)</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://d.laravel-china.org/docs/5.5">Docs5.5</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="http://d.laravel-china.org/docs/5.1">Docs5.1</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/153.html">Laravel 精选资源大全</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/205.html">Laravel 帮助函数</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/178.html">Laravel 集合</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="https://nwidart.com/laravel-modules/v1/introduction">laravel-modules</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Programming.Tools</h3>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://tool.chinaz.com/">站长工具</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.bejson.com/">Json验证</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://tool.oschina.net/encrypt?type=2">在线加密解密</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.atool.org/timestamp.php">时间戳</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://pandao.github.io/editor.md/">markdown(github)</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://cloudconvert.com/">cloudconvert WebP转图片</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://isparta.github.io/">isparta WebP转图片</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://processon.com/">免费在线作图ProcessOn</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.faviconico.org">在线转icon</a>
            </div>

            {{--Documents--}}
            <div class="box-header with-border">
                <h3 class="box-title">Documents</h3>
            </div>

            <div class="box-body">
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://www.liaoxuefeng.com/">廖雪峰</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="https://codeigniter.org.cn/docs">codeigniter</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://www.yiichina.com/">yii中文官网</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://select2.github.io/select2/">select2</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.open-open.com/lib/view/open1355830836135.html">Redis</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="https://space.bilibili.com/11490447#!/">万力B站</a>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://www.w3school.com.cn/">w3school</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://www.w3school.com.cn/php/index.asp">php</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://www.w3school.com.cn/js/index.asp">js</a>
                <a target="_blank" class="margin btn btn-sm btn-danger" href="http://www.w3school.com.cn/jquery/index.asp">jquery</a>
            </div>

            {{--Article.Laravel--}}
            <div class="box-header with-border">
                <h3 class="box-title">Article.Laravel</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.runoob.com/design-pattern/design-pattern-tutorial.html">设计模式</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/3502.html">多用户认证功能实现详解</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/3850.html">集成七牛云存储实现云存储功能</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://laravelacademy.org/post/2605.html">Simple QrCode 二维码</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://coding.imooc.com/class/chapter/111.html">Laravel 5.4 快速开发简书（课程）</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="https://d.laravel-china.org/docs/5.5/migrations">migrations 数据迁移</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.maatwebsite.nl/laravel-excel/docs">Laravel Excel</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href=""></a>
            </div>


            {{--Article.JQuery--}}
            <div class="box-header with-border">
                <h3 class="box-title">Article.JQuery</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.cnblogs.com/xiangsj/p/5884808.html">JQuery选中，置顶、上移、下移、置底、删除</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href=""></a>
            </div>


            {{--Article.Bootstrap--}}
            <div class="box-header with-border">
                <h3 class="box-title">Article.Bootstrap</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.runoob.com/bootstrap/bootstrap-modal-plugin.html">Bootstrap 模态框（Modal）插件</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href=""></a>
            </div>


            {{--Article.Others--}}
            <div class="box-header with-border">
                <h3 class="box-title">Article.Others</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.open-open.com/lib/view/open1355830836135.html">利用predis操作redis方法大全</a>
                <a target="_blank" class="margin btn btn-sm bg-olive" href=""></a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Medsci</h3>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://chandao.bioon.com:2222">禅道</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://doc.medon.com.cn:2222">日报</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://api.center.medsci.cn/api/docs#/">API.center</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://backend.bioon.com/admin">inside</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://common.backend.medsci.cn/admin">common</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://xy.bioon.com/admin_mooc/">行云后台</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://xy.bioon.com/">行云学院</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://customer.medsci.cn/imbruvica/index">杨森</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://customer.medsci.cn/casemeeting/meeting/list/bayer">拜新同</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://customer.medsci.cn/novonordisk/meeting/list/nhnd">诺和诺德</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://customer.medsci.cn/glypressin/index">可利新</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://customer.medsci.cn/glypressin/record/export">可利新下载</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://trial.medsci.cn/">患者招募</a>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>




{{--Documents--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border" style="margin:4px 0 16px">
                <h3 class="box-title">Life</h3>
            </div>
            <div class="box-body">

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.google.cn/maps">Google地图</a>
                    <a target="_blank" class="margin btn btn-sm bg-purple" href="http://map.baidu.com">百度地图</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://map.baidu.com/subways/index.html?c=shanghai">上海地铁</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.dy2018.com/">dy2018</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://www.youku.com/">优酷</a>
                    <a target="_blank" class="margin btn btn-sm bg-success" href="https://v.qq.com/">腾讯视频</a>
                    <a target="_blank" class="margin btn btn-sm bg-olive" href="http://www.iqiyi.com/">爱奇艺</a>
                    <a target="_blank" class="margin btn btn-sm bg-purple" href="https://www.iqiyi.com/a_19rrhb3xvl.html">海贼王</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://www.ashleymadison.com">ashleymadison</a>
                    <a target="_blank" class="margin btn btn-sm bg-purple" href="https://weibo.com/u/2427880080/home">微博</a>
                    <a target="_blank" class="margin btn btn-sm bg-purple" href="https://www.douban.com/">豆瓣</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://list.youku.com/show/id_z6e782defbfbd0d4e11ef.html">晓说</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://www.iqiyi.com/a_19rrgifngp.html">晓松奇谈</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://list.youku.com/show/id_z64feb2249b8211e296da.html">晓说第二季2013-14</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://list.youku.com/show/id_zc3c10ca46d8d11e1b52a.html">晓说第一季2012-13</a>

                    <a target="_blank" class="margin btn btn-sm bg-danger" href="http://list.youku.com/show/id_z5bdbf57c947311e3b8b7.html">罗辑思维</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://v.qq.com/detail/8/80376.html">十三邀 3</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://v.qq.com/detail/6/68145.html">十三邀 2</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://v.qq.com/detail/4/49622.html">十三邀 1</a>

                    <a target="_blank" class="margin btn btn-sm bg-danger" href="http://list.youku.com/show/id_z662fefbfbd61efbfbdef.html">一千零一夜走出季</a>
                    <a target="_blank" class="margin btn btn-sm bg-danger" href="http://list.youku.com/show/id_z7c87f1ae8e6311e5b522.html">一千零一夜</a>

                    <a target="_blank" class="margin btn btn-sm bg-warning" href="http://list.youku.com/show/id_zefbfbd3cefbfbd64efbf.html">圆桌派第3季</a>
                    <a target="_blank" class="margin btn btn-sm bg-warning" href="http://list.youku.com/show/id_z3127efbfbd11250911ef.html">圆桌派第2季</a>
                    <a target="_blank" class="margin btn btn-sm bg-warning" href="http://list.youku.com/show/id_z66ba2c36920211e6b9bb.html">圆桌派第1季</a>

                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://list.youku.com/show/id_zefbfbdefbfbd3e0defbf.html">局部 2</a>
                    <a target="_blank" class="margin btn btn-sm bg-info" href="http://list.youku.com/show/id_zcc117696c7cb11e4b432.html">局部 1</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-success" href="http://www.iqiyi.com/a_19rrhcoc51.html">坑王驾到 2</a>
                    <a target="_blank" class="margin btn btn-sm bg-success" href="http://www.iqiyi.com/a_19rrh9pwd9.html">坑王驾到 1</a>

                    <a target="_blank" class="margin btn btn-sm bg-orange" href="https://www.mgtv.com/h/320520.html">天天向上</a>
                </div>

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-success" href="http://list.youku.com/show/id_za94e7c9a1af411e5b2ad.html">新城商业</a>
                </div>

                <div>
                </div>

            </div>



            <div class="box-header with-border">
                <h3 class="box-title">Sports</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-orange" href="https://www.zhibo8.cc">直播吧</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://sports.pptv.com">PPTV</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://sports.sina.com.cn/g/pl/table.html">英超积分榜</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://sports.sina.com.cn/csl/table">中超积分榜</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://sports.qq.com/">腾讯体育</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://sports.qq.com/nba">腾讯NBA</a>

                <a target="_blank" class="margin btn btn-sm bg-success" href="https://weibo.com/donglu?is_all=1">董路微博</a>
                <a target="_blank" class="margin btn btn-sm bg-success" href="http://www.yizhibo.com/member/personel/user_info?memberid=39369208">董路一直播</a>
                <a target="_blank" class="margin btn btn-sm bg-success" href="http://star.longzhu.com/donglu/sport">董路龙珠</a>

                <a target="_blank" class="margin btn btn-sm btn-success" href="https://www.transfermarkt.com/">德国转会市场</a>
                <a target="_blank" class="margin btn btn-sm btn-success" href="http://www.stat-nba.com/query.php?QueryType=all&AllType=season&AT=tot&order=1&crtcol=threep&PageNum=50">NBA-数据库</a>
            </div>



            <div class="box-header with-border">
                <h3 class="box-title">Buy</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-default" href="https://www.amazon.cn/">亚马逊</a>
                <a target="_blank" class="margin btn btn-sm bg-danger" href="https://www.jd.com/">京东</a>
                <a target="_blank" class="margin btn btn-sm bg-primary" href="https://luojisiwei.tmall.com/category.htm?spm=a1z10.3-b-s.w4011-14454324002.43.5eeR3T&search=y&orderType=newOn_desc">罗辑思维</a>
            </div>



            <div class="box-header with-border">
                <h3 class="box-title">Life.Tools</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.gsxt.gov.cn/index.html">企业信用信息</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://xin.baidu.com/">百度企业信用</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://www.tianyancha.com/">天眼查</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://salarycalculator.sinaapp.com/">上海税后工资计算器</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.miitbeian.gov.cn">ICP备案</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.chsi.com.cn/">学信网</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://checkcoverage.apple.com/cn/zh/">apple保修服务和支持期限</a>
            </div>


            <div class="box-header with-border">
                <h3 class="box-title">Life.Tools</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.zhaopin.com/">智联招聘</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href=""></a>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>




<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border" style="margin:4px 0 16px">
                <h3 class="box-title">企业首页</h3>
            </div>
            <div class="box-body">

                <div>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.meritse.com/">锐凡企业管理咨询（上海）有限公司</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://www.paintin.cn/">Paintin（插画师）</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://leancapital.tk/">精益资本</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.youguard.cn/">上海誉甲自动化技术有限公司</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.10years.me/account/login">10年后</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.justsy.com">嘉兴嘉赛</a>
                    <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://www.vipp.com/en-us">vipp</a>
                </div>

                <div>

                </div>

            </div>

            <div class="box-header with-border">
                <h3 class="box-title">design</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="http://www.hellorf.com/">站酷海洛</a>
                <a target="_blank" class="margin btn btn-sm bg-maroon" href=""></a>
            </div>



        </div>
        <!-- END PORTLET-->
    </div>
</div>




{{--Reading--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-danger">

            <div class="box-header with-border" style="margin:4px 0 16px">
                <h3 class="box-title">Reading 读书</h3>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Miscellaneous</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://www.juzimi.com/">句子迷</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_1.aspx">《山海经》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_67.aspx">《徐霞客游记》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_51.aspx">《笑林广记》</a>

                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_3.aspx">《孙子兵法》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_4.aspx">《三十六计》</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">国学</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-maroon" href="https://v.qq.com/detail/8/8jwd4d9xbyar2u1.html">蔡志忠</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_6.aspx">《周易》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_28.aspx">《老子》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_26.aspx">《庄子》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_2.aspx">《论语》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_11.aspx">《孟子》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_20.aspx">《大学》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_21.aspx">《中庸》</a>

                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_18.aspx">《世说新语》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_75.aspx">《菜根谭》</a>

                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://www.daodejing.org/">《道德经》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://www.fosss.org/Book/ZhuangZi/Index.html">《庄子》白话译注</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://www.quanxue.cn/CT_DaoJia/ZhuangZiIndex.html">《庄子》劝学网</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">历史</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_5.aspx">《史记》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_8.aspx">《资治通鉴》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_9.aspx">《续资治通鉴》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_40.aspx">《汉书》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_41.aspx">《后汉书》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_54.aspx">《三国志》</a>

                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_19.aspx">《左传》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_143.aspx">《公羊传》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_44.aspx">《吕氏春秋》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_53.aspx">《战国策》</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">诗词歌赋</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/sanbai.aspx">《古诗三百首》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/tangshi.aspx">《唐诗三百首》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/songsan.aspx">《宋词三百首》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/shijing.aspx">《诗经》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/chuci.aspx">《楚辞》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/gushi/yuefu.aspx">《乐府诗集选》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/wenyan/guanzhi.aspx">《古文观止》</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">名著</h3>
            </div>
            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_105.aspx">《红楼梦》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_106.aspx">《三国演义》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_107.aspx">《水浒传》</a>
                <a target="_blank" class="margin btn btn-sm bg-purple" href="http://so.gushiwen.org/guwen/book_108.aspx">《西游记》</a>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection



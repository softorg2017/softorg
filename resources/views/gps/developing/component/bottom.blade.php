
{{--<script type="text/javascript" src="{{ asset('/templates/moban2030/assets/js/base.js') }}"></script>--}}
{{--<script type="text/javascript">--}}
    {{--$(function () {--}}
        {{--//初始化发表评论表单--}}
        {{--AjaxInitForm('feedback_form', 'btnSubmit', 1);--}}
    {{--});--}}
{{--</script>--}}
{{--<script type="text/javascript">--}}
    {{--$(function () {--}}
        {{--//初始化发表评论表单--}}
        {{--AjaxInitForm('feedback_form2', 'btnSubmit2', 1);--}}
    {{--});--}}
{{--</script>--}}


{{--<script charset="utf-8"></script>--}}
<style type="text/css">
    <!--
    .unnamed1 {
        font-family:Microsoft yahei,"宋体";
        font-size: 12px;
        line-height: 22px;
    }
    .submit
    {
        background-color:#ff312e;
        FONT-SIZE: 14px;
        color:#fff !important;
        width:90px;
        height:30px;
        border:none;
        cursor:pointer;
    }
    .submit_quxiao
    {
        background-color:#31a8fc;
        FONT-SIZE: 14px;
        color:#fff !important;
        width:90px;
        height:30px;
        border:none;
    }
    .input {
        font-size: 12px;
        color: #000099;
        background-color: #FFFFFF;
        border: 1px groove #CCCCCC;
        height:22px;
    }
    .menu4 { FONT-SIZE: 14px; COLOR: #fff; FONT-FAMILY: Microsoft yahei,"宋体"; TEXT-DECORATION: none;LINE-HEIGHT: 21px; }


    .breakNewsblock { position: relative; margin: 0 auto; width: 310px; overflow: hidden }

    #breakNews .list6 { margin-top: 5px; padding-left: 10px; width: 310px; float: left; height: 90px; color: #fff; font-size: 14px; overflow: hidden }
    #breakNews .list6 LI { padding-bottom: 3px; padding-left: 0; padding-right: 0; padding-top: 3px }
    #breakNews .hit { margin-top: 5px; width: 17px; float: right; height: 18px }
    #breakNews .hit SPAN { width: 13px; display: block; margin-bottom: 6px; float: left; height: 10px }

    .act_nav { position:fixed; left:0; bottom:0; width:100%; height:140px; padding: 16px 0; z-index:800;
        background:url("/templates/moban2030/assets/images/bottom.png") repeat; }
    .act_nav .s_w { width:1000px; margin:10px auto;}
    .act_nav .s_w .s_w_left { width:670px; height:auto; float:left;}
    .act_nav .s_w .s_w_right { width:310px; height:auto; margin-left:20px; float:left;}
    .act_nav .s_close { position:absolute; top:8px; right:8px; width:32px; height:32px; line-height:32px; color:#fff; font-size:32px; font-weight:100; z-index:999; }

    .act_nav .s_w .bm-top { width:100%; min-height:42px; }
    .act_nav .s_w .bm-bottom { width:100%; min-height:42px; line-height:42px; margin-top:16px; }
    .act_nav .s_w .bm-bottom span { height:30px; line-height:30px; }

    .act_nav .s_w input { height:30px; font-size:14px; }
    .act_nav .s_w .bm-input { width:420px; min-height:32px; line-height:32px; font-size:16px; float: left; }
    .act_nav .s_w .bm-submit { width:200px; min-height:32px; margin-left:16px; float: left; }
    .act_nav .s_w .bm-submit input { height:32px; }


    .bm-title { display:block; width:420px; height:42px; margin-right:16px; float:left; }
    .bm-tel { display:block; width:232px; height:42px; float:left; }
    .bm-tel img { height:42px; margin-right:8px; float:left; }
    .bm-tel a { font-size:24px; float:left; }


    .act_nav .s_w .bm-bottom { margin-top: 16px; line-height:32px; }

    .bm-input-item { width:50%; margin-top:8px; float:left;}
    .bm-input-item span { width:50px; text-align: center; float:left; }
    .bm-input-item input { width:calc(100% - 50px); float:left;}

    .div_tel { display:block;  margin-left:15px; color:#fff; font-size:22px; float:left;}

    @media screen and (max-width: 768px) {
        .act_nav { width:100%; height: 192px; padding: 8px; }
        .act_nav .row { margin: 0; }
        .act_nav .s_w { width:100%; height: auto; }
        .act_nav .s_w .s_w_left { float:left; width:100%;}
        .act_nav .s_w .s_w_right { display: none; }

        .act_nav .s_w .bm-top { min-height:20px; line-height:20px; font-weight:bold; color:#fff; }
        .act_nav .s_w .bm-bottom { margin-top: 16px; line-height:22px; }
        .act_nav .s_w .bm-input { width: 100%; clear: both; }
        .act_nav .s_w .bm-submit { width: 100%; clear: both; margin-top:16px; margin-left:0; }

        .bm-title { width:200px; height:20px; }
        .bm-tel { width:auto; height:20px; padding: 0 16px; }
        .bm-tel img { height:20px; }
        .bm-tel a { font-size:16px; }


        .bm-input-item { width:100%; float:left;}
    }
    -->
</style>

<script language="javascript" type="text/javascript">

    function ScrollText(content,btnPrevious,btnNext,autoStart,timeout,isSmoothScroll)
    {
        this.Speed = 1;
        this.Timeout = timeout;
        this.stopscroll =false;//是否停止滚动的标志位
        this.isSmoothScroll= isSmoothScroll;//是否平滑连续滚动
        this.LineHeight = 10;//默认高度。可以在外部根据需要设置
        this.NextButton = this.$(btnNext);
        this.PreviousButton = this.$(btnPrevious);
        this.ScrollContent = this.$(content);
        this.ScrollContent.innerHTML += this.ScrollContent.innerHTML;//为了平滑滚动再加一遍
        if(this.PreviousButton)
        {
            this.PreviousButton.onclick = this.GetFunction(this,"Previous");
            this.PreviousButton.onmouseover = this.GetFunction(this,"MouseOver");
            this.PreviousButton.onmouseout = this.GetFunction(this,"MouseOut");
        }
        if(this.NextButton){
            this.NextButton.onclick = this.GetFunction(this,"Next");
            this.NextButton.onmouseover = this.GetFunction(this,"MouseOver");
            this.NextButton.onmouseout = this.GetFunction(this,"MouseOut");
        }
        this.ScrollContent.onmouseover = this.GetFunction(this,"MouseOver");
        this.ScrollContent.onmouseout = this.GetFunction(this,"MouseOut");
        if(autoStart)
        {
            this.Start();
        }
    }
    ScrollText.prototype = {
        $:function(element)
        {
            return document.getElementById(element);
        },
        Previous:function()
        {
            this.stopscroll = true;
            this.Scroll("up");
        },
        Next:function()
        {
            this.stopscroll = true;
            this.Scroll("down");
        },
        Start:function()
        {
            if(this.isSmoothScroll)
            {
                this.AutoScrollTimer = setInterval(this.GetFunction(this,"SmoothScroll"), this.Timeout);
            }
            else
            {
                this.AutoScrollTimer = setInterval(this.GetFunction(this,"AutoScroll"), this.Timeout);
            }
        },
        Stop:function()
        {
            clearTimeout(this.AutoScrollTimer);
            this.DelayTimerStop = 0;
        },
        MouseOver:function()
        {
            this.stopscroll = false;
        },
        MouseOut:function()
        {
            this.stopscroll = false;
        },
        AutoScroll:function()
        {
            if(this.stopscroll)
            {
                return;
            }
            this.ScrollContent.scrollTop++;
            if(parseInt(this.ScrollContent.scrollTop) % this.LineHeight != 0)
            {
                this.ScrollTimer = setTimeout(this.GetFunction(this,"AutoScroll"), this.Speed);
            }
            else
            {
                if(parseInt(this.ScrollContent.scrollTop) >= parseInt(this.ScrollContent.scrollHeight) / 2)
                {
                    this.ScrollContent.scrollTop = 0;
                }
                clearTimeout(this.ScrollTimer);
//this.AutoScrollTimer = setTimeout(this.GetFunction(this,"AutoScroll"), this.Timeout);
            }
        },
        SmoothScroll:function()
        {
            if(this.stopscroll)
            {
                return;
            }
            this.ScrollContent.scrollTop++;
            if(parseInt(this.ScrollContent.scrollTop) >= parseInt(this.ScrollContent.scrollHeight) / 2)
            {
                this.ScrollContent.scrollTop = 0;
            }
        },
        Scroll:function(direction)
        {
            if(direction=="up")
            {
                this.ScrollContent.scrollTop--;
            }
            else
            {
                this.ScrollContent.scrollTop++;
            }
            if(parseInt(this.ScrollContent.scrollTop) >= parseInt(this.ScrollContent.scrollHeight) / 2)
            {
                this.ScrollContent.scrollTop = 0;
            }
            else if(parseInt(this.ScrollContent.scrollTop)<=0)
            {
                this.ScrollContent.scrollTop = parseInt(this.ScrollContent.scrollHeight) / 2;
            }
            if(parseInt(this.ScrollContent.scrollTop) % this.LineHeight != 0)
            {
                this.ScrollTimer = setTimeout(this.GetFunction(this,"Scroll",direction), this.Speed);
            }
        },
        GetFunction:function(variable,method,param)
        {
            return function()
            {
                variable[method](param);
            }
        }
    }
    function ignoreError() {
        return true;
    }
    window.onerror = ignoreError;
</script>

<style type="text/css">
    <!--
    .style1 {color: #FF0000}
    -->
</style>

<div class="act_nav" id="bottom-bm-container">
    <div class="s_close" id="bottom-bm-close" style="display:none;"><i class="fa fa-times-circle"></i></div>
    <div class="s_w">
        <div class="row s_w_left">
            <div class="row pull-left bm-top">
                <div class="bm-title"><img src="{{ url('/templates/moban2030/assets/images/bm.png') }}" alt=""></div>
                <div class="bm-tel hidden-xs">
                    <img src="{{ url('/templates/moban2030/assets/images/tel.png') }}" alt="">
                    <a href="tel:{{ config('company.info.telephone') }}" style="color:#fff;">{{ config('company.info.telephone') }}</a>
                </div>
            </div>

            <div class="row pull-left bm-bottom">
                <div class="bm-input">
                    <form id="form-book-appointment">

                        {{csrf_field()}}

                        <div class="bm-input-item">
                            <span class="menu4">姓名：</span>
                            <input type="text" name="name" class="input" id="book-name" placeholder="姓名">
                        </div>

                        <div class="bm-input-item">
                            <span class="menu4">手机：</span>
                            <input type="text" name="mobile" class="input" id="book-mobile" placeholder="手机">
                        </div>

                    </form>
                </div>
                <div class="bm-submit">
                    <input name="btnSubmit" class="submit" id="btnSubmit" value="立即预约" type="submit"> &nbsp;
                    <input name="Submit2" value="清空" class="submit_quxiao hidden-xs" type="reset"> &nbsp;
                    <div class="bm-tel visible-xs" style="float:right;">
                        <img src="{{ url('/templates/moban2030/assets/images/tel.png') }}" alt="">
                        <a href="tel:{{ config('company.info.telephone') }}" style="color:#fff;">{{ config('company.info.telephone') }}</a>
                    </div>
                </div>

            </div>
        </div>

        {{--<!-- 滚动文字 -->--}}
        <div class="s_w_right">
            <div class="breakNewsblock">
                <div id="breakNews">
                    <ul id="breakNewsList" class="list6">
                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>
                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>

                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>
                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>

                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>
                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>

                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>
                        <li>黄丽燕	成功报名看房	139****3077</li>
                        <li>吴兴良	成功报名看房	139****1638</li>
                        <li>张军	成功报名看房	138****9689</li>
                        <li>翟敦超	成功报名看房	135****8928</li>
                        <li>李晓通	成功报名看房	137****0150</li>
                        <li>邓慧敏	成功报名看房	139****6384</li>
                        <li>姚贤荣	成功报名看房	133****6012</li>
                    </ul>
                </div>
            </div>
            <script language="javascript" type="text/javascript">
                var scroll2 = new ScrollText("breakNewsList","pre2","next2",true,50,true);
                scroll2.LineHeight = 22;
            </script><!-- 滚动文字结束--></div>

    </div>
</div>




{{--<script language="javascript">--}}


{{--function checkform1(){--}}
{{--if(form1.names.value=="")--}}
{{--{--}}
{{--alert("名字不能为空");--}}
{{--form1.name.focus();--}}
{{--return false;--}}
{{--}--}}
{{--var filter=/^1[3|4|5|8][0-9]\d{ 4,8}$/;--}}
{{--if(!filter.test(document.form1.tels.value))--}}
{{--{--}}
{{--alert("请输入正确的手机号!");--}}
{{--document.form1.tels.focus();--}}
{{--form1.dianhua.value="";--}}
{{--return false;--}}
{{--}--}}
{{--form1.submit();--}}
{{--return true;--}}
{{--}--}}
{{--</script>--}}
@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/customer.css" />
@endsection

@section('content')
        <!-- 在线客服 start-->
<div class="w_1210 cus_container border-bfe2ff background-f0fbff clearfix">
    <b class="cus_tips"></b>
    <h2 class="cus_h2tit">客户服务中心</h2>
    <p class="cus_h2des color-cbcdcc">CUSTOMER SERVICE CENTER</p>
    <div class="cus_h2help"><span class="color-817f82">如果您有疑问或需要帮助，可以在此联系客服。</span><span class="color-ff5300">提示：有些QQ版本不能直接聊天，请先加为好友！</div>
    <!--list start-->
    <div class="cus_list background-ffffff border-bfe2ff clearfix">
        <ul>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico1"></span>企业客服</div>
                <h2 class="cus_bdes">负责咨询与各种问题解答。<br />QQ:40106639676</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico2"></span>匿名交流</div>
                <h2 class="cus_bdes">负责咨询与各种问题解答。<br />QQ:40106639676</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico3"></span>财务专员</div>
                <h2 class="cus_bdes">负责网站充值与代理商提现。<br />QQ:40106639676</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico4"></span>疑问解答</div>
                <h2 class="cus_bdes">负责咨询与各种问题解答。<br />QQ:40106639676</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico3"></span>值班客服</div>
                <h2 class="cus_bdes">周一到周五晚上7:00-9:00。<br />QQ:40106639676</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
            <li>
                <div class="cus_btit"><span class="cus_bico cus_bico6"></span>投诉建议</div>
                <h2 class="cus_bdes">负责网站投诉或建议处理与任务的申诉处理。</h2>
                <div class="cus_onlinqq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=123456789&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:123456789:51" alt="特速1块购在线客服" title="特速1块购在线客服"/></a></div>
            </li>
        </ul>
    </div>
    <!--list end-->

    <!--联系方式 start-->
    <div class="cus_contact border-bfe2ff">
        <h2 class="cus_cnt_h2">联系方式</h2>
        <div class="cus_cnt_txt">
            <ul>
                <li><span class="color-323232">工作时间：</span> <span class="color-7f8180">周一至周六 9：00 - 16:00 （其他时间段联系值班客服）</span></li>
                <li><span class="color-323232">全国免费客服电话：</span> <span class="color-7f8180">400-633-9676</span></li>
                <li><span class="color-323232">客服邮箱-Email：</span> <span class="color-7f8180">kefu@tsykg.com</span></li>
                <li><span class="color-323232">商务合作-Email：</span> <span class="color-7f8180">serve@tsykg.com</span></li>
                <li><span class="color-323232">官方千人QQ交流群：</span><a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=acbc8eaad0a2b4d47670a13772cefada25cde7c19b0bc47209c2e82edaadea4f"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="特速1块购QQ群" title="特速1块购QQ群"></a></li>
            </ul>
        </div>
    </div>
    <!--联系方式 end-->
</div>
<!-- 在线客服 end-->

@endsection
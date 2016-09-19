{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','邀请好友')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">

@endsection
@section('content_right')
    <div id="member_right" class="member_right">
        <!--invite start-->
        <div class="mem-invite">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a u_quet_acurr" href="javascript:void(0)" title="去邀请好友">去邀请好友</a>
                <a class="u_quet_a" href="/user/invite/score" title="邀请结果">邀请结果</a>
                <a class="u_quet_a" href="/user/inviteprize" title="邀友获奖记录">邀友获奖记录</a>
            </div>
            <!--tit end-->
            <!--内容 start-->
            <div class="mem-invtxt">
                <div class="mem-invad"><img src="{{ $url_prefix }}img/ad/invite_banner.png"></div>
                <div class="a_invite_link">
                    <em>您的邀请链接</em>
                    <span id="invite_link">http://{{$_SERVER['HTTP_HOST']}}/freeday?code={{session('user.id')}}</span>
                </div>
                <div class="a_invite_link">
                    <em>您的邀请码</em>
                    <span id="invite_mobile">{{session('user.id')}}</span>
                    &nbsp;&nbsp;您的好友注册时记得告诉他推荐人填写您的邀请码哦~
                </div>
                <!--分享 start-->
                <div class="a_invite_link_share">
                    <div class="a_invite_share_list a_invite_share_qq" id="a_invite_share_qq">
                        <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1457319308843">

                            <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title=一块购 快乐购&summary=1元就能买iPhone 6S，一种很有意思的购物方式，快来看看吧！&url=http%3A%2F%2F{{$_SERVER['HTTP_HOST']}}%2Ffreeday%3Fcode%3D{{session('user.id')}}&pics=''" class="bds_qzone" id="qq_share_link" target="_blank" title="分享到QQ空间">
                            <span></span></a>
                        </div>
                        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    </div>
                    <div class="a_invite_share_list a_invite_share_click a_invite_share_wx">
                        <span></span>
                        <div class="a_invite_share_click_down">
                            {!! QrCode::size(255)->generate('http://m.ts1kg.com'.'/freeday_m?code='.session('user.id')); !!}
<!--                            <img id="wxImg" src="{{ $url_prefix }}img/weishare.png">-->
                        </div>
                    </div>
                    <div class="a_invite_share_list a_invite_share_click a_invite_share_dx">
                        <span onclick="window.location='/activity'"></span>
<!--                        <div class="a_invite_share_click_down" style="display: none;">
                            <form >
                                <p class="a_share_dx_p" id="invite_notice">我是6097，邀您一起去云购，记得注册时填写我的邀请码：YG15915476097,点击http://www.qq.com/register
                                </p>
                                <input id="toMobile" onkeydown="$('#sendSMS').html('发送');" maxlength="11" type="text" placeholder="对方手机号">
                                <label>
                                    <input id="validCode" style="ime-mode:disabled " class="a_invite_share_click_down_input" type="text" placeholder="验证码">
                                    <em><img id="validCodeImg" src="/member/invite/validCode.do" onclick="reloadValidCode();" width="84px" height="28px"></em>
                                    <em><img id="validCodeImg" src="" onclick="reloadValidCode();" width="84px" height="28px"></em>
                                </label>
                                <a id="sendSMS" href="javascript:void(0);" onclick="sendSMS();">发送</a>
                            </form>
                        </div>-->
                    </div>
                </div>
                <!--分享 end-->
                <!--规则 start-->
                <div class="a_invite_font">
                    <h2>活动规则</h2>
                    <p>一、邀请人奖励</p>
                    <p class="a_invite_font1">   每成功推荐一名好友注册并消费您将获得<span id="">100</span>块乐豆。</p>
                    <p class="a_invite_font1">在【我的账户】的【我的块乐豆】里可看到您的每次积分奖励记录。</p>
<!--                    <p style="margin-top:15px;">二、被邀请人奖励</p>
                    <p class="a_invite_font1">1.  被推荐的好友手机认证成功可获得<span id="phone_verify_score">50</span>块乐豆</p>
                    <p class="a_invite_font1" style="padding-bottom:20px;">2.  被推荐的好友邮箱认证成功可获得<span id="">50</span>块乐豆</p>-->
                </div>
                <!--规则 end-->
            </div>
            <!--内容 end-->
        </div>
        <!--invite end-->
    </div>
    <!-- E 右侧 -->
@endsection

@section('my_js')
    <script>
            //二维码，短信 下拉收回
            $(".a_invite_share_list span").click(function(){
                $(this).siblings(".a_invite_share_click_down").slideToggle(300);
            });
    </script>
@endsection


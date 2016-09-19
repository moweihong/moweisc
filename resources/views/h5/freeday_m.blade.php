@extends('foreground.master_for_freeday_m')
@section('my_css')
  <meta name="viewport" content="initial-scale=0.41,minimum-scale=0.41,maximum-scale=0.41,user-scalable=yes" />
@endsection
<div class="all_grey_bg">
</div>
<div class="all_white_bg">
</div>
@section('content')
<style>
html{position:relative;overflow-x: hidden;}
#wrapper {
    position:absolute; 
    top:0; bottom:0px; left:0;
    width:100%;
    background:#555;
    overflow:auto;
}

#scroller {
    position:relative;
/*  -webkit-touch-callout:none;*/
    -webkit-tap-highlight-color:rgba(0,0,0,0);

    float:left;
    width:100%;
    padding:0;
}
.bdsharebuttonbox .bds_qzone,.bdsharebuttonbox .bds_tsina,.bdsharebuttonbox .bds_weixin,.bdsharebuttonbox .bds_renren,.bdsharebuttonbox .bds_tqq{
    background-size:100% 100%;
    width:49px;
    height:47px;
    margin-left:5px;
}
.bdsharebuttonbox .bds_qzone{
    background: url({{ $url_prefix }}img/qq_ioc.png) no-repeat;
}
.bdsharebuttonbox .bds_tsina{
    background: url({{ $url_prefix }}img/weibo.png) no-repeat;
}
.bdsharebuttonbox .bds_weixin{
    background: url({{ $url_prefix }}img/weichat.png) no-repeat;
}
.bdsharebuttonbox .bds_renren{
    background: url({{ $url_prefix }}img/happy_dou.png) no-repeat;
}
.bdsharebuttonbox .bds_tqq{
    background: url({{ $url_prefix }}img/moment.jpg) no-repeat;
}
.header,.yNavIndexOut {
display:none;
}
.qiang_img{
    width: 465px;
    height: 93px;
    animation: qiangBgKeyframes1 2000ms linear;

}
@keyframes qiangBgKeyframes1 {
    0%{
        width: 0px;
        height: 0px;
    }
    30%{
        width: 0px;
        height: 0px;
    }
    60%{
        width: 800px;
        height: 160px;
    }
    80%{
        width: 800px;
         height: 160px;
    }
    100%{
        width: 465px;
        height: 93px;
    }
}

.invite_friend_grey:hover{
    color:white;
}
</style>
<div id="wrapper"><div>
<!--content start-->
<div class="tiger_bg">
    <div class="tiger_content">
        <div class="gold_packet">
            <img src="{{ $url_prefix }}img/gold_explode.png" alt="" class="gold_explode hide">
            <img src="{{ $url_prefix }}img/gold_packet.png" alt="" class="gold_packet_img">
        </div>

        <div class="qiang_bg">
            <img src="{{ $url_prefix }}img/qiangtitle_big.png" alt="" class="qiang_img">
        </div>
        <div id="tiger_machine_container" class="hide">
            <div class="hqct_bg">
            </div>
            <div class="tiger_machine ">
            </div>

            <div class="number_container ">
                <ul>
                    <li>
                        <div class="p_div"><p>9</p></div>
                    </li><!--117-->
                    <li>
                        <div class="p_div"><p>9</p></div>
                    </li>
                    <li>
                        <div class="p_div"><p>9</p></div>
                    </li>
                </ul>
            </div>
            <div class="hand_shank_01" id="hand_shank"></div>
        </div>
        <div class="finger_bg">
        </div>
        <div class="join_btn_normal hide" id="join_btn_normal"></div>
        <div class="clock" >
            <div class="clock_div">
                <i><span>0</span><span>0</span></i>
                <span>:</span>
                <i><span>0</span><span>0</span></i>
                <span>:</span>
                <i><span>0</span><span>0</span></i>
            </div>
        </div>
       <div class="light_ct">
       <div class="light_bg"></div>
         <div class="explode">
                   <img src="{{ $url_prefix }}img/explode.png" alt=""/>
         </div>
       </div>
        <div class="announce_rule"></div>
        <div class="rule_container">
        <p class="rule-btn">抢红包规则> </p>
        </div>
        <!--弹出层start-->
           <!--块乐豆不足-->
                <div class="money_not_enough">
                <div class="not_enough_top">马上开抢<i class="close_btn1">x</i></div>
                <div class="not_enough_content">
                    <p class="not_enough_msg">客官您的块乐豆还差<br/>那么一点点</p>
                    <p class="not_enough_money">块乐豆余额：<span class="not_enough_bean">@if(session('user.id')) {{$member->kl_bean}} @else 0 @endif</span></p>
                    <div class="make_money_btn">去赚块乐豆</div>
                </div>  
                </div>
                <!--领取确认-->
                <div class="receive_confirm">
                <div class="receive_confirm_top">奖品领取<i class="close_btn1">x</i></div>
                <div class="receive_confirm_content">
                    <p class="receive_confirm_msg">客官，每人仅限领一个哦~</p>
                    <div class="receive_confirm_btn">我就要Ta</div>
                    <div class="receive_confirm_btn2">要更好的</div>
                </div>  
                </div>
                <!--领取成功-->
                <div class="receive_confirm_new">
                <div class="not_enough_top">奖品领取<i class="close_btn1">x</i></div>
                <div class="not_enough_content">
                    <p class="not_enough_msg">客官，恭喜您领取成功</p>
                    <p class="not_enough_money">收货地址的手机号码需与注册手机<br />号码一致（包括虚拟充值等）</p>
                    <div class="receive_success_btn2">好哒</div>
                </div>  
                </div>
                <!--抢红包提示-->
                <div class="qiang_confirm">
                <div class="qiang_confirm_top">马上开抢<i class="close_btn1">x</i></div>
                <div class="qiang_confirm_content">
                    <p class="qiang_confirm_msg">客官，100块乐豆一次哦~</p>
                    <div class="qiang_confirm_btn">好哒</div>
                    <div class="receive_confirm_btn2">不了</div>
                </div>  
                </div>
                <!--无货提示-->
                <div class="out_of_goods">
                <div class="out_of_goods_top">奖品领取<i class="close_btn1">x</i></div>
                <div class="out_of_goods_content">
                    <p class="out_of_goods_msg">客官，您手速太慢啦~</p>
                    <p class="out_of_goods_msg2">据说每天10:00后补货哦~</p>
                    <div class="out_of_goods_btn">选个别的呗</div>
                </div>  
                </div>
                 <!--揭晓规则-->
                 <div class="announce_rule_alert">
                     <span>今日超级幸运码：{{ $lucky_num }}</span>
                     <div class="announce_line"></div>
                     <p>超级幸运码的产生：按照当天的日期，年月日取后三位</p>
                     <em>例如：今天是{{ date('Y', time()) }}年{{ date('n', time()) }}月{{ date('d', time()) }}日，今日超级幸运码为{{ $lucky_num }}</em>
                     <div class="announce_rule_content">
                        <span>参与规则</span>
                        当你随机摇到的数字与当天的超级幸运码一样时即为中奖，中奖者获得999元现金红包，红包直接存入你的账户余额，不可提现。首次参与没有中奖，系统自动赠送5元红包。
                     </div>
                     <div class="close_window"><a data-url="javascript:void(0);" class="close_btn">关闭窗口</a></div>
                 </div>
        <!--未登录-->
        <div class="login_alert">
            <span>一块购账号登录</span>
            <span id="close_login" style="color:#999;float:right;cursor:hand;margin-right:10px;font-weight:normal">关闭</span>
            <div class="login_line"></div>
             <div class="login_account">
                 <div class="login_ioc_div">
                    <i><img src="{{ $url_prefix }}img/user_ioc.png" alt=""/></i>
                 <div class="vertical_line"></div>
                 </div>
                 <input type="text" placeholder="请输入手机号" name="username">
             </div>
            <div class="login_account">
                <div class="login_ioc_div">
                    <i><img src="{{ $url_prefix }}img/password_ioc.png" alt=""/></i>
                    <div class="vertical_line"></div>
                </div>
                <input type="password" placeholder="请输入密码" name="password" >
            </div>
            <input type="button" value="立即登录" class="login_btn">
            <div class="forget_title"><a href="/forgetpwd_m" class="fl">忘记密码</a><a href="/reg_m" class="fr">立即注册</a></div>
<!--             <div class="other_platform"><p>第三方登录</p> </div> -->
<!--             <div class="other_platform_ioc"> -->
<!--                 <a href="#"><img src="{{ $url_prefix }}img/qq_ioc.png"/></a> -->
<!--                 <a href="#"><img src="{{ $url_prefix }}img/weichat.png"/></a> -->
<!--               <a href="#"><img src="{{ $url_prefix }}img/weibo.png" style="margin-bottom: 1px;"/></a>  -->
<!--             </div> -->
        </div>

        <div class="award_result">
            <a href='javascript:void(0)' data-url='javascript:void(0)' id="continue_btn"></a>
            <a href='/user_m/bribery' data-url='/user_m/bribery' id="check_btn"></a>
        </div>
         <!--领取成功-->
                  <div class="receive_success">
                        <p class="congratulate_success">恭喜您领取成功</p>
                      <a href="/user_m/usercenter2" style="font-size: 20px;margin-left:30px;">请到个人中心-邀友获奖记录查看</a>
                    </div>
        <!--弹出层end-->
        <!--领取失败-->
                  <div class="receive_fail">
                        <p class="congratulate_success"></p>
                  </div>  
     <!--邀请好友方式-->
       <div class="code-content">
                   <h1 class="codec-tit">赚取块乐豆</h1>
                  
                   <div class="codec-txt">
                       1、微信客户端可直接点击右上角···分享<br />
                       2、邀请好友扫描二维码
                       <p class="codec-img">{!! QrCode::size(400)->margin(1)->generate($invite_url); !!}</p>
                        	<p class="font_center">手机其他浏览器分享可截屏此二维码通过</p><p class="font_center">微信/QQ分享给朋友</p>
                       <p class="make-money-tip">通过购买商品也能赚取块乐豆哦</p>
                   </div>
                   <div class="codec-close">知道了</div>
           </div> 
           <!--注册成功-->
           <div class="reg_content">
            <p class="reg_tit">恭喜您注册成功！</p>
            <p>您获得了一次免费抽取<br/><em>999元现金红包</em>的机会</p>
            <div class="codec-close">马上开抢</div>
           </div>         
        <!--弹出层end-->
        <div class="good_news">
          <div class="good_news_center" style="width:740px;">
                          <ul>
                          @if(!empty($anouncement))
                          @foreach($anouncement as $log)
                              <li><span class="news-title">最新喜报</span>：恭喜用户<span class="news-title"> {{$log['nickname']}} </span>获得了{{$log['desc']}}</li>
                          @endforeach
                          @else
                              {{--<li><span class="news-title">最新喜报</span>：恭喜用户<span class="news-title"> 匿名 </span>获得了999元现金红包</li>--}}
                          @endif
                          </ul>
          </div>
        </div>
      <!--  <div class="invite_friend_district">免费领</div>-->
       <!-- <div class="phone_show phone_show01">
        	@if(session('user.id'))
            	<div class="invite_friend_tip" style="width:900px;margin-left:-50px">邀请好友参与即可免费领取!&nbsp;&nbsp;&nbsp;当前已邀请：{{$total_invite}}人，<a href="/user_m/inviteprize" data-url="/user_m/inviteprize" style="font-size:22px;color: white">查看我的奖品>></a></div>
            @else
            	<div class="invite_friend_tip">邀请好友参与即可免费领取!<span style='margin-left:10px;color:#FFFF00;font-size:18px'>活动时间：2016年6月2日止（商品未领完可以继续领取哦~）
</span></div>
            @endif
            <ul>
            @if(count($invite_goods) > 0)
                @foreach($invite_goods as $invite_good)
                    <li>
                        <div class="phone_show_div">
                            <img src="{{ $invite_good->img }}"/>
                            <div class="trans_bg">
                                <div class="grey_bg">
                                    <p class="invite_title">{{ $invite_good->title }}</p>
                                    @if(session('user.id'))
                                        <p><span class="total_invite">{{ $total_invite }}</span>/<span class="total_need">{{ $invite_good->invite_need }}</span></p>
                                    @else
                                        <p><span>剩余{{$invite_good->stock}}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class='width' value="{{ $invite_good->width }}">
                        @if($is_get == 0)
                            @if(session('user.id') && $total_invite >= $invite_good->invite_need)
                                <a href='javascript:void(0)'  data-url='javascript:void(0)' g_id="{{ $invite_good->id }}" class="invite_friend invite_friend_success" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @elseif(session('user.id') && $total_invite < $invite_good->invite_need)
                                <a href='javascript:void(0)' data-url='javascript:void(0)' g_id="{{ $invite_good->id }}" class="invite_friend_grey" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @else
                            	<a href='/login_m' data-url='/login_m' g_id="{{ $invite_good->id }}" class="invite_friend invite_friend_login" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @endif
                        @else
                        	@if(session('user.id') && $invite_good->is_get == 1)
                            	<p style="font-size:28px;color:white">已领取</p>
                            	<a style="font-size:20px;color:white;margin-left:5px" href="/user_m/inviteprize">查看奖品></a>
                           	@endif
                        @endif
                    </li>
                @endforeach
            @else
                <div style="color:white;font-size:40px;margin-left:60px;">客官，你来晚了！今天的商品已全部领</div>
                <div style="color:white;font-size:40px;margin-left:230px;">完，明天早点来哦！</div>
            @endif
            </ul>
        </div>
        <div class="msg_introduce">关于"邀友福利区"规则<br/>
   01：邀请好友注册数量达到商品指定邀请人数后，可免费领取商品1次（每个新用户只有1次领取机会哦）；<br/>
   02：需通过天天免费页面邀请链接邀请好友，其他地方邀请的好友不在领奖范围内；<br/>
   03：收货地址的手机号码必须与注册手机号码一致，否则不发货（包括虚拟充值等）；<br/>
   04：禁止恶意刷邀请注册量，一旦发现立即封号处理；<br/>
   05：关于奖品发放时间:用户领取成功后，如果符合邀请活动规则，将在3个工作日内完成发货；<br/><br/>
 	  以下情况网站不给予发货（"抢999元现金红包"和"领取商品"活动）<br/>
   01：用户收货手机号码与注册手机号码不一致的；<br/>
   02：用户通过非法渠道邀请注册；（软件注册、购买手机号码注册等）<br/>
   03：用户领取商品后，网站工作人员会电话随机回访注册信息：如发现有电话为空号、电话呼叫限制、电话非用户本人注册等，网站有权做封号处理，并取消活动资格；<br/>
   </div>-->
        @if($flag != -1)
        <!--领取规则-  -->
             <div class="process_bar_alert hide">
                <div class="receive_rule_top">
                    <span class="receive_rule_title">中奖规则</span>
                 </div>

                 <div class="kld_content">
                    <p>还需邀请<num class="last_invite"></num>位小伙伴即可获得<a href='javascript:void(0)' data-url='javascript:void(0)' class="invite_goods_title"></a></p>
                    <div class="process_bar01_bg">
                        <i class="process_bar01" style="width:80%"></i>
                        <div class="join_percentage">1766/5888</div>
                    </div>

                   <p>1、点击右上角<img src="{{ $url_prefix }}img/share.jpg"/>分享给好友</p>
                   <p>2、保存二维码并分享给好友</p>
                 <div class="fenxiang">
<!--                    <img src="{{ $url_prefix }}img/clienty.png"/> -->
                        {!! QrCode::size(300)->generate($invite_url); !!}
                </div>
                    <div class="close_window"><a data-url="javascript:void();" id="close_btn">关闭窗口</a></div>
                 </div>
             </div>
        @endif
        <div class="shopping_together">一块抢</div>
        <div class="phone_show phone_show02">
            <ul>
                @foreach ($objects as $obj)
                    <li>
                        <div class="phone_show_div phone_show_div2">
                            <img src="{{$obj->thumb}}"/>
                            <div class="trans_bg">
                                <a href="/product_m/{{$obj->oid}}" cursor="hand">
                                    <div class="grey_bg">
                                        <p>{{$obj->title}}</p>
                                        <p>{{$obj->participate_person}}/{{$obj->total_person}}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <a href="/product_m/{{$obj->oid}}" data-url='/product_m/{{$obj->oid}}' class="invite_friend" ><span>立即抢</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="ttmf_bg_add"></div>
<div class="ttmf_bg_bottom">
    <div class="b-top"></div>
    <div class="b-middle"></div>
    <div class="b-bottom"></div>
</div>
</div></div>
<!--content end-->
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
<script>
var kl_flag = {{$flag}};
var is_first = {{$is_first_lottery}};
var one = 0;
var two = 0;
var three = 0;
var log = 0;
var _token = $("input[name='_token']").val();
var invite_url = '{{ $invite_url }}';

var reg_flag_freeday = {{$reg_flag_freeday}};

if(reg_flag_freeday == 1){
	$('.reg_content').show();
	$(".all_grey_bg").show();
}

window._bd_share_config = {
        common : {
            bdText : '哇塞，全部都好想要！',
            bdComment : '我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！',
            bdDesc : '我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！',
            bdUrl : invite_url.replace('&amp;', '&'),
            bdPic : "{{ url('foreground') }}/img/logo.png"
        },
        share : [{
            "bdSize" : 32
        }]
    }

with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];

$('#close_login').click(function(){
    $(".login_alert").hide();
    $(".all_grey_bg").hide();
})

$('.award_result a').click(function(){
    $(".all_grey_bg").hide();
    $(".award_result").hide();
});
</script>
<script type="text/javascript" src="{{ $url_prefix }}js/NumScroll.js"></script>
<script type="text/javascript" src="{{ $h5_prefix }}js/ttmf.js"></script>
<script type="text/javascript">
$(function(){
        var width = window.innerWidth;
        width = Math.min(window.innerWidth,document.body.scrollWidth);
        var left=(document.body.offsetWidth-width+4)/2;//网页可见区域宽-网页正文全文宽/2
        //alert(document.body.offsetWidth+":"+document.body.scrollWidth+":"+window.innerWidth+":"+width+":"+left+":"+$("body").width())
         $("body").css({"left":-left+"px"});
        // $(".msg_introduce").css({"left":-left+"px"});
             //alert(document.body.offsetWidth)  
         //设置ttmf_bg_bottom的高度
          $(".shopping_together").css({"top":900+$(".phone_show01").height()+"px"});
          $(".phone_show02").css({"top":1100+$(".phone_show01").height()+"px"});
          $(".b-middle").height(200+$(".phone_show01").height()+$(".phone_show02").height()+"px");
            $('.phone_show_div2').click(function(){
                var href = $(this).find('a').attr('href');
                window.location.href = href;
            })
            $("body").on("click",".close_window a",function(){
             $(".all_white_bg").hide();
             $(".all_grey_bg").hide();
             $(this).closest(".process_bar_alert").hide();
            })
          $("body").css({"visibility":"visible"});
           if(width<1235){
              $(".light_ct").css({"left":left+"px","width":width+"px"});
              var light_bg_left= ($(".light_bg").width()-$(".light_ct").width())/2;
              $(".light_bg").css({"left":-light_bg_left+"px" });
              $(".explode").css({"left":137-light_bg_left+"px" });
              $(".mui-bar-tab").css({"max-width":(screen.width)/.4});
         }
         var browser = {
            versions: function () {
                var u = navigator.userAgent, app = navigator.appVersion;
                return { //移动终端浏览器版本信息
                    ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
                    iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
                    iPad: u.indexOf('iPad') > -1 //是否iPad
                };
            }()
        };
        if (browser.versions.ios || browser.versions.iphone || browser.versions.ipad){
            myScroll = new iScroll('wrapper', { bounce: false,useTransform:false });
        }
         
});


</script>
@endsection


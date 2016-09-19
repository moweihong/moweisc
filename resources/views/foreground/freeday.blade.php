@extends('foreground.master')
@section('my_css')
     <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/ttmf.css">
@endsection

@section('content')
<style>
.bdsharebuttonbox .bds_qzone,.bdsharebuttonbox .bds_tsina,.bdsharebuttonbox .bds_weixin,.bdsharebuttonbox .bds_renren,.bdsharebuttonbox .bds_tqq{
    background-size:100% 100%;
    width:48px;
    height:47px;
    margin-left:5px;
}
.bdsharebuttonbox .bds_qzone{
    background: url({{ $url_prefix }}img/qq_ioc.png);
}
.bdsharebuttonbox .bds_tsina{
    width:46px;
    background: url({{ $url_prefix }}img/weibo.png);
}
.bdsharebuttonbox .bds_weixin{
    background: url({{ $url_prefix }}img/weichat.png);
}
.bdsharebuttonbox .bds_renren{
    background: url({{ $url_prefix }}img/happy_dou.png);
}
.bdsharebuttonbox .bds_tqq{
    background: url({{ $url_prefix }}img/moment.jpg);
}
body .money_not_enough {
height:315px
}
.invite_friend_grey:hover{
    color:white;
}
</style>
<div class="all_grey_bg">
</div>
<div class="all_white_bg">
</div>
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
        <div class="light_bg"></div>
        <div class="explode">
            <img src="{{ $url_prefix }}img/explode.png" alt=""/>
        </div>
        <div class="announce_rule"></div>
        <!--弹出层start-->
        <!--块乐豆不足-->
        <div class="money_not_enough hide">
            <span>很抱歉块乐豆不足<span id='close_moneyNotEnough' style='float:right;padding-right:15px;font-size:16px;cursor:pointer' >关闭</span></span>
            <div class="kld_content">
                <div class="show_money">
                    <p style="font-size: 15px;">参与一次需100块乐豆</p>
                    <span>块乐豆余额：<span class='not_enough'>{{$kl_bean}}</span></span>
                    <p>通过以下方式就可以获得块乐豆哦</p>
                </div>
                <ul>
                    <li>
                        <a href="#" id="invite_btn"><img src="{{ $url_prefix }}img/invite_btn.png"/></a>
                        <p>邀请好友最多可获得100块乐豆/人</p>
                    </li>
                    <li>
                        <a href="/category" id="buy_btn"><img src="{{ $url_prefix }}img/buy_btn.png"/></a>
                        <p>消费一元得一块乐豆</p>
                    </li>
                </ul>
            </div>
			
			<div class="fenxiang hide">
				<div class="share_content_desc">
                    <span style="margin-left: -241px">邀请有奖</span>
                    <p>邀请好友并消费最高可获<i>100块乐豆</i>加<i>5%现金奖励</i></p>
                </div>
                <div class="share_content_ioc bdsharebuttonbox" style="padding-left:15px;" data-tag="share_1">
                    <a class="bds_qzone"  data-cmd="qzone" href="#" style="background-position-y: -94px;"></a>
                    <a class="bds_tsina" data-cmd="tsina" style="background-position-y: -94px;"></a>
                    <a class="bds_weixin" data-cmd="weixin" style="background-position-y: -1598px;"></a>
                    <a class="bds_renren" data-cmd="renren"style="background-position-y: -187px;"></a>
                    <a class="bds_tqq" data-cmd="tqq" style="background-position-y: -240px;"></a>
                </div>
                <div class="dicuss_div">
                    <input type="text" class="share_content_input" value="我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！{{$invite_url}}" /><input type="button" value="复制" class="share_content_btn">
                </div>
			</div>
			
        </div>
        <!--揭晓规则-->
        <div class="announce_rule_alert">
            <span>今日超级幸运码：<i>{{ $lucky_num }}</i></span>
            <div class="close_btn"></div>
            <div class="announce_line"></div>
            <p>超级幸运码的产生：按照当天的日期，年月日取后三位</p>
            <p>例如：<i>今天是{{ date('Y', time()) }}年{{ date('n', time()) }}月{{ date('d', time()) }}日，今日超级幸运码为{{ $lucky_num }}.</i></p>
            <div class="announce_rule_content">
            参与规则 ：当你随机摇到的数字与当天的超级幸运码一样时即为中奖，中奖者获得999元现金红包，红包直接存入你的账户余额，不可提现。首次参与没有中奖，系统自动赠送5元红包。
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
            <!--领取成功-->
            <div class="receive_confirm_new">
            <div class="receive_confirm_top">奖品领取<i class="close_btn1">x</i></div>
            <div class="receive_confirm_content">
                <p class="out_of_goods_msg">客官，恭喜您领取成功</p>
                <p class="not_enough_money" style="font-size:12px">收货地址的手机号码需与注册手机<br />号码一致（包括虚拟充值等）</p>
                <div class="receive_success_btn2">好哒</div>
            </div>  
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
            <div class="forget_title"><a href="/forgetpwd" class="fl">忘记密码</a><a href="/register" class="fr">立即注册</a></div>
<!--             <div class="other_platform"><p>第三方登录</p> </div> -->
<!--             <div class="other_platform_ioc"> -->
<!--                 <a href="#"><img src="{{ $url_prefix }}img/qq_ioc.png"/></a> -->
<!--                 <a href="#"><img src="{{ $url_prefix }}img/weichat.png"/></a> -->
<!--               <a href="#"><img src="{{ $url_prefix }}img/weibo.png" style="margin-bottom: 1px;"/></a>  -->
<!--             </div> -->
        </div>

        <div class="award_result">
            <a href='javascript:void(0)' data-url='javascript:void(0)' id="continue_btn"></a>
            <a href='/user/bribery' data-url='/user/bribery' id="check_btn"></a>
        </div>
        <div class="reg_success">
        	<a></a>
        	<a></a>
        </div>
         <!--领取成功-->
                  <div class="receive_success">
                        <p class="congratulate_success">恭喜您领取成功</p>
                      <a href="/user/inviteprize" style="font-size: 20px;margin-left:30px;">请到个人中心-邀友获奖记录查看</a>
                    </div>
        <!--弹出层end-->
        <!--领取失败-->
                  <div class="receive_fail">
                        <p class="congratulate_success"></p>
                    </div>
        <!--弹出层end-->
        <div class="good_news">
            <div class="good_news_left"></div>
          <div class="good_news_center">
                          <ul>
                          @if(!empty($anouncement))
                          @foreach($anouncement as $log)
                          	  <li>喜报：恭喜用户{{$log['nickname']}}获得了{{$log['desc']}}</li>
                          @endforeach
                          @else
                          	  {{--<li>喜报：恭喜用户匿名获得了999元现金红包</li>--}}
                          @endif
                          </ul>
          </div>
            <div class="good_news_right"></div>
        </div>
     <!--   <div class="invite_friend_district">免费领<p class='activeTime'>活动时间：2016年6月2日止（商品未领完可以继续领取哦~）</p></div> -->
      <!--  <div class="phone_show">
        	@if(session('user.id'))
            	<div class="invite_friend_tip">邀友还有好礼免费领取哦！ 已邀友人数：{{$total_invite}}人，<a href="/user/inviteprize" data-url="/user/inviteprize" style="font-size:38px;color: white">查看我的奖品>></a></div>
            @else
            	<div class="invite_friend_tip">邀请好友参与即可免费领取!</div>
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
                        <p class="need_invite_count">需邀友人数 &nbsp;&nbsp;{{$invite_good->invite_need}}</p>
                        @if($is_get == 0)
                            @if(session('user.id') && $total_invite >= $invite_good->invite_need)
                                <a href='javascript:void(0)'  data-url='javascript:void(0)' g_id="{{ $invite_good->id }}" class="invite_friend invite_friend_success" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @elseif(session('user.id') && $total_invite < $invite_good->invite_need)
                                <a href='javascript:void(0)' data-url='javascript:void(0)' g_id="{{ $invite_good->id }}" class="invite_friend_grey" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @else
                            	<a href='javascript:void(0)' data-url='javascript:void(0)' g_id="{{ $invite_good->id }}" class="invite_friend invite_friend_login" ><span>{{ $invite_good->btn_name }}</span></a></li>
                            @endif
                        @else
                        	@if(session('user.id') && $invite_good->is_get == 1)
                            	<p style="font-size:28px;color:white">已领取</p>
                            	<a style="font-size:20px;color:white;margin-left:5px" href="/user/inviteprize">查看奖品></a>
                           	@endif
                        @endif
                    </li>
                @endforeach
            @else
            	<div style="color:white;font-size:40px;margin-left:80px;">客官，你来晚了！今天的商品已全部领完，明天早点来哦！</div>
            	<div style="color:white;font-size:40px;margin-left:350px;"></div>
            @endif
            </ul>
        </div>
          <div class="msg_introduce">关于"免费领"规则<br/>
   01：邀请好友注册数量达到商品指定邀请人数后，可免费领取商品1次（每个新用户只有1次领取机会哦）；<br/>
   02：需通过天天免费页面邀请链接邀请好友，其他地方邀请的好友不在领奖范围内；<br/>
   03：收货地址的手机号码必须与注册手机号码一致，否则不发货（包括虚拟充值等）；<br/>
   04：禁止恶意刷邀请注册量，一旦发现立即封号处理；<br/>
   05：关于奖品发放时间:用户领取成功后，如果符合邀请活动规则，将在3个工作日内完成发货；<br/><br/>
 	  以下情况网站不给予发货（"抢999元现金红包"和"领取商品"活动）<br/>
   01：用户收货手机号码与注册手机号码不一致的；<br/>
   02：用户通过非法渠道邀请注册；（软件注册、购买手机号码注册等）<br/>
   03：用户领取商品后，网站工作人员会电话随机回访注册信息：如发现有电话为空号、电话呼叫限制、电话非用户本人注册等，网站有权做封号处理，并取消活动资格；<br/>
   </div>
        @if($flag != -1)
        <div class="process_bar_alert hide">
            <div>
                <p>中奖规则：</p>
                <p>还需邀请<num class="last_invite"></num>位小伙伴即可获得<a href='javascript:void(0)' class="invite_goods_title"></a></p>
                <div class="process_bar01_bg">
                    <i class="process_bar01" style="width:100%"></i>
                    <div class="join_percentage"><label class="join_label"></label></div>
                </div>
                <div class="share_content_desc">
                    <span style="margin-left: -241px">邀请有奖</span>
                    <p>邀请好友并消费最高可获<i>100块乐豆</i>加<i>5%现金奖励</i></p>
                </div>
                <div class="share_content_ioc bdsharebuttonbox" style="padding-left:15px;" data-tag="share_1">
                    <a class="bds_qzone"  data-cmd="qzone" href="#" style="background-position-y: -94px;"></a>
                    <a class="bds_tsina" data-cmd="tsina" style="background-position-y: -94px;"></a>
                    <a class="bds_weixin" data-cmd="weixin" style="background-position-y: -1598px;"></a>
                    <a class="bds_renren" data-cmd="renren"style="background-position-y: -187px;"></a>
                    <a class="bds_tqq" data-cmd="tqq" style="background-position-y: -240px;"></a>
                </div>
                <div class="dicuss_div">
                    <input type="text" class="share_content_input" value="亲，三生有幸与你相识，送你一份礼物表示一下，快来拿吧！{{$invite_url}}" /><input type="button" value="复制" class="share_content_btn">
                </div>
            </div>
        </div>
        @endif
        
      -->
        
      <!--  <div class="shopping_together"></div>-->
        <div class="phone_show phone_show02">
            <ul>
                @foreach ($objects as $obj)
                    <li>
                        <div class="phone_show_div">
                            <img src="{{$obj->thumb}}"/>
                            <div class="trans_bg">
                                <a href="/product/{{$obj->oid}}" cursor="hand">
                                    <div class="grey_bg">
                                        <p>{{$obj->title}}</p>
                                        <p>{{$obj->participate_person}}/{{$obj->total_person}}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        {{--<i class="process_bar"><p style='width:{{$obj->rate}}%'></p></i><i class="process_show"><p class="fl">揭晓进度</p><p class="fr">{{$obj->rate}}%</p></i>--}}
                        <a href="/product/{{$obj->oid}}" data-url='/product/{{$obj->oid}}' class="invite_friend" ><span>立即抢</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
		
    </div>
</div>
<div class="ttmf_bg_bottom"></div>
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
	$('.reg_success').show();
	$(".all_grey_bg").show();
}

window._bd_share_config = {
		common : {
			bdText : '哇塞，全部都好想要！',
			bdComment : '我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！',
			bdDesc : '我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！',
			bdUrl : invite_url.replace('&amp;', '&'),
			bdPic : '{{$url_prefix}}img/111111.png'
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
$(".phone_show_div").mouseover(function () {
    $(this).children("div").css({"visibility": "visible"});
});
$(".phone_show_div").mouseout(function () {
    $(this).children("div").css({"visibility": "hidden"});
});
</script>
<script type="text/javascript" src="{{ $url_prefix }}js/NumScroll.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/ttmf.js"></script>
@endsection


@extends('foreground.mobilehead')
@section('title', '个人中心')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css?v={{config('global.version')}}">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css?v={{config('global.version')}}">
   <style>
		.mui-bar-nav{display:none}
		html,body{background:#ECECEC;}
		.uc_headimg{width:1rem;height:1rem;position:absolute;top:0.82rem;left:0.08rem}
		.uch{border:0.01rem solid #DE2D4F}
		.uc_info{width:65%;clear:both;float:right;margin-top:0.3rem}
		.uc_info_a{color:#fff;font-size:0.14rem;font-weight:600}
		.uc_info_b{color:#fff;font-weight:normal}
		.uc_recharge_bt{
			background:#fff;height:0.5rem;border:none;width:100%;clear:both;margin-top:1rem;
		}
		.uc_recharge{height:0.5rem;width:65%;float:right }
		.uc_recharge1{float:left;margin-top:0.1rem}
		.uc_recharge2{
			float:right;background:#DE2D4F;color:#fff;width:0.8rem;
			text-align:center;border-radius:4px;padding:0.02rem;font-size:0.14rem;margin-top:0.1rem
		}
		.uc_recharge1 p{font-size:0.12rem;color:#333;line-height:0.18rem;}
		.ucuc{margin-right:0.12rem;margin-top:0.02rem}
		.msg-ct img{float: left;width: 26px;height: 26px;padding-right: 0;}
		.msg-ct{float: right; padding-right: 8px; margin-right: 10px;}
		.mui-bar-tab{font-size:17px}
	 
   </style>
@endsection

@section('content')
   <div> 
		<div class="uc_head" style='margin-bottom:0.07rem; '>
			<div class="uc_setting">
				<img data-url="/user_m/setting" src="{{$h5_prefix}}images/set.png" alt="">
			<div class="msg-ct">
				<img data-url="/sysmessage" src="{{$h5_prefix}}images/msg_ioc.png"/>@if($allMsg > 0)<div class="bounsNotice">{{ $allMsg }}</div>@endif 
			</div>
			</div>
			<div class="uc_info" >
				<div class="uc_info_a">{{$nickname}}</div>
				<div class="uc_info_b">块乐豆 : {{$kl_been}}</div>
			</div>
			<div class="uc_headimg"><div class='uch' data-url="/user_m/userinfo"><img src="{{ $img or $h5_prefix.'images/feedb-qqlogo.jpg'}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg'" alt=""></div></div>
			<div class="uc_recharge_bt">
				<div class="uc_recharge">
					<div class="uc_recharge1">
                        <p>余额: {{ $money }}元</p>
                        <p>我的佣金: {{ $commission }}</p>
					</div>
                    @if(session('is_ios') != 1)
					    <div class='ucuc'><div class="uc_recharge2" data-url="/user_m/recharge_now">充 值</div></div>
                    @endif
				</div>
			</div>
		</div>
		<div class="dk">
			<div class="dk1" onclick="myalert('请关注公众号【ts1kg2016】')">
				<div class="dk11">
					<img src="{{$h5_prefix}}images/wx.png" alt="">
                    <p >一键关注微信</p>
				</div>
			</div>
			<div class="dk2" onclick="location.href='/makemoney_m_new'">
				<div class="dk11">
					<img src="{{$h5_prefix}}images/yyzq.png" alt="">
                    <p >邀友赚钱</p>
				</div>
			</div>
		</div>
		
		<div class="uclist uclist1" data-url="/user_m/buy">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci1.png" alt=""></div>
            <div class="uclistco">我的众筹记录</div>
		</div>
		{{--<div class="uclist" data-url="/user_m/buy">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci1.png" alt=""></div>
            <div class="uclistco">未支付订单</div>
		</div>--}}
		<div class="uclist" data-url="/user_m/prize">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci2.png" alt=""></div>
            <div class="uclistco"><div style='float:left'>获得记录</div>@if($prizeTotal)<div class="bounsNotice">{{$prizeTotal}}</div>@endif @if($noshow)<span>{{$noshow}}个可晒单</span>@endif</div>
		</div>
		<div class="uclist" data-url="/user_m/account">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci3.png" alt=""></div>
			<div class="uclistco">账户明细</div>
		</div>
		<div class="uclist" data-url="/user_m/bribery">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci4.png" alt=""></div>
			<div class="uclistco"><div style='float:left'>红包</div>@if($redtotal)<div class="bounsNotice">{{$redtotal}}</div>@endif</div>
		</div>
		<div class="uclist" data-url="/user_m/mycommission">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci5.png" alt=""></div>
			<div class="uclistco">我的佣金</div>
		</div>
		<div class="uclist" data-url="/user_m/show">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci6.png" alt=""></div>
			<div class="uclistco">我的晒单</div>
		</div>
		<div class="uclist" data-url="/user_m/score">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci7.png" alt=""></div>
			<div class="uclistco">块乐豆<!--<span>&nbsp;&nbsp;未签到&nbsp;&nbsp;</span>!--></div>
		</div>
		<div class="uclist"  data-url="/user_m/addresslist">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/uci8.png" alt=""></div>
			<div class="uclistco">收货地址</div>
		</div>
		<div class="uclist" data-url="/user_m/invite">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/icon.png" alt=""></div>
			<div class="uclistco">邀友记录</div>
		</div>
		<!--<div class="uclist" onclick="NTKF.im_openInPageChat('kf_9372_1470212593294')">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/kf2.png" alt=""></div>
			<div class="uclistco">在线客服</div>
		</div>-->
		<!--<div class="uclist" data-url="/user_m/inviteprize">
			<div class="uclisticon"><img src="{{$h5_prefix}}images/icon.png" alt=""></div>
			<div class="uclistco">邀友获奖记录</div>
		</div>-->
	   <div style="height: 68px"></div>
   </div>
<!--小能客服咨询入口START-->
<script type="text/javascript" src="{{$url_prefix}}js/xiaoneng.js" charset="utf-8"></script>
<script type="text/javascript" src="https://dl.ntalker.com/js/xn6/ntkfstat.js?siteid=kf_9372" charset="utf-8"></script>
<!--小能客服咨询入口END-->
@endsection

@section('my_js')
   <script>
     function weixin()
     {
         
     }
   </script>
@endsection



 
@extends('foreground.master')
@section('my_css')
    <style>
        body{font-family: "微软雅黑";}
        .new_ttmf_bg{width: 100%;height: 1302px;background: url({{$url_prefix}}img/new_ttmf_bg.jpg) no-repeat center; }
        .new_ttmf_bg_middle{width: 100%;min-height: 600px;background: #ffd203;padding-bottom: 47px;    padding-top: 15px;}
        .new_ttmf_bg_bottom{width: 100%;min-height: 700px;background: #fe274a;    padding-top: 40px; position: relative}
        .new_ttmf_bg_bottom .new-rotary-tit{width:224px; height: 110px; position: absolute; left:50%; top:-20px; margin-left:-112px; background: url({{$h5_prefix}}images/dayfree/ykqh2.png) no-repeat}
        .main_content{width: 1200px;margin: 0 auto;position: relative;}
        .new_ttmf_bg .main_content{height: 1302px;}
        .invite_count_bg{width:750px;height:109px;background:url({{$url_prefix}}img/ttmf_count_bg.png) no-repeat; margin: 0 auto;  padding-top: 20px;padding-left: 30px;}
        .invite_count_bg img{ width: 81px; height:81px;   vertical-align: middle;margin-right: 5px;float: left;    border-radius: 50%;}
        .invite_count_bg a{font-size: 14px;color: #c4173f;text-decoration: underline;float: left;     line-height: 90px;}
        .zhizhen{width:235px;height:270px;background:url({{$url_prefix}}img/ttmf_clickme.png) no-repeat;;position: absolute;left: 482.5px; bottom: 271px;cursor: pointer;}
        .zhuan_pan{width:700px;height:700px;background:url({{$url_prefix}}img/ttmf_pan.png) no-repeat;;position: absolute;left: 250px; bottom: 43px;}
        .counts_ct{float: right;    padding-top: 27px;    padding-right: 130px;}
        .counts_ct div{display: inline-block;*display: inline;*zoom: 1;font-size: 14px;color: white;padding: 10px; background: #c4173f;margin-right: 20px;border-radius: 5px;}
        .new_invite_friend_district_ct{width: 960px;height: 350px;margin: 0 auto;position: relative;}
        .new_invite_friend_district{width: 960px;height: 102px;display: block;position: absolute;top:120px;cursor: pointer;background: url({{$url_prefix}}img/invite_red_bg.png) no-repeat;font-size: 53px;color: white;text-align: center;line-height: 102px;}
        .new_invite_friend_district:hover{color:#fff}
        .invite_finger{width: 144px;height: 129px;display: block;position: absolute;top:2px; left: 480px;background: url({{$url_prefix}}img/invite_finger.png) no-repeat;z-index: 1;}
        .new_rule{width: 130px;height: 120px;display: block;position: absolute;right: -9px; bottom: 95px;cursor: pointer;}
        .won_prize_members{    width: 1060px; margin: 0 auto;padding-top: 50px;}
        .won_prize_members h1{width: 379px;height: 55px; line-height: 55px;font-size: 24px; color: white;background: #c4173f; text-align: center; margin: 0 auto; border-radius: 4px 4px 0px 0px; -webkit-border-radius: 4px 4px 0px 0px}
        .won_prize_bg{width: 1060px;background: #c4173f;border-radius: 5px;padding-bottom: 30px;padding-top: 6px; box-shadow: 3px 3px 3px #cba806; }
        .won_prize_bg ul{width: 1033px;height: 52px;    margin: 0 auto;  }
        .won_prize_bg ul li{width: 25%;display: inline-block;*display: inline;*zoom: 1;text-align: center;font-size: 20px;line-height: 48px;color: white;    overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
        .hr{width: 1033px;height:1px;margin: 0 auto;background:  url({{$url_prefix}}img/border_line.png) repeat;}
        .won_prize_bg .item_01{font-size: 22px;line-height: 44.07px;margin-bottom: 0;}
        .won_prize_bg .item_01 li{color: #ffd203;}
        .item_02{background: #ee363f;}
        .item_03{background: #6fade9;}
        .item_04{background: #69d58d;}
        .item_02,.item_03,.item_04{ width: 1033px; height: 52px; margin: 10px auto;    line-height: 52px;overflow: hidden;}
        .way01{margin-right: 109px;}
        .way01,.way02{width: 421px;height: 314px; background: white; border:1px solid #ffd203;display: inline-block;*display: inline;*zoom: 1;color: #333333;padding-bottom: 67px;    vertical-align: top;}
        .way01 h2,.way02 h2{font-size: 20px;font-weight: bold;    padding: 20px 10px;}
        .way01 p,.way02 p{font-size: 16px;line-height: 30px;    padding: 0 19px;    margin-bottom: 8px;}
        .won_prize_bg2{width: 960px;padding: 50px;}
        .tip_red{color: #C4173F;}

        .qiang_bg{width: 1060px;height: 269px; }
        .qiang_bg01{width: 1060px;height: 180px;}/* background: url(img/ttmf0010.png) no-repeat;*/
        .goods_bg_ct{width: 404px;height: 398px;     float: left;   position: relative;    margin-top: -194px;margin: -194px 75px 0 57px;}
        .goods_bg{width: 404px;height: 343px; background: url({{$url_prefix}}img/ttmf004.png) no-repeat;    text-align: center;  padding-top: 62px;}
        .goods_bg img{width: 258px;}
        .goods_btn{width: 402px;height: 85px; position:absolute; top:350px; left:0px; z-index: 88; background: url({{$url_prefix}}img/ttmf003.png) no-repeat;  }
        .goods_btn a{font-size: 20px;color: #fe274a;line-height: 24px;display: inline-block;*display: inline;*zoom: 1;width: 65px; height: 85px;float: right;    padding-top: 16px; padding-right: 10px;font-weight: bold;}
        .goods_btn span:first-child{font-size: 22px; line-height: 80px; color: #761e0a;display: inline-block;*display: inline;*zoom: 1;width: 316px; height: 85px; text-align: center;float: left;}
        .goods_desc{width: 100%;height: 177px; background: #000000; opacity: .7;*filter:alpha(opacity=70);   font-size: 16px;display: none;}
        .goods_desc_ct{width: 382px;position: absolute;top: 8px; left: 11px; padding-top: 208px;  border-radius: 50%; overflow: hidden;}
        .qiang_ct{    height: 618px;    padding-left: 70px;}
        .award_result{width: 838px;height: 700px;background: url({{$url_prefix}}img/zhongjiang.png) no-repeat;position: fixed;    z-index: 1;    margin: 0 auto;top: 50%;left: 50%;margin-left: -419px;margin-top: -350px;}
        .congratulate_content{font-size: 23px; line-height: 33px; font-weight: bold;width: 330px;height: 80px; text-align: center;   margin: 0 auto;    margin-bottom: 7px;}
        .award_result a{font-size: 27.75px;color: white;display: block; cursor: pointer;}
        .invite_btn a{width:228px;height: 62px;background: url({{$url_prefix}}img/btn_bg.png) no-repeat;float: right;color:#666666;line-height: 62px;}
        .invite_btn a:first-child{float: left;color: #ff0000;margin-left: 10px;}
        .award_result_inner{position: absolute;       bottom: -13px;  left: 100px;    text-align: center;}
        .continue_btn{width: 226px; height: 65px;    text-align: center;line-height: 65px;margin: 0 auto;}
        .invite_btn{    width: 635px; height: 62px;    padding-top: 10px;}
        .goods_desc p{width: 265px;    color: white;    margin: 0 auto; padding-top: 40px;max-height: 90px;overflow: hidden;    text-indent: 24px;}
        .login_alert ,.invite_friend_alert,.activity_rule,.kld_not_enought{ width: 396px; height: 410px; border: 1px solid #E2E2E4; position: fixed; margin-left: -198px;  margin-top: -150px;
            left: 50%; top: 50%; background: white; z-index: 2; border-radius: 8px;  text-align: center;overflow: hidden;  /* display: none; */}
        .invite_friend_alert{height: 180px;margin-top: -85px;}
        .login_alert span ,.invite_friend_alert span,.activity_rule span,.kld_not_enought .alert_header span{line-height: 38px;   font-size: 18px;}
        .login_line {  border-bottom: 1px solid #E2E2E4; width: 100%;  }
        .login_alert .login_line{margin-bottom: 40px;}
        .login_account { width: 302px;height: 49px;  border: 1px solid #E2E2E4;  border-top: 2px solid #A3A6AB;
            margin: 20px auto;  border-radius: 5%; -webkit-border-radius: 5%;  -o-border-radius: 5%; -moz-border-radius: 5%;}
        .login_ioc_div {
            width: 38px;
            height: 26px;
            display: inline-block;
            float: left;
            margin-top: 11px;
        }
        .vertical_line {
            height: 26px;
            border: 1px solid #E2E2E4;
            display: inline-block;
        }
        .login_account input {
            width: 264px;
            height: 49px;
            border: none;
            float: right;
            line-height: 49px;
        }
        .login_btn {
            width: 302px;
            height: 49px;
            background: #e63955;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 3%;
            -webkit-border-radius: 3%;
            -o-border-radius: 3%;
            -moz-border-radius: 3%;
        }
        .forget_title {
            width: 302px;
            height: 15px;
            margin: 10px auto;
            margin-bottom: 20px;
        }
        .close_login{
            color: #999;
            float: right;
            cursor: pointer;
            margin-right: 10px;
            font-weight: normal;
            font-size: 20px;
        }
        .other_platform_ioc a{
            margin: 0 21px;
        }
        .other_platform_ioc{    padding-top: 17px;}
        .other_platform{width: 300px;height: 11px;background: url({{$url_prefix}}img/other_plateform.png) no-repeat;     margin: 0 auto;  }
        .alert_header{background: #FFFBFB;height: 40px;}
        .invite_friend_alert .alert_header span{float: right;}
        .invite_friend_alert .alert_header span:first-child,.activity_rule  .alert_header span:first-child,.kld_not_enought .alert_header span:first-child{float: left;padding-left: 20px;}
        .invite_friend_alert {font-size: 14px;color:#666666}
        .invite_friend_ct{width: 320px;margin: 0 auto;}
        .invite_friend_ct div:first-child{    line-height: 30px; text-align: left;}
        .invite_friend_ct div a{display: block;float: right;width: 51px;margin-top: 15px;margin-right: 23px}
        .invite_friend_ct div a:first-child{margin-left: 0;}
        .activity_rule{height: 500px;margin-top: -250px;z-index: 10;}
        .rule{text-align: left; padding: 22px;}
        .rule_item{margin-bottom: 30px;}
        .rule h2{font-size: 14px; color: #333333;font-weight: bold;}
        .rule p{font-size: 12px;color: #666666;line-height: 20px;}
        .rule em{color: #E63955;}
        .kld_not_enought{height: 220px;margin-top: -110px;}
        .kld_content p{font-size: 30px; color: #e63955;padding: 35px 0;}
        .kld_content input{width:126px;height40px;line-height:40px;font-size: 18px; color: #e63955; background: white; border: 2px solid #e63955;border-radius:5px ;}
        .kld_content input:first-child{color: white; background:  #e63955;margin-right: 34px;}
        .black_bg{background: #000000; opacity: .7; filter: alpha(opacity=70);padding: 22px 12px;position: fixed;top: 50%;left: 50%;width: 360px;margin-left: -200px;}
        .black_bg{font-size: 16px;line-height: 20px;color: white;}
        .all_grey_bg{width: 100%;height: 100%; background: black; opacity: .4;filter: alpha(opacity=40);position: fixed;z-index: 10;}
        .alert{z-index: 12;}
        .login_after{width: 185px;float: left;    font-size: 14px; color: #c4173f;    padding-top: 26px;font-weight: bold;}
        .login_after i{    display: inline-block; *display:inline;*zoom:1;background: #c4173f;color: white; margin: 0 5px;padding: 2px 3px; border-radius: 5px;}
		
		
		.comm-tip-box{width: 380px;height:auto;padding-bottom:26px;position: fixed;top: 50%;left: 50%;margin-top:-190px;margin-left: -190px;background: white;border-radius: 5px;z-index: 101;display: none;}
		.tip-msg,.login-way{padding: 30px 0;text-align: center;}
		.tip-msg p{font-size: 30px;color: #E63955;}
		.tip-btn-group{text-align: center;}
		.tip-btn-group input{font-size: 18px;background: white;border: 2px solid #E63955; border-radius: 5px;width: 120px;height:36px;line-height:36px;text-align: center;color: #E63955;}
		.tip-btn-group input:first-child{background: #E63955; color: white;margin-right: 40px;}
		.login-tip{font-size: 12px;color: #999999;text-align: center;margin-bottom: 24px;}
		.tip-btn {text-align: center;}
		.tip-btn input{width: 65%;background: #E63955;height: 40px;text-align: center;color: white;font-size: 18px;line-height: 40px;border: none;}
		.login-way div{height: 60px;display: inline-block;*display: inline;*zoom: 1;margin: 0 auto;}
		.login-way a{width: 60px;height: 60px;font-size: 12px;color: #666666;margin: 0 40px 0 20px;float: left;text-align: center;display: block;}
		.login-way a:first-child{margin: 0 40px 0 40px;}
		.login-way i{width: 60px;height: 60px;display: block;}
		.weixin-login{background: url({{$url_prefix}}img/other_platform003.png) no-repeat;background-size: 100%;}
		.qq-login{background: url({{$url_prefix}}img/other_platform001.png) no-repeat;background-size: 100%;}
		.account-login{background: url({{$url_prefix}}img/prizem-ico-account.png) no-repeat;background-size: 100%;}
		.sina-login{background: url({{$url_prefix}}img/prizem-ico-sina.png) no-repeat;background-size: 100%;}
		.zone-login{background: url({{$url_prefix}}img/prizem-ico-qzone.png) no-repeat;background-size: 100%;}
		.register-tip{width: 90%;border-top: 1px dashed #DEDEDE;padding-top: 26px;margin: 0 auto;font-size: 14px; color: #666666;text-align: center;}
		.register-tip input{font-size: 12px;color: white;width: 60px;height: 25px;border: none;background: #E63955;border-radius: 5px;text-align: center;line-height: 25px;padding: 0;vertical-align: middle;margin-right: .02rem;}
		.login-area a{width: 50px;height:  50px;margin: 0 13px;display: block;float: left;cursor: pointer;}
		.login-area i{width: 50px;height: 50px;display: block;}
		.login-area div{height: 50px;    display: inline-block;}
		#make-money-free h2,#chou-jiang-rule h2{font-size: 14px}
		#make-money-free p,#chou-jiang-rule p{line-height: 20px;}
		#chou-jiang-rule{height: 500px;margin-top: 50px;}
		#make-money-free{height:386px;margin-top: -193px;}
		.comm-tip-box .popbox-h2{height:26px; line-height: 26px; border-bottom: 1px solid #dedede; font-size: 16px; text-indent: 10px; -webkit-text-size-adjust:none; position: relative;  border-top-left-radius: 5px; border-top-right-radius: 5px; background: linear-gradient(#fff,#fff8f8);}
		.h2-textcenter{text-align: center; text-indent: 0px;}
		.close-x{font-size: 18px;float: right;    margin-right: 4px;cursor: pointer;}
		.close-x:before{content:'x';}
		.login-area a{width: 50px;}
		.rules-h2{color: black;font-size: 15px;    margin-top: 20px;}
		.rules-main{width: 90%;margin: 0 auto;    padding-bottom: 20px;}
    </style>
@endsection
<div class="all_grey_bg hide"></div>		
@section('content')
<div class="new_ttmf_bg">
	<div class="main_content">
		<div class="zhuan_pan_bg">
			<div class="zhuan_pan"></div>
			<div class="zhizhen"></div>
		</div>

		<a class="new_rule"></a>
		<!--弹出层 -->
		<!--中奖结果-->	
		{{--<div class="award_result alert hide">
			<div class="award_result_inner">
				<div class="congratulate_content"  style="color:white">
					<p style="margin-left:25px;">恭喜您获得</p>
					<p class="js_award_name" style="margin-left:25px;"></p>
				</div>
				<a class="continue_btn" style="margin-left:203px;">继续参与</a>
				<div class="invite_btn">
					<a class="invite_friend_btn2">邀友免费玩</a>
					<a href="/user/bribery">查看红包</a>
				</div>
			</div>
		</div>  --}}
		<!--登录框-->	
		<div class="login_alert alert hide">
           <div class="alert_header"> 
           	<span>一块购账号登录</span>
            <span class="close_login">X</span>
            </div>
            <div class="login_line"></div>
             <div class="login_account">
                 <div class="login_ioc_div">
                    <i><img src="/foreground/img/user_ioc.png" alt=""></i>
                 <div class="vertical_line"></div>
                 </div>
                 <input type="text" placeholder="请输入手机号" name="username">
             </div>
            <div class="login_account">
                <div class="login_ioc_div">
                    <i><img src="/foreground/img/password_ioc.png" alt=""></i>
                    <div class="vertical_line"></div>
                </div>
                <input type="password" placeholder="请输入密码" name="password">
            </div>
            <input type="button" value="立即登录" class="login_btn">
            <div class="forget_title"><a href="/forgetpwd" class="fl">忘记密码</a><a href="/register" class="fr">立即注册</a></div>
            <div class="other_platform"> </div>
           <div class="other_platform_ioc">
                <a href="{{$qq_login_url}}"><img src="/foreground/img/other_platform001.png"/></a>
                {{--<a href="#"><img src="/foreground/img/other_platform002.png"/></a>--}}
              <a href="{{$wx_login_url}}"><img src="/foreground/img/other_platform003.png" /></a>
           </div> 
        </div>
        
        <!--邀友免费玩-->
        <div class="invite_friend_alert alert hide">
           <div class="alert_header"> 
           	<span>邀友免费玩</span>
            <span class="close_login">X</span>
            </div>
            <div class="login_line"></div>
            <div class="invite_friend_ct">
	            <div>邀请每满3位好友参与活动即可免费再抽一次，免费 次数可累积，赶快邀友抢百万豪礼吧！</div>
	            {{--<div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">--}}
	               {{--<a href="#" class="bds_qzone"  data-cmd="qzone"><img src="/foreground/img/other_platform001.png"/></a>--}}
	               {{--<a href="#"><img src="/foreground/img/other_platform002.png"/></a>--}}
	               {{--<a href="#"><img src="/foreground/img/other_platform003.png" /></a>--}}
	               {{--<a href="#"><img src="/foreground/img/other_platform004.png" /></a>--}}
	               {{--<a href="#"><img src="/foreground/img/other_platform005.png" /></a>--}}
	            {{--</div>--}}
                <div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">
                    <a class="bds_qzone"  data-cmd="qzone"  style="background: url('/foreground/img/other_platform006.png') no-repeat; height: 50px;display: block"></a>
                    {{--<a class="bds_renren" data-cmd="renren"  style="background: url('/foreground/img/other_platform004.png') no-repeat; height: 50px;display: block"></a>--}}
                    <a class="bds_weixin" data-cmd="weixin"  style="background: url('/foreground/img/other_platform003.png') no-repeat; height: 50px;display: block"></a>
                    <a class="bds_tsina" data-cmd="tsina" style="background: url('/foreground/img/other_platform002.png') no-repeat; height: 50px;display: block"></a>
                    <a class="bds_sqq" data-cmd="sqq"  style="background: url('/foreground/img/other_platform001.png') no-repeat; height: 50px;display: block"></a>
                </div>
            </div>
        </div>   
        
        <!--邀友免费玩--> 	
        <div class="activity_rule alert hide">
        	<div class="alert_header"> 
           	<span>抽奖规则</span>
            <span class="close_login">X</span>
            </div>
            <div class="rule">
            	<div class="rule_item">
            		<h2>活动时间:</h2>
            		<p>即日起生效，具体结束时间另行通知。 </p>
            	</div>
            	<div class="rule_item">
            		<h2>抽奖规则:</h2>
            		<p>1、新注册用户可免费获得1次抽奖机会；</p>
					<p>2、无免费抽奖则需要每次消耗10块乐豆抽奖1次；</p>
					<p>3、无登录状态下抽中的奖品视为无效，需要重新登录抽奖。</p>
            	</div>
            	<div class="rule_item">
            		<h2>奖品发放规则：</h2>
            		<p>1、实物奖品我司客服人员会在24小时内电话联系确认收货地址；</p>
					<p>2、红包奖励系统自动发放至账户，可在个人中心“我的红包”中查看并使用。</p>
            	</div>

            	<div class="rule_item">
            		<h2>注意事项:</h2>
            		<p>1、凡利用一切非法及不正当手段获得到的块乐豆及奖品，特速一块购将不会承认中奖事实，并回收块乐豆，情节严重导致平台损失，我们将会依法追究其法律责任；</p>
					<p>2、该活动在法律允许范围内享有最终解释权。</p>
            	</div>
            </div>
        </div>
        
         <!--邀友免费玩-->
        <div class="kld_not_enought alert hide">
           <div class="alert_header"> 
           	<span>块乐豆不足</span>
            <span class="close_login">X</span>
            </div>
            <div class="kld_content">
            	<p>块乐豆不足</p>
            	<div>
            		<input type="button" value="邀友免费玩" class="invite_friend_btn"/>
            		<input type="button" value="抢购赚乐豆" onclick="window.location.href='/index'"/>
            	</div>
            </div>
        </div> 
        
        <div class="black_bg alert hide klbean_tips">
        	每次抽奖需消耗10块乐豆，邀请每满3人参与活动即可免费再抽一次，免费次数可累积但每天仅限使用一次，详细规则请仔细查阅！
        </div>   
        
        
     <div class="comm-tip-box popdiv" id="award-result">
		<h2 class="popbox-h2"><i class="close-x js-closex"></i></h2>
		<div class="tip-msg">
			<p>恭喜您抽到</p>
			<p class="js_award_name"></p>
		</div>
		<div class="tip-btn-group"><input type="button" value="立即使用" onclick="window.location.href='/index'"/><input type="button" value="继续抽奖" class="continue_btn"/></div>
	</div>
	
	<div class="comm-tip-box popdiv" id="award-result1">
		<h2 class="popbox-h2"><i class="close-x js-closex"></i></h2>
		<div class="tip-msg">
			<p>恭喜您抽到</p>
			<p class="js_award_name_nologin"></p>
		</div>
		<p class="login-tip">
			提示：根据抽奖规则，您未登录视为无效抽奖，请登录后重新抽奖！
		</p>
		<div class="tip-btn"><input type="button" value="立即登录" class="login-now"/></div>
	</div>
	
	<div class="comm-tip-box popdiv" id="login-tip">
		<h2 class="popbox-h2">登录<i class="close-x js-closex"></i></h2>
		<div class="login-way">
			<div>
				<a href="{{$wx_login_url}}"><i class="weixin-login" style="cursor:hand"></i>微信登录</a>
				<a href="{{$qq_login_url}}"><i class="qq-login" style="cursor:hand"></i>QQ登录</a>
				<a href="/login"><i class="account-login" style="cursor:hand"></i>账号登录</a>
			</div> 
		</div>
	
		<div class="register-tip">
			不想使用第三方登录：<input type="button" value="免费注册" onclick="window.location.href='/register'"/>一块购账号
		</div>
	</div>

	<div class="comm-tip-box popbox activity-rules popdiv" id="make-money-free">
		<h2 class="popbox-h2">免费赚<i class="close-x js-closex"></i></h2>
		<div class="rules-main">
			<h2 class="rules-h2">赚抽奖机会：</h2>
			<p class="rules-des margin-bottom10">凡在活动期间，每邀请3位新好友参加幸运大转盘，即刻获得1次免费抽奖的机会；</p>
			<h2 class="rules-h2">赚钱：</h2>
			<p class="rules-des margin-bottom10">
				您邀请的好友只要在平台产生了现金消费行为，每一笔交易，您最高可获得3.5%的佣金；
			</p>
			<h2 class="rules-h2">赚块乐豆：</h2>
			<p class="rules-des margin-bottom10">
				<span>1、您邀请的好友首笔消费，您可获得100个块乐豆；</span><br />
				<span>2、您自己每消费1元钱，可获得1个块乐豆；</span><br />
				<span>3、100块乐豆=1元</span>
			</p>
		</div>
		<div class="login-area register-tip">
			<div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">
					 <a class="bds_qzone"  data-cmd="qzone"  style="background: url('/foreground/img/other_platform006.png') no-repeat;height: 50px;display: block"></a>
                    {{--<a class="bds_renren" data-cmd="renren"  style="background: url('/foreground/img/other_platform004.png') no-repeat; height: 50px;display: block"></a>--}}
                    <a class="bds_weixin" data-cmd="weixin"  style="background: url('/foreground/img/other_platform003.png') no-repeat; height: 50px;display: block"></a>
                    <a class="bds_tsina" data-cmd="tsina" style="background: url('/foreground/img/other_platform002.png') no-repeat; height: 50px;display: block"></a>
                    <a class="bds_sqq" data-cmd="sqq"  style="background: url('/foreground/img/other_platform001.png') no-repeat; height: 50px;display: block"></a>
			</div> 
		</div>
	</div>
	
        
	</div>
</div>
<div class="new_ttmf_bg_middle">
    <div class="invite_count_bg">
        @if(empty(session('user.id')))
            <img src="{{$url_prefix }}img/ttmf006.png" />
            <a href="javascript:void(0);" id="not_login">亲，请登录!</a>
        @else
            <img src="{{$member->user_photo}}" />
            <div class="login_after">
                <p>昵称：{{$member->nickname}}</p>
                <p>块乐豆：<span class="my_klbean">{{$member->kl_bean}}</span>个</p>
                <!--  <p>共获得<i><span  class="total_free_times">{{$total_free_times}}</span></i>次免费机会</p>-->
            </div>
        @endif
        <div class="counts_ct">
            <div class="choujiang_count">您剩余<span class="total_last_times">{{$total_last_times}}</span> 次抽奖机会 </div>
            <!--<div class="invite_count invite_total">已邀请好友：<span class="invite_total_num">{{$invite_total}}</span> /人</div>-->
        </div>
    </div>
	<div class="won_prize_members">
		<h1>幸运用户中奖名单 </h1>
		<div class="won_prize_bg">
			<ul class="item_01"><li>获奖昵称</li><li>获奖号码</li><li>获得奖品</li><li>获奖时间</li></ul>
            @foreach($anouncement as $key => $item)
                <div class="hr"></div>
                <div class="item_0{{$key}}">
                    @foreach($item as $row)
                        <ul><li>{{$row['nickname']}}</li><li>{{$row['mobile']}}</li><li>{{$row['prize']}}</li><li>{{$row['time']}}</li></ul>
                    @endforeach
                </div>
            @endforeach
			{{--<div class="hr"></div>--}}
			{{--<div class="item_02">--}}
			{{--<ul><li>包尾大师1</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师2</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师3</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--</div>--}}
			{{--<div class="hr"></div>--}}
			{{--<div class="item_03">--}}
			{{--<ul ><li>包尾大师4</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师5</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师6</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--</div>--}}
			{{--<div class="hr"></div>--}}
			{{--<div class="item_04">--}}
			{{--<ul><li>包尾大师7</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师8</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--<ul><li>包尾大师9</li><li>157****9852</li><li>iPhone 6</li><li>2016/06/17  14:12:55</li></ul>--}}
			{{--</div>--}}
			<div class="hr"></div>
			
			
		</div>
	</div>
	
	{{--<div class="won_prize_members">--}}
		{{--<h1>如何赚取块乐豆？</h1>--}}
		{{--<div class="won_prize_bg won_prize_bg2">--}}
			{{--<div class="way01">--}}
				{{--<h2>块乐豆赚取攻略:</h2>--}}
				{{--<p>（1）注册用户在特速一块购平台每消费1块钱，即可获得1块乐豆；</p>--}}
				{{--<p>（2）您的受邀好友首次消费即可赠送给您100块乐豆</p>--}}
				{{--<p>（3）晒单上传实物照片+分享心得，成功晒单后即可获得100-500块乐豆；</p>--}}
				{{--<p>（4）活动期间完善您的个人资料，即可获得30块乐豆，仅首次修改赠送。</p>--}}
			{{--</div>--}}
			{{--<div class="way02">--}}
				{{--<h2>块乐豆使用攻略：</h2>--}}
				{{--<p>（1）参与幸运转盘活动，百分百中奖，每次抽奖仅需消耗10块乐豆；另外，推荐一个免费 抽奖的方法，邀请3位好友即可免费抽奖一次哟！</p>--}}
				{{--<p>（2）100块乐豆=1块钱，订单支付时可使用块乐豆进行消费，100块乐豆即可获得一个商品块乐码，满满都是幸福感，立即一块购！</p>--}}
				{{--<p class="tip_red">（3）温馨提示：块乐豆每年12月31日清零，不花就浪费了，赶紧购起来。</p>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
</div>
<div class="new_ttmf_bg_bottom">
    <span class="new-rotary-tit"></span>
	<div class="main_content">
		<div class="qiang_ct">
			<div class="qiang_bg">
			</div>
            @foreach($products[0] as $product)
                <div class="goods_bg_ct" data-url="/product/{{$product->oid}}"  style="cursor:hand">
                    <div class="goods_bg"><img src="{{$product->thumb}}" /></div>
                    <div class="goods_desc_ct">
                        <div class="goods_desc">
                            <p> {{$product->title}}</p>
                        </div>
                    </div>
                    <div class="goods_btn"  data-url="/product/{{$product->oid}}"  style="cursor:hand">
                        <span>{{$product->title2}}</span>
                        <a>一块<br/>抢购  </a>
                    </div>
                </div>
            @endforeach
		</div>
		
		<div class="qiang_ct">
			<div class="qiang_bg01">
			</div>
            @foreach($products[1] as $product)
                <div class="goods_bg_ct" data-url="/product/{{$product->oid}}"  style="cursor:hand">
                    <div class="goods_bg"><img src="{{$product->thumb}}" /></div>
                    <div class="goods_desc_ct">
                        <div class="goods_desc">
                            <p> {{$product->title}}</p>
                        </div>
                    </div>
                    <div class="goods_btn"  data-url="/product/{{$product->oid}}"  style="cursor:hand">
                        <span>{{$product->title2}}</span>
                        <a>一块<br/>抢购  </a>
                    </div>
                </div>
            @endforeach
		</div>
	</div>

    <div class="new_invite_friend_district_ct">
        <i class="invite_finger"></i>
        <a class="new_invite_friend_district">邀请好友一起玩</a>
    </div>

</div>

<script type="text/javascript" src="{{$url_prefix}}js/jQueryRotate.2.1.js"></script>
<script>
    var _token = $("input[name='_token']").val();
    var flag = {{$flag}};
    var rotary_request = "{{$rotary_request}}";
    var log = 0;
    var invite_url = "{{$invite_url}}";

	$(function (){

	var rotateTimeOut = function (){
		$('.zhuan_pan').rotate({
			angle:0,
			animateTo:2160,
			duration:8000,
			callback:function (){
				alert('网络超时，请检查您的网络设置！');
			}
		});
	};
	var bRotate = false;

	var rotateFn = function (awards, angles, txt){
		$('.zhuan_pan').stopRotate();
		$('.zhuan_pan').rotate({
			angle:0,
			animateTo:angles+1800-22.5,
			duration:8000,
			callback:function (){
				//alert(txt);
				bRotate = !bRotate;
                if(flag == -1){
                    $('.js_award_name_nologin').html(txt);
                    $(".all_grey_bg").show();
                    $("#award-result1").show();
                }else {
                    $(".js_award_name").html(txt);
                    $(".all_grey_bg").show();
                    $("#award-result").show();

                    $.ajax({
                        url: '/rotary/upstatus',
                        type: 'post',
                        dataType: 'json',
                        data: {_token: _token, log: log},
                        success: function (res) {
                            //                        alert(res.message);
                        }
                    })
                }
			}
		})
	};

	$('.zhizhen').click(function (){

        if(bRotate)return;

        if(flag == -1){
            bRotate = !bRotate;
//            $('.all_grey_bg').show();
//            $('.login_alert').show();
//            window.location.href = '/login';
            var item = rnd(1, 7);
            runRotary(item);

            return false;
        }else {
            if (flag == 0) {
                $('.all_grey_bg').show();
                $('.kld_not_enought').show();
                return false;
            }

            if (flag == 2) {
                $('.klbean_tips').show();
                setTimeout(function () {
                    $('.klbean_tips').hide()
                }, 2000);
            }

            bRotate = !bRotate;

            $.ajax({
                url: rotary_request,
                type: 'post',
                dataType: 'json',
                data: {_token: _token},
                success: function (res) {
                    if (res.status == 0) {
                        var item = res.data.prize_id;

                        $('.my_klbean').text(res.data.kl_bean);
                        $('.invite_total_num').text(res.data.invite_total);
                        $('.total_free_times').text(res.data.total_free_times);
                        $('.last_free_times').text(res.data.last_free_times);
                        $('.total_last_times').text(res.data.total_last_times);

                        log = res.data.log;
                        flag = res.data.flag;

                        runRotary(item);
                    } else if (res.status == -1) {
                        flag = 0;
                        $('.all_grey_bg').show();
                        $('.kld_not_enought').show();
                        return false;
                    } else {
                        layer.alert(res.message);
                        return false;
                    }
                }
            })
        }

		//console.log(item);
	});

    function runRotary(item){
        switch (item) {
            case 7:
                //var angle = [45, 90, 135, 180, 225, 270, 315,360];
                rotateFn(7, 360, '10元红包');
                break;
            case 3:

                rotateFn(3, 315, 'ipadmini2');
                break;
            case 5:

                rotateFn(5, 270, '5元红包');
                break;
            case 4:

                rotateFn(4, 225, '暴风魔镜');
                break;
            case 8:

                rotateFn(8, 180, '1元红包');
                break;
            case 2:

                rotateFn(2, 135, '小米平衡车');
                break;
            case 6:

                rotateFn(6, 90, '88元红包');
                break;
            case 1:

                rotateFn(1, 45, 'iphone6');
                break;
        }
    }
});

function rnd(n, m){
	return Math.floor(Math.random()*(m-n+1)+n)
}
$(".close_login").click(function(){
	$(this).parent().parent().hide();
	$(".all_grey_bg").hide();
});
$(".continue_btn").click(function(){
    $(".js-closex").click();
	$(".alert,.all_grey_bg").hide();
});
$(".new_invite_friend_district").click(function(){
    if(flag == -1){
        $('#not_login').click();
        return false;
    }
	$(".all_grey_bg,#make-money-free ").show();
});
$(".new_rule").click(function(){
	$(".all_grey_bg,.activity_rule").show();
});

ss(".item_02 ul");
ss(".item_03 ul");
ss(".item_04 ul");
function ss(obj){
    var i1=0;
    setInterval(function(){
        pmd(obj,i1++);
    },3000);
    function pmd(parentObj,index){
        $(parentObj).eq(index).slideUp("2000");
        if(index==$(parentObj).length-1){
            setTimeout(function(){
                i1=0;
                $(parentObj).show();
            },1001);
        }
    }
}

$('#not_login, .login-now').click(function(){
//    $('.all_grey_bg').show();
//    $('.login_alert').show();
//    window.location.href = '/login';
    $(".js-closex").click();
    $('#login-tip').show();
    $('.all_grey_bg').show();
})

$('.login_btn').click(function(){
//    var username = $("input[name='username']").val();
//    var password = $("input[name='password']").val();
//
//    if(username=="请输入手机号" || username == "" || username == null){
//        return false;
//    }
//
//    if(password=="请输入密码" || password == "" || password == null){
//        return false;
//    }
//
//    $.ajax({
//        type: "post",
//        url: "/login",
//        dataType:'json',
//        data:{
//            username :username,
//            password : password,
//            _token : _token
//
//        },
//        success:function(data){
//            if(data.status == 0){
//                window.location.reload();
//            }else{
//                alert(data.msg);
//            }
//        }
//    });
    window.location.href = '/login';
})
    $(".goods_bg_ct").mouseenter(function(){
        $(this).children().children(".goods_desc").show();
    });
    $(".goods_bg_ct").mouseleave(function(){
        $(this).children().children(".goods_desc").hide();
    });

    $('.goods_bg_ct, .goods_btn').click(function(){
        var url = $(this).attr('data-url');
        window.location.href = url;
    })

    $('.invite_friend_btn').click(function(){
        $('.close_login').click();
        $('.new_invite_friend_district').click();
    })

    $('.invite_friend_btn2').click(function(){
        $(".alert,.all_grey_bg").hide();
        $('.new_invite_friend_district').click();
    })

    window._bd_share_config = {
        common : {
            bdText : '一言不合就中iPhone，就问还！有！谁！',
            bdComment : '一言不合就中iPhone，就问还！有！谁！',
            bdDesc : '一言不合就中iPhone，就问还！有！谁！',
            bdUrl : invite_url.replace('&amp;', '&'),
            bdPic : 'http://www.ts1kg.com/foreground/img/wxshare.png'
        },
        share : [{
            "bdSize" : 32
        }]
    }

    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
    
    $(".js-closex").click(function(){
    	$(".all_grey_bg").hide();
    	$(this).parent().parent().hide();
    });
</script>

@endsection
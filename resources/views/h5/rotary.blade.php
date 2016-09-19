<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=320,minimum-scale=1,maximum-scale=5,user-scalable=no">
	<meta meta name="format-detection" content="telephone=no,email=no,adress=no" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>一块购 幸运大转盘</title>
    <link href="{{$h5_prefix}}css/mui.css?v={{config('global.version')}}" rel="stylesheet" />
    <link href="{{$h5_prefix}}css/page.css?v={{config('global.version')}}" rel="stylesheet" />
    <style>
	body{font-size:12px; color:#656565; width: 100%;  font-family: 'Microsoft Yahei',tahoma,arial,"Hiragino Sans GB",\5b8b\4f53;}
	select,input,button{vertical-align:middle;font-size:100%;}
	a{color:#656565; font-size:12px; text-decoration:none;}
	body,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,p,th,td,form,fieldset,legend,input,button,textarea,blockquote,hr,pre{margin:0;padding:0;}
	h1,h2,h3,h4,h5,h6,b,i,button,input,select,textarea{font-size:100%;font-weight:normal;font-style:normal; font-family:"microsoft yahei"; outline: none;}
	::-moz-focus-inner{outline:none;}
	input[type="submit"],
	input[type="reset"],
	input[type="button"],
	button {-webkit-appearance: none;}
	article, aside, details, figcaption, figure, footer, header, nav, section { display: block; }
	audio, canvas, video { display: inline-block; *display: inline; *zoom: 1; }
	audio:not([controls]) { display: none; }
	fieldset,img{border:0;}
	li{list-style:none; margin:0; padding:0;}
	input,select{vertical-align:middle;}
	textarea {-webkit-appearance: none;}
	.clearfix:after {content:".";display:block;height:0;clear:both;visibility:hidden;}
	*html .clearfix {zoom:1;}
	*+html .clearfix {zoom:1;}
	select, textarea, input[type='text'], input[type='search'], input[type='password'], input[type='datetime'], input[type='datetime-local'], input[type='date'], input[type='month'], input[type='time'], input[type='week'], input[type='number'], input[type='email'], input[type='url'], input[type='tel'], input[type='color']{height:auto; line-height: auto; margin: 0px; padding:0px; border-radius: opx;}
	
	.mui-bar .mui-icon{font-size: 16px;}
	.mui-icon .mui-badge{padding:0px 3px;font-size: 8px; -webkit-text-size-adjust:none;}
	.mui-bar-tab .mui-tab-item .mui-icon ~ .mui-tab-label{font-size: 10px; -webkit-text-size-adjust:none;}
	.mui-bar-tab{height:34px}
	.mui-bar-tab .mui-tab-item{height:28px}
    </style>

    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>

<body style="overflow-x:hidden;">
{!! csrf_field() !!}
<div class="yg-wrap dayfree" id="ygwrap">
	<!--head start-->
	<div class="freeday-head">

				<span class="h2tit"></span>
				<span class="h2tit-cricle"></span>

			<!--登陆状态 start-->
			<div class="fday-myinfrom">
                @if(empty(session('user.id')))
                    <!--未登陆 start-->
                    <div class="inf-loginstate inf-nologin clearfix">
                        <div class="infno-click f-left">
                            <a href="javascript:void(0);">
                                <span class="tx-img"><img src="{{$h5_prefix}}images/dayfree/loginlogo.jpg" /></span>
                                <h2 class="tx-login">亲，请登录！</h2>
                            </a>
                        </div>
                        <div class="infno-right f-right">
                        	<span class="inf-r-jiang">您剩余 <span class="last_free_times">0</span> 次抽奖机会</span>
                            <!--<div><span class="inf-r-jiang">我的块乐豆：100 /个</span><img src="{{$h5_prefix}}images/question_ioc1.png"/></div>
                            <div><span class="inf-r-yaoqing">新邀请好友：20 /人</span><img src="{{$h5_prefix}}images/question_ioc1.png"/></div>-->
                        </div>
                    </div>
                    <!--未登陆 end-->
                @else
				<!--已登陆 start-->
                    <div class="inf-loginstate inf-yeslogin">
                        <div class="infno-click f-left">
                            <a href="#">
                                <span class="tx-img"><img src="{{$member->user_photo}}" /></span>
                                <div class="yeslog-ul f-right">
                                    <ul>
                                        <li>昵称：{{$member->nickname}}</li>
                                        <li>块乐豆：<span class="my_klbean">{{$member->kl_bean}}</span>个</li>
                                      <!--  <li>共获得<i class="times total_free_times">{{$total_free_times}}</i>次免费抽奖机会</li>-->
                                    </ul>
                                </div>
                            </a>
                        </div>
                   <!--     <div class="infno-right f-right">
                            <span class="inf-r-jiang">剩余免费抽奖次数：<span class="last_free_times">{{$last_free_times}}</span> /次</span>
                            <span class="inf-r-yaoqing">已邀请好友：<span class="invite_total_num">{{$invite_total}}</span> /人</span>
                        </div>-->
                       	<div class="infno-right f-right">
                           <span class="inf-r-jiang">您剩余<span class="total_last_times">{{$total_last_times}}</span> 次抽奖机会</span>
                        </div>
                    </div>
				<!--已登录 end-->
                @endif
			</div>
			<!--登陆状态 end-->
		
			<!--大转盘 start-->
			<div class="turntable">
				<div class="zp-bg"></div>
				<div class="turntable-pointer"></div>
				
			</div>
			<div class="box-shadow"></div>
			<!--大转盘 end-->
			<a href="javascript:void(0)" class="invite-rule"><b>规则</b></a>
			
	</div>
	<!--head end-->
	
	<!--main start-->
	<div class="fday-main">
		<!--名单 start-->
		<div class="f-box">
			<h2 class="f-boxh2">幸运用户中奖名单</h2>
			<div class="f-boxmain">
				<div class="fbox-tit fbox-h2-tit clearfix">
					<span class="fbox-t fbox-t-a">获奖昵称</span>
					<span class="fbox-t fbox-t-b">获得奖品</span>
					<span class="fbox-t fbox-t-c">获奖时间</span>
				</div>
				<!--滚动 start-->
				<div class="fbox-list-wrap">
					<div class="fbox-list-ul" id="fbox-ul1">
                        @foreach($anouncement as $key => $item)
                            @foreach($item as $k => $v)
                                <div class="fbox-list fbox-list{{$k+1}}">
                                    <div class="l-box clearfix">
                                        <span class="lbox-t lbox-t-a">{{$v['nickname']}}</span>
                                        <span class="lbox-t lbox-t-b">{{$v['prize']}}</span>
                                        <span class="lbox-t lbox-t-c">{{$v['time']}}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
						{{--<div class="fbox-list fbox-list1">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">1</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="fbox-list fbox-list2">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">2</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="fbox-list fbox-list3">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">3</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="fbox-list fbox-list1">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">4</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="fbox-list fbox-list2">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">5</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="fbox-list fbox-list3">--}}
							{{--<div class="l-box clearfix">--}}
								{{--<span class="lbox-t lbox-t-a">6</span>--}}
								{{--<span class="lbox-t lbox-t-b">小米（MI）平衡车</span>--}}
								{{--<span class="lbox-t lbox-t-c">2016/06/17 14:12:55</span>--}}
							{{--</div>--}}
						{{--</div>--}}
					</div>
				</div>
				<!--滚动 end-->
			</div>
		</div>
		<!--名单 end-->
		<!--如何赚取块乐豆 start-->
		{{--<div class="f-box">--}}
			{{--<h2 class="f-boxh2">如何赚取块乐豆？</h2>--}}
			{{--<div class="f-boxmain">--}}
				{{--<div class="getkld-box">--}}
					{{--<h2 class="getkld-tit">块乐豆赚取攻略：</h2>--}}
					{{--<p class="getkld-txt">--}}
						{{--（1）注册用户在特速一块购平台每消费1块钱，即可获得1块乐豆；<br />--}}
						{{--（2）您的受邀好友首次消费即可赠送给您100块乐豆；<br />--}}
						{{--（3）晒单上传实物照片+分享心得，成功晒单后即可获得100-500块乐豆；<br />--}}
						{{--（4）活动期间完善您的个人资料，即可获得30块乐豆，仅首次修改赠送。--}}
					{{--</p>--}}
				{{--</div>--}}
				{{--<div class="getkld-box" style="margin-top: 10px;">--}}
					{{--<h2 class="getkld-tit">块乐豆使用攻略：</h2>--}}
					{{--<p class="getkld-txt">--}}
						{{--（1）参与幸运转盘活动，百分百中奖，每次抽奖仅需消耗10块乐豆；另外，推荐一个免费抽奖的方法，邀请3位好友即可免费抽奖一次哟！<br />--}}
						{{--（2）100块乐豆=1块钱，订单支付时可使用块乐豆进行消费，100块乐豆即可获得一个商品块乐码，满满都是幸福感，立即一块购！<br />--}}
						{{--<span style="color: #c4173f;">（3）温馨提示：块乐豆每年12月31日清零，不花就浪费了，赶紧购起来。</span>--}}
					{{--</p>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
		<!--如何赚取块乐豆 end-->
		
		

		<!--一块抢start-->
		<div class="ykq-wrap">
			<b class="ykqh2"></b>
			<div class="ykq-main clearfix">
                @foreach($products as $product)
                   <!--box start-->
                   <div class="ykq-box">
                        <div class="ykgbox-b" data-url="/product_m/{{$product->oid}}">
                            <div class="ykq-img">
                                <img src="{{$product->thumb}}" />
                                <h2 class="ykq-imgtit"><i>{{$product->title}}</i></h2>
                            </div>
                        </div>
                        <div class="ykgbox-but" data-url="/product_m/{{$product->oid}}">
                            <span class="ykg-b-tit">{{$product->title2}}</span>
                            <span class="ykg-b-go">一块<br />抢购</span>
                        </div>
                   </div>
                   <!--box end-->
                @endforeach
			</div>
			<div class="invite-b-bottom js-invbutclick">
				<span class="invite-b-hand invite-hand-css3"></span>
				<span class="invite-b-btn invite-btn-css3">邀请好友一起玩</span>
			</div>

		</div>
		<!--一块抢 end-->
	</div>
	<!--main end-->
	
	<div class="popbg black-bg"></div>
	<div class="loading"></div>
	<!--中奖弹窗 start-->
	<div class="popdiv winning">
		<div class="winning-bg">
			<div class="winning-program"><span class="program-h2">恭喜您获得</span><span class="program-tit">"ipad mini2"</span></div>
		</div>
		<a href="javascript:void(0)" class="againbut w-button js-closeall">继续参与</a>
		<a href="javascript:void(0)" class="invite-fribut w-button js-closebut js-invite-a">邀请好友玩</a>
		<a href="/user_m/bribery" class="redbagbut w-button js-closeall">查看红包</a>
	</div>
	<!--中奖弹窗 end-->
	<!--账户登录 start-->
	<div class="popdiv popbox userlogin">
		<h2 class="popbox-h2 h2-textcenter">一块购账户登录<i class="close-x js-closex"></i></h2>
		<div class="popbox-main">
			<div class="userl-box"><i class="ubox-ico ubox-ico-phone"></i><input type="text" class="ubox-ico-text" name="username" placeholder="用户名/手机号/邮箱地址" /></div>
			{{--<div class="userl-tips hide"><div class="color-e01939">用户名不能为空</div></div>--}}
			<div class="userl-box"><i class="ubox-ico ubox-ico-password"></i><input type="password" class="ubox-ico-text" name="password" placeholder="请输入密码" /></div>
			{{--<div class="userl-tips hide"><div class="color-e01939">密码不能为空</div></div>--}}
			<div class="userl-submit"><input class="ul-button" type="submit" value="立即登录" id="login_btn"/></div>
			<div class="userl-des clearfix">
				<a href="/forgetpwd_m" class="userl-d-forget">忘记密码？</a>
				<a href="/reg_m" class="userl-d-reg">立即注册</a>
			</div>
			<h2 class="login-other"><span class="other-h2">第三方登录</span></h2>
			<div class="login-othmain">
				<a href="{{$qq_login_url}}" class="othmain-ico othmain-ico-qq"></a>
				<a href="{{$wx_login_url}}" class="othmain-ico othmain-ico-wx"></a>
			</div>
		</div>
	</div>
	<!--账户登录 end-->
	<!--邀请有奖 start-->
	<div class="popdiv popbox invite-prizes">
		<h2 class="popbox-h2">邀请有奖<i class="close-x js-closex"></i></h2>
		<div class="prizes-main">
			<p class="pri-des">邀请每满3位好友参与活动即可免费再抽一次，免费次数可累积，赶快邀友抢百万豪礼吧！<span style="color:red">微信里可直接戳右上角分享哦~</span></p>
			<div class="prizes-ico clearfix share_content_ioc bdsharebuttonbox" data-tag="share_1" style=" width: 181px;  margin: 3px auto;">
				{{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-qq.png" /></a>--}}
				{{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-wx.png" /></a>--}}
				{{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-sina.png" /></a>--}}
				{{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-tx.png" /></a>--}}
				{{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-pyq.png" /></a>--}}
                <a class="bds_sqq prizem-icoa"  data-cmd="sqq"  style="background: url('/H5/images/dayfree/prizem-ico-qq.png') no-repeat; height: 30px;display: block;width: 30px;background-size: 100% 100%;float:left"></a>
                <a class="bds_tsina prizem-icoa" data-cmd="tsina"  style="background: url('/H5/images/dayfree/prizem-ico-sina.png') no-repeat; height: 30px;display: block;width: 30px;background-size: 100% 100%;float:left"></a>
                {{--<a class="bds_weixin prizem-icoa" data-cmd="weixin"  style="background: url('/H5/images/dayfree/prizem-ico-wx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
                {{--<a class="bds_renren prizem-icoa" data-cmd="renren" style="background: url('/H5/images/dayfree/prizem-ico-tx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
                <a class="bds_qzone prizem-icoa" data-cmd="qzone"  style="background: url('/H5/images/dayfree/prizem-ico-qzone.png') no-repeat; height: 30px;display: block;  width: 30px;background-size: 100% 100%;float:left"></a>
			</div>
		</div>
	</div>
	<!--邀请有奖 end-->
	<!--活动规则 start-->
	<!--<div class="popdiv popbox activity-rules">
		<h2 class="popbox-h2">活动规则<i class="close-x js-closex"></i></h2>
		<div class="rules-main">
			<h2 class="rules-h2">活动时间：</h2>
			<p class="rules-des margin-bottom10">即日起生效，具体结束时间请留意特速一块购官方发布。</p>
			<h2 class="rules-h2">活动规则：</h2>
			<p class="rules-des margin-bottom10">
				（1）每抽奖一次需消耗10块乐豆，额外获取的抽奖机会可免费参与，优先使用；<br />
				（2）特速一块购新注册用户可免费获得1次抽奖机会，同一用户限领一次；<br />
				（3）活动期间邀请好友每满3人参与活动即可增加1次免费抽奖机会，免费次数可累积但每天仅限使用一次。
			</p>
			<h2 class="rules-h2">奖品发放：</h2>
			<p class="rules-des margin-bottom10">
				（1）<span class="color-e63955">我们的客服人员会在24小时内联系实物中奖用户提供收货地址，3个工作日内发货；</span><br />
				（2）红包奖品系统会自动发放至中奖用户账户中，<span class="color-e63955">红包有效期15天</span>，详细的使用规则可在“我的红包”中查看。
			</p>
			<h2 class="rules-h2">活动时间：</h2>
			<p class="rules-des margin-bottom10">
				（1）对于以不正当方式参与的用户，包括但不限于恶意刷单、恶意注册、利用程序漏洞等，特速一块购有权取消其活动参与资格、并有权撤销违规交易，回收所非法获得的金额；<br />
				（2）特速一块购在法律范围内享有本活动的最终解释权。
			</p>
		</div>
	</div>-->
	<div class="popbox activity-rules popdiv" id="chou-jiang-rule">
		<h2 class="popbox-h2">抽奖规则<i class="close-x js-closex"></i></h2>
		<div class="rules-main">
			<h2 class="rules-h2">活动时间：</h2>
			<p class="rules-des margin-bottom10">即日起生效，具体结束时间另行通知。</p>
			<h2 class="rules-h2">抽奖规则：</h2>
			<p class="rules-des margin-bottom10">
				1、新注册用户可免费获得1次抽奖机会；<br/>
				2、无免费抽奖则需要每次消耗10块乐豆抽奖1次；<br/>
				3、无登录状态下抽中的奖品视为无效，需要重新登录抽奖。
			</p>
			<h2 class="rules-h2">奖品发放规则：</h2>
			<p class="rules-des margin-bottom10">
				1、实物奖品我司客服人员会在24小时内电话联系确认收货地址；<br/>
				2、红包奖励系统自动发放至账户，可在个人中心“我的红包”中查看并使用。
			</p>
			<h2 class="rules-h2">违规处理说明：</h2>
			<p class="rules-des margin-bottom10">
				1、凡利用一切非法及不正当手段获得到的块乐豆及奖品，特速一块购将不会承认中奖事实，并回收块乐豆，情节严重导致平台损失，我们将会依法追究其法律责任；<br/>
				2、该活动在法律允许范围内享有最终解释权。
			</p>
		</div>
	</div>
	<!--活动规则 end-->
	<!--块乐豆不足 start-->
	<div class="popdiv popbox kld kld_not_enought">
		<h2 class="popbox-h2">块乐豆不足<i class="close-x js-closex"></i></h2>
		<div class="kld-main">
			<p class="kld-txt">块乐豆不足</p>
			<div class="kld-href clearfix">
				<a href="javascript:void(0);" class="kld-yaoyou invite_friend_btn">邀友免费玩</a>
				<a href="javascript:void(0);" class="kld-index" onclick="window.location.href='/category_m'">抢购赚乐豆</a>
			</div>
		</div>
	</div>
	<!--抽奖结构-已登陆 start-->
	<div class="popbox award-login-pop popdiv" id="award-result">
		<h2 class="popbox-h2"><i class="close-x js-closeall"></i></h2>
		<div class="tip-msg">
			<p>恭喜您抽到</p>
			<p class="js_award_name"></p>
		</div>
		<div class="tip-btn-group">
			<input type="button" value="立即使用" class="gotouse award-againbut">
			<a href="javascript:void(0)" class="award-againclose js-closeall">继续抽奖</a>
		</div>
	</div>
	<!--抽奖结构-未登陆 start-->
	<div class="popbox award-result-pop popdiv" id="award-result1">
		<h2 class="popbox-h2"><i class="close-x js-closeall"></i></h2>
		<div class="tip-msg">
			<p>恭喜您抽到</p>
			<p class="js_award_name_nologin"></p>
		</div>
		<p class="login-tip">
			提示：根据抽奖规则，您未登录视为无效抽奖，请登录后重新抽奖！
		</p>
		<div class="tip-btn"><input type="button" value="立即登录" class="login-now"/></div>
	</div>
	<!--登陆提示弹出窗 start-->
	<div class="popbox login-pop popdiv" id="login-tip">
		<h2 class="popbox-h2">登录<i class="close-x js-closeall"></i></h2>
		<div class="login-way clearfix">
           <a href="{{$wx_login_url}}" class="logp-alinks logp-alinks-1"><i class="log-p-ico wx-loginico"></i><i class="log-p-tit">微信登录</i></a>
           <a href="{{$qq_login_url}}" class="logp-alinks logp-alinks-2"><i class="log-p-ico qq-loginico"></i><i class="log-p-tit">QQ登录</i></a>
           <a href="/login_m" class="logp-alinks logp-alinks-3"><i class="log-p-ico site-loginico"></i><i class="log-p-tit">账号登录</i></a>
		</div>
	
		<div class="login-pop-reg">
			不想使用第三方登录：<a href="/reg_m" class="l-pop-reglink">免费注册</a>一块购账号
		</div>
	</div>

	<div class="popbox makemoney-pop popdiv" id="make-money-free">
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
		<div class="login-area">
            <div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">
				<a class="prizem-icoa bds_sqq"  data-cmd="sqq" style="width:30px; height:30px; margin: 5px 10px 0px 50px; display: block; float:left;background: url('/H5/images/dayfree/prizem-ico-qq.png') no-repeat; background-size: 30px 30px;"></a>
                <a class="prizem-icoa bds_tsina" data-cmd="tsina" style="width:30px; height:30px; margin: 5px 10px; display: block;float:left;background: url('/H5/images/dayfree/prizem-ico-sina.png') no-repeat; background-size: 30px 30px;"></a>
                {{--<a class="bds_weixin prizem-icoa" data-cmd="weixin"  style="background: url('/H5/images/dayfree/prizem-ico-wx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
                {{--<a class="bds_renren prizem-icoa" data-cmd="renren" style="background: url('/H5/images/dayfree/prizem-ico-tx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
                <a class="prizem-icoa bds_qzone" data-cmd="qzone"  style="width:30px; height:30px; margin: 5px 10px; display: block;float:left;background: url('/H5/images/dayfree/prizem-ico-qzone.png') no-repeat; background-size: 30px 30px;"></a>
			</div> 
		</div>
	</div>
	
	
	
	
	
	<!--块乐豆不足 end-->
	<!--抽奖提示弹窗 start-->
	<div class="popdiv cj-tips">
		<p>每次抽奖需消耗10块乐豆，邀请每满3人参与活动即可免费再抽一次，免费次数可累积但每天仅限使用一次，详细规则请仔细查阅！</p>
	</div>
	<!--抽奖提示弹窗 end-->
	<!--底部导航 start-->
	<nav class="mui-bar mui-bar-tab show hide" id="menu">

         <a class="mui-tab-item " href="/index_m" data-url="/index_m">
            <span class="mui-icon iconfont icon-home"></span>
            <span class="mui-tab-label">首页</span>
         </a>
         <a class="mui-tab-item " href="/category_m" data-url="/category_m">
             <span class="mui-icon iconfont icon-chanpinfenlei01"></span>
            <span class="mui-tab-label">全部商品</span>
         </a>
         <a class="mui-tab-item mui-active" href="/find_m" data-url="/find_m">
            <span class="mui-icon iconfont icon-youxi" style="font-size: 19px;"><!--<span class="mui-badge">9</span>--></span>
            <span class="mui-tab-label">发现</span>
         </a>
         <a class="mui-tab-item " href="/mycart_m" data-url="/mycart_m">
            <span class="mui-icon iconfont icon-gouwuche" ><span class="mui-badge @if($total_count <= 0) hide @endif" id="cartI">{{$total_count}}</span></span>
            <span class="mui-tab-label">购物车</span>
         </a>
          <a class="mui-tab-item " href="/usercenter" data-url=" /usercenter ">
            <span class="mui-icon iconfont icon-iconfuzhi"></span>
            <span class="mui-tab-label">我</span>
         </a>
          <div class="circle-div"><b class="circle-b"></b></div>
      </nav>
	<!--底部导航 end-->
</div>
<script src="{{$h5_prefix}}js/jquery191.min.js" type="text/javascript"></script>
<script src="{{$h5_prefix}}js/jQueryRotate.2.1.js?v={{config('global.version')}}" type="text/javascript"></script>
<script>
    var _token = $("input[name='_token']").val();
    var flag = {{$flag}};
    var rotary_request = "{{$rotary_request}}";
    var log = 0;
    var invite_url = "{{$invite_url}}";


	if(navigator.appVersion.indexOf('Android') != -1){
		document.addEventListener("DOMContentLoaded",function(e){
			document.getElementById('ygwrap').style.zoom = e.target.activeElement.clientWidth/320;
		});
	}
	//loading 加载动画
	$('.popbg').fadeIn().delay(1000).fadeOut();
	$('.loading').fadeIn().delay(1000).fadeOut();
	//滚动函数
	function scroll(){
			var lineHeight = $(".fbox-list:first").height();
			$(".fbox-list-ul:first").animate({
				"margin-top": -lineHeight + "px"
			},1200,
			function() {
		        $(".fbox-list-ul:first").css({
		            "margin-top": "0px"
		        }).find(".fbox-list:first").appendTo($('.fbox-list-ul:first'));
		    }
			);
		}
	$(document).ready(function(){
		//图片自动滚动
		setInterval('scroll()', 2500)
		
		//大转盘抽奖
		var rotateTimeOut = function (){
			$('.zp-bg').rotate({
				angle:0,
				animateTo:4160,
				duration:8000,
				callback:function (){
					alert('网络超时，请检查您的网络设置！');
				}
			});
		};
		var bRotate = false;
		var rotateFn = function (awards, angles, txt){
			$('.zp-bg').stopRotate();
			$('.zp-bg').rotate({
				angle:0,
				animateTo:angles+2880-22.5,    //转速时间，360倍速
				duration:9000,                 //持续时间ms
				callback:function (){
                    bRotate = !bRotate;
                    if(flag == -1){
                        $(".popbg").show();
                        $("#award-result1").show();
                        $(".js_award_name_nologin").html('"'+txt+'"');
                    }else{
                        $(".popbg").show();
                        $("#award-result").show();
                        $(".js_award_name").html('"'+txt+'"');

                        $.ajax({
                            url: '/rotary/upstatus',
                            type: 'post',
                            dataType: 'json',
                            data: {_token:_token,log:log},
                            success: function(res){
//                        alert(res.message);
                            }
                        })
                    }
				}
			})
		};
		//抽奖按钮事件
		$('.turntable-pointer').click(function (){
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
                    $('.popbg').show();
                    $('.kld_not_enought').show();
                    return false;
                }

                if (flag == 2) {
                    $('.cj-tips').show();
                    setTimeout(function () {
                        $('.cj-tips').hide()
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
                            $('.popbg').show();
                            $('.kld_not_enought').show();
                            return false;
                        } else {
                            layer.alert(res.message);
                            return false;
                        }
                    }
                })
            }
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
		
		
		//弹窗-点击黑背景隐藏各个弹窗
		$('.popbg').on('click',function(){
			$(this).hide();
			$('.popdiv').hide();
		})
		
		$('.js-closex').on('click',function(){
			$('.popbg').hide();
			$(this).parents('.popdiv').hide();
			$(".invite-b-hand").addClass("invite-hand-css3");
			$(".invite-b-btn").addClass("invite-btn-css3");
		})
		//点击关闭按钮，关闭所有弹窗
		$('.js-closeall').on('click',function(){
			$(this).parents('.popdiv').hide();
			$('.popbg').hide();
		})
		//点击关闭按钮，关闭父类窗口，保留黑色背景弹窗（用于弹窗与弹窗之间的切换）
		$('.js-closebut').on('click',function(){
			$(this).parents('.popdiv').hide();
		})
		
		/***获奖项目上按钮的弹窗****/
		$('.js-invbutclick').on('click',function(){
			//$(this).parents('.popdiv').hide();
            $('.popbg').show();
			$('#make-money-free').show();
			$(".invite-b-hand").removeClass("invite-hand-css3");
			$(".invite-b-btn").removeClass("invite-btn-css3");
		})
		/***邀请好友弹窗***/
		$('.invite-friends').on('click',function(){
            if(flag == -1){
//                $('.popbg').show();
//                $('.userlogin').show();
                window.location.href = '/login_m';
                return false;
            }
			$('.popbg').show();
			$('.invite-prizes').show();
		})
		/***邀请好友弹窗***/
		$('.invite-rule').on('click',function(){
			$('.popbg').show();
			$('#chou-jiang-rule').show();
		})

        $('.tx-login, .login-now').click(function(){
//            $('.popbg').show();
//            $('.userlogin').show();
//            window.location.href = '/login_m';
            $(".js-closeall").click();
            $('#login-tip').show();
            $('.popbg').show();
        })

        $('.gotouse').click(function(){
            window.location.href = '/category_m';
        })

        $('#login_btn').click(function(){
//            var username = $("input[name='username']").val();
//            var password = $("input[name='password']").val();
//
//            if(username=="请输入手机号" || username == "" || username == null){
//                return false;
//            }
//
//            if(password=="请输入密码" || password == "" || password == null){
//                return false;
//            }
//
//            $.ajax({
//                type: "post",
//                url: "/login",
//                dataType:'json',
//                data:{
//                    username :username,
//                    password : password,
//                    _token : _token
//
//                },
//                success:function(data){
//                    if(data.status == 0){
//                        window.location.reload();
//                    }else{
//                        alert(data.msg);
//                    }
//                }
//            });
            window.location.href = '/login_m';
        })

        $('.ykgbox-b, .ykgbox-but').click(function(){
            var url = $(this).attr('data-url');
            window.location.href = url;
        })

        $('.invite_friend_btn').click(function(){
            $('.js-closex').click();
            $('.js-closeall').click();

            $('.popbg').show();
            $('.js-invbutclick').click();
        })


	})
	function rnd(n, m){
		return Math.floor(Math.random()*(m-n+1)+n)
	}

    window._bd_share_config = {
        common : {
            bdText : '一言不合就中iPhone，就问还！有！谁！',
            bdComment : '一言不合就中iPhone，就问还！有！谁！',
            bdDesc : '一言不合就中iPhone，就问还！有！谁！',
            bdUrl : invite_url.replace('&amp;', '&'),
            bdPic : 'http://m.ts1kg.com/foreground/img/wxshare.png'
        },
        share : [{
            "bdSize" : 16
        }]
    }

    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>

<script>
    /*var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?cc4d5f60a15bfff8ca10bf514eb87d02";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();*/
</script>


@if($is_weixin)
    <script>
        wx.config({
            debug: false,
            appId: '{{$jspackage["appId"]}}',
            timestamp: '{{$jspackage["timestamp"]}}',
            nonceStr: '{{$jspackage["nonceStr"]}}',
            signature: '{{$jspackage["signature"]}}',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });

        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: '一言不合就中iPhone，就问还！有！谁！', // 分享标题
                link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}&is_freeday=1", // 分享链接
                imgUrl: 'http://m.ts1kg.com/foreground/img/wxshare.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    alert('感谢您的分享(^o-o^)');
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            //发送给朋友
            wx.onMenuShareAppMessage({
                title: '一言不合就中iPhone，就问还！有！谁！', // 分享标题
                desc: '一言不合就中iPhone，就问还！有！谁！', // 分享描述
                link: "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}&is_freeday=1", // 分享链接
                imgUrl: 'http://m.ts1kg.com/foreground/img/wxshare.png', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    alert('感谢您的分享(^o-o^)');
                },
                cancel: function () {
                }
            });
        });//end ready function

    </script>
@endif

</body>
</html>
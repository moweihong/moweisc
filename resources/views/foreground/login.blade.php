<!DOCTYPE html>
<html lang="en">
<head>
<meta name="keywords"content=""/>
<meta name="description" content=""/>
<meta name="author"  content=""/>
<meta name="robots" content="" />
<meta http-equiv="Content－Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
<meta name="format-detection" content="telephone=no,address=no,email=no"/>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/> 
<meta name="renderer" content="webkit"/>
<link rel="stylesheet" href="{{ asset('foreground/css/login.css') }}"/>
<link rel="stylesheet" href="{{ asset('foreground/css/comm.css') }}"/>
<link rel="stylesheet" href="{{ asset('foreground/css/forgetPwd.css') }}"/>
<script type="text/javascript" src="{{ asset('foreground/js/jquery190.js') }}"></script>
<script src="{{ asset('foreground/js/layer/layer.js') }}"></script>
<title>一块购-登录</title>
 
</head>
<body>


 <!-- center -->
  <div class="w_bg_box" >
      <div class="w_header">
		<a href="/"><img src="{{ asset('foreground/img/logo.png') }}" title="特速一块购" alt=""/></a>
      </div>
 
	  <div class="loginbg">
            <form method="post">
             {!! csrf_field() !!}
			<div class='dlk'></div>
			<div class="dlk_co">
			  <div class='dlk_coo'>
				<h2>欢迎登录</h2>
				<!--账号登录ST-->
				<div class='zhdlipt' >
					<input type="text" name="username" id="username" maxlength="11" value='' placeholder='全木行/特速一块购/链金所账号' class='dlkipt' style='background-image:url({{$url_prefix}}img/dlkico1.jpg);background-repeat:no-repeat;'>
					<input type="password" name="retPassword" id="password" maxlength="16" value='' placeholder='密码' class='dlkipt' style='background-image:url({{$url_prefix}}img/dlkico2.jpg);background-repeat:no-repeat;' >
				</div>
				<!--账号登录EN-->
				
				<!--验证码登录ST-->
				<div class='yzmdlipt' style='display:none'>
                    <input type="text" name='userphone' id="userphone" value='' placeholder='请输入手机号' class='dlkipt' style='background-image:url({{$url_prefix}}img/dlkico1.jpg);background-repeat:no-repeat;'>
					<div class='yzmdldiv'>
						<input type="password" name='userpasswd' id='userpasswd' value='' placeholder='密码' class='dlkipt yzmipt' style='background-image:url({{$url_prefix}}img/dlkico2.jpg);background-repeat:no-repeat;' >
						<div class='yzmdlbt'>免费发送</div>
					</div>
				</div>
				<!--验证码登录EN-->
			  </div>
			</div>   
           
			<div class="dlk_co2">
			   <div class='dlk_coo'>
				<!--账号登录ST-->
				<div class='zhdlipt' style='border:1px solid transparent'>
					<div class="wjmm">
						<a href='/forgetpwd' class="wjmm1">忘记密码？</a>
						<!--<a href='javascript:void();' class="wjmm2" id='djyzmdl'>验证码登录</a>-->
					</div>
                    <input type="button" class="denglu" value="登  录" style="margin-left:30px;margin-top: 5px" id="loginSubmit"/>
					<p class="zhuce23">没有账号？<a href='/register'>免费注册></a></p>
				</div>
				<!--账号登录EN-->
				
				<!--验证码登录ST-->
				<div class='yzmdlipt' style='display:none'>
					<div class="wjmm" style='border:1px solid transparent'>
						<a href='javascript:;' class="wjmm2" id='djmmdl'>密码登录</a>
					</div>
					<!--<div class="loginbt" style="margin-top:40px">登 录</div>-->
                    <input type="button" class="denglu" value="登  录" />
					<p style='font-size:12px;color:#dd2726;margin-top:10px'>提示：</p>
					<p style="font-size:12px;color:#666">未注册一块购的手机号，登录时将自动注册成为一块购账号</p>
				</div>
				<!--验证码登录EN-->
				<div class="fgx" style='margin-top:28px'>
					<hr>
					<div class="fgxwz">第三方登录</div>
					<div class="dltb">
						<div class="dltb1"><a href="{{$qq_login_url}}"><img src="{{$url_prefix}}img/dsfdl1.png" alt=""></a></div>
						<div class="dltb1"><a href="{{$wx_login_url}}"><img src="{{$url_prefix}}img/dsfdl2.png" alt=""></a></div>
<!--						<div class="dltb1"><a href=''><img src="{{$url_prefix}}img/dsfdl3.png" alt=""></a></div>-->
					</div>
				</div>
			</div>
			 </form>
		</div>
	  </div>	
 	  
	  <div class="login_foot1">
		  <a href='/'>首页</a> <s></s>
		  <a href='/help/11'>关于一块购</a> <s></s>
		  <a href='/help/18'>隐私声明</a> <s></s>
		  <a href='/help/12'>合作专区</a> <s></s>
		  <a href='/help/13'>联系我们</a> 
	  </div>
	  <div class="login_foot_row2">Copyright      2011 - 2016,版权所有 ts1kg.com 粤ICP备15100392号-2</div>
	  <div class="login_foot_row3"><img src="{{$url_prefix}}img/login_footicon.png"></div>
	  
  	

  </div>
 
</body>
<script type="text/javascript" src="{{ asset('foreground/js/include_login.js') }}"></script>
<script>
	if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
		//alert('你是使用IE')
		$(".reg-input").keyup(function(){
			$(this).siblings(".input_tips").hide();
			if($(this).val()=="" || $(this).val()==" "){
				$(this).siblings(".input_tips").show();
			}
		})
	}
	

	$(document).ready(function(){
		$('#djyzmdl').click(function(){
			$('.zhdlipt').hide();
			$('.yzmdlipt').show()
		});
		$('#djmmdl').click(function(){
			$('.yzmdlipt').hide();
			$('.zhdlipt').show()
		});
	});
	
</script>
</html>

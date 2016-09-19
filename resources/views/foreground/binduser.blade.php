<!DOCTYPE html>
<html lang="en">
<head>
<meta name="keywords"content=""/>
<meta http-equiv="Content－Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
<meta name="format-detection" content="telephone=no,address=no,email=no"/>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/> 
<meta name="renderer" content="webkit"/>
<link rel="stylesheet" href="{{ asset('foreground/css/registerNew.css') }}"/>
<link rel="stylesheet" href="{{ asset('foreground/css/comm.css') }}"/>
<script type="text/javascript" src="{{ asset('foreground/js/jquery190.js') }}"></script>
<title>一块购-账号绑定</title>
<style>
	.ygqq_register_logo{margin-top:0;width:1000px;margin:0 auto;text-align:left;}
	.ygqq_login_form{border-top:1px solid #dd2726;width:1000px;background:#fff}
	.haiyang{margin-top:30px;text-align:center;height:65px;width:350px;margin:30px auto}
	.haiyang img{border-radius:32px;height:64px;width:64px;}
	.imgwz{font-size:18px;float:left;line-height:64px;color:#333;position: absolute;margin-left: 70px;}
	.imgggg{float:left;width:70px;height:64px;margin:0 auto}
	.formco{border-bottom:1px solid #dedede;width:940px;margin:0 auto;height:30px}
	.formco1,.formco2{text-align:center;width:180px;font-size:18px;float:left;height:28px;cursor:pointer}
	.formco1{border-bottom:2px solid #dd2726;color:#dd2726;}
	.formco2{color:#999}
	.formcoo{width:380px;margin:0 auto}
	.bdsjhm{color:#666;text-align:center;margin:35px 0 20px 0; }
	.ygqq_login_dx_input input{width:380px;border-radius:5px}
	.ygqq_login_dx_input{width:400px;}
	.ygqq_form .ygqq_button{width:400px;font-size:18px}
	.ygqq_login_dx_input .ygqq_login_dx_ym{width:380px}
	.ygqq_login_dx_input .ygqq_register_dx_a{background:#3da3ea;font-size:16px}
	#_sms{display:none}
</style>
</head>
<body style='background:#f8f8f8'>

<div class="ygqq_login">
    <div class="ygqq_login_logo ygqq_register_logo">
        <a href="/"><img src="{{ asset('foreground/img/logo.png') }}"/></a>
    </div>
    <div class="ygqq_login_form">
		<div class="haiyang">
			<div class='imgggg'><img src="{{$headimgurl}}" ></div>
			<div class="imgwz">Hi，{{$nickname}} 欢迎来一块购玩哦</div>
		</div>
		
		<div class="formco">
			<div class="formcoo">
				<div class="formco1">已有一块购账号</div>
				<div class="formco2">没有一块购账号</div>
                <input id="bind_type" value="1" style="display:none;">
			</div>
		</div>
		
		<div class='bdsjhm'><p class='bdsjhm2'>绑定手机号码，以便我们为您提供更全面的服务。</p></div>
    
	<form class="ygqq_form" style="display:block">
      	  {!! csrf_field() !!}
          <div class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts">
              <label>
                  <input class="input reg-input" type="text" id="mobile" name="mobile" maxlength="11" placeholder="请输入手机号"/>
                  <!--[if lt IE 10]>
                  <b class="input_tips">请输入手机号</b>
                  <![endif]-->
                  <i class="ygqq_i"></i>
              </label>
          </div>
          <div class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts">
              <label>
                  <!--<input class="input" type="text" name="pas" id="pas" placeholder="密码为6-16位字符"/>-->
                  <input class="input reg-input" type="password" name="password" maxlength="20" id="password" placeholder="密码为6-16位字符"  />
                  <!--[if lt IE 10]>
                  <b class="input_tips">密码为6-16位字符</b>
                  <![endif]-->
                  <i class="ygqq_i"></i>
              </label>
          </div>
      
		  <div class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts" style="display: none;">
              <label>
                    <input type="text" name="captcha" id="captcha" class="form-control reg-input">
              </label>
          </div>
          <div id="TCaptcha" class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts"  style="height: 48px"></div>
		  
          <div class="ygqq_login_dx_input ygqq_register_dx_input ygqq_ts" id='_sms'>
              <label>
                  <input type="text" id="smsCode" placeholder="短信验证码" class="ygqq_login_dx_ym reg-input" style='width:230px;'/>
                  <!--[if lt IE 10]>
                  <b class="input_tips">短信验证码</b>
                  <![endif]-->
                  <i class="ygqq_i1"></i>
              </label>
              <a href="javascript:void(0);" id='getcode' class="ygqq_login_dx_a ygqq_register_dx_a">获取短信验证码</a>
              <a href="javascript:void(0);" id='getcode2' style='display:none' class="ygqq_login_dx_a"></a>
          </div>
		  
       
          <div class="ygqq_register_xy">
              <input class="ygqq_button" onclick="bindUser()" type="button" value="同意绑定">
          </div>
       
          <p class="zhanghao" style="width:289px; margin:20px auto 100px;font-size: 14px; border-top:1px solid #f0efef; font-family: microsoft Yahei; text-align: center; height: 35px; line-height: 35px; padding: 10px; color:#888888;">特速集团旗下品牌</p>
      </form>
    </div>
</div>
 
 
 

 <script type="text/javascript" src="{{$imgjsUrl}}"></script>
<script>
var capOption={callback :cbfn};
capInit(document.getElementById("TCaptcha"), capOption);
//回调函数：验证码页面关闭时回调
function cbfn(retJson)
{
    if(retJson.ret==0)
    {
        // 用户验证成功
        $("#captcha").val(retJson.ticket);
    }
    else
    {       
		layer.msg('请先点击完成验证');
        //用户关闭验证码页面，没有验证
    }
}
$(function(){
    if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
        //alert('你是使用IE')
        $(".reg-input").keyup(function(){
            $(this).siblings(".input_tips").hide();
            if($(this).val()=="" || $(this).val()==" "){
                $(this).siblings(".input_tips").show();
            }
        })
    }

	//手机号验证
	function checkMobile(mobile){
		var reg = new RegExp('^1[34578][0-9]{9}$');
		if(!reg.test(mobile)){
			return false;	
		}
		return true;
	}
});

$(document).ready(function(){
	$('.formco1').click(function(){
		$(this).css({"border-bottom":"2px solid #dd2726","color":"#dd2726"});
		$('.formco2').css({"border":"none","color":"#999"});
		$('.bdsjhm2').show();
		$('#_sms').hide();
        $("#bind_type").val(1);
	});
	$('.formco2').click(function(){
		$(this).css({"border-bottom":"2px solid #dd2726","color":"#dd2726"});
		$('.formco1').css({"border":"none","color":"#999"});
		$('.bdsjhm2').hide();
		$('#_sms').show();
        $("#bind_type").val(2);
	});
});

</script>
<script src="{{ asset('foreground/js/layer/layer.js') }}"></script><!-- 提示框js -->
<script src="{{ asset('foreground/js/alert.js') }}"></script>
<script src="{{ asset('foreground/js/binduser.js') }}"></script>
</body>
</html>

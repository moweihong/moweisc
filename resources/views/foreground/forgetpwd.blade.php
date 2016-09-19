<!DOCTYPE html>
<html lang="en">
<head>
<meta name="keywords"content=""/>
<meta name="robots" content="" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/> 
<meta name="renderer" content="webkit"/>
<meta http-equiv="Content－Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
<meta name="format-detection" content="telephone=no,address=no,email=no"/>
<link rel="stylesheet" href="{{$url_prefix}}css/forgetPwd.css"/>
<script src="{{$url_prefix}}js/jquery.js"></script>
<title>特速一块购-忘密码</title>
<style>
.yg_for_box{width: 490px;background:#ffffff;font-family:"Microsoft YaHei";}
.yg_for_box form{width: 348px;margin: 0 auto;overflow: hidden;}
.yg_for_box form label{height: 42px;position: relative;margin-top: 28px;display: block;}
.yg_for_box form label p{position: absolute;top: 42px;width: 332px;height: 24px;font-size: 14px;padding-left: 14px;border: 1px solid #c2c2c2;border-top: 0px;color: #616161;}
.yg_for_box form label p.error_yg_p{border: 1px solid #fa9494;border-top: 0px;background: #fcd1d1;color: #f05050;}
.yg_for_box form label p.true_yg_p{border: 1px solid #84c576;border-top: 0px;background: #eff9ff;color: #7abd54;}
.yg_for_box form input{color: #a9a9a9;font-size: 14px;padding-left: 12px;border: 1px solid #ccc;outline: none;width: 334px;height: 40px;font-family:"Microsoft YaHei";}
.yg_for_box h2{color: #111111;font-size: 16px;height: 38px;font-weight: normal;line-height: 38px;padding-left: 13px;border-bottom: 1px solid #bcbcc3;position: relative;}
.get_ygqq1 span{float: left;color: #ffffff;font-size: 14px;line-height: 40px;height: 40px;width: 148px;padding-left: 8px;text-align: center;background: #85c576;border: 1px solid #5cba6e;cursor: pointer;position: relative;}
.get_ygqq1 span:hover{background: #90d22c;}
.get_ygqq1 span i{display: block;border-left: 6px solid #fff;border-top: 3px solid transparent;border-bottom: 3px solid transparent;position: absolute;left: 4px;top: 17px;}
.yg_for_box form .get_ygqq1 input{width: 130px;float: left;margin-left: 44px;}
.yg_for_box form a.yg_true{display: block;width: 131px;height: 42px;background: #8a8a8a;line-height: 42px;text-align: center;color: #fff;border-radius: 2px;font-size: 16px;margin:29px auto 14px;}
#next{background: #FE0100;}
.yg_for_box form .get_ygqq3,.yg_for_box form .get_ygqq2{display: none;}
.yg_for_box form .get_ygqq2 input{width: 102px;float: left;}
.get_ygqq2 span{float: left;position: relative;display: block;width: 117px;height: 40px;border: 1px solid #dd2726;margin-left: 9px;}
.get_ygqq2 span img{width: 72px;height: 40px;}
.get_ygqq2 span i{display:block;width: 45px;height: 42px;position: absolute;right: -2px;top: -1px;background: url(/static/userCenter/images/refresh.jpg) no-repeat;}
.get_ygqq2 .get_ygqq2_a{display: block;width: 92px;height: 42px;background: #dd2726;line-height: 42px;text-align: center;color: #fff;border-radius: 2px;font-size: 14px;margin-left: 12px;float: left;}
.get_ygqq3 span{width: 178px;height: 42px;background: #eaeaea;display: block;float: left;line-height: 42px;text-align: center;color: #888888;font-size: 14px;}
.get_ygqq3 span em{font-style: normal;}
.yg_for_box form .get_ygqq3 input{width: 150px;float: left;margin-left: 6px;}
.y_forget_list{height: 51px;overflow: hidden;}
.email_yg_res{display: none;}
.y_forget_list li{border-top: 2px solid #dddddd;height: 48px;border-bottom: 1px solid #dddddd;float: left;width: 225px;text-align: center;line-height: 48px;color: #555555;font-size: 18px;cursor: pointer;}
.y_forget_list li.for_cl_li{color: #dd2726;border-top: 2px solid #dd2726;border-bottom: 0px;}
.pass_y_find{display: none;}
.c_error2 {
    background: #fff url("/static/userCenter/images/error_icon.png") no-repeat scroll 0 center;
    border: medium none;
    color: #dd2726;
    display: none;
    font-size: 12px;
    height: 38px;
    left: 10px;
    line-height: 43px;
    min-width: 100px;
    padding-left: 20px;
    position: absolute;
    top: 2px;
}
 .c_add_ygqq{
    position: absolute;
    top:264px;
    right:434px;
    display: block;
    width:130px;
    height:170px;
    cursor: pointer;
    margin-right:-452px;
  }
  .y_title_logo {
    width: 142px;
}
</style>
 
</head>
<body>
{!! csrf_field() !!}
	<!-- 内容区域 -->
	<div class="c_forget_bj">
		<div class="c_forget_pwd" style="width:452px;">
<!-- 			<a href="/" class="y_title_logo"><img src="{{$url_prefix}}img/logo.png" border="0" alt="" /></a> -->
			<div class="" style="padding:0px;">
				<h2 class="login_title" style="text-align:center;padding:30px 0px;font-weight:normal;">重置密码</h2>
<!-- 				<ul class="y_forget_list"> -->
<!-- 					<li class="for_cl_li">使用手机修改</li> -->
					<!-- <li style="border-left:1px solid #dddddd;">使用邮箱修改</li> -->
<!-- 				</ul> -->
				<div class="phone_yg_res yg_for_box yg_for_boxs">
					<form>
						<label>
							<input type="text" id="mobile" maxlength="11" placeholder="请输入手机号" onchange="user_mobile()"/>
							<!-- 提示信息 -->
							<!-- 正确 -->
							<p class="true_yg_p  mobileRight" style="display: none;">此手机号可用</p>
							<!-- 错误 -->
							<p class="error_yg_p mobileError" style="display: none;">手机号格式输入错误</p>
						</label>
						<label class="get_ygqq1">
							<span id="getCode"><i></i>免费获取手机验证码</span>
							<span id="getCode2" style="display:none"></span>
							<input type="text"  value="" placeholder='验证码' id="verifyCode" />
						</label>
						<label class="get_ygqq2">
							<input type="text" id="captcha" style="ime-mode:disabled " placeholder="验证码" maxlength="6"/>
							<span><img id="captcha_img" src="{{ URL('captcha/1') }}" style="width:100%" onclick="re_captcha();" cursor="pointer"></span>
							<a href="javascript:checkValidCode();" class="get_ygqq2_a">确定发送</a>
							<p class="error_yg_p code_error2" style="display: none;">验证码输入错误,无法发送</p>
						</label>
						<label class="get_ygqq3">
							<span><em>120</em>秒后重新获取短信</span>
							<input type="text"  id="code" style="ime-mode:disabled "  maxlength="6"  placeholder="验证码"/>
							<p class="error_yg_p code_error3" style="display: none;">验证码输入错误</p>
						</label>
						<div style="position:relative;">
						<a href="javascript:void(0);" id="next" class="yg_true">下一步</a>
						<a href="/" style="position:absolute;top:12px;right: 1px;color: #dd2726;font-size: 14px;">返回首页</a>
						</div>
					</form>
				</div>
				
				<div class="email_yg_res yg_for_box yg_for_boxs">
					<form>
						<label>
							<input id="emailInput" type="text" placeholder="请输入邮箱号"/>
							<!-- 提示信息 -->
							<!-- 正确 -->
							 <p class="true_yg_p emailRight" style="display: none;">此邮箱可用</p> 
							<!-- 错误 -->
							<p class="error_yg_p emailError" style="display: none;">此邮箱格式错误</p> 
						</label>
						<label class="get_ygqq1">
							<span onclick="get_yg1Email()"><i></i>免费获取邮箱验证码</span>
							<input type="text"  value="验证码"/>
						</label>
						<label class="get_ygqq2">
							<input type="text" id="validCodeEmail" style="ime-mode:disabled " value="验证码" maxlength="6"/>
							<span><img id="captcha_imgEmail" src="" width="72" height="40" onClick="this.src='/api/uc/validCodeEmail.do?t=' + Math.random();"><i id="changeImgEmail"></i></span>
							<a href="javascript:checkCodeEmail();" id="c2" class="get_ygqq2_a">确定发送</a>
							<p class="error_yg_p code_error2" style="display: none;">验证码输入错误,无法发送</p>
						</label>
						<label class="get_ygqq3">
							<span><em>120</em>秒后重新获取短信</span>
							<input type="text"  id="codeEmail" style="ime-mode:disabled "  maxlength="6"  value="验证码"/>
							<p class="error_yg_p code_error3" style="display: none;">验证码输入错误</p>
						</label>
						<div style="position:relative;">
						<a href="javascript:nextEmial();" class="yg_true">下一步</a>
						<a href="/" style="position:absolute;top:12px;right: 1px;color: #dd2726;font-size: 14px;">返回首页</a>
						</div>
					</form>
				</div>
			
				<div class="phone_yg_ress yg_for_box yg_for_boxss" style='display:none'>
					<form>
						<label>
							<input type="password" placeholder="请输入新密码" class="pass_y_find1" id="password" minlength="6" maxlength="16"/>
<!-- 							<input type="password" id="password" class="pass_y_find"/> -->
							<span class="c_error2" id="passwordP">密码不能为空</span>
						</label>
						<label>
							<input type="password" placeholder="确认密码" class="pass_y_find1" id="repassword" minlength="6" maxlength="16"/>
<!-- 							<input type="password" id="repassword" class="pass_y_find"/> -->
							<span class="c_error2" id="repasswordP">密码不能为空</span>
						</label>
						<p id="setPassMsg" style="display: none;color:#dd2726;font-size:14px;line-height:30px;padding-left:40px;background:url(/static/userCenter/images/tures.png) no-repeat 10px 4px;">
						密码修改成功后，<span id="loginTime">3</span>秒之后跳到登录页面</p>
						<a href="javascript:setPass();" class="yg_true" id="setPass">确认</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部 -->
	
</body>
<!-- <script type="text/javascript" src="{{$url_prefix}}js/forgetPwd.js"></script> -->
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
<script src="{{ asset('foreground/js/layer/layer.js') }}"></script>
<script>
var canNext = false;//下一步是否可以点击
var time = 120;
var validCode=true;    //获取验证码倒计时变量

if({{ $time }} != -1){
	time = {{ $time }};
	$("#getCode").css('display', 'none');
	$("#getCode2").html("<em class='ygqq_login_dx_time'>"+time+"</em>秒后重新获取");
	$("#getCode2").css('display', 'block');
	get_code($(".ygqq_login_dx_time"));
}
$(function(){
	$('#next').click(function(){
		var mobile = $('#mobile').val();
		var verifyCode = $('#verifyCode').val();
		var _token = $("input[name='_token']").val();

		var check_res = checkMobile();
		if(!check_res){
			return false;
		}
		
		if(verifyCode == "验证码" || verifyCode == "" || verifyCode == null){
			layer.msg('请输入验证码');
			return false;
		}

		$.ajax({
			type: "post",
			url: "/checkVerifyCode",
			dataType:'json',
			async: false,
			data: {_token:_token, verifyCode:verifyCode},
			success: function(res){
				if(res.status == 0){
					canNext = true;
				}else {
					canNext = false;
				}
			}
		})
		
		if(canNext){
			$(".yg_for_boxs").hide();
			$(".yg_for_boxss").show();
		}else{
			//$(".code_error3").html('验证码输入错误');
			//$(".code_error3").show(100).delay(2000).hide(0);
			layer.msg('验证码输入错误');
		}
	})

	$('#getCode').click(function(){
		var mobile=$("#mobile").val();
		var check_res = checkMobile();
		if(check_res){
			//$(".get_ygqq1").hide();
			//$(".get_ygqq2").css("display","block");
			//$("#captcha_img").trigger("click");
			$("#getCode").css('display', 'none');
			$("#getCode2").html("<em class='ygqq_login_dx_time'>120</em>秒后重新获取");
			$("#getCode2").css('display', 'block');
			get_code($(".ygqq_login_dx_time"));
			var _token = $("input[name='_token']").val();
			$.ajax({
				url: '/regverify_set',
				type: 'post',
				dataType: 'json',
				data: {_token:_token,mobile:mobile},
				success: function(res){
					if(res.status == 0){
						//layer.alert('验证码发送成功！');
						canNext = true;
					}else{
						layer.alert(res.message);
					}
				}
			})
		}
	})
})
function user_mobile(){
	var mobile=$("#mobile").val();
	var isMobile=/^0?1[3-8][0-9]\d{8}$/;//手机号码验证规则
	if(isMobile.test(mobile)){
		$('.yg_true').attr('id','next');
	}else{
		$('.yg_true').attr('id','');
	}
}
function checkMobile(){
	var mobile=$("#mobile").val();
	var isMobile=/^0?1[3-8][0-9]\d{8}$/; //手机号码验证规则
	if(mobile =="请输入手机号" || mobile == "" || mobile == null){
		$('.mobileError').html("请填写手机号");
		$('.mobileError').show(100).delay(2000).hide(0);
		$('.true_yg_p').hide();
		$("#mobile").focus();
		return false;
	}else if(!isMobile.test(mobile)){
		$('.mobileError').html("请正确填写手机号");
		$('.mobileError').show(100).delay(2000).hide(0);
		$('.true_yg_p').hide();
		$("#mobile").focus();
		return false;
	}else if(checkMobileExist() == false){
		layer.alert('该手机号未注册！');
		return false;
	}else{
		return true;
	}
}

//获取验证码倒计时
function get_code(obj){
    if (validCode) {
        validCode=false;
        var t=setInterval(function  () {
        	time--;
            obj.html(time);
            if (time==0) {
                clearInterval(t);
               // obj2.html("重新获取");
				$("#getCode2").css('display', 'none');
				$("#getCode").css('display', 'block');
                validCode=true;
                time=120;
            }
        },1000)
    }
}

//校验手机号存在	
function checkMobileExist(){
	var flag = false;
	var _token = $("input[name='_token']").val();
	
	$.ajax({
		type: "post",
		url: "/checkMobileExist",
		dataType:'json',
		async: false,
		data:{
			mobile :$("#mobile").val(),
			_token : _token
		},
		success:function(data){
			if(data.status == -1){
				flag = true;	
			}else{
				$("#mobile").focus();
				flag = false;
			}
		}
	});
	return flag;	
}

function re_captcha() {
    $url = "{{ URL('captcha') }}";
    $url = $url + "/" + Math.random();
    $('#captcha_img').attr('src', $url);
}

function checkValidCode(){
	var captcha = $('#captcha').val();
	var _token = $("input[name='_token']").val();
	$.ajax({
		url: '/checkCaptcha',
		type: 'POST',
		dataType: 'json',
		data: {_token:_token,captcha:captcha},
		async: false,
		success: function(res){
			if(res.status == 0){
				canNext = true;
				$(".get_ygqq2").hide();
				$(".get_ygqq3").css("display","block");
				$(".yg_true").css("background","#dd2726");
				var code=$(".get_ygqq3").find("span em");
				time=120;
				code.html(time);
				t=setInterval(function() {
					time--;
					code.html(time);
					if (time==0) {
						clearInterval(t);
						canNext = false;
						$(".get_ygqq3").css("display","none");
						$(".get_ygqq1").css("display","block");
						$("#captcha_img").trigger("click");
					}
				},1000);
			}else{
				if(res.message){
					$(".code_error2").html(res.message);
				}
				$("#captcha_img").trigger("onclick");
				$(".code_error2").show(100).delay(2000).hide(0);
				$("#validCode").val('');
				$("#validCode").focus();
			}
		}
	})
}

function setPass(){
	var password=$("#password").val();
	var repassword=$("#repassword").val();
	var _token = $("input[name='_token']").val();
	var verifyCode = $('#verifyCode').val();

	if(password==null || password == ""){
		//$("#passwordP").parent("label").find(".pass_y_find").show();
		//$("#passwordP").parent("label").find(".pass_y_find1").hide();
		layer.alert('密码不能为空', {title:false,btn:false});
	//}else if(!/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*?]+)$)^[\w~!@#$%\^&*?]{8,20}$/.test(password)){
	}else if(password.length<6 || password.length>16 ){
		//$("#passwordP").html("");
		layer.alert('密码长度为6-16位!', {title:false,btn:false});
		//$("#passwordP").show();
	}else if(repassword==null || repassword == ""){
		//$("#repasswordP").parent("label").find(".pass_y_find").show();
		//$("#repasswordP").parent("label").find(".pass_y_find1").hide();
		//$("#repasswordP").show();
		layer.alert('密码不能为空', {title:false,btn:false});
	}else if(repassword!=password){
		//$("#repasswordP").html("两次输入的密码不同！");
		//$("#repasswordP").show();
		layer.alert('两次输入的密码不同！', {title:false,btn:false});
	}else{
		$.ajax({
			type: "post",
			url: "/setPass",
			dataType:'json',
			data:{
				mobile:$('#mobile').val(),
				pass:$('#password').val(),
				verifyCode:verifyCode,
				_token:_token
			},
			success:function(data){
				if(data.status == 0){
					//$('#setPassMsg').show();
// 					var loginTime=3;
// 					$("#loginTime").html(loginTime);
// 					t2=setInterval(function() {
// 						loginTime--;
// 						$("#loginTime").html(loginTime);
// 						if (loginTime==0) {
// 							clearInterval(t2);
// 							window.location.href="/";
// 						}
// 					},1000);
					layer.alert('密码修改成功，3秒后跳转登陆页面...', {title:false,btn:false});
					setTimeout("window.location.href='/login'", 3000);
				}else{
					$('#setPassMsg').show();
					$("#setPassMsg").html("密码修改失败，请联系管理员");
				}
			}
		});
	}

}
</script>
</html>

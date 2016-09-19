$("#mobile").focus(function() {
	var mobile = $("#mobile").val();
	if (mobile == "请输入手机号") {
		$("#mobile").css({
			color : "#333"
		});
		$("#mobile").val('');
	}
});  
/* $(window).resize(function(){
	var widthL=$("body").width();
	 $(".add_car").css({left:(widthL-270)/2+"px"});
	 $(".c_add_ygqq").css({right:($("body").width()-130)/2+"px"});
});
$(window).resize(function(){
	$("#Contract").css({left:($(window).width()-$("#Contract").width())/2})
})
$(window).resize();
$("#smsCode").click(function(){
	if($(this).val()=="请输入短信验证码"){
		$(this).val("")
	}
});
$(".close").click(function(){
	$("#Contract").slideUp(600);
	$(".modal-backdrop").fadeOut();
})
$(".btn-primary").click(function(){
	$("#Contract").slideUp(600);
	$(".modal-backdrop").fadeOut();
}) 
if(code!=''){
	$("#registerCode").val(code).css({color:"#666"});
	$("#registerCode").attr("disabled","disabled");
}*/ 
$("#registerCode").focus(function() {
	$("#registerCode").css({
		color : "#333"
	});
	$("#registerCode").val('');
});
$("#mobile").blur(function() { 
	checkMobile();
});
//$("#smsCode").blur(function() {
//	if($("#smsCode").val()==""){
//		$("#smsCode").val("请输入短信验证码");
//	}
//});
$("#pas").focus(function(){
	$("#pas").hide();
	$("#password").show();
	$("#password").focus().css({
		color : "#333"
	});
});
$(".error_p").mouseover(function(){
	$(this).hide();
});
$("#password").blur(function(){
	checkPassWord();
});

$("#newpassword").blur(function(){
	if($(this).val() != $('#password').val()){
		myalert('两次输入密码不一致');
	}
});
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
			if(data.status == 0){
				flag = true;	
			}else{
				myalert('您手机号码已在特速集团旗下品牌一块购、全木行、链金所其中一个平台注册，请直接登录!', '#mobile');
				//$("#mobile").focus();
				//$("#mobile").css({border:"1px solid #E86969"})
	            //$("#mobile").next().css({background:"url(/foreground/img/false.png) no-repeat"});
				flag = false;
			}
		}
	});
	return flag;	
}
function doRegister(){
	if(!checkMobile()){
		return;
	}
	
	var captcha =$("#captcha").val();
	if(captcha == ''|| captcha == null){
        $("#captcha").css({border:"1px solid #E86969"});
        $("#captcha").siblings(".ygqq_i").css({background:"url(img/false.png) no-repeat"});
        myalert('请先点击完成验证');
		$("#captcha").focus();
        return false;
    } 
	
	if($('#smsCode').val()==""||$('#smsCode').val()=="请输入短信验证码"){
		myalert('请填写短信验证码！', '#smsCode');
		$('#smsCode').val("");
		//$("#smsCode").focus();
		return;
	}
	var registerCode = $('#registerCode').val();
	if(registerCode=='') registerCode='no';
	
	var _token = $("input[name='_token']").val();
	var index = layer.open({type: 2});
	$.ajax({
		type: "post",
		url: "/register_m",
		dataType:'json',
		data:{
			mobile :$("#mobile").val(),
			_token : _token,
			code:$('#smsCode').val(),
			registerCode:registerCode
			},
		success:function(data){
			if(data.status == 0){
				$('form').submit();
			}else{
				layer.close(index);
				myalert(data.msg);
			}
		}
	});
}

function regSubmit(){
	if(!checkPassWord()){
		return false;
	}
	
	var password = $('#password').val();
	var newpassword = $('#newpassword').val();
	var _token = $("input[name='_token']").val();
	
	if(password != newpassword){
		myalert('两次输入密码不一致');
		return false;
	}
	
	$.ajax({
		type: "post",
		url: "/regSubmit_m",
		dataType:'json',
		data:{
			newpassword:newpassword,
			password:password
			},
		success:function(data){
			if(data.status == 0){
				window.location.href = '/freeday_m';
			}else{
				myalert(data.msg);
			}
		}
	})
}

/*检查手机号*/
function checkMobile(){ 
	var mobile = $("#mobile").val();
	var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
	if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
		myalert('请输入手机号');
		//$("#mobile").css({border:"1px solid #E86969"});
        //$("#mobile").next().css({background:"url(/foreground/img/false.png ) no-repeat"});
		return false;
	} else if (!isMobile.test(mobile)) {
		//$("#mobile").focus();
		//$("#mobile").css({border:"1px solid #E86969"});
		myalert('手机号格式不正确！', '#mobile');
        $("#mobile").next().css({background:"url(/foreground/img/false.png) no-repeat"});
		return false;
	} else if (!checkMobileExist()) {
		return false;
	}else{
		//$("#mobile").css({border:"1px solid #0697DA"})
		//$("#mobile").next().css({background:"url(/foreground/img/true.png) no-repeat"});
		return true;
	}
}
/*检查密码*/
function checkPassWord(){  
	var password = $("#password").val();
	if( password =="登录密码" || password == "" ){
		//$("#password").css({border:"1px solid #E86969"});
		myalert('密码不能为空');
		return false;
	}else if(password.length<6 || password.length>16 ){
		//$("#password").css({border:"1px solid #E86969"});
		myalert('密码长度须为6-16位！');
		return false;
	}else{
		//$("#password").css({border:"1px solid #0697DA"});
		return true;
	}
}

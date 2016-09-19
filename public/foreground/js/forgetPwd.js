var canNext = false;//下一步是否可以点击
$(function(){
		// 2015 7 18
		$(".y_forget_list li").click(function(){
		$(".yg_for_boxss").css("display","none");
		$(".y_forget_list li").removeClass("for_cl_li");	
		$(this).addClass("for_cl_li");
		var index=$(".y_forget_list li").index(this);
		$(".yg_for_boxs").hide();
		$($(".yg_for_boxs")[index]).show();
		$(".get_ygqq1").css("display","block");
		$(".get_ygqq2").css("display","none");
		$(".get_ygqq3").css("display","none");
		$("#mobile").val("请输入手机号").css({color:"#c9c9cf"});
		$('#mobile').attr("disabled","");
		$("#emailInput").val("请输入邮箱号").css({color:"#c9c9cf"});
		$('#emailInput').attr("disabled","");
		$(".emailRight").hide();
		if(typeof(t)!="undefined"){
			clearInterval(t);
		}
		if(typeof(t2)!="undefined"){
			clearInterval(t2);
		}
	})
	$(window).resize(function(){
	  var widthL=$("body").width();
	  $(".add_car").css({left:(widthL-270)/2+"px"});
	  $(".c_add_ygqq").css({right:($("body").width()-130)/2+"px"});
	});
	$(window).resize();
   // 2015-6-19 end
//更换验证码
	$("#changeImg").click(function(){
		$("#captcha_img").trigger("click");
	})
//更换验证码
	$("#changeImgEmail").click(function(){
		$("#captcha_imgEmail").trigger("click");
	})
	//验证码输入框获得焦点
		$("#validCode").focus(function(){
			if($("#mobile").val()=="请输入手机号"||$("#mobile").val()==""){
				$("#mobile").focus();
				return;
			}
			$("#validCode").css({color:"#333"});
			$("#validCode").val('');
		})
		$("#validCode").blur(function(){
			if($("#validCode").val()==""){
				$("#validCode").val("验证码").css({color:"#c9c9cf"});
			}
		})
		$("#validCodeEmail").focus(function(){
			if($("#emailInput").val()=="请输入邮箱号"||$("#mobile").val()==""){
				$("#emailInput").focus();
				return;
			}
			$("#validCodeEmail").css({color:"#333"});
			$("#validCodeEmail").val('');
		})
		$("#validCodeEmail").blur(function(){
			if($("#validCodeEmail").val()==""){
				$("#validCodeEmail").val("验证码").css({color:"#c9c9cf"});
			}
		})
		$("#mobile").focus(function(){
			var mobile=$("#mobile").val();
			if(mobile =="请输入手机号"){
				$("#mobile").css({color:"#333"});
				$("#mobile").val('');
			}
		});
	$("#mobile").blur(function(){
		var mobile=$("#mobile").val();
		if(mobile ==""){
			$("#mobile").val('请输入手机号');
		}
	});
		$("#c").focus(function(){
			$("#mobile").focus();
		});
		
		$("#emailInput").focus(function(){
			var email=$("#emailInput").val();
			if(email =="请输入邮箱号"){
				$("#emailInput").css({color:"#333"});
				$("#emailInput").val('');
			}
		});
		$("#emailInput").blur(function(){
			var email=$("#emailInput").val();
			var isEmail = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
			if(email =="请输入邮箱号" || email == "" || email == null){
				$("#emailInput").val('请输入邮箱号').css({color:"#c9c9cf"});
				$('.emailError').html("请输入邮箱号");
				$('.emailError').show(100).delay(2000).hide(0);
			}else if(!isEmail.test(email)){
				$('.emailError').html("请正确填写邮箱号");
				$('.emailError').show(100).delay(2000).hide(0);
				$("#emailInput").focus();
			}else if(checkEmailExist()){
				$('#emailInput').attr("disabled","disabled")
				$(".emailRight").show();
			}
		});
		$("#code").focus(function(){
			$("#code").css({color:"#333"});
			$("#code").val('');
		});
		$("#code").blur(function(){
			if($("#code").val()==""){
				$("#code").val("验证码").css({color:"#c9c9cf"});
			}
		});
		$("#codeEmail").focus(function(){
			$("#codeEmail").css({color:"#333"});
			$("#codeEmail").val('');
		});
		$("#codeEmail").blur(function(){
			if($("#codeEmail").val()==""){
				$("#codeEmail").val("验证码").css({color:"#c9c9cf"});
			}
		});
		
//密码输入框
$(".pass_y_find1").focus(function(){
	$(this).hide();
	$(this).parent("label").find(".pass_y_find").show().focus().css({color:"#333"});
});
//第一个密码框
$("#password").blur(function(){
	var password=$(this).val();
	if(password==null || password == ""){
		$(this).hide();
		$(this).parent("label").find(".pass_y_find1").show();
	}else if(!/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*?]+)$)^[\w~!@#$%\^&*?]{8,20}$/.test(password)){
		$("#passwordP").html("长度为8到20位,须包含英文、数字!");
		$("#passwordP").show();
	}
});
//第二个密码框
$("#repassword").blur(function(){
	var password=$("#password").val();
	var repassword=$(this).val();
	if(repassword==null || repassword == ""){
		$(this).hide();
		$(this).parent("label").find(".pass_y_find1").show();
	}else if(repassword!=password){
		$("#repasswordP").html("两次输入的密码不同！");
		$("#repasswordP").show();
	}
});
//密码错误提示
$('.c_error2').mouseover(function(){
	$(this).hide();
	$(this).parent("label").find(".pass_y_find").show().focus().css({color:"#333"});
});
})
//校验手机号存在	
function checkMobileExist(){return true;
	var flag = false;
	$.ajax({
		type: "post",
		url: "/api/uc/checkMobileExist.do",
		dataType:'json',
		async: false,
		data:{
			mobile :$("#mobile").val()
			},
		success:function(data){
			if(data.status == true){
				$(".mobileError").html("该手机号还没有注册！")
				$(".mobileError").show(100).delay(2000).hide(0);
				$("#mobile").focus();
				return flag;
			}else if(data.status == false){
				if(data.msg.indexOf("已被使用")>-1){
					$('#mobile').attr("disabled","disabled")
					flag = true;
					return flag;
				}else{
					$(".mobileError").html(data.msg)
					$(".mobileError").show(100).delay(2000).hide(0);
					$("#mobile").focus();
					return flag;
				}
			}
		}
	});
	return flag;	
}
//校验邮箱存在	
function checkEmailExist(){
	var flag = false;
	$.ajax({
		type: "post",
		url: "/api/uc/checkEmailExist.do",
		dataType:'json',
		async: false,
		data:{
			email :$("#emailInput").val()
		},
		success:function(data){
			if(data.status == true){
				flag = true;
				return flag;
			}else if(data.status == false){
				$(".emailError").html("此邮箱不可用！")
				$(".emailError").show(100).delay(2000).hide(0);
				$("#emailInput").focus();
				return flag;
			}
		}
	});
	return flag;	
}
	//检验图片验证码
	function checkValidCode(){
		var mobile=$("#mobile").val();
		var isMobile=/^0?1[3-8][0-9]\d{8}$/; //手机号码验证规则
		if(mobile =="请输入手机号" || mobile == "" || mobile == null){
			$('.mobileError').html("请填写手机号");
			$('.mobileError').show(100).delay(2000).hide(0);
			$('.true_yg_p').hide();
			$("#mobile").focus();
			return;
		}else if(!isMobile.test(mobile)){
			$("#mobile").focus();
			$('.mobileError').html("请正确填写手机号");
			$('.mobileError').show(100).delay(2000).hide(0);
			$('.true_yg_p').hide();
			return;
		}else if(checkMobileExist()){
			$.ajax({
				type: "post",
				url: "/api/uc/checkValidCodeForPwd.do",
				dataType:'json',
				async: false,
				data:{
					validCode :$("#validCode").val(),
					mobile :$("#mobile").val(),
				},
				success:function(data){
					if(data.status == true){
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
					}else if(data.status == false){
						if(data.msg){
							$(".code_error2").html(data.msg);
						}
						$("#captcha_img").trigger("onclick");
						$(".code_error2").show(100).delay(2000).hide(0);
						$("#validCode").val('');
						$("#validCode").focus();
					}
				}
			});
		}
	}
	//检验图片验证码(邮箱)
	function checkCodeEmail(){
		var email=$("#emailInput").val();
		var isEmail = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		if(email =="请输入邮箱号" || email == "" || email == null){
			$("#emailInput").val('请输入邮箱号').css({color:"#c9c9cf"});
			return;
		}else if(!isEmail.test(email)){
			$('.emailError').html("请正确填写邮箱号");
			$('.emailError').show(100).delay(2000).hide(0);
			$("#emailInput").focus();
			return;
		}else if(checkEmailExist()){
			$.ajax({
				type: "post",
				url: "/api/uc/checkValidCodeForPwdEmail.do",
				dataType:'json',
				async: false,
				data:{
					validCode :$("#validCodeEmail").val(),
					email :$("#emailInput").val(),
				},
				success:function(data){
					if(data.status == true){
						canNext = true;
						$(".get_ygqq2").hide();
						$(".get_ygqq3").css("display","block");
						$(".yg_true").css("background","#dd2726");
						var code=$(".get_ygqq3").find("span em");
						timeEmail=300;
						code.html(timeEmail);
						t=setInterval(function() {
							timeEmail--;
							code.html(timeEmail);
							if (timeEmail==0) {
								clearInterval(t);
								canNext = false;
								$(".get_ygqq3").css("display","none");
								$(".get_ygqq1").css("display","block");
								$("#captcha_img").trigger("onclick");
							}
						},1000);
					}else if(data.status == false){
						$("#captcha_img").trigger("onclick");
						$(".code_error2").show(100).delay(2000).hide(0);
						$("#validCode").val('');
						$("#validCode").focus();
					}
				}
			});
		}
	}
	//验证码显示
	function get_yg1(){
		var mobile=$("#mobile").val();
		var isMobile=/^0?1[3-8][0-9]\d{8}$/; //手机号码验证规则
		if(mobile =="请输入手机号" || mobile == "" || mobile == null){
			$('.mobileError').html("请填写手机号");
			$('.mobileError').show(100).delay(2000).hide(0);
			$('.true_yg_p').hide();
			$("#mobile").focus();
			return;
		}else if(!isMobile.test(mobile)){
			$('.mobileError').html("请正确填写手机号");
			$('.mobileError').show(100).delay(2000).hide(0);
			$('.true_yg_p').hide();
			$("#mobile").focus();
			return;
		}else if(checkMobileExist()){
			$(".get_ygqq1").hide();
			$(".get_ygqq2").css("display","block");
			$("#captcha_img").trigger("click");
		}
	}
	//验证码显示
	function get_yg1Email(){
		var email=$("#emailInput").val();
		var isEmail = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		if(email =="请输入邮箱号" || email == "" || email == null){
			$("#emailInput").val('请输入邮箱号').css({color:"#c9c9cf"});
			return;
		}else if(!isEmail.test(email)){
			$('.emailError').html("请正确填写邮箱号");
			$('.emailError').show(100).delay(2000).hide(0);
			$("#emailInput").focus();
			return;
		}else if(checkEmailExist()){
			$(".get_ygqq1").hide();
			$(".get_ygqq2").css("display","block");
			$("#captcha_imgEmail").trigger("onclick");
		}
	}
	//下一步
	function next(){
		if($("#code").val()!="验证码"&&canNext){
			$.ajax({
				type: "post",
				url: "/api/uc/checkCode.do",
				dataType:'json',
				async: false,
				data:{
					mobile :$("#mobile").val(),
					code :$("#code").val()
				},
				success:function(data){
					if(data.status == true){
						$(".yg_for_boxs").hide();
						$(".yg_for_boxss").show();
					}else {
						$(".code_error3").html(data.msg);
						$(".code_error3").show(100).delay(2000).hide(0);
					}
				}
			});
		}else{
			$("#code").val("请输入验证码")
		}
	}
	//下一步
	function nextEmial(){
		if($("#codeEmail").val()!="验证码"&&canNext){
			$.ajax({
				type: "post",
				url: "/api/uc/checkCodeToEmail.do",
				dataType:'json',
				async: false,
				data:{
					email :$("#emailInput").val(),
					code :$("#codeEmail").val()
				},
				success:function(data){
					if(data.status == true){
						$(".yg_for_boxs").hide();
						$(".yg_for_boxss").show();
					}else {
						$(".code_error3").html(data.msg);
						$(".code_error3").show(100).delay(2000).hide(0);
					}
				}
			});
		}else{
			$("#code").val("请输入验证码")
		}
	}
	function setPass(){
			var password=$("#password").val();
			var repassword=$("#repassword").val();
			if(password==null || password == ""){
				$("#passwordP").parent("label").find(".pass_y_find").show();
				$("#passwordP").parent("label").find(".pass_y_find1").hide();
				$("#passwordP").show();
			}else if(!/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*?]+)$)^[\w~!@#$%\^&*?]{8,20}$/.test(password)){
				$("#passwordP").html("长度为8到20位,须包含英文、数字!");
				$("#passwordP").show();
			}else if(repassword==null || repassword == ""){
				$("#repasswordP").parent("label").find(".pass_y_find").show();
				$("#repasswordP").parent("label").find(".pass_y_find1").hide();
				$("#repasswordP").show();
			}else if(repassword!=password){
				$("#repasswordP").html("两次输入的密码不同！");
				$("#repasswordP").show();
			}else{
				$.ajax({
					type: "post",
					url: "/api/uc/setPass.do",
					dataType:'json',
					data:{
						email:$('#emailInput').val(),
						mobile:$('#mobile').val(),
						pass:$('#password').val()
					},
					success:function(data){
						if(data.status){
							$('#setPassMsg').show();
							var loginTime=3;
							$("#loginTime").html(loginTime);
							t2=setInterval(function() {
								loginTime--;
								$("#loginTime").html(loginTime);
								if (loginTime==0) {
									clearInterval(t);
									window.location.href="/api/uc/login.do";
								}
							},1000);
						}else{
							$('#setPassMsg').show();
							$("#setPassMsg").html("重置失败，请联系管理员");
						}
					}
				});
		}
	}
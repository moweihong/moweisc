$(function(){
    //推荐人
    recommended();
	function recommended(){              
        var num=0
        $(".ygqq_register_text1").click(function(){
          if(num%2==0){
            $(".ygqq_register_text1 a b").html("收起");
            $(".ygqq_register_xz").slideDown();
          }
          else{
            $(".ygqq_register_text1 a b").html("选填");
            $(".ygqq_register_xz").slideUp();
          } 
          num++;
        }) 
      }
	
      //注册获取验证码
		$(".ygqq_register_dx_a").click(function(){
			if(!validCode){
				return
			}
            var statueCode =$("#statueCode").val();
			var mobile = $("#mobile").val();
			var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
			if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
				$("#mobile").css({border:"1px solid #E86969"})
		        $("#mobile").siblings(".ygqq_i").css({background:"url(img/false.png) no-repeat"});
				$("#mobile").focus();
				return ;
			} else if (!isMobile.test(mobile)) {
				$("#mobile").focus();
				$("#mobile").css({border:"1px solid #E86969"})
		        $("#mobile").siblings(".ygqq_i").css({background:"url(img/false.png) no-repeat"});
                layer.tips('手机号格式不正确！', '#mobile');
				$("#mobile").focus();
				return ;
			} 
            if(statueCode == ''|| statueCode == null){
                layer.msg('非法操作');
                location.href = '/login';
                return false;
            }            
			sendVerifyCode(mobile);//发送短信验证码	
		});
		

		$(".register_img_close").click(function(){
			$(".ygqq_float").css({display:"none"});
			$(".register_img_con").css({display:"none"});
		})

        //协议
        //鼠标滑过显示提示
        $(".ygqq_register_xy").hover(function(){
            $(".b_login_btn_xy").css({display:"block"})
        },function(){
        	$(".b_login_btn_xy").css({display:"none"})
        })

        //点击出现协议
        $(".ygqq_register_xy a").click(function(){
        	//wx_login();
        	$("#b_Contract").css({display:"block"});
        	$(".ygqq_float").css({display:"block"});
        })
 
        //点击关闭协议
        $(".b_close1").click(function(){
        	$("#b_Contract").css({display:"none"});
        	$(".ygqq_float").css({display:"none"});
        })
        //点击关闭协议
        $(".b_btn-primary").click(function(){
        	$("#b_Contract").css({display:"none"});
        	$(".ygqq_float").css({display:"none"});
        })
        //点击注册
        $(".ygqq_register_xy button").click(function(){
        	doRegister();
        })

})
 
//注册时获取验证码倒计时
var validCode=true;    //获取验证码倒计时变量
var time=120;
function get_code(obj,obj2){
        if (validCode) {
            validCode=false;
            var t=setInterval(function  () {
            time--;
                obj.html(time);
                if (time==0) {
                    clearInterval(t);
                   // obj2.html("重新获取");
					$("#getcode2").css({display:"none"});
					$("#getcode").css({display:"block"});
                    validCode=true;
                    time=120;
                }
            },1000)
        }
}

function sendVerifyCode(mobile){
	var _token = $("input[name='_token']").val();
	var statueCode =$("#statueCode").val();
	$.ajax({
		url: '/mobileSendCode',
		type: 'post',
		dataType: 'json',
		data: {_token:_token,mobile:mobile,statueCode:statueCode},
		success: function(res){
			if(res.status == 0){
				layer.alert('验证码发送成功！');
                $(".ygqq_register_dx_a").css({display:"none"});
                $("#getcode2").css({display:"block"});
                $("#getcode2").html("<em class='ygqq_login_dx_time'>120</em>秒后重新获取");		
                get_code($(".ygqq_login_dx_time"),$('#getcode2'));
			}else{
				layer.alert(res.message);
			}
		}
	})
}

$("#mobile").blur(function() { 
	checkMobile();
});

$(".error_p").mouseover(function(){
	$(this).hide();
});
$("#password").blur(function(){
	checkPassWord();
});
//校验手机号存在	
function checkMobileExist(){
	var flag = false;
	var _token = $("input[name='_token']").val();
	var bind_type = $("#bind_type").val();
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
                if(bind_type == 1){
                    layer.tips('您的手机号码未注册！', '#mobile');
                    $("#mobile").focus();
                    $("#mobile").css({border:"1px solid #E86969"})
                    $("#mobile").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png) no-repeat"});
                    flag = false;
                }else{
                    flag = true;
                }
			}else{
				if(bind_type == 1){
                    flag = true;
                }else{
                    layer.tips('您手机号码已在特速集团旗下品牌一块购、全木行、链金所其中一个平台注册，请点击“已有一块购账号”进行绑定！', '#mobile');
                    $("#mobile").focus();
                    $("#mobile").css({border:"1px solid #E86969"})
                    $("#mobile").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png) no-repeat"});
                    flag = false;
                }
			}
		}
	});
	return flag;	
}
function bindUser(){
	if(!checkMobile()){
		return;
	}
	var smsCode =$("#smsCode").val();
	var mobile = $("#mobile").val();
    var _token = $("input[name='_token']").val();
	if(smsCode == ''|| smsCode == null || smsCode.length != 6){
        $("#smsCode").css({border:"1px solid #E86969"});
        $("#smsCode").siblings(".ygqq_i").css({background:"url(img/false.png) no-repeat"});
        layer.tips('请输入6位数字验证码！', '#smsCode');
        $("#smsCode").focus();
        return false;
    }	
    $.ajax({
        type: "post",
        url: "/binduser",
        dataType:'json',
        data:{
            mobile :$("#mobile").val(),
            _token : _token,
            code:smsCode,
        },
        success:function(data){
            if(data.status == 0){
                layer.msg('绑定成功！');
                window.location.href = typeof(data.refer) == 'undefined' ? '/index' : data.refer;
            }else{
                layer.alert(data.msg);
            }
        }
    });
}
/*检查手机号*/
function checkMobile(){ 
	var mobile = $("#mobile").val();
	var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
	if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
		//$("#mobile").val("请输入手机号")
		$("#mobile").css({border:"1px solid #E86969"});
        $("#mobile").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png ) no-repeat"});
		return false;
	} else if (!isMobile.test(mobile)) {
		$("#mobile").focus();
		$("#mobile").css({border:"1px solid #E86969"});
		layer.tips('手机号格式不正确！', '#mobile');
        $("#mobile").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png) no-repeat"});
		return false;
    }else{
		$("#mobile").css({border:"1px solid #0697DA"})
		$("#mobile").siblings(".ygqq_i").css({background:"url(/foreground/img/true.png) no-repeat"});
		return true;
	}
}
/*检查密码*/
function checkPassWord(){  
	var password = $("#password").val();
	if( password =="登录密码" || password == "" ){
		//$("#password").hide();
		$("#password").css({border:"1px solid #E86969"})
        $("#password").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png) no-repeat"});
		//$("#pas").show();
		return false;
	}else if(password.length<6 || password.length>16 ){
		$("#password").css({border:"1px solid #E86969"})
        $("#password").siblings(".ygqq_i").css({background:"url(/foreground/img/false.png) no-repeat"});
		layer.tips('密码长度须为6-16位！', '#password');
		return false;
	}else{
		$("#password").css({border:"1px solid #0697DA"})
		$("#password").siblings(".ygqq_i").css({background:"url(/foreground/img/true.png) no-repeat"});
		return true;
	}
}

$(function(){

      //注册获取验证码
		$(".code_btn").click(function(){
			if(!validCode){
				return
			}
            var statueCode =$("#statueCode").val();
			var mobile = $("#mobile").val();
			var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
			if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
				$("#mobile").css({border:"1px solid #E86969"})
		        $("#mobile").next().css({background:"url(img/false.png) no-repeat"});
				$("#mobile").focus();
				return ;
			} else if (!isMobile.test(mobile)) {
				$("#mobile").focus();
				$("#mobile").css({border:"1px solid #E86969"})
		        $("#mobile").next().css({background:"url(img/false.png) no-repeat"});
				$("#mobile").focus();
				return ;
			} 
            if(statueCode == ''|| statueCode == null){
                myalert('非法操作');
                return false;
            }   

			sendVerifyCode(mobile);//发送短信验证码	
		});

})
 
//注册时获取验证码倒计时
var validCode=true;    //获取验证码倒计时变量
var time=120;
function get_code(){
        if (validCode) {
            validCode=false;
            var t=setInterval(function  () {
            time--;
                $('.code_btn').val(time+"秒");
                if (time==0) {
                    clearInterval(t);
                   $('.code_btn').val("获取验证码");
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
		url: '/mobileSendCode_m',
		type: 'post',
		dataType: 'json',
		data: {_token:_token,mobile:mobile,statueCode:statueCode},
		success: function(res){
			if(res.status == 0){
				myalert('验证码发送成功！');
                $(".code_btn").val("120秒");
                get_code();
			}else{
				myalert(res.message);
                if(res.status == -1){
                    capRefresh();
                    $("#captcha").val('');
                }
			}
		}
	})
}

$("#mobile").blur(function() { 
	checkMobile();
});
function doBindUser(){
	if(!checkMobile()){
		return;
	}
	
	var statueCode =$("#statueCode").val();
	if(statueCode == ''|| statueCode == null){
        myalert('非法操作');
        return false;
    } 
	var smsCode =$("#smsCode").val();
    var _token = $("input[name='_token']").val();
	if(smsCode == ''|| smsCode == null || smsCode.length != 6){
        myalert('请输入6位数字验证码！', '#smsCode');
        $("#smsCode").focus();
        return false;
    }	
	var index = layer.open({type: 2});
	$.ajax({
		type: "post",
		url: "/bindUser_m",
		dataType:'json',
		data:{
			mobile :$("#mobile").val(),
			_token : _token,
			code:smsCode,
			},
		success:function(data){
			if(data.status == 0){
                myalert('绑定成功！');
                window.location.href = typeof(data.refer) == 'undefined' ? '/index_m' : data.refer;
			}else{
				layer.close(index);
                myalert(data.msg);
			}
		}
	});
}

/*检查手机号*/
function checkMobile(){ 
	var mobile = $("#mobile").val();
	var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
	if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
        $("#mobile").focus();
		myalert('请输入手机号');
		return false;
	} else if (!isMobile.test(mobile)) {
		$("#mobile").focus();
		myalert('手机号格式不正确！', '#mobile');
        $("#mobile").next().css({background:"url(/foreground/img/false.png) no-repeat"});
		return false;
	} else{
		return true;
	}
}

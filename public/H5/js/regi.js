$(function(){
//	$(".qq_form").submit(function(e){
//	    e.preventDefault();
//	    //alert("表单阻止提交了");
//	  }); 
	//登录表单切换
//	$(".ygqq_login_link li").click(function(){
//		$(".ygqq_login_link li").removeClass("ygqq_link_active");
//		$(this).addClass("ygqq_link_active");
//		var index=$(this).index(".ygqq_login_link li") 
//		$(".ygqq_login_form form").css({display:"none"});
//		$($(".ygqq_login_form form")[index]).css({display:"block"});
//	})

    /*/微信登录
    $(".ygqq_wx_all").click(function(){
    	wx_login();
    	$(".ygqq_float").css({display:"block"})
    	$(".ygqq_float_con").css({display:"block"})
    })*/

    //关闭微信登录
//    $(".ygqq_float_right").click(function(){
//    	$(".ygqq_float").css({display:"none"});
//    	$(".ygqq_float_con").css({display:"none"});
//    })

    //关闭QQ
//    $(".ygqq_float_close").click(function(){
//    	$(".ygqq_float").css({display:"none"});
//    	$(".ygqq_float_qq_con").css({display:"none"});
//    })

    //居中显示
//    function wx_login(){
//		$(".ygqq_float_con").css({left:($(window).width()-$(".ygqq_float_con").width())/2,
//			                      top:($(window).height()-$(".ygqq_float_con").height())/2});
//		$(".ygqq_float_qq_con").css({left:($(window).width()-$(".ygqq_float_qq_con").width())/2,
//			                      top:($(window).height()-$(".ygqq_float_qq_con").height())/2});
//		$(".register_img_con").css({left:($(window).width()-$(".register_img_con").width())/2,
//			                      top:($(window).height()-$(".register_img_con").height())/2});
//		$("#b_Contract").css({left:($(window).width()-$("#b_Contract").width())/2,
//			                      top:($(window).height()-$("#b_Contract").height())/2});
//		$(window).resize(function(){
//			$(".ygqq_float_con").css({left:($(window).width()-$(".ygqq_float_con").width())/2,
//			                      top:($(window).height()-$(".ygqq_float_con").height())/2});
//			$(".ygqq_float_qq_con").css({left:($(window).width()-$(".ygqq_float_qq_con").width())/2,
//			                      top:($(window).height()-$(".ygqq_float_qq_con").height())/2});
//		    $("#b_Contract").css({left:($(window).width()-$("#b_Contract").width())/2,
//			                      top:($(window).height()-$("#b_Contract").height())/2});
//		})
//	}


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
	
	//短信登录获取验证码
/* 	$(".ygqq_login_dx_a1").click(function(){
		$(".ygqq_form_dx_one").css({display:"none"});
		$(".ygqq_form_dx_two").css({display:"block"});
		$(".ygqq_dx_later_btn").click(function(){
			$(".ygqq_login_dx_a1").html("<em class='ygqq_login_dx_time'>116</em>秒后重新获取");
            get_code($(".ygqq_login_dx_time"));
            $(".ygqq_form_dx_one").css({display:"block"});
            $(".ygqq_form_dx_two").css({display:"none"});
		});
	}) */

      //注册获取验证码
		$(".ygqq_register_dx_a").click(function(){
			if(!validCode){
				return
			}
            var captcha =$("#captcha").val();
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
            if($("#password").length>0){
                if(!checkPassWord()){
                    return false;
                }
            }
            if(captcha == ''|| captcha == null){
                $("#captcha").css({border:"1px solid #E86969"});
                $("#captcha").siblings(".ygqq_i").css({background:"url(img/false.png) no-repeat"});
                myalert('请先点击完成验证');
				$("#captcha").focus();
                return false;
            }   

			sendVerifyCode(mobile);//发送短信验证码	
		});
		

		$(".register_img_close").click(function(){
			$(".ygqq_float").css({display:"none"});
			$(".register_img_con").css({display:"none"});
		})
		
		 



		/*/错误提示信息
        $("input[class!='ygqq_xt']").blur(function(){
        	if($(this).val() ==""){       
            $(this).css({border:"1px solid #E86969"})
            $(this).next().css({background:"url(img/false.png) no-repeat"});
          }
          else{
            $(this).css({border:"1px solid #0697DA"})
            $(this).next().css({background:"url(/static/userCenter/newImages/true.png) no-repeat"});         
            }
        })*/

  
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
                    capRefresh();
                    $("#captcha").val('');
                    validCode=true;
                    time=120;
                }
            },1000)
        }
}

function sendVerifyCode(mobile){
	var _token = $("input[name='_token']").val();
	var captcha =$("#captcha").val();
	$.ajax({
		url: '/regverify_m',
		type: 'post',
		dataType: 'json',
		data: {_token:_token,mobile:mobile,captcha:captcha},
		success: function(res){
			if(res.status == 0){
				myalert('验证码发送成功！');
                $(".ygqq_register_dx_a").css({display:"none"});
                $("#getcode2").css({display:"block"});
                $("#getcode2").html("<em class='ygqq_login_dx_time'>120</em>秒后重新获取");		
                get_code($(".ygqq_login_dx_time"),$('#getcode2'));
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
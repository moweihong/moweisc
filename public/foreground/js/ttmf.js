function isloadImg(url){
    var img=new Image();
    img.src=url;
    return img.complete;
}
$(document).ready(function(){
    var a =isloadImg('../../foreground/img/ttmf_bg03.jpg');
    var s= setInterval(function(){
        if(isloadImg('../../foreground/img/ttmf_bg03.jpg')&&isloadImg('../../foreground/img/tiger_machine.png')){
            loadAnimation();
            clearInterval(s);
        }else{
            var img=new Image();
            img.src='../../foreground/img/ttmf_bg03.jpg';
            img.onload=function(){
                var img1=new Image();
                img1.src='../../foreground/img/tiger_machine.png';
                img1.onload=function(){
                    loadAnimation();
                    clearInterval(s);
                }
            }
        }
    },500);
});

function loadAnimation(){
    $(".gold_packet").show();
    setTimeout(function () {
        $(".gold_explode").show();
        setTimeout(function () {
            $(".light_bg").show();//一束光出现
            setTimeout(function () {
                $(".explode").show();//光团出现，1s放大动画
                setTimeout(function () {
                    $(".qiang_bg").show();//2s后抢红包横幅出现，2s放大动画
                    setTimeout(function () {
                        $(".light_bg,.explode,.gold_packet").fadeOut();//500ms后光团消失
                        setTimeout(function () {
                            $("#tiger_machine_container").show();
                            setTimeout(function () {
                                $(".join_btn_normal").show();
                                setTimeout(function () {
                                    $(".finger_bg").show();//手指点击动画效果
                                    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
                                    if (userAgent.indexOf("Firefox") > -1 || (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && userAgent.indexOf("Opera") == -1)) {//火狐和ie的判断
                                        var i = 0;
                                        var d = setInterval(function () {
                                            if ($(".finger_bg").attr("class").indexOf("finger_bg_down") == -1) {
                                                $(".finger_bg").addClass("finger_bg_down");
                                            } else {
                                                $(".finger_bg").removeClass("finger_bg_down");
                                            }
                                            setTimeout(function () {
                                                if ($(".join_btn_normal").attr("class").indexOf("join_btn_click") == -1) {
                                                    $(".join_btn_normal").addClass("join_btn_click");
                                                } else {
                                                    $(".join_btn_normal").removeClass("join_btn_click");
                                                }
                                            }, 30);
                                            if (i++ > 3) {
                                                clearInterval(d);
                                            }
                                        }, 100);
                                    }
                                    setTimeout(function () {
                                        $(".finger_bg").hide();
                                        $(".rule_container").show();
                                    }, 500);
                                }, 1000);
                            }, 300);
                        }, 500);
                    }, 400);
                }, 50);
            }, 250);
        }, 50);
    }, 1150);
}


$("#invite_btn").click(function () {
    $(".share_content").show();
    $(".money_not_enough").css({
        "height": "478px"
    });
	 $(".fenxiang").show();

});

$("#close_moneyNotEnough").click(function(){
	$(".money_not_enough").hide();
	$(".all_grey_bg").hide();
});

$(".all_grey_bg").click(function () {
    if($(".announce_rule_alert").is(":hidden")&&$(".award_result").is(":hidden")){
        $(this).hide();
    }
    $(".money_not_enough").hide();
    //$(".announce_rule_alert").hide();
    $(".login_alert").hide();
   // $(".award_result").hide();
    $(".receive_success").hide();
    $(".receive_fail").hide();
});
$(".all_white_bg").click(function () {
    $(this).hide();
    $(".process_bar_alert").hide();
    $(".receive_success").hide();
});

$(".announce_rule,.rule-btn").click(function () {
    $(".all_grey_bg").show();
    $(".announce_rule_alert").show();
});
//$(".award_result a").click(function(){
//    $(".award_result").hide();
//    $(".all_grey_bg").hide();
//    $(".announce_rule_alert").hide();
//});
$(".close_btn1, .receive_confirm_btn2, .out_of_goods_btn").click(function(){
	$(this).parent().parent().hide();
	$(".all_grey_bg").hide();
});

$(".reg_success>a").click(function(){
	$(this).parent().hide();
	$(".all_grey_bg").hide();
});
$(".invite_friend_con").click(function () {
	var li_obj = $(this).parents('li');
	var total_invite = li_obj.find('.total_invite').text();
	var total_need = li_obj.find('.total_need').text();
	var width = li_obj.find('.width').val();
	var title = li_obj.find('.invite_title').text();

	$('.last_invite').text(total_need - total_invite);
	$('.process_bar01').css('width', width);
	$('.join_percentage label').text(total_invite + '/' + total_need);
	$('.invite_goods_title').text(title);

    $(".all_white_bg").show();
    $(this).parent().append($(".process_bar_alert"));
    $(".process_bar_alert").show();
});

var invite_g_id = 0;
$('.invite_friend_success').click(function(){
	if(kl_flag != -1){
		$('.receive_confirm').show();
		$(".all_grey_bg").show();
		invite_g_id = $(this).attr('g_id');
	}
})

$('.receive_confirm_btn').click(function(){
	$('.receive_confirm').hide();
	$(".all_grey_bg").hide();
	//领取成功
	$.ajax({
		url: '/freeday/inviteExchange',
		type: 'post',
		dataType: 'json',
		data: {g_id:invite_g_id,_token:_token},
		success: function(res){
			if(res.status == 0){
//				$(".receive_success").find('.congratulate_success').text(res.message);
//				$(".receive_success").show();
				$(".receive_confirm_new").show();
				$(".all_grey_bg").show();
				setTimeout(function(){window.location.reload();}, 2000);
			}else if(res.status == -3){
				$('.out_of_goods').show();
				$(".all_grey_bg").show();
			}else{
				$(".receive_fail").find('.congratulate_success').text(res.message);
				$(".receive_fail").show();
				$(".all_grey_bg").show();
			}
		}
	})
})

$('.invite_friend_login').click(function(){
	login_alert();
	return;
})

//$(".invite_friend").click(function () {
//    $(".all_white_bg").show();
//    $(".invite_3").show();
//});

var running_flag=false;//判断是否正在执行完老虎机
//开奖倒计时
var mm;//定时器开始分钟
var ss;//定时器开始秒数
//var sss;//定时器开始毫秒数
var minus;//2分钟内（120秒）40秒停一个数字 所以三个数字停止的时间分别为40、80、120
var startDate;
var isImmediate=false;
var canGet = false;
var is_prize = false;
var is_first_lottery = 0;
function timer() {
    var nowDate = new Date();//时间实例
    var leftTime=nowDate.getTime() - startDate.getTime();
    var passSecond = parseInt(leftTime/1000);
    var day1=Math.floor(passSecond/(60*60*24));
    var hour=Math.floor((passSecond-day1*24*60*60)/3600);
    var minute=Math.floor((passSecond-day1*24*60*60-hour)/60);
    var second=Math.floor(passSecond-day1*24*60*60-hour-minute*60);
    var millSecond= leftTime<1000?leftTime:leftTime-passSecond*1000;
    var showMinute=mm-minute;
    var showSecond=ss-second;
    var showMillSecond=10-parseInt((millSecond+"").substr(0,1));
   // console.log("shominute:"+showMinute+"showMil"+showSecond)
    if(showSecond<0){
        showSecond=showSecond+60;
        showMinute--;
        if(showMinute<0){
            $(".clock_div i").eq(0).html("<span>0</span><span>0</span>");
            $(".clock_div i").eq(1).html("<span>0</span><span>0</span>");
            $(".clock_div i").eq(2).html("<span>0</span><span>0</span>");
            clearInterval(clock);
            setTimeout(function () {
                $(".all_grey_bg").show();
                var result1 = Math.round(-parseInt($(".p_div").eq(0).css("top")) / single_top);
                var result2 = Math.round(-parseInt($(".p_div").eq(1).css("top")) / single_top);
                var result3 = Math.round(-parseInt($(".p_div").eq(2).css("top")) / single_top);
                
                $.ajax({
                    url:'/freeday/getNum',
                    type: 'post',
                    //async: false,
                    dataType: 'json',
                    data: {_token:_token,log:log},
                    success: function(res){
                        if(res.status == 0){
                            //状态更新
                        }
                    }
                })
                
                if (is_prize) {
                	$(".award_result").removeClass("not-winning2");
                    $(".award_result").addClass("winning");
                }else{
                    $(".award_result").removeClass("winning");
                    if(is_first_lottery != 1){
                    	$(".award_result").addClass("not-winning2");
                    }
                }
                running_flag=false;
                $(".award_result").show();
                $(".clock").hide();
                $(".join_btn_normal").css({"visibility":"visible"});
            }, 1000);
            return;
        }
    }
    showMinute=showMinute+"";
    showSecond=showSecond+"";
    $(".clock_div i span").eq(0).html(showMinute<10?"0":showMinute.substring(0,1));
    $(".clock_div i span").eq(1).html(showMinute<10?showMinute:showMinute.substring(1,2));
    $(".clock_div i span").eq(2).html(showSecond<10?"0":showSecond.substring(0,1));
    $(".clock_div i span").eq(3).html(showSecond<10?showSecond:showSecond.substring(1,2));
    $(".clock_div i span").eq(4).html("0");
    $(".clock_div i span").eq(5).html(showMillSecond);

}




var clock;
var single_top = 196;//单个p元素的相对高度
var num = 10;//产生多少个数字

var scroll = $(this).ScrollNum({
    single_top:single_top,
    num:num
});
var speed=single_top / 4;

$("#hand_shank,#join_btn_normal").click(function () {
	if(kl_flag == -1){
    	//login_alert();
    	window.location.href = '/login';
    	return false;
    }

    if(kl_flag == 0){
    	$(".money_not_enough").show();
		$(".all_grey_bg").show();
    	return false;
    }
    
    if(is_first == 0){
    	$('.qiang_confirm').show();
        $(".all_grey_bg").show();
    }else{
    	is_first = 0;
    	$('.qiang_confirm_btn').click();
    }
})

$('.qiang_confirm_btn').click(function(){
	$('.qiang_confirm').hide();
	$(".all_grey_bg").hide();
	
	$("#hand_shank").addClass("hand_shank_02");
	running_flag=true;
    var before_top = parseInt($(".p_div").eq(2).css("top"));
    var after_top;
    
	window.onbeforeunload = function() {
        if(running_flag){
            return "倒计时未结束离开页面，抽奖结果将不会保存！";
        }
    }
    
    var system = true;
    var error_msg = '';
    var muti_kl_flag = false;
    if (kl_flag == 1) {
        $.ajax({
            url: '/freeday/checkBean',
            type: 'post',
            async: false,
            dataType: 'json',
            data: {_token:_token},
            success: function (res) {
                if (res.status == 0) {
                    $('#kl_bean').text(res.data.kl_bean);
                    $('.not_enough').text(res.data.kl_bean);
                    is_prize = res.data.is_prize;
                    if (res.data.kl_bean >= 100) {
                        kl_flag = 1;
                    } else {
                        kl_flag = 0;
                    }
                    canGet = true;
                    
                    one = res.data.one;
                    two = res.data.two;
                    three = res.data.three;
                    log = res.data.log;
                    is_first_lottery = res.data.is_first_lottery;
                    
                    muti_kl_flag = true;
                } else if(res.status == -1){
                	$('#kl_bean').text(res.data);
                    $('.not_enough').text(res.data);
                    is_prize = false;
                    kl_flag = 0;
                    is_first_lottery = 0;
                    canGet = false;
                }else{
                	is_prize = false;
                	canGet = false;
                	system = false;
                	is_first_lottery = 0;
                	error_msg = res.message;
                }
            }
        })
    }
    
    if(!muti_kl_flag){
    	$(".money_not_enough").show();
		$(".all_grey_bg").show();
		return false;
    }
    
    if(!system){
    	alert(error_msg);
    	return false;
    }
    
    setTimeout(function () {
        //$("#hand_shank").removeClass("hand_shank_02");
        after_top = parseInt($(".p_div").eq(2).css("top"));
        if (before_top == after_top) {//如果当前的没有滚动时
            $(".clock").show();
            mm = 0;//定时器开始分钟
            ss = 16;//定时器开始秒数
           // sss = 0;//定时器开始毫秒数
            minus = 5000;//2分钟内（120秒）40秒停一个数字 所以三个数字停止的时间分别为40、80、120
            var delay = 1000 * (mm * 60 + ss) + 200;//表示delay时间后开始停止

		     setTimeout(function () {
			     $("#hand_shank").removeClass("hand_shank_02");
			     after_top = parseInt($(".p_div").eq(2).css("top"));
			     if (before_top == after_top) {//如果当前的没有滚动时
				     startDate=new Date();
				     mm = 0;//定时器开始分钟
				     ss = 16;//定时器开始秒数
				    // sss = 0;//定时器开始毫秒数
				     minus = 5000;//2分钟内（120秒）40秒停一个数字 所以三个数字停止的时间分别为40、80、120
				     var delay = 1000 * (mm * 60 + ss) + 200;//表示delay时间后开始停止
				     scroll.transferY(0, delay - minus * 2,speed);
				     scroll.transferY(1, delay - minus,speed);
				     scroll.transferY(2, delay,speed);
				     $(".clock").show();
                     $(".join_btn_normal").css({"visibility":"hidden"});
				     clock =setInterval(timer,100);
			     }
		     }, 200);
        }
    });
})

//news滚动
var index=0;
var tmp=setInterval(function(){
    $(".good_news_center>ul li").eq(index).slideUp("2000");
    index++;
    if(index==$(".good_news_center>ul li").length){
        setTimeout(function(){
            $(".good_news_center>ul li").show();
            index=0;
        },1001);
    }
},5000);


function copyToClipboard(maintext){
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isOpera = userAgent.indexOf("Opera") > -1;
    if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera) {
        if (window.clipboardData){
            window.clipboardData.setData("Text", maintext);
        }else if (window.netscape){
            try{
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }catch(e){
                alert("该浏览器不支持一键复制！请手工复制文本框链接地址～");
            }
            var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
            if (!clip) return;
            var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
            if (!trans) return;
            trans.addDataFlavor('text/unicode');
            var str = new Object();
            var len = new Object();
            var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
            var copytext=maintext;
            str.data=copytext;
            trans.setTransferData("text/unicode",str,copytext.length*2);
            var clipid=Components.interfaces.nsIClipboard;
            if (!clip) return false;
            clip.setData(trans,null,clipid.kGlobalClipboard);
        }
        layer.alert("分享内容已经复制到剪贴板！", {title:false,btn:false});
    }else{
        alert("该浏览器不支持一键复制！请手工复制文本框链接地址～");
        return false;
    } //判断是否IE浏览器
}

function login_alert(){
    $(".join_btn_normal").addClass("join_btn_click");
    setTimeout(function () {
        $(".join_btn_normal").removeClass("join_btn_click");
    }, 100);
    $(".all_grey_bg").show();
    // $(".money_not_enough").show();
    $(".login_alert").show();
}

$(function(){
	$('.share_content_btn').click(function(){
		var text = $(this).prev().val();
		copyToClipboard(text);
	})
	var _token = $("input[name='_token']").val();
	$('.login_btn').click(function(){
		var username = $("input[name='username']").val();
		var password = $("input[name='password']").val();

		if(username=="请输入手机号" || username == "" || username == null){
			return false;
		}

		if(password=="请输入密码" || password == "" || password == null){
			return false;
		}

		$.ajax({
			type: "post",
			url: "/login",
			dataType:'json',
			data:{
				username :username,
				password : password,
				_token : _token
				
			},
			success:function(data){
				if(data.status == 0){
					window.location.reload();
				}else{
					alert(data.msg);
				}
			}
		});
	})
})

$(".close_btn").click(function(){
    $(".announce_rule_alert").hide();
    $(".all_grey_bg").hide();
});

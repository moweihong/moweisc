<style>
	.usertips{background:#FE0100;color:#fff;width:26px;display:inline-block;text-align:center;
			  position:absolute;height:24px;line-height:24px;margin-top:13px;right:24px;border-radius:12px; }
</style>
<div class="c_newhead_portrait">
    <span class="c_close_btn"></span>
    <div class="c_header_alert">
        <div class="face_conts" id="face" style="margin-left:10px;">
            <embed tplayername="SWF" splayername="SWF"
                   type="application/x-shockwave-flash"
                   src="../static/plugin/uploadportrait/face.swf" mediawrapchecked="true"
                   pluginspage="http://www.macromedia.com/go/getflashplayer"
                   id="tagcloudflash" name="tagcloudflash" bgcolor="#ffffff"
                   quality="high" wmode="transparent" allowscriptaccess="always"
                   FlashVars="uploadServerUrl=/upfile.jsp?userId=9892354&defaultImg=/imgurl.do?userId=9892354&size=big"
                   width="600" height="500"/>
        </div>
        <div class="c_qq_close c_header_close"></div>
    </div>
</div>
<div class="c_box_bg"></div>
<div id="member_left" class="member_left">
    <div class="c_left_side">
        <ul class="c_left_nav">
            <li><a id='menu1' class="c_first_out_a c_click_li" style='background:#FE0100;color:#fff' href="/user/account"><i></i>我的账户</a></li>
            <li><a id='menu2' class="c_out_a " href="/user/buy"><i class="c_out_i_two"></i>购买记录</a></li>
            <li><a id='menu3' class="c_out_a" href="/user/recharge_now"><i class="c_out_i_four"></i>账户充值</a></li>
            <li><a id='menu4' class="c_out_a" href="/user/prize"><i class="c_out_i_three"></i>获得记录  @if($myprize > 0)<span class="usertips">{{ $myprize }}</span>@endif</a></li>
            <li><a id='menu13' class="c_out_a" href="/user/unpay"><i class="c_out_i_two"></i>未支付订单  @if($no_pay_count > 0)<span class="usertips">{{ $no_pay_count }}</span>@endif</a></li>
            <li><a id='menu5' class="c_out_a" href="/user/show"><i class="c_out_i_six"></i>我的晒单 @if($myshownum > 0)<span class="usertips">{{ $myshownum }}</span>@endif</a></li>
            <li><a id='menu6' class="c_out_a" href="/user/score"><i class="c_out_i_seven"></i>我的块乐豆</a></li>
            <li><a id='menu7' class="c_out_a" href="/user/bribery"><i class="c_out_i_eight"></i>我的红包</a></li>
            <li><a id='menu8' class="c_out_a" href="/user/invite"><i class="c_out_i_nine"></i>邀请好友</a></li>
            <li><a id='menu9' class="c_out_a" href="/user/commissionsource"><i class="c_out_i_thirteen"></i>我的佣金</a></li>
            <li><a id='menu10' class="c_out_a" href="/user/address"><i class="c_out_i_ten"></i>收货地址</a></li>
            <li><a id='menu11' class="c_out_a" href="/user/security"><i class="c_out_i_eleven"></i>安全中心</a></li>
            <li><a id='menu12' class="c_out_a" href="/user/question"><i class="c_out_i_twelve"></i>常见问题</a></li>
            <li><a id='menu14' class="c_out_a" href="/user/message"><i class="c_out_i_fifteen"></i>系统消息</a></li>
        </ul>
    </div>
</div>

<script>
	$(function(){
		//一级导航菜单 - 选中变红，通过js获取pathname值获取
		var clearNavCur = function(){
			$('#menu2,#menu3,#menu4,#menu5,#menu6,#menu7,#menu8,#menu9,#menu10,#menu11,#menu12,#menu13').removeClass('c_click_li');
		}
		var _pathname = window.location.pathname;
		//alert(_pathname.substring(6,17));
		if(_pathname.substring(6,9)=='buy'){
			clearNavCur();
			$('#menu2').addClass('c_click_li');
		}else if(_pathname.substring(6,14)=='recharge'){
			clearNavCur();
			$('#menu3').addClass('c_click_li');
		} else if(_pathname.substring(6,11)=='prize'){
			clearNavCur();
			$('#menu4').addClass('c_click_li');
		}else if(_pathname.substring(6,10)=='show'){
			clearNavCur();
			$('#menu5').addClass('c_click_li');
		}else if(_pathname.substring(6,11)=='score'){
			clearNavCur();
			$('#menu6').addClass('c_click_li');
		}else if(_pathname.substring(6,13)=='bribery'){
			clearNavCur();
			$('#menu7').addClass('c_click_li');
		}else if(_pathname.substring(6,17)=='inviteprize'){
			clearNavCur();
			$('#menu8').addClass('c_click_li');
		}else if(_pathname.substring(6,12)=='invite'){
			clearNavCur();
			$('#menu8').addClass('c_click_li');
		}else if(_pathname.substring(6,22)=='commissionsource'){
			clearNavCur();
			$('#menu9').addClass('c_click_li');
		}else if(_pathname.substring(6,19)=='commissionbuy'){
			clearNavCur();
			$('#menu9').addClass('c_click_li');
		}else if(_pathname.substring(6,16)=='mybankcard'){
			clearNavCur();
			$('#menu9').addClass('c_click_li');
		}else if(_pathname.substring(6,13)=='address'){
			clearNavCur();
			$('#menu10').addClass('c_click_li');
		}else if(_pathname.substring(6,14)=='security'){
			clearNavCur();
			$('#menu11').addClass('c_click_li');
		}else if(_pathname.substring(6,14)=='question'){
			clearNavCur();
			$('#menu12').addClass('c_click_li');
		}else if(_pathname.substring(6,14)=='unpay'){
			clearNavCur();
			$('#menu13').addClass('c_click_li');
		}else if(_pathname.substring(6,14)=='message'){
			clearNavCur();
			$('#menu14').addClass('c_click_li');
		}
	});
</script>
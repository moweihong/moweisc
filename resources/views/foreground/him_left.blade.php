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
            <li><a id='menu2' class="c_out_a " href="/him/buy/{{ $himinfo->usr_id }}"><i class="c_out_i_two"></i>参与记录</a></li>
            <li><a id='menu4' class="c_out_a" href="/him/prize/{{ $himinfo->usr_id }}"><i class="c_out_i_three"></i>获得记录</a></li>            
            <li><a id='menu5' class="c_out_a" href="/him/show/{{ $himinfo->usr_id }}"><i class="c_out_i_six"></i>晒单记录</a></li>

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
			$('#menu14').addClass('c_click_li');
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
		}
	});
</script>
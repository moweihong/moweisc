@extends('foreground.master')
@section('my_css')
     <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/wyzq.css">
     <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/ttmf.css">
@endsection

@section('content')
   <div class="all_grey_bg"></div>
  <div class="bg_top">
  <div class="invite_reg">赚钱链接已复制成功，快去发送给好友注册吧！</div>
  </div>
    <div class="bg_middle">
    	<input type="hidden" value="http://{{ $url }}" id="txtInfo" />
       <div id='btnCopy' class="immediate_btn" data-clipboard-target="txtInfo">立即赚钱</div>
       <div class="freeday_btn">天天免费</div>
    </div>
    <div class="bg_bottom">
        <div class="content1">
            <p >你获得什么</p>
            <p>赚多少</p>
            <p class="bg_bottom_last_p">怎么赚</p>
                <div class="how_to_make_money">
                   <ul><li>1. &nbsp;&nbsp;&nbsp;邀请好友一起玩，你和好友都可以获得免费抢红包和宝马的机会。</li>
                       <li>2. &nbsp;&nbsp;&nbsp;你可以拿好友消费额的一定比例作为佣金返点。（分为两层。你可以拿好友消费额的6%，还可以拿好友邀请的人消费额的1%）。</li>
                       <li>3. &nbsp;&nbsp;&nbsp;你也可以申请为渠道用户，渠道用户佣金高达8%以上。<div class="apply_bg"><span>立即申请渠道</span></div></li>
                       <li>4. &nbsp;&nbsp;&nbsp;被邀请好友消费金额可以支持终生制返佣。</li>
                       <li>5. &nbsp;&nbsp;&nbsp;佣金永久有效，不清零 、可累计，可以随时充值到个人账户用于本站消费，满100元也可申请提现。</li>
                       <li>6. &nbsp;&nbsp;&nbsp;严禁利用非法手段恶意获取佣金，一经查实，将立即冻结账号，扣除所有佣金，清除所有块乐豆。</li>
                   </ul>
                </div>
        </div>
    </div>
      <!--未登录-->
            <div class="login_alert">
                <span>一块购账号登录</span>
                <input type="hidden" id="longintrue" value="{{ $longintrue }}">
                <span id="close_login" style="color:#999;float:right;cursor:hand;margin-right:10px;font-weight:normal">关闭</span>
                <div class="login_line"></div>
                 <div class="login_account">
                     <div class="login_ioc_div">
                        <i><img src="{{ $url_prefix }}img/user_ioc.png" alt=""/></i>
                     <div class="vertical_line"></div>
                     </div>
                     <input type="text" placeholder="请输入手机号" name="username">
                 </div>
                <div class="login_account">
                    <div class="login_ioc_div">
                        <i><img src="{{ $url_prefix }}img/password_ioc.png" alt=""/></i>
                        <div class="vertical_line"></div>
                    </div>
                    <input type="password" placeholder="请输入密码" name="password" >
                </div>
                <input type="button" value="立即登录" class="login_btn">
                <div class="forget_title"><a href="/forgetpwd" class="fl">忘记密码</a><a href="/register" class="fr">立即注册</a></div>
    <!--             <div class="other_platform"><p>第三方登录</p> </div> -->
    <!--             <div class="other_platform_ioc"> -->
    <!--                 <a href="#"><img src="{{ $url_prefix }}img/qq_ioc.png"/></a> -->
    <!--                 <a href="#"><img src="{{ $url_prefix }}img/weichat.png"/></a> -->
    <!--               <a href="#"><img src="{{ $url_prefix }}img/weibo.png" style="margin-bottom: 1px;"/></a>  -->
    <!--             </div> -->
            </div>
 <script type="text/javascript" src="{{ $url_prefix }}js/NumScroll.js"></script>
 <script type="text/javascript" src="{{ $url_prefix }}js/ttmf.js"></script>
 <script type="text/javascript" src="{{ $url_prefix }}js/dist/ZeroClipboard.js"></script>
    <script type="text/javascript">
     var d;
    $(".immediate_btn").click(function(){
		var daihao=$("#longintrue").val();
       	if(daihao!=0)
       	{
	        $(".invite_reg").fadeIn(200);
	        $(".all_grey_bg").show();
	           d = setTimeout(function(){
	              $(".all_grey_bg").hide();
	               $(".invite_reg").hide();
	               clearTimeout(d);
	            },3000);
		}
		else
		{
			$(".all_grey_bg").show();
		    $(".login_alert").show();
		}
    });
    $(".freeday_btn").click(function(){
    window.location.href="/freeday";
    });
    $(".all_grey_bg").click(function(){
    $(this).hide();
    $(".invite_reg").hide();
     clearTimeout(d);
    });

       $(".apply_bg").click(function(){
	       	var daihao=$("#longintrue").val();
	       	if(daihao==0)
	       	{
		   	 	$(".all_grey_bg").show();
		        $(".login_alert").show();
	       	}
	       	else
	       	{
	       		window.location.href="/user/commissionsource";
	       	}
         
        });
        $("#close_login").click(function(){
          $(".all_grey_bg").hide();
         $(".login_alert").hide();
        });
        
        
		    var client = new ZeroClipboard( document.getElementById("btnCopy") );
		    client.on( "ready", function( readyEvent ) {
		      client.on( "aftercopy", function( event ) {
		        //layer.msg("复制成功！");
		      } );
		    } );    
        
    </script>

@endsection


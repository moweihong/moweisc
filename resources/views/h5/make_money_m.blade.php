@extends('foreground.mobilehead')
@section('title', '我要赚钱')
@section('my_css')
     <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/ttmf.css">
     <style>
         @media screen and (min-width: 414px) {
             html{
                 font-size: 150px;
             }
             .btn_group div{
                 width: 80px;
                 padding: 3px 0;
             }
             .select-item{
                 height: 45px;
                 padding-top: 7px;
                 font-size: .14rem;
             }
             .address-info{
                 border-bottom: 1px solid #EAEAEA;
                 padding: 4px 13px;
             }
         }
         @media screen and (max-width: 414px) {
             html{
                 font-size: 100px;
             }
             .btn_group div{
                 width: 60px;
             }
             .select-item{
                 height: 40px;
                 padding-top: 5px;
                 font-size: .14rem;
             }
             .address-info{
                 border-bottom: 1px solid #EAEAEA;
                 padding: 2px 13px;
             }
         }
         .make-money-content img{
             width:100%;
         }
         .login_alert {
             width: 286px;
             height: 250px;
             border: 1px solid #E2E2E4;
             position: fixed;
             margin-left: -143px;
             margin-top: -125px;
             left: 50%;
             top: 50%;
             background: white;
             z-index: 4000;
             border-radius: 5%;
             text-align: center;
             display: none;
         }
         .login_alert span {
             line-height: 38px;
             font-weight: bold;
             font-size: 13px;
         }
         .login_line {
             border-bottom: 1px solid #E2E2E4;
             width: 100%;
             margin-bottom: 20px;
         }
         .login_account {
             width: 269px;
             height: 43px;
             border: 1px solid #E2E2E4;
             border-top: 2px solid #A3A6AB;
             margin: 20px auto;
             border-radius: 5%;
             -webkit-border-radius: 5%;
             -o-border-radius: 5%;
             -moz-border-radius: 5%;
         }
         .login_ioc_div {
             width: 30px;
             height: 26px;
             display: inline-block;
             float: left;
             margin-top: 11px;
         }
         .login_ioc_div img{
             width: 15px;
             margin-left: -10px;
         }
         body .login_account input {
             width: 235px;
             height: 38px;
             border: none;
             float: right;
             line-height: 38px;
         }
         .forget_title {
             width: 266px;
             height: 15px;
             margin: 0 9px;
         }
         .bg_bottom{
             width: 100%;
             height: 140px;
             background:#FFBB22;
         }
         .btn_bg{
             width: 100%;
             position: fixed;
             bottom: 0;
             background: rgba(0,0,0,0.9);
             z-index: 10;

         }
         .btn_bg img{
             width:40%;
             margin: 20px 4%;
         }

         html body .login_btn {
             width: 269;
             height: 40px;
             background: #FF0000;
             color: white;
             font-size: 15px;
             border: none;
             border-radius: 3%;
             -webkit-border-radius: 3%;
             -o-border-radius: 3%;
             -moz-border-radius: 3%;
         }
         .fl {
             float: left;
             font-size: 12px;
         }
         .fr {
             float: right;
             font-size: 12px;
         }
         .immediate_apply{
             width: 10%;
             height: 1.5%;
             display: inline-block;
             position: absolute;
             bottom: 7.5%;
             left: 55%;
         }
         .immediate_btn,.ttmf_btn{
             width: 44%;
             height: 38px;
             background: #D81E1F;
             border-radius: 5px;
             display: inline-block;
             text-align: center;
             line-height: 38px;
             color: white;
             margin: 16px 2.7%;

         }
         .ttmf_btn{
             background: #335BE1;
             margin-right: .05rem;
         }
         .make-money-content{
             position:relative;
             top: 44px;
         }
         .invite_reg{
             width: 90%;
             height: 30px;
             background: #DE1A16;
             position: fixed;
             left: 5%;
             bottom: 33%;
             /* margin-left: -298px; */
             font-size: .1rem;
             color: white;
             text-align: center;
             line-height: 2rem;
             border-radius: 10px;
             box-shadow: -1px 5px 10px black;
             z-index: 41;
             display:none;
         }
         .all_grey_bg{
             position: fixed;
             width: 100%;
             height: 500%;
             background: black;
             z-index: 3999;
             opacity: 0.85;
             display:none;
         }


         .color-dd2626{color:#dd2626}
          .code-content{position: fixed; top:0px; left:0px; z-index:4999; color:#fff; font-family: "microsoft yehei"}
         .code-blackbg{position: fixed; width: 100%;  height: 100%; background: rgba(0,0,0,.8);  z-index: 3999; display: none}

         .codec-tit{width:2rem; margin: 0.3rem auto 0;}
         .codec-tit img{width:100%;}
         .codec-img img{width:100%; height: 100%;}
         .codec-tit2{width:90%; padding: 0.15rem 0 0.1rem; margin: 0px auto; border-bottom: 1px solid #a5a5a5; color:#fff; text-align: center;}
         .codec-txt{width:90%; padding: 0.1rem 0 0.1rem; margin: 0px auto; line-height: 24px; }
         .codec-img{width:200px; height: 200px; background: #fff; margin: 0.15rem auto;}
         .codec-close{width:140px; height: 40px; line-height: 40px; display: block; border: 1px solid #fff; border-radius: 4px; color:#fff; text-align: center; margin: 10px auto 0;}
     </style>
@endsection

@section('content')
    <div class="code-blackbg"></div>
   <div class="all_grey_bg"></div>
  <div class="bg_top">
  <!--<div class="invite_reg" style="height: 50px;font-size:30px;"><font size="6">赚钱链接已复制成功，快去发送给好友注册吧！</font></div>-->
  </div>
   <div class="make-money-content">
   <img src="{{ $h5_prefix }}images/make_money_app.jpg"/>
   <i class="immediate_apply"></i>
   </div>
   <!--<div class="bg_bottom"></div>-->
   <div class="btn_bg">

   	<input type="hidden" value="http://{{ $url }}" id="txtInfo" />
    <a><div id='btnCopy' class="immediate_btn" data-clipboard-target="txtInfo">立刻赚钱</div></a>

    <a href="freeday_m"><div  class="ttmf_btn">幸运转盘</div></a>
   </div>
      <!--未登录-->
            <div class="login_alert">
                <span>一块购账号登录</span>
                <input type="hidden" id="longintrue" value="{{ $longintrue }}">
                <span id="close_login" style="color:#999;float:right;cursor:hand;margin-right:10px;font-weight:normal">关闭</span>
                <div class="login_line"></div>
                 <div class="login_account">
                     <div class="login_ioc_div">
                        <i><img src="{{ $h5_prefix }}images/user_ioc.png" alt=""/></i>
                     <div class="vertical_line"></div>
                     </div>
                     <input type="text" placeholder="请输入手机号" name="username">
                 </div>
                <div class="login_account">
                    <div class="login_ioc_div">
                        <i><img src="{{ $h5_prefix }}images/password_ioc.png" alt=""/></i>
                        <div class="vertical_line"></div>
                    </div>
                    <input type="password" placeholder="请输入密码" name="password" >
                </div>
                <input type="button" value="立即登录" class="login_btn">
                <div class="forget_title"><a href="/forgetpwd_m" class="fl">忘记密码</a><a href="/reg_m" class="fr">立即注册</a></div>
    <!--             <div class="other_platform"><p>第三方登录</p> </div> -->
    <!--             <div class="other_platform_ioc"> -->
    <!--                 <a href="#"><img src="{{ $h5_prefix }}img/qq_ioc.png"/></a> -->
    <!--                 <a href="#"><img src="{{ $h5_prefix }}img/weichat.png"/></a> -->
    <!--               <a href="#"><img src="{{ $h5_prefix }}img/weibo.png" style="margin-bottom: 1px;"/></a>  -->
    <!--             </div> -->
            </div>
   <!--二维码弹窗 start-->
	@if(session('user.id'))
   <div class="code-content" style="display: none;">
           <p class="codec-tit2">邀请好友去消费最高可获得 <span class="color-dd2626">3.5%现金奖励！</span></p>
           <div class="codec-txt">
               1、微信客户端可直接点击右上角···分享<br/>
               2、邀请好友扫描二维码
               <p class="codec-img">{!! QrCode::size(200)->margin(1)->generate('http://'.$url); !!}</p>
               3、手机其他浏览器分享可截屏此二维码通过微信/QQ分享给朋友
           </div>
           <a href="javascript:void(0)" class="codec-close">知道了</a>
   </div>
   <!--二维码弹窗 end-->
	@endif
 <script type="text/javascript" src="{{ $url_prefix }}js/dist/ZeroClipboard.js"></script>
    <script type="text/javascript">
     var d;
    $(".immediate_btn").click(function(){
		var daihao=$("#longintrue").val();
       	if(daihao!=0)
       	{
            /*layer.open({
                title: [
                    '邀请好友链接',
                ],
                content: '<input type="text" value="http://{{ $url }}"/>'

            });
	           d = setTimeout(function(){
	              $(".all_grey_bg").hide();
	               $(".invite_reg").hide();
	               clearTimeout(d);
	            },3000);*/
            $(".code-blackbg").show();
            $(".code-content").show();
            //document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
            $("html,body").css({"overflow":"hidden", "height":"100%"})
		}
		else
		{
			$(".all_grey_bg").show();
		    $(".login_alert").show();
		}
    });


     $(".codec-close").click(function(){
         $(".code-blackbg").hide();
         $(".code-content").hide();
         $("html,body").removeAttr("style")
     })

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
	        layer.msg("复制成功！");
	      } );
	    } );
        
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
    </script>

@endsection


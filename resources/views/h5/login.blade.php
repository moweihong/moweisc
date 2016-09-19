@extends('foreground.mobilehead')
@section('title', '登录')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <style>body,.mui-content{background: #fff;}
 body .p-login-main {
    margin: 0 20px;
}
.login_tab span{
	display: inline-block;
    width: 50%;
    text-align: center;
    font-weight: bold;
    line-height: 0.3rem;
    font-size: .12rem;
}
.login_tab .active{
	border-bottom: 3px solid #E63955;
	color: #E63955;
}
.send_code_btn{
	width: .86rem;
    height: .25rem;
    display: inline-block;
    background: #CECECE;
    text-align: center;
    line-height: .25rem;
    color: #666666;
    border-radius: 3px;
    margin-top: 12px;
    font-size: .11rem;
}
.plog-but2{
	 text-align: center;
	 padding: 0.25rem 4%;
}
.plog-but2 .log-button2{
	width: 90%;
    height: 40px;
    display: inline-block;
    color: #fff;
    border: 1px solid #e63955;
    border-radius: 35px;
    background: #e63955;
}
.hide{
	display: none;
}
.other_platform_ct{
	    text-align: center;
}
.other_platform_ct p{
	width: 60px;
    display: inline-block;
    margin: 30px 16px;
}
.other_platform_ct p img{
	width: 46px;
}
.other_platform_ct a{
	font-size: .1rem;
}
.other_platorm_line{
	width: 80%;
    height: 1px;
    background: #e63955;
    position: relative;
    text-align: center;
    margin: 0 auto;
}
.other_platorm_line span{
	background: white;
    color: #e63955;
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -50px;
    display: inline-block;
    width: 100px;
}
#login1 .plog-box .log-text{
	    padding-left: 0.12rem;
}
.grey_bg {
    width: 100%;
    height: 10000px;
    background: black;
    opacity: .8;
    position: fixed;
    top: 0;
    z-index: 1;
    border-radius: 8px;
    word-break: break-all;
    display: none;
}
.layer_number {
    position: fixed;
    top: 40%;
    background: white;
    width: 90%;
    height: 200px;
    left: 5%;
    z-index: 1;
    color: grey;
    word-break: break-all;
    border-radius: 7px;
    padding-bottom: 50px;
    display: none;
}
.layer_number h2{
	text-align: center;
    padding-top: 48px;
    font-size: .18rem;
    font-family: "pingfang";
    color: black;
}
.layer_number p{
    padding: 15px 8%;
    font-size: .15rem;
    font-family: "pingfang";
    color: #999999;
}
   </style>
@endsection

@section('content')
   <div class="mui-content">
   	<div class="grey_bg"></div>
   	<div class="layer_number">
		<h2>请您设置登录密码</h2>
		<p>您的手机未设置登录密码，请用手机动态码登录后设置 </p>
	</div>
   	<!--<div class="login_tab"><span class="active" target-id="login">手机登录</span><span target-id="login1">手机验证码登录</span></div>--></br>
      <form method="POST" action="/user_m/login">
      {!! csrf_field() !!}
      <div class="p-login-main" id="login">
         <div class="plog-box mui-input-row">
            <span class="log-ico log-ico-tel"></span>
            <input type="text" name="username" id="username" class="log-text" placeholder="请输入手机号码" />
         </div>
         <div class="plog-box">
            <span class="log-ico log-ico-pas"></span>
            <input type="password" name="password" id="password" class="log-text" placeholder="请输入密码" style="width: 55%;" />
            <a href="/forgetpwd_m" class="log-forgetpass">忘记密码？</a>
         </div>
         <div class="plog-but">
            <input class="log-button" type="button" id="loginSubmit" value="登录" />
            <a href="/reg_m" class="log-butteg">快速注册</a>
         </div>
      </div>
      </form>
      <div class="p-login-main hide" id="login1">
         <div class="plog-box">
              <input type="text" name="number" id="number" class="log-text" placeholder="请输入手机号码"  style="width: 67%;"/>
              <a href="" class="send_code_btn">发送验证码</a>
         </div>
		 <div class="plog-box">
              <input type="text" name="code" id="code" class="log-text" placeholder="请输入手机短信中的验证码" />
         </div>
         <div class="plog-but2">
            <input class="log-button2" type="button" id="loginSubmit" value="登录" />
         </div>
      </div>
    
        <div class="other_platorm_line">
            <span>第三方登录</span>
        </div>
      <div class="other_platform_ct">
        
      	<p onclick='window.location.href="{{$qq_login_url}}"'>
      		<img src="{{ $h5_prefix }}/images/qq-tx.png" style="width: 35px;"/>
            <br/>
      		QQ登录
      	</p>
        @if($is_weixin)
        <p onclick='window.location.href="{{$wx_login_url}}"'>
      		<img src="{{ $h5_prefix }}/images/weichat-tx.png"/>
            <br/>
      		微信登录
      	</p>
        @endif        
<!--      	<p>
      		<img src="{{ $h5_prefix }}/images/weibo-tx.png"/>
      		<a href="">微博登录</a>
      	</p>-->
      </div>
       
   </div>
@endsection

@section('my_js')
<script>
   //会员登录
    $(document).ready(function(){
        var url="/synchronize";
        $.ajax({
            type:'GET',
            url:url,
            success:function(data){
                var data =eval('('+data+')');
                if(data.status == 0){ 
                       window.location.href = '/index_m';
                }
            }
        });
    });
    
   $("#loginSubmit").click(function(){
         var username = $("#username").val();      
         var password = $("#password").val();
         var _token = $("input[name='_token']").val();
         if(username==null || username == "" || !checkMobile(username)){
            myalert('请输入正确的手机号');
            return ;
         }else if(password==null ||password ==""){
            myalert("请输入密码");
            return ;
         }else{
            $("#loginSubmit").val("等待...");
            var index = layer.open({type: 2});
            $.ajax({
               type: "post",
               url: "/user_m/login",
               dataType:'json',
               data:{
                  username :username,
                  password : password,
                  _token : _token
               },
               success:function(data){
                  if(data.status == 0){
                     if (data.refer == '/usercenter'){
                        window.location.href = 'user_m/usercenter2';
                     }else{
                    	 window.location.href = data.refer;
                     }
                  }else{
                     layer.close(index);
                     myalert(data.msg);
                     $("#loginSubmit").val("立即登录");
                  }
               }
            });      
      }

   });

   /*检查手机号*/
   function checkMobile(mobile){ 
   	var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
   	if (mobile == "请输入手机号" || mobile == "" || mobile == null) {
   		return false;
   	} else if (!isMobile.test(mobile)) {
   		return false;
   	}else{
   		return true;
   	}
   }
   $(".login_tab>span").click(function(){
   	$(".login_tab>span").removeClass("active");
   	$(this).addClass("active");
   	var target_id=$(this).attr("target-id");
   	$(".p-login-main").hide();
   	$("#"+target_id).show();
   });
   $(".grey_bg").click(function(){
   	$(this).hide();
   	$(".layer_number").hide();
   });
</script>
@endsection



 
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="{{$url_prefix}}mobile/css/bootstrap.css">
<link rel="stylesheet" media="screen,projection,tv" href="{{$url_prefix}}mobile/css/header_footer.css"/>
<link rel="stylesheet" media="screen,projection,tv" href="{{$url_prefix}}mobile/css/main.css"/>
 
<title>特速一块购-注册</title>
</head>
<body style="background:#f3f3f3;">
     <div class="c_header">
      <div class="col-xs-4 text-left">
        <a href="javascript:history.go(-1);" class="c_header_left">
          <img src="{{$url_prefix}}mobile/img/deta_06.png" width=12 />
        </a>
      </div>
      <div class="col-xs-4 text-center c_header_center">
                 免费注册
      </div>
      <div class="col-xs-4 text-right">
        <a href="index.html" class="c_header_right" >
          <img src="{{$url_prefix}}mobile/img/deta_03.png" width=30 />
        </a>
      </div>
    </div>
    <!--S 内容区域 -->
    <div class="container-fluid">
       <form class="c_nickname c_login c_register" action='registered_next.html' method='post' >
       
        <div class="form-group">
          <input pattern="[0-9]*"  class="form-control c_password_input" id="telephone" value="" maxlength="11" placeholder="请输入手机号" name="telephone" type="text" autocomplete="off">
          <img src="{{$url_prefix}}mobile/img/re1.png" width=16/>
        </div>
        <div class="form-group">
          <input type="password" class="form-control c_password_input c_press"  id="pwd" maxlength="20"  placeholder="请输入8-20位字母+数字组合密码" >
          <img src="{{$url_prefix}}mobile/img/re3.png" width=20 />
          <span class="c_yan_zheng c_yan_zheng_one" id="clearPassword"></span>
        </div>
          
        <div class="form-group">
           <input type="text" class="form-control  c_password_input" id="verifyCode" placeholder="请输入手机验证码" maxlength="6">
             <img src="{{$url_prefix}}mobile/img/re2.png" width=16 />
           <span class="w_validation w_img c_get_num" id="getCode" onclick="getVerifyCode()">获取验证码</span>
        </div>
        <div class="form-group" id="forhide">
          <input type="text" class="form-control  c_password_input" id="registerCode"  placeholder="邀请人手机号（选填）" maxlength="13" name="registerCode" value="" >
          <img src="{{$url_prefix}}mobile/img/re4.png" width=16 />
        </div>
   </form>
 
      <a href="javascript:void(0)"   id="finish" class="c_login_btn c_forget_btn">立即注册</a>
    </div>
    <!--E 内容区域 -->
   <!--  <div class="c_about_register">
      <a href="/login.html" class="col-xs-12">登录</a>
    </div> -->
    
      <div class="b_about_register">
       <!--<ul>
          <li><a href="">关于一块购</a></li>|
          <li><a href="">消费者保障说明</a></li>|
          <li><a href="">隐私协议</a></li>
       </ul>-->
       <p>版权所有   Copyright © 2016 ts1kg.com</p>
    </div>
</body>   
	<script type="text/javascript">
    var inviteCode='';//邀请码
    var redFlyingFlag="";//注册送红包
    var mobile="";//注册送红包
	</script>
	
<script type="text/javascript" src="/static/plugins/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/static/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/common/common.js"></script>
<script type="text/javascript" src="/static/plugins/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/static/js/other/registered.min.js"></script>
<script type="text/javascript" src="/static/js/common/common_ajaxfunction_other.js"></script>
</html>

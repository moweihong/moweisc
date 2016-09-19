@extends('foreground.mobilehead')
@section('title', '登录成功')
@section('my_css')
 <style>
 	html{
 		font-size: 100px;
 	}
 	.glzh_photo{
 		text-align: center;
    	padding: 20px;
    	background: white;
 	}
 	.glzh_photo div{
 	    width: 1.1rem;
	    height: 1.1rem;
	    border-radius: 50%;
	    border: 1px solid #e63955;
	    margin: 0 auto;
	    padding-top: .05rem;
 	}
 	.glzh_photo img{
	 	width: 1rem;
	    height: 1rem;
	    border-radius: 50%;
	    
 	}
 	.glzh_tip{
	 width: 90%;
    height: .7rem;
    background: url("/H5/images/glzh_bg.png") no-repeat;
    margin: 0 auto;
    background-size: 100% 100%;
    padding: .1rem 0 0 .2rem;
    font-size: .18rem;
    line-height: 48px;
    color: #e63955;
 	}

 	.say_hi{
 		font-size: .14rem;
 		  color: #e63955;
 	}
 	.friendly_tip{
 		font-size: .18rem;
 		  color: #e63955;
 	}
 	em{
 	font-size: .11rem;
    font-style: normal;
 	}
 	.glzh_reg,.glzh_gl{
 		width: 80%;
 		margin: 0 auto;
 		}
 	.glzh_reg p,.glzh_gl p{
	    border: 2px solid #e63955;
	    text-align: center;
	    height: 45px;
	    font-size: 0.15rem;
	    color: #8c8c8c;
	    line-height: 45px;
	    border-radius: 5px;
	    font-family: simhei;
	    margin-top: 10px;
}
	.glzh_gl p{
		background: #e63955;
		color: white;
 	}
 	.glzh_msg{
 		text-align: center;
 	}
 	.glzh_msg p{
 	font-size: .2rem;
    color: #e63955;
    padding-bottom: 20px;
 	}
 	.tip{text-align:center;margin: 0 auto;    background: white;    padding-bottom: 10px;   margin-top: -6px;}
 	.tip p{font-family: SourceHanSansCNExtraLight;font-weight: bold;}
 	.phone_code input:first-child{width: 50%;float: left;}
 	.phone_code .code_btn{width: 40%;height:40px;background: #E63955;font-family: "microsoft yehei"; font-size: .14rem;color: white;float: right;border-radius:5px ;}
 	.confirm{text-align: center;}
 	.confirm input{width: 90%;background: #E63955;margin: 40px auto;font-family: "microsoft yehei"; font-size: .14rem;color: white;}
 	.glzh_reg01{font-size: .11rem;color: #333333;line-height: 24px;    text-align: center;font-family: "microsoft yehei";  background: url("{{ $h5_prefix }}images/union_bg.png") no-repeat;     background-size: 100% 100%;padding-bottom: 47px;padding-top: 15px;margin-top:-1px ;}
 	
 </style>
@endsection

@section('content')
  <div class="mui-content">
  <div class="glzh_photo">
  	<div>
  		<img src="{{$headimgurl}}" />
  	</div>
  </div>
  <div class="tip">
  	<p class="say_hi">Hi,{{$nickname}} </p>
  	<p class="friendly_tip">登录特速一块购成功</p>
  </div>
   <div class="glzh_reg01">
  	<p>您已使用微信/QQ账号成功登录一块购平台。</p>
	<p>验证手机号码即可立即参与一块购。</p>
  </div>
  {!! csrf_field() !!}
  <div class="glzh_reg">
  	<input type="text" id="mobile" name="mobile" maxlength="11"  placeholder="请输入手机号码" />
  </div>
 
   <div class="glzh_reg phone_code">
  	<input type="text" id="smsCode" placeholder="短信验证码" maxlength="6" />
  	<input type="button" value="获取验证码" class="code_btn"/>
  </div>
    <div style="display:none;">
        <input type="text" id="statueCode" name="statueCode" value="{{$statueCode}}">
    </div>
 <div class="confirm">
     <input type="button" onclick="doBindUser()" value="立即绑定" />
 </div>
  </div>

@endsection

@section('my_js')
<script>
</script>
 <script src="{{ $h5_prefix }}js/binduser.js"></script>  
@endsection


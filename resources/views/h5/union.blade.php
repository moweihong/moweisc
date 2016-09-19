@extends('foreground.mobilehead')
@section('title', '关联账号')
@section('my_css')
 <style>
 	html{
 		font-size: 100px;
 	}
 	.glzh_photo{
 		text-align: center;
    	padding: 20px;
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
 	}
 	.glzh_tip p{
 	 font-size: .11rem;
    line-height: .12rem;
    color: #666666;
 	}
 	em{
 	font-size: .11rem;
    font-style: normal;
 	}
 	.glzh_reg,.glzh_gl{
 		width: 70%;
 		margin: 0 auto;
 		}
 	.glzh_reg p,.glzh_gl p{
	    border: 2px solid #e63955;
	    text-align: center;
	    height: 45px;
	    font-size: 0.14rem;
	    color: #e63955;
	    line-height: 45px;
	    border-radius: 5px;
	    font-family: "pingfang";
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
 </style>
@endsection

@section('content')
  <div class="mui-content">
  <div class="glzh_photo">
  	<div>
  		<img src="{{$headimgurl}}" />
  	</div>
  </div>
  <div class="glzh_tip">
  	<p>客官：{{$nickname}} </p>
  	<p>为了给您更好的服务，请关联一个一块购账号！</p>
  </div>
  <div class="glzh_reg">
  	<em>没有一块购账号？</em>
    <p onclick='window.location.href="/reg_m"'>立即注册</p>
  </div>
   <div class="glzh_gl">
  	<em>已有一块购账号？</em>
  	<p onclick='window.location.href="/login_m?show=0"'>立即关联</p>
  </div>
  <div class="glzh_msg">
  	<em>关联后下次可快捷登录哦</em> 
  	<p>......</p>
  </div>
  </div>
@endsection

@section('my_js')
  
@endsection



 
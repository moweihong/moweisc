@extends('foreground.mobilehead')
@section('title', '安全设置')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	label{color:#666}
	input{color:#A4A4A4;text-align:right}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
    
	    <div class="mui-input-group"  style='margin-top:0.06rem;'>
            <div class="mui-input-row" onclick="location.href='/user_m/updatepwd'">
               <label>修改密码</label>
               <input type="text" value="" readonly="readonly">
            </div>
		</div>
		
		<div class="mui-input-group"  style='margin-top:0.08rem;'>
            <div class="mui-input-row" onclick="location.href='/user_m/bindmail'" >
               <label>修改邮箱</label>
               <input type="text" value="" readonly="readonly">
            </div>
		</div>
		
<!--	  <div class="p-reg-main" style='margin-top:0.08rem'>
         <div class="mui-input-group" >
            <div class="mui-input-row" >
               <label>修改QQ</label>
               <input type="text" value="416781002" maxlength="11">
            </div>
			<div class="mui-input-row">
               <label>修改微信</label>
               <input type="text" value="tzarlink123" maxlength="11">
            </div>
         </div>
         
		 <div class="mui-input-group"  style='margin-top:0.08rem;'>
            <div class="mui-input-row" >
               <label>修改微博</label>
               <input type="text" value="tzalrink@sina.cn" maxlength="11">
            </div>
		</div>
        
      </div>-->
   </div>
@endsection

@section('my_js')
   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
   </script>
@endsection



 



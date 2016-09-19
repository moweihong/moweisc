@extends('foreground.mobilehead')
@section('title', '修改密码')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:0.5rem}
	label{color:#333}
	input{color:#A4A4A4}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
        {!! csrf_field() !!}
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <input type="password" id="password" name="password" value="" placeholder="请输入旧密码" maxlength="16">
            </div>
			 <div class="mui-input-row" >
               <input type="password" id="newpassword" name="newpassword" value="" placeholder="请输入新密码" maxlength="16">
            </div>
			 <div class="mui-input-row" >
               <input type="password" id="repasswd" name="repasswd" value="" placeholder="请确认新密码" maxlength="16">
            </div>
		</div>

		 
	  <div class="p-reg-main" style='margin-top:0.08rem'>
          <div class="reg-button"><button type="button" id="updatePassword" class="mui-btn mui-btn-danger mui-btn-block">确认</button></div>
      </div>
   </div>
@endsection

@section('my_js')

<script src="{{ asset('foreground/js/layer/layer.js') }}"></script><!-- 提示框js -->

<script>
$(function(){
    $('#updatePassword').click(function(){//修改密码
        var oldpass=$("#password").val();
        var newpass=$("#newpassword").val();
        var repasswd=$("#repasswd").val();
        var token = $("input[name='_token']").val();
        if(oldpass=='' || newpass=='' || repasswd=='')
        {
            layer.msg('密码不能为空');
            return false;
        }
        if(oldpass == newpass)
        {
            layer.msg('新密码和旧密码相同');
            return false;
        }
        if(newpass.length<6 || repasswd.length<6){
            layer.msg('设置密码不能少于6位');
            return false;
        }
        if(newpass.length>16 || repasswd.length>16){
            layer.msg('设置密码不能大于16位');
            return false;
        }
        if(repasswd != newpass)
        {
            layer.msg('两次输入密码不一致');
            return false;
        }
        $.post("/user_m/updatepwd", { 'oldpass': oldpass,'newpass':newpass,'repasswd':repasswd,'_token':token}, function(data){
             if(data.status!=0)
             {                
                layer.msg(data.msg);                
             }
             else
             {
                layer.msg(data.msg);
                location.href='/user_m/usercenter2';
             }
       
       }, 'json')
       
    })

});
</script>

   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
   </script>
@endsection



 



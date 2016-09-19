@extends('foreground.mobilehead')
@section('title', $title)
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
	    <div class="mui-input-group"  style='margin-top:0.08rem;'>
            <div class="mui-input-row" >
               <input type="password" id="password" name="password" value="" placeholder="{{$pwdTips}}" maxlength="16">
            </div>
			 <div class="mui-input-row" >
               <input type="password" id="newpassword" name="newpassword" value="" placeholder="{{$cpwdTips}}" maxlength="16">
            </div>
		</div>

        @if ($pwd=='setpwd')
{{--         <input type="hidden" id="mobile" name="mobile" value="{{$mobile}}" />
             <input type="hidden" id="smsCode" name="smsCode" value="{{$smsCode}}" />
            <input type="hidden" id="registerCode" name="registerCode" value="{{$registerCode}}" /> -->--}}
        @elseif ($pwd=='resetpwd')
        <input type="hidden" id="mobile" name="mobile" value="{{$mobile}}" />
        @endif
		 
	  <div class="p-reg-main" style='margin-top:0.08rem'>
         <div class="reg-button"><button type="button"  @if ($pwd=='setpwd') onclick="regSubmit()" @else id="updatePassword" @endif class="mui-btn mui-btn-danger mui-btn-block">{{$nextBottom}}</button></div>
      </div>
   </div>
@endsection

@section('my_js')


@if ($pwd=='setpwd')
<script type="text/javascript" src="{{ asset('H5/js/reg.js') }}"></script>
@elseif ($pwd=='editpwd')

<script>
$(function(){
    $('#updatePassword').click(function(){//修改密码
        var oldpass=$("#password").val();
        var newpass=$("#newpassword").val();
        var token = $("input[name='_token']").val();
        if(oldpass=='')
        {
        	myalert('密码不能为空');
            return false;
        }
        if(oldpass.length<6 || oldpass.length>16 ){
        	myalert('密码长度须为6-16位！');
    		return false;
        }
        
        if(oldpass != newpass)
        {
        	myalert('两次输入密码不相同');
            return false;
        }
        var index = layer.open({type: 2});
        $.post("/user/security/updatePassWord", { 'oldpass': oldpass,'newpass':newpass,'repass':newpass,'username':'{{session('user.user_name')}}','uid':'{{session('user.id')}}','_token':token}, function(data){
             if(data.code!=0)
             {
                 layer.close(index);
            	 myalert('修改失败');
                return false;
             }
             else
             {
            	 myalert('修改成功');
                window.location.href='/index_m';
             }
       
       }, 'json')
       
    })

});
</script>

@elseif ($pwd=='resetpwd')

<script>
$(function(){
    $('#updatePassword').click(function(){//修改密码
        var oldpass=$("#password").val();
        var newpass=$("#newpassword").val();
        var mobile=$("#mobile").val();
        var token = $("input[name='_token']").val();
        if(oldpass=='')
        {
        	myalert('密码不能为空');
            return false;
        }

        if(oldpass.length<6 || oldpass.length>16 ){
        	myalert('密码长度须为6-16位！');
    		return false;
        }
        
        if(oldpass != newpass)
        {
        	myalert('两次输入密码不相同');
            return false;
        }
        var index = layer.open({type: 2});
        $.post("/setPass", { 'pass':oldpass,'mobile':mobile,'_token':token}, function(data){
             if(data.status!=0)
             {
                 layer.close(index);
            	 myalert('修改失败');
                return false;
             }
             else
             {
            	 myalert('修改成功');
                window.location.href='/index_m';
             }
       
       }, 'json')
       
    })

});
</script>

@endif

@endsection



 



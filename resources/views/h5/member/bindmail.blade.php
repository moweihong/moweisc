@extends('foreground.mobilehead')
@section('title', '绑定邮箱')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <style>
	.mui-content{width:92%;margin:0 auto}
	.reg-button{width:100%;padding:0;margin:0.4rem 0}
	.mui-input-group{border-radius:6px;border:1px solid #ccc}
	.mui-input-group:before,.mui-input-group:after,.mui-input-row:after{height:0}
	.get-yzm{background:#e63955;color:white;font-size:0.18rem}
 
   </style>
@endsection

@section('content')
   <div class="mui-content">
		<p style="margin:0.1rem auto ">验证手机号：{{$mobile}}</p>
      <div class="p-reg-main" >
         <div class="mui-input-group"   >

            <div class="mui-input-row input-password " >
               <input type="text" class="mui-input-clear" id="code" placeholder="请输入6位验证码" maxlength="6" style='font-size:0.18rem;width:68%;float:left;height:0.45rem;line-height:0.45rem'><!--<span class="mui-icon mui-icon-clear"></span>-->
               <span class="get-yzm">获取验证码</span>
            </div>
          
         </div>
       
         <div class="reg-button"><button type="button" class="mui-btn mui-btn-danger mui-btn-block">下一步</button></div>
      </div>
   </div>
@endsection

@section('my_js')
   <script>
   var phone = {{$mobile}};
    var SmsSecond = 0;
    var SmsBtn = false;
    var valtime;
    $(".get-yzm").click(function(){
            var yzm = $(this);
            if (SmsBtn) {
                return false;
            }
            if (SmsSecond > 0) {
                myalert('获取验证码的间隔太短<BR>' + SmsSecond + '秒后再试');
                return false;
            }
            SmsBtn = true;
            $.post("/user_m/sendcode", { 'phone': phone,'type':'phone','_token':"{{csrf_token()}}"}, function(data){
                    if (data.status == 1) {
                        showTime(yzm);
                    } else {
                        myalert(data.msg);
                    }
                    SmsBtn = false;
           }, 'json');
    });

    function showTime(yzm) {
        SmsSecond = 120;
        valtime = window.setInterval(function() {
            if (SmsSecond > 0) {
                SmsSecond--;
                yzm.html(SmsSecond + '秒');
            } else {
                yzm.html('获取验证码');
                window.clearInterval(valtime);
                SmsSecond = 0;
            }
        }, 1000);
    }
    
    $(".mui-btn").click(function(){
            var code = $("#code").val();
        if(code == ''||code.length!=6){
            myalert('请输入6位有效的验证码');
            return false;
        }
        $.post("/user_m/updatetel", { 'code': code,'type':'email','_token':"{{csrf_token()}}"}, function(data){
                if (data.status == 1) {
                    location.href='/user_m/setmail';
                } else {
                    myalert(data.msg);
                }
       }, 'json');
    });
   </script>
@endsection



 
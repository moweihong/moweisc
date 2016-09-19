@extends('foreground.mobilehead')
@section('title', '注册')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <form method="post" action="/user_m/setpwd" id="form">
      {!! csrf_field() !!}
      <div class="p-reg-main">
         <div class="mui-input-group">
            <div class="mui-input-row">
               <label>手机号</label>
               <input type="text" id="mobile" name="mobile" maxlength="11" placeholder="请输入手机号">
            </div>
             <div class="mui-input-row" style="display: none;">                
               <input type="text" name="captcha" id="captcha" class="form-control">
            </div>
            <div id="TCaptcha" class="mui-input-row input-password"  style="height: 48px"></div>
            <div class="mui-input-row input-password">
               <label>验证码</label>
               <input type="text"  id="smsCode" name="smsCode" class="mui-input-clear" placeholder="请输入验证码" maxlength="6" style="width:45%; float: left; border-right:1px solid #e7e7e7"><!--<span class="mui-icon mui-icon-clear"></span>-->
               <span id='getcode' name="getcode" class="get-yzm ygqq_register_dx_a">获取验证码</span>
               <span id='getcode2' style='display:none' class="get-yzm"></span>
            </div> 
            @if($code || $recommend_id)
                <div class="mui-input-row input-yqrtel">
                   <label style="width: 34%;">邀请码</label> <?php $code = $code==0?$recommend_id:$code; ?>
                   <input style="width: 66%;" type="text" id="registerCode" name="registerCode" value="{{$code}}" maxlength="11" placeholder="请输入邀请码" disabled="disabled">
                </div>
            @else
            	<div class="mui-input-row input-yqrtel hide">
                   <label>邀请码</label>
                   <input type="text" id="registerCode" name="registerCode" value="" maxlength="11" placeholder="请输入邀请码">
                </div>
            @endif
         </div>
         <div class="reg-other">
            <div class="reg-chebox reg-yqm" style="margin-bottom: 10px;"><label style="width:100%; display: block"><input name="yqm" maxlength="11" type="checkbox" @if($code) checked @endif /> 我要输入邀请码</label></div>
            <div class="reg-chebox reg-xieyi"><label ><input type="checkbox" name="fwxy" checked /> 我已阅读并同意 </label><a href="agreement_m" style="text-decoration:underline">《一块购注册协议》</a></div>
         </div>
         <div class="reg-button"><button type="button" class="mui-btn mui-btn-danger mui-btn-block" onclick="doRegister()">下一步</button></div>
      </div>
      </form>
   </div>
@endsection

@section('my_js')
<script type="text/javascript" src="{{$imgjsUrl}}"></script>
<script>
   var time = 120;
    $(document).ready(function(){
       if({{ $time }} != -1){
          time = {{ $time }};
          $(".ygqq_register_dx_a").css({display:"none"});
          $("#getcode2").css({display:"block"});
          $("#getcode2").html("<em class='ygqq_login_dx_time'>"+time+"</em>秒后重新获取");
          get_code($(".ygqq_login_dx_time"),$('#getcode2'));
       }
    })
    var capOption={callback :cbfn,showHeader :true};
    capInit(document.getElementById("TCaptcha"), capOption);
    //回调函数：验证码页面关闭时回调
    function cbfn(retJson)
    {
        if(retJson.ret==0)
        {
            // 用户验证成功
            $("#captcha").val(retJson.ticket);
        }
        else
        {
            layer.msg('请先点击完成验证');
            //用户关闭验证码页面，没有验证
        }
    }
</script>
<script src="{{ $h5_prefix }}js/regi.js"></script>
<script src="{{ $h5_prefix }}js/reg.js"></script>
<script>

   $(function(){
      //手机号验证
      function checkMobile(mobile){
         var reg = new RegExp('^1[34578][0-9]{9}$');
         if(!reg.test(mobile)){
            return false;  
         }
         return true;
      }

      //监测邀请人选中状态
      $(".reg-yqm").on("click",function(){
         if($('input[name=yqm]').is(':checked')){
            $(".input-yqrtel").fadeIn();
         }
         else {
            $(".input-yqrtel").fadeOut();
         }
      })

      //监测一块购服务协议选中状态
      $(".reg-xieyi").on("click",function(){
         if($('input[name=fwxy]').is(':checked')){
            return true;
         }
         else {
            myalert("请勾选一块购服务协议！");
         }
      })

   })
</script>
@endsection



 
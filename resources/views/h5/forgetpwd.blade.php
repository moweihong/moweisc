@extends('foreground.mobilehead')
@section('title', '找回密码')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <form id="forgetpwd" method="post" action="/user_m/resetpwd">
      {!! csrf_field() !!}
      <div class="p-reg-main">
         <div class="mui-input-group">
            <div class="mui-input-row">
               <label>手机号</label>
               <input type="text" id="mobile" name="mobile" maxlength="11" placeholder="请输入手机号" style="width:45%; float: left;">
            </div>
            <div class="mui-input-row input-password">
               <label>验证码</label>
               <input type="text"  id="smsCode" name="smsCode" class="mui-input-clear" placeholder="请输入验证码" maxlength="6" style="width:45%; float: left; border-right:1px solid #e7e7e7"><!--<span class="mui-icon mui-icon-clear"></span>-->
               <span id='getcode' name="getcode" class="get-yzm ygqq_register_dx_a">获取验证码</span>
               <span id='getcode2' style='display:none' class="get-yzm"></span>
            </div>
      </div>
      <div class="reg-button"><button type="button" class="submit mui-btn mui-btn-danger mui-btn-block">下一步</button></div>
      </form>
   </div>
@endsection

@section('my_js')

<script>
$(function(){
    //注册获取验证码
    $(".ygqq_register_dx_a").click(function(){
        var mobile = $("#mobile").val();
        var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
        if (mobile == " " || mobile == "" || mobile == null) {
            myalert("手机号不能为空！");
            $("#mobile").focus();
            return ;
        } else if (!isMobile.test(mobile)) {
            myalert("请输入正确的手机号码！");
            $("#mobile").focus();
            return ;
        }
        if(checkMobileExist()){
            return false;
        }
        if(!validCode){
            return
        }
        $(".ygqq_register_dx_a").css({display:"none"});
        $("#getcode2").css({display:"block"});
        $("#getcode2").html("<em class='ygqq_login_dx_time'>120</em>秒");       
        get_code($(".ygqq_login_dx_time"),$('#getcode2'));
        sendVerifyCode(mobile);//发送短信验证码    
    });
    //注册时获取验证码倒计时
    var validCode=true;    //获取验证码倒计时变量
    var time = 120;
    function get_code(obj,obj2){
            if (validCode) {
                validCode=false;
                var t=setInterval(function  () {
                time--;
                    obj.html(time);
                    if (time==0) {
                        clearInterval(t);
                       // obj2.html("重新获取");
                        $("#getcode2").css({display:"none"});
                        $("#getcode").css({display:"block"});
                        validCode=true;
                        time=120;
                    }
                },1000)
            }
    }

    function sendVerifyCode(mobile){
        var _token = $("input[name='_token']").val();
        
        $.ajax({
            url: '/regverify_m_set',
            type: 'post',
            dataType: 'json',
            data: {_token:_token,mobile:mobile},
            success: function(res){
                if(res.status == 0){
                    myalert('验证码发送成功！');
                }else{
                    myalert(res.message);
                }
            }
        })
    }

    //校验手机号存在   
    function checkMobileExist(){
        var flag = false;
        var _token = $("input[name='_token']").val();

        $.ajax({
            type: "post",
            url: "/checkMobileExist",
            dataType:'json',
            async: false,
            data:{
                mobile :$("#mobile").val(),
                _token : _token
            },
            success:function(data){
                if(data.status == 0){
                    myalert('手机号没有注册！');
                    $("#mobile").focus();
                    flag = true;    
                }else{
                    flag = false;
                }
            }
        });
        return flag;    
    }

    //提交表单
    $(".submit").click(function(){
        var mobile = $("#mobile").val();
        var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
        if (mobile == " " || mobile == "" || mobile == null) {
            myalert("手机号不能为空！");
            //$("#mobile").focus();
            return ;
        } else if (!isMobile.test(mobile)) {
            myalert("请输入正确的手机号码！");
            $("#mobile").focus();
            return ;
        }
        if($('#smsCode').val()==""||$('#smsCode').val()=="请输入验证码"){
            myalert('请填写短信验证码！');
            $('#smsCode').val("");
            $("#smsCode").focus();
            return;
        }
        var index = layer.open({type: 2}); //loading等待框
        if(checkMobileExist()){
            return false;
        }
        var _token = $("input[name='_token']").val();

        $.ajax({
            type: "post",
            url: "/checkVerifyCode_m",
            dataType:'json',
            data:{
                type :1,
                _token : _token,
                verifyCode:$('#smsCode').val()
            },
            success:function(data){
                if(data.status == 0){
                    $("#forgetpwd").submit();
                }else{
                    layer.close(index);
                    myalert(data.message);
                    return false;
                }
            }
        });
    });
});
</script>
@endsection
@extends('foreground.mobilehead')
@section('title', '佣金转余额')
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
	.mui-input-group .mui-input-row label{
        color:#333;
        width: 33%;
	}
.mui-input-group .mui-input-row input{
    width: 67%;
    height: 50px;
}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
      
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>佣金总余额</label>
               <div class='commission'>{{$commission}}元<span style='color:#999'></span></div>
            </div>
		</div>
		<!--如果类型为佣金转余额-->
		<div class="mui-input-group"  style='margin-top:0.08rem;'>
            <div class="mui-input-row" >
               <label>转入余额</label>
               <input id="money" type="text" placeholder="请输金额" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" data-maxmoney="{{ $commission }}">
            </div>
            <div style="color:red;" ><center id='moneyerror'></center></div>
		</div>
	  <div class="p-reg-main" style='margin-top:0.08rem'>
         <div class="reg-button"><button type="button" class="mui-btn mui-btn-danger mui-btn-block">确认并提交</button></div>
      </div>
   </div>
@endsection

@section('my_js')
   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
    /*佣金转入余额，键盘和失焦js验证*/
    $("#moneyerror").text("");
    checkcommission();
    function checkcommission(){
        //键盘键入验证
        $("#money").keyup(function(){
            var maxcommoney = $(this).attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
            var realcommoney = parseInt($(this).val());                              //获取用户输入的真实金额
            if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
                $("#moneyerror").text("您输入的金额有误！");
                $(this).val("");//为空重置
                $("#money").focus();
                return false;
            }
            else if(realcommoney > maxcommoney){
                $("#moneyerror").text("提现金额不能超出账户余额" + maxcommoney + "元！");
                $(this).val(parseInt(maxcommoney));
            }
            else{
                $("#moneyerror").text("");
            }
        })
        /*失去焦点验证*/
        $("#money").blur(function(){
            var maxcommoney = $(this).attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
            var realcommoney = parseInt($(this).val());                              //获取用户输入的真实金额
            if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
                $("#moneyerror").text("您输入的金额有误！");
                $(this).val("");//为空重置
                $("#money").focus();
                return false;
            }
            else if(realcommoney > maxcommoney){
                $("#moneyerror").text("输入金额不能超出账户余额" + maxcommoney + "元！");
                $(this).val(parseInt(maxcommoney));
            }
            else{
                $("#moneyerror").text("");
            }
        })

    }
    $('.mui-btn').on('click', function(){
        var maxcommoney = $("#money").attr("data-maxmoney");                         //限制最大转入金额，其实为用户佣金金额
        var realcommoney = parseInt($("#money").val());                //获取用户输入的真实金额
        if( realcommoney == 0 || realcommoney == "" || realcommoney == null || isNaN(realcommoney)){
            $("#moneyerror").text("您输入的金额有误！");
            $("#money").val("");//为空重置
            $("#money").focus();
            return false;
        }
        else if(realcommoney > maxcommoney){
            $("#moneyerror").text("输入金额不能超出账户余额" + maxcommoney + "元！");
            $("#money").val(maxcommoney);
        }
        else{
            $("#moneyerror").text("");
            $(".mui-btn").val("正在转入...");
            $.post("{{url('/user_m/ajaxtomoney')}}",{'money':realcommoney,'_token':"{{csrf_token()}}"},function(data){
                if(data==null){
                    myalert('服务端错误');
                }
                if (data.status == 1){
                    myalert('充值成功，已到账，<BR>当前账户总余额￥'+data.msg+'元。')
                    location.href='/user_m/mycommission';
                    //location.reload();
                }
                if (data.status == 0){
                    myalert(data.msg);
                    $(".mui-btn").val("确认并提交");
                }
            },'json');
        }
    });


   </script>
@endsection



 



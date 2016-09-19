@extends('foreground.mobilehead')
@section('title', '申请提现')
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
	label{color:#333}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
    <p style="margin:0.1rem 0.5rem 0">为确保您申请的金额能购正确无误的转入您的账户，请填写真实有效的账户信息，以下信息为必填项</p>
      
	    <div class="mui-input-group"  style='margin-top:0.03rem;'>
            <div class="mui-input-row" >
               <label>佣金总余额</label>
               <div class='commission'>{{$commission}}元<span style='color:#999'>（满100元才能提现）</span></div>
            </div>
		</div>
        <div style="color:red;" ><center id='moneyerror'></center></div>
		<div class="mui-input-group"  style='margin-top:0.08rem;'>
            <div class="mui-input-row" >
               <label>提现金额</label>
               <input type="text" id="money"  placeholder="请输提现金额" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" data-maxmoney="{{ $commission }}">
            </div>            
		</div>
	  <div class="p-reg-main" style='margin-top:0.08rem'>
         <div class="mui-input-group" >
            <div class="mui-input-row" >
               <label>持卡人</label>
               <input type="text" id="bank_name" placeholder="请输入持卡人姓名" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');" maxlength="10">
            </div>
			<div class="mui-input-row">
               <label>银行卡</label>
               <input id="banknum" type="text" placeholder="请输入银行卡号" onkeyup="value=value.replace(/[^0-9]/g,'').replace(/\s/g,'');" maxlength="23">
            </div>
			<div class="mui-input-row">
               <label>开户行</label>
               <input type="text" id="bank_input" placeholder="请输入开户行" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');" maxlength="30">
            </div>
			<div class="mui-input-row">
               <label>支行</label>
               <input type="text" id="bank_subname" placeholder="请输入开户支行" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');" maxlength="30">
            </div>
         </div>
        <p style="margin:0.1rem 0.5rem 0">银行预留手机号必须与注册手机号码一致，否则佣金无法提现</p>
        <div class="reg-button"><button type="button" class="mui-btn mui-btn-danger mui-btn-block" onclick="addBank()">确认并提交</button></div>
      </div>
   </div>
@endsection

@section('my_js')
   <script>
	// myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
	// myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
        /*提现银行卡，键盘和失焦js验证*/
        checkmoney();
        function checkmoney(){
            //键盘键入验证
            $("#money").keyup(function(){
                var maxmoney = $(this).attr("data-maxmoney");        //限制最大转入金额，其实为用户账户金额
                var realmoney = parseInt($(this).val());             //获取用户输入的真实金额
                if( realmoney == 0 || realmoney == "" || realmoney == null || isNaN(realmoney)){
                    showError('您输入的金额有误！');
                    $(this).val("");
                    return false;
                }
                else if(realmoney > maxmoney){
                    $("#moneyerror").text("提现金额不能超出账户余额" + maxmoney + "元！");
                    $(this).val(parseInt(maxmoney));
                    return false;
                }
                else{
                    $("#moneyerror").text("");
                }
            })
            $("#banknum").keyup(function(){
                var cardno = $(this).val();
                $("#banknum").val(cardno.replace(/(\d{4})(?=\d)/g,'$1 '));
            })

        }
        function showError(str)
        {
            $("#moneyerror").text(str);
            $("#moneyerror").show();
            setTimeout("$('#moneyerror').hide()",5000);
        }
      // 添加和修改银行卡信息
        function addBank(){
            // 校验信息合法性
            $("#moneyerror").text('');
            var realmoney = $("#money").val();             //获取用户输入的真实金额
            if( realmoney == 0 || realmoney == ""){
                showError('请输入金额！');
                return false;
            }
            if( realmoney < 100){
                showError('输入金额不能少于100！');
                return false;
            }
            if($("#bank_name").val() == ""){
                showError('持卡人姓名不能为空');
                
                return false;
            }
            if($("#banknum").val() == ""){
                showError('卡号不能为空');
                return false;
            }
            var banknum = $("#banknum").val().replace(/ /g,'');
            if(banknum.length < 16 || banknum.length > 19){
                showError('卡号格式不正确');
                return false;
            }
            if($("#bank_input").val() == ""){
                showError('开户行不能为空');
                return false;
            }
            if($("#bank_subname").val() == ""){
                showError('支行不能为空');
                return false;
            }
            $.ajax({
                    type : 'post',
                    url : '/user_m/ajaxcommitobank',
                    data : {
                        subbranch : $("#bank_subname").val(),
                        bankname : $("#bank_input").val(),                        
                        username : $("#bank_name").val(),
                        banknum : banknum,
                        money : realmoney,
                         _token : "{{csrf_token()}}",
                    },
                    dataType : 'json',
                    success : function(data) {
                        if(data == null){
                            myalert('服务端错误！');
                        }
                        if(data.status == 1){
                            myalert('提交成功，后台审核中<BR>预计1-7个工作日到账');
                            location.reload();
                          //  location.href = '/user_m/mycommission';
                        }else {
                            myalert(data.msg);
                        }
                    }
            });
        }
   </script>
@endsection



 



@extends('foreground.mobilehead')
@section('title', '编辑地址')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">

   <link href="{{ $h5_prefix }}css/mui.picker.css" rel="stylesheet" />
   <link href="{{ $h5_prefix }}css/mui.poppicker.css" rel="stylesheet" />
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.mui-input-row label {
        width: 28%;
        padding: 18px 15px;
        color:#333;
        font-size: .14rem;
    }

    .mui-input-row label ~  input{
      width:72%;
    }

   </style>
@endsection

@section('content')
   <div class="mui-content" >
	  <div class="p-reg-main" style='margin-top:0.08rem'>
         <div class="mui-input-group" >
            <div class="mui-input-row" >
               <label>收货人</label>
               <input id="name" type="text" value="" placeholder="输入姓名"  maxlength="20" onkeyup="value=value.replace(/[^a-zA-Z\u4E00-\u9FA5]/g,'');">
            </div>
			<div class="mui-input-row">
               <label>手机号码</label>
               <input id="phone" type="text" value="" placeholder="输入手机号" maxlength="13" onkeyup="value=value.replace(/[^0-9]/g,'').replace(/\s/g,'');">
            </div>
<!--			<div class="mui-input-row">
               <label>固定号码</label>
               <input type="text" placeholder="例如0755-82556355" maxlength="11">
            </div>-->
			<div class="mui-input-row">
               <label>地址</label>
               <input id="showCityPicker3" type="text" readonly="readonly"  placeholder="XX省XX市XX县/区" maxlength="20">
            </div>

			<div class="mui-input-row">
               <label>详细地址</label>
               <input id="addrDetail" type="text" placeholder="输入详细地址" maxlength="35">
            </div>
            <div class="mui-input-row">
               <label>备注</label>
               <input id="notice" type="text" placeholder="例：充值qq为123456" maxlength="35">
            </div>
<!--            <div id='cityResult3' class="ui-alert"></div>-->
         </div>

         <button type="button" class="mui-btn mui-btn-danger mui-btn-block" style="width:90%; margin: 0.2rem auto">确认</button>
      </div>
   </div>
@endsection

@section('my_js')
   <script src="{{ $h5_prefix }}js/mui.picker.js"></script>
   <script src="{{ $h5_prefix }}js/mui.poppicker.js"></script>
   <script src="{{ $h5_prefix }}js/city.data.js" type="text/javascript" charset="utf-8"></script>
   <script src="{{ $h5_prefix }}js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
   <script>
       (function($) {

               //3级联示例
               var cityPicker3 = new $.PopPicker({
                   layer: 3
               });
               cityPicker3.setData(cityData3);
               var showCityPickerButton = document.getElementById('showCityPicker3');
               var cityResult3 = document.getElementById('cityResult3');
               var showCityPicker3 = document.getElementById('showCityPicker3');
               showCityPickerButton.addEventListener('tap', function(event) {
                   cityPicker3.show(function(items) {
                       var html =(items[0] || {}).text + " " + (items[1] || {}).text + " " + (items[2] || {}).text;
                    //   cityResult3.innerText = "你选择的城市是:" + html;
                        showCityPicker3.value = html;
                      
                       //返回 false 可以阻止选择框的关闭
                       //return false;
                   });
               }, false);

       })(mui);

        $("#phone").keyup(function(){
            var cardno = $(this).val();
            $("#phone").val(cardno.replace(/(\d{4})(?=\d)/g,'$1 '));
        })
        
        $(".mui-btn").click(function(){
            var name = $("#name").val();
            var phone = $("#phone").val().replace(/ /g,'');
            var address = $("#showCityPicker3").val();
            var addrDetail = $("#addrDetail").val();
            var notice = $("#notice").val();
            if(name == ''){
                myalert('收货人不能为空');
                return false;
            }
            if(phone == ''){
                myalert('手机不能为空');
                return false;
            }
            if(phone.length != 11){
                myalert('手机格式不正确');
                return false;
            }
            if(address == ''){
                myalert('收货地址不能为空');
                return false;
            }
            if(addrDetail == ''){
                myalert('收货详细地址不能为空');
                return false;
            }
            $.post("/user_m/saveaddress", { 'notice': notice,'name': name,'phone': phone,'address': address,'addrDetail': addrDetail,'action':'save','_token':"{{csrf_token()}}"}, function(data){
                     if (data.status == 1) {
                        myalert(data.msg);
                        location.href = '/user_m/addresslist';
                     } else {
                         myalert(data.msg);
                     }
            }, 'json');
        })
   </script>
@endsection



 



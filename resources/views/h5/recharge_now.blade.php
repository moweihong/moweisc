@extends('foreground.mobilehead')
@section('title', '充值')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <style>
      input[type='search']{text-align: center;}
   </style>
@endsection

@section('content')
   <div class="mui-content">
      <div class="recharge-now">
         <h2 class="rec-tith2 background-eeeeee">选择充值金额（元）</h2>
         <div class="recharge-list mui-clearfix background-ffffff ">
            <div class="rec-lbox" charge_num="10">10</div>
            <div class="rec-lbox" charge_num="20">20</div>
            <div class="rec-lbox" charge_num="50">50</div>
            <div class="rec-lbox" charge_num="100">100</div>
            <div class="rec-lbox" charge_num="200">200</div>
            <div class="rec-lbox rec-other-input" charge_num=""><input type="text" class="rec-lbox-other" maxlength="8" placeholder="其他" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  /></div>
         </div>
         <h2 class="rec-tith2 background-eeeeee">选择充值方式</h2>
         <div class="mui-input-group pay-type-cont background-ffffff">
            <div class="mui-input-row mui-radio pay-type-box weixin-div" data-type="weixin">
               <label style="width:100%; padding: 0;">
                  <span class="pay-typeimg pay-typeimg-wx"></span>
                  <span class="pay-typetit">微信支付</span>
                  <input name="paytype" type="radio" checked style="top:13px">
               </label>
            </div>
            {{--<div class="mui-input-row mui-radio pay-type-box" data-type="alipay">
               <label style="width:100%; padding: 0;">
                  <span class="pay-typeimg pay-typeimg-zfb"></span>
					<span class="pay-typetit">支付宝支付<span style="color:#999; font-size: 0.10rem;">（金额小于20元，不可使用支付宝）</span>
					<input name="paytype" type="radio" style="top:13px">
               </label>
            </div>--}}
            {{--<div class="mui-input-row mui-radio pay-type-box" data-type="unionpay">--}}
               {{--<label style="width:100%; padding: 0;">--}}
                  {{--<span class="pay-typeimg pay-typeimg-yl"></span>--}}
                  {{--<span class="pay-typetit">银联移动支付</span>--}}
                  {{--<input name="paytype" type="radio" @if(!$is_weixin) checked @endif  style="top:13px">--}}
               {{--</label>--}}
            {{--</div>--}}
             @if(!$is_weixin)
                 {{--<div class="mui-input-row mui-radio pay-tips" style="color:red;margin:0 auto;font-size:12px;height:80px">--}}
                     {{--当前浏览器不支持微信支付，请关注微信公众号直接支付：<br />--}}
                     {{--第一步：搜索并关注特速一块购公众号：ts1kg2016 <br />--}}
                     {{--第二步：点击底部菜单栏【一块就购】进入官网，登录后选择购物车进行结算--}}
                 {{--</div>--}}
             @endif

         </div>
         <div class="sdform-but recharge-but"><button  type="button" class="mui-btn mui-btn-danger mui-btn-block pay-button"  id='submit' >确认充值</button></div>
      </div>

   </div>
@endsection

@section('my_js')
   <script>
      $(function(){
    	  var ua = navigator.userAgent.toLowerCase();	
    		var equip = '';
    		if (/iphone|ipad|ipod/.test(ua)) {
    			equip = 'ios';		
    		} else if (/android/.test(ua)) {
    			equip = 'android';	
    		}
   
    	 	if(equip == 'android' && typeof(myObj) != 'undefined'){
                //$('.pay-tips').hide();
                $('.weixin-div').hide();

    			$("input[name='paytype']").removeAttr('checked');
    			var pay_html = '<div class="mui-input-row mui-radio pay-type-box" data-type="weixin_app">';
    			pay_html += '<label style="width:100%; padding: 0;">';
    			pay_html += '<span class="pay-typeimg pay-typeimg-wx"></span>';
    			pay_html += '<span class="pay-typetit">微信支付</span>';
    			pay_html += '<input name="paytype" type="radio" checked  style="top:13px">';
    			pay_html += '</label></div>';
          
//    			$(".pay-type-cont").prepend(pay_html);
    	 	}

    	 	if(equip == 'ios'){  
    	 		function setupWebViewJavascriptBridge(callback) {
    		        if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
    		        if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
    		        window.WVJBCallbacks = [callback];
    		        var WVJBIframe = document.createElement('iframe');
    		        WVJBIframe.style.display = 'none';
    		        WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
    		        document.documentElement.appendChild(WVJBIframe);
    		        setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0);
    		    }

    			setupWebViewJavascriptBridge(function(bridge) {
    				bridge.registerHandler('iosJavascriptHandler', function(data, responseCallback) {
                        //$('.pay-tips').hide();
                        $('.weixin-div').hide();

    					$("input[name='paytype']").removeAttr('checked');
   	    			var pay_html = '<div class="mui-input-row mui-radio pay-type-box" data-type="weixin_app">';
    	    			pay_html += '<label style="width:100%; padding: 0;">';
    	    			pay_html += '<span class="pay-typeimg pay-typeimg-wx"></span>';
    	    			pay_html += '<span class="pay-typetit">微信支付</span>';
    	    			pay_html += '<input name="paytype" type="radio" checked  style="top:13px">';
    	    			pay_html += '</label></div>';

//    	    			$(".pay-type-cont").prepend(pay_html);

                        /* mtz STAR */
//						$('.rec-tith2').hide();
//                        $('.pay-type-cont').hide();
//                        $('.sdform-but').hide();
						 /* mtz  END*/
    	    			
    					responseCallback({'message' : 'ok!'});
    				})
    			})
    	 	}
    	 	
         /*选择金额 当前金额*/
         $(".recharge-list .rec-lbox").click(function(){
            var moneyval = $(this).attr("charge_num");                                  // 获取当前金额数值
            $(this).addClass("rec-lbox-curr").siblings(".rec-lbox").removeClass("rec-lbox-curr");  // 移除其他选中红框状态
            $(".rec-other-input .rec-lbox-other").blur(function(){                       //选择其他金额情况 填充金额
               var othmoney = $(this).val()
               $(this).parent(".rec-other-input").attr("charge_num",othmoney);
            })
            if(!$(this).hasClass("rec-other-input")){                                  //选择其他金额情况，再点击定制金额，清楚数据为空
               $(".rec-lbox-other").val("");
               $(".rec-other-input").attr("charge_num","");
            }
         })

         //提交
         $("#submit").click(function(){
            if(!$(".recharge-list .rec-lbox").hasClass("rec-lbox-curr")){
               myalert("请选择金额！");
               return false;
            }
            
            var recharge_money = parseInt($('.rec-lbox-curr').attr('charge_num'));
            var paytype = $("input[name='paytype']:checked").parents('.pay-type-box').attr("data-type");
            var _token = $("input[name='_token']").val();

            if(!recharge_money && recharge_money <= 0){
            	myalert("请输入充值金额，充值金额不能为0！");
                return false;
            }
            
            $.ajax({      
				type:"post",
				url:"/chargeSubmit_m",
				data:{'_token':_token,paytype:paytype,recharge_money:recharge_money},       
				async :false,
				dataType:'json',
				success:function(res){   
					if(res.status == 0){   
						$('body').append(res.data.form);
					} 
				}    
			});
  
			$("#subform").submit();
         })

      })
   </script>
@endsection



 
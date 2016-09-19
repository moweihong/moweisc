@extends('foreground.mobilehead')
@section('title', '我的订单')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/pay_m.css">
@endsection

@section('content')
<div class="mui-content">
    <div class="goods-total">
        <div class="goods-num">
            <label>商品总数</label>
            <span>{{$count}}件</span>
        </div>
        <div class="goods-money">
            <label>商品总额</label>
            <span>{{$total_amount}}元</span>
        </div>
       <div class="arrow-bg"><div class="arrow-down"></div></div>
        <div class="goods-desc">
        	@foreach($goods_info as $good)
            	<div><p>第 ( {{$good['periods']}}期 ) {{$good['title']}}</p><p class="join-num">参与<span>{{$good['bid_cnt']}}</span>人次</p></div>
           	@endforeach
        </div>
    </div>

    <div class="balance-pay">

        <p>余额支付<span>(帐户余额：￥{{$user['money']}})</span><span style="position:absolute;right:10px;color:red" class="minus-money">-{{number_format(floatval($minus_money), 2)}}</span></p>
        <p>块乐豆抵扣<span>(剩余块乐豆：{{$user['kl_bean']}})</span><span class="ab-right mui-radio"><input type="radio" name="deduction" value="klbean" class="radion-klbean"/><input type="radio" name="deduction1" value="klbean" class="radion-klbean1" style="display:none;"/></span></p>
        <p style="color:red;font-size: .1rem;" class="klbean_tips hide">使用<span class="use-klbean">0</span>块乐豆抵扣<span class="pay-klbean">0.00</span>块<span style="position:absolute;right:10px;color:red" class="minus-klbean">-0.00</span></p>
		@if(empty($red))	
        	<p>红包抵扣<span class="ab-right mui-radio">没有可用红包&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="red" disabled  class="out-of-balance"/> </span></p>
		@else
        	<p>红包抵扣<span class="ab-right mui-radio"><input type="radio" name="deduction" value="red" class="radion-red"/>  <input type="radio" name="deduction1" value="red" class="radion-red1" style="display:none;"/></span></p>
            <div class="pack-group">
            	@foreach($red as $key => $info)
            	<div class="pack-item" data-id="{{$key}}"><div><img src="{{ $h5_prefix }}images/cash-packge-ioc.png"/><span>{{$info['name']}}</span></div></div>
            	@endforeach
            </div>
		@endif
    </div>
    @if($is_show_pay == 1)
    <div class="pay-channel">
        <div class="pay-title">选择充值方式</div>
        <p class="weixin-p"><i class="weixin-ioc" ></i>微信支付<span class="ab-right mui-radio"><input type="radio" name="paytype" value='weixin' checked /> </span></p>
        {{--<p><i class="zhifubao-ioc"></i>支付宝<span class="ab-right mui-radio"><input type="radio" name="paytype" value='alipay' /> </span></p>--}}
        {{--<p><i class="bank-ioc"></i>银联移动支付<span class="ab-right mui-radio"><input type="radio" name="paytype" value='unionpay'  @if(!$is_weixin) checked @endif/> </span></p>--}}
        {{--<p><i class="bank-ioc"></i>网银在线支付<span class="ab-right mui-radio"><input type="radio" name="paytype" value='jdpay'  @if(!$is_weixin) checked @endif/> </span></p>--}}
        @if(!$is_weixin)
            {{--<div class="mui-input-row mui-radio pay-tips" style="color:red;margin:0 auto;font-size:12px">--}}
                {{--当前浏览器不支持微信支付，请关注微信公众号直接支付：<br />--}}
                {{--第一步：搜索并关注特速一块购公众号：ts1kg2016 <br />--}}
                {{--第二步：点击底部菜单栏【一块就购】进入官网，登录后选择购物车进行结算--}}
            {{--</div>--}}
        @endif
    </div>
	@endif
    <div class="main-btn pay-button" id="sub-pay" >立即支付</div>
    <input type="hidden" name="code" value="{{$code}}" id="code"/>
    
    <div class="hide" id="pay_div"></div>
</div>
<script>
    $(".arrow-down").bind("touchstart",function(){
        if($(".goods-desc").css("display")==='none'){
            $(".goods-desc").slideDown(500);
            $(".arrow-down").addClass("arrow-up");
        }else {
            $(".goods-desc").slideUp(500);
            $(".arrow-down").removeClass("arrow-up");
        }
    });
//     $("[name='deduction1']").click(function(){
//         var deduction = $(this).val();alert(deduction);
//       var hideradio=$("[name='deduction1']").find('.radio-'+deduction);
//        if(hideradio.checked){
//            this.checked=false;
//             hideradio.checked=false;
//         }else{
//          hideradio.checked=true;
//         }
//     });
</script>
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
        $('.weixin-p').hide();

		$("input[name='paytype']").removeAttr('checked');
//		$(".pay-title").after('<p><i class="weixin-ioc" ></i>微信支付<span class="ab-right mui-radio"><input type="radio" name="paytype" value="weixin_app" checked/> </span></p>');
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
                $('.weixin-p').hide();

				$("input[name='paytype']").removeAttr('checked');
//				$(".pay-title").after('<p><i class="weixin-ioc" ></i>微信支付<span class="ab-right mui-radio"><input type="radio" name="paytype" value="weixin_app" checked/> </span></p>');
//                $(".pay-channel").hide();  //mtz
				responseCallback({'message' : 'ok!'});
			})
		})
 	}
	
	$('.pack-item').click(function(){
        if($("input[name='deduction']:checked").val() == 'klbean'){
            myalert('红包抵扣和块乐豆抵扣不能同时使用');
            return false;
        }

		if($(this).hasClass('active')){
			$('.pack-item').removeClass('active');
			$(".radion-red").prop('checked', false);
		}else{
			$("input[name='red']").prop('checked', true);
			//$('.radio-red').removeClass('active');
            $('.pack-item').removeClass('active');
			$(this).addClass('active');
            $(".radion-red").prop('checked', true);
		}
		
		refreshPayAmount();
	})
	
	$("input[name='deduction']").click(function(){
        $deduction = $(this).val();
		if($deduction == 'klbean'){
            if($(this).hasClass('choosed')){
                $(this).prop("checked", false);
                $(this).removeClass('choosed');
                $('.klbean_tips').hide();
            }else{
                $(this).addClass('choosed');
                $('.radion-red').removeClass('choosed');
            }

            $('.pack-item').removeClass('active');
        }else{
            if($(this).hasClass('choosed')){
                $(this).prop("checked", false);
                $(this).removeClass('choosed');
                $('.pack-item').removeClass('active');
            }else{
                $(this).addClass('choosed');
                $('.radion-klbean').removeClass('choosed');
                //默认选择抵扣金额最大的（第一个）
                $('.pack-item:first').click();
            }

            $('.klbean_tips').hide();
        }

		refreshPayAmount();
	})

	$('#sub-pay').click(function(){
		var _token = $("input[name='_token']").val();
		var code = $('#code').val();
		var red = 0, klbean = 0;
        var deduction = $("input[name='deduction']:checked").val();

		var paytype = '';
		if($('.pay-channel').css('display') != 'none'){
			paytype = $("input[name='paytype']:checked").val();
		}
		
		if(!paytype || paytype == '' || paytype == 'undefined'){
			paytype = 'yue';
		}
		
		//是否使用红包
		$('.pack-item').each(function(){
			if($(this).hasClass('active')){
				red = $(this).attr('data-id');
				return false;
			}
		})

        //是否使用块乐豆
        if(deduction == 'klbean'){
            klbean = 1;
        }

        if(klbean && red){
            myalert('红包抵扣和块乐豆抵扣不能同时使用');
            return false;
        }

		$.ajax({
			url: '/paySubmit_m',
			type: 'POST',
			dataType: 'json',
			async :false,
			data: {_token:_token,red:red,code:code,paytype:paytype,klbean:klbean},
			success: function(res){
				if(res.status == 0){
					$('#pay_div').html(res.data.form);
					$('#subform').submit();
				}else{
					myalert(res.message);
				}
			}
		})
	})
})

function refreshPayAmount(){
	var _token = $("input[name='_token']").val();
	var code = $('#code').val();
	var red = 0, klbean = 0;
    var deduction = $("input[name='deduction']:checked").val();

	//是否使用红包
	$('.pack-item').each(function(){
		if($(this).hasClass('active')){
			red = $(this).attr('data-id');
			return false;
		}
	})

    //是否使用块乐豆
    if(deduction == 'klbean'){
        klbean = 1;
    }

    if(klbean && red){
        myalert('红包抵扣和块乐豆抵扣不能同时使用');
        return false;
    }

	$.ajax({
		url: '/refreshPayAmount_m',
		type: 'POST',
		dataType: 'json',
		data: {_token:_token,red:red,code:code,klbean:klbean},
		success: function(res){
			if(res.status == 0){
				if(res.data.pay_amount == 0){
					$('.pay-channel').css('display', 'none');
				}else{
					$('.pay-channel').css('display', 'block');
				}
				$('.minus-money').html('-'+res.data.minus_money);
                $('.minus-klbean').html('-'+res.data.minus_klbean);
                $('.pay-klbean').html(res.data.minus_klbean);
                $('.use-klbean').html(res.data.minus_klbean*100);

                if(res.data.minus_klbean > 0){
                    $('.klbean_tips').show();
                }else{
                    $('.klbean_tips').hide();
                }
			}else{
				$('.pack-item').removeClass('active');
                $(".radio-red").prop('checked', false);
				myalert(res.message);
			}
		}
	})
}
</script>
@endsection



 
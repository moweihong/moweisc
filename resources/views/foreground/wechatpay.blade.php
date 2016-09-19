@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css"/>
@endsection
@section('content')
<!--wechatpay start-->
<div class="footnews-container clearfix">
    <div class="wechatpay-container">
        <!--订单号 start-->
        <div class="wxpaytop clearfix">
            <div class="o-left">
                <h2 class="o-title">请您及时付款，以便订单尽快处理！ 订单号：{{ $code }}</h2>
                <input type="hidden" value="{{ $code }}" id="code" />
                <p class="o-titdes">请您在提交订单后<span class="red-color">30分钟</span>内完成支付，否则订单会自动取消。</p>
            </div>
            <div class="o-right">
                <div class="o-rightit">应付金额<strong class="ord-wxprice">{{ $charge_amount }}</strong>元</div>
<!--                 <div class="o-righlink"><a href="#">订单详情 ></a></div> -->
            </div>
        </div>
        <!--订单号 end-->
        <!--order start-->
        <div class="wxpay-content">
            <h2 class="wxpay-h2tit">微信支付</h2>
            <!--main start-->
            <div class="wx-p-main clearfix">
                <div class="wx-p-box">
                    <div class="wx-p-btit">
<!--                         <span class="wxp-countdown">距离二维码过期还剩 <b class="countdown-time">60</b> 秒，过期后请刷新页面重新获取二维码。</span> -->
<!--                         <span class="wxp-imgover">二维码已过期，<a href="javascript:window.location.reload();">刷新</a>页面重新获取二维码。</span> -->
                    </div>
                    <div class="wxbg-img" style="border:1px solid #dddddd">{!! QrCode::size(288)->generate($url); !!}</div>
                    
                    <div class="wxbg-des">请使用微信扫一扫<br />扫描二维码支付</div>
                </div>
                <div class="wx-p-sldebar"></div>
            </div>
            <!--main end-->
            <!--other start-->
<!--             <div class="wxpay-other"> -->
<!--                 <h2 class="wxpay-othh2"><i><</i><a href="#">选择其他支付方式</a></h2> -->
<!--             </div> -->
            <!--otert end-->
        </div>
        <!--order end-->
    </div>
</div>
<!--wechatpay end-->
@endsection
@section("my_js")
    <script>
        $(function(){
            //1分钟倒计时
//             var wait= 60;
//             var yzmobj = $(".countdown-time");
//             time();
//             function time() {
//                 if (wait == 0)
//                 {
//                    $(".wxp-countdown").hide().siblings(".wxp-imgover").show();
//                 }
//                 else{
//                         yzmobj.html(wait);
//                         wait--;
//                         $(".wxp-imgover").hide().siblings(".wxp-countdown").show();
//                         setTimeout(function() {
//                             time(yzmobj)
//                         },1000)
//                      }
//              }
			
			setInterval('checkOrder()', 2000);
        });

        function checkOrder(){
			var code = $('#code').val();
			$.ajax({
				url: '/weixin/check',
				type: 'post',
				dataType: 'json',
				data: {code:code},
				success: function(res){
					if(res.status == 0){
						window.location.href = '/weixin/result';
					}
				}
			})
        }
    </script>
@endsection
@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css"/>
@endsection
@section('content')
<!--wechatpay start-->
<div class="footnews-container clearfix">
    <div class="wechatpay-container">
        <!--order start-->
        <div class="wxpay-content" style="border:0">
            <!--main start-->
            <div class="wx-p-main clearfix">
                <div class="wx-p-box" style="width:500px;display:block;float:none;margin-left:450px;font-size:20px">
                        <span class="wxp-countdown">支付成功，页面将在<b class="countdown-time">5</b> 秒后跳转，点击跳转<a href="/user/buy" style="font-size:20px;color:blue;text-decoration:underline;">购买记录</a></span>
						
						

			   </div>
			   <p style='font-size:14px;width:92%;margin:0 auto;padding-top:24px'>
			   您已付款成功！正在为您分配块乐码！<br>
			   温馨提示：成功付款后系统会自动为您分配块乐码，获得块乐码表示成功参与当期一块购；若未能获得块乐码，则表示您未能成功参与一块购，
			   所支付的款项会在3-15个工作日内退还至您的名下账户！<br>
			   成功参与众筹后，所支付款项将用于为当期幸运用户购买商品，不能退回！若成功抢到商品，会有短信通知您完善收获地址，若未能抢到商品，
			   订单状态会自动变更为已完成！感谢您的支持！<br>
			   </p>
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
            var wait= 5;
            var yzmobj = $(".countdown-time");
            time();
            function time() {
                if (wait == 0)
                {
                   //$(".wxp-countdown").hide().siblings(".wxp-imgover").show();
                    window.location.href = '/user/buy';
                }
                else{
                        yzmobj.html(wait);
                        wait--;
                        $(".wxp-imgover").hide().siblings(".wxp-countdown").show();
                        setTimeout(function() {
                            time(yzmobj)
                        },1000)
                     }
             }
        });
    </script>
@endsection
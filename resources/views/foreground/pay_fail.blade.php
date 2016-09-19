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
                <div class="wx-p-box" style="width:500px;display:block;float:none;margin-left:400px;font-size:20px">
                    @if(isset($flag) && $flag == 1)
                    	<span class="wxp-countdown">您购买的期数库存不足，充值金额将会自动转入您的余额账户中，页面将在<b class="countdown-time">5</b> 秒后跳转，点击跳转<a href="/user/buy" style="font-size:20px;color:blue;text-decoration:underline;">购买记录</a></span>
                	@elseif(isset($flag) && $flag == 2)
                		<span class="wxp-countdown">充值失败，请联系客服人员！</span>
                    @elseif(isset($flag) && $flag == 3)
                        <span class="wxp-countdown">您的余额不足，购买失败，充值金额将会自动转入您的余额账户中，页面将在<b class="countdown-time">5</b> 秒后跳转，点击跳转<a href="/user/buy" style="font-size:20px;color:blue;text-decoration:underline;">购买记录</a></span>
                    @else
                		<span class="wxp-countdown">{{$message}}，页面将在<b class="countdown-time">5</b> 秒后跳转，点击跳转<a href="/user/buy" style="font-size:20px;color:blue;text-decoration:underline;">购买记录</a></span>
                	@endif
                </div>
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
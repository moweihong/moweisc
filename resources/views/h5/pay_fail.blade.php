@extends('foreground.mobilehead')
@section('title', '支付结果')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
<div class="mui-content">
        <!--null start-->
        <div class="cart-null">
            <div class="success-tick"><span class="mui-icon mui-icon-closeempty"></span></div>
            @if(isset($msg))
            	<p class="cart-nulltxt">{{$msg}}，页面将在<b class="countdown-time">5</b> 秒后跳转，</p>
            @else
            	<p class="cart-nulltxt">@if(isset($message)) {{$message}} @else 购买失败 @endif，页面将在<b class="countdown-time">5</b> 秒后跳转，</p>
            @endif
            <a href="/user_m/buy" class="cart-nulllinks">去购买记录~</a>
        </div>
        <!--null end-->
</div>
@endsection

@section('my_js')
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
                    window.location.href = '/user_m/usercenter2';
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



 
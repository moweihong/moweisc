@extends('foreground.mobilehead')
@section('title', '支付结果')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
	<style>
		.fkcg{font-size:0.20rem;color:#333;margin:0.2rem 0 0.55rem}
		.cart-null{width:100%}
		.cart-null .cart-nulllinks{width:90%}
		.wxts,.wxts h2{color:#333}
		.wxts{width:90%;margin:0.12rem auto;text-align:left;}
	</style>
@endsection

@section('content')
<div class="mui-content">
        <!--null start-->
        <div class="cart-null">
            <div class="success-tick"><span class="mui-icon mui-icon-checkmarkempty"></span></div>
            <p class="cart-nulltxt">支付成功，页面将在<b class="countdown-time">3</b> 秒后跳转首页，</p>
			{{--<p class='fkcg'>付款成功</p>--}}
            <a href="/user_m/buy" class="cart-nulllinks">去购买记录~</a>
			<div class='wxts'>
				<h2>温馨提示</h2>
				1.成功付款后系统会自动为您分配块乐码，获得块乐码表示成功参与当期众筹；若未能获得块乐码，
				则表示您未能成功参与众筹，所支付的款项会在3-15个工作日内退还至您的名下账户！
				<br/>
				<br/>
				2.成功参与众筹后，所支付款项将用于为当期幸运用户购买商品，不能退回！若成功抢到商品，
				会有短信通知您完善收获地址，若未能抢到商品，订单状态会自动变更为已完成！感谢您的支持！
			</div>
        </div>
        <!--null end-->
        <!--猜你喜欢 start-->
{{--        <div class="faxbox sdshare-box">
            <h2 class="faxboxh2 announce-boxtit">
                <a href="#">
                    <span class="boxtit-h2">猜你喜欢</span>
                </a>
            </h2>

            <div class="guess-pro mui-clearfix">
                <div class="guess-probox">
                    <a href="#">
                        <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
                        <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
                        <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
                    </a>
                </div>
                <div class="guess-probox">
                    <a href="#">
                        <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
                        <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
                        <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
                    </a>
                </div>
                <div class="guess-probox">
                    <a href="#">
                        <div class="gue-proimg"><img src="{{ $h5_prefix }}images/product.jpg" /></div>
                        <span class="gue-protxt">Apple iPhone6s 16G 颜色随机</span>
                        <div class="gue-progress"><div class="gue-progress-div" style="width: 80%;"></div></div>
                    </a>
                </div>
            </div>

        </div> --}}
        <!--猜你喜欢 start-->
</div>
@endsection

@section('my_js')
    <script>
    	var is_charge = {{isset($is_charge) ? $is_charge : 1}};
        $(function(){
            //1分钟倒计时
            var wait= 3;
            var yzmobj = $(".countdown-time");
            time();
            function time() {
                if (wait == 0)
                {
                    window.location.href = '/index_m';
                   //$(".wxp-countdown").hide().siblings(".wxp-imgover").show();
                   if(is_charge == 1){
                	  // window.location.href = '/user_m/usercenter2';
                   }else{
                	  // window.location.href = '/user_m/buy';
                   }
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



 
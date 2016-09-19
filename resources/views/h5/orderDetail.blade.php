@extends('foreground.mobilehead')
@section('title', '订单进度')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	html{background-color:#EFEFF4}
   </style>
@endsection

@section('content')
   <div class="mui-content" >   
		<div class='order_detail_title'>
			<p>特速一块购&nbsp;&nbsp;13888888888</p>
			<p>广东省深圳市 福田区 XX街道 XXXX小区</p>
		</div>
         
		 <div class="xxzz">
			<div class='xxzz_title'>信息追踪</div>
			<div class='xxzz_co'>
				您的商品【金龙鱼 黄金比例 食用调和油 5L】已由<span id=''>顺丰速递</span>发出。
				订单号:<span>102562562585</span>。请留意收货。
			</div>
		 </div>
        
		<div class="ddxq">
			<div class="ddxq2">
				<div class="ddxq3"><img src="{{$h5_prefix}}images/sj.png" alt=""></div>
				<div class="ddxq4">
					<h2>(第90341云) 小米 红米 Note 增强版4G手机 双卡......</h2>
					<p>幸运块乐码：1000020</p>
					<p>揭晓时间：2016-03-12 10:16</p>
					<img src="{{$h5_prefix}}images/proShare.png" alt="">
				</div>
			</div>
		</div>
	   <div class="reg-button"><button type="button" class="mui-btn mui-btn-danger mui-btn-block">确认收货</button></div>
 
   </div>
@endsection

@section('my_js')
 
@endsection



 



@extends('foreground.mobilehead')
@section('title', '发现')
@section('footer_switch', 'show')
@section('my_css')
   {{--<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/footer_menu.css">--}}
	<style>
		.mui-table-view-cell:after{left:0px}
		.img_item{width: 60px; vertical-align:baseline;}
		.mui-table-view-cell img{margin-right: 10px;}
		.item{display: inline-block; padding-left: 20px; margin-top: 10px;}
		.item span b{font-size: 16px; font-weight: normal; color:#333; font-family: "Microsoft yahei"}
		.mui-table-view-cell p{ margin-top: 8px; font-family: "Microsoft yahei"}
	</style>
@endsection

@section('content')
 <div class="mui-content paddingbot90">
 	<ul class="mui-table-view">
 		<li class="mui-table-view-cell" data-url="share_m">
 			<a class="mui-navigate-right">
 				<img src="{{ $h5_prefix }}images/find_01.png" class="img_item" style="vertical-align: sub;" />
 				<div class="item">
 					<span><img style="vertical-align:middle;" src="{{ $h5_prefix }}images/H.png"/><b>晒单分享</b></span>
 					<p>听说晒出来运气会翻倍，还能赢块乐豆哦！</p>
 				</div>
 			</a>
 		</li>
 	</ul>
	 <ul class="mui-table-view" style="margin-top: 0.8rem">
		 <li class="mui-table-view-cell" data-url="freeday_m">
			 <a class="mui-navigate-right">
				 <img src="{{ $h5_prefix }}images/find_02.png" class="img_item" />
				 <div class="item">
					 <span><img style="vertical-align:middle;" src="{{ $h5_prefix }}images/H.png"/><b>幸运转盘</b></span>
					 <p>现金红包，天天抢到手软！</p>
				 </div>
			 </a>
		 </li>
		 <li class="mui-table-view-cell"  data-url="makemoney_m_new">
			 <a class="mui-navigate-right">
				 <img src="{{ $h5_prefix }}images/find_03.png" class="img_item"/>
				 <div class="item">
					 <span><img style="vertical-align:middle;" src="{{ $h5_prefix }}images/H.png"/><b>我要赚钱</b></span>
					 <p>还有比躺着赚钱更兴奋的事吗！</p>
				 </div>
			 </a>
		 </li>
		 <li class="mui-table-view-cell"  data-url="partner_m">
			 <a class="mui-navigate-right">
				 <img src="{{ $h5_prefix }}images/find_04.png" class="img_item"/>
				 <div class="item">
					 <span><img style="vertical-align:middle;" src="{{ $h5_prefix }}images/H.png"/><b>招募合伙人</b></span>
					 <p>百万年薪的梦想，就要实现了呢！</p>
				 </div>
			 </a>
		 </li>
	 </ul>
 </div>


@endsection




 
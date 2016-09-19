@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/wdfx.css"></link>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
@endsection

@section('content')
        <!--content start-->
<!-- 导航   end  -->
<!--banner start-->

<!--banner start-->
<!--content start-->
<!--<div class="w_con"  style="padding: 30px;">
<div><b>晒单用户：</b>{{$show->nickname }}</div>
   <div><b>晒单标题：</b>{{$show->sd_title }}</div>
   <div><b>晒单内容：</b>{{$show->sd_content }}</div>
   <div><b>中奖商品：</b>{{$show->title }}</div>
   <div><b>晒单奖励：</b>获得块乐豆：{{$show->kl_bean }}</div>
   <div>
   	@foreach($show->sd_photolist as $v)
   	<img src="{{$v}}" style="width: 300px;height: 300px;">
   	@endforeach
   </div>
</div>-->
    <!-- <div id="pageStr" class="pageStr" style="margin: 64px auto;"><span class="f-noClick"><a href="javascript:;"><i
             class="f-tran f-tran-prev">&lt;</i>上一页</a></span><span class="current"><a>1</a></span><span><a
             href="javascript:;" class="tcdNumber">2</a></span><span><a href="javascript:;"
                                                                        class="tcdNumber">3</a></span><span><a
             href="javascript:;" class="tcdNumber">4</a></span><span>...</span><span><a href="javascript:;"
                                                                                        class="tcdNumber">30</a></span><span><a
             title="下一页" href="javascript:;" class="nextPage">下一页<i class="f-tran f-tran-next">&gt;</i></a></span><span
             class="f-mar-left">共<em>30</em>页，去第</span><span><input type="text" id="txtGotoPage" value="1">页</span><span
             class="f-mar-left"><a title="确定" href="javascript:;" id="btnGotoPage">确定</a></span></div>
 </div>-->
    <!--content end-->


<!--content end-->
<div class="share_detail_ct">
	<h1>{{$show->sd_title }}</h1>
	<div class="winner_info">
		<div class="winner_info_left"><img src="{{$show->user_photo}}"></div>
		<div class="winner_info_right">
			<p><label>商品名称：</label><a href='/product/{{$periods}}' title='{{$show->title }}'><span>{{$show->title }}</span></a></p>
			<p><label>获得者：</label><span>{{$show->nickname}}</span></p>
			<p><label>本次参与：</label><span>{{$buycount}}</span>人次</p>
			<p><label>幸运号码：</label><span>{{$fetchno}}</span></p>
			<p><label>揭晓时间：</label><span>{{date('Y-m-d',$show->lottery_time/1000)}}</span></p>
		</div>
		<a href='/product/{{$periods}}'><div class="lj_btn"><input type="button" value="立即一块购" /></div></a>
	</div>
	<div class="share_detail">
	{{$show->sd_content}}
	</div>
	
	
	
	<div class="share_imgs">
		@foreach($show->sd_photolist as $v)
		<img src="{{$v}}" style="width:500px;">
		@endforeach
	</div>
</div>

@endsection

@section('my_js')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
{{--<script type="text/javascript" src="{{ $url_prefix }}js/banner.js"></script>--}}
<script type="text/javascript" src="{{ $url_prefix }}js/wdfx.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/owl.carousel.js"></script>
@endsection

@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/wdfx.css"></link>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
    <script type="text/javascript" src="{{ $url_prefix }}js/slider.js"></script><!--轮播图 -->
    <script type="text/javascript">
$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 1800,
		event: 'hover',
		auto: true,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		bannerSlider.prev()
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next()
	});
})
</script>
@endsection

@section('content')
        <!--content start-->
<!-- 导航   end  -->
<!--banner start-->
    <style>
    	.flexslider{
    		  height: 245px !important;
    	}
    	.slides a {
    		  height: 245px !important;
    	}
    </style>
<div id="banner_tabs" class="flexslider">
    	<ul class="slides">
            <li>
            	<a class="item" style="background-image: url({{ $url_prefix }}img/goods/niyoubenshi.jpg);"></a>
				
		</li>
		<li>
			<a class="item" style="background-image: url({{ $url_prefix }}img/goods/shaidanyoujiang.jpg);"></a>
		</li>
       </ul>
       <ul class="flex-direction-nav">
		<li><a class="flex-prev" >Previous</a></li>
		<li><a class="flex-next" >Next</a></li>
	</ul>
	<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
		<li><a>1</a></li>
		<li><a>2</a></li>
	</ol>
  </div>
<!--banner start-->
<!--content start-->
<div class="w_con">
    <h2 class="w_title">全部晒单<b>（共{{ $totalnum }}条晒单）</b></h2>
    <input type="hidden" id='userid' value="{{ $userid }}">
    <div class="w_share">
        <!--第一列-->
        <dl class="w_share_one">
        	@foreach($sdlist as $v)
            <dd class="w_oneself_share"><a href="/sharedetail/{{$v->id }}">
                <img class="lazy0" data-original="{{$v->sd_thumbs }}" src="{{$v->sd_thumbs }}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading3.png';"  style="display: inline;">
            </a>
                <a href="/sharedetail/{{$v->id }}">(第 {{$v->sd_periods }}期) {{$v->title }}</a>
                <p title="{{$v->sd_content }}"
                   style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;display:block;">
                    {{$v->sd_content }}<br>{{ date('Y-m-d H:i:s',$v->sd_time) }}</p>
                <div class="w_single">
                   <div class="idiv"><img src="{{ $v->user_photo  }}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';" class="ihead"/><span class="ispan">{{$v->nickname }}</span> </div>
                   <div class="comment-div">
                       <div class="comment-border"><p>羡慕</p><i><img src="{{ $url_prefix }}img/wujiaoxin_white.png" data-id='{{$v->id }}' data-type='1' alt=""></i></div>
                        <span class="comment-person">{{$v->sd_admire }}</span>
                   </div>
                    <div class="comment-div">
                        <div class="comment-border"><p>嫉妒</p><i><img src="{{ $url_prefix }}img/wujiaoxin_white.png" data-id='{{$v->id }}' data-type='2' alt=""></i></div>
                        <span class="comment-person">{{$v->sd_jeal }}</span>
                    </div>
                    <div class="comment-div">
                        <div class="comment-border c-width"><p style="width:27px;">恨</p><i><img src="{{ $url_prefix }}img/wujiaoxin_white.png" data-id='{{$v->id }}' data-type='3' alt=""></i></div>
                        <span class="comment-person">{{$v->sd_hate }}</span>
                    </div>
                </div>
            </dd>
            @endforeach
          

        </dl>
    </div>
    </div>
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
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $sdlist->render() !!}
</div>

<!--content end-->


@endsection

@section('my_js')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
{{--<script type="text/javascript" src="{{ $url_prefix }}js/banner.js"></script>--}}
<script type="text/javascript" src="{{ $url_prefix }}js/wdfx.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/owl.carousel.js"></script>
@endsection

@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/wdfx.css"></link>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
	<link rel="stylesheet" type="text/css" href="{{	$url_prefix	}}css/buyHistory.css">
@endsection

@section('content')
<div class="ygRecord">
        <h3>
            <span>最新众筹记录</span><p style="color:#333333;">本页显示最新众筹记录<strong>100</strong>条 <a href="/getHistoryRecord">查看历史众筹记录&gt;&gt;</a></p>
        </h3>
        <ul class="Record_title">
            <li class="time">众筹时间</li>
            <li class="nem">会员账号</li>
            <li class="name">众筹商品名称</li>
            <li class="much">众筹人次</li>
        </ul>
        <div id="recordList">
    @foreach($list as $v)
	<ul class="Record_contents">
	    <li class="time">{{ date('Y-m-d H:i:s',$v->bid_time/1000). '.' . substr($v->bid_time, -3) }}</li>
	    <li class="nem" ><a class="blue"  title='{{$v->nickname}}'>{{ str_limit($v->nickname,26,'...') }}</a></li>
	    <li class="name"><a href="/product/{{ $v->o_id }}">（第{{ $v->g_periods }}云）{{ $v->g_name }}</a></li><li class="much">{{ $v->buycount }}人次</li>
	</ul>
	@endforeach
	
	</div>
        <div class="endpage" style="color:#333333;">本页显示最新众筹记录<strong>100</strong>条 <a href="/getHistoryRecord" rel="nofollow">查看历史众筹记录&gt;&gt;</a></div>
    </div>




<!--content end-->


@endsection

@section('my_js')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
{{--<script type="text/javascript" src="{{ $url_prefix }}js/banner.js"></script>--}}
<script type="text/javascript" src="{{ $url_prefix }}js/wdfx.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/owl.carousel.js"></script>
@endsection

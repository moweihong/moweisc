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
            <span>最新众筹记录</span><p style="color:#333333;"><a href="/getLatestRecord">查看最新众筹记录&gt;&gt;</a></p>
        </h3>
	
	<div class="timeDiv"><dl class="b_choose_cal" style="">
							<form action="/searchRecord" method="post">
                            <dd>选择时间段：</dd>
                            <dd><input name="stime" id="invite_result_startTime" readonly="true" type="text" value="{{$stime or ''}}"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd>
                            	<input name="etime" id="invite_result_endTime" readonly="true" type="text" value="{{$etime or '' }}">
                            	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            </dd>
                            
                            <dd  ><input type="submit" value="搜索"></dd>
                            </form>
		    </dl>
	 </div>
        <ul class="Record_title">
            <li class="time">众筹时间</li>
            <li class="nem">会员账号</li>
            <li class="name">众筹商品名称</li>
            <li class="much">众筹人次</li>
        </ul>
        <div id="recordList">
	 @foreach($list as $v)
	<ul class="Record_contents">
	    <li class="time">{{   microtime_format('Y/m/d H:i:s.x', $v->bid_time) }}</li>
	    <li class="nem"><a class="blue" href="javascript:;" title='{{$v->nickname}}' target="_blank">{{str_limit($v->nickname,26)}}</a></li>
	    <li class="name"><a href="/product/{{ $v->o_id }}">（第{{ $v->g_periods }}云）{{ $v->g_name }}</a></li><li class="much">{{ $v->buycount }}人次</li>
	</ul>
	@endforeach
	
	</div>
        <div class="endpage" style="color:#333333;"><a href="/getLatestRecord" rel="nofollow">查看最新众筹记录&gt;&gt;</a></div>
    </div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
     {!! $list->render() !!}
</div>

<!--content end-->


@endsection

@section('my_js')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
{{--<script type="text/javascript" src="{{ $url_prefix }}js/banner.js"></script>--}}
<script type="text/javascript" src="{{ $url_prefix }}js/wdfx.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/owl.carousel.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>
    <script>
        $(function(){
            var start = {
                elem: '#invite_result_startTime',
                format: 'YYYY/MM/DD hh:mm:ss',
                //min: laydate.now(), 设定最小日期为当前日期
                max: '2099-06-16 23:59:59', //最大日期
                istime: true,
                istoday: false,
                choose: function(datas){
                    end.min = datas; //开始日选好后，重置结束日的最小日期
                    end.start = datas //将结束日的初始值设定为开始日
                }
            };
            var end = {
                elem: '#invite_result_endTime',
                format: 'YYYY/MM/DD hh:mm:ss',
                //min: laydate.now(),
                max: '2099-06-16 23:59:59',
                istime: true,
                istoday: false,
                choose: function(datas){
                    start.max = datas; //结束日选好后，重置开始日的最大日期
                }
            };
            laydate(start);
            laydate(end);
        })
        
        
    </script>
@endsection

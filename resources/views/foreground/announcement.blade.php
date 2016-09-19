@extends('foreground.master')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/new_join.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/zxjx.css">
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
    <!--banner start-->


    <!--以前版本的轮播图<div id="owl-demo" class="owl-carousel">
      <a class="item"><img src="{{ $url_prefix }}img/goods/niyoubenshi.jpg" alt=""></a>
      <a class="item"><img src="{{ $url_prefix }}img/goods/shaidanyoujiang.jpg" alt=""></a>
    </div>-->
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
    <div class="g-body">
        <div class="m-results">
            <div class="g-wrap f-clear">
                <div class="g-main m-results-revealList">
                    <div id="current" class="publish_Curtit">
                        <h1 class="fl">最新揭晓</h1>
                        <span id="spTotalCount">(到目前为止共揭晓商品<em class="orange">{{$data['latest_count']}}</em>件)</span>
                    </div>
                    <div class="m-results-mod-bd">
                        <ul class="w-revealList f-clear">


                            @foreach($data['goods']['data'] as $k=>$v)
                                @if($v['is_lottery']==1)
                                    <li class="w-revealList-item">
                                        <div class="w-goods w-goods-reveal">
                                            <div class="w-goods-info">
                                                <div class="w-goods-pic">
                                                    <a class="goodsimg" href="/product/{{$v['id']}}"
                                                       target="_blank">
                                                        <img width="180px" height="180px" alt="" onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading2.png';" src="{{$v['belongs_to_goods']['thumb']}}"></a>
                                                </div>
                                                <p class="w-goods-title f-txtabb">
                                                    <a href="/product/{{$v['id']}}" target="_blank"
                                                       class="gray01">(第{{$v['periods']}}
                                                        期){{$v['belongs_to_goods']['title']}}</a>
                                                </p>
                                                <p class="w-goods-price">总需{{$v['participate_person']}}.00人次</p>
                                            </div>
                                            <div class=" buy_pre">
                                                <div class=" clock-bac">
                                                    <div class="clock-container">
                                                        <p>揭晓倒计时</p>
                                                        <div class="clock_div" data-v="{{date('Y/m/d H:i:s',floor($v['lottery_time'])/1000)}}">
                                                        	<p>
                                                            <i class="mini">00</i>
                                                            <span>:</span>
                                                            <i class="sec">00</i>
                                                            <span>:</span>
                                                            <i class="hm">00</i>
                                                           </p>
                                                           <input type="hidden" id="lottime2" value="{{date('Y/m/d H:i:s',time())}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="w-revealList-item">
                                        <div class="w-goods w-goods-reveal">
                                            <div class="w-goods-info">
                                                <div class="w-goods-pic">
                                                    <a class="goodsimg" href="/product/{{$v['id']}}"
                                                       target="_blank">
                                                        <img width="180px" height="180px" alt="" onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading2.png';" src="{{$v['belongs_to_goods']['thumb']}}"></a>
                                                </div>
                                                <p class="w-goods-title f-txtabb">
                                                    <a href="/product/{{$v['id']}}" target="_blank"
                                                       class="gray01">(第{{$v['periods']}}
                                                        期){{$v['belongs_to_goods']['title']}}</a>
                                                </p>
                                                <p>
                                                </p>
                                                <p class="w-goods-price">总需{{$v['participate_person']}}.00人次</p>
                                            </div>
                                            @if($v['fetchuser'])
                                                <div class="w-record">
                                                    <div class="w-record-avatar">
                                                        <a class="fl headimg" href=""
                                                           target="_blank">
                                                            <a href="/him/{{$v['fetchuser'][0]['usr_id']}}"><img id="imgUserPhoto" src="{{$v['fetchuser'][0]['user_photo']}}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';" width="40"height="40" border="0"></a>
                                                        </a>
                                                    </div>
                                                    <div class="w-record-detail">
                                                        <p class="user f-breakword">恭喜&nbsp;<a style='color:#3CA0FF'
                                                                    href="/him/{{$v['fetchuser'][0]['usr_id']}}" title="{{$v['fetchuser'][0]['nickname']}}"
                                                                    target="_blank">{{str_limit($v['fetchuser'][0]['nickname'],16,'')}}</a>
                                                            &nbsp;获得该商品</p>
                                                        <p>幸运码:<b class="txt-red">{{$v['fetchuser'][0]['fetchno']}}</b>
                                                        </p>
                                                        <p>
                                                            本期参与:<b class="txt-red">{{$v['fetchuser'][0]['buycount']}}</b>人次
                                                        </p>
                                                        <p>揭晓时间:<span
                                                                    title="一块购奖品揭晓时间:{{date('Y年m月d日 H:i', floor($v['lottery_time']/1000))}}">{{date('Y年m月d日 H:i', floor($v['lottery_time']/1000))}}</span>
                                                        </p>
                                                        <div class="pay_back_bac"><a
                                                                    href="#">回报率：{{$v['fetchuser'][0]['rate']}}倍</a>
                                                        </div>
                                                        <p class="detail-btn"><a class="w-button w-button-simple"
                                                                                 href="/product/{{$v['id']}}"
                                                                                 rel="nofollow"
                                                                                 target="_blank">查看详情</a></p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endif

                            @endforeach


                        </ul>
                    </div>


                    <div id="pageStr" class="pageStr" style="margin: 64px auto;">
                        {!! $paginate->render() !!}
                    </div>

                </div>
                <!--最新揭晓板块 start-->
                <div class="g-side">
                    <div class="m-results-leastRemain">
                        <div class="m-results-leastRemain-title">
                            <h4>即将揭晓</h4>
                        </div>
                        <div class="m-results-leastRemain-title-ft"></div>
                        <div class="m-results-leastRemain-main">
                            <ul class="w-remainList">
                                @foreach($data['goods_right'] as  $key=>$val)
                                    <li class="w_latest_right">
                                        <div class="w_rightImg">
                                            <a class="w_goods_img" href="/product/{{$val['id']}}" target="_blank"
                                               title="{{$val['belongs_to_goods']['title']}}"><img onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading2.png';"
                                                        src="{{$val['belongs_to_goods']['thumb']}}"
                                                        alt="{{$val['belongs_to_goods']['title']}}"></a>
                                        </div>
                                        <a class="w_goods_three" href="/product/{{$val['id']}}" target="_blank"
                                           title="{{$val['belongs_to_goods']['title']}}">(第{{$val['periods']}}
                                            期){{$val['belongs_to_goods']['title']}}</a>

                                        <div class="w_line"><span
                                                    title="已完成{{round(($val['participate_person']/$val['total_person'])*100,2)}}"
                                                    style="width:{{round(($val['participate_person']/$val['total_person'])*100,2)}}%"></span>
                                        </div>
                                        <ul class="buydes-member clearfix">
                                            <li class="buy-members">
                                                <span class="projx-number color-f95b1a">{{$val['participate_person']}}</span>
                                                <i class="projx-titdes">已参与人数</i>
                                            </li>
                                            <li class="total-members">
                                                <span class="projx-number">{{$val['total_person']}}</span>
                                                <i class="projx-titdes">总需人次</i>
                                            </li>
                                            <li class="last-members">
                                                <span class="projx-number color-1ea9d0">{{$val['total_person']-$val['participate_person']}}</span>
                                                <i class="projx-titdes">剩余人次</i>
                                            </li>
                                        </ul>
                                        <a class="w_package" href="javascript:void(0)" onclick="addCart_pdt({{$val['belongs_to_goods']['id']}},{{$val['total_person']-$val['participate_person']}})" >我来扫尾</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>
                <!--最新揭晓板块 end-->

            </div>
        </div>

    </div>

    <!-- 时间值-->
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

@endsection


@section('my_js')
    {{--<script type="text/javascript" src="{{ $url_prefix }}js/banner.js"></script>--}}
    <script type="text/javascript" src="{{ $url_prefix }}js/zxjx.js"></script>
    <script>//立即购买
       //调用倒计时
        function addCart_pdt(g_id, bid_cnt) {
            $.ajax({
                url: '/addCart',
                type: 'post',
                dataType: 'json',
                async:false,
                data: {'g_id': g_id, 'bid_cnt': bid_cnt, '_token': "{{csrf_token()}}"},
                success: function (res) {
                    if (res.status == 0) {
                        //添加成功，刷新购物车信息
                        // 打开页面，此处最好使用提示页面
                       window.open('/mycart');
                    } else if (res.status == '') {
                        //未登录跳转
                        window.location.href = '/login';
                    } else {
                        //添加失败
                        layer.alert(res.message, {title: false, btn: false});
                    }
                }
            })
        }


    </script>
    
   <script>
	function countDown(end_time,day_elem,hour_elem,minute_elem,second_elem,hm_elem){
    	//if(typeof end_time == "string")
    	//var end_time = new Date(time).getTime(),//月份是实际月份-1
    	var timer = setInterval(function(){
        	var	current_time = new Date().getTime();
        	var sys_second = (end_time-current_time);
    		if (sys_second > 0) {
    			var day = Math.floor((sys_second /1000/ 3600) / 24);
    			var hour = Math.floor((sys_second /1000/ 3600) % 24);
    			var minute = Math.floor((sys_second /1000/ 60) % 60);
    			var second = Math.floor(sys_second/1000 % 60);
    			var haomiao = Math.floor(sys_second%1000);
    			day_elem && $(day_elem).text(day+'天');//计算天
    			$(hour_elem).text(hour<10?"0"+hour:hour+'时');//计算小时
    			$(minute_elem).text(minute<10?"0"+minute:minute);//计算分
    			$(second_elem).text(second<10?"0"+second:second);// 计算秒
    			$(hm_elem).text(haomiao);// 计算秒
    		} else { 
        		clearInterval(timer);	
                window.location.reload();
    		}
    	}, 10);
    }
</script>
<script>
$(document).ready(function(){
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: '/getsystime?'+new Date().getTime(),
		success: function(res){
			if(res.time){
//				$("#lottime2").val(res.time);
//				//调用倒计时，上面是倒计时计算
//				var timeColock=$("#lottime").val();
//				var time2 = $("#lottime2").val();
//				//$(".w_addBg").fnTimeCountDown("2016-04-21 17:22:23");
//				var end_time = new Date(timeColock).getTime(),//月份是实际月份-1
//				current_time = new Date(time2).getTime(),
//				sys_second = (end_time-current_time);
//				timeColock=sys_second+new Date().getTime();
//				countDown(timeColock,".day"," .hour",".mini",".sec");
                
                $(".clock_div").each(function(){
                   // $(this).attr('data-v',res.time)
                    //调用倒计时，上面是倒计时计算
                    var timeColock=$(this).attr('data-v');
                    var time2 =res.time;
                    $(this).find("#lottime2").val('res.time');
                    var end_time = new Date(timeColock).getTime(),//月份是实际月份-1
                    current_time = new Date(time2).getTime(),
                    sys_second = (end_time-current_time);
                    timeColock=sys_second+new Date().getTime();
                    var a=$(this).find('.mini');
                    var b=$(this).find('.sec');
                    var c=$(this).find('.hm');
                    countDown(timeColock,".day"," .hour",a,b,c);
                });
			}else{
				window.location.reload();
			}
		}
	})
})
</script> 
    
@endsection
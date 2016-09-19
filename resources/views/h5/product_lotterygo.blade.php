@extends('foreground.mobilehead')
@section('title', '商品详情')

@section('canonical')
    <link rel='canonical' href="http://m.ts1kg.com/prod_m/{{$data['goods_will']['belongs_to_goods']['id']}}" />
@endsection

@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/product.css">
@endsection

@section('content')
<div class="mui-content">
<!--首页头部 start-->
<div class="pro-focus">
   <!--幻灯片 start-->
   <div class="i-focus" >
      <div id="slider" class="mui-slider" >
         <div class="mui-slider-group mui-slider-loop">
            <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
               	@if(count($data['goods']['belongs_to_goods']['picarr'])-1 >= 0)
               		<img src="{{$data['goods_will']['belongs_to_goods']['picarr'][count($data['goods_will']['belongs_to_goods']['picarr'])-1]}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload320.jpg';">
            	@else
            		<img src="" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload320.jpg';" >
            	@endif
            </div>
            @foreach($data['goods_will']['belongs_to_goods']['picarr'] as $key => $val)
            @if($key != 0 || $key != count($data['goods_will']['belongs_to_goods']['picarr'])-1)
                <div class="mui-slider-item">
                  <img src="{{$val}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload320.jpg';" data-preview-src="" data-preview-group="1">
                </div>
            @endif
            @endforeach
            <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
               <img src="{{$data['goods_will']['belongs_to_goods']['picarr'][0]}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload320.jpg';">
            </div>
         </div>
         <div class="mui-slider-indicator">
            @foreach($data['goods_will']['belongs_to_goods']['picarr'] as $key => $val)
                @if($key == 0)
                    <div class="mui-indicator mui-active"></div>
                @else
                    <div class="mui-indicator"></div>
                @endif
           	@endforeach
         </div>
      </div>
	  <p class='album_tips' data-url="/productdetail_m/{{ $id }}">点击查看详情</p>
   </div>
   <!--幻灯片 end-->
</div>
<!--首页头部 end-->

<!--板块 start-->
<div class="item-main">
   <div class="item-m-nav clearfix">
      <div class='pro_title'>
		<h2><div class='product_status'>正在开奖</div>(第{{$data['goods_will']['periods']}}期){{$data['goods_will']['belongs_to_goods']['title']}}</h2>
	  </div>

   </div>

   <div class="h-notice mui-clearfix">
   @if(!empty(session('user.id')))
       @if(!empty($data['userbuywithid']))
            <ul>
                <li style='text-align:center;color:#999'>您本期一块购幸运码为：
                	@if(!empty($data['buyno']))
                    @foreach($data['buyno'] as $key=>$val)
                        @if($key < 1)
                            <span class="buyover_number">{{$val}}</span>
                        @endif
                    @endforeach
                @endif
                <a href="javascript:void(0);" style='color:#999' class="buyover_more_a">查看更多 ></a>
                </li>
             </ul>
        @else
        	<ul>
                <li style='text-align:center;'>您还没有参加,赶紧参加吧&nbsp;&nbsp;&nbsp;<a style='color: red;' onclick="window.location.href='/product_m/{{$newPeriod}}'">最新一期</a></li>
             </ul>
        @endif
   @else
        <ul>
            <li style='text-align:center;'><a style='color:#999' data-url="/login_m">请<a data-url="/login_m">登录</a></a></li>
         </ul>
   @endif 
   </div>
</div>
   <!--即将揭晓倒计时START-->
	<div class="jjjxdjs">
		<h2>揭晓倒计时</h2>
		<div class="djs" onclick='window.location.href="/calculate_m/1?o_id={{$data['goods_will']['id']}}"'>
			<div class='djs1'>即将揭晓:<span class="cut-time" data-time="{{$data['goods_will']['lottery_time']}}" data-systime="{{date('Y/m/d H:i:s')}}"><b class="mini"></b>分<b class="sec"></b>秒<b class="hma"></b><b class="hmb"></b></span></div>
			<div  class='djs2'><a >查看计算详情</a></div>
		</div>
	</div>
	<input type="hidden" id="cur_oid" value="{{$data['goods_will']['id']}}"/>
   <!--即将揭晓倒计时END-->
   
	<!--上一期获奖结果 start-->
    @if($prizeUser != null)
	<div class="jxjg" style="margin-top:5px">
		<div class="jxjgL jxjgL-pre">
			<div class="owner_img"><img src="{{$prizeUser['user_photo']}}"></div>
		</div>
		<div class="jxjgR">
			<p>
                获得者：<span id='owner'>{{$prizeUser['username']}}</span><br>
				本期参与：{{$prizeUser['buycount']}}人次<br>
				揭晓时间：{{$prizeUser['lottery_time']}}<br>
				购买时间：{{$prizeUser['bug_time']}}<br>
			</p>
		</div>
	</div>
	<div class="jxnumber" >
		<div class='no1'>幸运号码：{{$prizeUser['fetchno']}}</div>
		<div class='no2' onclick='window.location.href="/calculate_m/2?o_id={{$prizeUser['o_id']}}"'><a>查看计算详情</a></div>
	</div>
    @endif
   
   <div class="pro_info"  onclick='window.location.href="/wqjx_m?gid={{$data['goods_will']['belongs_to_goods']['id']}}"'>
      <a href="#">
         <span class="pro_jx"><img src="{{$h5_prefix}}images/pro_jx.png" class="pro_jxIcon"></span>
         <span class="pro_infoTitle">往期揭晓</span>
         <span class="pro_arrow"><img src="{{$h5_prefix}}images/pro_arrow.png"></span>
      </a>
   </div>
   
   <div class="pro_info" style="clear:both;margin-top:0.02rem" onclick='window.location.href="/share_m?gid={{$data['goods_will']['belongs_to_goods']['id']}}"'>
      <a href="#">
         <span class="pro_sd"><img src="{{$h5_prefix}}images/pro_sd.png" class="pro_sdIcon"></span>
         <span class="pro_infoTitle">往期晒单</span>
         <span class="pro_arrow"><img src="{{$h5_prefix}}images/pro_arrow.png"></span>
      </a>
   </div>
 
	<div class='join_recored'>
		<div class='rec_title'>所有参与记录</div>
		<div class='rec_time'>@if(!empty($data['starttime'])) (自{{$data['starttime']}}开始)@endif</div>
	</div>
	
	<div class='rec_list' id="wrapper">
		<div class='vertical_line'></div>
		<ul>
			<br/>
			 
		</ul>
	</div>
   
   <div class="lucky_numberbox" style="display: none;">
        @if(!empty($data['buyno']))
            @foreach($data['buyno'] as $key=>$val)
                <span class="l_number">{{$val}}</span>
            @endforeach
        @endif
   </div>
 
    <input type="hidden" id="lottime" value="{{date('Y/m/d H:i:s',floor($data['goods_will']['lottery_time']/1000))}}"/>

@if(session('is_ios') != 1)
<!--底部导航-->
<div style="height:0.77rem;"></div>
</div>

<footer class="fixed-footer">
		<div class='toFlow' onclick="window.location.href='/product_m/{{$newPeriod}}'">新一期正在火爆进行中...</div>
        <div class='toBuy' onclick="toCart({{$data['goods']['g_id']}},1)">立即参与</div>
</footer>
@endif
	
@endsection

@section('my_js')
	<script type="text/javascript" src="{{ $h5_prefix }}js/countdown.js"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/mui.zoom.js"></script>
    <script type="text/javascript" src="{{ $h5_prefix }}js/mui.previewimage.js"></script>
    <script type="text/javascript">
      mui.previewImage();

      var gallery = mui('.mui-slider');
      gallery.slider({
         interval:5000//自动轮播周期，若为0则不自动播放，默认为0；
      });
	  //myalert('恭喜你，参与成功！<BR/>请等待系统为您揭晓！');
      var urlstr = '<a onclick="window.location.href=\'/selectperiods_m/?gid='+{{$data['goods']['belongs_to_goods']['id']}}+'\';" >第'+{{$data['goods_will']['periods']}}+'期&gt; </a>';
	  $("#rightTopAction").html(urlstr);
	  var page = 0;

$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
		    var o_id = "{{$data['goods_will']['id']}}";
		    var _token = $("input[name='_token']").val();
	    	$.ajax({
	            type: 'post',
	            url: '/product_m/getbuyrecord',
	            dataType: 'json',
	            data:{page:page,o_id:o_id,_token:_token},
	            success: function(data){
					var products = data.data.data;
		            var html = '';
		            for(var key in products){
			            html += '<li>'+
                            '<div class="rec_liL"><div class="rec_liLImg join_btn"><a data-url="/him_m/getHisBuy/'+products[key]["usr_id"]+'"><img src="'+products[key]['user_photo']+'" onerror="javascript:this.src=\'/H5/images/lazyload130.jpg\'"></a></div></div>'+
							'<div class="rec_liR">'+
								'<H3 class="join_btn"><a data-url="/him_m/getHisBuy/'+products[key]["usr_id"]+'">'+products[key]["nickname"]+'</a></H3>'+
								'<p>'+products[key]["login_ip"]+'</p>'+
								'<p>购买人次:<span>'+products[key]["buycount"]+'人次</span> '+products[key]["bid_time"]+'</p>'+
							'</div></li>';
			        }

		            if(products.length < 10){
	            		// 锁定
                        me.lock();
                        // 无数据
                        me.noData();
		            }

		            page++;

		            $('#wrapper').find('ul').append(html);
	                // 每次数据加载完，必须重置
	                me.resetload();
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    }
	    
	});
})

    //我的幸运码弹出窗
    $('.buyover_more_a').on('click', function () {
        var html = $(".lucky_numberbox").html();
        layer.open({
            type: 1,
            title: '您本期一块购幸运码',
            area: ['410px', '300px'], //宽高
            content: html,
        });
    });

$('.pro_share').click(function(){
		layer.open({
		    title: [
		        '复制',
		    ],
		    content: '<input type="text" value="{{Request::url()}}"/>'
		    
		});
	})
	
	$(document).on('click',".join_btn>a",function(){
		window.location.href=$(this).attr("data-url");
	});
    </script>
@endsection



 
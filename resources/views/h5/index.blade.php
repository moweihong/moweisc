@extends('foreground.mobilehead')
@section('title', '首页')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css?v={{config('global.version')}}">
   <style>.mui-bar-nav{display:none} ::-webkit-search-cancel-button { display: none; } body input[type='search'] {
   background-color: white;
   }</style>
@endsection

@section('content')
        <!--首页头部 start-->
<div class="i-header">
   <!--幻灯片 start-->
   <div class="i-focus">
      <div id="slider" class="mui-slider" >
      	@if($data['count'] > 0)
         <div class="mui-slider-group mui-slider-loop">
         	<!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
         	<div class="mui-slider-item mui-slider-item-duplicate">
               <a href="{{ $data['slide'][$data['count']-1]['link'] }}"><img src="{{ $data['slide'][$data['count']-1]['img'] }}" onerror="javascript:this.src='{{ $h5_prefix }}images/banner-loading.jpg';"></a>
            </div>
         	@foreach ($data['slide'] as $key => $row)
         		<div class="mui-slider-item">
                   <a href="{{ $row['link'] }}"><img src="{{ $row['img'] }}" onerror="javascript:this.src='{{ $h5_prefix }}images/banner-loading.jpg';"></a>
                </div>
         	@endforeach
            <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
               <a href="{{ $data['slide'][0]['link'] }}"><img src="{{ $data['slide'][0]['img'] }}" onerror="javascript:this.src='{{ $h5_prefix }}images/banner-loading.jpg';"></a>
            </div>
         </div>
         <div class="mui-slider-indicator">
            <div class="mui-indicator mui-active"></div>
			@for ($i=0;$i<$data['count']-1;$i++)
            	<div class="mui-indicator"></div>
            @endfor
         </div>
         @else
         <!--默认图片 start-->
            <div class="mui-slider-group mui-slider-loop">
               <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
               <div class="mui-slider-item mui-slider-item-duplicate">
                  <a href="javascript:void(0)"><img src="{{ $h5_prefix }}images/banner-loading.jpg"></a>
               </div>

               <div class="mui-slider-item">
                  <a href="javascript:void(0)"><img src="{{ $h5_prefix }}images/banner-loading.jpg"></a>
               </div>

                  <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
                  <div class="mui-slider-item mui-slider-item-duplicate">
                     <a href="javascript:void(0)"><img src="{{ $h5_prefix }}images/banner-loading.jpg"></a>
                  </div>
            </div>
            <div class="mui-slider-indicator">
               <div class="mui-indicator mui-active"></div>
            </div>


         @endif
      </div>
   </div>
   <!--幻灯片 end-->
   <!--top start-->
   <div class="i-headertop">
      <div class="mui-icon h-topmessage-ico" data-url="/sysmessage"><!--<span class="mui-badge" id="cartI">0</span>--></div>
       {{--<span class="mui-icon icon-naozhong01" data-url="/sysmessage"></span>
       <a data-href="/categoty_m" id="category-btn" class="mui-icon mui-action-menu mui-icon-bars mui-pull-left" style="width:8%; font-size: 0.28rem; color:#fff; margin-top: 5px;"></a>--}}
      <div class="h-topinput">
         <span class="mui-icon mui-icon-search serachclick"></span>
         <form action="/search_m_result" method="get">
         	<input type="search" class="head-input" name="key" placeholder="搜索一块购商品" disabled/>
         </form>
      </div>

   </div>
   <!--top end-->
</div>
<!--首页头部 end-->

<!--板块 start-->
<div class="item-main">
   <div class="item-m-nav clearfix">
      <ul>
         <li>
            <a href="/freeday_m">
               <img src="{{ $h5_prefix }}images/hnav-a.png" class="hnav-li" />
               <span class="">幸运转盘</span>
            </a>
         </li>
         <li>
            <a href="/makemoney_m_new">
               <img src="{{ $h5_prefix }}images/hnav-b.png" class="hnav-li" />
               <span class="">赚钱</span>
            </a>
         </li>
         <li>
            <a href="/share_m">
               <img src="{{ $h5_prefix }}images/hnav-c.png" class="hnav-li" />
               <span class="">晒单</span>
            </a>
         </li>
         <li>
            <a href="/category_m?type=new">
               <img src="{{ $h5_prefix }}images/hnav-d.png" class="hnav-li" />
               <span class="">最新上架</span>
            </a>
         </li>
      </ul>
   </div>
   <!--通知 start-->
   <div class="h-notice mui-clearfix">
      <span class="h-noticeico"><img src="{{ $h5_prefix }}images/h-noticeico.png" /></span>
      <div class="h-noticetxt">
         <ul>
         	@foreach($data['articles'] as $article)
            	<li><a href="">恭喜用户 <span class="color-427cf8">{{$article->nickname}}</span> 支持 <span class="color-fd6384">{{$article->buycount}}元</span> 获得 <span class="color-fd6384">{{$article->g_name}}</span></a></li>
         	@endforeach
         </ul>
      </div>
   </div>
   <!--通知  end-->
</div>
<!--板块 end-->

<!--正在揭晓 start-->
<div class="faxbox announce-box">
   <h2 class="faxboxh2 announce-boxtit" data-url="/jiexiao_m">
         <span class="boxtit-h2">最新揭晓</span>
         <span class="boxtit-more">&gt;&gt;</span>
   </h2>
   <div class="announce-pro mui-clearfix moweijiexiao">
       <?php $i=1; ?>
       @foreach($data['latest'] as $latest)
           @if($latest['is_lottery'] == 1)
                 <!--揭晓中START-->
                 <div class="ann-probox" id='apento{{ $i }}' >
                     <a href="{{$latest['path']}}">
                        <div class="ann-pimg"><img src="{{ $h5_prefix }}images/lazyload130.jpg" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" data-echo="{{ $latest['thumb'] }}" /></div>
                        <span class="ann-ptit">{{ $latest['title'] }}</span>
                        <div id='gettime{{ $i }}' class="ann-ptime ind-cuttime" data-id="{{ $latest['id'] }}" data-time="{{ $latest['ltime'] }}" data-systime="{{date('Y/m/d H:i:s')}}">
                           <b class="pcutime pcutime-min"><i>-</i><i>-</i></b>
                           <span class="pcut-hao">:</span>
                           <b class="pcutime pcutime-sec"><i>-</i><i>-</i></b>
                           <span class="pcut-hao">:</span>
                           <b class="pcutime pcutime-ss"><i class="hma">-</i><i  class="hmb">-</i></b>
                        </div>
                     </a>
                  </div>
                   <!--揭晓中END-->
            @else
                    <!--已揭晓START-->
                   <div class="ann-probox" id='apento{{ $i }}' >
                       <a href="{{$latest['path']}}">
                       <div class="ann-pimg"><img src="{{ $h5_prefix }}images/lazyload130.jpg" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" data-echo="{{ $latest['thumb'] }}" /></div>
                       <span class="ann-ptit">{{ $latest['title'] }}</span>
                       <div class="ann-ptime mhdz" id='gettime{{ $i }}' data-id="{{ $latest['id'] }}" data-time="-1">
                        恭喜<a href='/him_m/getHisBuy/{{$latest["usr_id"]}}' class='mhdza' >{{$latest['nickname']}}</a>获得
                       </div>
                       </a>
                   </div>
                   <!--已揭晓END-->
            @endif
            <?php $i++;?>
         @endforeach
   </div>
  <!-- <div id='clickfunction' style="margin-top: 200px;">点击加载一个</div>-->
</div>
<!--正在揭晓 end-->

<!--人气最旺 start-->
<div class="faxbox announce-box">
   <h2 class="faxboxh2 announce-boxtit" data-url="/category_m">
         <span class="boxtit-h2">最快揭晓</span>
         <span class="boxtit-more">&gt;&gt;</span>
   </h2>
   <!--txt start-->
   <div class="rq-hotpro-main mui-clearfix">
       @foreach ($data['fast'] as $fast)
          <div class="rq-hotpro">
             <a href="/product_m/{{ $fast->id }}">
                <div class="rqhot-proimg"><img src="{{ $h5_prefix }}images/lazyload130.jpg" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" data-echo="{{ $fast->thumb }}" /></div>
                <span class="rqhot-protit">@if(empty($fast->title2)){{ $fast->title }}@else {{$fast->title2}} @endif</span>
             </a>
             <div class="rq-progress mui-clearfix">
                <div class="progress-box">
                   <span class="hot-gress-jd">揭晓进度<i>{{ $fast->rate }}%</i></span>
                   <div class="hot-gress-box"><div class="hot-gress-width" style="width:{{ $fast->rate }}%;"></div></div>
                   <span class="hot-gress-number">总需：{{ $fast->total_person }}</span>
                </div>
                 @if(session('is_ios') != 1)
                     <a class="progress-img" href="javascript:void(0)" onclick="addCart({{$fast->g_id}},1)"><img src="{{ $h5_prefix }}images/progress-img.png" /></a>
                 @endif
             </div>
          </div>
       @endforeach
   </div>
   <!--txt end-->
</div>
<!--人气最旺 start-->

<!--晒单分享 start-->
@if(!empty($data['share']))
<div class="faxbox sdshare-box">
   <h2 class="faxboxh2 announce-boxtit" data-url="/share_m">
         <span class="boxtit-h2">晒单分享</span>
         <span class="boxtit-more">&gt;&gt;</span>
   </h2>

   <div class="sd-share mui-clearfix">
      <div class="sd-share1"><a href="/sharedetail_m/{{$data['share']['first']['id']}}"><img src="{{ $h5_prefix }}images/sdload1.jpg" onerror="javascript:this.src='{{ $h5_prefix }}images/sdload1.jpg';" data-echo="{{ $data['share']['first']['sd_thumbs'] }}" /><span class="share-des">{{ $data['share']['first']['sd_content'] }}</span></a></div>
      <div class="sd-sharetow">
          @foreach($data['share']['last'] as $share)
         	  <div class="sd-share2"><a href="/sharedetail_m/{{$share['id']}}"><img src="{{ $h5_prefix }}images/sdload2.jpg" onerror="javascript:this.src='{{ $h5_prefix }}images/sdload2.jpg';" data-echo="{{ $share['sd_thumbs'] }}" /><span class="share-des">{{ $share['sd_content'] }}</span></a></div>
          @endforeach
      </div>
   </div>
</div>
@endif

<!--晒单分享 end-->
<div style="height: 62px"></div>
@endsection

@section('my_js')
   <script type="text/javascript" src="{{ $h5_prefix }}js/countdown.js"></script>
   <script type="text/javascript">


   		$(window).on("scroll",function(e){
            var topH = $(this).scrollTop();
			
            if(topH <= 80){
				$(".i-headertop").css("background-color" ,'rgba(0,0,0,0)');
            }else if(topH <= 150){
				$(".i-headertop").css("background-color" ,'rgba(0,0,0,'+((topH-100)*0.01)+')');
			}else{
                $(".i-headertop").css("background-color" ,'rgba(0,0,0,.6)');
            }
        });
	   var gallery = mui('.mui-slider');
	      gallery.slider({
	         interval:5000//自动轮播周期，若为0则不自动播放，默认为0；
	      });

	   $('#category-btn').click(function(){
			window.location.href = '/category_m';
	   })
	   
	   $('.h-topinput').click(function(){
			window.location.href = '/search_m';
	   })
   </script>
@endsection



 
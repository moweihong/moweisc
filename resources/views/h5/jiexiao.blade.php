@extends('foreground.mobilehead')
@section('title', '最新揭晓')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css?v={{config('global.version')}}">
   	<style>
   		.cut-timediv{font-size: 0.32rem;}
   		.jjjx-result{background: #E4E4E4;padding: 3.5px 5px 1px 3px;margin-top: -14px;}    
   		.jjjx-result p{font-size: .1rem;line-height: 10.5px;color: #737373;}
   		.red{color:#e63955;}
   		.blue{color: #49B4FA;}
		.jjjx-bimg{margin-top:0.3rem;}
   	</style>
@endsection

@section('content')
   <div class="mui-content">
       <div id="wrapper">
            <div id="account_content">
               
           </div>
       </div>
   </div>
   <!--footnav start-->
   <div class="footer-menu">
      <div class="circle-div"><b class="circle-b"></b></div>
      <nav class="mui-bar mui-bar-tab" id="menu">
         <a class="mui-tab-item mui-active" href="/index_m">
            <span class="mui-icon iconfont icon-home"></span>
            <span class="mui-tab-label">首页</span>
         </a>
         <a class="mui-tab-item" href="#tabbar-with-chat">
            <span class="mui-icon iconfont icon-chanpinfenlei01"><span class="mui-badge">9</span></span>
            <span class="mui-tab-label">全部商品</span>
         </a>
         <a class="mui-tab-item" href="#tabbar-with-chat">
            <span class="mui-icon iconfont icon-youxi" style="font-size: 28px"><span class="mui-badge">9</span></span>
            <span class="mui-tab-label">发现</span>
         </a>
         <a class="mui-tab-item" href="#tabbar-with-contact">
            <span class="mui-icon iconfont icon-gouwuche"></span>
            <span class="mui-tab-label">购物车</span>
         </a>
         <a class="mui-tab-item" href="#tabbar-with-map">
            <span class="mui-icon iconfont icon-iconfuzhi"></span>
            <span class="mui-tab-label">我</span>
         </a>
      </nav>
   </div>
   <!--footnav end-->
@endsection

@section('my_js')
   <script>
var page = 0;
var interval = 20;  //倒计时延迟时间
var h5_prefix = {{ $h5_prefix }};
$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	$.ajax({
	            type: 'POST',
	            url: '/jiexiao_m',
	            dataType: 'json',
	            data:{page:page},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
                        if(list[i]['is_lottery'] == 2){
                            html = '<div class="jjjx-listbox mui-clearfix">'+
                                      '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img src="'+list[i]['thumb']+'" width="108"   /></a></div>'+
                                      '<div class="jjjx-btxt zzjx-btxt">'+
                                         '<h2><a href="/product_m/'+list[i]['o_id']+'">(第'+list[i]['periods']+'期)'+list[i]['title']+'</a></h2>'+
                                         '<div class="jjjx-result">'+
                                             '<p>获得者：<span class="blue">'+list[i]['username']+'</span></p>'+
                                             '<p>参与次数：<span class="red">'+list[i]['buynums']+'</span>次</p>'+      		
                                             '<p>幸运码：<span class="red">'+list[i]['fetchno']+'</span></p>'+
                                             '<p>揭晓时间：<span>'+list[i]['lottery_time']+'</span></p>'+
                                         '</div>'+
                                      '</div>'+
                                   '</div>';
                           $('#account_content').append(html);	
                        }else{
                            html = '<div class="jjjx-listbox mui-clearfix">'+
                                        '<b class="jjjx-bq jjjx-zz"><img src="{{ $h5_prefix }}images/page/bq-zzjx.png" /></b>'+
                                        '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img src="'+list[i]['thumb']+'" width="108"   /></a></div>'+
                                        '<div class="jjjx-btxt zzjx-btxt">'+
                                           '<h2><a href="/product_m/'+list[i]['o_id']+'">(第'+list[i]['periods']+'期)'+list[i]['title']+'</a></h2>'+
                                           '<div class="zzjx-des">'+
                                              '<span>期数：'+list[i]['periods']+'期</span>'+
                                              '<span>揭晓倒计时：</span>'+
                                           '</div>'+
                                           '<div class="cut-timediv">'+
                                              '<span class="spanimg"><img src="{{ $h5_prefix }}/images/clock.png" /></span>'+
                                              '<span class="cut-time" id="'+list[i]['o_id']+'" data-time="'+list[i]['lottery_time']+'" data-systime="'+list[i]['time']+'"><b class="mini">00</b>:<b class="sec">00</b>:<b class="hma">00</b></span>'+
                                           '</div>'+
                                        '</div>'+
                                     '</div>';
                            $('#account_content').append(html);	
                            ShowCountDown($('#'+list[i]['o_id']));
                        }

                    }                    
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{                                        
                        page = data.current_page;
                        page++;
                    }
                    // 每次数据加载完，必须重置
                    me.resetload()
	            },
	            error: function(xhr, type){
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    },
        loadUpFn : function(me){
            $('#account_content').html('');
	    	$.ajax({
	            type: 'POST',
	            url: '/jiexiao_m',
	            dataType: 'json',
	            data:{page:0},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
                        if(list[i]['is_lottery'] == 2){
                            html = '<div class="jjjx-listbox mui-clearfix">'+
                                      '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img src="'+list[i]['thumb']+'" width="108"   /></a></div>'+
                                      '<div class="jjjx-btxt zzjx-btxt">'+
                                         '<h2><a href="/product_m/'+list[i]['o_id']+'">(第'+list[i]['periods']+'期)'+list[i]['title']+'</a></h2>'+
                                         '<div class="jjjx-result">'+
                                             '<p>获得者：<span class="blue">'+list[i]['username']+'</span></p>'+
                                             '<p>参与次数：<span class="red">'+list[i]['buynums']+'</span>次</p>'+      		
                                             '<p>幸运码：<span class="red">'+list[i]['fetchno']+'</span></p>'+
                                             '<p>揭晓时间：<span>'+list[i]['lottery_time']+'</span></p>'+
                                         '</div>'+
                                      '</div>'+
                                   '</div>';
                           $('#account_content').append(html);	
                        }else{
                            html = '<div class="jjjx-listbox mui-clearfix">'+
                                        '<b class="jjjx-bq jjjx-zz"><img src="{{ $h5_prefix }}images/page/bq-zzjx.png" /></b>'+
                                        '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img src="'+list[i]['thumb']+'" width="108"   /></a></div>'+
                                        '<div class="jjjx-btxt zzjx-btxt">'+
                                           '<h2><a href="/product_m/'+list[i]['o_id']+'">(第'+list[i]['periods']+'期)'+list[i]['title']+'</a></h2>'+
                                           '<div class="zzjx-des">'+
                                              '<span>期数：'+list[i]['periods']+'期</span>'+
                                              '<span>揭晓倒计时：</span>'+
                                           '</div>'+
                                           '<div class="cut-timediv">'+
                                              '<span class="spanimg"><img src="{{ $h5_prefix }}/images/clock.png" /></span>'+
                                              '<span class="cut-time" id="'+list[i]['o_id']+'" data-time="'+list[i]['lottery_time']+'" data-systime="'+list[i]['time']+'"><b class="mini">00</b>:<b class="sec">00</b>:<b class="hma">00</b></span>'+
                                           '</div>'+
                                        '</div>'+
                                     '</div>';
                            $('#account_content').append(html);	
                            ShowCountDown($('#'+list[i]['o_id']));
                        }

                    }                    
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{                                        
                        page = data.current_page;
                        page++;
                    }
                    // 每次数据加载完，必须重置
                    me.resetload()
                    me.unlock();
                    me.noData(false);
	            },
	            error: function(xhr, type){
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
        }
	});
 });    
      function ShowCountDown(y) {                    //倒计时延迟时间，不包括毫秒
          var _d = y.attr("data-time");            // 获取截止时间
          var endDate = new Date(_d);                       // 把截止时间准换成毫秒数
          var sysInterval=endDate.getTime()-new Date(y.attr("data-systime")).getTime();     // 时间差毫秒数是
      	  var endTime = sysInterval + new Date().getTime();

          var _jxtime = setInterval(function() {
        	  var leftTime = endTime - new Date().getTime();     // 时间差毫秒数是
              if(leftTime <= 0){
                  y.text("正在计算...");
                  clearInterval(_jxtime);
                  setTimeout(function(){afertLottery(y)},1000);
                  //updatedoc(y);
                  //window.location.reload();
                  return;
              }
              else{
    			var day = Math.floor((leftTime /1000/ 3600) / 24);
    			var hour = Math.floor((leftTime /1000/ 3600) % 24);
    			var minute = Math.floor((leftTime /1000/ 60) % 60);
    			var second = Math.floor(leftTime/1000 % 60);
    			var haomiao = Math.floor((leftTime%1000)/10);
    			y.find(".mini").text(minute<10?"0"+minute:minute);//计算分
    			y.find(".sec").text(second<10?"0"+second:second);// 计算秒
    			y.find(".hma").text(haomiao);// 计算秒
              }
          },interval);
      }
        function afertLottery(obj){
          var id = obj.attr('id');
            $.post("/aferjx", {'id':id,'_token':"{{csrf_token()}}"}, function(data){
                     if (data.status == 0) {
                         var html = '<div class="jjjx-bimg"><a href="/product_m/'+data.o_id+'"><img src="'+data.thumb+'" width="108"   /></a></div>'+
                                      '<div class="jjjx-btxt zzjx-btxt">'+
                                         '<h2><a href="/product_m/'+data.o_id+'">'+data.title   +'</a></h2>'+
                                         '<div class="jjjx-result">'+
                                             '<p>获得者：<span class="blue">'+data.username+'</span></p>'+
                                             '<p>参与次数：<span class="red">'+data.buynums+'</span>次</p>'+      		
                                             '<p>幸运码：<span class="red">'+data.fetchno+'</span></p>'+
                                             '<p>揭晓时间：<span>'+data.lottery_time+'</span></p>'+
                                         '</div>'+
                                      '</div>';
                         obj.parents('.jjjx-listbox').html(html);
                     }
            }, 'json');
        }
   </script>
@endsection

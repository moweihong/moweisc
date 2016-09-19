@extends('foreground.mobilehead')
@section('title', '我的晒单')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
<div class="mui-content" id="wrapper">
      <!--box start-->
      
<!--      <div class="jjjx-listbox zjjl-listbox mui-clearfix">
         <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
         <div class="jjjx-btxt zjjl-btxt">
            <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
            <div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">10000055</span></div>
            <div class="jjjx-des-other" style="color:#666666">揭晓时间：2016-04-11:16:11:11</div>
            <div class="jjjx-des-other color-de2f51">晒单状态：审核中</div>
            <div class="zj-button sd-button mui-clearfix">
               <a href="#" class="zjbut-b zjbut-going zjbut-looking">查看</a>
            </div>
         </div>
      </div>
      box end
      box start
      <div class="jjjx-listbox zjjl-listbox mui-clearfix">
         <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
         <div class="jjjx-btxt zjjl-btxt">
            <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
            <div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">10000055</span></div>
            <div class="jjjx-des-other" style="color:#666666">揭晓时间：2016-04-11:16:11:11</div>
            <div class="jjjx-des-other color-de2f51">晒单状态：审核中</div>
            <div class="zj-button sd-button mui-clearfix">
               <a href="#" class="zjbut-b zjbut-going zjbut-looking">查看</a>
            </div>
         </div>
      </div>
      box end
      box start
      <div class="jjjx-listbox zjjl-listbox mui-clearfix">
         <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
         <div class="jjjx-btxt zjjl-btxt">
            <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
            <div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">10000055</span></div>
            <div class="jjjx-des-other" style="color:#666666">揭晓时间：2016-04-11:16:11:11</div>
            <div class="jjjx-des-other color-de2f51">晒单状态：审核中</div>
            <div class="jjjx-des-other color-de2f51">赠送块乐豆：250</div>
            <div class="zj-button sd-button mui-clearfix">
               <a href="#" class="zjbut-b zjbut-going zjbut-looking">查看</a>
            </div>
         </div>
      </div>-->
      <div id="showContent"></div>
<div id="nullshow" style="display:none;">
	   <div class="cart-null">
		   <img src="{{ $h5_prefix }}images/show-null.png" />
           <center>晒单空空的~~快去一块购</center>
		   <a href="/category_m" class="cart-nulllinks">立即一块购</a>
	   </div>
<!--	   null end
	   猜你喜欢 start-->
	   <div class="faxbox sdshare-box">
		   <h2 class="faxboxh2 announce-boxtit">
			   <a >
				   <span class="boxtit-h2">猜你喜欢</span>
			   </a>
		   </h2>

		   <div class="guess-pro mui-clearfix">
               @foreach($list as $val)
                <div class="guess-probox">
                    <a href="/product_m/{{$val->id}}">
                        <div class="gue-proimg"><img src="{{$val->goods->thumb}}" /></div>
                        <span class="gue-protxt">第({{$val->periods}})期{{$val->goods->title}}</span>
                        <div class="gue-progress"><div class="gue-progress-div" style="width:{{round($val->participate_person/$val->total_person*100,2)}}%;"></div></div>
                    </a>
                </div>  
               @endforeach
		   </div>

	   </div>
</div>
      <!--box end-->
   </div>
@endsection
@section('my_js')
<script>
var page = 0;
var h5_prefix = {{ $h5_prefix }};
$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	$.ajax({
	            type: 'GET',
	            url: '/user_m/show',
	            dataType: 'json',
	            data:{page:page},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
		                html += '<div class="jjjx-listbox zjjl-listbox mui-clearfix">'+
                                    '<div class="jjjx-bimg"><a href="#"><img src="'+list[i]['img']+'" onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\'\" /></a></div>'+
                                    '<div class="jjjx-btxt zjjl-btxt">'+
                                       '<h2><a href="#">'+list[i]['productname']+'</a></h2>'+
                                       '<div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">'+list[i]['yunnum']+'</span></div>'+
                                       '<div class="jjjx-des-other" style="color:#666666">揭晓时间：'+list[i]['lotterytime']+'</div>';
                            if(list[i]['is_show'] == 0)
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：审核中</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="/user_m/editshow/'+list[i]['id']+'" class="zjbut-b zjbut-going zjbut-looking">编辑</a>'+
                                       '</div>';
                            else if(list[i]['is_show'] == 1){
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：已通过</div>'+
                                       '<div class="jjjx-des-other color-de2f51">赠送块乐豆：'+list[i]['kl_bean']+'</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="/user_m/showdetail/'+list[i]['id']+'" class="zjbut-b zjbut-going zjbut-looking">查看</a>'+
                                       '</div>';
                            }else if(list[i]['is_show'] == 2){
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：审核不通过</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="/user_m/editshow/'+list[i]['id']+'" class="zjbut-b zjbut-going zjbut-looking">修改</a>'+
                                       '</div>';
                            }
                                html += '</div>'+
                                '</div>';
                    }                    
                    if(list.length==0){
                        me.lock();
                        me.noData()
                        if(data.last_page == 0){
                            //无数据显示猜你喜欢
                            $("#nullshow").show();
                        }
                    }else{
                        $('#showContent').append(html);	                
                        page = data.current_page;
                        page++;
                    }

                    // 每次数据加载完，必须重置
                    me.resetload()
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    },
        loadUpFn : function(me){
	    	$.ajax({
	            type: 'GET',
	            url: '/user_m/show',
	            dataType: 'json',
	            data:{page:0},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
		                html += '<div class="jjjx-listbox zjjl-listbox mui-clearfix">'+
                                    '<div class="jjjx-bimg"><a href="#"><img src="'+list[i]['img']+'" onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\'\" /></a></div>'+
                                    '<div class="jjjx-btxt zjjl-btxt">'+
                                       '<h2><a href="#">'+list[i]['productname']+'</a></h2>'+
                                       '<div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">'+list[i]['yunnum']+'</span></div>'+
                                       '<div class="jjjx-des-other" style="color:#666666">揭晓时间：'+list[i]['lotterytime']+'</div>';
                            if(list[i]['is_show'] == 0)
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：审核中</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="#" class="zjbut-b zjbut-going zjbut-looking">修改</a>'+
                                       '</div>';
                            else if(list[i]['is_show'] == 1){
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：已通过</div>'+
                                       '<div class="jjjx-des-other color-de2f51">赠送块乐豆：'+list[i]['kl_bean']+'</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="#" class="zjbut-b zjbut-going zjbut-looking">查看</a>'+
                                       '</div>';
                            }else if(list[i]['is_show'] == 2){
                                html +='<div class="jjjx-des-other color-de2f51">晒单状态：审核不通过</div>'+
                                       '<div class="zj-button sd-button mui-clearfix">'+
                                          '<a href="#" class="zjbut-b zjbut-going zjbut-looking">修改</a>'+
                                       '</div>';
                            }
                                html += '</div>'+
                                '</div>';
                    }   
                    if(list.length==0){
                        me.lock();
                        me.noData()
                        if(data.last_page == 0){
                            //无数据显示猜你喜欢
                            $("#nullshow").show();
                        }
                    }else{
                        $('#showContent').html(html);	                
                        page = data.current_page;
                        page++;
                    }
                    // 每次数据加载完，必须重置
                    me.resetload()
                    me.unlock();
                    me.noData(false);
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
        }
	});
 });
  </script>
@endsection
 
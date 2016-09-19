@extends('foreground.mobilehead')
@section('title', '我的众筹记录')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--tabtit start-->
        <div class="ygrecord-tit tab-tit">
            <a  class="ygm-t tabm-t tabm-t-on" data-tab="0" id="tab1">进行中</a>
           <a  class="ygm-t tabm-t" data-tab="1" id="tab2">即将揭晓</a>
           <a  class="ygm-t tabm-t" data-tab="2" id="tab3">已揭晓</a>
        </div>
      <!--tabtit end-->
      <!--tabtxt start-->
      <div class="ygrecord-txt tab-mtxt">
         <!--选项卡1 start-->
         <div class="tab-box" style="display: block;" id="tabContent1">
            <!--box start--ajax 异步加载>
<!--            <div class="jjjx-listbox yyjl-listbox mui-clearfix">
               <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
               <div class="jjjx-btxt">
                  <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
                  <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:80%"></div></div>
                  <div class="jjjx-prodes mui-clearfix">
                     <span class="prodes-s1">总需：7488</span>
                     <span class="prodes-s2">剩余：<b class="color-de2f51">10</b></span>
                  </div>
                  <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">7478</span></div>
                  <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>
                  <a href="#" class="yyrecord-but">追加</a>
               </div>
            </div>
            box end
            box start
            <div class="jjjx-listbox yyjl-listbox mui-clearfix">
                <div class="jjjx-bimg"><a href="#"><img style="width: 108px;height: 108px" src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
               <div class="jjjx-btxt">
                  <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
                  <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:80%"></div></div>
                  <div class="jjjx-prodes mui-clearfix">
                     <span class="prodes-s1">总需：7488</span>
                     <span class="prodes-s2">剩余：<b class="color-de2f51">10</b></span>
                  </div>
                  <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">7478</span></div>
                  <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>
                  <a href="#" class="yyrecord-but">再次购买</a>
               </div>
            </div>-->
            <!--box end-->
         </div>
         <!--选项卡2 start-->
         <div class="tab-box" id="tabContent2">
            <!--box start--ajax 异步加载>
<!--            <div class="jjjx-listbox yyjl-listbox mui-clearfix">
               <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
               <div class="jjjx-btxt">
                  <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
                  <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:80%"></div></div>
                  <div class="jjjx-prodes mui-clearfix">
                     <span class="prodes-s1">总需：7488</span>
                     <span class="prodes-s2">剩余：<b class="color-de2f51">10</b></span>
                  </div>
                  <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">7478</span></div>
               </div>
            </div>-->
            <!--box end-->
         </div>
         <!--选项卡3 start-->
         <div class="tab-box" id="tabContent3">
            <!--box start-- ajax异步加载>-->
<!--            <div class="jjjx-listbox yyjl-listbox mui-clearfix">
               <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
               <div class="jjjx-btxt">
                  <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
                  <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:80%"></div></div>
                  <div class="jjjx-prodes mui-clearfix">
                     <span class="prodes-s1">总需：7488</span>
                     <span class="prodes-s2">剩余：<b class="color-de2f51">10</b></span>
                  </div>
                  <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">7478</span></div>
                  <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>
                  <a href="#" class="yyrecord-but">追加</a>
               </div>
            </div>
            box end
            box start
            <div class="jjjx-listbox yyjl-listbox mui-clearfix">
               <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
               <div class="jjjx-btxt">
                  <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
                  <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:80%"></div></div>
                  <div class="jjjx-prodes mui-clearfix">
                     <span class="prodes-s1">总需：7488</span>
                     <span class="prodes-s2">剩余：<b class="color-de2f51">10</b></span>
                  </div>
                  <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">7478</span></div>
                  <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>
                  <a href="#" class="yyrecord-but">再次购买</a>
               </div>
            </div>-->
            <!--box end-->
         </div>
      </div>
        <div id="nullshow" style="display:none;">
               <div class="cart-null">
                   <center>为自己的梦想一块购吧</center>
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
<!--      <!--tabtxt end-->
   </div>
@endsection

@section('my_js')
<script>
  var type = 0;//云购记录 0;进行中 1;即将揭晓 2:已揭晓
    var page = 0;
   var loadOver = false; //避免用户点击过快或网络慢，出现加载出错
    var tab1page = 0;//进行中的下一页
    var tab2page = 0;//即将揭晓的下一页
    var tab3page = 0;//已揭晓的下一页
    var tab1LoadEnd = false;//进行中是否加载
    var tab2LoadEnd = false;//即将揭晓是否加载
    var tab3LoadEnd = false;//已揭晓是否加载
    var dropload = {};
    var is_ios = {{session('is_ios') ? session('is_ios') : 0}};
    $(document).ready(function(){
        dropload = $('.ygrecord-txt').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            if(type == 0){
                page = tab1page;
            }else if(type == 1){
                page = tab2page;
            }else if(type == 2){
                page = tab3page;
            }
            loadOver = false;
            $.ajax({
                type: 'GET',
                url: '/user_m/buy',
                dataType: 'json',
                data:{page:page,type:type},
                success: function(data){
                    var list = data.data;
                    var html = '';
                    if(data.type == 0){
                        //进行中
                        for(var i=0;i<list.length;i++){
                            html += '<div class="jjjx-listbox yyjl-listbox mui-clearfix">'+
                                        '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img src="'+list[i]['img']+'" /></a></div>'+
                                        '<div class="jjjx-btxt">'+
                                           '<h2><a href="/product_m/'+list[i]['o_id']+'">'+list[i]['productname']+'</a></h2>'+
                                           '<div class="jjjx-progress"><div class="jjjx-progress-div" style="width:'+list[i]['width']+'%"></div></div>'+
                                           '<div class="jjjx-prodes mui-clearfix">'+
                                              '<span class="prodes-s1">总需：'+list[i]['total']+'</span>'+
                                              '<span class="prodes-s2">剩余：<b class="color-de2f51">'+list[i]['last']+'</b></span>'+
                                           '</div>'+
                                           '<div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">'+list[i]['person']+'</span><a style="color:orange;" href="/user_m/buydetail/'+list[i]['id']+'">&nbsp;&nbsp;&nbsp;查看</a></div>'+
                                         '<div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>';
                            html += is_ios != 1 ? '<a onclick="addCart('+list[i]['g_id']+',1)" href="/mycart_m" class="yyrecord-but">追加</a>' : '';
                            html += '</div></div>';
                        }
                    }else if(data.type == 1){
                        //即将揭晓
                        for(var i=0;i<list.length;i++){
                            html += '<div class="jjjx-listbox yyjl-listbox mui-clearfix">'+
                                        '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img  src="'+list[i]['img']+'" /></a></div>'+
                                        '<div class="jjjx-btxt">'+
                                           '<h2><a href="/product_m/'+list[i]['o_id']+'">'+list[i]['productname']+'</a></h2>'+
                                           '<div class="jjjx-progress"><div class="jjjx-progress-div" style="width:'+list[i]['width']+'%"></div></div>'+
                                           '<div class="jjjx-prodes mui-clearfix">'+
                                              '<span class="prodes-s1">总需：'+list[i]['total']+'</span>'+
                                              '<span class="prodes-s2">剩余：<b class="color-de2f51">'+list[i]['last']+'</b></span>'+
                                           '</div>'+
                                           '<div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">'+list[i]['person']+'</span><a style="color:orange;" href="/user_m/buydetail/'+list[i]['id']+'">&nbsp;&nbsp;&nbsp;查看</a></div>'+
                                            '<div class="jjjx-des-other color-de2f51">即将揭晓，正在计算，请稍后...</div>'+
                                        '</div>'+
                                    '</div>';
                        }
                    }else{
                        //已揭晓
                        for(var i=0;i<list.length;i++){
                            html += '<div class="jjjx-listbox yyjl-listbox mui-clearfix">'+
                                        '<div class="jjjx-bimg"><a href="/product_m/'+list[i]['o_id']+'"><img  src="'+list[i]['img']+'" /></a></div>'+
                                        '<div class="jjjx-btxt">'+
                                           '<h2><a href="/product_m/'+list[i]['o_id']+'">'+list[i]['productname']+'</a></h2>'+
                                           '<div class="jjjx-prodes mui-clearfix">'+
                                              '<span class="prodes-s1">本期中奖者：'+list[i]['winner']+'</span>'+
                                           '</div>'+
                                           '<div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">'+list[i]['person']+'</span><a style="color:orange;" href="/user_m/buydetail/'+list[i]['id']+'">&nbsp;&nbsp;&nbsp;查看</a></div>'+
                                         '<div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>';
                                           //'<a onclick="addCart('+list[i]['g_id']+',1)" href="/mycart_m" class="yyrecord-but" >再次购买</a>'+
                            html += is_ios != 1 ? '<a onclick="addCart('+list[i]['g_id']+',1)" href="/mycart_m" class="yyrecord-but" >再次购买</a>' : '';
                            html += '</div></div>';
                        }
                    }

                    if(list.length==0){
                        //暂无数据
                        if(data.type == 0){
                            tab1LoadEnd = true;
                        }else if (data.type == 1){
                            tab2LoadEnd = true;
                        }else{
                            tab3LoadEnd = true;
                        }
                        me.lock();
                        me.noData()
                        if(data.last_page == 0){
                            //无数据显示猜你喜欢
                            $("#nullshow").show();
                        }
                    }else{
                        //有数据
                        if(data.type == 0){
                            $('#tabContent1').append(html);	                
                            tab1page = data.current_page+1;
                        }else if(data.type == 1){
                            $('#tabContent2').append(html);
                            tab2page = data.current_page+1;
                        }else{
                            $('#tabContent3').append(html);
                            tab3page = data.current_page+1;
                        }
                    }
                    loadOver = true;
                    // 每次数据加载完，必须重置
                    me.resetload()
                },
                error: function(xhr, type){
                   // alert('服务器错误!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
    $('#tab1').click(function(){ 
           type = 0;
           $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
           if(!tab1LoadEnd){               
               //数据没有加载完  解锁 继续加载
               dropload.unlock();
               dropload.noData(false);
           }else{
                if(tab1page == 0){
                    //无数据显示猜你喜欢
                    $("#nullshow").show();  
                }
               dropload.lock();
               dropload.noData();
           }
           dropload.resetload();
        });
        $('#tab2').click(function(){
          type = 1;
          $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
          if(!tab2LoadEnd){              
              //数据没有加载完  解锁 继续加载
              dropload.unlock();
              dropload.noData(false);
          }else{
            if(tab2page == 0){
                //无数据显示猜你喜欢
                $("#nullshow").show();  
            }
              dropload.lock();
              dropload.noData();
          }
          dropload.resetload();
       });
        $('#tab3').click(function(){
          type = 2;
          $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
          if(!tab3LoadEnd){             
              //数据没有加载完  解锁 继续加载
              dropload.unlock();
              dropload.noData(false);
          }else{
                if(tab3page == 0){
                    //无数据显示猜你喜欢
                    $("#nullshow").show();  
                }
              dropload.lock();
              dropload.noData();
          }
            dropload.resetload();
         });
    
    });
    
</script>
@endsection



 
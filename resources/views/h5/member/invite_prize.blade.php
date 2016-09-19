@extends('foreground.mobilehead')
@section('title', '邀友获奖记录')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--box start-->
      <div id="prizeContent">
          <!--ajax异步加载-->
<!--        <div class="jjjx-listbox zjjl-listbox mui-clearfix">
           <div class="jjjx-bimg"><a href="#"><img src="{{ $h5_prefix }}/images/product.jpg" /></a></div>
           <div class="jjjx-btxt zjjl-btxt">
              <h2><a href="#">（第90341云）小米 红米Note 增强版4G手机 双卡.....</a></h2>
              <div class="jjjx-des-canyu" style=" margin-top:-0.1rem; color:#666666">幸运块乐码：<span class="color-de2f51">10000055</span></div>
              <div class="jjjx-des-other" style="color:#666666">揭晓时间：2016-04-11:16:11:11</div>
              <div class="zj-button mui-clearfix">
                 <a href="#" class="zjbut-b zjbut-over">备货中</a>
                 <a href="#" data-id="68" class="zjbut-b zjbut-going zjbut-confirm">确认收货</a>
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
              <div class="zj-button mui-clearfix">
                 <a href="#" class="zjbut-b zjbut-over">发货中</a>
                 <a href="#" data-id="10" class="zjbut-b zjbut-going zjbut-confirm">确认收货</a>
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
                <div class="zj-button mui-clearfix">
                    <a href="#" class="zjbut-b zjbut-over">订单已完成</a>
                    <a href="#" class="zjbut-b zjbut-going">晒单有奖</a>
                </div>
            </div>
        </div>-->
      </div>
      <!--box end-->
    <div id="nullshow" style="display:none;">
           <div class="cart-null">
               <center>您还没有获奖记录~~</center>
               <a href="/freeday_m" class="cart-nulllinks">去邀请好友</a>
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
   </div>
@endsection

@section('my_js')
   <script>
    $(document).on('tap','.zjbut-confirm', function(){
          var id=$(this).data("id");
         layer.open({
            content: '你是想确认收货吗？',
            btn: ['确认', '取消'],
            shadeClose: false,
            yes: function(){
               layer.open({content: '你确认了！', time: 1});
               confirmGood(id);
            }, no: function(){
               layer.open({content: '你取消了！', time: 1});
            }
         });
      })
    var page = 0;
    $(document).ready(function(){
        var dropload = $('.mui-content').dropload({
            scrollArea : window,
            loadDownFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '/user_m/inviteprize',
                    dataType: 'json',
                    data:{page:page},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            html += '<div class="jjjx-listbox zjjl-listbox mui-clearfix">'+
                                        '<div class="jjjx-bimg"><a><img src="'+list[i]['img']+'" /></a></div>'+
                                        '<div class="jjjx-btxt zjjl-btxt">'+
                                            '<h2><a>'+list[i]['productname']+'</a></h2>'+
                                            '<div class="jjjx-des-other" style="color:#666666">获得时间：'+list[i]['lotterytime']+'</div>'+
                                            '<div class="zj-button mui-clearfix">';
                                             if(list[i]['addressid'] == 0){
                                                html +='<a class="zjbut-b zjbut-over">地址未完善</a>'+
                                                       '<a href="/user_m/confirm/'+list[i]['id']+'" class="zjbut-b zjbut-going">完善地址</a>';
                                            }else if(list[i]['status'] == 3){
                                                    html += '<a class="zjbut-b zjbut-over">备货中</a>';
                                            }else if(list[i]['status'] == 4){
                                                    html += '<a class="zjbut-b zjbut-over">已发货</a>'+
                                                            '<a data-id="'+list[i]['id']+'" class="zjbut-b zjbut-going zjbut-confirm">确认收货</a>';
                                            }else if(list[i]['status'] == 5){
                                                    html += '<a class="zjbut-b zjbut-over">已完成</a>';
                                                            //'<a class="zjbut-b zjbut-going">已完成</a>';
                                            }else if(list[i]['status'] == 6){
                                                    html += '<a class="zjbut-b zjbut-over">已晒单</a>';
                                                            //'<a class="zjbut-b zjbut-going">已晒单</a>';
                                            }
                                        html+='</div>'+
                                        '</div>'+
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
                            $('#prizeContent').append(html);
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
                    url: '/user_m/inviteprize',
                    dataType: 'json',
                    data:{page:0},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            html += '<div class="jjjx-listbox zjjl-listbox mui-clearfix">'+
                                        '<div class="jjjx-bimg"><a><img src="'+list[i]['img']+'" /></a></div>'+
                                        '<div class="jjjx-btxt zjjl-btxt">'+
                                            '<h2><a>'+list[i]['productname']+'</a></h2>'+
                                            '<div class="jjjx-des-other" style="color:#666666">获得时间：'+list[i]['lotterytime']+'</div>'+
                                            '<div class="zj-button mui-clearfix">';
                                             if(list[i]['addressid'] == 0){
                                                html +='<a class="zjbut-b zjbut-over">地址未完善</a>'+
                                                       '<a href="/user_m/confirm/'+list[i]['id']+'" class="zjbut-b zjbut-going">完善地址</a>';
                                            }else if(list[i]['status'] == 3){
                                                    html += '<a class="zjbut-b zjbut-over">备货中</a>';
                                            }else if(list[i]['status'] == 4){
                                                    html += '<a class="zjbut-b zjbut-over">已发货</a>'+
                                                            '<a data-id="'+list[i]['id']+'" class="zjbut-b zjbut-going zjbut-confirm">确认收货</a>';
                                            }else if(list[i]['status'] == 5){
                                                    html += '<a class="zjbut-b zjbut-over">已完成</a>';
                                                            //'<a class="zjbut-b zjbut-going">已完成</a>';
                                            }else if(list[i]['status'] == 6){
                                                    html += '<a class="zjbut-b zjbut-over">已晒单</a>';
                                                            //'<a class="zjbut-b zjbut-going">已晒单</a>';
                                            }
                                        html+='</div>'+
                                        '</div>'+
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
                            $("#nullshow").hide();
                            $('#prizeContent').html(html);
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
     //确认地址
    function confirmGood(id){
        $.post('/user_m/confirmGood',{'id':id,'_token':"{{ csrf_token() }}"},function(data){
            data=eval('('+data+')');
            if(data.code>0)
            {
                myalert(data.msg);
                location.reload();
            }
            else
            {
                myalert(data.msg);
            }
        })
    }
   </script>
@endsection



 
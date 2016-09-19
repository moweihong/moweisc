@extends('foreground.master')

@section('canonical')
    <link rel='canonical' href="http://www.ts1kg.com/prod/{{$data['goods_will']['belongs_to_goods']['id']}}" />
@endsection

@section('my_css')
    <link rel="stylesheet" href="{{ $url_prefix }}css/c_cloud.css"/>
    <link rel="stylesheet" href="{{ $url_prefix }}css/page.css"/>
    @endsection

    @section('content')
            <!--当前位置 start-->
    <div class="yg-positioncont" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="/index">首页</a> <span class="sep">&gt;</span> <a href="/category">全部商品</a> <span class="sep">&gt;</span>
        <span>商品详情</span>
    </div>
    <!--当前位置 end-->
    <!--揭晓中main start-->
    <div class="w_con" id="goods_during">
        <!--揭晓进行时-左侧-->
        <div class="w_during_left">
            <!--more 期数start-->
            <div class="ng-pastpronav">
                <h2 class="pastnav-h2tit">商品期数回顾</h2>
                <a class="pastnav-close" href="javascript:void(0)"></a>
                <div class="pastnav-main clearfix">
                    <ul>
                        @foreach($data['goods_periods'] as $val)
                            @if($val['id']==$data['goods']['id'])
                                <li><a href="/product/{{$val['id']}}">第{{$val['periods']}}期进行中...</a></li>
                            @elseif($val['periods']==$data['goods_will']['periods'])
                                <li class="curr"><a href="/product/{{$val['id']}}">第{{$val['periods']}}期</a></li>
                            @else
                                <li><a href="/product/{{$val['id']}}">第{{$val['periods']}}期</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--more 期数end-->
            <!--其他期数 start-->
            <div class="w_all_nper">
                @if($data['goods']['id']==$data['goods_will']['id'])
                    <a class="w_nper_color" href="/product/{{$data['goods']['id']}}">第{{$data['goods']['periods']}}期进行</a>
                @else
                    <a href="/product/{{$data['goods']['id']}}">第{{$data['goods']['periods']}}期进行</a>
                @endif

                @if( ($data['beforelottery'][0]->periods+1)<$data['goods']['periods'])
                    <a href="javascript:void(0)">...</a>
                @endif

                @if(!empty($data['beforelottery']))
                    @foreach($data['beforelottery'] as $key=>$val)
                        @if($val->id !=$data['goods']['id'])
                        @if($data['goods_will']['periods']==$val->periods)
                         <a class="w_nper_color" href="/product/{{$val->id}}">第{{$val->periods}}期</a>
                         @else
                            <a  href="/product/{{$val->id}}">第{{$val->periods}}期</a>
                        @endif
                        @endif
                    @endforeach
                @endif
                <span class="w_all_more">查看更多&gt;&gt;</span>
            </div>
            <!--其他期数 end-->
            <div class="w_during_graphic">
                <div class="w_during_figure" style="position:relative;">
                    <img id="publishImg" src="{{$data['goods_will']['belongs_to_goods']['thumb']}}"/>
                    <!--S 2015-10-17 添加 -->
                    <div class="c_sold_out" style="display: none" id="goodsDown">
                        <img src="../static/img/front/goods/sold.png"/>
                    </div>
                    <!--E 2015-10-17 添加 -->
                </div>
                <div class="w_during_wen" style="position:relative;">
                    <h1 id="publishTitle">(第{{$data['goods_will']['periods']}}期){{$data['goods_will']['belongs_to_goods']['title']}}</h1>
                    <div class="w_add_doing" id="publishWinCode">
                        <div class="w_addBg">
                            <p class="">
                            	<b class="mini"></b><span>:</span>
                            	<b class="sec"></b><span>:</span>
                            	<b class="hm"></b>
                            </p>
                        </div>
                        <div id="pics" class="w_add_newimg">
                            <img id="pic" src="{{ $url_prefix }}img/goods/six.png">
                        </div>
                    </div>
                </div>
                <div class="w_clear"></div>
            </div>
            <div class="w_during_winner" style="position:relative;">
                <!--正在揭晓状态 start-->
                <div class="w_winner_left">
                    <div class="w_winner_left_box"><img src="{{ $url_prefix }}img/goods/boy_07.png"></div>
                    <p class="w_winner_left_text">谁将会是本期幸运儿？</p>
                </div>
                <!--正在揭晓状态 end-->

                <dl class="w_winner_right" id="userBuyCodes">
                    <!--未登陆状态 -->
                    @if($usr_id>0)
                        @if($data['userbuywithid'])
                            <div class="w_winner_lucky">
                                <i>您本期一块购幸运码为：</i>
                             @if(!empty($data['buyno']))
                                    @foreach($data['buyno'] as $key=>$val)
                                        @if($key<7)
										   <i class="winer_lucknumber">{{$val}}</i>
                                        @endif
                                    @endforeach
                                @endif
                                <a href="javascript:void(0)" class="buyover_more_a">查看更多</a>
                            </div>
                        @else
                            <div class="winer_nobuy" style="margin-top:45px;"><span class="winer_nobuy_txt">您还没有参加本次购买哦！</span></div>
                        @endif
                    @else
                        <span class="w_not_logged"><a href="/login" id="login">请登录</a>，查看你的购买号码！</span>
                    @endif
                </dl>
            </div>

            <div class="w_big_text_box">
                <ul class="w_calculate">
                    <p>计算公式</p>
                    <ul class="w_calculate_in">
                        <li class="w_details_first"><em>?</em><span>本期幸运号码</span></li>
                        <li class="w_details_second " onmouseenter="Times100Enter()" onmouseleave="Times100Leave()"><em>?</em><span>100个时间求和</span>
                            <div class="w_two_con">
                                <i></i>
                                <p class="w_two_text">奖品的最后一个号码分配完毕，公示该分配时间点前本站全部奖品的<strong>最后100个参与时间</strong>，并求和。</p>
                            </div>
                        </li>
                        <li class="w_details_fourth"><em
                                    id="publishTotalPrice">{{$data['goods']['total_person']}}</em><span>该奖品总需人次</span>
                        </li>
                        <li class="w_details_fifth"><em>100000001</em><span>原始数</span></li>
                    </ul>
                </ul>
            </div>
        </div>
        <!--揭晓进行时-右侧-->
        <div class="w_during_right">
            <h3>最新一期</h3>
            <p>最新一期正在进行，赶紧参加吧！</p>
            <div class="w_latest_right1" style="position:relative;">
                <div class="w_rightImg"><a href='/product/{{$data['goods']['id']}}' class="w_goods_img" id="cartImg"
                                           href=""><img id="onlineGoodsImg"
                                                        src="{{$data['goods']['belongs_to_goods']['thumb']}}"/></a>
                </div>
                <a class="w_goods_ddree" href="/product/{{$data['goods']['id']}}">(第{{$data['goods']['periods']}}
                    期){{$data['goods']['belongs_to_goods']['title']}}</a>
                <b id="onlineSubTitle"></b><em
                        id="onlinePriceTotal">价值：￥{{$data['goods']['belongs_to_goods']['money']}}</em>
                <div class="w_line"><span id="onlinLine" style="width:{{round($data['goods']['participate_person']/$data['goods']['total_person'],2)*100}}%"></span></div>
                <ul class="w_number">
                    <li class="w_amount" id="onlinePriceSell">{{$data['goods']['participate_person']}}</li>
                    <li class="w_amount w_amount_right"
                        id="onlineSurplus">{{$data['goods']['total_person']-$data['goods']['participate_person']}}</li>
                    <li>已购买人次</li>
                    <li class="w_amount_right">剩余人次</li>
                </ul>
            </div>
            <div class="w_cumulative clearfix">
                <strong>参与人次：</strong>
                <div class="count">
                    <div class="w_one_new">
                        <span class="reduce">-</span>
                        <input width="70px" class="count-input buytimes" id='input_addcart' type="text" maxlength="5" value="1"
                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                               onafterpaste="this.value=this.value.replace(/\D/g,'')"><span class="add">+</span>
                    </div>
                </div>
            </div>
            <div class="w_buy"><a href="javascript:void(0)" id="buybuybuy" data-gid="{{$data['goods']['belongs_to_goods']['id']}}" onclick="javascript:void(0)">立即抢购</a></div>
        </div>
        <div class="w_clear"></div>
        <!--选项卡-->
        @include("foreground/product_tab")

        <!--人气商品-->
        <div class="c_popular_recommend">
            <h4 class="c_popular_title">人气商品</h4>
            <div class="c_pop_shop">
                <ul class="c_pop_list" id="goodsList">
                    @foreach( $data['hot'] as $k=>$v)
                        <li>
                        <span class="span"><img height="210px" width="204px" id="goodsImg_0"
                                                src="{{$v['belongs_to_goods']['thumb']}}"></span>
                            <b title="{{$v['belongs_to_goods']['title']}}">{{$v['belongs_to_goods']['title']}}</b>
                            <i>剩余<em>{{$v['total_person']-$v['participate_person']}}</em>人次</i>
                            <div class="c_pop_hover" style="display: none;">
                                <div class="c_pop_bj"></div>
                                <div class="c_divide_btn"><a href="javascript:;" class="c_add_cart" onclick="addCart({{$v['belongs_to_goods']['id']}},1)">加入购物车</a>
                                    <a href="/product/{{$v['id']}}" class="c_know_detail">查看详情</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="c_pop_btn c_pop_left" style="display: none;"><i></i></div>
                <div class="c_pop_btn c_pop_right" style="display: none;"><i></i></div>
            </div>
        </div>
        <div class="lucky_numberbox">
            @if(!empty($data['buyno']))
                @foreach($data['buyno'] as $key=>$val)
                    <span class="l_number">{{$val}}</span>
                @endforeach
            @endif

        </div>
        <input type="hidden" id="lottime" value="{{date('Y/m/d H:i:s',floor($data['goods_will']['lottery_time']/1000))}}"/>
  <input type="hidden" id="lottime2" value="{{date('Y/m/d H:i:s',time())}}"/>
  
    </div>
    <!--揭晓中main end-->
@endsection
@section("my_js")
    <script type="text/javascript" src="{{ $url_prefix }}js/goods.js"></script>
    <script type="text/javascript" src="{{ $url_prefix }}js/layer/layer.js"></script>


    <script>
        $(".w_all_more").click(function(){
            $(".ng-pastpronav").slideDown(400);
        })
        $(".pastnav-close").click(function(){
            $(".ng-pastpronav").slideUp(400);
        })
		 //我的幸运码弹出窗
            $('.buyover_more_a').on('click', function () {
                layer.open({
                    type: 1,
                    title: '您本期一块购幸运码',
                    shadeClose: true,
                    area: ['410px', '300px'], //宽高
                    content: $('.lucky_numberbox'),
                });
            });
        //控制添加购物车事件
        $('.reduce').click(function () {
            //修改
            var nextval = parseInt($("#input_addcart").val()) - 1;
            if (nextval >= 1)$("#input_addcart").val(nextval);

        });//减少输了1
        $(".add").click(function () {
            var count = parseInt($("#onlineSurplus").text());
            var nextval = parseInt($("#input_addcart").val()) + 1;
            if (nextval <= count)if (nextval >= 1)$("#input_addcart").val(nextval);
        });

        $('#input_addcart').bind('input propertychange', function () {
            var count = parseInt($("#onlineSurplus").text());
            var curval = $(this).val();
            if (curval > count) {
                $(this).val(count);
            }
            if (!curval || curval == '') {
                $(this).val(1);
            }
            if (curval && /^[1-9]*[1-9][0-9]*$/.test(curval)) {
            } else {
                $(this).val(1);
            }
        });

        $("#buybuybuy").click(function(){
            var id = $(this).attr('data-gid');
            var count=parseInt($('#input_addcart').val());//获取所能购买的最大值
            if (count && /^[1-9]*[1-9][0-9]*$/.test(count)) {
                addCart_pdt(id, count);
            } else {
                addCart_pdt(id, 1);
            }


        });
        function addCart_pdt(g_id, bid_cnt){
            $.ajax({
                url: '/addCart',
                type: 'post',
                dataType: 'json',
                data: {'g_id':g_id,'bid_cnt':bid_cnt,'_token':"{{csrf_token()}}"},
                success: function(res){
                    if(res.status == 0){
                        //添加成功，刷新购物车信息
                        window.location.href = '/mycart';
                    }else if(res.status == ''){
                        //未登录跳转
                        window.location.href = '/login';
                    }else{
                        //添加失败
                        layer.alert(res.message, {title:false,btn:false});
                    }
                }
            })
        }
    </script>
<script>
	function countDown(end_time,day_elem,hour_elem,minute_elem,second_elem){
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
    			$(minute_elem).text(minute<10?"0"+minute:minute+'分');//计算分
    			$(second_elem).text(second<10?"0"+second:second+'秒');// 计算秒
    			$(".hm").text(haomiao);// 计算秒
    		} else { 
        		clearInterval(timer);	
        		function endAjax(){
                    var url="{{config('global.base_url').config('global.ajax_path.product_checkstatus').'/'.$data['goods_will']['id']}}";
                    $.ajax({
                        type:'GET',
                        url:url,
                        success:function(data){
                             var data = eval('('+data+')');
                             data =data.data;
                             if(data.status==2){
                                 window.location.reload();
                             }
                        }
                  });
                }
        		setInterval(endAjax,2000);
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
				$("#lottime2").val(res.time);
				//调用倒计时，上面是倒计时计算
				var timeColock=$("#lottime").val();
				var time2 = $("#lottime2").val();
				//$(".w_addBg").fnTimeCountDown("2016-04-21 17:22:23");
				var end_time = new Date(timeColock).getTime(),//月份是实际月份-1
				current_time = new Date(time2).getTime(),
				sys_second = (end_time-current_time);
				timeColock=sys_second+new Date().getTime();
				countDown(timeColock,".day"," .hour",".mini",".sec");
			}else{
				window.location.reload();
			}
		}
	})
})
</script>
@endsection
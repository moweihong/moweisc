@extends('foreground.master')
@section('canonical')
<link rel='canonical' href="http://www.ts1kg.com/prod/{{$data['goods']['belongs_to_goods']['id']}}" />
@endsection

@section('my_css')
    <link rel="stylesheet" href="{{ $url_prefix }}css/new_join.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
@endsection

@section('content')
    <div class="yg-positioncont" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="/index">首页</a> <span class="sep">&gt;</span> <a href="/category">全部商品</a> <span class="sep">&gt;</span> <span class="w_accord">商品详情</span>
    </div>
    <div class="w_con" id="goods_details" style="display: block;">
        <div class="w_details_left">

            <div class="ng-pastpronav">
                <h2 class="pastnav-h2tit">商品期数回顾</h2>
                <a class="pastnav-close" href="javascript:void(0)"></a>
                <div class="pastnav-main clearfix">
                    <ul>
                        @foreach($data['goods_periods'] as $val)
                            @if($val['id']==$data['goods']['id'])
                                <li><a href="/product/{{$val['id']}}">第{{$val['periods']}}期进行中...</a></li>
                            @elseif($val['periods']==$data['goods_latest']['periods'])
                                <li class="curr"><a href="/product/{{$val['id']}}">第{{$val['periods']}}期</a></li>
                            @else
                                <li><a href="/product/{{$val['id']}}">第{{$val['periods']}}期</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="w_all_nper">
                @if($data['goods']['id']==$data['goods_latest']['id'])
                <a class="w_nper_color" href="/product/{{$data['goods_latest']['id']}}">第{{$data['goods_latest']['periods']}}期进行</a>
                @else
                <a href="/product/{{$data['goods_latest']['id']}}">第{{$data['goods_latest']['periods']}}期进行</a>
                @endif
                @if(!empty($data['beforelottery']))
                        @if( $data['goods_latest']['periods']>($data['beforelottery'][0]->periods+1))
                            <a href="javascript:void(0)">...</a>
                        @endif
                    @foreach($data['beforelottery'] as $key=>$val)
                        @if($data['goods_latest']['id'] !=$val->id)
                        @if($data['goods']['periods']==$val->periods)
                            <a class="w_nper_color" href="/product/{{$val->id}}">第{{$val->periods}}期</a>
                        @else
                            <a href="/product/{{$val->id}}">第{{$val->periods}}期</a>
                        @endif
                            @endif
                    @endforeach
                @endif

                <span class="w_all_more">查看更多&gt;&gt;</span>
            </div>
            <div class="w_details_top clearfix">
                <div class="w_details_choose" style="position:relative;">
                    <div class="w_big_img">
                        <div class="wb_bigimg"><img class="bigimg_src" onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading4.png';"
                                                    src="{{ !empty($data['goods']['belongs_to_goods']['picarr'] ['0'])?$data['goods']['belongs_to_goods']['picarr'] ['0']:'' }}"/>
                        </div>
                    </div>
                    <ul class="w_small_img">
                        <i class='w_modified'></i>
                        @foreach($data['goods']['belongs_to_goods']['picarr'] as $key=>$val)
                            @if($key==0)
                                <li class="w_small_li w_small_color" date-img="{{$key}}"><img onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading.png';" src="{{$val}}"/></li>
                            @else
                                <li class="w_small_li" date-img="{{$key}}"><img onerror="javascript:this.src='{{$url_prefix}}img/nodata/product-loading.png';" src="{{$val}}"/></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="w_details_text" style="position:relative;">
                    <div class="zhengchang">
                        <!-- 正常购买 -->
                        <p id="zc_title">
                            （第<span id='cart_period'>{{$data['goods']['periods']}}期）<strong>
                                    <c id='cart_title'>{{$data['goods']['belongs_to_goods']['title']}}</c></span></strong><i
                                    style='color:'></i>
                        </p>
                        <input type="hidden" value="" id="cart_priceArea"/>
                        <b>价值：￥<span id="cart_priceTotal">{{$data['goods']['belongs_to_goods']['money']}}</span></b>
                        <div class="w_line"><span id="zc_line" style="width:{{round($data['goods']['participate_person']/$data['goods']['total_person'],2)*100}}%"></span></div>
                        <ul class="w_number">
                            <li class="w_amount w_amount_one"
                                id="cart_priceSell">{{$data['goods']['participate_person']}}</li>
                            <li class="w_amount" id="cart_need">{{$data['goods']['total_person']}}</li>
                            <li class="w_amount  w_amount_two w_amount_val"
                                id="cart_surplus">{{$data['goods']['total_person']-$data['goods']['participate_person']}}</li>
                            <li class="w_amount_one">已参与</li>
                            <li>总需人次</li>
                            <li class="w_amount_two">剩余人次</li>
                        </ul>
                        <div class="w_cumulative w_cumulative_another clearfix">
                            <strong>购买：</strong>
                            <div class="count">
                                <div class="w_one_newss"><span class="reduce">-</span><input width="70px"
                                                                                             class="count-input buytimes"
                                                                                             id="input_addcart"
                                                                                             type="text" maxlength="5"
                                                                                             value="1"
                                                                                             onkeyup="this.value=this.value.replace(/\D/g,'')"
                                                                                             onafterpaste="this.value=this.value.replace(/\D/g,'')"><span
                                            class="add">+</span></div>
                            </div>
                            <div class="count tails" data-id="{{$data['goods']['belongs_to_goods']['id']}}" style="height:25px;width:50px;border:1px solid red;border-radius: 5px;text-align: center;font-size:14px;color:red;padding-top:3px;cursor:pointer">包尾</div>
                        </div>
                        <dl class="w_rob w_rob_another y_rob_another" style="margin-bottom:24px;">
                            <dd><a id="iWantyg" class="w_slip" data-gid="{{$data['goods']['belongs_to_goods']['id']}}"
                                  href="javascript:void(0)" onclick="javascript:void(0)" >立即一块购</a></dd>
                            <dd class="w_slip_out">
                                <a class="w_slip_in" href="javascript:void(0)"
                                   id="{{$data['goods']['belongs_to_goods']['id']}}">加入购物车</a>
                            </dd>
                            <div class="w_clear"></div>
                        </dl>
                    </div>
                    <ul class="w_security">
                        <li class="w_security_one">公平公正公开</li>
                        <li class="w_security_two">品质保障</li>
                        <li class="w_security_three">全国免运费（港澳除外）</li>
                        <li class="w_security_four">权益保障</li>
                        <div class="w_clear"></div>
                    </ul>

                    <div class="w_winner_bg">
                        @if(!empty($userid))

                            @if(!empty($data['userbuywithid']))
                                <div class="winer_buyover">
                                    <b class="buyover_tit">您本期一块购幸运码为：</b>
                                    @if(!empty($data['buyno']))
                                        @foreach($data['buyno'] as $key=>$val)
                                            @if($key<7)
                                                <span class="buyover_number">{{$val}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    <a href="javascript:void(0)" class="buyover_more_a">查看更多 ></a>
                                </div>
                            @else
                                <span class="winer_nobuy_txt">您还没有参加本次购买哦！</span>
                            @endif
                        @else
                            <span class="w_not_logged">请您<a href="/login" id="login">登录</a>，查看您的幸运码！</span>
                        @endif
                    </div>
					<div class="bdsharebuttonbox">
						<a href="#" class="bds_more" data-cmd="more"></a>
						<a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
						<a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
						<a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a>
						<a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
						<a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>
				    </div>
		<script>
					window._bd_share_config={
						"common":{
							"bdSnsKey":{},
							"bdText":"",
							"bdMini":"2",
							"bdMiniList":false,
							"bdPic":"",
							"bdStyle":"0",
							"bdSize":"16"
							},
							"share":{}};
							with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
							</script>
                </div>
            </div>
        </div>
        <!--揭晓前-->
        <div class="w_details_right" style="position:relative;">
            <h3 id="purchase_history"><a href="javascript:void(0);">最新众筹记录</a></h3>
            <h3 id="my_history" style="color:#9EA1A8"><a href="javascript:void(0);">我的众筹记录</a></h3>
            <ul class="w_period">
                @foreach($data['allbuy'] as $key=>$val)
                    <li>
                        <a href="/him/{{ $val['usr_id']}}"><img class="w_period_userImg" src="@if(isset($val['user_photo'])){{$val['user_photo']}}@else {{$url_prefix}}img/nodata/tx-loading.png @endif" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';"></a>
                        <a href="/him/{{ $val['usr_id']}}" title="@if(isset($val['nickname'])){{$val['nickname']}}@endif">@if(isset($val['nickname'])){{$val['nickname']}}@else{{config('global.default_nickname')}}@endif</a>
                        <span  class="w_period_countNum">{{$val['buycount']}}人次</span>
                    </li>
                @endforeach
                @if(isset($data['buytotal']))
                <li>
                    <a href="javascript:void(0);" class="view_ALL">查看全部</a>
                </li>
                @endif
            </ul>
			<ul class="w_period2" style="display:none">
                @if(!empty($userid))
                    @if(empty($data['buybid']))
                        <div class="winer_nobuy"><span class="winer_nobuy_txt">您还没有参加本次购买哦！</span></div>
                    @else    
                        @foreach($data['buybid'] as $val)
                        <li>
                            <a><img class="w_period_userImg" src="{{$data['userinfo']['user_photo']}}" onerror="javascript:this.src='{{$url_prefix}}img/nodata/tx-loading.png';"></a>
                            <a href="javascript:void(0);" title="{{$data['userinfo']['nickname']}}">{{$data['userinfo']['nickname']}}</a>
                             <span class="w_period_countNum">{{$val['buycount']}}人次</span>
                        </li> 
                        @endforeach
                    @endif
                @else
                    <div class="no-login-wrapper">
                        <div class="gth-icon transparent-png"></div>
                        <p class="ng-see-mycord">请您<a id="a_login" href="/login">登录</a>查看幸运码！</p>
                    </div>
                @endif

            </ul>
            <div class="w_clear"></div>
        </div>
        <!--揭晓后结束-->
        <div class="w_clear"></div>

        <!--引入商品详情页模板-->
        @include('foreground.product_tab')


                <!--本期幸运块乐码 start-->
        <div class="lucky_numberbox">
            @if(!empty($data['buyno']))
                @foreach($data['buyno'] as $key=>$val)
                    <span class="l_number">{{$val}}</span>
                @endforeach
            @endif

        </div>
        <!--本期幸运块乐码 end-->
    </div>
@endsection
@section("my_js")
    <script type="text/javascript" src="{{ $url_prefix }}js/goods.js"></script>

    <script>  
        //左侧缩略图放大效果
        $(".w_small_img .w_small_li").mouseover(function () {
            var j = $(this).attr("date-img");
            $(this).addClass("w_small_color").siblings(".w_small_li").removeClass("w_small_color");
            @foreach($data['goods']['belongs_to_goods']['picarr'] as $key=>$val)
                    @if($key==0)
            if (j == 0) {
                $(".w_modified").css("left", "28px");
                $(".bigimg_src").attr("src", "{{$data['goods']['belongs_to_goods']['picarr'][0]}}");
            }
                    @elseif($key==1)
            else if (j == 1) {
                $(".w_modified").css("left", "116px");
                $(".bigimg_src").attr("src", "{{$data['goods']['belongs_to_goods']['picarr'][1]}}");
            }
                    @elseif($key==2)
            else if (j == 2) {
                $(".w_modified").css("left", "206px");
                $(".bigimg_src").attr("src", "{{$data['goods']['belongs_to_goods']['picarr'][2]}}");
            }
                    @elseif($key==3)
            else if (j == 3) {
                $(".w_modified").css("left", "296px");
                $(".bigimg_src").attr("src", "{{$data['goods']['belongs_to_goods']['picarr'][3]}}");
            }
            @endif
            @endforeach
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
            var count = parseInt($("#cart_surplus").text());
            var nextval = parseInt($("#input_addcart").val()) + 1;
            if (nextval <= count)if (nextval >= 1)$("#input_addcart").val(nextval);
        });
        $('#input_addcart').bind('input propertychange', function () {
            var count = parseInt($("#cart_surplus").text());
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

        $('.w_slip_in').click(function () {
            var id = $(this).attr('id');
            var count = parseInt($('#input_addcart').val());
            if (count && /^[1-9]*[1-9][0-9]*$/.test(count)) {
                addCart(id, count);
            } else {
                addCart(id, 1);
            }
        });
        $('.tails').click(function(){
            var id = $(this).attr('data-id');
            var count = parseInt($('#cart_surplus').text());
            addCart_pdt(id, count);
        })
        //立即购买
        $('#iWantyg').click(function () {
            var id = $(this).attr('data-gid');
            var count = parseInt($('#input_addcart').val());
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
                    }else if(res.status == -1 && res.message == '未登陆'){
                        //未登录跳转
                        window.location.href = '/login';
                    }else{
                        //添加失败
                        layer.alert(res.message, {title:false,btn:false});
                    }
                }
            })
        }
        $(".w_all_more").click(function(){
            $(".ng-pastpronav").slideDown(400);
        })
        $(".pastnav-close").click(function(){
            $(".ng-pastpronav").slideUp(400);
        })

    </script>
@endsection
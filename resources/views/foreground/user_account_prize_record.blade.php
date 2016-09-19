{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','中奖记录')
@section('content_right')
    <div id="member_right" class="member_right b_record_box">
	    <div class="layer_phone">
	    		<div class="finish_info">
	    			完善信息
	    			<span>x</span>
	    		</div>
	    		<div class="phone_content">
                    <span>充值到手机:</span><input type="text" id="mobile_num" maxlength="11"/><span class="error_msg" style="display: none;">手机格式不正确</span>
	    			<p class="phone_number"></p>
	    			<div class="confirm_div">
	    				<p>客官~号码一旦确定就无法更改哦</p>
                        <input type="hidden" value="" id="order_id"/>
	    				<input type="button" class="confirm_btn" value="确定"/>
	    			</div>
	    		</div>
	    </div>
	   <div class="receive_confirm_new" id="success_content">
               
                <div class="not_enough_content">
                    <p class="not_enough_msg">提交成功</p>
                    <p class="not_enough_money">到帐要一点点时间哦~不要着急~<br>注意查收短信</p>
                    <div class="receive_success_btn2" id="success_ok">好哒</div>
                </div>  
        </div>
	   <div class="receive_confirm_new" id="error_content">
               
                <div class="not_enough_content">
                    <p class="not_enough_msg">咦？提交出错啦~</p>
                    <p class="not_enough_money">客官，拨打客服电话400-6626-985<br>或重新确认号码试试吧</p>
                    <div class="receive_success_btn2" id="error_ok">好哒</div>
                </div>  
        </div>
        <!-- S 中奖记录模块内容 -->
        <div class="b_record_buy">
            <!-- 实物商品 -->
            <div class="b_record_list b_record_cloud" style="display:block;">
                <div class="b_record_info">
                    <!-- 商品按时间筛选 -->
                    <div class="b_choose" style="display: none;">
                        <ul class="b_choose_day">
                            <li class="{{ empty($type) ? 'b_choose_this':'' }}"><a href="{{ url('/user/prize',['type'=>0]) }}">全部</a></li>
                            <li class="{{ $type==1 ? 'b_choose_this':'' }}"><a href="{{ url('/user/prize',['type'=>1]) }}">今天</a></li>
                            <li class="{{ $type==2 ? 'b_choose_this':'' }}"><a href="{{ url('/user/prize',['type'=>2]) }}">本周</a></li>
                            <li class="{{ $type==3 ? 'b_choose_this':'' }}"><a href="{{ url('/user/prize',['type'=>3]) }}">本月</a></li>
                            <li class="{{ $type==4 ? 'b_choose_this':'' }}"><a href="{{ url('/user/prize',['type'=>4]) }}">最近三个月</a></li>
                        </ul>
                        <dl class="b_choose_cal" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="brokerage_source_startTime" readonly="true" type="text"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="brokerage_source_endTime" readonly="true" type="text"></dd>
                            <dd class="b_choose_search" onclick="actionSearch()">搜索</dd>
                        </dl>
                    </div>
            <!-- 中奖记录商品样式 -->
            <div class="b_record_table">
                @if($list->count()==0)
                <div style="text-align:center;width:948px;height:530px;padding-top:290px;"><a href="" target="_blank"><img style="width:377px;height:49px;" src="{{asset('foreground/img/self_win.png')}}" alt="暂无数据"></a></div>
                @else
                <table id="winTable">
                    <tbody>
                        <tr class="b_part_title">
                            <th class="b_th1">商品图片</th>
                            <th class="b_th2">商品名称</th>
                            <th class="b_th2">本期参与人次</th>
                            <th class="b_th3">全部状态</th>
                            <th class="b_th4">操作详情</th>
                            <th class="b_th6">分享赚佣金</th>
                        </tr>
                        @foreach ($list as $val)
                            <tr>
                                @if($val->goods!=null && $val->object!=null)
                                <td><a href="{{ url('/product',['id'=>$val->object->id]) }}"><img src="{{ $val->goods->thumb }}" alt=""></a></td>
                                <td id="div_0"><div class="b_goods_name">
                                        <span><a href="{{ url('/product',['id'=>$val->object->id]) }}">(第{{ $val->g_periods}}期){{ $val->g_name }}</a></span>
                                        <b class="b_all_require">总需：{{ $val->object->total_person }}人次</b><b class="b_all_require">幸运码：{{ $val->fetchno }}</b>
                                    </div></td>
							    <td>{{$val->buycount}}</td>
                                <td class="b_color">
                                    @if($val->goods->is_virtual == 1 && $val->goods->g_type == 1)
                                        @if($val->status == 2)
                                            <span>待确认</span>
                                        @elseif($val->status == 5)
                                            <span>已完成</span>
                                        @endif
                                    @else
                                        @if($val->addressid == 0)
                                            <span>地址未完善</span>
                                        @else
                                            @if($val->status == 3)
                                                <span>待发货</span>
                                            @elseif($val->status == 4)   
                                                <span>已发货</span>
                                            @elseif($val->status == 5)
                                                @if($val->goods->is_virtual == 1)
                                                    <span>已完成</span>
                                                @else
                                                    <span>已完成待晒单</span>
                                                @endif
                                            @elseif($val->status == 6)   
                                                <span>已晒单</span>
                                            @else
                                                <span>地址已完善</span>
                                            @endif
                                        @endif
                                    @endif
                                        
                                </td>
                                <td class="times0">
                                    @if($val->goods->is_virtual == 1 && $val->goods->g_type == 1)
                                        @if($val->status == 2)
                                        <a id="wanshanAddress" onclick="perfectInfo({{$val->id}})">完善信息</a>
                                        @elseif($val->status == 5)
                                            <a id="wanshanAddress" title="已充值号码：{{json_decode($val->addressjson)->mobile}}">查看信息</a>
                                        @endif
                                    @else
                                        @if($val->addressid == 0)
                                        <a href="{{url('user/address',['orderid'=>$val->id])}}" id="wanshanAddress" >完善地址</a>
                                        @else
                                            @if($val->status == 3)
                                            <a id="wanshanAddress" class="viewAll2" onclick="orderAddres({{$val->id}})">查看地址</a>
                                            @elseif($val->status == 4)   
                                                <a id="wanshanAddress" onclick="confirmGood({{$val->id}})">确认收货</a>
                                            @elseif($val->status == 5)   
                                                <!--虚拟商品不返佣不晒单-->
                                                @if($val->goods->is_virtual == 1)                                                
                                                    <a id="wanshanAddress">已完成</a>
                                                @else
                                                    <a href="/user/show" id="wanshanAddress">去晒单</a>
                                                @endif
                                            @elseif($val->status == 6)
                                                <a id="wanshanAddress">已晒单</a>
                                            @else
                                                <a id="wanshanAddress" onclick="orderAddres({{$val->id}})">查看地址</a>
                                            @endif 
                                        @endif 
                                    @endif
                                </td>
                                <td>
                                    <div  class="bdsharebuttonbox bdshare-button-style2-16" data-bd-bind="1457684604192">
                                        <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                                        <a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                                        <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                                        <a class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                                        <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
                                        <a class="bds_renren" data-cmd="renren"></a>
                                    </div>                                    
                                    <!--<a href="javascript::void(0);" class="viewAll" style="display:none">分享赚佣金</a>-->
                                </td>
                                @endif
                            </tr>
                        @endforeach

                        <tr style="display: none;">
                            <td><a href="javascript:gotoGoods(327,725)"><img src="http://img02.ygqq.com/upload/goodsfile/20151127/1_1448627594990.jpg" alt=""></a></td>
                            <td id="div_0"><div class="b_goods_name">
                                    <span><a href="javascript:gotoGoods(327,725)">(第725期)iPhone6S至尊王者版999999G大写的牛！！！【包邮】</a></span>
                                    <b class="b_all_require">总需：59人次</b><b class="b_all_require">获得者：用户名最多是八个</b>
                                </div></td>
                            <td class="b_color"><span>等待下单中</span><span><a>订单详情</a></span></td><td class="times0"></td>
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">分享赚佣金</a></td>
                        </tr>
                        <tr style="display: none;">
                            <td><a href="javascript:gotoGoods(327,725)"><img src="http://img02.ygqq.com/upload/goodsfile/20151127/1_1448627594990.jpg" alt=""></a></td>
                            <td id="div_0"><div class="b_goods_name">
                                    <span><a href="javascript:gotoGoods(327,725)">(第725期)iPhone6S至尊王者版999999G大写的牛！！！【包邮】</a></span>
                                    <b class="b_all_require">总需：59人次</b><b class="b_all_require">获得者：用户名最多是八个</b>
                                </div></td>
                            <td class="b_color"><span>物流运输中</span><span>订单详情</span><span><a id="viewWL">查看物流</a></span></td><td class="times0"><a id="queren">确认收货</a></td>
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">分享赚佣金</a></td>
                        </tr>
                        <tr style="display: none;">
                            <td><a href="javascript:gotoGoods(327,725)"><img src="http://img02.ygqq.com/upload/goodsfile/20151127/1_1448627594990.jpg" alt=""></a></td>
                            <td id="div_0"><div class="b_goods_name">
                                    <span><a href="javascript:gotoGoods(327,725)">(第725期)iPhone6S至尊王者版999999G大写的牛！！！【包邮】</a></span>
                                    <b class="b_all_require">总需：59人次</b><b class="b_all_require">获得者：用户名最多是八个</b>
                                </div></td>
                            <td class="b_color"><span>交易完成</span><span>订单详情</span></td><td class="times0"></td>
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">分享赚佣金	</a></td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
            <!-- S 分页 -->
            <center>
                <div id="pageWin" class="pageStr" style="display: block;">
                    {!! $list->render() !!}
                </div>
            </center>
            <!-- E 分页 -->
        </div>
        <!-- 虚拟商品 -->
        <div class="b_record_list b_record_free">
            <div class="b_record_info">
                <!-- 商品类型 -->
                <div class="b_cloud_goods">
                    <b>累计获得晋商贷体验卡：</b>
                    <span id="statistics1">0张</span>
                    <b>总金额：</b>
                    <span id="statistics2">￥0</span>
                    <b>累计收益（全部）：</b>
                    <span id="statistics3">￥0</span>
                    <b>中奖面值：</b>
                    <span id="statistics4">￥0</span>
                    <b>投资金额：</b>
                    <span id="statistics5">￥0</span>
                </div>
                <!-- 商品按时间筛选 -->
                <div id="timeChoose" class="b_choose">
                    <ul class="b_choose_day">
                        <li class="b_choose_this" onclick="setCardTime(0)">全部</li>
                        <li onclick="setCardTime(1)">今天</li>
                        <li onclick="setCardTime(2)">本周</li>
                        <li onclick="setCardTime(3)">本月</li>
                        <li onclick="setCardTime(4)">最近三个月</li>
                    </ul>
                    <dl class="b_choose_cal">
                        <dd>选择时间段：</dd>
                        <dd><input type="text"></dd>
                        <dd>&nbsp;-&nbsp;</dd>
                        <dd><input type="text"></dd>
                        <dd class="b_choose_search">搜索</dd>
                    </dl>
                </div>
            </div>
            <!-- 虚拟商品样式 -->
            <div class="b_record_table">
                <div class="b_active_type">
                    <div class="b_is_active">
                        <span class="b_this_active" onclick="setStatus(1)">未使用</span>
                        <i>|</i>
                        <span class="" onclick="setStatus(2)">已使用</span>
                    </div>
                </div>
                <div class="b_card_list" style="display:block;">
                    <!-- 未查看 -->
                    <dl id="status_dl" class="b_card_all b_no_active" style="display: block;">
                        <div class="b_exp_active">
                            <div class="b_exp_left">
                            </div>
                            <div class="b_exp_right">
                                <span class="b_checkbox_all " style="display: none;"><em class="b_exp_checkbox"><div style="display: none;"></div></em><em>全选</em></span>
                                <span class="b_active_btn b_active_btn b_look_detail">查看</span>
                                <span class="b_active_btn b_all_active">批量选择</span>
                            </div>
                        </div>

                        <tt id="cardPackage"></tt><!-- 卡包数据 -->
                        <div class="b_clear"></div>

                    </dl>
                    <!-- 已使用 -->
                    <dl class="b_card_all b_already_active" style="display: none;">
                        <div class="b_exp_active">
                            <div class="b_exp_left">
                            </div>
                            <div class="b_exp_right">
                                <span class="b_checkbox_all"><em class="b_exp_checkbox"><div style="display: none;"></div></em><em>全选</em></span>
                                <span class="b_active_btn b_active_btn b_already_look">查看</span>
                                <span class="b_active_btn b_all_active">批量选择</span>
                            </div>
                        </div>
                        <tt id="cardPackage2"></tt><!-- 卡包数据 -->
                        <div class="b_clear"></div>
                    </dl>
                    <!-- 未查看详情、显示卡号密码 -->
                    <div class="b_card_info b_noactive_info">
                        <div class="b_exp_active">
                            <div class="b_exp_left"><a href="javascript:backPackage();" class="b_back_list">返回列表</a></div>
                            <div class="b_exp_right">
                                <span class="b_checkbox_all " style="display: none;"><em class="b_exp_checkbox"><div style="display: none;"></div></em><em>全选</em></span>
                                <span class="b_active_btn b_active_btn b_active_valid">查看</span>
                                <span class="b_active_btn b_all_active">批量选择</span>
                            </div>
                        </div>
                        <div class="b_winning_List">
                            <ul id="listTable">
                            </ul>
                        </div>
                        <!-- S 分页 -->
                        <center>
                            <div id="pageCardDetails" class="pageStr" style="display: block;"></div>
                        </center>
                        <!-- E 分页 -->
                        <div class="b_clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- S 中奖记录模块内容 -->
</div>
<!-- E 右侧 -->
</div>
<div class="member_right2" style="display:none">
    <div class="g-buyCon clrfix" style="height: 240px;">
        <h3 class="gray3">订单收货地址<a href="javascript:void(0)" class="details_back">返回</a></h3>
        <div class="m-buy-num clrfix">
            <dl id="showNum">
            </dl>
        </div>
    </div>
</div>
<script>
    $(function () {//中奖记录效果
        $('#winTable  tr').hover(function () {
            $(this).children().children('.viewAll').show();
        }, function () {
            $(this).children().children('.viewAll').hide();
        })
    })
</script>
@endsection
@section('my_js')
<script type="text/javascript" src="{{ $url_prefix }}js/user_history.js"></script>
    <script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>
    <script>
        $(function(){
            var start = {
                elem: '#brokerage_source_startTime',
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
                elem: '#brokerage_source_endTime',
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
        
    window._bd_share_config = {
        common: {
        	bdText : '哇塞，全部都好想要！',
			bdComment : '有钱买iphone6s不牛B，花一块钱买到才牛B，有本事就来试试吧！',
			bdDesc : '有钱买iphone6s不牛B，花一块钱买到才牛B，有本事就来试试吧！',
            bdUrl: 'http://{{$_SERVER['HTTP_HOST']}}/freeday?code={{session('user.id')}}',
            bdPic: '{{ url('foreground') }}/img/logo.png',
        },
        share: {}
    };
    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];
        function orderAddres(id){
            $("#showNum").html('');
            var index = layer.load();
            $.ajax({
                    type : 'post',
                    url : '/user/orderAddres',
                    data : {
                        id : id,
                         _token : "{{csrf_token()}}",
                    },
                    dataType : 'json',
                    success : function(data) {
                        layer.close(index);
                        if(data == null){
                            layer.msg('服务端错误！');
                        }
                        if(data.status == 1){
                            var appendStr1 = "";
                            appendStr1 += "<dt class=\"gray6\"><em class=\"f-mar-left\">收货人："+data.receiver+"</em><br><em class=\"f-mar-left\">收货地区："+data.province+"</em><em class=\"f-mar-left\">"+data.city+"</em><em class=\"f-mar-left\">"+data.country+"</em><br><em class=\"f-mar-left\">收货地址："+data.area+"</em><br><em class=\"f-mar-left\">收货号码："+data.mobile+"</em><br><em class=\"f-mar-left\">备注："+data.notice+"</em></dt>";
                            $("#showNum").html(appendStr1);
                        }else if(data.status == 0){
                            layer.msg(data.msg)
                        }
                    }
            });
        }
        function confirmGood(id){
            $.post('/user/confirmGood',{'id':id,'_token':"{{ csrf_token() }}"},function(data){
                data=eval('('+data+')');
                if(data.code>0)
                {
                    layer.msg(data.msg);
                    location.reload();
                }
                else
                {
                    layer.msg(data.msg);
                }
            })
        }
        
        function perfectInfo(id){
            $(".layer_phone").show();
            $("#order_id").val(id);
        }
        
        $(".confirm_btn").click(function(){
            var mobile = $("#mobile_num").val();
            var id = $("#order_id").val();
            if(mobile == ''){
                showError('请填写手机号');
                return false;
            }
            if(mobile.length != 11){
                showError('手机格式不正确');
                return false;
            }
            if(!checkMobile(mobile)){
                showError('手机格式不正确');
                return false;
            }
            $(".layer_phone").hide();
            $.post('/user/autorecharge',{'id':id,'mobile':mobile,'_token':"{{ csrf_token() }}"},function(data){
                if(data.status == 1)
                {
                    $("#success_content").show();
                }
                else
                {
                    $("#error_content").show();
                }
            },'json');
        });
        
        function showError(str)
        {
            $(".error_msg").text(str);
            $(".error_msg").show();
            setTimeout("$('.error_msg').hide()",5000);
        }
        
        function checkMobile(mobile)
        {
            var arr = ['139','138','137','136','135','134','159','158','152','151','150','157','182','183','188','187','147','130','131','132','155','156','186','185','133','153','189','180'];
            var result = $.inArray(mobile.substr(0,3), arr);
            if(result > -1){
                return true;
            }else {
                return false;
            }
        }
        
        $(".phone_content input[type='text']").bind("keyup",function(){
        	var s=$(this).val();
        	var lenth=$(this).val().length;
        	if(lenth<=3){
        		  s=$(this).val();
        		  
        	}else if(lenth<=7){
        		  s=($(this).val()+"").substring(0,3)+"\t"+($(this).val()+"").substring(3,lenth);
        	
        	}else if(lenth<=11){
        		  s=($(this).val()+"").substring(0,3)+"\t"+($(this).val()+"").substring(3,7)+"\t"+($(this).val()+"").substring(7,lenth);
        	
        	}
        	  
           $(".phone_number").html(s);
        });
        $(".finish_info>span").click(function(){
        	$(".layer_phone").hide();
        });
         $("#success_ok").click(function(){
        	$("#success_content").hide();
            location.reload();
        });
         $("#error_ok").click(function(){
        	$("#error_content").hide();
            location.reload();
        });
        
    </script>
@endsection


{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','中奖记录')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
@section('content_right')
    <div id="member_right" class="member_right b_record_box">
        <!-- S 中奖记录模块内容 -->
        <div class="b_record_buy">
		
		
		<div class="u_questit tabtit clearfix">
                <a class="u_quet_a " href="javascript:void(0)" title="去邀请好友">去邀请好友</a>
                <a class="u_quet_a" href="/user/invite/score" title="邀请结果">邀请结果</a>
                <a class="u_quet_a u_quet_acurr" href="/user/inviteprize" title="邀友获奖记录">邀友获奖记录</a>
        </div>
		
            <!-- 实物商品 -->
            <div class="b_record_list b_record_cloud" style="display:block;">
                <div class="b_record_info">
                    <!-- 商品按时间筛选 -->
                    <div class="b_choose" style="display: none;">
                        <ul class="b_choose_day">
                            <li class=""><a href="">全部</a></li>
                            <li class=""><a href="">今天</a></li>
                            <li class=""><a href="">本周</a></li>
                            <li class=""><a href="">本月</a></li>
                            <li class=""><a href="">最近三个月</a></li>
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
                <div style="text-align:center;width:948px;height:530px;padding-top:290px;"><a href="" target="_blank"><img style="width:377px;height:49px;" src="{{asset('foreground/img/member/invite_no.png')}}" alt="暂无数据"></a></div>
                @else
                <table id="winTable">
                    <tbody>
                        <tr class="b_part_title">
                            <th class="b_th1">商品图片</th>
                            <th class="b_th2">商品名称</th>
                            <th class="b_th3">全部状态</th>
                            <th class="b_th4">操作详情</th>
                            <th class="b_th6">一键分享</th>
                        </tr>
                        @foreach ($list as $val)
                            <tr>
                                
                                @if($val->inviteGoods!=null)
                                <td><a href="javascript:void(0)"><img src="{{ $val->inviteGoods->img }}" alt=""></a></td>
                                <td style="text-align: center;" id="div_0"><div class="b_goods_name2">
                                        <span><a href="javascript:void(0)">{{ $val->g_name }}</a></span>
                                    </div></td>
                                <td class="b_color">
                                    @if($val->addressid == 0)
                                        <span>地址未完善</span>
                                    @else
                                        @if($val->status == 3)
                                            <span>待发货</span>
                                        @elseif($val->status == 4)   
                                            <span>已发货</span>
                                        @elseif($val->status == 5)   
                                            <span>已完成</span>
                                        @else
                                            <span>地址已完善</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="times0">
                                    @if($val->addressid == 0)
                                    <a href="{{url('user/address',['orderid'=>$val->id])}}" id="wanshanAddress" >完善地址</a>
                                    @else
                                        @if($val->status == 3)
                                        <a  class="viewAll2" onclick="orderAddres({{$val->id}})" id="wanshanAddress">查看地址</a>
                                        @elseif($val->status == 4)   
                                            <a  onclick="confirmGood({{$val->id}})" id="wanshanAddress">确认收货</a>
                                        @elseif($val->status == 5)   
                                        <a id="wanshanAddress">已完成</a>
                                        @else
                                            <a  onclick="orderAddres({{$val->id}})" id="wanshanAddress">查看地址</a>
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
                                    <!--<a href="javascript::void(0);" class="viewAll" style="display:none">一键分享</a>-->
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
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">一键分享</a></td>
                        </tr>
                        <tr style="display: none;">
                            <td><a href="javascript:gotoGoods(327,725)"><img src="http://img02.ygqq.com/upload/goodsfile/20151127/1_1448627594990.jpg" alt=""></a></td>
                            <td id="div_0"><div class="b_goods_name">
                                    <span><a href="javascript:gotoGoods(327,725)">(第725期)iPhone6S至尊王者版999999G大写的牛！！！【包邮】</a></span>
                                    <b class="b_all_require">总需：59人次</b><b class="b_all_require">获得者：用户名最多是八个</b>
                                </div></td>
                            <td class="b_color"><span>物流运输中</span><span>订单详情</span><span><a id="viewWL">查看物流</a></span></td><td class="times0"><a id="queren">确认收货</a></td>
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">一键分享</a></td>
                        </tr>
                        <tr style="display: none;">
                            <td><a href="javascript:gotoGoods(327,725)"><img src="http://img02.ygqq.com/upload/goodsfile/20151127/1_1448627594990.jpg" alt=""></a></td>
                            <td id="div_0"><div class="b_goods_name">
                                    <span><a href="javascript:gotoGoods(327,725)">(第725期)iPhone6S至尊王者版999999G大写的牛！！！【包邮】</a></span>
                                    <b class="b_all_require">总需：59人次</b><b class="b_all_require">获得者：用户名最多是八个</b>
                                </div></td>
                            <td class="b_color"><span>交易完成</span><span>订单详情</span></td><td class="times0"></td>
                            <td><a href="javascript:gotoGoods(327,725)" class="viewAll" style="display:none">一键分享	</a></td>
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
    </div>
    <!-- S 中奖记录模块内容 -->
</div>
<!-- E 右侧 -->
</div>
<div class="member_right2" style="display:none">
    <div class="g-buyCon clrfix">
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
                   bdText: '1元就能买iPhone 6S，一种很有意思的购物方式，快来看看吧！\n http://www.{{$_SERVER['HTTP_HOST']}}/register?code={{session('user.phone')}}',
                   bdUrl: '',
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
                            appendStr1 += "<dt class=\"gray6\"><em class=\"f-mar-left\">收货人："+data.receiver+"</em><br><em class=\"f-mar-left\">收货地区："+data.province+"</em><em class=\"f-mar-left\">"+data.city+"</em><em class=\"f-mar-left\">"+data.country+"</em><br><em class=\"f-mar-left\">收货地址："+data.area+"</em><br><em class=\"f-mar-left\">收货号码："+data.mobile+"</em></dt>";
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
    </script>
@endsection


{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','充值记录')
@section('content_right')
    <div id="member_right" class="member_right b_record_box">
        <!-- S 充值记录模块内容 -->
        <div class="b_record_buy">
            <!--S 充值明细 -->
            <div class="b_record_list b_record_cloud" style="display: block;">
                <div class="b_record_info" style="display:none">
                    <!-- 充值按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                        <ul class="b_choose_day">
                            <li class="{{ empty($type) ? 'b_choose_this':'' }}"><a href="{{ url('/user/recharge',['type'=>0]) }}">全部</a></li>
                            <li class="{{ $type==1 ? 'b_choose_this':'' }}"><a href="{{ url('/user/recharge',['type'=>1]) }}">今天</a></li>
                            <li class="{{ $type==2 ? 'b_choose_this':'' }}"><a href="{{ url('/user/recharge',['type'=>2]) }}">本周</a></li>
                            <li class="{{ $type==3 ? 'b_choose_this':'' }}"><a href="{{ url('/user/recharge',['type'=>3]) }}">本月</a></li>
                            <li class="{{ $type==4 ? 'b_choose_this':'' }}"><a href="{{ url('/user/recharge',['type'=>4]) }}">最近三个月</a></li>
                        </ul>
                        <dl class="b_choose_cal a_choose_cal" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="brokerage_source_startTime" readonly="true" type="text"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="brokerage_source_endTime" readonly="true" type="text"></dd>
                        </dl>
                        <div class="a_clear a_margin_num" style="display: none;"></div>
                        <ul class="b_choose_day" style="display: none;">
                            <li class="b_choose_this">来源状态</li>
                        </ul>
                        <div class="a_select_choose" style="display: none;">
                            <ul>
                                <i></i>
                                <li id="payCode" class="a_select_info">
                                    <span><input value="" class="code" type="hidden"> 全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="" type="hidden"> 全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="weixin" type="hidden"> 微信支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="jdong" type="hidden"> 京东支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="ylian" type="hidden"> 银联支付</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="jcard" type="hidden"> 购物卡</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="code" value="zfb" type="hidden"> 支付宝支付</span>
                                </li>
                            </ul>
                            <em>-</em>
                            <ul>
                                <i></i>
                                <li id="payStatus" class="a_select_info">
                                    <span>全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span>全部</span>
                                </li>
                                <li class="a_select_detail">
                                    <span> <input class="status" type="hidden" value="1">成功</span>
                                </li>
                                <li class="a_select_detail">
                                    <span><input class="status" type="hidden" value="0">未付款</span>
                                </li>
                            </ul>
                        </div>
                        <dl class="b_choose_cal" style="display: none;">
                            <dd>交易号：</dd>
                            <dd>
                                <input id="tradeNo" type="text" maxlength="40" style="width: 299px;">
                            </dd>
                            <dd class="b_choose_search a_choose_search" onclick="actionRechargeSeach()">搜索</dd>
                        </dl>
                        <div class="a_clear" ></div>
                    </div>
                </div>
                <div class="b_record_table a_record_table">
                @if($list->count()==0)
                    <div style="text-align:center;width:948px;height:530px;padding-top:290px;"><a href="" target="_blank"><img style="width:377px;height:49px;" src="{{asset('foreground/img/no_num.png')}}" alt="暂无数据"></a></div>
                @else
                    <table id="rechargeList">
                        <tbody>
                            <tr class="b_part_title">
                                <th class="b_th1">交易号</th>
                                <th class="b_th2">充值时间</th>
                                <th class="b_th3">金额 （元）</th>
                                <th class="b_th4">充值通道</th>
                                <th class="b_th6">充值状态</th>
                            </tr>
                            @foreach ($list as $val)
                                <tr>
                                    <td>{{ $val->code }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$val->time) }}</td>
                                    <td>{{ $val->amount }}</td>
                                    <td>
                                        @if($val->pay_type == 'unionpay')
                                        银联支付
                                        @elseif($val->pay_type == 'weixin')
                                        微信支付
                                        @endif
                                    </td>
                                    <td class="a_record_span">
                                        @if ($val->status == 1)
                                            <span>已付款</span>
                                        @elseif($val->status == 0)
                                            <span>未付款</span>
                                        @endif                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
                <!-- S 分页 -->
                <center>
                    <div id="rechargeListPageStr" class="pageStr" style="display: block;">
                        {!! $list->render() !!}
                    </div>
                </center>
                <!-- E 分页 -->
            </div>
            <!--E 充值明细 -->
        </div>
        <!-- E 充值记录模块内容 -->
    </div>
    <!-- E 右侧 -->
    </div>
@endsection
@section('my_js')
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
    </script>
@endsection



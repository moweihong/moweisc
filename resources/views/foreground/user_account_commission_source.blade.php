{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','佣金来源')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection

@section('content_right')
    <div id="member_right" class="member_right">
        <!--invite result start-->
        <div class="mycommission">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a" href="commission" title="招募合伙人" style="display: none;">招募合伙人</a>
                <a class="u_quet_a u_quet_acurr" href="commissionsource" title="佣金来源">佣金来源</a>
                <a class="u_quet_a" href="commissionbuy" title="佣金消费">佣金消费</a>
                <a class="u_quet_a" href="mybankcard" title="我的银行卡">我的银行卡</a>
            </div>
            <!--tit end-->
            <!--txt start-->
            <div class="mycommission-source">
                <!--条件 start-->
                <div class="b_record_info">
                    <!-- 佣金类型 -->
                    <div class="b_cloud_goods a_cloud_goods">
                        <b>邀请好友（人）：</b>
                        <span id="brokerage_source_count">（{{$inviteNums}}）</span>
                        <b>累计已赚取佣金：</b>
                        <span id="brokerage_source_total_money">（{{$makeCommi}}）</span>
                        <b>累计赚取推广收益：</b>
                        <span id="tgBrokerageSum">（{{$makeInviteCommi}}）</span>
                        <b>好友购买累计赚取佣金：</b>
                        <span id="hhrBrokerageSum">（{{$snatchCommi}}）</span>
                        @if($makeCommi>0)
                            <a class="a_score_exchange" href="/user/withdraw">提现</a>
                        @else
                            <a class="a_score_exchange a_invite_withdraw" href="javascript:void(0);" style="background-image: none; background-attachment: scroll; background-color: rgb(153, 153, 153); background-position: 0px 0px; background-repeat: repeat repeat;">提现</a>
                        @endif                 
                       
                    </div>
                    <!-- 佣金来源按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                        <ul class="b_choose_day">
                            <li class="b_choose_this" onclick="ajaxBrokerageSource({size:5}, actionLoadBrokerageSource);">全部</li>
                            <li onclick="actionSearchBrokerageSourceByTime(1);">今天</li>
                            <li onclick="actionSearchBrokerageSourceByTime(2);">本周</li>
                            <li onclick="actionSearchBrokerageSourceByTime(3);">本月</li>
                            <li onclick="actionSearchBrokerageSourceByTime(4);">最近三个月</li>
                        </ul>
                        <!-- <dl class="b_choose_cal">
                            <dd>选择时间段：</dd>
                            <dd><input readonly="true" type="text" class="laydate-icon" id="brokerage_source_startTime" name="brokerage_source_startTime"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input readonly="true" type="text" class="laydate-icon" id="brokerage_source_endTime" name="brokerage_source_endTime"></dd>
                            <dd class="b_choose_search" onclick="actionSearchBrokerageSourceByTimeRange();">搜索</dd>
                        </dl> -->
                        <div class="a_clear"></div>
                    </div>
                </div>
                <!--source start-->
                <div class="b_record_table a_record_table a_record_table1 a_record_table_width">
                    @if(is_object($list)&&$list->count()>0)
                        <table>
                            <tr class="b_part_title">
                                <th class="b_th1_score">被邀请人</th>
                                <th class="b_th3_score">获得佣金</th>
                                <th class="b_th4_score">佣金来源</th>
                                <th class="b_th4_score">佣金获得时间</th>
                            </tr>
                            @foreach($list as $val)
                                <tr class="b_part_title">
                                    <td class="b_th1">{{$val->member->nickname}}</td>
                                    <td class="b_th3">{{$val->commission}}</td>
                                    <td class="b_th4">
                                        <?php 
                                            switch ($val->source_type) {
                                                case 0:
                                                    echo '推广佣金';
                                                    break;
                                                case 1:
                                                    echo '好友购买';
                                                    break;
                                                case 2:
                                                    echo '好友充值';
                                                    break;
                                                default:
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="b_th6">{{date('Y-m-d H:i:s',$val->time)}}</td>
                                </tr>
                            @endforeach
                           </table>
                    @else
                        <div class="invite-nodata"></div>
                    @endif   
                    <center>
                        <div id="pageCloud" class="pageStr" style="display: block;">
                            {!! $list->render() !!}
                        </div>
                    </center>
                  </div>
                <!--source end-->
            </div>
            <!--txt start-->
        </div>
        <!--invite result end-->
    </div>
    <!-- E 右侧 -->
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


{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','积分邀请结果')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
@section('content_right')
    <div id="member_right" class="member_right">
        <!--invite score start-->
        <div class="invite-result">
            <!--tit start-->
            <div class="u_questit tabtit clearfix">
                <a class="u_quet_a" href="/user/invite" title="去邀请好友">去邀请好友</a>
                <a class="u_quet_a u_quet_acurr" href="javascript:void(0)" title="邀请结果">邀请结果</a>
				 <a class="u_quet_a" href="/user/inviteprize" title="邀友获奖记录">邀友获奖记录</a>
            </div>
            <!--tit end-->
            <!--txt start-->
            <div class="result-main">
                <div class="b_record_info">
                    <!-- 积分类型 -->
                    <div class="b_cloud_goods a_cloud_goods">
                        <b>  邀请获得块乐豆：</b>
                        <span id="invite_result_score">（{{ $invitescore }}块乐豆）</span>
                        <b>邀请好友注册：</b>
                        <span id="invite_result_total">（{{ $invitenum }}人）</span>
                    </div>
                    <!-- 积分来源按时间筛选 -->
                    <div class="b_choose a_choose clearfix" style="display: none;">
                        <ul class="b_choose_day">
                            <li class="b_choose_this">全部</li>
                            <li>今天</li>
                            <li>本周</li>
                            <li>本月</li>
                            <li>最近三个月</li>
                        </ul>
                        <dl class="b_choose_cal clearfix" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input readonly="true" type="text" id="invite_result_startTime" class="laydate-icon" name="invite_result_startTime"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input readonly="true" type="text" id="invite_result_endTime" class="laydate-icon" name="invite_result_endTime"></dd>
                            <dd class="b_choose_search" onclick="actionSearchInviteResultByTimeRange();">搜索</dd>
                        </dl>
                    </div>
                    <!--record start-->
                    <div class="b_record_table a_record_table a_record_table1 a_record_table_width" style="margin: 20px 0 0 0;">
                        <table>
                            @if ($list==null)
                                <div class="invite-nodata"></div>
                            @else
                            <tr class="b_part_title">
                                <th class="b_th1">被邀请用户名</th>
                                <th class="b_th2">注册时间</th>
                                <th class="b_th3">认证手机</th>
                                <th class="b_th4">验证邮箱</th>
                            </tr>
                           
                                @foreach ($list as $val)
                                <tr class="b_part_title">
                                    <td class="b_th1">{{ preg_replace("/(1\d{2})(\d{4})(\d{4})/", "\$1****\$3", $val['user_name']) }}</td>
                                    <td class="b_th2">{{ $val['reg_time'] }}</td>
                                    <td class="b_th3">{{ preg_replace("/(1\d{2})(\d{4})(\d{4})/", "\$1****\$3", $val['user_phone']) }}</td>
                                    @if(empty($val['user_email']))
                                        <td class="b_th4">无</td>
                                    @else
                                        <td class="b_th4">{{ $val['user_email'] }}</td>
                                    @endif
                                </tr> 
                                @endforeach
                            @endif
                         
                        </table>
                    </div>
                    <!--record end-->
                </div>
            </div>
            <!--txt end-->
        </div>
        <!--invite score end-->
    </div>
    <!-- E 右侧 -->
@endsection

@section('my_js')
    <script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>
    <script>
        $(function(){
            var start = {
                elem: '#invite_result_startTime',
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
                elem: '#invite_result_endTime',
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


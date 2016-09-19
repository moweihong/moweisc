{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','我的红包')
@section('content_right')
    <div id="member_right" class="member_right b_record_box">
        <ul class="b_record_title">
            <li class="<?php echo $state==0? 'b_record_this':'';?>"><a href="{{ url('user/bribery',['state'=>0]) }}">可使用</a></li>
            <li class="<?php echo $state==1? 'b_record_this':'';?>"><a href="{{ url('user/bribery',['state'=>1]) }}">已使用/过期</a></li>
        </ul>
        <input type="hidden" id="state" value="1">
        <div>
            <!-- S 可使用红包 -->
            <div class="b_record_list" style="display:block;">
                <!-- <div class="c_address_top c_redpacket_top">
                    红包即将过期时通知我：
                    <b>1.邮件通知</b>
                    <b>2.短信提醒发送至：13603550771 </b>
                    <a href="javascript:void(0);" class="c_revise">修改</a>
                </div> -->
                <div class="b_record_info">
                    <!-- 商品按时间筛选 -->
                    <div class="b_choose" style="display:none;">
                        <ul class="b_choose_day">
                            <li class="{{ empty($type) ? 'b_choose_this':'' }}"><a href="{{ url('/user/bribery',['state'=>$state,'type'=>0]) }}">全部</a></li>
                            <li class="{{ $type==1 ? 'b_choose_this':'' }}"><a href="{{ url('/user/bribery',['state'=>$state,'type'=>1]) }}">今天</a></li>
                            <li class="{{ $type==2 ? 'b_choose_this':'' }}"><a href="{{ url('/user/bribery',['state'=>$state,'type'=>2]) }}">本周</a></li>
                            <li class="{{ $type==3 ? 'b_choose_this':'' }}"><a href="{{ url('/user/bribery',['state'=>$state,'type'=>3]) }}">本月</a></li>
                            <li class="{{ $type==4 ? 'b_choose_this':'' }}"><a href="{{ url('/user/bribery',['state'=>$state,'type'=>4]) }}">最近三个月</a></li>
                        </ul>
                        <dl class="b_choose_cal" style="display:none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="invite_result_startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="invite_result_endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\')}',maxDate:'2020-10-01'})"></dd>
                            <dd class="b_choose_search" onclick="actionSearch()">搜索</dd>
                        </dl>
                    </div>
                </div>
                @if ($list->count()>0)
                <ul class="c_user_list" id="redList">
                    @foreach ($list as $val)<li>
                        <div class="c_user_bg">
                        	<a href="/category">
                            <div class="c_user_left">
                            	
                                	￥{{floor($val->redbao->money)}}
                                
                            </div>
                            </a>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>{{ $val->redbao->name }}</span>
                                    @if($val->status == 1)
                                        <a>已使用</a>
                                    @elseif($state==1)
                                        <a>已过期</a>
                                    @endif
                                </div>
                                <p class="c_remain">
                                    金额：
                                    <span>{{$val->redbao->money}}块</span>
                                </p>
                                <p class="">开始日期：
                                    <i>{{ date('Y-m-d H:i:s',$val->start_time) }}</i>
                                </p>
                                <p class="">结束日期：
                                    <i>{{ date('Y-m-d H:i:s',$val->end_time) }}</i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>{{$val->redbao->desc}}</i>
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    
<!--                    <li>
                        <div class="c_user_bg">
                            <div class="c_user_left">
                                ￥1
                            </div>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>
                                        1元红包
                                    </span>
                                    <a href="/goods/allCat.html">
                                        使用
                                    </a>
                                </div>
                                <p class="c_remain">
                                    余额：
                                    <span>
                                        1块
                                    </span>
                                </p>
                                <p class="">
                                    开始日期：
                                    <i>
                                        2016-02-26 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    结束日期：
                                    <i>
                                        2016-03-27 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>
                                        单笔消费满10元可使用1元红包
                                    </i>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="c_user_bg">
                            <div class="c_user_left">
                                ￥3
                            </div>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>
                                        3元红包
                                    </span>
                                    <a href="/goods/allCat.html">
                                        使用
                                    </a>
                                </div>
                                <p class="c_remain">
                                    余额：
                                    <span>
                                        3块
                                    </span>
                                </p>
                                <p class="">
                                    开始日期：
                                    <i>
                                        2016-02-26 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    结束日期：
                                    <i>
                                        2016-03-27 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>
                                        单笔消费满30元可使用3元红包
                                    </i>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="c_user_bg">
                            <div class="c_user_left">
                                ￥5
                            </div>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>
                                        5元红包
                                    </span>
                                    <a href="/goods/allCat.html">
                                        使用
                                    </a>
                                </div>
                                <p class="c_remain">
                                    余额：
                                    <span>
                                        5块
                                    </span>
                                </p>
                                <p class="">
                                    开始日期：
                                    <i>
                                        2016-02-26 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    结束日期：
                                    <i>
                                        2016-03-27 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>
                                        单笔消费满50元可使用5元红包
                                    </i>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="c_user_bg">
                            <div class="c_user_left">
                                ￥10
                            </div>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>
                                        10元红包
                                    </span>
                                    <a href="/goods/allCat.html">
                                        使用
                                    </a>
                                </div>
                                <p class="c_remain">
                                    余额：
                                    <span>
                                        10块
                                    </span>
                                </p>
                                <p class="">
                                    开始日期：
                                    <i>
                                        2016-02-26 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    结束日期：
                                    <i>
                                        2016-03-27 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>
                                        单笔消费满100元可使用10元红包
                                    </i>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="c_user_bg">
                            <div class="c_user_left">
                                ￥10
                            </div>
                            <div class="c_user_right">
                                <div class="c_packet_name">
                                    <span>
                                        10元红包
                                    </span>
                                    <a href="/goods/allCat.html">
                                        使用
                                    </a>
                                </div>
                                <p class="c_remain">
                                    余额：
                                    <span>
                                        10块
                                    </span>
                                </p>
                                <p class="">
                                    开始日期：
                                    <i>
                                        2016-02-26 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    结束日期：
                                    <i>
                                        2016-03-27 14:05:11
                                    </i>
                                </p>
                                <p class="">
                                    使用说明：
                                    <i>
                                        单笔消费满100元可使用10元红包
                                    </i>
                                </p>
                            </div>
                        </div>
                    </li>-->
                </ul>
                @else
                  <div style="text-align:center;width:948px;height:530px;padding-top:290px;"><a href="" target="_blank"><img style="width:377px;height:49px;" src="{{asset('foreground/img/hb.png')}}" alt="暂无数据"></a></div>  
                @endif
                
                <!-- S 分页 -->
                <center>
                    <div id="pageRed" class="pageStr" style="display: block;">
                        {!! $list->render()!!}
                    </div>
                </center>
                <!-- E 分页 -->
            </div>
            <!-- E 可使用红包 -->
        </div>
        <!-- E 右侧 -->
    </div>
    </div>
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

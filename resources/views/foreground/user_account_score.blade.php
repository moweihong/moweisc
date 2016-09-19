{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','我的块乐豆')
@section('content_right')
<style>
	.kld_mission h2{
		font-size: 20px;
	    font-weight: bold;
	    padding-left: 23px;
	    padding-top: 10px;
	}
	.kld_mission p{
		width: 263px;
	    height: 51px;
	    background: #FE0100;
	    font-size: 22px;
	    color: white;
	    text-align: center;
	    line-height: 51px;
	    float: left;
	    margin: 7px 10px;
	    cursor: pointer;
	}
	.kld_mission div{
		width: 850px;
	    height: 128px;
	    padding: 25px 10px;
	    border: 1px solid #E3E3E3;
	    margin: 14px 43px;
	}
	.kld_mission .active{
		background: grey;
	}
	.kld_tip2 {
    width: 240px;
    height: 74px;
    background: url({{ $url_prefix }}img/kld_tip.png) no-repeat;
    position: absolute;
    padding-left: 12px;
    padding-top: 14px;
    top: 119px;
    left: 77px;
    font-size: 14px;
    color: #666666;
 	z-index: 1;
    display: none;
	}
	.counts-ct{height:158px;position: relative;border: 1px solid #DEDEDE;font-size: 20px;margin-bottom: 18px;}
	.counts-ct li{width: 191px;float: left;    text-align: center;  padding: 8px 0;}
	.counts-ct li div{    padding: 21px 0;    border-right: 1px dashed #DEDEDE;}
	.counts-ct p{height: 50px;line-height: 50px;color: #fe0100;}
	.counts-ct li:first-child p img{    vertical-align: middle; margin-left: 4px;}
	.counts-ct p:first-child{color: #333333;}
	.counts-ct .counts-li-last{width:380px;font-size: 16px;}
	.counts-ct .counts-li-last div{border: none;}
	.kld-mission ul li input,.counts-li-last input{width: 80px;height: 30px;border:none;border-radius:5px; background: #eb5151; font-size: 16px;color: white;line-height: 28px;}
	.counts-li-last input:first-child{margin-right: 55px;}
	.b_record_title{	border-top: 1px solid #E7E7E7;}
	.kld-mission{    padding: 40px 20px;}
	.kld-mission ul{height:85px;border: 1px solid #D91E16;	border-radius:5px ;margin-top: -1px;}
	.kld-mission ul li{width: 190px;height:85px;line-height:85px;float: left; text-align: center;}
	.kld-mission ul li:first-child{font-size: 20px;color: #EB5151;}
	.kld-mission ul .kld-mission-li-center{width: 532px;border-left:1px dashed #D91E16 ;border-right:1px dashed #D91E16 ;font-size: 18px;}
	.kld-mission ul .two-line{line-height: 32px;    padding-top: 10px;  height: 75px;}
	.kld_tip2 p{    height: 24px; line-height: 30px;}
	.js-quesion img{cursor: pointer;}
    .invite_friend_alert{ width: 396px; height: 410px; border: 1px solid #E2E2E4; position: fixed; margin-left: -198px;  margin-top: -150px;
        left: 50%; top: 50%; background: white; z-index: 9999; border-radius: 8px;  text-align: center;overflow: hidden;  /* display: none; */}
    .invite_friend_alert{height: 180px;margin-top: -85px;}
    .invite_friend_alert span{line-height: 38px;   font-size: 18px;}
    .invite_friend_alert .alert_header span{float: right;}
    .invite_friend_alert .alert_header span:first-child,.activity_rule  .alert_header span:first-child,.kld_not_enought .alert_header span:first-child{float: left;padding-left: 20px;}
    .invite_friend_alert {font-size: 14px;color:#666666}
    .login_line {
        border-bottom: 1px solid #E2E2E4;
        width: 100%;
    }
    .invite_friend_ct {
        width: 320px;
        margin: 0 auto;
    }
    .invite_friend_ct div:first-child {
        line-height: 30px;
        text-align: left;
    }
    .alert_header {
        background: #FFFBFB;
        height: 40px;
    }
    .close_login {
        color: #999;
        float: right;
        cursor: pointer;
        margin-right: 10px;
        font-weight: normal;
        font-size: 20px;
    }
    .invite_friend_ct div a:first-child {
        margin-left: 0;
    }
    .invite_friend_ct div a {
        display: block;
        float: right;
        width: 51px;
        margin-top: 15px;
        margin-right: 23px;
    }
</style>

    <div id="member_right" class="member_right b_record_box">
    	<div class="counts-ct">
    		<ul><li><div><p>我的块乐豆</p><p class="js-quesion">{{$totalScore}}个<img src="{{$url_prefix}}img/question_ioc.png"/></p></div></li>
    			<li><div><p>累计获得</p><p>{{$totalGet}}个</p></div></li>
    			<li><div><p>累计消费</p><p>{{$totalUse}}个</p></div></li>
    			<li class="counts-li-last"><div><p>块乐豆不仅可以消费抵扣，还可以参与活动抽奖哦</p><p><input type="button" value="参与活动" onclick="window.location.href='/freeday'"/><input type="button" value="参与抢购" onclick="window.location.href='/index'"/></p></div></li>
    		</ul>
    		<div class="kld_tip2">
        		<p>100块乐豆=1块钱,</p>
        		<p>块乐豆将于每年12月31日24点清零</p>
        	</div>
    	</div>
    	
    	
        <!-- S 我的积分模块标题 -->
        <ul class="b_record_title score_b_record_title">
        	<li class="{{ $status==2 ? 'b_record_this':'' }}"><a href="{{ url('user/score',['status'=>2]) }}">块乐豆任务</a></li>
            <li class="{{ $status==0 ? 'b_record_this':'' }}"><a href="{{ url('user/score',['status'=>0]) }}">块乐豆来源</a></li>
            <li class="{{ $status==1 ? 'b_record_this':'' }}"><a href="{{ url('user/score',['status'=>1]) }}">块乐豆使用</a></li>
        </ul>


        <!-- E 我的积分模块标题 -->
        <!-- S 我的积分模块内容 -->
        <div class="b_record_buy">
            @if($status == 2)
        	  <div class="kld-mission">
                	<ul><li>火速抢宝</li><li class="kld-mission-li-center">每参与1元可获得1个块乐豆</li><li><input type="button" value="去参与" onclick="window.location.href='/index'"/></li></ul>
                	<ul><li>呼朋唤友</li><li class="kld-mission-li-center two-line">邀请好友注册并消费可获得100个块乐豆<br/>（块乐豆，红包消费除外）</li><li><input type="button" value="去邀请" class="invite_friend"/></li></ul>
                	<ul><li>昭告天下</li><li class="kld-mission-li-center">成功晒单可获得100-500个块乐豆</li><li><input type="button" value="去晒单" onclick="window.location.href='/user/prize'"/></li></ul>
                	<ul><li>客官贵姓</li><li class="kld-mission-li-center">完善个人信息可获得30个块乐豆</li><li><input type="button"  @if($profile > 0) style="background-color:#999" value="已完善" @else onclick="window.location.href='/user/security'" value="去完善" @endif/></li></ul>
              </div>
            @endif
            <!-- 积分来源 -->
            @if($status == 0)
            <div class="b_record_list b_record_cloud" style="display:block;">
                <div class="b_record_info">
                    <!-- 积分类型 -->
                    <div class="b_cloud_goods a_cloud_goods">
                        <b>全部累计块乐豆</b>
                        <span id="scoreSourceTotalByTime">({{ $totalScore }})</span>
                        {{--<b>晒单获得块乐豆</b>--}}
                        {{--<span id="buyScore">({{ $buyScore }})</span>--}}
                        {{--<b style="display: none;">签到获得块乐豆</b>--}}
                        {{--<span id="signScore" style="display: none;">({{ $signScore }})</span>--}}
                        {{--<b>邀请好友获得块乐豆</b>--}}
                        {{--<span id="inviteScore">({{ $inviteScore }})</span>--}}
                        <!-- <b>晒单获得积分</b>
                        <span id="singleScore"></span>
                        <a class="a_score_exchange" href="javascript:void(0);">积分兑换</a> -->
                    </div>
                    <!-- 积分来源按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                        <ul class="b_choose_day b_score_source_time">
                            <li class="{{ empty($type) ? 'b_choose_this':'' }}" ><a href="{{ url('/user/score',['type'=>0]) }}">全部</a></li>
                            <li data-val="1" class="{{ $type==1 ? 'b_choose_this':'' }}"><a href="{{ url('/user/score',['type'=>1]) }}">今天</a></li>
                            <li data-val="2" class="{{ $type==2 ? 'b_choose_this':'' }}"><a href="{{ url('/user/score',['type'=>2]) }}">本周</a></li>
                            <li data-val="3" class="{{ $type==3 ? 'b_choose_this':'' }}"><a href="{{ url('/user/score',['type'=>3]) }}">本月</a></li>
                            <li data-val="4" class="{{ $type==4 ? 'b_choose_this':'' }}"><a href="{{ url('/user/score',['type'=>4]) }}">最近三个月</a></li>
                        </ul>
                        <dl class="b_choose_cal" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="invite_result_startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="invite_result_endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\')}',maxDate:'2020-10-01'})"></dd>
                            <dd class="b_choose_search" onclick="ScoreSourceSearch()">搜索</dd>
                        </dl>
                        <div class="a_clear"></div>
                    </div>
                </div>
                <div class="b_record_table a_record_table a_record_table1 a_record_table_width" style="height:626px">
                    <table id="scoreSource">
                        <tbody>
                            <tr class="b_part_title">
                                <th class="b_th1">渠道来源</th>
                                <th class="b_th3">获得时间</th>
                                <th class="b_th4">获得块乐豆</th>
                            </tr>
                            @foreach ($list as $val)
                                <tr>
                                    <td>{{ $val->pay }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$val->time) }}</td>
                                    <td>{{ $val->money }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- S 分页 -->
                <div class="">
                    <center>
                        <div id="pageStr" class="pageStr" style="display: block;">
                            {!! $list->render() !!}
                        </div>
                    </center>
                </div>
                <!-- E 分页 -->
            </div>
            @elseif($status == 1)
            <!-- 积分消费 -->
            <div class="b_record_list b_record_cloud" style="display:block;">
                <div class="b_record_info">
                    <!-- 积分类型 -->
                    <div class="b_cloud_goods a_cloud_goods">
                        <b>全部累计块乐豆</b>
                        <span id="scoreSourceTotalByTime">({{ $totalScore }})</span>
                        {{--<b>晒单获得块乐豆</b>--}}
                        {{--<span id="buyScore">({{ $buyScore }})</span>--}}
                        {{--<b style="display: none;">签到获得块乐豆</b>--}}
                        {{--<span id="signScore" style="display: none;">({{ $signScore }})</span>--}}
                        {{--<b>邀请好友获得块乐豆</b>--}}
                        {{--<span id="inviteScore">({{ $inviteScore }})</span>--}}
                        <!-- <b>晒单获得积分</b>
                        <span id="singleScore"></span>
                        <a class="a_score_exchange" href="javascript:void(0);">积分兑换</a> -->
                    </div>
                    <!-- 积分消费按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                        <ul class="b_choose_day b_score_consume_time">
                            <li class="b_choose_this" data-val="-1">全部</li>
                            <li data-val="1">今天</li>
                            <li data-val="2">本周</li>
                            <li data-val="3">本月</li>
                            <li data-val="4">最近三个月</li>
                        </ul>
                        <dl class="b_choose_cal">
                            <dd>选择时间段：</dd>
                            <dd><input id="invite_result_startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="invite_result_endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\')}',maxDate:'2020-10-01'})"></dd>
                            <dd class="b_choose_search" onclick="ScoreConsumerSearch()">搜索</dd>
                        </dl>
                        <div class="a_clear"></div>
                    </div>
                </div>
                <div class="b_record_table a_record_table a_record_table1 a_record_table_width" style="height:570px">
                    <table id="scoreSource">
                        <tbody>
                            <tr class="b_part_title">
                                <th class="b_th1">使用记录</th>
                                <th class="b_th3">使用时间</th>
                                <th class="b_th4">使用块乐豆</th>
                            </tr>
                            @foreach ($list as $val)
                                <tr>
                                    <td>{{ $val->pay }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$val->time) }}</td>
                                    <td>{{ $val->money }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- S 分页 -->
                    <center>
                        <div id="pageStr" class="pageStr" style="display: block;">
                            {!! $list->render() !!}
                        </div>
                    </center>
                <!-- E 分页 -->
            </div>
            @endif
        </div>
        <!-- E 我的积分模块内容 -->
        <!-- E 右侧 -->
    </div>

<div class="invite_friend_alert alert hide">
    <div class="alert_header">
        <span>邀友免费玩</span>
        <span class="close_login">X</span>
    </div>
    <div class="login_line"></div>
    <div class="invite_friend_ct">
        <div>邀请好友可免费参与活动，赶快邀友抢百万豪礼吧！</div>
        {{--<div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">--}}
        {{--<a href="#" class="bds_qzone"  data-cmd="qzone"><img src="/foreground/img/other_platform001.png"/></a>--}}
        {{--<a href="#"><img src="/foreground/img/other_platform002.png"/></a>--}}
        {{--<a href="#"><img src="/foreground/img/other_platform003.png" /></a>--}}
        {{--<a href="#"><img src="/foreground/img/other_platform004.png" /></a>--}}
        {{--<a href="#"><img src="/foreground/img/other_platform005.png" /></a>--}}
        {{--</div>--}}
        <div class="share_content_ioc bdsharebuttonbox" data-tag="share_1">
            <a class="bds_qzone"  data-cmd="qzone"  style="background: url('/foreground/img/other_platform006.png') no-repeat; height: 50px;display: block"></a>
            {{--<a class="bds_renren" data-cmd="renren"  style="background: url('/foreground/img/other_platform004.png') no-repeat; height: 50px;display: block"></a>--}}
            <a class="bds_weixin" data-cmd="weixin"  style="background: url('/foreground/img/other_platform003.png') no-repeat; height: 50px;display: block"></a>
            <a class="bds_tsina" data-cmd="tsina" style="background: url('/foreground/img/other_platform002.png') no-repeat; height: 50px;display: block"></a>
            <a class="bds_sqq" data-cmd="sqq"  style="background: url('/foreground/img/other_platform001.png') no-repeat; height: 50px;display: block"></a>
        </div>
    </div>
</div>
@endsection


@section('my_js')
    {{--<script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>--}}
    <script>
//        $(function(){
//            var start = {
//                elem: '#invite_result_startTime',
//                format: 'YYYY/MM/DD hh:mm:ss',
//                //min: laydate.now(), 设定最小日期为当前日期
//                max: '2099-06-16 23:59:59', //最大日期
//                istime: true,
//                istoday: false,
//                choose: function(datas){
//                    end.min = datas; //开始日选好后，重置结束日的最小日期
//                    end.start = datas //将结束日的初始值设定为开始日
//                }
//            };
//            var end = {
//                elem: '#invite_result_endTime',
//                format: 'YYYY/MM/DD hh:mm:ss',
//                //min: laydate.now(),
//                max: '2099-06-16 23:59:59',
//                istime: true,
//                istoday: false,
//                choose: function(datas){
//                    start.max = datas; //结束日选好后，重置开始日的最大日期
//                }
//            };
//            laydate(start);
//            laydate(end);
//        })
        $(".js-quesion img").mouseenter(function(){
        	$(".kld_tip2").show();
        })
         $(".js-quesion img").mouseleave(function(){
        	$(".kld_tip2").hide();
        })
        $('.invite_friend').click(function(){
            $('.invite_friend_alert').show();
            $('.all_grey_bg').show();
        })
$(".close_login").click(function(){
    $(this).parent().parent().hide();
    $(".all_grey_bg").hide();
});

window._bd_share_config = {
    common : {
        bdText : '一言不合就中iPhone，就问还！有！谁！',
        bdComment : '一言不合就中iPhone，就问还！有！谁！',
        bdDesc : '一言不合就中iPhone，就问还！有！谁！',
        bdUrl : "http://www.ts1kg.com/freeday?code={{session('user.id')}}",
        bdPic : 'http://www.ts1kg.com/foreground/img/wxshare.png'
    },
    share : [{
        "bdSize" : 32
    }]
}

with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
    </script>
@endsection

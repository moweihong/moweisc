{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','系统消息')
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
    .no_read td{
        color: #000000;
        font-size: 14px;
        font-style: normal;
        font-weight: 700;
    }
    .b_record_list .check_look{ 
  		width: 65px;
		height: 22px;
	    border-radius: 5px;
	    display: inline-block;
	    *display: inline;
	    *zoom: 1;
	    background: #3CA2EA;
	    color: white;
}
.none-of-message{    
	text-align: center;
    padding-top: 110px;
    }
    .msg-alert{width: 478px;height: 310px;border-radius: 5px;border: 1px solid #DEDEDE;position: absolute;top: 50%;left: 50%;margin-left: -239px;margin-top: -155px;background: white;z-index: 10000;display: none;}
    .msg-title{height: 32px;line-height: 32px;border-bottom: 1px solid #DEDEDE;padding-left: 10px;}
    .msg-title *{font-size: 14px;color: black;}
	.msg-title i{ display: inline-block;  *display: inline; *zoom: 1;width: 50px;}
    .msg-content{height: 186px;border-bottom: 1px solid #DEDEDE;    padding-top: 12px;padding-left: 22px;}
    .msg-bottom{height:68px;text-align: center;line-height: 68px;}
    .msg-bottom input{width: 100px;height: 30px;line-height:30px;border-radius: 5px;color: white;  background: #3CA2EA;border: none;}
    .close-btn{font-size:23px;float: right;padding-right: 3px;line-height: 20px;cursor: pointer;}
   	.msg-content p{    width: 340px;  max-height: 159px;float: right; padding-right: 55px;overflow: hidden;  display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 9;
    /* white-space: nowrap; */}
</style>
    <div id="member_right" class="member_right b_record_box">
        <!-- S 我的积分模块标题 -->
        <ul class="b_record_title score_b_record_title">
            <li class="b_record_this"><a >系统消息</a></li>
        </ul>

        <!-- E 我的积分模块标题 -->
        <!-- S 我的积分模块内容 -->
        <div class="b_record_buy">
            <div class="b_record_list b_record_cloud" style="display:block;">
                <div class="b_record_info">
                    <!-- 积分类型 -->
                    <div class="b_cloud_goods a_cloud_goods">
                        <b>共收到系统消息</b>
                        <span id="scoreSourceTotalByTime">({{ $allMsg }}条)</span>
                        <b>已读</b>
                        <span id="msgRead" data-yes-read="{{ $readMsg }}">({{ $readMsg }}条)</span>
                        <b>未读</b>
                        <span id="msgNoRead" data-no-read="{{ ($allMsg-$readMsg) }}">({{ ($allMsg-$readMsg) }}条)</span>
                    </div>
                    <!-- 积分来源按时间筛选 -->
                    <div class="b_choose a_choose" style="display: none;">
                        <ul class="b_choose_day b_score_source_time">
                            <li class="" ><a href="">全部</a></li>
                            <li data-val="1" class=""><a href="">今天</a></li>
                            <li data-val="2" class=""><a href="">本周</a></li>
                            <li data-val="3" class=""><a href="">本月</a></li>
                            <li data-val="4" class=""><a href="">最近三个月</a></li>
                        </ul>
                        <dl class="b_choose_cal" style="display: none;">
                            <dd>选择时间段：</dd>
                            <dd><input id="invite_result_startTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\')||\'2020-10-01\'}'})"></dd>
                            <dd>&nbsp;-&nbsp;</dd>
                            <dd><input id="invite_result_endTime" readonly="true" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\')}',maxDate:'2020-10-01'})"></dd>
                            <dd class="b_choose_search" onclick="">搜索</dd>
                        </dl>
                        <div class="a_clear"></div>
                    </div>
                </div>
                <div class="b_record_table a_record_table a_record_table1 a_record_table_width" >
                    <table id="scoreSource">
                        <tbody>
                            <tr class="b_part_title">
                                <th class="b_th1">时间</th>
                                <th class="b_th3">标题</th>
                                <th class="b_th4"></th>
                            </tr>
                            @foreach ($list as $val)
                                @if($val->r_type == 0)
                                <tr class="no_read">
                                    <td >{{ date('Y/m/d H:i:s' ,$val->send_time) }}</td>
                                    <td>{{ $val->title }}</td>
                                    <td><a class="check_look" data-id="{{$val->id}}" data-title="{{ str_limit($val->title,10) }}" data-msg="{{ $val->msg }}" data-time="{{ date('Y/m/d H:i:s' ,$val->send_time) }}" data-read="{{$val->r_type}}">查看</a></td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{ date('Y/m/d H:i:s' ,$val->send_time) }}</td>
                                    <td>{{ $val->title }}</td>
                                    <td><a class="check_look" data-id="{{$val->id}}" data-title="{{ str_limit($val->title,10) }}" data-msg="{{ $val->msg }}" data-time="{{ date('Y/m/d H:i:s' ,$val->send_time) }}" data-read="{{$val->r_type}}">查看</a></td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @if($list->count() == 0)
                    <!--没有消息-->
                    <div class="none-of-message">
                        <img src="{{ $url_prefix }}img/none_of_message.png" />
                    </div>
                @endif
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
        </div>
         <!--弹出窗-->
         <div class="msg-alert">
         	<div class="msg-title"><label>标题：</label><span id="title"></span>&nbsp;&nbsp;&nbsp;<i></i><label>时间：</label><span id="msg_time"></span><span class="close-btn">x</span></div>
         	<div class="msg-content">
         		<label>发送内容：</label>
         		<p id="content"></p>	
         	 </div>
         	<div class="msg-bottom"><input type="button" value="关闭" /></div>
         </div>
    </div>

@endsection


@section('my_js')
    <script type="text/javascript" src="{{ $url_prefix }}js/laydate/laydate.js"></script>
    <script>
        $(".check_look").click(function(){
            //alert($(this).attr('data-title'));
            var obj = $(this);
            var r_type = $(this).attr('data-read');
            var id = $(this).attr('data-id');
            var readNum = parseInt($("#msgRead").attr('data-yes-read'));
            var noReadNum = parseInt($("#msgNoRead").attr('data-no-read'));
            $("#title").html($(this).attr('data-title'));
            $("#msg_time").html($(this).attr('data-time'));
            $("#content").html($(this).attr('data-msg'));
            $(".msg-alert").show();
            if(r_type == 0){
                $.post("{{url('/user/setmessage')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
                   if (data.status == 0){
                       obj.attr('data-read',1);
                       obj.parents('.no_read').removeClass();
                       readNum++;
                       noReadNum--;
                       $("#msgRead").html('('+readNum+'条)');
                       $("#msgNoRead").html('('+noReadNum+'条)');
                       $("#msgRead").attr('data-yes-read',readNum);
                       $("#msgNoRead").attr('data-no-read',noReadNum);
                   }else{
                       layer.msg(data.msg);
                   }
               },'json');
            }
        });
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

        $(".msg-bottom input,.close-btn").click(function(){
        	$(".all_grey_bg").hide();
        	$(".msg-alert").hide();
        });
    </script>
@endsection

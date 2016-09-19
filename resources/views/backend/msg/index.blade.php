@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">系统消息</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/sys/msg">消息列表</a> <span class="divider">/</span></li>
            <li class="active">消息列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div>
        <form name = 'msg' method="post" action="{{url('backend/sys/msg')}}" onsubmit="return check()">
        {!! csrf_field() !!}
        <span>订单状态：</span>
        <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time' value="{{ !empty($start_time) ? date('Y/m/d H:i:s',$start_time):'' }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ !empty($end_time) ? date('Y/m/d H:i:s',$end_time):'' }}"/>
        <span>手机号：</span>
        <input  id='mobile' style="widht:200px" type="text" name='mobile' maxlength="11" value="{{ $mobile or '' }}" />
        <input type="submit" value="查询">
        <input id='unset' type="button" value="重置">
        </form>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>发送时间</th>
          <th>接受账号</th>
          <th>消息类型</th>
          <th style="width: 30%;">标题</th>
          <th style="width: 40%;">内容</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ date('Y/m/d H:i:s',$row->send_time) }}</td>
                <td>
                    @if($row->msg_type == 0)
                        全部用户
                    @else
                        {{$row->mobile}}
                    @endif
                </td>
                <td>
                    <?php
                        switch ($row->msg_type) {
                            case 0:
                                echo '系统消息';
                                break;
                            case 1:
                                echo '中奖消息';
                                break;
                            case 2:
                                echo '购买消息';
                                break;
                            case 3:
                                echo '指定消息';
                                break;
                            default:
                                echo '系统消息';
                                break;
                        }
                    ?>
                </td>
            	<td>{{ $row->title }}</td>
            	<td>{{ $row->msg }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $list->render() !!}
</div>          
</div>
</div>
<script src="{{ asset('backend/lib/finance/finance.js') }}" type="text/javascript"></script>
<script>
	function check()
	{
		var start_time=$('#start_time').val();
		var end_time=$('#end_time').val();
		var mobile=$('#mobile').val();
        var isMobile = /^0?1[3-8][0-9]\d{8}$/; // 手机号码验证规则
		if(start_time!='' && end_time=='')
		{
            layer.msg('请选择结束时间！');
            return false;
		}else if(start_time =='' && end_time!=''){
            layer.msg('请选择开始时间！');
            return false;
        }
        if(mobile != '' && mobile != null){
            if(!isMobile.test(mobile)){
                layer.msg('手机格式不正确！');
                return false;
            }
        }
	}
	$('#unset').click(function()
	{
        location.href='/backend/sys/msg';
	})
 </script>
@endsection
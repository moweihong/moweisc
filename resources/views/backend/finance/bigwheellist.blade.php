@extends('backend.master')

@section('content')

<div class="header">
 <h1 class="page-title">财务报表</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a >财务报表</a> <span class="divider">/</span></li>
            <li class="active">充值列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
    <div class="btn-group">
  
    </div>
</div>
<form method="post" action="/backend/finance/bigWheelInfoSearch" onsubmit="return check()">
抽奖时间：<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('bigwheel.starttime') }}" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('bigwheel.endtime') }}" />

注册时间：<input class="datetimepicker7" id='regstarttime' style="widht:60px" type="text" name='regstarttime'  value="{{ session('bigwheel.regstarttime') }}" />-
<input class="datetimepicker7" id='regendtime' type="text" name='regendtime' value="{{ session('bigwheel.regendtime') }}" />

<input type="text" name="phone" placeholder="输入手机号" value="{{ session('bigwheel.phone') }}">
<select name='prize_type'>
	<option value="0">奖品内容</option>
	@foreach($prizetype as $v)
	<option <?php if(session('bigwheel.prizetype')==$v->id){ ?> selected="selected" <?php }?> value="{{ $v->id}}">{{ $v->name}}</option>
	@endforeach
	
</select>
<input type="submit" id="submitbtn" value="搜索">
<a href="/backend/finance/exportBigWheel?{{ $url }}"><input type="button"  value="导表"></a>
<input type="hidden" value="{{ csrf_token() }}" name="_token" />
</form>

<div class="well">
	
    <table class="table">
      <thead>
        <tr>
          <th style="width: 15%">手机号码</th>
          <th style="width: 15%">用户名</th>
          <th style="width: 15%">红包金额</th>
          <th style="width: 15%;">抽奖时间</th>
          <th style="width: 15%; ">注册时间</th>
          <th style="width: 15%;">损耗</th>
          <!--<th style="width: 15%;">剩余抽奖次数</th>-->
        </tr>
      </thead>
      <tbody>
      	<?php $count=0;?>
      	@foreach ($list as $row)
            <tr>
            	<?php $count=$count+$row->money;?>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->nickname }}</td>
            	<td>{{ $row->money }}</td>
            	<td>{{ date('Y-m-d H:i:s',$row->time) }}</td>
            	<td style="color: burlywood;">
            		@if($row->reg_time)
            		{{ date('Y-m-d H:i:s',$row->reg_time) }}
            		@endif
            	</td> 
            	<td>
            		@if($row->is_free==1)
            		奖励次数
            		@else
            		消费10块乐豆
            		@endif
            	</td> 
            	
            	<!--<td>{{ ceil($row->invite_last/3) }}</td> -->         	
            </tr>
        @endforeach
      </tbody>
    </table>
     <h3>本页红包总额：{{ $count }}元</h3>
     <h3>总共红包金额：{{ $summoney }}元</h3>
     <h3>总共参加人数：{{ $membernum }}个</h3>
     <h3>总共抽奖次数：{{ $canjiacishu }}次</h3>
      
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	@if(is_callable(array($list,'render')))
    {!! $list->render() !!}
    @else
     {!! $page !!}
    @endif
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal">Delete</button>
    </div>
</div>              
</div>
</div>
<script src="{{ asset('backend/lib/finance/finance.js') }}" type="text/javascript"></script>

@endsection
@extends('backend.master')

@section('content')

<div class="header">
 <h1 class="page-title">商品管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop">商品</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
  <div class="btn-group">
  </div>
</div>
<form method="post" action="/backend/finance/search" onsubmit="return check()">
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time' value="{{ session('buy.starttime') }}" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('buy.endtime') }}"/>
手机号：<input type="text" name="phonenum" value="{{ session('buy.phonenum') }}">
商品id：<input type="text" name="shopname" value="{{ session('buy.shopname') }}">
商品期数：<input type="text" name="qishu" value="{{ session('buy.qishu') }}">
<input type="submit" id="submitbtn" value="搜索">
<a href="/backend/finance/export?{{ $url }}"><input type="button" value="导出excel表"></a>
<input type="hidden" value="buy" name="type" />
<input type="hidden" value="{{ csrf_token() }}" name="_token" />
</form>
<div class="well">
	
    <table class="table">
      <thead>
        <tr>
          <th style="width: 10%">订单号</th>
          <th style="width: 15%">手机号码</th>
          <th style="width: 15%">用户名</th>
          <th style="width: 15%">消费金额</th>
          <th style="width: 15%">商品名称</th>
          <th style="width: 15%">商品期数</th>
          <th style="width: 15%;">时间</th>
        </tr>
      </thead>
      <tbody>
      	<?php $count=0;?>
      	@foreach ($chagelist as $row)
            <tr>
            	<?php $count=$count+$row->buycount;?>
            	<td>{{ $row->code }}</td>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->nickname }}</td>
            	<td>{{ $row->buycount }}</td>
            	<td>{{ $row->g_name }}</td>
            	<td>{{ $row->g_periods }}</td>
            	<td>{{ date('Y-m-d H:i:s',floor($row->bid_time/1000)) }}</td>	
            </tr>
        @endforeach
      </tbody>
     
    </table>
     <h3>本页消费总额：{{ $count }}元</h3>
     <h3>总共消费金额：{{ $allmoney }}元</h3>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    @if(is_callable(array($chagelist,'render')))
    {!! $chagelist->render() !!}
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
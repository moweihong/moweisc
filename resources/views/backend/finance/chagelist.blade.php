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
<form method="post" action="/backend/finance/search" onsubmit="return check()">
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="{{ session('chage.starttime') }}" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('chage.endtime') }}" />
充值类型：<select class="selectpay" name='pay_type'>
	<option value="false">请选择</option>
	<option value="weixin" <?php if(session('chage.paytype')=='weixin'){?> selected="selected"<?php }?> >微信公众号</option>
	<option value="unionpay" <?php if(session('chage.paytype')=='unionpay'){?> selected="selected"<?php }?>>银联</option>
	<option value="weixin_app" <?php if(session('chage.paytype')=='weixin_app'){?> selected="selected"<?php }?>>微信app</option>
	<option value="jdpay" <?php if(session('chage.paytype')=='jdpay'){?> selected="selected"<?php }?>>京东支付</option>
</select>
手机号：<input type="text" name="phonenum" value="{{ session('chage.phonenum') }}">
<input type="submit" id="submitbtn" value="搜索">
<input type="hidden" value="chage" name="type" />
<input type="hidden" value="{{ csrf_token() }}" name="_token" />
<a href="/backend/finance/export?{{ $url }}"><input type="button" value="导出excel表"></a>
</form>

<div class="well">
	
    <table class="table">
      <thead>
        <tr>
          <th style="width: 10%">订单号</th>
          <th style="width: 15%">手机号码</th>
          <th style="width: 15%">用户名</th>
          <th style="width: 15%">充值金额</th>
          <th style="width: 15%;">时间</th>
          <th style="width: 15%;">充值来源</th>
        </tr>
      </thead>
      <tbody>
      	<?php $count=0;?>
      	@foreach ($chagelist as $row)
            <tr>
            	<?php $count=$count+$row->money;?>
            	<td>{{ $row->code }}</td>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->nickname }}</td>
            	<td>{{ $row->money }}</td>
            	<td>{{ date('Y-m-d H:i:s',$row->pay_time) }}</td>
            	<td>
            		@if($row->pay_type=='weixin')
            		 微信充值
            		@elseif($row->pay_type=='unionpay')
            		银联充值
            		@elseif($row->pay_type=='weixin_app')
            		微信app
            		@elseif($row->pay_type=='jdpay')
            		京东支付
            		@endif
            	</td>	
            </tr>
        @endforeach
      </tbody>
     
    </table>
     <h3>本页充值总额：{{ $count }}元</h3>
     <h3>总共充值金额：{{ $allmoney }}元</h3>
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
@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">话费充值</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">话费充值</a> <span class="divider">/</span></li>
            <li class="active">充值列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>订单序号</th>
          <th>商品名称</th>
          <th>用户名</th>
          <th>充值号码</th>
          <th>金额</th>
          <th>状态</th>
          <th>充值时间</th>
          <th>信息</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->trade_id }}</td>
            	<td>(第{{$row->order->g_periods}}期){{ $row->order->g_name }}</td>
            	<td>{{ $row->user->nickname }}</td>
            	<td>{{ $row->mobile }}</td>
            	<td>{{ $row->money }}</td>
                <td>
                    @if($row->r_type == 1)
                      充值成功
                    @elseif($row->r_type == 2)
                      充值失败
                    @endif
                </td>
            	<td>{{ date('Y-m-d H:i:s',$row->create_time) }}</td>       	
            	<td>{{ $row->log_msg }}</td>
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
@endsection
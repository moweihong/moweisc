@extends('backend.master')

@section('content')
<div class="header">
            
            <h1 class="page-title">佣金提现</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">佣金提现</a> <span class="divider">/</span></li>
            <li class="active">提现列表</li>
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
          <th>用户名</th>
          <th>电话</th>
          <th>用户余额</th>
          <th>佣金</th>
          <th>开户行</th>
          <th>支行</th>
          <th>银行卡号</th>
          <th>提现金额</th>
          <th>申请时间</th>
          <th>状态</th>
          <th style="width: 150px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($list as $row)
            <tr>
            	<td>{{ $row->username }}</td>
            	<td>{{ $row->user->mobile }}</td>
            	<td>{{ $row->user->money }}</td>       	
            	<td>{{ $row->user->commission }}</td>       	
            	<td>{{ $row->bankname }}</td>       	
            	<td>{{ $row->subbranch }}</td>       	
            	<td>{{ $row->banknum }}</td>       	
            	<td>{{ $row->money }}</td>       	
            	<td>{{ date('Y-m-d H:i:s',$row->time) }}</td>       	
            	<td>
                    @if($row->cashtype==0)
                       申请提现
                    @elseif($row->cashtype==1)
                       已打款
                    @elseif($row->cashtype==2)
                       拒绝
                    @endif
                </td>
            	<td>
                    @if($row->cashtype == 0)
                    <input type="button" onclick="checkPass({{$row->id}})"  value="打款">
                    <input type="button" onclick="checkRefuse({{$row->id}})"  value="拒绝" style="display: none;">
                    @endif
            	</td>
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
<script type="text/javascript">
    layer.msg('sfjlksdlkf');
function checkPass(id){
    $.post("{{url('/backend/bank/checkpass')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
        if(data==null){
            alert('服务端错误');
        }
        if (data.status == 1){
           layer.msg(data.msg)
           location.reload();
        }
        if (data.status == 0){
           layer.msg(data.msg)
           location.reload();
        }
    },'json');
}

function checkRefuse(id){
    $.post("{{url('/backend/bank/checkrefuse')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
        if(data==null){
            alert('服务端错误');
        }
        if (data.status == 1){
           layer.msg(data.msg)
           location.reload();
        }
        if (data.status == 0){
           layer.msg(data.msg)
           location.reload();
        }
    },'json');
}

</script>
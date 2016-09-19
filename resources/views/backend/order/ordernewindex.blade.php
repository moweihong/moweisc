@extends('backend.master')

@section('content')

</script>
<div class="header">
            
            <h1 class="page-title">订单管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">订单管理</a> <span class="divider">/</span></li>
            <li class="active">订单列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div>
        <form name = 'orderform' method="post" action="/backend/order/ordernew">
        {!! csrf_field() !!}
        <textarea name="phones" style="margin: 0px; width: 1088px; height: 174px;">{{session('ordernew.phones')}}</textarea>
       	<p style="color: red;">多个手机号用英文的逗号","隔开</p>
        <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time' value="{{ session('ordernew.starttime') }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('ordernew.endtime') }}"/>
        <input type="submit" value="确认">
        <input id='unset' type="button" value="清空搜索条件">
         <a href="/backend/order/daoBiaonew?{{$url }}"><input type="button" value="导表"></a>
        </form>
    </div>

    <table class="table" style="table-layout: fixed;">
      <thead>
        <tr>
          <th width="6%">订单号</th>
          <th width="8%">下单时间</th>
          <th width="18%">商品名称</th>
       	  <th width="8%">商品价格</th>
       	  <th width="5%">期数</th>
       	  <th width="8%">购买总数</th>
       	  <th width="5%">结果</th>
          <th width="8%">订单状态</th>
          <th width="6%">昵称</th>
          <th width="6%">总金额</th>
          <th width="6%">块乐豆抵扣</th>
          <th width="5%">红包抵扣</th>
          <!--<th width="5%">余额抵扣</th>-->
          <th width="5%">实际支付</th>
          <th>账号异常</th>
        </tr>
      </thead>
      @if(count($orderlist))
      <tbody>  
          
      	  <?php foreach($orderlist as $row){ ?>
      	  	   
      	       <?php $i=0;foreach($row->dindan as $v){?>
      	  	   <tr>
      	  	   	<td>{{ $v->code }}</td>
      	  	   	<td>{{date('Y-m-d H:i:s',$v->bid_time/1000)}}</td>
      	  	   	<td>{{ $v->g_name }}</td>
      	  	   	<td>{{ $v->goods->money }}</td>
      	  	   	<td>{{ $v->g_periods }}</td>
      	  	   	<td>{{ $v->buycount }}</td>
      	  	   	<td>
      	  	   		@if($v->object->is_lottery==2)
	      	  	   		@if($v->fetchno>0)
	      	  	   		中奖
	      	  	   		@else
	      	  	   		没中
	      	  	   		@endif
	      	  	   	@else
	      	  	   	  未开奖
	      	  	   	@endif
      	  	   	</td>
      	  	   	<td>
      	  	   		<?php
                    if($v->fetchno == 0){
                        //邀友获奖订单显示
                        if($v->pay_type == 'invite'){
                            switch ($v->status) {
                                case 0:
                                    echo '未支付';
                                    break;
                                case 1:
                                    echo '正在支付'; 
                                    break;
                                case 2:
                                    echo '支付完成'; 
                                    break;
                                case 3: 
                                    echo '待发货'; 
                                    break;
                                case 4: 
                                    echo '已发货';
                                    break;
                                case 5: 
                                    echo '已完成待晒单';
                                    break;
                                case 6: 
                                    echo '已晒单';
                                    break;
                                default:
                                    echo '未支付';
                                    break;
                            }
                        }else {
                           echo '支付完成';
                        }
                    }else if($v->fetchno > 0){
                        switch ($v->status) {
                            case 0:
                                echo '未支付';
                                break;
                            case 1:
                                echo '正在支付'; 
                                break;
                            case 2:
                                echo '支付完成'; 
                                break;
                            case 3: 
                                echo '待发货'; 
                                break;
                            case 4: 
                                echo '已发货';
                                break;
                            case 5: 
                                echo '已完成待晒单';
                                break;
                            case 6: 
                                echo '已晒单';
                                break;
                            default:
                                echo '未支付';
                                break;
                        }
                    }
                    ?>
      	  	   	</td>
      	  	   	<td> {{ $v->user->nickname}} </td>
      	  	   
      	  	   	@if($i==0)
      	  	   	<td>{{$row->amount}}</td>
      	  	   	<td>{{$row->kld }}</td>
      	  	   	<td>{{$row->redbao }}</td>
      	  	   	<td>{{$row->amount-$row->redbao-($row->kld/100) }}</td>
      	  	   	@else
      	  	   	<td>0</td>
      	  	   	<td>0</td>
      	  	   	<td>0</td>
      	  	   	<td>0</td>
      	  	   	@endif
      	  	   	
      	  	   	<td>
      	  	   		@if($v->user->is_unusual==0)
      	  	   		正常
      	  	   		@else
      	  	   		封号
      	  	   		@endif
      	  	   	</td>
      	  	   </tr>
      	  	   <?php $i++;}?>
      	  <?php } ?>
      </tbody>
      @else
      <tbody>
          <tr><td></td><td></td><td></td><td style="color: red;">没有订单！</td><td></td><td></td><td></td></tr>
      </tbody>
      @endif
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
   @if(is_object($orderlist) && count($orderlist))
    {!! $orderlist->render() !!}
    @endif
</div>  
</div>
</div>
<script src="{{ asset('backend/lib/finance/finance.js') }}" type="text/javascript"></script>
<script>
	$(".sendGood").click(function(){
	var id=$(this).data('id');
	$(this).parent().parent().after("<tr><td>快递名称:</td><td><input type='text'></td><td>快递单号:</td><td><input type='text'></td><td><input type='button' value='提交' onclick='queren(this)' data-id="+id+"></td><td><input onclick='quxiao(this)' type='button' value='取消'></td></tr>");
	//alert($(this).data('id'));
});
	$('#unset').click(function()
	{
		$.post('/backend/order/unsetSearchOrdernew',{'_token':"{{csrf_token()}}"},
		        function(data){  
                  location.href='/backend/order/ordernew';
		}) 
	})
	
	function quxiao(obj)
	{
		$(obj).parent().parent().hide();
	}
	
	function queren(obj)
	{
		var id=$(obj).data('id');
		var delivery=$(obj).parent().parent().children().eq(1).children().val();
		var delivery_code=$(obj).parent().prev().children().val();
		if(delivery=='')
		{
			layer.msg('快递公司不可以为空');
			return false;
		}
		if(delivery_code=='')
		{
			layer.msg('订单号不可以为空');
			return false;
		}
		$.post('/backend/order/sendGood',{'id':id,'delivery':delivery,'delivery_code':delivery_code,'_token':"{{csrf_token()}}"},
		        function(data){
		          data=eval( '('+data+')');
		          layer.msg(data.msg);    
                  location.reload();
		})
		
	}
	
</script>
@endsection

<script type="text/javascript">
function cheackOrder(id,flag){
    var action ='ok';
    if(flag == 0){        
        if(!confirm('是否确认要删除此订单！')){
            return false;
        }
        action ='del';
    }
    $.post("{{url('/backend/order/cheackorder')}}",{'id':id,'action':action,'_token':"{{csrf_token()}}"},function(data){
        if(data==null){
            layer.msg('服务端错误');
        }        
        if (data.status==1){
            layer.msg(data.msg);    
            location.reload();
        }
    },'json');  
}



</script>

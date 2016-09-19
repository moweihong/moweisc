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
        <form name = 'orderform' method="post" action="{{url('backend/order')}}" onsubmit="return check()">
        {!! csrf_field() !!}
        <span>订单号：<input value="" placeholder="输入订单号..." name="orderid" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span>账号：<input value="<?php echo session('order.phone'); ?>" placeholder="输入手机号..." name="phone" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span>供应商：
        	<select  name="supplier">           
                   <option value="0">≡ 请选商户名≡</option>
                   <?php foreach($supplierList as $vv){?> 
                   	<option <?php echo (session('order.supplier')==$vv['merchants']) ? 'selected':'';?> value="<?php echo $vv['merchants'];?>"><?php echo $vv['merchants'];?></option>  
               		<?php }?>
               </select>
        <span>是否中奖：</span>
        <select name="zhongjiang" id="zhongjiang">
            <option value="-1" >请选择...</option>
            <option value="0" <?php echo (session('order.zhongjiang')=='0') ? 'selected':'';?>>中奖</option>
            <option value="1" <?php echo (session('order.zhongjiang')==1) ? 'selected':'';?>>不中奖</option> 
        </select>
        <span>订单状态：</span>
        <select name="status" id="status">
            <option value="-1" >请选择...</option>
            <option value="2" <?php echo !empty(session('order.status'))&&(session('order.status')==2) ? 'selected':'';?>>待确认</option>
            <option value="7" <?php echo !empty(session('order.status'))&&(session('order.status')==7) ? 'selected':'';?>>待付款</option>
            <option value="3" <?php echo !empty(session('order.status'))&&(session('order.status')==3) ? 'selected':'';?>>待发货</option>
            <option value="1" <?php echo !empty(session('order.status'))&&(session('order.status')==1) ? 'selected':'';?>>付款中</option>
            <option value="4" <?php echo !empty(session('order.status'))&&(session('order.status')==4) ? 'selected':'';?>>已发货</option>
            <option value="5" <?php echo !empty(session('order.status'))&&(session('order.status')==5) ? 'selected':'';?>>已完成</option>
            <option value="6" <?php echo !empty(session('order.status'))&&(session('order.status')==6) ? 'selected':'';?>>已晒单</option>
        </select>
        <span>商品类型：</span>
        <select name="is_virtual" id="is_virtual">
            <option value="-1" >请选择...</option>
            <option value="0" <?php echo (session('order.virtual')=='0') ? 'selected':'';?>>实物</option>
            <option value="1" <?php echo (session('order.virtual')==1) ? 'selected':'';?>>虚拟</option>
            
        </select>
                         时间类型：
         <select name="timetype" id="timetype">
            <option value="-1" >请选择...</option>
            <option value="0" <?php echo (session('order.timetype')=='0') ? 'selected':'';?>>下单时间</option>
            <option value="1" <?php echo (session('order.timetype')==1) ? 'selected':'';?>>发货时间</option>
            <option value="2" <?php echo (session('order.timetype')==2) ? 'selected':'';?>>确址时间</option>   
        </select>
        <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time' value="{{ session('order.starttime') }}" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="{{ session('order.endtime') }}"/>
        <input type="submit" value="确认">
        <input id='unset' type="button" value="重置">
        <a href="/backend/order/daoBiao?{{$url }}"><input type="button" value="导表"></a>
        <input type="button" id="pldaying" value="批量打印">
        <input type="button" id="plziti" value="批量自提">
         <input onclick="quanxuan()" id='allselect' value="0" type="radio"><span>全选</span>
        </form>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th width="20%">订单号/时间</th>
          <th width="20%">商品信息</th>
          <th width="12%">下单信息</th>
          <th width="8%">支付金额</th>
          <th width="8%">是否中奖</th>
          <th width="8%">订单状态</th>
          <th width="8%">用户异常</th>
          <th>操作</th>
        </tr>
      </thead>
      @if(is_object($list) && count($list))
      <tbody>          
      	@foreach ($list as $row)
            <tr>
            	<td rowspan="5">
            		<span>订单号：{{ $row->code }}</span><br />
            		<span>下单：{{ date('Y-m-d H:i:s',$row->bid_time/1000) }}</span><br />
            		<span>开奖：@if($row->fetchno > 0){{ date('Y-m-d H:i:s',$row->kaijiang_time/1000) }}@endif</span><br />
            		<span>确址：@if($row->affirm_time > 0){{ date('Y-m-d H:i:s',$row->affirm_time) }}@endif</span><br />
            		<span>发货：@if($row->shiptime > 0){{ date('Y-m-d H:i:s',$row->shiptime) }}@endif</span><br />
            	</td>
            	
            	
            	<td rowspan="5">
            		<span>商品名称：{{ $row->g_name }}</span><br />
            		<span>供应商：{{ $row->supplier }}</span><br />
            		<span>商品价格：{{ $row->money }}</span>
            		<span>期数：{{ $row->g_periods }}</span>
            		<span>类型：@if($row->is_virtual==0)实物 @else虚拟@endif</span>
            	</td>
            	
            	
            	<td rowspan="5">
            		<span>下单人：{{ $row->user->mobile }}</span><br />
            		<span>购买人次：{{ $row->buycount }}</span><br />
            	</td>
            	
            	<td>{{ $row->buycount }}</td>
            	<td>
                    @if($row->fetchno == 0)
                        @if($row->pay_type == 'invite')
                            邀友获奖产品
                        @else
                            否
                        @endif
                    @elseif($row->fetchno > 0)
                        中奖号是：{{$row->fetchno}}
                    @endif
             </td>
            	<td>
                    <?php
                    if($row->fetchno == 0){
                        //邀友获奖订单显示
                        if($row->pay_type == 'invite'){
                            switch ($row->status) {
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
                    }else if($row->fetchno > 0){
                        switch ($row->status) {
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
                <td>{{ $row->sign }}<input name="dayin" type="checkbox" value="{{$row->id}}" ></td>
            	<td>

                    @if($row->fetchno > 0)
                        @if($row->status == 3)
                        <input type="button" class="sendGood" data-id='{{$row->id}}' value="发货">
					    <input type="button" class="ziti" data-id='{{$row->id}}' value="自提">
                        @endif
                    @elseif($row->pay_type=='invite')
                        @if($row->status == 3)
                        <input type="button" class="sendGood" data-id='{{$row->id}}' value="发货">
                        @endif
                    @endif
                    <!--<input type="button" onclick="cheackOrder({{$row->id}},0)" value="删除">-->
                    <a href="{{url('backend/order/orderlook',['id'=>$row->id])}}" target="_blank"><button>查看</button></a>
            		<a href="{{url('backend/order/orderdayin',['id'=>$row->id])}}"><button>打印</button></a>
            	</td>
            </tr>
            <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
        @endforeach
      
      </tbody>
      
      @else
      <tbody>
          <tr><td></td><td></td><td></td><td style="color: red;">没有订单！</td><td></td><td></td><td></td></tr>
      </tbody>
      @endif
      
   
    </table>
</div>
<div>
	   合计条数：{{ $num }}合计金额：{{$summoney}}
<div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	  
   @if(is_object($list) && count($list))
    {!! $list->render() !!}
    @endif
</div>  
</div>
</div>
<script src="{{ asset('backend/lib/finance/finance.js') }}" type="text/javascript"></script>
<script>
	$('#pldaying').click(function(){
	 		var id=new Array();
	 		var i=0;
            $('input[name="dayin"]:checked').each(function(){
            	
                 id[i]=$(this).val();
                 i++;
                });
                
            $.post('/backend/order/setDayinId',{'_token':"{{csrf_token()}}",'id':id},
		        function(data){  
                  location.href='/backend/order/orderdayinpl';
		}) 
                
              
    });
    
     function selectAll(){
	var a = document.getElementsByTagName("input");
	if(a[0].checked){
		for(var i = 0;i<a.length;i++){
		if(a[i].type == "checkbox") a[i].checked = false;
		}
	}
	else{
		for(var i = 0;i<a.length;i++){
		if(a[i].type == "checkbox") a[i].checked = true;
		}
	}
  }
  
  function uncheckAll() {   
  var code_Values = document.getElementsByTagName("input");  
  for (i = 0; i < code_Values.length; i++) {  
  if (code_Values[i].type == "checkbox") {  
    code_Values[i].checked = false;  
  }  
  }  
}  
  
  function quanxuan(){
  	
  		var radioCheck= $('#allselect').val(); 
  
        if("1"==radioCheck){  
            $('#allselect').attr("checked",false);  
            $('#allselect').val("0"); 
            uncheckAll() 
              
        }else{   
            $('#allselect').val("1");  
            selectAll();
              
        }  
  		
  		
  		
  }

	function check()
	{
		var timetype=$('#timetype').find("option:selected").val();
		var start_time=$('#start_time').val();
		var end_time=$('#end_time').val();
		if(start_time!='' || end_time!='')
		{
			if(timetype==-1)
			{
				alert('请选择时间类型');
				return false;
			}
		}
		
		
	}

	$(".sendGood").click(function(){
	var id=$(this).data('id');
	$(this).parent().parent().after("<tr><td>快递名称:</td><td><input type='text'></td><td>快递单号:</td><td><input type='text'></td><td><input type='button' value='提交' onclick='queren(this)' data-id="+id+"></td><td><input onclick='quxiao(this)' type='button' value='取消'></td></tr>");
	//alert($(this).data('id'));
});
	$('#unset').click(function()
	{
		$.post('/backend/order/unsetSearch',{'_token':"{{csrf_token()}}"},
		        function(data){  
                  location.href='/backend/order';
		}) 
	})
	

	$(".ziti").click(function(){
		var id=$(this).data('id');
		
		layer.confirm('您是否确定自提此订单？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('/backend/order/takeorder')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
				if(data==null){
					layer.msg('服务端错误');
				}        
				if (data.status==1){
					layer.msg(data.msg);
					location.reload();
				}else{
					layer.msg(data.msg);
				}
			},'json');
		}, function(){
		  layer.msg('您取消了！');
		});
		
	});
	
	
	$("#plziti").click(function(){
		var id=new Array();
 		var i=0;
        $('input[name="dayin"]:checked').each(function(){
        	
             id[i]=$(this).val();
             i++;
            });
		
		layer.confirm('您是否确定自提这些订单，请认真对清楚？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('/backend/order/takeorderpl')}}",{'id':id,'_token':"{{csrf_token()}}"},function(data){
				if(data==null){
					layer.msg('服务端错误');
				}        
				if (data.status==1){
					layer.msg(data.msg);
					location.reload();
				}else{
					layer.msg(data.msg);
				}
			},'json');
		}, function(){
		  layer.msg('您取消了！');
		});
		
	});
	
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

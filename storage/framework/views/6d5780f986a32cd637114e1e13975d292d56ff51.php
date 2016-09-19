<?php $__env->startSection('content'); ?>

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
        <form name = 'orderform' method="post" action="<?php echo e(url('backend/order/getprize')); ?>">
        <?php echo csrf_field(); ?>

        <span>订单号：<input value="" placeholder="输入订单号..." name="orderid" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
        <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time' value="<?php echo e(session('order.starttime')); ?>" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="<?php echo e(session('order.endtime')); ?>"/>
        <input type="submit" value="确认">
        <input id='unset' type="button" value="重置">
        <a href="/backend/order/daoBiao?<?php echo e($url); ?>"><input type="button" value="导表"></a>
        </form>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th width="10%">订单号</th>
          <th width="10%">下单时间</th>
          <th width="15%">商品名称</th>
       	  <th width="15%">商品类型</th>
          <th width="10%">订单状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <?php if(is_object($list) && count($list)): ?>
      <tbody>          
      	<?php foreach($list as $row): ?>
            <tr>
            	<td><?php echo e($row->code); ?></td>
            	<td><?php echo e(date('Y-m-d H:i:s',$row->bid_time/1000)); ?></td>
            	<td><?php echo e($row->g_name); ?></td>
            	<td>
                    
                        <?php if($row->pay_type == 'invite'): ?>
                            邀友获奖产品
                        <?php else: ?>
                            否
                        <?php endif; ?>
            
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
            	<td>

                    <?php if($row->fetchno > 0): ?>
                        <?php if($row->status == 3): ?>
                        <input type="button" class="sendGood" data-id='<?php echo e($row->id); ?>' value="发货">
                        <?php endif; ?>
                    <?php elseif($row->pay_type=='invite'): ?>
                        <?php if($row->status == 3): ?>
                        <input type="button" class="sendGood" data-id='<?php echo e($row->id); ?>' value="发货">
                        <?php endif; ?>
                    <?php endif; ?>
                    <!--<input type="button" onclick="cheackOrder(<?php echo e($row->id); ?>,0)" value="删除">-->
                    <a href="<?php echo e(url('backend/order/orderlook',['id'=>$row->id])); ?>" target="_blank"><button>查看</button></a>
            	</td>
            	<td>
            		<a href="<?php echo e(url('backend/order/orderdayinp',['id'=>$row->id])); ?>"><button>打印</button></a>
            	</td>
            </tr>
        <?php endforeach; ?>
      </tbody>
      <?php else: ?>
      <tbody>
          <tr><td></td><td></td><td></td><td style="color: red;">没有订单！</td><td></td><td></td><td></td></tr>
      </tbody>
      <?php endif; ?>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
   <?php if(is_object($list) && count($list)): ?>
    <?php echo $list->render(); ?>

    <?php endif; ?>
</div>  
</div>
</div>
<script src="<?php echo e(asset('backend/lib/finance/finance.js')); ?>" type="text/javascript"></script>
<script>
	$(".sendGood").click(function(){
	var id=$(this).data('id');
	$(this).parent().parent().after("<tr><td>快递名称:</td><td><input type='text'></td><td>快递单号:</td><td><input type='text'></td><td><input type='button' value='提交' onclick='queren(this)' data-id="+id+"></td><td><input onclick='quxiao(this)' type='button' value='取消'></td></tr>");
	//alert($(this).data('id'));
});
	$('#unset').click(function()
	{
		$.post('/backend/order/unsetSearch',{'_token':"<?php echo e(csrf_token()); ?>"},
		        function(data){  
                  location.href='/backend/order/getprize';
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
		$.post('/backend/order/sendGood',{'id':id,'delivery':delivery,'delivery_code':delivery_code,'_token':"<?php echo e(csrf_token()); ?>"},
		        function(data){
		          data=eval( '('+data+')');
		          layer.msg(data.msg);    
                  location.reload();
		})
		
	}
	
</script>
<?php $__env->stopSection(); ?>

<script type="text/javascript">
function cheackOrder(id,flag){
    var action ='ok';
    if(flag == 0){        
        if(!confirm('是否确认要删除此订单！')){
            return false;
        }
        action ='del';
    }
    $.post("<?php echo e(url('/backend/order/cheackorder')); ?>",{'id':id,'action':action,'_token':"<?php echo e(csrf_token()); ?>"},function(data){
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

<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('my_css'); ?>
    <style>
        .b-table{width:80%;border-collapse:collapse;}
        .b-table td{border:1px solid #e3e3e3; padding: 12px;}
        .order-xd-td{height:30px; line-height: 30px; display: block; color:#b20023; font-weight: bold}
        .color-ff0737{color:#ff0737; font-weight: bold}
        .color-f3bd00{color:#2593e7; font-weight: bold}
        .order-div-h{height:40px; line-height: 40px; border-bottom:1px solid #e3e3e3; overflow: hidden; zoom:1;}
        .order-div-h:last-child{border-bottom: none}
        .order-div-h .order-h-tit{width:20%; float: left; display: block; border-right: 1px solid #e3e3e3; padding-left:10px;}
        .order-div-h .order-h-text{width:59%; float: left; display: block; padding-left:10px;}
        .order-div-h .order-buy-times{color:#55ac00; font-weight: bold}
        .order-div-h .order-buy-money{color:#ff0737; font-weight: bold; font-size: 18px;}
        .order-div-h .order-buy-ydh{color:#3e000c; font-weight: bold}
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="header">
            
            <h1 class="page-title">订单管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">订单管理</a> <span class="divider">/</span></li>
            <li class="active">订单详情</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="">
    <div>
        <?php if($order->pay_type == 'invite'): ?>
            <div>
                <span>商品类型：</span><span class="require-field" style="color: red;">邀友获得的商品</span>

            </div><br>
            <div>
                <span>商品名称：</span><span class="require-field"><?php echo e($order->g_name); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div><br>
            <div>
                <span>商品图片：</span>
                <div>
                    <img src="<?php echo e($order->inviteGoods->img); ?>" style="width: 200px;height: 300px;"> </img>
                </div>
            </div><br>
        <?php else: ?>
        	<table class="b-table" border="0" cellpadding="0">
        		<tr>
        			<td width="10%">订单号</td>
                    <td width="30%"><?php echo e($order->code); ?></td>
                    <td width="30%">
                    订单状态:<?php
                    if($order->fetchno == NULL){
                        echo '支付完成';
                    }else if($order->fetchno != NULL){
                        switch ($order->status) {
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
                ?></td>	
        		</tr>
        		<tr>
                    <td bgcolor="#f7f7f7">时间</td>
                    <td bgcolor="#f7f7f7"><span class="order-xd-td">下单：<?php echo e(date('Y-m-d H:i:s',$order->bid_time/1000)); ?></span>
                        <span class="order-xd-td">开奖：
                        	<?php if($order->kaijiang_time): ?>
                        	<?php echo e(date('Y-m-d H:i:s',$order->kaijiang_time/1000)); ?>

                        	<?php endif; ?>
                        </span>
                        <span class="order-xd-td">确址：
                        	<?php if($order->affirm_time): ?>
                        	<?php echo e(date('Y-m-d H:i:s',$order->affirm_time)); ?>

                        	<?php endif; ?>
                        </span>
                        <span class="order-xd-td">发货：
                        	<?php if($order->shiptime): ?>
                        	<?php echo e(date('Y-m-d H:i:s',$order->shiptime)); ?>

                        	<?php endif; ?>
                        </span>
                    </td>
                    <td bgcolor="#f7f7f7">开奖结果：<span class="color-ff0737"><?php echo $order->fetchno ? '中奖号：'.$order->fetchno:'无';?></span> </td>
                </tr>
                <tr>
                    <td>商品信息</td>
                    <td colspan="2" style="padding: 0px">
                        <div class="order-div-h"><span class="order-h-tit">商品标题</span> <span class="order-h-text"><?php echo e($order->g_name); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">供应商</span> <span class="order-h-text color-f3bd00"><?php echo e($order->goods->supplier); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">价格</span> <span class="order-h-text color-ff0737" style="font-family: microsoft yahei">￥<?php echo e($order->goods->money); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">期数</span> <span class="order-h-text"><?php echo e($order->g_periods); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">类型</span> <span class="order-h-text"><?php if($order->goods->is_virtua==0): ?>实物<?php else: ?>虚拟<?php endif; ?></span></div>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#f7f7f7">下单信息</td>
                    <td colspan="2" style="padding: 0px" bgcolor="#f7f7f7">
                        <div class="order-div-h"><span class="order-h-tit">下单人</span> <span class="order-h-text"><?php echo e($order->user->mobile); ?> </span></div>
                        <div class="order-div-h"><span class="order-h-tit">购买次数</span> <span class="order-h-text order-buy-times"> <?php echo e($order->buycount); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">总金额</span> <span class="order-h-text order-buy-money" style="font-family: microsoft yahei">￥<?php echo e($order->buycount*$order->object->minimum); ?></span></div>
                    </td>
                </tr>
                <?php if($order->addressjson && $order->fetchno!=NULL): ?>

                <tr>
                    <td>发货信息</td>
                    <td colspan="2" style="padding: 0px">
                        <div class="order-div-h"><span class="order-h-tit">收货人</span> <span class="order-h-text"><?php echo $order->addressjson->receiver;?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">收货人电话 </span> <span class="order-h-text"><?php echo $order->addressjson->mobile;?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">收货地址</span> <span class="order-h-text"><?php echo $order->addressjson->province.$order->addressjson->city.$order->addressjson->country.$order->addressjson->area;?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">备注</span> <span class="order-h-text"><?php echo e($order->addressjson->notice); ?></span></div>
                    </td>
                </tr>

        		<?php endif; ?>
                <tr>
                    <td bgcolor="#f7f7f7">物流信息</td>
                    <td colspan="2"  style="padding: 0px" bgcolor="#f7f7f7">
                        <div class="order-div-h"><span class="order-h-tit">物流公司 </span> <span class="order-h-text"><?php echo e($order->delivery); ?></span></div>
                        <div class="order-div-h"><span class="order-h-tit">运单号 </span> <span class="order-h-text order-buy-ydh"><?php echo e($order->delivery_code); ?></span></div>
                    </td>
                </tr>

        	</table>


        <?php endif; ?>

</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<script type="text/javascript">
function cheackOrder(id){
    var action ='ok';
    $.post("<?php echo e(url('/backend/order/cheackorder')); ?>",{'id':id,'action':action,'_token':"<?php echo e(csrf_token()); ?>"},function(data){
        if(data==null){
            alert('服务端错误');
        }
        if (data.status==1){
            alert(data.msg);
            location.href="<?php echo e(url('/backend/order')); ?>";
        }
    },'json');
}
</script>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>

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
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="<?php echo e(session('chage.starttime')); ?>" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="<?php echo e(session('chage.endtime')); ?>" />
充值类型：<select class="selectpay" name='pay_type'>
	<option value="false">请选择</option>
	<option value="weixin" <?php if(session('chage.paytype')=='weixin'){?> selected="selected"<?php }?> >微信公众号</option>
	<option value="unionpay" <?php if(session('chage.paytype')=='unionpay'){?> selected="selected"<?php }?>>银联</option>
	<option value="weixin_app" <?php if(session('chage.paytype')=='weixin_app'){?> selected="selected"<?php }?>>微信app</option>
	<option value="jdpay" <?php if(session('chage.paytype')=='jdpay'){?> selected="selected"<?php }?>>京东支付</option>
</select>
手机号：<input type="text" name="phonenum" value="<?php echo e(session('chage.phonenum')); ?>">
<input type="submit" id="submitbtn" value="搜索">
<input type="hidden" value="chage" name="type" />
<input type="hidden" value="<?php echo e(csrf_token()); ?>" name="_token" />
<a href="/backend/finance/export?<?php echo e($url); ?>"><input type="button" value="导出excel表"></a>
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
      	<?php foreach($chagelist as $row): ?>
            <tr>
            	<?php $count=$count+$row->money;?>
            	<td><?php echo e($row->code); ?></td>
            	<td><?php echo e($row->mobile); ?></td>
            	<td><?php echo e($row->nickname); ?></td>
            	<td><?php echo e($row->money); ?></td>
            	<td><?php echo e(date('Y-m-d H:i:s',$row->pay_time)); ?></td>
            	<td>
            		<?php if($row->pay_type=='weixin'): ?>
            		 微信充值
            		<?php elseif($row->pay_type=='unionpay'): ?>
            		银联充值
            		<?php elseif($row->pay_type=='weixin_app'): ?>
            		微信app
            		<?php elseif($row->pay_type=='jdpay'): ?>
            		京东支付
            		<?php endif; ?>
            	</td>	
            </tr>
        <?php endforeach; ?>
      </tbody>
     
    </table>
     <h3>本页充值总额：<?php echo e($count); ?>元</h3>
     <h3>总共充值金额：<?php echo e($allmoney); ?>元</h3>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	<?php if(is_callable(array($chagelist,'render'))): ?>
    <?php echo $chagelist->render(); ?>

    <?php else: ?>
     <?php echo $page; ?>

    <?php endif; ?>
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
<script src="<?php echo e(asset('backend/lib/finance/finance.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
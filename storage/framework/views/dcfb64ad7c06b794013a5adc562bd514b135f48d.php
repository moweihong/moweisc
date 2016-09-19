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
<form method="post" action="/backend/finance/bigWheelInfoSearch" onsubmit="return check()">
抽奖时间：<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="<?php echo e(session('bigwheel.starttime')); ?>" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="<?php echo e(session('bigwheel.endtime')); ?>" />

注册时间：<input class="datetimepicker7" id='regstarttime' style="widht:60px" type="text" name='regstarttime'  value="<?php echo e(session('bigwheel.regstarttime')); ?>" />-
<input class="datetimepicker7" id='regendtime' type="text" name='regendtime' value="<?php echo e(session('bigwheel.regendtime')); ?>" />

<input type="text" name="phone" placeholder="输入手机号" value="<?php echo e(session('bigwheel.phone')); ?>">
<select name='prize_type'>
	<option value="0">奖品内容</option>
	<?php foreach($prizetype as $v): ?>
	<option <?php if(session('bigwheel.prizetype')==$v->id){ ?> selected="selected" <?php }?> value="<?php echo e($v->id); ?>"><?php echo e($v->name); ?></option>
	<?php endforeach; ?>
	
</select>
<input type="submit" id="submitbtn" value="搜索">
<a href="/backend/finance/exportBigWheel?<?php echo e($url); ?>"><input type="button"  value="导表"></a>
<input type="hidden" value="<?php echo e(csrf_token()); ?>" name="_token" />
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
      	<?php foreach($list as $row): ?>
            <tr>
            	<?php $count=$count+$row->money;?>
            	<td><?php echo e($row->mobile); ?></td>
            	<td><?php echo e($row->nickname); ?></td>
            	<td><?php echo e($row->money); ?></td>
            	<td><?php echo e(date('Y-m-d H:i:s',$row->time)); ?></td>
            	<td style="color: burlywood;">
            		<?php if($row->reg_time): ?>
            		<?php echo e(date('Y-m-d H:i:s',$row->reg_time)); ?>

            		<?php endif; ?>
            	</td> 
            	<td>
            		<?php if($row->is_free==1): ?>
            		奖励次数
            		<?php else: ?>
            		消费10块乐豆
            		<?php endif; ?>
            	</td> 
            	
            	<!--<td><?php echo e(ceil($row->invite_last/3)); ?></td> -->         	
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
     <h3>本页红包总额：<?php echo e($count); ?>元</h3>
     <h3>总共红包金额：<?php echo e($summoney); ?>元</h3>
     <h3>总共参加人数：<?php echo e($membernum); ?>个</h3>
     <h3>总共抽奖次数：<?php echo e($canjiacishu); ?>次</h3>
      
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	<?php if(is_callable(array($list,'render'))): ?>
    <?php echo $list->render(); ?>

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
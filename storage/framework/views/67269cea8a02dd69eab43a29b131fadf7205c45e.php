<?php $__env->startSection('content'); ?>

<div class="header">
 <h1 class="page-title">推广渠道管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="#">推广人</a> <span class="divider">/</span></li>
            <li class="active">邀请明细</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    
          推广员账号：<input type="text" style="margin-left: 200px;" placeholder="输入手机号号"  class="btn">
    <button class="btn searchUser">查询</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th style="width: 20%">推广员账号</th>
          <th style="width: 20%">邀请用户电话</th>
          <th style="width: 20%">邀请用户名</th>
          
          <th style="width: 20%">消费金额</th>
      
        </tr>
      </thead>
      <tbody>
      	<?php $money=0;?>
      	<?php if(!empty($list)): ?>
      	
      	<?php foreach($list as $row): ?>
      	<?php $money=$money+$row->xfmoney;?>
            <tr>
            	<td><?php echo e($row->user->mobile); ?></td>
            	<td><?php echo e($row->usersec->mobile); ?></td>
            	<td><?php echo e($row->usersec->nickname); ?></td>
            	<td><?php echo e($row->xfmoney); ?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
</div>
<div>本页消费金额：<?php echo e($money); ?> 邀请注册总人数：<?php echo e($usernum); ?></div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	<?php if(method_exists($list,'render')): ?>
    <?php echo $list->render(); ?>

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
<script>
  $("#showaddusr").click(function(){
  		$('#divone').show();
  })
  
  $("#hideaddusr").click(function(){
  		$('#divone').hide();
  })
  
   $(".showcardnum").click(function(){
   		var uid=$(this).data('uid');
   		$('#uploaduid').val(uid);
  		$('#divtwo').show();
  })
  
  $("#hideaddcardnum").click(function(){
  		$('#divtwo').hide();
  })
  
  //更新
  $(".upshop").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	  
  	  window.location.href="/backend/shop/upShop/"+id;
  	  
  })
  
   $(".lookshop").click(function(){
  	 
  	  var id=parseInt($(this).data('id'));
  	  
  	  window.location.href="/backend/shop/lookShop/"+id;
  	  
  })
  
   $('.searchUser').click(function(){
  		var keyword=$(this).prev().val();
  		location.href='/backend/promote/getOfflineInfo/'+keyword;
  		//$.get('/backend/searchShop/'+keyword,{},function(){})
  })
  

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
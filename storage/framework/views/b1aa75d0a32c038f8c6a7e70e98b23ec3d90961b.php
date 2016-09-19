<?php $__env->startSection('content'); ?>
<div class="header">
 <h1 class="page-title">品牌管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop/merchants">商户列表</a> <span class="divider">/</span></li>
            <li class="active">添加商户</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
   <div class="btn-toolbar">
   <!-- <button class="btn btn-primary"><i class="icon-save"></i> Save</button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab" method="post" action="/backend/shop/addMerchants">
      
       <label>商户名称</label>
        <input type="text" name='merchants' class="input-xlarge">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    	<input type="submit" value="提交">
    </form>
      </div>
  </div>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
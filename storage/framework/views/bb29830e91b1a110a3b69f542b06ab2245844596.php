<?php $__env->startSection('content'); ?>
<div class="header">
 <h1 class="page-title">商品管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop">商品</a> <span class="divider">/</span></li>
            <li class="active">活动商品列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="addActivityShop">
         <i class="icon-plus"></i>添加商户
    </button>
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
       
          <th style="width: 10%">商户id</th>
          <th style="width: 15%">商户名称</th>
          <th style="width: 30%">时间</th>
          <th>管理</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($list as $row): ?>
            <tr>
            	
            	<td><?php echo e($row->id); ?></td>
            	<td><?php echo e($row->merchants); ?></td>
            	<td style="color: burlywood;"><?php echo e(date('Y-m-d H:i:s',$row->time)); ?></td>
            	<td>
            		
              		<a href="javascript:void(0);" role="button" data-toggle="modal" >
              			<input data-id="<?php echo e($row->id); ?>" class="delMerchants" type="button" value="删除">
              		</a>
              		<a href="javascript:void(0);" role="button" data-toggle="modal" >
              			<input class="changeMerchants"  data-content="<?php echo e($row->merchants); ?>" data-id="<?php echo e($row->id); ?>" type="button" value="编辑">
              		</a>
            		
            	</td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div id='changemer' style="background: gray;width: 800px; margin-left: 100px;display: none;">
	    <form method="post" action="/backend/shop/changeMerchants">
	    	<input style="margin-left: 400px;width: 300px;"type="hidden" name="id" id="merchantsid">
	    	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	    	<input style="margin-left: 200px;margin-top:20px;width: 300px;"type="text" name="merchants" id="merchantstitle"><br />
	    	<input style="margin-left: 300px;"type="submit" value="提交"><input type="button" value="取消" id='notshow'>
	    </form>
    </div>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    <?php echo $list->render(); ?>

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
  $("#addActivityShop").click(function(){
  		window.location.href="/backend/shop/addMerchants";
  })
  
  //更新
  $(".changeMerchants").click(function(){
  	  
  	var id=parseInt($(this).data('id'));
  	var content=$(this).data('content');
  	$("#merchantsid").val(id);
  	$("#merchantstitle").val(content); 
  	$("#changemer").show();	
  	 
  })
  
  //删除
  $(".delMerchants").click(function(){
  	  var id=parseInt($(this).data('id'));
  	   
	$.post("/backend/shop/delMerchants", { 'id': id,'_token':"<?php echo csrf_token(); ?>" },
       function(data){
       if(data>0)
       {
     		alert("删除成功");
     		window.location.reload()
     		
     		
       }
       else
       {
       		alert("删除失败");
       }
       
    });
  	  //alert(111);
  })
  
  //取消
  $("#notshow").click(function(){
  	var val='';
  	$("#changemer").hide();
  	$("#merchantsid").val(val);
  	$("#merchantstitle").val(val); 	
  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
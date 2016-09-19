<style>
	.xiajia{color:red;}
	td{border:1px solid #ddd}
	.fbt{font-size:12px}
</style>
<?php $__env->startSection('content'); ?>

<div class="header">
 <h1 class="page-title">商品管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop">商品</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="addshop">
         <i class="icon-plus"></i>添加商品
    </button>
    <input type="text" style="margin-left: 200px;" placeholder="输入商品名称" class="btn">
    <button class="btn searchShop">搜索</button>
    <a style="margin-left: 10px;" href="/backend/shop/exportShop">
         <button class="btn searchShop">导表</button>
    </button></a>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <!--<th style="width: 5%">排序</th>-->
          <th style="width: 5%">商品id</th>
          <th style="width: 27%">商品信息</th>
		   <th style="width:8%">所属类别</th>
          <th style="width: 8%">标签</th>
          <th style="width: 8%;">采购价</th>
          <th style="width: 8%;">售价</th>
          <th style="width: 8%;">销售量</th>
          <th style="width: 8%;">推广链接</th>
          <th>管理</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($shoplist as $row): ?>
            <tr>
            	<!--<td><input style="width: 18px" size="6" type="text" value="<?php echo e($row->order); ?>"></td>-->
            	<td><?php echo e($row->id); ?></td>
            	<td>
					<?php echo $row->title; ?>

					<p class='fbt'>副标题：<?php echo $row->title2; ?><BR>供应商：<font color='#f60'><?php echo e(!empty($row->supplier)?$row->supplier:'无'); ?>  </font></p>
				</td>
            	<td><?php echo e($row->name); ?></td>
            	<td style="color: burlywood;">
            		<?php if($row->shoptype==0): ?>
            		无标签
            		<?php elseif($row->shoptype==1): ?>
            		人气商品
            		<?php elseif($row->shoptype==2): ?>
            		推荐商品
            		<?php endif; ?>
            	</td>
            	<td><?php echo $row->purchase_price; ?></td>
            	<td>
            		<?php echo $row->money; ?>

            	</td>
            	<td><?php echo e(isset($row->cur_periods) ? $row->cur_periods : ''); ?></td>
				<td><BUTTON onclick='alert("正在开发...")'>PC链接</BUTTON><br/><br/><BUTTON onclick='alert("正在开发...")'>H5链接</BUTTON></td>
            	<td>
            		<a href="javascript:void(0);" role="button" data-toggle="modal" class="lookshop" data-id="<?php echo e($row->id); ?>"><i >查看详情</i></a>
              		<a href="javascript:void(0);" role="button" data-toggle="modal" class="upshop" data-id="<?php echo e($row->id); ?>"><i >修改</i></a>
            		<?php if($row->isdeleted==0): ?>
            		 <a href="javascript:void(0);"  role="button" data-toggle="modal" class="delshop" data-id="<?php echo e($row->id); ?>"><button>下架</button></a>
            		<?php else: ?>
            		<a href="javascript:void(0);" class='xiajia uploadShopAgain' role="button" data-toggle="modal" data-id="<?php echo e($row->id); ?>"><button>上架</button></a>
            		<a href="javascript:void(0);" class='xiajia' role="button" data-toggle="modal"  data-id="<?php echo e($row->id); ?>"><button onclick='alert("正在开发...")'>预览</button></a>
            		<?php endif; ?>
            	</td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    <?php echo $shoplist->render(); ?>

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
  $("#addshop").click(function(){
  		window.location.href="/backend/shop/addShop";
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
  
  //下架
  $(".delshop").click(function(){
  	
  	if(confirm("是否确认下架"))
  	{
	  	var id=parseInt($(this).data('id'));  
		$.post("/backend/shop/delShop", { 'id': id },
	       function(data){
	       if(data>0)
	       {
	     		alert("下架成功");
	     		window.location.reload()
	     		
	     		
	       }
	       else
	       {
	       		alert("下架失败");
	       }
	    });
	}
	else
	{
		return false;
	}
	
  	
  	  //alert(111);
  })
  
  //上架
  $(".uploadShopAgain").click(function(){
  	var id=parseInt($(this).data('id'));
  	  
  	window.location.href="/backend/shop/loadUoloadShopAgain/"+id;
  })
  
  $('.searchShop').click(function(){
  		var keyword=$(this).prev().val();
  		location.href='/backend/shop/searchShop/'+keyword;
  		//$.get('/backend/searchShop/'+keyword,{},function(){})
  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
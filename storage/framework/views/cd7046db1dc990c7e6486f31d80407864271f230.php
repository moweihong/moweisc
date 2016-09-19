<?php $__env->startSection('content'); ?>

<div class="header">
 <h1 class="page-title">推广渠道管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="#">推广人</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" id="showaddusr">
         <i class="icon-plus"></i>新增推广员
    </button>
          推广员账号：<input type="text" style="margin-left: 200px;" value="填账号" class="btn">
    <button class="btn searchUser">查询</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th style="width: 10%">推广员id</th>
          <th style="width: 15%">推广员账号</th>
          <th style="width: 15%">剩余有效卡</th>
          <th style="width: 10%">已充值</th>
          <th style="width: 10%">已冻结</th>
          <th style="width: 10%">已过期</th>
          <th style="width: 15%;">状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($userlist as $row): ?>
            <tr>
            	<td><?php echo e($row->usr_id); ?></td>
            	<td><?php echo e($row->mobile); ?></td>
            	<td><?php echo e($row->nousenum); ?></td>
            	<td><?php echo e($row->usenum); ?></td>
            	<td><?php echo e($row->dongjienum); ?></td>
            	<td><?php echo e($row->timeoutnum); ?></td>
            	
            	<td>正常</td>
            	<td>
              		<a href="javascript:void(0);" role="button" data-toggle="modal" class="showcardnum" data-uid="<?php echo e($row->usr_id); ?>"><i >添加卡数</i></a>
            	</td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
<div id='divone' style="background: gray;display: none; ">
	<h2>新增推广员<h2>
	账号：<input type="text" id="usermobile">
		<font id='showtip' style="color: red;font-size: x-small;"><font><br />
		<input type="button" id='uploadUsr' value="提交">
		<input type="button" id='hideaddusr' value="关闭">
		
</div>
<div id='divtwo' style="background: gray;display: none;">
	<h2>添加卡数<h2>
	张数：<input type="text" id="cardnum"><br />
		<input type="hidden" id='uploaduid' value="">
		<input type="button" id='uploadcardnum' value="提交">
		<input type="button" id='hideaddcardnum' value="关闭">
		
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
	<?php if(method_exists($userlist,'render')): ?>
    <?php echo $userlist->render(); ?>

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
  
  //添加推广人员
  $("#uploadUsr").click(function(){
  	  var mobile=$('#usermobile').val();
  	  if(mobile=='')
  	  {
  	  	alert('账号不能为空');
  	  	return false;
  	  }
	 $.get("/backend/promote/addUser", { 'mobile': mobile },
       function(data){
       	var data=eval("("+data+")")
       if(data.status==0)
       {
     		alert(data.msg);
     		location.reload();
     		
     		
       }
       else
       {
       		alert(data.msg);
       		
       }
       
    });
  	  //alert(111);
  })
  
 
  
  //添加卡数
  $("#uploadcardnum").click(function(){
  	  var usrid=$('#uploaduid').val();
  	  var cardnum=$('#cardnum').val();
	  if(!confirm('你确定要给该推广员绑定'+cardnum+'张卡吗？')){
		  return false;
	  } 
  	  if(cardnum=='')
  	  {
  	  	alert('张数不能为空');
  	  	return false;
  	  }
	 $.get("/backend/promote/addUserCardNum", { 'usrid': usrid,'cardnum':cardnum },
       function(data){
       	var data=eval("("+data+")")
       if(data.status==0)
       {
     		alert(data.msg);
     		location.reload();
     		
     		
       }
       else
       {
       		alert(data.msg);
       		
       }
       
    });
  	  //alert(111);
  })
  
  $('.searchUser').click(function(){
  		var keyword=$(this).prev().val();
  		location.href='/backend/promote/searchUser/'+keyword;
  		//$.get('/backend/searchShop/'+keyword,{},function(){})
  })
  
   //检测用户是否存在
  $('#usermobile').change(function(){
  		var mobile=$(this).val();
  		if(mobile.length!=11)
  		{
  			alert('手机格式有误');
  			return false;
  		}
  		$.get("/backend/promote/testUser", { 'mobile': mobile },
       function(data){
	       var data=eval("("+data+")");
	       if(data.status==-1)
	       {
	     		$('#uploadUsr').hide();
	     		$('#showtip').html(data.msg);
	     		
	       }else
	       {
	       		$('#uploadUsr').show();
	       }
	       
       })
  		
  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
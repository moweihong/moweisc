<?php $__env->startSection('content'); ?>
<div class="header">
            
            <h1 class="page-title">会员管理</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/member">会员管理</a> <span class="divider">/</span></li>
            <li class="active">会员列表</li>
        </ul>
		
		<div style='margin:0 auto;width:96%;text-align:center;'>
			<b>注册来源：</b>
			<?php  
			if(!empty($reg)){ 
			foreach($reg['Logincntlist'] as $r){  ?>
				<?php echo e($r['equipment']); ?>:<?php echo e($r['logincnt']); ?>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }} ?>
		</div>
		
    <div class="container-fluid">
        <div class="row-fluid">
<div class="well">
	<form action="/backend/member/muchPhoneSearch" method="post">
		<?php echo csrf_field(); ?>

		 <textarea name="phones" style="margin: 0px; width: 1088px; height: 174px;"><?php echo e(session('member.phones')); ?></textarea>
       	 <p style="color: red;">多个手机号用英文的逗号","隔开</p>
       	 <input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="<?php echo e(session('member.starttime')); ?>" />-
		<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="<?php echo e(session('member.endtime')); ?>" />
       	 <input type="submit" value="提交">
       	 	
	</form>
    <div>
        <span>单个手机号：<input value="<?php echo e($username); ?>" placeholder="输入手机号码" name="username" type="text"></span>
        <button id="searchName" >搜索</button>
        <a href="/backend/member/exportUser?<?php echo e($url); ?>"><input type="button" value="导表"></a>
    </div>
    </br>
    <table class="table">
      <thead>
        <tr>
          <th>用户id</th>
          <th>用户名</th>
          <th>电话</th>
          <th>用户余额</th>
          <th>佣金</th>
          <th>块乐豆</th>
          <th>注册时间</th>
          <th>用户经验</th>
          <th>用户级别</th>
          <th >渠道审核</th>
          <th >消费金额</th>
          <th >操作</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($list as $row): ?>
            <tr <?php if($row->is_unusual == -1): ?> style="background-color:red;" <?php endif; ?>>
            	<td><?php echo e($row->usr_id); ?></td>
                <td>
                <?php
                    if($username==''){
                        echo $row->nickname;
                    }else{
                        echo str_replace($username,'<font color="red">'.$username.'</font>',$row->nickname);
                    }
                ?>
                </td>
            	<td><?php echo e($row->mobile); ?></td>
            	<td><?php echo e($row->money); ?></td>
            	<td><?php echo e($row->commission); ?></td>
            	<td><?php echo e($row->kl_bean); ?></td>
            	<td><?php echo e(date('Y-m-d H:i:s',$row->reg_time)); ?></td>
            	<td><?php echo e($row->exps); ?></td>
            	<td>
                     <?php if($row->usr_level==1): ?>
                        <font color="red">渠道用户</font>
                     <?php else: ?>
                     普通用户
                     <?php endif; ?>
                </td>
                <td>
                    <?php if($row->usr_level == 2): ?>
                    <a href="javascript:void(0);" onclick="checkPass(<?php echo e($row->usr_id); ?>)">审核</a>
<!--                    <a href="javascript:void(0);">拒绝</a>-->
                    <?php endif; ?>
            	</td>
            	<td><?php echo e($row->buymoney); ?></td>
            	<td>
            		<?php if($row->is_unusual==0 || $row->is_unusual==-1): ?>
            		<input type="button" value="封号" data-id="<?php echo e($row->id); ?>" data-type="1" class="fenghao">
            		<?php else: ?>
            		<input type="button" value="解封" data-id="<?php echo e($row->id); ?>" data-type="0" class="fenghao">
            		<?php endif; ?>
            	</td>
            	
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">
    <?php echo $list->render(); ?>

</div>          
</div>
</div>
<script>

$("#searchName").click(function(){
    var name = $("input[name='username']").val();
    location.href = '/backend/member/'+name;
})

$(".fenghao").click(function(){
	var id=$(this).data('id');
	var type=$(this).data('type');
	$.ajax({
        'url': "<?php echo e(url('/backend/member/setFengHao')); ?>",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'type':type,'_token':"<?php echo e(csrf_token()); ?>"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg(data.msg);
                }
        }
        });
})

var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('.datetimepicker7').datetimepicker();
$('#datetimepicker8').datetimepicker({
	onGenerate:function( ct ){
		$(this).find('.xdsoft_date')
			.toggleClass('xdsoft_disabled');
	},
	minDate:'-1970/01/2',
	maxDate:'+1970/01/2',
	timepicker:false
});
</script>
<?php $__env->stopSection(); ?>
<script type="text/javascript">
function checkPass(id)
{
    layer.confirm('是否确认升级为渠道用户？', {icon: 3, title:'提示'}, function(index){
        $.ajax({
        'url': "<?php echo e(url('/backend/member/uplevel')); ?>",
        'dataType': 'json',
        'type': 'POST',
        'data':{'id':id,'_token':"<?php echo e(csrf_token()); ?>"},
        'success': function(data){
                if(data == null){
                    layer.msg('服务端错误！');
                }
                if(data.status == 1){
                    layer.msg(data.msg);
                    location.reload();
                } else {
                    layer.msg(data.msg);
                }
        }
        });
    });
}


</script>

<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
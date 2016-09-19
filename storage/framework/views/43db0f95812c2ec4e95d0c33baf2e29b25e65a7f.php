<?php $__env->startSection('content'); ?>
<div class="header">
            
            <h1 class="page-title">Users</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/backend/article">文章管理</a> <span class="divider">/</span></li>
            <li class="active">文章分类</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="addcat">添加分类</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
            <th>文章分类名称</th>
          <th>类型</th>
          <th>描述</th>
          <th>排序</th>
          <th style="display: none;">是否显示在导航栏</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($list as $row): ?>
            <tr>
            	<td><?php echo e($row->cat_name); ?></td>
                <?php
                    switch ($row->cat_type) {
                        case 1: echo '<td style="color: #ffadbd;">普通分类</td>';break;
                        case 2: echo '<td style="color: #FF7930;">帮助分类</td>';break;
                        case 3: echo '<td >首页动态公告</td>';break;
                        case 4: echo '<td style="color: #ff1493;">常见问题</td>';break;
                        case 5: echo '<td style="color: #F32043;">新闻分类</td>';break;
                        default:
                            echo '普通分类';break;
                    }
                ?>                
            	<td><?php echo e($row->cat_desc); ?></td>
            	<td><?php echo e($row->sort_order); ?></td>
            	<td style="display: none;">
                    <?php if($row->show_in_nav==0): ?>
                       <?php echo e('否 '); ?>

                     <?php else: ?>
                        <?php echo e('是 '); ?>

                     <?php endif; ?>
                </td>
            	<td>
                    <a href="<?php echo e(url('/backend/article/editarticlecat',['id'=>$row->cat_id])); ?>" title="编辑分类"><i class="icon-pencil"></i></a>
                    <a href="javascript:void(0);" class="delete" onclick="delcat(<?php echo e($row->cat_id); ?>)" title="删除分类"><i class="icon-remove"></i></a>
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
<script type="text/javascript">
    $("#addcat").click(function(){
        location.href = 'article/addarticlecat';
    });
    function delcat(id){
        layer.confirm('是否确认删除此分类？', {icon: 3, title:'提示'}, function(index){
            $.ajax({
            'url': "<?php echo e(url('/backend/article/delarticlecat')); ?>",
            'dataType': 'json',
            'type': 'POST',
            'data':{'cat_id':id,'_token':"<?php echo e(csrf_token()); ?>"},
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
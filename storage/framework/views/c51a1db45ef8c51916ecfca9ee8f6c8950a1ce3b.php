<?php $__env->startSection('content'); ?>
<div class="header">
            
            <h1 class="page-title">Users</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/backend/article">文章管理</a> <span class="divider">/</span></li>
            <li class="active">文章列表</li>
        </ul>
        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="addArticle">添加文章</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>文章标题</th>
          <th>标签</th>
          <th>文章类型</th>
          <th style="display: none;">是否显示</th>
          <th>创建时间</th>
          <th style="width: 40px;">操作</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($list as $row): ?>
            <tr>
            	<td><?php echo e($row->article_id); ?></td>
            	<td><?php echo e($row->title); ?></td>       	
            	<td>
                    <?php 
                        switch ($row->tag) {
                            case 'p': echo '图片'; break;
                            case 'j': echo '推荐'; break;
                            case 'h': echo '热门'; break;
                            case 't': echo '头条'; break;
                            default:
                                echo '无';
                                break;
                        }
                    ?>                    
                </td>       	
            	<td><?php echo e($row->articleCat->cat_name); ?></td>       	
                <td style="display: none;">
                    <?php if($row->is_open==0): ?>
                       <?php echo e('否 '); ?>

                     <?php else: ?>
                        <?php echo e('是 '); ?>

                     <?php endif; ?>
                </td>
                <td><?php echo e($row->created_at); ?></td>
            	<td>
                    <a href="<?php echo e(url('/backend/article/editarticle',['id'=>$row->article_id])); ?>" title="编辑文章"><i class="icon-pencil"></i></a>                    
                    <a href="javascript:void(0);" class="delete" onclick="delArticle(<?php echo e($row->article_id); ?>)"  title="删除文章"><i class="icon-remove"></i></a>
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
    $("#addArticle").click(function(){
        location.href = 'addarticle';
    });
    function delArticle(id){
    layer.confirm('确定删除此文章?', {icon: 3, title:'提示'}, function(index){
      //do something
        layer.close(index);
        $.ajax({
                'url': "<?php echo e(url('/backend/article/delarticle')); ?>",
                'dataType': 'json',
                'type': 'POST',
                'data':{'article_id':id,'_token':"<?php echo e(csrf_token()); ?>"},
                'success': function(data){
                        if(data == null){
                            layer.msg('服务端错误！');
                        }
                        if(data.status == 1){
                            layer.msg(data.msg);
                            location.reload();
                        } else {
                            layer.msg('操作失败！');
                        }
                }
        });
    });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
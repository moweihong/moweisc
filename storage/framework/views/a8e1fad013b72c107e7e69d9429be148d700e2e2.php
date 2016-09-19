<?php $__env->startSection('title', '图文详情'); ?>
<?php $__env->startSection('my_css'); ?>
   <meta http-equiv="Cache-Control" content="max-age=8640000" />
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/product.css">
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/common.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mui-content">
   <div class='pro_co'>
	<?php echo $content->content; ?>

   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_js'); ?>
   <script>
   </script>
<?php $__env->stopSection(); ?>



 
<?php echo $__env->make('foreground.mobilehead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
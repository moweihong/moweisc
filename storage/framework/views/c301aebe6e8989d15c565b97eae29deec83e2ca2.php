<?php $__env->startSection('my_usercss'); ?>
<link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/page.css"/>
<link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/b_member.css"/>
<link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/c_member.css"/>
<link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/a_member.css"/>
<link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/member_comm.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/users_question.css">
<?php $__env->stopSection(); ?>
<?php /*内容模板基本固定，仅需要重写content_right文件即可*/ ?>
<?php $__env->startSection('content'); ?>
    <?php /*个人中心 头部文件*/ ?>
<?php echo $__env->make('foreground.user_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php /*个人中心 内容文件包裹*/ ?>
    <div id="content_box" class="">
        <?php /*个人中心 内容左部文件*/ ?>
        <?php echo $__env->make('foreground.user_left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php /*个人中心 内容右部文件*/ ?>
        <?php echo $__env->yieldContent('content_right'); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('my_userjs'); ?>
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/jquery190.js"></script>
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/user_history.js"></script>
<?php $__env->stopSection(); ?>
<?php /*<?php echo $__env->yieldContent('my_userjs'); ?>*/ ?>

<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
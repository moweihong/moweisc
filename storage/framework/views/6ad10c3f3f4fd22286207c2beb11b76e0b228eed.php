<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="Generator" content="">
    <meta name="Author" content="">
    <meta name="keywords" content="<?php echo e($seo['web_keyword']); ?>">
    <meta name="description" content="<?php echo e($seo['web_description']); ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta property="qc:admins" content="365000766564313763757" />
    <title><?php echo e($seo['web_title']); ?></title>
    <?php echo $__env->yieldContent('canonical'); ?>
    <?php /*全局css*/ ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/comm.css?v=<?php echo e(config('global.version')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/footer_header.css?v=<?php echo e(config('global.version')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/goods.css?v=<?php echo e(config('global.version')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/index.css?v=<?php echo e(config('global.version')); ?>"/>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/jquery190.js"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/jquery.lazyload.min.js"></script>
    <?php if(isset($is_mobile)): ?>
    	<script>
			 var is_mobile = <?php echo e($is_mobile); ?>;
			 var invite_code_m = <?php echo e($invite_code_m); ?>;
             //手机型号访问pc端直接访问触屏手机版
             var mobileAgents = ['Windows Phone', 'iPad', 'iPod', 'Symbian', 'iPhone', 'BlackBerry', 'Android'];
             var sUserAgent = navigator.userAgent;
             for (var i = 0; i < mobileAgents.length; i++) {
                 if (sUserAgent.indexOf(mobileAgents[i]) > -1) {
                     if(is_mobile == 1){
                        window.location.href = window.location.href+'index_m'
                     }else if(is_mobile == 2){
                    	 var is_freeday = <?php echo e(isset($is_freeday) ? $is_freeday : 0); ?>;
                         var jump = "http://m.ts1kg.com/freeday_m";
                    	 jump = parseInt(invite_code_m) > 0 ? jump+'?code='+parseInt(invite_code_m) : jump;
                    	 jump = (parseInt(invite_code_m) > 0 && parseInt(is_freeday) == 1) ? jump+'&is_freeday='+parseInt(is_freeday) : jump;
                    	 window.location.href = jump;
                     }
                     break;
                 }
             }
		</script>
    <?php endif; ?>
    <script type="text/javascript">
        //csrf_token验证
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '<?php echo e(csrf_token()); ?>' }
        });
    </script>
	<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/index.js?v=<?php echo e(config('global.version')); ?>"></script>
	<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/user_history.js?v=<?php echo e(config('global.version')); ?>"></script>
	<script type="text/javascript">
	var editurl=Array();
	editurl['editurl']="<?php echo e(asset('backend/ueditor')); ?>/";
	editurl['imageupurl']="<?php echo e(asset('backend/ueditor/upimage')); ?>/";
	editurl['imageManager']="<?php echo e(asset('backend/ueditor/imagemanager')); ?>/";
	editurl['webswf']="<?php echo e(asset('backend/uploadify/uploadify.swf')); ?>";
	editurl['webupswf']="<?php echo e(asset('foreground/js/webupload/Uploader.swf')); ?>";
	</script>
	<?php /*全局js*/ ?>
    <?php /*公共脚本*/ ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/common.js?v=<?php echo e(config('global.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/layer/layer.js?v=<?php echo e(config('global.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/my_cart.js?v=<?php echo e(config('global.version')); ?>"></script>
    
    <?php /*私有css*/ ?>
    <?php echo $__env->yieldContent('my_usercss'); ?>
    <?php echo $__env->yieldContent('my_css'); ?>

    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?dac62fbf58b41ab26923857a4cae5af8";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>

<body>
	<?php echo $__env->yieldContent('myt_js'); ?>
	<?php echo $__env->yieldContent('my_uploadjs'); ?>
	<?php echo csrf_field(); ?>

	
    <?php /*模板头文件*/ ?>
    <?php echo $__env->make('foreground.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php /*模板导航*/ ?>
    <?php echo $__env->make('foreground.navigate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php /*模板内容*/ ?>
    <div class="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php /*模板底部*/ ?>
    <?php echo $__env->make('foreground.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php /*滑动条模块*/ ?>
    <?php echo $__env->make('foreground.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->yieldContent('my_js'); ?>
    <?php echo $__env->yieldContent('my_shaidanjs'); ?>
<!--小能客服咨询入口START-->
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/xiaoneng.js" charset="utf-8"></script>
<script type="text/javascript" src="https://dl.ntalker.com/js/xn6/ntkfstat.js?siteid=kf_9372" charset="utf-8"></script>
<!--小能客服咨询入口END-->
</body>

<script>
    //定时检测用户的登录状态
    var  st=false;
    $(function time()
    {
        if(st)return;
        checklogin();
        setTimeout(time,5000); //time是指本身,延时递归调用自己,100为间隔调用时间,单位毫秒
    });
    function checklogin(){
        var url="/synchronize";
        $.ajax({
            type:'get',
            url:url,
            success:function(data){
            	var data =eval('('+data+')');
            	if(data.status == -10001){  //已登录，下线
                    st=true;
                    layer.confirm('亲，您的账号已下线或在别的地方登陆~', {
                        btn: ['重新登陆', '返回'], //按钮
                        offset: ['40%', '40%']
                    }, function () {
                        //跳转到充值页面
                        window.location.href = '/login';
                    }, function () {
                        window.location.href='/index';
                    });
                }else if(data.status == -1){  //初始状态为未登录
                	st=true;
                }else{
                    //用户处于登录状态
                	st=false;
                }
            }

        });
    }

</script>
</html>

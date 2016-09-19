<?php $__env->startSection('title', '个人中心'); ?>
<?php $__env->startSection('footer_switch', 'show'); ?>
<?php $__env->startSection('my_css'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/user.css?v=<?php echo e(config('global.version')); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/common.css?v=<?php echo e(config('global.version')); ?>">
   <style>
	   .mui-bar-nav{display:none}
	   html,body{background:#ECECEC;}
	   .mui-bar-tab{font-size:17px}
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div>
		<div class="uc_head" style='margin-bottom:0.07rem; '>
			<div class="uc_setting"><img data-url="/user_m/setting" src="<?php echo e($h5_prefix); ?>images/set.png" alt=""></div>
			<div class="uc_headimg"><div class='uch'><img src="<?php echo e($url_prefix); ?>img/def.jpg" alt=""></div></div>
			<div class="uc_login_bt" data-url="/login_m">未登录</div>
		</div>
		<div class="dk">
			<div class="dk1">
				<div class="dk11" onclick="myalert('请关注公众号【ts1kg2016】')">
					<img src="<?php echo e($h5_prefix); ?>images/wx.png" alt="">
					<p>一键关注微信</p>
				</div>
			</div>
			<div class="dk2" data-url="/login_m">
				<div class="dk11" onclick="location.href='/makemoney_m_new'">
					<img src="<?php echo e($h5_prefix); ?>images/yyzq.png" alt="">
					<p>邀友赚钱</p>
				</div>
			</div>
		</div>
		
		<div class="uclist uclist1" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci1.png" alt=""></div>
			<div class="uclistco">我的众筹记录</div>
		</div>
		<?php /*<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci1.png" alt=""></div>
            <div class="uclistco">未支付订单</div>
		</div>*/ ?>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci2.png" alt=""></div>
			<div class="uclistco">获得记录</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci3.png" alt=""></div>
			<div class="uclistco">账户明细</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci4.png" alt=""></div>
			<div class="uclistco">红包</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci5.png" alt=""></div>
			<div class="uclistco">我的佣金</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci6.png" alt=""></div>
			<div class="uclistco">我的晒单</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci7.png" alt=""></div>
			<div class="uclistco">块乐豆</div>
		</div>
		<div class="uclist" data-url="/login_m">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/uci8.png" alt=""></div>
			<div class="uclistco">收货地址</div>
		</div>
		<!--<div class="uclist" onclick="NTKF.im_openInPageChat('kf_9372_1470212593294')">
			<div class="uclisticon"><img src="<?php echo e($h5_prefix); ?>images/kf2.png" alt=""></div>
			<div class="uclistco">在线客服</div>
		</div>-->
	   <div style="height: 68px"></div>
   </div>
<!--小能客服咨询入口START-->
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/xiaoneng.js" charset="utf-8"></script>
<script type="text/javascript" src="https://dl.ntalker.com/js/xn6/ntkfstat.js?siteid=kf_9372" charset="utf-8"></script>
<!--小能客服咨询入口END-->
<?php $__env->stopSection(); ?>




 
<?php echo $__env->make('foreground.mobilehead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
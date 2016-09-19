<?php $__env->startSection('content'); ?>

<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/laydate/laydate.js"></script>
<div class="header">
 <h1 class="page-title">数据统计</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="">统计</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
<div class="btn-toolbar">
    <!--<button class="btn">Import</button>
    <button class="btn">Export</button>-->
  <div class="btn-group">
  </div>
</div>
<form method="post" action="/backend/finance/tongji" onsubmit="return check()">
<input class="datetimepicker7" id='start_time' style="widht:60px" type="text" name='start_time'  value="<?php echo e(session('lottery.starttime')); ?>" />-
<input class="datetimepicker7" id='end_time' type="text" name='end_time' value="<?php echo e(session('lottery.endtime')); ?>" /><input type="submit" id="submitbtn" value="搜索">
<input type="hidden" value="<?php echo e(csrf_token()); ?>" name="_token" />
</form>
<div class="well">
	
    <table class="table">
      <thead>
        <tr>
          <th style="width: 30%">统计项目</th>
          <th style="width: 15%">数值</th>
        </tr>
      </thead>
      <tbody>
      
      		<tr><td>注册总数</td><td><?php echo e($rgnum); ?></td></tr>
      		<tr><td>新增注册总数</td><td><?php echo e($xzrgnum); ?>(没有选择时间就是总注册人数了)</td></tr>
      		<tr><td>新增注册消费人数</td><td><?php echo e($xzxfnum); ?>(没有选择时间就是总消费人数了)</td></tr>
      		<tr><td>消费用户数</td><td><?php echo e($xfunum); ?></td></tr>
      		<tr><td>网站销售额</td><td><?php echo e($xftsum); ?></td></tr>
      		
      		
			<tr><td>幸运转盘每日参与人数</td><td><?php echo e($peopleofbigwheeleveryday); ?></td></tr>
			<tr><td>幸运转盘每日参与次数</td><td><?php echo e($numofbigwheeleveryday); ?></td></tr>
			<tr><td>幸运转盘参与二次人数</td><td><?php echo e($pepoleofbigwheeleverydayagain); ?></td></tr>
			<tr><td>幸运转盘老用户每日参与人数</td><td><?php echo e($oldpepoleofbigwheeleveryday); ?></td></tr>
			<tr><td>幸运转盘老用户每日参与次数</td><td><?php echo e($oldpepolenumofbigwheeleveryday); ?></td></tr>
			<tr><td>每日新增注册用户幸运转盘参与人数</td><td><?php echo e($newpepoleofbigwheeleveryday); ?></td></tr>
			<tr><td>每日新增注册用户幸运转盘二次参与人数</td><td><?php echo e($newpepoleofbigwheeleverydayagain); ?></td></tr>
      		
      		<tr><td>总消费块乐豆</td><td><?php echo e($klxfnum); ?></td></tr>
      		<tr><td>活动发现参与用户数</td><td><?php echo e($atfnum); ?></td></tr>
      		<tr><td>发送短信数</td><td><?php echo e($smsnum); ?></td></tr>
      		<tr><td>用户充值数量(人数)</td><td><?php echo e($czunum); ?></td></tr>
      		<tr><td>用户总充值金额</td><td><?php echo e($zcmsum); ?></td></tr>
      		<tr><td>用户账户总余额</td><td><?php echo e($symsum); ?></td></tr>
      		<tr><td>邀请总佣金</td><td><?php echo e($yjsum); ?></td></tr>
      		<tr><td>每日新增佣金</td><td><?php echo e($everydayincyongjing); ?></td></tr>
      		<tr><td>3日登陆用户数</td><td><?php echo e($srunum); ?></td></tr>
      		<tr><td>7日登陆用户数</td><td><?php echo e($qrunum); ?></td></tr>
			<tr><td>15日登陆用户数</td><td><?php echo e($swrunum); ?></td></tr>
            <tr><td>30日登陆用户数</td><td><?php echo e($ssrunum); ?></td></tr>
  
      </tbody>
     
    </table>

     <!--<h3>总共充值金额：<?php echo e(11111111); ?>元</h3>-->
</div>
<div id="pageStr" class="pageStr" style="margin: 64px auto;">

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
<script src="<?php echo e(asset('backend/lib/finance/finance.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
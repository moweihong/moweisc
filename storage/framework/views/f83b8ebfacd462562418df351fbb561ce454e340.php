<?php /*个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件*/ ?>

<?php $__env->startSection('title','我的账户'); ?>
<?php $__env->startSection('my_css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/users_question.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content_right'); ?>
<style>
    .c_main_income li{width:155px}
	.wenhao{position:absolute;margin-top:-9px;margin-left:9px;font-weight:800;color:#333;cursor:pointer;
			border:1px solid #eee;border-radius:50%;width:30px;height:30px;line-height:30px}
</style>
<div id="member_right" class="member_right c_member_right" style="border:none;">
    <!-- S 主页内容 -->
    <div class="c_main_box">
        <!-- S 主页内容右侧-->
        <div class="sidebar_r clrfix fr">
            <div class="g-invitation g-sid-title">
                <h3 class="gray3"><b>邀请有奖</b></h3>
                <span>邀请好友并消费最高可获得<em class="orange">100块乐豆</em>加<em class="orange">3.5%现金奖励</em></span>
                <textarea id="txtInfo" rows="3" cols="10" class="gray6" spellcheck="false">
                </textarea>
                <div class="fx-out-inner">
                    <a id="btnCopy" data-clipboard-target="txtInfo" href="javascript:;" class="z-copy-share fr">复制分享</a>
                    <div class="bdsharebuttonbox bdshare-button-style2-16" data-bd-bind="1457684604192">
                        <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                        <a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                        <a class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                        <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
                        <a class="bds_renren" data-cmd="renren"></a>
                    </div>
                </div>
            </div>
            <div class="g-QR-code g-sid-title">
                <h3 class="gray3"><b>关注官方微博</b></h3>
                <div class="clrfix">
                    <span class="fl"><a href="javascript:void(0);" >
                            <img style="width: 70px; height: 70px;" src="<?php echo e($url_prefix); ?>img/wei.jpg"></a></span>
                    <p class="fl gray6">
                        扫一扫<br>
                        了解更多信息
                    </p>
                </div>
                <s class="u-personal"></s>
            </div>
            <div class="g-QR-code g-sid-title">
                <h3 class="gray3"><b>关注官方微信</b></h3>
                <div class="clrfix">
                    <span class="fl"><a href="javascript:void(0);">
                            <img style="width: 75px; height: 75px;" src="<?php echo e($url_prefix); ?>img/weixin.jpg"></a></span>
                    <p class="fl gray6">
                        扫一扫<br>
                        享受更多微信专享服务
                    </p>
                </div>
                <em class="u-personal"></em>
            </div>
        </div>
        <!-- E 主页内容右侧-->
        <!-- 收益展示、充值、提现 -->
       <!-- <ul class="c_main_income" style="margin-bottom:15px">
            <li id="c_money_type"  >
                <div class="c_money_type">可用余额</div>
                <span id="accountUsableMoney">￥<?php echo e($user->money); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li class="c_income">
                <div class="c_money_type">块乐豆<span title='100块乐豆=1块钱，块乐豆将于每年12月31日24点清零' style='color:#ddd' class='wenhao'>?</span></div>
                <span style="color:#f57403;" id="redCount"><?php echo e($user->kl_bean); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li class="c_income">
                <div class="c_money_type">红包(个)</div>
                <span style="color:#f57403;" id="JSDshopCard"><?php echo e($redtotal); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li>
                <a href="/user/recharge_now" target="_blank" class="c_main_recharge">充值</a>
            </li>
            <div class="c_clear"></div>
        </ul>
        <ul class="c_main_income">
            <li id="c_money_type"  >
                <div class="c_money_type">待确定</div>
                <span id="accountUsableMoney"><?php echo e($orderSure); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li class="c_income">
                <div class="c_money_type">待发货<i></i></div>
                <span style="color:#f57403;" id="redCount"><?php echo e($orderSend); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li class="c_income">
                <div class="c_money_type">待收货</div>
                <span style="color:#f57403;" id="JSDshopCard"><?php echo e($orderGet); ?></span>
            </li>
            <div class="c_right_line"></div>
            <li>
                <a href="/category" target="_blank" class="c_main_recharge">立即一块购</a>
            </li>
            <div class="c_clear"></div>
        </ul>-->
        
        <div class="account_show">
        	<ul class="item01"><li>账号余额：<span><?php echo e($user->money); ?></span>元</li><li><input type="button" value="立即充值" onclick="window.location.href='/user/recharge_now'"/></li></ul>
        	<ul class="item02"><li>块乐豆：<span><?php echo e($user->kl_bean); ?></span>个&nbsp;<img src="<?php echo e($url_prefix); ?>img/question_ioc.png"/></li><li><input type="button" value="赚块乐豆" onclick="window.location.href='/user/score'" /></li></ul>
        	<ul class="item03"><li>红包：<span><?php echo e($redtotal); ?></span>个</li><li><input type="button" value="立即一块购" onclick="window.location.href='/category'"/></li></ul>
        	<ul class="item04"><li><div><p>待支付</p><p class="red">0</p></div></li><li><div><p>已获得待确认</p><p class="red"><?php echo e($orderSure); ?></p></div></li><li><div><p>待发货</p><p class="red"><?php echo e($orderSend); ?></p></div></li><li><div><p>待收货</p><p class="red"><?php echo e($orderGet); ?></p></div></li></ul>
        	<div class="kld_tip">
        		<p>100块乐豆=1块钱,</p>
        		<p>块乐豆将于每年12月31日24点清零</p>
        	</div>
        </div>
        <!-- 账户总额、客服 -->
        <div class="c_main_account  c_new_main_account">
        </div>
        <!-- 广告图轮转 -->
        <div class="g-acquired-goods g-common-control clrfix">
            <div class="m-getGood-title clrfix">
                <a href="/user/prize" class="gray9">全部<em class="f-tran">&gt;</em></a><b id="b_getgoodstitle" class="gray3">获得的商品</b>
            </div>
            <?php if($obtainOrder->count()>0): ?>
            <ul>
                <?php foreach($obtainOrder as $val): ?>
                <li>
                    <span class="fl"><a href="<?php echo e(url('product',['id'=>$val->o_id])); ?>">
                            <img alt="" src="<?php echo e($val->goods->thumb); ?>"></a></span>
                    <dl class="fl">
                        <dt><a class="wztxt" href="<?php echo e(url('product',['id'=>$val->o_id])); ?>" class="gray3" title="<?php echo e($val->goods->title); ?>">恭喜您获得<span>(第<?php echo e($val->object->periods); ?>期)<?php echo e($val->goods->title); ?></span></a></dt>
                        <dd>价值：￥<?php echo e($val->goods->money); ?></dd>
                        <dd>幸运块乐码：<?php echo e($val->fetchno); ?></dd>
                    </dl>
                    <?php if($val->status==4): ?>
                    <a href="javascript::void(0);" data-id='<?php echo e($val->id); ?>' class="z-perfect-btn confirmGood">确认收货</a>
                	<?php endif; ?>
                	<?php if($val->status==2): ?>
                	<a href="<?php echo e(url('user/address',['orderid'=>$val->id])); ?>" class="z-perfect-btn">完善地址</a>
               		<?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <div class="m-comm-scroll">
                <div class="null-data">
                        您还没有参与一块购？ 梦想与您只有1元的距离！
                    <a class="blue" target="_blank" href="/index">去一块购</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- S 云购记录-->
        <div id="g_buys_records" class="g-buys-records g-common-control clrfix">
            <div class="m-getGood-title clrfix">
                <a href="/user/buy" class="gray9">全部<em class="f-tran">&gt;</em></a><b class="gray3">一块购记录</b>
            </div>
            <div class="m-comm-scroll">
                <?php if($yunOrder->count()>4): ?>
                <a href="javascript:;" class="z-prev" style=""><i class="u-personal"></i><span></span></a>
                <a href="javascript:;" class="z-next" style=""><i class="u-personal"></i><span></span></a>
                <?php endif; ?>               
                <div class="commodity-list clrfix">
                 <?php if($yunOrder->count()>0): ?>
                    <div id="div_UserBuyList" style="position: absolute; width: 1638px; left: 0px;">
                        <?php foreach($yunOrder as $val): ?>
                        <div class="productsCon">
                            <div class="proList">
                                <ul>
                                    <li class="list-pic">
                                        <a  href="<?php echo e(url('product',['id'=>$val->o_id])); ?>"><img src="<?php echo e($val->goods->thumb); ?>"></a>
                                    </li>
                                    <li class="list-name"><a href="<?php echo e(url('product',['id'=>$val->o_id])); ?>">(第<?php echo e($val->object->periods); ?>期)<?php echo e($val->goods->title); ?></a></li>
                                    <li class="list-over"><a href="javascript::void(0);">
                                     <?php 
                                        switch ($val->object->is_lottery) {
                                            case 0:
                                                echo '进行中';
                                                break;
                                            case 1:
                                                echo '未开奖';
                                                break;
                                            case 2:
                                                echo '已揭晓';
                                                break;
                                            default:
                                                break;
                                        }
                                     ?>
                                     </a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endforeach; ?>                       
                </div>
                <?php else: ?>
                <div class="m-comm-scroll">
                    <div class="null-data">
                        您还没有参与一块购？ 梦想与您只有1元的距离！
                        <a class="nulldata-link" target="_blank" href="/index">去一块购</a>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
        <!-- E 云购记录-->
    </div>
    <!-- E 主页内容 -->
</div>
<!-- E 右侧 -->
</div>
<div class="p-rec-tips" id="show">
    <h2 class="rec-tiph2">尊敬的用户，你的佣金已满100，符合升级资格！</h2>
    <div class="rec-tiptxt">
        <p>升级为渠道用户，会获取更多的佣金</p>
        <p>您的资料未完善，请先去完善资料！</p>
    </div>
    <p class="rec-tipbut clearfix"><a href="/user/security" class="rect-record">完善资料</a><a href="javascript:void(0);" onclick="closewindow()" class="rect-reload">稍后完善</a></p>
</div>
<div class="p-rec-tips" id="show1">
    <h2 class="rec-tiph2">尊敬的用户，你的佣金已满100，符合升级资格！</h2>
    <div class="rec-tiptxt">
        <p>升级为渠道用户，会获取更多的佣金</p>
        <p>动动手，现在就升级为渠道用户吧！</p>
    </div>
    <p class="rec-tipbut clearfix"><a href="javascript:void(0);" onclick="levelUp()" class="rect-record">立即升级</a><a href="javascript:void(0);" onclick="closewindow()" class="rect-reload">稍后升级</a></p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_js'); ?>
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/dist/ZeroClipboard.js"></script>
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/layer/layer.js"></script>
<script>
    var isshow = <?php echo e($isshow); ?>;
    var txtObj = $("#txtInfo");
    ShareTitle = "我在这里花了1块钱就得到了，看来还是特速一块购能给我带来好运啊，祝大家好运！";
    ShareUrl = 'http://<?php echo e($_SERVER['HTTP_HOST']); ?>/freeday?code=<?php echo e(session('user.id')); ?>';
    txtObj.val(ShareTitle + "\n" + ShareUrl);
    
    //创建ZeroClipboard对象，并绑定指定事件元素 
    var client = new ZeroClipboard( document.getElementById("btnCopy") );
    client.on( "ready", function( readyEvent ) {
      client.on( "aftercopy", function( event ) {
        layer.msg("复制成功！");
      } );
    } );    
    
    window._bd_share_config = {
        common: {
        	bdText : '哇塞，全部都好想要！',
			bdComment : '有钱买iphone6s不牛B，花一块钱买到才牛B，有本事就来试试吧！',
			bdDesc : '有钱买iphone6s不牛B，花一块钱买到才牛B，有本事就来试试吧！',
            bdUrl: ShareUrl,
            bdPic: '<?php echo e(url('foreground')); ?>/img/logo.png',
        },
        share: {}
    };
    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];

	$('.confirmGood').click(function(){
		var id=$(this).data('id');
		$.post('/user/confirmGood',{'id':id,'_token':"<?php echo e(csrf_token()); ?>"},function(data){
			data=eval('('+data+')');
			if(data.code>0)
			{
				layer.msg(data.msg);
				location.reload();
			}
			else
			{
				layer.msg(data.msg);
			}
		})
		
	})

    var index=0;
    showwindow(isshow);
    function showwindow(isshow){
        if(isshow == 1){
         index = layer.open({
                type: 1,
                title: '升级为渠道用户',
                area: ['434px', '290px'], //宽高
                content: $("#show"),
            });
        }else if(isshow == 2){
          index = layer.open({
                type: 1,
                title: '升级为渠道用户',
                area: ['434px', '290px'], //宽高
                content: $("#show1"),
            });
        }
    }
    function closewindow(){
        layer.close(index);
    }
    function levelUp(){
        $.post("<?php echo e(url('/user/levelup')); ?>",{'_token':"<?php echo e(csrf_token()); ?>"},function(data){
            if(data==null){
               layer.msg('服务端错误');
            }
            if (data.status == 1){
                closewindow();
                layer.msg(data.msg);
            }
            if (data.status == 0){
                layer.msg(data.msg);
            }
        },'json');
    }

	$(".item02 img").mouseenter(function(){
		$(".kld_tip").show();
	})
	$(".item02").mouseleave(function(){
		$(".kld_tip").hide();
	})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('foreground.user_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
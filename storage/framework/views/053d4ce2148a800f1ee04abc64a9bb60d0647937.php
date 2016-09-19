
<?php $__env->startSection('canonical'); ?>
<link rel='canonical' href="http://www.ts1kg.com/prod/<?php echo e($data['goods']['belongs_to_goods']['id']); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/new_join.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/page.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="yg-positioncont" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="/index">首页</a> <span class="sep">&gt;</span> <a href="/category">全部商品</a> <span class="sep">&gt;</span> <span class="w_accord">商品详情</span>
    </div>
    <div class="w_con" id="goods_details" style="display: block;">
        <div class="w_details_left">

            <div class="ng-pastpronav">
                <h2 class="pastnav-h2tit">商品期数回顾</h2>
                <a class="pastnav-close" href="javascript:void(0)"></a>
                <div class="pastnav-main clearfix">
                    <ul>
                        <?php foreach($data['goods_periods'] as $val): ?>
                            <?php if($val['id']==$data['goods']['id']): ?>
                                <li><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期进行中...</a></li>
                            <?php elseif($val['periods']==$data['goods_latest']['periods']): ?>
                                <li class="curr"><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期</a></li>
                            <?php else: ?>
                                <li><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期</a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="w_all_nper">
                <?php if($data['goods']['id']==$data['goods_latest']['id']): ?>
                <a class="w_nper_color" href="/product/<?php echo e($data['goods_latest']['id']); ?>">第<?php echo e($data['goods_latest']['periods']); ?>期进行</a>
                <?php else: ?>
                <a href="/product/<?php echo e($data['goods_latest']['id']); ?>">第<?php echo e($data['goods_latest']['periods']); ?>期进行</a>
                <?php endif; ?>
                <?php if(!empty($data['beforelottery'])): ?>
                        <?php if( $data['goods_latest']['periods']>($data['beforelottery'][0]->periods+1)): ?>
                            <a href="javascript:void(0)">...</a>
                        <?php endif; ?>
                    <?php foreach($data['beforelottery'] as $key=>$val): ?>
                        <?php if($data['goods_latest']['id'] !=$val->id): ?>
                        <?php if($data['goods']['periods']==$val->periods): ?>
                            <a class="w_nper_color" href="/product/<?php echo e($val->id); ?>">第<?php echo e($val->periods); ?>期</a>
                        <?php else: ?>
                            <a href="/product/<?php echo e($val->id); ?>">第<?php echo e($val->periods); ?>期</a>
                        <?php endif; ?>
                            <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <span class="w_all_more">查看更多&gt;&gt;</span>
            </div>
            <div class="w_details_top clearfix">
                <div class="w_details_choose" style="position:relative;">
                    <div class="w_big_img">
                        <div class="wb_bigimg"><img class="bigimg_src" onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/product-loading4.png';"
                                                    src="<?php echo e(!empty($data['goods']['belongs_to_goods']['picarr'] ['0'])?$data['goods']['belongs_to_goods']['picarr'] ['0']:''); ?>"/>
                        </div>
                    </div>
                    <ul class="w_small_img">
                        <i class='w_modified'></i>
                        <?php foreach($data['goods']['belongs_to_goods']['picarr'] as $key=>$val): ?>
                            <?php if($key==0): ?>
                                <li class="w_small_li w_small_color" date-img="<?php echo e($key); ?>"><img onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/product-loading.png';" src="<?php echo e($val); ?>"/></li>
                            <?php else: ?>
                                <li class="w_small_li" date-img="<?php echo e($key); ?>"><img onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/product-loading.png';" src="<?php echo e($val); ?>"/></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="w_details_text" style="position:relative;">
                    <div class="zhengchang">
                        <!-- 正常购买 -->
                        <p id="zc_title">
                            （第<span id='cart_period'><?php echo e($data['goods']['periods']); ?>期）<strong>
                                    <c id='cart_title'><?php echo e($data['goods']['belongs_to_goods']['title']); ?></c></span></strong><i
                                    style='color:'></i>
                        </p>
                        <input type="hidden" value="" id="cart_priceArea"/>
                        <b>价值：￥<span id="cart_priceTotal"><?php echo e($data['goods']['belongs_to_goods']['money']); ?></span></b>
                        <div class="w_line"><span id="zc_line" style="width:<?php echo e(round($data['goods']['participate_person']/$data['goods']['total_person'],2)*100); ?>%"></span></div>
                        <ul class="w_number">
                            <li class="w_amount w_amount_one"
                                id="cart_priceSell"><?php echo e($data['goods']['participate_person']); ?></li>
                            <li class="w_amount" id="cart_need"><?php echo e($data['goods']['total_person']); ?></li>
                            <li class="w_amount  w_amount_two w_amount_val"
                                id="cart_surplus"><?php echo e($data['goods']['total_person']-$data['goods']['participate_person']); ?></li>
                            <li class="w_amount_one">已参与</li>
                            <li>总需人次</li>
                            <li class="w_amount_two">剩余人次</li>
                        </ul>
                        <div class="w_cumulative w_cumulative_another clearfix">
                            <strong>购买：</strong>
                            <div class="count">
                                <div class="w_one_newss"><span class="reduce">-</span><input width="70px"
                                                                                             class="count-input buytimes"
                                                                                             id="input_addcart"
                                                                                             type="text" maxlength="5"
                                                                                             value="1"
                                                                                             onkeyup="this.value=this.value.replace(/\D/g,'')"
                                                                                             onafterpaste="this.value=this.value.replace(/\D/g,'')"><span
                                            class="add">+</span></div>
                            </div>
                            <div class="count tails" data-id="<?php echo e($data['goods']['belongs_to_goods']['id']); ?>" style="height:25px;width:50px;border:1px solid red;border-radius: 5px;text-align: center;font-size:14px;color:red;padding-top:3px;cursor:pointer">包尾</div>
                        </div>
                        <dl class="w_rob w_rob_another y_rob_another" style="margin-bottom:24px;">
                            <dd><a id="iWantyg" class="w_slip" data-gid="<?php echo e($data['goods']['belongs_to_goods']['id']); ?>"
                                  href="javascript:void(0)" onclick="javascript:void(0)" >立即一块购</a></dd>
                            <dd class="w_slip_out">
                                <a class="w_slip_in" href="javascript:void(0)"
                                   id="<?php echo e($data['goods']['belongs_to_goods']['id']); ?>">加入购物车</a>
                            </dd>
                            <div class="w_clear"></div>
                        </dl>
                    </div>
                    <ul class="w_security">
                        <li class="w_security_one">公平公正公开</li>
                        <li class="w_security_two">品质保障</li>
                        <li class="w_security_three">全国免运费（港澳除外）</li>
                        <li class="w_security_four">权益保障</li>
                        <div class="w_clear"></div>
                    </ul>

                    <div class="w_winner_bg">
                        <?php if(!empty($userid)): ?>

                            <?php if(!empty($data['userbuywithid'])): ?>
                                <div class="winer_buyover">
                                    <b class="buyover_tit">您本期一块购幸运码为：</b>
                                    <?php if(!empty($data['buyno'])): ?>
                                        <?php foreach($data['buyno'] as $key=>$val): ?>
                                            <?php if($key<7): ?>
                                                <span class="buyover_number"><?php echo e($val); ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <a href="javascript:void(0)" class="buyover_more_a">查看更多 ></a>
                                </div>
                            <?php else: ?>
                                <span class="winer_nobuy_txt">您还没有参加本次购买哦！</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="w_not_logged">请您<a href="/login" id="login">登录</a>，查看您的幸运码！</span>
                        <?php endif; ?>
                    </div>
					<div class="bdsharebuttonbox">
						<a href="#" class="bds_more" data-cmd="more"></a>
						<a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
						<a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
						<a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a>
						<a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
						<a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>
				    </div>
		<script>
					window._bd_share_config={
						"common":{
							"bdSnsKey":{},
							"bdText":"",
							"bdMini":"2",
							"bdMiniList":false,
							"bdPic":"",
							"bdStyle":"0",
							"bdSize":"16"
							},
							"share":{}};
							with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
							</script>
                </div>
            </div>
        </div>
        <!--揭晓前-->
        <div class="w_details_right" style="position:relative;">
            <h3 id="purchase_history"><a href="javascript:void(0);">最新众筹记录</a></h3>
            <h3 id="my_history" style="color:#9EA1A8"><a href="javascript:void(0);">我的众筹记录</a></h3>
            <ul class="w_period">
                <?php foreach($data['allbuy'] as $key=>$val): ?>
                    <li>
                        <a href="/him/<?php echo e($val['usr_id']); ?>"><img class="w_period_userImg" src="<?php if(isset($val['user_photo'])): ?><?php echo e($val['user_photo']); ?><?php else: ?> <?php echo e($url_prefix); ?>img/nodata/tx-loading.png <?php endif; ?>" onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/tx-loading.png';"></a>
                        <a href="/him/<?php echo e($val['usr_id']); ?>" title="<?php if(isset($val['nickname'])): ?><?php echo e($val['nickname']); ?><?php endif; ?>"><?php if(isset($val['nickname'])): ?><?php echo e($val['nickname']); ?><?php else: ?><?php echo e(config('global.default_nickname')); ?><?php endif; ?></a>
                        <span  class="w_period_countNum"><?php echo e($val['buycount']); ?>人次</span>
                    </li>
                <?php endforeach; ?>
                <?php if(isset($data['buytotal'])): ?>
                <li>
                    <a href="javascript:void(0);" class="view_ALL">查看全部</a>
                </li>
                <?php endif; ?>
            </ul>
			<ul class="w_period2" style="display:none">
                <?php if(!empty($userid)): ?>
                    <?php if(empty($data['buybid'])): ?>
                        <div class="winer_nobuy"><span class="winer_nobuy_txt">您还没有参加本次购买哦！</span></div>
                    <?php else: ?>    
                        <?php foreach($data['buybid'] as $val): ?>
                        <li>
                            <a><img class="w_period_userImg" src="<?php echo e($data['userinfo']['user_photo']); ?>" onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/tx-loading.png';"></a>
                            <a href="javascript:void(0);" title="<?php echo e($data['userinfo']['nickname']); ?>"><?php echo e($data['userinfo']['nickname']); ?></a>
                             <span class="w_period_countNum"><?php echo e($val['buycount']); ?>人次</span>
                        </li> 
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="no-login-wrapper">
                        <div class="gth-icon transparent-png"></div>
                        <p class="ng-see-mycord">请您<a id="a_login" href="/login">登录</a>查看幸运码！</p>
                    </div>
                <?php endif; ?>

            </ul>
            <div class="w_clear"></div>
        </div>
        <!--揭晓后结束-->
        <div class="w_clear"></div>

        <!--引入商品详情页模板-->
        <?php echo $__env->make('foreground.product_tab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <!--本期幸运块乐码 start-->
        <div class="lucky_numberbox">
            <?php if(!empty($data['buyno'])): ?>
                <?php foreach($data['buyno'] as $key=>$val): ?>
                    <span class="l_number"><?php echo e($val); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <!--本期幸运块乐码 end-->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("my_js"); ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/goods.js"></script>

    <script>  
        //左侧缩略图放大效果
        $(".w_small_img .w_small_li").mouseover(function () {
            var j = $(this).attr("date-img");
            $(this).addClass("w_small_color").siblings(".w_small_li").removeClass("w_small_color");
            <?php foreach($data['goods']['belongs_to_goods']['picarr'] as $key=>$val): ?>
                    <?php if($key==0): ?>
            if (j == 0) {
                $(".w_modified").css("left", "28px");
                $(".bigimg_src").attr("src", "<?php echo e($data['goods']['belongs_to_goods']['picarr'][0]); ?>");
            }
                    <?php elseif($key==1): ?>
            else if (j == 1) {
                $(".w_modified").css("left", "116px");
                $(".bigimg_src").attr("src", "<?php echo e($data['goods']['belongs_to_goods']['picarr'][1]); ?>");
            }
                    <?php elseif($key==2): ?>
            else if (j == 2) {
                $(".w_modified").css("left", "206px");
                $(".bigimg_src").attr("src", "<?php echo e($data['goods']['belongs_to_goods']['picarr'][2]); ?>");
            }
                    <?php elseif($key==3): ?>
            else if (j == 3) {
                $(".w_modified").css("left", "296px");
                $(".bigimg_src").attr("src", "<?php echo e($data['goods']['belongs_to_goods']['picarr'][3]); ?>");
            }
            <?php endif; ?>
            <?php endforeach; ?>
        })
        //我的幸运码弹出窗
        $('.buyover_more_a').on('click', function () {
            layer.open({
                type: 1,
                title: '您本期一块购幸运码',
                shadeClose: true,
                area: ['410px', '300px'], //宽高
                content: $('.lucky_numberbox'),
            });
        });

        //控制添加购物车事件
        $('.reduce').click(function () {
            //修改
            var nextval = parseInt($("#input_addcart").val()) - 1;
            if (nextval >= 1)$("#input_addcart").val(nextval);

        });//减少输了1
        $(".add").click(function () {
            var count = parseInt($("#cart_surplus").text());
            var nextval = parseInt($("#input_addcart").val()) + 1;
            if (nextval <= count)if (nextval >= 1)$("#input_addcart").val(nextval);
        });
        $('#input_addcart').bind('input propertychange', function () {
            var count = parseInt($("#cart_surplus").text());
            var curval = $(this).val();
            if (curval > count) {
                $(this).val(count);
            }
            if (!curval || curval == '') {
                $(this).val(1);
            }
            if (curval && /^[1-9]*[1-9][0-9]*$/.test(curval)) {
            } else {
                $(this).val(1);
            }
        });

        $('.w_slip_in').click(function () {
            var id = $(this).attr('id');
            var count = parseInt($('#input_addcart').val());
            if (count && /^[1-9]*[1-9][0-9]*$/.test(count)) {
                addCart(id, count);
            } else {
                addCart(id, 1);
            }
        });
        $('.tails').click(function(){
            var id = $(this).attr('data-id');
            var count = parseInt($('#cart_surplus').text());
            addCart_pdt(id, count);
        })
        //立即购买
        $('#iWantyg').click(function () {
            var id = $(this).attr('data-gid');
            var count = parseInt($('#input_addcart').val());
            if (count && /^[1-9]*[1-9][0-9]*$/.test(count)) {
                addCart_pdt(id, count);
            } else {
                addCart_pdt(id, 1);
            }
        });
        function addCart_pdt(g_id, bid_cnt){
            $.ajax({
                url: '/addCart',
                type: 'post',
                dataType: 'json',
                data: {'g_id':g_id,'bid_cnt':bid_cnt,'_token':"<?php echo e(csrf_token()); ?>"},
                success: function(res){
                    if(res.status == 0){
                        //添加成功，刷新购物车信息
                        window.location.href = '/mycart';
                    }else if(res.status == -1 && res.message == '未登陆'){
                        //未登录跳转
                        window.location.href = '/login';
                    }else{
                        //添加失败
                        layer.alert(res.message, {title:false,btn:false});
                    }
                }
            })
        }
        $(".w_all_more").click(function(){
            $(".ng-pastpronav").slideDown(400);
        })
        $(".pastnav-close").click(function(){
            $(".ng-pastpronav").slideUp(400);
        })

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
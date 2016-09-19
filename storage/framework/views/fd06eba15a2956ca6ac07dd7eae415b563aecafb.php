<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>/css/my_cart.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/activity.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="act_top">
            <div class="act_content">
                <div class="send_number">
                    <div style="line-height: 75px;">已送礼物<span> 人！！！</span>
                    </div>
                    <div class="number_container">
                        <ul>
                            <li>
                                <i></i>
                                <div class="p_div"><p>9</p></div>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="people" value="<?php echo e($people); ?>"/>
        <input type="hidden" id="curgid" value=""/>
        <input type="hidden" id="curdemo" value="0"/>
        <div class="act_middle">
            <div class="middle_content">
                <div class="gift_bg_container">
                    <div class="gift_bg"></div>
                    <p>就是这么任性，全平台商品任你选！</p>
                </div>
                <div class="show_banner_container">
                    <div class="show_banner_tab">
                        <div>
                            <?php foreach($data['category'] as $key=>$val): ?>
                                    <?php if(!empty($val['goods'])): ?>
                                <i id="test" class="nodes" value="<?php echo e(count($val['goods'])); ?>"><?php echo e($val['name']); ?></i>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <a href="javascript:void(0)" id="category_more" style="display: none"> <i></i></a></div>
                        <div><input type="text" id="search_bg_input">
                            <div class="search_bg"><img src="<?php echo e($url_prefix); ?>img/search_ioc.png" alt=""></div>
                        </div>
                    </div>
                    <?php foreach($data['category'] as $key=>$val): ?>
                        <?php if(!empty($val['goods'])): ?>
                        <div id="demo<?php echo e($key); ?>" class="jcImgScroll">
                            <ul>
                                <?php if(!empty($val['goods'])): ?>
                                    <?php foreach($val['goods'] as $key2=>$val2): ?>
                                        <li><a href="/product/<?php echo e($val2->id); ?>" name="<?php if(!empty($val2->title2)): ?><?php echo e($val2->title2); ?><?php else: ?><?php echo e($val2->title); ?><?php endif; ?>" target="_blank"
                                               path="<?php echo e($val2->thumb); ?>"></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                            <div class="selected_bg"></div>
                            <div class="img_shadow_left"></div>
                            <div class="img_shadow_right"></div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <div class="send_msg_bg">
            <div class="border_top"></div>
            <div class="send_msg_content">
                <div class="gift_bg_container">
                    <div class="gift_bg02"></div>
                    <p>输入手机号码即可送出丰厚礼物一份，你送礼，我买单！</p>
                </div>
                <div class="send_msg_box">
                    <div class="send_msg_box_top"></div>
                    <div class="send_msg_box_shadow">
                    </div>
                    <div class="send_msg_text">
                        <div class="username_bg">
                            <p>您的姓名：<input type="text" name="username" maxlength="20" id="username" placeholder="" oninput="return editText();"  onpropertychange="return editText();"> 问候语：
                                <input type="button" value="类型一" id="smstmp1" class="smstmp">
                                <input type="button" value="类型二" id="smstmp2" class="smstmp"></p>
                            <input type="hidden" id='hidesmstem1' value="客官，我是???，我送了XXX给你，赶快去领取！"/>
                            <input type="hidden" id='hidesmstem2' value="亲，三生有幸与你相识，送你XXX表示一下，快来拿吧！我是???！"/>
                        </div>
                        <div class="textarea_div"><textarea  id='smstext1' class="smstext" readonly="readonly" style="resize:none;">
                             </textarea>
                        </div>
                        <div class="send_to">发送给：<input type="text"  name="phone" maxlength="11" id="number_one" placeholder=""><a
                                    id="send_add"><img
                                        src="<?php echo e($url_prefix); ?>img/add_contact.png"
                                        style="vertical-align: middle"/></a><span class="send_max_msg">最多群发5人次</span>
                        </div>
                    </div>
                </div>
                <div class="send_btn_bg">
                    <div class="send_btn_shadow"></div>
                    <div class="send_btn" id="send_one">立即发送</div>
                    <input type="hidden" id="send_api" value="<?php echo e(config('global.base_url').config('global.ajax_path.activity/sendMsg')); ?>"/>
                    <input type="hidden" id="send_pay_api" value="<?php echo e(config('global.base_url').config('global.ajax_path.activity/sendPayMessage')); ?>"/>
                </div>
                <div class="send_group_bg">
                    <ul>
                        <li><input type="text" maxlength="11" disabled/><i></i></li>
                        <li><input type="text" maxlength="11" disabled/><i></i></li>
                        <li><input type="text" maxlength="11" disabled/><i></i></li>
                        <li><input type="text" maxlength="11" disabled/><i></i></li>
                        <li><input type="text" maxlength="11" disabled/><i></i></li>
                        <li><input type="button" value="立即发送" class="group_send_btn"/></li>
                    </ul>
                </div>
            </div>
            <div class="border_bottom"></div>
        </div>
        <div class="act_bottom">
            <div class="news_head"> 
                <p>一块看<span>资讯</span></p>
                <div style="margin-top: -30px;"><img src="<?php echo e($url_prefix); ?>img/watch_news_ioc.png"></div>
            </div>

            <div class="news_box">
               <!--上 start-->
               <div class="news_box-top">
                    <div class="news_img_box">
                        <?php /*<div id="owl-demo" class="owl-carousel" style="">
                            <?php foreach($picArticles as $val): ?>
                                <a href="<?php echo e(url('news',['id'=>$val->article_id])); ?>">
                                     <img src="<?php echo e($val->img); ?>">
                                    <div class="news_bottom_bg">
                                        <span><?php if(!empty($val2->title2)): ?><?php echo e($val2->title2); ?><?php else: ?><?php echo e($val2->title); ?><?php endif; ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>*/ ?>
                        <div id="banner_tabs" class="flexslider">
                                <ul class="slides">
                                     <?php foreach($picArticles as $val): ?>
                                    <li>
                                        <a class="item"  href="<?php echo e(url('news',['id'=>$val->article_id])); ?>"style="background-image: url(<?php echo e($val->img); ?>);"></a>
                                            <div class="news_bottom_bg">
                                                <span><?php echo e($val->title); ?></span>
                                            </div>
                                    </li>
                                     <?php endforeach; ?>
                                 </ul>
                                 <ul class="flex-direction-nav">
                                    <li><a class="flex-prev" >Previous</a></li>
                                    <li><a class="flex-next" >Next</a></li>
                                </ul>
                                <ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
                                    <?php foreach($picArticles as $key=>$val): ?>
                                    <li><a><?php echo e($key+1); ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                        </div>
                    </div>
                    <div class="news_title">
                            <?php foreach($hotArticles as $val): ?>
                            <dl>
                                <dt><a href="<?php echo e(url('news',['id'=>$val->article_id])); ?>"><?php echo e($val->title); ?></a></dt>
                                <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e(str_limit($val->description,128,'。')); ?><a href="<?php echo e(url('news',['id'=>$val->article_id])); ?>">[详情]</a></dd>
                            </dl>
                            <?php endforeach; ?>

                    </div>
            </div>
            <!--上 end-->
            <!--上 end-->
            <div class="news_box-list clearfix">
                <ul>
                	<?php foreach($remainArticles as $rmat): ?>
                    <li><a href="<?php echo e(url('news',['id'=>$rmat->article_id])); ?>" title="<?php echo e($rmat->title); ?>"><?php echo e($rmat->title); ?></a><span><?php echo e(date('Y-m-d',strtotime($rmat->updated_at))); ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!--上 end-->
        </div>
    </div>


    <?php /*<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/banner.js"></script>*/ ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/owl.carousel.js"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/common.js"></script>
    <script src="<?php echo e($url_prefix); ?>js/jQuery-easing.js" language="javascript" type="text/javascript"></script>
    <script src="<?php echo e($url_prefix); ?>js/jQuery-jcImgScroll.js" language="javascript" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/NumScroll.js"></script>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/activity.js"></script>
        <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/slider.js"></script><!--轮播图 -->
    <script type="text/javascript">
$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 1800,
		event: 'hover',
		auto: true,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		bannerSlider.prev()
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next()
	});
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
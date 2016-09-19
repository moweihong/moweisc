<?php $__env->startSection('title','常见问题'); ?>
<?php $__env->startSection('content'); ?>
        <!--footnews start-->
<div class="footnews-container clearfix">
    <!--当前位置 start-->
    <div class="yg-positioncont">
        <a href="/index">首页</a><span class="sep">&gt;</span> <a href="#">帮助中心</a><span class="sep">&gt;</span><span>购物指南</span>
    </div>
    <!--当前位置 end-->
    <!--main start-->
    <div class="footnews-main clearfix">
        <!--sidebar start-->
        <div class="footnews-left">
            <!--新手指南 start-->
            <?php foreach($articleCats as $val): ?>
            <div class="fnews_box">
                <h2 class="fnews_btit"><?php echo e($val->cat_name); ?></h2>
                <ul class="fnews_btxt">
                    <?php foreach($val->articleCats as $value): ?>
                    <li><a href="<?php echo e(url('help',['id'=>$value->article_id])); ?>"><?php echo e($value->title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
        <!--sidebar end-->
        <!--content start-->
        <div class="footnews-right">
            <?php if(!empty($article)): ?>
            <h2 class="fnews-m-tit"><?php echo e($article->title); ?></h2>
            <?php endif; ?>
            <?php if(!empty($article) &&  $article->article_id == 3): ?>
                <!--常见问题 start-->
            <div class="fnews-question">
                <!--tit start-->
                <div class="fnes-quetit clearfix">
                    <?php foreach($questionCats as $key=>$val): ?>
                        <?php if($key == 0): ?>
                            <a class="fquetit-a fquetit-aon" href="javascript:void(0)" title="<?php echo e($val->cat_name); ?>" data-queshow="<?php echo e($key); ?>"><?php echo e($val->cat_name); ?></a>
                        <?php else: ?>
                            <a class="fquetit-a" href="javascript:void(0)" title="<?php echo e($val->cat_name); ?>" data-queshow="<?php echo e($key); ?>"><?php echo e($val->cat_name); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <!--tit end-->
                <!--txt start-->
                <div class="fnes-qustxt">
                    <!--选项卡1 start-->
                    <?php foreach($questionCats as $key=>$val): ?>
                        <?php if($key == 0): ?>
                            <div class="fuque_tab" style="display: block;">
                                <!--box start-->
                                <?php foreach($val->articleCats as $article_key => $article): ?>
                                <div class="uqb_box">
                                    <h2 class="uqb_btit"><span class="uqb_bico"></span><a class="uqb_btit_a" href="javascript:void(0)" title="<?php echo e($article_key++); ?>、<?php echo e($article->title); ?>"><?php echo e($article_key++); ?>、<?php echo e($article->title); ?></a></h2>
                                    <div class="uqb_btxt">
                                        <?php echo $article->content; ?>

                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <!--box end-->
                            </div>
                        <?php else: ?>
                            <div class="fuque_tab">
                                <!--box start-->
                                <?php foreach($val->articleCats as $article_key => $article): ?>
                                <div class="uqb_box">
                                    <h2 class="uqb_btit"><span class="uqb_bico"></span><a class="uqb_btit_a" href="javascript:void(0)" title="<?php echo e($article_key++); ?>、<?php echo e($article->title); ?>"><?php echo e($article_key++); ?>、<?php echo e($article->title); ?></a></h2>
                                    <div class="uqb_btxt">
                                        <?php echo $article->content; ?>

                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <!--box end-->
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!--选项卡8 end-->
                </div>
                <!--txt end-->
            </div>
            <!--常见问题 end-->
            <?php elseif(!empty($article)): ?>
                <div class="fnews-m-content">
                    <?php echo $article->content;?>
                </div>
            <?php endif; ?>
            
            
        </div>
        <!--content end-->
    </div>
    <!--main end-->
</div>
<!--footnews end-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
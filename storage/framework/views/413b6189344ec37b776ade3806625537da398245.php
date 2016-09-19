<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/c_cloud.css"/>
    <link rel="stylesheet" href="<?php echo e($url_prefix); ?>css/page.css"/>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
            <!--当前位置 start-->
    <div class="yg-positioncont" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="/index">首页</a> <span class="sep">&gt;</span> <a href="/category">全部商品</a> <span class="sep">&gt;</span>
        <span>商品详情</span>
    </div>
    <!--当前位置 end-->

    <!--揭晓后main start-->
    <div class="w_con" id="goods_during">
        <!--揭晓进行时-左侧-->
        <div class="w_during_left">
            <!--more 期数start-->
            <div class="ng-pastpronav">
                <h2 class="pastnav-h2tit">商品期数回顾</h2>
                <a class="pastnav-close" href="javascript:void(0)"></a>
                <div class="pastnav-main clearfix">
                    <ul>
                      <?php foreach($data['goods_periods'] as $val): ?>
                          <?php if($val['id']==$data['goods']['id']): ?>
                        <li><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期进行中...</a></li>
                          <?php elseif($val['periods']==$data['goods_will']['periods']): ?>
                                <li class="curr"><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期</a></li>
                          <?php else: ?>
                                <li><a href="/product/<?php echo e($val['id']); ?>">第<?php echo e($val['periods']); ?>期</a></li>
                            <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!--more 期数end-->
            <!--其他期数 start-->
            <div class="w_all_nper">
                <?php if($data['goods']['id']==$data['goods_will']['id']): ?>
                    <a class="w_nper_color" href="/product/<?php echo e($data['goods']['id']); ?>">第<?php echo e($data['goods']['periods']); ?>期进行</a>
                <?php else: ?>
                    <a href="/product/<?php echo e($data['goods']['id']); ?>">第<?php echo e($data['goods']['periods']); ?>期进行</a>
                <?php endif; ?>

                <?php if( ($data['beforelottery'][0]->periods+1)<$data['goods']['periods']): ?>
                    <a href="javascript:void(0)">...</a>
                <?php endif; ?>
                <?php if(!empty($data['beforelottery'])): ?>
                    <?php foreach($data['beforelottery'] as $key=>$val): ?>
                        <?php if($val->id !=$data['goods']['id']): ?>
                        <?php if($data['goods_will']['periods']==$val->periods): ?>
                            <a class="w_nper_color" href="/product/<?php echo e($val->id); ?>">第<?php echo e($val->periods); ?>期</a>
                        <?php else: ?>
                            <a href="/product/<?php echo e($val->id); ?>">第<?php echo e($val->periods); ?>期</a>
                        <?php endif; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
                <span class="w_all_more">查看更多&gt;&gt;</span>
            </div>
            <!--其他期数 end-->
            <div class="w_during_graphic">
                <div class="w_during_figure" style="position:relative;">
                    <img id="publishImg" src="<?php echo e($data['goods_will']['belongs_to_goods']['thumb']); ?>"/>
                    <!--S 2015-10-17 添加 -->
                    <div class="c_sold_out" style="display: none" id="goodsDown">
                        <img src="../static/img/front/goods/sold.png"/>
                    </div>
                    <!--E 2015-10-17 添加 -->
                </div>
                <div class="w_during_wen" style="position:relative;">
                    <h1 id="publishTitle">(第<?php echo e($data['goods_will']['periods']); ?>

                        期)<?php echo e($data['goods_will']['belongs_to_goods']['title']); ?></h1>
                    <div class="w_add_doing" id="publishWinCode">
                        <p class="w_add_doing_noleft">揭晓结果<b>幸运码</b></p>
                        <div class="w_addBg_other"><p class="w_results"><?php echo e($data['goods_will']['lottery_code']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="w_clear"></div>
            </div>
            <div class="w_during_winner" style="position:relative;">
                <!--揭晓后状态 start-->
                <?php if($fetchuser): ?>
                <div class="w_winner_left2">
                    <div class="w_winner_figure"><a href="/him/<?php echo e($fetchuser[0]['usr_id']); ?>"><img id="publishWinUserIcon"
                                                      src="<?php echo e($fetchuser[0]['user_photo']); ?>"/></a></div>
                    <dl class="w_winner_wen">
                        <dd class="w_red" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">恭喜<span
                                    id="publishWinUser"><a href="/him/<?php echo e($fetchuser[0]['usr_id']); ?>"><?php echo e($fetchuser[0]['nickname']); ?></a></span> 获得了本期商品
                        </dd>
                        <dd>本期购买：<i id="publishWinBuyTimes"><?php echo e(count($data['buynolucky'])); ?></i>人次 <a id="lookYgCode" href="javascript:void(0)"
                                                                       class="w_other_ren" onclick="">点击查看</a></dd>
                        <dd id="publishWinTime">揭晓时间：<?php echo e($fetchuser[0]['kaijiang_time']); ?></dd>
                        <dd id="publishBuyTime">购买时间：<?php echo e($fetchuser[0]['bid_time']); ?></dd>
                    </dl>
                </div>
                <?php endif; ?>
                <!--揭晓后状态 end-->
                <dl class="w_winner_right" id="userBuyCodes">
                    <?php if($usr_id>0): ?>
                        <?php if(!empty($data['userbuywithid'])): ?>
                            <div class="w_winner_lucky">
                                <?php if(!empty($data['buyno'])): ?>
                                    <i>您本期一块购<?php if(!empty($fetchuser[0]['usr_id'])&&$fetchuser[0]['usr_id']==$usr_id): ?>幸运码<?php else: ?>块乐码<?php endif; ?>为：</i>
                                    <?php foreach($data['buyno'] as $key=>$val): ?>
                                        <?php if($key<7): ?>
                                            <i class="winer_lucknumber"><?php echo e($val); ?></i>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <a href="javascript:void(0)" class="buyover_more_a">查看更多 &gt;</a>
                            </div>

                        <?php else: ?>
                            <div class="winer_nobuy" style="margin-top:30px"><span class="winer_nobuy_txt">您还没有参加本次购买哦！</span></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="w_not_logged" style="display: block; margin-top: 13px"><a href="/login" id="login">请登录</a>，查看你的幸运码！</span>
                    <?php endif; ?>

                </dl>
            </div>

            <div class="w_big_text_box">
                <div class="w_big_text" style="display: none">
                    <h3>我们有严谨的幸运号码计算规则，保证公平公正公开</h3>
                    <p class="w_add_line">为什么会进行倒计时？</p>
                </div>
                <ul class="w_calculate">
                    <p>计算公式</p>
                    <ul class="w_calculate_in">
                        <li class="w_details_first"><em id="publishWinCodeCalculate"><?php echo e($data['goods_will']['lottery_code']); ?></em><span>本期幸运号码</span>
                        </li>
                        <li class="w_details_second " onmouseenter="Times100Enter()" onmouseleave="Times100Leave()"><em
                                    id="ygRecord100"><?php echo e($data['total_time']); ?></em><span>100个时间求和</span>
                            <div class="w_two_con">
                                <i></i>
                                <p class="w_two_text">奖品的最后一个号码分配完毕，公示该分配时间点前本站全部奖品的<strong>最后100个参与时间</strong>，并求和。</p>
                            </div>
                        </li>
                        <li class="w_details_fourth"><em id="publishTotalPrice"><?php echo e($data['goods_will']['total_person']); ?></em><span>该奖品总需人次</span></li>
                        <li class="w_details_fifth"><em>100000001</em><span>原始数</span></li>
                    </ul>
                </ul>
            </div>
        </div>
        <!--揭晓进行时-右侧-->
        <div class="w_during_right">
            <h3>最新一期</h3>
            <p>最新一期正在进行，赶紧参加吧！</p>
            <div class="w_latest_right1" style="position:relative;">
                <div class="w_rightImg"><a href='/product/<?php echo e($data['goods']['id']); ?>' class="w_goods_img" id="cartImg" /><img src="<?php echo e($data['goods']['belongs_to_goods']['thumb']); ?>"/></a>
                </div>
                <a class="w_goods_ddree" href="/product/<?php echo e($data['goods']['id']); ?>">(第<?php echo e($data['goods']['periods']); ?>

                    期)<?php echo e($data['goods']['belongs_to_goods']['title']); ?></a>
                <b id="onlineSubTitle"></b><em
                        id="onlinePriceTotal">价值：￥<?php echo e($data['goods']['belongs_to_goods']['money']); ?></em>
                <div class="w_line"><span id="onlinLine" style="width:<?php echo e(round($data['goods']['participate_person']/$data['goods']['total_person'],2)*100); ?>%"></span></div>
                <ul class="w_number">
                    <li class="w_amount" id="onlinePriceSell"><?php echo e($data['goods']['participate_person']); ?></li>
                    <li class="w_amount w_amount_right"
                        id="onlineSurplus"><?php echo e($data['goods']['total_person']-$data['goods']['participate_person']); ?></li>
                    <li>已购买人次</li>
                    <li class="w_amount_right">剩余人次</li>
                </ul>
            </div>
            <div class="w_cumulative clearfix">
                <strong>参与人次：</strong>
                <div class="count">
                    <div class="w_one_new">
                        <span class="reduce">-</span>
                        <input width="70px" class="count-input buytimes" id="input_addcart" type="text" maxlength="5" value="1"
                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                               onafterpaste="this.value=this.value.replace(/\D/g,'')"><span class="add">+</span>
                    </div>
                </div>
            </div>
            <div class="w_buy"><a id="buybuybuy" href="javascript:void(0)"  data-gid=<?php echo e($data['goods']['belongs_to_goods']['id']); ?> onclick="javascript:void(0)">立即抢购</a></div>
        </div>
        <div class="w_clear"></div>
        <!--选项卡-->
        <?php echo $__env->make('foreground.product_tab2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--人气商品-->
        <div class="c_popular_recommend">
            <h4 class="c_popular_title">人气商品</h4>
            <div class="c_pop_shop">
                <ul class="c_pop_list" id="goodsList">
                    <?php foreach( $data['hot'] as $k=>$v): ?>
                    <li>
                        <span class="span"><img height="210px" width="204px" id="goodsImg_0"
                                                src="<?php echo e($v['belongs_to_goods']['thumb']); ?>"></span>
                        <b title="<?php echo e($v['belongs_to_goods']['title']); ?>"><?php echo e($v['belongs_to_goods']['title']); ?></b>
                        <i>剩余<em><?php echo e($v['total_person']-$v['participate_person']); ?></em>人次</i>
                        <div class="c_pop_hover" style="display: none;">
                            <div class="c_pop_bj"></div>
                            <div class="c_divide_btn"><a href="javascript:;" class="c_add_cart" onclick="addCart(<?php echo e($v['belongs_to_goods']['id']); ?>,1)">加入购物车</a>
                                <a href="/product/<?php echo e($v['id']); ?>" class="c_know_detail">查看详情</a>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="c_pop_btn c_pop_left" style="display: none;"><i></i></div>
                <div class="c_pop_btn c_pop_right" style="display: none;"><i></i></div>
            </div>
        </div>
    </div>
    <!--揭晓后main end-->

    <!--本期幸运块乐码 start-->
    <div class="lucky_numberbox">
        <?php if(!empty($data['buyno'])): ?>
            <?php foreach($data['buyno'] as $key=>$val): ?>
                <span class="l_number"><?php echo e($val); ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!--本期幸运块乐码 end-->

    <!--本期幸运块乐码 start-->
    <div class="luckymen_numberbox" style="display:none">
        <?php if(!empty($data['buynolucky'])): ?>
            <?php foreach($data['buynolucky'] as $key=>$val): ?>
                <span class="l_number"><?php echo e($val); ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!--本期幸运块乐码 end-->

<?php $__env->stopSection(); ?>
<?php $__env->startSection("my_js"); ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/goods.js"></script>
    <script>
        $(function(){
            $(".w_all_more").click(function(){
                $(".ng-pastpronav").slideDown(400);
            })
            $(".pastnav-close").click(function(){
                $(".ng-pastpronav").slideUp(400);
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
           //购买记录幸运码弹出窗
           $('#lookYgCode').on('click', function () {
                layer.open({
                    type: 1,
                    title: '获奖者购买码',
                    shadeClose: true,
                    area: ['410px', '300px'], //宽高
                    content: $('.luckymen_numberbox'),
                });
            });
        })
        $("#buybuybuy").click(function(){
            var id = $(this).attr('data-gid');
            var count=parseInt($('#input_addcart').val());//获取所能购买的最大值
            if (count && /^[1-9]*[1-9][0-9]*$/.test(count)) {
                addCart_pdt(id, count);
            } else {
                addCart_pdt(id, 1);
            }

        });


        //控制添加购物车事件
        $('.reduce').click(function () {
            //修改
            var nextval = parseInt($("#input_addcart").val()) - 1;
            if (nextval >= 1)$("#input_addcart").val(nextval);

        });//减少输了1
        $(".add").click(function () {
            var count = parseInt($("#onlineSurplus").text());
            var nextval = parseInt($("#input_addcart").val()) + 1;
            if (nextval <= count)if (nextval >= 1)$("#input_addcart").val(nextval);
        });

        $('#input_addcart').bind('input propertychange', function () {
            var count = parseInt($("#onlineSurplus").text());
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
                    }else if(res.status == ''){
                        //未登录跳转
                        window.location.href = '/login';
                    }else{
                        //添加失败
                        layer.alert(res.message, {title:false,btn:false});
                    }
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
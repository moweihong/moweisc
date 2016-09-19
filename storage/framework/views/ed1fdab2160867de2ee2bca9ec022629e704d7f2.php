<div class="w_details_bottom">
    <!--最新上架-->

    <!--奖品详情-->
    <div class="w_calculate_results pgp">
        <div class="w_calculate_tabtit">
            <dl class="w_calculate_nav tabtit">
                <dd class="tabtita tabtita-on" id="goods_info" data-divshow="0">计算结果<i class="line"></i></dd>
                <dd class="tabtita" data-divshow="1" id="buy_record">所有参与记录<i class="line"></i></dd>
                <dd class="tabtita" data-divshow="2" id="show_record">晒单<i class="line"></i></dd>
            </dl>
        </div>
        <div class="ng-data-inner tabcon-box" style="display: block;">
            <div id="div_evaldata" class="ng-data-inner">
                <div class="ng-data-info">
                    <div class="ng-data-head">
                        <span class="time">众筹时间</span>
                        <span class="data">转换数据</span>
                        <span class="user">会员</span>
                        <span class="num">参与人次</span>
                        <span class="product">商品名称</span>
                    </div>
                </div>
                <div class="ng-data-detail">
                    <div class="ng-data-step">
                        <p class="title">截止该商品最后购买时间【<?php echo e($data['lasttime']); ?>】网站所有商品的最后100条购买时间(时、分、秒、毫秒)记录</p>
                        <div class="step">
                            <ul class="step-inner clearfix">
                                <li class="s-r1">
                                    <p>计算结果</p>
                                </li>
                                <li class="s-t">=</li>
                                <li class="s-t">(</li>
                                <li class="s-r2"><p><?php echo e($data['total_time']); ?></p><span>以下100条时间取值之和</span></li>
                                <li id="li_mod" class="s-t mod"><i>%</i><span class="txt">(取余)</span></li>
                                <li class="s-r3"><p><?php echo e($data['goods_will']['total_person']); ?></p><span>总需参与人次</span></li>
                                <li class="s-t">)</li>
                                <li class="s-t">+</li>
                                <li class="s-r4"><p>100000001</p><span>固定数值</span></li>
                                <li class="s-t">=</li>
                                <li class="s-r5"><p><?php echo e($data['goods_will']['lottery_code']); ?></p><span>最终计算结果</span></li>
                            </ul>
                            <div class="ng-result-bg equals transparent-png"></div>
                        </div>
                    </div>
                    <div class="ng-table-wrapper">
                        <div id="div_nginner" class="ng-table-inner">
                            <ul class="ng-table-ul clearfix">
                                <?php foreach($data['buyrecord'] as $kc=>$vc): ?>
                                    <?php if($kc<100): ?>
                                        <li>
                                            <span class="time"><b><?php echo e($vc['lottery_time1']); ?></b><?php echo e($vc['lottery_time2']); ?></span>
                                            <span class="code"><?php echo e($vc['lottery_time3']); ?></span>
                                    <span class="name"><a target="_blank"><?php if(isset($vc['nickname'])): ?><?php echo e($vc['nickname']); ?><?php else: ?><?php echo e(config('global.default_nickname')); ?><?php endif; ?></a></span>
                                            <span class="num"><?php echo e($vc['buycount']); ?>人次</span>
                                    <span class="pro"><a href="/product/<?php echo e($vc['o_id']); ?>"
                                                         target="_blank">(第<?php echo e($vc['g_periods']); ?>

                                            期)<?php echo e($vc['g_name']); ?></a></span>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <div class="ng-table-bg01 transparent-png"></div>
                            <div class="ng-table-bg02 transparent-png"></div>
                            <div class="ng-table-bg03 ng-result-bg transparent-png"></div>
                        </div>
                        <div id="div_showmore" class="ng-see-more">
                            <span>展开全部100条数据<b><s></s></b></span>
                        </div>
                    </div>
                </div>
                <ul class="ng-table-ul ng-tc-ul">
                    <?php foreach($data['buyrecord'] as $k=>$v): ?>
                        <?php if($k>99): ?>
                            <li>
                                <span class="time"><b><?php echo e($v['lottery_time1']); ?></b><?php echo e($v['lottery_time2']); ?></span>
                                <span class="code"></span><span class="name"><a href=""
                                                                                target="_blank"><?php if(isset($vc['nickname'])): ?><?php echo e($vc['nickname']); ?><?php else: ?><?php echo e(config('global.default_nickname')); ?><?php endif; ?></a></span>
                                <span class="num">1人次</span>
                        <span class="pro"><a href="/product/<?php echo e($data['goods_will']['id']); ?>" target="_blank">(第<?php echo e($data['goods_will']['periods']); ?>

                                期)<?php echo e($data['goods_will']['belongs_to_goods']['title']); ?></a></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
        <!--所有参与记录-->
        <div class="w_prize_con c_newest_prize_con tabcon-box" id="product_buyrecord">
            <div class="w_clear"></div>
            <table class="w_yun_con" cellspacing="0" cellpadding="0">
                <tbody id="tbody_record">
                <tr>
                    <th>时间</th>
                    <th>昵称</th>
                    <th>参与人次</th>
                    <th>IP</th>
                    <th>来源</th>
                </tr>
                </tbody>
            </table>
            <!-- 分页 -->
            <div id="pro_page1"></div>
            <div class="w-msgbox m-detail-codesDetail" id="pro-view-9" style="z-index:10000;">
                <a data-pro="close" href="javascript:void(0);" class="w-msgbox-close"></a>
                <div class="w-msgbox-hd" data-pro="header">
                    <h3></h3>
                </div>
                <div class="w-msgbox-bd" data-pro="entry">
                    <div class="m-detail-codesDetail-bd">
                        <div class="m-detail-codesDetail-wrap">
                            <dl class="m-detail-codesDetail-list f-clear">
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--晒单-->
        <div class="w_prize_con  c_newest_prize tabcon-box" id="product_show">

            <div id="pro_page2"></div>

        </div>

    </div>
    <div class="w_clear"></div>
</div>

<input type="hidden" value="<?php echo e($id); ?>" id="product_id"/>
<input type="hidden" value="<?php echo e(config('global.base_url').config('global.ajax_path.product_buyrecord')); ?>"
       id="recordpath"/>
<input type="hidden" value="<?php echo e(config('global.base_url').config('global.ajax_path.product_showrecord')); ?>" id="showpath"/>

<input type="hidden" id="curpage_show" value="1"/>
<input type="hidden" id="curpage_show_total" value="0"/>
<input type="hidden" id="curpage_show_totalpage" value="0"/>
<input type="hidden" id="curpage_show_pagesize" value="0"/>
<input type="hidden" id="curpage_show_isload" value="0"/>


<input type="hidden" id="curpage_record" value="1"/>
<input type="hidden" id="curpage_total" value="0"/>
<input type="hidden" id="curpage_totalpage" value="0"/>
<input type="hidden" id="curpage_pagesize" value="0"/>
<input type="hidden" id="curpage_isload" value="0"/>

<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/product.js"></script>
<script>
	$(function(){
			//商品详情计算结果收起和结束数据不够的情况
	if($('.ng-table-ul li').size() <=8 ){
		$('#div_nginner').css('height','auto');
	}else{
		$('#div_nginner').css('height','');
	}
		
	})
</script>

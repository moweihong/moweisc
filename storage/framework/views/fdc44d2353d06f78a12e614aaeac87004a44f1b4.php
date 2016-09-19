<?php /*继承master模板*/ ?>


<?php $__env->startSection('title', '首页'); ?>
<?php /*重写内容*/ ?>
<?php $__env->startSection('my_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($url_prefix); ?>css/owl.carousel.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <style>
		.m-ser{width: 237px;}
        .item {width: 100%;height: 400px;background-position: 50% 0;}

		.share_detail_ct{width: 1180px;border: 1px solid #DEDEDE;padding: 40px;margin: 0 auto;margin-bottom: 120px;margin-top: 10px;}
		.share_detail_ct h1{font-size: 22px;line-height: 64px;color: #666666;font-weight: bold;    padding-left: 36px;}
		.winner_info{width: 1184px;height: 159px;border-bottom: 1px dashed #DEDEDE;border-top: 1px dashed #DEDEDE;font-size: 14px;position: relative;    padding-top: 7px;margin: 0 auto;}
		.winner_info_left{width: 140px;float: left;    padding-top: 47px;}
		.winner_info_left img{width:80px;height:80px;border-radius:50% ;}
		.winner_info_right{width: 518px;float: left;}
		.winner_info_right span{color: #ff0000;}
		.winner_info_right p{line-height: 30px;}
		.lj_btn input{font-size: 16px;  width: 122px;height: 40px; background: #ff0000; line-height: 40px;color: white; border-radius: 5px; position: absolute;top: 107px;  left: 531px;border: none;}
		.share_detail{font-size: 16px;line-height: 30px;color: #666666;padding: 46px 0;}
		.share_detail p{text-indent: 30px;}
		.share_imgs {width: 1107px;margin: 0 auto;}
		.share_imgs img{width: 500px;height: 500px;margin: 25px;}
		.winner_info_right label{font-size: 14px;}
		.share-item{width: 303px;height: 504px;    border: 1px solid #DEDEDE; padding-top: 10px;float: left;}
		.share-item .inner-item01 img{width: 278px;height: 342px;}
		.share-item .inner-item01 {text-align: center;}
		.share-item .inner-item02{width: 278px;margin: 0 auto;}
		.share-item .inner-item02 img{width: 50px;height: 50px;border-radius:50%;}
		.share-item .user-nickname{font-size: 14px;line-height: 64px;color: #2E93E1;margin-left: 10px;vertical-align: top;}
		.share-item .inner-item02 .timestr{float: right;color: #999999;font-size: 12px;line-height: 64px; margin: 0 auto;}
		.share-item .inner-item03{width: 253px;height: 55px;background: url(<?php echo e($url_prefix); ?>img/share_ioc01.png) no-repeat;font-size: 14px;line-height: 20px;color: #999999;padding: 20px 25px;}
		
		.share-item01{width:293px;height: 246px;    border: 1px solid #DEDEDE; padding-top: 10px;float: left;}
		.share-item01 .inner-item01 img{width: 278px;height: 178px;}
		.share-item01 .inner-item01 {text-align: center;}
		.share-item01 .inner-item02{width: 278px;margin: 0 auto;}
		.share-item01 .inner-item02 img{width: 50px;height: 50px;border-radius:50%;    margin-top: 3px;}
		.share-item01 .user-nickname{font-size: 14px;color: #2E93E1;}
		.share-item01 .inner-item02 .timestr{float: right;color: #999999;font-size: 12px;    margin-top: 3px;}
		.share-item01 .inner-item02 div{    width: 217px; float: right;padding-left: 10px;}
		.share-item01 .inner-item02 div p,.inner-item03 p{line-height: 20px;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;    overflow: hidden;}
		.share-ct-item{width:1194px;}

    </style>
    </head>
    <body onselectstart='return false'>
    <script>
        var userMId = '';
    </script>
    <span id="index" style="display:none">index</span>
    <!-- banner   start -->
    <input type="hidden" value="<?php echo e(session('isout')); ?>" id="isout"/>
    <div id="banner_tabs" class="flexslider">
    	<ul class="slides">
        <?php foreach( $data['slide']  as $key=>$val): ?>
            <?php if(!empty($val['img'])): ?>
            <li>
                <a href="<?php echo e($val['link']); ?>" <?php if($val->show_type == 1): ?> target="_blank" <?php endif; ?> class="item" style="background-image:url(<?php echo e($val['img']); ?>)"></a>
				
		</li>
                <?php /*<a href="<?php echo e($val['link']); ?>" class="item" style="background-image:url(<?php echo e($val['img']); ?>)"></a>*/ ?>
            <?php endif; ?>
        <?php endforeach; ?>
       </ul>
       <ul class="flex-direction-nav">
		<li><a class="flex-prev" >Previous</a></li>
		<li><a class="flex-next" >Next</a></li>
	</ul>
	<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
     <?php foreach( $data['slide']  as $key=>$val): ?>
        <?php if(!empty($val['img'])): ?>
        <li><a><?php echo e($key+1); ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
	</ol>
    </div>
    <!-- banner end -->
    <!-- 最新动态 start -->
    <div class="ind-notice">
        <div class="width1210 ind-notcentent clearfix" id="scroll-notice">
            <span class="i-notice-tit"><i class="i-notice-ico"></i>最新动态：</span>
        </div>
    </div>
    <!-- 最新动态 end -->
    <div class="g-wrap w1190">
        <!--最新揭晓-->
        <div class="g-title">
            <h3 class="fl"><i></i>最新揭晓<span>截至目前共揭晓商品<em><a id="em_lotcount" >0</a></em>个</span></h3>
			<div class="m-other fr"><a href="./announcement" target="_blank" class="u-more">更多</a></div>
        </div>
        <div class="g-list">
            <ul id="ul_Lottery" class="clearfix">

            </ul>
        </div>

        <!--热门推荐-->
        <div class="g-title">
            <h3 class="fl"><i></i>即将揭晓</h3>
            <div class="m-other fr"><a href="./category" target="_blank" title="更多" class="u-more">更多</a></div>
        </div>
        <div class="g-hot clrfix">

            <div class="g-hotR fr">
                <div class="u-are">最新购买记录</div>
                <div class="g-zzyging">
                    <input name="hidBuyID" type="hidden" id="hidBuyID" value="0"/>
                    <ul id="UserBuyNewList">


                    </ul>
                </div>
                <div class="u-see100"><a href="./getLatestRecord" target="_blank">查看最新100条记录</a></div>
            </div>
        </div>
        <!--全部商品-->
        <div class="g-title">
            <h3 class="fl"><i></i>全部商品</h3>
            <div class="m-other fr">
                <a href="/category" target="_blank" title="更多" class="u-more">更多</a>
            </div>
        </div>
        <div class="announced-soon clrfix" id="divSoonGoodsList">

        </div>
        <div class="check-out"><a href="/category" target="_blank" title="查看所有商品">查看所有商品</a></div>
        <!--新品上架-->
        <div class="g-title">
            <h3 class="fl"><i></i>新品上架</h3>
            <div class="m-other fr">
                <a href="/category" target="_blank" title="更多" class="u-more">更多</a>
            </div>
        </div>
        <div class="announced-soon clrfix announced-soon-new" id="divNewGoodsList">


        </div>
        <!--晒单分享-->
        <div class="g-title">
            <h3 class="fl"><i></i>晒单分享</h3>
            <div class="m-other fr">
                <a href="./share" target="_blank" title="更多" class="u-more">更多</a>
            </div>
        </div>
        <!--<div class="g-single-sun" id="g-single-sun">-->
		<div class="share-ct-item clearfix" id='share-ct-item'>
        </div>
        <div class="g-guide clrfix" id="footer">
        </div>
    </div>

<input type="hidden" id="sys_cur_time" value="<?php echo e(date('Y/m/d H:i:s')); ?>"/>
    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('my_js'); ?>
    <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript">
$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 2000,
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
        <script>
            //ajax分解首页接口
            getarticles();
            getlatest();
            getsoon();
            //getnavigate();
            getall();
            getisbuy();
            getnew();
            getshow();
            getfooter();


            /**首页所有数据填充AJAX方法集合***/
            function getlatest() { //最新揭晓 填充数据版
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_latest')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        var allcount = data.data.latest_count;
                        $("#em_lotcount").html(allcount);
                        data = data.data.data;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
							if(data[i]['is_lottery'] == 1){  //正在揭晓样式
                            strbody += '<li id="li'+data[i]['id']+'" class="current">' +
                                    '<dl class="m-in-progress">' +
									'<div class="zzjx"></div>' +  //已揭晓的水印为将class改为yjx
                                    '<dt><a href="'+data[i]['path']+'" target="_blank" title="">' +
                                    '<img class="lazy1" alt="' + data[i]['title'] + '"' +
                                    'src="<?php echo e($url_prefix); ?>img/nodata/product-loading.png"' +
                                    'data-original="' + data[i]['thumb'] + '"' +
                                    '>' +
                                    '</a></dt>' +
                                    '<dd class="u-name"><a href="'+data[i]['path']+'"' +
                                    'title=" ' + data[i]['title'] + '">' + data[i]['title'] + '</a>' +
                                    '</dd><dd class="gray">价值：' + data[i]['money'] + '</dd>' +
                                    '<dd class="u-time" id="dd_time">' +
                                    '<em>揭晓倒计时</em><span class="cut-time" data-id="'+data[i]['id']+'"  data-time="' + data[i]['ltime'] + '"> <b class="mini">00</b> : <b class="sec">00</b> :  <b class="hma">0</b><b class="hmb">0</b></span>' +
                                    '</dd></dl></li>';
							}else{
								 /*已揭晓样式 */
							    strbody += '<li id="li'+data[i]['id']+'" class="current lottery_after">' +
                               '<dl class="m-in-progress">' +
							   '<div class="yjx"></div>' +  
                               '<dt><a href="'+data[i]['path']+'" target="_blank" title="">' +
                               '<img class="lazy1" alt="' + data[i]['title'] + '"' +
                               'src="<?php echo e($url_prefix); ?>img/nodata/product-loading.png"' +
                               'data-original="' + data[i]['thumb'] + '"' +
                               '>' +
                               '</a></dt>' +
                               '<dd id="u-name-yjx">恭喜<a href="/him/'+data[i]['usr_id']+'"' +
                               'title=" ' + data[i]['title'] + '">' + data[i]['nickname'] + '</a>获得' +
                               '</dd><dd id="gray-hr"></dd>' +
                               '<dd id="yjx-detail"><a href="'+data[i]['path']+'" title="" id="yjx-detail-a">' + data[i]['title'] + '</a></dd></dl></li>';
							}
                        }
                        $("#ul_Lottery").append(strbody);
                        $("img.lazy1").lazyload({
                            effect: "fadeIn"
                        });
                        $.getScript("/foreground/js/countdown.js", function () {
                        });
                    }
                });
            }


         /*   function getlatest_zhen() { //最新揭晓
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_latest')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        var allcount = data.data.latest_count;
                        $("#em_lotcount").html(allcount);
                        data = data.data.latest;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            strbody = '<li id="' + data[i]['id'] + '" class="current">' +
                                    '<dl class="m-in-progress">' +
                                    '<dt><a href="" target="_blank" title="">' +
                                    '<img class="lazy1" alt="' + data[i]['belongs_to_goods']['title'] + '"' +
                                    'src="<?php echo e($url_prefix); ?>img/nodata/product-loading.png"' +
                                    'data-original="' + data[i]['belongs_to_goods']['thumb'] + '"' +
                                    '>' +
                                    '</a></dt>' +
                                    '<dd class="u-name"><a href="/product/' + data[i]['id'] + '"' +
                                    'title="(第' + data[i]['periods'] + '期)' + data[i]['belongs_to_goods']['title'] + '">' + data[i]['belongs_to_goods']['title'] + '</a>' +
                                    '</dd><dd class="gray">价值：' + data[i]['belongs_to_goods']['money'] + '</dd>' +
                                    '<dd class="u-time" id="dd_time">' +
                                    '<em>揭晓倒计时</em><span><b>' + data[i]['lottery_min'] + '</b> : <b>' + data[i]['lottery_sec'] + '</b> : <b><i>0</i><i>0</i></b></span>' +
                                    '</dd></dl></li>';
                        }
                        $("#ul_Lottery").append(strbody);
                        $("img.lazy1").lazyload({
                            effect: "fadeIn"
                        });

                    }
                });
            }*/
            function getsoon() {
                //获取热门推荐商品
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_soon')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval(' ('+data+') ');
                        data = data.data.soon;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            var participate_person = data[i]['participate_person'] == null ? 0 : data[i]['participate_person'];
                            var strheader = '<div class="g-hotL fl" id="divHotGoodsList">';
                            strbody += '<div class="g-hotL-list">' +
                                    '<div class="g-hotL-con"><ul>' +
                                    '<li class="g-hot-pic">' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)&nbsp;' + data[i]['belongs_to_goods']['title'] + '">' +
                                    '<img class="lazy2" width="178" height="178" alt="(第' + data[i]['periods'] + '期)&nbsp;' + data[i]['belongs_to_goods']['title'] + '"' +
                                    'src="<?php echo e($url_prefix); ?>img/nodata/product-loading2.png" data-original="' + data[i]['belongs_to_goods']['thumb'] + '"' +
                                    '></img></a></li> <li class="g-hot-name">' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)&nbsp;' + data[i]['belongs_to_goods']['title'] + '">(第' + data[i]['periods'] + '' +
                                    '期)&nbsp;' + data[i]['belongs_to_goods']['title'] +
                                    '</a></li><li class="gray">价值：￥' + data[i]['belongs_to_goods']['money'] + '</li>' +
                                    '<li class="g-progress"><dl class="m-progress"><dt title="已完成' + data[i]['rate'] + '%"><b style="width:' + data[i]['rate'] + '%;"></b></dt>' +
                                    '<dd>' +
                                    '<span class="orange fl"><em>' + participate_person + '</em>已参与</span>' +
                                    '<span class="gray6 fl"><em>' + data[i]['total_person'] + '</em>总需人次</span>' +
                                    '<span class="blue fr"><em>' + parseInt(data[i]['total_person'] - participate_person) + '</em>剩余</span>' +
                                    '</dd>' +
                                    '</dl>' +
                                    '</li>' +
                                    '<li>' +
                                    '<a href="product/' + data[i]['id'] + '"  class="u-imm" target="_blank"' +
                                    'title="立即一块购">立即一块购</a>' +
                                    '</li>' +
                                    '</ul>' +
                                    '</div>' +
                                    '</div>';
                        }
                        var strend = "</div>";
                        $(".g-hot").append(strheader + strbody + strend);
                        $("img.lazy2").lazyload({
                            effect: "fadeIn"
                        });
                    }
                });
            }
            function getall() {
                //获取全部商品
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_all')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.all;
                        //console.log(data);
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            var participate_person = data[i]['participate_person'] == null ? 0 : data[i]['participate_person'];
                            strbody += '<ul>' + '<div class="soon-list-con"><div class="soon-list">' +
                                    '<li class="g-soon-pic">' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)' + data[i].belongs_to_goods.title + '">' +
                                    '<img width="200" height="200" class="lazy3" name="goodsImg"' +
                                    'alt="(第' + data[i]['periods'] + '期)' + data[i].belongs_to_goods.title + '"' +
                                    'src="<?php echo e($url_prefix); ?>img/nodata/product-loading2.png"' +
                                    'data-original="' + data[i].belongs_to_goods.thumb + '"' +
                                    '>' +
                                    '</a>' +
                                    '</li>' +
                                    '<li class="soon-list-name">' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)' + data[i].belongs_to_goods.title + '">(第<em>' + data[i]['periods'] +
                                    '</em>期)&nbsp;' + data[i].belongs_to_goods.title + '' +
                                    '</a>' +
                                    '</li>' +
                                    '<li class="gray">价值：￥' + data[i].belongs_to_goods.money + '</li>' +
                                    '<li class="g-progress">' +
                                    '<dl class="m-progress">' +
                                    '<dt title="已完成' + data[i]['rate'] + '%">' +
                                    '<b style="width:' + data[i]['rate'] + '%;">' +
                                    '</b>' +
                                    '</dt>' +
                                    '<dd>' +
                                    '<span class="orange fl"><em>' + participate_person + '</em>已参与</span>' +
                                    '<span class="gray6 fl"><em>' + data[i]['total_person'] + '</em>总需人次</span>' +
                                    '<span class="blue fr"><em>' + parseInt(data[i]['total_person'] - participate_person) + '</em>剩余</span>' +
                                    '</dd>' +
                                    '</dl>' +
                                    '</li>' +
                                    '<li>' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank" title="立即一块购" class="u-now">立即一块购</a>' +
                                    '<a href="javascript:;" title="加入到购物车" onclick="addCart(' + data[i].belongs_to_goods.id + ',1)"  codeid="3384576" surplus="2959"' +
                                    'class="u-cart"><s></s></a>' +
                                    '</li>' +
                                    '</ul></div></div>';
                        }
                        $('#divSoonGoodsList').append(strbody);
                        $("img.lazy3").lazyload({
                            effect: "fadeIn"
                        });
                        //添加右边框
                        var length = $("#divSoonGoodsList .soon-list").length;
                        if(length%4!=0){
                          $("#divSoonGoodsList .soon-list").eq(length-1).css({"border-right":"1px solid #e4e4e4"});
                        }
                    }
                });
            }
            function getnew() {//获取最新商品
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_new')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.news;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            strbody += '<div class="soon-list-con">' +
                                    '<div class="soon-list">' +
                                    '<ul>' +
                                    '<li class="g-soon-pic">' +
                                    '<a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)' + data[i]['belongs_to_goods']['title'] + '">' +
                                    '<img class="lazy4" width="178" height="178" alt="(第' + data[i]['periods'] + '期)' + data[i]['belongs_to_goods']['title'] + '"' +
                                    'src="<?php echo e($url_prefix); ?>img/nodata/product-loading2.png"' +
                                    'data-original="' + data[i]['belongs_to_goods']['thumb'] + '"' +
                                    '>' +
                                    '</a>' +
                                    '</li>' +
                                    '<li class="soon-list-name"><a href="product/' + data[i]['id'] + '" target="_blank"' +
                                    'title="(第' + data[i]['periods'] + '期)' + data[i]['belongs_to_goods']['title'] + '">(第' + data[i]['periods'] + '' +
                                    '期)&nbsp;' + data[i]['belongs_to_goods']['title'] + '</a></li>' +
                                    '<li class="gray">价值：￥' + data[i]['belongs_to_goods']['money'] + '</li>' +
                                    '</ul>' +
                                    '</div>' +
                                    '</div>';
                        }
                        $('#divNewGoodsList').append(strbody);
                        $("img.lazy4").lazyload({
                            effect: "fadeIn"
                        });
                    }
                });
            }
            function getshow() {//获取晒单分享
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_show')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.show;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            if (i == 0) {
								strbody+='<div class="share-item">'+
										    '<a href="/sharedetail/'+data[i]['id']+'" target="_blank" title="' + data[i]['sd_title'] + '">' +
												'<div class="inner-item01"><img src="<?php echo e($url_prefix); ?>img/nodata/product-loading3.png" class="lazy5" data-original="' + data[i]['sd_thumbs'] + '" /></div>'+
											'</a>'+
											'<a href="/him/'+data[i]['usr_id']+'" target="_blank" >' +
												'<div class="inner-item02"><img class="lazy5" src="<?php echo e($url_prefix); ?>img/def.jpg" data-original="'+data[i]['user_photo']+'" /><span class="user-nickname">'+data[i]['nickname']+'</span><span class="timestr">'+data[i]['sd_time']+'</span></div>'+
											'</a>'+
											'<a href="/sharedetail/'+data[i]['id']+'" target="_blank" title="' + data[i]['sd_title'] + '">' +
												'<div class="inner-item03"><p>'+data[i]['sd_title']+'</p></div>'+
											'</a>'+
										'</div>';
                            } else {
								 strbody+='<div class="share-item01">'+
												'<a href="/sharedetail/'+data[i]['id']+'" target="_blank" title="' + data[i]['sd_title'] + '">' +
													'<div class="inner-item01"><img src="<?php echo e($url_prefix); ?>img/nodata/product-loading2.png" class="lazy5" data-original="' + data[i]['sd_thumbs'] + '" /></div>'+
												'</a>'+
												'<a href="/him/'+data[i]['usr_id']+'" target="_blank" >' +
													'<div class="inner-item02"><img class="lazy5" src="<?php echo e($url_prefix); ?>img/def.jpg" data-original="'+data[i]['user_photo']+'"/>'+
												'</a>'+
												'<a href="/sharedetail/'+data[i]['id']+'" target="_blank" title="' + data[i]['sd_title'] + '">' +
													'<div>'+
														'<span class="user-nickname">'+data[i]['nickname']+'</span><span class="timestr">'+data[i]["sd_time"]+'</span>'+
														'<p>'+data[i]['sd_title']+'</p>'+
													'</div>'+
												'</a>'+
												'</div>'+
										 '</div>';
                            }
                        }
                        var strend = '</ul></div>';
                        $('#share-ct-item').append(strbody + strend);
                        $("img.lazy5").lazyload({
                            effect: "fadeIn"
                        });
                    }
                });
            }
            function getfooter() { //获取底部数据填充
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_footer')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.footer;
                        var strbody = '';
                        var len=0;
                        for (var i = 0; i < data.length; i++) {
                            strbody += '<dl><dt>' + data[i]['cat_name'] + '</dt>';
                            if (data[i]['has_many_atricles']) {
                                if(data[i]['has_many_atricles'].length>3){
                                    len = 3;
                                }else {
                                    len = data[i]['has_many_atricles'].length;
                                }
                                for (var j = 0; j < len; j++) {
                                    strbody += '<dd>' +
                                            '<a target="_blank" href="/help/' + data[i]['has_many_atricles'][j]['article_id'] + '"title="' +
                                            data[i]['has_many_atricles'][j]['title'] + '">' + data[i]['has_many_atricles'][j]['title'] +
                                            '</a></dd>';
                                }
                                strbody += '</dl>';
                            }
                        }
                        $("#footer").append(strbody);

                    }
                });
            }

            function getarticles() {     //滚动公告栏
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_articles')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.articles;
                        var strbody = '';
                        var strheader = '<div class="i-notice-scroll"><div class="bd"><ul class="infoList">';
                        for (var i = 0; i < data.length; i++) {
                            strbody += '<li>' +
                                    '<a title="' + data[i]['title'] + '"' +
                                    'href="/notice/' + data[i]['article_id'] + '">' + data[i]['title'] + '</a>' +
                                    //'<p class="yscrolltime">' + data[i]['updated_at'] + '</p>' +
                                    '</li>';
                        }
                        strbody += '</ul></div></div>';
                        var strend = '<a href="/notice/' + data[0]['article_id'] + '" target="_blank" class="i-notice-more">更多</a>';
                        $("#scroll-notice").append(strheader + strbody + strend);
                        jQuery(".i-notice-scroll").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,scroll:1,vis:1,trigger:"click",interTime:4000,delayTime:800});
                    }
                });

            }


            function getnavigate() {    //全部商品分类
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_navigata')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.navigata;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            strbody += '<a href="' + data[i]['cat_id'] + '" target="_blank" title="' + data[i]['cat_name'] + '">' + data[i]['cat_name'] + '</a>';
                        }
                        $('#index_navigation').append(strbody);
                    }
                });
            }
            function getisbuy() {
                var url = "<?php echo e(config('global.base_url').config('global.ajax_path.index_isbuy')); ?>";
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        data = data.data.isbuy;
                        var strbody = '';
                        for (var i = 0; i < data.length; i++) {
                            if(!data[i]['userinfo']['user_photo']){
                            	data[i]['userinfo']['user_photo'] = <?php echo e($url_prefix); ?>img/nodata/tx-loading.png;
                            }
                            strbody += '<li>' +
                                    '<span class="fl"><a href="/him/'+data[i]['userinfo']['usr_id']+ '"  rel="nofollow"' +
                                    'title="' + data[i]['userinfo']['nickname'] + '">' +
                                    '<img  src="' + data[i]['userinfo']['user_photo'] + '"/></a></span>' +
                                    '<p>' +
                                    '<a href="/him/'+data[i]['userinfo']['usr_id']+ '" title="' + data[i]['userinfo']['nickname'] + '"' +
                                    'class="blue">' + data[i]['userinfo']['nickname'] + '</a><br/>' +
                                    '<a href="/product/' + data[i]['o_id'] + '" target="_blank"' +
                                    'title="' + data[i]['g_name'] + '" class="u-ongoing">' + data[i]['g_name'] + '</a>' +
                                    '</p>' +
                                    '</li>';
                        }
                        $('#UserBuyNewList').append(strbody);
                    }
                });


            }
            //首页活动弹框暂时隐藏 $(function(){
            //		setTimeout(a,3000);
            //		setTimeout('$(".activity2").slideUp()',6000);
            //	function a(){
            //		$('.header').before('<div class="activity"><img  alt="活动图" /></div>');
            //		$('.header').before('<div class="activity2">我是下面的大图</div>')
            //	};
            //	});
            //踢出登陆f
            var isout = $("#isout").val();
            if(isout=='yes'){
            	layer.confirm('亲，您的账号已下线或在别的地方登陆~', {
                    btn: ['重新登陆', '返回'] //按钮
                }, function () {
                    //跳转到充值页面
                    window.location.href = '/login';
                }, function () {
                    window.location.href='/index';
                });
            }

        </script>
        <?php /*<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/banner.js"></script>*/ ?>
        <script type="text/javascript" src="<?php echo e($url_prefix); ?>js/slider.js"></script><!--轮播图 -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('foreground.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
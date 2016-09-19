<!-- 顶部 -->
<!--<script charset="utf-8" src="http://wpa.b.qq.com/cgi/wpa.php"></script>-->
<div class="all_grey_bg"></div>
<!-- 2015-5-22 -修改 start  .header增加header_fixed类 -->
<div class="header header_fixed">
    <div class="header1">
        <div class="header1in">
            <ul class="headerul1">
                <li style="">特速集团旗下品牌</li>
                <!--<li><a href="javascript:void(0)" onclick="AddFavorite(document.title,window.location)">收藏</a></li>-->
                <li style="margin-left:10px;"><a class='fg'>|</a></li>
                <li class="cctv-icon" style="margin-left:20px;"><img style='margin:-8px 0 0 -8px' src="<?php echo e($url_prefix); ?>/img/cctv.png"></li>
            </ul>
            <ul class="headerul2">
                <?php if(session('user.id') > 0){  ?>
                <li style="margin-top:6px"><span class="h-ruwelcome" style="font-size: 14px">欢迎您，</span><a href="/user" style="color:#fb0603; display: inline"><?php echo e(session('user.nickname')); ?></a> <a href="/destory_login" style=" display: inline">[ <span>退出</span> ]</a></li>
                <li><a class='fg'>|</a></li>
                <li><a href="/user/account">我的一块购</a></li>
                <li><a class='fg'>|</a></li>
                <li><a href="/user/recharge_now">充值</a></li>
                <li><a class='fg'>|</a></li>
                <?php }else{ ?>
                <li><a href="/login">登录</a></li>
                <li><a class='fg'>|</a></li>
                <li><a href="/register">免费注册</a></li>
                <li><a class='fg'>|</a></li>
                <?php } ?>

                <li><a href="/help/2">帮助</a></li>
                <li><a class='fg'>|</a></li>
                <li><a target='_blank' href="http://shang.qq.com/wpa/qunwpa?idkey=b7a0eb1aaf1b0fb29a2d6f232ce94f0cff06b95f9a2a3d0feb8d910f304f3458" rel="nofollow">官方QQ群</a></li>
                <li><a class='fg'>|</a></li>
                <li>
                   <a href="/app" target="_blank">手机客户端</a>
                </li>
                 <!-- <li><a class='fg'>|</a></li>
               <li class="cctv-icon"><img style='margin:-3px -3px 0 5px' src="<?php echo e($url_prefix); ?>/img/kf.png"></li>
                <li>
                    <a href="javascript:;" id="BizQQWPA" style="color:#FC302F； padding-right: 0px;" rel="nofollow">在线客服</a>
                </li>-->
            </ul>
        </div>
    </div>
    <div class="header2">
        <a href="/index" class="header_logo"><img src="<?php echo e($url_prefix); ?>img/logo.png"></a>
        <div class="search_header2">
            <s></s>
            <input type="text" placeholder="搜索您需要的商品" maxlength="30" value="" id="searchVal"/>
            <a href="javascript:actionSearch();" class="btnHSearch"><img src="<?php echo e($url_prefix); ?>/img/search.png"></a>
                       <ul class="hot-query">
                            <li class="hot-query-highlight"><a href="/search/0/黄金">黄金</a></li>
                            <li><a href="/search/0/Apple">Apple</a></li>
                            <li class="hot-query-highlight"><a href="/search/0/小米">小米</a></li>
                            <li><a href="/search/0/咖啡">咖啡</a></li>
                            <li><a href="/search/0/宝马">宝马</a></li>
                            <li><a href="/search/0/单反">单反</a></li>
                        </ul>
        </div>
        <!-- 2015 6 9 end-->
    </div>
</div>
<div style="clear:both;"></div>
<!-- 导航   start  -->
<div class="yNavIndexOut yNavIndexOut_fixed yNavIndexOut_fixed_index">
    <div class="yNavIndex">
        <div class="pullDown">
            <h4 class="pullDownTitle">
                <a href="/category" target="">所有商品分类</a>
            </h4>
            <ul class="pullDownList">
                <?php foreach($category['category'] as $key=>$val): ?>
                    <li class="pullnav-li">
                        <a href="/category/<?php echo e($val['cateid']); ?>" class="dir_nav_a"><i class="dir_navico dir_navico<?php echo e($key+1); ?>"></i><em
                                    class="dir_navtit"><?php echo e($val['name']); ?></em><span></span></a>
                        <div class="item-sub item-sub<?php echo e($key+1); ?> clearfix">
                            <ul>
                            	<?php if(isset($val['brand'])): ?>
                                <?php foreach($val['brand'] as $key2=>$val2): ?>
                                    <li>
                                        <a href="/product/<?php echo e($val2->id); ?>" title="<?php echo e($val2->title2); ?>"alt="<?php echo e($val2->title2); ?>">
                                            <div class="item-simg"><img onerror="javascript:this.src='<?php echo e($url_prefix); ?>img/nodata/product-loading.png';" src="<?php echo e($val2->thumb); ?>" alt="<?php echo e($val2->title2); ?>" width="100"  height="100"/></div>
                                            <b class="item-stit"><?php echo e($val2->title2); ?></b>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- 下拉详细列表具体分类 -->
        </div>
        <ul class="yMenuIndex">
            <li><a href="/index" id='nav1' class="yMenua">首页</a><em class="yMenuaEm"></em></li>
            <li><a href="/freeday" id='nav2'>幸运转盘</a><em class="yMenuaEm"></em></li>
            <li><a href="/activity" id='nav3'>免费送礼</a><em class="yMenuaEm"></em></li>
            <li><a href="/share" id='nav4'>晒单分享</a><em class="yMenuaEm"></em></li>
            <li><a href="/announcement" id='nav5'>最新揭晓</a><em class="yMenuaEm"></em></li>
              <li><a href="/makeMoney" id='nav7'>我要赚钱</a><em class="yMenuaEm"></em></li>
            <li><a href="/guide" id='nav6'>新手指南</a></li>
            <div class="_mycart">
                <em class="cartEm"></em><span><a href="/mycart">我的购物车</a></span><i class="cartI" id="cartI"> <?php echo e($total_count); ?></i>
            </div>
        </ul>
    </div>
</div>


<div class="join-shop-car">
    <div class="car-item01"><img src="<?php echo e($url_prefix); ?>img/login_success.png"/>成功加入购物车</div>
    <div class="car-item02"><input type="button" value="结算" class="gotopay"/><input type="button" value="继续一块购" class="goonshop"/></div>
    <div class="car-item03">X</div>
</div>

<!-- 导航   end  -->

<script>
	// 加入收藏 兼容360和IE6
	function AddFavorite(title, url) {
	  try {
		  window.external.addFavorite(url, title);
	  }
	catch (e) {
		 try {
		   window.sidebar.addPanel(title, url, "");
		}
		 catch (e) {
			 alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
		 }
	  }
	}

    $(".join-shop-car .car-item03, .goonshop").click(function(){
        $('.join-shop-car').hide();
        $(".all_grey_bg").hide();
    });

    $('.gotopay').click(function(){
        window.location.href = '/mycart';
    })
	
	//QQ营销账号在线客服
	//BizQQWPA.addCustom({aty: '0', a: '1001', nameAccount: 800158208, selector: 'BizQQWPA'});

</script>

<script type="text/javascript">
$(function () {
    $(window).scroll(function() {
        if($(window).scrollTop() >= 205){               //向下滚动像素大于这个值，出现二级菜单
            $(".yNavIndexOut").addClass("navfixed");
            $('.yMenuIndex').css({'padding-top':'5px'});
            $('.cartEm').css({'margin-top':'3px'});
            $(".pullDownList").hide();

            /*$(".pullDown").hover(function () {
                $(this).find(".pullDownList").show();
            },function(){
                $(this).find(".pullDownList").hide();
            });
            $(".pullDownList").hover(function(){
                $(this).show();
            },function(){
                $(this).hide();
            })*/

        }else{                                        //移除二级菜单
            $(".yNavIndexOut").removeClass("navfixed");
            $('.yMenuIndex').css({'padding-top':'0px'});
            $('.cartEm').css({'margin-top':'0px'});
            var index = $("#index").html();
            if (index == 'index') {
                $('.pullDownList').show();
            }
        }

    });

});
</script>
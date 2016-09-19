<!--E 底部浮条 -->
 

<div id='theFooter'>
<div class="g-footer">
    <div class="w1190">


        <div class="g-service">
           
            <!--<div class="m-ser u-ser3">
                <ul>
                    <li><s class="u-icons"></s></li>
                    <li>
                        <dl>
                            <dt>服务器时间</dt>
							<dd id="pServerTime">
                                <span id='hour'>00</span>
                                <em>:</em>
                                <span id='mini'>00</span>
                                <em>:</em>
                                <span id='sec'>00</span>
                            </dd>
                            <dd id="pServerTime">
                                <span><?php echo e(date("H",time())); ?></span>
                                <em>:</em>
                                <span><?php echo e(date("i",time())); ?></span>
                                <em>:</em>
                                <span><?php echo e(date("s",time())); ?></span>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="m-ser u-ser4">
                <ul>
                    <li><s class="u-icons"></s></li>
                    <li>
                        <dl>
                            <dt>块乐公益基金</dt>
                            <dd><span href="javascript:;" id="spFundTotal"></span></dd>
                        </dl>
                    </li>
                </ul>
            </div>-->
           

        <div class="g-special clrfix">
            <ul>
                <li>
                  
                        <em class="u-spc-icon1"></em>
                        <span>100%公平公正</span>
                      	  参与过程公平透明 <br/>用户可随时查看
                
                </li>
        	</ul>
       	</div>
       	<div class="g-special clrfix">
       		<ul>
                <li>
                    
                        <em class="u-spc-icon2"></em>
                        <span>100%正品保证</span>
                        精心挑选优质商家 <br/>100%品牌正品
                   
                </li>
             	</ul>
       	</div>
       	<div class="g-special clrfix">
       		<ul>
                <li>
                 
                        <em class="u-spc-icon3"></em>
                        <span>全国免运费</span>
                        全场商品全国包邮<br/>（港澳台地区除外）
                 
                </li>
            </ul>
        </div>
         <div class="m-ser u-ser1">
				 <ul>
                          <em class="u-spc-icon4"></em>
                        <span>关注官方微博</span>
                          	查看精彩内容
                </ul> 
           </div>
           
             <div class="m-ser u-ser2">
			 
                <ul>
                          <em class="u-spc-icon4"></em>
                        <span>关注官方微信</span>
                          	掌握一手讯息
                </ul> 
            </div>
              <div class="m-ser u-ser5">
                <ul>
                    <li>
                        <dl>
                            <dt>服务热线</dt>
                            <dd class="orange u-tel">400-6626-985</dd>
                            <dd><a id="btnBtmQQ" href="javascript:;" class="u-service u-service-on"><i></i></a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
       </div>
    </div>
</div>

<?php 
	IF($_SERVER['REQUEST_URI']=='/index.php' || $_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index'){  
		require'hd_caches/index_footer_friendlink.html';
	} 
?>

 
		
<div class="g-copyrightCon">
    <div class="w1190">
        <div class="g-links">
            <a href="<?php echo e(url('help/11')); ?>" target="_blank" title="关于云购">关于我们</a><s></s>
            <a href="<?php echo e(url('help/18')); ?>" target="_blank" title="隐私声明">隐私声明</a><s></s>
            <!--<a href="<?php echo e(url('help/12')); ?>" target="_blank" title="合作专区">合作专区</a><s></s>
            <a href="<?php echo e(url('link')); ?>" target="_blank" title="友情链接">友情链接</a><s></s>
            <a href="<?php echo e(url('help/19')); ?>" target="_blank" title="加入云购">加入云购</a><s></s>-->
            <a href="<?php echo e(url('help/13')); ?>" target="_blank" title="联系我们">联系我们</a>
        </div>
        <div class="g-copyright">Copyright © 2012 - 2016, 版权所有 深圳市木有关系网络科技有限公司 粤ICP备15100392号-2</div>
    </div>
</div>
</div>
<!--end thefooter-->

<!--悬浮导航STRT-->
<style>
.all-tipbar {
	position: fixed;
	right: 24px;
	bottom: 50px;
	z-index: 9999;
	width: 60px
}
.all-tipbar.all-tipbar-show a.a-backtop {
	display: block
}
.all-tipbar a.a-backtop {
	display: none
}
.all-tipbar .tipbar-item {
	display: block;
	overflow: hidden;
	width: 60px;
	height: 64px;
	background-color: #7f7f7f;
	color: #fff;
	text-align: center
}
.all-tipbar .tipbar-item .iconfont {
	display: block;
	height: 32px;
	font-size: 40px;
	line-height: 32px;
	padding-top: 7px
}
.all-tipbar .tipbar-item:hover {
	background-color:#F80808
}
.a-tip-servicer {
	margin-bottom: 2px;
	cursor: pointer
}
 
</style>
<!--
<div class="all-tipbar all-tipbar-show" id="all-tipbar"> 
    <a href="/mycart" class="a-back tipbar-item a-tip-servicer"><i class="iconfont" style='padding-top:5px' ><img src="<?php echo e($url_prefix); ?>img/icon_shopping_cart.png"></i><p style='margin-top:5px'>购物车</p></a>
    <span onclick="NTKF.im_openInPageChat('kf_9372_1470212593294')" class="a-tip-servicer tipbar-item"><i class="iconfont"><img src="<?php echo e($url_prefix); ?>img/icon_comment.png"></i>在线客服</span>
    <a onclick="javascript:goTop();return false;" href='javascript:;' class="a-backtop tipbar-item" style="visibility:visible;"><i class="iconfont" style='padding-top:0px'><img src="<?php echo e($url_prefix); ?>img/icon_goTop.png"></i><p style='margin-top:5px'>返回顶部</p></a>
</div>-->
<!--悬浮导航END-->
<script type="text/javascript" src="<?php echo e($url_prefix); ?>js/severtime.js"></script>

<script type="text/javascript"> 
/** 
* 回到页面顶部 
* @param  acceleration 加速度 
* @param  time 时间间隔 (毫秒) 
**/
function goTop(acceleration, time) { 
acceleration = acceleration || 0.1; 
time = time || 16; 
 
var x1 = 0; 
var y1 = 0; 
var x2 = 0; 
var y2 = 0; 
var x3 = 0; 
var y3 = 0; 
 
if (document.documentElement) { 
x1 = document.documentElement.scrollLeft || 0; 
y1 = document.documentElement.scrollTop || 0; 
} 
if (document.body) { 
x2 = document.body.scrollLeft || 0; 
y2 = document.body.scrollTop || 0; 
} 
var x3 = window.scrollX || 0; 
var y3 = window.scrollY || 0; 
 
// 滚动条到页面顶部的水平距离 
var x = Math.max(x1, Math.max(x2, x3)); 
// 滚动条到页面顶部的垂直距离 
var y = Math.max(y1, Math.max(y2, y3)); 
 
// 滚动距离 = 目前距离 / 速度, 因为距离原来越小, 速度是大于 1 的数, 所以滚动距离会越来越小 
var speed = 1 + acceleration; 
window.scrollTo(Math.floor(x / speed), Math.floor(y / speed)); 
 
// 如果距离不为零, 继续调用迭代本函数 
if(x > 0 || y > 0) { 
var invokeFunction = "goTop(" + acceleration + ", " + time + ")"; 
window.setTimeout(invokeFunction, time); 
} 
} 
</script>

<script>
 
 
 $(function(){
   	    $.post("/user/getFund", {'_token':"<?php echo e(csrf_token()); ?>"},
	       function(data){
		       data=eval( '('+data+')');
		       $("#spFundTotal").html('￥'+data.money+'元');
		 })
		
})

function actionSearch(){
    var searchVal = $("#searchVal").val();
    location.href = '/search/0/'+searchVal.replace(/(\/)/g, "");
}
// 按回车键搜索
$(document).keydown(function(event) {
	if (event.keyCode == 13) {
            if($("#searchVal").val() == '')
            {
               return false;
            } else {
               actionSearch();
            }
            
        }

});
</script>
<?php if(!isset($is_mobile) || $is_mobile != 2): ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"2","bdPos":"right","bdTop":"100"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<?php endif; ?>
<?php $__env->startSection('title', '商品详情'); ?>

<?php $__env->startSection('canonical'); ?>
    <link rel='canonical' href="http://m.ts1kg.com/prod_m/<?php echo e($data['goods']['belongs_to_goods']['id']); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('rightTopAction', ''); ?>
<?php $__env->startSection('my_css'); ?>
   
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/page.css">
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/product.css">
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mui-content">
<!--首页头部 start-->
<div class="pro-focus">
   <!--幻灯片 start-->
   <div class="i-focus" >
       <div id="slider" class="mui-slider" >
         <div class="mui-slider-group mui-slider-loop">
            <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
            	<?php if(count($data['goods']['belongs_to_goods']['picarr'])-1 >= 0): ?>
               		<img src="<?php echo e($data['goods']['belongs_to_goods']['picarr'][count($data['goods']['belongs_to_goods']['picarr'])-1]); ?>" onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload320.jpg';" >
            	<?php else: ?>
            		<img src="" onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload320.jpg';" >
            	<?php endif; ?>
            </div>
            <?php foreach($data['goods']['belongs_to_goods']['picarr'] as $key => $val): ?>
            <?php if($key != 0 || $key != count($data['goods']['belongs_to_goods']['picarr'])-1): ?>
                <div class="mui-slider-item">
                   <img src="<?php echo e($val); ?>" onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload320.jpg';" data-preview-src="" data-preview-group="1">
                </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
               <?php if(count($data['goods']['belongs_to_goods']['picarr']) > 0): ?>
               		<img src="<?php echo e($data['goods']['belongs_to_goods']['picarr'][0]); ?>" onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload320.jpg';" >
               <?php else: ?>
               		<img src="" onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload320.jpg';" >
               <?php endif; ?>
            </div>
         </div>
         <div class="mui-slider-indicator">            
            <?php foreach($data['goods']['belongs_to_goods']['picarr'] as $key => $val): ?>
                <?php if($key == 0): ?>
                    <div class="mui-indicator mui-active"></div>
                <?php else: ?>
                    <div class="mui-indicator"></div>
                <?php endif; ?>
           	<?php endforeach; ?>
         </div>
      </div>
   </div>
   <!--幻灯片 end-->
</div>
<!--首页头部 end-->
<!--<p class='album_tips' data-url="/productdetail_m/<?php echo e($id); ?>"><a >点击查看详情</a></p>-->
<p class='album_tips' data-url="/html_static/h5pro/<?php echo e($data['goods']['g_id']); ?>.html"><a>请点击查看详情</a></p>

<!--板块 start-->
<div class="item-main">
   <div class="item-m-nav clearfix">
      <div class='pro_title'>
		<h2><div class='product_status'>进行中</div>(第<?php echo e($data['goods']['periods']); ?>期)<?php echo e($data['goods']['belongs_to_goods']['title']); ?></h2>
	  </div>
      <div>
		<div class='pro_bar'>
			<div class='pro_barA'>
				<div class='pro_barB' style="width:<?php echo e(round($data['goods']['participate_person']/$data['goods']['total_person'],2)*100); ?>%"></div>
				<div class='pro_store'>
					<div>总需:<?php echo e($data['goods']['total_person']); ?></div>
					<div>剩余:<?php echo e($data['goods']['total_person']-$data['goods']['participate_person']); ?></div>
				</div>
			</div>
		</div>
		<div class='pro_share'><img src="<?php echo e($h5_prefix); ?>images/proShare.png"></div>
	  </div>
   </div>

   <div class="h-notice mui-clearfix">
   <?php if(!empty(session('user.id'))): ?>
       <?php if(!empty($data['userbuywithid'])): ?>
            <ul>
                <li style='text-align:center;color:#999'>您本期一块购幸运码为：
                	<?php if(!empty($data['buyno'])): ?>
                    <?php foreach($data['buyno'] as $key=>$val): ?>
                        <?php if($key<3): ?>
                            <span class="buyover_number"><?php echo e($val); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if(count($data['buyno'])>3): ?>
                        <a href="javascript:void(0);" style='color:#999' class="buyover_more_a">查看更多 ></a>
                    <?php endif; ?>
                <?php endif; ?>                
                </li>
             </ul>
        <?php else: ?>
        	<ul>
                <li style='text-align:center;'><a style='color:#999' href="#">您还没有参加本次购买哦！</a></li>
             </ul>
        <?php endif; ?>
   <?php else: ?>
        <ul>
            <li style='text-align:center;'><a style='color:#999' data-url="/login_m">请<a data-url="/login_m">登录</a></a></li>
         </ul>
   <?php endif; ?> 
   </div>
</div>
	<!--上一期获奖结果 start-->
    <?php if($prizeUser != null): ?>
	<div class="jxjg">
		<div class="jxjgL jxjgL-pre">
			<div class="owner_img"><a data-url="/him_m/getHisBuy/<?php echo e($prizeUser['usr_id']); ?>"><img src="<?php echo e($prizeUser['user_photo']); ?>"></a></div>
		</div>
		<div class="jxjgR">
			<p>
                获得者：<span id='owner'><?php echo e($prizeUser['username']); ?></span><br>
				本期参与：<?php echo e($prizeUser['buycount']); ?>人次<br>
				揭晓时间：<?php echo e($prizeUser['lottery_time']); ?><br>
				购买时间：<?php echo e($prizeUser['bug_time']); ?><br>
			</p>
		</div>
	</div>
	<div class="jxnumber" >
		<div class='no1'>幸运号码：<?php echo e($prizeUser['fetchno']); ?></div>
		<div class='no2' onclick='window.location.href="/calculate_m/2?o_id=<?php echo e($prizeUser['o_id']); ?>"'><a>查看计算详情</a></div>
	</div>
    <?php endif; ?>
	<!--上一期获奖结果 end-->

 	<?php if($status == 1): ?>
   <!--即将揭晓倒计时START-->
	<div class="jjjxdjs">
		<h2>揭晓倒计时</h2>
		<div class="djs">
			<div class='djs1'>即将揭晓:<span class="cut-time" data-time="2016/04/22 18:40:40"><b class="mini">04</b>分<b class="sec">34</b>秒<b class="hma">1</b><b class="hmb">2</b></span></div>
			<div class='djs2'><a>查看计算详情</a></div>
		</div>
	</div>
   <!--即将揭晓倒计时END-->
   <?php endif; ?>
   
   <?php if($status == 2): ?>
    <!--揭晓结果START-->
	<div class="jxjg">
		<div class="jxjgL">
			<div class="owner_img"><img src="<?php echo e($h5_prefix); ?>images/tx2.jpg"></div>
		</div>
		<div class="jxjgR">
			<p>
				中奖者：<span id='owner'>德田重男</span><br>
				手机号：135****5856<br>
				用户地址：中国广东深圳<br>
				本期参与：10人次<br>
				揭晓时间：2015-06-08 13:25:15<br>
			</p>
		</div>
	</div>
	<div class="jxnumber">
			<div class='no1'>幸运号码：10000095</div>
			<div class='no2'><a>查看计算详情</a></div>
	</div>
   <!--揭晓结果END-->
   <?php endif; ?>
   
   <div class="pro_info"  onclick='window.location.href="/wqjx_m?gid=<?php echo e($data['goods']['belongs_to_goods']['id']); ?>"'>
      <a href="#">
         <span class="pro_jx"><img src="<?php echo e($h5_prefix); ?>images/pro_jx.png" class="pro_jxIcon"></span>
         <span class="pro_infoTitle">往期揭晓</span>
         <span class="pro_arrow"><img src="<?php echo e($h5_prefix); ?>images/pro_arrow.png"></span>
      </a>
   </div>
   
   <div class="pro_info" style="clear:both;margin-top:0.02rem" onclick='window.location.href="/share_m?gid=<?php echo e($data['goods']['belongs_to_goods']['id']); ?>"'>
      <a href="#">
         <span class="pro_sd"><img src="<?php echo e($h5_prefix); ?>images/pro_sd.png" class="pro_sdIcon"></span>
         <span class="pro_infoTitle">往期晒单</span>
         <span class="pro_arrow"><img src="<?php echo e($h5_prefix); ?>images/pro_arrow.png"></span>
      </a>
   </div>
 
	<div class='join_recored'>
		<div class='rec_title'>所有参与记录</div>
		<div class='rec_time'><?php if(!empty($data['starttime'])): ?> (自<?php echo e($data['starttime']); ?>开始)<?php endif; ?></div>
	</div>
	
	<div class='rec_list' id="wrapper">
		<div class='vertical_line'></div>
		<ul>
			<br/>
			 
		</ul>
	</div>
 
   <div class="lucky_numberbox" style="display: none;">
        <?php if(!empty($data['buyno'])): ?>
            <?php foreach($data['buyno'] as $key=>$val): ?>
                <span class="l_number"><?php echo e($val); ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
   </div>

</div>
<?php if(session('is_ios') != 1): ?>
<!--底部导航-->
<div style="height:0.77rem;"></div>
<footer class="fixed-footer">
		<div class='toFlow' onclick="addCart(<?php echo e($data['goods']['g_id']); ?>,1)"><img src="<?php echo e($h5_prefix); ?>images/progress-img.png" ></div>
        <div class='toBuy' onclick="toCart(<?php echo e($data['goods']['g_id']); ?>,1)">立即参与</div>
</footer>
<?php endif; ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_js'); ?>
	<script type="text/javascript" src="<?php echo e($h5_prefix); ?>js/countdown.js"></script>
	<script type="text/javascript" src="<?php echo e($h5_prefix); ?>js/mui.zoom.js"></script>
	<script type="text/javascript" src="<?php echo e($h5_prefix); ?>js/mui.previewimage.js"></script>
    <script type="text/javascript">
	  mui.previewImage();

      var gallery = mui('.mui-slider');
      gallery.slider({
         interval:5000//自动轮播周期，若为0则不自动播放，默认为0；
      });
	  //myalert('恭喜你，参与成功！<BR/>请等待系统为您揭晓！');
      var urlstr = '<a onclick="window.location.href=\'/selectperiods_m/?gid='+<?php echo e($data['goods']['belongs_to_goods']['id']); ?>+'\';" >第'+<?php echo e($data['goods']['periods']); ?>+'期&gt; </a>';
	  $("#rightTopAction").html(urlstr);
      
	  var page = 0;

$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
		    var o_id = "<?php echo e($data['goods']['id']); ?>";
		    var _token = $("input[name='_token']").val();
	    	$.ajax({
	            type: 'post',
	            url: '/product_m/getbuyrecord',
	            dataType: 'json',
	            data:{page:page,o_id:o_id,_token:_token},
	            success: function(data){
					var products = data.data.data;
		            var html = '';
		            for(var key in products){
			            html += '<li>'+
							'<div class="rec_liL"><div class="rec_liLImg join_btn"><a data-url="/him_m/getHisBuy/'+products[key]["usr_id"]+'"><img src="'+products[key]['user_photo']+'" onerror="javascript:this.src=\'/H5/images/lazyload130.jpg\'"></a></div></div>'+
							'<div class="rec_liR">'+
								'<H3 class="join_btn"><a data-url="/him_m/getHisBuy/'+products[key]["usr_id"]+'">'+products[key]["nickname"]+'</a></H3>'+
								'<p>'+products[key]["login_ip"]+'</p>'+
								'<p>购买:<span>'+products[key]["buycount"]+'人次</span> '+products[key]["bid_time"]+'</p>'+
							'</div></li>';
			        }

		            if(products.length < 10){
	            		// 锁定
                        me.lock();
                        // 无数据
                        me.noData();
		            }

		            page++;

		            $('#wrapper').find('ul').append(html);
	                // 每次数据加载完，必须重置
	                me.resetload();
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    }
	    
	});
})
    
    //我的幸运码弹出窗
    $('.buyover_more_a').on('click', function () {
        var html = $(".lucky_numberbox").html();
        layer.open({
            type: 1,
            title: '您本期一块购幸运码',
            area: ['410px', '300px'], //宽高
            content: html,
        });
    });

	$('.pro_share').click(function(){
		layer.open({
		    title: [
		        '复制',
		    ],
		    content: '<input type="text" value="<?php echo e(Request::url()); ?>"/>'
		    
		});
	})
	
	$(document).on('click',".join_btn>a",function(){
		window.location.href=$(this).attr("data-url");
	});
	
	$(document).on('click',".owner_img>a",function(){
		window.location.href=$(this).attr("data-url");
	});
    </script>  
<?php $__env->stopSection(); ?>



 
<?php echo $__env->make('foreground.mobilehead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
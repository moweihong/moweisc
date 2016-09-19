<?php $__env->startSection('title', '商品分类'); ?>
<?php $__env->startSection('rightTopAction', '搜索'); ?>
<?php $__env->startSection('footer_switch', 'show'); ?>
<?php $__env->startSection('my_css'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e($h5_prefix); ?>css/category.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="mui-content">
  <div class="menu-content">
  	<ul>
  		<li class="menu_img_all h5_menu_img"><i class="active" data-catid="0"></i><a>全部商品</a></li>
  		<?php if(!empty($category['category'])): ?>
        <?php foreach($category['category'] as $key=>$val): ?>
  			<li class="<?php echo e($h5_category_conf[$val['cateid']]); ?> h5_menu_img"><i data-catid="<?php echo e($val['cateid']); ?>"></i><a><?php echo e($val['name']); ?></a></li>
  		<?php endforeach; ?>
        <?php endif; ?>
  	</ul>
    <div class="tab-menu mui-clearfix">
      <a <?php if($order == 'fast'): ?> class="active" <?php endif; ?> data-order="fast">最快<i class="tmenu-line"></i></a>
      <a <?php if($order == 'default'): ?> class="active" <?php endif; ?> data-order="default">最热<i class="tmenu-line"></i></a>
      <a <?php if($order == 'new'): ?> class="active" <?php endif; ?> data-order="new">最新<i class="tmenu-line"></i></a>
      <a <?php if($order == 'price_desc'): ?> class="active" <?php endif; ?> data-order="price_desc">高价<i class="tmenu-line"></i></a>
      <a <?php if($order == 'price_asc'): ?> class="active" <?php endif; ?> data-order="price_asc">低价<i class="tmenu-line"></i></a>
    </div>
  </div>
  <p class="hide js-menuH"></p>
  <div class="tab-list" id="wrapper">
  	<ul>
  		<?php foreach($data as $product): ?>
      		<li>
          		<a href="/product_m/<?php echo e($product->id); ?>">
          			<img onerror="javascript:this.src='<?php echo e($h5_prefix); ?>images/lazyload130.jpg';" src="<?php echo e($product->thumb); ?>" class="phone-img"/>
          			<p><?php echo e($product->title2); ?></p>
                    </a>
          			<div>
          				<div class="bar-contain">
          					总需：<?php echo e($product->total_person); ?>

          					<div class="progress-bar">
          						<div class="inner-progress-bar" style="width:<?php echo e($product->rate); ?>"></div>
          					</div>
          					剩余<span><?php echo e($product->surplus); ?></span>
          				</div>
                        <?php if(session('is_ios') != 1): ?>
          				    <img src="<?php echo e($h5_prefix); ?>images/shop_car.png" class="car-img"/>
                        <?php endif; ?>
          			</div>
      		</li>
  		<?php endforeach; ?>
  	</ul>
  </div>
	<div style="height: 62px"></div>
  </div>
  <?php $par=empty($_GET['par'])?0:'yes' ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('my_js'); ?>
<script>
var page = <?php echo e($page); ?>;
var h5_prefix = <?php echo e($h5_prefix); ?>;
var is_ios = <?php echo e(session('is_ios') ? session('is_ios') : 0); ?>;

$(document).ready(function(){
//url跳转最新产品
var par = "<?php echo $par ?>";
var url = window.location.search || "";

//ajax拉取各大分类，最快，最热，最新，高价,低价
function productajax(fun){
	var dropload = $('#wrapper').dropload({
		scrollArea : window,
		loadDownFn : function(me){
			fun;
			var catid = $('.menu-content').find('.active').attr('data-catid');
			var order = $('.tab-menu').find('.active').attr('data-order');
			var index = layer.open({type: 2});

			$.ajax({
				type: 'GET',
				url: '',
				dataType: 'json',
				data:{page:page,order:order,catid:catid},
				success: function(data){
					layer.close(index);
					var products = data.data;
					var html = '';
					for(var key in products){
						$class = key%2 != 0 ? 'style="margin-left:6px"' : '';
						html += '<li '+$class+'>';
						html += '<a href="/product_m/'+products[key].id+'">';
						html += '<img onerror=\"javascript:this.src=\'<?php echo e($h5_prefix); ?>images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
						html += '<p>'+products[key].title2+'</p></a>';
						html += '<div><div class="bar-contain">总需：'+products[key].total_person;
						html += '<div class="progress-bar"><div class="inner-progress-bar" style="width:'+products[key].rate+'%"></div></div>';
						html += '剩余<span>'+products[key].surplus+'</span></div>';
						html += is_ios != 1 ? '<img src="'+h5_prefix+'images/shop_car.png" class="car-img" onclick="addCart('+products[key].g_id+',1)" />' : '';
						html += '</div></li>';
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
					// 即使加载出错，也得重置
					me.resetload();
				}
			});
		},
		loadUpFn : function(me){
			var catid = $('.menu-content').find('.active').attr('data-catid');
			var order = $('.tab-menu').find('.active').attr('data-order');
			var index = layer.open({type: 2});

			$.ajax({
				type: 'GET',
				url: '',
				dataType: 'json',
				data:{page:0,order:order,catid:catid},
				success: function(data){
					layer.close(index);
					var products = data.data;
					var html = '';
					for(var key in products){
						$class = key%2 != 0 ? 'style="margin-left:6px"' : '';
						html += '<li '+$class+'>';
						html += '<a href="/product_m/'+products[key].id+'">';
						html += '<img onerror=\"javascript:this.src=\'<?php echo e($h5_prefix); ?>images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
						html += '<p>'+products[key].title2+'</p></a>';
						html += '<div><div class="bar-contain">总需：'+products[key].total_person;
						html += '<div class="progress-bar"><div class="inner-progress-bar" style="width:'+products[key].rate+'%"></div></div>';
						html += '剩余<span>'+products[key].surplus+'</span></div>';
						html += is_ios != 1 ? '<img src="'+h5_prefix+'images/shop_car.png" class="car-img" onclick="addCart('+products[key].g_id+',1)" />' : '';
						html += '</div></li>';
					}

					$('#wrapper').find('ul').html(html);
					page = 1;
					// 每次数据加载完，必须重置
					me.resetload();
				},
				error: function(xhr, type){
					// 即使加载出错，也得重置
					me.resetload();
				}
			});
		}


	});
}

//为首页制作带参数函数封装
function newproduct(){
	var f = $(".tab-menu a").eq(2).addClass("active").siblings("a").removeClass("active");
	productajax(f);
};

//判断url是否含有 ?par=yes,为了首页即将揭晓跳转带参数
if(url.indexOf(par) > 0){
	newproduct();
}
else{   //判断url没带参数，正常分类筛选
	productajax();
}

	$('.tab-menu a').click(function(){
		$('.tab-menu').find('a').removeClass('active');
		$(this).addClass('active');
		
		refreshCategory();
	})

	$('.h5_menu_img').click(function(){
		$('.h5_menu_img').find('i').removeClass('active');
		$(this).find('i').addClass('active');

		refreshCategory();
	})
})

function refreshCategory(){
	var catid = $('.menu-content').find('.active').attr('data-catid');
	var order = $('.tab-menu').find('.active').attr('data-order');
	var index = layer.open({type: 2});

	$.ajax({
        type: 'GET',
        url: '',
        dataType: 'json',
        data:{page:0,order:order,catid:catid},
        success: function(data){
			layer.close(index);
        	var products = data.data;
            var html = '';
            for(var key in products){
	            $class = key%2 != 0 ? 'style="margin-left:6px"' : '';
            	html += '<li '+$class+'>';
	            html += '<a href="/product_m/'+products[key].id+'">';
	            html += '<img onerror=\"javascript:this.src=\'<?php echo e($h5_prefix); ?>images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
	            html += '<p>'+products[key].title2+'</p></a>';
	            html += '<div><div class="bar-contain">总需：'+products[key].total_person;
	            html += '<div class="progress-bar"><div class="inner-progress-bar" style="width:'+products[key].rate+'%"></div></div>';
	            html += '剩余<span>'+products[key].surplus+'</span></div>';
	            html += is_ios != 1 ? '<img src="'+h5_prefix+'images/shop_car.png" class="car-img" onclick="addCart('+products[key].g_id+',1)" />' : '';
	            html += '</div></li>';
	        }

            $('#wrapper').find('ul').html(html);
            page = 1;

        },
        error: function(xhr, type){
            //alert('服务器错误!');
        }
    });
}
$(".js-menuH").height($(".menu-content ul").show().innerHeight())
$(".menu-content ul").hide();
$(".mui-title").bind("click",function(){
	if($(".menu-content ul").css("display")==='none'){
		$(".menu-content ul, .js-menuH").slideDown(500);
		$("#menu-btn").addClass("caret-white-up");
	}else{
		$(".menu-content ul, .js-menuH").slideUp(500);
		$("#menu-btn").removeClass("caret-white-up");
	}
});
$(".menu-content ul li").bind("click",function(){
	var catval =$(this).find("a").text();
	$(".mui-title").find("b").text(catval);
	$(".menu-content ul, .js-menuH").slideUp(300);
})
$('#rightTopAction').click(function(){
    location.href = '/search_m';
});
</script>
<?php $__env->stopSection(); ?>



 
<?php echo $__env->make('foreground.mobilehead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
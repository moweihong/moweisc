@extends('foreground.mobilehead')
@section('title', '')
@section('rightTopAction', '搜索')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/category.css">
@endsection

@section('content')
  <div class="mui-content">
  <div class="menu-content">
  	<ul>
  		<li class="menu_img_all h5_menu_img"><i data-index='0' data-catid="0" data-catname="全部商品"></i><a>全部商品</a></li>
  		@if(!empty($category['category']))
        @foreach($category['category'] as $key=>$val)
  			<li class="{{ $h5_category_conf[$val['cateid']] or ''}} h5_menu_img"><i data-index="{{$key+1}}" data-catid="{{$val['cateid']}}" data-catname="{{$val['name']}}"></i><a>{{$val['name']}}</a></li>
  		@endforeach
        @endif
  	</ul>
    <div class="tab-menu mui-clearfix">
      <a @if($order == 'fast') @endif data-order="fast">最快<i class="tmenu-line"></i></a>
      <a @if($order == 'default') @endif data-order="default">最热<i class="tmenu-line"></i></a>
      <a @if($order == 'new') @endif data-order="new">最新<i class="tmenu-line"></i></a>
      <a @if($order == 'price_desc') @endif data-order="price_desc">高价<i class="tmenu-line"></i></a>
      <a @if($order == 'price_asc') @endif data-order="price_asc">低价<i class="tmenu-line"></i></a>
    </div>
  </div>
  <p class="hide js-menuH"></p>
  <div class="tab-list" id="wrapper">
  	<ul>
  		@foreach($data as $product)
      		<li>
          		<a href="/product_m/{{ $product->id }}">
          			<img onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" src="{{ $product->thumb }}" class="phone-img"/>
          			<p>{{ $product->title2}}</p>
                    </a>
          			<div>
          				<div class="bar-contain">
          					总需：{{ $product->total_person }}
          					<div class="progress-bar">
          						<div class="inner-progress-bar" style="width:{{ $product->rate }}"></div>
          					</div>
          					剩余<span>{{ $product->surplus }}</span>
          				</div>
                        @if(session('is_ios') != 1)
          				    <img src="{{ $h5_prefix }}images/shop_car.png" class="car-img"/>
                        @endif
          			</div>
      		</li>
  		@endforeach
  	</ul>
  </div>
	<div style="height: 62px"></div>
  </div>
  <?php $par=empty($_GET['par'])?0:'yes' ?>
@endsection

@section('my_js')
<script>
var page = {{ $page }};
var h5_prefix = {{ $h5_prefix }};
var is_ios = {{session('is_ios') ? session('is_ios') : 0}};

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
						html += '<img onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
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
						html += '<img onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
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

	//刷新按排序方式显示数据
	var orderType = "{{$_GET['type'] or 'fast'}}";
	if(orderType=='fast')
		$(".tab-menu a").eq(0).addClass("active");
	else if(orderType=='default')
		$(".tab-menu a").eq(1).addClass("active");
	else if(orderType=='new')
		$(".tab-menu a").eq(2).addClass("active");
	else if(orderType=='price_desc')
		$(".tab-menu a").eq(3).addClass("active");
	else if(orderType=='price_asc')
		$(".tab-menu a").eq(4).addClass("active");
	//商品分类样式
	var cate = "{{$_GET['cate'] or 0}}";
	$(".h5_menu_img i").eq(cate).addClass("active");
	//更改TITLE上的分类名称
	var catename =$('.menu-content ul li').find(".active").attr('data-catname');
	$(".mui-title").find("b").text(catename);
	//拉取数据
	productajax();

		
	/*排序方式点击事件*/
	$('.tab-menu a').click(function(){
		$('.tab-menu').find('a').removeClass('active');
		$(this).addClass('active'); 
		var order = $('.tab-menu').find('.active').attr('data-order'); 
		var cate  = $('.h5_menu_img').find('.active').attr('data-index'); 
		window.location='category_m?type='+order+'&cate='+cate;
		//refreshCategory();
	})
	
	/*商品分类点击事件*/
	$('.h5_menu_img').click(function(){
		//$('.h5_menu_img').find('i').removeClass('active');
		//$(this).find('i').addClass('active');
		//refreshCategory();
		$('.h5_menu_img i').removeClass('active');
		$(this).find('i').addClass('active'); 
		var order = $('.tab-menu').find('.active').attr('data-order'); 
		var cate  = $('.h5_menu_img').find('.active').attr('data-index'); 
		window.location='category_m?type='+order+'&cate='+cate;
	})


})
/*
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
	            html += '<img onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\'\" src="'+products[key].thumb+'" class="phone-img"/>';
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
}*/
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
	//var catval =$(this).find("a").text();
	//$(".mui-title").find("b").text(catval);
	$(".menu-content ul, .js-menuH").slideUp(300);
})
$('#rightTopAction').click(function(){
    location.href = '/search_m';
});
</script>
@endsection



 
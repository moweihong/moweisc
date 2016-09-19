$(function () {
	//一级导航菜单 - 选中变红，通过js获取pathname值获取
	var clearNavCur = function(){
		$('#nav1,#nav2,#nav3,#nav4,#nav5,#nav6,#nav7').removeClass('yMenua');
	}
	var _pathname = window.location.pathname;
	if(_pathname.substring(1,8)=='freeday'){
		clearNavCur();
		$('#nav2').addClass('yMenua');
	}else if(_pathname.substring(1,9)=='activity'){
		clearNavCur();
		$('#nav3').addClass('yMenua');
	} else if(_pathname.substring(1,6)=='share'){
		clearNavCur();
		$('#nav4').addClass('yMenua');
	}else if(_pathname.substring(1,13)=='announcement'){
		clearNavCur();
		$('#nav5').addClass('yMenua');
	}else if(_pathname.substring(1,6)=='guide'){
		clearNavCur();
		$('#nav6').addClass('yMenua');
	}else if(_pathname.substring(1,10)=='makeMoney'){
		clearNavCur();
		$('#nav7').addClass('yMenua');
	}

	/*二级菜单 - 控制头部下拉当行栏显示隐藏*/
	var index = $("#index").html();  
	if (index == undefined) {
		$(".pullDown").hover(function () {
			$(this).find(".pullDownList").show();
		},function(){
			$(this).find(".pullDownList").hide();
		});
		$(".pullDownList").hover(function(){
			$(this).show();
		},function(){
			$(this).hide();
		})
	}
	else{
		$(".pullDownList").show();
	}

	/*二级导航 - 侧滑10个商品显示隐藏效果*/
	$(".pullDownList .pullnav-li").hover(function(){
			$(this).find(".dir_nav_a").addClass("dir_nav_aon");
			$(this).find(".item-sub").show();
		},function()
		{
			$(this).find(".dir_nav_a").removeClass("dir_nav_aon");
			$(this).find(".item-sub").hide();
		}
	)
});


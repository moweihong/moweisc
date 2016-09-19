$(function(){
	//调用登陆弹框
	$('#login').click(function(){
		var worldw=$(window).width();
		var worldh=$(window).height();
		$(".a_world_bg").css({height:worldh+"px"});
		$(".a_login_fixed_box").css({left:(worldw-$(".a_login_fixed_box").outerWidth())/2+"px",top:(worldh-$(".a_login_fixed_box").outerHeight())/2+"px"});
		$(".a_register_fixed_box").css({left:(worldw-$(".a_register_fixed_box").outerWidth())/2+"px",top:(worldh-$(".a_register_fixed_box").outerHeight())/2+"px"});
		//S 登录弹窗
		$(".a_login_fixed_box").show();
		$(".a_world_bg").show();
	});
	$(".a_login_world_close").click(function(){
		$(".a_world_bg").hide();
		$(".a_login_fixed_box").hide();
	});
		//E 登录弹窗 

	//banner列表
	$('.pullDownTitle').hover(function(){
		$('.pullDownList').show()
	},function(){
		$('.pullDownList').hide()
	});
		/*
	 * 收起数据点击事件
	 */
	$("#div_showmore").bind("click",function(){ 
		debugger;
	var O=$(this);
	var F=$("#div_nginner");
	var H=parseInt($('.ng-table-ul').height());
	if(parseInt(F.height())<=322){//当高度小于等于322的时候
	 	if(F.find('li').size() <=8){//当里面的数据少于或者等于八个点击后高度自适应
	 	F.height("auto");O.removeClass("up").html("<span>展开全部100条数据<b><s></s></b></span>");
	 	}else{//不然多余八个显示收起
	 	F.animate({height:H},function(){O.addClass("up").html("<span>收起<b><s></s></b></span>")})
		 }
	}else{
		if(F.find('li').size() <=8){//当里面的数据少于或者等于八个点击后高度自适应
		F.height("auto");O.removeClass("up").html("<span>展开全部100条数据<b><s></s></b></span>");
		}else{//不然当里面的数据少于或者等于八个点击后高度设成322px
		F.height("322px");O.removeClass("up").html("<span>展开全部100条数据<b><s></s></b></span>");
		}
	
	}});
	//页面下方人气商品鼠标滑过事件：展示查看详情 和 加入购物车按钮
	$(".c_pop_list li").hover(function(){
		$(".c_pop_list li").find(".c_pop_hover").hide();
			$(this).find(".c_pop_hover").show();
		},function(){
		   $(".c_pop_list li").find(".c_pop_hover").hide();
	});
     //最新元购记录和我的云购记录
	 $('#purchase_history').click(function(){
		 $(this).css('border-bottom','2px solid #FE0100');
		 $(this).css('color','black');
	    $('#my_history').css('border-bottom','2px solid #D8D5D0');
		$('#my_history').css('color','#9EA1A8');
		$('.w_period').show();
		$('.w_period2').hide();
	 })
	  $('#my_history').click(function(){
		$(this).css('border-bottom','2px solid #FE0100');
		$(this).css('color','black');
	    $('#purchase_history').css('border-bottom','2px solid #D8D5D0');
		 $('#purchase_history').css('color','#9EA1A8');
		$('.w_period2').show();
		$('.w_period').hide();
	 })
})


//计算结果选项卡
 	function tabChange(event) {
   		var index = $(event.target).index(".w_calculate_results .w_calculate_nav dd");
		if(parseInt(index) ==  0){
		$(".c_newest_prize").css("display", "none");
		$('.c_newest_prize_con').css("display","none");
		$($(".ng-data-inner")[index]).css("display", "block");
		}
		if (parseInt(index) == 1){ 
			//if($($(".ng-data-inner")[index]).css("display")=="none"&&timelineType){
				//调用展示购买记录
			$('.c_newest_prize').css("display","none");
			$(".ng-data-inner").css("display", "none");
			$('.c_newest_prize_con').css("display","block");
			//}
		}
		if (parseInt(index) == 2){ 
			// if($($(".ng-data-inner")[index]).css("display")=="none"&&sunType){
				//获取晒单列表
		    $('.c_newest_prize').css("display","block");
			$(".ng-data-inner").css("display", "none");
			$('.c_newest_prize_con').css("display","none");
			//	}  
		}
		
		$(".w_calculate_results .w_calculate_nav dd").removeClass("w_results_arrow");
		$(event.target).addClass("w_results_arrow");
		//$(".ng-data-inner").css("display", "none");
		//$($(".ng-data-inner")[index]).css("display", "block");
	};
/*
 * 购买框的加号事件(待完善..)
 */
function addBuyTimes(){
		var max = parseInt($(".w_detailsinputs").attr("max")),
            min = parseInt($(".w_detailsinputs").attr("min"));
		if (max - parseInt($(".w_detailsinputs").val()) >= min) {
		$(".w_detailsinputs").val(parseInt($(".w_detailsinputs").val())+min);
		}
		$(".w_detailsinputs").val($(".w_detailsinputs").val()+1);
		
}
/*
 * 购买框的减号事件
 */
	function cutBuyTimes(){
		var min = parseInt($(".w_detailsinputs").attr("min"));
	if (parseInt($(".w_detailsinputs").val()) - min > 0) {
		$(".w_detailsinputs").val(parseInt($(".w_detailsinputs").val())-min);
	};
	}
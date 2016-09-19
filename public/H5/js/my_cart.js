/**
 * Created by Administrator on 2016/3/3 0003.
 */

$(function(){
	
	$('input[name="checkCart"]').click(function(){
		refreshPriceTotal();
		var checked = false;
		$('input[name="checkCart"]').each(function(){
			if($(this).prop('checked')){
				checked = true;
				return false;
			}
		})
		
		if(checked == false){
			$('#sub_check').prop('checked', false);
			$('#submit_btn').removeAttr('onclick').css('background', '#999');
		}else{
			$('#sub_check').prop('checked', true);
			$('#submit_btn').attr('onclick', 'createOrder()').css('background', '#e63955');
		}
	})
	
	$('#sub_check').click(function(){
		var check = false;
		if($(this).prop('checked')){
			check = true;
		}
		
		$('input[name="checkCart"]').each(function(){
			$(this).prop('checked', check);
		})
		
		if(check == false){
			$('#sub_check').prop('checked', false);
			$('#submit_btn').removeAttr('onclick').css('background', '#999');
		}else{
			$('#sub_check').prop('checked', true);
			$('#submit_btn').attr('onclick', 'createOrder()').css('background', '#e63955');
		}
		
		refreshPriceTotal();
	})
	
	$('#deleteAll').click(function(){
		var _token = $("input[name='_token']").val();
		var g_ids = [];
		$('#listTable').find("input:checkbox:checked").each(function(){
			g_ids.push($(this).val());
		});
		
		$.ajax({
			url: '/deleteCart',
			type: 'post',
			dataType: 'json',
			data: {g_ids:g_ids,_token:_token},
			success: function(res){
				if(res.status == 0){
					var count = $('#listTable').find('tr').length;
					//删除成功，刷新购物车信息
					if(count == g_ids.length){
						var html = '<tr><td colspan="5" style="height:80px"><p style="color:#808080">您的清单里还没有任何商品，<a href="/" style="text-decoration:underline;color:#39f">马上去逛逛~</a></p></td></tr>';
						$('#listTable').find('tbody').html(html);
					}else{
						$('#listTable').find("input:checkbox:checked").each(function(){
							$(this).parents('tr').remove();
						});
					}

					$('#cartI').text(res.data.total.total_count);
					$('#priceTotal').text(res.data.total.total_amount);
					refreshPayAmount();
				}else if(res.status == ''){
					//未登录跳转
					window.location.href = '/login';
				}else{
					//删除失败
					myalert(res.message);
				}
			}
		})
	})
	
	//减少1
	$('.c-minus').click(function () {
		var nextval = parseInt($(this).siblings(".c-numinput").val()) - 1;
		if(nextval <= 0){
			$(this).attr("disabled","");
		}else{
			$(this).siblings("button").removeAttr("disabled");
			$(this).siblings(".c-numinput").val(nextval);
			amountChange($(this).parent().find(".buytimes"), 2);
		}

	});

	//增加 +1
	$(".c-plus").click(function () {
		var nextval = parseInt($(this).siblings(".c-numinput").val()) + 1;
		var last_person = parseInt($(this).parents('.c-prot-other').find(".last_person").text());
		if(nextval >= last_person){
			$(this).siblings(".c-numinput").val(last_person);
			$(this).attr("disabled","");
		}else{
			$(this).siblings("button").removeAttr("disabled");
			$(this).siblings(".c-numinput").val(nextval);
		}
		amountChange($(this).parent().find(".buytimes"), 1);
	});

	$(".c-numinput").blur(function(){
		var inpval = parseInt($(this).val());
		if(inpval == 0 || inpval == "" || inpval == null || isNaN(inpval)){
			$(this).val(1);
		}
	})
})

function actionSettlement() {
	$(".c_recharge_remind").show();
}

function onlyNum()
{
 if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
  if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
    event.returnValue=false;
}

function amountChange(obj, type){
	obj = $(obj);

	var buytimes = parseInt(obj.val());
	
	if (buytimes && /^[1-9]*[1-9][0-9]*$/.test(buytimes)) {
    } else {
    	obj.val();
    	buytimes = 1;
    }
	
	var tr_obj = obj.parents('.c-prot-other');
	var last_person = parseInt(tr_obj.find(".last_person").text());
	
	if(buytimes > last_person){
		buytimes = last_person;
		obj.val(last_person);
	}else{
		obj.val(buytimes);
	}

    var g_id = obj.attr('g_id');
    var _token = $("input[name='_token']").val();
    $.ajax({
        url: '/updateCart_m',
        type: 'post',
        dataType: 'json',
        data: {g_id:g_id,bid_cnt:buytimes,_token:_token,type:type},
        success: function(res){
            if(res.status == 0){

            }else{
                layer.alert(res.message, {title:false,btn:false});
            }
        }
    })
	refreshPriceTotal();
}

function refreshPriceTotal(){
	var priceTotal = 0;
	var count = 0;
	$("input[name='checkCart']:checked").each(function(){
		var obj = $(this).parents('.cart-probox').find('.buytimes');
		var buytimes = parseInt(obj.val());
		var minimum = parseInt(obj.attr('data-minimum'));
		
		priceTotal += buytimes * minimum;
		count++;
	})
	
	$('#sub_count').html(count);
	$('#priceTotal').html(priceTotal);
}

function addCart(g_id, bid_cnt){
	var _token = $("input[name='_token']").val();
	$.ajax({
		url: '/addCart',
		type: 'post',
		dataType: 'json',
		data: {g_id:g_id,bid_cnt:bid_cnt,_token:_token},
		success: function(res){
			if(res.status == 0){
				addCartAlert('添加成功');
				//添加成功，刷新购物车信息
				$('#cartI').text(res.data.count);
                $('#cartI').removeClass('hide');
			}else if(res.status == -1){
				//未登录
				addCartAlert('未登录');
			}else{
				//添加失败
				addCartAlert(res.message);
			}
		}
	})
}
//添加到购物车 不显示信息
function toCart(g_id, bid_cnt){
	var _token = $("input[name='_token']").val();
	$.ajax({
		url: '/addCart',
		type: 'post',
		dataType: 'json',
		data: {g_id:g_id,bid_cnt:bid_cnt,_token:_token},
		success: function(res){
			if(res.status == 0){
				location.href='/mycart_m';
				//添加成功，刷新购物车信息
				$('#cartI').text(res.data.count);
			}else if(res.status == -1){
				//未登录
				location.href='/login_m';
			}else{
				//添加失败
				myalert(res.message);
			}
		}
	})
}

function deleteCart(e){
	var _token = $("input[name='_token']").val();
	var del = $(e);
	var g_id = del.attr('g_id');
	$.ajax({
		url: '/deleteCart',
		type: 'POST',
		dataType: 'json',
		data: {g_id:g_id, _token:_token},
		success: function(res){
			if(res.status == 0){
				var count = del.parents('.mui-content').find('.cart-probox').length;
				//删除成功，刷新购物车信息
				if(count == 1){
					window.location.href = '/mycart_m_empty';
				}else{
					//del.parents('.cart-probox').remove();
                    window.location.reload();
				}

				//refreshPriceTotal();
			}else if(res.status == ''){
				//未登录跳转
				window.location.href = '/login';
			}else{
				//删除失败
				myalert(res.message);
			}
		}
	})
}

function createOrder(){
	var _token = $("input[name='_token']").val();
	var g_ids = {};
	$("input[name='checkCart']:checked").each(function(){
		//g_ids.push($(this).val());
		g_ids[$(this).val()] = {'bid_cnt':parseInt($(this).parents('.cart-probox').find('.buytimes').val()), 'minimum':parseInt($(this).parents('.cart-probox').find('.buytimes').attr('data-minimum'))};
	});
	
	$.ajax({
		url: '/createOrder_m',
		type: 'post',
		dataType: 'json',
		data: {g_ids:g_ids,_token:_token},
		success: function(res){
			if(res.status == 0){
				$('body').append(res.data);
				$('#subform').submit();
			}else{
				myalert('服务器异常');
			}
		}
	})
}

function wrap_tail(e){
	var that = $(e);
	var last = that.parents('.cart-probox').find('.last_person').text();
	that.parents('.cart-probox').find('.buytimes').val(last);
	
	amountChange(that.parents('.cart-probox').find('.buytimes'), 0);
}
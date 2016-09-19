/**
 * Created by Administrator on 2016/3/3 0003.
 */

var flag = false;

$(function(){
	$('#red').click(function(){
		if($(this).prop('checked') == true){
            if($('#klbean').prop('checked')){
                layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
                $(this).prop('checked', false);
                return false;
            }
			$(this).next().css('color', '#555');
			$('#redDiv').find('select').removeAttr('disabled');
		}else{
			$(this).next().css('color', '#999');
			$('#redDiv').find('select').attr('disabled', 'disabled');
			$("select[name='red']").val(0);
			refreshPayAmount();
		}
	})

    $('#klbean').click(function(){
        if($(this).prop('checked') == true){
            if($('#red').prop('checked')){
                layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
                $(this).prop('checked', false);
                return false;
            }
            $('.klbean_font').css('color', '#555');
        }else{
            $('.klbean_font').css('color', '#999');
        }
        refreshPayAmount();
    })
	
	$('#money').click(function(){
		if($(this).prop('checked') == true){
			$('.money_font').css('color', '#555');
		}else{
			$('.money_font').css('color', '#999');
		}
		refreshPayAmount();
	})
	
	$("select[name='red']").change(function(){
        if($('#klbean').prop('checked')){
            layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
            $('#red').prop('checked', false);
            $('#red').next().css('color', '#999');
            $('#redDiv').find('select').attr('disabled', 'disabled');
            $("select[name='red']").val(0);
            return false;
        }
		refreshPayAmount();
	})
	
	$('#SelectAll').click(function(){
		if($(this).prop('checked')){
			$('#listTable').find('input:checkbox').prop('checked', true);
		}else{
			$('#listTable').find('input:checkbox').prop('checked', false);
		}
		updateChoose();
	})
	
	$('input[name="checkCart"]').click(function(){
		updateChoose();
		var checked = false;
		$('input[name="checkCart"]').each(function(){
			if($(this).prop('checked')){
				checked = true;
				return false;
			}
		})
		
		if(checked == false){
			$('#submit_btn').removeAttr('onclick').css('background', '#999');
		}else{
			$('#submit_btn').attr('onclick', 'orderSubmit()').css('background', '#dd2726');
		}
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
				}else if(res.status == -1 && res.message == '未登陆'){
					//未登录跳转
					window.location.href = '/login';
				}else{
					//删除失败
					layer.alert(res.message, {title:false,btn:false});
				}
			}
		})
	})
	
	$(".add_n,.w_next").click(function(){
	    var inputObj=$(this).parent().children(".buytimes");
	    var last_person = parseInt($(this).parents('tr').find(".last_person").text());
	    if(parseInt(inputObj.val())>last_person){
	    	inputObj.val(parseInt(last_person));
	    }else{
	    	inputObj.val(parseInt(inputObj.val())+1);
	    }
	    amountChange(inputObj, 1);
	});
	
	$(".reduce_n,.w_pre").click(function(){
	    var inputObj=$(this).parent().children(".buytimes");
	    if(parseInt(inputObj.val())>1){
	    	inputObj.val(parseInt(inputObj.val())-1);
	    	amountChange(inputObj, 2);
	    }
	});
	
	$(".c_qq_close").click(function () {
	    $(".c_recharge_remind").hide();
	    $(".c_remind_bj").hide()
	});
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
    	obj.val(1);
    	buytimes = 1;
    }
	
	var tr_obj = obj.parents('tr');
	var last_person = parseInt(tr_obj.find(".last_person").text());
	var minimum = parseInt(tr_obj.find('.minimum').val());
	
	if(buytimes > last_person){
		buytimes = last_person;
		if(flag == true){
			obj.val(last_person);
			tr_obj.find('.subtotal').text(last_person*minimum);
			return ;
		}else{
			obj.val(last_person);
			tr_obj.find('.subtotal').text(last_person*minimum);
			type = 0;
			flag = true;
		}
	}else{
		obj.val(buytimes);
		tr_obj.find('.subtotal').text(buytimes*minimum);
		flag = false;
	}
	
	var red = 0, is_money = 0, klbean = 0;
	//是否使用红包
	if($('#red').is(':checked')){
		red = $("select[name='red']").val();
	}
    //是否使用块乐豆
    if($('#klbean').is(':checked')){
        klbean = 1;
    }
	//是否使用余额
	if($('#money').is(':checked')){
		is_money = 1;
	}

    if(red && klbean){
        layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
        return false;
    }
	
	if(!red && !is_money && !klbean){
		var subtotal = 0;
		//未使用红包、余额和块乐豆
		$('#listTable').find("input:checkbox:checked").each(function(){
			subtotal += parseInt($(this).parents('tr').find('.subtotal').text());
		});
		$('#priceTotal').text(subtotal);
		$('#rechargeMoney').text(subtotal);
	}
	
	var g_id = obj.parents('tr').find('.check').val();
	var _token = $("input[name='_token']").val();
	$.ajax({
		url: '/updateCart',
		type: 'post',
		dataType: 'json',
		data: {g_id:g_id,bid_cnt:buytimes,_token:_token,red:red,is_money:is_money,type:type,klbean:klbean},
		success: function(res){
			if(res.status == 0){
				if(red || is_money || klbean){
					$('#priceTotal').text(res.data.total.total_amount);
					$('#rechargeMoney').text(res.data.pay_amount);
					$('#minus-money').text(res.data.pay_money);
                    $('#minus-klbean').text(res.data.pay_klbean);
				}
			}else if(res.status == -3){   //红包抵扣失败
				$('#priceTotal').text(res.data.total.total_amount);
				$('#rechargeMoney').text(res.data.pay_amount);
                $('#minus-money').text(res.data.pay_money);
                $('#minus-klbean').text(res.data.pay_klbean);
				layer.alert(res.message, {title:false,btn:false});
			}else{
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})
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
				//layer.msg('添加成功!');
                $('.join-shop-car').show();
                $(".all_grey_bg").show();
				//添加成功，刷新购物车信息
				$('#cartI').text(res.data.count);
				setTimeout("$('.join-shop-car').hide();$('.all_grey_bg').hide();",1000);
			}else if(res.status == -1 && res.message == '未登陆'){
				//未登录跳转
				window.location.href = '/login';
			}else{
				//添加失败
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})
}

function deleteCart(e){
	var del = $(e);
	var g_id = del.attr('g_id');
	var _token = $("input[name='_token']").val();
	$.ajax({
		url: '/deleteCart',
		type: 'POST',
		dataType: 'json',
		data: {g_id:g_id, _token:_token},
		success: function(res){
			if(res.status == 0){
				var count = del.parents('tbody').find('tr').length;
				//删除成功，刷新购物车信息
				if(count == 1){
					var html = '<tr><td colspan="5" style="height:80px"><p style="color:#808080">您的清单里还没有任何商品，<a href="/" style="text-decoration:underline;color:#39f">马上去逛逛~</a></p></td></tr>';
					del.parents('tbody').html(html);
				}else{
					del.parents('tr').remove();
				}

				$('#cartI').text(res.data.total.total_count);
				$('#priceTotal').text(res.data.total.total_amount);
				refreshPayAmount();
			}else if(res.status == -1 && res.message == '未登陆'){
				//未登录跳转
				window.location.href = '/login';
			}else{
				//删除失败
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})
}

function updateChoose(){
	var _token = $("input[name='_token']").val();
	var g_ids = [];
	$('#listTable').find("input:checkbox:checked").each(function(){
		g_ids.push($(this).val());
	});

    var red = 0, is_money = 0, klbean = 0;
	//是否使用红包
	if($('#red').is(':checked')){
		red = $("select[name='red']").val();
	}
    //是否使用块乐豆
    if($('#klbean').is(':checked')){
        klbean = 1;
    }
	//是否使用余额
	if($('#money').is(':checked')){
		is_money = 1;
	}

    if(red && klbean){
        layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
        return false;
    }
	
	$.ajax({
		url: '/updateChoose',
		type: 'POST',
		dataType: 'json',
		data: {g_ids:g_ids,red:red,is_money:is_money,klbean:klbean,_token:_token},
		success: function(res){
			if(res.status == 0){
				$('#priceTotal').text(res.data.total.total_amount);
				$('#rechargeMoney').text(res.data.pay_amount);
				$('#minus-money').text(res.data.pay_money);
                $('#minus-klbean').text(res.data.pay_klbean);
			}else if(res.status == -3){   //抵扣失败
				$('#priceTotal').text(res.data.total.total_amount);
				$('#rechargeMoney').text(res.data.pay_amount);
				layer.alert(res.message, {title:false,btn:false});
			}else{
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})
}

function refreshPayAmount(){
	var _token = $("input[name='_token']").val();
	var red = 0, is_money = 0, klbean = 0;
	//是否使用红包
	if($('#red').is(':checked')){
		red = $("select[name='red']").val();
	}

    //是否使用块乐豆
    if($('#klbean').is(':checked')){
        klbean = 1;
    }

	//是否使用余额
	if($('#money').is(':checked')){
		is_money = 1;
	}

    if(red && klbean){
        layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
        return false;
    }
	
	if(!red && !is_money && !klbean){
		$('#rechargeMoney').text($('#priceTotal').text());
		$('#minus-money').text('0.00');
		$('#minus-klbean').text('0.00');
	}else{
		$.ajax({
			url: '/refreshPayAmount',
			type: 'POST',
			dataType: 'json',
			data: {_token:_token,red:red,is_money:is_money,klbean:klbean},
			success: function(res){
				if(res.status == 0){
					$('#rechargeMoney').text(res.data.pay_amount);
					$('#minus-money').text(res.data.pay_money);
                    $('#minus-klbean').text(res.data.pay_klbean);
				}else if(res.status == -1 || res.status == -2 || res.status == -3){
					$('#rechargeMoney').text(res.data.pay_amount);
					$('#minus-money').text(res.data.pay_money);
                    $('#minus-klbean').text(res.data.pay_klbean);
					layer.alert(res.message, {title:false,btn:false});
					$('#red').prop('checked', false);
					$('#red').next().css('color', '#999');
					$('#redDiv').find('select').attr('disabled', 'disabled');
					$("select[name='red']").val(0);
				}else if(res.status == -4){
                    layer.alert(res.message, {title:false,btn:false});

                    $('#red').prop('checked', false);
                    $('#red').next().css('color', '#999');
                    $('#redDiv').find('select').attr('disabled', 'disabled');
                    $("select[name='red']").val(0);

                    $('#klbean').prop('checked', false);
                    $('.klbean_font').css('color', '#999');
                }else{
					layer.alert(res.message, {title:false,btn:false});
				}
			}
		})
	}
}

function orderSubmit(){ 
	var _token = $("input[name='_token']").val();
	if($('#agreement').prop('checked') != true){
		layer.alert('请阅读并同意《服务协议》', {title:false,btn:false});
		return false;
	}
	
	var pay_flag = true;
	var paytype = '';
	var red = 0, is_money = 0, klbean = 0;
	//是否使用红包
	if($('#red').is(':checked')){
		red = $("select[name='red']").val();
	}
    //是否使用块乐豆
    if($('#klbean').is(':checked')){
        klbean = 1;
    }
	//是否使用余额
	if($('#money').is(':checked')){
		is_money = 1;
	}

    if(red && klbean){
        layer.msg('红包抵扣和块乐豆抵扣不能同时使用');
        return false;
    }
	
	_payTip();
	$(".paytype").each(function(){
		if($(this).attr('data-checked')==1){
			paytype = $(this).attr('data-paytype');
			
		}
		
	});
	
	var g_ids = [];
	$('#listTable').find("input:checkbox:checked").each(function(){
		g_ids.push($(this).val());
	});
	
	//检查订单是否已支付
	$.ajax({      
            type:"post",
            url:"/orderSubmit",
            data:{_token:_token,red:red,is_money:is_money,paytype:paytype,g_ids:g_ids,klbean:klbean},
            async :false,
            dataType:'json',
            success:function(res){
                if(res.status != 0){  //订单已支付
                	if(res.status == -2){
                		pay_flag = true;
                	}else{
                		layer.alert(res.message, {title:false,btn:false});
                    	pay_flag = false;
                        return false;
                	}
                }else{
                	pay_flag = true;
                	$('body').append(res.data.form);
                }  
            }    
     });
	if(pay_flag){
		$("#subform").submit(); 
		//console.log($("#weixin_sub"));
		
		close_box();
		payTip();
	}  
}




function _payTip(){ 
	var html='<div class="g_mask"  id="orderPopCon"><div class="g_popWarp" style="margin-left:-191px">';
        html+='<div class="g_popBg g_p5 pop_loading__300">';
        html+='<div class="g_popBgFff">';
        html+='<div class="com_loading">';
        html+='<img src="/foreground/img/pay-loader.gif" alt="">';
        html+='<p class="loading_txt">正在跳转支付平台，请稍后...</p>';
        html+='</div>';
        html+='</div>';
        html+='</div>';
        html+='</div></div>';     
        $(document.body).append(html);
}

function payTip(){
	var html='<div class="g_mask g_mask_tips"  id="orderPopCon"><div class="g_popWarp" style="margin-left:-191px">';
        html+='<div class="g_popBg g_p5 pop_bankingPay">';
        html+='<div class="g_popBgFff">';
        html+='<div class="g_popTit"><a href="javascript:" class="g_popColse" onclick="close_box_tips()">关闭</a><b class="pt_txt">支付提醒</b></div>';
        html+='<div class="p_bkp_box">';
        html+='<h4 class="tip"><s class="icon_error"></s>请勿关闭或刷新页面，正在跳转支付...</h4>';
//        html+='<p>付款成功：<a href="/user/buy">查看订单</a> 或 <a href="/">继续购物</a></p>';
//        html+='<p>付款失败：请联系客服处理！';
        //html+='<p>付款失败：<a href="#" target="_blank">查看帮助</a> 或 <a href="javascript:void(0)" onclick="close_box()">使用其他付款方式</a></p>';
        html+='</div>';
        html+='</div>';
        html+='</div>';
        html+='</div></div>';
    $(document.body).append(html);
}

function close_box(){ 
	$(".g_mask").remove();
}

function close_box_tips(){ 
	$(".g_mask").remove();
	window.location.href = '/user/buy';
}
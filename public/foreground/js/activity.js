/*var show_width=450;
 $(window).load(function(){
 $(".show_banner li img").each(function(){
 $(this).css({
 "margin-left":-($(this).width()-show_width)/2+"px"
 });
 });
 });*/


$(function () {

    $(".jcImgScroll li").addClass("img_shadow");

    var number_container_ul_html = $(".number_container ul").html();
    for (var i = 0; i < 6; i++) {
        $(".number_container ul").append(number_container_ul_html);
    }
    $(".show_banner_tab i").each(function (index) {
        $(this).click(function () {
            var imgSize = $(".show_banner_tab i").eq(index).attr("value");
            imgScrollInit(index, imgSize);
            $('#curdemo').val(index);
            editText();
        });
    });
    imgScrollInit(0, 10);
    $('#test').trigger('click');//初始化事件

    $("#smstmp1").trigger('click');
});

function imgScrollInit(index, imgSize) {
    var s = $(".jcImgScroll").eq(index).find("li");
    $(".jcImgScroll").hide();
    $(".jcImgScroll").eq(index).show();
    if (imgSize == s.length) {
        s.eq(0).before("<li><a href='#' path='" + s.eq(s.length - 1).find("a").attr("path") + "'></a></li>");
        s.eq(s.length - 1).after("<li><a href='#' path='" + s.eq(0).find("a").attr("path") + "'></a></li>");
        $(".jcImgScroll").eq(index).jcImgScroll({});
    }
}

var s= $(this).ScrollNum({
    single_top:54,//单个p元素的相对高度
    num:10
});

var people = $("#people").val();
var d1 = people.substring(0, 1);
var d2 = people.substring(1, 2);
var d3 = people.substring(2, 3);
var d4 = people.substring(3, 4);
var d5 = people.substring(4, 5);
var d6 = people.substring(5, 6);
var d7 = people.substring(6, 7);
setInterval(function () {//执行多次
    s.transferY2(0, 500, 18, d1);
    s.transferY2(1, 1200, 9, d2);
    s.transferY2(2, 2000, 9, d3);
    s.transferY2(3, 2600, 6, d4);
    s.transferY2(4, 3200, 3, d5);
    s.transferY2(5, 4000, 3, d6);
    s.transferY2(6, 4500, 2, d7);
}, 8000)
setTimeout(function(){//一进来就执行一次
    s.transferY2(0, 500, 18, d1);
    s.transferY2(1, 1200, 9, d2);
    s.transferY2(2, 2000, 9, d3);
    s.transferY2(3, 2600, 6, d4);
    s.transferY2(4, 3200, 3, d5);
    s.transferY2(5, 4000, 3, d6);
    s.transferY2(6, 4500, 2, d7);
}, 100)

$(function(){
    $("#number_one").on('input propertychange',function(e){
        var phone = $("input[name='phone']").val();
        if (phone && /^1\d{10}$/.test(phone)) {
            //手机号码验证通过，发起ajax查询这个手机号码是否需要付费
            var data = new Array();
            data['mobile'] = phone;
            $.ajax({
                url: '/checkMobileExist',
                method: 'POST',
                data: {'mobile': phone},
                success: function (data) {
                    if (data.status != '0') {
                        layer.confirm('号码' + phone + '是注册用户，您需要支付一块钱才能赠送!', {
                            btn: ['确认', '取消'] //按钮
                        }, function () {
                            //跳转到充值页面
                            $("input[name='phone']").val("");
                            if ($(".send_group_bg").css("display") == "none") {
                                $(".send_group_bg").show();
                            }
                            if (phone != "") {
                                $(".send_group_bg ul input").each(function (i) {
                                    if ($(this).val() == '') {
                                        $(this).val(phone);
                                        $(this).siblings("i").addClass("delete_ioc");
                                        return false;
                                    }
                                });
                            }
                            if ($(".send_group_bg ul input").eq(4).val() != "") {
                                $(".send_max_msg").show();
                            }
                            layer.msg({});
                        }, function () {
                            layer.msg('取消', {});
                        });
                    } else {

                    }

                }

            });
        }

    });
    $("#send_add").click(function () {
        var phone = $("input[name='phone']").val();
        if (phone && /^1\d{10}$/.test(phone)) {
            //手机号码验证通过，发起ajax查询这个手机号码是否需要付费
            var data = new Array();
            data['mobile'] = phone;
            $.ajax({
                url: '/checkMobileExist',
                method: 'POST',
                data: {'mobile': phone},
                success: function (data) {
                    if (data.status != '0') {
                        layer.confirm('号码' + phone + '是注册用户，您需要支付一块钱才能赠送!', {
                            btn: ['确认', '取消'] //按钮
                        }, function () {
                            //跳转到充值页面
                            $("input[name='phone']").val("");
                            if ($(".send_group_bg").css("display") == "none") {
                                $(".send_group_bg").show();
                            }
                            if (phone != "") {
                                $(".send_group_bg ul input").each(function (i) {
                                    if ($(this).val() == '') {
                                        $(this).val(phone);
                                        $(this).siblings("i").addClass("delete_ioc");
                                        return false;
                                    }
                                });
                            }
                            if ($(".send_group_bg ul input").eq(4).val() != "") {
                                $(".send_max_msg").show();
                            }
                            layer.msg({});
                        }, function () {
                            layer.msg('取消', {});
                        });
                    } else {
                        $("input[name='phone']").val("");
                        if ($(".send_group_bg").css("display") == "none") {
                            $(".send_group_bg").show();
                        }
                        if (phone != "") {
                            $(".send_group_bg ul input").each(function (i) {
                                if ($(this).val() == '') {
                                    $(this).val(phone);
                                    $(this).siblings("i").addClass("delete_ioc");
                                    return false;
                                }
                            });
                        }
                        if ($(".send_group_bg ul input").eq(4).val() != "") {
                            $(".send_max_msg").show();
                        }
                    }

                }

            });
        }
        else {
            if (phone != '')
                layer.msg('请输入正确的手机号码！');
        }
    });

});






$(".send_group_bg li i").click(function () {
    var inputObj = $(this).parent("li").children("input");
    inputObj.val("");
    $(this).removeClass("delete_ioc");
    $(".send_group_bg li").eq(4).after($(this).parent("li"));
    $(".send_max_msg").hide();
});

$(".group_send_btn").click(function () {
    $(".send_group_bg").hide();
    $(".send_max_msg").hide();
});


//将隐藏域中的数据抽取到窗体，将模板ID进行赋值
$('.smstmp').click(function () {
    var id = $(this).attr("id");
    if (id == 'smstmp1') {
        //获取隐藏域数据
        var smsval = $("#hidesmstem1").val();
        $('.smstext').attr('id', 'smstmp1');
    } else {
        var smsval = $("#hidesmstem2").val();
        $('.smstext').attr('id', 'smstmp2');
    }
    //获取用户选择的商品和商品name
    //当前demo
    var curdemo=$("#curdemo").val();
    var goodsname = $("#demo"+curdemo+" .select a").attr('name');
    //获取用户nickname
    if ($('#username').val()) {
        var nickname = $('#username').val();
    } else {
        var nickname = $('#username').attr('placeholder');
    }
    //对模板字符串进行替换
    smsval = smsval.replace('???', nickname);
    smsval = smsval.replace('XXX', goodsname);
    $('.smstext').val(smsval);
});

//显示短信数据
function editText() {
    var id = $('.smstext').attr("id");
    if (id == 'smstmp1') {
        //获取隐藏域数据
        var smsval = $("#hidesmstem1").val();
        $('.smstext').attr('id', 'smstmp1');
    } else {
        var smsval = $("#hidesmstem2").val();
        $('.smstext').attr('id', 'smstmp2');
    }
    //获取用户选则的商品和商品name
    var curdemo=$("#curdemo").val();
    var goodsname = $("#demo"+curdemo+" .select a").attr('name');
    //获取用户nickname
    if ($('#username').val()) {
        var nickname = $('#username').val();
    } else {
        var nickname = $('#username').attr('placeholder');
    }
    //对模板字符串进行替换
    smsval = smsval.replace('???', nickname);
    smsval = smsval.replace('XXX', goodsname);
    $('.smstext').val(smsval);
}

$("#username").change(function(){
	
	checkusername();
	
})

function checkusername()
{
	var myReg = /^[\u4e00-\u9fa5]+$/;
	var name=$("#username").val();
	var count=$("#username").val().length;
	if(!myReg.test(name))
	{
		layer.alert('姓名必须是中文哦，亲！');
		return false;
	}
	if(count<2 || count>5 )
	{
		layer.alert('姓名长度只能2到5哦，亲！');
		return false;
	}
	
}

//单数据进行确认发送事件
$('#send_one').click(function () {
	checkusername();
    //获取表单所有数据，并且进行校验
    var smsval = $('.smstext').val();
    var number_one = $('#number_one').val();
    if (number_one && /^1\d{10}$/.test(number_one)) {
    } else {
        layer.alert('手机号码格式错误！');
        return false;
    }
    //获取发送者nickname
    if ($("#username").val()) {
        var nickname = $("#username").val();
    } else {
        var nickname = $("#username").attr("placeholder");
    }
    //获取发送的商品名称
    var curdemo=$("#curdemo").val();
    var goodsname = $("#demo"+curdemo+" .select a").attr('name');
    //商品GID
    var gid =$("#demo"+curdemo+" .select a").attr('href').replace('/product/', '');
    //发送接口
    var url = $('#send_api').val();
    send_sms(number_one, smsval, nickname, goodsname, 'one', url, gid);
});

//群发短信
$(".group_send_btn").click(function () {
    //获取表单数据
    checkusername();
    var smsval = $('.smstext').val();
    var number = new Array();
    var error = 'false';
    $(".send_group_bg input[type='text']").each(function () {
        if ($(this).val() != '') {
            if ($(this).val() && /^1\d{10}$/.test($(this).val())) {
            } else {
                error = 'true';
                $(this).css("color", "red");
            }
            number.push($(this).val());
        }
    });
    if (!number[0]) {
        return;
    }
    if (error == 'true') {
        layer.alert('手机号码格式错误！');//手机号码错误，中断发送
        return false;
    }
    //获取发送者nickname
    if ($("#username").val()) {
        var nickname = $("#username").val();
    } else {
        var nickname = $("#username").attr("placeholder");
    }
    //获取发送的商品名称
    var curdemo=$("#curdemo").val();
    var goodsname = $("#demo"+curdemo+" .select a").attr('name');
    //商品GID

    var gid =$("#demo"+curdemo+" .select a").attr('href').replace('/product/', '');
    //发送接口
    var url = $('#send_api').val();
    send_sms(number, smsval, nickname, goodsname, 'group', url, gid);
});


/*短信接口调用*/
function send_sms(number, smsval, nickname, goodsname, from, url, gid) {
    //接收数据，再次封装
    var data = new Array();
    data['number'] = number;
    data['smsval'] = smsval;
    data['nickname'] = nickname;
    data['goodsname'] = goodsname;
    data['from'] = from;
    layer.alert('正在发送中,请稍等~');
    $.ajax({
        type: 'POST',
        url: url,
        data: {number: number, content: smsval, nickname: nickname, goodsname: goodsname, gid: gid},
        success: function (data) {
            var data = eval('(' + data + ')');
            if (data.status != '100000' && data.status != '0') {
                layer.alert(data.message);
                return false;//参数问题
            }
            data = data.data;
            if (data.is_send == 'send') {
                //发送成功，进行判断和前端反馈
                layer.alert('发送成功!');
                clearInput();
                return false;
            }
            if (data.is_send == 'nosend') {
                //发送失败，解析data数组，将其中需要扣费的记录进行检测，反馈给前端页面
                var group = 'no';
                var msg = data.msg;
                for (var i = 0; i < msg.length; i++) {
                    //检查哪个手机号码不支持
                    if (msg[i]['ismember'] == 'yes') {
                        //这个号码不支持发送短信，需要扣费之后才能发送,进行页面反馈。
                        if (from == 'one') {
                            //修改单个input控件
                            CommandConfirm(msg, data);
                            return false;
                        }
                        else {
                            group = 'yes';
                        }
                    }
                }
                //如果存在批量的手机号码
                if (group == 'yes') {
                    CommandConfirm(msg, data);
                    return;
                }
            }
            layer.alert('网络状态差，请再试一次！');
        }
    });
}

//对话框
function CommandConfirm(msg, data) {
    str = '你需要为';
    var count = 0;
    var number = new Array();
    var smsval = $('.smstext').val();
    //获取发送者nickname
    if ($("#username").val()) {
        var nickname = $("#username").val();
    } else {
        var nickname = $("#username").attr("placeholder");
    }
    //获取发送的商品名称
    var curdemo=$("#curdemo").val();
    var goodsname = $("#demo"+curdemo+" .select a").attr('name');
    //商品GID
    var gid =$("#demo"+curdemo+" .select a").attr('href').replace('/product/', '');
    for (var i = 0; i < msg.length; i++) {
        number.push(msg[i]['number']);
        if (msg[i]['ismember'] == 'yes') {
            str += ' ' + msg[i]['number'];
            count += 1;
        }
    }
    str += ' 等号码每个号码支付1元 总计' + count + '.00元';
    layer.confirm(str, {
        btn: ['确认支付', '取消'] //按钮
    }, function () {
        //进行异步支付操作
        //调用异步支付方法,传入支付数组
        //发送接口
        var url = $('#send_pay_api').val();
        //加载层
        layer.msg('正在支付中，请稍等~!', {icon: 1});
        $.ajax({
            type: 'POST',
            url: url,
            data: {number: number, content: smsval, nickname: nickname, goodsname: goodsname, gid: gid},
            success: function (data) {
                var data = eval('(' + data + ')');
                data = data.data;
                if (data.ispay == '1') {
                    //遍历msg，检查短信中内容是否有发送失败的
                    var msg = data.msg;
                    for (var i = 0; i < msg.length; i++) {
                        if (msg[i]['issend'] == 0) {
                            //短信未发送成功的记录 TODO
                            //return
                        }
                    }
                    clearInput();
                    layer.msg('支付完成,短信发送成功!', {icon: 1});
                    return;
                } else {
                    goRecharge();
                    return;
                }
                layer.alert('网络状态差，请再试一次！');
            }
        });

    }, function () {
        layer.msg('取消支付', {});
    });

}

//去充值对话框

function goRecharge() {
    layer.confirm('余额不足，需要充值才能继续发送~', {
        btn: ['去充值', '取消'] //按钮
    }, function () {
        //跳转到充值页面
        window.location.href = '/user/recharge_now';
    }, function () {
        layer.msg('取消', {});
    });
}

//清空表单
function clearInput() {
    $("#username").val('');
    $("#number_one").val('');
    $(".send_group_bg").children('li').val('');
}

//搜索按钮

$('.search_bg').click(function () {
    var key = $("#search_bg_input").val();
    if (!key) {
        return false;
    }
    //判断nothing是否存在，如果存在，怎替换nothing中的值
    if ($("#nothing").val() == 1) {
        $("#nothing").text(key);
    }
    //异步获取数据
    $.ajax({
        type: 'GET',
        url: '/activity/search?keyword=' + key,
        success: function (data) {
            var data = eval('(' + data + ')');
            data = data.data;
            if (data.length == 0) {
                layer.msg('您搜索的商品不存在~');
                return;
            }
            clearEvent();
            var str1 = '<i  value="' + data.length + '" id="nothing">' + key + '</i>';
            $("#category_more").before(str1);
            $(".jcImgScroll").css('display', 'none');
            //生成节点 重构数据
            str = '<div id="demon" class="jcImgScroll" style="display:block">' +
                '<ul>';
            for (var i = 0; i < data.length; i++) {
                str += '<li><a href="/product/' + data[i]['id'] + '" name="' + data[i]['title2'] + '" target="_blank"' +
                    'path="' + data[i]['thumb'] + '"></a></li>';
            }
            str += '</ul>' +
                '<div class="selected_bg"></div>' +
                '<div class="img_shadow_left"></div>' +
                '<div class="img_shadow_right"></div>' +
                '</div>';
            $(".show_banner_container").append(str);
            //刷新页面的demo节点
            $('#curdemo').val('n');
            //重新初始化事件
            $(function () {
                $(".jcImgScroll li").addClass("img_shadow");

                $(".show_banner_tab i").each(function (index) {
                    $(this).click(function () {
                        var imgSize = $(".show_banner_tab i").eq(index).attr("value");
                        imgScrollInit(index, imgSize);
                    });
                });
                imgScrollInit(0, 10);
                $("#nothing").trigger('click');
                editText();

            });
        }
    });

});

function clearEvent() {
    $("#demon").remove();
    $("#nothing").remove();
}

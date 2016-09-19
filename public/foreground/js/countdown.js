// JavaScript Document
var interval = 1000;  //倒计时延迟时间
var hmainter = 90;    //毫秒a延迟时间
var hmbinter = 40;    //毫秒b延迟时间
var objtime = $(".cut-time");

function hma(timehm,hmainter){
    var s = 9 ;
    var d= setInterval(function(){
        if(s <= 0){s = 9;}
        else{$( timehm).html(s);  s--;}
    }, hmainter);
    return d;
}

function ShowCountDown(y) {                    //倒计时延迟时间，不包括毫秒
	var now = new Date(); 
	var _d = y.attr("data-time");            // 获取截止时间
	var _ds = y.attr("data-id");            // 获取截止时间
	var endDate = new Date(_d).getTime();                       // 把截止时间准换成毫秒数
	var current_time = new Date($('#sys_cur_time').val()).getTime();
	var sys_second = endDate-current_time;     // 时间差毫秒数是
	var endDate_local = sys_second + new Date().getTime();

    var d= setInterval(function() {
		var leftTime = endDate_local - new Date().getTime();
		if(leftTime <= 0){
			y.text("正在计算...");
			y.attr('id','yes');
            clearInterval(d);
           // clearInterval(hmad1);
           // clearInterval(hmad2);
			}
		else{
			var leftsecond = parseInt(leftTime/1000); 
			var day1=Math.floor(leftsecond/(60*60*24));                              
			var hour=Math.floor((leftsecond-day1*24*60*60)/3600); 
			var minute=Math.floor((leftsecond-day1*24*60*60-hour)/60); 
			var second=Math.floor(leftsecond-day1*24*60*60-hour-minute*60); 
			
			if(minute<10){minute = "0" + minute}    //倒计时为1位数，前面增加0
			if(second<10){second = "0" + second}    //倒计时为1位数，前面增加0
			
			//y.find(".day").text(day1);
			//y.find(".hour").text(hour);
			y.find(".mini").text(minute);
			y.find(".sec").text(second);
			}
		},interval)
        setTimeout(function(){
            hmad1 = hma(y.find(".hma"), 80);
            hmad2 = hma(y.find(".hmb"), 20);
        },interval);

	}
$(document).ready(function(){
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: '/getsystime?'+new Date().getTime(),
		success: function(res){
			if(res.time){
				$("#sys_cur_time").val(res.time);
				for (var i = 0; i < objtime.length; i++) {  //获取obj对象
					ShowCountDown(objtime.eq(i));
				}

			}else{
				//window.location.reload();
			}
		}
	})
})

/*var s = 9 ;
function hma(timehm){
	 if(s <= 0){s = 9;}
	 else{$( timehm).html(s);  s--;}
	}
function hmb(timehm){
	 if(s <= 0){s = 9;}
	 else{$(timehm).html(s);  s--;}
	}
setInterval(function(){hma('.hma');}, hmainter);
setInterval(function(){hma('.hmb');}, hmbinter);
*/


var timeout = false; //启动及关闭按钮
$(function time()
{
    //获取页面所有倒计时的节点
    $(".cut-time").each(function(){
        if($(this).attr('id')=='yes'){
            getLotteryResult($(this).attr('data-id'));
        }
    });

	//if(timeout) return;
    var lottery_after = $(".lottery_after");
    if(lottery_after.length > 0){
        checklatest();
    }

	setTimeout(time,3000); //time是指本身,延时递归调用自己,100为间隔调用时间,单位毫秒
})();

function getLotteryResult(id){
    //获取开奖结果
    var url = "/index/getLotteryResult";
    $.ajax({
        type: 'GET',
        dataType: 'json',
        data: {o_id:id},
        url: url,
        success: function (data) {
            if(data.status == 0){
                var allcount = data.data.latest_count;
                $("#em_lotcount").html(allcount);
                data = data.data.data;
                var strbody = '';

                //$(".current").each(function(){
                //    console.log($(this).attr('id'));
                //    if($(this).attr('id')=='li'+data[i]['id']){
                //        appends=false;
                //    }
                //});

                strbody += '<dl class="m-in-progress">' +
                    '<div class="yjx"></div>' +
                    '<dt><a href="'+data.path+'" target="_blank" title="">' +
                    '<img class="lazy1" alt="' + data.title + '"' +
                    'src="'+data.thumb+'"' +
                    'data-original="' + data.thumb + '"' +
                    '>' +
                    '</a></dt>' +
                    '<dd id="u-name-yjx">恭喜<a href="'+data.usr_id+'"' +
                    'title=" ' + data.title + '">' + data.nickname + '</a>获得' +
                    '</dd><dd id="gray-hr"></dd>' +
                    '<dd id="yjx-detail"><a href="' + data.path + '" title="" id="yjx-detail-a">' + data.title + '</a></dd></dl>';

                $("#li"+id).html(strbody);
                $("#li"+id).addClass('lottery_after');
            }

        }
    });
}
function checklatest(){
    //通过ajax重新获取一个数据
    var url = "/index/checklatest";
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url,
        success: function (data) {
            if(data.status == 0){
                var allcount = data.data.latest_count;
                $("#em_lotcount").html(allcount);
                data = data.data.data;
                var strbody = '';
                var append_id = 0;
                for (var i = 0; i < data.length; i++) {
                    var appends=true;
                    $(".current").each(function(){
                        //console.log($(this).attr('id'));
                        if($(this).attr('id')=='li'+data[i]['id']){
                            appends=false;
                        }
                    });
                    if(appends)
                    {
                        append_id = data[i]['id'];
                        strbody += '<li id="li'+data[i]['id']+'" class="current">' +
                            '<dl class="m-in-progress">' +
                            '<div class="zzjx"></div>' +  //已揭晓的水印为将class改为yjx
                            '<dt><a href="'+data[i]['path']+'" target="_blank" title="">' +
                            '<img class="lazy1" alt="' + data[i]['title'] + '"' +
                            'src="'+data[i]['thumb']+'"' +
                            'data-original="' + data[i]['thumb'] + '"' +
                            '>' +
                            '</a></dt>' +
                            '<dd class="u-name"><a href="'+data[i]['path']+'"' +
                            'title=" ' + data[i]['title'] + '">' + data[i]['title'] + '</a>' +
                            '</dd><dd class="gray">价值：' + data[i]['money'] + '</dd>' +
                            '<dd class="u-time" id="dd_time">' +
                            '<em>揭晓倒计时</em><span class="cut-time" data-id="'+data[i]['id']+'" id="no" data-time="'+data[i]['ltime']+'"> <b class="mini">00</b> : <b class="sec">00</b> :  <b class="hma">0</b><b class="hmb">0</b></span>' +
                            '</dd></dl></li>';
                        break;
                    }
                }
                if(!strbody){
                    //resert();
                    return;
                }

                var current = $(".current");
                if(current.length == 5){
                    $(".lottery_after:last").remove();
                }

                $('#ul_Lottery').prepend(strbody);

                $.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: '/getsystime?'+new Date().getTime(),
                    success: function(res){
                        if(res.time){
                            $("#sys_cur_time").val(res.time);
                            ShowCountDown($('#li' + append_id).find('.cut-time'));
                        }else{
                            //window.location.reload();
                        }
                    }
                })
            }

        }
    });
}


function resert(){
    //通过ajax重新获取一个数据
    var url = "/index/getlatest";
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            var data = eval('(' + data + ')');
            var allcount = data.data.latest_count;
            $("#em_lotcount").html(allcount);
            data = data.data.data;
            var strbody = '';
            var appends=true;
            for (var i = 0; i < data.length; i++) {
                $(".current").each(function(){
                    console.log($(this).attr('id'));
                    if($(this).attr('id')=='li'+data[i]['id']){
                        appends=false;
                    }
                });
                if(appends)
                {
                    strbody += '<li id="li'+data[i]['id']+'" class="current">' +
                        '<dl class="m-in-progress">' +
						'<div class="zzjx"></div>' +  //已揭晓的水印为将class改为yjx
                        '<dt><a href="'+data[i]['path']+'" target="_blank" title="">' +
                        '<img class="lazy1" alt="' + data[i]['title'] + '"' +
                        'src="'+data[i]['thumb']+'"' +
                        'data-original="' + data[i]['thumb'] + '"' +
                        '>' +
                        '</a></dt>' +
                        '<dd class="u-name"><a href="'+data[i]['path']+'"' +
                        'title=" ' + data[i]['title'] + '">' + data[i]['title'] + '</a>' +
                        '</dd><dd class="gray">价值：' + data[i]['money'] + '</dd>' +
                        '<dd class="u-time" id="dd_time">' +
                        '<em>揭晓倒计时</em><span class="cut-time" data-id="'+data[i]['id']+'" id="no" data-time="'+data[i]['ltime']+'"> <b class="mini">00</b> : <b class="sec">00</b> :  <b class="hma">0</b><b class="hmb">0</b></span>' +
                        '</dd></dl></li>';
                    break;
                }
            }
            if(!strbody){
                resert();
                return;
            }
            $("#ul_Lottery").append(strbody);

            $.getScript("/foreground/js/countdown.js", function () {
            });

        }
    });

}
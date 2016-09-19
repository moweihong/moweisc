// //最新接晓倒计时;
// jQuery.fc=function (a,b,c,d,e,f)
//{
//  var ts = (new Date(a, b, c, d, e, f)) - (new Date());//计算剩余的毫秒数
// // var dd = parseInt(ts / 1000 / 60 / 60 / 24, 10);//计算剩余的天数
//  var hh = parseInt(ts / 1000 / 60 / 60 % 24, 10);//计算剩余的小时数
//  var mm = parseInt(ts / 1000 / 60 % 60, 10);//计算剩余的分钟数
//  var ss = parseInt(ts / 1000 % 60, 10);//计算剩余的秒数
// // dd = checkTime(dd);
//  hh = checkTime(hh);
//  mm = checkTime(mm);
//  ss = checkTime(ss);
//  //console.log("hh:"+hh+"-mm:"+mm+"-ss:"+ss)
//  $(".clock_div i").eq(0).html(hh);
//  $(".clock_div i").eq(1).html(mm);
//  $(".clock_div i").eq(2).html(ss);
//	return ts;
//}
//function checkTime(i)
//{
//  if (i < 10) {
//      i = "0" + i;
//  }
//  return i;
//}
$(".pay_back_bac").mouseenter(function(){
    $(this).hide();
    $(this).parent().children(".detail-btn").show();
});
$(".detail-btn").mouseleave(function(){
    $(this).hide();
    $(this).parent().children(".pay_back_bac").show();
});
$(".w-revealList-item").mouseover(function(){
    $(this).css({
        border:"1px solid red"
    });
});
$(".w-revealList-item").mouseout(function(){
    $(this).css({
        border:"1px solid #ddd"
    });
});


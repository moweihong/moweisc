/**
 * 该插件用于数字滚动(如老虎机)
 * 2016/4/5
 * author rss
 *
 */
(function($){
    $.fn.ScrollNum=function(options){
        var single_top = options.single_top;
        var num=options.num;
        var  p_div_height_start= 0;//div初始位置top
        this.transferY = function (index, delay,speed,number) {//index:第index个p_div,delay:延迟几秒才进行停止判断，number:希望摇出的数字
            var nums = getNums(num);//产生num个随机数
            if (number == undefined) {//如果未规定输出数字则随机
                number = parseInt(Math.random() * 10);
            }
            init(index, number, nums);//初始化位置
            p_div_height_start = parseInt($(".p_div").eq(0).css("top"));
            var p_div_height = p_div_height_start;
            var i = 0;
            var d = setInterval(function () {//移动外围包裹的div元素
                // console.log("p_div_height:"+p_div_height+",p_div_height_start:"+p_div_height_start)
                if (p_div_height >= single_top) {
                    p_div_height = p_div_height_start - single_top;
                    i = 0;
                } else if (p_div_height % single_top == 0) {//当为0时表示数字在正中间位置，刚好移动了一个数字的位置
                    i++;
                }
                p_div_height = p_div_height + speed;//(single_top / 4);//除以4控制速度，4次就可以下去一个完整数字的位置（必须得被single_top整除的数）
                $(".p_div").eq(index).css({"top": p_div_height + 8 + "px"});
            }, 10);

            
          var sit;
          var st=  setTimeout(function () {
        	  if(canGet){
        		  number = index == 0 ? one : (index == 1 ? two : three);
                  nums[num]=number;
                  var d1 = setInterval(function () {
                      if (p_div_height % single_top == 0) {//当为正中间位置且数字等于规定的数字时，停止滚动
                          if (nums[num - 1 - i] == number) {
                              clearInterval(d);
                              clearInterval(d1);
                              clearInterval(sit);
                          }
                      }
                  }, 1);
        	  }
            }, delay);
          
            sit= setInterval(function(){
                if(!running_flag && canGet){
                    clearTimeout(st);
                    clearInterval(sit);
                    
                    number = index == 0 ? one : (index == 1 ? two : three);
                    nums[num]=number;
                    var d1 = setInterval(function () {
                        if (p_div_height % single_top == 0) {//当为正中间位置且数字等于规定的数字时，停止滚动
                            // console.log(i + "-" + nums[num - 1 - i] + ":" + number);
                            if (nums[num - 1 - i] == number) {
                                clearInterval(d);
                                clearInterval(d1);
                            }
                        }
                    }, 1);
                }
            },200);

        }
            this.transferY2 = function (index, delay,speed,number) {//index:第index个p_div,delay:延迟几秒才进行停止判断，number:希望摇出的数字
                var nums = getNums(num);//产生num个随机数
                if (number == undefined) {//如果未规定输出数字则随机
                    number = parseInt(Math.random() * 10);
                }
                init(index, number, nums);//初始化位置
                p_div_height_start = parseInt($(".p_div").eq(0).css("top"));
                var p_div_height = p_div_height_start;
                var i = 0;
                var d = setInterval(function () {//移动外围包裹的div元素
                    // console.log("p_div_height:"+p_div_height+",p_div_height_start:"+p_div_height_start)
                    if (p_div_height >= single_top) {
                        p_div_height = p_div_height_start - single_top;
                        i = 0;
                    } else if (p_div_height % single_top == 0) {//当为0时表示数字在正中间位置，刚好移动了一个数字的位置
                        i++;
                    }
                    p_div_height = p_div_height + speed;//(single_top / 4);//除以4控制速度，4次就可以下去一个完整数字的位置（必须得被single_top整除的数）
                    $(".p_div").eq(index).css({"top": p_div_height + 8 + "px"});
                }, 10);


                setTimeout(function () {
                    var d1 = setInterval(function () {
                        if (p_div_height % single_top == 0) {//当为正中间位置且数字等于规定的数字时，停止滚动
                            //console.log(i + "-" + nums[num - 1 - i] + ":" + number);
                            if (nums[num - 1 - i] == number) {
                                clearInterval(d);
                                clearInterval(d1);
                            }
                        }
                    }, 1);
                }, delay);


        }
            function init(index, number, nums) {
                $(".p_div").eq(index).empty();
                for (var i = 0; i < nums.length; i++) {
                    $(".p_div").eq(index).append("<p>" + nums[i] + "</p>");
                }
                $(".p_div").eq(index).css({"top": (1 - nums.length) * single_top + "px"});

            }

            function getNums(num) {
                var a = new Array();
                for (var i = 0; i < num; i++) {
                    //var rand = parseInt(Math.random()*10);
                    a[i] = i;
                }
                return a;
            }
        return this;
    }
})(jQuery);
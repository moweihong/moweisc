@extends('foreground.mobilehead')
@section('title', '个人主页')
@section('footer_switch', 'hide')
@section('my_css')
   
   <style>
   html{
   	font-size: 100px;
   	}
   	body{
   	font-family: pingfang;
   	font-size: .12rem;
   	}
   .mui-bar-nav{
    width: 100%;
    max-height: 158px;
   	height: 180px;
    background: url("{{ $h5_prefix }}images/others_bg.jpg") no-repeat;
    background-size: 100% 100%;
    z-index:1;
    
   } 
   .mui-title b{
   	    font-size: .18rem;
   }
   .i-header{
   	margin-top: 35px;
   	text-align: center;
   	position: fixed;
   	width: 100%;
   	z-index: 1;
   }

   .my_photo img{
    width: 71px;
    height: 71px;
    margin-top: 8px;
    border-radius: 50%;
   }
   .nick_name{
   	font-size: .14rem;
    color: white;
   }
   .level_name{
   	font-size: .11rem;
    color: white;
    margin-top: -8px;
   }
   .content_menu ul li{
     width: 33.3%;
    display: inline-block;
    text-align: center;
    font-size: 14px;
   }
   .active{
   	color: #e63955;
  	border-bottom: 3px solid #e63955;
  	line-height: 30px;
   }
   .join_img{
   	width: 25.4%;
   	display: inline-block;
   }
   .join_img img{
   	width: 84%;
    margin: 8%;
   }
   .join_detail{
   	width: 71%;
   	display: inline-block;
   	vertical-align: top;
   }
   .join_detail p:first-child{
   	overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
   }
   .join_detail p{
   	font-size: .12rem;
   }
   .join_title{
   	font-size: 11rem;
   	color: #333333;
   }
   .join_btn{
      width: .75rem;
    height: .23rem;
    background: #E63955;
    font-size: .13rem;
    text-align: center;
    line-height: .23rem;
    color: white;
    display: inline-block;
    float: right;
    margin-right: 15px;
   }
   .join_count{
   	vertical-align: top;
   	line-height: .2rem;
   }
   .join_count .join_btn a{
   	color: white;
   }
   .join_count span,.join_member,.lucky_num{
   	color:#E63955;
   }
	.content_menu{
	background: white;
	}
 	.content_container{
 		padding-top: 194px;
 	    background: white;
 	}
 	.join_count a,.lucky_man{
 		color: #0072FF;
 	}
/* 	.lucky_container{
 	transform: scale(.46);
    margin-top: -13%;
    background: #F1F1F1;
    width: 140%;
    margin-left: -11%;
    padding-left: 10px;
 	}*/
 	.lucky_container{
 	 background: #F1F1F1;
 	}
 	.lucky_container ul li:nth-child(odd){
 	 width: 44%;
    display: inline-block;
 	}
 	.lucky_container ul li:nth-child(even){
 	 width: 54%;
    display: inline-block;
 	}
 	.lucky_container ul li p{
	 	 font-size:.08rem;
		text-align: left;
		line-height:.08rem;
		 -webkit-text-size-adjust: none;
 	}
 	.join_count p:first-child{
 		display: inline-block;
 	}
 	p{
 		margin: 0;
 	}
 	.award_record1,.shai_record,.hide{
 		display: none;
 	}
 	.content_detail-item{
 		border-bottom: 1px solid #F1F1F1;
 	}
 	.lucky_container p{
 		overflow: hidden;
 		text-overflow:ellipsis;
 		white-space: nowrap;
 	}
  .shai_record2{
  	padding: 15px 0 5px 0;
    border-bottom: 1px solid  #F1F1F1;
  }
  .shai-photo {
    width: 18%;
    display: inline-block;
    text-align: center;
}
.shai-detail img {
    width: 40px;
}
.shai-desc {
    width: 80%;
    display: inline-block;
    vertical-align: 3px;
}
.shai-desc p {
    font-size: .1rem;
    line-height: 16px;
}
.shai-desc span:nth-child(1) {
    font-size: .15rem;
    color: blue;
}
.shai-desc span:nth-child(2) {
    font-size: .1rem;
    right: 0;
    position: absolute;
    margin-right: 10px;
}

.shai-img {
    width: 80%;
    margin-left: 20%;
}
.shai-img img {
    width: 20%;
    margin-right: 15px;
}
.love-ioc-bg {
    text-align: right;
    font-size: .1rem;
    color: grey;
}
.love-ioc {
    width: 23px;
    height: 20px;
    display: inline-block;
    background: url("{{ $h5_prefix }}/images/love-ioc-group.png") 0 0 no-repeat;
    zoom: .6;
    vertical-align: middle;
}
.love-ioc-bg span {
    color: #e63955;
    margin-left: 20px;
    margin-right: 10px;
}
.love-ioc-bg .mui-icon {
    font-size: 15px;
}
.mui-icon {
    font-family: Muiicons;
    font-size: 24px;
    font-weight: normal;
    font-style: normal;
    line-height: 1;
    display: inline-block;
    text-decoration: none;
    -webkit-font-smoothing: antialiased;
}
.layer_number{
    position: fixed;
    top: 40%;
    background: white;
    width: 90%;
    height: 200px;
    left: 5%;
    z-index: 1;
    color: grey;
    word-break: break-all;
    border-radius: 7px;
    padding-bottom: 50px;
    display: none;
  
}
.grey_bg{
	width: 100%;
    height: 10000px;
    background: black;
    opacity: .9;
    position: fixed;
    top: 0;
    z-index: 1;
    border-radius: 8px;
    word-break: break-all;
    display: none;
}
.layer_number p{
	font-size: .16rem;
	color: #333333;
	text-align: center;
	line-height: 30px;
}
.layer_number ul li{
	   display: inline-block;
	   margin: 0 7px;
}
.confirm_btn{
	text-align: center;
    font-size: 20px;
    color:#E63955;
    position: absolute;
    bottom: 0;
    width: 100%;
    line-height: 40px;
    border-top: 1px solid #F1F1F1;
}
.scroll_content{
	height: 130px;
    overflow-y: scroll;
}
.love_active{
   background: url("{{ $h5_prefix }}/images/love-ioc-group.png") -41px 0 no-repeat;
}
      </style>
@endsection

@section('content')
        <!--首页头部 start-->
<div class="i-header">
	<p class="my_photo"><img src="{{ $userinfo->user_photo }}"</p>
	<p class="nick_name">{{ $userinfo->nickname }}</p>
	<p class="level_name">{{ $level }}</p>
	<input type="hidden" value="{{ $userid }}" id='singin'>
	<input type="hidden" value="{{ $himid }}" id='himid'>
	<div class="content_menu">
	<ul><li class="active" id="tab1">订单记录</li><li id="tab2">获得记录</li><li id="tab3">晒单记录</li></ul>
	</div>
</div>
<div class="content_container ygrecord-txt">
	
<div class="order_record0" id="tabContent1">
	<!--<div class="content_detail-item">
		<div class="join_img"><img src="{{ $h5_prefix }}images/phone_berry.png"/></div>
		<div class="join_detail">
			<p class="join_title">小米 红米Note 增强版  4G手机 双卡双待 （颜色随机）【包邮】</p>
			<div class="join_count">
			<p>总需1460 <div class="join_btn">再次购买</div></p>
			<p>本期参与：<span>1</span>人次<a>&nbsp;&nbsp;查看幸运号></a></p>
			</div>
		
		</div>
			<div class="lucky_container">
				<ul><li><p>中奖者:<span class="lucky_man">特速一块购</span></p></li>
				<li><p>本期参与：<span class="join_member">1</span>人次</p></li>
				<li><p>中奖号码:<span class="lucky_num">10000055</span></p></li>
				<li><p>揭晓时间:<span class="show_time">2016-5-27 17:19</span></p></li>
				</ul>
			</div>
	</div>-->
</div>


<div class="award_record1" id="tabContent2">
	<!--<div class="content_detail-item">
		<div class="join_img"><img src="{{ $h5_prefix }}images/phone_berry.png"/></div>
		<div class="join_detail">
			<p class="join_title">1小米 红米Note 增强版  4G手机 双卡双待 （颜色随机）【包邮】</p>
			<div class="join_count">
				<p>中奖号码:<span class="lucky_num">10000055</span>
				<p>本期参与：<span class="join_member">1</span>人次</p>
				<p>揭晓时间:<span class="show_time">2016-5-27 17:19</span><a data-buyno=''>&nbsp;查看幸运号></a></p>
			</div>
		</div>	
	</div>-->
</div>

<div class="shai_record2" id="tabContent3">
	<!--<div class="content_detail-item">
	    <div class="shai-detail">
	        <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"></div>
	        <div class="shai-desc">
	            <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p>
	        </div>
	    </div>
	    <div class="shai-img-bg">
	        <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"><img src="{{ $h5_prefix }}images/phone_berry.png"> <img src="{{ $h5_prefix }}images/phone_berry.png"></div>
	    </div>
	    <div class="love-ioc-bg"><i class="love-ioc"></i>攒人品 <span>试试手气<i class="mui-icon mui-icon-forward"></i></span></div>
	</div>-->

</div>


</div>
<div class="grey_bg"></div>
<div class="layer_number">
	<p>幸运号</p>
	<div class="scroll_content">
	<ul id='luckyshow'>
		
	<ul>
	</div>
	<div class="confirm_btn">确认</div>
</div>

<script>
  var type = 0;//订单记录 0;中奖记录 1;晒单记录 2:
    var page = 0;
   var loadOver = false; //避免用户点击过快或网络慢，出现加载出错
    var tab1page = 0;//订单记录的下一页
    var tab2page = 0;//中奖的下一页
    var tab3page = 0;//晒单下一页
    var tab1LoadEnd = false;//订单记录是否加载
    var tab2LoadEnd = false;//中奖是否加载
    var tab3LoadEnd = false;//晒单是否加载
    var dropload = {};
    var himid=$('#himid').val();//他人记录的uid
    $(document).ready(function(){
        dropload = $('.ygrecord-txt').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            if(type == 0){
                page = tab1page;
            }else if(type == 1){
                page = tab2page;
            }else if(type == 2){
                page = tab3page;
            }
            loadOver = false;
            $.ajax({
                type: 'GET',
                url: '/him_m/getajxaHisBuy',
                dataType: 'json',
                data:{page:page,type:type,himid:himid},
                success: function(data){
                    var list = data.data;
                    var html = '';
                    if(data.type == 0){
                        //订单记录
                        for(var i=0;i<list.length;i++){
                            html += '<div class="content_detail-item">'+
									'<div class="join_img" ><a data-url="/product_m/'+ list[i]['o_id']+'"><img src="'+ list[i]['img']+'"/></a></div>'+
									'<div class="join_detail">'+
										'<p class="join_title"><a data-url="/product_m/'+ list[i]['o_id']+'">'+ list[i]['productname']+'</a></p>'+
										'<div class="join_count">'+
										'<p>总需'+list[i]['money']+'<div class="join_btn"><a data-url="/product_m/'+ list[i]['o_id']+'">再次购买</a></div></p>'+
										'<p>本期参与：<span>' +list[i]['buycount'] + '</span>人次<a class="buynoclick" data-luckynum=' +list[i]['buyno']+ '>&nbsp;&nbsp;查看幸运号></a></p>'+
										'</div>';
								if(list[i]['is_lottery']==2){
										html+='<div class="lucky_container">'+
												'<ul><li><p>中奖者:<span class="lucky_man">' +list[i]['nickname']+ '</span></p></li>'+
												'<li><p >本期参与：<span class="join_member">' +list[i]['buycountl']+ '</span>人次</p></li>'+
												'<li><p>中奖号码:<span class="lucky_num">' +list[i]['fetchno']+ '</span></p></li>'+
												'<li><p>揭晓时间:<span class="show_time">' +list[i]['kaijiang_time']+ '</span></p></li>'+
												'</ul>'+
											'</div>';
								}
									html+='</div>';
						
								   html+='</div>';
                        }
                    }else if(data.type == 1){
                        //中奖记录
                        for(var i=0;i<list.length;i++){
                            html += '<div class="content_detail-item">'+
										'<div class="join_img"><a data-url="/product_m/'+ list[i]['o_id']+'"><img src="'+ list[i]['img']+'"/></a></div>'+
										'<div class="join_detail">'+
											'<p class="join_title"><a data-url="/product_m/'+ list[i]['o_id']+'">'+ list[i]['productname']+'</a></p>'+
											'<div class="join_count">'+
												'<p>中奖号码:<span class="lucky_num">' +list[i]['fetchno']+ '</span>'+
												'<p>本期参与：<span class="join_member">' +list[i]['buycountl']+ '</span>人次</p>'+
												'<p>揭晓时间:<span class="show_time">' +list[i]['kaijiang_time']+ '</span><a class="buynoclick" data-luckynum=' +list[i]['buyno']+ '>&nbsp;查看幸运号></a></p>'+
											'</div>'+
										'</div>'+	
									'</div>';
                        }
                    }else{
                        //晒单记录
                        for(var i=0;i<list.length;i++){
                            html += '<div class="content_detail-item">'+
									    '<div class="shai-detail">'+
									        '<div class="shai-photo"><img src="'+data['user_photo']+'"></div>'+
									        '<div class="shai-desc">'+
									           '<p><span>'+ list[i]['title']+'</span><span>'+ list[i]['time']+'</span></p> <p>'+ list[i]['content']+'</p>'+
									        '</div>'+
									    '</div>'+
									    '<div class="shai-img-bg">'+
									        '<div class="shai-img">';
									        for(var num=0;num<list[i]['imgnum'];num++){
									        
									        	html+='<img src="'+ list[i]['img'][num]+'">';
									        }
									        html+='</div>'+
									    '</div>'+
									    '<div class="love-ioc-bg admire_num"><span>'+list[i]['admire']+'</span><i data-id="'+ list[i]['id']+'" class="love-ioc"></i>攒人品 <span><a href="/product_m/'+list[i]['oid']+'">试试手气</a><i class="mui-icon mui-icon-forward"></i></span></div>'+
									'</div>';
                        }
                    }

                    if(list.length==0){
                        //暂无数据
                        if(data.type == 0){
                            tab1LoadEnd = true;
                        }else if (data.type == 1){
                            tab2LoadEnd = true;
                        }else{
                            tab3LoadEnd = true;
                        }
                        me.lock();
                        me.noData()
                        if(data.last_page == 0){
                            //无数据显示猜你喜欢
                           
                        }
                    }else{
                        //有数据
                        if(data.type == 0){
                            $('#tabContent1').append(html);	                
                            tab1page = data.current_page+1;
                        }else if(data.type == 1){
                            $('#tabContent2').append(html);
                            tab2page = data.current_page+1;
                        }else{
                            $('#tabContent3').append(html);
                            tab3page = data.current_page+1;
                        }
                    }
                    loadOver = true;
                    // 每次数据加载完，必须重置
                    me.resetload()
                },
                error: function(xhr, type){
                   // alert('服务器错误!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
    $('#tab1').click(function(){ 
           type = 0;
           $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
           if(!tab1LoadEnd){               
               //数据没有加载完  解锁 继续加载
               dropload.unlock();
               dropload.noData(false);
           }else{
                if(tab1page == 0){
                    //无数据显示猜你喜欢
                    $("#nullshow").show();  
                }
               dropload.lock();
               dropload.noData();
           }
           dropload.resetload();
        });
        $('#tab2').click(function(){
          type = 1;
          $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
          if(!tab2LoadEnd){              
              //数据没有加载完  解锁 继续加载
              dropload.unlock();
              dropload.noData(false);
          }else{
            if(tab2page == 0){
                //无数据显示猜你喜欢
                $("#nullshow").show();  
            }
              dropload.lock();
              dropload.noData();
          }
          dropload.resetload();
       });
        $('#tab3').click(function(){
          type = 2;
          $("#nullshow").hide();
            if(!loadOver){
                return false;
            }
          if(!tab3LoadEnd){             
              //数据没有加载完  解锁 继续加载
              dropload.unlock();
              dropload.noData(false);
          }else{
                if(tab3page == 0){
                    //无数据显示猜你喜欢
                    $("#nullshow").show();  
                }
              dropload.lock();
              dropload.noData();
          }
            dropload.resetload();
         });
    
    });
    
</script>
<script>

	$(".content_menu>ul>li").each(function(index){
		$(this).click(function(){
		$(".content_menu>ul>li").removeClass("active");
		$(this).addClass("active");
		$("[class*='_record']").hide();
		$("[class$='_record"+index+"']").show();
	});
	})
	$(document).on('click','.buynoclick',function(){
		
		var buyno=$(this).data('luckynum');
		var html='';
		html+='<li>'+buyno+'<li>';
		$('#luckyshow').html(html);
		
		$(".grey_bg,.layer_number").show();
	})
	
	$(".confirm_btn").click(function(){
		$(".grey_bg,.layer_number").hide();
	});
	$(document).on('click',".join_btn>a",function(){
		window.location.href=$(this).attr("data-url");
	});
	$(document).on('click',".join_title>a",function(){
		window.location.href=$(this).attr("data-url");
	});
	$(document).on('click',".join_img>a",function(){
		window.location.href=$(this).attr("data-url");
	});
	$(document).on('click',".love-ioc",function(){
		//alert($(this).prev("span").html())
		var userid=$('#singin').val();
		
    if(userid==-1)
    {
    	myalert('若要点赞，请先登录');
        location.href='/login_m';
    	return false;
    }
    $(this).unbind("click");
   // alert($(this).prev("span").html())
    var num = parseInt($(this).prev("span").html());
    var _token = $("input[name='_token']").val();
    var sid=$(this).attr('data-id');
    var type=1;
    var that = $(this);
    $.ajax({
		url:'/share_m/pushcomment',
		type:'post',
		dataType:'json',
		data:{ 'id': sid,'type':type,'_token':_token},
		success: function(res){
           if(res.status == 0){
        	   that.addClass('love_active');
        	   that.prev("span").html(num+1);
        	   that.parents('.love-ioc-bg').next().css('display', 'block'); 
           }else{
		       myalert(res.message);
           }
       }
    })
		
		
		
		
	});
</script>
@endsection


 
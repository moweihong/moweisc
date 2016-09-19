@extends('foreground.mobilehead')
@section('title', '我的红包')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:2rem}
	html{background-color:#EFEFF4}
	body .bounsR{
	 color: #999999;
     font-family: "微软雅黑";
	}
	.bounsR p{
		margin-left: 0.2rem;text-align: left;
	}
	.bounsR  .bouns_btn{
		width: .65rem;
	    background: grey;
	    height: .3rem;
	    line-height: .3rem;
	    text-align: center;
	    border-radius: 4px;
	    color: white;
	}
	#b1 .bouns_btn{
		background: #e63955;
	}
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
    <div class="_tab">
        <div id='tab1' class="active"><a>可使用</a></div>
		<div id='tab2' ><a>已使用/过期</a></div>
	</div>
            <div  id='b1'>
                    <!--ajax异步加载-->
<!--                <div class="bouns">
                   <div class='bounsL'>￥<span class='bouns_limit'>6</span></div>
                   <div class='bounsR'>
                       <div class='bouns_title'>红包抵用券</div>
                       <div class='bouns_desc'>红包描述文案文案文案</div>
                   </div>
                   <div style='clear:both;padding-top:0.05rem'>
                    <p style='float:left'>还有XX天过期</p>
                    <p style='float:right'>有效期至：2016-05-02</p>
                   </div>
                </div>-->
            </div>
            <div id='b2' style="display:none;">
<!--                <div class="bouns">
                   <div class='bounsL'>￥<span class='bouns_limit'>8</span></div>
                   <div class='bounsR'>
                       <div class='bouns_title'>红包抵用券</div>
                       <div class='bouns_desc'>红包描述文案文案文案</div>
                   </div>
                   <div style='clear:both;padding-top:0.05rem'>
                    <p style='float:left'>还有XX天过期</p>
                    <p style='float:right'>有效期至：2016-05-02</p>
                   </div>
                </div>-->
            </div>

<!--	   null start-->
<div id="nullshow" style="display:none;">
	   <div class="cart-null" style="padding-top: 0.3rem">
		   <center>红包空空的~~快去抽奖吧</center>
		   <a href="/freeday_m" class="cart-nulllinks">去 抽 奖</a>
	   </div>
<!--	   null end
	   猜你喜欢 start-->
	   <div class="faxbox sdshare-box">
		   <h2 class="faxboxh2 announce-boxtit">
			   <a >
				   <span class="boxtit-h2">猜你喜欢</span>
			   </a>
		   </h2>

           <div class="guess-pro mui-clearfix">
               @foreach($list as $val)
                   <div class="guess-probox">
                       <a href="/product_m/{{$val->id}}">
                           <div class="gue-proimg"><img src="{{$val->goods->thumb}}" onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" /></div>
                           <span class="gue-protxt">第({{$val->periods}})期{{$val->goods->title}}</span>
                           <div class="gue-progress"><div class="gue-progress-div" style="width:{{round($val->participate_person/$val->total_person*100,2)}}%;"></div></div>
                       </a>
                   </div>
               @endforeach
           </div>

	   </div>
</div>
<!--	   猜你喜欢 start-->
		 
	 
   </div>
@endsection

@section('my_js')
<script>
   var type = 0;//红包状态 0;未使用 1;已使用或已过期
    var page = 0;
    var loadOver = false; //避免用户点击过快或网络慢，出现加载出错
    var tab1page = 0;//未使用红包的下一页
    var tab2page = 0;//已使用或已过期的下一页
    var tab1LoadEnd = false;//未使用红包是否加载
    var tab2LoadEnd = false;//已使用或已过期的红包是否加载
    var dropload = {};
    $(document).ready(function(){
        dropload = $('.mui-content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            if(type == 0){
                page = tab1page;
            }else if(type == 1){
                page = tab2page;
            }
            loadOver = false;
            $.ajax({
                type: 'GET',
                url: '/user_m/bribery',
                dataType: 'json',
                data:{page:page,type:type},
                success: function(data){
                    var red = data.data;
                    var html = '';
                    for(var i=0;i<red.length;i++){
                        var btn_name = '';
                        if(red[i]['status'] == 1){
                            html += '<div class="bouns" onclick="location.href=\'/category_m\'">';
                            btn_name = '立即使用';
                        }else{
                            html += '<div class="bouns">';
                            btn_name = red[i]['enddays'];
                        }                        
                            html += "<div class='bounsL'>￥<span class='bouns_limit'>"+red[i]['money']+"</span></div>"+
                                    '<div class="bounsR">'+
                                       /* '<div class="bouns_title">'+red[i]['name']+'</div>'+*/
                                        "<div class='bouns_desc'>"+red[i]['desc']+"</div>"+
                                        "<p>有效期" + red[i]['starttime'] + "至："+red[i]['endtime']+"</p>"+
                                        "<p class='bouns_btn'>"+btn_name+"</p>"+
                                    
                                    '</div>'+
                                    '<div style="clear:both;padding-top:0.05rem">'+
                                    /* "<p style='float:left'>"+red[i]['enddays']+"</p>"+*/
                                     
                                    '</div>'+
                                '</div>';
                    }                    
                    if(red.length==0){
                        //最后一页就锁定，暂无数据
                        if(data.type == 0){
                            tab1LoadEnd = true;
                        }else{
                            tab2LoadEnd = true;
                        }
                        if(data.last_page == 0){
                            //无数据显示猜你喜欢
                            $("#nullshow").show();
                        }
                        me.lock();
                        me.noData()
                    }else{
                        if(data.type == 0){
                            $('#b1').append(html);	                
                            tab1page = data.current_page+1;
                        }else if(data.type == 1){
                            $('#b2').append(html);	                
                            tab2page = data.current_page+1;
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
    });
    $('#tab1').click(function(){
        type =0;
        $('#tab2').removeClass('active');
        $('#tab1').addClass('active');
        $('#b1').show();
        $('#b2').hide();  
        $("#nullshow").hide();
        if(!loadOver){
            return false;
        }
        if(!tab1LoadEnd){
            $("#nullshow").hide();
            //数据没有加载完  解锁 继续加载
            dropload.unlock();
            dropload.noData(false);
        }else{
            if(tab1page == 0){
                $("#nullshow").show();  
            }
            dropload.lock();
            dropload.noData();
        }
        dropload.resetload();
    });
     $('#tab2').click(function(){ 
        type =1;
        $('#tab1').removeClass('active');
        $('#tab2').addClass('active');
        $('#b2').show();
        $('#b1').hide();
         $("#nullshow").hide();
        if(!loadOver){
            return false;
        }
        if(!tab2LoadEnd){
            $("#nullshow").hide();
            //数据没有加载完  解锁 继续加载
            dropload.unlock();
            dropload.noData(false);
        }else{
            if(tab2page == 0){
                $("#nullshow").show();  
            }
            dropload.lock();
            dropload.noData();
        }
        dropload.resetload();
    });
</script>
@endsection



 



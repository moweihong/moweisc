@extends('foreground.mobilehead')
@section('title', '我的块乐豆')
@section('footer_switch', 'show')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
    <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
    <style>
        .mui-input-group::before {background-color:#fff}
        .mui-input-group .mui-input-row::after{background-color:#eee}
        .mui-input-group::after{background-color:#fff}
        p{font-size:0.12rem}
        .commission{height:48px;line-height:48px;color:#e63955}
        .mui-input-row{color:#666;}
        .mui-input-group .mui-input-row{height:0.6rem}

        .wdkld{height:1.4rem}
        .wdkld p:nth-child(1){margin-top:-9px}
        .wdkld p:nth-child(2){margin-top:-11px}
        .cz{width:40px;height:40px;background-color:#e63955;margin:-8px auto;border-radius:50%;line-height:40px;font-size:0.14rem;font-weight:800     }
        .cz a{color:#fff;}


    </style>

   {{--<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/footer_menu.css">--}}
	<style>
		html{font-size: 100px;}
		.mui-table-view-cell:after{left:0px}
		.img_item{width: 60px; vertical-align:baseline;}
		.mui-table-view-cell img{margin-right: 10px;}
		.item{display: inline-block; padding-left: 20px; margin-top: 10px;}
		.item span b{font-size: 16px; font-weight: normal; color:#333333; font-family: "Microsoft Himalaya"}
		.mui-table-view-cell p{ margin-top: 8px; font-family: "Microsoft Himalaya"}
		.kld-remain{padding: .35rem 0; text-align: center;    margin-bottom: 5px; background: white;}
		.kld-remain p{color: #e63955;}
		.kld-remain p:nth-child(1){font-size: .15rem;}
		.kld-remain p:nth-child(2){font-size: .26rem;}
		.kld-remain p:nth-child(3){font-size: .14rem;color: white;width: 36px;height: 36px;line-height:36px;background: #e63955; border-radius: 50%;    margin: 0 auto;}
		.kld-btngroup{text-align: center;background: white;    padding: 5px 0;}
		.mui-content input{    padding: 0;}
		.kld-btngroup input{width: 33%;height: 32px;border: 1px solid #e63955; background: white; font-size:.15rem; color: #333333;}
		.kld-btngroup input:first-child{margin-right: -6px;}
		.kld-btngroup .active{background: #e63955;color: white;    }
		.kld-content{background: white;margin-top: -1px;}
		.kld-mission{margin: 0 auto; padding-top: 5px;}
		.kld-mission p{padding:0 2%;font-size: .10rem;color: #999999;height: 45px;line-height: 45px;border-top: 1px solid #DEDEDE;    margin: 0;}
		.kld-mission b{font-size: .13rem; color: #333333;}
		.kld-mission input{width: 65px;height: 31px;background: #e63955;color: white;border-radius: 5px;font-size: .12rem; float: right;   border: 0;margin-top: 7px;}
		.kld-add  input{width: 60px;height: 33px;background: white;border: 1px solid  #e63955;color:  #e63955;margin-top: 6px;}
		.kld-add .red input{background: #e63955; color: white;}
	</style>
@endsection

@section('content')
 <div class="mui-content paddingbot90">
 	<div class="kld-remain">
 		<p>我的块乐豆</p>
 		<p>{{$totalScore}}</p>
 		<p><a href="/cz" style="color:white">充值</a></p>
 	</div>
 	<div class="kld-btngroup">
 		<input  type="button" value="块乐豆任务" class="active"/>
 		<input  type="button" value="块乐豆明细"/>
 	</div>
 	<div class="kld-content">
 		<div class="kld-mission" >
 			<p><b>火速抢宝</b>（每参与1元可获得1块乐豆）<input  class="mission-btn" type="button" value="去参与" data="/index_m"/></p>
 			<p><b>呼朋唤友</b>（邀请好友注册并消费可获得100块乐豆）<input class="mission-btn"  type="button" value="去邀请" data="alert"/></p>
 			<p><b>昭告天下</b>（成功晒单可获得100-500块乐豆）<input class="mission-btn" type="button" value="去晒单" data="/user_m/prize"/></p>
 			<p><b>客观贵姓</b>（完善个人资料可获得30块乐豆）<input class="mission-btn" type="button" @if($profile > 0) style="background-color:#999" value="已完善" data="#" @else  value="去完善" data="/user_m/userinfo" @endif/></p>
 		</div>
 		<div class="kld-add kld-mission hide" id="wrapper">
 			{{--<p><b>注册成功</b><input  type="button" value="+100"/></p>--}}
 			{{--<p><b>参与夺宝</b>（每消费一元+1 生日当天双倍）<input  type="button" value="+1"/></p>--}}
 			{{--<p><b>邀请一个好友参加</b><input  type="button" value="+100"/></p>--}}
 			{{--<p><b>好友首次充值</b><input  type="button" value="+100"/></p>--}}
 			{{--<p class="red"><b>成功晒单</b>（500-1500块乐豆）<input  type="button" value="+1500"/></p>--}}
 			{{--<p class="red"><b>完善资料</b>（全部完成奖励185块乐豆）<input  type="button" value="+800"/></p>--}}
            <div id="kl_content"></div>
 		</div>
 	</div>
 </div>

 <div class="popdiv popbox invite-prizes">
     <h2 class="popbox-h2">邀请有奖<i class="close-x js-closex"></i></h2>
     <div class="prizes-main">
         <p class="pri-des">邀请好友可免费参与活动，赶快邀友抢百万豪礼吧！<span style="color:red">微信里可直接戳右上角分享哦~</span></p>
         <div class="prizes-ico clearfix share_content_ioc bdsharebuttonbox" data-tag="share_1" style=" width: 181px;  margin: -8px auto;">
             {{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-qq.png" /></a>--}}
             {{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-wx.png" /></a>--}}
             {{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-sina.png" /></a>--}}
             {{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-tx.png" /></a>--}}
             {{--<a href="#" class="prizem-icoa"><img src="H5/images/dayfree/prizem-ico-pyq.png" /></a>--}}
             <a class="bds_sqq prizem-icoa"  data-cmd="sqq"  style="background: url('/H5/images/dayfree/prizem-ico-qq.png') no-repeat; height: 30px;display: block;width: 30px;background-size: 100% 100%;float:left"></a>
             <a class="bds_tsina prizem-icoa" data-cmd="tsina"  style="background: url('/H5/images/dayfree/prizem-ico-sina.png') no-repeat; height: 30px;display: block;width: 30px;background-size: 100% 100%;float:left"></a>
             {{--<a class="bds_weixin prizem-icoa" data-cmd="weixin"  style="background: url('/H5/images/dayfree/prizem-ico-wx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
             {{--<a class="bds_renren prizem-icoa" data-cmd="renren" style="background: url('/H5/images/dayfree/prizem-ico-tx.png') no-repeat; height: 22px;display: block;width: 22px;background-size: 100% 100%;float:left"></a>--}}
             <a class="bds_qzone prizem-icoa" data-cmd="qzone"  style="background: url('/H5/images/dayfree/prizem-ico-qzone.png') no-repeat; height: 30px;display: block;  width: 30px;background-size: 100% 100%;float:left"></a>
         </div>
     </div>
 </div>
 <div class="popbg black-bg"></div>
@endsection
@section('my_js')
<script>
    // myalert('提交成功，后台审核中<BR>预计XX个工作日到账');
    // myalert('充值成功，已到账，<BR>当前账户总余额￥300.3元。');
    var page = 0;
    $(document).ready(function(){
        var dropload = $('#wrapper').dropload({
            scrollArea : window,
            loadDownFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '/user_m/score',
                    dataType: 'json',
                    data:{page:page},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            html += '<div class="wdkld_list"><div class="left_kld">'+list[i]['pay']+'</div><div class="right_kld">';
                            if(list[i]['type'] == 6 || list[i]['type'] == 9){
                                html += '-'+list[i]['money']+'</div></div>';
                            }else{
                                html += '+'+list[i]['money']+'</div></div>';
                            }
                        }
                        if(list.length==0){
                            me.lock();
                            me.noData()
                        }else{
                            $('#kl_content').append(html);
                            page = data.current_page;
                            page++;
                        }

                        // 每次数据加载完，必须重置
                        me.resetload()
                    },
                    error: function(xhr, type){
                        //alert('服务器错误!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            },
            loadUpFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '/user_m/score',
                    dataType: 'json',
                    data:{page:0},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            html += '<div class="wdkld_list"><div class="left_kld">'+list[i]['pay']+'</div><div class="right_kld">';
                            if(list[i]['type'] == 6  || list[i]['type'] == 9){
                                html += '-'+list[i]['money']+'</div></div>';
                            }else{
                                html += '+'+list[i]['money']+'</div></div>';
                            }
                        }
                        if(list.length==0){
                            me.lock();
                            me.noData()
                        }else{
                            $('#kl_content').html(html);
                            page = data.current_page;
                            page++;
                        }
                        // 每次数据加载完，必须重置
                        me.resetload()
                        me.unlock();
                        me.noData(false);
                    },
                    error: function(xhr, type){
                        //alert('服务器错误!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            }
        });
    });
		
	$(".kld-btngroup input").each(function(i){
		$(this).click(function(){
			$(".kld-btngroup input").removeClass("active");
			$(this).addClass("active");
			$(".kld-content .kld-mission").hide();
			$(".kld-content .kld-mission").eq(i).show();
		});
	});

    $('.mission-btn').click(function(){
        var url = $(this).attr('data');
        if(url == 'alert'){
            $('.invite-prizes').show();
            $('.popbg').show();
        }else if(url != '#'){
            window.location.href = url;
        }
    })

    //弹窗-点击黑背景隐藏各个弹窗
    $('.popbg').on('click',function(){
        $(this).hide();
        $('.popdiv').hide();
    })

    $('.js-closex').on('click',function(){
        $('.popbg').hide();
        $(this).parents('.popdiv').hide();
    })
    //点击关闭按钮，关闭所有弹窗
    $('.js-closeall').on('click',function(){
        $(this).parents('.popdiv').hide();
        $('.popbg').hide();
    })

    window._bd_share_config = {
        common : {
            bdText : '一言不合就中iPhone，就问还！有！谁！',
            bdComment : '一言不合就中iPhone，就问还！有！谁！',
            bdDesc : '一言不合就中iPhone，就问还！有！谁！',
            bdUrl : "http://m.ts1kg.com/freeday_m?code={{session('user.id')}}",
            bdPic : 'http://m.ts1kg.com/foreground/img/wxshare.png'
        },
        share : [{
            "bdSize" : 16
        }]
    }

    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>

@endsection
 
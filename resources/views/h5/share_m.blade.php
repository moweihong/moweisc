@extends('foreground.mobilehead')
@section('title', '晒单')
@section('rightTopAction', '<span class="mui-icon mui-icon-plus" id="mui-icon"></span>')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/share_m.css">
@endsection

@section('content')
    <div class="mui-content">
   <div class="tab-title">
       <span class="tab-active" data-type="new">最新</span>
       <span class="" data-type="hot">最热</span>
        <input type="hidden" id='userid' value="{{ $userid }}">
   </div>
   <div  id="wrapper">
   <div class='wrapper_content'>
   @foreach($sdlist as $v)
       <div class="shai-item">
       <div class="shai-detail" data-id='{{$v->id }}'>
           <div class="shai-photo"><img src="{{ $v->user_photo  }}" onerror="javascript:this.src='{{ $h5_prefix }}images/tx-loading.png';" /></div>
           <div class="shai-desc">
               <p><span>{{ $v->nickname  }}</span><span>{{ $v->sd_time }}</span></p> <p>{{$v->sd_content }}</p>
           </div>
       </div>
       <div class="shai-img-bg">
           <div class="shai-img">
           @foreach($v->sd_photolist as $photo)
               <img src="{{$photo}}"/>
           @endforeach
           </div>
       </div>
       <div class="love-ioc-bg">
		   <span class="ico-loveit">
			   <i class="love-ioc heart" data-id='{{$v->id }}'></i>
			   <i class="admire_num">{{$v->sd_admire }}</i>
		   </span>
		   <a href="/product_m/{{$v->o_id }}"><b>我也来中奖<i class="mui-icon mui-icon-forward"></i></b><a>
	   </div>
       <div class="add-detail">
           <i class="love-ioc active"></i><span>{{ session('user.nickname')  }}</span>
       </div>
       </div>
   @endforeach
<!--        <div class="shai-item"> -->
<!--            <div class="shai-detail"> -->
<!--                <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"/></div> -->
<!--                <div class="shai-desc"> -->
<!--                    <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p> -->
<!--                </div> -->
<!--            </div> -->
<!--            <div class="shai-img-bg"> -->
<!--                <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"/><img src="{{ $h5_prefix }}images/phone_berry.png"/> <img src="{{ $h5_prefix }}images/phone_berry.png"/></div> -->
<!--            </div> -->
<!--            <div class="love-ioc-bg"><i class="love-ioc active"></i>点赞<span class="add-num">+1</span> <span>我也来中奖<i class="mui-icon mui-icon-forward"></i></span></div> -->
<!--            <div class="add-detail"> -->
<!--                <i class="love-ioc active"></i><span>一块就够了</span> -->
<!--            </div> -->
<!--        </div> -->
<!--        <div class="shai-item"> -->
<!--            <div class="shai-detail"> -->
<!--                <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"/></div> -->
<!--                <div class="shai-desc"> -->
<!--                    <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p> -->
<!--                </div> -->
<!--            </div> -->
<!--            <div class="shai-img-bg"> -->
<!--                <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"/><img src="{{ $h5_prefix }}images/phone_berry.png"/> <img src="{{ $h5_prefix }}images/phone_berry.png"/></div> -->
<!--            </div> -->
<!--            <div class="love-ioc-bg"><i class="love-ioc active"></i>点赞<span>我也来中奖<i class="mui-icon mui-icon-forward"></i></span></div> -->
<!--        </div> -->
   </div>
   </div>
    <div id="nullshow" style="display:none;">
           <div class="cart-null">
               <center>晒单空空的~~快去一块购</center>
           </div>
    </div>
   </div>
@endsection

@section('my_js')
<script type="text/javascript" src="{{ $h5_prefix }}js/mui.zoom.js"></script>
<script type="text/javascript" src="{{ $h5_prefix }}js/mui.previewimage.js"></script>
<script>
mui.previewImage();

var page = {{ $page }};

$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	var type = $('.tab-title').find('.tab-active').attr('data-type');
	    	$.ajax({
	    		type: 'GET',
	            url: '',
	            dataType: 'json',
	            data:{page:page,type:type},
	            success: function(data){
	            	var share = data.sdlist;
	                var html = '';
	                for(var key in share){
	                	html += '<div class="shai-item"><div class="shai-detail" data-id="'+share[key].id+'">';
	    	            html += '<div class="shai-photo"><img src="'+share[key].user_photo+'" onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/tx-loading.png\'\" /></div>';
	    	            html += '<div class="shai-desc"><p><span>'+share[key].nickname+'</span><span>'+share[key].sd_time+'</span></p> <p>'+share[key].sd_content+'</p></div>';
	    	            html += '</div>';
	    	            html += '<div class="shai-img-bg"><div class="shai-img">';
	    		        for(var i in share[key].sd_photolist){
	    					html += '<img src="'+share[key].sd_photolist[i]+'"  data-preview-src="" data-preview-group="1" />';
	    			    }
	    	            html += '</div></div>';
	    	            html += '<div class="love-ioc-bg"><span class="ico-loveit"><i class="love-ioc heart" data-id="'+share[key].id+'"></i><i class="admire_num">'+share[key].sd_admire+'</i></span> <a href="/product_m/'+share[key].o_id+'"><b>我也来中奖<i class="mui-icon mui-icon-forward"></i></b></a></div>';
	    	            html += '<div class="add-detail" style="display:none"><i class="love-ioc active"></i><span>'+"{{ session('user.nickname')  }}"+'</span></div></div>';
	    	        }

		            if(share.length < 10){
                        if(share.length == 0 && page == 0){
                            //无数据
                            $("#nullshow").show();
                        }
	            		// 锁定
                        me.lock();
                        // 无数据
                        me.noData();
		            }

		            page++;

		            $('#wrapper').find('.wrapper_content').append(html);
	                // 每次数据加载完，必须重置
	                me.resetload();
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    },
	    loadUpFn : function(me){
	    	var type = $('.tab-title').find('.tab-active').attr('data-type');
	    	$.ajax({
	    		type: 'GET',
	            url: '',
	            dataType: 'json',
	            data:{page:0,type:type},
	            success: function(data){
	            	var share = data.sdlist;
	                var html = '';
	                for(var key in share){
	                	html += '<div class="shai-item"><div class="shai-detail" data-id="'+share[key].id+'">';
	    	            html += '<div class="shai-photo"><img src="'+share[key].user_photo+'" onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/tx-loading.png\'\" /></div>';
	    	            html += '<div class="shai-desc"><p><span>'+share[key].nickname+'</span><span>'+share[key].sd_time+'</span></p> <p>'+share[key].sd_content+'</p></div>';
	    	            html += '</div>';
	    	            html += '<div class="shai-img-bg"><div class="shai-img">';
	    		        for(var i in share[key].sd_photolist){
	    					html += '<img src="'+share[key].sd_photolist[i]+'"  data-preview-src="" data-preview-group="1" />';
	    			    }
	    	            html += '</div></div>';
	    	            html += '<div class="love-ioc-bg"><span class="ico-loveit"><i class="love-ioc heart" data-id="'+share[key].id+'"></i><i class="admire_num">'+share[key].sd_admire+'</i></span> <a href="/product_m/'+share[key].o_id+'"><b>我也来中奖<i class="mui-icon mui-icon-forward"></i></b></a></div>';
	    	            html += '<div class="add-detail" style="display:none"><i class="love-ioc active"></i><span>'+"{{ session('user.nickname')  }}"+'</span></div></div>';
	    	        }
                    if(share.length == 0 && page == 0){
                        //无数据
                        $("#nullshow").show();
                    }
		            $('#wrapper').find('.wrapper_content').html(html);
		            page =1;
	                // 每次数据加载完，必须重置
	                me.resetload();
	            },
	            error: function(xhr, type){
	                //alert('服务器错误!');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
	        });
	    }
	    
	});

	$('.tab-title span').click(function(){
		$('.tab-title').find('span').removeClass('tab-active');
		$(this).addClass('tab-active');
		
		refreshCategory();
	})
}) 

function refreshCategory(){
	var type = $('.tab-title').find('.tab-active').attr('data-type');
	
	$.ajax({
        type: 'GET',
        url: '',
        dataType: 'json',
        data:{page:0,type:type},
        success: function(data){
        	var share = data.sdlist;
            var html = '';
            for(var key in share){
                html += '<div class="shai-item"><div class="shai-detail" data-id="'+share[key].id+'">';
                html += '<div class="shai-photo"><img src="'+share[key].user_photo+'" onerror=\"javascript:this.src=\'{{ $h5_prefix }}images/tx-loading.png\'\" /></div>';
                html += '<div class="shai-desc"><p><span>'+share[key].nickname+'</span><span>'+share[key].sd_time+'</span></p> <p>'+share[key].sd_content+'</p></div>';
                html += '</div>';
                html += '<div class="shai-img-bg"><div class="shai-img">';
                for(var i in share[key].sd_photolist){
                    html += '<img src="'+share[key].sd_photolist[i]+'"  data-preview-src="" data-preview-group="1" />';
                }
                html += '</div></div>';
                html += '<div class="love-ioc-bg"><span class="ico-loveit"><i class="love-ioc heart" data-id="'+share[key].id+'"></i><i class="admire_num">'+share[key].sd_admire+'</i></span> <a href="/product_m/'+share[key].o_id+'"><b>我也来中奖<i class="mui-icon mui-icon-forward"></i></b></a></div>';
                html += '<div class="add-detail" style="display:none"><i class="love-ioc active"></i><span>'+"{{ session('user.nickname')  }}"+'</span></div></div>';
            }

            $('#wrapper').find('.wrapper_content').html(html);
            page = 1;
        },
        error: function(xhr, type){
            //alert('服务器错误!');
        }
    });

//     $('.shai_detail').click(function(){
// 		var id = $(this).attr('data-id');
// 		window.location.href = '/sharedetail_m/'+id;
//     })
}

$(document).on('tap',".ico-loveit", function(){
	var userid=$("#userid").val();	
    if(userid==-1)
    {
    	myalert('若要点赞，请先登录');
        location.href='/login_m';
    	return false;
    }
    $(this).unbind("click");
    var num = parseInt($(this).find('.admire_num').text());
    var _token = $("input[name='_token']").val();
    
    var sid=$(this).find(".love-ioc").attr('data-id');
    var type=1;
    var that = $(this);
    $.ajax({
		url:'/share_m/pushcomment',
		type:'post',
		dataType:'json',
		data:{ 'id': sid,'type':type,'_token':_token},
		success: function(res){
           if(res.status == 0){
        	   that.find(".love-ioc").addClass('active');
        	   that.find('.admire_num').html(num+1);
        	   that.parents('.love-ioc-bg').next().css('display', 'block'); 
           }else{
		       myalert(res.message);
           }
       }
    })
});
$(document).on("tap","a",function(){
	window.location.href=$(this).attr("href");
});
$(document).on("tap",".shai-detail",function(){
	var id = $(this).attr('data-id');
	window.location.href = '/sharedetail_m/'+id;
});

$(function(){
	$('#rightTopAction').click(function(){
		var uid = "{{session('user.id')}}";
		if(uid && uid != 'undefined'){
			$.ajax({
				url: '/sharePlus',
				dataType: 'json',
				type: 'get',
				success: function(res){
					if(res.status == -2){
						myalert(res.message);
					}else if(res.status == 1 || res.status == 2){
						window.location.href = res.message;
					}else{
						window.location.href = '/login_m';
					}
				}
			})
		}else{
			window.location.href = '/login_m';
		}
	})
})
</script>
@endsection



 
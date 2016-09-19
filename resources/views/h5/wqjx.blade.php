@extends('foreground.mobilehead')
@section('title', '往期揭晓')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/common.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/product.css">
   <style>
		html,body{background:#ECECEC}
   </style>
@endsection

@section('content')
	<div class="wqjx_merge"></div>
	<div id="wrapper">
	<div class="wqcontent">
	
   </div>
   </div>
@endsection

@section('my_js')
<script>
var page = {{ $data['page'] }};
var gid = {{$gid}};

$(document).ready(function(){
   var dropload = $('#wrapper').dropload({
       scrollArea : window,
       loadDownFn : function(me){
         $.ajax({
               type: 'GET',
               url: '',
               dataType: 'json',
               data:{page:page,gid:gid},
               success: function(data){
                 var html = '';
                 $.each(data.goods, function(idx, item){console.log(item);

                     html += '<div class="wqjx">';
					 html += '	<div class="wqjx_title">';
					 html += '		第'+item.periods+'期 揭晓时间：'+item['fetchuser'][0]['bid_time'];
					 html += '	</div>';
					 html += '	<div class="wqjx_co mui-clearfix">';
					 html += '	 <a href="/product_m/'+item.id+'"><div class="wqjxL">';
					 html += '			<div class="wqjxTX"><img src='+item['fetchuser'][0]['user_photo']+' alt="" onerror="javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\';"></div>';
					 html += '		</div>';
					 html += '		<div class="wqjxR">';
					 html += '			<p>';
					 html += '				获得者：'+item['fetchuser'][0]['nickname']+'<BR/>';
					 html += '				幸运号码：<span class="wqjxRed">'+item['fetchuser'][0]['fetchno']+'</span><BR/>';
					 html += '				本次参与：<span class="wqjxRed">'+item['fetchuser'][0]['buycount']+'</span>人次<BR/>';
					 html += '				回报率：<span class="wqjxRed">'+item['fetchuser'][0]['rate']+'</span>倍';
					 html += '			</p>';
					 html += '		</div></a>';
					 html += '	</div>';
				     html += '</div>';

                 });

                  if(data.total < data.limit){
                     // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                  }

                  page++;

                  $('#wrapper').find('.wqcontent').append(html);
                   // 每次数据加载完，必须重置
                   me.resetload();
               },
               error: function(xhr, type){
                   // 即使加载出错，也得重置
                   me.resetload();
               }
           });
       },
       loadUpFn : function(me){
         $.ajax({
               type: 'GET',
               url: '',
               dataType: 'json',
               data:{page:0,gid:gid},
               success: function(data){
                    var html = '';
                    $.each(data.goods, function(idx, item){
                         html += '<div class="wqjx">';
						 html += '	<div class="wqjx_title">';
						 html += '		第'+item.periods+'期 揭晓时间：'+item['fetchuser'][0]['bid_time'];
						 html += '	</div>';
						 html += '	<div class="wqjx_co mui-clearfix">';
						 html += '		<div class="wqjxL">';
						 html += '			<div class="wqjxTX"><img src='+item['fetchuser'][0]['user_photo']+'" alt="" onerror="javascript:this.src=\'{{ $h5_prefix }}images/lazyload130.jpg\';"></div>';
						 html += '		</div>';
						 html += '		<div class="wqjxR">';
						 html += '			<p>';
						 html += '				获得者：'+item['fetchuser'][0]['nickname']+'<BR/>';
						 html += '				幸运号码：<span class="wqjxRed">'+item['fetchuser'][0]['fetchno']+'</span><BR/>';
						 html += '				本次参与：<span class="wqjxRed">'+item['fetchuser'][0]['buycount']+'</span>人次<BR/>';
						 html += '				回报率：<span class="wqjxRed">'+item['fetchuser'][0]['rate']+'</span>倍';
						 html += '			</p>';
						 html += '		</div>';
						 html += '	</div>';
					     html += '</div>';
                     });

                    $('#wrapper').find('.wqcontent').empty();
                    $('#wrapper').find('.wqcontent').prepend(html);
                   // 每次数据加载完，必须重置
                   me.resetload();
               },
               error: function(xhr, type){
                   // 即使加载出错，也得重置
                   me.resetload();
               }
           });
       }
   });
});
</script>
@endsection
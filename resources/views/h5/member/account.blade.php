@extends('foreground.mobilehead')
@section('title', '账户明细')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/user.css">
   <style>
	.mui-input-group::before {background-color:#fff}
	.mui-input-group .mui-input-row::after{background-color:#eee}
	.mui-input-group::after{background-color:#fff}
	p{font-size:0.12rem}
	.commission{height:48px;line-height:48px;color:#e63955}
	.reg-button{margin-top:0.5rem}
	label{color:#333}
	input{color:#A4A4A4}
	.finance{padding-top:0.18rem;width:20%;padding-left:0.1rem;float:left;height:0.8rem;position:relative}
	.sm{font-size:0.11rem}
	.bb{font-size:0.18rem;font-weight:600}
	.mui-input-row{color:#666;}
	.finance_r{padding-top:0.18rem;width:78%;text-align:right;float:right;padding-right:0.1rem;height:0.8rem}
	.mui-input-group .mui-input-row{height:0.8rem}
	 
   </style>
@endsection

@section('content')
   <div class="mui-content" >  
   
	   <div class="mui-input-group"  style='margin-top:0.06rem;' id="wrapper">
           <div id="account_content">
               
           </div>
           <!--异步加载-->
<!--	    <div class="mui-input-row" >
				<div class='finance'>
					<div>在线充值</div>					
					<div class='sm'>余额：0.00</div>		
				</div>
				<div class='finance_r'>
					<div>2016-04-15</div>					
					<div class='bb'>+33.00</div>					
				</div>
            </div>
-->
		</div> 
   </div>
@endsection

@section('my_js')
   <script>
var page = 0;
var h5_prefix = {{ $h5_prefix }};
$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	$.ajax({
	            type: 'GET',
	            url: '/user_m/account',
	            dataType: 'json',
	            data:{page:page},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
		                html += '<div class="mui-input-row" >'+
                                    '<div class="finance">'+
                                        "<div>"+list[i]['type']+"</div>"+
                                    '</div>'+
                                    '<div class="finance_r">'+
                                        "<div>"+list[i]['time']+"</div>"+
                                        "<div class=\"bb\">"+list[i]['amount']+"</div>"+
                                    '</div>'+
                                '</div>';
                    }                    
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{
                        $('#account_content').append(html);	                
                        page = data.current_page;
                        page++;
                    }

                    // 每次数据加载完，必须重置
                    me.resetload()
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
	            url: '/user_m/account',
	            dataType: 'json',
	            data:{page:0},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
		                html += '<div class="mui-input-row" >'+
                                    '<div class="finance">'+
                                        "<div>"+list[i]['type']+"</div>"+
                                    '</div>'+
                                    '<div class="finance_r">'+
                                        "<div>"+list[i]['time']+"</div>"+
                                        "<div class=\"bb\">"+list[i]['amount']+"</div>"+
                                    '</div>'+
                                '</div>';
                    }
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{
                        $('#account_content').html(html);	                
                        page = data.current_page;
                        page++;
                    }
                    // 每次数据加载完，必须重置
                    me.resetload()
                    me.unlock();
                    me.noData(false);
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



 



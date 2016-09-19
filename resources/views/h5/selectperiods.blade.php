@extends('foreground.mobilehead')
@section('title', '选择期数')
@section('my_css')
<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/selectperiods.css">
@endsection

@section('content')
<div class="mui-content" id="wrapper">
    <div class="mui-search">
        <div class="search-div"><img src="{{ $h5_prefix }}images/search_ioc.png"/> <input type="text" id="period" onkeyup="this.value=this.value.replace(/()\D/g,'')" placeholder="直接输入数字搜索期数"/>
        </div>
        <span class="search-btn"><input type="button" id="search_period" value="搜索"/></span>
        <input type="hidden" value="{{$max}}" id="max_period"/>
    </div>
    <ul id="select_content">
<!--        <li class="active">第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>
        <li>第7777期进行中</li>-->
    </ul>
</div>
@endsection

@section('my_js')
   <script>
       var page = 0;
       var gid={{$_GET['gid']}};
$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	$.ajax({
	            type: 'GET',
	            url: '/selectperiods_m',
	            dataType: 'json',
	            data:{page:page,gid:gid},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
                       if(list[i]['is_lottery'] == 0){
                            html +='<li class="active"><a id="'+list[i]['period']+'" href="/product_m/'+list[i]['id']+'">第'+list[i]['period']+'期进行中</a></li>';
                        }else{
                            html +='<li><a id="'+list[i]['period']+'" href="/product_m/'+list[i]['id']+'">第'+list[i]['period']+'期</a></li>';
                        }
                    }                    
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{
                        $('#select_content').append(html);	                
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
	            url: '/selectperiods_m',
	            dataType: 'json',
	            data:{page:0,gid:gid},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
                        if(list[i]['is_lottery'] == 0){
                            html +='<li class="active"><a id="'+list[i]['period']+'" href="/product_m/'+list[i]['id']+'">第'+list[i]['period']+'期进行中</a></li>';
                        }else{
                            html +='<li><a id="'+list[i]['period']+'" href="/product_m/'+list[i]['id']+'">第'+list[i]['period']+'期</a></li>';
                        }

                    }
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{
                        $('#select_content').html(html);	                
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
 

    $("#search_period").click(function(){
        var num = parseInt($("#period").val());
        var maxNum = parseInt($("#max_period").val());
        if(num <= 0 || num == 'undefined' || !num){
           myalert('请输入大于0的数字');
           $("#period").val('');
           return false;
        }
        if(num>maxNum){
            myalert('超过最大期数，请正确输入！');
            $("#period").val('');
            return false;
        }
        
        var hrefStr = $('#'+num).attr('href');
        if(hrefStr==''|| hrefStr == null){
            $.ajax({
				url: '/geturlbyperiod',
				type: 'get',
				dataType: 'json',
				data: {gid:gid,period:num},
				success:function(res){
					if(res.status == 0){
						location.href = res.data;
					}else{
						myalert('没有找到该期数，请输入正确的期数！');
			            $("#period").val('')
					}
				}
            })
        }else{
        	location.href = hrefStr;
        }
    })
   </script>
@endsection



 
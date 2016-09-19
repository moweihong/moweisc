@extends('foreground.mobilehead_search')
@section('rightTopAction', '搜索')
@section('search_ioc_switch', 'hide')
@section('my_css')
 <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/search_result.css">
@endsection

@section('content')
<div class="mui-content" id="wrapper">
    <div id="content">
        
   </div>
</div>
@endsection

@section('my_js')
<script type="text/javascript" src="{{ $h5_prefix }}js/dropload.min.js"></script>
<script type="text/javascript" src="{{ $h5_prefix }}js/my_cart.js"></script>
<script>
    var page = {{ $page }};
    var h5_prefix = {{ $h5_prefix }};

    $(document).ready(function(){
        var dropload = $('#wrapper').dropload({
            scrollArea : window,
            loadDownFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '',
                    dataType: 'json',
                    data:{page:page},
                    success: function(data){
                        var products = data.list.data;
                        var html = '';
                        $.each(products,function(id,item){
                            html += '<div class="display-item">';
                            html += '    <div class="phone-img"><a href="/product_m/'+item.id+'"><img src="'+item.thumb+'" /></a></div>';
                            html += '    <div class="phone-desc">';
                            html += '        <p><a href="/product_m/'+item.id+'">'+item.title+'</a></p>';
                            html += '        <p class="process-bar-bg"><i class="inner-process-bar-bg" style="width:'+(item.participate_person*100/item.total_person).toFixed(2)+'%"></i></p>';
                            html += '        <div><span>总需：'+item.total_person+'</span><span>剩余：<i>'+(item.total_person - item.participate_person)+'</i></span></div>';
                            html += '    </div>';
                            html += '    <div class="s-car" onclick="addCart('+item.g_id+',1)"><img src="{{ $h5_prefix }}images/s_car.png"/></div>';
                            html += '</div>';
                        });

                        if(products.length < 1){
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }
						
                        if(products.length < 1 && page == 1){
                        	html = '<div class="dropload-noData">暂无数据</div>';
                        }

                        page++;

                        $('#content').append(html);
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
                $.ajax({
                    type: 'GET',
                    url: '',
                    dataType: 'json',
                    data:{page:0},
                    success: function(data){
                        var products = data.list.data;
                        var html = '';
                        $.each(products,function(id,item){
                            html += '<div class="display-item">';
                            html += '    <div class="phone-img"><a href="/product_m/'+item.id+'"><img src="'+item.thumb+'" /></a></div>';
                            html += '    <div class="phone-desc">';
                            html += '        <p><a href="/product_m/'+item.id+'">'+item.title+'</a></p>';
                            html += '        <p class="process-bar-bg"><i class="inner-process-bar-bg"></i></p>';
                            html += '        <div><span>总需：'+item.total_person+'</span><span>剩余：<i>'+(item.total_person - item.participate_person)+'</i></span></div>';
                            html += '    </div>';
                            html += '    <div class="s-car" onclick="addCart('+item.g_id+',1)"><img src="{{ $h5_prefix }}images/s_car.png"/></div>';
                            html += '</div>';
                        });

                        if(products.length < 1){
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }

                        if(products.length < 1 && page == 1){
                        	html = '<div class="dropload-noData">暂无数据</div>';
                        }

                        page++;

                        $('#content').html(html);
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
    }) 

</script>
@endsection



 
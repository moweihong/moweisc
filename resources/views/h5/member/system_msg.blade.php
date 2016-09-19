@extends('foreground.mobilehead')
@section('title', '系统消息')

@section('my_css')
<style>
	html{
	font-size: 100px;

	}
	.mui-content *{
		    color: #666666;
		    /* font-family: "pingfang";*/
	}
	time{
		float: right;
		font-size: .11rem;
	}

	.mui-table-view-cell h1{
	 font-size: .14rem;
    display: inline-block;
	}
	.mui-table-view-cell h2{
		font-size: .11rem;
	}
	.mui-table-view-cell p{
	font-size: .11rem;
	display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
	}

	.detail-btn{
	font-size: .09rem;
    float: right;
    margin-top: 0px;
    text-decoration: underline;
	}

	.msg-detail{width: 95%;margin: 0 auto;padding: 20px 15px 55px 15px;font-size: .11rem;line-height: 22px;background: white;    margin-top: 10px;}
	.msg-detail h1{font-size: .14rem;display: inline;}
	.timestr{float: right;padding-right: 20px;}
	.send-person{text-align: right;}
    .unread-msg{height: 17px;font-size: .11rem;color: white; background: #e63955;border-radius:5px;font-style: normal;padding: 0 3px;display: inline-block;line-height: 17px;margin-left: 3px;    vertical-align: top;}
</style>
@endsection

@section('content')
 <div class="mui-content">
	   <div class="mui-input-group"  style='margin-top:0.06rem;' id="wrapper">
          <ul class="mui-table-view" id="account_content">
<!--                 <li class="mui-table-view-cell">
                     <div><h1>重要紧急防骗公告<i class="unread-msg">未读消息</i></h1><time>2016-03-02</time></div>
                    <h2><a>【重要紧急防骗公告】</a></h2>
                    <p>为自己私人QQ的昵称，以及把“特速一块购”特速一块购特速一块购特速一块购特速一块购特速一块购特速....</p>
                    <a class="detail-btn">查看详情</a>
                 </li>-->
            </ul>
		</div> 
 </div>

@endsection

@section('my_js')
<script>
    var page = 0;
    $(document).ready(function(){
        var dropload = $('#wrapper').dropload({
            scrollArea : window,
            loadDownFn : function(me){
                $.ajax({
                    type: 'post',
                    url: '/sysmessage',
                    dataType: 'json',
                    data:{page:page},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for(var i=0;i<list.length;i++){
                            if(list[i]['r_type'] == 0){
                                html += '<li class="mui-table-view-cell" onclick="window.location.href=\'/msginfo/'+list[i]['id']+'\'">'+
                                            '<div><h1>'+list[i]['title']+'<i class="unread-msg">未读消息</i></h1><time>'+list[i]['time']+'</time></div>'+
                                            '<h2><a>【'+list[i]['title']+'】</a></h2>'+
                                            '<p>'+list[i]['msg']+'</p>'+
                                            '<a href="/msginfo/'+list[i]['id']+'" class="detail-btn">查看详情</a>'+
                                         '</li>';
                            }else{
                                html += '<li class="mui-table-view-cell" onclick="window.location.href=\'/msginfo/'+list[i]['id']+'\'">'+
                                            '<div><h1>'+list[i]['title']+'</h1><time>'+list[i]['time']+'</time></div>'+
                                            '<h2><a>【'+list[i]['title']+'】</a></h2>'+
                                            '<p>'+list[i]['msg']+'</p>'+
                                            '<a href="/msginfo/'+list[i]['id']+'" class="detail-btn">查看详情</a>'+
                                         '</li>';
                            }
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
                    type: 'post',
                    url: '/sysmessage',
                    dataType: 'json',
                    data:{page:0},
                    success: function(data){
                        var list = data.data;
                        var html = '';
                        for (var i = 0; i < list.length; i++){
                            if(list[i]['r_type'] == 0){
                                html += '<li class="mui-table-view-cell" onclick="window.location.href=\'/msginfo/'+list[i]['id']+'\'">'+
                                            '<div><h1>'+list[i]['title']+'<i class="unread-msg">未读消息</i></h1><time>'+list[i]['time']+'</time></div>'+
                                            '<h2><a>【'+list[i]['title']+'】</a></h2>'+
                                            '<p>'+list[i]['msg']+'</p>'+
                                            '<a href="/msginfo/'+list[i]['id']+'" class="detail-btn">查看详情</a>'+
                                         '</li>';
                            }else{
                                html += '<li class="mui-table-view-cell" onclick="window.location.href=\'/msginfo/'+list[i]['id']+'\'">'+
                                            '<div><h1>'+list[i]['title']+'</h1><time>'+list[i]['time']+'</time></div>'+
                                            '<h2><a>【'+list[i]['title']+'】</a></h2>'+
                                            '<p>'+list[i]['msg']+'</p>'+
                                            '<a href="/msginfo/'+list[i]['id']+'" class="detail-btn">查看详情</a>'+
                                         '</li>';
                            }
                        }
                        if (list.length == 0){
                        me.lock();
                        me.noData()
                        } else{
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




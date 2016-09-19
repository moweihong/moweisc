/**
 * Created by Administrator on 2016/3/2 0002.
 */
/**
 * Created by Administrator on 2015/12/27.
 */


<!--评论（取消）点赞-->
$(".comment-border>i>img").click(function(){
	var that = $(this);
	var userid=$("#userid").val();
	
    if(userid==-1)
    {
    	layer.msg('若要点赞，请先登录');
    	return false;
    }
    
    var sid=$(this).data('id');
    var type=$(this).data('type');
    $.post("/share/pushcomment", { 'id': sid,'type':type,'userid':userid},
       function(data){data = eval('(' + data + ')');
       if(data.data == 0)
       {
    	   that.attr("src","/foreground/img/wujiaoxin_red.png");
    	    //$(this).addClass("comment-border-red");
    	    var num=parseInt(that.parent().parent().next().html());
    	    that.parent().parent().next().html(num+1);
    	    that.unbind("click");
       }else{
    	   layer.msg('客官，点一次就好了啦~');
       }
       
       })
});

$(document).ready(function(){
    $(".owl-item").css({"width":window.screen.width});
});

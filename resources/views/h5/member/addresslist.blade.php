@extends('foreground.mobilehead')
@section('title', '管理收货地址')
@section('my_css')
<link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/address_modify.css">
@endsection

@section('content')
<div class="mui-content" id="wrapper">
    <ul class="mui-table-view">
        <!--ajax异步加载-->
<!--        <li class="cell">
            <div class="address-info">
                <span>1特速一块购</span>
                <span>13666666666</span>
                <p>广东省深圳市福田区 广东省深圳市福田区泰然九路16号xx写字楼B座</p>
            </div>
            <div class="select-item">
                <div class="mui-radio"><input name="radio1" type="radio" checked><span>设为默认地址</span></div>

                <div class="btn_group"><div class="btn_edit">编辑</div><div class="btn_delete">删除</div></div>
            </div>
        </li>
        <li class="cell">
            <div class="address-info">
                <span>特速一块购</span>
                <span>13666666666</span>
                <p>广东省深圳市福田区 广东省深圳市福田区泰然九路16号xx写字楼B座</p>
            </div>
            <div class="select-item">
                <div class="mui-radio"><input name="radio1" type="radio"><span>设为默认地址</span></div>

                <div class="btn_group"><div class="btn_edit">编辑</div><div class="btn_delete">删除</div></div>
            </div>
        </li>
        -->
    </ul>
</div>
    <div class="bottom-btn" data-url="/user_m/address">新增收货地址</div>
@endsection

@section('my_js')
<script>

var page = 0;
$(document).ready(function(){
	var dropload = $('#wrapper').dropload({
	    scrollArea : window,
	    loadDownFn : function(me){
	    	$.ajax({
	            type: 'GET',
	            url: '/user_m/addresslist',
	            dataType: 'json',
	            data:{page:page},
	            success: function(data){
                    var list = data.data;
                    var html = '';
                    for(var i=0;i<list.length;i++){
                     html += '<li class="cell">'+
                                '<div class="address-info">'+
                                    "<span>"+list[i]['name']+"</span>"+
                                    "<span>"+list[i]['phone']+"</span>"+
                                    "<p>"+list[i]['addr']+"</p>"+
                                '</div>'+
                                '<div class="select-item">'+
                                    '<div class="mui-radio"><input name="radio1" type="radio" '+list[i]['default']+' data-id="'+list[i]['id']+'" id="isDefault"><span>设为默认地址</span></div>'+
                                    '<div class="btn_group"><div class="btn_edit" onclick="location.href=\'/user_m/editaddr/'+list[i]['id']+'\'">编辑</div><div data-id="'+list[i]['id']+'" id="btn_delete" >删除</div></div>'+
                                '</div>'+
                            '</li>';
                    }
                    if(list.length==0){
                        me.lock();
                        me.noData()
                    }else{
                        $('ul').append(html);
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
	    }
	});
    $(document).on('tap','#btn_delete', function(){
        var id=$(this).data("id");
        layer.open({
            content: '您确认删除吗？',
            btn: ['确认', '取消'],
            shadeClose: false,
            yes: function(){
               layer.open({content: '你确认了！', time: 1});
               delAddress(id);
            }, no: function(){
               layer.open({content: '你取消了！', time: 1});
            }
        });
    });
    $(document).on('tap','#isDefault', function(){
        var id=$(this).data("id");
        setDefault(id);
    });
 });
 //删除地址
 function delAddress(id) {
    $.ajax({
        type : 'post',
        url : '/user_m/deleteAddress',
        data : {
                id : id,
            _token : "{{csrf_token()}}",
        },
        dataType : 'json',
        success : function(data) {
            if(data.status<1){
                myalert(data.msg);
            }
            else{
                myalert(data.msg);
                location.reload();
            }
        }
    });
 }
 //设置默认地址
 function setDefault(id){
    $.ajax({
        type : 'post',
        url : '/user_m/setdefault',
        data : {
                id : id,
            _token : "{{csrf_token()}}",
        },
        dataType : 'json',
        success : function(data) {
            if(data.status<1){
                myalert(data.msg);
            }
            else{
                myalert(data.msg);
            }
        }
    });
 }
</script>
@endsection




@extends('foreground.master')
@section('my_css')
<link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/customer.css"/>
<link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/goods.css"/>
<link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css"/>
@endsection

@section('content')
<!--列表 start-->
<div class="w_con">
    <h4 class="w_guide">
        <a href="{{ url('index') }}">首页</a>
        <a href="javascript::void(0);" class="w_accord">全部商品</a>
    </h4>
    <!--商品板块 start-->
    <div class="w_goods_nav">
        <h2>商品搜索&nbsp;&nbsp; "<label class="w_goods_seach">{{ $searchval }}</label>"&nbsp;&nbsp;全部商品<span>（共<a href="javascript:void(0)" class="goodscount">{{ $list->total() }}</a>件商品）</span></h2>
    </div>
    <!--商品板块 end-->
    <!--排序 start-->
    <div class="w_product_con">
        <dl class="w_new">
            <dd>排列：</dd>
            <dd><a href="{{ url('search',['type'=>0,'$p'=>$searchval]) }}" class="{{ $type==0 ? 'w_announced':''}}">即将揭晓</a></dd>
            <dd><a href="{{ url('search',['type'=>1,'$p'=>$searchval]) }}" class="{{ $type==1 ? 'w_announced':''}}">剩余人次</a></dd>
            <dd><a href="{{ url('search',['type'=>2,'$p'=>$searchval]) }}" class="{{ $type==2 ? 'w_announced':''}}">热卖</a></dd>
            <dd><a href="{{ url('search',['type'=>3,'$p'=>$searchval]) }}" class="{{ $type==3 ? 'w_announced':''}}">最新商品</a></dd>
            <dd>
                @if ($type == 4)
                    <a class="w_last {{ $type==4 ? 'w_announced':''}}" href="{{ url('search',['type'=>5,'$p'=>$searchval]) }}">价格
                        <span class="w_jian_down"></span>
                    </a>
                @else
                    <a class="w_last {{ $type==5 ? 'w_announced':''}}" href="{{ url('search',['type'=>4,'$p'=>$searchval]) }}">价格
                        <span class="w_jian_up"></span>
                    </a>
                @endif
            </dd>
        </dl>
    </div>
    @if ($list->count()>0)
        <div class="w_goods_con">
            <ul class="w_goods_one">
                @foreach ($list as $val)
                    <li class="w_goods_details">
                        <div class="w_imgOut">
                            <a class="w_goods_img" href="{{url('product',['id'=>$val->id])}}" target="_blank">
                                <img id="img_0" class="lazy0"  src="{{$val->thumb}}" style="display: inline;">
                            </a>
                        </div>
                        <a class="w_goods_three" title="{{ $val->title }}" data-pid="372" data-gid="885" href="{{url('product',['id'=>$val->id])}}" target="_blank">(第{{$val->periods}}期) {{ $val->title }}</a>
                        <b>价值：￥{{$val->money}}</b>
                        <div class="w_line">
                            <span style="width:{{round($val->participate_person/$val->total_person*100,2)}}%"></span>
                        </div>
                        <ul class="w_number">
                            <li class="w_amount">{{$val->participate_person}}</li>                    
                            <li class="w_amount">{{$val->total_person}}</li>
                            <li class="w_amount">{{$val->total_person - $val->participate_person}}</li>
                            <li>已购买人次</li>
                            <li>总需人次</li>
                            <li>剩余人次</li>
                        </ul>
                        <div class="c_rob_box">
                            <dl class="w_rob">
                                <dd>
                                    <a class="w_slip"  onclick="addtoCart({{$val->g_id}},1)" href="{{url('mycart')}}">立即购买</a>
                                </dd>
                                <dd class="w_rob_out">
                                    <a class="w_rob_in" onclick="addCart({{$val->g_id}},1)" href="javascript:void(0);">加入购物车</a>
                                </dd>
                            </dl>
                        </div>
                    </li>   
                @endforeach            
            </ul>
        </div>
    @else
        <div id="pageStr" class="pageStr" style="margin: 64px auto;">
            <img src="{{ $url_prefix }}img/lis_icon.png">
        </div> 
    @endif

    <!-- 分页 start-->
    <div class="page">
        <div id="pageStr" class="pageStr" style="margin: 64px auto;">
            {!! $list->render()!!}
        </div>
    </div>
    <!-- 分页 end-->
</div>
<!--列表 end-->
<input type="hidden" id="catid" value="2"/>
<input type="hidden" id="order" value="default"/>
<input type="hidden" id="brandid" value="0"/>
<script>
     var str="<?php echo $searchval;?>";
     $("#searchVal").val(str);
</script>
@endsection

@section('my_js')
<script type="text/javascript">
function addtoCart(g_id,num)
{
	$.ajax({
		url: '/addCart',
		type: 'post',
		dataType: 'json',
		data: {'g_id':g_id,'bid_cnt':num,'_token':"{{csrf_token()}}"},
		success: function(res){
			if(res.status == 0){
				//添加成功，刷新购物车信息
				$('#cartI').text(res.data.count);
                location.href = '/mycart';
			}else if(res.status == ''){
				//未登录跳转
				window.location.href = '/login';
			}else{
				//添加失败
				layer.alert(res.message, {title:false,btn:false});
			}
		}
	})  
}
</script>
@endsection
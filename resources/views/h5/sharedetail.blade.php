@extends('foreground.mobilehead')
{{--@section('title', '晒单详情')--}}
@section('my_css')
  <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/share_detail.css">
@endsection

@section('content')
<div class="mui-content">
    <div class="share-top">
        <i><img src="{{ $info->user_photo }}"/></i>
        <div>
            <input type="hidden" id='userid' value="{{ $userid }}">
            <p>{{$info->nickname}}　<span class="share-tip">晒单奖励{{$info->kl_bean}}块乐豆</span></p>
            <p>众筹期数：第{{$info->sd_periods}}期</p>
            <p style="white-space: nowrap;text-overflow: ellipsis; overflow:hidden">获得商品：{{empty($info->title2) ? $info->title : $info->title2}}</p>
        </div>
    </div>
    <div class="share-content">
        <p>{{$info->sd_title}}</p>
        <span>{{$info->sd_time}}</span>
        <p>{{$info->sd_content}}</p>
        @foreach($info->sd_photolist as $photo)
        	<img src="{{ $photo }}"/>
        @endforeach
    </div>
    <div class="share-but mui-clearfix">
        <div class="share-good">
            @if($zanflag)
                <div class="admire-over" data-id="{{$info->id}}">已点赞</div>            
            @else
                <div class="admire" data-id="{{$info->id}}">点赞</div>
            @endif
        </div>
        @if($userid==-1)
        <a href="/login_m" class="share-goodbuy">立即参与</a>
        @else
        <a href="/product_m/{{$info->o_id}}" class="share-goodbuy">立即参与</a>
        @endif
    </div>
</div>
@endsection

@section('my_js')
<script>
$('.admire').click(function(){
	var userid=$("#userid").val();	
    if(userid==-1)
    {
    	myalert('若要点赞，请先登录');
        location.href='/login_m';
    	return false;
    }
	$(this).unbind("click");
    var _token = $("input[name='_token']").val();
    
    var sid=$(this).attr('data-id');
    var type=1;
    var that = $(this);
    $.ajax({
		url:'/share_m/pushcomment',
		type:'post',
		dataType:'json',
		data:{ 'id': sid,'type':type,'_token':_token},
		success: function(res){
           if(res.status == 0){
        	   myalert('点赞成功');
        	   that.text("已点赞").removeClass("admire").addClass("admire-over");
           }else{
		       myalert(res.message); 
           }
       }
    })
})
</script>
@endsection



 
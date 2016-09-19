@extends('foreground.mobilehead')
@section('title', '晒单详情')
@section('my_css')
  <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/share_detail.css">
  <style>
      .bottom-btn span{
          width:100%;
          background: #E63955;
          color:white;
      }
      
  </style>
@endsection

@section('content')
<div class="mui-content">
    <div class="share-top">
        <i><img onerror="javascript:this.src='{{ $h5_prefix }}images/lazyload130.jpg';" src="{{ $show->relateGood->thumb or $h5_prefix.'feedb-qqlogo.jpg' }}"/></i>
        <div>
            <p><span class="share-tip">晒单奖励{{$show->kl_bean}}块乐豆</span></p>
            <p>中奖码：{{$show->object->lottery_code}}</p>
            <p>获得商品：(第{{$show->sd_periods}}期){{$show->relateGood->title}}</p>
        </div>
    </div>
    <div class="share-content">
        <p>{{$show->sd_title}}</p>
        <span>{{date('Y-m-d',$show->sd_time)}}</span>
        <p>
            {{$show->sd_content}}
        </p>
        @foreach($show->sd_photolist as $val)
            <img src="{{$val}}"/>
        @endforeach
        
    </div>

    <div class="button-common fix-button"><button type="button" onclick="location.href='/category_m'" class="mui-btn mui-btn-danger mui-btn-block">立即购买</button></div>
</div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 
@extends('foreground.mobilehead')
@section('title', '微信支付')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css?v={{config('global.version')}}">
@endsection

@section('content')
   <div class="mui-content">
      <div class="wchat-error">
         <div class="circle-h2">X</div>
         <h2 class="error-h2">微信支付启用失败</h2>
         <p class="error-des">当前浏览器不支持微信支付，请关注微信公众号直接支付：<br />
            第一步：搜索并关注特速一块购公众号：<span style="color:#e63955">ts1kg2016</span><br />
            第二步：点击“一块就购”进入官网选择购物车。</p>
      </div>
   </div>
@endsection
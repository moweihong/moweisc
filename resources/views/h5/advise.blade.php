@extends('foreground.mobilehead')
@section('title', '意见反馈')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <div class="p-feedback-main">
         <div class="feedb-qqcode"><img src="{{ $h5_prefix }}/images/qqcode.jpg" /></div>
         <div class="feedb-other mui-clearfix">
            <img src="{{ $h5_prefix }}/images/feedb-qqlogo.jpg" class="feedb-qqlogo  mui-pull-left" width="42px">
            <div class="feedb-des">
               <span class="fb-dh2">特速一块购交流群</span>
               <span class="fb-dhdes">扫描二维码加入该群</span>
            </div>
         </div>
         <p class="feedb-deskld">（每次反馈奖励块乐豆）</p>
         <div class="reg-button"><a href="http://jq.qq.com/?_wv=1027&k=2EUZm6h" class="mui-btn mui-btn-danger mui-btn-block">点击加群</a></div>
      </div>
   </div>
@endsection





 
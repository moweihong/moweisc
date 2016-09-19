@extends('foreground.mobilehead')
@section('title', '晒单')
@section('rightTopAction', '<span class="mui-icon mui-icon-plus" id="mui-icon"></span>')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/share_m.css">
@endsection

@section('content')
    <div class="mui-content">
       <div class="shai-item">
       <div class="shai-detail">
           <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"/></div>
           <div class="shai-desc">
               <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p>
           </div>
       </div>
       <div class="shai-img-bg">
           <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"/><img src="{{ $h5_prefix }}images/phone_berry.png"/> <img src="{{ $h5_prefix }}images/phone_berry.png"/></div>
       </div>
       <div class="love-ioc-bg"><i class="love-ioc"></i>101 <span>我也来中奖<i class="mui-icon mui-icon-forward"></i></span></div>
       </div>
       <div class="shai-item">
           <div class="shai-detail">
               <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"/></div>
               <div class="shai-desc">
                   <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p>
               </div>
           </div>
           <div class="shai-img-bg">
               <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"/><img src="{{ $h5_prefix }}images/phone_berry.png"/> <img src="{{ $h5_prefix }}images/phone_berry.png"/></div>
           </div>
           <div class="love-ioc-bg"><i class="love-ioc active"></i>点赞<span class="add-num">+1</span> <span>我也来中奖<i class="mui-icon mui-icon-forward"></i></span></div>
           <div class="add-detail">
               <i class="love-ioc active"></i><span>一块就够了</span>
           </div>
       </div>
       <div class="shai-item">
           <div class="shai-detail">
               <div class="shai-photo"><img src="{{ $h5_prefix }}images/touxiang.png"/></div>
               <div class="shai-desc">
                   <p><span>一块就够了</span><span>2016-04-11</span></p> <p>中奖很开心，手机很不错。真心想中一个大苹果</p>
               </div>
           </div>
           <div class="shai-img-bg">
               <div class="shai-img"><img src="{{ $h5_prefix }}images/phone_berry.png"/><img src="{{ $h5_prefix }}images/phone_berry.png"/> <img src="{{ $h5_prefix }}images/phone_berry.png"/></div>
           </div>
           <div class="love-ioc-bg"><i class="love-ioc active"></i>点赞<span>我也来中奖<i class="mui-icon mui-icon-forward"></i></span></div>
       </div>
   </div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 
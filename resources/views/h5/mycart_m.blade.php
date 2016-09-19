@extends('foreground.mobilehead')
@section('title', '购物车')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--main start-->
      <div class="cart-container">
      @foreach ($list as $good)
         <!--box start-->
         <div class="cart-probox" id="{{ $good['cart_id'] }}">
            <div class="c-protit">
               <a class="c-protit-a" href="/product_m/{{$good['o_id']}}">{{ $good['title'] }}</a>
               <a href="javascript:void(0)" class="c-protit-del" g_id="{{$good['id']}}" onclick="deleteCart(this)">删除</a>
            </div>
            <div class="c-protxt mui-clearfix">
               <div class="c-prot-check">
                  <div class="mui-input-row mui-checkbox mui-left">
                     <label style="padding: 12px 0px;" class="checkbox"></label><input style="left:0px" name="checkCart" value="{{ $good['id'] }}" class="check-one check" type="checkbox" checked="checked">
                  </div>
               </div>
               <div class="c-prot-img"><a href="/product_m/{{$good['o_id']}}"><img src="{{ $h5_prefix }}images/lazyload130.jpg" data-echo="{{ $good['thumb'] }}" /></a></div>
               <div class="c-prot-other">
                  <div class="c-prot-des">总需<span class="color-df3051">{{ $good['total_person'] }}</span> <span style="padding-left: 2%;"> 剩余<span class="color-df3051 last_person">{{ $good['total_person'] - $good['participate_person'] }}人次</span></div>
                  <div class="c-prot-numbertxt">
                     <div class="c-mumdiv mui-clearfix">
                        <button class="c-minus" type="button ">-</button>
                        <input type="text" class="c-numinput buytimes" g_id="{{$good['id']}}" onchange="amountChange(this, 0);" maxlength="7" value="{{ $good['bid_cnt'] }}" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" data-minimum="{{$good['minimum']}}" />
                        <button class="c-plus" type="button ">+</button>
                     </div>
                  </div>
               </div>
               <div class="c-prot-sw"><a href="javascript:void(0)" onclick="wrap_tail(this)">包尾</a></div>
            </div>
         </div>
         <!--box end-->
      @endforeach
      </div>
      <!--main end-->

   </div>
   <div style="height: 122px;"></div>
   <!--结算 start-->
   <div class="cart-jiesuan">
      <div class="c-prot-check" style="margin-left: 4%; margin-top: 13px; height: 30px; overflow: hidden;">
         <div class="mui-input-row mui-checkbox mui-left">
            <label style="padding: 12px 0px;"></label><input style="left:0px" name="checkbox1" id="sub_check" value="Item 4" type="checkbox" checked="">
         </div>
      </div>
      <div class="cart-pertal">
         <span class="pertal-heji">总计：<b class="color-de2f51" id="priceTotal">{{$total_amount}}</b> 块</span>
         <span class="pertal-hjpro">共<span id="sub_count">{{count($list)}}</span>件商品</span>
      </div>
      @if(count($list) > 0)
      	<a href="javascript:void(0)" onclick="createOrder()" class="cart-jsbutton" id="submit_btn">去结算 ></a>
      @else
      	<a href="javascript:void(0)" style="background:#999" class="cart-jsbutton" id="submit_btn">去结算 ></a>
      @endif
   </div>
   <!--结算 end-->
@endsection

@section('my_js')
   <script>
   </script>
@endsection

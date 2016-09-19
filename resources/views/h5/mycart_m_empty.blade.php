@extends('foreground.mobilehead')
@section('title', '购物车')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--null start-->
      <div class="cart-null">
          <img src="{{ $h5_prefix }}images/cart-null.png" />
          <p class="cart-nulltxt">购物车空空的~~快去购买去吧</p>
          <a href="/category_m" class="cart-nulllinks">去 逛 逛</a>
      </div>
      <!--null end-->
      <!--猜你喜欢 start-->
      <div class="faxbox sdshare-box">
          <h2 class="faxboxh2 announce-boxtit">
              <a href="#">
                  <span class="boxtit-h2">猜你喜欢</span>
              </a>
          </h2>

          <div class="guess-pro mui-clearfix">
          @foreach ($objects as $obj)
              <div class="guess-probox">
                  <a href="/product_m/{{$obj->oid}}">
                      <div class="gue-proimg"><img src="{{$obj->thumb}}" /></div>
                      <span class="gue-protxt">@if($obj->title2){{$obj->title2}}@else{{$obj->title}}@endif</span>
                      <div class="gue-progress"><div class="gue-progress-div" style="width: {{$obj->rate}}%"></div></div>
                  </a>
              </div>
          @endforeach
          </div>

      </div>
      <!--猜你喜欢 start-->
</div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 
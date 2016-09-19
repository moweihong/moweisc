@extends('foreground.mobilehead')
@section('title', '图文详情')
@section('my_css')
   <meta http-equiv="Cache-Control" content="max-age=8640000" />
   <link rel="stylesheet" type="text/css" href="{{$h5_prefix}}css/product.css">
   <link rel="stylesheet" type="text/css" href="{{$h5_prefix}}css/common.css">
@endsection

@section('content')
<div class="mui-content">
   <div class='pro_co'>
	{!!$content->content!!}
   </div>
</div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 
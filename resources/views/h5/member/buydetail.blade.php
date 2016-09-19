@extends('foreground.mobilehead')
@section('title', '众筹详情')
@section('my_css')
  <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/buy_detail.css">
  <style>
     body .good-publish-p{
     font-size:0.14rem;
     }  
  </style>
@endsection

@section('content')
<div class="mui-content">
    @if($is_lottery == 2)
	<div class="good-show">
		<i class="img-show"><img src="{{ $img }}"/> </i>
		<div class="good-publish">
			<p class="p-title">(第{{$periods}}期){{$title}}</p>
            <p class="good-publish-p">价格：{{$money}}</p>
			<p class="good-publish-p">获得者：{{$name}}</p>
			<p class="good-publish-p">揭晓时间：{{$lotterytime}}</p>
			<div class="lucky-num good-publish-p">幸 运 号 码 {{$code}}</div>
		</div>
	</div>
    @else
	<div class="good-show">
		<i class="img-show"><img src="{{ $img }}"/> </i>
		<div class="good-publish">
			<p class="p-title">(第{{$periods}}期){{$title}}</p>
			<p class="good-publish-p">价格：{{$money}}</p>
            <p class="good-publish-p">参与：<span style="color: red;">{{count($buyno)}}</span> 人次</p>
		</div>
	</div>
    @endif
	<div class="code-record">
		<p class="good-publish-p">{{$time}}</p> 
		<ul>
            @if($is_lottery == 2)
                @foreach($buyno as $val)
                    @if($code == $val)
                        <li class="active good-publish-p">{{$val}}</li>
                    @else
                        <li class="good-publish-p">{{$val}}</li>
                    @endif                    
                @endforeach
            @else
                @foreach($buyno as $val)            
                    <li class="good-publish-p">{{$val}}</li>
                @endforeach
            @endif
        </ul>
	</div>
</div>
@endsection

@section('my_js')
   <script>
   </script>
@endsection



 
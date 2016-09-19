@extends('foreground.mobilehead_search')
@section('rightTopAction', '搜索')
@section('my_css')
 <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/search.css">
@endsection

@section('content')
 <div class="mui-content">
 <div class="search-history">
			<p><img src="{{ $h5_prefix }}images/search_ioc.png"/>最近搜索</p>
			@if ($history)
			@foreach ($history as $val)
			<a href="/search_m_result?key={{$val}}"><input type="button" value="{{$val}}"/></a>
			@endforeach
			@else
			<p class="none-history">暂无搜索历史</p>
			@endif

 </div>
 <div class="search-hot">
		 <p><img src="{{ $h5_prefix }}images/hot_ioc.png"/>热门搜索</p>
			@if ($hot)
			@foreach ($hot as $val)
			<a href="/search_m_result?key={{$val->keyword}}"><input type="button" value="{{$val->keyword}}"/></a>
			@endforeach
			@else
			<p class="none-history">暂无搜索</p>
			@endif
 </div>
 <div class="clear-history"><input type="button" value="清空搜索记录"/></div>
 </div>
@endsection

@section('my_js')
	 <script>
		$(function(){
			$('.clear-history').click(function(){
	             $.ajax({
                    url: '/search_cookie',
                    data:{name:'keyword_{{session('user.id')}}'},
                    success: function(data){
                    	location.href="/search_m";
                    }
                });
			});
		});
	 </script>
@endsection



 
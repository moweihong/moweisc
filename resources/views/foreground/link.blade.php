@extends('foreground.master')

@section('content')
        <!--footnews start-->
<div class="footnews-container clearfix">
    <!--当前位置 start-->
    <div class="yg-positioncont">
        <a href="/index">首页</a><span class="sep">&gt;</span> <a href="#">友情链接</a>
    </div>
    <!--当前位置 end-->
    <!--main start-->
    <div class="footnews-main">
        <!--content start-->
        <div class="footnews-right">
            <h2 class="fnews-m-tit">文字链接</h2>
            <div class="fnews-m-content">
                <ul>
                    @foreach ($links as $val)
                    <li><a href="{{ $val->url }}" class=""  title="{{ $val->name}}">{{ $val->name}}</a></li> 
                    @endforeach
                </ul>
            </div>
        </div>
        <!--content end-->
    </div>
    <!--main end-->
</div>
<!--footnews end-->
@endsection
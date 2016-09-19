@extends('foreground.master')

@section('content')
        <!--footnews start-->
<div class="footnews-container clearfix">
    <!--当前位置 start-->
    <div class="yg-positioncont">
        <a href="/index">首页</a><span class="sep">&gt;</span> <a href="#">帮助中心</a><span class="sep">&gt;</span><span>购物指南</span>
    </div>
    <!--当前位置 end-->
    <!--main start-->
    <div class="footnews-main clearfix">
        <!--sidebar start-->
        <div class="footnews-left">
            <!--新手指南 start-->
            @foreach ($articleCats as $val)
            <div class="fnews_box">
                <h2 class="fnews_btit">{{ $val->cat_name }}</h2>
                <ul class="fnews_btxt">
                    @foreach ($val->articleCats as $value)
                    <li><a href="{{url('help',['id'=>$value->article_id]) }}">{{ $value->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <!--sidebar end-->
        <!--content start-->
        <div class="footnews-right">
            <h2 class="fnews-m-tit">{{ $article->title }}</h2>
            <div class="fnews-m-content">
               <?php echo $article->content;?>
            </div>
        </div>
        <!--content end-->
    </div>
    <!--main end-->
</div>
<!--footnews end-->
@endsection
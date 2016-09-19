@extends('foreground.master')

@section('content')
        <!--footnews start-->
<div class="footnews-container clearfix">
    <!--当前位置 start-->
    <div class="yg-positioncont">
        <a href="/index">首页</a><span class="sep">&gt;</span> <a href="#">动态公告</a>
    </div>
    <!--当前位置 end-->
    <!--main start-->
    <div class="footnews-main clearfix">
        <!--sidebar start-->
        <div class="footnews-left">
            <div class="fnews_box">
                <h2 class="fnews_btit">动态公告</h2>
                <ul class="fnews_btxt">
                    @foreach ($articles as $val)
                    <li title="{{ $val->title }}"><a href="{{url('notice',['id'=>$val->article_id]) }}">{{ str_limit($val->title,28,'') }}</a></li>
                    @endforeach
                </ul>
            </div>
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
    <div id="pageStr" class="pageStr" style="margin: 64px auto;">
    {!! $articles->render() !!}
    </div>
    <!--main end-->
</div>
<!--footnews end-->
@endsection

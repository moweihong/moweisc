@extends('foreground.master')
@section('title','新闻')
@section('content')
        <!--footnews start-->
<div class="footnews-container clearfix">
    <!--当前位置 start-->
    <div class="yg-positioncont">
        <a href="/index">首页</a><span class="sep">&gt;</span> <a href="javascript:void(0);">新闻类</a>
    </div>
    
    <div class="footnews-main clearfix"> 
        <div class="footnews-left">
            <div class="fnews_box">
                <h2 class="fnews_btit">新闻栏</h2>
                <ul class="fnews_btxt">
                    @foreach ($articles as $val)
                    <li><a href="{{url('news',['id'=>$val->article_id]) }}" title="{{ $val->title }}">{{ mb_substr($val->title,0,14) }}</a></li>
                    @endforeach
                    @if($articles->total() > 10)
                    <a href="{{url('newslist')}}" >更多</a>
                    @endif
                </ul>
            </div>
        </div>
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
@section("my_js")
    <script>
        $(function(){
            //选项卡
            $(".fnes-quetit .quetit-a").click(function(){
                var k = $(this).attr("data-divshow");
                $(".fnes-qustxt .uque_tab").eq(k).show().siblings(".uque_tab").hide();
                $(this).addClass("quetit-aon").siblings(".quetit-a").removeClass("quetit-aon");
            });

            //帮助中心点击弹出，再点击收回
            $(".uqb_box .uqb_btit").click(function(){
                $(this).siblings(".uqb_btxt").slideToggle(300);
                $(this).find(".uqb_bico").toggleClass("uqb_bico_down");
                return false;
            });
        })
    </script>
@endsection
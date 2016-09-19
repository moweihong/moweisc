@extends('foreground.master')
@section('my_css')
<link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/page.css">
<style type="text/css">
    .Q-tpList {
        border-bottom: 1px solid #f0f0f0;
        position: relative;
        padding-bottom: 14px;
    }
    .f14 {
        font: 24px/27px "微软雅黑","simhei";
        margin: 8px 0 0;
        display: inline-block;
        margin-bottom: 7px;
    }
    .news_content{
        color: #818181;
        padding: 1px 15px 0 0;
        height: 42px;
        overflow: hidden;
    }
    .linkto {
        font: 20px/28px "微软雅黑","simhei";
    }
</style>
@endsection
@section('title','新闻列表')
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
                </ul>
            </div>
        </div>

        <div class="footnews-right">
            <h2 class="fnews-m-tit">新闻列表</h2>
            @foreach ($articles as $val)
            <div class="Q-tpList" style="z-index:99"><div class="Q-tpWrap">
                    <em class="f14"><a target="_blank" class="linkto" href="{{url('news',['id'=>$val->article_id]) }}" style="">{{ $val->title }}</a></em>
                    <p class="news_content"><a target="_blank" href="{{url('news',['id'=>$val->article_id]) }}" style="">{{ $val->description }}</a></p>
                </div>
            </div>
            @endforeach
        </div>
        <!--content end-->
    </div>
    <center>
        <div id="pageStr" class="pageStr" style="margin: 64px auto;">
            {!! $articles->render() !!}
        </div>  
    </center>
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
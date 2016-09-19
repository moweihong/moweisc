@extends('foreground.master')
@section('title','常见问题')
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
            @if(!empty($article))
            <h2 class="fnews-m-tit">{{ $article->title }}</h2>
            @endif
            @if (!empty($article) &&  $article->article_id == 3)
                <!--常见问题 start-->
            <div class="fnews-question">
                <!--tit start-->
                <div class="fnes-quetit clearfix">
                    @foreach($questionCats as $key=>$val)
                        @if($key == 0)
                            <a class="fquetit-a fquetit-aon" href="javascript:void(0)" title="{{$val->cat_name}}" data-queshow="{{$key}}">{{$val->cat_name}}</a>
                        @else
                            <a class="fquetit-a" href="javascript:void(0)" title="{{$val->cat_name}}" data-queshow="{{$key}}">{{$val->cat_name}}</a>
                        @endif
                    @endforeach
                </div>
                <!--tit end-->
                <!--txt start-->
                <div class="fnes-qustxt">
                    <!--选项卡1 start-->
                    @foreach($questionCats as $key=>$val)
                        @if($key == 0)
                            <div class="fuque_tab" style="display: block;">
                                <!--box start-->
                                @foreach($val->articleCats as $article_key => $article)
                                <div class="uqb_box">
                                    <h2 class="uqb_btit"><span class="uqb_bico"></span><a class="uqb_btit_a" href="javascript:void(0)" title="{{$article_key++}}、{{$article->title}}">{{$article_key++}}、{{$article->title}}</a></h2>
                                    <div class="uqb_btxt">
                                        {!!$article->content!!}
                                    </div>
                                </div>
                                @endforeach
                                <!--box end-->
                            </div>
                        @else
                            <div class="fuque_tab">
                                <!--box start-->
                                @foreach($val->articleCats as $article_key => $article)
                                <div class="uqb_box">
                                    <h2 class="uqb_btit"><span class="uqb_bico"></span><a class="uqb_btit_a" href="javascript:void(0)" title="{{$article_key++}}、{{$article->title}}">{{$article_key++}}、{{$article->title}}</a></h2>
                                    <div class="uqb_btxt">
                                        {!!$article->content!!}
                                    </div>
                                </div>
                                @endforeach
                                <!--box end-->
                            </div>
                        @endif
                    @endforeach
                    <!--选项卡8 end-->
                </div>
                <!--txt end-->
            </div>
            <!--常见问题 end-->
            @elseif(!empty($article))
                <div class="fnews-m-content">
                    <?php echo $article->content;?>
                </div>
            @endif
            
            
        </div>
        <!--content end-->
    </div>
    <!--main end-->
</div>
<!--footnews end-->
@endsection

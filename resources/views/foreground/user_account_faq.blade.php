{{--个人中心我的账户页面，所有个人中心参照本文件进行应用，只需要重写content_right文件--}}
@extends('foreground.user_center')
@section('title','常见问题')
@section('my_css')
    <link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
@section('content_right')
    <div id="member_right" class="member_right" style="border:none;">
        <!--question start-->
        <div class="user_question">
            <!--tit start-->
            <div class="u_questit clearfix">
            	@foreach ($articleCatList as $key=>$row)
                <a class="u_quet_a " href="javascript:void(0)" title="{{$row->cat_name}}" data-divshow="{{ $key }}">{{$row->cat_name}}</a>
                @endforeach
            </div>
            <!--tit end-->
            <!--txt start-->
           
            <div class="u_quesmain">
                <!--选项卡 1 start-->
                 @foreach ($articleCatList as $k=>$v)
                <div class="uque_tab" <?php if($k==0){?> style="display: block;<?php }?> ">
                    <!--box start-->
                      @foreach ($v->articlelsit as $num=>$art)
                    <div class="uqb_box">
                        <h2 class="uqb_btit"><span class="uqb_bico"></span><a class="uqb_btit_a" href="javascript:void(0)" title="{{ $art->title}}">{{$num+1 }}、{{ $art->title}}</a></h2>
                        <div class="uqb_btxt">
                           {!!$art->content!!}
                        </div>
                    </div>
                    @endforeach
                    <!--box end-->
                    
                
                </div>
                @endforeach
                <!--选项卡1 end-->
               
            </div>
            <!--txt end-->
        </div>
        <!--question end-->
    </div>
    <!-- E 右侧 -->
    </div>
@endsection




@extends('foreground.mobileactivity')
@section('title', '新手指南')
@section('activity_css')
    <style>
        /*新版 2016.8.11*/
        .newguide-wrap{position: relative; padding-top: 30px; background: #e23c58;}
        .newguide-button{width:74px; height: 27px; position: absolute; bottom:90px; right: 22px;}
    </style>
@endsection

@section('content')
    <div class="newguide-wrap">
        <img src="{{ $h5_prefix }}images/guide/newguidebg.jpg" width="100%">
        <a href="javascript:void(0)" class="newguide-button" data-url="/category_m?par=yes"></a>
    </div>
@endsection
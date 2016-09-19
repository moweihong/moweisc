@extends('foreground.master')
@section('my_usercss')
<link rel="stylesheet" href="{{ $url_prefix }}css/page.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/b_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/c_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/a_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/member_comm.css"/>
<style type="text/css">
	.b_cloud_code {
    width: 140px;
    margin: 0 auto;
    text-align: left;
    overflow: hidden;
    font-size: 12px;
    color: #555;
}
	.b_cloud_code i {
    font-size: 12px;
}

.b_record_box .b_periods_num {
    cursor: pointer;
    font-size: 12px;
    color: #dd2726;
}
.w-msgbox-close {
    position: absolute;
    right: 0px;
    top: 0px;
    display: block;
    width: 34px;
    height: 38px;
    text-decoration: none;
    background: url({{ $url_prefix }}img/close.png) no-repeat center center;
}
.w-msgbox-hd {
    height: 58px;
    line-height: 58px;
    border-bottom: 1px solid #ececec;
    margin: 0 10px;
}
.w-msgbox-hd h3 {
    margin-bottom: 20px;
    padding-bottom: 15px;
    font-size: 16px;
    color: #3c3c3c;
    line-height: 20px;
    text-align: center;
    font-weight: bold;
    line-height: 58px;
    position: relative;
}
.w-msgbox {
    display: none;
    width: 694px;
    border: 6px solid #999;
    font-size: 14px;
    line-height: 1.8;
    position: fixed;
    z-index: 999;
    -position: absolute;
    left: 0;
    top: 0;
    background: #fff;
    color: #333;
    box-shadow: 0 0 5px rgba(0,0,0,.4);
    border-radius: 4px;
}
.m-detail-codesDetail-bd {
    padding-bottom: 20px;
}
.m-detail-codesDetail-wrap {
    width: 654px;
    _height: 300px;
    max-height: 300px;
    overflow-y: scroll;
}
.m-detail-codesDetail-list {
    margin-bottom: 20px;
    font-size: 12px;
    line-height: 26px;
}
.m-detail-codesDetail-list dt {
    font-size: 16px;
    font-weight: bold;
    color: #555;
}
.m-detail-codesDetail-list .selected {
    font-weight: bold;
    color: #dd2726;
}
.m-detail-codesDetail-list dd {
    font-size: 14px;
    float: left;
    margin-right: 10px;
    width: 81px;
}
</style>
@endsection
{{--内容模板基本固定，仅需要重写content_right文件即可--}}
@section('content')
    {{--个人中心 头部文件--}}
@include('foreground.him_header')
    {{--个人中心 内容文件包裹--}}
    <div id="content_box" class="">
        {{--个人中心 内容左部文件--}}
        @include('foreground.him_left')
        {{--个人中心 内容右部文件--}}
        @yield('content_right')
    </div>
@endsection
@section('my_userjs')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/user_history.js"></script>
@endsection
{{--@yield('my_userjs')--}}

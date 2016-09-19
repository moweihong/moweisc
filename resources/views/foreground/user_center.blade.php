@extends('foreground.master')
@section('my_usercss')
<link rel="stylesheet" href="{{ $url_prefix }}css/page.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/b_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/c_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/a_member.css"/>
<link rel="stylesheet" href="{{ $url_prefix }}css/member_comm.css"/>
<link rel="stylesheet" type="text/css" href="{{ $url_prefix }}css/users_question.css">
@endsection
{{--内容模板基本固定，仅需要重写content_right文件即可--}}
@section('content')
    {{--个人中心 头部文件--}}
@include('foreground.user_header')
    {{--个人中心 内容文件包裹--}}
    <div id="content_box" class="">
        {{--个人中心 内容左部文件--}}
        @include('foreground.user_left')
        {{--个人中心 内容右部文件--}}
        @yield('content_right')
    </div>
@endsection
@section('my_userjs')
<script type="text/javascript" src="{{ $url_prefix }}js/jquery190.js"></script>
<script type="text/javascript" src="{{ $url_prefix }}js/user_history.js"></script>
@endsection
{{--@yield('my_userjs')--}}

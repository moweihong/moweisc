@extends('backend.master')

@section('content')
<div class="header">

    <h1 class="page-title">大转盘</h1>
</div>

<ul class="breadcrumb">
    <li><a href="/backend/article">大转盘奖品管理</a> <span class="divider">/</span></li>
    <li class="active" >编辑奖品</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">        
        <div class="well">
            <form  name="articleForm" action="/backend/rotary/save" method="POST">
                {!! csrf_field() !!}
                <input type="text" value="{{$info['id']}}" maxlength="60" name="id" style="display: none;">

                <table cellspacing="1" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td>奖品名称：{{$info['name']}}</td>
                        </tr>

                        <tr>
                            <td>
                                奖品库存：
                                <input type="text" value="{{$info['stock']}}" size="30" maxlength="60" name="stock">&nbsp;&nbsp;
                                <input type="checkbox" value="1" name="no_limit" @if($info['no_limit'] == 1) checked @endif>不限制库存
                            </td>
                        </tr>

                        <tr>
                            <td>
                                中奖权重：
                                <input type="text" size="15" value="{{$info['weight']}}" name="weight">&nbsp;&nbsp;(数值越大，中奖概率越大，0表示中奖概率为0)
                            </td>
                        </tr>

                        <tr>
                            <td align="center" colspan="2">
                                <br>
                                <input class="button" type="submit" value=" 确定 ">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

    </div>
</div>

@endsection
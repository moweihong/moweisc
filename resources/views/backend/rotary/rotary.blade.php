@extends('backend.master')

@section('content')
    <div class="header">

        <h1 class="page-title">大转盘</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="/backend/rotery">大转盘奖品管理</a> <span class="divider">/</span></li>
        <li class="active">奖品列表</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>奖品名称</th>
                        <th>奖品库存</th>
                        <th>是否限制库存</th>
                        <th>中奖权重</th>
                        <th style="width: 40px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->stock  }}</td>
                            <td>{{ $row->no_limit ? '不限制' : '限制' }}</td>
                            <td>{{ $row->weight }}</td>
                            <td>
                                <a href="{{url('backend/rotary/edit',['id'=>$row->id]) }}" title="编辑"><i class="icon-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="pageStr" class="pageStr" style="margin: 64px auto;">
                {!! $list->render() !!}
            </div>
        </div>
    </div>

@endsection
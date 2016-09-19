@extends('foreground.master')
@section('content')
<!-- 新手指引 start-->
<div class="newer-guide-wrap">
    <div class="w1200 newer-guide">
        <div class="guide-p guide-p1"><b class="guide-png guide-p1-img"></b></div>
        <div class="guide-p guide-p2"><b class="guide-img guide-p2-img1"></b><b class="guide-img guide-p2-img2"></b></div>
        <div class="guide-p guide-img guide-p3"></div>
        <div class="guide-p guide-img guide-p4"><a href="/category?par=yes" class="guide-p4-button"></a></div>
        <div class="guide-p guide-p5">
            <b class="guide-img guide-p5-img1"></b>
            <div class="guide-product clearfix">
                <ul>
                    @foreach($shopCheap as $row)
                    <li>
                        <div class="g-proimg" data-gid="956" data-pid="240">
                            <a href="/product/{{$row->bid}}" data-gid="956" data-pid="240">
                                <img id="img_0" data-gid="956"  class="lazy0" data-original="{{ $row->thumb }}" src="{{ $row->thumb }}" width="160" height="160" />
                                <noscript>&lt;img id="img_0" data-gid="956" data-pid="240" src="{{ $row->thumb }}" /&gt;</noscript>
                            </a>
                        </div>
                        <h2 class="g-protit" data-gid="956" data-pid="240"><a href="/product/{{$row->bid}}" data-gid="956" data-pid="240" title="{{ $row->title }}">(第{{ $row->periods }}期) {{ $row->title }}</a></h2>
                        <p class="g-proyuanjia">价值：￥{{ $row->money }}</p>
                        <div class="g-proprogress">
                            <div class="g-progress-wrap"><div class="g-progress-red" style="width:{{ ($row->participate_person/$row->total_person)*100 }}%"></div></div>
                            <span class="g-progress-number">{{$row->participate_person}}</span>
                            <span class="g-progress-total">{{$row->total_person}}</span>
                            <span class="g-progress-last">{{$row->total_person-$row->participate_person}}</span>
                            <b class="g-progress-ico">新手专区</b>
                        </div>
                        <div class="g-buybutton">
                            <a href="/product/{{$row->bid}}" class="g-buy-go">立即一块购</a>
                            <a href="javascript:void(0)" class="guide-png g-buy-cart" onclick="addCart({{$row->id}},1)"></a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <b class="guide-png guide-p5-ico1"></b>
            <b class="guide-png guide-p5-ico2"></b>
        </div>
    </div>
</div>
<!-- 新手指引 end-->
<input type="hidden" id="cartGid_0" value="956">
<input type="hidden" id="cartPid_0" value="240">
<input type="hidden" id="priceArea_0" value="1">
<input type="hidden" id="period_0" value="240">
<input type="hidden" id="priceTotal_0" value="30">
<input type="hidden" id="surplus_0" value="15">
<input type="hidden" id="thumbPath_0" value="undefined">
<input type="hidden" id="title_0" value="">
@endsection
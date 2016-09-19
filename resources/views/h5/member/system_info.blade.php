@extends('foreground.mobilehead')
@section('title', '系统消息')

@section('my_css')
<style>
	html{
	font-size: 100px;

	}
	.mui-content *{
		    color: #666666;
		    /* font-family: "pingfang";*/
	}
	time{
		float: right;
		font-size: .11rem;
	}

	.mui-table-view-cell h1{
	 font-size: .14rem;
    display: inline-block;
	}
	.mui-table-view-cell h2{
		font-size: .11rem;
	}
	.mui-table-view-cell p{
	font-size: .11rem;
	display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
	}

	.detail-btn{
	font-size: .09rem;
    float: right;
    margin-top: 0px;
    text-decoration: underline;
	}

	.msg-detail{width: 95%;margin: 0 auto;padding: 20px 15px 55px 15px;font-size: .11rem;line-height: 22px;background: white;    margin-top: 10px;}
	.msg-detail h1{font-size: .14rem;display: inline;}
	.timestr{float: right;padding-right: 20px;}
	.send-person{text-align: right;}
</style>
@endsection

@section('content')
 <div class="mui-content">
	<div class="msg-detail">
        <div msg-title><h1>{{ $msg->title }}</h1><span class="timestr">{{ date('Y-m-d', $msg->send_time) }}</span></div>
        <div class="msg-content" style="clear:both;">
			<h2>【{{ $msg->title }}】</h2>
			<p>
				{{ $msg->msg }}
			</p>
		</div>
	</div>
 </div>

@endsection

@section('my_js')

@endsection




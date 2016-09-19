@extends('foreground.mobilehead')
@section('title', '即将揭晓')
@section('footer_switch', 'show')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css?v={{config('global.version')}}">
@endsection

@section('content')
   <div class="mui-content">
      @if(!empty($data['goods']))
       <div id="contentshow">
      @foreach($data['goods'] as $key=>$val)
      <!--box start-->
     
      <div class="jjjx-listbox mui-clearfix">
          <b class="jjjx-bq jjjx-jj"><img src="{{ $h5_prefix }}images/page/bq-jjjx.png" /></b>
         <div class="jjjx-bimg"><a href="/product_m/{{$val['id']}}"><img src="{{$val['belongs_to_goods']['thumb']}}" width="108" height="124" /></a></div>
         <div class="jjjx-btxt">
            <h2><a href="#">（第{{$val['periods']}}期）{{!empty($val['belongs_to_goods']['title2'])?$val['belongs_to_goods']['title2']:$val['belongs_to_goods']['title']}}</a></h2>
            <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:{{$val['progress']}}%"></div></div>
            <div class="jjjx-prodes mui-clearfix">
               <span class="prodes-s1">总需：{{$val['total_person']}}</span>
               <span class="prodes-s2">剩余：<b class="color-de2f51">{{$val['total_person'] - $val['participate_person']}}</b></span>
            </div>
            <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">{{$val['participate_person']}}</span></div>
            <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>
         </div>
          @if(session('is_ios') != 1)
         <div class="jjjx-bcurt"><a href="javascript:;" onclick="addCart('{{$val['g_id']}}',1)"><img src="{{ $h5_prefix }}images/progress-img.png" /></a></div>
          @endif
      </div>
      
      <!--box end-->
      @endforeach
      </div>
      @else
      <div class="jjjx-listbox mui-clearfix">
         暂无数据
      </div>
      @endif
   </div>
   <!--footnav start-->

   <!--footnav end-->
@endsection


@section('my_js')
<script>
var page = {{ $data['page'] }};
var h5_prefix = {{ $h5_prefix }};
var is_ios = {{session('is_ios') ? session('is_ios') : 0}};
page++;

$(document).ready(function(){
   var dropload = $('.mui-content').dropload({
       scrollArea : window,
       loadDownFn : function(me){
         $.ajax({
               type: 'GET',
               url: '',
               dataType: 'json',
               data:{page:page},
               success: function(data){
                 var html = '';
                 $.each(data.goods, function(idx, item){
                     html += '<div class="jjjx-listbox mui-clearfix">';
                     html += '   <b class="jjjx-bq jjjx-jj"><img src="{{ $h5_prefix }}images/page/bq-jjjx.png" /></b>';
                     html += '   <div class="jjjx-bimg"><a href="/product_m/'+item.id+'"><img src="'+item.belongs_to_goods.thumb+'" width="108" height="124" /></a></div>';
                     html += '   <div class="jjjx-btxt">';
                     var title = item.belongs_to_goods.title2 ? item.belongs_to_goods.title2 : item.belongs_to_goods.title;
                     html += '      <h2><a href="#">（第'+item.periods+'期）'+title+'</a></h2>';
                     html += '      <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:'+item.progress+'%"></div></div>';
                     html += '      <div class="jjjx-prodes mui-clearfix">';
                     html += '         <span class="prodes-s1">总需：'+item.total_person+'</span>';
                     html += '         <span class="prodes-s2">剩余：<b class="color-de2f51">'+ (item.total_person - item.participate_person) +'</b></span>';
                     html += '      </div>';
                     html += '      <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">'+item.participate_person+'</span></div>';
                     html += '      <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>';
                     html += '   </div>';
                     html += is_ios != 1 ? '   <div class="jjjx-bcurt"><a href="javascript:;" onclick="addCart(\''+item.g_id+'\',1)"><img src="{{ $h5_prefix }}images/progress-img.png" /></a></div>' : '';
                     html += '</div>';
                 });

                  if(data.total < data.limit){
                     // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                  }

                  page++;

                  $('#contentshow').append(html);
                   // 每次数据加载完，必须重置
                   me.resetload();
               },
               error: function(xhr, type){
                   // 即使加载出错，也得重置
                   me.resetload();
               }
           });
       },
       loadUpFn : function(me){
         $.ajax({
               type: 'GET',
               url: '',
               dataType: 'json',
               data:{page:0},
               success: function(data){
                    var html = '';
                    $.each(data.goods, function(idx, item){
                         html += '<div class="jjjx-listbox mui-clearfix">';
                         html += '   <b class="jjjx-bq jjjx-jj"><img src="{{ $h5_prefix }}images/page/bq-jjjx.png" /></b>';
                         html += '   <div class="jjjx-bimg"><a href="/product_m/'+item.id+'"><img src="'+item.belongs_to_goods.thumb+'" width="108" height="124" /></a></div>';
                         html += '   <div class="jjjx-btxt">';
                         var title = item.belongs_to_goods.title2 ? item.belongs_to_goods.title2 : item.belongs_to_goods.title;
                         html += '      <h2><a href="#">（第'+item.periods+'期）'+title+'</a></h2>';
                         html += '      <div class="jjjx-progress"><div class="jjjx-progress-div" style="width:'+item.progress+'%"></div></div>';
                         html += '      <div class="jjjx-prodes mui-clearfix">';
                         html += '         <span class="prodes-s1">总需：'+item.total_person+'</span>';
                         html += '         <span class="prodes-s2">剩余：<b class="color-de2f51">'+ (item.total_person - item.participate_person) +'</b></span>';
                         html += '      </div>';
                         html += '      <div class="jjjx-des-canyu">本期参与：<span class="color-de2f51">'+item.participate_person+'</span></div>';
                         html += '      <div class="jjjx-des-other color-de2f51">再来一元，为运气加油</div>';
                         html += '   </div>';
                         html += is_ios != 1 ? '   <div class="jjjx-bcurt"><a href="javascript:;" onclick="addCart(\''+item.g_id+'\',1)"><img src="{{ $h5_prefix }}images/progress-img.png" /></a></div>' : '';
                         html += '</div>';
                     });

                    $('#contentshow').empty();
                    $('#contentshow').prepend(html);
                   // 每次数据加载完，必须重置
                   page=1;
                   me.resetload();
                     me.unlock();
                     me.noData(false);
                   me.resetload();  
               },
               error: function(xhr, type){
                   // 即使加载出错，也得重置
                   me.resetload();
               }
           });
       }
       
   });
}) 
</script>
@endsection
 
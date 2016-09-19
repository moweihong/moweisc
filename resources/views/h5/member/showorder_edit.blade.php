@extends('foreground.mobilehead')
@section('title', '修改晒单')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--发布晒单 start-->
      <div class="fbsd-main">
         <div class="mui-input-row sdf-row">
            <label>晒单标题</label>
            <input class="sdinp-tit" type="text" value="{{$show->sd_title}}" maxlength="50" placeholder="请输入标题" >
            <input type="hidden"  type="text" value="{{$show->id}}" id="o_id" >
         </div>
         <div class="row mui-input-row">
            <textarea id='question' class="mui-input-clear sdinp-txt" placeholder="晒单内容不少于20字 ，晒单成功奖励哦~ ">{{$show->sd_content}}</textarea>
         </div>
          
         <div class="pic-upload mui-clearfix">
            <div class="pic-upbox mui-clearfix">
               <div id="uploader-demo mui-clearfix">
                   <!--用来存放item-->
                   <div id="fileList" class="uploader-list mui-clearfix">
                        @foreach($show->sd_photolist as $val)

                            <div  class="file-item thumbnail">
                                <img  src="{{$val}}">
                                <input type="hidden" name="photo" value="{{$val}}">
                                <span onclick="delPhone(this)" class="upload-close">X</span>
                            </div>
                        @endforeach
                   </div>
                   <div id="filePicker"></div>
               </div>
            </div>
            <!--<a href="#" class="picupload-add"></a>-->
            <div class="picupload-tips">上传至少3张图片</div>
         </div>
         <div class="sdform-but"><button id='submit' type="button" class="mui-btn mui-btn-danger mui-btn-block">提交</button></div>
         <div class="sdshow-des">
            <h2 style="margin-bottom: 0.1rem;">晒单说明</h2>
            <p>1、晒单内容越详细，获得的块乐豆奖励就越多；<span class="color-de2f51">晒单块乐豆奖励规则：500 块乐豆≤ 商品金额*5%+字数*5+图片*50 ≤1500块乐豆。</sapn></p>
            <p>2、您的文字描述应不少于20字，高清的商品实拍照不少于3张、单张图片不得超过5M；</p>
            <p>3、请避免晒单内容中文字与图片的大量重复；</p>
            <p>4、为提高晒单的真实性，您可以展示真实有效的快递单号；</p>
            <p>5、建议晒出您与商品的合照，您的手机短信、邮件通知及众筹网上的交易详情页面截图等；</p>
            <p>6、注意保持晒单内容与获得商品的关联性，请勿使用其他网站的图片，请勿违反国家相关规定，否则我们有权利删除并冻结账号；</p>
            <p>温馨提示：如果您的晒单非常新颖，那么您有可能会获得更高的奖励！</p>
         </div>
      </div>
      <!--发布晒单 end-->
   </div>
@endsection

@section('my_js')
<script type="text/javascript" src="{{ $h5_prefix }}js/webuploader/webuploader.js"></script>
   <script>

// 图片上传d
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 50 * ratio,
        thumbnailHeight = 50 * ratio,
        index,

        // Web Uploader实例
        uploader;

    // 初始化Web Uploader
    uploader = WebUploader.create({
        // 自动上传。
        auto: true,
        // swf文件路径
        swf: "{{ $h5_prefix }}js/webuploader/Uploader.swf",
        // 文件接收服务端。
        server: '/user_m/showpic',
        fileNumLimit:6,
        fileSingleSizeLimit: 5242880,//5M
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var photolist =   $("input[name='photo']");
        if(photolist.length==6){
            uploader.removeFile( file );
            $("#filePicker").hide();
            myalert('图片不能超过6张');
        }else{
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                        '<img>' +
                        '<span class="upload-close">X</span>'+
                    '</div>'
                    ),
                $img = $li.find('img');
            $li.on( 'click', 'span', function() {
                $('#'+file.id).remove();
                uploader.removeFile( file );
                $("#filePicker").show();
            });
            $list.append( $li );

            // 创建缩略图
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }
                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
            index = layer.open({type: 2});
        }        
    });

    // 文件上传成功
    uploader.on( 'uploadSuccess', function( file,data) {
        layer.close(index);
        var $pic = '<input type="hidden" name="photo" value="'+data.photo+'"><div class="tick">上传成功</div>';
        $( '#'+file.id ).append($pic);
        var text;
        //var json=JSON.parse(result);
        if(data.status == 0){
            myalert(data.msg);
        }
        var stats = uploader.getStats();
        if(stats.successNum >= 6){
            $("#filePicker").hide();
        }
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        layer.close(index);
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });
    
    uploader.onError = function( code ) {
       layer.close(index);
       switch ( code ) {
          case 'Q_EXCEED_NUM_LIMIT':
                myalert('图片不能超过6张');
                break;
          case 'F_EXCEED_SIZE':
                myalert('图片大小不能超过5M');
                break;
          case 'Q_TYPE_DENIED':
                myalert('图片格式不正确<BR>请选择gif,jpg,jpeg,bmp,png格式');
                break;
          case 'F_DUPLICATE':
                myalert('你已上传了同一张图片');
                break;
       }
    };
       
    $("#submit").click(function(){
       var photolist =   $("input[name='photo']");
       var titval = $(".sdinp-tit").val();
       var txtval = $(".sdinp-txt").val();
       if(titval == 0 || titval == "" || titval == null ){
          myalert("晒单标题不能为空！");
          return false;
       }
       else if(titval.length < 2){
          myalert("晒单标题不能少于2个字符！");
          return false;
       }
       else if(txtval == 0 || txtval == "" || txtval == null ){
          myalert("晒单内容不能为空！")
          return false;
       }
       else if(txtval.length < 20){
          myalert("晒单内容不能少于20个字符！");
          return false;
       }
       else if(photolist.length < 3){
          myalert("图片不能少于3张！");
          return false;
       }
       else{
            
            var pics = [];
            var o_id = $("#o_id").val();
            for(var i=0;i<photolist.length;i++){
                pics[i]=photolist[i].value;
            }
                $.post('/user_m/savepics',{'title':titval,'content':txtval,'pics':pics,'action':'update','id':o_id},function(data){
                if(data.status == 1){
                    layer.open({
                       content: '恭喜你，晒单成功状态审核中...',
                       btn: ['查看我的晒单', '回到首页'],
                       shadeClose: false,
                       yes: function(){
                         // layer.open({content: '查看我的晒单！', time: 1});
                          location.href = '/user_m/show';
                       }, no: function(){
                         // layer.open({content: '回到首页！', time: 1});
                          location.href = '/index_m';
                       }
                    });
                }else{
                    myalert(data.msg);
                }
            },'json');

       }
    })
});
function delPhone(obj)
{
    $(obj).parent().remove();
//    $(obj).prev().prev().remove();
//    $(obj).prev().remove();
//    $(obj).remove();
    $("#filePicker").show();
}

   </script>
@endsection



 
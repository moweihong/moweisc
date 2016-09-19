
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
        if(stats.successNum-stats.cancelNum >= 6){
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
      var stats = uploader.getStats(); 
      //var pictotals = stats.successNum-stats.cancelNum;
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
            $.post('/user_m/savepics',{'title':titval,'content':txtval,'action':'save','pics':pics,'o_id':o_id},function(data){
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


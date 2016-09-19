@extends('foreground.mobilehead')
@section('title', '发布晒单')
@section('my_css')
   <link rel="stylesheet" type="text/css" href="{{ $h5_prefix }}css/page.css">
@endsection

@section('content')
   <div class="mui-content">
      <!--发布晒单 start-->
      <div class="fbsd-main">
         <div class="mui-input-row sdf-row">
            <label>晒单标题</label>
            <input class="sdinp-tit" type="text" maxlength="50" placeholder="请输入标题" >
            <input type="hidden"  type="text" value="{{$o_id}}" id="o_id" >
         </div>
         <div class="row mui-input-row">
            <textarea id='question' class="mui-input-clear sdinp-txt" placeholder="晒单内容不少于20字 ，晒单成功奖励哦~ "></textarea>
         </div>

         <div class="pic-upload mui-clearfix">
            <div class="pic-upbox mui-clearfix">
               <div id="uploader-demo mui-clearfix">
                   <!--用来存放item-->
                   <div id="fileList" class="uploader-list mui-clearfix"></div>
                   <div id="filePicker"></div>
               </div>
            </div>
            <!--<a href="#" class="picupload-add"></a>-->
            <div class="picupload-tips">上传至少3张图片</div>
         </div>
         <div class="sdform-but"><button id='submit' type="button" class="mui-btn mui-btn-danger mui-btn-block">提交</button></div>
         <div class="sdshow-des">
            <h2 style="margin-bottom: 0.1rem;">晒单说明</h2>
            <p>1、晒单内容越详细，获得的块乐豆奖励就越多；<span class="color-de2f51">晒单块乐豆奖励规则：100 块乐豆≤ 商品金额*5%+字数*5+图片*50 ≤500块乐豆。</sapn></p>
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
<script type="text/javascript" src="{{ $h5_prefix }}js/uploader.js"></script>
   <script>

   </script>
@endsection



 
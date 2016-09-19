@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">品牌管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop/brand">品牌列表</a> <span class="divider">/</span></li>
            <li class="active">更改品牌</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
                    
   <div class="btn-toolbar">
   <!-- <button class="btn btn-primary"><i class="icon-save"></i> Save</button>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab" method="post" action="/backend/shop/saveBrand">
        <label>所属分类：</label>
        <select id="category" name="cateid">           
                   
                   <?php if(!empty($cateList)){ foreach($cateList as $v){?> 
                   	<option  <?php if($brandlist->cateid==$v['cateid']){?> selected="selected" <?php }?> value="<?php echo $v['cateid'];?>"><?php echo $v['html'].$v['name'];?></option>  
               		<?php }}else{?>
               		<option value="-1">≡出错了≡</option>	
               		<?php }?>
               </select>
       <label>品牌名称</label>
        <input type="text" name='name' class="input-xlarge" value="{{ $brandlist->name }}">
        <label>排序</label>
        <input type="text" name='order' class="input-xlarge" value="{{ $brandlist->order }}"><span style="color: red;">值越大越排前</span>
       <input type="hidden" name="id" value="{{ $brandlist->id }}">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    	<label></label>
    	
    	<input type="submit" value="提交">
    </form>
      </div>
  </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
  </div>
</div>
                    
</div>
</div>
@endsection
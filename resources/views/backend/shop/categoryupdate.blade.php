@extends('backend.master')

@section('content')
<div class="header">
 <h1 class="page-title">栏目管理</h1>
 </div>
        
         <ul class="breadcrumb">
            <li><a href="/backend/shop/category">栏目分类</a> <span class="divider">/</span></li>
            <li class="active">更改栏目</li>
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
    <form id="tab" method="post" action="/backend/shop/dealUpCategory">
        <label>所属分类：</label>
        <select id="category" name="parentid">           
                   <option value="0">≡ 作等级目录≡</option>
                   <?php foreach($cateList as $v){?> 
                   	<option  <?php if($cateinfo->cateid==$v['cateid']){?> selected="selected" <?php }?> value="<?php echo $v['cateid'];?>"><?php echo $v['html'].$v['name'];?></option>  
               		<?php }?>
               </select>
       
    	<label>栏目名称</label>
        <input type="text" name='name' class="input-xlarge" value="{{ $cateinfo->name }}">
        <label>描述</label>
        <textarea name="info"  rows="3" class="input-xlarge" value="">
		{{ $cateinfo->info }}
        </textarea>
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       	<input type="hidden" name="cateid" value="{{ $cateinfo->cateid }}">
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
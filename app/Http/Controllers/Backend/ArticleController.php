<?php

namespace App\Http\Controllers\Backend;
use Request,Validator;
use App\Models\Article_cat,
        App\Models\Article;
use App\Http\Controllers\BaseController;
use Input;
use Illuminate\Support\Facades\File;
class ArticleController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->model = new Article_cat();
    }
    /*
     * 显示所有的分类信息
     */
    public function index(){
        $list = $this->model->getAll();
        return view('backend.article.index', array('list' => $list));
    }
    
    /*
     * 添加文章分类
     */
    public function addArticleCat(){
        $list = $this->allArticleCat();
        $articleCat = "<select name='parent_id'>";
        $articleCat .="<option value='0'>顶级分类</option>";
        foreach ($list as $val)
        {
            $articleCat .= "<option value='{$val['cat_id']}'>{$val['cat_name']}</option>";
        }
        $articleCat .= '</select>';
        
        return view('backend.article.addArticleCat')->with('articleCat',$articleCat);
    }
    /*
     * 编辑文章类型
     */
    public function editArticleCat($id)
    {
        $articleCat = Article_cat::find($id);
        $list = $this->allArticleCat();
        $articleCatlist = "<select name='parent_id'>";
        $articleCatlist .="<option value='0'>顶级分类</option>";
        foreach ($list as $val)
        {
            if ($val['cat_id'] == $articleCat->parent_id){
                $articleCatlist .= "<option value='{$val['cat_id']}' selected>{$val['cat_name']}</option>";
            }else {
                $articleCatlist .= "<option value='{$val['cat_id']}'>{$val['cat_name']}</option>";
            }            
        }
        $articleCatlist .= '</select>';
        return view('backend.article.editArticleCat',['articleCat'=>$articleCat,'articleCatlist'=>$articleCatlist]);
    }
    
    /*
     * 保存文章分类
     */
    public function storeArticleCat(Request $request)
    {
       if ($request::isMethod('post'))
       {
            if ('insert' == $request::input('action'))
            {
                $validator = Validator::make($request::all(), [
                    'cat_name' => 'required|unique:article_cat|max:40',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    //insert 添加文章分类
                    $newArticleCat = new Article_cat();
                    $newArticleCat->cat_name = $request::input('cat_name');
                    $newArticleCat->cat_type = $request::input('cat_type');
                    $newArticleCat->keywords = $request::input('keywords');
                    $newArticleCat->cat_desc = $request::input('cat_desc');
                    $newArticleCat->sort_order = $request::input('sort_order');
                    $newArticleCat->show_in_nav = $request::input('show_in_nav');
                    $newArticleCat->parent_id = $request::input('parent_id');
                    if($newArticleCat->save()){
                        return redirect('/backend/article');
                    }
                }
            }else if('update' == $request::input('action')) {
                $cat_id = $request::input('cat_id');
                $validator = Validator::make($request::all(), [
                    'cat_name' => 'required|max:40',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    //update 更新文章分类
                    $newArticleCat = new Article_cat();
                    $articleCat = $newArticleCat->find($cat_id);
                    $articleCat->cat_name = $request::input('cat_name');
                    $articleCat->keywords = $request::input('keywords');
                    $articleCat->cat_desc = $request::input('cat_desc');
                    $articleCat->sort_order = $request::input('sort_order');
                    $articleCat->show_in_nav = $request::input('show_in_nav');
                    $articleCat->cat_type = $request::input('cat_type');
                    $articleCat->parent_id = $request::input('parent_id');
                    if($articleCat->update()){
                        return redirect('/backend/article');
                    }
                }
            }
        }
    }
    
    /*
     * 删除文章类型
     */
    public function delArticleCat(Request $request)
    {
        if ($request::isMethod("post")){
            $cat_id = $request::input('cat_id');
            $childCat = Article_cat::where('parent_id',$cat_id)->get();            
            if (count($childCat)>0){
                $childCatName = '';
                foreach ($childCat as $val) {
                    $childCatName .=','.$val['cat_name'];
                }
                $data['status'] =0;
                $data['msg'] = '此分类有下级分类'.$childCatName.'，请先删除下级分类';
                return json_encode($data);
            }
            $childArticle = Article::where('cat_id',$cat_id)->get();
            if (count($childArticle)>0){
                $data['status'] =0;
                $data['msg'] = '此分类下有文章，请先删除文章';
                return json_encode($data);
            }
            $articleCat = Article_cat::find($cat_id);
            if ($articleCat->delete()){
                $data['status'] =1;
                $data['msg'] = '删除成功!';
                return json_encode($data);
            } else {
                $data['status'] =0;
                $data['msg'] = '操作失败!';                
                return json_encode($data);
            }
        }
    }
    
    /*
     * 递归找出所有的文章分类
     */
    public function allArticleCat($pid=0,&$result=array(),&$num=0,$length=0)
    {   
        $length++;
        $pad_length  = $length-1;
        $article_cat = $this->model->where('parent_id',$pid)->get();
        foreach ($article_cat as $val){
            $result[$num]['cat_id'] = $val->cat_id;
            $result[$num]['cat_name'] =str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $pad_length).$val->cat_name;
            $num++;
            if ($this->model->where('parent_id',$val->cat_id)->get()->count()>0){
                $this->allArticleCat($val->cat_id,$result,$num,$length);
            }
        }
        return $result;
    }
    
    /*
     * 显示所有的文章
     */
    public function showArticles()
    {
        $list = Article::orderBy('created_at','desc')->paginate(50);
        return view('backend.article.showArticles', array('list' => $list));
    }
    
    /*
     * 添加文章
     */
    public function addArticle()
    {
        $list = $this->allArticleCat();
        $articleCat = "<select name='cat_id'>";
        foreach ($list as $val)
        {
            $articleCat .= "<option value='{$val['cat_id']}'>{$val['cat_name']}</option>";
        }
        $articleCat .= '</select>';
        return view('backend.article.addArticle')->with('list',$articleCat);
    }

    /*
     * 保存文章
     */
    public function storeArticle(Request $request)
    {
        if($request::isMethod('post')){
            if ($request::input('action') == 'insert')
            {
                $validator = Validator::make($request::all(), [
                   'title' => 'required|unique:article|max:255',
                   'editorValue'=>'required'
                ]);
                if ($validator->fails()) {
                    $request::flashOnly('title','editorValue');//在sission中保存之前值  一次性存储
                    return redirect()->back()->withErrors($validator);
                } else {
                    //insert 添加文章
                    $newarticle = new Article();
                    if($request::hasFile('photo')){
                        //有选择图片 校验图片格式
                        $validator = Validator::make($request::all(), ['photo' => 'mimes:png,gif,jpeg,jpg,bmp'], ['photo.mimes' => '上传的图片格式不正确']);
                        if($validator->fails()){
                            $request::flashOnly('title','editorValue');//在sission中保存之前值  一次性存储
                            return redirect()->back()->withErrors($validator);
                        }
                        $file = $request::file('photo');
                        //文件扩展名
                        $photoext = $file->getClientOriginalExtension();
                        //生成新的文件名
                        $newname = time().rand( 1 , 10000 ).'.'.$photoext;
                        //新的文件目录，存在就返回原有的文件目录
                        $newPath = $this->getFolder();
                        if(!$newPath){
                            $validator->errors()->add('photo', '保存图片时创建目录失败');
                            return redirect()->back()->withErrors($validator);
                        }
                        $file->move($newPath,$newname);
                        $newarticle->img = '/'.$newPath.'/'.$newname;
                    }                    

                    if($request::has('tag')){
                     //有选择标签 就保存图片标签类型
                        $newarticle->tag = $request::input('tag');
                    }
                    $newarticle->cat_id = $request::input('cat_id');
                    $newarticle->title = $request::input('title');
                    $newarticle->content = $request::input('editorValue');
                    $newarticle->author = $request::input('author');
                    $newarticle->is_open = $request::input('is_open');
                    $newarticle->keywords = $request::input('keywords');
                    $newarticle->description = $request::input('description');
                    $articleCat = Article_cat::find($request::input('cat_id'));
                    $newarticle->article_type = $articleCat->cat_type;
                    if($newarticle->save())
                    {
                        return redirect('/backend/article/showarticles');
                    }                    
                }
            } else {
                $article_id = $request::input('article_id');
                $validator = Validator::make($request::all(), [
                   'title' => 'required|max:255',
                   'editorValue'=>'required'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);              
                 }else {
                    //update 更新文章
                    $newarticle = new Article();                    
                    $article = $newarticle->find($article_id);
                    if($request::hasFile('photo')){
                        //有选择图片 校验图片格式
                        $validator = Validator::make($request::all(), ['photo' => 'mimes:png,gif,jpeg,jpg,bmp'], ['photo.mimes' => '上传的图片格式不正确']);
                        if($validator->fails()){
                            return redirect()->back()->withErrors($validator);
                        }
                        $file = $request::file('photo');
                        //文件扩展名
                        $photoext = $file->getClientOriginalExtension();
                        //生成新的文件名
                        $newname = time().rand( 1 , 10000 ).'.'.$photoext;
                         //新的文件目录，存在就返回原有的文件目录
                        $newPath = $this->getFolder();
                        if(!$newPath){
                            $validator->errors()->add('photo', '保存图片时创建目录失败');
                            return redirect()->back()->withErrors($validator);
                        }
                        $file->move($newPath,$newname);
                        if($article->img!=null){
                            if(file_exists(substr($article->img, 1))){
                                //更新图片 删除之前的图片
                                unlink(substr($article->img, 1)); 
                            }
                        }
                        $article->img = '/'.$newPath.'/'.$newname;
                    }

                    if($request::has('tag')){
                     //有选择标签 就保存图片类型
                        $article->tag = $request::input('tag');
                    }
                    $article->cat_id = $request::input('cat_id');
                    $article->title = $request::input('title');
                    $article->content = $request::input('editorValue');
                    $article->author = $request::input('author');
                    $article->is_open = $request::input('is_open');
                    $article->keywords = $request::input('keywords');
                    $article->description = $request::input('description');
                    $articleCat = Article_cat::find($request::input('cat_id'));
                    if ($article->article_type!=$articleCat->cat_type){
                        //更改类型 总类型也要跟着改
                        $article->article_type = $articleCat->cat_type;
                    }                    
                    if($article->update())
                    {
                        return redirect('/backend/article/showarticles');
                    }
                 }  
            }
        }
    }
    
    
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    private function getFolder()
    {
        $pathStr = 'backend/upload/article/img/';
        if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }
        $pathStr .= date( "Ymd" );
        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr , 0777 , true ) ) {
                return false;
            }
        }
        return $pathStr;
    }
    
    /*
     * 编辑文章
     */
    public function editArticle($id) {
        $article = Article::find($id);
        $list =$this->allArticleCat();
        $articleCat = "<select name='cat_id'>";
        foreach ($list as $val)
        {
            if ($val['cat_id'] == $article['cat_id']){
                $articleCat .= "<option value='{$val['cat_id']}' selected>{$val['cat_name']}</option>";
            } else {
                $articleCat .= "<option value='{$val['cat_id']}'>{$val['cat_name']}</option>";
            }
        }
        $articleCat .= '</select>';
    return view('backend.article.editArticle')->with(['article'=>$article,'list'=>$articleCat]);;
    }
    
    /*
     * 删除文章
     */
    public function delArticle(Request $request)
    {  
        if($request::isMethod('post')){
            $article_id = $request::input('article_id');
            $article = Article::find($article_id);
            if($article->img!=null){
                if(file_exists(substr($article->img, 1))){
                    //更新图片 删除之前的图片
                    unlink(substr($article->img, 1)); 
                }
            }
            if($article->delete()){
                $result['status'] = 1;
                $result['msg'] = '删除成功！'; 
                return json_encode($result);
            }else {
                $result['status'] = 0; 
                return json_encode($result);
            }
        }
    }

}

<?php

namespace App\Http\Controllers;

use DB;
use Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Facades\FunctionRepositoryFacade;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 获取http请求参数，可设置默认值
     * @param string $name
     * @param mixed  $defalt
     * @return object $request
     */
    public function getParam($name, $default = NULL){
        if($default !== NULL){
            return Request::input($name, $default);
        }
    
        if(Request::has($name)){
            return Request::input($name);
        }else{
            return null;
            //throw new \Exception("Param does not exist!");
        }
    }
    
    /**
     * db操作封装
     * @param string $table
     * @return object DB
     * @throws \Exception
     */
    public function db($table){
        if(empty($table)){
            throw new \Exception("Param '\$table' is necessary!");
        }
        return DB::table($table);
    }
	
	 /**验证码短信发送
     * @ $phone 短信接收号码
	 * @ $param 验证码
	 */
	public function sendverifysms($phone,$param){
		$param=''.$param;
		$phone_number = $phone;
		$res=FunctionRepositoryFacade::sendMessage($phone,'21940',$param);
		return $res;
	}
	
	/**普通模板短信发送
     * @param  $phone_number 短信接收号码
     * @param  $template_id 短信模板类型
     * @param  $param 需要填充的参数,多个参数用英文逗号符号隔开
	 * *短信模板对照表：
	 ★发货短信文案，模板ID：21945
	   【特速一块购】阁下的商品已被XX镖局火速送出，请留意查收！江湖险恶，检查是否有破损再签收。关注公众号ts1kg2016，随时随地一块购！
	★天天免费默认短信一，模板ID:21962
		客官，我是XXX（姓名），我送了XXX（用户选择的商品）给你，赶快去领取！
	★天天免费默认短信二，模板ID:21963
		亲，三生有幸与你相识，送你xxx表示一下，快来拿吧！我是xxx
	★邀请，模板ID:22006
		尊敬的XXX，您好，你的佣金已到达100，可以申请成为渠道用户。
	 ★中标，模板ID:22008
		尊敬的用户，您购买的标已中标，中标云购码为XXX，详情请查看订单。
	
	 */
	public function sendtplsms($phone_number,$template_id,$param){
		  $res=FunctionRepositoryFacade::sendMessage($phone_number,$template_id,$param);
		  return $res;
	}
    

}

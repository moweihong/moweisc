<?php
namespace App\Http\Controllers\Foreground\Service;

/*
 * 商品相关控制器
 * */

use App\Http\Controllers\ForeController;
use App\Mspecs\M3Result;
use App\Models\Member;
use App\Models\Red;
use App\Models\Redbao;
use App\Models\FreeDay;
use App\Models\InviteGoods;
use App\Models\Userpoint;
use App\Models\Bid_record;
use DB;
use Log;

class FreeDayController extends ForeController {
    public function __construct()
    {
        $this->jsonMspecs = new M3Result();
        $this->memberModel = new Member();
        $this->freedayModel = new FreeDay();
        
        $this->chance = 10000;   //中奖概率参数，越大中奖概率越低 
        //$this->chance = 2;//测试概率
        $this->price = 100;  //每次抽奖消耗块乐豆
        $this->prize_amount = 999;  //大奖金额
        
        $this->lucky_num = date('nd', time());
    }
    
    /**
     * 检查用户块乐豆是否足够参加抽奖，足够则扣除块乐豆并生成快乐码
     * @return string
     */
    public function checkBean(){
        $member = $this->memberModel->where('usr_id', session('user.id'))->first();
        $is_first_lottery = session('is_first_lottery');
        if($member->kl_bean >= $this->price || $is_first_lottery == 1){
            if($is_first_lottery == 1){
                $result = true;
                session(['is_first_lottery' => 0]);  //更新session
            }else{
                $result = DB::update('update tab_member set kl_bean = kl_bean - '.$this->price.' where kl_bean >= '.$this->price.' and usr_id = '.session('user.id'));
                
                $member = $this->memberModel->where('usr_id', session('user.id'))->first();
                
                if($result){
                    //保存块乐豆消费记录
                    $userpoint = new Userpoint();
                    $userpoint->usr_id = session('user.id');
                    $userpoint->type = 6;
                    $userpoint->pay = '天天免费抽奖消耗';
                    $userpoint->content = '天天免费抽奖消耗'.$this->price.'块乐豆';
                    $userpoint->money = $this->price;
                    $userpoint->time = time();
                    $userpoint->save();
                }else{
                    $this->jsonMspecs->status = -1;
                    $this->jsonMspecs->message = '您的块乐豆不足';
                    $this->jsonMspecs->data = $member->kl_bean;
                    
                    return $this->jsonMspecs->toJson();
                }
            }
            
            if($result){
                //中奖概率
                $is_prize = mt_rand(2, $this->chance);
                if($is_prize == 1){
                    //中奖，快乐码等于幸运码
                    $happy_num = $this->lucky_num;
                }else{
                    //未中奖
                    $happy_num = mt_rand(0, 999);
                    if($happy_num == $this->lucky_num){   //如果随机数等于幸运码，重新生成
                        $happy_num += mt_rand(1, 9);
                        if($happy_num > 999){
                            $happy_num = substr($happy_num, 1, 3);
                        }
                    }
                }
        
                //保存抽奖记录
                $this->freedayModel->usr_id = session('user.id');
                $this->freedayModel->user_phone = session('user.phone');
                $this->freedayModel->happy_num = $happy_num;
                $this->freedayModel->time = time();
                $this->freedayModel->lucky_num = $this->lucky_num;
                $this->freedayModel->status = 0;
                if($this->freedayModel->save()){
                    if(isset($userpoint)){
                        $userpoint->content = '天天免费抽奖消耗'.$this->price.'块乐豆，记录id：'.$this->freedayModel->id;
                        $userpoint->save();
                    }
                    
                    //第一次未中奖赠送红包
                    if($is_first_lottery == 1 && $is_prize != 1){
                        //赠送红包，插入记录
                        $start_time = time();
                        $freeday_red = config('global.freeday_red');
                        foreach($freeday_red as $red_id){
                            $red_info = Redbao::find($red_id);
                            $redModel = new Red();
                            $redModel->usr_id = session('user.id');
                            $redModel->red_code = $red_id;
                            $redModel->start_time = $start_time;
                            $redModel->end_time = $start_time + intval(config('global.red_expired_days')) * 86400;
                            $redModel->status = 0;
                            
                            $redModel->save();
                        }
                    }
        
                    $this->jsonMspecs->status = 0;
                    $this->jsonMspecs->message = 'ok';
                    $this->jsonMspecs->data = array(
                            'kl_bean' => $member->kl_bean, 
                            'is_prize' => $is_prize == 1 ? true : false, 
                            'one' => substr($happy_num, 0, 1),
                            'two' => substr($happy_num, 1, 1),
                            'three' => substr($happy_num, 2, 1),
                            'log' => $this->freedayModel->id,
                            'is_first_lottery' => $is_first_lottery
                    );
                }else{
                    $this->jsonMspecs->status = -3;
                    $this->jsonMspecs->message = '服务器异常';
                }
            }else{
                $this->jsonMspecs->status = -2;
                $this->jsonMspecs->message = '抽奖参与失败，请联系客服';
            }
        }else{
            session()->forget('happy_num');
            session()->forget('freeday_log_id');
        
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '您的块乐豆不足';
            $this->jsonMspecs->data = $member->kl_bean;
        }        
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * ajax获取用户幸运码
     * @return string
     */
    public function getNum(){
        $log_id = $this->getParam('log');
        
        if($log_id){
            $log = $this->freedayModel->find($log_id);
            $status = 1;
            //如果中奖，发放奖励
            if($log->happy_num == $log->lucky_num){
                $member = Member::where('usr_id', session('user.id'))->first();
                $member->money += $this->prize_amount;
                $result = $member->save();
                if(!$result){
                    $status = 2;
                }
            }
            
            $log->status = $status;
            $log->save();
            
            $this->jsonMspecs->status = 0;
            $this->jsonMspecs->message = 'ok';
        }else{
            $this->jsonMspecs->status = -1;
            $this->jsonMspecs->message = '非法请求';
        }
        
        return $this->jsonMspecs->toJson();
    }
    
    /**
     * ajax用户领取奖品
     */
    public function inviteExchange(){
        $g_id = $this->getParam('g_id');
        if(!empty(session('user.id'))){
            $count = Bid_record::where('usr_id',session('user.id'))->where('pay_type', 'invite')->count();
            if($count == 0){
                $invite_good = InviteGoods::find($g_id);
                if(session('userInviteInterval') >= $invite_good->invite_need){
                    DB::beginTransaction();
                    //减库存
                    $update = DB::update('update tab_invite_goods set stock = stock - 1 where stock > 0 and id = :id', [":id" => $g_id]);
                    if($update){
//                         $base_url  =  config('global.api.base_url');
//                         $api_url   =  config('global.api.subUsrIniteInterval');
//                         $invite_res = $this->api($base_url,$api_url,array('usr_id' => session('user.id'), 'sub_integral' => $invite_good->invite_need),'GET');
//                         if($invite_res['code'] == 0){
                            $last_invite = session('userInviteInterval') - $invite_good->invite_need;
                            session(['userInviteInterval' => $last_invite]);
                            //添加订单
                            $bid_record = new Bid_record();
                            $bid_record->code = 'TESU'.date('YmdHis').$this->getNonceStr(4, 2);
                            $bid_record->o_id = 0;
                            $bid_record->usr_id = session('user.id');
                            $bid_record->g_id = $g_id;
                            $bid_record->g_name = $invite_good->title;
                            $bid_record->g_periods = 0;
                            $bid_record->buycount = 0;
                            $bid_record->buyno = '';
                            $bid_record->fetchno = 0;
                            $bid_record->pay_type = 'invite';
                            $bid_record->status = 2;
                            $bid_record->bid_time = time().'000';
                            
                            if($bid_record->save()){
                                $this->jsonMspecs->status = 0;
                                $this->jsonMspecs->message = '恭喜您领取成功';
                            }else{
                                Log::info('invite goods insert failed, usr_id:'.session('user.id').', g_id:'.$g_id.', interval:'.$invite_good->invite_need);
                                
                                $this->jsonMspecs->status = -2;
                                $this->jsonMspecs->message = '领取失败，请联系客服！';
                            }
                            DB::commit();
//                         }else{
//                             DB::rollback();
                            
//                             $this->jsonMspecs->status = -4;
//                             $this->jsonMspecs->message = '您的邀友积分不够';
//                         }
                    }else{
                        DB::rollback();
                        
                        $this->jsonMspecs->status = -3;
                        $this->jsonMspecs->message = '库存不足！';
                    }
                }else{
                    $this->jsonMspecs->status = -4;
                    $this->jsonMspecs->message = '您的邀友积分不够';
                }
            }else{
                $this->jsonMspecs->status = -5;
                $this->jsonMspecs->message = '您已领取该奖品';
            }
        }
        
        return $this->jsonMspecs->toJson();
    }
}
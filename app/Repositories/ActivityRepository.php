<?php

namespace App\Repositories;

/*
 *公共函数资源库
 */
use App\Models\ActivityLog;
use App\Repositories\Interfaces\ActivityRepositoryInterface;

class ActivityRepository extends Repository implements ActivityRepositoryInterface
{
    //生成发送短信的日志记录
    public function createActivitySmsLog($send_uid, $rece_phone, $needpay, $unit_price, $ispay, $sendcontent, $sendtmpid, $is_send,$sms_error='')
    {
        $alog=new ActivityLog();
        $alog->send_uid=$send_uid;
        $alog->receive_phone=$rece_phone;
        $alog->needpay=$needpay;
        $alog->unit_price=$unit_price;
        $alog->ispay=$ispay;
        $alog->sendcontent=$sendcontent;
        $alog->sendtmpid=$sendtmpid;
        $alog->is_send=$is_send;
        $alog->time=time();
        $alog->sms_error="$sms_error";
        $alog->save();
    }

    //获取今天用户发送信息条数
    public function getSendCountToday($uid)
    {
        $stime=strtotime(date('Y-m-d',time()));
        $etime=$stime+86400;
        return ActivityLog::where('send_uid',$uid)->where('time','<',$etime)->where('time','>',$stime)->where('is_send',1)->count();
    }
    //读取全站短信发送数
    public function getAllSendCouont()
    {
        return ActivityLog::where('is_send','1')->count();
    }


}

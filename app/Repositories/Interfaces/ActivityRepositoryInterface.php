<?php

namespace App\Repositories\Interfaces;

/*活动接口*/

interface ActivityRepositoryInterface
{

   //生成发送短信的日志记录
    public  function createActivitySmsLog($send_uid,$rece_phone,$needpay,$unit_price,$ispay,$sendcontent,$sendtmpid,$is_send,$sms_error='');

   //返回今日用户发送短信条数
    public  function getSendCountToday($uid);

   //读取全站有效发送短信数
    public  function getAllSendCouont();
}

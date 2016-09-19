<?php
namespace App\Repositories;

/*
 *UserRepository仓库,有关user的信息
 */
use App\Models\Bid_record;
use App\Models\Member;
use App\Models\Money_Log;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository implements UserRepositoryInterface
{
    //根据标的id查询出所有购买的用户信息
    public function findBuyRecordWithId($id, $limit = '10')
    {
        $record = $this->object2Array(Bid_record::where('o_id', $id)->orderBy('bid_time', 'desc')->paginate($limit));
        foreach ($record['data'] as $key => $val) {
            //修改时间显示格式
            $record['data'][$key]['bid_time'] = date('Y-m-d H:i:s', floor($val['bid_time']/1000)) . '.' . substr($val['bid_time'], -3);
            $usrid = $val['usr_id'];
            //根据用户名查出用户昵称
            $nickname = $this->findUserInfo($usrid);
            $record['data'][$key]['nickname'] =!empty($nickname['nickname']) ? $nickname['nickname'] : config('global.default_nickname');
            $record['data'][$key]['user_photo'] = !empty($nickname['user_photo']) ? $nickname['user_photo'] : config('global.default_photo');
            $record['data'][$key]['login_ip'] = !empty($val['login_ip']) ? $val['login_ip'] : (!empty($nickname['reg_ip']) ? $nickname['reg_ip'] : '');
            switch ($val['pay_type']) {
                case 'yue':
                    $record['data'][$key]['pay_type'] = '余额支付';
                    break;
                case 'weixin':
                    $record['data'][$key]['pay_type'] = '微信支付';
                    break;
                case 'unionpay':
                    $record['data'][$key]['pay_type'] = '银联支付';
                    break;
                default:
                    $record['data'][$key]['pay_type'] = '余额支付';
            }
        }
        return $record;
    }
    
    //根据标的id查询出所有购买的用户信息（移动端）
    public function findBuyRecordWithIdMobile($id, $page)
    {
        $skip = $page * 10;
        $record['data'] = $this->object2Array(Bid_record::where('o_id', $id)->orderBy('bid_time', 'desc')->skip($skip)->take(10)->get());
        foreach ($record['data'] as $key => $val) {
            //修改时间显示格式
            $record['data'][$key]['bid_time'] = date("Y-m-d H:i:s", floor($val['bid_time'] / 1000)) . '.' . substr($val['bid_time'], -3);
            $usrid = $val['usr_id'];
            //根据用户名查出用户昵称
            $nickname = $this->findUserInfo($usrid);
            $record['data'][$key]['nickname'] =!empty($nickname['nickname']) ? $nickname['nickname'] : config('global.default_nickname');
            $record['data'][$key]['user_photo'] = !empty($nickname['user_photo']) ? $nickname['user_photo'] : config('global.default_photo');
            $record['data'][$key]['login_ip'] = !empty($val['login_ip']) ? $val['login_ip'] : (!empty($nickname['reg_ip']) ? $nickname['reg_ip'] : '');
            switch ($val['pay_type']) {
                case 'yue':
                    $record['data'][$key]['pay_type'] = '余额支付';
                    break;
                case 'weixin':
                    $record['data'][$key]['pay_type'] = '微信支付';
                    break;
                case 'unionpay':
                    $record['data'][$key]['pay_type'] = '银联支付';
                    break;
                case 'alipay':
                    $record['data'][$key]['pay_type'] = '支付宝支付';
                    break;
                default:
                    $record['data'][$key]['pay_type'] = '余额支付';
            }
        }
        return $record;
    }

    //根据uid找出用户所有购买记录
    public function findBuyRecordUser($uid)
    {
        // TODO: Implement findBuyRecordUser() method.
    }

    //根据uid找出用户限定条数的购买记录
    public function findBuyRecordUserLimit($uid, $limit)
    {
        return DB::table('tab_member')
            ->leftjoin('tab_bid_record', 'tab_member.usr_id', '=', 'tab_bid_record.g_id')
            ->where('pay_type','!=','invite')
            ->orderBy('tab_bid_record.id', 'desc')
            ->take($limit)
            ->get() ;
    }

    //查询最新的全站购买记录$limit条
    public function findBuyRecordAllLimit($oid,$gid,$limit)
    {
        return $this->object2Array(Bid_record::orderBy('id', 'desc')
            ->where(['o_id'=>$oid,'g_id'=>$gid])
            ->where('pay_type','!=','invite')
            ->take($limit)->get());
    }

    //查询按照时间排序的$limit条记录
    public function findBuyRecordOrderByTime($time, $orderby, $limit)
    {
        // TODO: Implement findBuyRecordOrderByTime() method.
    }

    //查询用户购物车信息
    public function findShoppingCart($uid)
    {
        // TODO: Implement findShoppingCart() method.
    }

    //查出用户信息
    public function findUserInfo($uid)
    {
        return $this->object2Array(Member::where('usr_id', $uid)->get(['nickname', 'user_photo','reg_ip'])->first());
    }

    //批量查找用户信息
    public function findUserInfoWithArray($arruid)
    {
        return $this->object2Array(Member::whereIn('usr_id', $arruid)->get(['usr_id', 'nickname', 'user_photo']));
    }


    //根据商品o_id和用户id查找出用户的所有购买的号码
    public function findBuyRecordUserWithId($id, $uid, $limit = 0)
    {
        if ($limit == 0) {
            return $this->object2Array(Bid_record::where('o_id', $id)
                ->where('pay_type','!=','invite')
                ->where('usr_id', $uid)->get());
        } else {
            return $this->object2Array(Bid_record::where('o_id', $id)
                ->where('pay_type','!=','invite')
                ->where('usr_id', $uid)->take($limit)->get());
        }
    }

    //查询用户最近的登陆时间，返回时间戳
    public function findLoginTime($uid)
    {
        $login_time = Member::where('usr_id', $uid)->get(['login_time']);
        foreach ($login_time as $val) {
            return $val->login_time;
        }
    }

    //减少用户的余额
    public function reduceMoney($uid, $money)
    {
        $member = Member::where('usr_id', $uid)->first();
        if ($member) {
            $balance = $member->money;
            if ($balance - $money >= 0) {
                $member->money = $balance - $money;
                return $member->save();
            } else {
                return false;
            }
        }
        return false;
    }

    //用户账户金额发生变更之后进行日志记录
    public function moneyChangeLog($uid, $money, $type, $message = '')
    {

        $money_log = new Money_Log();
        $money_log->uid = $uid;
        $money_log->money = $money;
        $money_log->type = $type;
        $money_log->message = $message;
        $money_log->time = time();
        $money_log->save();
    }


}
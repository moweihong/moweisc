<?php

namespace App\Repositories;

/*
 *公共函数资源库
 */
use App\Repositories\Interfaces\FunctionRepositoryInterface;

class FunctionRepository extends Repository implements FunctionRepositoryInterface
{
    /**模板短信发送接口
     * @param  $phone_number 短信接收号码
     * @param  $template_id 短信模板类型
     * @param  $param 需要填充的参数,多个参数用半角符号隔开
     * @return array['code']=0 表示成功,array['resultText']='信息'，否则失败
     * ★验证码/修改密码短信，模板ID：21940
     * 【特速一块购】验证码：123456，注意保密哦。如非本人操作请及时登录并修改密码保证账户安全，如有疑问请拨打客服电话4006626985。
     ***/
    public function sendMessage($phone_number, $template_id, $param)
    {
        $url = config('global.api.base_url') . config('global.api.sendMessage');//接口地址
        $str_sign = config('global.message_platform') . rand(0, 9) . $phone_number . '-' . $template_id;//生成签名字符串
        $sign = $this->encrypt($str_sign, config('global.message_key'));//对字符串进行签名
        $phone_number = $phone_number;//手机号码
        $data['phone_number'] = $phone_number;
        $data['template_value'] = $this->exceptChar($param);//去除变量中c2a0
        $data['platform'] = config('global.message_platform');
        $data['sign'] = $sign;
        $data['template_id'] = $template_id;
        return json_decode($this->postCurl($url, $data), true);
    }

    /*发送群发短信
     *@param  $phone_number 短信接收号码
     *@param  $template_id 短信模板类型
     *@param  $param 需要填充的参数
    */
    public function sendADmsg($phone_number, $template_id)
    {
        switch ($template_id) {
            case 1:      //中奖短信
                $msg = '【特速一块购】客官，喜报送到，恭喜成为商品获得者，请及时登录我的账号完善收货地址，我们将以最快的速度为您安排发货。';
                break;
            case 2:      //收货邀请晒单短
                $msg = '【特速一块购】客官，您的商品已安全送达，赶紧去晒单分享，可以赚取更多块乐豆哦。更多惊喜关注公众号ts1kg2016，随时随地一块购！';
                break;
            case 3:      //晒单审核短信
                $msg = '【特速一块购】亲，您的晒单审核已通过，块乐豆已存入您的个人中心。更多惊喜关注公众号ts1kg2016，随时随地一块购！';
                break;
            case 4:         //购物车提醒短信
                $msg = '【特速一块购】大王，您选购的商品已经在购物车躺太久了，再不支付就要错失大奖了，只要一块就够了呢！';
                break;
        }
    }

    /**
     * curl
     * *
     */
    public function getCurl($url)
    {
        $curl = curl_init();
        $header [0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header [0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header [] = "Cache-Control: max-age=0";
        $header [] = "Connection: keep-alive";
        $header [] = "Keep-Alive: 300";
        $header [] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header [] = "Accept-Language: en-us,en;q=0.5";
        $header [] = "Pragma: "; // browsers keep this blank.
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');//设定代理
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.baidu.com');//伪造来源
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $content = curl_exec($curl); // execute the curl command get the data
        curl_close($curl); // close the connection
        if ($content) {
            // 如果抓取到了数据则返回json对象，结束代码
            return $content;
        }
    }

    /**
     * curl with post
     * *
     */
    public function postCurl($url, $postdata)
    {
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $tmpInfo = curl_exec($ch);
        curl_close($ch);
        if ($tmpInfo) {
            return $tmpInfo;
        }
    }


    /**
     * Des 加密解密
     **/
    public function encrypt($string, $key)
    {
        $size = mcrypt_get_block_size('des', 'ecb');
        $string = mb_convert_encoding($string, 'GBK', 'UTF-8');
        $string = $this->pkcs5_pad($string, $size);
        $key = $key;
        $td = mcrypt_module_open('des', '', 'ecb', '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $string);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    public function decrypt($string, $key)
    {
        $string = base64_decode($string);
        $key = $key;
        $td = mcrypt_module_open('des', '', 'ecb', '');
        //使用MCRYPT_DES算法,cbc模式
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        //初始处理
        $decrypted = mdecrypt_generic($td, $string);
        //解密
        mcrypt_generic_deinit($td);
        //结束
        mcrypt_module_close($td);

        $result = $this->pkcs5_unpad($decrypted);
        $result = mb_convert_encoding($result, 'UTF-8', 'GBK');
        return $result;
    }

    public function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    /***des encrypt end***/

    public function log($mesage)
    {
        $fp = fopen("debug.txt", "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . date("Y-m-d H:i:s", time()) . "\n_" . $mesage . "\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    public function string2Hex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return strtolower($hex);
    }

    public function hex2String($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]) & 0xff);
        }
        return $string;
    }

    public function exceptChar($string)
    {
        if (!empty($string)) {
            $string = $this->string2Hex($string);
            $string = str_replace('c2a0', '', $string);
            $string = $this->hex2String($string);
            return $string;
        }
        return;
    }


}

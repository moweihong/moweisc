<?php
namespace App\Http\Tools\Captcha;

class BspCaptcha{
	private $secret_id = 'AKIDlfzZG1n1InSHgHvxOHaQbvk042LBjkLU';
	private $secret_key = 'xsPN8tVnBAqE5Nins1rPMwAhEYawMclV';
	private $captacha_type ='4';
	private $disturb_level ='1';
	private $is_htttps =1;
	private $business_id = '1234';
	private $url = 'csec.api.qcloud.com/v2/index.php';

	
	/*
	*腾迅 bsp 天御验证码  by baoyaoling
	*/
    
   /* Construct query string from array */
   private function makeQueryString($args, $isURLEncoded)
   {
       return implode(
           '&', array_map(
           function ($key, $value) use (&$isURLEncoded) {
               if (!$isURLEncoded) {
                   return "$key=$value";
               } else {
                   return $key . '=' . urlencode($value);
               }
           }, array_keys($args), $args
       )
       );
   }
    
   private function makeURL($method, $action, $region, $secretId, $secretKey, $args)
   {

       /* Add common parameters */
       $args['Nonce'] = (string)rand(0, 0x7fffffff);
       $args['Action'] = $action;
       $args['Region'] = $region;
       $args['SecretId'] = $secretId;
       $args['Timestamp'] = (string)time();
       /* Sort by key (ASCII order, ascending), then calculate signature using HMAC-SHA1 algorithm */
       ksort($args);
       $args['Signature'] = base64_encode(
           hash_hmac(
               'sha1', $method . $this->url . '?' . $this->makeQueryString($args, false),
               $secretKey, true
           )
       );

       /* Assemble final request URL */
      
       return 'https://' . $this->url . '?' . $this->makeQueryString($args, true);
   }

    private function sendJsRequest($url, $method = 'POST')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (false !== strpos($url, "https")) {
            // 证书
            // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $resultStr = curl_exec($ch);
        $result = json_decode($resultStr, true);

        return $result;
    }
    
    /* Demo section */
    function getJsUrl()
    {

        $url =$this->makeURL(
            'GET',
            'CaptchaIframeQuery',
            'sz',
            $this->secret_id,
            $this->secret_key,

            array(
                /* 行为信息参数 */
                'userIp'       => $_SERVER['REMOTE_ADDR'],

                /* 验证码信息参数 */
                'captchaType'  =>$this->captacha_type,
                'disturbLevel' =>$this->disturb_level,
                'isHttps'      =>$this->is_htttps,

                /* 其他信息参数 */
                'businessId'   =>$this->business_id
            )
        );
        $result = $this->sendJsRequest($url);
        $jsUrl = $result['url'];

        return $jsUrl;
    }
    
    function Check($ticket)
    {
        $url =$this->makeURL(
            'GET',
            'CaptchaCheck',
            'sz',
            $this->secret_id,
            $this->secret_key,

            array(
                /* 行为信息参数 */
                'userIp'      => $_SERVER['REMOTE_ADDR'],

                /* 验证码信息参数 */
                'captchaType' => $this->captacha_type,
                'ticket'      => $ticket,


                /* 其他信息参数 */
                'businessId'  => $this->business_id
            )
        );
        $result = $this->sendJsRequest($url);

        return $result;
    }
    
    /*
     * 注册保护
     */
    function register($arr)
    {
        $url =$this->makeURL(
            'GET',
            'RegisterProtection',
            'gz',
            $this->secret_id,
            $this->secret_key,
            $arr
        );

        $result = $this->sendJsRequest($url);
        return $result;
    }
}
?>
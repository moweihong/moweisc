<?php

namespace App\Repositories\Interfaces;

/*公共函数接口*/

interface FunctionRepositoryInterface
{


    //短信平台接口函数封装提交给java
    public function sendMessage($phone_number, $template_id, $param);

    //Curl Get
    public function getCurl($url);

    //Curl Post
    public function postCurl($url, $postdata);

    //DES Encrypt
    public function encrypt($input, $key);

    //DES Decrypt
    public function decrypt($input, $key);

    //日志函数
    public function log($mesage);

    /**
     * 将十进制字符串转换为十六进制字符串
     *
     * @param $string 需要转换字符串
     * @return 一个十六进制字符串
     */
    public function string2Hex($string);

    /**
     * 16进制抓换为字符串
     *
     * @param $string 需要转换字符串
     * @return 一个十六进制字符串
     */
    public function hex2String($hex);

    //去除字符串包含的C2A0字符
    public function exceptChar($string);


}

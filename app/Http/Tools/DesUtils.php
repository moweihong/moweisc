<?php
namespace App\Http\Tools;

/**
 * DES 加密类
 */

class DesUtils
{
    private $key;

    function __construct($key)
    {
        $this->key = $key;
    }

    function encrypt($string)
    {
        $size = mcrypt_get_block_size('des','ecb');
        $string = mb_convert_encoding($string, 'GBK', 'UTF-8');
        $string = $this->pkcs5_pad($string, $size);
        $key = $this->key;
        $td = mcrypt_module_open('des', '', 'ecb', '');
        $iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $string);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }
    function decrypt($string)
    {
        $string = base64_decode($string);
        $key =$this->key;
        $td = mcrypt_module_open('des','','ecb','');
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
    function pkcs5_pad ($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text))
        {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
        {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
}



<?php
/**
 * Created by PhpStorm.
 * Author: KAM
 * Date: 2019/5/27
 * Time: 17:56
 */

namespace App\Utils\CreateWebAPI;


class Encrypt
{
    const MODULUS =
        '00e0b509f6259df8642dbc35662901477df22677ec152b5ff68ace615bb7b725152b3ab17a876aea8a5aa76d2e417629ec4ee341f56135fccf695280104e0312ecbda92557c93870114af6c9d05c4f7f0c3685b7a46bee255932575cce10b424d813cfe4875d3e82047b97ddef52741d546b8e289dc6935b3ece0462db0a22b8e7';
    const PUBKEY = '010001';
    const NONCE = '0CoJUm6Qyw8W8jud';
    const KEY = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct()
    {

    }

    public function index()
    {

    }

    /**
     * 获取随机16位字符串
     * @param $size
     * Author: KAM
     * Date: 2019/5/31 14:04
     * @return string
     */
    public static function createSecretKey($size)
    {
        $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $_key = '';
        for ($i = 0; $i < $size; $i++) {
            $rand = rand(0, count($keys) - 1);
            $_key .= $keys[$rand];
        }
        return $_key;
    }

    /**
     * AES-128-CBC 加密数据
     * @param string $text
     * @param string $secKey
     * Author: KAM
     * Date: 2019/5/31 14:03
     * @return string
     */
    public static function aesEncrypt($text = '', $secKey = '')
    {
        $lv = '0102030405060708';
        $_secKey = $secKey;
        $cipher = base64_encode(openssl_encrypt($text, "AES-128-CBC", $_secKey, OPENSSL_RAW_DATA, $lv));
        return $cipher;
    }

    /**
     * 16进制处理相反的数据，求幂再转字符串
     * @param $text
     * @param $pubKey
     * @param $modulus
     * Author: KAM
     * Date: 2019/5/31 14:03
     * @return array
     */
    public static function rsaEncrypt($text, $pubKey, $modulus)
    {
        $_text = strrev($text);
        $rand = bin2hex($_text);
        $biText = static::decodeBigInt($rand, 16);
        $biEx = static::decodeBigInt($pubKey, 16);
        $biMod = static::decodeBigInt($modulus, 16);
        $biRet = bcpowmod($biText, $biEx, $biMod);
        $encSecKey = static::encodeBigInt($biRet, 16);

        return ['rand' => $rand, 'biText' => $biText, 'biEx' => $biEx, 'biMod' => $biMod, 'biRet' => $biRet, 'encSecKey' => $encSecKey];
    }

    /**
     * 字符串转数字BigInt
     * @param $code
     * @param $base
     * Author: KAM
     * Date: 2019/5/31 14:02
     * @return string
     */
    public static function decodeBigInt($code, $base)
    {
        bcscale(0);
        $result = '';
        $len = strlen($code);
        for ($i = 1; $i <= $len; $i++) {
            $char = substr($code, $i - 1, 1);
            $result = bcadd(bcmul(strpos(static::KEY, $char), bcpow($base, $len - $i)), $result);
        }
        return $result;
    }

    /**
     * BigInt数字转字符串
     * @param $num
     * @param $radix
     * Author: KAM
     * Date: 2019/5/31 14:02
     * @return bool|string
     */
    public static function encodeBigInt($num, $radix)
    {
        bcscale(0);
        $str = '';
        if ($num <= 0)
            $str = substr(static::KEY, 0, 1);
        while ($num > 0) {
            $div = bcdiv($num, $radix);
            $mod = bcmod($num, $radix);
            $str = substr(static::KEY, $mod, 1) . $str;
            $num = $div;
        }
        return $str;
    }

    /**
     * 主要加密函数
     * @param array $data
     * Author: KAM
     * Date: 2019/5/31 14:00
     * @return array
     */
    public static function enctypt($data = [])
    {
        $text = str_replace(" ",'',json_encode($data, JSON_UNESCAPED_UNICODE));

//        $text = json_encode($data);
        $secKey = static::createSecretKey(16);
        $encText = static::aesEncrypt(static::aesEncrypt($text, static::NONCE), $secKey);
        $encSecKey = static::rsaEncrypt($secKey, static::PUBKEY, static::MODULUS);

        $res = 'params='.urlencode($encText).'&encSecKey='.urlencode($encSecKey['encSecKey']);
        return $res;
    }

    public static function eapi($data){
        $text = str_replace(' ','',json_encode($data, JSON_UNESCAPED_SLASHES));
        $en = openssl_encrypt($text, "AES-128-ECB", 'rFgB&h#%2?^eDg:Q', OPENSSL_RAW_DATA, '');
        $encrypt = strtoupper(bin2hex($en));

        return $encrypt;
    }

}
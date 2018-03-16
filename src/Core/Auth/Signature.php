<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2017/9/29
 * Time: 上午11:01
 */

namespace Pingqu\OpenApiSdk\Core\Auth;


class Signature
{
    //签名算法,$query是GET参数
    public static function getSign($postData,$query,$method, $secret = '') {
        //签名步骤一：按字典序排序参数
        ksort($postData);
        ksort($query);
        $string1 = self::ToUrlParams($postData);
        \Log::info($string1);
        $string2 = self::ToUrlParams($query);
        //签名步骤二：在string后加入KEY
        $string = $method.'/'.$string1 . $string2 . "&key=" . $secret;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;

    }

    protected static function ToUrlParams($data) {
        \Log::info($data);
        $buff = "";
        foreach ($data as $k => $v) {
            if ($v == '' || is_array($v) || is_object($v)) {
                continue;
            }

            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

//    public static function getSign($query,$secret)
//    {
//        $query = self::ToUrlParams($query);
//        $str = rawurlencode('/') . '&' . rawurlencode($query);
//        return base64_encode(hash_hmac('sha1', $str, $secret . '&', true));
//    }
}
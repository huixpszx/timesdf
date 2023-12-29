<?php

namespace Timespay\Df;

class BaseMethod
{
    public static function arrayToKv($arr,$sort=true)
    {
        if($sort){
            ksort($arr);
        }
        $tmp = array();
        foreach ($arr as $k => $param) {
            if (!empty($param)) {
                $tmp[] = $k.'='.$param;
            }
        }
        $params = implode('&', $tmp);
        return $params;
    }

    public static  function rsa_sign ($data, $privyKey_path)
    {
//通过存放路径，读取私钥
        if(file_exists($privyKey_path)){
            $prk = file_get_contents($privyKey_path);
            $privyKey = openssl_pkey_get_private($prk);
        }
        if (!is_string($data)) {
            return null;
        }
        if(!empty($privyKey)){
            openssl_sign($data, $sign, $privyKey);
            //base64编码
            return base64_encode($sign);
        }
        return null;
    }
}
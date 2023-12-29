<?php

namespace Timespay\Df;

class Method
{
    public static function sign($parrnedd,$appkey,$privKey_path)
    {
        //callback_url不参与签名
        unset($parrnedd['callback_url']);
        //加agent_key到数组
        $parrnedd['agent_key'] = $appkey;

        //从小到大排序
        $need_sign = BaseMethod::arrayToKv($parrnedd);

        //排序后的字符串rsa私钥签名
        return BaseMethod::rsa_sign($need_sign,$privKey_path);

    }

    public static function Send_post_from($url, $post_data)
    { //POST FROM格式
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded;charset=UTF-8',
                'content' => $postdata,
                'timeout' => 15 * 60
            )
        );
        $content = stream_context_create($options);
        return file_get_contents($url, false, $content);
    }
    public static function httpGet($url, $headers = [], $cookies = [])
    {
        $httpOptions = array(
            'method' => 'GET',
            'timeout' => 10,
        );

        if ($cookies) {
            $ls = [];
            foreach ($cookies as $k => $v) {
                $ls[] = $k . '=' . $v;
            }
            $headers['Cookie'] = implode('; ', $ls);
        }


        if ($headers) {
            $ls = [];
            foreach ($headers as $k => $v) {
                $ls[] = $k . ': ' . $v;
            }
            $httpOptions['header'] = $ls;
        }

        $options = array(
            'http' => $httpOptions
        );
        $context = stream_context_create($options);
        return @file_get_contents($url, false, $context);
    }
}
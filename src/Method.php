<?php

namespace Timespay\Df;
use Exception;

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

    public static function Send_post_form($url, $post_data)
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

    public static function verify ($formData,$appkey,$times_pubKey_path)
    {
//        $formData = $_POST;
        $sign_from = $formData['sign'];
        unset($formData['sign']);
        //加agent_key到数组
        $formData['agent_key'] = $appkey;

        //排序得到需要验证的字符串
        $need_sign = BaseMethod::arrayToKv($formData);
        //用我方公钥验证签名，不正确则直接退出
        $result = BaseMethod::rsa_verify($need_sign,$sign_from,$times_pubKey_path);

        //结果只有两种，true或者false
        if($result){
            return $result;
        }else{
            throw new Exception('回调验签不通过');
        }
    }

}
<?php

namespace Timespay\Df;

class ConfigChid
{
    public static function ConfigTimes()
    {
        //测试域名，生产改为正式域名
        $domain = '';
        //实际的项目地址，用于寻找私钥和公钥的存放地址
        $www = '';
        return [
            'balance_pay'=> $domain.'/pay/balance',
            'query_pay'=> $domain.'/pay/status',
            'pay_url'=> $domain.'/pay/order',
            'chid' => 'APITEST',//测试商户号，生产改为正式商户号
            'agent_key'   => 'qflugsx6qtl6pmwc',//测试密钥，生产改为正式密钥
            'privyKey_path' => $www.'/vendor/timespay/dfsdk/src/rsa/rsa_private_key.pem',//测试私钥的存放地址，生产改为正式私钥的存放地址
            'times_pubKey_path' => $www.'/vendor/timespay/dfsdk/src/rsa/kuaifu_pub.pem',//平台公钥，用于验证回调的签名
            'callback_url' => 'https://www.baidu.com',//测试回调地址，生产改为商户提交的地址
            'remark'=>'test',//测试商品备注，，生产改为商户自己的商品备注
        ];
    }
}
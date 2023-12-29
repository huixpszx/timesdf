<?php

namespace Timespay\Df;

class ConfigChid
{
    public static function ConfigTimes()
    {
        $domain = '';//测试域名，生产改为正式域名
        return [
            'url_pay'=> $domain.'/pay/index/index',
            'chid' => 'QD101',//测试商户号，生产改为正式商户号
            'appkey'   => 'cgefmuzmtri38x9s5kf898xuigea88ox',//测试密钥，生产改为正式密钥
            'channel_no' => '12580',//测试通道号，生产改为正式通道号
            'callback_url' => 'https://www.baidu.com',//测试回调地址，生产改为商户提交的地址
            'remark'=>'test',//测试商品备注，，生产改为商户自己的商品备注
        ];
    }
}
<?php

namespace Timespay\Df;

class SdkDf
{
    public static function test()
    {
        $config = ConfigChid::ConfigTimes();
        $privyKey_path = $config['privyKey_path'];
//        echo $privyKey_path;
        return file_get_contents($privyKey_path);
    }

    public static function balance(): bool|string
    {
        $config = ConfigChid::ConfigTimes();
        $balance_pay = $config['balance_pay'];
        $privyKey_path = $config['privyKey_path'];
        if(!str_contains($balance_pay, 'http')){
            return '需要在ConfigChid文件，正确的支付域名';
        }
        $my_self = [
            'chid' => $config['chid'],
            'timestamp' => time(),
        ];
        $my_self['sign'] = Method::Sign($my_self,$config['agent_key'],$privyKey_path);
        $resJson = Method::Send_post_from($balance_pay,$my_self);
        //msg转为utf-8
        return json_encode(json_decode($resJson,true),320);
    }

    public static function pay($fee = 100,$ext='')
    {
        $config = ConfigChid::ConfigTimes();
        if(!str_contains($config['url_pay'], 'http')){
            return '需要在ConfigChid文件，配置正确的支付域名';
        }
        //  $my_self里的金额和订单号，必须传入自己的真实数据
        if(empty($ext)){
            $ext = time();//商户唯一订单号，32位以内的字符串
        }
        $my_self = [
            'ext' => $ext,
            'fee' =>  number_format($fee, 2, '.', ''),
            // 支付金额，单位元，强制保留两位小数点
            'method' => 0,//支付固定传0
        ];


        // paymethod
        $pubMethod = [
            'chid' => $config['chid'],
            'channel_no' => $config['channel_no'],
            'callback_url' => $config['callback_url'],
            'remark' => $config['remark'],
            'timeamp' => date('YmdHis'),
        ];

        $pubMethod['sign'] = Method::Sign($pubMethod, $my_self,$config);
        $paramArr = $pubMethod +  $my_self;
        return Method::Send_post_form($config['url_pay'],$paramArr);
    }

    public static function pay_query($ext='')
    {
        $config = ConfigChid::ConfigTimes();
        if(!str_contains($config['url_pay'], 'http')){
            return '需要在ConfigChid文件，正确的支付域名';
        }
        //  $ext订单号，必须为自己的真实数据
        if(empty($ext)){
            $ext = time();//商户唯一订单号，32位以内的字符串
        }
        $sent = $config['url_pay'].'?method=1'.'&chid='.$config['chid'].'&ext='.$ext;
        return Method::httpGet($sent);
    }
}
<?php

namespace Timespay\Df;

class SdkDf
{
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
        $resJson = Method::Send_post_form($balance_pay,$my_self);
        //msg转为utf-8
        return json_encode(json_decode($resJson,true),320);
    }

    public static function order($form_date=[])
    {
        $config = ConfigChid::ConfigTimes();
        $pay_url = $config['pay_url'];
        $privyKey_path = $config['privyKey_path'];
        if(!str_contains($pay_url, 'http')){
            return '需要在ConfigChid文件，正确的支付域名';
        }
        //  $my_self里的金额和订单号，必须传入自己的真实数据
        if(empty($form_date['ext'])){
            $ext = time();//商户唯一订单号，32位以内的字符串
        }else{
            $ext = $form_date['ext'];
        }

        if(empty($form_date['uname'])){
            $uname = '测试';
        }else{
            $uname = $form_date['uname'];
        }

        if(empty($form_date['ucode'])){
            $ucode = '6226220612345678';
        }else{
            $ucode = $form_date['ucode'];
        }

        if(empty($form_date['fee'])){
            $form_date['fee'] = '100.00';
        }
        $fee = number_format($form_date['fee'], 2, '.', '');
        $paramArr = [
            'chid' => $config['chid'],
            'timestamp' => time(),
            'uname'=> $uname,
            'ucode' => $ucode,
            'bcode' => 'ICBC',//收款人银行编号，固定写ICBC
            'callback_url' => $config['callback_url'],
            'ext' => $ext,
            'fee' =>  $fee,
            // 支付金额，单位元，强制保留两位小数点
        ];
        //  传入下发参数，商户号密钥，私钥
        $paramArr['sign'] = Method::Sign($paramArr, $config['agent_key'],$privyKey_path);
        return Method::Send_post_form($pay_url,$paramArr);
    }

    public static function order_query($ext=''): bool|string
    {
        $config = ConfigChid::ConfigTimes();
        $query_pay = $config['query_pay'];
        $privyKey_path = $config['privyKey_path'];
        if(!str_contains($query_pay, 'http')){
            return '需要在ConfigChid文件，正确的支付域名';
        }
        //  $ext订单号，必须为自己的真实数据
        if(empty($ext)){
            return '需要传入自己的订单号来查询';//商户唯一订单号，32位以内的字符串
        }
        $my_self = [
            'chid' => $config['chid'],
            'timestamp' => time(),
            'ext' => $ext,
        ];
        $my_self['sign'] = Method::Sign($my_self,$config['agent_key'],$privyKey_path);
        $resJson = Method::Send_post_form($query_pay,$my_self);
        //msg转为utf-8
        return json_encode(json_decode($resJson,true),320);
    }
}
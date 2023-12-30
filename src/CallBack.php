<?php

namespace Timespay\Df;

class CallBack
{
    public static function PayCallBack()
    {
        $formData = $_POST;
        if(empty($formData)){
            $formData = [
                'flowid' => 'Times1703905439961gjsv2yf3rey00d',
                'paytime' => '1703909903',
                'fee' => '100.00',
                'ext' => '1703905438',
                'status' => 'success',
                'sign' => 'i9SxxhzBg31dbKaSKpjRpz/g9RpY9rl0tlOSbmRoNb3WrAORDwtw97j/DhI51SrTz+RRbBRjUMj87uIhK06UiUsRufAbmRG3Kr/6ZVI/VcCmGy8FYXtXqJ7K5pnO0AjPWAWjH2NxvZvFm/wKHD1cY6Ab06fOXOCkWDv1x7WwyFYY3K6qj8acyPy2SwhYlTwT7gZUeRB/Te7kckxnfsy99CmJ/cHDytOFSN6Ep/zf/71xBkKYn201IacoYa/Y7e9Npyg+h92FdpbSKVXYSiMnJjKZhvXGYBTed+AJqXN5FmHDZoe+LK/vzzxvafnFrQ5wiYePHh4ITq6Qs4sINOEwiw==',
            ];
        }
        $config = ConfigChid::ConfigTimes();
        $appkey = $config['agent_key'];
        $times_pubKey_path = $config['times_pubKey_path'];
        //  验证平台的签名
        Method::verify($formData, $appkey,$times_pubKey_path);
        //  已通过平台验证签名
        $formData['sign_check'] = "true";
        return json_encode($formData,320);
    }
}
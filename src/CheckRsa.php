<?php

namespace Timespay\Df;

class CheckRsa
{
    public static function PrviRsa()
    {
        $config = ConfigChid::ConfigTimes();
        $privyKey_path = $config['privyKey_path'];
//        echo $privyKey_path;
        return file_get_contents($privyKey_path);
    }

    public static function PubRsa()
    {
        $config = ConfigChid::ConfigTimes();
        $times_pubKey_path = $config['times_pubKey_path'];
//        echo $privyKey_path;
        return file_get_contents($times_pubKey_path);
    }
}
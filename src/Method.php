<?php

namespace Timespay\Df;

class Method
{
    public static function Sign($pubMethod, $my_self,$config)
    {
        $channel_needsign = "{$pubMethod['chid']}|{$my_self['ext']}|{$my_self['fee']}|{$pubMethod['timeamp']}|".$config['appkey'];
        //MD5加密后大写
        return strtoupper(md5($channel_needsign));
    }

    public static function Send_post_form($url, $post_data){
        { //POST FORM格式
            $postdate = http_build_query($post_data);
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type:application/x-www-form-urlencoded;charset=UTF-8',
                    'content' => $postdate,
                    'timeout' => 15 * 60
                )
            );
            $content = stream_context_create($options);
            return file_get_contents($url, false, $content);
        }
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
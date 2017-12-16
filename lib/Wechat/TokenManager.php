<?php namespace Lib\Wechat;

use Cache;
use Exception;

class TokenManager
{
    private static $app_id;
    private static $secret;
    private static $token;
    private static $instance;
    const token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=@app_id&secret=@secret';
    const ticket_url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=@access_token&type=jsapi';
    const cache_key = 'wechat_config';

    private function __construct()
    {

    }

    public static function getConfig()
    {
        if(Cache::has(self::cache_key)) return Cache::get(self::cache_key);

        $ticket = self::getTicket();
        $nonce_str = self::getNonceStr();
        $timestamp = time();
        $url = url()->full();

        $params = ['noncestr' => $nonce_str, 'jsapi_ticket' => $ticket, 'timestamp' => $timestamp, 'url' => $url];
        $sign = sha1(http_build_query($params));

        $config = [
            'app_id' => self::$app_id,
            'timestamp' => $timestamp,
            'nonce_str' => $nonce_str,
        ];
        Cache::put(self::cache_key, $config, 119); //119 minutes
        return $config;
    }

    public static function getToken()
    {
        self::init();
        $url = str_replace(['@app_id', '@secret'], [self::$app_id, self::$secret], self::token_url);
        $response = self::curl_get($url);
        $json = json_decode($response, true);
        if(empty($json['access_token'])) {
            //dd($json);
            throw new Exception('Fail to get Access Token' . $response);

        }
        return $json['access_token'];
    }

    public static function getTicket()
    {
        self::init();
        $token = self::getToken();
        $url = str_replace('@access_token', $token, self::ticket_url);
        $response = self::curl_get($url);
        $json = json_decode($response, true);
        if(empty($json['ticket'])) throw new Exception('Fail to get ticket');
        return $json['ticket'];
    }

    public static function init()
    {
        if (empty(self::$app_id) or empty(self::$secret) or empty(self::$token)) {
            self::$app_id = env('WECHAT_APPID');
            self::$secret = env('WECHAT_SECRET');
        }
    }

    private static function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if(empty($response)) throw new Exception('curl get request failed');
        return $response;
    }

    private static function getNonceStr($len = 16)
    {
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $list = str_split($charset);
        $count = count($list);
        $str = '';
        while($len > 0) {
            $len--;
            $index = mt_rand(0, $count - 1);
            $str .= $list[$index];
        }
        return $str;
    }
}
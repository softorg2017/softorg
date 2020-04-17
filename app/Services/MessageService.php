<?php namespace App\Services;

require_once base_path('lib/aliyun-dysms-php-sdk/api_sdk/vendor/autoload.php');
\Aliyun\Core\Config::load();

use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;


class MessageService
{
    private static $client = null;

    public function __construct()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";
        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";
        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";

        $access_key = env('SMS_ACCESS_KEY');
        $secret = env('SMS_SECRET');

        if(self::$client == null) {
            $profile = DefaultProfile::getProfile($region, $access_key, $secret);
            DefaultProfile::addEndPoint($endPointName, $region, $product, $domain);
            self::$client = new DefaultAcsClient($profile);
        }
    }

    public function send_SMS($mobile, $template_name, array $data = [])
    {
        $template = config("sms.template.{$template_name}");
        if(empty($template)) throw new Exception("unknow SMS template - {$template_name}");

        $sms = new SendSmsRequest();
        $sms->setPhoneNumbers($mobile);
        $sms->setSignName($template['sign_name']);
        $sms->setTemplateCode($template['code']);

        $send_data = [];
        foreach($template['keyword'] as $keyword) {
            if(!isset($data[$keyword])) {
                throw new Exception("模板中的{$keyword}未配置");
            } else {
                $send_data[$keyword] = $data[$keyword];
            }
        }

        $sms->setTemplateParam(json_encode($send_data));
        return self::$client->getAcsResponse($sms);
    }
}
<?php
namespace App\Repositories\Root;


use App\Models\Outside\OutsideModule;
use App\Models\Outside\OutsideMenu;
use App\Models\Outside\OutsideItem;
use App\Models\Outside\OutsideTemplate;
use App\Models\Outside\OutsidePivotMenuItem;


use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;
use App\Models\Org\OrgRecord;

use App\Models\Softorg;
use App\Models\SoftorgExt;
use App\Models\Record;
use App\Models\Website;

use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use App\Models\Apply;
use App\Models\Sign;
use App\Models\Answer;
use App\Models\Choice;

use App\Repositories\Common\CommonRepository;
use App\Repositories\Admin\MailRepository;

use Response, Auth, Validator, DB, Exception, Cache, Log;
use QrCode;

class WeixinRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgOrganization;
    }

    //
    public function gongzhonghao()
    {
//        $this->valid();
        $this->responseMsg();
    }


    // 初始化配置
    public function valid()
    {
        $echoStr = request('echostr','');
        if($this->checkSignature())
        {
            echo $echoStr;
            exit;
        }
    }

    //检查签名
    private function checkSignature()
    {
        $token = 'asdfghjklzxcvbnmqwertyuiop123456';
        $nonce = request('nonce','');
        $timestamp = request('timestamp','');
        $signature = request('signature','');
        $echoStr = request('echostr','');

        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str == $signature && $echoStr ) return true;
        else return false;
    }


    // 回应用户消息
    public function responseMsg()
    {

        // 1.获取到微信推送过来post数据（xml格式）
//             $message = $GLOBALS['HTTP_RAW_POST_DATA'];
        $message = file_get_contents("php://input");
        echo 'input something ...';
        exit;

//        if(!empty($message))
//        {
////                2.处理消息类型，并设置回复类型和内容
////                <xml>
////                    <ToUserName><![CDATA[toUser]]></ToUserName>
////                    <FromUserName><![CDATA[FromUser]]></FromUserName>
////                    <CreateTime>123456789</CreateTime>
////                    <MsgType><![CDATA[event]]></MsgType>
////                    <Event><![CDATA[subscribe]]></Event>
////                </xml>
//
//            $postObj = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
//
//            $fromUserName = $postObj->FromUserName;  // 获取发送方帐号（OpenID）
//            $toUserName = $postObj->ToUserName;  // 获取接收方账号
//            $keyword = trim($postObj->Content);  // 获取消息内容
//            $time = time();
//            $content = '我是'.$toUserName.'，'.$fromUserName.' 你好!';
////
//            $info =
//                "<xml>".
//                "<ToUserName>< ![CDATA[{$fromUserName}]] ></ToUserName>".
//                "<FromUserName>< ![CDATA[{$toUserName}]] ></FromUserName>".
//                "<CreateTime>{$time}</CreateTime>".
//                "<MsgType>< ![CDATA[text]] ></MsgType>".
//                "<Content>< ![CDATA[{$content}]] ></Content>".
//                "</xml>";
//            echo $info;
//            exit;
//
////            $ToUserName = 'nihao';
////            $FromUserName = 'nihao';
////            $Content = 'nihao';
////            return view('root.weixin.text')->with(['ToUserName'=>$ToUserName,'FromUserName'=>$FromUserName,'Content'=>$Content]);
//        }
//        else
//        {
//            echo '';
//            exit;
//        }


    }


}
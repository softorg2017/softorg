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

        $token = 'asdfghjklzxcvbnmqwertyuiop123456';
        $nonce = $_GET['nonce'];
        $timestamp = $_GET['timestamp'];
        $signature = $_GET['signature'];
        $echostr = $_GET['echostr'];

        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str == $signature && $echostr )
        {
            //第一次接入weixin api接口的时候
            echo $echostr;
            exit;
        }
        else
        {

            echo $echostr;
            exit;

            //1.获取到微信推送过来post数据（xml格式）
//            $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];

            //2.处理消息类型，并设置回复类型和内容
//            <xml>
//                <ToUserName><![CDATA[toUser]]></ToUserName>
//                <FromUserName><![CDATA[FromUser]]></FromUserName>
//                <CreateTime>123456789</CreateTime>
//                <MsgType><![CDATA[event]]></MsgType>
//                <Event><![CDATA[subscribe]]></Event>
//            </xml>

//            $postObj = simplexml_load_string( $postArr );
//            $postObj->ToUserName = '';
//            $postObj->FromUserName = '';
            //$postObj->CreateTime = '';
            //$postObj->MsgType = '';
            //$postObj->Event = '';
            // gh_e79a177814ed

//            if(!empty($GLOBALS["HTTP_RAW_POST_DATA"])) $message = $GLOBALS["HTTP_RAW_POST_DATA"];
//            if(!empty(file_get_contents('php://input'))) $message = file_get_contents('php://input');
//            $message = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
//            print_r($message);
//            Log::info($message);
//
//            $toUser = $message->ToUserName;
//            $fromUser   = $message->FromUserName;
//            $time = time();
//            $msgType = 'text';
//            $content = '我是'.$toUser.'，'.$fromUser.' 你好!';
//
//            $info =
//                "<xml>".
//                "<ToUserName>< ![CDATA[{$fromUser}]] ></ToUserName>".
//                "<FromUserName>< ![CDATA[{$toUser}]] ></FromUserName>".
//                "<CreateTime>{$time}</CreateTime>".
//                "<MsgType>< ![CDATA[text]] ></MsgType>".
//                "<Content>< ![CDATA[{$content}]] ></Content>".
//                "</xml>";
//            echo $info;
//            exit;
//            return response($info);


//            $ToUserName = 'nihao';
//            $FromUserName = 'nihao';
//            $Content = 'nihao';
//            return view('root.weixin.text')->with(['ToUserName'=>$ToUserName,'FromUserName'=>$FromUserName,'Content'=>$Content]);



            //判断该数据包是否是订阅的事件推送
//            if( strtolower( $postObj->MsgType) == 'event')
//            {
//                //如果是关注 subscribe 事件
//                if( strtolower($postObj->Event == 'subscribe') )
//                {
//                    //回复用户消息(纯文本格式)
//                    $toUser   = $postObj->FromUserName;
//                    $fromUser = $postObj->ToUserName;
//                    $time     = time();
//                    $msgType  =  'text';
//                    $content  = '欢迎关注我们的微信公众账号'.$postObj->FromUserName.'-'.$postObj->ToUserName;
//                    $template = "<xml>
//                                <ToUserName><![CDATA[%s]]></ToUserName>
//                                <FromUserName><![CDATA[%s]]></FromUserName>
//                                <CreateTime>%s</CreateTime>
//                                <MsgType><![CDATA[%s]]></MsgType>
//                                <Content><![CDATA[%s]]></Content>
//                                </xml>";
//                    $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
//                    return $info;
//                    /*<xml>
//                    <ToUserName><![CDATA[toUser]]></ToUserName>
//                    <FromUserName><![CDATA[fromUser]]></FromUserName>
//                    <CreateTime>12345678</CreateTime>
//                    <MsgType><![CDATA[text]]></MsgType>
//                    <Content><![CDATA[你好]]></Content>
//                    </xml>*/
//                }
//            }
//            else
//            {
//            }
        }

    }


}
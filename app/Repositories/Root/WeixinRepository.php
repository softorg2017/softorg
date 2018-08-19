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
use Lib\Wechat\TokenManager;

class WeixinRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgOrganization;
    }

    public function test()
    {
        $account = 'MHA00CTM';
        $password = '123456';
        $token_1 = md5(date("nj").$password);
        $token_2 = md5(date("YH").$account);
        $token = $token_1.$token_2;
        $url = 'http://api.51ohh.com/getxml.jsp?act=f&uid='.$account.'&token='.$token;
        $url = 'http://api.51ohh.com/?act=c&uid='.$account.'&token='.$token.'&dev=171919&com=326303';
        $url = 'https://wx.51ohh.com/dev_add_ohh.asp?weixin=ofNnNwi3jZPb3zhSsSG413J9qs78&token=7684220';

//        http://api.51ohh.com/?act=c&uid=MH000001&dev=12&com=50&token=9f5fc0089f1937314d923c4eb7bd130d451ed74dc34f836fbd451151071dca10

        $ch = curl_init();

        // 请求头
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        // 响应头
//        curl_setopt($ch, CURLOPT_HEADER, true);  // 返回相应头信息，否则只返回响应正文
//        curl_setopt($ch, CURLOPT_NOBODY, false); // 响应信息【包括】正文
//        curl_setopt($ch, CURLOPT_NOBODY, true); // 响应信息【不包括】正文

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 7);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $response = curl_exec($ch);

        // 获取请求头
        $request_header = curl_getinfo($ch);
        dd($request_header);

        curl_close($ch);


        $postObj = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        dd($postObj);
        dd(collect($postObj)->toArray());
    }

    //
    public function weixin_auth($post_data)
    {
        $app_id = env('WECHAT_APPID');
        $app_secret = env('WECHAT_SECRET');
        $code = $post_data["code"];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app_id}&secret={$app_secret}&code={$code}&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch);
        $response1 = json_decode($response1, true);
        var_dump($response1);

        $access_token = $response1["access_token"];
        $openid = $response1["openid"];

        // 获取授权用户信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        curl_setopt($ch, CURLOPT_URL, $url);
        $response2 = curl_exec($ch);
        $response2 = json_decode($response2, true);
        var_dump($response2);

        // 获取一般用户信息
        // $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";

        $info = $this->getInfo($openid);
        $info = json_decode($info, true);
        var_dump($info);
    }

    //
    public function gongzhonghao()
    {
        $echoStr = request('echostr',0);

        if(!empty($echoStr)) $this->valid();
        else $this->responseMsg();
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

//         1.获取到微信推送过来post数据（xml格式）
//         $message = $GLOBALS['HTTP_RAW_POST_DATA'];

        $message = file_get_contents("php://input");

        if(!empty($message))
        {
//                2.处理消息类型，并设置回复类型和内容
//                <xml>
//                    <ToUserName><![CDATA[toUser]]></ToUserName>
//                    <FromUserName><![CDATA[FromUser]]></FromUserName>
//                    <CreateTime>123456789</CreateTime>
//                    <MsgType><![CDATA[event]]></MsgType>
//                    <Event><![CDATA[subscribe]]></Event>
//                </xml>

            $postObj = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUserName = $postObj->FromUserName;  // 获取发送方帐号（OpenID）
            $toUserName = $postObj->ToUserName;  // 获取接收方账号
            $keyword = trim($postObj->Content);  // 获取消息内容
            $time = time();
            $content = '很高兴认识你';

//            Log:info($content);



//            $info = $this->getInfo($fromUserName);
            $content = $fromUserName;

            // 消息模板
            $textTpl = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[%s]]></Content>
                  <FuncFlag>0</FuncFlag>
                  </xml>";

            // 格式化消息模板
            $resultStr = sprintf($textTpl,$fromUserName,$toUserName,$time,$content);
            echo $resultStr;
            exit;

//            echo view('root.weixin.text')
//                ->with(['toUserName'=>$fromUserName,'fromUserName'=>$toUserName,'time'=>$time,'content'=>$content]);
//            exit;
        }
        else
        {
            echo '';
            exit;
        }


    }


    public function root()
    {
        $info = $this->getInfo("ojBDq06UlHn3OTfJ2TKeaifaHzCc");
        dd($info);
    }

    // 创建菜单
    public function createMenu($data, $token='')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) return curl_error($ch);

        curl_close($ch);
        return $tmpInfo;
    }

    // 获取菜单
    public function getMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
    }

    // 删除菜单
    public function deleteMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
    }



    // 获取用户 UnionId
    public function getInfo($openid)
    {
        header("Content-type: text/html; charset=utf-8");
        $access_token = TokenManager::getToken();
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}";
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) return curl_error($ch);
        curl_close($ch);
        return $tmpInfo;
    }


}
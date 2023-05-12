<?php
namespace App\Repositories\LW\WWW;

use App\User;
use App\UserExt;

use App\Models\Def\Def_Item;
use App\Models\Def\Def_Pivot_User_Relation;

use Response, Auth, Validator, DB, Exception, Cache, Log;
use QrCode;
use Lib\Wechat\TokenManager;

use App\Repositories\Common\CommonRepository;

class WeixinRepository {

    private $model;
    private $repo;
    public function __construct()
    {
    }


    public function root()
    {
        $data = '{
            "button":
            [
                {    
                    "type":"view",
                    "name":"如未",
                    "url":"http://softdoc.cn/"
                },
                {
                    "name":"我",
                    "sub_button":
                    [
                        {    
                            "type":"view",
                            "name":"待办事",
                            "url":"http://softdoc.cn/home/todolist"
                        },
                        {
                            "type":"view",
                            "name":"日程",
                            "url":"http://softdoc.cn/home/schedule"
                        },
                        {
                            "type":"view",
                            "name":"收藏",
                            "url":"http://softdoc.cn/home/collection"
                        }
                    ]
                }
            ]
        }';
        define("ACCESS_TOKEN", TokenManager::getToken());
        $res = $this->createMenu($data);
        dd($res);

        $info = $this->getInfo("ojBDq06UlHn3OTfJ2TKeaifaHzCc");
        dd($info);
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




    // 微信扫码登录
    public function weixin_login($post_data)
    {
        $app_id = env('WECHAT_WEBSITE_LOOKWIT_APPID');
        $app_secret = env('WECHAT_WEBSITE_LOOKWIT_SECRET');
        $code = $post_data["code"];
        $state = $post_data["state"];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app_id}&secret={$app_secret}&code={$code}&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch);
        $response1 = json_decode($response1, true);

        if(isset($response1["errcode"]))
        {
            dd($response1);
        }
        else
        {
            $access_token = $response1["access_token"];
            $openid = $response1["openid"];
            $unionid = $response1["unionid"];

            // 获取授权用户信息
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            curl_setopt($ch, CURLOPT_URL, $url);
            $response2 = curl_exec($ch);
            $response2 = json_decode($response2, true);

            $headimgurl = $response2["headimgurl"];

            $user = User::where('wx_unionid',$unionid)->first();
            if($user)
            {
                Auth::login($user,true);
                if($state == '' || $state == "STATE") return redirect('/');
                else return redirect($state);
            }
            else
            {
                $return =$this->register_wx_user($unionid);
                if($return["success"])
                {
                    $user1 = User::where('wx_unionid',$unionid)->first();
                    Auth::login($user1,true);

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $headimgurl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
                    $data = curl_exec($curl);
                    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    curl_close($curl);
                    if ($code == 200)
                    {
                        //把URL格式的图片转成base64_encode格式的！
                        $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
                        $img_content = $imgBase64Code;//图片内容

                        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_content, $result))
                        {

                            $type = $result[2]; // 得到图片类型 png?jpg?jpeg?gif?
                            $filename = uniqid().time().'.'.$type;
                            $storage_path = "resource/root/common/".date('Y-m-d')."/";
                            $sql_path = "root/common/".date('Y-m-d')."/";
                            $sql_text = $sql_path.$filename;

                            $file = storage_path($storage_path.$filename);
                            $path = storage_path($storage_path);
                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }

                            if (file_put_contents($file, base64_decode(str_replace($result[1], '', $img_content))))
                            {
                                $user1->username = $response2["nickname"];
                                $user1->portrait_img = $sql_text;
                                $user1->save();
                            }
                        }
                    }
                    //echo $img_content;exit;
                    if($state == '' || $state == "STATE")
                    {
                        return redirect('/');
//                        return redirect(url()->previous());
                    }
                    else return redirect($state);

                }
                else
                {
                    dd($return);
                }
            }
        }
    }


    // 微信公众号授权
    public function weixin_auth($post_data)
    {
        $app_id = env('WECHAT_LOOKWIT_APPID');
        $app_secret = env('WECHAT_LOOKWIT_SECRET');
        $code = $post_data["code"];
        $state = $post_data["state"];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app_id}&secret={$app_secret}&code={$code}&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch);
        $response1 = json_decode($response1, true);

        if(isset($response1["errcode"]))
        {
            dd($response1);
        }
        else
        {
            $access_token = $response1["access_token"];
            $openid = $response1["openid"];
            $unionid = $response1["unionid"];

            // 获取授权用户信息
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            curl_setopt($ch, CURLOPT_URL, $url);
            $response2 = curl_exec($ch);
            $response2 = json_decode($response2, true);

            $headimgurl = $response2["headimgurl"];

            $user = User::where('wx_unionid',$unionid)->first();
            if($user)
            {
                Auth::login($user,true);
                if($state == '' || $state == "STATE") return redirect('/');
                else return redirect($state);
            }
            else
            {
                $return =$this->register_wx_user($unionid);
                if($return["success"])
                {
                    $user1 = User::where('wx_unionid',$unionid)->first();
                    Auth::login($user1,true);

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $headimgurl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
                    $data = curl_exec($curl);
                    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    curl_close($curl);
                    if ($code == 200)
                    {
                        //把URL格式的图片转成base64_encode格式的！
                        $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
                        $img_content = $imgBase64Code;//图片内容

                        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_content, $result))
                        {

                            $type = $result[2]; // 得到图片类型 png?jpg?jpeg?gif?
                            $filename = uniqid().time().'.'.$type;
                            $storage_path = "resource/root/common/".date('Y-m-d')."/";
                            $sql_path = "root/common/".date('Y-m-d')."/";
                            $sql_text = $sql_path.$filename;

                            $file = storage_path($storage_path.$filename);
                            $path = storage_path($storage_path);
                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }

                            if (file_put_contents($file, base64_decode(str_replace($result[1], '', $img_content))))
                            {
                                $user1->username = $response2["nickname"];
                                $user1->portrait_img = $sql_text;
                                $user1->save();
                            }
                        }
                    }
                    //echo $img_content;exit;
                    if($state == '' || $state == "STATE")
                    {
                        return redirect('/');
//                        return redirect(url()->previous());
                    }
                    else return redirect($state);

                }
                else
                {
                    dd($return);
                }
            }
        }



//        var_dump($response2);
//
//        // 获取一般用户信息
//        // $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
//
//        $info = $this->getInfo($openid);
//        $info = json_decode($info, true);
//        var_dump($info);
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


    // 注册微信用户
    public function register_wx_user($unionid)
    {
        DB::beginTransaction();
        try
        {
            $user = new User;
            $user_create['user_category'] = 1;
            $user_create['user_type'] = 1;
            $user_create['wx_unionid'] = $unionid;
            $bool = $user->fill($user_create)->save();
            if(!$bool) throw new Exception("insert--user--failed");

            $user_ext = new UserExt;
            $user_ext_create['user_id'] = $user->id;
            $bool_2 = $user_ext->fill($user_ext_create)->save();
            if(!$bool_2) throw new Exception("insert--user-ext--failed");

            DB::commit();
            return ['success' => true];
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '注册失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return ['success' => false];
        }

    }


}
<?php
    /**
     * wechat php test
     */

    //获得参数 signature nonce token timestamp echostr


    $token     = 'imooc';
    $nonce     = $_GET['nonce'];
    $timestamp = $_GET['timestamp'];
    $signature = $_GET['signature'];
    $echostr   = $_GET['echostr'];

    //形成数组，然后按字典序排序
    $array = array();
    $array = array($nonce, $timestamp, $token);
    sort($array);
    //拼接成字符串,sha1加密 ，然后与signature进行校验
    $str = sha1( implode( $array ) );
    if( $str == $signature && $echostr )
    {
        //第一次接入weixin api接口的时候
        echo  $echostr;
        exit;
    }



//    //define your token
//    define("TOKEN", "asdfghjklzxcvbnmqwertyuiop123456");
//
//    $wechatObj = new wechatCallbackapiTest();
//
//    $wechatObj->valid();
//
//    class wechatCallbackapiTest
//    {
//        public function valid()
//        {
//            $echoStr = $_GET["echostr"];
//            //valid signature , option
//            if($this->checkSignature()){
//                header('content-type:text');
//                echo $echoStr;
//                exit;
//            }
//        }
//        public function responseMsg()
//        {
//            //get post data, May be due to the different environments
//            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//            //extract post data
//            if (!empty($postStr)){
//
//                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
//                $fromUsername = $postObj->FromUserName;
//                $toUsername = $postObj->ToUserName;
//                $keyword = trim($postObj->Content);
//                $time = time();
//                $textTpl = "<xml>
//                                <ToUserName><![CDATA[%s]]></ToUserName>
//                                <FromUserName><![CDATA[%s]]></FromUserName>
//                                <CreateTime>%s</CreateTime>
//                                <MsgType><![CDATA[%s]]></MsgType>
//                                <Content><![CDATA[%s]]></Content>
//                                <FuncFlag>0</FuncFlag>
//                                </xml>";
//                if(!empty( $keyword ))
//                {
//                    $msgType = "text";
//                    $contentStr = "Welcome to wechat world!";
//                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                    echo $resultStr;
//                }else{
//                    echo "Input something...";
//                }
//            }else {
//                echo "";
//                exit;
//            }
//        }
//
//        private function checkSignature()
//        {
//            $signature = $_GET["signature"];
//            $timestamp = $_GET["timestamp"];
//            $nonce = $_GET["nonce"];
//
//
//
//            $token = TOKEN;
//            $tmpArr = array($token, $timestamp, $nonce);
//            print_r($tmpArr);
//            echo "<hr>";
//            sort($tmpArr,SORT_STRING);
//            print_r($tmpArr);
//            echo "<hr>";
//            $tmpStr = implode( $tmpArr );
//            echo $tmpStr;
//            echo "<hr>";
//            $tmpStr = sha1( $tmpStr );
//            echo "sha1加密后:".$tmpStr;
//            echo "<hr>";
//            echo  'signature:'.$signature;
//
//            if( $tmpStr == $signature ){
//                return true;
//            }else{
//                return false;
//            }
//        }
//    }
<?php

namespace App\Http\Middleware;

use Closure;

class CheckSignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验签
        if (isset($_REQUEST['echostr'])) {
            //微信公众号第一次接入时需要验签，验证后原样返回
            $this->firstAccess();
        } else {
            //获取输入php://input
            $postStr = file_get_contents("php://input");
            if (empty($postStr)) {
                echo "";
                exit;
            }
            //解析XML
            $xmlObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xmlObj === false) {
                echo "";
                exit;
            }
            //接收到的每条消息验签
            $this->valid($xmlObj);
            $request->attributes->add(compact('xmlObj'));
        }
        return $next($request);
    }

    private function firstAccess()
    {
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        //读取临时Token
        $token = config('temp.Token','ningjian');
        if ($this->checkSignature($token, $signature, $timestamp, $nonce)) {
            // ob_clean(); //两行真牛逼
            // header('content-type:text'); //两行真牛逼
            echo $_REQUEST["echostr"];
            exit;
        }
    }

    private function valid($xmlObj)
    {
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];

        //根据解析后不同的XML格式，获取其对应的配置信息
        if (isset($xmlObj->ToUserName)) {
            $token = config($xmlObj->ToUserName . '.Token', 'ningjian');
        } elseif (isset($xmlObj->AppId)) {
            $token = config($xmlObj->AppId . '.Token', 'ningjian');
        } else {
            echo "";
            exit;
        }

        //验证消息来源，没有此参数就不用验证了
        if (isset($_REQUEST["signature"]) && !$this->checkSignature($token, $_REQUEST["signature"], $timestamp, $nonce)) {
            echo "";
            exit;
        }

        //判断是否加密（只有加密时才有必要验证信息加密后的签名）
        if (isset($xmlObj->Encrypt)) {
            $msg_encrypt = $xmlObj->Encrypt;
            //消息体签名验证，没有此参数就不用验证了
            if (isset($_REQUEST["msg_signature"]) && !$this->checkSignature($token, $_REQUEST["msg_signature"], $timestamp, $nonce, $msg_encrypt)) {
                echo "";
                exit;
            }
        }
    }

    private function checkSignature($token, $signature, $timestamp, $nonce, $msg_encrypt = '')
    {
        if (empty($token) || empty($signature) || empty($timestamp) || empty($nonce)) return false;
        if(empty($msg_encrypt)){
            $tmpArr = array($token, $timestamp, $nonce);
        }else{
            $tmpArr = array($token, $timestamp, $nonce, $msg_encrypt);
        }
        //sort_flags = SORT_STRING不能少！！！
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr); //数组拼接成字符串
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}

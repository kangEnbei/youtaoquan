<?php

namespace App\Http\Middleware;

use Closure;

class DecryptMiddleware
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
        //获取输入php://input
        $postStr = file_get_contents("php://input");
        if (empty($postStr)) {
            echo "";
            exit;
        }
        //解析XML
        $xmlObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //验证签名（不通过则中断）
        $xmlObj = $this->valid($xmlObj);
        //判断是否需要解密
        if(isset($xmlObj->Encrypt)){
            //解密，返回解密后的XML对象
            $xmlObj = $this->decrypt($xmlObj);
            $IF_ENCRYPT = true;
            $request->attributes->add(compact('IF_ENCRYPT'));
        };
        //XML对象转字符串
        //$xmlStr = $xmlObj->asXML();
        $request->attributes->add(compact('xmlObj'));

        return $next($request);
    }

    /**
     * 微信公众号接口第一次接入验证（通过后原样返回$_REQUEST['echostr']）
     */
    private function firstAccess()
    {
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        //读取临时Token
        $token = config('wechat.temp.Token', 'ningjian');

        if ($this->checkSignature($token, $signature, $timestamp, $nonce)) {
            // ob_clean(); //两行真牛逼
            // header('content-type:text'); //两行真牛逼
            echo $_REQUEST["echostr"];
            exit;
        }
    }

    /**
     * 验签方法
     * @param $xmlObj
     * @return mixed
     */
    private function valid($xmlObj)
    {
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        //根据不同公众号ID获取其对应的配置信息
        if (isset($xmlObj->ToUserName)) {
            $token = config('wechat.' . $xmlObj->ToUserName . '.Token', 'ningjian');
        } elseif (isset($xmlObj->AppId)) {
            $token = config('wechat.' . $xmlObj->AppId . '.Token', 'ningjian');
        } else {
            echo "";
            exit;
        }

        //验证信息来源（签名），没有此参数就不用验证了
        if (isset($_REQUEST["signature"]) && !$this->checkSignature($token, $_REQUEST["signature"], $timestamp, $nonce)) {
            echo "";
            exit;
        }

        //判断是否加密（只有加密时才有必要验证信息加密后的签名）
        if (isset($xmlObj->Encrypt)) {
            $msg_encrypt = $xmlObj->Encrypt;
            //消息体签名验证，没有此参数就不用验证了
            if (isset($_REQUEST["msg_signature"]) && !$this->checkSignature($token, $_REQUEST["signature"], $_REQUEST["signature"], $nonce, $msg_encrypt)) {
                echo "";
                exit;
            }
        }
        return $xmlObj;
    }

    /**
     * 解密方法
     * @param $xmlObj
     * @return \SimpleXMLElement
     */
    private function decrypt($xmlObj)
    {
        //（先判断是否需要）
        if (isset($xmlObj->Encrypt)) {
            if (isset($xmlObj->ToUserName)) {
                //用户发送给公众号的消息（由公众号第三方平台代收）。
                //此时，消息XML体中，ToUserName（即接收者）为公众号的原始ID（可通过《接口说明》中的获取授权方信息接口来获得）
                $appID = config('wechat.' . $xmlObj->ToUserName . '.AppID', 'wx550edb53f9e9cc7c');
                $encodingAESKey = config('wechat.' . $xmlObj->ToUserName . '.EncodingAESKey', 'CQIodkZlvLV9VmkjabY7ZQ6SHqLsEpc9IOnrUVz3naB');
            } elseif ($xmlObj->AppId) {
                //微信服务器发送给服务自身的事件推送（如取消授权通知，Ticket推送等）。
                //此时，消息XML体中没有ToUserName字段，而是AppId字段，即公众号服务的AppId。
                //这种系统事件推送通知（现在包括推送component_verify_ticket协议和推送取消授权通知），
                //服务开发者收到后也需进行解密，接收到后只需直接返回字符串“success”。
                $appID = config('wechat.' . $xmlObj->AppId . '.AppID', 'wx550edb53f9e9cc7c');
                $encodingAESKey = config('wechat.' . $xmlObj->AppId . '.EncodingAESKey', 'CQIodkZlvLV9VmkjabY7ZQ6SHqLsEpc9IOnrUVz3naB');
            } else {
                echo "";
                exit;
            }
            $pc = new \Prpcrypt($encodingAESKey);
            $result = $pc->decrypt($xmlObj->Encrypt, $appID);
            //解密失败
            if ($result[0] != 0) {
                echo "";
                exit;
            }
            //XML字符串转对象
            $xmlObj = simplexml_load_string($result[1], 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        //返回对象
        return $xmlObj;
    }

    private function checkSignature($token, $signature, $timestamp, $nonce, $msg_encrypt = '')
    {
        if (empty($token) || empty($signature) || empty($timestamp) || empty($nonce)) return false;
        $tmpArr = array($token, $timestamp, $nonce, $msg_encrypt);
        sort($tmpArr);
        $tmpStr = implode($tmpArr); //数组拼接成字符串
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}

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
        $xmlObj = $request->get('xmlObj', null);
        if (isset($xmlObj->Encrypt)) {
            $xmlObj = $this->decrypt($xmlObj);
            $request->attributes->add(compact('xmlObj'));
            $IF_ENCRYPT = true;
            $request->attributes->add(compact('IF_ENCRYPT'));
        } else {
            echo "";
            exit;
        }
        return $next($request);
    }

    private function decrypt($xmlObj)
    {
        //先判断是否需要
        if (isset($xmlObj->Encrypt)) {
            if (isset($xmlObj->ToUserName)) {
                //用户发送给公众号的消息（由公众号第三方平台代收）。
                //此时，消息XML体中，ToUserName（即接收者）为公众号的原始ID（可通过《接口说明》中的获取授权方信息接口来获得）
                $appID = config($xmlObj->ToUserName . '.AppID', 'wx550edb53f9e9cc7c');
                $encodingAESKey = config($xmlObj->ToUserName . '.EncodingAESKey', 'CQIodkZlvLV9VmkjabY7ZQ6SHqLsEpc9IOnrUVz3naB');
            } elseif ($xmlObj->AppId) {
                //微信服务器发送给服务自身的事件推送（如取消授权通知，Ticket推送等）。
                //此时，消息XML体中没有ToUserName字段，而是AppId字段，即公众号服务的AppId。
                //这种系统事件推送通知（现在包括推送component_verify_ticket协议和推送取消授权通知），
                //服务开发者收到后也需进行解密，接收到后只需直接返回字符串“success”。
                $appID = config($xmlObj->AppId . '.AppID', 'wx550edb53f9e9cc7c');
                $encodingAESKey = config($xmlObj->AppId . '.EncodingAESKey', 'CQIodkZlvLV9VmkjabY7ZQ6SHqLsEpc9IOnrUVz3naB');
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
            if ($xmlObj === false) {
                echo "";
                exit;
            }
        }
        //返回对象
        return $xmlObj;
    }

}

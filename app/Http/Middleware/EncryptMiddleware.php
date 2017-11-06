<?php

namespace App\Http\Middleware;

use Closure;

class EncryptMiddleware
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
        $response = $next($request);

        // Perform action
        //判断用不用加密
        $IF_ENCRYPT = $request->get('IF_ENCRYPT', false);
        if ($IF_ENCRYPT) {
            $response->setContent($this->encrypt($response->getContent()));
        }
        return $response;
    }

    private function encrypt($content)
    {
        $xmlObj = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xmlObj === false) {
            echo "";
            exit;
        }
        if (!isset($xmlObj->FromUserName)) {
            echo "";
            exit;
        }

        $appID = config($xmlObj->FromUserName . '.AppID', 'wx550edb53f9e9cc7c');
        $encodingAESKey = config($xmlObj->FromUserName . '.EncodingAESKey', 'CQIodkZlvLV9VmkjabY7ZQ6SHqLsEpc9IOnrUVz3naB');
        $token = config($xmlObj->FromUserName . '.Token', 'ningjian');

        $pc = new \WXBizMsgCrypt($token, $encodingAESKey, $appID);
        $timeStamp = $xmlObj->CreateTime;
        $nonce = $this->getRandomStr(6);
        $encryptMsg = '';
        $errCode = $pc->encryptMsg($content, $timeStamp, $nonce, $encryptMsg);
        //加密错误
        if ($errCode != 0) {
            echo "";
            exit;
        }

        $content = $encryptMsg;
        return $content;
    }

    private function getRandomStr($length = 16)
    {
        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}

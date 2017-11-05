<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatCallbackController extends Controller
{
    public function index()
    {
        //微信公众号接口第一次接入，验证后原样返回
        if (isset($_REQUEST['echostr'])) {
            $this->valid();
        } else {
        }
    }

    private function valid(){
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        //读取临时Token
        $token = config('temp.Token', 'ningjian');

        if ($this->checkSignature($token, $signature, $timestamp, $nonce)) {
            // ob_clean(); //两行真牛逼
            // header('content-type:text'); //两行真牛逼
            echo $_REQUEST["echostr"];
            exit;
        }
    }

    public function index2(Request $request)
    {
        $xmlObj = $request->get('xmlObj');
        //消息类型
        $RX_TYPE = trim($xmlObj->MsgType);
        switch ($RX_TYPE) {
            case "text":
                $resultStr = $this->receiveText($xmlObj);
                break;
            case "image":
                $resultStr = $this->receiveImage($xmlObj);
                break;
            case "voice":
                $resultStr = $this->receiveVoice($xmlObj);
                break;
            case "video":
                $resultStr = $this->receiveVideo($xmlObj);
                break;
            case "shortvideo":
                $resultStr = $this->receiveShortVideo($xmlObj);
                break;
            case "location":
                $resultStr = $this->receiveLocation($xmlObj);
                break;
            case "link":
                $resultStr = $this->receiveLink($xmlObj);
                break;
            case "event":
                $resultStr = $this->receiveEvent($xmlObj);
                break;
            default:
                $resultStr = "unknow msg type: " . $RX_TYPE;
                break;
        }

        echo $resultStr;
    }

    /**
     * 接收文本消息
     * @param $object
     * @return string
     */
    private function receiveText($object)
    {
        //判断消息是否重复
//        if ($this->msgRepeated($object)) {
//            return "";
//        }

        //根据关键词从Redis
        $fromUserName = $object->FromUserName;
        $content = $object->Content;
        if (strcasecmp($content, 'openid') == 0) {
            //返回用户OPENID
            $contentStr = $fromUserName;
            $resultStr = $this->transmitText($object, $contentStr);
        } else {
            //城市天气，现在用不了，解析XML太耗时。
            $tw = new WeatherApiTest();
            $contentStr = $tw->getWeatherInfo($content);
            $resultStr = $this->transmitText($object, $contentStr);
        }
        //返回XML字符串
        return $resultStr;
    }

    /**
     * 接收事件，关注等
     * @param $object
     * @return string
     */
    private function receiveEvent($object)
    {
        //判断消息是否重复
        if ($this->msgRepeated($object)) {
            return "";
        }

        $contentStr = "";
        switch ($object->Event) {
            case "subscribe":
                $title = "你好，发送666即可玩摇摇机"; //关注后回复内容
                $contentStr = $this->transmitText($object, $title);
                break;
            case "unsubscribe":
                $contentStr = "取消成功";
                $this->unsubscribe($object);
                break;
            case "LOCATION":
                $contentStr = $this->receiveClick($object); //点击事件
                break;
            case "CLICK":
                $contentStr = $this->receiveClick($object); //点击事件
                break;
            case "VIEW":
                $contentStr = $this->receiveClick($object); //点击事件
                break;
            default:
                $contentStr = "receive a new event: " . $object->Event;
                break;
        }
        //返回XML字符串
        return $contentStr;
    }
}
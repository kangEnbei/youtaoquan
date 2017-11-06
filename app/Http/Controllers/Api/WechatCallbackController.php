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
    public function index(Request $request)
    {
        $resultStr = "";
        $xmlObj = $request->get('xmlObj', null);
        if (!is_null($xmlObj)) {
            //消息类型
            $RX_TYPE = trim($xmlObj->MsgType);
            switch ($RX_TYPE) {
                case "text":
                    $resultStr = $this->receiveText($xmlObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($xmlObj);
                    break;
                default:
                    $resultStr = "unknow msg type: " . $RX_TYPE;
                    break;
            }
        }
        return $resultStr;
    }

    /**
     * 接收文本消息
     * @param $object
     * @return string
     */
    private function receiveText($object)
    {
        //判断消息是否重复
        if ($this->msgRepeated($object)) {
            return "";
        }

        //根据关键词从Redis
        $fromUserName = $object->FromUserName;
        $content = $object->Content;
        $resultStr = $this->transmitText($object, "你好");
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
//        if ($this->msgRepeated($object)) {
//            return "";
//        }

//        $contentStr = "";
//        switch ($object->Event) {
//            case "subscribe":
//                $title = "你好，发送666即可玩摇摇机"; //关注后回复内容
//                $contentStr = $this->transmitText($object, $title);
//                break;
//            case "unsubscribe":
//                $contentStr = "取消成功";
//                $this->unsubscribe($object);
//                break;
//            case "LOCATION":
//                $contentStr = $this->receiveClick($object); //点击事件
//                break;
//            case "CLICK":
//                $contentStr = $this->receiveClick($object); //点击事件
//                break;
//            case "VIEW":
//                $contentStr = $this->receiveClick($object); //点击事件
//                break;
//            default:
//                $contentStr = "receive a new event: " . $object->Event;
//                break;
//        }
//        //返回XML字符串
//        return $contentStr;
    }

    private function transmitText($object, $contentStr)
    {
        $textTpl = '<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>';

        $fromUserName = $object->FromUserName;
        $toUserName = $object->ToUserName;
        $time = $object->CreateTime;
        $resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $contentStr);
        return $resultStr;
    }

    private function msgRepeated($object)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        //TODO
        $redis->select(config('redis.dbindex', 2));//默认选择db2，下标从0开始，可读取配置
        //集合操作
        $RX_TYPE = trim($object->MsgType);
        switch ($RX_TYPE) {
            case 'event':
                //添加失败表示已存在，所以要返回true代表不存在
                if ($redis->sadd($RX_TYPE, strval($object->FromUserName . $object->CreateTime))) {
                    $FLAG = false;
                } else {
                    $FLAG = true;
                }
                break;

            default:
                //添加成功表示不存在，所以要返回false代表不存在
                if ($redis->sadd($RX_TYPE, strval($object->MsgId))) {
                    $FLAG = false;
                } else {
                    $FLAG = true;
                }
                break;
        }
        //60s 判断消息是否重复
        $redis->expire($RX_TYPE,60);
        //redis有最大数量限制，这里设为1024*1024=1M
        if ($redis->scard($RX_TYPE) > 1048576) {
            $redis->del($RX_TYPE);
        }
        $redis->close();
        return $FLAG;
    }
}
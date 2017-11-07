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
use Illuminate\Support\Facades\DB;

class WechatCallbackController extends Controller
{
    public function index(Request $request)
    {
        $resultStr = "";
        $xmlObj = $request->get('xmlObj', null);
        if (!is_null($xmlObj)) {
            //若classMap过期，则更新Redis
            $redis = new \Redis();
            if ($redis->connect(config('redis.ClassSelector.host', '127.0.0.1'), intval(config('redis.ClassSelector.port', 6379))) === true) {
                if ($redis->select(intval(config('redis.ClassSelector.dbindex', 1))) === true) {
                    if ($redis->exists('classMap') || $this->reloadClassMap()) ;
                }
            }
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
        //初始化通用控制器类
        $controller = new \App\Http\Controllers\Api\CommonUseController();
        //根据关键词从Redis
        $redis = new \Redis();
        if ($redis->connect(config('redis.ClassSelector.host', '127.0.0.1'), intval(config('redis.ClassSelector.port', 6379))) === true) {
            //默认选择db1，下标从0开始，可读取配置
            if ($redis->select(intval(config('redis.ClassSelector.dbindex', 1))) === true) {
                if ($redis->hExists('classMap', $object->Content)) {
                    $classInfo = (array)(unserialize($redis->hGet('classMap', $object->Content)));
                    if (!empty($classInfo['class']) && !empty($classInfo['method'])) {
                        $redis->close();
                        $controller = new $classInfo['class']();
                        //下面这一步不能执行，怎么解决
                        return $controller->$classInfo['method']($object);
                        return call_user_func(array($classInfo['class'], $classInfo['method']),$object);
                    }
                    $redis->close();
                }
                $redis->close();
            }
            $redis->close();
        }
        //返回XML字符串
        return $controller->index($object);//调用通用方法名
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
        $welcomeTemplate = config('language.WelcomeTemplate', "您好！欢迎关注我们的公众号%s，发送关键字%s可获取更多信息，祝您每天都有好运气！");
        $name = '「' . config($object->ToUserName . '.Name', '') . '」';
        $keyWords = "";
        $redis = new \Redis();
        if ($redis->connect(config('redis.ClassSelector.host', '127.0.0.1'), intval(config('redis.ClassSelector.port', 6379))) === true) {
            //默认选择db1，下标从0开始，可读取配置
            if ($redis->select(intval(config('redis.ClassSelector.dbindex', 1))) === true) {
                $keyWordsArr = $redis->hKeys('classMap');
                foreach ($keyWordsArr as $key => $value) {
                    $keyWordsArr[$key] = '“' . $value . '”';
                }
                $keyWords = implode('、', $keyWordsArr);
            }
            $redis->close();
        }

        switch ($object->Event) {
            case "subscribe":
                $title = sprintf($welcomeTemplate, $name, $keyWords); //关注后回复内容
                $contentStr = $this->transmitText($object, $title);
                break;
            default:
                $contentStr = "receive a new event: " . $object->Event;
                break;
        }
        //返回XML字符串
        return $contentStr;
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
        if ($redis->connect(config('redis.MsgStatistics.host', '127.0.0.1'), intval(config('redis.MsgStatistics.port', 6379))) === false) {
            return false;
        }
        //默认选择db2，下标从0开始，可读取配置
        if ($redis->select(intval(config('redis.MsgStatistics.dbindex', 2))) === false) {
            return false;
        }
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
        //设置过期时间为60s 判断60s内是否有消息重复
        $redis->expire($RX_TYPE, intval(config('redis.MsgStatistics.expire', 60)));
        //redis有最大数量限制，这里设为1024*1024=1M
        if ($redis->scard($RX_TYPE) > intval(config('redis.MsgStatistics.chunkSize', 1048576))) {
            $redis->del($RX_TYPE);
        }
        $redis->close();
        return $FLAG;
    }

    private function reloadClassMap()
    {
        $classInfoArr = array();
        $classMapArr = DB::connection('mysql')->table('class_map')->where('status',1)->get();
        foreach ($classMapArr as $item) {
            $classInfoArr[$item->keyword] = serialize($item);
        }

        $redis = new \Redis();
        if ($redis->connect(config('redis.ClassSelector.host', '127.0.0.1'), intval(config('redis.ClassSelector.port', 6379))) === true) {
            //默认选择db1，下标从0开始，可读取配置
            if ($redis->select(intval(config('redis.ClassSelector.dbindex', 1))) === true) {
                $redis->hMset('classMap', $classInfoArr);
                $redis->expire('classMap', intval(config('redis.ClassSelector.expire', 3600)));//3600s过期
            }
            $redis->close();
        }
    }
}
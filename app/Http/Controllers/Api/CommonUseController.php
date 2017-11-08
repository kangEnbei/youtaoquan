<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CommonUseController extends Controller
{
    //返回XML字符串
    public function index($xmlObj)
    {
        //判断消息是否重复，进来前一级控制器已经判断过消息是否重复，所以二级控制器就不用再判断了
        $rulesIntroducedTemplate = config('language.RulesIntroducedTemplate', "发送关键字%s可获取更多信息，您记住了么？祝您每天都有好运气！");
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

        $text = sprintf($rulesIntroducedTemplate, $keyWords);
        //返回XML字符串
        return $this->transmitText($xmlObj, $text);
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
}
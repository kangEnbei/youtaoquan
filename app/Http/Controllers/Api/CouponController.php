<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    //返回XML字符串
    public function index($xmlObj)
    {
        //根据ToUserName读表选8条数据组装成XML并返回图文消息
        $tableName = $xmlObj->ToUserName;
        $column = array('as', 'as', 'as', 'as');
        $couponArr = DB::connection('mysql')->table('class_map')->select($column)->orderBy('name', 'desc')->get();
        //销量优先原则
        return $this->transmitText($xmlObj, $couponArr);
    }

    private function transmitText($object, $arrayData)
    {
        $itemTpl = '<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>';
        $itemStr = '';
        foreach ($arrayData as $item) {
            $itemStr += sprintf($itemTpl, $item->,$item->,$item->,$item->);
        }

        $textTpl = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>%s</Articles>
</xml>';
        $fromUserName = $object->FromUserName;
        $toUserName = $object->ToUserName;
        $time = $object->CreateTime;
        $resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, count($arrayData), $itemStr);
        return $resultStr;
    }
}
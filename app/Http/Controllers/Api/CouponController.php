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
        //从Redis里随机返回6条
        $couponArr = array();
        $redis = new \Redis();
        if ($redis->connect(config('redis.CouponWarehouse.host', '127.0.0.1'), intval(config('redis.CouponWarehouse.port', 6379))) === true) {
            //默认选择db0，下标从0开始，可读取配置
            if ($redis->select(intval(config('redis.CouponWarehouse.dbindex', 0))) === true) {
                if ($redis->exists($xmlObj->ToUserName)) {
                    $CouponWarehouseArr = $redis->hGetAll($xmlObj->ToUserName);
                    $idArr = array_rand($CouponWarehouseArr,config($xmlObj->ToUserName . '.ArticleCount', 6));
                    foreach($idArr as $id){
                        $couponArr[] = unserialize($CouponWarehouseArr[$id]);
                    }
                }
            }
            $redis->close();
        }

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

        $itemXMLArr = array();
        foreach ($arrayData as $item) {
            $itemXMLArr[] = sprintf($itemTpl, $item['商品名称'], $item['优惠券面额'], $item['商品主图'], 'http://8xdmkh.natappfree.cc/view/list/'.$item['商品id'].'?gzh='.$object->ToUserName);
        }
        $itemXMLStr = implode('', $itemXMLArr);
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
        $resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, count($arrayData), $itemXMLStr);
        return $resultStr;
    }
}
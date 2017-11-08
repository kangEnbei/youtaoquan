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
        //以下三个数要求能配置
        //Redis复制量选最高的2个，取出商品ID，然后去优惠券仓库Redis里读取，没有就跳过
        //Redis点击量选最高的1个，取出商品ID，然后去优惠券仓库Redis里读取，没有就跳过
        //优惠券仓库Redis里随机选出5个
        $redis = new \Redis();
        if ($redis->connect(config('redis.CouponWarehouse.host', '127.0.0.1'), intval(config('redis.CouponWarehouse.port', 6379))) === true) {
            //默认选择db0，下标从0开始，可读取配置
            if ($redis->select(intval(config('redis.CouponWarehouse.dbindex', 0))) === true) {
                if ($redis->hExists('classMap', $object->Content)) {
                    $classInfo = (array)(unserialize($redis->hGet('classMap', $object->Content)));
                    if (!empty($classInfo['class']) && !empty($classInfo['method'])) {
                        $redis->close();
//                        $controller = new $classInfo['class']();
//                        //下面这一步不能执行，怎么解决
//                        return $controller->$classInfo['method']($object);
                        return call_user_func(array(new $classInfo['class'](), $classInfo['method']),$object);
//                        return call_user_func(array($classInfo['class'], $classInfo['method']),$object);
                    }
                }
            }
            $redis->close();
        }

        //根据ToUserName读表选8条数据组装成XML并返回图文消息
        $tableName = $xmlObj->ToUserName;
        $column = array('商品名称 as Title', '优惠券面额 as Description', '商品主图 as PicUrl', '淘宝客链接 as Url');
        $couponArr = DB::connection('mysql')->table($tableName)->select($column)->limit(8)->orderBy('商品月销量', 'desc')->get()->toArray();
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

        $itemXMLArr = array();
        foreach ($arrayData as $item) {
            $itemXMLArr[] = sprintf($itemTpl, $item->Title,$item->Description,$item->PicUrl,'http://8xdmkh.natappfree.cc/view');
        }
        $itemXMLStr = implode('',$itemXMLArr);
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
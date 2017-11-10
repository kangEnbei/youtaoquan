<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Statistics\StatisticsController;
use Illuminate\Http\Request;

class CouponPageController extends Controller
{
    public function couponList(Request $request, $id)
    {
        //记得给每个商品的链接上加上公众号ID
        $gzh = $request->input('gzh');
//        $statistics = new StatisticsController();
//        if(!$statistics->isItLegal()){
//            //中断，id和gzh不存在
//        }
        $list = null;
        //
        $idArr = array();
        $idArr[] = $id;//将点击进来的商品id先添加进去
        //选5个复制量高的
        $copyHighestNeededNumbers = 5;
        $copyHighestActualNumbers = 0;
        $copyHighestStillNeedNumbers = 5;
        if (1) {
            $redis = new \Redis();
            if ($redis->connect(config("redis.CopyStatistics.host", '127.0.0.1'), intval(config("redis.CopyStatistics.port", 6379))) === true) {
                //默认选择db4，下标从0开始，可读取配置
                if ($redis->select(intval(config("redis.CopyStatistics.dbindex", 4))) === true) {
                    //按降序取出
                    $copyDescWithscoreArr = $redis->zRevRange($gzh, 0, -1, true);
                    foreach ($copyDescWithscoreArr as $k => $v) {
                        $idArr[] = $k;
                        $copyHighestActualNumbers++;
                        if ($copyHighestActualNumbers == $copyHighestNeededNumbers) {
                            break;
                        }
                    }
                    $copyHighestStillNeedNumbers = $copyHighestNeededNumbers - $copyHighestActualNumbers;
                }
                $redis->close();
            }
        }
        //选4个点击量高的
        $clickHighestNeededNumbers = 4;
        $clickHighestActualNumbers = 0;
        $clickHighestStillNeedNumbers = 4;
        if (1) {
            $redis = new \Redis();
            if ($redis->connect(config("redis.ClickStatistics.host", '127.0.0.1'), intval(config("redis.ClickStatistics.port", 6379))) === true) {
                //默认选择db3，下标从0开始，可读取配置
                if ($redis->select(intval(config("redis.ClickStatistics.dbindex", 3))) === true) {
                    //按降序取出
                    $clickDescWithscoreArr = $redis->zRevRange($gzh, 0, -1, true);
                    foreach ($clickDescWithscoreArr as $k => $v) {
                        $idArr[] = $k;
                        $clickHighestActualNumbers++;
                        if ($clickHighestActualNumbers == $clickHighestNeededNumbers) {
                            break;
                        }
                    }
                    $clickHighestStillNeedNumbers = $clickHighestNeededNumbers - $clickHighestActualNumbers;
                }
                $redis->close();
            }
        }

        $redis = new \Redis();
        if ($redis->connect(config("redis.CouponWarehouse.host", '127.0.0.1'), intval(config("redis.CouponWarehouse.port", 6379))) === true) {
            //默认选择db0，下标从0开始，可读取配置
            if ($redis->select(intval(config("redis.CouponWarehouse.dbindex", 0))) === true) {
                if ($redis->hLen($gzh)) {
                    //去掉无效商品id
                    foreach ($idArr as $k => $v) {
                        if (!$redis->hExists($gzh, $v)) {
                            unset($idArr[$k]);
                        }
                    }
                    $idArr = array_values($idArr);

                    //分页
                    $pageSize = 30;
                    $pageNum = $request->input('page', 1);
                    $totalPage = ($redis->hLen($gzh) + count($idArr)) / $pageSize;
                    $temp = $redis->hKeys($gzh);
                    sort($temp,SORT_NUMERIC);
                    $idArr = array_merge($idArr, $temp);
                    $idArr = array_slice($idArr, ($pageNum - 1) * $pageSize, $pageSize);
                    //获取信息
                    $list = $redis->hMGet($gzh, $idArr);
                    foreach ($list as $k =>$v){
                        $list[$k] = unserialize($v);
                    }
                }
            }
            $redis->close();
        }
        var_dump($list);
        exit;
//        if (view()->exists('Coupon.list')) {
//            return view('Coupon.list', ['list' => $list]);
//        }
    }

    public function couponItem(Request $request, $id)
    {
        //记得给每个商品的链接上加上公众号ID
        $item = null;
        if (view()->exists('Coupon.item')) {
            return view('Coupon.item', ['item' => $item]);
        }
    }

    //不要删，有复制代码
    private function transmitHTML($id)
    {
        $template = '<html>
<style>
html,body{  
    height: 10000px;
    width: 10000px;
} 
</style>
<body data-clipboard-text="【好方生活馆】天猫双11预售主会场火热开启！上亿红包大放送，复制此信息{￥xmp906jFmye￥}或点击https://s.click.taobao.com/LgwqWYw打开淘宝，最高可抢1111元，百分百领到哦">
<ul>
<li onclick="ddd(this)">eeeee</li>
</ul>
</body>
<script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
window.onload=function(){
    var clipboard = new Clipboard("body");
}
function ddd(target) {
  target.select;
  document.execCommand("Copy");
}
</script>
</html>';
        $HTML = sprintf($template, $id);
        return $HTML;
    }
}

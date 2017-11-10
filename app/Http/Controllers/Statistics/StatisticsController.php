<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function clickStatistics(Request $request, $id)
    {
        if (($gzh = $request->input('gzh', '')) != '') {//取值赋值判空
            if ($this->isItLegal($gzh, $id)) {//判断公众号和商品ID是否存在
                return $this->increment($gzh, $id, 'click');//click+1
            }
        }
    }

    public function copyStatistics(Request $request, $id)
    {
        if (($gzh = $request->input('gzh', '')) != '') {//取值赋值判空
            if ($this->isItLegal($gzh, $id)) {//判断公众号和商品ID是否存在
                return $this->increment($gzh, $id, 'copy');//copy+1
            }
        }
    }

    public function isItLegal($gzh, $id)
    {
        //混沌
        $yin = false;
        $yang = false;
        //去公众号仓库里查找$gzh是否存在
        $redisGZH = new \Redis();
        if ($redisGZH->connect(config("redis.GZHWarehouse.host", '127.0.0.1'), intval(config("redis.GZHWarehouse.port", 6379))) === true) {
            //默认选择db5，下标从0开始，可读取配置
            if ($redisGZH->select(intval(config("redis.GZHWarehouse.dbindex", 5))) === true) {
                if ($redisGZH->hExists('GZHWarehouse', $gzh)) $yin = true;
            }
            $redisGZH->close();
        }
        //去优惠券仓库里查找$id是否存在
        $redisCoupon = new \Redis();
        if ($redisCoupon->connect(config("redis.CouponWarehouse.host", '127.0.0.1'), intval(config("redis.CouponWarehouse.port", 6379))) === true) {
            //默认选择db0，下标从0开始，可读取配置
            if ($redisCoupon->select(intval(config("redis.CouponWarehouse.dbindex", 0))) === true) {
                if ($redisCoupon->hExists($gzh, $id)) $yang = true;
            }
            $redisCoupon->close();
        }
        if ($yin && $yang) {
            return true;
        } else {
            return false;
        }
    }

    private function increment($gzh, $id, $cmd)
    {
        switch ($cmd) {
            case 'click':
                $redisConfigName = 'ClickStatistics';
                break;
            case 'copy':
                $redisConfigName = 'CopyStatistics';
                break;
            default:
                return false;
                break;
        }

        $redis = new \Redis();
        if ($redis->connect(config("redis.$redisConfigName.host", '127.0.0.1'), intval(config("redis.$redisConfigName.port", 6379))) === true) {
            //默认选择db3，下标从0开始，可读取配置
            if ($redis->select(intval(config("redis.$redisConfigName.dbindex", 3))) === true) {
                $redis->zIncrBy($gzh, 1, $id);
            }
            $redis->close();
        }
        return true;
    }
}
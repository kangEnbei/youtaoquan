<?php

namespace App\Http\Controllers\Instruction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponWarehouseController extends Controller
{
    //更新指定公众号的优惠券仓库
    public function updateCouponWarehouse(Request $request, $gzh)
    {
        //程序运行时间
        $starttime = explode(' ', microtime());
        echo microtime();

        //忽略浏览器关闭（客户端断开连接），设置超时时间永不
        ignore_user_abort(true);
        set_time_limit(0);
        //更新公众号仓库
        $gzhController = new GZHController();
        if ($gzhController->updateGZHWarehouse()) {
            //去公众号仓库里查找$gzh是否存在
            $redisGZH = new \Redis();
            if ($redisGZH->connect(config("redis.GZHWarehouse.host", '127.0.0.1'), intval(config("redis.GZHWarehouse.port", 6379))) === true) {
                //默认选择db5，下标从0开始，可读取配置
                if ($redisGZH->select(intval(config("redis.GZHWarehouse.dbindex", 5))) === true) {
                    if ($redisGZH->sIsMember('GZHWarehouse', $gzh)) $this->importToRedis($gzh);
                }
                $redisGZH->close();
            }
        }

        $endtime = explode(' ', microtime());
        $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
        $thistime = round($thistime, 3);
        echo "本网页执行耗时：" . $thistime . " 秒。" . time();
    }

    private function importToRedis($gzh)
    {
        $tableName = $gzh;
        $column = array('*');
        $couponArr = DB::connection('mysql')->table($tableName)->select($column)->get()->toArray();

        $redis = new \Redis();
        if ($redis->connect(config("redis.CouponWarehouse.host", '127.0.0.1'), intval(config("redis.CouponWarehouse.port", 6379))) === true) {
            //默认选择db0，下标从0开始，可读取配置
            if ($redis->select(intval(config("redis.CouponWarehouse.dbindex", 0))) === true) {
                if ($redis->exists($gzh)) $redis->del($gzh);
                foreach ($couponArr as $coupon) {
                    $coupon = (array)$coupon;
                    //一万条商品优惠券里商品ID有重复
                    $redis->hSet($gzh, $coupon['商品id'], serialize($coupon));
                }
            }
            $redis->expire($gzh, intval(config('redis.CouponWarehouse.expire', 86400)));
            echo "size:" . $redis->hLen($gzh) . PHP_EOL;
            $redis->close();
        }
    }

    public function generateTkl(Request $request,$gzh)
    {
        //程序运行时间
        $starttime = explode(' ', microtime());
        echo microtime();
        //忽略浏览器关闭（客户端断开连接），设置超时时间永不
        ignore_user_abort(true);
        set_time_limit(0);
        //更新公众号仓库
        $gzhController = new GZHController();
        if ($gzhController->updateGZHWarehouse()) {
            //去公众号仓库里查找$gzh是否存在
            $redisGZH = new \Redis();
            if ($redisGZH->connect(config("redis.GZHWarehouse.host", '127.0.0.1'), intval(config("redis.GZHWarehouse.port", 6379))) === true) {
                //默认选择db5，下标从0开始，可读取配置
                if ($redisGZH->select(intval(config("redis.GZHWarehouse.dbindex", 5))) === true) {
                    if ($redisGZH->sIsMember('GZHWarehouse', $gzh)) $this->updateCouponsTkl($gzh);
                }
                $redisGZH->close();
            }
        }
        $endtime = explode(' ', microtime());
        $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
        $thistime = round($thistime, 3);
        echo "本网页执行耗时：" . $thistime . " 秒。" . time();
    }

    private function updateCouponsTkl($tableName)
    {
        \TopSdk::init();//这玩意只能初始化一次，可别放在循环里面
        $columns = array('id', '商品id', '商品名称', '商品主图', '商品优惠券推广链接','淘口令');
        $couponArr = DB::connection('mysql')->table($tableName)->select($columns)->get()->toArray();
        foreach ($couponArr as $coupon) {
            $coupon = (array)$coupon;
//            if(empty($coupon['淘口令'])){
//                $tkl = $this->aliApiForTkl($coupon['商品名称'],$coupon['商品主图'],$coupon['商品优惠券推广链接']);
//                DB::connection('mysql')->table($tableName)->where('id', $coupon['id'])->update(['淘口令' => $tkl]);
//            }
            if(strpos($coupon['淘口令'],'￥') === false){
                DB::connection('mysql')->table($tableName)->where('id', $coupon['id'])->update(['淘口令' => '￥'.$coupon['淘口令'].'￥']);
            }
        }
    }

    private function aliApiForTkl($name, $pic, $url)
    {
        $appkey = "24531125";
        $secret = "182701ce3a46d62c5d2eabef55f0b01e";
        $c                   = new \TopClient;
        $c->appkey           = $appkey;
        $c->secretKey        = $secret;
        $req                 = new \WirelessShareTpwdCreateRequest;
        $tpwd_param          = new \GenPwdIsvParamDto;
        // $tpwd_param->ext     = "{\"xx\":\"xx\"}";
        $tpwd_param->logo    = $pic;
        $tpwd_param->url     = $url;
        $tpwd_param->text    = $name;
        // $tpwd_param->user_id = "24234234234";
        $req->setTpwdParam(json_encode($tpwd_param));
        $resp = $c->execute($req);
//        var_dump($resp);exit;
        //如果返回的淘口令没有加“”，那么加
        //如果返回的没有model，那么下面这句就不适用了，最好改一下啊
        return $resp->model;
    }
}

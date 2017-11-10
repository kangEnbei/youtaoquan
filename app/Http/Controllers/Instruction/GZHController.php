<?php

namespace App\Http\Controllers\Instruction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GZHController extends Controller
{
    public function updateGZHWarehouse()
    {
        //连接Redis
        $redis = new \Redis();
        if ($redis->connect(config('redis.GZHWarehouse.host', '127.0.0.1'), intval(config('redis.GZHWarehouse.port', 6379))) === false) {
            return false;
        }
        //默认选择db5，下标从0开始，可读取配置
        if ($redis->select(intval(config('redis.GZHWarehouse.dbindex', 5))) === false) {
            return false;
        }
        //删除旧的数据
        if ($redis->sCard('GZHWarehouse')) $redis->del('GZHWarehouse');
        //这里的方法是统计数据库里有几张公众号ID对应的商品优惠券表
        $tableNameArr = DB::connection('mysql')->select('select table_name from information_schema.TABLES where TABLE_SCHEMA=:table_schema', ['table_schema' => config('database.connections.mysql.database', 'youtaoquan')]);
        $pregRules = '/' . config('database.connections.mysql.prefix', 'ytq_') . '[a-z0-9_]{15}/';
        foreach ($tableNameArr as $k => $v) {
            //正则判断名称是否合法
            if (preg_match($pregRules, $tableNameArr[$k]->table_name)) {
                //如果合法，就去掉表名称的前缀，存入set
                $tableNameArr[$k] = substr($tableNameArr[$k]->table_name, strlen(config('database.connections.mysql.prefix', 'ytq_')));
                $redis->sadd('GZHWarehouse', $tableNameArr[$k]);
            }
        }
        //如果键名存在，则设置过期时间
        if ($redis->exists('GZHWarehouse')) {
            //设置过期时间为7d
            $redis->expire('GZHWarehouse', intval(config('redis.GZHWarehouse.expire', 604800)));
            $redis->close();
            return true;
        } else {
            $redis->close();
            return false;
        }
    }
}

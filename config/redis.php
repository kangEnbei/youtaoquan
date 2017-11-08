<?php
return [
    //优惠券仓库，100万
    //hash
    'CouponWarehouse' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 0,
        'expire' => 86400,//24h
        'chunkSize' => 1048576,//1024*1024=1M
    ],
    //控制器类选择器，俗称玩法
    //hash
    'ClassSelector' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 1,
        'expire' => 3600,//1h
        'chunkSize' => 2048,//1024*2=2k
    ],
    //接收到的微信消息60s内防重复，消息或事件id统计
    //set
    'MsgStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 2,
        'expire' => 60,//1m
        'chunkSize' => 1048576,//1024*1024=1M
    ],
    //统计点击量
    //sorted set
    'ClickStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 3,
        'expire' => 604800,//7d
        'chunkSize' => 1048576,//1024*1024=1M，与优惠券仓库保持一致
    ],
    //统计复制量
    //sorted set
    'CopyStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 4,
        'expire' => 604800,//7d
        'chunkSize' => 1048576,//1024*1024=1M，与优惠券仓库保持一致
    ],
];
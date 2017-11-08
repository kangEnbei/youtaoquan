<?php
return [
    //�Ż�ȯ�ֿ⣬100��
    //hash
    'CouponWarehouse' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 0,
        'expire' => 86400,//24h
        'chunkSize' => 1048576,//1024*1024=1M
    ],
    //��������ѡ�������׳��淨
    //hash
    'ClassSelector' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 1,
        'expire' => 3600,//1h
        'chunkSize' => 2048,//1024*2=2k
    ],
    //���յ���΢����Ϣ60s�ڷ��ظ�����Ϣ���¼�idͳ��
    //set
    'MsgStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 2,
        'expire' => 60,//1m
        'chunkSize' => 1048576,//1024*1024=1M
    ],
    //ͳ�Ƶ����
    //sorted set
    'ClickStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 3,
        'expire' => 604800,//7d
        'chunkSize' => 1048576,//1024*1024=1M�����Ż�ȯ�ֿⱣ��һ��
    ],
    //ͳ�Ƹ�����
    //sorted set
    'CopyStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 4,
        'expire' => 604800,//7d
        'chunkSize' => 1048576,//1024*1024=1M�����Ż�ȯ�ֿⱣ��һ��
    ],
];
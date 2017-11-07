<?php
return [
    //hash
    'ClassSelector' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 1,
        'expire' => 3600,
        'chunkSize' => 2048,//1024*1024=1M
    ],
    //set
    'MsgStatistics' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'dbindex' => 2,
        'expire' => 60,
        'chunkSize' => 1048576,//1024*1024=1M
    ],
];
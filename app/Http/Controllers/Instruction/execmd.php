<?php

if ($argc != 4) {
die("Usage: execmd.php <class> <method> <param>");
}

// remove first argument
array_shift($argv);

// get and use remaining arguments
$name = $argv[0];
$method = $argv[1];
$param = $argv[2];

//拼出类文件路径, 如果a为index crontab_path = index.controller.php
$crontab_path = $name . '.php';
//引入该文件
require $crontab_path;
//实例化类
$controller = new $name;
//调用该方法

$controller->$method($param);

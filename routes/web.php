<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$router->get('/', function () use ($router) {
//    echo "";
//    exit;
//});

//微信接口
$router->group(['namespace' => 'Api', 'middleware' => ['CheckSignatureMiddleware', 'DecryptMiddleware', 'EncryptMiddleware'], 'prefix' => 'api'], function () use ($router) {

    $router->get('/', [
        'as' => 'WechatCallback', 'uses' => 'WechatCallbackController@index'
    ]);
    $router->post('/', [
        'as' => 'WechatCallback', 'uses' => 'WechatCallbackController@index'
    ]);

});

//此条规则弃用
//$router->group(['namespace' => 'View', 'middleware' => [], 'prefix' => ''], function () use ($router) {
//    //匹配view、view/、view/id
//    //很奇怪这种模式下不能把view写到prefix里
//    $router->get('view[/{id}]', [
//        'as' => 'CouponPage', 'uses' => 'CouponPageController@index'
//    ]);
//
//});

//商品展示
$router->group(['namespace' => 'View', 'middleware' => [], 'prefix' => 'view'], function () use ($router) {

    $router->get('list/{id:[0-9]+}', [
        'as' => 'CouponList', 'uses' => 'CouponPageController@couponList'
    ]);

    $router->get('item/{id:[0-9]+}', [
        'as' => 'CouponItem', 'uses' => 'CouponPageController@couponItem'
    ]);

});

//统计点击量和复制量
$router->group(['namespace' => 'Statistics', 'middleware' => [], 'prefix' => 'statistics'], function () use ($router) {

    $router->get('click/{id:[0-9]+}', [
        'as' => 'ClickStatistics', 'uses' => 'StatisticsController@clickStatistics'
    ]);

    $router->get('copy/{id:[0-9]+}', [
        'as' => 'CopyStatistics', 'uses' => 'StatisticsController@copyStatistics'
    ]);

});

//内部指令
$router->group(['namespace' => 'Instruction', 'middleware' => [], 'prefix' => 'instruction'], function () use ($router) {

    //更新指定公众号对应的商品优惠券仓库
    $router->get('updateCouponWarehouse/{gzh:[a-z0-9_]{15}}', [
        'as' => 'UpdateCouponWarehouse', 'uses' => 'CouponWarehouseController@updateCouponWarehouse'
    ]);

    //生成淘口令并存入数据库（太TM耗时了，一秒大概生成10个淘口令，10000个要1000秒）
    $router->get('generateTkl/{gzh:[a-z0-9_]{15}}', [
        'as' => 'GenerateTkl', 'uses' => 'CouponWarehouseController@generateTkl'
    ]);

});
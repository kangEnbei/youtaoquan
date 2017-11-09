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
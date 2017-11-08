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

$router->group(['namespace' => 'View', 'middleware' => [], 'prefix' => 'view'], function () use ($router) {
    //匹配view、view/、view/id
    //很奇怪这种模式下不能把view写到prefix里
    $router->get('/{id:[0-9]+}', [
        'as' => 'CouponPage', 'uses' => 'CouponPageController@index'
    ]);

});
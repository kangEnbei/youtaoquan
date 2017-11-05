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

$router->get('/', function () use ($router) {
    echo "";
    exit;
});

$router->group(['namespace' => 'Api', 'middleware' => ['CheckSignatureMiddleware', 'DecryptMiddleware', 'EncryptMiddleware'], 'prefix' => 'api'], function () use ($router) {

    $router->get('/', [
        'as' => 'WechatCallback', 'uses' => 'WechatCallbackController@index'
    ]);
    $router->post('/', [
        'as' => 'WechatCallback', 'uses' => 'WechatCallbackController@index'
    ]);

});
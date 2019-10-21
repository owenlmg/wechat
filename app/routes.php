<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-09
 * Time: 13:21
 */





// 登录验证
$app->map(['GET', 'POST'], '/auth/login', 'Controllers\AuthController:login');

// 文件上传
$app->map(['OPTIONS', 'POST'], '/file/upload', 'Controllers\FileUploadController:upload');


// 类型
$app->map(['GET', 'POST'], '/type/list', 'Controllers\TypeController:list');

$app->map(['GET', 'POST'], '/type/update', 'Controllers\TypeController:update');

$app->map(['GET', 'POST'], '/type/delete', 'Controllers\TypeController:delete');

$app->map(['OPTIONS', 'POST'], '/type/upload', 'Controllers\TypeController:upload');

// 商家
$app->map(['GET', 'POST'], '/corp/list', 'Controllers\CorpController:list');

$app->map(['GET', 'POST'], '/corp/update', 'Controllers\CorpController:update');

$app->map(['GET', 'POST'], '/corp/delete', 'Controllers\CorpController:delete');

// 活动
$app->map(['GET', 'POST'], '/activity/list', 'Controllers\ActivityController:list');

$app->map(['GET', 'POST'], '/activity/update', 'Controllers\ActivityController:update');

$app->map(['GET', 'POST'], '/activity/delete', 'Controllers\ActivityController:delete');

// 用户
$app->map(['GET', 'POST'], '/user/list', 'Controllers\UserController:list');

$app->map(['GET', 'POST'], '/user/update', 'Controllers\UserController:update');

$app->map(['GET', 'POST'], '/user/delete', 'Controllers\UserController:delete');

// 浏览&收藏
$app->map(['GET', 'POST'], '/browse/list', 'Controllers\BrowseController:list');

$app->map(['GET', 'POST'], '/browse/update', 'Controllers\BrowseController:update');

$app->map(['GET', 'POST'], '/browse/favorite', 'Controllers\BrowseController:favorite');
$app->map(['GET', 'POST'], '/browse/browse', 'Controllers\BrowseController:browse');

$app->map(['GET', 'POST'], '/browse/delete', 'Controllers\BrowseController:delete');

// 轮播图
$app->map(['GET', 'POST'], '/slide/list', 'Controllers\SlideController:list');

$app->map(['GET', 'POST'], '/slide/update', 'Controllers\SlideController:update');

$app->map(['GET', 'POST'], '/slide/delete', 'Controllers\SlideController:delete');

// 消息
$app->map(['GET', 'POST'], '/message/list', 'Controllers\MessageController:list');

$app->map(['GET', 'POST'], '/message/update', 'Controllers\MessageController:update');
// 留言
$app->map(['GET', 'POST'], '/message/msg', 'Controllers\MessageController:msg');

$app->map(['GET', 'POST'], '/message/delete', 'Controllers\MessageController:delete');

// 微信
$app->map(['GET', 'POST'], '/home', 'Controllers\WechatController:home');
$app->map(['GET', 'POST'], '/wechat/getToken', 'Controllers\WechatController:getToken');


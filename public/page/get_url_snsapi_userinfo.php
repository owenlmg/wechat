<?php
/**
 * 生成授权地址的链接（用户点击后完成授权后，跳到回调页面获取用户信息）
 * `snsapi_userinfo` 授权方式获取用户信息（弹出授权页面，可通过openid拿到昵称、性别、所在地。
 * 即使在未关注的情况下，只要用户授权，也能获取其信息）
 *
 * @author        gaoming13 <gaoming13@yeah.net>
 * @link        https://github.com/gaoming13/wechat-php-sdk
 * @link        http://me.diary8.com/
 */

use Gaoming13\WechatPhpSdk\Api;

require '../../vendor/gaoming13/wechat-php-sdk/autoload.php';
require_once '../../app/Wechat/Token.php';
$settings = require '../../app/setting.php';
$wechat = $settings['settings']['wechat'];

$token = new \Wechat\Token();

// api模块 - 包含各种系统主动发起的功能
$api = new Api(
    array(
        'appId' => $token->getAppId(),
        'appSecret' => $token->getAppSecret(),
        'get_access_token' => function () use ($token) {
            // 用户需要自己实现access_token的返回
            return $token->getToken();
        },
        'save_access_token' => function ($value) use ($token) {
            // 用户需要自己实现access_token的保存
            $token->setToken($value);
        }
    )
);


header('Content-type: text/html; charset=utf-8');

$authorize_url = $api->get_authorize_url('snsapi_userinfo',
    $wechat['callback_userinfo_page']);

echo '<a href="' . $authorize_url . '">' . $authorize_url . '</a>';
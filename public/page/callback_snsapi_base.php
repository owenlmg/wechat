<?php
/**
 * demo/snsapi/callback_snsapi_base.php
 *
 * 授权链接跳转回调页面
 * `snsapi_base` 授权方式获取用户信息（不弹出授权页面，直接跳转，只能获取用户openid）
 *
 * @author        gaoming13 <gaoming13@yeah.net>
 * @link        https://github.com/gaoming13/wechat-php-sdk
 * @link        http://me.diary8.com/
 */
require '../../vendor/gaoming13/wechat-php-sdk/autoload.php';
require_once '../../app/Wechat/Token.php';
require_once '../../app/Wechat/User.php';

session_start();

use Gaoming13\WechatPhpSdk\Api;
use Wechat\Token;

// 这是使用了Memcached来保存access_token
// 由于access_token每日请求次数有限
// 用户需要自己定义获取和保存access_token的方法
$token = new Token();

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

list($err, $user_info) = $api->get_userinfo_by_authorize('snsapi_base');

if ($user_info !== null && !is_null($user_info->openid)) {
    $user = new \Wechat\User();
    $u = $user->getUser($user_info->openid);
    if(!$u) {
        $_SESSION['user'] = new \stdClass;
        $_SESSION['user']->openid = $user_info->openid;
    }
    $location = 'home.php';
    if (isset($_SESSION['last_page'])) {
        $location = $_SESSION['last_page'];
    }
    header("Location: $location");
    exit;

} else {
    echo '授权失败！';
}
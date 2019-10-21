<?php
/**
 * 生成授权地址的链接（用户点击后完成授权后，跳到回调页面获取用户信息）
 * `snsapi_base` 授权方式获取用户信息（不弹出授权页面，直接跳转，只能获取用户openid）
 *
 * @author        gaoming13 <gaoming13@yeah.net>
 * @link        https://github.com/gaoming13/wechat-php-sdk
 * @link        http://me.diary8.com/
 */
require '../../vendor/gaoming13/wechat-php-sdk/autoload.php';
require_once '../../app/Wechat/Token.php';

$settings = require '../../app/setting.php';
$wechat = $settings['settings']['wechat'];

header('Content-type: text/html; charset=utf-8');

$authorize_url = $api->get_authorize_url('snsapi_base',
    $wechat['callback_base_page']);

echo '<a href="' . $authorize_url . '">' . $authorize_url . '</a>';
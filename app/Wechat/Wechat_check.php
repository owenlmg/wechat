<?php
namespace Wechat;
require_once '../../app/Wechat/Token.php';
require_once '../../app/Wechat/User.php';

/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2019-10-12
 * Time: 12:37
 */
class Wechat_check {

    public function index($jump_page) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if($this->is_weixin()) {
            $settings = require '../../app/setting.php';
            $wechat = $settings['settings']['wechat'];

            $token = new Token();
            if (!isset($_SESSION['user']) || is_null($_SESSION['user']) || is_null($_SESSION['user']->openid)) {
                // 1. 根据基本授权先获取openid
                // 2. 检测openid对应的用户信息是否已存在
                // 3.1 如果存在，直接使用
                // 3.2 如果不存在，获取授权


                $redirect_uri = urlencode($wechat['callback_base_page']);
                $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $token->getAppId() .
                    '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_base&state=home#wechat_redirect';
                $_SESSION['last_page'] = $jump_page;

                header('Location: ' . $url);

                exit;
            } else if (is_null($_SESSION['user']->id)) {
                // 尝试根据openid能否获取到其它信息
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $token->getToken() . '&openid=' . $_SESSION['user']->openid . '&lang=zh_CN';
                $result = file_get_contents($url);
                $result = json_decode(trim($result, chr(239) . chr(187) . chr(191)), true);
                if (isset($result->subscribe)) {
                    $user = new User();
                    $user_info = $user->save($result);
                    if ($user_info) {
                        $_SESSION['user'] = $user_info;
                    }
                } else {
                    // 高级授权
                    $redirect_uri = urlencode($wechat['callback_userinfo_page']);
                    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $token->getAppId() .
                        '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=home#wechat_redirect';

                    $_SESSION['last_page'] = $jump_page;

                    header('Location: ' . $url);
                    exit;
                }

            }
        }
    }

    function is_weixin(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }
}
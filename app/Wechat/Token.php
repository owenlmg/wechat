<?php

/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2019-10-09
 * Time: 21:41
 */
namespace Wechat;
require_once '../../app/Wechat/DbCache.php';
require '../../vendor/autoload.php';

class Token
{
    // 开发者中心-配置项-AppID(应用ID)
    private $appid;
    // 开发者中心-配置项-AppSecret(应用密钥)
    private $appsecret;

    private $cache;
    private $url;

    public function __construct()
    {

        $settings = require '../../app/setting.php';
        $wechat = $settings['settings']['wechat'];
        $this->appid = $wechat['appid'];;
        $this->appsecret = $wechat['appsecret'];;

        $this->cache = new DbCache();
        $this->url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret.'';
    }

    public function getToken() {
        $token = $this->cache->get("access_token");
//        var_dump($token);
        if($token) {
            return $token;
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->url);
        $body = $response->getBody();
        $stringBody = (string) $body;
//        var_dump($stringBody);
        $json = json_decode($stringBody);
        if(isset($json->access_token)) {
            $this->cache->set("access_token", $json->access_token, 7200);
            return $json->access_token;
        }
        return "";
    }

    public function setToken($token) {
        $this->cache->set('access_token', $token, 7200);
    }

    public function getAppId() {
        return $this->appid;
    }
    public function getAppSecret() {
        return $this->appsecret;
    }
}
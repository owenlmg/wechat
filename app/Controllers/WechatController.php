<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


use Psr\Container\ContainerInterface;

class WechatController
{
    protected $app;
    protected $pdo;
    private $appId;
    private $appSecret;
    private $token;


    public function __construct(ContainerInterface $ci)
    {
        $this->app = $ci;
        $this->pdo = $ci->db;
        $this->appId = "";
        $this->appSecret = "";
        $this->token = "LUO";
    }

    public function valid(){    //用于基本配置的函数
        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        } else{
            return false;
        }
    }


    public function home() {
        //授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
        $codeBackUrl=urlencode('http://wx.rsses.xyz/wechat/getToken');

        if(isset($_SESSION['user'])){//session中有信息
            $wxOpenId=$_SESSION['user']['openId'];
            $wxName=$_SESSION['user']['name'];
            $wxSex=$_SESSION['user']['sex'];
            $wxIcon=$_SESSION['user']['icon'];
            //查询微信用户比对信息
            $result = $this->getUser($wxOpenId);
            if(isset($result)){//老用户
                $data['wx_userinfo']=$result;
            }else{//新用户
                //插入新增微信用户
                $data = array();
                $data['openid'] = $wxOpenId;
                $data['name'] = $wxName;
                $data['sex'] = $wxSex;
                $data['avatar'] = $wxIcon;
                $data['enable'] = 1;
                $addResult = $this->addUser($data);
                $result = $this->getUser($wxOpenId);
                $data['wx_userinfo']=$result;
            }

        }else{//session中没有信息
            $this->wxAuthUrl($this->appId,$codeBackUrl);
        }
    }

    //引导用户授权
    public function wxAuthUrl($wxAppId,$codeBackUrl){
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxAppId.'&redirect_uri='.$codeBackUrl.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header("Location:" . $url);
    }

    //获取用户授权code
    public function getToken(){
        $code=$_GET['code'];
        //通过code换取网页授权access_token
        $codeUrl='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appId.'&secret='.$this->appSecret.'&code='.$code.'&grant_type=authorization_code';
        //初始化curl
        $ch = curl_init();
        //需要获取的URL地址
        curl_setopt($ch,CURLOPT_URL, $codeUrl);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $TokenData = curl_exec($ch);
        curl_close($ch);
        $TokenArr=json_decode($TokenData);
        $tokenAccess=$TokenArr->access_token;
        $tokenOpenid=$TokenArr->openid;
        $lang='zh_CN';
        $this->getWxInfo($tokenAccess,$tokenOpenid,$lang);
    }

    //获取用户信息
    public function getWxInfo($tokenAccess,$tokenOpenid,$lang){
        $userUrl='https://api.weixin.qq.com/sns/userinfo?access_token='.$tokenAccess.'&openid='.$tokenOpenid.'&lang='.$lang.'';
        //初始化curl
        $ch = curl_init();
        //需要获取的URL地址
        curl_setopt($ch,CURLOPT_URL, $userUrl);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        if($data){
            $wx_info=json_decode($data);
            // var_dump($wx_info->openid);
            $user=array(
                'starWxOpenId'=>$wx_info->openid,
                'starWxName'=>$wx_info->nickname,
                'starWxSex'=>$wx_info->sex,
                'starWxIcon'=>$wx_info->headimgurl,
                // 'starWxlanguage'=>$wx_info->language,//语言
                // 'starWxcity'=>$wx_info->city,//城市
                // 'starWxprovince'=>$wx_info->province,//省份
                // 'starWxcountry'=>$wx_info->country,//国家
                // 'starWxprivilege'=>$wx_info->privilege,//用户特权信息
                // 'starWxunionid'=>$wx_info->unionid,//只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
            );
            $_SESSION['user'] = $user;
            //登陆成功
            $homeUrl='page/home.php';
            header("Location:" . $homeUrl);
        }
    }

    public function getUser($openId) {
        $sql = "select * from t_user where openid=:openId";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array('openId' => $openId));
        return $sth->fetchObject();
    }

    private function addUser(array $data)
    {
        $sql = "insert into t_user (name_, sex, openid, avatar, enable) values (:name, :sex, :openid, :avatar, :enable)";
        $sth = $this->pdo->prepare($sql);
        $success = $sth->execute($data);
        return $success;
    }

}
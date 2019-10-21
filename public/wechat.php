<?php
session_start();
define("TOKEN", "lmg");    //定义TOKEN, “lmg”是自己随便定义，这一句很重要！！！
$wechatObj = new Wechat();
if (!isset($_GET['echostr'])) {
    $wechatObj->valid();    //后续的有实质功能的function(此篇不用管）
}else{
    $wechatObj->valid();    //调用valid函数进行基本配置
}



class Wechat
{
    private $access_token;    //定义一个access_token，用于后续调用微信接口（此篇用不到）
    private $appId;
    private $appSecret;

    public function __construct(){    //构造函数

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
        $token = TOKEN;
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

    public function xxx() {
        //微信appid&secret
        $wxAppId=$this->config->item('WeChat')['APPID'];
        //授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
        $codeBackUrl=urlencode('http://starwalker.asesspace.com/home/getToken');

        if(isset($_SESSION['starWalkWxUserInfo'])){//session中有信息
            $swWxOpenId=$_SESSION['starWalkWxUserInfo']['starWxOpenId'];
            $swWxName=$_SESSION['starWalkWxUserInfo']['starWxName'];
            $swWxSex=$_SESSION['starWalkWxUserInfo']['starWxSex'];
            $swWxIcon=$_SESSION['starWalkWxUserInfo']['starWxIcon'];
            //查询微信用户比对信息
            $result = $this->User_model->getUserByOpen($swWxOpenId);
            if(isset($result)){//老用户
                $data['wx_userinfo']=$result;
            }else{//新用户
                //插入新增微信用户
                $data = array();
                $data['u_wechatopenid'] = $swWxOpenId;
                $data['u_wechatnick'] = $swWxName;
                $data['u_gender'] = $swWxSex;
                $data['u_wechaticon'] = $swWxIcon;
                $addResult = $this->User_model->addUser($data);
                $result = $this->User_model->getUserByOpen($swWxOpenId);
                $data['wx_userinfo']=$result;
            }

        }else{//session中没有信息
            $this->wxAuthUrl($wxAppId,$codeBackUrl);
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
}
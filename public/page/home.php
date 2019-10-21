<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('home.php');
?>
<?php

//session_start();
//require_once '../../app/Wechat/Token.php';
//$token = new \Wechat\Token();
//if(is_null($_SESSION['user']) || is_null($_SESSION['user']->openid)) {
//    // 1. 根据基本授权先获取openid
//    // 2. 检测openid对应的用户信息是否已存在
//    // 3.1 如果存在，直接使用
//    // 3.2 如果不存在，获取授权
//
//
//    $redirect_uri = urlencode('http://rsses.xyz/wechat/public/page/callback_snsapi_base.php');
//    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $token->getAppId() .
//        '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_base&state=home#wechat_redirect';
//    $_SESSION['last_page'] = 'home.php';
//
//    header('Location: '.$url);
//
//    exit;
//} else if(is_null($_SESSION['user']->id)) {
//    // 尝试根据openid能否获取到其它信息
//    $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token->getToken().'&openid='.$_SESSION['user']->openid.'&lang=zh_CN';
//    $result = file_get_contents($url);
//    $result = json_decode(trim($result,chr(239).chr(187).chr(191)),true);
//    if(isset($result->subscribe)) {
//        $user = new \Wechat\User();
//        $user_info = $user->save($result);
//        if($user_info) {
//            $_SESSION['user'] = $user_info;
//        }
//    } else {
//        // 高级授权
//        $redirect_uri = urlencode('http://rsses.xyz/wechat/public/page/callback_snsapi_userinfo.php');
//        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $token->getAppId() .
//            '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=home#wechat_redirect';
//
//        $_SESSION['last_page'] = 'home.php';
//
//        header('Location: '.$url);
//        exit;
//    }
//
//}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>首页</title>
    <!--常规-->

    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/common.js" type="text/javascript"></script>

    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>

</head>

<body>
<link rel="stylesheet" href="css/banner.css">
<script charset="utf-8" src="js/common.js"></script>
<script charset="utf-8" src="js/base.js"></script>
<script charset="utf-8" src="js/swp_goods_dc.js"></script>
<script charset="utf-8" src="js/TouchSlide.1.1.js"></script>
<!--TouchSlide-->
<script type="text/javascript">
    TouchSlide({slideCell: "#tab"});
</script>
<style>
    .header {
        position: absolute;
        background: none;
    }
</style>
<!--header-->
<!--header-->
<div class="header">
    <!-- <div class="head"><a href="http://jcxh.slb.lmfkj.com/user.html"><img src="../../../themes/front/images/head.png"></a></div>-->
    <div class="search">
        <form class="form-horizontal" id="search_form" action="search.php"
              method="git">
            <div class="searchbox">
                <input type="text" name="search" class="searchbox-text" value="" placeholder="">
                <a href="javascript:void()" onclick="document.getElementById('search_form').submit();"
                   class="searchbox-btn"></a>
            </div>
        </form>
    </div>
</div>
<!--header end--><!--header end-->
<?php

require '../../vendor/autoload.php';
$settings = require '../../app/setting.php';
$db = $settings['settings']['db'];
$link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
mysqli_query($link,'set names utf8');
if (mysqli_connect_errno()) {
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}
?>
<!--body-->
<div class="body">
    <!--banner-->
    <div class="index-banner">
        <div class="js-swp swp">
            <div class="swiper-wrapper js-swp-wrap" style="height:60px;"><!--調整高度-->
            </div>
            <div class="swiper-pagination js-swiper-pagination">
                <ul class="swp-thumbnail-list">
                    <li class="swiper-pagination-switch"></li>
                    <li class="swiper-pagination-switch swiper-active-switch"></li>
                </ul>
            </div>
        </div>
    </div>
    <!--导航按钮-->
    <div class="a-nav" id="tab">
        <div class="a-nav-scroll">
            <ul>
                <?php
                    $sql = "select id, name_, icon from t_type";
                    $result = mysqli_query($link, $sql);

                    while($type = $result->fetch_object()){
                        echo '<li>';
                        echo "<a href='shops.php?type=$type->id'><img src='$type->icon'>";
                        echo "<p>$type->name_</p></a>";
                        echo '</li>';
                    }
                    ?>
            </ul>
        </div>
    </div>
    <!--精彩活动-->
    <div class="a-title"><img src="images/a-title-1.png">精彩活动</div>
    <div class="a-activity">
        <ul>

            <?php
            $sql = "select id, name_, desc_, url, icon from t_activity";
            $result = mysqli_query($link, $sql);

            while($activity = $result->fetch_object()){
                echo "<li>";
                echo "    <a href='$activity->url'>";
                echo "        <img src='$activity->icon' alt='$activity->desc_'>";
                echo "        <div class='a-activity-title'>";
                echo "            <span>$activity->name_</span><!--标题全输出-->";
                echo "             <i>></i>";
                echo "        </div>";
                echo "    </a>";
                echo "</li>";
            }
            ?>

        </ul>
    </div>
    <!--会员单位-->
    <div class="a-title"><img src="images/a-title-1.png" alt="">会员单位</div>
    <div class="a-unit">
        <ul>
            <?php
            $sql = "select t.id, t.name_, t.sd, t.logo, t.phone, t.mobile, t.address,t1.name_ as typeName from t_corp t inner join t_type t1 on  t.type_=t1.id";
            $result = mysqli_query($link, $sql);

            while($corp = $result->fetch_object()){
                $tel = $corp->mobile ? $corp->mobile : ($corp->phone ? $corp->phone : "");

                print <<<EOT
<li>
                <div class="a-unit-left">
                    <a href="shop.php?id=$corp->id">
                        <img src="$corp->logo" alt="$corp->name_">
                        <div class="a-unit-text">
                            <h1>$corp->name_</h1>
                            <p>$corp->sd</p>
                            <span>$corp->typeName</span>
                        </div>
                    </a>
                </div>
                <div class="a-unit-right">
                    <a href="tel:$tel"><img src="images/a-unit-p.png" alt=""></a>
                    <a href="javascript:void(0)" onclick="openMap('$corp->address', '$corp->name_', '$corp->mobile', '$corp->phone')"><img
                                src="images/a-unit-m.png" alt=""></a>
                </div>
            </li>
EOT;

            }
            ?>
        </ul>
    </div>
    <!--body end-->
    <!--广告-->
    <!--技术支持-->
    <div class="support"></div>
</div>
<!--body end-->
<!--nav-->
<div class="navigation">
    <ul>
        <li><a class="_home active" href="home.php">
                <div></div>
                <span>首页</span></a></li>
        <li><a class="_unit" href="shops.php">
                <div></div>
                <span>会员单位</span></a></li>
        <li><a class="_activity " href="activity.php">
                <div></div>
                <span>精彩活动</span></a></li>
        <li><a class="_center " href="user.php">
                <div></div>
                <span>会员中心</span></a></li>
    </ul>
</div>
<!--nav end-->

<?php
mysqli_close($link);
?>
</body>
</html>

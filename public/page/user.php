<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>会员中心</title>
    <!--常规-->

    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>
</head>

<body><div class="body">
    <!--头像-->
    <div class="a-center-portrait">
        <img src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']->avatar : ''; ?>" alt="">
        <h1><?php echo isset($_SESSION['user']) ? $_SESSION['user']->name_ : ''; ?></h1>
    </div>
    <!--中心导航-->
    <div class="a-center-nav">
        <ul>
            <li><a href="favorite.php?type=favorite"><img src="images/a-center-nav-1.png" alt=""><p>收藏单位<i class="icon-chevron-right float_right"></i></p></a></li>
            <li><a href="favorite.php?type=browse"><img src="images/a-center-nav-2.png" alt=""><p>浏览记录<i class="icon-chevron-right float_right"></i></p></a></li>
            <li><a href="message.php"><img src="images/a-center-nav-3.png" alt=""><p>留言客服<i class="icon-chevron-right float_right"></i></p></a></li>
        </ul>
    </div>
    <!--广告-->
    <!--技术支持-->
    <div class="support"></div>
</div>
<!--body end-->
<!--nav-->
<div class="navigation">
    <ul>
        <li><a class="_home " href="home.php">
                <div></div>
                <span>首页</span></a></li>
        <li><a class="_unit " href="shops.php">
                <div></div>
                <span>会员单位</span></a></li>
        <li><a class="_activity " href="activity.php">
                <div></div>
                <span>精彩活动</span></a></li>
        <li><a class="_center active" href="user.php">
                <div></div>
                <span>会员中心</span></a></li>
    </ul>
</div>
<!--nav end-->

</body></html>
<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('favorite.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php if($_GET['type'] == 'favorite') echo '我的收藏'; else echo '浏览记录' ?></title>
    <!--常规-->
    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>

    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>
</head>
<?php

require '../../vendor/autoload.php';
$settings = require '../../app/setting.php';
$db = $settings['settings']['db'];
$link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
mysqli_query($link,'set names utf8');
if (mysqli_connect_errno()) {
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}
?>
<body>
<link href="css/public.1.0.0.css" rel="stylesheet" type="text/css">
<link href="css/Child-pages.css" rel="stylesheet" type="text/css">
<div class="collect">
    <ul>

        <?php
        $userId = -1;
        if(isset($_SESSION['user']) && isset($_SESSION['user']->id)) {
            $userId = $_SESSION['user']->id;
        }
        $sql = "select t.id, t.name_, t.sd, t.logo, t.phone, t.mobile, t.address as typeName,t1.time_ from t_corp t inner join t_browse t1 on  t.id=t1.corp where t1.user_=".$userId;
        if($_GET['type'] == 'favorite') {
            $sql .= ' and t1.favorite=1';
        } else {
            $sql .= ' and t1.browse=1';
        }
        $sql .= ' order by t1.time_ desc';
        $result = mysqli_query($link, $sql);
        $total = 0;

        while($corp = $result->fetch_object()){
            $total++;
            print <<<EOT
<li>
            <a href="shop.php?id=$corp->id" style="display:block;">
                <img src="$corp->logo">
                <div class=" float_left float_left2">
                    <div class="float_left collect-name">$corp->name_</div>
                    <div class="float_left collect-number">$corp->sd</div>
                </div>
                <div></div>
                <div class="clear"></div>
            </a>
EOT;
            if($_GET['type'] == 'favorite') {
                echo "<a href='javascript:void(0)' shops-id='$corp->id' class='collect-cancel'>取消收藏</a>";
            } else {
                echo "<span class='collect-time'>$corp->time_</span>";
            }
            echo '</li>';
        }
        if($total === 0) {
            echo '<li>没有数据</li>';
        }
            ?>
     </ul>
</div>
<script>
    $(document).ready(function() {
        $('.collect-cancel').click(function(event) {
            let collect = $(this);
            let shops_id = collect.attr('shops-id');
            $.get('/browse/favorite?id=' + shops_id + '&action=del', function(data) {
                if(data && data.code == 1){
                    collect.parent().remove();
                }
            });
        });
    });
</script>
<!--广告-->
<!--技术支持-->
<div class="support"></div>

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
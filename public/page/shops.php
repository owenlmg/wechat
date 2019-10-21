<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('shops.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>会员单位</title>
    <!--常规-->
    <script>
        console.log('用户已关注!');
    </script>
    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/common.js" type="text/javascript"></script>

    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>
</head>

<body>
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

if(isset($_GET['type'])) {
    $id = $_GET['type'];
}

$sql = "select id, name_, icon from t_type";
$result = mysqli_query($link, $sql);
$types = [];
$typeName = '';
while($type = $result->fetch_object()){
    $types[] = $type;
    if(isset($id) && $id == $type->id) {
        $typeName = $type->name_;
    }
}
?>
<div class="body">

    <script>
        $(window).on('load', function () {
            $(window).on('scroll', function () {
                if ($(window).scrollTop() > 90) {
                    $('.a-class').addClass('fixed');
                    $('.a-unit').attr('style', 'margin-top:98px;')
                } else {
                    $('.a-class').removeClass('fixed');
                    $('.a-unit').removeAttr('style')
                }
            })

            //显示隐藏菜单
            $('.a-class-title-btn').on('click', function () {
                $('.a-class-list-nav, .a-class-list-bg').fadeToggle(60);
            })

            //分类一选择
            $('.CLassA li').on('click', function () {
                $('.CLassA li').removeClass('active');
                $(this).addClass('active');
                $('.CLassB li').hide();
                $('.CLassB li').eq($(this).index()).show();
            })
        })

    </script>

    <!--分类-->

    <div class="a-class">
        <!--分类下拉按钮-->
        <div class="a-class-title">
            <div class="a-class-title-btn">会员单位<i class="icon-chevron-right turnDown"></i></div>
            <h1><?php echo $typeName ? $typeName : '全部'; ?></h1>
        </div>

        <!--分类列表-->

        <div class="a-class-list">
            <div class="a-class-list-nav">
                <!--一级分类-->
                <div class="CLassA">
                    <ul>
                        <li>
                            <a href="shops.php">全部</a>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <?php

                        foreach($types as $type){
                            echo '<li>';
                            echo "    <a href='shops.php?type=$type->id'>$type->name_</a>";
                            echo "    <i class='icon-chevron-right'></i>";
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>

                <!--二级分类-->
                <div class="CLassB">
                    <ul>
                        <li>
                        </li>
                    </ul>
                </div>
            </div>

            <!--分类背景-->
            <div class="a-class-list-bg"></div>
        </div>

    </div>

    <!--会员单位-->
    <div class="a-unit">
        <ul>
            <?php

            $sql = "select t.id, t.name_, t.sd, t.logo, t.phone, t.mobile, t.address, t.type_, t1.name_ as typeName from t_corp t inner join t_type t1 on  t.type_=t1.id";
            if(isset($id) && is_numeric($id)) {
                $sql .= " where t.type_ = ".$id;
            }
            $result = mysqli_query($link, $sql);

            while($corp = $result->fetch_object()){
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
                    <a href="tel:$corp->mobile ? $corp->mobile : ($corp->phone ? $corp->phone : '')"><img src="images/a-unit-p.png"
                                                                                                          alt=""></a>
                    <a href="javascript:void(0)" onclick="openMap('$corp->address', '$corp->name_', '$corp->mobile', '$corp->phone')"><img
                                src="images/a-unit-m.png" alt=""></a>
                </div>
            </li>
EOT;

            }
            ?>
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
        <li><a class="_unit active" href="shops.php">
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

</body>
</html>
<?php
mysqli_close($link);
?>
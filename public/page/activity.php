<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('activity.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>精彩活动</title>
    <!--常规-->
    <script>
        console.log('用户已关注!');
    </script>
    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>
    <style type="text/css">

        /*.pics{ position:relative; width:320px;  height:360px; overflow:hidden; margin:10px auto; }*/
        /*.pics .hd{ position:absolute; height:28px; line-height:28px; bottom:0; right:0; z-index:1; }*/
        /*.pics .hd li{ display:inline-block; width:5px; height:5px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#333; text-indent:-9999px; overflow:hidden; margin:0 6px;   }*/
        /*.pics .hd li.on{ background:#fff;  }*/
        /*.pics .bd{ position:relative; z-index:0; }*/
        /*.pics .bd li{ position:relative;  }*/
        /*.pics .bd li img{*/
            /*height:320px;*/
            /*width: auto;*/
            /*max-width: 100%;*/
            /*max-height: 100%;*/
            /*display:block;*/
        /*}*/
        /*.pics .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); !* 取消链接高亮 *! }*/
        /*.pics .bd li .tit{ display:block; width:100%;  position:absolute; bottom:0; text-indent:10px; height:28px; line-height:28px; background:url(images/focusBg.png) repeat-x; color:#fff;   }*/

        .pics{ position:relative; width:640px;  height:280px; overflow:hidden; margin:10px auto; }
        .pics .hd{ position:absolute; width:100%;  height:34px; bottom:0; left:0; z-index:1; }
        .pics .hd img{ width:auto; padding-top: 3px; }
        .pics .prev,.pics .next{ position:absolute; left:0; top:0; display:block; width:23px; height:34px; line-height:34px; text-align:center;   }
        .pics .next{ left:auto; right:0;}
        .pics .bd{ position:relative; z-index:0; }
        .pics .bd li{ position:relative; }
        .pics .bd li img{ width:640px;  height:280px; display:block;   }
        .pics .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */  }
        .pics .bd li .tit{ display:block; width:100%;  position:absolute; bottom:0; text-indent:10px; height:34px; line-height:34px;  text-align:center;  color:#fff; background-color:rgba(0,0,0,0.5); ;

    </style>

</head>

<body>

<link rel="stylesheet" href="css/banner.css">
<script charset="utf-8" src="js/common.js"></script>
<script charset="utf-8" src="js/base.js"></script>
<script charset="utf-8" src="js/swp_goods_dc.js"></script>
<script charset="utf-8" src="js/TouchSlide.1.1.js"></script>



<!--header-->

<!--header-->
<!--<div class="header">
    <div class="search">
        <form class="form-horizontal" id="search_form" action="http://jcxh.slb.lmfkj.com/shops/search.html" method="git">
            <div class="searchbox">
                <input type="text" name="search" class="searchbox-text" value="" placeholder="">
                <a href="javascript:void()" onclick="document.getElementById('search_form').submit();" class="searchbox-btn"></a>
            </div>
        </form>
    </div>
</div>-->
<!--header end-->
<!--header end-->

<!--body-->

<!--body-->

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

<div class="body">
    <!--单页面特有样式-->
    <style>
        body{ background-color:#fff;}
        .header {position: absolute;background:none;}
    </style>
    <!--banner-->
    <div class="index-banner" style="display:none">
        <div class="js-swp swp">
            <div class="swiper-wrapper js-swp-wrap" style="height:360px;"><!--調整高度-->
                <div class="swp-page">
                    <a href="http://mp.weixin.qq.com/s/laFTajeRsfQJxD9frRhcEA">
                        <!--选中-->
                        <img class="js-res-load" src="http://jcxh.slb.lmfkj.com/uploads/img/4a583053f046216af77eda532580293c.png" alt="">
                        <div class="a-activity-title">
                            <span>御丽墙布·窗帘盛大开业</span><!--标题全输出-->
                        </div>
                    </a>
                </div>
            </div>

            <div class="swiper-pagination js-swiper-pagination">
                <ul class="swp-thumbnail-list">
                    <li class="swiper-pagination-switch"></li>
                    <li class="swiper-pagination-switch swiper-active-switch"></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="pics" class="pics">
        <div class="bd">
            <ul>
                <!--                        <li><a href="#"><img src="images/tb1.jpg" /></a></li>-->
                <?php
                $sql = "select id, name_, desc_, url, icon from t_activity where is_slide = 1";
                $result = mysqli_query($link, $sql);
                while($activity = $result->fetch_object()){
                    echo "<li>";
                    echo "<a class='pic' href='$activity->url'><img src='$activity->icon' width='640' height='280' /></a>";
                    echo "<a class='tit' href='$activity->url'>$activity->name_</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
        <div class="hd">
            <span class="prev"><img src="images/sohu-prev.png"/></span>
            <span class="next"><img src="images/sohu-next.png"/></span>
        </div>
    </div>
    <script type="text/javascript">
        TouchSlide({
            slideCell:"#pics",
            mainCell:".bd ul",
            effect:"left",
            autoPlay: true
        });
    </script>

    <!--文章列表-->
    <div class="a-article">
        <ul>
            <?php
            $sql = "select id, name_, desc_, url, icon from t_activity";
            $result = mysqli_query($link, $sql);

            while($activity = $result->fetch_object()){
                echo "<li>";
                echo "    <a href='$activity->url'>";
                echo "        <img src='$activity->icon' alt='$activity->name_'>";
                echo "        <div class='a-article-text'>";
                echo "            <h1>$activity->name_</h1>";
                echo "            <p>$activity->desc_</p>";
                echo "        </div>";
                echo "    </a>";
                echo "</li>";
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
        <li><a class="_home" href="home.php">
                <div></div>
                <span>首页</span></a></li>
        <li><a class="_unit" href="shops.php">
                <div></div>
                <span>会员单位</span></a></li>
        <li><a class="_activity active" href="activity.php">
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
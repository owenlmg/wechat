<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('shop.php?id=$_GET["id"]');
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>商家详情</title>
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
    <style type="text/css">
        .pics{ width:640px; hegiht:auto;  margin:0 auto; position:relative; overflow:hidden;   }
        .pics .hd{ width:100%; height:5px;  position:absolute; z-index:1; bottom:0; text-align:center;  }
        .pics .hd ul{ overflow:hidden; display:-moz-box; display:-webkit-box; display:box; height:5px; background-color:rgba(51,51,51,0.5);   }
        .pics .hd ul li{ -moz-box-flex:1; -webkit-box-flex:1; box-flex:1; }
        .pics .hd ul .on{ background:#FF4000;  }
        .pics .bd{ position:relative; z-index:0; }
        .pics .bd li img{ width:100%;  height:640px; }
        .pics .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */ }
    </style>

</head>

<body>
<link href="css/public.1.0.0.css" rel="stylesheet" type="text/css">
<link href="css/Child-pages.css" rel="stylesheet" type="text/css">
<script charset="utf-8" src="js/TouchSlide.1.1.js"></script>

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
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $userId = -1;
    if(isset($_SESSION['user']) && isset($_SESSION['user']->id)) {
        $userId = $_SESSION['user']->id;
    }
    $sql = "select t.id, t.name_, t.desc_, t.logo, t.pics, t.phone, t.mobile ,t.address, t.remark,t1.favorite from t_corp t left join t_browse t1 on t.id=t1.corp and t1.favorite=1 and t1.user_ = ".$userId." where t.id = $id";

    $result = mysqli_query($link, $sql);
    $corp = $result->fetch_object();
    if(!$corp) {
        echo "数据不存在";
        exit;
    }
} else {
    echo "数据不存在";
    exit;
}

// 添加到浏览，并且查询是否在收藏里面
$isFavorite = 0;
if($userId != -1) {
    $sql = "insert into t_browse (user_, corp, time_, browse) values (?, ?, sysdate(), 1)";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "si", $userId, $id);
    mysqli_stmt_execute($stmt);

    $isFavorite = $corp->favorite;
}

?>

<div class="body">
    <div class="seller-info">
        <div class="seller-info-box">
            <img src="<?php echo $corp->logo; ?>" class="seller-logo">
            <div class="seller-info-name"><?php echo $corp->name_; ?></div>
        </div>
        <div class="seller-info-box2">
            <div class="seller-info-title">商家介绍</div>
            <div class="seller-info-text">
                <?php echo $corp->desc_; ?>
            </div>
        </div>
        <div class="seller-info-box2" style="position:relative;">
            <div class="seller-info-title">商家图片</div>
            <?php if($corp->pics) { ?>
                <div id="pics" class="pics">
                    <div class="hd">
                        <ul></ul>
                    </div>
                    <div class="bd">
                        <ul>
                            <!--                        <li><a href="#"><img src="images/tb1.jpg" /></a></li>-->
                            <?php
                            $pics = explode(',', $corp->pics);
                            foreach ($pics as $pic) {
                                echo "<li><a href='$pic'><img src='$pic' /></a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <!--<a href="http://jcxh.slb.lmfkj.com/shops/images/55.html" data-size="1600x1600" data-med="http://jcxh.slb.lmfkj.com/uploads_thumb/img/139e75b7cb15937e2de0d43222f34817_1024X1024.jpg" data-med-size="1024x1024" data-author="">
                <img src="http://jcxh.slb.lmfkj.com/uploads_thumb/img/139e75b7cb15937e2de0d43222f34817_640X640.jpg" alt="" width="100%">
            </a>
            <span style=" position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,.3); color: #fff; padding: 4px 6px;">共4张</span>-->
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#pics",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"leftLoop",
                autoPlay:true,//自动播放
                autoPage:true //自动分页
            });
        </script>
        <div class="seller-info-box2">
            <div class="seller-info-title">商家信息</div>
            <ul class="information">
                <?php if(isset($corp->mobile)) { ?>
                    <li>
                        <a href="tel:$corp->mobile"><i class="fa fa-mobile-phone" style="font-size:20px"></i>手机 : <?php if(!empty($corp->mobile)) {echo $corp->mobile;echo '&nbsp;&nbsp;(点击拨号)';}?> </a>
                    </li>
                <?php } ?>
                <?php if(isset($corp->phone)) { ?>
                    <li>
                        <a href="tel:$corp->phone"><i class="fa fa-mobile-phone" style="font-size:20px"></i>座机 : <?php if(!empty($corp->phone)) {echo $corp->phone;echo '&nbsp;&nbsp;(点击拨号)';}?></a>
                    </li>
                <?php } ?>


                <li>
                    <a href="javascript:void(0)" onclick="openMap('<?php echo $corp->address; ?>', '<?php echo $corp->name_; ?>', '<?php echo $corp->mobile; ?>', '<?php echo $corp->phone; ?>')">
                        <i class="fa fa-map-marker"></i>地址 : <?php echo $corp->address; ?><i class="fa fa-angle-right"></i>
                    </a>
                    <!--                    <a href="http://mo.amap.com/share/index/lnglat=113.5702620,22.2446190&amp;name=深圳市朗尼科技术有限公司珠海分公司" class="map"><i class="fa fa-map-marker"></i>地址 : 锦江之星酒店(珠海吉大九洲...<i class="fa fa-angle-right"></i></a>-->
                </li>
                <li style="position:relative" class="seller-collect-box">
                    <i class="fa fa-heart"></i>商家收藏
                    <div class="seller-collect" style="right: 20px;top: 26px;" shops-id="<?php echo $corp->id; ?>" action="<?php echo $isFavorite ? 'del' : 'add'; ?>">
                        <?php
                        if($isFavorite) {
                            echo '<i style="background-image:url(images/h1.png);"></i>';
                        } else {
                            echo '<i style="background-image:url(images/h.png);"></i>';
                        }
                        ?>

                    </div>
                </li>
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.seller-collect-box').click(function(event) {
                let collect = $(this).find('.seller-collect');
                let shops_id = collect.attr('shops-id');
                let action = collect.attr('action');
                $.get('/browse/favorite?id=' + shops_id + '&action=' + action, function(data) {
                    if(data && data.code == 1){
                        if(action == 'add'){
                            collect.attr('action','del');
                            alert('商家收藏添加成功');
                            collect.find('i').css('background-image', "url(images/h1.png)");
                        }else{
                            collect.attr('action','add');
                            alert('商家收藏删除成功');
                            collect.find('i').css('background-image', "url(images/h.png)");
                        }
                    }
                });
            });
        });
    </script>
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

</body></html>
<?php
mysqli_close($link);
?>
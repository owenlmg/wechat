<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('search.php?search='.$_GET['search']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员单位</title>
<!--常规-->

<link href="css/public.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js"type="text/javascript"></script>
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
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}
?>

<body><div class="body">
  <!--header-->
<div class="header">
 <!-- <div class="head"><a href="http://jcxh.slb.lmfkj.com/user.html"><img src="../../../themes/front/images/head.png"></a></div>-->
  <div class="search">
    <form class="form-horizontal" id="search_form" action="search.php" method="get"/>
      <div class="searchbox">
        <input type="text" name="search" class="searchbox-text" value="<?php echo $_GET['search'];?>" placeholder="" />
        <a href="javascript:void()" onclick="document.getElementById('search_form').submit();" class="searchbox-btn"></a>
      </div>
    </form>
  </div>
</div>
<!--header end-->  <!--会员单位-->
  <div class="a-unit">
        <ul>
            <?php
            $sql = "select t.id, t.name_, t.sd, t.logo, t.phone, t.mobile, t.address,t1.name_ as typeName from t_corp t inner join t_type t1 on  t.type_=t1.id";
            if(isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql .= " where t.name_ like '%$search%' or t.sd like '%$search%' or t1.name_ like '%$search%'";
            }
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
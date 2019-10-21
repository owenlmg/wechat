<?php
require_once '../../app/Wechat/Wechat_check.php';
$we = new \Wechat\Wechat_check();
$we->index('message.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>留言</title>
    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>

    <!--配置页面宽度-->
    <script src="js/viewport.js" type="text/javascript"></script>

</head>

<body>
<style>
    #content{padding: 14px; font-size: 24px; line-height: 40px; letter-spacing: 1px; display: block; margin: 60px auto 40px; resize: none; width: 540px; height: 400px; border-radius: 12px; border: 1px solid #aaa; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    #link{padding: 14px; font-size: 24px; line-height: 40px; letter-spacing: 1px; display: block; margin: 10px auto 40px; resize: none; width: 540px; height: 40px; border-radius: 12px; border: 1px solid #aaa; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    #submit{ width: 540px; display: block; margin: auto; line-height: 66px; font-size: 26px; border-radius: 12px; background: #27b327; color: #fff; appearance:none;-moz-appearance:none; /* Firefox */-webkit-appearance:none; /* Safari 和 Chrome */}
</style>

<form class="form-horizontal" id="form1" action="/message/update" method="get"/>

<textarea name="content" id="content" placeholder="留言内容" cols="30" rows="10"></textarea>
<input id="link" type="text" placeholder="联系方式">
<input id="submit" type="button" value="留言">

</form>

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
<script>
    $(document).ready(function() {
        $('#submit').click(function(){
            let content = $("#content").val();
            if(content != '') {
                $.post('/message/msg', {"content": content, link : $("#link").val()}, function(data) {
                    if(data && data.code == 1){
                        alert("感谢您的留言！");
                        window.location.href = "user.php";
                    } else {
                        alert("留言提交失败！");
                    }
                });
            }
        });
    });
</script>
</body>
</html>
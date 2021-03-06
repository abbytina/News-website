<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="site_keywords" content="<?php echo $sites[4]['value']?>">
  <meta name="site_description" content="<?php echo $sites[3]['value']?>">
  <title><?php echo $sites[2]['value']?></title>
  <link rel="shurtcut icon" href="./News.ico">
  <link rel="stylesheet" href="assets/css/pagination.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <!-- <ul class="ul_topnav">
        <?php foreach($lists as $key => $vals){?>
          <li class="li_topnav"><a href="<?php echo $vals['link']?>"><i class="<?php echo $vals['icon']?>"></i><?php echo $vals['title']?></a></li>
        <?php }?>
      </ul> -->
    </div>
    <div class="header">
      <h1 class="logo"><a href="/"><img src="assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <?php foreach($lists as $key => $vals){?>
          <li class="li_nav li_<?php echo $key?>"><a href="<?php echo $vals['link'], '#', $key?>"><i class="<?php echo
              $vals['icon']?>"></i><?php
                  echo $vals['title']?></a></li>
        <?php }?>
      </ul>
      <div class="search">
        <form action="/search.php">
          <input type="text" name="keyword" class="keys" placeholder="输入关键字" value="<?php echo isset($_GET['keyword'])?$_GET['keyword']:'';?>">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="/weibo.php">微博&nbsp;<i class="fa fa-weibo"></i></a> | <a href="/wechat.php">公众号&nbsp;<i class="fa fa-wechat"></i></a>
      </div>
      <?php
      // session_start();
      if (!session_id()) session_start();
      if(!empty($_SESSION['userInfo'])) { ?>
          <!-- 登录后状态 -->
      <div class="ent_user">
          <div class="ent_img">
          <!-- 判断头像 没有则给默认头像 -->
          <?php if(empty($_SESSION['userInfo']['avatar'])) { ?>
              <img class="avatar" src="/assets/img/animal.jpg">
              <?php } else { ?>
              <img class="avatar" src="<?php echo $_SESSION['userInfo']['avatar']; ?>">
          <?php } ?>
          </div>
          <div class="en_utxt">
                <p>
                  <span>欢迎您，</span><a href="/profiles.php"><?php echo  $_SESSION['userInfo']['nickname'];?> </a>
                </p>
          </div>
          <a href="/logouts.php" class="en_exit">[退出]</a>
      </div>
      <?php } else { ?>
          <!-- 登录前 -->
      <div class="lg_slink">
        <a href="/login.php">登录&nbsp;<i class="fa fa-sign-in"></i></a> | <a href="/register.php">注册&nbsp;<i class="fa fa-envelope-square"></i></a>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
<script src="../assets/vendors/jquery/jquery.min.js">
  
</script>
<script>
    $(function () {
        $('.li_' + window.location.hash.substr(1)).css('background', '#F0F6F8');
    })
</script>
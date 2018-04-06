<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="site_keywords" content="<?php echo $sites[4]['value']?>">
  <meta name="site_description" content="<?php echo $sites[3]['value']?>">
  <title><?php echo $sites[2]['value']?></title>
  <link rel="shurtcut icon" href="./News.ico">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <?php foreach($lists as $key => $vals){?>
          <li><a href="<?php echo $vals['link']?>"><i class="<?php echo $vals['icon']?>"></i><?php echo $vals['title']?></a></li>
        <?php }?>
      </ul>
    </div>
    <div class="header">
      <h1 class="logo"><a href="index.php"><img src="assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <?php foreach($lists as $key => $vals){?>
          <li><a href="<?php echo $vals['link']?>"><i class="<?php echo $vals['icon']?>"></i><?php echo $vals['title']?></a></li>
        <?php }?>
      </ul>
      <div class="search">
        <form action="/search.php">
          <input type="text" name="keyword" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">微博&nbsp;<i class="fa fa-weibo"></i></a> | <a href="javascript:;">公众号&nbsp;<i class="fa fa-wechat"></i></a>
      </div>
      <?php if(!empty($_SESSION['user_info'])) { ?>
          <!-- 登录后状态 -->
      <div class="ent_user">
          <div class="ent_img">
          <!-- 判断头像 没有则给默认头像 -->
          <?php if(empty($_SESSION['user_info']['avatar'])) { ?>
              <img class="avatar" src="/assets/img//animal.jpg">
              <?php } else { ?>
              <img class="avatar" src="<?php echo $_SESSION['user_info']['avatar']; ?>">
          <?php } ?>
          </div>
          <div class="en_utxt">
                <p>
                  <span>欢迎您，</span><a href="javascript:;"><?php echo  $_SESSION['user_info']['nickname'];?> </a>
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
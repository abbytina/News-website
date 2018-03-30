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
      <h1 class="logo"><a href="index.html"><img src="assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <?php foreach($lists as $key => $vals){?>
          <li><a href="<?php echo $vals['link']?>"><i class="<?php echo $vals['icon']?>"></i><?php echo $vals['title']?></a></li>
        <?php }?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>
<?php
require './functions.php';
header('content-type:text/html;charset=utf-8');
error_reporting(0);
$json = query("SELECT `value` FROM options WHERE `key` = 'nav_menus'");
// print_r($lists);
// exit;
//1. 导航完成
$lists = json_decode($json[0]['value'],true);
// print_r($lists);
// exit;

// 查询趣生活的文章内容
// $live_contents = query("SELECT id,title,category_id,created,content,feature FROM posts WHERE category_id = '4' ORDER BY id DESC limit 0,8");
$live_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id WHERE category_id = '4' ORDER BY id DESC limit 0,10");
  // print_r($live_contents);
  // exit;
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
   
    <?php include './inc/head.php'?>

    <?php include './inc/aside.php'?>

    <div class="content">
      <div class="panel new">
        <h3>趣生活</h3>
        <?php foreach($live_contents as $key => $vals){ ?>
        <div class="entry">
          <div class="head">
            <a href="detail.php?id=<?php echo $vals['id'] ?>"><?php echo $vals['title']?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $vals['nickname']?>  发表于 <?php echo $vals['created']?></p>
            <p class="brief"><?php echo $vals['content']?></p>
            <p class="extra">
              <span class="reading">阅读(3406)</span>
              <span class="comment">评论(0)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(167)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $vals['name']?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src=<?php echo $vals['feature']?> alt="">
            </a>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
    <?php include './inc/footer.php'?>
  </div>
</body>
</html>

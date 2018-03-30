<?php
    
    //判断用户是否登陆,只有登陆了才可以进行页面的访问
    //判断有没有session的信息 
    // session_start();
    // // print_r($_SESSION['user_info']);
    // if(!isset($_SESSION['user_info'])){
    //     //如果不存在，说明 还没有登陆，应该跳转到登陆页面
    //   header('location:/admin/login.php');
    //   exit;
    // }

      require '../functions.php';
      checkLogin();//检测用户是否登陆

      // 定义导航状态
      $active = 'dashboard';
      //查询posts数据库中的文章数量
      $lists = query('SELECT COUNT(*) as total FROM posts');
      // print_r($lists);
      // exit;
       //查询posts数据库中的草稿数量
      $rows = query("SELECT COUNT(*) as total FROM posts where status = 'drafted'");

        //查询categories数据库中分类的数量
      $Catcounts = query('SELECT COUNT(*) AS Catcounts FROM categories ');
      //查询comments数据库中评论的数量
      $commentcounts = query('SELECT COUNT(*) AS commentcounts FROM comments');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
   <?php include './inc/css.php'?>
  <?php include './inc/script.php'?>
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>这里有酒，诗和远方</h1>
        <p>所以你有故事吗？</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $lists[0]['total']?></strong>篇文章（<strong><?php echo $rows[0]['total']?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $Catcounts[0]['Catcounts']?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $commentcounts[0]['commentcounts']?></strong>条评论</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php include './inc/aside.php' ?>

 
</body>
</html>

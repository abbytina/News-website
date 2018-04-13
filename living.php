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
// 当前数据库里面有106条数据
$total = query("SELECT count(*) AS total FROM posts WHERE category_id = '4'");
//  print_r($total);
//  exit();
 
     $total = $total[0]['total'];
 //   print_r($total);
 // exit();
     //每页显示几条数据
     $pageSize = 6;
 
     //计算出总的页数
     $pageCount = ceil($total / $pageSize) ;
 
     //获取当前页的编码
     $pageCurrent = isset($_GET['page'])?$_GET['page']:'1';
 
     //设置上一页
     $prevPage = $pageCurrent - 1;
 
     $prevPage = $prevPage <1? 1 : $prevPage;
     //设置下一页
     $nextPage = $pageCurrent + 1;
 
     $nextPage = $nextPage > $pageCount ? $pageCount:$nextPage;
 
     //设置当前显示的每页的编码个数
     $pageLimit = 7;  //1 2 3 4 5 6 7     5 6 7  8 9 10 11    19  20  21 22 23 24 25
 
     //1 2 3 4 5 6 7 8 9           limit 0, 9,   (当前页-1)*$pageSize
     //10 11 12 13 14 15 16 17 18        9, 9
     //19 20 21 22 23 24 25 26 27        18,9 
 
  //根据当前页码计算页码的起点
     $start = $pageCurrent - floor($pageLimit / 2);
  //判断起点的边界不能小于1
     if($start < 1) {
       $start = 1;
   }
   //根据页码的起点计算终点（长度是固定的）
     $end = $start + $pageLimit - 1 ;
     if($end > $pageCount ){
       $end = $pageCount;
       $start = $end - $pageLimit + 1; // 开始页面要重新计算
        // 同样需要判断起点边界不能小于1
        if($start < 1) {
         $start = 1;
         }
     }
 
     $pages =range($start,$end);
 //     //设置当前页面中显示数据的起始编号
     $offset  = ($pageCurrent -1) * $pageSize;
// 查询趣生活的文章内容
// $live_contents = query("SELECT id,title,category_id,created,content,feature FROM posts WHERE category_id = '4' ORDER BY id DESC limit 0,8");
$live_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id WHERE category_id = '4' and posts.status= 'published' ORDER BY id DESC limit " . $offset . "," . $pageSize . "");
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
            <p class="brief"><?php echo $vals['slug']?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $vals['views']?>)</span>             
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
      <div class="page-action">
          <ul class="pagination pagination-sm pull-right">
            <li>
              <a href="/living.php?page=<?php echo $prevPage?>">上一页</a>
            </li>
            <?php foreach($pages as $key => $val){?>
              <?php if($pageCurrent == $val){ ?>
              <li class="active">
                <a href="/living.php?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }else { ?>
              <li>
                <a href="/living.php?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }?>
          <?php }?>
            <li>
              <a href="/living.php?page=<?php echo $nextPage?>">下一页</a>
            </li> 
          </ul>
        </div>
    </div>
    <?php include './inc/footer.php'?>
  </div>
</body>
</html>

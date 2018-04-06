<?php
header('content-type:text/html;charset=utf-8');
error_reporting(0);
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/30
 * Time: 21:44
 */
require_once 'functions.php';
if (!isset($_GET['keyword']) || empty($_GET['keyword'])) {
    echo '页面不存在';
    exit();
    // exit("请输入关键字");
}
$keyword = $_GET['keyword'];
// $total = 106;// 当前数据库里面有106条数据
$total = query("SELECT count(*) AS total FROM posts WHERE title LIKE '%{$keyword}%'");
// print_r($total);
// exit;
$total = $total[0]['total'];

//每页显示7条数据
$pageSize = 9;

//计算出总的页数
$pageCount = ceil($total / $pageSize);

//获取当前页的编码
$pageCurrent = isset($_GET['page']) ? $_GET['page'] : '1';
// print_r($pageCount);
// exit;
//设置上一页
$prevPage = $pageCurrent - 1;

$prevPage = $prevPage < 1 ? 1 : $prevPage;
//设置下一页
$nextPage = $pageCurrent + 1;

$nextPage = $nextPage > $pageCount ? $pageCount : $nextPage;

//设置当前显示的每页的编码个数

$pageLimit = 7;  //1 2 3 4 5 6 7     5 6 7  8 9 10 11    19  20  21 22 23 24 25

//1 2 3 4 5 6 7 8 9           limit 0, 9,   (当前页-1)*$pageSize
//10 11 12 13 14 15 16 17 18        9, 9
//19 20 21 22 23 24 25 26 27        18,9

$start = $pageCurrent - floor($pageLimit / 2);
$start = $start < 1 ? 1 : $start;

$end = $start + $pageLimit - 1;

// $end = $end > $pageCount ?$pageCount :$end;
if ($end > $pageCount) {
    $end = $pageCount;
    $start = $end - $pageLimit + 1; // 开始页面要重新计算
}
// $pages =range(1,10);
// $pages =range(1,$pageCount);

$pages = range($start < 1 ? 1 : $start, $end);


//设置当前页面中显示数据的起始编号
$offset = ($pageCurrent - 1) * $pageSize;
// $lists = query('SELECT * FROM posts');
// $lists = query('SELECT * FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id');
$sql = "SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,
posts.status,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id 
LEFT JOIN categories on posts.category_id = categories.id WHERE title LIKE '%{$keyword}%' LIMIT {$offset}, {$pageSize}";
$postLists = query($sql);

?>
<?php
$json = query("SELECT `value` FROM options WHERE `key` = 'nav_menus'");
// print_r($lists);
// exit;
//1. 导航完成
$lists = json_decode($json[0]['value'], true);
// $sites[2]['value'] = $postDetail['title'];
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
        <h3>搜索结果</h3>
        <?php foreach($postLists as $key => $vals){ ?>
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
    </div>
   
  </div>
  <?php include './inc/footer.php'?>
</body>
</html>

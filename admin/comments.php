<?php 
  /**
   * 思路：
   * 1.检测用户是否已经登陆
   * 2.显示当前页面的内容
   * 3.当数据量很大的时候，要实现一个分布的处理
   * 4.当单击批准、删除
   */
  require '../functions.php';
  checkLogin();
    // 定义导航状态
  $active = 'comments';

  // $total = 106;// 当前数据库里面有106条数据
    $total = query('SELECT count(*) AS total FROM posts');
    // print_r($total);
    // exit;
    $total = $total[0]['total'];

    //每页显示7条数据
    $pageSize = 9;

    //计算出总的页数
    $pageCount = ceil($total / $pageSize) ;

    //获取当前页的编码
    $pageCurrent = isset($_GET['page'])?$_GET['page']:'1';
    // print_r($pageCount);
    // exit;
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

    $start = $pageCurrent - floor($pageLimit / 2);
    $start = $start < 1? 1 :$start;

    $end = $start + $pageLimit - 1 ;

    // $end = $end > $pageCount ?$pageCount :$end;
    if($end > $pageCount ){
      $end = $pageCount;
      $start = $end - $pageLimit + 1; // 开始页面要重新计算
    }
    // $pages =range(1,10);
    // $pages =range(1,$pageCount);
    $pages =range($start,$end);


    //设置当前页面中显示数据的起始编号
    $offset  = ($pageCurrent -1) * $pageSize;
  // $lists = query('SELECT * FROM posts');
  // $lists = query('SELECT * FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id');
  $lists = query("SELECT comments.id,posts.title,posts.category_id,posts.created,posts.status,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id limit ".$offset.",".$pageSize.""); //精确查询,可解决覆盖的问题

  // print_r($lists);
  // exit;
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <?php include './inc/css.php'?>
</head>
<body>
  <div class="main">
  <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="danger">
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php include './inc/aside.php'?>

  <?php include './inc/script.php'?>
</body>
</html>

<?php 
header('content-type:text/html;charset=utf-8');
  /**
   * 思路：
   * 1.检测用户是否已经登陆
   * 2.显示当前页面的内容
   * 3.当数据量很大的时候，要实现一个分布的处理
   * 4.当单击批准、删除
   */
  require '../functions.php';
  checkLogin();
  error_reporting(0);
  // 提示信息
  $msg = '';
    // 定义导航状态
  $active = 'comments';

  // 当前数据库里面有106条数据
    $total = query('SELECT count(*) AS total FROM comments');

    $total = $total[0]['total'];

    //每页显示7条数据
    $pageSize = 3;

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

  // $lists = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.status,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id limit ".$offset.",".$pageSize.""); //精确查询,可解决覆盖的问题
  $com_lists = query("SELECT comments.id,comments.author,comments.post_id,comments.email,
  comments.created,comments.content,comments.status,posts.title FROM comments 
  LEFT JOIN posts on comments.post_id = posts.id limit ".$offset.",".$pageSize.""); //精确查询,可解决覆盖的问题
  //  print_r($com_lists);
  //  exit;
  
      //post提交过来的数据
      if(!empty($_POST)){ //接收post提交过来的数据      
       if($action =='update'){
           //
           //更新数据   $_POST
           // print_r($_POST);
           // exit;
         $comments_id = $_POST['id'];
         
         unset($_POST['id']);//删除掉这个id，因为更新的时候是不能更新id的，得根据id的条件去更新其它的字段值
         // echo $str;
         // exit;
         // $sql = "update users set ". "aa=bb,cc=dd"
        
         $result = update('comments',$_POST,$comments_id);
         // print_r($result);
         // exit;
         if($result ){
           header('location:/admin/comments.php');
         }else {
           $msg = '更新数据失败...';
         }
        }else if($action=='deleteAll') {
           $sql = "DELETE FROM comments where id in (".implode(',',$_POST['ids']).")";
          $result = delete($sql);

           header('Content-type:application/json');
          if($result) {
            //向前台发送一条删除 成功的信息
            $arr = array('code'=>10000,'msg'=>'删除成功');
            echo json_encode($arr);//转换成字符串输出到前台
          }else {
             $arr = array('code'=>10001,'msg'=>'删除失败...');
            echo json_encode($arr);//转换成字符串输出到前台
          }
          exit;
        }
    }
      
    if($action=='delete'){
      //删除  
      // $connect = connect();
      // $result = mysqli_query($connect,"DELETE FROM users where id = ".$id);
      // print_r($result);
      // exit;
      $result= delete("DELETE FROM comments where id = ".$id);
      if($result){
        header('location:/admin/comments.php');//刷新页面
      }else {
        $msg = '删除数据失败...';
      }
    }
 // }
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
     <?php if(!empty($msg)){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>
        <?php echo $msg ?>
      </div> 
    <?php } ?>
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch deleteAll" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li>
            <a href="/admin/comments.php?page=<?php echo $prevPage?>">上一页</a>
          </li>
          <?php foreach($pages as $key => $val){?>
            <?php if($pageCurrent == $val){ ?>
            <li class="active">
              <a href="/admin/comments.php?page=<?php echo $val?>"><?php echo $val?></a>
            </li>
            <?php }else { ?>
            <li>
              <a href="/admin/comments.php?page=<?php echo $val?>"><?php echo $val?></a>
            </li>
            <?php }?>
        <?php }?>
          <li>
            <a href="/admin/comments.php?page=<?php echo $nextPage?>">下一页</a>
          </li> 
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
        <?php foreach($com_lists as $key => $vals){ ?>
          <tr class="danger">
            <td class="text-center"><input type="checkbox"></td>
            <td><?php echo $vals['author']?></td>
            <td><?php echo $vals['content']?></td>
            <td><?php echo $vals['title']?></td>
            <td><?php echo $vals['created']?></td>
            <?php if($vals['status']=='approved'){ ?>
                  <td>批准</td>
                  <?php }else if($vals['status']=='rejected'){ ?>
                  <td>驳回</td>
                  <?php }else if($vals['status']=='held'){ ?>
                  <td>展示</td>
                  <?php }else {?>
                  <td>垃圾</td>
                  <?php }?>
            <td class="text-center">
              <a href="/admin/comments.php?action=status&comments_id=<?php echo $vals['id']?>" class="btn btn-info btn-xs">批准</a>
              <a href="/admin/comments.php?action=delete&comments_id=<?php echo $vals['id']?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include './inc/aside.php'?>

  <?php include './inc/script.php'?>
</body>
</html>
<script>
   //1.当单击总的小方块的时候，让要下面的的小方块都选中
   $('.toggleChk').on('click',function(){
    // 在jquery的事件当中，this表示DOM对象
      // if($(this).prop('checked')){

      // }

      if(this.checked){
        $('.chk').prop('checked',true); // checked selected disabled
        $('.deleteAll').show();
      }else {
        $('.chk').prop('checked',false);  
        $('.deleteAll').hide();
      }
  })
  //2.给小按钮注册事件，当一个或多个被选中的时候，也要让批量删除的按钮显示
  $('.chk').on('click',function(){
    var size = $('.chk:checked').size();
    if(size>0){
      $('.deleteAll').show();
      return;
      //1. 如果函数中有数据需要返回的话，得需要使用return关键字，将数据返回后，跳出当前函数，return关键字后面的代码不会执行
      //2. 如果函数中没有数据要返回，但是也使用了return关键字,就表示直接跳出当前函数，return关键字后面的代码也不会执行
      //3. 也就是说，在函数中只要使用了return关键字后，不管有没有返回数据，最终都会跳出当前的函数，return关键字后面的代码不会执行。
    }

     $('.deleteAll').hide();
  })
  //3.给批量删除按钮注册事件，批量的删除数据
  $('.deleteAll').on('click',function(){
      //1.获取所有被选中的小按钮的id,存到数组当中
      var ids = [];
      $('.chk:checked').each(function(){
          ids.push($(this).val());
      })

     
      //2.发送ajax请求到后台接口
      $.ajax({
        url:'/admin/comments.php?action=deleteAll', //虽然是post的提交，但是仍然可以在 url中拼接参数，只要是URL中的参数，都可以在后端通过$_GET的方式来获取
        type:'post',
        data:{ids:ids},
        success:function(info){
          // console.log(typeof info);
          if(info.code == 10000){
            location.reload(true);
          }else {
            alert('删除失败...');
          }
        }
      })

  })
  
</script>

<?php 
  require '../functions.php';
  checkLogin();//判断是否登陆

  $user_id = $_SESSION['user_info']['id'];
  // print_r($user_id);
  // exit;
  $rows = query('SELECT * FROM users WHERE id = '.$user_id);
  // print_r($rows);
  // exit;
  $msg = '';
  if(!empty($_POST)){
    // print_r($_POST);
    // exit;

    $result = update('users',$_POST,$user_id);
    if($result){
      //刷新当前的页面
      header('location:/admin/password-reset.php');
    }else {
      $msg = '数据更新失败...';
    }
  }

  /**
   * 1. 跳到此页面后，首先先判断是否登陆
   * 2. 去查询当前用户的数据，渲染在当前页面上,一定要查询最新的数据
   */
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Password reset &laquo; Admin</title>
  <?php include './inc/css.php'?>
  <?php include './inc/script.php'?>
</head>
<body>

  <div class="main">
  <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>修改密码</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal">
        <div class="form-group">
          <label for="old" class="col-sm-3 control-label">旧密码</label>
          <div class="col-sm-7">
            <input id="old" class="form-control" type="password" placeholder="旧密码">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">新密码</label>
          <div class="col-sm-7">
            <input id="password" class="form-control" type="password" placeholder="新密码">
          </div>
        </div>
        <div class="form-group">
          <label for="confirm" class="col-sm-3 control-label">确认新密码</label>
          <div class="col-sm-7">
            <input id="confirm" class="form-control" type="password" placeholder="确认新密码">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-7">
            <button type="submit" class="btn btn-primary">修改密码</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'?>

</body>
</html>

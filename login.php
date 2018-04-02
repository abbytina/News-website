<?php
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/31
 * Time: 0:07
 */
require_once 'functions.php';
$res = array(
    'code' => 1,
    'msg' => ''
);
if (!isset($_POST['email']) || empty($_POST['email'])) {
    $res['msg'] = '邮箱不能为空';
} else if (!isset($_POST['password']) || empty($_POST['password'])) {
    $res['msg'] = '密码不能为空';
} else {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = query("SELECT * FROM users WHERE email = '{$email}' AND `password` = '{$password}'");
    if (empty($query)) {
        $res['msg'] = '邮箱或密码不正确';
    } else {
        $res['code'] = 0;
        $res['msg'] = '登录成功';
        // session_start(['cookie_lifetime' => 86400]);
        session_start(array('cookie_lifetime' =>86400));
        $_SESSION['userInfo'] = $query[0];
    }
}

header('Content-type: application/json');
// echo json_encode_no_zh($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>register</title>
  <?php include './admin/inc/css.php'?>
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="" method="post">
      
      <!-- 有错误信息时展示 -->
      <?php if(!empty($msg)){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>
        <?php echo $msg?>
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" value="" type="email" class="form-control" placeholder="邮箱" autofocus required>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" value="" type="password" class="form-control" placeholder="密码" required>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">用户名</label>
        <input id="password" name="username" value="" type="text" class="form-control" placeholder="用户名" required>
      </div>
      <input type="submit" class="btn btn-primary btn-block" value="注册">
      <a href=""  class="btn btn-primary btn-block" value="返回"></a>
    </form>
  </div>
</body>
</html>
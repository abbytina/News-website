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
echo json_encode_no_zh($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login</title>
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="">
      <div class="login-group">
        <input  name="email" value="" type="email"  placeholder="邮箱" autofocus >
      </div>
      <div class="login-wrap">  
        <input name="password" value="" type="password"  placeholder="密码" >
      </div>
      <input type="submit" class="" value="注册">
    </form>
    <div>
      <a href="index.php">返回首页</a>
    </div>
  </div>
</body>
</html>
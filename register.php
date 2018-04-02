<?php
require_once 'functions.php';
if (isPost()) {
    if (!isset($_POST['email']) || !preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/', $_POST['email'])) {
        $msg = '请输入正确的邮箱';
    } else if (!isset($_POST['password']) || empty($_POST['password'])) {
        $msg = '请输入密码';
    }  else if (!isset($_POST['username']) || empty($_POST['username'])) {
        $msg = '请输入密码';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];

        $row = query("SELECT id FROM users WHERE email = '{$email}'");
        if (!empty($row)) {
            $msg = '该帐号已存在';
        } else {
            $data = array(
                'slug' => $email,
                'email' => $email,
                'password' => $password,
                'nickname' => $username,
            );
            if (!insert('users', $data)) {
                $msg = '注册失败';
            } else {
                echo "<html><head><meta charset=\"UTF-8\"><script>alert('注册成功');location.href = '/'</script></head></html>";
                exit();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>register</title>
</head>
<body>
  <div class="register">
    <form class="register-wrap" action="">
      <div class="register-group">
        <input  name="email" value="" type="email"  placeholder="邮箱" autofocus >
      </div>
      <div class="register-wrap">   
        <input  name="username" value="" type="text" placeholder="用户名" >
      </div>
      <div class="register-wrap">  
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
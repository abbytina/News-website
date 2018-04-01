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
            // $data = [
            //     'slug' => $email,
            //     'email' => $email,
            //     'password' => $password,
            //     'nickname' => $username,
            // ];
            $data = array('slug' =>$email,'email' =>$email,'password' =>$password,'nickname' =>$username);
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
  <?php include './admin/inc/css.php'?>
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="./register.php" method="post">
      
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
    </form>
  </div>
</body>
</html>
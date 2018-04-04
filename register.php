<?php
require_once 'functions.php';
if (isPost()) {
    if (!isset($_POST['email']) || !preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/', $_POST['email'])) {
        $msg = '请输入正确的邮箱';
    } else if (!isset($_POST['password']) || empty($_POST['password'])) {
        $msg = '请输入密码';
    } else if (!isset($_POST['username']) || empty($_POST['username'])) {
        $msg = '请输入账号';
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
                'status' => 'unactivated'
            );
            if (!insert('users', $data)) {
                $msg = '注册失败';
            } else {
                echo '<html><head><meta charset="UTF-8"></head></html><script>alert("注册成功");location.href = "/index.php"</script>';
                exit();
            }
        }
    }
}
if (!empty($msg)) {
    echo '<html><head><meta charset="UTF-8"></head></html><script>alert("' . $msg . '");</script>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>register</title>
    <link rel="stylesheet" href="assets/css/rlpage.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
<div class="b_register">
    <div class='reg_title'>
        <h2>Sign Up</h2>
    </div>
    <form class="reg-wrap" action="register.php" method="post">
        <div class="form-group">
            <input name="username" value="" type="text" class="form-control" autocomplete="off" placeholder="用户名" autofocus>
        </div>
        <div class="form-group">
            <input name="email" value="" type="email" class="form-control" autocomplete="off" placeholder="邮箱">
        </div>
        <div class="form-group">
            <input name="password" value="" type="password"  class="form-control" autocomplete="off" placeholder="密码">
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="注册">
        <a href="index.php" class="in_back" >返回首页&nbsp;<i class="fa fa-mail-reply"></i></a>
    </form>
</div>
</body>
</html>
<script src="./assets/vendors/jquery/jquery.min.js">

</script>
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
</head>
<body>
<div class="register">
    <form class="qq_register" action="register.php" method="post">
        <div class="register">
            <input name="username" value="" type="text" autocomplete="off" placeholder="用户名" autofocus>
        </div>
        <div class="register">
            <input name="email" value="" type="email" autocomplete="off" placeholder="邮箱">
        </div>
        <div class="register">
            <input name="password" value="" type="password" autocomplete="off" placeholder="密码">
        </div>
        <input type="submit" class="reg_btn" value="注册">
    </form>
    <div>
        <a href="index.php">返回首页</a>
    </div>
</div>
</body>
</html>
<script src="./assets/vendors/jquery/jquery.min.js">

</script>
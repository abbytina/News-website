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
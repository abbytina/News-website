<?php
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/31
 * Time: 0:07
 */
require_once '../functions.php';
$res = array(
  // 响应的状态码：0:登录成功  1：登录失败
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
    // print_r($email, $password);
    $query = query("SELECT * FROM users WHERE email = '{$email}' AND `password` = '{$password}'");
    // print_r($query);
    // exit();
    if (empty($query)) {
        $res['msg'] = '邮箱或密码不正确';
    } else {
        $res['code'] = 0;
        $res['msg'] = '登录成功';

        // session_start();//使用session之前一定要先启用session
        // $_SESSION['user_info'] = $query; //把用户的登陆信息存到session当中,随响应头发送给浏览器，存到浏览器的cookie当中
        // header('location:/admin');  //php中页面跳转

        session_start(array('cookie_lifetime' =>86400));
        $_SESSION['userInfo'] = $query[0];
        //  echo "<script>window.location.href='/index.php'</script>";
        // header('location:/index');  //php中页面跳转
        // exit;
        // echo '<html><head><meta charset="UTF-8"></head></html><script>alert("登录成功");location.href = "/index.php"</script>';
    }
}
header('Content-type: application/json');
echo json_encode($res, JSON_UNESCAPED_UNICODE);



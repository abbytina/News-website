<?php
  session_start();
  unset($_SESSION['userInfo']);
  header('location:/');//跳转到首页

  // 退出功能

?>
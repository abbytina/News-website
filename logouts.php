<?php
  session_start();
  unset($_SESSION['user_info']);
  header('location:/');//跳转到首页

  // 退出功能

?>
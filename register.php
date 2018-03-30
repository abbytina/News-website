<?php




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
      <!-- <?php if(!empty($msg)){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>
        <?php echo $msg?>
      </div>
      <?php } ?> -->
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" value="" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" value="" type="password" class="form-control" placeholder="密码">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">用户名</label>
        <input id="password" name="password" value="" type="password" class="form-control" placeholder="密码">
      </div>
      <input type="submit" class="btn btn-primary btn-block" value="注册">
    </form>
  </div>
</body>
</html>
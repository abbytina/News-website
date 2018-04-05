<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login</title>
  <link rel="stylesheet" href="assets/css/rlpage.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="user_login">
    <form class="login-wrap" action="/login.php" id="form">
    <img class="avatar" src="./assets/img/girl.jpg">
      <div class="form-group">
        <input name="email" value="" type="email"  class="form-control" placeholder="邮箱" autofocus >
      </div>
      <div class="form-group">  
        <input name="password" value="" type="password"  class="form-control" autocomplete="new-password"  placeholder="密码" >
      </div>
      <input type="button" id="lg_btn" class="btn btn-primary btn-block" value="登录">
      <a href="index.php" class="in_back" >返回首页&nbsp;<i class="fa fa-mail-reply"></i></a>
    </form>
    <div>  
    </div>
  </div>
</body>
</html>
<script src="./assets/vendors/jquery/jquery.min.js">
  
</script>
<script>
  $("#lg_btn").click(function() {
  //如果要将表单中的所有数据进行键值对的处理
  var dataStr  = $("#form").serialize();
    $.ajax({
      type:"POST",
      url:"/api/logins.php",
      dataType:"json",
      data:dataStr,
      success:function(data){
        // console.log(data);
        // 判断状态
        if(data.code == 0) {
        alert(data.msg);
        window.location.href= '/index.php'; //js下的页面跳转
      } else {
        alert(data.msg);
      }
      }
    });
  });
  </script>
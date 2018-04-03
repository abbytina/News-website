<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login</title>
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="/login.php" id="form">
      <div class="login-group">
        <input name="email" value="" type="email"  placeholder="邮箱" autofocus >
      </div>
      <div class="login-wrap">  
        <input name="password" value="" type="password"  autocomplete="new-password"  placeholder="密码" >
      </div>
      <input type="button" id="lg_btn" value="提交">
    </form>
    <div>
      <a href="index.php">返回首页</a>
    </div>
  </div>
</body>
</html>
<script src="./assets/vendors/jquery/jquery.min.js">
  
</script>
<script>
  $("#lg_btn").click(function() {
    // 先获取uName和pwd的值
    // var uName = $("#uName").val();
    // var pwd = $("#pwd").val();
    // var dataStr = "uName="+uName+"pwd="+pwd; //（数据的序列化）

  //如果要将表单中的所有数据进行键值对的处理
  var dataStr  = $("#form").serialize();
    $.ajax({
      type:"POST",
      url:"login.php",
      dataType:"json",
      data:dataStr,
      success:function(data){
        // 判断状态
        if(data.status == 0) {
        alert(data.msg);
        // window.location.href= '/index.php'; //js下的页面跳转
      } else {
        alert(data.msg);
      }
      }
    });
  });
  </script>
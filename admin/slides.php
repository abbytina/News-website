<?php 
  require '../functions.php';
  checkLogin();
    // 设置导航菜单
    $cogs = array('nav-menus', 'slides', 'settings');
      // 当前导航
      $active = 'slides';
  /**
   * 思路：
   * 1.跳转过来的时候，要渲染页面
   * 2.上传图片
   * 3.实现添加功能  
   * 4.删除
   *     所谓的删除其实是更新数据库里面的那一项数据的值
   *     [
   *     {"image":"/uploads/slide_1.jpg","text":"轮播项一","link":"https://zce.me"},
   *     {"image":"/uploads/slide_2.jpg","text":"轮播项二","link":"https://zce.me"},
   *     {"image":"/uploads/1509331778.jpg","text":"asfda","link":"afsdaf"},
   *     {"image":"/uploads/1509332034.jpg","text":"风云变幻","link":"http://abc.com"}
   *     ]
   *     就是将数据中的这一条数据取出来(字符串),将当前的字符串转换成数组，再删除其中的某一项，然后将剩余的数组再转换成字符串，更新回数据
   */

  //查询数据库中的数据
  $json = query("SELECT `value` FROM options where `key` = 'home_slides'");

  // print_r($json);
  // exit;  
  //将数据转换成数组
  $data = json_decode($json[0]['value'],true);
  // print_r($data);
  // exit;  
  $action = isset($_GET['action']) ?$_GET['action'] :'';
  $msg = '';

  //一.获取上传过来的图片,移动到指定的文件夹
  if($action == 'upfile'){
     //把上传过来的图片放到指定的文件夹里面，php有一个特点，会将上传过来的图片先存到临时的文件夹里面，需要我们把临时文件移动到指定文件
     //1. 判断指定的文件夹是否存在
      if(!file_exists('../uploads')){
          mkdir('../uploads');
      }

      //2. 设置图片文件的时间戳名称 
      $fileName = time();  //按当前的时间命名的图片文件

      // print_r($_FILES);
      // exit;
      //3.获取上传过来的图片文件的后缀
      $ext = explode('.',$_FILES['image']['name']);
      $ext = $ext[1];//只要上传文件的后缀名称 

      //4. 拼接路径
      $path = '/uploads/'.$fileName . '.' . $ext;
      // echo $path;
      // exit;

      //5. 要将图片从临时文件夹里面移动到指定的文件夹里面
      move_uploaded_file($_FILES['image']['tmp_name'],'..'.$path);

      //6.返回给前台一份路径
      echo $path;
      exit;
  }else if($action=='delete'){
    $index = $_GET['index'];  //获取当前要删除的那一项的索引
    unset($data[$index]); //根据索引删除 数组中的那一项
    $data= json_encode_no_zh($data); //将数组转换成字符串
    $result =  update('options',array('value'=>$data),10); //更新数组库里面的那一项数据
    if($result){
      header('location:/admin/slides.php');
    }else {
      $msg = '删除失败...';
    }
  }

  //二.获取post过来的表单数据,添加的功能实现
  if(!empty($_POST)){
    //接收post过来的数据,存到上面的数据当中，再把数据转换成字符串，更新回数据库的指定值
    $data[] = $_POST; //此时的$data是一个数组，里面有三项
    // print_r($data);
    // exit;
    $data = json_encode_no_zh($data);//此时前面的变量$data是一个字符串，需要更新回数据库
    $result = update('options',array('value'=>$data),10);
    if($result){
      header('location:/admin/slides.php');
    }else {
      $msg = '添加数据失败...';
    }
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
  <?php include './inc/css.php'?>
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if($msg){?>
        <div class="alert alert-danger">
          <strong>错误！</strong>
          <?php echo $msg ?>
        </div>
      <?php }?>
      <div class="row">
        <div class="col-md-4">
          <form action='/admin/slides.php' method='post'>
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" class="form-control"  type="file">
              <input type="hidden" name="image">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="page-action">
          <!-- show when multiple checked -->
          <div class="btn-batch deleteAll" style="display: none">
            <button class="btn btn-info btn-sm">批量批准</button>
            <button class="btn btn-warning btn-sm">批量拒绝</button>
            <button class="btn btn-danger btn-sm">批量删除</button>
          </div>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center">图片</th>
                <th>文本</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($data as $key => $vals){ ?>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="slide" src="<?php echo $vals['image']?>"></td>
                <td><?php echo $vals['text']?></td>
                <td><?php echo $vals['link']?></td>
                <td class="text-center">
                  <a href="/admin/slides.php?action=delete&index=<?php echo $key?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include './inc/aside.php'?>

  <?php include './inc/script.php'?>
</body>
</html>
<script>
  // $('input[type=file]').on('change',function(){
  //   alert(123);
  // })
  $('#image').on('change',function(){
     var data = new FormData();
     data.append('image',this.files[0]) ;

     //1. 创建异步对象
     var xhr = new XMLHttpRequest();

     //2. 设置请求行
     xhr.open('post','/admin/slides.php?action=upfile');

     //3. 发送数据
     xhr.send(data);

     //4.请求成功之后的处理
     xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
          //将接收到的图片路径，渲染在页面上
          $('.thumbnail').attr('src',xhr.responseText).show();

          //给隐藏域添加当前图片的路径，以备提交的时候，提交给服务器存在数据库里面
          $('input[name=image]').val(xhr.responseText);
        }
     }
  })
</script>

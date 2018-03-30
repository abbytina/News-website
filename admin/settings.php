<?php
  require '../functions.php';
  checkLogin();
   // 设置导航菜单
   $cogs = array('nav-menus', 'slides', 'settings');
   
    // 当前导航
   $active = 'settings';

  $lists = query('SELECT * from options where id < 9');
  // print_r($lists);
  // exit;

  //1.接收上传过来的图片文件
  if(!empty($_FILES)){
    if(!file_exists('../uploads')){
        mkdir('../uploads');
    }

    $fileName = time();

    $ext = explode('.',$_FILES['site_logo']['name']);
    $ext = $ext[1];

    $path = '/uploads/'.$fileName . '.' .$ext;
    move_uploaded_file($_FILES['site_logo']['tmp_name'],'..'.$path);
    echo $path;
    exit;
  }

  //2. 接收所有传过来的文件，存到数据库里面
  if(!empty($_POST)){
    // print_r($_POST);
    // exit;
    $_POST['comment_status'] = isset($_POST['comment_status'])?1:0;
    $_POST['comment_reviewed'] = isset($_POST['comment_reviewed'])?1:0;

    // update options set value = 值 where key = 'site_name'
    // update options set value = 值 where key = 'site_keywords'
    // update options set value = 值 where key = 'site_description'
    $connect = connect();
    foreach($_POST as $key => $val){
      $sql = "update options set `value` = '".$val."' where `key` = '".$key."' ";
      // print_r($sql);
      mysqli_query($connect,$sql);
    }
    // exit;
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Settings &laquo; Admin</title>
  <?php include './inc/css.php'?>
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>网站设置</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" action='/admin/settings.php' method="post">
        <div class="form-group">
          <label for="site_logo" class="col-sm-2 control-label">网站图标</label>
          <div class="col-sm-6">
            <input id="site_logo" name="site_logo" type="hidden">
            <label class="form-image">
              <input id="logo" type="file">
              <img src="<?php echo $lists[1]['value']?>">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="site_name" class="col-sm-2 control-label">站点名称</label>
          <div class="col-sm-6">
            <input id="site_name" value="<?php echo $lists[2]['value']?>" name="site_name" class="form-control" type="type" placeholder="站点名称">
          </div>
        </div>
        <div class="form-group">
          <label for="site_description" class="col-sm-2 control-label">站点描述</label>
          <div class="col-sm-6">
            <textarea id="site_description" name="site_description" class="form-control" placeholder="站点描述" cols="30" rows="6"><?php echo $lists[3]['value']?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="site_keywords" class="col-sm-2 control-label">站点关键词</label>
          <div class="col-sm-6">
            <input id="site_keywords" value="<?php echo $lists[4]['value']?>" name="site_keywords" class="form-control" type="type" placeholder="站点关键词">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">评论</label>
          <div class="col-sm-6">
            <div class="checkbox">
              <label><input id="comment_status" name="comment_status" type="checkbox" <?php if($lists[6]['value']==1){ ?> checked <?php }?>>开启评论功能</label>
            </div>
            <div class="checkbox">
              <label><input id="comment_reviewed" name="comment_reviewed" type="checkbox" <?php if($lists[7]['value']==1){ ?> checked <?php }?>>评论必须经人工批准</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-primary">保存设置</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'?>

  <?php include './inc/script.php'?>
</body>
</html>
<script>

  $('input[type=file]').on('change',function(){
    var data = new FormData();
    data.append('site_logo',this.files[0]);

    var xhr = new XMLHttpRequest();

    xhr.open('post','/admin/settings.php');
    xhr.send(data);
    xhr.onreadystatechange = function(){
      if(xhr.readyState==4&&xhr.status == 200){
        $('#logo').next().attr('src',xhr.responseText);
        $('#site_logo').val(xhr.responseText);
      }
    }
  })
</script>


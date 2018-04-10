<?php 
    require '../functions.php';
    checkLogin();//检测用户是否登陆
    
      // 定义二级导航
   $actives = array('posts', 'postadd', 'categories');
   // 定义二级导航状态
   $active = 'categories';
  // 当前数据库里面有106条数据
  $total = query('SELECT count(*) AS total FROM categories');
  // print_r($total);
  // exit();
  
      $total = $total[0]['total'];
  //   print_r($total);
  // exit();
      //每页显示几条数据
      $pageSize = 7;
  
      //计算出总的页数
      $pageCount = ceil($total / $pageSize) ;
  
      //获取当前页的编码
      $pageCurrent = isset($_GET['page'])?$_GET['page']:'1';
  
      //设置上一页
      $prevPage = $pageCurrent - 1;
  
      $prevPage = $prevPage <1? 1 : $prevPage;
      //设置下一页
      $nextPage = $pageCurrent + 1;
  
      $nextPage = $nextPage > $pageCount ? $pageCount:$nextPage;
  
      //设置当前显示的每页的编码个数
      $pageLimit = 7;  //1 2 3 4 5 6 7     5 6 7  8 9 10 11    19  20  21 22 23 24 25
  
      //1 2 3 4 5 6 7 8 9           limit 0, 9,   (当前页-1)*$pageSize
      //10 11 12 13 14 15 16 17 18        9, 9
      //19 20 21 22 23 24 25 26 27        18,9 
  
   //根据当前页码计算页码的起点
      $start = $pageCurrent - floor($pageLimit / 2);
   //判断起点的边界不能小于1
      if($start < 1) {
        $start = 1;
    }
    //根据页码的起点计算终点（长度是固定的）
      $end = $start + $pageLimit - 1 ;
      if($end > $pageCount ){
        $end = $pageCount;
        $start = $end - $pageLimit + 1; // 开始页面要重新计算
         // 同样需要判断起点边界不能小于1
         if($start < 1) {
          $start = 1;
          }
      }
  
      $pages =range($start,$end);
  //     //设置当前页面中显示数据的起始编号
      $offset  = ($pageCurrent -1) * $pageSize;
    $msg = '';
    $action = isset($_GET['action'])?$_GET['action']:'add';
    $ct_id =  isset($_GET['ct_id'])?$_GET['ct_id']:'';
    $title = '添加新分类目录';
    $btnText = '添加';
    //1. 当页面跳转到此处的时候，要查询数据库，渲染当前页面
    // $lists = query('SELECT * FROM categories');
    $lists = query("SELECT categories.id,categories.slug,categories.name FROM categories limit ".$offset.",".$pageSize."");
    // print_r($lists);
    // exit;

    //2. 做添加操作 
    if(!empty($_POST)){ //接收post过来的数据,添加到数据库当中     
      if($action =='add'){
         $result = insert('categories',$_POST);
        if($result){
          header('location:/admin/categories.php');
        }else {
          $msg = '添加数据失败...';
        }
      }else if($action == 'update'){
        //获取表单数据，提交给数据库
        // update('categories',$_POST,)
        // print_r($ct_id);
        // print_r($_POST);
        // exit;
        // 因为更新的时候是不能更新id的，因此需要把id给先删除掉,删除之前先获取到此id,后面的sql语句会用到
        $ct_id = $_POST['id']; //获取id
        unset($_POST['id']); //从数组中删除此id
        $result = update('categories',$_POST,$ct_id);
        if($result){
          header('location:/admin/categories.php');
        }else {
          $msg = '更新数据失败...';
        }
      }else if($action == 'deleteAll'){
        // $ids = $_POST['ids'];
        //   delete('DELETE FROM categories WHERE id in('. implode(",",$ids).')')
        $result =  delete('DELETE FROM categories WHERE id in('. implode(",",$_POST['ids']).')');
        header('Content-type:application/json');
        if($result){
          $arr = array('code'=>10000,'msg'=>'批量删除成功');
          echo json_encode($arr);
        }else {
           
          echo json_encode(array('code'=>10001,'msg'=>'批量删除失败'));
        }
        exit; //程序不要往下执行了
      }

    }

    //3. 做编辑或是删除的操作
    if($action =='edit'){
      //当点按钮的时候，要把当前的这条数据渲染在左侧的表单当中
      $rows = query("SELECT * FROM categories where id = ". $ct_id);
      // print_r($rows);
      // exit;
      $action = 'update';
      $title = '修改此分类';
      $btnText = '更新';

    }else if($action=='delete') {
      $result = delete('DELETE FROM categories WHERE id = '.$ct_id);
      if($result){
        header('location:/admin/categories.php');
      }else {
        $msg = '删除数据失败...';
      }
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <?php include './inc/css.php'?>
  
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if($msg){ ?>
        <div class="alert alert-danger">
          <strong>错误！</strong>
          <?php echo $msg?>
        </div>
      <?php }?>
      <div class="row">
        <div class="col-md-4">
          <form action='./categories.php?action=<?php echo $action?>' method='post'>
            <h2><?php echo $title?></h2>
            <?php if(isset($rows[0]['id'])){ ?>
              <input type="hidden" name="id" value="<?php echo $rows[0]['id']?>">
            <?php }?>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" value="<?php echo isset($rows[0]['name'])?$rows[0]['name']:'' ?>" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" value="<?php echo isset($rows[0]['slug'])?$rows[0]['slug']:''?>" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit"><?php echo $btnText?></button>
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
          <ul class="pagination pagination-sm pull-right">
            <li>
              <a href="/admin/categories.php?page=<?php echo $prevPage?>">上一页</a>
            </li>
            <?php foreach($pages as $key => $val){?>
              <?php if($pageCurrent == $val){ ?>
              <li class="active">
                <a href="/admin/categories.php?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }else { ?>
              <li>
                <a href="/admin/categories.php?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }?>
          <?php }?>
            <li>
              <a href="/admin/categories.php?page=<?php echo $nextPage?>">下一页</a>
            </li> 
          </ul>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm deleteAll" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40">
                  <input type="checkbox" id="toggleChk">
                </th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($lists as $key => $vals ){ ?>
              <tr>
                <td class="text-center">
                  <input type="checkbox" value="<?php echo $vals['id']?>" class="chk">
                </td>
                <td><?php echo $vals['name']?></td>
                <td><?php echo $vals['slug']?></td>
                <td class="text-center">
                  <a href="/admin/categories.php?action=edit&ct_id=<?php echo $vals['id']?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/categories.php?action=delete&ct_id=<?php echo $vals['id']?>" class="btn btn-danger btn-xs">删除</a>
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
  //1.给总按钮添加事件，按钮所有小按钮的显示和隐藏及批量删除按钮的显示和隐藏
  $('#toggleChk').on('click',function(){
     if(this.checked){ //总按钮被选中的时候
      $('.chk').prop('checked',true); //所有的小按钮也被选中
      $('.deleteAll').show(); // 
     }else {
       $('.chk').prop('checked',false);
       $('.deleteAll').hide();
     }
  })
  //2. 当下面的小按钮被选中的超过一个的时候，也要让批量删除的按钮显示出来
  $('.chk').on('click',function(){
    var size = $('.chk:checked').size();
    if(size>0){
      $('.deleteAll').show();
      return ;
    }

    $('.deleteAll').hide();
  })
  //3.给批量删除的按钮注册事件
  $('.deleteAll').on('click',function(){
    var ids = [];
    $('.chk:checked').each(function(){
        ids.push($(this).val());//将每一个小按钮的id添加到数组当中
    })
    //发送ajax请求
     $.ajax({
      url:'/admin/categories.php?action=deleteAll',
      type:'post',
      data:{
        ids:ids
      },
      success:function(info){
        if(info.code == 10000){
          location.reload(true);
        }else {
          alert('批量删除失败...');
        }
      }
     }) 
  })
</script> 

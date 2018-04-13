<?php 
header('content-type:text/html;charset=utf-8');
    // echo __DIR__; //获取当前的绝对路径
    require './functions.php';
    // checkLogins(); // 判断用户是否登录
    // 热门排行序号
    $i = 1;
    // 当前数据库里面有106条数据
  $total = query('SELECT count(*) AS total FROM posts');
  // print_r($total);
  // exit();
  
      $total = $total[0]['total'];
  //   print_r($total);
  // exit();
      //每页显示几条数据
      $pageSize = 6;
  
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
   $json = query("SELECT `value` FROM options WHERE `key` = 'nav_menus'");
    // print_r($lists);
    // exit;
   //1. 导航完成
   $lists = json_decode($json[0]['value'],true);
   // print_r($lists);
   // exit;

   //2.轮播图的实现
   $rows = query("SELECT `value` FROM options where `key` = 'home_slides'");

    //将字符串数据转换成数组
    $data = json_decode($rows[0]['value'],true);

    $sites = query('SELECT * from options where id < 9');
    // 文章内容
    $postSql=<<<SQL
SELECT
  p.id,
  p.title,
  p.category_id,
  p.created,
  p.content,
  p.feature,
  p.views,
  p.slug,
  u.nickname,
  categories.name
FROM posts AS p
  LEFT JOIN users AS u ON p.user_id = u.id
  LEFT JOIN categories ON p.category_id = categories.id
WHERE p.status = 'published'
ORDER BY id DESC
limit $offset, $pageSize
SQL;

    $contents = query($postSql);
    // $contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY id ");
    // print_r($contents);
    // exit;
    // 热门排行 按点击数（阅读数）查询 
    $hot_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id where posts.status= 'published' ORDER BY views DESC limit 0,5");
    // print_r($hot_contents);
    // exit;
 ?>

<?php include './inc/head.php'?>
    <?php include './inc/aside.php'?>
    <div class="content">
      <div class="swipe">
        <ul class="swipe-wrapper">
        <?php foreach($data as $key =>$vals){ ?>
          <li class="active">
            <a href="#">
              <img src="<?php echo $vals['image']?>">
              <span><?php echo $vals['text']?></span>
            </a>
          </li>
        <?php }?>
        </ul>
        <p class="cursor">
          <?php foreach($data as $key => $vals){ ?>
            <span <?php if($key==0){?> class="active" <?php } ?>></span>
          <?php }?>
        </p>
        <a href="javascript:;" class="arrow prev"><i class="fa fa-chevron-left"></i></a>
        <a href="javascript:;" class="arrow next"><i class="fa fa-chevron-right"></i></a>
      </div>
    
      <div class="panel top">
        <h3>热门排行</h3>      
        <ol>
        <?php foreach($hot_contents as $key =>$vals){ ?>
          <li>
            <i><?php echo $i++ ?></i>
            <a href="detail.php?id=<?php echo $vals['id'] ?>"><?php echo $vals['title']?></a>
            <a href="javascript:;" class="like"><i class="fa fa-fire"></i></a>
            <span>阅读 (<?php echo $vals['views']?>)</span>
          </li>
          <?php }?>
        </ol>
      </div>
      <div class="panel new">
        <h3>最新发布</h3>
        <?php foreach($contents as $key => $vals){ ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $vals['name']?></span>
            <a href="detail.php?id=<?php echo $vals['id'] ?>"><?php echo $vals['title']?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $vals['nickname']?>  发表于 <?php echo $vals['created']?></p>
            <p class="brief"><?php echo $vals['slug']?></p> 
            <p class="extra">
              <span class="reading">阅读(<?php echo $vals['views']?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-hand-o-right"></i>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $vals['name']?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <?php if(empty($vals['feature'])){ ?>
                 <img src="./assets/img/cimg.jpeg" alt=""> 
              <?php } else { ?>
              <img src=<?php echo $vals['feature']?> alt="">     
              <?php } ?> 
            </a>
          </div>
        </div>
       <?php }?>
      </div>
      <div class="page-action">
          <ul class="pagination pagination-sm pull-right">
            <li>
              <a href="/?page=<?php echo $prevPage?>">上一页</a>
            </li>
            <?php foreach($pages as $key => $val){?>
              <?php if($pageCurrent == $val){ ?>
              <li class="active">
                <a href="/?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }else { ?>
              <li>
                <a href="/?page=<?php echo $val?>"><?php echo $val?></a>
              </li>
              <?php }?>
          <?php }?>
            <li>
              <a href="/?page=<?php echo $nextPage?>">下一页</a>
            </li> 
          </ul>
        </div>
    </div>
    <?php include './inc/footer.php'?>
  </div>
  <?php include './inc/script.php'?>
  <script>
    // 1 显示自己 隐藏其他
    var swiper = Swipe(document.querySelector('.swipe'), {
      auto: 2000,
      transitionEnd: function (index) {
        // index++;

        $('.cursor span').eq(index).addClass('active').siblings('.active').removeClass('active');
      }
    });

    // 2 上/下一张
    $('.swipe .arrow').on('click', function () {
      var _this = $(this);
      if(_this.is('.prev')) {
        swiper.prev();
      } else if(_this.is('.next')) {
        swiper.next();
      }
    })

    // 3 点击标题标签切换显示对应内容 
  </script>
</body>
</html>

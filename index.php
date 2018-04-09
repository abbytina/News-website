<?php 
header('content-type:text/html;charset=utf-8');
    // echo __DIR__; //获取当前的绝对路径
    require './functions.php';
    // checkLogins(); // 判断用户是否登录
    // 热门排行序号
    $i = 1;
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
    $contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY id DESC limit 0,8");
    // $contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY id ");
    // print_r($contents);
    // exit;
    // 热门排行 按点击数（阅读数）查询 
    $hot_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY views DESC limit 0,5");
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
              <!-- <img src="uploads/hots_2.jpg" alt="">  -->
              <img src=<?php echo $vals['feature']?> alt="">      
            </a>
          </div>
        </div>
       <?php }?>
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

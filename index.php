<?php 
    // echo __DIR__; //获取当前的绝对路径
    require './functions.php';
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
    $contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY id DESC limit 0,8");
    // $contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY id ");
    // print_r($contents);
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
        <h3>一周热门排行</h3>
        <ol>
          <li>
            <i>1</i>
            <a href="javascript:;">你敢骑吗？全球第一辆全功能3D打印摩托车亮相</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>2</i>
            <a href="javascript:;">又现酒窝夹笔盖新技能 城里人是不让人活了！</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span class="">阅读 (18206)</span>
          </li>
          <li>
            <i>3</i>
            <a href="javascript:;">实在太邪恶！照亮妹纸绝对领域与私处</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>4</i>
            <a href="javascript:;">没有任何防护措施的摄影师在水下拍到了这些画面</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>5</i>
            <a href="javascript:;">废灯泡的14种玩法 妹子见了都会心动</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
        </ol>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="uploads/hots_2.jpg" alt="">
              <span>星球大战:原力觉醒视频演示 电影票68</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="uploads/hots_3.jpg" alt="">
              <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="uploads/hots_4.jpg" alt="">
              <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="uploads/hots_5.jpg" alt="">
              <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
            </a>
          </li>
        </ul>
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
            <p class="brief"><?php echo $vals['content']?></p>
            <p class="extra">
              <span class="reading">阅读(3406)</span>
              <span class="comment">评论(0)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(167)</span>
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
    var box = document.getElementsByClassName("swipe-wrapper");//获取滑动标签最外层元素
    // console.log(box);
    var olis = box.getElementsByTagName("li"); //获取标签元素
    // console.log(olis);
    //构建循环，获取每一个标签
    for(var i=0; i<olis.length; i++) {
        //给每一个标签设置一个序号属性
        olis[i].index = i;
        //给每一个标签绑定点击事件
        olis[i].onclick = function () {
            //清除所有标签样式
            for(var j=0; j<olis.length; j++) {
                olis[j].className="";
            }
            //给当前点击的标签加上样式
            this.className="active";
           }
    }

  </script>
</body>
</html>

<?php
// require './functions.php';
// 查询趣生活的文章内容
// $live_contents = query("SELECT id,title,category_id,created,content,feature FROM posts WHERE category_id = '4' ORDER BY id DESC limit 0,8");
// 随机推荐
$ss_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id  ORDER BY rand() DESC limit 0,5");
  // print_r($ss_contents);
  // exit;

// 最新评论
$pl_contents = query("SELECT comments.id,comments.author,comments.email,comments.created,comments.content FROM comments ORDER BY id DESC limit 0,5");
// print_r($pl_contents);
// exit;

?>

<div class="aside">
      <div class="widgets">
      <h4>主题</h4>
       <a href="https://www.baidu.com/"><img src="../uploads/cloud_2.jpg" alt=""></a>
      </div>
      <div class="widgets">
        <h4>随机推荐</h4>
        <?php foreach($ss_contents as $key => $vals){ ?>
        <ul class="body random">
          <li>
            <a href="detail.php?id=<?php echo $vals['id'] ?>">
              <p class="title"><?php echo $vals['title']?></p>
              <p class="reading"><i class="fa fa-paper-plane"></i></p>
              <div class="pic">
                <img src=<?php echo $vals['feature']?> alt="">
              </div>
            </a>
          </li>
        </ul>
        <?php }?>
      </div>
      <div class="widgets">
        <h4>最新评论</h4>
        <?php foreach($pl_contents as $key => $vals){ ?>
        <ul class="body discuz">
          <li>
            <a href="javascript:;">
              <div class="avatar">
                   <!-- 判断头像 没有则给默认头像 -->
                <?php if(empty($_SESSION['userInfo']['avatar'])) { ?>
                    <img class="avatar" src="/assets/img/animal.jpg">
                    <?php } else { ?>
                    <img class="avatar" src="<?php echo $_SESSION['userInfo']['avatar']; ?>">
                <?php } ?>
              </div>
              <div class="txt">
                <p>
                  <span><?php echo $vals['author']?></span>说:
                </p>
                <p><?php echo $vals['content']?></p>
              </div>
            </a>
          </li>
        </ul>
        <?php }?>
      </div>
    </div>
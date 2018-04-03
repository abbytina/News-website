<?php
// require './functions.php';
// 查询趣生活的文章内容
// $live_contents = query("SELECT id,title,category_id,created,content,feature FROM posts WHERE category_id = '4' ORDER BY id DESC limit 0,8");
// 随机推荐
$ss_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id  ORDER BY rand() DESC limit 0,5");
  // print_r($ss_contents);
  // exit;

// 最新评论
$pl_contents = query("SELECT comments.id,comments.author,comments.email,comments.created,comments.content FROM comments ORDER BY rand() DESC limit 0,5");
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
              <p class="reading">☝</p>
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
        <ul class="body discuz">
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
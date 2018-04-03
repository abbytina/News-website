<?php
header('content-type:text/html;charset=utf-8');
require_once './functions.php';
error_reporting(0);
/**
 * 获取文章详情
 * @param $postId
 * @return mixed
 */
function get_post_detail($postId)
{

    $sql = <<<SQL
SELECT
  p.id,
  p.title,
  p.content,
  p.views,
  p.category_id,
  c.name AS c_name,
  u.nickname AS nickname
FROM posts AS p
  LEFT JOIN categories AS c ON p.category_id = c.id
  LEFT JOIN users AS u ON u.id = p.user_id
WHERE p.id =  $postId
SQL;
    $row = query($sql);
    if (empty($row)) {
        exit('文章不存在');
    }
    $detail = $row[0];

    $sql = "SELECT count(id) AS num FROM comments WHERE id = {$detail['id']}";
    $row = query($sql);
    $detail['comments'] = $row[0]['num'];
    query("UPDATE posts SET views=views + 1 where id = {$detail['id']}");
    return $detail;
}

/**
 * 获取文章评论
 * @param $postId
 * @return array
 */
function get_post_comment($postId)
{
    $sql = "SELECT * FROM comments WHERE post_id = {$postId} AND `status` ='approved' ORDER BY created DESC";
    $row = query($sql);
    return $row;
}

if (!isset($_GET['id'])) {
    echo '页面不存在';
    exit();
}
$postDetail = get_post_detail($_GET['id']);

?>
<?php
$json = query("SELECT `value` FROM options WHERE `key` = 'nav_menus'");
// print_r($lists);
// exit;
//1. 导航完成
$lists = json_decode($json[0]['value'],true);
$sites[2]['value'] = $postDetail['title'];
?>
<?php include './inc/head.php'?>
<?php include './inc/aside.php'?>
    <div class="content">
      <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $postDetail['c_name']?></a></dd>
            <dd><?php echo $postDetail['title']?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $postDetail['title']?></a>
        </h2>
        <div class="meta">
          <span><?php echo $postDetail['nickname']?>发布于 <?php echo $postDetail['created']?></span>
          <span>分类: <a href="javascript:;"><?php echo $postDetail['c_name']?></a></span>
          <span>阅读: (<?php echo $postDetail['views']?>)</span>
          <span>评论: (<?php echo $postDetail['comments']?>)</span>
        </div>
          <div>
              <?php echo $postDetail['content']?>
          </div>
      </div>
        <div>
            <?php
            foreach (get_post_comment($_GET['id']) as $item) {
                echo $item['author'], $item['email'], $item['created'], $item['content'], '<br>';
            }
            ?>
        </div>
        <!-- 登录前的评论 -->
      <div class="comment">
        <h3 class="title" id="comments">
        <div class="text-muted pull-right">
        </div>
        <strong>评论 <b> 0 </b></strong>
        </h3>
        <div id="respond" class="no_webshot">
        <div class="comment-signarea">
        <h3 class="text-muted">评论前必须登录！</h3>
        <a class="btn btn-default" target="_blank" href="login.php">登陆</a>
        <a class="btn btn-default" target="_blank" href="register.php">注册</a>
        </div>
        </div>
      </div>
      <!-- 登录后的评论效果 -->
      <div class="comment">
        <h3 class="title" id="comments">
        <div class="text-muted pull-right">
        </div>
        <strong>评论 <b> 0 </b></strong>
        </h3>
        <div id="respond" class="no_webshot">
        <div class="comment-signarea">
        <textarea class="box-textarea" id="J_Textarea" placeholder="说两句吧..."></textarea>
        <input type="submit" class="" value="评论">
        </div>
        </div>    
      </div>
      <!-- 评论列表 -->
      <div class="comment">
        <strong>评论列表</strong>
            <div>
              <p>小红说：</p>
              <p>这条新闻不错</p>
            </div>    
      </div>
        <!-- 热门推荐 -->
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
    </div>
    <div class="footer">
      <p>© 2018 奇趣新闻网站 by花花</p>
    </div>
  </div>
</body>
</html>

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
    <div class="aside">
      <div class="widgets">
        <h4>搜索</h4>
        <div class="body search">
            <form action="/search.php">
                <input type="text" name="keyword" class="keys" placeholder="输入关键字">
                <input type="submit" class="btn" value="搜索">
            </form>
        </div>
      </div>
      <div class="widgets">
        <h4>随机推荐</h4>
        <ul class="body random">
          <li>
            <a href="javascript:;">
              <p class="title">废灯泡的14种玩法 妹子见了都会心动</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="uploads/widget_1.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">可爱卡通造型 iPhone 6防水手机套</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="uploads/widget_2.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">变废为宝！将手机旧电池变为充电宝的Better</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="uploads/widget_3.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">老外偷拍桂林芦笛岩洞 美如“地下彩虹”</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="uploads/widget_4.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">doge神烦狗打底南瓜裤 就是如此魔性</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="uploads/widget_5.jpg" alt="">
              </div>
            </a>
          </li>
        </ul>
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

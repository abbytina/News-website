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
  p.created,
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

  // 热门推荐内容
  // 热门排行 按点击数（阅读数）查询 
  $hot_contents = query("SELECT posts.id,posts.title,posts.category_id,posts.created,posts.content,posts.feature,posts.views,posts.slug,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id ORDER BY views DESC limit 0,3");
  // print_r($hot_contents);
  // exit;
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
          <!-- <span>评论: (<?php echo $postDetail['comments']?>)</span> -->
        </div>
          <div>
              <?php echo $postDetail['content']?>
          </div>
      </div>
      <!-- 评论区 -->
      <div class="qq_comment">
        <h3 class="com_title" id="comments">
        <strong>评论</strong>
        </h3>
        <div id="respond" class="qq_webshot">
          <textarea class="box_textarea" id="J_Textarea" placeholder="说两句吧..."></textarea>
          <input type="button" class="qq_cbtn " value="评论">
        </div>    
      </div>
      <!-- 评论列表 -->
      <div class="qq_comment">
        <h3 class="com_title" id="comments">
        <strong>评论列表</strong>
        </h3> 
       <?php foreach(get_post_comment($_GET['id']) as $item){ ?>
          <ul class="body com_lists">
          <li>
            <a href="javascript:;">
              <div class="com_img">
                        <!-- 判断头像 没有则给默认头像 -->
                <?php if(empty($_SESSION['user_info']['avatar'])) { ?>
                    <img class="avatar" src="/assets/img/animal.jpg">
                    <?php } else { ?>
                    <img class="avatar" src="<?php echo $_SESSION['user_info']['avatar']; ?>">
                <?php } ?>
              </div>
              <div class="com_txt">
                <p>
                  <span><?php echo $item['author']?></span>&nbsp;&nbsp; 在&nbsp;&nbsp;<span><?php echo $item['created']?></span>&nbsp;&nbsp;说:
                </p>
                <p><?php echo $item['content']?></p>
              </div>
            </a>
          </li>
          </ul>
        <?php }?>
      </div>
        <!-- 热门推荐 -->
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
        <?php foreach($hot_contents as $key =>$vals){ ?>
          <li>
            <a href="detail.php?id=<?php echo $vals['id'] ?>">
              <img src=<?php echo $vals['feature']?> alt="">
              <span><?php echo $vals['title']?></span>
            </a>
          </li>
        <?php }?>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2018 奇趣新闻网站 by花花</p>
    </div>
  </div>

<script src="./assets/vendors/jquery/jquery.min.js">  
</script>
<script>
  $(function() {
      var postId = '<?php echo $postDetail["id"]; ?>';
      
      $.get('/comment.php?action=index', {postId: postId}, function (res) {
          // console.log(res);
      });

      // 点击评论按钮的提交请求
      $(".qq_cbtn").click(function() {
          //获取Textarea的内容
          var dataStr  = $("#J_Textarea").val();
          console.log(dataStr);
          $.ajax({
              type:"POST",
              url:"/comment.php?action=add",
              dataType:"json",
              data:{postId: postId, content: dataStr},
              success:function(data){
                  // console.log(data);
                  // 判断状态
                  if(data.code == 0) {
                      alert(data.msg);
                      window.location.reload();
                  } else {
                      alert(data.msg);
                  }
              }
          });
      });
  })
</script>
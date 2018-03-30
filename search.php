<?php
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/30
 * Time: 21:44
 */
require_once 'functions.php';
if (!isset($_GET['keyword']) || empty($_GET['keyword'])) {
    exit("请输入关键字");
}
$keyword = $_GET['keyword'];
// $total = 106;// 当前数据库里面有106条数据
$total = query("SELECT count(*) AS total FROM posts WHERE title LIKE '%{$keyword}%'");
// print_r($total);
// exit;
$total = $total[0]['total'];

//每页显示7条数据
$pageSize = 9;

//计算出总的页数
$pageCount = ceil($total / $pageSize);

//获取当前页的编码
$pageCurrent = isset($_GET['page']) ? $_GET['page'] : '1';
// print_r($pageCount);
// exit;
//设置上一页
$prevPage = $pageCurrent - 1;

$prevPage = $prevPage < 1 ? 1 : $prevPage;
//设置下一页
$nextPage = $pageCurrent + 1;

$nextPage = $nextPage > $pageCount ? $pageCount : $nextPage;

//设置当前显示的每页的编码个数

$pageLimit = 7;  //1 2 3 4 5 6 7     5 6 7  8 9 10 11    19  20  21 22 23 24 25

//1 2 3 4 5 6 7 8 9           limit 0, 9,   (当前页-1)*$pageSize
//10 11 12 13 14 15 16 17 18        9, 9
//19 20 21 22 23 24 25 26 27        18,9

$start = $pageCurrent - floor($pageLimit / 2);
$start = $start < 1 ? 1 : $start;

$end = $start + $pageLimit - 1;

// $end = $end > $pageCount ?$pageCount :$end;
if ($end > $pageCount) {
    $end = $pageCount;
    $start = $end - $pageLimit + 1; // 开始页面要重新计算
}
// $pages =range(1,10);
// $pages =range(1,$pageCount);

$pages = range($start < 1 ? 1 : $start, $end);


//设置当前页面中显示数据的起始编号
$offset = ($pageCurrent - 1) * $pageSize;
// $lists = query('SELECT * FROM posts');
// $lists = query('SELECT * FROM posts LEFT JOIN users on posts.user_id = users.id LEFT JOIN categories on  posts.category_id = categories.id');
$sql = "SELECT posts.id,posts.title,posts.category_id,posts.created,
posts.status,users.nickname,categories.name FROM posts LEFT JOIN users on posts.user_id = users.id 
LEFT JOIN categories on posts.category_id = categories.id WHERE title LIKE '%{$keyword}%' LIMIT {$offset}, {$pageSize}";
$postLists = query($sql);

?>
<?php
$json = query("SELECT `value` FROM options WHERE `key` = 'nav_menus'");
// print_r($lists);
// exit;
//1. 导航完成
$lists = json_decode($json[0]['value'], true);
$sites[2]['value'] = $postDetail['title'];
?>
<?php include './inc/head.php' ?>
<ul class="pagination pagination-sm pull-right">
    <li><a href="/admin/posts.php?page=<?php echo $prevPage ?>">上一页</a></li>
    <?php foreach ($pages as $key => $val) { ?>
        <?php if ($pageCurrent == $val) { ?>
            <li class="active"><a href="/admin/posts.php?page=<?php echo $val ?>"><?php echo $val ?></a></li>
        <?php } else { ?>
            <li><a href="/admin/posts.php?page=<?php echo $val ?>"><?php echo $val ?></a></li>
        <?php } ?>
    <?php } ?>
    <li><a href="/admin/posts.php?page=<?php echo $nextPage ?>">下一页</a></li>
</ul>
<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="text-center" width="40">
            编号
        </th>
        <th>标题</th>
        <th>作者</th>
        <th>分类</th>
        <th class="text-center">发表时间</th>
        <th class="text-center">状态</th>
        <th class="text-center" width="100">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
    print_r($postLists);
    foreach ($postLists as $key => $vals) { ?>
        <tr>
            <td class="text-center">
                <?php echo $vals['id'] ?>
            </td>
            <td><?php echo $vals['title'] ?></td>
            <td><?php echo $vals['nickname'] ?></td>
            <?php if (empty($vals['name'])) { ?>
                <td>未分类</td>
            <?php } else { ?>
                <td><?php echo $vals['name'] ?></td>
            <?php } ?>
            <td class="text-center"><?php echo $vals['created'] ?></td>
            <?php if ($vals['status'] == 'published') { ?>
                <td class="text-center">已发布</td>
            <?php } else { ?>
                <td class="text-center">草稿</td>
            <?php } ?>
            <td class="text-center">
                <a href="/admin/post-add.php?action=edit&pid=<?php echo $vals['id'] ?>" class="btn btn-default btn-xs">编辑</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
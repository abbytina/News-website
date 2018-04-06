<?php
header('content-type:text/html;charset=utf-8');
/**
 * Created by PhpStorm.
 * User: ivoth
 * Date: 2018/3/30
 * Time: 22:29
 */
require_once 'functions.php';
require_once 'utils.php';

class Comment
{
    public static function index()
    {
        $postId = $_GET['postId'];
        if (empty($postId)) {
            return Utils::formatApi(1, '文章id不能为空');
        }
        $query = query("SELECT * FROM comments WHERE status = 'approved' AND post_id = {$postId}");
        return Utils::formatApi(0, 'ok', $query);
    }

    public static function add()
    {
        $postId = $_POST['postId'];
        $content = $_POST['content'];

        if (empty($content)) {
            return Utils::formatApi(1, '文章内容不能为空');
        }
        $userInfo = Utils::getUserInfo();
        $query = query("SELECT * FROM posts where id = {$postId}");
        if (empty($postId) || empty($query)) {
            return Utils::formatApi(1, '文章不存在');
        }
        $data = array(
            'author' => $userInfo['nickname'],
            'email' => $userInfo['email'],
            'created' => date('Y-m-d H:i:s'),
            'content' => $content,
            'status' => 'held',
            'post_id' => $postId,
        );
        if (!insert('comments', $data)) {
            return Utils::formatApi(1, '评论失败');
        }
        return Utils::formatApi(0, '评论成功');
    }

    public static function delete()
    {

    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
switch ($action) {
    case 'add':
        $res = Comment::add();
        break;
    default:
        $res = Comment::index();
}
header('Content-type: application/json');
echo $res;

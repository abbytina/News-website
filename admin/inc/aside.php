<?php
  error_reporting(0);
?>
<div class="aside">
<div class="profile">
  <img class="avatar" src="<?php echo $_SESSION['user_info']['avatar']?>">
  <h3 class="name"><?php echo $_SESSION['user_info']['nickname']?></h3>
</div>
<ul class="nav">
  <li <?php if($active == 'dashboard') { ?> class="active" <?php } ?>>
    <a href="index.php"><i class="fa fa-dashboard"></i>站点</a>
  </li>
  <li <?php if(in_array($active, $actives)) { ?> class="active" <?php } ?>>
    <a href="#menu-posts" class="collapsed" data-toggle="collapse">
      <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
    </a>
    <ul id="menu-posts" class="collapse <?php if(in_array($active, $actives)) { ?> in <?php } ?>">
      <li <?php if($active == 'posts') { ?> class="active" <?php } ?>>
        <a href="/admin/posts.php">所有文章</a>
      </li>
      <li <?php if($active == 'postadd') { ?> class="active" <?php } ?>>
        <a href="/admin/post-add.php">写文章</a>
        </li>
      <li <?php if($active == 'categories') { ?> class="active" <?php } ?>>
        <a href="/admin/categories.php">分类目录</a>
      </li>
    </ul>
  </li>
  <li <?php if($active == 'comments') { ?> class="active" <?php } ?>>
    <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
  </li>
  <li <?php if($active == 'users') { ?> class="active" <?php } ?>>
    <a href="users.php"><i class="fa fa-users"></i>用户</a>
  </li>
  <li <?php if(in_array($active, $cogs)) { ?> class="active" <?php } ?> >
    <a href="#menu-settings" class="collapsed" data-toggle="collapse">
      <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
    </a>
    <ul id="menu-settings" class="collapse <?php if(in_array($active, $cogs)) { ?> in <?php } ?>">
      <li <?php if($active == 'nav-menus') { ?> class="active" <?php } ?>>
        <a href="/admin/nav-menus.php">导航菜单</a>
      </li>
      <li <?php if($active == 'slides') { ?> class="active" <?php } ?>>
        <a href="/admin/slides.php">图片轮播</a>
      </li>
      <li <?php if($active == 'settings') { ?> class="active" <?php } ?>>
        <a href="/admin/settings.php">网站设置</a>
      </li>
    </ul>
  </li>
</ul>
</div>

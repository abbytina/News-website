<div class="aside">
<div class="profile">
  <img class="avatar" src="<?php echo $_SESSION['user_info']['avatar']?>">
  <h3 class="name"><?php echo $_SESSION['user_info']['nickname']?></h3>
</div>
<ul class="nav">
  <li class="zhan active">
    <a href="index.php"><i class="fa fa-dashboard"></i>站点</a>
  </li>
  <li class="">
    <a href="#menu-posts" class="collapsed" data-toggle="collapse">
      <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
    </a>
    <ul id="menu-posts" class="collapse">
      <li><a href="/admin/posts.php">所有文章</a></li>
      <li><a href="/admin/post-add.php">写文章</a></li>
      <li><a href="/admin/categories.php">分类目录</a></li>
    </ul>
  </li>
  <li class="">
    <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
  </li>
  <li>
    <a href="users.php"><i class="fa fa-users"></i>用户</a>
  </li>
  <li>
    <a href="#menu-settings" class="collapsed" data-toggle="collapse">
      <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
    </a>
    <ul id="menu-settings" class="collapse">
      <li><a href="/admin/nav-menus.php">导航菜单</a></li>
      <li><a href="/admin/slides.php">图片轮播</a></li>
      <li><a href="/admin/settings.php">网站设置</a></li>
    </ul>
  </li>
</ul>
</div>
<script>
    // var nav = document.getElementsByClassName("nav"); //获取滑动标签最外层元素
    // var zhan = document.getElementsByClassName("zhan"); // 站点
    // var olis = nav.getElementsByTagName("li"); //获取标签元素
    // // var odivs = box.getElementsByTagName("div"); //获取切换内容层元素
    // //构建循环，获取每一个标签
    // for(var i=0; i<olis.length; i++) {
    //     //给每一个标签设置一个序号属性
    //     olis[i].index = i;
    //     //给每一个标签绑定点击事件
    //     olis[i].onclick = function () {
    //         //清除所有标签样式
    //         for(var j=0; j<olis.length; j++) {
    //             olis[j].className="";
    //             odivs[j].className="";
    //         }
    //         //给当前点击的标签加上样式
    //         this.className="active";
    //         //给当前点击的标签序号对应的内容层加上样式
    //         odivs[this.index].className="active";
    //        }
    // }
</script>
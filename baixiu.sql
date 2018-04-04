/*
Navicat MySQL Data Transfer

Source Server         : YOYO
Source Server Version : 50524
Source Host           : 127.0.0.1:3306
Source Database       : baixiu

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-04-03 22:39:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `slug` varchar(200) NOT NULL COMMENT '别名',
  `name` varchar(200) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'travel', '爱旅行');
INSERT INTO `categories` VALUES ('2', 'tech', '看科技');
INSERT INTO `categories` VALUES ('3', 'funny', '新奇闻');
INSERT INTO `categories` VALUES ('4', 'living', '趣生活');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `author` varchar(100) NOT NULL COMMENT '作者',
  `email` varchar(200) NOT NULL COMMENT '邮箱',
  `created` datetime NOT NULL COMMENT '创建时间',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `status` varchar(20) NOT NULL COMMENT '状态（held/approved/rejected/trashed）',
  `post_id` int(11) NOT NULL COMMENT '文章 ID',
  `parent_id` int(11) DEFAULT NULL COMMENT '父级 ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '汪磊', 'w@zce.me', '2017-07-04 12:00:00', '这是一条测试评论，欢迎光临', 'approved', '1', null);
INSERT INTO `comments` VALUES ('2', '嘿嘿', 'ee@gmail.com', '2017-07-05 09:10:00', '想知道香港回归的惊人内幕吗？快快与我取得联系', 'rejected', '1', null);
INSERT INTO `comments` VALUES ('3', '小右', 'www@gmail.com', '2017-07-06 14:10:00', '你好啊，交个朋友好吗？', 'held', '1', null);
INSERT INTO `comments` VALUES ('4', '汪磊', 'www@gmail.com', '2017-07-09 22:22:00', '不好', 'held', '1', '3');
INSERT INTO `comments` VALUES ('5', '汪磊', 'w@zce.me', '2017-07-09 18:22:00', 'How are you?', 'held', '1', '3');
INSERT INTO `comments` VALUES ('6', '小右', 'www@gmail.com', '2017-07-11 22:22:00', 'I am fine thank you and you?', 'held', '1', '5');
INSERT INTO `comments` VALUES ('7', '哈哈', 'hh@gmail.com', '2017-07-22 09:10:00', '一针见血', 'approved', '1', null);

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `key` varchar(200) NOT NULL COMMENT '属性键',
  `value` text NOT NULL COMMENT '属性值',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('1', 'site_url', 'http://localhost');
INSERT INTO `options` VALUES ('2', 'site_logo', '');
INSERT INTO `options` VALUES ('3', 'site_name', '奇趣新闻');
INSERT INTO `options` VALUES ('4', 'site_description', '这里有趣的内容自然是要有趣的你来分享');
INSERT INTO `options` VALUES ('5', 'site_keywords', '生活，旅行，新闻');
INSERT INTO `options` VALUES ('6', 'site_footer', '<p>©  2018 奇趣新闻网站 by花花</p>');
INSERT INTO `options` VALUES ('7', 'comment_status', '1');
INSERT INTO `options` VALUES ('8', 'comment_reviewed', '1');
INSERT INTO `options` VALUES ('9', 'nav_menus', '{\"7\":{\"text\":\"趣生活\",\"title\":\"趣生活\",\"icon\":\"fa fa-fire\",\"link\":\"/living.php\"},\"8\":{\"text\":\"新奇闻\",\"title\":\"新奇闻\",\"icon\":\"fa fa-glass\",\"link\":\"/funny.php\"},\"9\":{\"text\":\"看科技\",\"title\":\"看科技\",\"icon\":\"fa fa-phone\",\"link\":\"/tech.php\"},\"10\":{\"text\":\"爱旅行\",\"title\":\"爱旅行\",\"icon\":\"fa fa-gift\",\"link\":\"/travel.php\"}}');
INSERT INTO `options` VALUES ('10', 'home_slides', '[{\"image\":\"/uploads/1521911059.jpg\",\"text\":\"圣诞节\",\"link\":\"\"},{\"image\":\"/uploads/1521911076.jpg\",\"text\":\"123\",\"link\":\"\"},{\"image\":\"/uploads/1521911089.jpg\",\"text\":\"456\",\"link\":\"\"},{\"image\":\"/uploads/1521911103.jpg\",\"text\":\"789\",\"link\":\"\"}]');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `slug` varchar(200) NOT NULL COMMENT '别名',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `feature` varchar(200) DEFAULT NULL COMMENT '特色图像',
  `created` datetime NOT NULL COMMENT '创建时间',
  `content` text COMMENT '内容',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  `likes` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `status` varchar(20) NOT NULL COMMENT '状态（drafted/published/trashed）',
  `user_id` int(11) NOT NULL COMMENT '用户 ID',
  `category_id` int(11) NOT NULL COMMENT '分类 ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', '趣生活', '今日头条科普大数据', '', '2018-02-02 01:58:00', '<p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: \">“2017 年网民最爱看的科普文章类型是健康与医疗，飙升最快的关键词是人工智能。”</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: \">3 月 29 日，今日头条联合中国科协科普部、中国科普研究所发布的《2017 网民科普阅读大数据》报告为我们揭露了科普文章传播的规律。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: \">报告显示，2017 年今日头条客户端上共有 2935 万篇科普类文章被阅读，阅读数为 2440 亿。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: \">报告通过分析2017年全年网民在今日头条上的阅读数据发现，男性和女性在科普信息阅读上的差异并不明显，而年龄在 30 岁以上的人群比 30 岁及以下的人群更喜欢看科普文章。不同区域的居民对科普类信息阅读也存在着差异，超一线城市科普渗透率最高。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: \">八大领域科普类文章中，健康与医疗最受读者关注，其次是信息技术类内容。</p><p><br/></p>', '25', '0', 'published', '1', '4');
INSERT INTO `posts` VALUES ('2', '生活', '眼皮老跳可能缺镁', '/uploads/1522687825.jpg', '2018-01-31 18:02:00', '<p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">眼皮老跳可能缺镁</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">天津第一中心医院营养科主任 谭桂军</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">生活中，许多人会有失眠、抑郁、厌食和疲惫等症状，这可能是因为身体缺镁。镁是人体必需矿物质之一，体内缺镁有7个信号。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">1.不能入睡。镁有助于提升大脑内一种名为伽马氨基丁酸（GABA）的神经递质水平，可促进放松和睡眠，利于缓解睡眠障碍。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">2.抑郁。镁能改善人体激素调节和大脑血清素水平，利于血糖平衡，大脑血清素对维持情绪稳定至关重要，所以缺镁更易抑郁、焦虑等。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">3.偏头痛。《欧洲神经科学研究杂志》一项研究发现，镁能有效降低偏头痛症状的严重程度和发生频度，这或与镁能调节激素、松弛肌肉有关。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">4.眼皮跳。镁缺乏症最常见表现之一就是眼皮跳。这是因为镁调节肌肉运动，若体内镁水平低，身体许多部位的肌肉就会发生痉挛和抽搐。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">5.心跳不规则。镁有助于保持正常心律。医生会通过静脉注射补镁，以减少房颤和心律失常发生，这是因为镁会使钙等营养物质水平下降。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">6.总是很累。镁是人体能源生产系统的必备要素，人体需要镁来生成三磷酸腺苷，用于产能。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">7.皮肤问题。镁可减少体内炎症，而体内发炎或导致痤疮、湿疹、牛皮癣等皮肤病。镁也能调节维生素D含量，是保持皮肤健康所必需的。</p><p style=\"margin-top: 0px; padding: 0px; border: 0px; color: rgb(51, 51, 51); line-height: 30px; text-align: justify; text-indent: 2em; font-family: &quot;Microsoft YaHei&quot;; white-space: normal;\">补充镁可以提高免疫力、心脏健康，并降低代谢综合征的风险。生活中，许多常见食物是我们补充镁的良好来源，包括绿叶蔬菜，如菠菜，坚果、糙米、面包（尤其是全麦）、鱼、肉、奶制品。▲</p><p><br/></p>', '21', '0', 'published', '1', '4');
INSERT INTO `posts` VALUES ('3', 'live', 'MYHGFD', '/uploads/1522688268.png', '2018-01-01 23:59:00', '<p>RBHJGHGJHGHHHHHHHHHHHHHHHHHHHHHHHHHHCCCCCCCCCCCCCCCCCCCBVXFFFFFFF<br/></p>', '33', '0', 'published', '1', '4');
INSERT INTO `posts` VALUES ('4', '奇闻', '黑洞吞噬物质，讲究“细嚼慢咽”', '/uploads/1522690734.jpg', '2018-03-01 00:00:00', '<p style=\"margin-top: 10px; margin-bottom: 10px; font-family: &quot;Microsoft YaHei&quot;, SimHei; font-size: 18px; line-height: 2.2em; text-indent: 2em; white-space: normal; background-color: rgb(250, 254, 249);\">几乎每个星系中心都存在一个超大质量黑洞。最新研究发现，这些黑洞在吞噬周围物质时，心急吃不了热豆腐，因为如果吞噬物质速度太快，有可能反而将这些物质推开。中科院南美天文中心博士后克劳迪奥·里奇（Claudio&nbsp;Ricci）团队的这项发现，发表在近日出版的《自然》杂志上。</p><p style=\"margin-top: 10px; margin-bottom: 10px; font-family: &quot;Microsoft YaHei&quot;, SimHei; font-size: 18px; line-height: 2.2em; text-indent: 2em; white-space: normal; background-color: rgb(250, 254, 249);\">黑洞本身不发光，但有些黑洞会“吃掉”周边的物质，发出大量电磁辐射。绝大部分明亮的黑洞周围有大量尘埃和气体，并分布成“甜甜圈”的形状，以保证黑洞有充足的食物，从而不断发光并逐渐长大。然而，科学家并不清楚这些物质的分布，以及尘埃气体与辐射之间的关系。</p><p><br/></p>', '13', '0', 'published', '1', '3');
INSERT INTO `posts` VALUES ('5', '科技', '王者荣耀百里守约新皮肤特工魅影', '/uploads/1522729979.jpg', '2018-01-01 00:00:00', '<p style=\"margin-top: 25px; margin-bottom: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background: rgb(255, 255, 255); text-align: justify; color: rgb(51, 51, 51); font-family: \">王者荣耀联合《魂斗罗：归来》首发：百里守约史诗皮肤——特工魅影登场。恶魔魅影隐匿而行，恶魔能量包裹的子弹将给予敌人出其不意的致命打击！作为近期在KPL春季赛上的热门英雄，百里守约小哥哥的这款新皮肤，您有什么理由错过呢？</p><p><br/></p>', '21', '0', 'published', '1', '2');
INSERT INTO `posts` VALUES ('18', '旅行', '三门峡', '/uploads/1522751174.jpg', '2018-01-01 08:02:00', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: 宋体; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">　受地坑院景区带动，春节假日期间，陕州各类宾馆酒店客房平均入住率达到93%以上，城区星级宾馆、商务酒店在春节前就早已预订一空。浅水湾、金浪温泉、御海温泉、天鹅温泉等中小型温泉酒店以及温塘村家庭温泉旅馆也宾客爆满，累计接待游客超过4.6万人次，餐饮、住宿、娱乐等综合收入1000余万元。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: 宋体; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">　　陕州区旅游局局长王丽娟表示，早在几年前，这里还是另一番景象。作为传统的农业种植乡镇，隶属于河南省三门峡市的陕州区经济发展相对滞后。在城镇化过程中，不少地坑院荒废，捶草印花、以黑色为主的剪纸、板腔音乐锣鼓书……传统民间技艺一度濒临失传。</p><p><br/></p>', '18', '0', 'published', '1', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `slug` varchar(200) NOT NULL COMMENT '别名',
  `email` varchar(200) NOT NULL COMMENT '邮箱',
  `password` varchar(200) NOT NULL COMMENT '密码',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(200) DEFAULT NULL COMMENT '头像',
  `bio` varchar(500) DEFAULT NULL COMMENT '简介',
  `status` varchar(20) NOT NULL COMMENT '状态（unactivated/activated/forbidden/trashed）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '11', '11@11.com', '111', '11', '/uploads/1521387798.jpg', '11111111', 'activated');
INSERT INTO `users` VALUES ('2', 'qq', '23@qq.com', '23', 'qq', '/uploads/1522386155.jpg', 'qq123', 'activated');
INSERT INTO `users` VALUES ('3', '33', '33@qq.com', '33', '33', null, '33333', 'unactivated');

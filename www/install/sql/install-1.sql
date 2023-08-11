/*
Navicat MariaDB Data Transfer

Source Server         : localhost
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : install_v5

Target Server Type    : MariaDB
Target Server Version : 100130
File Encoding         : 65001

Date: 2018-04-22 19:20:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wz_admin
-- ----------------------------
DROP TABLE IF EXISTS `wz_admin`;
CREATE TABLE `wz_admin` (
  `uid` int(10) unsigned NOT NULL,
  `role` varchar(200) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `factor` varchar(6) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `department` varchar(30) NOT NULL,
  `face` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `atwork` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 在位，0请假中',
  `teamleader` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 组长，2副组长',
  `offline` varchar(10) NOT NULL DEFAULT 'offline',
  `sign` varchar(255) NOT NULL COMMENT '签名',
  `qf_priv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '签发权限',
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for wz_admin_onlinetime
-- ----------------------------
DROP TABLE IF EXISTS `wz_admin_onlinetime`;
CREATE TABLE `wz_admin_onlinetime` (
  `uid` int(10) unsigned NOT NULL,
  `dayid` int(10) unsigned NOT NULL,
  `onlinetimes` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '在线时间',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`uid`,`dayid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员在线时长统计';

-- ----------------------------
-- Records of wz_admin_onlinetime
-- ----------------------------

-- ----------------------------
-- Table structure for wz_admin_private
-- ----------------------------
DROP TABLE IF EXISTS `wz_admin_private`;
CREATE TABLE `wz_admin_private` (
  `id` smallint(5) unsigned NOT NULL,
  `role` smallint(5) unsigned NOT NULL,
  `chk` tinyint(1) NOT NULL,
  `keyid` char(16) NOT NULL,
  UNIQUE KEY `id` (`id`,`role`),
  KEY `keyid` (`keyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员权限表';

-- ----------------------------
-- Records of wz_admin_private
-- ----------------------------

-- ----------------------------
-- Table structure for wz_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `wz_admin_role`;
CREATE TABLE `wz_admin_role` (
  `role` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) NOT NULL COMMENT '角色名',
  `remark` varchar(500) NOT NULL,
  PRIMARY KEY (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of wz_admin_role
-- ----------------------------
INSERT INTO `wz_admin_role` VALUES ('1', '超级管理员', '拥有所有权限');
INSERT INTO `wz_admin_role` VALUES ('2', '网站编辑', '');
INSERT INTO `wz_admin_role` VALUES ('3', '信息发布员', '');

-- ----------------------------
-- Table structure for wz_affiche
-- ----------------------------
DROP TABLE IF EXISTS `wz_affiche`;
CREATE TABLE `wz_affiche` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL COMMENT '标题',
  `css` varchar(30) NOT NULL,
  `publisher` varchar(20) NOT NULL COMMENT '发布人',
  `content` text NOT NULL COMMENT '公告内容',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1，会员中心，2 全站公告，3 后台公告',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统公告';

-- ----------------------------
-- Records of wz_affiche
-- ----------------------------

-- ----------------------------
-- Table structure for wz_attachment
-- ----------------------------
DROP TABLE IF EXISTS `wz_attachment`;
CREATE TABLE `wz_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '文件名',
  `md5file` varchar(32) NOT NULL,
  `addtime` int(10) unsigned NOT NULL COMMENT '上传时间',
  `filesize` int(10) unsigned NOT NULL COMMENT '文件大小',
  `ip` varchar(15) NOT NULL COMMENT '上传者ip',
  `path` varchar(100) NOT NULL COMMENT '文件路径',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传用户id',
  `username` varchar(20) NOT NULL,
  `usertimes` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '文件使用次数',
  `tags` varchar(100) NOT NULL COMMENT '图片tags分类',
  `userkeys` varchar(11) NOT NULL COMMENT '当前上传标识',
  `isimage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为图片',
  `diycat` varchar(20) NOT NULL COMMENT '自定义目录',
  PRIMARY KEY (`id`),
  KEY `usertimes` (`usertimes`) USING BTREE,
  KEY `md5file` (`md5file`),
  KEY `username` (`username`),
  KEY `id` (`id`,`userkeys`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='附件记录表';

-- ----------------------------
-- Records of wz_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for wz_attachment_tags
-- ----------------------------
DROP TABLE IF EXISTS `wz_attachment_tags`;
CREATE TABLE `wz_attachment_tags` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL COMMENT 'tag名称',
  `usertimes` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '使用次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_attachment_tags
-- ----------------------------

-- ----------------------------
-- Table structure for wz_attachment_tag_index
-- ----------------------------
DROP TABLE IF EXISTS `wz_attachment_tag_index`;
CREATE TABLE `wz_attachment_tag_index` (
  `tag_id` mediumint(8) unsigned NOT NULL COMMENT '标签tags id',
  `att_id` mediumint(8) unsigned NOT NULL COMMENT '附件id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签id->附件id映射表,一个附件id对应多个标签id,但多个标签id不重复';

-- ----------------------------
-- Records of wz_attachment_tag_index
-- ----------------------------

-- ----------------------------
-- Table structure for wz_atwork
-- ----------------------------
DROP TABLE IF EXISTS `wz_atwork`;
CREATE TABLE `wz_atwork` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `remark` text NOT NULL COMMENT '请假说明',
  `uid` int(10) unsigned NOT NULL COMMENT '请假人uid',
  `admin_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_username` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 回收站，9正常',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_atwork
-- ----------------------------

-- ----------------------------
-- Table structure for wz_badword
-- ----------------------------
DROP TABLE IF EXISTS `wz_badword`;
CREATE TABLE `wz_badword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` char(12) NOT NULL,
  `addtime` int(10) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`)
) ENGINE=InnoDB AUTO_INCREMENT=1507 DEFAULT CHARSET=utf8 COMMENT='非法词语表';

-- ----------------------------
-- Records of wz_badword
-- ----------------------------
INSERT INTO `wz_badword` VALUES ('1', '气枪弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('2', '伪麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('3', '银行卡生成器', '0', '0');
INSERT INTO `wz_badword` VALUES ('4', '皇冠平台', '0', '0');
INSERT INTO `wz_badword` VALUES ('5', '威龙国际网', '0', '0');
INSERT INTO `wz_badword` VALUES ('6', '明升娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('7', '永利高现金网', '0', '0');
INSERT INTO `wz_badword` VALUES ('8', '新博彩通', '0', '0');
INSERT INTO `wz_badword` VALUES ('9', '智尊国际', '0', '0');
INSERT INTO `wz_badword` VALUES ('10', '新濠博亚娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('11', '迈巴赫娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('12', '瑞丰国际', '0', '0');
INSERT INTO `wz_badword` VALUES ('13', '壹贰博', '0', '0');
INSERT INTO `wz_badword` VALUES ('14', '送码图', '0', '0');
INSERT INTO `wz_badword` VALUES ('15', '玄机诗', '0', '0');
INSERT INTO `wz_badword` VALUES ('16', '送码诗', '0', '0');
INSERT INTO `wz_badword` VALUES ('17', '必中特码', '0', '0');
INSERT INTO `wz_badword` VALUES ('18', '特码诗', '0', '0');
INSERT INTO `wz_badword` VALUES ('19', '冠军娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('20', '一代国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('21', '蓝盾娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('22', '百胜娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('23', '瑞博娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('24', '线上21点', '0', '0');
INSERT INTO `wz_badword` VALUES ('25', '百姓娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('26', '美式轮盘', '0', '0');
INSERT INTO `wz_badword` VALUES ('27', '兄弟娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('28', '利赢娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('29', '回力娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('30', '布加迪娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('31', '鸿利会娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('32', '金宝博娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('33', '华盛顿娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('34', '百老汇娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('35', '扑克王娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('36', '必赢亚洲娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('37', '新世纪娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('38', '大富豪娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('39', '天空娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('40', '多伦多娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('41', '博天堂娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('42', '专业报仇网', '0', '0');
INSERT INTO `wz_badword` VALUES ('43', '汽车门锁干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('44', '土炸药配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('45', 'DIY原子弹教程', '0', '0');
INSERT INTO `wz_badword` VALUES ('46', '火药配方大全', '0', '0');
INSERT INTO `wz_badword` VALUES ('47', '五狐狩猎网', '0', '0');
INSERT INTO `wz_badword` VALUES ('48', '土炸弹制作流程', '0', '0');
INSERT INTO `wz_badword` VALUES ('49', '夜来香社区', '0', '0');
INSERT INTO `wz_badword` VALUES ('50', '苍老师的超时空双飞之旅', '0', '0');
INSERT INTO `wz_badword` VALUES ('51', '仙童下地狱', '0', '0');
INSERT INTO `wz_badword` VALUES ('52', '妈妈的乱欲故事', '0', '0');
INSERT INTO `wz_badword` VALUES ('53', '哪里有援交妹', '0', '0');
INSERT INTO `wz_badword` VALUES ('54', '黄色歌曲', '0', '0');
INSERT INTO `wz_badword` VALUES ('55', '医院里的淫虐盛宴', '0', '0');
INSERT INTO `wz_badword` VALUES ('56', '与家人一起淫乱的日子', '0', '0');
INSERT INTO `wz_badword` VALUES ('57', '少女之心', '0', '0');
INSERT INTO `wz_badword` VALUES ('58', '警用电击器', '0', '0');
INSERT INTO `wz_badword` VALUES ('59', '兼职妹妹', '0', '0');
INSERT INTO `wz_badword` VALUES ('60', 'USB电视棒成人版', '0', '0');
INSERT INTO `wz_badword` VALUES ('61', '一字锁强开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('62', '办理', '0', '0');
INSERT INTO `wz_badword` VALUES ('63', '士兵证', '0', '0');
INSERT INTO `wz_badword` VALUES ('64', '居民户口本', '0', '0');
INSERT INTO `wz_badword` VALUES ('65', '高仿证', '0', '0');
INSERT INTO `wz_badword` VALUES ('66', '警察证', '0', '0');
INSERT INTO `wz_badword` VALUES ('67', '身份证', '0', '0');
INSERT INTO `wz_badword` VALUES ('68', '军人证', '0', '0');
INSERT INTO `wz_badword` VALUES ('69', '金木棉赌场', '0', '0');
INSERT INTO `wz_badword` VALUES ('70', '皇冠在线赌场', '0', '0');
INSERT INTO `wz_badword` VALUES ('71', '世界名刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('72', '甲基苯丙胺合成方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('73', '米尔军刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('74', '投注', '0', '0');
INSERT INTO `wz_badword` VALUES ('75', 'X8改号神器', '0', '0');
INSERT INTO `wz_badword` VALUES ('76', '任意显示手机去电号码', '0', '0');
INSERT INTO `wz_badword` VALUES ('77', '下载', '0', '0');
INSERT INTO `wz_badword` VALUES ('78', '售', '0', '0');
INSERT INTO `wz_badword` VALUES ('79', '刀迷汇', '0', '0');
INSERT INTO `wz_badword` VALUES ('80', '百兵行刀具网', '0', '0');
INSERT INTO `wz_badword` VALUES ('81', '中国刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('82', '百兵坊', '0', '0');
INSERT INTO `wz_badword` VALUES ('83', '弓弩狩猎网', '0', '0');
INSERT INTO `wz_badword` VALUES ('84', '不凡军品网', '0', '0');
INSERT INTO `wz_badword` VALUES ('85', '西点军品网', '0', '0');
INSERT INTO `wz_badword` VALUES ('86', '127名刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('87', '阳江刀剑网', '0', '0');
INSERT INTO `wz_badword` VALUES ('88', '户外刀具网', '0', '0');
INSERT INTO `wz_badword` VALUES ('89', '不凡军品', '0', '0');
INSERT INTO `wz_badword` VALUES ('90', '好刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('91', '名刀阁', '0', '0');
INSERT INTO `wz_badword` VALUES ('92', '太恩炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('93', '掌心雷', '0', '0');
INSERT INTO `wz_badword` VALUES ('94', '塑胶炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('95', '起爆药', '0', '0');
INSERT INTO `wz_badword` VALUES ('96', '汽车遥控信号屏蔽器', '0', '0');
INSERT INTO `wz_badword` VALUES ('97', '一字开锁工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('98', '减震吹', '0', '0');
INSERT INTO `wz_badword` VALUES ('99', '空气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('100', '购买', '0', '0');
INSERT INTO `wz_badword` VALUES ('101', '手机定位监听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('102', '卧底窃听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('103', 'GSM监听设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('104', '物流成单数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('105', '电购资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('106', '转让', '0', '0');
INSERT INTO `wz_badword` VALUES ('107', '求购', '0', '0');
INSERT INTO `wz_badword` VALUES ('108', '金融客户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('109', '股民开户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('110', '警用催泪剂', '0', '0');
INSERT INTO `wz_badword` VALUES ('111', '警服肩章', '0', '0');
INSERT INTO `wz_badword` VALUES ('112', 'PCP汽狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('113', '汽狗图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('114', '仿真64', '0', '0');
INSERT INTO `wz_badword` VALUES ('115', '54手狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('116', '气狗子弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('117', '侧拉式气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('118', '汽枪图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('119', '折叠气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('120', '汽步狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('121', '峨眉气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('122', '气皇', '0', '0');
INSERT INTO `wz_badword` VALUES ('123', '消音器', '0', '0');
INSERT INTO `wz_badword` VALUES ('124', 'CO2狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('125', 'PCP狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('126', '世纪打猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('127', '猎友之家打猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('128', '飘红户外狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('129', '华夏狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('130', '预订', '0', '0');
INSERT INTO `wz_badword` VALUES ('131', '液体炸药配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('132', '炸弹DIY', '0', '0');
INSERT INTO `wz_badword` VALUES ('133', '液体炸药比例', '0', '0');
INSERT INTO `wz_badword` VALUES ('134', '我的性启蒙老师', '0', '0');
INSERT INTO `wz_badword` VALUES ('135', '星光伴我淫', '0', '0');
INSERT INTO `wz_badword` VALUES ('136', '色中色论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('137', '现代艳帝传奇', '0', '0');
INSERT INTO `wz_badword` VALUES ('138', '天龙八部淫传', '0', '0');
INSERT INTO `wz_badword` VALUES ('139', '淫妻俱乐部', '0', '0');
INSERT INTO `wz_badword` VALUES ('140', '成人电子书&#160;', '0', '0');
INSERT INTO `wz_badword` VALUES ('141', '午夜爽片', '0', '0');
INSERT INTO `wz_badword` VALUES ('142', '恋足电影', '0', '0');
INSERT INTO `wz_badword` VALUES ('143', '母子乱伦', '0', '0');
INSERT INTO `wz_badword` VALUES ('144', '色中色影院', '0', '0');
INSERT INTO `wz_badword` VALUES ('145', '倚天屠龙别记', '0', '0');
INSERT INTO `wz_badword` VALUES ('146', '十景缎', '0', '0');
INSERT INTO `wz_badword` VALUES ('147', '内射', '0', '0');
INSERT INTO `wz_badword` VALUES ('148', '群交', '0', '0');
INSERT INTO `wz_badword` VALUES ('149', '兽交', '0', '0');
INSERT INTO `wz_badword` VALUES ('150', '自慰', '0', '0');
INSERT INTO `wz_badword` VALUES ('151', '性交', '0', '0');
INSERT INTO `wz_badword` VALUES ('152', '提供', '0', '0');
INSERT INTO `wz_badword` VALUES ('153', '肛交', '0', '0');
INSERT INTO `wz_badword` VALUES ('154', '催情药', '0', '0');
INSERT INTO `wz_badword` VALUES ('155', '迷幻药', '0', '0');
INSERT INTO `wz_badword` VALUES ('156', '催情液', '0', '0');
INSERT INTO `wz_badword` VALUES ('157', '催情粉', '0', '0');
INSERT INTO `wz_badword` VALUES ('158', '催情水', '0', '0');
INSERT INTO `wz_badword` VALUES ('159', '迷情水', '0', '0');
INSERT INTO `wz_badword` VALUES ('160', '妓女', '0', '0');
INSERT INTO `wz_badword` VALUES ('161', '楼凤性息', '0', '0');
INSERT INTO `wz_badword` VALUES ('162', '学生鸡', '0', '0');
INSERT INTO `wz_badword` VALUES ('163', '女优种子', '0', '0');
INSERT INTO `wz_badword` VALUES ('164', 'AV', '0', '0');
INSERT INTO `wz_badword` VALUES ('165', '脾脏', '0', '0');
INSERT INTO `wz_badword` VALUES ('166', '卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('167', '供应', '0', '0');
INSERT INTO `wz_badword` VALUES ('168', '试用', '0', '0');
INSERT INTO `wz_badword` VALUES ('169', '出租', '0', '0');
INSERT INTO `wz_badword` VALUES ('170', '批发', '0', '0');
INSERT INTO `wz_badword` VALUES ('171', '订购', '0', '0');
INSERT INTO `wz_badword` VALUES ('172', '直销', '0', '0');
INSERT INTO `wz_badword` VALUES ('173', '出售', '0', '0');
INSERT INTO `wz_badword` VALUES ('174', '枪弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('175', '气弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('176', '弓弩专卖网', '0', '0');
INSERT INTO `wz_badword` VALUES ('177', '冰妹陪玩', '0', '0');
INSERT INTO `wz_badword` VALUES ('178', '去甲麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('179', '季戊四醇', '0', '0');
INSERT INTO `wz_badword` VALUES ('180', '麻古制作技术', '0', '0');
INSERT INTO `wz_badword` VALUES ('181', '氯胺酮制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('182', '磁条数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('183', '信用卡复制器', '0', '0');
INSERT INTO `wz_badword` VALUES ('184', '自制烟花', '0', '0');
INSERT INTO `wz_badword` VALUES ('185', '礼花弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('186', '正规真票', '0', '0');
INSERT INTO `wz_badword` VALUES ('187', 'fa票', '0', '0');
INSERT INTO `wz_badword` VALUES ('188', '开瞟', '0', '0');
INSERT INTO `wz_badword` VALUES ('189', '铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('190', '电狗网', '0', '0');
INSERT INTO `wz_badword` VALUES ('191', '激情视频聊天室', '0', '0');
INSERT INTO `wz_badword` VALUES ('192', '全国性息大全', '0', '0');
INSERT INTO `wz_badword` VALUES ('193', '逃亡艳旅', '0', '0');
INSERT INTO `wz_badword` VALUES ('194', '江湖淫娘传', '0', '0');
INSERT INTO `wz_badword` VALUES ('195', '金麟岂是池中物', '0', '0');
INSERT INTO `wz_badword` VALUES ('196', '焚天愤天淫魔阴魔', '0', '0');
INSERT INTO `wz_badword` VALUES ('197', '真人棋牌', '0', '0');
INSERT INTO `wz_badword` VALUES ('198', '银行卡克隆设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('199', '办假身份证件', '0', '0');
INSERT INTO `wz_badword` VALUES ('200', '真实民办学历', '0', '0');
INSERT INTO `wz_badword` VALUES ('201', '高仿证件网', '0', '0');
INSERT INTO `wz_badword` VALUES ('202', '大发娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('203', '百乐坊', '0', '0');
INSERT INTO `wz_badword` VALUES ('204', 'bwin亚洲', '0', '0');
INSERT INTO `wz_badword` VALUES ('205', 'bet365', '0', '0');
INSERT INTO `wz_badword` VALUES ('206', '金宝博', '0', '0');
INSERT INTO `wz_badword` VALUES ('207', '真人二八杠', '0', '0');
INSERT INTO `wz_badword` VALUES ('208', '现金龙虎斗', '0', '0');
INSERT INTO `wz_badword` VALUES ('209', '鸿利国际', '0', '0');
INSERT INTO `wz_badword` VALUES ('210', '六合彩内参', '0', '0');
INSERT INTO `wz_badword` VALUES ('211', '三优娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('212', '女神国际', '0', '0');
INSERT INTO `wz_badword` VALUES ('213', '亿博娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('214', '老挝蓝盾娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('215', '易胜博博彩', '0', '0');
INSERT INTO `wz_badword` VALUES ('216', '卡迪拉娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('217', '百家乐开户', '0', '0');
INSERT INTO `wz_badword` VALUES ('218', '皇冠现金网', '0', '0');
INSERT INTO `wz_badword` VALUES ('219', '博狗亚洲', '0', '0');
INSERT INTO `wz_badword` VALUES ('220', '骰宝', '0', '0');
INSERT INTO `wz_badword` VALUES ('221', '现金棋牌游戏', '0', '0');
INSERT INTO `wz_badword` VALUES ('222', '心脏', '0', '0');
INSERT INTO `wz_badword` VALUES ('223', '胰腺', '0', '0');
INSERT INTO `wz_badword` VALUES ('224', '硅胶人皮', '0', '0');
INSERT INTO `wz_badword` VALUES ('225', '钢珠弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('226', '甩刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('227', '三棱刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('228', '尼泊尔刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('229', '尼泊尔狗腿刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('230', '斩马刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('231', '骨髓', '0', '0');
INSERT INTO `wz_badword` VALUES ('232', '英语等级证', '0', '0');
INSERT INTO `wz_badword` VALUES ('233', '磁道内码信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('234', '勃郎宁刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('235', '假言正', '0', '0');
INSERT INTO `wz_badword` VALUES ('236', '四六级证书', '0', '0');
INSERT INTO `wz_badword` VALUES ('237', '毕业证书', '0', '0');
INSERT INTO `wz_badword` VALUES ('238', '会计师证', '0', '0');
INSERT INTO `wz_badword` VALUES ('239', '资质证书', '0', '0');
INSERT INTO `wz_badword` VALUES ('240', '人皮面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('241', '报仇网', '0', '0');
INSERT INTO `wz_badword` VALUES ('242', '四六级考中答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('243', '手机监听定位软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('244', '手机远程卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('245', '手机偷听器软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('246', '手机X卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('247', '手机监控软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('248', '十字快开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('249', '十字开锁工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('250', '自考考前答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('251', '汽车遥控信号解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('252', '汽车遥控信号干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('253', '汽车遥控电子干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('254', '锡纸快开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('255', '电子开锁器', '0', '0');
INSERT INTO `wz_badword` VALUES ('256', '反屏蔽考试作弊设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('257', '防屏蔽耳机', '0', '0');
INSERT INTO `wz_badword` VALUES ('258', '安卓手机卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('259', '手机卧底监听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('260', '汽车中控干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('261', '潜伏者手机监听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('262', '汽车中控拦截器', '0', '0');
INSERT INTO `wz_badword` VALUES ('263', '电动开锁器', '0', '0');
INSERT INTO `wz_badword` VALUES ('264', '手机偷听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('265', '一字强开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('266', '警用肩章', '0', '0');
INSERT INTO `wz_badword` VALUES ('267', '警察肩章', '0', '0');
INSERT INTO `wz_badword` VALUES ('268', '高仿警察证', '0', '0');
INSERT INTO `wz_badword` VALUES ('269', '银行客户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('270', '仿制警服', '0', '0');
INSERT INTO `wz_badword` VALUES ('271', '小区业主名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('272', '小区住户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('273', '警用标志', '0', '0');
INSERT INTO `wz_badword` VALUES ('274', '警用安全指示牌', '0', '0');
INSERT INTO `wz_badword` VALUES ('275', '车主信息资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('276', '警用催泪弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('277', '考生数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('278', '高考考生资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('279', '帮人复仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('280', '找杀手公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('281', '报仇公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('282', '杀手网', '0', '0');
INSERT INTO `wz_badword` VALUES ('283', '打手网', '0', '0');
INSERT INTO `wz_badword` VALUES ('284', '打火机吹', '0', '0');
INSERT INTO `wz_badword` VALUES ('285', '吹尘diy', '0', '0');
INSERT INTO `wz_badword` VALUES ('286', '成人版电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('287', '成人高考考前答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('288', 'jia币', '0', '0');
INSERT INTO `wz_badword` VALUES ('289', '假rmb', '0', '0');
INSERT INTO `wz_badword` VALUES ('290', '快开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('291', '锡纸万能开锁', '0', '0');
INSERT INTO `wz_badword` VALUES ('292', '万能钥匙', '0', '0');
INSERT INTO `wz_badword` VALUES ('293', '万能开锁器', '0', '0');
INSERT INTO `wz_badword` VALUES ('294', '万能开琐工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('295', '强开工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('296', '万能开锁工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('297', '开锁器', '0', '0');
INSERT INTO `wz_badword` VALUES ('298', '汽车遥控解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('299', '汽车信号屏蔽器', '0', '0');
INSERT INTO `wz_badword` VALUES ('300', '汽车信号解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('301', '偷听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('302', '监听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('303', '汽车遥控拦截器', '0', '0');
INSERT INTO `wz_badword` VALUES ('304', '汽车钥匙解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('305', '汽车解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('306', '汽车干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('307', '汽车拦截器', '0', '0');
INSERT INTO `wz_badword` VALUES ('308', '手机007间谍软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('309', '监听器软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('310', '手机GSM监听设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('311', '手机监听设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('312', '警用电击棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('313', '高压警棍', '0', '0');
INSERT INTO `wz_badword` VALUES ('314', '警察徽章', '0', '0');
INSERT INTO `wz_badword` VALUES ('315', '警用手铐', '0', '0');
INSERT INTO `wz_badword` VALUES ('316', '警用电棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('317', '高仿警官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('318', '金融客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('319', '电视购物资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('320', '保险客户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('321', '小区业主名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('322', '汽狗配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('323', '美秃套件', '0', '0');
INSERT INTO `wz_badword` VALUES ('324', '金钟气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('325', '金钟汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('326', '五四式手狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('327', '54式手木仓', '0', '0');
INSERT INTO `wz_badword` VALUES ('328', '64式手木仓', '0', '0');
INSERT INTO `wz_badword` VALUES ('329', '64式气木仓', '0', '0');
INSERT INTO `wz_badword` VALUES ('330', '92式手木仓', '0', '0');
INSERT INTO `wz_badword` VALUES ('331', '东方狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('332', '联盟狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('333', '三角牌气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('334', '汽狗狗粮', '0', '0');
INSERT INTO `wz_badword` VALUES ('335', '七七式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('336', '工字气qiang', '0', '0');
INSERT INTO `wz_badword` VALUES ('337', '高压鸟枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('338', '狗管', '0', '0');
INSERT INTO `wz_badword` VALUES ('339', '仿真汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('340', '峨眉牌汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('341', '老妖狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('342', '上海工字气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('343', '气狗狗粮', '0', '0');
INSERT INTO `wz_badword` VALUES ('344', '气枪枪管', '0', '0');
INSERT INTO `wz_badword` VALUES ('345', '钢珠猎狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('346', '工字汽狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('347', '锡锋牌气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('348', '骚本套件', '0', '0');
INSERT INTO `wz_badword` VALUES ('349', '气枪瞄准镜', '0', '0');
INSERT INTO `wz_badword` VALUES ('350', '汽狗铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('351', '气枪子弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('352', '猎枪铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('353', '汽枪配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('354', '秃鹰套件', '0', '0');
INSERT INTO `wz_badword` VALUES ('355', '汽枪铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('356', '枪支配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('357', '五四式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('358', '军用枪支', '0', '0');
INSERT INTO `wz_badword` VALUES ('359', '钢珠弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('360', '德版PPK', '0', '0');
INSERT INTO `wz_badword` VALUES ('361', '温切斯特气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('362', '手拉狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('363', '上海工字汽狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('364', '1比1仿真枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('365', '三箭汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('366', '上海工字牌气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('367', '三箭气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('368', '仿真气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('369', '猎狗铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('370', '仿真气木仓', '0', '0');
INSERT INTO `wz_badword` VALUES ('371', '锡锋汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('372', '三箭汽狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('373', '单管猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('374', '猎枪配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('375', '汽枪消声器', '0', '0');
INSERT INTO `wz_badword` VALUES ('376', '雷鸣登猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('377', '雷鸣登汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('378', '三箭气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('379', '手狗配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('380', '金属枪模', '0', '0');
INSERT INTO `wz_badword` VALUES ('381', '金属仿真枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('382', '高压步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('383', '自制手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('384', '高压打鸟枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('385', '一比一枪模', '0', '0');
INSERT INTO `wz_badword` VALUES ('386', '气狗配件', '0', '0');
INSERT INTO `wz_badword` VALUES ('387', '秃鹰汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('388', '健卫步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('389', '汽短狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('390', '土制猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('391', '狙击狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('392', '汽长狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('393', '台秃', '0', '0');
INSERT INTO `wz_badword` VALUES ('394', '左轮手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('395', '45MM铅弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('396', '45MM狗粮', '0', '0');
INSERT INTO `wz_badword` VALUES ('397', '92式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('398', '654k手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('399', '77式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('400', '654K气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('401', '77式手狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('402', '54式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('403', '92式手狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('404', '钢珠狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('405', 'pcp气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('406', 'pcp汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('407', 'CFX气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('408', '小姐威客网', '0', '0');
INSERT INTO `wz_badword` VALUES ('409', '丝袜恋足会所', '0', '0');
INSERT INTO `wz_badword` VALUES ('410', '楼凤信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('411', '兼职小姐', '0', '0');
INSERT INTO `wz_badword` VALUES ('412', '淫淫网', '0', '0');
INSERT INTO `wz_badword` VALUES ('413', '就去射', '0', '0');
INSERT INTO `wz_badword` VALUES ('414', 'AV网址', '0', '0');
INSERT INTO `wz_badword` VALUES ('415', '性息平台', '0', '0');
INSERT INTO `wz_badword` VALUES ('416', '国产A片下载', '0', '0');
INSERT INTO `wz_badword` VALUES ('417', '无码成人影院', '0', '0');
INSERT INTO `wz_badword` VALUES ('418', '激情少妇', '0', '0');
INSERT INTO `wz_badword` VALUES ('419', '援交会所', '0', '0');
INSERT INTO `wz_badword` VALUES ('420', '亚洲色站', '0', '0');
INSERT INTO `wz_badword` VALUES ('421', '午夜成人电影', '0', '0');
INSERT INTO `wz_badword` VALUES ('422', '性爱电影', '0', '0');
INSERT INTO `wz_badword` VALUES ('423', '裸聊', '0', '0');
INSERT INTO `wz_badword` VALUES ('424', '淫图', '0', '0');
INSERT INTO `wz_badword` VALUES ('425', '寂寞少妇', '0', '0');
INSERT INTO `wz_badword` VALUES ('426', '清纯学生妹', '0', '0');
INSERT INTO `wz_badword` VALUES ('427', '菀式服务', '0', '0');
INSERT INTO `wz_badword` VALUES ('428', '丝袜美女', '0', '0');
INSERT INTO `wz_badword` VALUES ('429', '毛片网址', '0', '0');
INSERT INTO `wz_badword` VALUES ('430', '三级片地址', '0', '0');
INSERT INTO `wz_badword` VALUES ('431', '丐帮情色论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('432', '少妇白洁', '0', '0');
INSERT INTO `wz_badword` VALUES ('433', '枪刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('434', '巴克折刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('435', '买卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('436', '零售', '0', '0');
INSERT INTO `wz_badword` VALUES ('437', '贩卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('438', '配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('439', '制作', '0', '0');
INSERT INTO `wz_badword` VALUES ('440', '氯化银钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('441', '安乐死药物', '0', '0');
INSERT INTO `wz_badword` VALUES ('442', '敌恶磷', '0', '0');
INSERT INTO `wz_badword` VALUES ('443', '敌杀磷', '0', '0');
INSERT INTO `wz_badword` VALUES ('444', '黄曲霉素', '0', '0');
INSERT INTO `wz_badword` VALUES ('445', '冰毒技术', '0', '0');
INSERT INTO `wz_badword` VALUES ('446', '海洛因制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('447', '甲基苯丙胺制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('448', '咖啡碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('449', '缅古制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('450', '麦角酸提炼技术', '0', '0');
INSERT INTO `wz_badword` VALUES ('451', '缅古配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('452', '缅古制作技术', '0', '0');
INSERT INTO `wz_badword` VALUES ('453', '脱氧麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('454', '摇头丸制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('455', '罂粟碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('456', '麻古配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('457', '朝鲜冰', '0', '0');
INSERT INTO `wz_badword` VALUES ('458', '甲基乙基酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('459', '古可叶', '0', '0');
INSERT INTO `wz_badword` VALUES ('460', '苯基甲酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('461', '异黄樟素', '0', '0');
INSERT INTO `wz_badword` VALUES ('462', '黄樟油', '0', '0');
INSERT INTO `wz_badword` VALUES ('463', '冰毒提炼教程', '0', '0');
INSERT INTO `wz_badword` VALUES ('464', '身份证号生成器', '0', '0');
INSERT INTO `wz_badword` VALUES ('465', '麻醉箭弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('466', '三利达追月', '0', '0');
INSERT INTO `wz_badword` VALUES ('467', '军用弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('468', '三利达大黑鹰', '0', '0');
INSERT INTO `wz_badword` VALUES ('469', '猎弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('470', '上海工字气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('471', '骚本气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('472', '汽枪专卖网', '0', '0');
INSERT INTO `wz_badword` VALUES ('473', '54式图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('474', '枪械制造方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('475', '手枪见面交易', '0', '0');
INSERT INTO `wz_badword` VALUES ('476', '天朝狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('477', '钢珠汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('478', 'TNT炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('479', '遥控炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('480', '土炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('481', '鱼雷', '0', '0');
INSERT INTO `wz_badword` VALUES ('482', '定时炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('483', '导火索', '0', '0');
INSERT INTO `wz_badword` VALUES ('484', '电子炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('485', '土制火药', '0', '0');
INSERT INTO `wz_badword` VALUES ('486', 'C4橡胶炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('487', '自制炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('488', '土制燃烧弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('489', '自制炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('490', '工业雷管', '0', '0');
INSERT INTO `wz_badword` VALUES ('491', '军用雷管', '0', '0');
INSERT INTO `wz_badword` VALUES ('492', '高爆炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('493', '液体炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('494', '爆破剂', '0', '0');
INSERT INTO `wz_badword` VALUES ('495', '手机改号软件破解版', '0', '0');
INSERT INTO `wz_badword` VALUES ('496', '任意改号软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('497', '91电影网', '0', '0');
INSERT INTO `wz_badword` VALUES ('498', '怡红电影网', '0', '0');
INSERT INTO `wz_badword` VALUES ('499', '办', '0', '0');
INSERT INTO `wz_badword` VALUES ('500', '删帖', '0', '0');
INSERT INTO `wz_badword` VALUES ('501', '投注娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('502', '洗码返水', '0', '0');
INSERT INTO `wz_badword` VALUES ('503', '大三元', '0', '0');
INSERT INTO `wz_badword` VALUES ('504', '慢性毒药', '0', '0');
INSERT INTO `wz_badword` VALUES ('505', '安乐死毒药', '0', '0');
INSERT INTO `wz_badword` VALUES ('506', '溴氰菊酯', '0', '0');
INSERT INTO `wz_badword` VALUES ('507', '致癌慢性毒药', '0', '0');
INSERT INTO `wz_badword` VALUES ('508', '百治磷', '0', '0');
INSERT INTO `wz_badword` VALUES ('509', '二甲基硫代磷酰氯', '0', '0');
INSERT INTO `wz_badword` VALUES ('510', '甲基丙烯腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('511', '二乙基硫代磷酰氯', '0', '0');
INSERT INTO `wz_badword` VALUES ('512', '无水肼', '0', '0');
INSERT INTO `wz_badword` VALUES ('513', '士的宁', '0', '0');
INSERT INTO `wz_badword` VALUES ('514', '绿藜芦生物碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('515', '氮芥气', '0', '0');
INSERT INTO `wz_badword` VALUES ('516', '琥珀胆碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('517', '敌百虫', '0', '0');
INSERT INTO `wz_badword` VALUES ('518', '羟基乙腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('519', '毒鼠强', '0', '0');
INSERT INTO `wz_badword` VALUES ('520', '毒药', '0', '0');
INSERT INTO `wz_badword` VALUES ('521', '氟醋酸钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('522', '液氯', '0', '0');
INSERT INTO `wz_badword` VALUES ('523', '氯化硫酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('524', '过氯甲硫醇', '0', '0');
INSERT INTO `wz_badword` VALUES ('525', '氯化硫酰甲烷', '0', '0');
INSERT INTO `wz_badword` VALUES ('526', '光气', '0', '0');
INSERT INTO `wz_badword` VALUES ('527', '三氯硫氯甲烷', '0', '0');
INSERT INTO `wz_badword` VALUES ('528', '氯气', '0', '0');
INSERT INTO `wz_badword` VALUES ('529', '甲基磺酰氟', '0', '0');
INSERT INTO `wz_badword` VALUES ('530', '四氯硫代碳酰', '0', '0');
INSERT INTO `wz_badword` VALUES ('531', '甲烷磺酰氯', '0', '0');
INSERT INTO `wz_badword` VALUES ('532', '氯硫酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('533', '甲磺酰氟', '0', '0');
INSERT INTO `wz_badword` VALUES ('534', '胡椒基甲酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('535', 'GHB水', '0', '0');
INSERT INTO `wz_badword` VALUES ('536', 'LSD迷幻药', '0', '0');
INSERT INTO `wz_badword` VALUES ('537', '左旋麻黃素', '0', '0');
INSERT INTO `wz_badword` VALUES ('538', '麻黃素', '0', '0');
INSERT INTO `wz_badword` VALUES ('539', '左旋麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('540', '鸦片', '0', '0');
INSERT INTO `wz_badword` VALUES ('541', '甲基安非他命', '0', '0');
INSERT INTO `wz_badword` VALUES ('542', '盐酸羟亚胺&#160;', '0', '0');
INSERT INTO `wz_badword` VALUES ('543', '麦角胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('544', '麦角酸二乙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('545', '去氧麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('546', '天然可卡因', '0', '0');
INSERT INTO `wz_badword` VALUES ('547', '摇头丸配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('548', '氯胺酮制作配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('549', 'k粉制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('550', 'FM2', '0', '0');
INSERT INTO `wz_badword` VALUES ('551', 'k粉制作技术', '0', '0');
INSERT INTO `wz_badword` VALUES ('552', '麻古制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('553', '新千秋狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('554', '中华打猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('555', '中华狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('556', '中国汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('557', '诚信汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('558', '52名刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('559', '销售', '0', '0');
INSERT INTO `wz_badword` VALUES ('560', '高压汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('561', '子弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('562', '三棱军刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('563', '三箭牌汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('564', '瓦斯手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('565', '秃鹰气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('566', '提炼', '0', '0');
INSERT INTO `wz_badword` VALUES ('567', '直供', '0', '0');
INSERT INTO `wz_badword` VALUES ('568', '左轮枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('569', '左轮手狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('570', '仿真长狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('571', '成人影视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('572', '万能钥匙开锁器', '0', '0');
INSERT INTO `wz_badword` VALUES ('573', '秃鹰汽长狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('574', '精品弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('575', '弩弓制作图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('576', '弓弩麻醉箭', '0', '0');
INSERT INTO `wz_badword` VALUES ('577', '三健弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('578', '黑森林弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('579', '代办', '0', '0');
INSERT INTO `wz_badword` VALUES ('580', '棋牌真钱游戏', '0', '0');
INSERT INTO `wz_badword` VALUES ('581', '21点真钱游戏', '0', '0');
INSERT INTO `wz_badword` VALUES ('582', '车主保险数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('583', '银行客户名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('584', '高考学生资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('585', '老板资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('586', '小区业主资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('587', '小区业主信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('588', '企业老板资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('589', '警用电棍', '0', '0');
INSERT INTO `wz_badword` VALUES ('590', '秃鹰狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('591', '千秋狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('592', '气枪免定金', '0', '0');
INSERT INTO `wz_badword` VALUES ('593', '亚洲打猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('594', '兄弟打猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('595', '秃鹰组装教程', '0', '0');
INSERT INTO `wz_badword` VALUES ('596', '大漠狩猎论坛', '0', '0');
INSERT INTO `wz_badword` VALUES ('597', '打鸟汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('598', '聚色网', '0', '0');
INSERT INTO `wz_badword` VALUES ('599', '狼客娱乐网', '0', '0');
INSERT INTO `wz_badword` VALUES ('600', '钢珠汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('601', '汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('602', '网络电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('603', '草榴社区', '0', '0');
INSERT INTO `wz_badword` VALUES ('604', '黄金城娱乐场', '0', '0');
INSERT INTO `wz_badword` VALUES ('605', '蓝盾国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('606', '真钱轮盘赌博', '0', '0');
INSERT INTO `wz_badword` VALUES ('607', '蒙特卡罗娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('608', '新葡京娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('609', '盈丰国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('610', '大赢家真人娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('611', 'bet365娱乐场', '0', '0');
INSERT INTO `wz_badword` VALUES ('612', '乐九娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('613', '战神国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('614', '圣淘沙娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('615', '百家乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('616', '轮盘', '0', '0');
INSERT INTO `wz_badword` VALUES ('617', '赌球', '0', '0');
INSERT INTO `wz_badword` VALUES ('618', '最新银行卡复制器', '0', '0');
INSERT INTO `wz_badword` VALUES ('619', '假结婚证', '0', '0');
INSERT INTO `wz_badword` VALUES ('620', '军官证样本', '0', '0');
INSERT INTO `wz_badword` VALUES ('621', '假文凭', '0', '0');
INSERT INTO `wz_badword` VALUES ('622', '高仿身份证', '0', '0');
INSERT INTO `wz_badword` VALUES ('623', '假身份证', '0', '0');
INSERT INTO `wz_badword` VALUES ('624', '假户口本', '0', '0');
INSERT INTO `wz_badword` VALUES ('625', '高仿户口本', '0', '0');
INSERT INTO `wz_badword` VALUES ('626', '假军官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('627', '高仿学位证', '0', '0');
INSERT INTO `wz_badword` VALUES ('628', '高仿人民币', '0', '0');
INSERT INTO `wz_badword` VALUES ('629', '森林之虎', '0', '0');
INSERT INTO `wz_badword` VALUES ('630', '十字弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('631', '蝴蝶刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('632', '阿昌刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('633', '户撒刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('634', '自制K粉教程', '0', '0');
INSERT INTO `wz_badword` VALUES ('635', '甲苯喹唑酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('636', '邻氨基苯甲酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('637', '麻果配方', '0', '0');
INSERT INTO `wz_badword` VALUES ('638', '相思红娘粉', '0', '0');
INSERT INTO `wz_badword` VALUES ('639', '云南情蛊', '0', '0');
INSERT INTO `wz_badword` VALUES ('640', '亚甲二氧基甲基苯丙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('641', '代删', '0', '0');
INSERT INTO `wz_badword` VALUES ('642', '身份证复印件制作器', '0', '0');
INSERT INTO `wz_badword` VALUES ('643', '身份证复印件模板', '0', '0');
INSERT INTO `wz_badword` VALUES ('644', '红9娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('645', '91娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('646', '必胜国际', '0', '0');
INSERT INTO `wz_badword` VALUES ('647', '老钱庄娱乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('648', '皇朝娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('649', '金海岸娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('650', '一码中特', '0', '0');
INSERT INTO `wz_badword` VALUES ('651', '六合玄机', '0', '0');
INSERT INTO `wz_badword` VALUES ('652', '冰毒的制作方法', '0', '0');
INSERT INTO `wz_badword` VALUES ('653', '毕业文凭', '0', '0');
INSERT INTO `wz_badword` VALUES ('654', '红樱桃催情液', '0', '0');
INSERT INTO `wz_badword` VALUES ('655', '汽车电子干扰器', '0', '0');
INSERT INTO `wz_badword` VALUES ('656', '假警官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('657', '高仿军官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('658', '秃鹰汽枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('659', '汽车电子解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('660', '真钱百家乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('661', '金盛国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('662', '永利高娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('663', '在线现金扑克', '0', '0');
INSERT INTO `wz_badword` VALUES ('664', '百乐坊娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('665', '菲律宾太阳城', '0', '0');
INSERT INTO `wz_badword` VALUES ('666', '凯撒皇宫娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('667', '金沙娱乐场', '0', '0');
INSERT INTO `wz_badword` VALUES ('668', '百丽宫娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('669', '嘉禾娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('670', '美高梅娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('671', '金木棉娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('672', '永利娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('673', '金沙娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('674', 'E世博娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('675', '身份证号码生成器', '0', '0');
INSERT INTO `wz_badword` VALUES ('676', '身份证复印件生成器', '0', '0');
INSERT INTO `wz_badword` VALUES ('677', '假币', '0', '0');
INSERT INTO `wz_badword` VALUES ('678', '假钞', '0', '0');
INSERT INTO `wz_badword` VALUES ('679', '森林之狼', '0', '0');
INSERT INTO `wz_badword` VALUES ('680', '小飞狼', '0', '0');
INSERT INTO `wz_badword` VALUES ('681', '森林之鹰', '0', '0');
INSERT INTO `wz_badword` VALUES ('682', '蝴蝶甩刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('683', '卡巴刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('684', '直刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('685', '蜘蛛刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('686', '苗刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('687', '三棱刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('688', '博伊刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('689', '廓尔喀刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('690', '人造芥子油', '0', '0');
INSERT INTO `wz_badword` VALUES ('691', '苯环利定', '0', '0');
INSERT INTO `wz_badword` VALUES ('692', '硝甲西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('693', '植物冰', '0', '0');
INSERT INTO `wz_badword` VALUES ('694', '唛可奈因', '0', '0');
INSERT INTO `wz_badword` VALUES ('695', '恩华三唑仑', '0', '0');
INSERT INTO `wz_badword` VALUES ('696', '美沙酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('697', '迷幻蘑菇', '0', '0');
INSERT INTO `wz_badword` VALUES ('698', 'k粉', '0', '0');
INSERT INTO `wz_badword` VALUES ('699', '黄牙签', '0', '0');
INSERT INTO `wz_badword` VALUES ('700', '二代身份证制作软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('701', '国外文凭', '0', '0');
INSERT INTO `wz_badword` VALUES ('702', '假证件', '0', '0');
INSERT INTO `wz_badword` VALUES ('703', '学历证书', '0', '0');
INSERT INTO `wz_badword` VALUES ('704', '土制手雷', '0', '0');
INSERT INTO `wz_badword` VALUES ('705', '土制手榴弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('706', '土制炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('707', '男性数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('708', '进口气狗', '0', '0');
INSERT INTO `wz_badword` VALUES ('709', '渔夫吹图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('710', '快排吹教程', '0', '0');
INSERT INTO `wz_badword` VALUES ('711', 'diy吹尘', '0', '0');
INSERT INTO `wz_badword` VALUES ('712', '丛林刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('713', '狗腿刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('714', '巴克刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('715', '安纳咖', '0', '0');
INSERT INTO `wz_badword` VALUES ('716', '摇头丸', '0', '0');
INSERT INTO `wz_badword` VALUES ('717', '丁丙诺啡', '0', '0');
INSERT INTO `wz_badword` VALUES ('718', '氟硝安定', '0', '0');
INSERT INTO `wz_badword` VALUES ('719', '出台', '0', '0');
INSERT INTO `wz_badword` VALUES ('720', '肉文', '0', '0');
INSERT INTO `wz_badword` VALUES ('721', '快排吹图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('722', '土铳', '0', '0');
INSERT INTO `wz_badword` VALUES ('723', '进口汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('724', '国产气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('725', '钢珠枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('726', '沙漠之鹰', '0', '0');
INSERT INTO `wz_badword` VALUES ('727', '老人资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('728', '学生资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('729', '学生数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('730', '删帖公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('731', '二代身份证生成器', '0', '0');
INSERT INTO `wz_badword` VALUES ('732', '普通增值税发票', '0', '0');
INSERT INTO `wz_badword` VALUES ('733', '机打发票', '0', '0');
INSERT INTO `wz_badword` VALUES ('734', '假车牌', '0', '0');
INSERT INTO `wz_badword` VALUES ('735', '军车套牌', '0', '0');
INSERT INTO `wz_badword` VALUES ('736', '麻醉弩箭', '0', '0');
INSERT INTO `wz_badword` VALUES ('737', '三利达', '0', '0');
INSERT INTO `wz_badword` VALUES ('738', '大黑鹰', '0', '0');
INSERT INTO `wz_badword` VALUES ('739', '麻古', '0', '0');
INSERT INTO `wz_badword` VALUES ('740', '亚甲二氧甲基苯丙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('741', '氯胺酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('742', '缅果', '0', '0');
INSERT INTO `wz_badword` VALUES ('743', '三唑仑', '0', '0');
INSERT INTO `wz_badword` VALUES ('744', '甲基苯丙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('745', '沙菲片', '0', '0');
INSERT INTO `wz_badword` VALUES ('746', '福寿膏', '0', '0');
INSERT INTO `wz_badword` VALUES ('747', '倍它洛尔', '0', '0');
INSERT INTO `wz_badword` VALUES ('748', '苯丙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('749', '安眠酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('750', '安钠咖', '0', '0');
INSERT INTO `wz_badword` VALUES ('751', '香料精灵', '0', '0');
INSERT INTO `wz_badword` VALUES ('752', '曲马多', '0', '0');
INSERT INTO `wz_badword` VALUES ('753', '大麻烟', '0', '0');
INSERT INTO `wz_badword` VALUES ('754', 'GHB原液', '0', '0');
INSERT INTO `wz_badword` VALUES ('755', '勃朗宁刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('756', '潜水刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('757', '廓尔喀弯刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('758', '丛林直刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('759', '开山刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('760', '三棱跳刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('761', '弹簧跳刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('762', '西布曲明', '0', '0');
INSERT INTO `wz_badword` VALUES ('763', '援交', '0', '0');
INSERT INTO `wz_badword` VALUES ('764', 'AV种子', '0', '0');
INSERT INTO `wz_badword` VALUES ('765', '色狼集中营', '0', '0');
INSERT INTO `wz_badword` VALUES ('766', '肉漫', '0', '0');
INSERT INTO `wz_badword` VALUES ('767', '上门援交', '0', '0');
INSERT INTO `wz_badword` VALUES ('768', '上门服务', '0', '0');
INSERT INTO `wz_badword` VALUES ('769', '哪里有小姐', '0', '0');
INSERT INTO `wz_badword` VALUES ('770', '业主数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('771', '快递面单资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('772', '快递面单数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('773', '保健品数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('774', '电视购物数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('775', '股民数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('776', '老人数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('777', 'PCP枪管膛线', '0', '0');
INSERT INTO `wz_badword` VALUES ('778', '秃鹰扳机', '0', '0');
INSERT INTO `wz_badword` VALUES ('779', '铅弹母鸡', '0', '0');
INSERT INTO `wz_badword` VALUES ('780', '豪门国际俱乐部', '0', '0');
INSERT INTO `wz_badword` VALUES ('781', '天成国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('782', '华尔街娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('783', '天猫娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('784', '大中华娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('785', '嘉年华娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('786', '米其林娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('787', '喜力国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('788', '五湖四海娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('789', '澳博国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('790', '半岛国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('791', '金牌娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('792', '凯旋门娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('793', '永辉国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('794', '太阳城百家乐', '0', '0');
INSERT INTO `wz_badword` VALUES ('795', '万达国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('796', '鼎丰国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('797', '帝王娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('798', '宝龙娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('799', '皇冠娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('800', '太阳城', '0', '0');
INSERT INTO `wz_badword` VALUES ('801', '澳门星际赌场', '0', '0');
INSERT INTO `wz_badword` VALUES ('802', '威龙国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('803', '帝豪国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('804', '鼎龙国际娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('805', '百家乐平台', '0', '0');
INSERT INTO `wz_badword` VALUES ('806', '仿真硅胶面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('807', '甲基甲卡西酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('808', '甲氧麻黄酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('809', '身份证制作软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('810', '身份证复印件生成软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('811', '身份证号码生成软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('812', '曾道人特码', '0', '0');
INSERT INTO `wz_badword` VALUES ('813', '乐透', '0', '0');
INSERT INTO `wz_badword` VALUES ('814', '德州扑克', '0', '0');
INSERT INTO `wz_badword` VALUES ('815', '扎金花', '0', '0');
INSERT INTO `wz_badword` VALUES ('816', '梭哈', '0', '0');
INSERT INTO `wz_badword` VALUES ('817', '棋牌', '0', '0');
INSERT INTO `wz_badword` VALUES ('818', '赌马', '0', '0');
INSERT INTO `wz_badword` VALUES ('819', '特码', '0', '0');
INSERT INTO `wz_badword` VALUES ('820', '斗地主', '0', '0');
INSERT INTO `wz_badword` VALUES ('821', '娱乐城', '0', '0');
INSERT INTO `wz_badword` VALUES ('822', '彩金', '0', '0');
INSERT INTO `wz_badword` VALUES ('823', '博彩', '0', '0');
INSERT INTO `wz_badword` VALUES ('824', '六合彩', '0', '0');
INSERT INTO `wz_badword` VALUES ('825', '见面交易', '0', '0');
INSERT INTO `wz_badword` VALUES ('826', '货到付款', '0', '0');
INSERT INTO `wz_badword` VALUES ('827', '克隆', '0', '0');
INSERT INTO `wz_badword` VALUES ('828', '办证', '0', '0');
INSERT INTO `wz_badword` VALUES ('829', '注册', '0', '0');
INSERT INTO `wz_badword` VALUES ('830', '开户', '0', '0');
INSERT INTO `wz_badword` VALUES ('831', '下注', '0', '0');
INSERT INTO `wz_badword` VALUES ('832', '开奖', '0', '0');
INSERT INTO `wz_badword` VALUES ('833', '身份证模板', '0', '0');
INSERT INTO `wz_badword` VALUES ('834', '3d轮盘', '0', '0');
INSERT INTO `wz_badword` VALUES ('835', '八肖中特', '0', '0');
INSERT INTO `wz_badword` VALUES ('836', '盘口高额返水', '0', '0');
INSERT INTO `wz_badword` VALUES ('837', '抱养', '0', '0');
INSERT INTO `wz_badword` VALUES ('838', '女宝', '0', '0');
INSERT INTO `wz_badword` VALUES ('839', '女童', '0', '0');
INSERT INTO `wz_badword` VALUES ('840', '男童', '0', '0');
INSERT INTO `wz_badword` VALUES ('841', '宝宝', '0', '0');
INSERT INTO `wz_badword` VALUES ('842', '幼童', '0', '0');
INSERT INTO `wz_badword` VALUES ('843', '男婴', '0', '0');
INSERT INTO `wz_badword` VALUES ('844', '孩子', '0', '0');
INSERT INTO `wz_badword` VALUES ('845', '婴儿', '0', '0');
INSERT INTO `wz_badword` VALUES ('846', '认养', '0', '0');
INSERT INTO `wz_badword` VALUES ('847', '收养', '0', '0');
INSERT INTO `wz_badword` VALUES ('848', '领养', '0', '0');
INSERT INTO `wz_badword` VALUES ('849', '送养', '0', '0');
INSERT INTO `wz_badword` VALUES ('850', '男宝', '0', '0');
INSERT INTO `wz_badword` VALUES ('851', '女婴', '0', '0');
INSERT INTO `wz_badword` VALUES ('852', '证件制作网', '0', '0');
INSERT INTO `wz_badword` VALUES ('853', '刻章办证公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('854', '专业办证公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('855', '文凭代办网', '0', '0');
INSERT INTO `wz_badword` VALUES ('856', '办证工作室', '0', '0');
INSERT INTO `wz_badword` VALUES ('857', '办证公司网', '0', '0');
INSERT INTO `wz_badword` VALUES ('858', '办证刻章公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('859', '办证服务公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('860', '证件网', '0', '0');
INSERT INTO `wz_badword` VALUES ('861', '办证刻章', '0', '0');
INSERT INTO `wz_badword` VALUES ('862', '办证网', '0', '0');
INSERT INTO `wz_badword` VALUES ('863', '英语替考', '0', '0');
INSERT INTO `wz_badword` VALUES ('864', '四六级替考', '0', '0');
INSERT INTO `wz_badword` VALUES ('865', '四六级助考', '0', '0');
INSERT INTO `wz_badword` VALUES ('866', '替考网站', '0', '0');
INSERT INTO `wz_badword` VALUES ('867', '枪手网站', '0', '0');
INSERT INTO `wz_badword` VALUES ('868', '枪手替考', '0', '0');
INSERT INTO `wz_badword` VALUES ('869', 'GFX面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('870', '飞叶子', '0', '0');
INSERT INTO `wz_badword` VALUES ('871', '纯缅麻古', '0', '0');
INSERT INTO `wz_badword` VALUES ('872', '黄冰', '0', '0');
INSERT INTO `wz_badword` VALUES ('873', '帮人报仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('874', '钻石冰', '0', '0');
INSERT INTO `wz_badword` VALUES ('875', '职业报仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('876', '专业报仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('877', '替人了仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('878', '帮人出气', '0', '0');
INSERT INTO `wz_badword` VALUES ('879', '找职业杀手', '0', '0');
INSERT INTO `wz_badword` VALUES ('880', '替人消灾', '0', '0');
INSERT INTO `wz_badword` VALUES ('881', '替人追债', '0', '0');
INSERT INTO `wz_badword` VALUES ('882', '替人出气', '0', '0');
INSERT INTO `wz_badword` VALUES ('883', '买凶杀人', '0', '0');
INSERT INTO `wz_badword` VALUES ('884', '替人复仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('885', '雇人复仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('886', '提供打手', '0', '0');
INSERT INTO `wz_badword` VALUES ('887', '替人报仇', '0', '0');
INSERT INTO `wz_badword` VALUES ('888', '替人报仇网', '0', '0');
INSERT INTO `wz_badword` VALUES ('889', '找人报仇网', '0', '0');
INSERT INTO `wz_badword` VALUES ('890', '雇打手网', '0', '0');
INSERT INTO `wz_badword` VALUES ('891', '特洛伊卧底软件官方网', '0', '0');
INSERT INTO `wz_badword` VALUES ('892', '帮人复仇网', '0', '0');
INSERT INTO `wz_badword` VALUES ('893', '手机监听官网', '0', '0');
INSERT INTO `wz_badword` VALUES ('894', '专业删帖机构', '0', '0');
INSERT INTO `wz_badword` VALUES ('895', 'x手机卧底软件官网', '0', '0');
INSERT INTO `wz_badword` VALUES ('896', '网络删贴公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('897', '弩弓官网', '0', '0');
INSERT INTO `wz_badword` VALUES ('898', '三利达官网', '0', '0');
INSERT INTO `wz_badword` VALUES ('899', '弓弩网', '0', '0');
INSERT INTO `wz_badword` VALUES ('900', '军刀网', '0', '0');
INSERT INTO `wz_badword` VALUES ('901', '代办发票公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('902', '代理发票公司', '0', '0');
INSERT INTO `wz_badword` VALUES ('903', '户外军品网', '0', '0');
INSERT INTO `wz_badword` VALUES ('904', '发嘌', '0', '0');
INSERT INTO `wz_badword` VALUES ('905', '发缥', '0', '0');
INSERT INTO `wz_badword` VALUES ('906', '发剽', '0', '0');
INSERT INTO `wz_badword` VALUES ('907', '莫洛托夫鸡尾酒', '0', '0');
INSERT INTO `wz_badword` VALUES ('908', '红烧兔子大餐', '0', '0');
INSERT INTO `wz_badword` VALUES ('909', '发漂', '0', '0');
INSERT INTO `wz_badword` VALUES ('910', '无政府主义者食谱', '0', '0');
INSERT INTO `wz_badword` VALUES ('911', '改火套件', '0', '0');
INSERT INTO `wz_badword` VALUES ('912', '3d打印枪支图纸', '0', '0');
INSERT INTO `wz_badword` VALUES ('913', '枪模网', '0', '0');
INSERT INTO `wz_badword` VALUES ('914', 'PCP气枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('915', '小六改火', '0', '0');
INSERT INTO `wz_badword` VALUES ('916', '仿真枪械网', '0', '0');
INSERT INTO `wz_badword` VALUES ('917', '猎枪销售网', '0', '0');
INSERT INTO `wz_badword` VALUES ('918', '气枪专卖网', '0', '0');
INSERT INTO `wz_badword` VALUES ('919', '进口气枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('920', '气狗专卖网', '0', '0');
INSERT INTO `wz_badword` VALUES ('921', '猎枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('922', '工字气枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('923', '三箭气枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('924', '气枪网', '0', '0');
INSERT INTO `wz_badword` VALUES ('925', '护照', '0', '0');
INSERT INTO `wz_badword` VALUES ('926', '车辆牌照', '0', '0');
INSERT INTO `wz_badword` VALUES ('927', '公文', '0', '0');
INSERT INTO `wz_badword` VALUES ('928', '国安证', '0', '0');
INSERT INTO `wz_badword` VALUES ('929', '行驶证', '0', '0');
INSERT INTO `wz_badword` VALUES ('930', '驾照', '0', '0');
INSERT INTO `wz_badword` VALUES ('931', '证件', '0', '0');
INSERT INTO `wz_badword` VALUES ('932', '工作证', '0', '0');
INSERT INTO `wz_badword` VALUES ('933', '记者证', '0', '0');
INSERT INTO `wz_badword` VALUES ('934', '言正', '0', '0');
INSERT INTO `wz_badword` VALUES ('935', '驾驶证', '0', '0');
INSERT INTO `wz_badword` VALUES ('936', '军官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('937', '户口本', '0', '0');
INSERT INTO `wz_badword` VALUES ('938', '甲基磺酰氯', '0', '0');
INSERT INTO `wz_badword` VALUES ('939', '马拉硫磷', '0', '0');
INSERT INTO `wz_badword` VALUES ('940', '警官证', '0', '0');
INSERT INTO `wz_badword` VALUES ('941', '氰化钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('942', '山奈', '0', '0');
INSERT INTO `wz_badword` VALUES ('943', '氰化钙', '0', '0');
INSERT INTO `wz_badword` VALUES ('944', '氰化钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('945', '砷化氢', '0', '0');
INSERT INTO `wz_badword` VALUES ('946', '硝酸汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('947', '亚砷酸钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('948', '三氧化二砷', '0', '0');
INSERT INTO `wz_badword` VALUES ('949', '亚砷酸钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('950', '乙酸亚铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('951', '重铬酸钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('952', '氧化铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('953', '四氧化锇', '0', '0');
INSERT INTO `wz_badword` VALUES ('954', '丙二酸铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('955', '乙硼烷', '0', '0');
INSERT INTO `wz_badword` VALUES ('956', '六氟丙酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('957', '三氟化硼', '0', '0');
INSERT INTO `wz_badword` VALUES ('958', '马钱子碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('959', '番木鳖碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('960', '氯磺酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('961', '碳酸亚铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('962', '丙腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('963', '甲基肼', '0', '0');
INSERT INTO `wz_badword` VALUES ('964', '丁腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('965', '烯丙胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('966', '异丁腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('967', '乌头碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('968', '亚硝酸乙酯', '0', '0');
INSERT INTO `wz_badword` VALUES ('969', '氯甲酸甲酯', '0', '0');
INSERT INTO `wz_badword` VALUES ('970', '一氯乙醛', '0', '0');
INSERT INTO `wz_badword` VALUES ('971', '丙烯醛', '0', '0');
INSERT INTO `wz_badword` VALUES ('972', '氯乙酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('973', '乙酸苯汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('974', '二盐酸盐', '0', '0');
INSERT INTO `wz_badword` VALUES ('975', '放线菌酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('976', '甲氰菊酯', '0', '0');
INSERT INTO `wz_badword` VALUES ('977', '地高辛', '0', '0');
INSERT INTO `wz_badword` VALUES ('978', '五氯酚钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('979', '赭曲毒素', '0', '0');
INSERT INTO `wz_badword` VALUES ('980', '甲藻毒素', '0', '0');
INSERT INTO `wz_badword` VALUES ('981', '硫酸亚铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('982', '氯化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('983', '二氯化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('984', '乙酸汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('985', '溴化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('986', '羰基氟', '0', '0');
INSERT INTO `wz_badword` VALUES ('987', '银氰化钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('988', '碘甲烷', '0', '0');
INSERT INTO `wz_badword` VALUES ('989', '碘化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('990', '三氯化砷', '0', '0');
INSERT INTO `wz_badword` VALUES ('991', '氰化银钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('992', '氰化物', '0', '0');
INSERT INTO `wz_badword` VALUES ('993', '保米磷', '0', '0');
INSERT INTO `wz_badword` VALUES ('994', '锇酸酐', '0', '0');
INSERT INTO `wz_badword` VALUES ('995', '全氟异丁烯', '0', '0');
INSERT INTO `wz_badword` VALUES ('996', '氰气', '0', '0');
INSERT INTO `wz_badword` VALUES ('997', '全氟丙酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('998', '偏压砷酸钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('999', '氰甲汞胍', '0', '0');
INSERT INTO `wz_badword` VALUES ('1000', '氰胍甲汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1001', '灭害威', '0', '0');
INSERT INTO `wz_badword` VALUES ('1002', '硼烷', '0', '0');
INSERT INTO `wz_badword` VALUES ('1003', '藜芦碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1004', '甲基碘', '0', '0');
INSERT INTO `wz_badword` VALUES ('1005', '氯化亚砷', '0', '0');
INSERT INTO `wz_badword` VALUES ('1006', '高哌啶', '0', '0');
INSERT INTO `wz_badword` VALUES ('1007', '花青甙', '0', '0');
INSERT INTO `wz_badword` VALUES ('1008', '红海葱甙', '0', '0');
INSERT INTO `wz_badword` VALUES ('1009', '法尼林', '0', '0');
INSERT INTO `wz_badword` VALUES ('1010', '氟乙酸胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1011', '乳腈', '0', '0');
INSERT INTO `wz_badword` VALUES ('1012', '二氯苯胂', '0', '0');
INSERT INTO `wz_badword` VALUES ('1013', '二磷化三锌', '0', '0');
INSERT INTO `wz_badword` VALUES ('1014', '西力生', '0', '0');
INSERT INTO `wz_badword` VALUES ('1015', '硝酸高汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1016', '塔崩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1017', '铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1018', '索曼', '0', '0');
INSERT INTO `wz_badword` VALUES ('1019', '沙林', '0', '0');
INSERT INTO `wz_badword` VALUES ('1020', '矢车菊甙', '0', '0');
INSERT INTO `wz_badword` VALUES ('1021', '重亚硒酸钠', '0', '0');
INSERT INTO `wz_badword` VALUES ('1022', '碳酸铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1023', '一氯醋酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('1024', '乙基氰', '0', '0');
INSERT INTO `wz_badword` VALUES ('1025', '一氧化二氟', '0', '0');
INSERT INTO `wz_badword` VALUES ('1026', '特普', '0', '0');
INSERT INTO `wz_badword` VALUES ('1027', '赛丸丁', '0', '0');
INSERT INTO `wz_badword` VALUES ('1028', '二乙基汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1029', '氧化亚铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1030', '升汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1031', '硫氰化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1032', '二碘化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1033', '原砷酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('1034', '硫酸铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1035', '醋酸汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1036', '氰化碘', '0', '0');
INSERT INTO `wz_badword` VALUES ('1037', '氰化金钾', '0', '0');
INSERT INTO `wz_badword` VALUES ('1038', '红降汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1039', '白砒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1040', '醋酸铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1041', '砒霜', '0', '0');
INSERT INTO `wz_badword` VALUES ('1042', '氧化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1043', '氰化汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1044', '五氯苯酚', '0', '0');
INSERT INTO `wz_badword` VALUES ('1045', '金属铊', '0', '0');
INSERT INTO `wz_badword` VALUES ('1046', '当面交易', '0', '0');
INSERT INTO `wz_badword` VALUES ('1047', '专卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('1048', '公务员考试答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1049', '考研答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1050', '国考答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1051', '高考答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1052', '考试答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1053', '高考考中答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1054', '无线电作弊器材', '0', '0');
INSERT INTO `wz_badword` VALUES ('1055', '中考考中答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1056', '高考考前答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1057', '中考考前答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1058', '考前答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1059', '反屏蔽考试设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('1060', '四六级答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1061', '考试作弊器材', '0', '0');
INSERT INTO `wz_badword` VALUES ('1062', '考中答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1063', '考试作弊设备', '0', '0');
INSERT INTO `wz_badword` VALUES ('1064', '英语等级考试答案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1065', '考试作弊工具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1066', '针孔作弊器', '0', '0');
INSERT INTO `wz_badword` VALUES ('1067', '警用臂章', '0', '0');
INSERT INTO `wz_badword` VALUES ('1068', '考试题', '0', '0');
INSERT INTO `wz_badword` VALUES ('1069', '考试作弊器', '0', '0');
INSERT INTO `wz_badword` VALUES ('1070', '仿真警服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1071', '警帽', '0', '0');
INSERT INTO `wz_badword` VALUES ('1072', '武警作战服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1073', '警用器材', '0', '0');
INSERT INTO `wz_badword` VALUES ('1074', '手铐', '0', '0');
INSERT INTO `wz_badword` VALUES ('1075', '警用甩棍', '0', '0');
INSERT INTO `wz_badword` VALUES ('1076', '特警作战服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1077', '警用钢叉', '0', '0');
INSERT INTO `wz_badword` VALUES ('1078', '警衔', '0', '0');
INSERT INTO `wz_badword` VALUES ('1079', '警徽', '0', '0');
INSERT INTO `wz_badword` VALUES ('1080', '警察作训服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1081', '警服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1082', '警灯', '0', '0');
INSERT INTO `wz_badword` VALUES ('1083', '警察胸标', '0', '0');
INSERT INTO `wz_badword` VALUES ('1084', '警察执勤服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1085', '交警警服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1086', '电警棍', '0', '0');
INSERT INTO `wz_badword` VALUES ('1087', '高压电警棍', '0', '0');
INSERT INTO `wz_badword` VALUES ('1088', '高仿警服', '0', '0');
INSERT INTO `wz_badword` VALUES ('1089', '宅急送数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1090', '银行客户名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1091', '银行开户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1092', '婴儿信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1093', '银行卡用户信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1094', '银行卡用户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1095', '业主资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1096', '业主身份资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1097', '业主资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1098', '业主信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1099', '业主名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1100', '业主身份信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1101', '学生家长资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1102', '学生档案', '0', '0');
INSERT INTO `wz_badword` VALUES ('1103', '学生家长名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1104', '学生家长名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1105', '信用卡客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1106', '物流客户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1107', '网购数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1108', '物流客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1109', '网购客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1110', '顺丰面单数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1111', '顺丰快递数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1112', '收藏品数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1113', '社保资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1114', '收藏品客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1115', '全球通用户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1116', '期货客户名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1117', '期货客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1118', '期货客户资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1119', '女性数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1120', '拍拍用户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1121', '女性资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1122', '落榜考生名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1123', '楼盘业主资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1124', '楼盘业主数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1125', '老年人资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1126', '楼盘业主名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1127', '联通客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1128', '老年人数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1129', '老板通讯录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1130', '老年人信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1131', '老板手机号码', '0', '0');
INSERT INTO `wz_badword` VALUES ('1132', '客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1133', '客户资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1134', '客户名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1135', '客户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1136', '客户信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1137', '家长数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1138', '考生资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1139', '金融客户资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1140', '家长资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1141', '户主资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1142', '户主信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1143', '股民信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1144', '股民资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1145', '股民资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1146', '股民联系方式', '0', '0');
INSERT INTO `wz_badword` VALUES ('1147', '股民名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1148', '股民名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1149', '股民开户数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1150', '股民个人资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1151', '股民个人信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1152', '股民电话号码', '0', '0');
INSERT INTO `wz_badword` VALUES ('1153', '高消费人群名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1154', '股民电话资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1155', '高官名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1156', '回收', '0', '0');
INSERT INTO `wz_badword` VALUES ('1157', '高考学生信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1158', '富人资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1159', '富人数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1160', '富人信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1161', '富豪数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1162', '房地产客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1163', '服刑人员资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1164', '买', '0', '0');
INSERT INTO `wz_badword` VALUES ('1165', '法人资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1166', '房主数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1167', '犯人数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1168', '票据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1169', '法人数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1170', '电信用户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1171', '电视购物资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1172', '法人手机号码', '0', '0');
INSERT INTO `wz_badword` VALUES ('1173', '电购面单数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1174', '电购数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1175', '电视购物名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1176', '代开', '0', '0');
INSERT INTO `wz_badword` VALUES ('1177', '车主数据', '0', '0');
INSERT INTO `wz_badword` VALUES ('1178', '车主资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1179', '车主资源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1180', '车主名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1181', '别墅业主信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1182', '车主信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1183', '保险客户名录', '0', '0');
INSERT INTO `wz_badword` VALUES ('1184', '保险客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1185', '毕业生简历', '0', '0');
INSERT INTO `wz_badword` VALUES ('1186', '高仿真脸皮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1187', '保健品客户资料', '0', '0');
INSERT INTO `wz_badword` VALUES ('1188', '保险客户名单', '0', '0');
INSERT INTO `wz_badword` VALUES ('1189', '硅胶面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1190', '定购', '0', '0');
INSERT INTO `wz_badword` VALUES ('1191', '高仿真人皮面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1192', '易容面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1193', '乳胶人皮面具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1194', '微声手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1195', '无声手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1196', '代购', '0', '0');
INSERT INTO `wz_badword` VALUES ('1197', '合成', '0', '0');
INSERT INTO `wz_badword` VALUES ('1198', '微型冲锋枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1199', '微冲', '0', '0');
INSERT INTO `wz_badword` VALUES ('1200', '冲锋枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1201', '瓦斯枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1202', '热兵器', '0', '0');
INSERT INTO `wz_badword` VALUES ('1203', 'DIY', '0', '0');
INSERT INTO `wz_badword` VALUES ('1204', '双筒猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1205', '制造', '0', '0');
INSERT INTO `wz_badword` VALUES ('1206', '制式手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1207', '改装射钉枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1208', '改装发令枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1209', '枪械', '0', '0');
INSERT INTO `wz_badword` VALUES ('1210', '来复枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1211', '枪模', '0', '0');
INSERT INTO `wz_badword` VALUES ('1212', '交换', '0', '0');
INSERT INTO `wz_badword` VALUES ('1213', '打鸟气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1214', '仿真气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1215', '电击枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1216', '打鸟汽枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1217', '打鸟枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1218', '运动步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1219', '平式枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1220', '短枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1221', '汽步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1222', '双管猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1223', '长枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1224', '枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1225', '真枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1226', '火药枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1227', '火枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1228', '狙击枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1229', '警用枪支', '0', '0');
INSERT INTO `wz_badword` VALUES ('1230', '麻醉枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1231', '军用手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1232', '猎枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1233', '仿真枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1234', '气步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1235', '气枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1236', '快删', '0', '0');
INSERT INTO `wz_badword` VALUES ('1237', '删除', '0', '0');
INSERT INTO `wz_badword` VALUES ('1238', '清除', '0', '0');
INSERT INTO `wz_badword` VALUES ('1239', '手枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1240', '步枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1241', '发票', '0', '0');
INSERT INTO `wz_badword` VALUES ('1242', '高仿钞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1243', '硬币模具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1244', '假币模具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1245', '硬币', '0', '0');
INSERT INTO `wz_badword` VALUES ('1246', '伪币', '0', '0');
INSERT INTO `wz_badword` VALUES ('1247', '人民币', '0', '0');
INSERT INTO `wz_badword` VALUES ('1248', '纸币', '0', '0');
INSERT INTO `wz_badword` VALUES ('1249', '伪钞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1250', '假钱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1251', '钞票', '0', '0');
INSERT INTO `wz_badword` VALUES ('1252', '专供', '0', '0');
INSERT INTO `wz_badword` VALUES ('1253', '氢弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1254', '巡航导弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1255', '迫击炮弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1256', '定做', '0', '0');
INSERT INTO `wz_badword` VALUES ('1257', '硅烷炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1258', '汽油弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1259', '手雷', '0', '0');
INSERT INTO `wz_badword` VALUES ('1260', '土炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1261', '黑索今', '0', '0');
INSERT INTO `wz_badword` VALUES ('1262', '导弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1263', '催泪弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1264', '液体炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1265', '烟雾弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1266', '黄色炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1267', '太恩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1268', '硝胺炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1269', '硝酸胺炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1270', '手榴弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1271', '硝铵炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1272', '太安', '0', '0');
INSERT INTO `wz_badword` VALUES ('1273', '水胶炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1274', '三硝基苯酚', '0', '0');
INSERT INTO `wz_badword` VALUES ('1275', '乳化炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1276', '三硝基甲苯', '0', '0');
INSERT INTO `wz_badword` VALUES ('1277', '内裤炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1278', '雷汞', '0', '0');
INSERT INTO `wz_badword` VALUES ('1279', '銷售', '0', '0');
INSERT INTO `wz_badword` VALUES ('1280', '黑索金', '0', '0');
INSERT INTO `wz_badword` VALUES ('1281', '导爆索', '0', '0');
INSERT INTO `wz_badword` VALUES ('1282', '铵油炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1283', '铵梯炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1284', '季戊四醇四硝酸酯', '0', '0');
INSERT INTO `wz_badword` VALUES ('1285', '硝化甘油', '0', '0');
INSERT INTO `wz_badword` VALUES ('1286', '塑料炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1287', '原子弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1288', 'TNT', '0', '0');
INSERT INTO `wz_badword` VALUES ('1289', 'PETN', '0', '0');
INSERT INTO `wz_badword` VALUES ('1290', '燃烧弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1291', 'C4', '0', '0');
INSERT INTO `wz_badword` VALUES ('1292', '燃烧瓶', '0', '0');
INSERT INTO `wz_badword` VALUES ('1293', '雷管', '0', '0');
INSERT INTO `wz_badword` VALUES ('1294', '黑火药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1295', '炸药', '0', '0');
INSERT INTO `wz_badword` VALUES ('1296', '炸弹', '0', '0');
INSERT INTO `wz_badword` VALUES ('1297', 'xwodi软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1298', '手机监听王', '0', '0');
INSERT INTO `wz_badword` VALUES ('1299', '移动电话卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1300', '卧底定位软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1301', '智能偷听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1302', '手机远程监控软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1303', '特洛伊卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1304', 'x卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1305', 'spyera软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1306', '手机窃听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1307', '手机监听软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1308', '手机间谍软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1309', '信息快照', '0', '0');
INSERT INTO `wz_badword` VALUES ('1310', '卧底监控软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1311', '手机卧底软件', '0', '0');
INSERT INTO `wz_badword` VALUES ('1312', '负面贴文', '0', '0');
INSERT INTO `wz_badword` VALUES ('1313', '论坛信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1314', '网上信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1315', '诽谤信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1316', '负面评价', '0', '0');
INSERT INTO `wz_badword` VALUES ('1317', '造谣信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1318', '负面消息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1319', '天涯帖', '0', '0');
INSERT INTO `wz_badword` VALUES ('1320', '不利信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1321', '负面视频', '0', '0');
INSERT INTO `wz_badword` VALUES ('1322', '陪睡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1323', '负面新闻', '0', '0');
INSERT INTO `wz_badword` VALUES ('1324', '负面报道', '0', '0');
INSERT INTO `wz_badword` VALUES ('1325', '百度贴吧帖子', '0', '0');
INSERT INTO `wz_badword` VALUES ('1326', '负面帖子', '0', '0');
INSERT INTO `wz_badword` VALUES ('1327', '负面微博', '0', '0');
INSERT INTO `wz_badword` VALUES ('1328', '负面论坛贴', '0', '0');
INSERT INTO `wz_badword` VALUES ('1329', '银联卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1330', '负面信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1331', '负面评论', '0', '0');
INSERT INTO `wz_badword` VALUES ('1332', '磁道信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1333', '储蓄卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1334', '磁条信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1335', '银行卡号信息', '0', '0');
INSERT INTO `wz_badword` VALUES ('1336', '信用卡磁条', '0', '0');
INSERT INTO `wz_badword` VALUES ('1337', '借记卡磁条', '0', '0');
INSERT INTO `wz_badword` VALUES ('1338', '银行卡磁条', '0', '0');
INSERT INTO `wz_badword` VALUES ('1339', '磁道内码', '0', '0');
INSERT INTO `wz_badword` VALUES ('1340', '黑卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1341', '银行卡解码器', '0', '0');
INSERT INTO `wz_badword` VALUES ('1342', '银行卡复制器', '0', '0');
INSERT INTO `wz_badword` VALUES ('1343', '银行卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1344', '信用卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1345', '借记卡', '0', '0');
INSERT INTO `wz_badword` VALUES ('1346', '折叠手弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1347', '森林之狼弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1348', '弩箭', '0', '0');
INSERT INTO `wz_badword` VALUES ('1349', '力斯曼弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1350', '战神弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1351', '反恐弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1352', '小飞狼弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1353', '有偿捐赠', '0', '0');
INSERT INTO `wz_badword` VALUES ('1354', '有偿捐献', '0', '0');
INSERT INTO `wz_badword` VALUES ('1355', '二手弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1356', '秦氏弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1357', '弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1358', '进口弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1359', '弩弓', '0', '0');
INSERT INTO `wz_badword` VALUES ('1360', '追风弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1361', '眼镜蛇弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1362', '猎豹弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1363', '有偿提供', '0', '0');
INSERT INTO `wz_badword` VALUES ('1364', '大黑鹰弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1365', '赵氏弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1366', '三利达弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1367', '黑曼巴弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1368', '阻击弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1369', '军用弓弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1370', '军用折叠弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1371', '军用弩箭', '0', '0');
INSERT INTO `wz_badword` VALUES ('1372', '警用弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1373', '狩猎弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1374', '手弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1375', '钢弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1376', '踏弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1377', '军用钢珠弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1378', '十字弩', '0', '0');
INSERT INTO `wz_badword` VALUES ('1379', '弩枪', '0', '0');
INSERT INTO `wz_badword` VALUES ('1380', '武士刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1381', '战术折刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1382', '戈博刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1383', '军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1384', '勃朗宁军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1385', '大马士革刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1386', '三棱军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1387', '56式刺刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1388', '56式枪刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1389', '双刃尖刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1390', '三棱尖刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1391', '大马士革军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1392', '兰博刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1393', '廓尔喀军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1394', '卡巴军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1395', '军用刺刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1396', '虎牙刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1397', '战术匕首', '0', '0');
INSERT INTO `wz_badword` VALUES ('1398', '军刺枪刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1399', '伞兵刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1400', '野战砍刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1401', '尼泊尔弯刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1402', '七孔狗腿刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1403', '军用潜水刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1404', '战术军刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1405', '战术军刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1406', '格斗刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1407', '狗腿弯刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1408', 'd80军刺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1409', '武士直刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1410', '战术刀具', '0', '0');
INSERT INTO `wz_badword` VALUES ('1411', '军品刺刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1412', '丛林开山刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1413', '三棱刺刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1414', '跳刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1415', '战术狗腿刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1416', '三棱尖刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1417', '弹簧刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1418', '三棱刮刀', '0', '0');
INSERT INTO `wz_badword` VALUES ('1419', '匕首', '0', '0');
INSERT INTO `wz_badword` VALUES ('1420', '安非他明', '0', '0');
INSERT INTO `wz_badword` VALUES ('1421', '白粉', '0', '0');
INSERT INTO `wz_badword` VALUES ('1422', '苯巴比妥', '0', '0');
INSERT INTO `wz_badword` VALUES ('1423', '冰毒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1424', '大麻', '0', '0');
INSERT INTO `wz_badword` VALUES ('1425', '地西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1426', '二甲基安非他明', '0', '0');
INSERT INTO `wz_badword` VALUES ('1427', '古柯碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1428', '氟硝西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1429', '海乐神', '0', '0');
INSERT INTO `wz_badword` VALUES ('1430', '酣乐欣', '0', '0');
INSERT INTO `wz_badword` VALUES ('1431', '胡椒醛', '0', '0');
INSERT INTO `wz_badword` VALUES ('1432', '海洛因', '0', '0');
INSERT INTO `wz_badword` VALUES ('1433', '甲基安非他明', '0', '0');
INSERT INTO `wz_badword` VALUES ('1434', '甲基麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('1435', '甲硝西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1436', '甲卡西酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1437', '咖啡因', '0', '0');
INSERT INTO `wz_badword` VALUES ('1438', '可卡因', '0', '0');
INSERT INTO `wz_badword` VALUES ('1439', '卡西酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1440', '黎城辣面', '0', '0');
INSERT INTO `wz_badword` VALUES ('1441', '氯氨酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1442', '力月西片', '0', '0');
INSERT INTO `wz_badword` VALUES ('1443', '六氢大麻酚', '0', '0');
INSERT INTO `wz_badword` VALUES ('1444', '氯硝西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1445', '麻果', '0', '0');
INSERT INTO `wz_badword` VALUES ('1446', '麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1447', '麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('1448', '麻黄浸膏', '0', '0');
INSERT INTO `wz_badword` VALUES ('1449', '麻黄素羟亚胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1450', '麦角乙二胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1451', '麦角酸', '0', '0');
INSERT INTO `wz_badword` VALUES ('1452', '麦司卡林', '0', '0');
INSERT INTO `wz_badword` VALUES ('1453', '莫达非尼', '0', '0');
INSERT INTO `wz_badword` VALUES ('1454', '尼美西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1455', '普斯普剂', '0', '0');
INSERT INTO `wz_badword` VALUES ('1456', '普拉西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1457', '去甲麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('1458', '去氧麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1459', '去甲伪麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1460', '天然咖啡因', '0', '0');
INSERT INTO `wz_badword` VALUES ('1461', '替马西泮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1462', '香港ghb', '0', '0');
INSERT INTO `wz_badword` VALUES ('1463', '伪麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('1464', '香港GHB粉', '0', '0');
INSERT INTO `wz_badword` VALUES ('1465', '亚甲基二氧苯基', '0', '0');
INSERT INTO `wz_badword` VALUES ('1466', '盐酸氯胺酮', '0', '0');
INSERT INTO `wz_badword` VALUES ('1467', '盐酸麻黄碱', '0', '0');
INSERT INTO `wz_badword` VALUES ('1468', '盐酸麻黄素', '0', '0');
INSERT INTO `wz_badword` VALUES ('1469', '盐酸羟亚胺', '0', '0');
INSERT INTO `wz_badword` VALUES ('1470', '盐酸曲马多', '0', '0');
INSERT INTO `wz_badword` VALUES ('1471', '长治筋', '0', '0');
INSERT INTO `wz_badword` VALUES ('1472', '成人3d电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1473', 'AV电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1474', '成人电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1475', '高清成人电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1476', '成人AV电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1477', '3D网络电视棒成人版', '0', '0');
INSERT INTO `wz_badword` VALUES ('1478', '高清3d成人电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1479', '眼角膜', '0', '0');
INSERT INTO `wz_badword` VALUES ('1480', '成人3d网络电视棒', '0', '0');
INSERT INTO `wz_badword` VALUES ('1481', 'shen源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1482', '肾器官', '0', '0');
INSERT INTO `wz_badword` VALUES ('1483', '肾脏', '0', '0');
INSERT INTO `wz_badword` VALUES ('1484', '肝源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1485', '肝脏', '0', '0');
INSERT INTO `wz_badword` VALUES ('1486', '肾源', '0', '0');
INSERT INTO `wz_badword` VALUES ('1487', '肾', '0', '0');
INSERT INTO `wz_badword` VALUES ('1488', '加工', '0', '0');
INSERT INTO `wz_badword` VALUES ('1489', '现货', '0', '0');
INSERT INTO `wz_badword` VALUES ('1490', '自制', '0', '0');
INSERT INTO `wz_badword` VALUES ('1491', '改进', '0', '0');
INSERT INTO `wz_badword` VALUES ('1492', '改装', '0', '0');
INSERT INTO `wz_badword` VALUES ('1493', '热卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('1494', '代理', '0', '0');
INSERT INTO `wz_badword` VALUES ('1495', '代销', '0', '0');
INSERT INTO `wz_badword` VALUES ('1496', '破解', '0', '0');
INSERT INTO `wz_badword` VALUES ('1497', '清理', '0', '0');
INSERT INTO `wz_badword` VALUES ('1498', '删贴', '0', '0');
INSERT INTO `wz_badword` VALUES ('1499', '处理', '0', '0');
INSERT INTO `wz_badword` VALUES ('1500', '复制', '0', '0');
INSERT INTO `wz_badword` VALUES ('1501', '热销', '0', '0');
INSERT INTO `wz_badword` VALUES ('1502', '有偿卖', '0', '0');
INSERT INTO `wz_badword` VALUES ('1503', '有偿献', '0', '0');
INSERT INTO `wz_badword` VALUES ('1504', '有偿售', '0', '0');
INSERT INTO `wz_badword` VALUES ('1505', '援交妹', '0', '0');

-- ----------------------------
-- Table structure for wz_block
-- ----------------------------
DROP TABLE IF EXISTS `wz_block`;
CREATE TABLE `wz_block` (
  `blockid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tplid` varchar(20) NOT NULL COMMENT '绑定模版名称',
  `modelid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '绑定的模型',
  `siteid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL,
  `codetype` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(40) NOT NULL,
  `max_number` smallint(5) unsigned NOT NULL COMMENT '最大数量',
  `code` text NOT NULL COMMENT '模版代码或代码',
  `url` varchar(100) NOT NULL COMMENT 'jsonurl / rss url',
  `updatetime` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `timing` int(10) unsigned NOT NULL COMMENT '定时更新时间',
  `createhtml` tinyint(1) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `isopenid` tinyint(1) NOT NULL DEFAULT '0',
  `lang` varchar(10) NOT NULL DEFAULT 'zh',
  PRIMARY KEY (`blockid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='区块表';


-- ----------------------------
-- Table structure for wz_block_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_block_data`;
CREATE TABLE `wz_block_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `keyid` varchar(15) NOT NULL COMMENT '内容关联索引',
  `blockid` mediumint(8) unsigned NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属分类',
  `title` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `sort` tinyint(3) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '9' COMMENT '状态，9通过审核',
  `attach` text NOT NULL COMMENT '附加参数',
  `isdiy` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `blockid` (`blockid`,`status`,`sort`),
  KEY `blockid_2` (`blockid`,`cid`,`sort`),
  KEY `siteid` (`siteid`,`keyid`),
  KEY `keyid` (`keyid`,`blockid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='区块数据表';

-- ----------------------------
-- Records of wz_block_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_category
-- ----------------------------
DROP TABLE IF EXISTS `wz_category`;
CREATE TABLE `wz_category` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keyid` varchar(20) NOT NULL COMMENT '所属模块或唯一值',
  `name` varchar(30) NOT NULL COMMENT '栏目名称',
  `mb` varchar(30) NOT NULL COMMENT '移动网站名称',
  `catdir` varchar(30) NOT NULL COMMENT '英文目录',
  `parentdir` varchar(100) NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 栏目，1单网页，2外部链接',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有子栏目',
  `modelid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型id',
  `sort` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `domain` varchar(60) NOT NULL COMMENT '绑定域名',
  `url` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL COMMENT '栏目图片',
  `icon` varchar(200) NOT NULL,
  `workflowid` smallint(5) NOT NULL DEFAULT '0' COMMENT '工作流',
  `showloop` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在栏目列表处显示',
  `ismenu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在导航中显示',
  `mshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '移动导航是否显示',
  `listhtml` tinyint(1) NOT NULL DEFAULT '0' COMMENT '栏目页生成静态',
  `showhtml` tinyint(1) NOT NULL DEFAULT '0' COMMENT '内容页生成静态',
  `listurl` varchar(150) NOT NULL COMMENT '栏目页URL规则',
  `showurl` varchar(150) NOT NULL COMMENT '内容页URL规则',
  `category_template` varchar(36) NOT NULL COMMENT '大栏目页模版',
  `list_template` varchar(36) NOT NULL COMMENT '终级栏目页模版',
  `show_template` varchar(36) NOT NULL COMMENT '内容页模版',
  `seo_title` varchar(80) NOT NULL COMMENT 'SEO 标题',
  `seo_keywords` varchar(40) NOT NULL COMMENT 'SEO 关键字',
  `seo_description` varchar(255) NOT NULL COMMENT 'SEO 网页描述',
  `ishot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热门',
  PRIMARY KEY (`cid`),
  KEY `keyid` (`keyid`,`ismenu`,`sort`),
  KEY `siteid` (`keyid`,`siteid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for wz_category_private
-- ----------------------------
DROP TABLE IF EXISTS `wz_category_private`;
CREATE TABLE `wz_category_private` (
  `role` mediumint(8) unsigned NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL,
  `actionid` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`role`,`cid`,`actionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容管理权限表';

-- ----------------------------
-- Records of wz_category_private
-- ----------------------------

-- ----------------------------
-- Table structure for wz_category_stat
-- ----------------------------
DROP TABLE IF EXISTS `wz_category_stat`;
CREATE TABLE `wz_category_stat` (
  `dayid` int(10) NOT NULL,
  `num_contribute` int(10) NOT NULL DEFAULT '0',
  `num_publish` int(10) unsigned NOT NULL DEFAULT '0',
  `num_gooditem` int(10) NOT NULL DEFAULT '0',
  `num_comment` int(10) NOT NULL DEFAULT '0',
  `cid` mediumint(8) NOT NULL,
  KEY `dayid` (`dayid`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='稿件统计';

-- ----------------------------
-- Records of wz_category_stat
-- ----------------------------
INSERT INTO `wz_category_stat` VALUES ('20180405', '3', '1', '0', '0', '1');

-- ----------------------------
-- Table structure for wz_check_msg
-- ----------------------------
DROP TABLE IF EXISTS `wz_check_msg`;
CREATE TABLE `wz_check_msg` (
  `cmid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `msg` text NOT NULL,
  `checktime` int(10) unsigned NOT NULL,
  `admin_username` varchar(20) NOT NULL,
  `uid` int(10) NOT NULL,
  `status_msg` varchar(10) NOT NULL,
  PRIMARY KEY (`cmid`),
  KEY `id` (`id`,`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='审核记录';

-- ----------------------------
-- Records of wz_check_msg
-- ----------------------------

-- ----------------------------
-- Table structure for wz_cloud_app
-- ----------------------------
DROP TABLE IF EXISTS `wz_cloud_app`;
CREATE TABLE `wz_cloud_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `code` varchar(255) NOT NULL COMMENT '编码',
  `description` text NOT NULL COMMENT '描述',
  `icon` varchar(255) NOT NULL COMMENT '图标',
  `version` varchar(32) NOT NULL COMMENT '当前版本',
  `fromVersion` varchar(32) NOT NULL DEFAULT '0.0.0' COMMENT '更新前版本',
  `developerId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开发者用户ID',
  `developerName` varchar(255) NOT NULL DEFAULT '' COMMENT '开发者名称',
  `installedTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `updatedTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='已安装的应用';

-- ----------------------------
-- Records of wz_cloud_app
-- ----------------------------
INSERT INTO `wz_cloud_app` VALUES ('1', 'WUZHICMS', 'MAIN', 'WUZHICMS主系统', '', '4.0.0', '0.0.0', '1', 'WUZHICMS官方', '1493259939', '1493259939');

-- ----------------------------
-- Table structure for wz_cloud_app_logs
-- ----------------------------
DROP TABLE IF EXISTS `wz_cloud_app_logs`;
CREATE TABLE `wz_cloud_app_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '应用编码',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '应用名称',
  `fromVersion` varchar(32) DEFAULT '' COMMENT '升级前版本',
  `toVersion` varchar(32) NOT NULL DEFAULT '' COMMENT '升级后版本',
  `type` enum('install','upgrade') NOT NULL DEFAULT 'install' COMMENT '升级类型',
  `dbBackupPath` varchar(255) NOT NULL DEFAULT '' COMMENT '数据库备份文件',
  `sourceBackupPath` varchar(255) NOT NULL DEFAULT '' COMMENT '源文件备份地址',
  `status` varchar(32) NOT NULL COMMENT '升级状态(ROLLBACK,ERROR,SUCCESS,RECOVERED)',
  `userId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '升级时的IP',
  `message` text COMMENT '失败原因',
  `createdTime` int(10) unsigned NOT NULL COMMENT '日志记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用升级日志';

-- ----------------------------
-- Records of wz_cloud_app_logs
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_day_stat
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_day_stat`;
CREATE TABLE `wz_content_day_stat` (
  `dayid` int(10) unsigned NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `dayid` (`dayid`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_content_day_stat
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_ids
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_ids`;
CREATE TABLE `wz_content_ids` (
  `ciid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` tinyint(3) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL COMMENT '原始内容id',
  `cid` int(10) unsigned NOT NULL,
  `new_id` int(10) unsigned NOT NULL COMMENT '新的id',
  `new_siteid` tinyint(3) unsigned NOT NULL,
  `new_cid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ciid`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='站群内容对应关系';

-- ----------------------------
-- Records of wz_content_ids
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_rank
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_rank`;
CREATE TABLE `wz_content_rank` (
  `cid` mediumint(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `yesterdayviews` int(10) unsigned NOT NULL DEFAULT '0',
  `dayviews` int(10) unsigned NOT NULL DEFAULT '0',
  `weekviews` int(10) unsigned NOT NULL DEFAULT '0',
  `monthviews` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `cid` (`cid`,`id`),
  KEY `views` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_content_rank
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_relation
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_relation`;
CREATE TABLE `wz_content_relation` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL COMMENT '内容id索引',
  `cid` mediumint(8) unsigned NOT NULL COMMENT '栏目id',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `origin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `origin_cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `id` (`id`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='相关文章表';

-- ----------------------------
-- Records of wz_content_relation
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_share
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_share`;
CREATE TABLE `wz_content_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` char(255) NOT NULL DEFAULT '1',
  `title` char(80) NOT NULL DEFAULT '',
  `css` char(24) NOT NULL DEFAULT '',
  `thumb` char(255) NOT NULL DEFAULT '',
  `keywords` char(255) NOT NULL DEFAULT '',
  `remark` char(255) NOT NULL DEFAULT '',
  `block` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL DEFAULT '',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '9',
  `modelid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型id',
  `route` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'url路由，1为自定义路径',
  `publisher` char(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `soft_author` char(255) NOT NULL DEFAULT '',
  `soft_size` char(255) NOT NULL DEFAULT '',
  `soft_license` char(255) NOT NULL DEFAULT '',
  `soft_language` int(10) unsigned NOT NULL DEFAULT '0',
  `soft_env` char(255) NOT NULL DEFAULT '',
  `down_numbers` int(10) unsigned NOT NULL DEFAULT '0',
  `downfile` char(255) NOT NULL DEFAULT '',
  `push` tinyint(1) NOT NULL DEFAULT '0',
  `old_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment` char(255) NOT NULL DEFAULT '',
  `signature` char(255) NOT NULL DEFAULT '',
  `initial` char(1) NOT NULL,
  `box` char(255) NOT NULL DEFAULT '1',
  `yuding_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `zd` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `yx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优秀',
  `tj` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `tureName` char(255) NOT NULL DEFAULT '',
  `disgnation` char(255) NOT NULL DEFAULT '',
  `code` char(255) NOT NULL DEFAULT '',
  `videos` char(255) NOT NULL DEFAULT '',
  `use_notice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用稿通知状态：1 已通知',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`sort`,`id`),
  KEY `sort` (`cid`,`status`,`sort`,`id`),
  KEY `cid` (`cid`,`status`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_content_share
-- ----------------------------

-- ----------------------------
-- Table structure for wz_content_stat
-- ----------------------------
DROP TABLE IF EXISTS `wz_content_stat`;
CREATE TABLE `wz_content_stat` (
  `cid` mediumint(8) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `qkey` char(13) NOT NULL COMMENT '唯一值',
  `ip` char(15) NOT NULL,
  KEY `cid` (`cid`,`id`,`addtime`),
  KEY `qkey` (`qkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容模块访问统计';

-- ----------------------------
-- Records of wz_content_stat
-- ----------------------------
INSERT INTO `wz_content_stat` VALUES ('2', '9', '1514776430', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '9', '1514776443', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '5', '1514776551', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514777732', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514777735', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514777740', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '20', '1514777887', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '19', '1514777897', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '17', '1514777903', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '19', '1514780757', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '9', '1514780884', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514780891', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('3', '28', '1514794257', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514794463', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '10', '1514794481', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('13', '61', '1514794816', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('3', '29', '1514794840', '5a49a76e5ec91', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '17', '1522853834', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1522905485', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1522915181', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1522999118', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1523199514', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1523199527', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('10', '17', '1523199609', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('3', '28', '1523200288', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('4', '32', '1524274906', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '62', '1524316118', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('2', '7', '1524316131', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('3', '24', '1524316149', '5ac4e7caddf1b', '127.0.0.1');
INSERT INTO `wz_content_stat` VALUES ('1', '63', '1524386404', '5ac4e7caddf1b', '127.0.0.1');

-- ----------------------------
-- Table structure for wz_copyfrom
-- ----------------------------
DROP TABLE IF EXISTS `wz_copyfrom`;
CREATE TABLE `wz_copyfrom` (
  `fromid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `url` char(200) NOT NULL,
  `logo` char(200) NOT NULL,
  `usetimes` mediumint(8) unsigned NOT NULL,
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remark` text NOT NULL,
  PRIMARY KEY (`fromid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='来源表';

-- ----------------------------
-- Records of wz_copyfrom
-- ----------------------------

-- ----------------------------
-- Table structure for wz_credit
-- ----------------------------
DROP TABLE IF EXISTS `wz_credit`;
CREATE TABLE `wz_credit` (
  `jid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `remark` varchar(80) NOT NULL,
  `j_type` int(1) unsigned NOT NULL COMMENT '1:增 2：减(积分操作)',
  `point` int(10) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `keyid` char(18) NOT NULL COMMENT '唯一值',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`jid`),
  KEY `keyid` (`keyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分表';

-- ----------------------------
-- Records of wz_credit
-- ----------------------------

-- ----------------------------
-- Table structure for wz_credit_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_credit_data`;
CREATE TABLE `wz_credit_data` (
  `jid` int(10) unsigned NOT NULL COMMENT '积分id',
  `content` text NOT NULL COMMENT '备注',
  UNIQUE KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分从表';

-- ----------------------------
-- Records of wz_credit_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_credit_day
-- ----------------------------
DROP TABLE IF EXISTS `wz_credit_day`;
CREATE TABLE `wz_credit_day` (
  `cdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dayid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `point1` int(10) NOT NULL DEFAULT '0' COMMENT '增加的积分',
  `point2` int(10) NOT NULL DEFAULT '0' COMMENT '减少的积分',
  PRIMARY KEY (`cdid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分按天统计表';



-- ----------------------------
-- Table structure for wz_credit_set
-- ----------------------------
DROP TABLE IF EXISTS `wz_credit_set`;
CREATE TABLE `wz_credit_set` (
  `csid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `action` varchar(20) NOT NULL COMMENT '动作方法名',
  `point` int(10) unsigned NOT NULL COMMENT '数量',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 增加，2 减少',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '策略所在频道',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`csid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分策略';

-- ----------------------------
-- Records of wz_credit_set
-- ----------------------------
INSERT INTO `wz_credit_set` VALUES ('1', 'aaa', 'addnews', '11', '1', '3', '1000');
INSERT INTO `wz_credit_set` VALUES ('3', '投稿', 'addnews', '10', '1', '4', '1000');

-- ----------------------------
-- Table structure for wz_download_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_download_data`;
CREATE TABLE `wz_download_data` (
  `id` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groups` varchar(100) NOT NULL,
  `template` varchar(30) NOT NULL,
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `downfiles` text NOT NULL,
  `tcid` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_download_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_editor_log
-- ----------------------------
DROP TABLE IF EXISTS `wz_editor_log`;
CREATE TABLE `wz_editor_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL COMMENT '做的事情描述',
  `url` varchar(255) NOT NULL COMMENT '访问地址',
  `editurl` varchar(100) NOT NULL COMMENT '修改地址',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL COMMENT '作者',
  `ip` varchar(15) NOT NULL,
  `action` enum('add','edit','sort','delete','check') NOT NULL,
  `addtime` int(10) unsigned NOT NULL COMMENT '操作时间',
  `dayid` int(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='编辑操作日志';

-- ----------------------------
-- Records of wz_editor_log
-- ----------------------------

-- ----------------------------
-- Table structure for wz_feedback
-- ----------------------------
DROP TABLE IF EXISTS `wz_feedback`;
CREATE TABLE `wz_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` char(255) NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '9未回复，8已回复',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `reply` mediumtext NOT NULL,
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `linkman` char(20) NOT NULL DEFAULT '',
  `tel` char(20) NOT NULL DEFAULT '',
  `email` char(20) NOT NULL DEFAULT '',
  `reply_user` varchar(10) NOT NULL COMMENT '回复人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for wz_guestbook
-- ----------------------------
DROP TABLE IF EXISTS `wz_guestbook`;
CREATE TABLE `wz_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '',
  `url` char(100) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `reply` mediumtext NOT NULL,
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `linkman` char(20) NOT NULL DEFAULT '',
  `tel` char(20) NOT NULL DEFAULT '',
  `publisher` char(20) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reply_user` varchar(10) NOT NULL COMMENT '回复人',
  `area` char(255) NOT NULL DEFAULT '',
  `category` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_guestbook
-- ----------------------------

-- ----------------------------
-- Table structure for wz_key_verify
-- ----------------------------
DROP TABLE IF EXISTS `wz_key_verify`;
CREATE TABLE `wz_key_verify` (
  `keyid` char(32) NOT NULL,
  `addtime` int(10) NOT NULL,
  UNIQUE KEY `keyid` (`keyid`,`addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_key_verify
-- ----------------------------

-- ----------------------------
-- Table structure for wz_kind
-- ----------------------------
DROP TABLE IF EXISTS `wz_kind`;
CREATE TABLE `wz_kind` (
  `kid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyid` varchar(20) NOT NULL COMMENT '所属模块或自定义键值',
  `name` varchar(20) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`kid`),
  KEY `keyid` (`keyid`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='类别表';


-- ----------------------------
-- Table structure for wz_link
-- ----------------------------
DROP TABLE IF EXISTS `wz_link`;
CREATE TABLE `wz_link` (
  `linkid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `kid` int(10) unsigned NOT NULL COMMENT '所属类别',
  `sitename` varchar(60) NOT NULL COMMENT '站点名称',
  `remark` varchar(255) NOT NULL COMMENT '描述',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `logo` varchar(100) NOT NULL COMMENT 'logo',
  `username` varchar(20) NOT NULL COMMENT '添加人',
  `addtime` int(10) NOT NULL COMMENT '添加时间',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`linkid`),
  KEY `kid` (`kid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of wz_link
-- ----------------------------
INSERT INTO `wz_link` VALUES ('1', '3', '五指互联网站管理系统', '', 'http://www.wuzhicms.com', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', '1431925825', '1');
INSERT INTO `wz_link` VALUES ('3', '1', '五指CMS论坛', '', 'http://bbs.wuzhicms.com', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', '1431925830', '2');
INSERT INTO `wz_link` VALUES ('5', '2', '短信通', '', 'http://sms.phpip.com/index.php?m=member', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', '1431925841', '3');

-- ----------------------------
-- Table structure for wz_linkage
-- ----------------------------
DROP TABLE IF EXISTS `wz_linkage`;
CREATE TABLE `wz_linkage` (
  `linkageid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `display_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`linkageid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='联动菜单';

-- ----------------------------
-- Records of wz_linkage
-- ----------------------------
INSERT INTO `wz_linkage` VALUES ('2', 'tags类别', '1', '1', 'tag标签分类');
INSERT INTO `wz_linkage` VALUES ('1', '省市', '3', '1', '省市区');

-- ----------------------------
-- Table structure for wz_linkage_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_linkage_data`;
CREATE TABLE `wz_linkage_data` (
  `lid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `linkageid` mediumint(8) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `child` tinyint(1) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(100) DEFAULT NULL,
  `initial` varchar(1) NOT NULL,
  `letter` varchar(30) NOT NULL,
  `thumb` varchar(150) NOT NULL,
  `pictures` text NOT NULL,
  `isgroup` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`),
  KEY `parentid` (`pid`,`sort`),
  KEY `linkageid` (`linkageid`,`pid`),
  KEY `pid` (`pid`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=3367 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_linkage_data
-- ----------------------------
INSERT INTO `wz_linkage_data` VALUES ('2', '1', '北京市', '0', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3', '1', '上海市', '0', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('4', '1', '天津市', '0', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('5', '1', ' 重庆市', '0', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('6', '1', '河北省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('7', '1', '山西省', '0', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('8', '1', '内蒙古', '0', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('9', '1', '辽宁省', '0', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('10', '1', '吉林省', '0', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('11', '1', '黑龙江省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('12', '1', '江苏省', '0', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('13', '1', '浙江省', '0', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('14', '1', '安徽省', '0', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('15', '1', '福建省', '0', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('16', '1', '江西省', '0', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('17', '1', '山东省', '0', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('18', '1', '河南省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('19', '1', '湖北省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('20', '1', '湖南省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('21', '1', '广东省', '0', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('22', '1', '广西', '0', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('23', '1', '海南省', '0', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('24', '1', '四川省', '0', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('25', '1', '贵州省', '0', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('26', '1', '云南省', '0', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('27', '1', '西藏', '0', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('28', '1', '陕西省', '0', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('29', '1', '甘肃省', '0', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('30', '1', '青海省', '0', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('31', '1', '宁夏', '0', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('32', '1', '新疆', '0', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('33', '1', '台湾省', '0', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('34', '1', '香港', '0', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('35', '1', '澳门', '0', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('36', '1', '东城区', '3360', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('37', '1', '西城区', '3360', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('40', '1', '朝阳区', '3360', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('41', '1', '石景山区', '3360', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('42', '1', '海淀区', '3360', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('43', '1', '门头沟区', '3360', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('44', '1', '房山区', '3360', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('45', '1', '通州区', '3360', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('46', '1', '顺义区', '3360', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('47', '1', '昌平区', '3360', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('48', '1', '大兴区', '3360', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('49', '1', '怀柔区', '3360', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('50', '1', '平谷区', '3360', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('51', '1', '密云县', '3360', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('52', '1', '延庆县', '3360', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('53', '1', '黄浦区', '3361', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('54', '1', '卢湾区', '3361', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('55', '1', '徐汇区', '3361', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('56', '1', '长宁区', '3361', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('57', '1', '静安区', '3361', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('58', '1', '普陀区', '3361', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('59', '1', '闸北区', '3361', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('60', '1', '虹口区', '3361', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('61', '1', '杨浦区', '3361', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('62', '1', '闵行区', '3361', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('63', '1', '宝山区', '3361', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('64', '1', '嘉定区', '3361', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('65', '1', '浦东新区', '3361', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('66', '1', '金山区', '3361', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('67', '1', '松江区', '3361', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('68', '1', '青浦区', '3361', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('69', '1', '南汇区', '3361', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('70', '1', '奉贤区', '3361', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('71', '1', '崇明县', '3361', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('72', '1', '和平区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('73', '1', '河东区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('74', '1', '河西区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('75', '1', '南开区', '3362', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('76', '1', '河北区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('77', '1', '红桥区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('78', '1', '塘沽区', '3362', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('79', '1', '汉沽区', '3362', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('80', '1', '大港区', '3362', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('81', '1', '东丽区', '3362', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('82', '1', '西青区', '3362', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('83', '1', '津南区', '3362', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('84', '1', '北辰区', '3362', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('85', '1', '武清区', '3362', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('86', '1', '宝坻区', '3362', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('87', '1', '宁河县', '3362', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('88', '1', '静海县', '3362', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('89', '1', '蓟县', '3362', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('90', '1', '万州区', '3363', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('91', '1', '涪陵区', '3363', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('92', '1', '渝中区', '3363', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('93', '1', '大渡口区', '3363', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('94', '1', '江北区', '3363', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('95', '1', '沙坪坝区', '3363', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('96', '1', '九龙坡区', '3363', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('97', '1', '南岸区', '3363', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('98', '1', '北碚区', '3363', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('99', '1', '万盛区', '3363', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('100', '1', '双桥区', '3363', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('101', '1', '渝北区', '3363', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('102', '1', '巴南区', '3363', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('103', '1', '黔江区', '3363', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('104', '1', '长寿区', '3363', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('105', '1', '綦江县', '3363', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('106', '1', '潼南县', '3363', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('107', '1', '铜梁县', '3363', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('108', '1', '大足县', '3363', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('109', '1', '荣昌县', '3363', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('110', '1', '璧山县', '3363', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('111', '1', '梁平县', '3363', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('112', '1', '城口县', '3363', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('113', '1', '丰都县', '3363', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('114', '1', '垫江县', '3363', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('115', '1', '武隆县', '3363', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('116', '1', '忠县', '3363', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('117', '1', '开县', '3363', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('118', '1', '云阳县', '3363', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('119', '1', '奉节县', '3363', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('120', '1', '巫山县', '3363', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('121', '1', '巫溪县', '3363', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('122', '1', '石柱县', '3363', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('123', '1', '秀山县', '3363', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('124', '1', '酉阳县', '3363', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('125', '1', '彭水县', '3363', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('126', '1', '江津区', '3363', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('127', '1', '合川区', '3363', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('128', '1', '永川区', '3363', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('129', '1', '南川区', '3363', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('130', '1', '石家庄市', '6', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('131', '1', '唐山市', '6', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('132', '1', '秦皇岛市', '6', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('133', '1', '邯郸市', '6', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('134', '1', '邢台市', '6', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('135', '1', '保定市', '6', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('136', '1', '张家口市', '6', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('137', '1', '承德市', '6', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('138', '1', '沧州市', '6', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('139', '1', '廊坊市', '6', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('140', '1', '衡水市', '6', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('141', '1', '太原市', '7', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('142', '1', '大同市', '7', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('143', '1', '阳泉市', '7', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('144', '1', '长治市', '7', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('145', '1', '晋城市', '7', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('146', '1', '朔州市', '7', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('147', '1', '晋中市', '7', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('148', '1', '运城市', '7', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('149', '1', '忻州市', '7', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('150', '1', '临汾市', '7', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('151', '1', '吕梁市', '7', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('152', '1', '呼和浩特市', '8', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('153', '1', '包头市', '8', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('154', '1', '乌海市', '8', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('155', '1', '赤峰市', '8', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('156', '1', '通辽市', '8', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('157', '1', '鄂尔多斯市', '8', '1', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('158', '1', '呼伦贝尔市', '8', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('159', '1', '巴彦淖尔市', '8', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('160', '1', '乌兰察布市', '8', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('161', '1', '兴安盟', '8', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('162', '1', '锡林郭勒盟', '8', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('163', '1', '阿拉善盟', '8', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('164', '1', '沈阳市', '9', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('165', '1', '大连市', '9', '1', '0', '', 'd', 'dl', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('166', '1', '鞍山市', '9', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('167', '1', '抚顺市', '9', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('168', '1', '本溪市', '9', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('169', '1', '丹东市', '9', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('170', '1', '锦州市', '9', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('171', '1', '营口市', '9', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('172', '1', '阜新市', '9', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('173', '1', '辽阳市', '9', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('174', '1', '盘锦市', '9', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('175', '1', '铁岭市', '9', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('176', '1', '朝阳市', '9', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('177', '1', '葫芦岛市', '9', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('178', '1', '长春市', '10', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('179', '1', '吉林市', '10', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('180', '1', '四平市', '10', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('181', '1', '辽源市', '10', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('182', '1', '通化市', '10', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('183', '1', '白山市', '10', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('184', '1', '松原市', '10', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('185', '1', '白城市', '10', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('186', '1', '延边', '10', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('187', '1', '哈尔滨市', '11', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('188', '1', '齐齐哈尔市', '11', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('189', '1', '鸡西市', '11', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('190', '1', '鹤岗市', '11', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('191', '1', '双鸭山市', '11', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('192', '1', '大庆市', '11', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('193', '1', '伊春市', '11', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('194', '1', '佳木斯市', '11', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('195', '1', '七台河市', '11', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('196', '1', '牡丹江市', '11', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('197', '1', '黑河市', '11', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('198', '1', '绥化市', '11', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('199', '1', '大兴安岭地区', '11', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('200', '1', '南京市', '12', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('201', '1', '无锡市', '12', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('202', '1', '徐州市', '12', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('203', '1', '常州市', '12', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('204', '1', '苏州市', '12', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('205', '1', '南通市', '12', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('206', '1', '连云港市', '12', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('207', '1', '淮安市', '12', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('208', '1', '盐城市', '12', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('209', '1', '扬州市', '12', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('210', '1', '镇江市', '12', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('211', '1', '泰州市', '12', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('212', '1', '宿迁市', '12', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('213', '1', '杭州市', '13', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('214', '1', '宁波市', '13', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('215', '1', '温州市', '13', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('216', '1', '嘉兴市', '13', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('217', '1', '湖州市', '13', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('218', '1', '绍兴市', '13', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('219', '1', '金华市', '13', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('220', '1', '衢州市', '13', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('221', '1', '舟山市', '13', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('222', '1', '台州市', '13', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('223', '1', '丽水市', '13', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('224', '1', '合肥市', '14', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('225', '1', '芜湖市', '14', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('226', '1', '蚌埠市', '14', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('227', '1', '淮南市', '14', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('228', '1', '马鞍山市', '14', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('229', '1', '淮北市', '14', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('230', '1', '铜陵市', '14', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('231', '1', '安庆市', '14', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('232', '1', '黄山市', '14', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('233', '1', '滁州市', '14', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('234', '1', '阜阳市', '14', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('235', '1', '宿州市', '14', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('236', '1', '巢湖市', '14', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('237', '1', '六安市', '14', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('238', '1', '亳州市', '14', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('239', '1', '池州市', '14', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('240', '1', '宣城市', '14', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('241', '1', '福州市', '15', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('242', '1', '厦门市', '15', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('243', '1', '莆田市', '15', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('244', '1', '三明市', '15', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('245', '1', '泉州市', '15', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('246', '1', '漳州市', '15', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('247', '1', '南平市', '15', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('248', '1', '龙岩市', '15', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('249', '1', '宁德市', '15', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('250', '1', '南昌市', '16', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('251', '1', '景德镇市', '16', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('252', '1', '萍乡市', '16', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('253', '1', '九江市', '16', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('254', '1', '新余市', '16', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('255', '1', '鹰潭市', '16', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('256', '1', '赣州市', '16', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('257', '1', '吉安市', '16', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('258', '1', '宜春市', '16', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('259', '1', '抚州市', '16', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('260', '1', '上饶市', '16', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('261', '1', '济南市', '17', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('262', '1', '青岛市', '17', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('263', '1', '淄博市', '17', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('264', '1', '枣庄市', '17', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('265', '1', '东营市', '17', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('266', '1', '烟台市', '17', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('267', '1', '潍坊市', '17', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('268', '1', '济宁市', '17', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('269', '1', '泰安市', '17', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('270', '1', '威海市', '17', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('271', '1', '日照市', '17', '1', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('272', '1', '莱芜市', '17', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('273', '1', '临沂市', '17', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('274', '1', '德州市', '17', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('275', '1', '聊城市', '17', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('276', '1', '滨州市', '17', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('277', '1', '荷泽市', '17', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('278', '1', '郑州市', '18', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('279', '1', '开封市', '18', '1', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('280', '1', '洛阳市', '18', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('281', '1', '平顶山市', '18', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('282', '1', '安阳市', '18', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('283', '1', '鹤壁市', '18', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('284', '1', '新乡市', '18', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('285', '1', '焦作市', '18', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('286', '1', '濮阳市', '18', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('287', '1', '许昌市', '18', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('288', '1', '漯河市', '18', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('289', '1', '三门峡市', '18', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('290', '1', '南阳市', '18', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('291', '1', '商丘市', '18', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('292', '1', '信阳市', '18', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('293', '1', '周口市', '18', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('294', '1', '驻马店市', '18', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('295', '1', '武汉市', '19', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('296', '1', '黄石市', '19', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('297', '1', '十堰市', '19', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('298', '1', '宜昌市', '19', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('299', '1', '襄樊市', '19', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('300', '1', '鄂州市', '19', '1', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('301', '1', '荆门市', '19', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('302', '1', '孝感市', '19', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('303', '1', '荆州市', '19', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('304', '1', '黄冈市', '19', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('305', '1', '咸宁市', '19', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('306', '1', '随州市', '19', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('307', '1', '恩施土家族苗族自治州', '19', '1', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('308', '1', '仙桃市', '19', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('309', '1', '潜江市', '19', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('310', '1', '天门市', '19', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('311', '1', '神农架林区', '19', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('312', '1', '长沙市', '20', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('313', '1', '株洲市', '20', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('314', '1', '湘潭市', '20', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('315', '1', '衡阳市', '20', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('316', '1', '邵阳市', '20', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('317', '1', '岳阳市', '20', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('318', '1', '常德市', '20', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('319', '1', '张家界市', '20', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('320', '1', '益阳市', '20', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('321', '1', '郴州市', '20', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('322', '1', '永州市', '20', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('323', '1', '怀化市', '20', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('324', '1', '娄底市', '20', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('325', '1', '湘西土家族苗族自治州', '20', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('326', '1', '广州市', '21', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('327', '1', '韶关市', '21', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('328', '1', '深圳市', '21', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('329', '1', '珠海市', '21', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('330', '1', '汕头市', '21', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('331', '1', '佛山市', '21', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('332', '1', '江门市', '21', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('333', '1', '湛江市', '21', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('334', '1', '茂名市', '21', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('335', '1', '肇庆市', '21', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('336', '1', '惠州市', '21', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('337', '1', '梅州市', '21', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('338', '1', '汕尾市', '21', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('339', '1', '河源市', '21', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('340', '1', '阳江市', '21', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('341', '1', '清远市', '21', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('342', '1', '东莞市', '21', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('343', '1', '中山市', '21', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('344', '1', '潮州市', '21', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('345', '1', '揭阳市', '21', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('346', '1', '云浮市', '21', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('347', '1', '南宁市', '22', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('348', '1', '柳州市', '22', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('349', '1', '桂林市', '22', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('350', '1', '梧州市', '22', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('351', '1', '北海市', '22', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('352', '1', '防城港市', '22', '1', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('353', '1', '钦州市', '22', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('354', '1', '贵港市', '22', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('355', '1', '玉林市', '22', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('356', '1', '百色市', '22', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('357', '1', '贺州市', '22', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('358', '1', '河池市', '22', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('359', '1', '来宾市', '22', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('360', '1', '崇左市', '22', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('361', '1', '海口市', '23', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('362', '1', '三亚市', '23', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('363', '1', '五指山市', '23', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('364', '1', '琼海市', '23', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('365', '1', '儋州市', '23', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('366', '1', '文昌市', '23', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('367', '1', '万宁市', '23', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('368', '1', '东方市', '23', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('369', '1', '定安县', '23', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('370', '1', '屯昌县', '23', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('371', '1', '澄迈县', '23', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('372', '1', '临高县', '23', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('373', '1', '白沙黎族自治县', '23', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('374', '1', '昌江黎族自治县', '23', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('375', '1', '乐东黎族自治县', '23', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('376', '1', '陵水黎族自治县', '23', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('377', '1', '保亭黎族苗族自治县', '23', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('378', '1', '琼中黎族苗族自治县', '23', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('379', '1', '西沙群岛', '23', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('380', '1', '南沙群岛', '23', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('381', '1', '中沙群岛的岛礁及其海域', '23', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('382', '1', '成都市', '24', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('383', '1', '自贡市', '24', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('384', '1', '攀枝花市', '24', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('385', '1', '泸州市', '24', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('386', '1', '德阳市', '24', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('387', '1', '绵阳市', '24', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('388', '1', '广元市', '24', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('389', '1', '遂宁市', '24', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('390', '1', '内江市', '24', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('391', '1', '乐山市', '24', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('392', '1', '南充市', '24', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('393', '1', '眉山市', '24', '1', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('394', '1', '宜宾市', '24', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('395', '1', '广安市', '24', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('396', '1', '达州市', '24', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('397', '1', '雅安市', '24', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('398', '1', '巴中市', '24', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('399', '1', '资阳市', '24', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('400', '1', '阿坝州', '24', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('401', '1', '甘孜州', '24', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('402', '1', '凉山州', '24', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('403', '1', '贵阳市', '25', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('404', '1', '六盘水市', '25', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('405', '1', '遵义市', '25', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('406', '1', '安顺市', '25', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('407', '1', '铜仁地区', '25', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('408', '1', '黔西南州', '25', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('409', '1', '毕节地区', '25', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('410', '1', '黔东南州', '25', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('411', '1', '黔南州', '25', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('412', '1', '昆明市', '26', '1', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('413', '1', '曲靖市', '26', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('414', '1', '玉溪市', '26', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('415', '1', '保山市', '26', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('416', '1', '昭通市', '26', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('417', '1', '丽江市', '26', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('418', '1', '思茅市', '26', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('419', '1', '临沧市', '26', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('420', '1', '楚雄州', '26', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('421', '1', '红河州', '26', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('422', '1', '文山州', '26', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('423', '1', '西双版纳', '26', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('424', '1', '大理', '26', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('425', '1', '德宏', '26', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('426', '1', '怒江', '26', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('427', '1', '迪庆', '26', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('428', '1', '拉萨市', '27', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('429', '1', '昌都', '27', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('430', '1', '山南', '27', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('431', '1', '日喀则', '27', '1', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('432', '1', '那曲', '27', '1', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('433', '1', '阿里', '27', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('434', '1', '林芝', '27', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('435', '1', '西安市', '28', '1', '0', '', 'x', 'xa', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('436', '1', '铜川市', '28', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('437', '1', '宝鸡市', '28', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('438', '1', '咸阳市', '28', '1', '0', '', 'x', 'xy', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('439', '1', '渭南市', '28', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('440', '1', '延安市', '28', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('441', '1', '汉中市', '28', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('442', '1', '榆林市', '28', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('443', '1', '安康市', '28', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('444', '1', '商洛市', '28', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('445', '1', '兰州市', '29', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('446', '1', '嘉峪关市', '29', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('447', '1', '金昌市', '29', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('448', '1', '白银市', '29', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('449', '1', '天水市', '29', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('450', '1', '武威市', '29', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('451', '1', '张掖市', '29', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('452', '1', '平凉市', '29', '1', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('453', '1', '酒泉市', '29', '1', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('454', '1', '庆阳市', '29', '1', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('455', '1', '定西市', '29', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('456', '1', '陇南市', '29', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('457', '1', '临夏州', '29', '1', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('458', '1', '甘州', '29', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('459', '1', '西宁市', '30', '1', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('460', '1', '海东地区', '30', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('461', '1', '海州', '30', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('462', '1', '黄南州', '30', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('463', '1', '海南州', '30', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('464', '1', '果洛州', '30', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('465', '1', '玉树州', '30', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('466', '1', '海西州', '30', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('467', '1', '银川市', '31', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('468', '1', '石嘴山市', '31', '1', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('469', '1', '吴忠市', '31', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('470', '1', '固原市', '31', '1', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('471', '1', '中卫市', '31', '1', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('472', '1', '乌鲁木齐市', '32', '1', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('473', '1', '克拉玛依市', '32', '1', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('474', '1', '吐鲁番地区', '32', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('475', '1', '哈密地区', '32', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('476', '1', '昌吉州', '32', '1', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('477', '1', '博尔州', '32', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('478', '1', '巴音郭楞州', '32', '1', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('479', '1', '阿克苏地区', '32', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('480', '1', '克孜勒苏柯尔克孜自治州', '32', '1', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('481', '1', '喀什地区', '32', '1', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('482', '1', '和田地区', '32', '1', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('483', '1', '伊犁州', '32', '1', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('484', '1', '塔城地区', '32', '1', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('485', '1', '阿勒泰地区', '32', '1', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('486', '1', '石河子市', '32', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('487', '1', '阿拉尔市', '32', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('488', '1', '图木舒克市', '32', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('489', '1', '五家渠市', '32', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('490', '1', '台北市', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('491', '1', '高雄市', '33', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('492', '1', '基隆市', '33', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('493', '1', '新竹市', '33', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('494', '1', '台中市', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('495', '1', '嘉义市', '33', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('496', '1', '台南市', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('497', '1', '台北县', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('498', '1', '桃园县', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('499', '1', '新竹县', '33', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('500', '1', '苗栗县', '33', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('501', '1', '台中县', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('502', '1', '彰化县', '33', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('503', '1', '南投县', '33', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('504', '1', '云林县', '33', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('505', '1', '嘉义县', '33', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('506', '1', '台南县', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('507', '1', '高雄县', '33', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('508', '1', '屏东县', '33', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('509', '1', '宜兰县', '33', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('510', '1', '花莲县', '33', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('511', '1', '台东县', '33', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('512', '1', '澎湖县', '33', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('513', '1', '金门县', '33', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('514', '1', '连江县', '33', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('515', '1', '中西区', '3364', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('516', '1', '东区', '3364', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('517', '1', '南区', '3364', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('518', '1', '湾仔区', '3364', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('519', '1', '九龙城区', '3364', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('520', '1', '观塘区', '3364', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('521', '1', '深水埗区', '3364', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('522', '1', '黄大仙区', '3364', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('523', '1', '油尖旺区', '3364', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('524', '1', '离岛区', '3364', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('525', '1', '葵青区', '3364', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('526', '1', '北区', '3364', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('527', '1', '西贡区', '3364', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('528', '1', '沙田区', '3364', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('529', '1', '大埔区', '3364', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('530', '1', '荃湾区', '3364', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('531', '1', '屯门区', '3364', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('532', '1', '元朗区', '3364', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('533', '1', '花地玛堂区', '3365', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('534', '1', '市圣安多尼堂区', '3365', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('535', '1', '大堂区', '3365', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('536', '1', '望德堂区', '3365', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('537', '1', '风顺堂区', '3365', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('538', '1', '嘉模堂区', '3365', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('539', '1', '圣方济各堂区', '3365', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('540', '1', '长安区', '130', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('541', '1', '桥东区', '130', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('542', '1', '桥西区', '130', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('543', '1', '新华区', '130', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('544', '1', '井陉矿区', '130', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('545', '1', '裕华区', '130', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('546', '1', '井陉县', '130', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('547', '1', '正定县', '130', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('548', '1', '栾城县', '130', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('549', '1', '行唐县', '130', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('550', '1', '灵寿县', '130', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('551', '1', '高邑县', '130', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('552', '1', '深泽县', '130', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('553', '1', '赞皇县', '130', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('554', '1', '无极县', '130', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('555', '1', '平山县', '130', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('556', '1', '元氏县', '130', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('557', '1', '赵县', '130', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('558', '1', '辛集市', '130', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('559', '1', '藁城市', '130', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('560', '1', '晋州市', '130', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('561', '1', '新乐市', '130', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('562', '1', '鹿泉市', '130', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('563', '1', '路南区', '131', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('564', '1', '路北区', '131', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('565', '1', '古冶区', '131', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('566', '1', '开平区', '131', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('567', '1', '丰南区', '131', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('568', '1', '丰润区', '131', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('569', '1', '滦县', '131', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('570', '1', '滦南县', '131', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('571', '1', '乐亭县', '131', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('572', '1', '迁西县', '131', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('573', '1', '玉田县', '131', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('574', '1', '唐海县', '131', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('575', '1', '遵化市', '131', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('576', '1', '迁安市', '131', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('577', '1', '海港区', '132', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('578', '1', '山海关区', '132', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('579', '1', '北戴河区', '132', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('580', '1', '青龙县', '132', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('581', '1', '昌黎县', '132', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('582', '1', '抚宁县', '132', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('583', '1', '卢龙县', '132', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('584', '1', '邯山区', '133', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('585', '1', '丛台区', '133', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('586', '1', '复兴区', '133', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('587', '1', '峰峰矿区', '133', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('588', '1', '邯郸县', '133', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('589', '1', '临漳县', '133', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('590', '1', '成安县', '133', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('591', '1', '大名县', '133', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('592', '1', '涉县', '133', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('593', '1', '磁县', '133', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('594', '1', '肥乡县', '133', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('595', '1', '永年县', '133', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('596', '1', '邱县', '133', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('597', '1', '鸡泽县', '133', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('598', '1', '广平县', '133', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('599', '1', '馆陶县', '133', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('600', '1', '魏县', '133', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('601', '1', '曲周县', '133', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('602', '1', '武安市', '133', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('603', '1', '桥东区', '134', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('604', '1', '桥西区', '134', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('605', '1', '邢台县', '134', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('606', '1', '临城县', '134', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('607', '1', '内丘县', '134', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('608', '1', '柏乡县', '134', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('609', '1', '隆尧县', '134', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('610', '1', '任县', '134', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('611', '1', '南和县', '134', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('612', '1', '宁晋县', '134', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('613', '1', '巨鹿县', '134', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('614', '1', '新河县', '134', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('615', '1', '广宗县', '134', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('616', '1', '平乡县', '134', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('617', '1', '威县', '134', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('618', '1', '清河县', '134', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('619', '1', '临西县', '134', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('620', '1', '南宫市', '134', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('621', '1', '沙河市', '134', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('622', '1', '新市区', '135', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('623', '1', '北市区', '135', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('624', '1', '南市区', '135', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('625', '1', '满城县', '135', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('626', '1', '清苑县', '135', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('627', '1', '涞水县', '135', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('628', '1', '阜平县', '135', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('629', '1', '徐水县', '135', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('630', '1', '定兴县', '135', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('631', '1', '唐县', '135', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('632', '1', '高阳县', '135', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('633', '1', '容城县', '135', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('634', '1', '涞源县', '135', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('635', '1', '望都县', '135', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('636', '1', '安新县', '135', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('637', '1', '易县', '135', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('638', '1', '曲阳县', '135', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('639', '1', '蠡县', '135', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('640', '1', '顺平县', '135', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('641', '1', '博野县', '135', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('642', '1', '雄县', '135', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('643', '1', '涿州市', '135', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('644', '1', '定州市', '135', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('645', '1', '安国市', '135', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('646', '1', '高碑店市', '135', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('647', '1', '桥东区', '136', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('648', '1', '桥西区', '136', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('649', '1', '宣化区', '136', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('650', '1', '下花园区', '136', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('651', '1', '宣化县', '136', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('652', '1', '张北县', '136', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('653', '1', '康保县', '136', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('654', '1', '沽源县', '136', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('655', '1', '尚义县', '136', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('656', '1', '蔚县', '136', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('657', '1', '阳原县', '136', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('658', '1', '怀安县', '136', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('659', '1', '万全县', '136', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('660', '1', '怀来县', '136', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('661', '1', '涿鹿县', '136', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('662', '1', '赤城县', '136', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('663', '1', '崇礼县', '136', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('664', '1', '双桥区', '137', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('665', '1', '双滦区', '137', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('666', '1', '鹰手营子矿区', '137', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('667', '1', '承德县', '137', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('668', '1', '兴隆县', '137', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('669', '1', '平泉县', '137', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('670', '1', '滦平县', '137', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('671', '1', '隆化县', '137', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('672', '1', '丰宁县', '137', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('673', '1', '宽城县', '137', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('674', '1', '围场县', '137', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('675', '1', '新华区', '138', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('676', '1', '运河区', '138', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('677', '1', '沧县', '138', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('678', '1', '青县', '138', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('679', '1', '东光县', '138', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('680', '1', '海兴县', '138', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('681', '1', '盐山县', '138', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('682', '1', '肃宁县', '138', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('683', '1', '南皮县', '138', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('684', '1', '吴桥县', '138', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('685', '1', '献县', '138', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('686', '1', '孟村县', '138', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('687', '1', '泊头市', '138', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('688', '1', '任丘市', '138', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('689', '1', '黄骅市', '138', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('690', '1', '河间市', '138', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('691', '1', '安次区', '139', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('692', '1', '广阳区', '139', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('693', '1', '固安县', '139', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('694', '1', '永清县', '139', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('695', '1', '香河县', '139', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('696', '1', '大城县', '139', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('697', '1', '文安县', '139', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('698', '1', '大厂县', '139', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('699', '1', '霸州市', '139', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('700', '1', '三河市', '139', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('701', '1', '桃城区', '140', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('702', '1', '枣强县', '140', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('703', '1', '武邑县', '140', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('704', '1', '武强县', '140', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('705', '1', '饶阳县', '140', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('706', '1', '安平县', '140', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('707', '1', '故城县', '140', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('708', '1', '景县', '140', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('709', '1', '阜城县', '140', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('710', '1', '冀州市', '140', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('711', '1', '深州市', '140', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('712', '1', '小店区', '141', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('713', '1', '迎泽区', '141', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('714', '1', '杏花岭区', '141', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('715', '1', '尖草坪区', '141', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('716', '1', '万柏林区', '141', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('717', '1', '晋源区', '141', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('718', '1', '清徐县', '141', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('719', '1', '阳曲县', '141', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('720', '1', '娄烦县', '141', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('721', '1', '古交市', '141', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('722', '1', '城区', '142', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('723', '1', '矿区', '142', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('724', '1', '南郊区', '142', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('725', '1', '新荣区', '142', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('726', '1', '阳高县', '142', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('727', '1', '天镇县', '142', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('728', '1', '广灵县', '142', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('729', '1', '灵丘县', '142', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('730', '1', '浑源县', '142', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('731', '1', '左云县', '142', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('732', '1', '大同县', '142', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('733', '1', '城区', '143', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('734', '1', '矿区', '143', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('735', '1', '郊区', '143', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('736', '1', '平定县', '143', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('737', '1', '盂县', '143', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('738', '1', '城区', '144', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('739', '1', '郊区', '144', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('740', '1', '长治县', '144', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('741', '1', '襄垣县', '144', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('742', '1', '屯留县', '144', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('743', '1', '平顺县', '144', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('744', '1', '黎城县', '144', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('745', '1', '壶关县', '144', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('746', '1', '长子县', '144', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('747', '1', '武乡县', '144', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('748', '1', '沁县', '144', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('749', '1', '沁源县', '144', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('750', '1', '潞城市', '144', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('751', '1', '城区', '145', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('752', '1', '沁水县', '145', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('753', '1', '阳城县', '145', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('754', '1', '陵川县', '145', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('755', '1', '泽州县', '145', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('756', '1', '高平市', '145', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('757', '1', '朔城区', '146', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('758', '1', '平鲁区', '146', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('759', '1', '山阴县', '146', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('760', '1', '应县', '146', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('761', '1', '右玉县', '146', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('762', '1', '怀仁县', '146', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('763', '1', '榆次区', '147', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('764', '1', '榆社县', '147', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('765', '1', '左权县', '147', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('766', '1', '和顺县', '147', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('767', '1', '昔阳县', '147', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('768', '1', '寿阳县', '147', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('769', '1', '太谷县', '147', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('770', '1', '祁县', '147', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('771', '1', '平遥县', '147', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('772', '1', '灵石县', '147', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('773', '1', '介休市', '147', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('774', '1', '盐湖区', '148', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('775', '1', '临猗县', '148', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('776', '1', '万荣县', '148', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('777', '1', '闻喜县', '148', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('778', '1', '稷山县', '148', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('779', '1', '新绛县', '148', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('780', '1', '绛县', '148', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('781', '1', '垣曲县', '148', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('782', '1', '夏县', '148', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('783', '1', '平陆县', '148', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('784', '1', '芮城县', '148', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('785', '1', '永济市', '148', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('786', '1', '河津市', '148', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('787', '1', '忻府区', '149', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('788', '1', '定襄县', '149', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('789', '1', '五台县', '149', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('790', '1', '代县', '149', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('791', '1', '繁峙县', '149', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('792', '1', '宁武县', '149', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('793', '1', '静乐县', '149', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('794', '1', '神池县', '149', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('795', '1', '五寨县', '149', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('796', '1', '岢岚县', '149', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('797', '1', '河曲县', '149', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('798', '1', '保德县', '149', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('799', '1', '偏关县', '149', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('800', '1', '原平市', '149', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('801', '1', '尧都区', '150', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('802', '1', '曲沃县', '150', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('803', '1', '翼城县', '150', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('804', '1', '襄汾县', '150', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('805', '1', '洪洞县', '150', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('806', '1', '古县', '150', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('807', '1', '安泽县', '150', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('808', '1', '浮山县', '150', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('809', '1', '吉县', '150', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('810', '1', '乡宁县', '150', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('811', '1', '大宁县', '150', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('812', '1', '隰县', '150', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('813', '1', '永和县', '150', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('814', '1', '蒲县', '150', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('815', '1', '汾西县', '150', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('816', '1', '侯马市', '150', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('817', '1', '霍州市', '150', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('818', '1', '离石区', '151', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('819', '1', '文水县', '151', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('820', '1', '交城县', '151', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('821', '1', '兴县', '151', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('822', '1', '临县', '151', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('823', '1', '柳林县', '151', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('824', '1', '石楼县', '151', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('825', '1', '岚县', '151', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('826', '1', '方山县', '151', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('827', '1', '中阳县', '151', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('828', '1', '交口县', '151', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('829', '1', '孝义市', '151', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('830', '1', '汾阳市', '151', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('831', '1', '新城区', '152', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('832', '1', '回民区', '152', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('833', '1', '玉泉区', '152', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('834', '1', '赛罕区', '152', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('835', '1', '土默特左旗', '152', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('836', '1', '托克托县', '152', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('837', '1', '和林格尔县', '152', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('838', '1', '清水河县', '152', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('839', '1', '武川县', '152', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('840', '1', '东河区', '153', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('841', '1', '昆都仑区', '153', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('842', '1', '青山区', '153', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('843', '1', '石拐区', '153', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('844', '1', '白云矿区', '153', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('845', '1', '九原区', '153', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('846', '1', '土默特右旗', '153', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('847', '1', '固阳县', '153', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('848', '1', '达尔罕茂明安联合旗', '153', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('849', '1', '海勃湾区', '154', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('850', '1', '海南区', '154', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('851', '1', '乌达区', '154', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('852', '1', '红山区', '155', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('853', '1', '元宝山区', '155', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('854', '1', '松山区', '155', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('855', '1', '阿鲁科尔沁旗', '155', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('856', '1', '巴林左旗', '155', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('857', '1', '巴林右旗', '155', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('858', '1', '林西县', '155', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('859', '1', '克什克腾旗', '155', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('860', '1', '翁牛特旗', '155', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('861', '1', '喀喇沁旗', '155', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('862', '1', '宁城县', '155', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('863', '1', '敖汉旗', '155', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('864', '1', '科尔沁区', '156', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('865', '1', '科尔沁左翼中旗', '156', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('866', '1', '科尔沁左翼后旗', '156', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('867', '1', '开鲁县', '156', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('868', '1', '库伦旗', '156', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('869', '1', '奈曼旗', '156', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('870', '1', '扎鲁特旗', '156', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('871', '1', '霍林郭勒市', '156', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('872', '1', '东胜区', '157', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('873', '1', '达拉特旗', '157', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('874', '1', '准格尔旗', '157', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('875', '1', '鄂托克前旗', '157', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('876', '1', '鄂托克旗', '157', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('877', '1', '杭锦旗', '157', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('878', '1', '乌审旗', '157', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('879', '1', '伊金霍洛旗', '157', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('880', '1', '海拉尔区', '158', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('881', '1', '阿荣旗', '158', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('882', '1', '莫力达瓦达斡尔族自治旗', '158', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('883', '1', '鄂伦春自治旗', '158', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('884', '1', '鄂温克族自治旗', '158', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('885', '1', '陈巴尔虎旗', '158', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('886', '1', '新巴尔虎左旗', '158', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('887', '1', '新巴尔虎右旗', '158', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('888', '1', '满洲里市', '158', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('889', '1', '牙克石市', '158', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('890', '1', '扎兰屯市', '158', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('891', '1', '额尔古纳市', '158', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('892', '1', '根河市', '158', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('893', '1', '临河区', '159', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('894', '1', '五原县', '159', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('895', '1', '磴口县', '159', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('896', '1', '乌拉特前旗', '159', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('897', '1', '乌拉特中旗', '159', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('898', '1', '乌拉特后旗', '159', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('899', '1', '杭锦后旗', '159', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('900', '1', '集宁区', '160', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('901', '1', '卓资县', '160', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('902', '1', '化德县', '160', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('903', '1', '商都县', '160', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('904', '1', '兴和县', '160', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('905', '1', '凉城县', '160', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('906', '1', '察哈尔右翼前旗', '160', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('907', '1', '察哈尔右翼中旗', '160', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('908', '1', '察哈尔右翼后旗', '160', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('909', '1', '四子王旗', '160', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('910', '1', '丰镇市', '160', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('911', '1', '乌兰浩特市', '161', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('912', '1', '阿尔山市', '161', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('913', '1', '科尔沁右翼前旗', '161', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('914', '1', '科尔沁右翼中旗', '161', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('915', '1', '扎赉特旗', '161', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('916', '1', '突泉县', '161', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('917', '1', '二连浩特市', '162', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('918', '1', '锡林浩特市', '162', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('919', '1', '阿巴嘎旗', '162', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('920', '1', '苏尼特左旗', '162', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('921', '1', '苏尼特右旗', '162', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('922', '1', '东乌珠穆沁旗', '162', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('923', '1', '西乌珠穆沁旗', '162', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('924', '1', '太仆寺旗', '162', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('925', '1', '镶黄旗', '162', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('926', '1', '正镶白旗', '162', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('927', '1', '正蓝旗', '162', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('928', '1', '多伦县', '162', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('929', '1', '阿拉善左旗', '163', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('930', '1', '阿拉善右旗', '163', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('931', '1', '额济纳旗', '163', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('932', '1', '和平区', '164', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('933', '1', '沈河区', '164', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('934', '1', '大东区', '164', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('935', '1', '皇姑区', '164', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('936', '1', '铁西区', '164', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('937', '1', '苏家屯区', '164', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('938', '1', '东陵区', '164', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('939', '1', '新城子区', '164', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('940', '1', '于洪区', '164', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('941', '1', '辽中县', '164', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('942', '1', '康平县', '164', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('943', '1', '法库县', '164', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('944', '1', '新民市', '164', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('945', '1', '中山区', '165', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('946', '1', '西岗区', '165', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('947', '1', '沙河口区', '165', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('948', '1', '甘井子区', '165', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('949', '1', '旅顺口区', '165', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('950', '1', '金州区', '165', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('951', '1', '长海县', '165', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('952', '1', '瓦房店市', '165', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('953', '1', '普兰店市', '165', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('954', '1', '庄河市', '165', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('955', '1', '铁东区', '166', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('956', '1', '铁西区', '166', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('957', '1', '立山区', '166', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('958', '1', '千山区', '166', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('959', '1', '台安县', '166', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('960', '1', '岫岩满族自治县', '166', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('961', '1', '海城市', '166', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('962', '1', '新抚区', '167', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('963', '1', '东洲区', '167', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('964', '1', '望花区', '167', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('965', '1', '顺城区', '167', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('966', '1', '抚顺县', '167', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('967', '1', '新宾满族自治县', '167', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('968', '1', '清原满族自治县', '167', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('969', '1', '平山区', '168', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('970', '1', '溪湖区', '168', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('971', '1', '明山区', '168', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('972', '1', '南芬区', '168', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('973', '1', '本溪满族自治县', '168', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('974', '1', '桓仁满族自治县', '168', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('975', '1', '元宝区', '169', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('976', '1', '振兴区', '169', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('977', '1', '振安区', '169', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('978', '1', '宽甸满族自治县', '169', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('979', '1', '东港市', '169', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('980', '1', '凤城市', '169', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('981', '1', '古塔区', '170', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('982', '1', '凌河区', '170', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('983', '1', '太和区', '170', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('984', '1', '黑山县', '170', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('985', '1', '义县', '170', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('986', '1', '凌海市', '170', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('987', '1', '北镇市', '170', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('988', '1', '站前区', '171', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('989', '1', '西市区', '171', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('990', '1', '鲅鱼圈区', '171', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('991', '1', '老边区', '171', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('992', '1', '盖州市', '171', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('993', '1', '大石桥市', '171', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('994', '1', '海州区', '172', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('995', '1', '新邱区', '172', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('996', '1', '太平区', '172', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('997', '1', '清河门区', '172', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('998', '1', '细河区', '172', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('999', '1', '阜新蒙古族自治县', '172', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1000', '1', '彰武县', '172', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1001', '1', '白塔区', '173', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1002', '1', '文圣区', '173', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1003', '1', '宏伟区', '173', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1004', '1', '弓长岭区', '173', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1005', '1', '太子河区', '173', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1006', '1', '辽阳县', '173', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1007', '1', '灯塔市', '173', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1008', '1', '双台子区', '174', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1009', '1', '兴隆台区', '174', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1010', '1', '大洼县', '174', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1011', '1', '盘山县', '174', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1012', '1', '银州区', '175', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1013', '1', '清河区', '175', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1014', '1', '铁岭县', '175', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1015', '1', '西丰县', '175', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1016', '1', '昌图县', '175', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1017', '1', '调兵山市', '175', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1018', '1', '开原市', '175', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1019', '1', '双塔区', '176', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1020', '1', '龙城区', '176', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1021', '1', '朝阳县', '176', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1022', '1', '建平县', '176', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1023', '1', '喀喇沁左翼蒙古族自治县', '176', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1024', '1', '北票市', '176', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1025', '1', '凌源市', '176', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1026', '1', '连山区', '177', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1027', '1', '龙港区', '177', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1028', '1', '南票区', '177', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1029', '1', '绥中县', '177', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1030', '1', '建昌县', '177', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1031', '1', '兴城市', '177', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1032', '1', '南关区', '178', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1033', '1', '宽城区', '178', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1034', '1', '朝阳区', '178', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1035', '1', '二道区', '178', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1036', '1', '绿园区', '178', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1037', '1', '双阳区', '178', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1038', '1', '农安县', '178', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1039', '1', '九台市', '178', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1040', '1', '榆树市', '178', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1041', '1', '德惠市', '178', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1042', '1', '昌邑区', '179', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1043', '1', '龙潭区', '179', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1044', '1', '船营区', '179', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1045', '1', '丰满区', '179', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1046', '1', '永吉县', '179', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1047', '1', '蛟河市', '179', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1048', '1', '桦甸市', '179', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1049', '1', '舒兰市', '179', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1050', '1', '磐石市', '179', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1051', '1', '铁西区', '180', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1052', '1', '铁东区', '180', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1053', '1', '梨树县', '180', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1054', '1', '伊通满族自治县', '180', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1055', '1', '公主岭市', '180', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1056', '1', '双辽市', '180', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1057', '1', '龙山区', '181', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1058', '1', '西安区', '181', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1059', '1', '东丰县', '181', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1060', '1', '东辽县', '181', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1061', '1', '东昌区', '182', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1062', '1', '二道江区', '182', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1063', '1', '通化县', '182', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1064', '1', '辉南县', '182', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1065', '1', '柳河县', '182', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1066', '1', '梅河口市', '182', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1067', '1', '集安市', '182', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1068', '1', '八道江区', '183', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1069', '1', '抚松县', '183', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1070', '1', '靖宇县', '183', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1071', '1', '长白朝鲜族自治县', '183', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1072', '1', '江源县', '183', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1073', '1', '临江市', '183', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1074', '1', '宁江区', '184', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1075', '1', '前郭尔罗斯蒙古族自治县', '184', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1076', '1', '长岭县', '184', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1077', '1', '乾安县', '184', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1078', '1', '扶余县', '184', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1079', '1', '洮北区', '185', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1080', '1', '镇赉县', '185', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1081', '1', '通榆县', '185', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1082', '1', '洮南市', '185', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1083', '1', '大安市', '185', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1084', '1', '延吉市', '186', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1085', '1', '图们市', '186', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1086', '1', '敦化市', '186', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1087', '1', '珲春市', '186', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1088', '1', '龙井市', '186', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1089', '1', '和龙市', '186', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1090', '1', '汪清县', '186', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1091', '1', '安图县', '186', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1092', '1', '道里区', '187', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1093', '1', '南岗区', '187', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1094', '1', '道外区', '187', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1095', '1', '香坊区', '187', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1096', '1', '动力区', '187', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1097', '1', '平房区', '187', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1098', '1', '松北区', '187', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1099', '1', '呼兰区', '187', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1100', '1', '依兰县', '187', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1101', '1', '方正县', '187', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1102', '1', '宾县', '187', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1103', '1', '巴彦县', '187', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1104', '1', '木兰县', '187', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1105', '1', '通河县', '187', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1106', '1', '延寿县', '187', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1107', '1', '阿城市', '187', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1108', '1', '双城市', '187', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1109', '1', '尚志市', '187', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1110', '1', '五常市', '187', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1111', '1', '龙沙区', '188', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1112', '1', '建华区', '188', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1113', '1', '铁锋区', '188', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1114', '1', '昂昂溪区', '188', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1115', '1', '富拉尔基区', '188', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1116', '1', '碾子山区', '188', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1117', '1', '梅里斯达斡尔族区', '188', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1118', '1', '龙江县', '188', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1119', '1', '依安县', '188', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1120', '1', '泰来县', '188', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1121', '1', '甘南县', '188', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1122', '1', '富裕县', '188', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1123', '1', '克山县', '188', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1124', '1', '克东县', '188', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1125', '1', '拜泉县', '188', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1126', '1', '讷河市', '188', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1127', '1', '鸡冠区', '189', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1128', '1', '恒山区', '189', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1129', '1', '滴道区', '189', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1130', '1', '梨树区', '189', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1131', '1', '城子河区', '189', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1132', '1', '麻山区', '189', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1133', '1', '鸡东县', '189', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1134', '1', '虎林市', '189', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1135', '1', '密山市', '189', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1136', '1', '向阳区', '190', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1137', '1', '工农区', '190', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1138', '1', '南山区', '190', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1139', '1', '兴安区', '190', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1140', '1', '东山区', '190', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1141', '1', '兴山区', '190', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1142', '1', '萝北县', '190', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1143', '1', '绥滨县', '190', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1144', '1', '尖山区', '191', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1145', '1', '岭东区', '191', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1146', '1', '四方台区', '191', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1147', '1', '宝山区', '191', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1148', '1', '集贤县', '191', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1149', '1', '友谊县', '191', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1150', '1', '宝清县', '191', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1151', '1', '饶河县', '191', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1152', '1', '萨尔图区', '192', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1153', '1', '龙凤区', '192', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1154', '1', '让胡路区', '192', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1155', '1', '红岗区', '192', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1156', '1', '大同区', '192', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1157', '1', '肇州县', '192', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1158', '1', '肇源县', '192', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1159', '1', '林甸县', '192', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1160', '1', '杜尔伯特蒙古族自治县', '192', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1161', '1', '伊春区', '193', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1162', '1', '南岔区', '193', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1163', '1', '友好区', '193', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1164', '1', '西林区', '193', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1165', '1', '翠峦区', '193', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1166', '1', '新青区', '193', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1167', '1', '美溪区', '193', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1168', '1', '金山屯区', '193', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1169', '1', '五营区', '193', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1170', '1', '乌马河区', '193', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1171', '1', '汤旺河区', '193', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1172', '1', '带岭区', '193', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1173', '1', '乌伊岭区', '193', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1174', '1', '红星区', '193', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1175', '1', '上甘岭区', '193', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1176', '1', '嘉荫县', '193', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1177', '1', '铁力市', '193', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1178', '1', '永红区', '194', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1179', '1', '向阳区', '194', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1180', '1', '前进区', '194', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1181', '1', '东风区', '194', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1182', '1', '郊区', '194', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1183', '1', '桦南县', '194', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1184', '1', '桦川县', '194', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1185', '1', '汤原县', '194', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1186', '1', '抚远县', '194', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1187', '1', '同江市', '194', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1188', '1', '富锦市', '194', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1189', '1', '新兴区', '195', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1190', '1', '桃山区', '195', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1191', '1', '茄子河区', '195', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1192', '1', '勃利县', '195', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1193', '1', '东安区', '196', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1194', '1', '阳明区', '196', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1195', '1', '爱民区', '196', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1196', '1', '西安区', '196', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1197', '1', '东宁县', '196', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1198', '1', '林口县', '196', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1199', '1', '绥芬河市', '196', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1200', '1', '海林市', '196', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1201', '1', '宁安市', '196', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1202', '1', '穆棱市', '196', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1203', '1', '爱辉区', '197', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1204', '1', '嫩江县', '197', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1205', '1', '逊克县', '197', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1206', '1', '孙吴县', '197', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1207', '1', '北安市', '197', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1208', '1', '五大连池市', '197', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1209', '1', '北林区', '198', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1210', '1', '望奎县', '198', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1211', '1', '兰西县', '198', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1212', '1', '青冈县', '198', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1213', '1', '庆安县', '198', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1214', '1', '明水县', '198', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1215', '1', '绥棱县', '198', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1216', '1', '安达市', '198', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1217', '1', '肇东市', '198', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1218', '1', '海伦市', '198', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1219', '1', '呼玛县', '199', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1220', '1', '塔河县', '199', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1221', '1', '漠河县', '199', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1222', '1', '玄武区', '200', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1223', '1', '白下区', '200', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1224', '1', '秦淮区', '200', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1225', '1', '建邺区', '200', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1226', '1', '鼓楼区', '200', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1227', '1', '下关区', '200', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1228', '1', '浦口区', '200', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1229', '1', '栖霞区', '200', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1230', '1', '雨花台区', '200', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1231', '1', '江宁区', '200', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1232', '1', '六合区', '200', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1233', '1', '溧水县', '200', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1234', '1', '高淳县', '200', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1235', '1', '崇安区', '201', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1236', '1', '南长区', '201', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1237', '1', '北塘区', '201', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1238', '1', '锡山区', '201', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1239', '1', '惠山区', '201', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1240', '1', '滨湖区', '201', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1241', '1', '江阴市', '201', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1242', '1', '宜兴市', '201', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1243', '1', '鼓楼区', '202', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1244', '1', '云龙区', '202', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1245', '1', '九里区', '202', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1246', '1', '贾汪区', '202', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1247', '1', '泉山区', '202', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1248', '1', '丰县', '202', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1249', '1', '沛县', '202', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1250', '1', '铜山县', '202', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1251', '1', '睢宁县', '202', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1252', '1', '新沂市', '202', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1253', '1', '邳州市', '202', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1254', '1', '天宁区', '203', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1255', '1', '钟楼区', '203', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1256', '1', '戚墅堰区', '203', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1257', '1', '新北区', '203', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1258', '1', '武进区', '203', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1259', '1', '溧阳市', '203', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1260', '1', '金坛市', '203', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1261', '1', '沧浪区', '204', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1262', '1', '平江区', '204', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1263', '1', '金阊区', '204', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1264', '1', '虎丘区', '204', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1265', '1', '吴中区', '204', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1266', '1', '相城区', '204', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1267', '1', '常熟市', '204', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1268', '1', '张家港市', '204', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1269', '1', '昆山市', '204', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1270', '1', '吴江市', '204', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1271', '1', '太仓市', '204', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1272', '1', '崇川区', '205', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1273', '1', '港闸区', '205', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1274', '1', '海安县', '205', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1275', '1', '如东县', '205', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1276', '1', '启东市', '205', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1277', '1', '如皋市', '205', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1278', '1', '通州市', '205', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1279', '1', '海门市', '205', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1280', '1', '连云区', '206', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1281', '1', '新浦区', '206', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1282', '1', '海州区', '206', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1283', '1', '赣榆县', '206', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1284', '1', '东海县', '206', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1285', '1', '灌云县', '206', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1286', '1', '灌南县', '206', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1287', '1', '清河区', '207', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1288', '1', '楚州区', '207', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1289', '1', '淮阴区', '207', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1290', '1', '清浦区', '207', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1291', '1', '涟水县', '207', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1292', '1', '洪泽县', '207', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1293', '1', '盱眙县', '207', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1294', '1', '金湖县', '207', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1295', '1', '亭湖区', '208', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1296', '1', '盐都区', '208', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1297', '1', '响水县', '208', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1298', '1', '滨海县', '208', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1299', '1', '阜宁县', '208', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1300', '1', '射阳县', '208', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1301', '1', '建湖县', '208', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1302', '1', '东台市', '208', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1303', '1', '大丰市', '208', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1304', '1', '广陵区', '209', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1305', '1', '邗江区', '209', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1306', '1', '维扬区', '209', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1307', '1', '宝应县', '209', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1308', '1', '仪征市', '209', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1309', '1', '高邮市', '209', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1310', '1', '江都市', '209', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1311', '1', '京口区', '210', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1312', '1', '润州区', '210', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1313', '1', '丹徒区', '210', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1314', '1', '丹阳市', '210', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1315', '1', '扬中市', '210', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1316', '1', '句容市', '210', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1317', '1', '海陵区', '211', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1318', '1', '高港区', '211', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1319', '1', '兴化市', '211', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1320', '1', '靖江市', '211', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1321', '1', '泰兴市', '211', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1322', '1', '姜堰市', '211', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1323', '1', '宿城区', '212', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1324', '1', '宿豫区', '212', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1325', '1', '沭阳县', '212', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1326', '1', '泗阳县', '212', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1327', '1', '泗洪县', '212', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1328', '1', '上城区', '213', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1329', '1', '下城区', '213', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1330', '1', '江干区', '213', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1331', '1', '拱墅区', '213', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1332', '1', '西湖区', '213', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1333', '1', '滨江区', '213', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1334', '1', '萧山区', '213', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1335', '1', '余杭区', '213', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1336', '1', '桐庐县', '213', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1337', '1', '淳安县', '213', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1338', '1', '建德市', '213', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1339', '1', '富阳市', '213', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1340', '1', '临安市', '213', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1341', '1', '海曙区', '214', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1342', '1', '江东区', '214', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1343', '1', '江北区', '214', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1344', '1', '北仑区', '214', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1345', '1', '镇海区', '214', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1346', '1', '鄞州区', '214', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1347', '1', '象山县', '214', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1348', '1', '宁海县', '214', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1349', '1', '余姚市', '214', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1350', '1', '慈溪市', '214', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1351', '1', '奉化市', '214', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1352', '1', '鹿城区', '215', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1353', '1', '龙湾区', '215', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1354', '1', '瓯海区', '215', '0', '0', '', 'o', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1355', '1', '洞头县', '215', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1356', '1', '永嘉县', '215', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1357', '1', '平阳县', '215', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1358', '1', '苍南县', '215', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1359', '1', '文成县', '215', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1360', '1', '泰顺县', '215', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1361', '1', '瑞安市', '215', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1362', '1', '乐清市', '215', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1363', '1', '秀城区', '216', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1364', '1', '秀洲区', '216', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1365', '1', '嘉善县', '216', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1366', '1', '海盐县', '216', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1367', '1', '海宁市', '216', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1368', '1', '平湖市', '216', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1369', '1', '桐乡市', '216', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1370', '1', '吴兴区', '217', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1371', '1', '南浔区', '217', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1372', '1', '德清县', '217', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1373', '1', '长兴县', '217', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1374', '1', '安吉县', '217', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1375', '1', '越城区', '218', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1376', '1', '绍兴县', '218', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1377', '1', '新昌县', '218', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1378', '1', '诸暨市', '218', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1379', '1', '上虞市', '218', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1380', '1', '嵊州市', '218', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1381', '1', '婺城区', '219', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1382', '1', '金东区', '219', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1383', '1', '武义县', '219', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1384', '1', '浦江县', '219', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1385', '1', '磐安县', '219', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1386', '1', '兰溪市', '219', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1387', '1', '义乌市', '219', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1388', '1', '东阳市', '219', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1389', '1', '永康市', '219', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1390', '1', '柯城区', '220', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1391', '1', '衢江区', '220', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1392', '1', '常山县', '220', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1393', '1', '开化县', '220', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1394', '1', '龙游县', '220', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1395', '1', '江山市', '220', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1396', '1', '定海区', '221', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1397', '1', '普陀区', '221', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1398', '1', '岱山县', '221', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1399', '1', '嵊泗县', '221', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1400', '1', '椒江区', '222', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1401', '1', '黄岩区', '222', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1402', '1', '路桥区', '222', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1403', '1', '玉环县', '222', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1404', '1', '三门县', '222', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1405', '1', '天台县', '222', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1406', '1', '仙居县', '222', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1407', '1', '温岭市', '222', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1408', '1', '临海市', '222', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1409', '1', '莲都区', '223', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1410', '1', '青田县', '223', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1411', '1', '缙云县', '223', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1412', '1', '遂昌县', '223', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1413', '1', '松阳县', '223', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1414', '1', '云和县', '223', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1415', '1', '庆元县', '223', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1416', '1', '景宁畲族自治县', '223', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1417', '1', '龙泉市', '223', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1418', '1', '瑶海区', '224', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1419', '1', '庐阳区', '224', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1420', '1', '蜀山区', '224', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1421', '1', '包河区', '224', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1422', '1', '长丰县', '224', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1423', '1', '肥东县', '224', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1424', '1', '肥西县', '224', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1425', '1', '镜湖区', '225', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1426', '1', '弋江区', '225', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1427', '1', '鸠江区', '225', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1428', '1', '三山区', '225', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1429', '1', '芜湖县', '225', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1430', '1', '繁昌县', '225', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1431', '1', '南陵县', '225', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1432', '1', '龙子湖区', '226', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1433', '1', '蚌山区', '226', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1434', '1', '禹会区', '226', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1435', '1', '淮上区', '226', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1436', '1', '怀远县', '226', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1437', '1', '五河县', '226', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1438', '1', '固镇县', '226', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1439', '1', '大通区', '227', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1440', '1', '田家庵区', '227', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1441', '1', '谢家集区', '227', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1442', '1', '八公山区', '227', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1443', '1', '潘集区', '227', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1444', '1', '凤台县', '227', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1445', '1', '金家庄区', '228', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1446', '1', '花山区', '228', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1447', '1', '雨山区', '228', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1448', '1', '当涂县', '228', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1449', '1', '杜集区', '229', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1450', '1', '相山区', '229', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1451', '1', '烈山区', '229', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1452', '1', '濉溪县', '229', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1453', '1', '铜官山区', '230', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1454', '1', '狮子山区', '230', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1455', '1', '郊区', '230', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1456', '1', '铜陵县', '230', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1457', '1', '迎江区', '231', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1458', '1', '大观区', '231', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1459', '1', '宜秀区', '231', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1460', '1', '怀宁县', '231', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1461', '1', '枞阳县', '231', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1462', '1', '潜山县', '231', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1463', '1', '太湖县', '231', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1464', '1', '宿松县', '231', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1465', '1', '望江县', '231', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1466', '1', '岳西县', '231', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1467', '1', '桐城市', '231', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1468', '1', '屯溪区', '232', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1469', '1', '黄山区', '232', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1470', '1', '徽州区', '232', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1471', '1', '歙县', '232', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1472', '1', '休宁县', '232', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1473', '1', '黟县', '232', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1474', '1', '祁门县', '232', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1475', '1', '琅琊区', '233', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1476', '1', '南谯区', '233', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1477', '1', '来安县', '233', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1478', '1', '全椒县', '233', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1479', '1', '定远县', '233', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1480', '1', '凤阳县', '233', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1481', '1', '天长市', '233', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1482', '1', '明光市', '233', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1483', '1', '颍州区', '234', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1484', '1', '颍东区', '234', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1485', '1', '颍泉区', '234', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1486', '1', '临泉县', '234', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1487', '1', '太和县', '234', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1488', '1', '阜南县', '234', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1489', '1', '颍上县', '234', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1490', '1', '界首市', '234', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1491', '1', '埇桥区', '235', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1492', '1', '砀山县', '235', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1493', '1', '萧县', '235', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1494', '1', '灵璧县', '235', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1495', '1', '泗县', '235', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1496', '1', '居巢区', '236', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1497', '1', '庐江县', '236', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1498', '1', '无为县', '236', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1499', '1', '含山县', '236', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1500', '1', '和县', '236', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1501', '1', '金安区', '237', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1502', '1', '裕安区', '237', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1503', '1', '寿县', '237', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1504', '1', '霍邱县', '237', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1505', '1', '舒城县', '237', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1506', '1', '金寨县', '237', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1507', '1', '霍山县', '237', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1508', '1', '谯城区', '238', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1509', '1', '涡阳县', '238', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1510', '1', '蒙城县', '238', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1511', '1', '利辛县', '238', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1512', '1', '贵池区', '239', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1513', '1', '东至县', '239', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1514', '1', '石台县', '239', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1515', '1', '青阳县', '239', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1516', '1', '宣州区', '240', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1517', '1', '郎溪县', '240', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1518', '1', '广德县', '240', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1519', '1', '泾县', '240', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1520', '1', '绩溪县', '240', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1521', '1', '旌德县', '240', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1522', '1', '宁国市', '240', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1523', '1', '鼓楼区', '241', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1524', '1', '台江区', '241', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1525', '1', '仓山区', '241', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1526', '1', '马尾区', '241', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1527', '1', '晋安区', '241', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1528', '1', '闽侯县', '241', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1529', '1', '连江县', '241', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1530', '1', '罗源县', '241', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1531', '1', '闽清县', '241', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1532', '1', '永泰县', '241', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1533', '1', '平潭县', '241', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1534', '1', '福清市', '241', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1535', '1', '长乐市', '241', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1536', '1', '思明区', '242', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1537', '1', '海沧区', '242', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1538', '1', '湖里区', '242', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1539', '1', '集美区', '242', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1540', '1', '同安区', '242', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1541', '1', '翔安区', '242', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1542', '1', '城厢区', '243', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1543', '1', '涵江区', '243', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1544', '1', '荔城区', '243', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1545', '1', '秀屿区', '243', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1546', '1', '仙游县', '243', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1547', '1', '梅列区', '244', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1548', '1', '三元区', '244', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1549', '1', '明溪县', '244', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1550', '1', '清流县', '244', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1551', '1', '宁化县', '244', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1552', '1', '大田县', '244', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1553', '1', '尤溪县', '244', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1554', '1', '沙县', '244', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1555', '1', '将乐县', '244', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1556', '1', '泰宁县', '244', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1557', '1', '建宁县', '244', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1558', '1', '永安市', '244', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1559', '1', '鲤城区', '245', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1560', '1', '丰泽区', '245', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1561', '1', '洛江区', '245', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1562', '1', '泉港区', '245', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1563', '1', '惠安县', '245', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1564', '1', '安溪县', '245', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1565', '1', '永春县', '245', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1566', '1', '德化县', '245', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1567', '1', '金门县', '245', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1568', '1', '石狮市', '245', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1569', '1', '晋江市', '245', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1570', '1', '南安市', '245', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1571', '1', '芗城区', '246', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1572', '1', '龙文区', '246', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1573', '1', '云霄县', '246', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1574', '1', '漳浦县', '246', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1575', '1', '诏安县', '246', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1576', '1', '长泰县', '246', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1577', '1', '东山县', '246', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1578', '1', '南靖县', '246', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1579', '1', '平和县', '246', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1580', '1', '华安县', '246', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1581', '1', '龙海市', '246', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1582', '1', '延平区', '247', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1583', '1', '顺昌县', '247', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1584', '1', '浦城县', '247', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1585', '1', '光泽县', '247', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1586', '1', '松溪县', '247', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1587', '1', '政和县', '247', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1588', '1', '邵武市', '247', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1589', '1', '武夷山市', '247', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1590', '1', '建瓯市', '247', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1591', '1', '建阳市', '247', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1592', '1', '新罗区', '248', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1593', '1', '长汀县', '248', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1594', '1', '永定县', '248', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1595', '1', '上杭县', '248', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1596', '1', '武平县', '248', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1597', '1', '连城县', '248', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1598', '1', '漳平市', '248', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1599', '1', '蕉城区', '249', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1600', '1', '霞浦县', '249', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1601', '1', '古田县', '249', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1602', '1', '屏南县', '249', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1603', '1', '寿宁县', '249', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1604', '1', '周宁县', '249', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1605', '1', '柘荣县', '249', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1606', '1', '福安市', '249', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1607', '1', '福鼎市', '249', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1608', '1', '东湖区', '250', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1609', '1', '西湖区', '250', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1610', '1', '青云谱区', '250', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1611', '1', '湾里区', '250', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1612', '1', '青山湖区', '250', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1613', '1', '南昌县', '250', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1614', '1', '新建县', '250', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1615', '1', '安义县', '250', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1616', '1', '进贤县', '250', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1617', '1', '昌江区', '251', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1618', '1', '珠山区', '251', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1619', '1', '浮梁县', '251', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1620', '1', '乐平市', '251', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1621', '1', '安源区', '252', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1622', '1', '湘东区', '252', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1623', '1', '莲花县', '252', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1624', '1', '上栗县', '252', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1625', '1', '芦溪县', '252', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1626', '1', '庐山区', '253', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1627', '1', '浔阳区', '253', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1628', '1', '九江县', '253', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1629', '1', '武宁县', '253', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1630', '1', '修水县', '253', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1631', '1', '永修县', '253', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1632', '1', '德安县', '253', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1633', '1', '星子县', '253', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1634', '1', '都昌县', '253', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1635', '1', '湖口县', '253', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1636', '1', '彭泽县', '253', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1637', '1', '瑞昌市', '253', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1638', '1', '渝水区', '254', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1639', '1', '分宜县', '254', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1640', '1', '月湖区', '255', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1641', '1', '余江县', '255', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1642', '1', '贵溪市', '255', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1643', '1', '章贡区', '256', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1644', '1', '赣县', '256', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1645', '1', '信丰县', '256', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1646', '1', '大余县', '256', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1647', '1', '上犹县', '256', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1648', '1', '崇义县', '256', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1649', '1', '安远县', '256', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1650', '1', '龙南县', '256', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1651', '1', '定南县', '256', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1652', '1', '全南县', '256', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1653', '1', '宁都县', '256', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1654', '1', '于都县', '256', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1655', '1', '兴国县', '256', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1656', '1', '会昌县', '256', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1657', '1', '寻乌县', '256', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1658', '1', '石城县', '256', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1659', '1', '瑞金市', '256', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1660', '1', '南康市', '256', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1661', '1', '吉州区', '257', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1662', '1', '青原区', '257', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1663', '1', '吉安县', '257', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1664', '1', '吉水县', '257', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1665', '1', '峡江县', '257', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1666', '1', '新干县', '257', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1667', '1', '永丰县', '257', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1668', '1', '泰和县', '257', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1669', '1', '遂川县', '257', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1670', '1', '万安县', '257', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1671', '1', '安福县', '257', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1672', '1', '永新县', '257', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1673', '1', '井冈山市', '257', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1674', '1', '袁州区', '258', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1675', '1', '奉新县', '258', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1676', '1', '万载县', '258', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1677', '1', '上高县', '258', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1678', '1', '宜丰县', '258', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1679', '1', '靖安县', '258', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1680', '1', '铜鼓县', '258', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1681', '1', '丰城市', '258', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1682', '1', '樟树市', '258', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1683', '1', '高安市', '258', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1684', '1', '临川区', '259', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1685', '1', '南城县', '259', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1686', '1', '黎川县', '259', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1687', '1', '南丰县', '259', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1688', '1', '崇仁县', '259', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1689', '1', '乐安县', '259', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1690', '1', '宜黄县', '259', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1691', '1', '金溪县', '259', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1692', '1', '资溪县', '259', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1693', '1', '东乡县', '259', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1694', '1', '广昌县', '259', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1695', '1', '信州区', '260', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1696', '1', '上饶县', '260', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1697', '1', '广丰县', '260', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1698', '1', '玉山县', '260', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1699', '1', '铅山县', '260', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1700', '1', '横峰县', '260', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1701', '1', '弋阳县', '260', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1702', '1', '余干县', '260', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1703', '1', '鄱阳县', '260', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1704', '1', '万年县', '260', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1705', '1', '婺源县', '260', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1706', '1', '德兴市', '260', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1707', '1', '历下区', '261', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1708', '1', '市中区', '261', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1709', '1', '槐荫区', '261', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1710', '1', '天桥区', '261', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1711', '1', '历城区', '261', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1712', '1', '长清区', '261', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1713', '1', '平阴县', '261', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1714', '1', '济阳县', '261', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1715', '1', '商河县', '261', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1716', '1', '章丘市', '261', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1717', '1', '市南区', '262', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1718', '1', '市北区', '262', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1719', '1', '四方区', '262', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1720', '1', '黄岛区', '262', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1721', '1', '崂山区', '262', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1722', '1', '李沧区', '262', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1723', '1', '城阳区', '262', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1724', '1', '胶州市', '262', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1725', '1', '即墨市', '262', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1726', '1', '平度市', '262', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1727', '1', '胶南市', '262', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1728', '1', '莱西市', '262', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1729', '1', '淄川区', '263', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1730', '1', '张店区', '263', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1731', '1', '博山区', '263', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1732', '1', '临淄区', '263', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1733', '1', '周村区', '263', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1734', '1', '桓台县', '263', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1735', '1', '高青县', '263', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1736', '1', '沂源县', '263', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1737', '1', '市中区', '264', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1738', '1', '薛城区', '264', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1739', '1', '峄城区', '264', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1740', '1', '台儿庄区', '264', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1741', '1', '山亭区', '264', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1742', '1', '滕州市', '264', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1743', '1', '东营区', '265', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1744', '1', '河口区', '265', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1745', '1', '垦利县', '265', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1746', '1', '利津县', '265', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1747', '1', '广饶县', '265', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1748', '1', '芝罘区', '266', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1749', '1', '福山区', '266', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1750', '1', '牟平区', '266', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1751', '1', '莱山区', '266', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1752', '1', '长岛县', '266', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1753', '1', '龙口市', '266', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1754', '1', '莱阳市', '266', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1755', '1', '莱州市', '266', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1756', '1', '蓬莱市', '266', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1757', '1', '招远市', '266', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1758', '1', '栖霞市', '266', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1759', '1', '海阳市', '266', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1760', '1', '潍城区', '267', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1761', '1', '寒亭区', '267', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1762', '1', '坊子区', '267', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1763', '1', '奎文区', '267', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1764', '1', '临朐县', '267', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1765', '1', '昌乐县', '267', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1766', '1', '青州市', '267', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1767', '1', '诸城市', '267', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1768', '1', '寿光市', '267', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1769', '1', '安丘市', '267', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1770', '1', '高密市', '267', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1771', '1', '昌邑市', '267', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1772', '1', '市中区', '268', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1773', '1', '任城区', '268', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1774', '1', '微山县', '268', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1775', '1', '鱼台县', '268', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1776', '1', '金乡县', '268', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1777', '1', '嘉祥县', '268', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1778', '1', '汶上县', '268', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1779', '1', '泗水县', '268', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1780', '1', '梁山县', '268', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1781', '1', '曲阜市', '268', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1782', '1', '兖州市', '268', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1783', '1', '邹城市', '268', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1784', '1', '泰山区', '269', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1785', '1', '岱岳区', '269', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1786', '1', '宁阳县', '269', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1787', '1', '东平县', '269', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1788', '1', '新泰市', '269', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1789', '1', '肥城市', '269', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1790', '1', '环翠区', '270', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1791', '1', '文登市', '270', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1792', '1', '荣成市', '270', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1793', '1', '乳山市', '270', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1794', '1', '东港区', '271', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1795', '1', '岚山区', '271', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1796', '1', '五莲县', '271', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1797', '1', '莒县', '271', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1798', '1', '莱城区', '272', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1799', '1', '钢城区', '272', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1800', '1', '兰山区', '273', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1801', '1', '罗庄区', '273', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1802', '1', '河东区', '273', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1803', '1', '沂南县', '273', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1804', '1', '郯城县', '273', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1805', '1', '沂水县', '273', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1806', '1', '苍山县', '273', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1807', '1', '费县', '273', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1808', '1', '平邑县', '273', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1809', '1', '莒南县', '273', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1810', '1', '蒙阴县', '273', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1811', '1', '临沭县', '273', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1812', '1', '德城区', '274', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1813', '1', '陵县', '274', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1814', '1', '宁津县', '274', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1815', '1', '庆云县', '274', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1816', '1', '临邑县', '274', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1817', '1', '齐河县', '274', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1818', '1', '平原县', '274', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1819', '1', '夏津县', '274', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1820', '1', '武城县', '274', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1821', '1', '乐陵市', '274', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1822', '1', '禹城市', '274', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1823', '1', '东昌府区', '275', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1824', '1', '阳谷县', '275', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1825', '1', '莘县', '275', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1826', '1', '茌平县', '275', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1827', '1', '东阿县', '275', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1828', '1', '冠县', '275', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1829', '1', '高唐县', '275', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1830', '1', '临清市', '275', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1831', '1', '滨城区', '276', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1832', '1', '惠民县', '276', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1833', '1', '阳信县', '276', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1834', '1', '无棣县', '276', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1835', '1', '沾化县', '276', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1836', '1', '博兴县', '276', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1837', '1', '邹平县', '276', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1838', '1', '牡丹区', '277', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1839', '1', '曹县', '277', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1840', '1', '单县', '277', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1841', '1', '成武县', '277', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1842', '1', '巨野县', '277', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1843', '1', '郓城县', '277', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1844', '1', '鄄城县', '277', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1845', '1', '定陶县', '277', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1846', '1', '东明县', '277', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1847', '1', '中原区', '278', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1848', '1', '二七区', '278', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1849', '1', '管城回族区', '278', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1850', '1', '金水区', '278', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1851', '1', '上街区', '278', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1852', '1', '惠济区', '278', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1853', '1', '中牟县', '278', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1854', '1', '巩义市', '278', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1855', '1', '荥阳市', '278', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1856', '1', '新密市', '278', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1857', '1', '新郑市', '278', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1858', '1', '登封市', '278', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1859', '1', '龙亭区', '279', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1860', '1', '顺河回族区', '279', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1861', '1', '鼓楼区', '279', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1862', '1', '禹王台区', '279', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1863', '1', '金明区', '279', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1864', '1', '杞县', '279', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1865', '1', '通许县', '279', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1866', '1', '尉氏县', '279', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1867', '1', '开封县', '279', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1868', '1', '兰考县', '279', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1869', '1', '老城区', '280', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1870', '1', '西工区', '280', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1871', '1', '廛河回族区', '280', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1872', '1', '涧西区', '280', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1873', '1', '吉利区', '280', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1874', '1', '洛龙区', '280', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1875', '1', '孟津县', '280', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1876', '1', '新安县', '280', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1877', '1', '栾川县', '280', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1878', '1', '嵩县', '280', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1879', '1', '汝阳县', '280', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1880', '1', '宜阳县', '280', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1881', '1', '洛宁县', '280', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1882', '1', '伊川县', '280', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1883', '1', '偃师市', '280', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1884', '1', '新华区', '281', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1885', '1', '卫东区', '281', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1886', '1', '石龙区', '281', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1887', '1', '湛河区', '281', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1888', '1', '宝丰县', '281', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1889', '1', '叶县', '281', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1890', '1', '鲁山县', '281', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1891', '1', '郏县', '281', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1892', '1', '舞钢市', '281', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1893', '1', '汝州市', '281', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1894', '1', '文峰区', '282', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1895', '1', '北关区', '282', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1896', '1', '殷都区', '282', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1897', '1', '龙安区', '282', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1898', '1', '安阳县', '282', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1899', '1', '汤阴县', '282', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1900', '1', '滑县', '282', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1901', '1', '内黄县', '282', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1902', '1', '林州市', '282', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1903', '1', '鹤山区', '283', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1904', '1', '山城区', '283', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1905', '1', '淇滨区', '283', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1906', '1', '浚县', '283', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1907', '1', '淇县', '283', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1908', '1', '红旗区', '284', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1909', '1', '卫滨区', '284', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1910', '1', '凤泉区', '284', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1911', '1', '牧野区', '284', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1912', '1', '新乡县', '284', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1913', '1', '获嘉县', '284', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1914', '1', '原阳县', '284', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1915', '1', '延津县', '284', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1916', '1', '封丘县', '284', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1917', '1', '长垣县', '284', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1918', '1', '卫辉市', '284', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1919', '1', '辉县市', '284', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1920', '1', '解放区', '285', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1921', '1', '中站区', '285', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1922', '1', '马村区', '285', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1923', '1', '山阳区', '285', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1924', '1', '修武县', '285', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1925', '1', '博爱县', '285', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1926', '1', '武陟县', '285', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1927', '1', '温县', '285', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1928', '1', '济源市', '285', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1929', '1', '沁阳市', '285', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1930', '1', '孟州市', '285', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1931', '1', '华龙区', '286', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1932', '1', '清丰县', '286', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1933', '1', '南乐县', '286', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1934', '1', '范县', '286', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1935', '1', '台前县', '286', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1936', '1', '濮阳县', '286', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1937', '1', '魏都区', '287', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1938', '1', '许昌县', '287', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1939', '1', '鄢陵县', '287', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1940', '1', '襄城县', '287', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1941', '1', '禹州市', '287', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1942', '1', '长葛市', '287', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1943', '1', '源汇区', '288', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1944', '1', '郾城区', '288', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1945', '1', '召陵区', '288', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1946', '1', '舞阳县', '288', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1947', '1', '临颍县', '288', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1948', '1', '湖滨区', '289', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1949', '1', '渑池县', '289', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1950', '1', '陕县', '289', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1951', '1', '卢氏县', '289', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1952', '1', '义马市', '289', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1953', '1', '灵宝市', '289', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1954', '1', '宛城区', '290', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1955', '1', '卧龙区', '290', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1956', '1', '南召县', '290', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1957', '1', '方城县', '290', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1958', '1', '西峡县', '290', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1959', '1', '镇平县', '290', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1960', '1', '内乡县', '290', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1961', '1', '淅川县', '290', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1962', '1', '社旗县', '290', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1963', '1', '唐河县', '290', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1964', '1', '新野县', '290', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1965', '1', '桐柏县', '290', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1966', '1', '邓州市', '290', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1967', '1', '梁园区', '291', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1968', '1', '睢阳区', '291', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1969', '1', '民权县', '291', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1970', '1', '睢县', '291', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1971', '1', '宁陵县', '291', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1972', '1', '柘城县', '291', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1973', '1', '虞城县', '291', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1974', '1', '夏邑县', '291', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1975', '1', '永城市', '291', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1976', '1', '浉河区', '292', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1977', '1', '平桥区', '292', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1978', '1', '罗山县', '292', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1979', '1', '光山县', '292', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1980', '1', '新县', '292', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1981', '1', '商城县', '292', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1982', '1', '固始县', '292', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1983', '1', '潢川县', '292', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1984', '1', '淮滨县', '292', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1985', '1', '息县', '292', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1986', '1', '川汇区', '293', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1987', '1', '扶沟县', '293', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1988', '1', '西华县', '293', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1989', '1', '商水县', '293', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1990', '1', '沈丘县', '293', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1991', '1', '郸城县', '293', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1992', '1', '淮阳县', '293', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1993', '1', '太康县', '293', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1994', '1', '鹿邑县', '293', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1995', '1', '项城市', '293', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1996', '1', '驿城区', '294', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1997', '1', '西平县', '294', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1998', '1', '上蔡县', '294', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('1999', '1', '平舆县', '294', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2000', '1', '正阳县', '294', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2001', '1', '确山县', '294', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2002', '1', '泌阳县', '294', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2003', '1', '汝南县', '294', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2004', '1', '遂平县', '294', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2005', '1', '新蔡县', '294', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2006', '1', '江岸区', '295', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2007', '1', '江汉区', '295', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2008', '1', '硚口区', '295', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2009', '1', '汉阳区', '295', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2010', '1', '武昌区', '295', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2011', '1', '青山区', '295', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2012', '1', '洪山区', '295', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2013', '1', '东西湖区', '295', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2014', '1', '汉南区', '295', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2015', '1', '蔡甸区', '295', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2016', '1', '江夏区', '295', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2017', '1', '黄陂区', '295', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2018', '1', '新洲区', '295', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2019', '1', '黄石港区', '296', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2020', '1', '西塞山区', '296', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2021', '1', '下陆区', '296', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2022', '1', '铁山区', '296', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2023', '1', '阳新县', '296', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2024', '1', '大冶市', '296', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2025', '1', '茅箭区', '297', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2026', '1', '张湾区', '297', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2027', '1', '郧县', '297', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2028', '1', '郧西县', '297', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2029', '1', '竹山县', '297', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2030', '1', '竹溪县', '297', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2031', '1', '房县', '297', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2032', '1', '丹江口市', '297', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2033', '1', '西陵区', '298', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2034', '1', '伍家岗区', '298', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2035', '1', '点军区', '298', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2036', '1', '猇亭区', '298', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2037', '1', '夷陵区', '298', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2038', '1', '远安县', '298', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2039', '1', '兴山县', '298', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2040', '1', '秭归县', '298', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2041', '1', '长阳土家族自治县', '298', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2042', '1', '五峰土家族自治县', '298', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2043', '1', '宜都市', '298', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2044', '1', '当阳市', '298', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2045', '1', '枝江市', '298', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2046', '1', '襄城区', '299', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2047', '1', '樊城区', '299', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2048', '1', '襄阳区', '299', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2049', '1', '南漳县', '299', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2050', '1', '谷城县', '299', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2051', '1', '保康县', '299', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2052', '1', '老河口市', '299', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2053', '1', '枣阳市', '299', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2054', '1', '宜城市', '299', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2055', '1', '梁子湖区', '300', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2056', '1', '华容区', '300', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2057', '1', '鄂城区', '300', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2058', '1', '东宝区', '301', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2059', '1', '掇刀区', '301', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2060', '1', '京山县', '301', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2061', '1', '沙洋县', '301', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2062', '1', '钟祥市', '301', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2063', '1', '孝南区', '302', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2064', '1', '孝昌县', '302', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2065', '1', '大悟县', '302', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2066', '1', '云梦县', '302', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2067', '1', '应城市', '302', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2068', '1', '安陆市', '302', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2069', '1', '汉川市', '302', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2070', '1', '沙市区', '303', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2071', '1', '荆州区', '303', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2072', '1', '公安县', '303', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2073', '1', '监利县', '303', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2074', '1', '江陵县', '303', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2075', '1', '石首市', '303', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2076', '1', '洪湖市', '303', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2077', '1', '松滋市', '303', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2078', '1', '黄州区', '304', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2079', '1', '团风县', '304', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2080', '1', '红安县', '304', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2081', '1', '罗田县', '304', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2082', '1', '英山县', '304', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2083', '1', '浠水县', '304', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2084', '1', '蕲春县', '304', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2085', '1', '黄梅县', '304', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2086', '1', '麻城市', '304', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2087', '1', '武穴市', '304', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2088', '1', '咸安区', '305', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2089', '1', '嘉鱼县', '305', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2090', '1', '通城县', '305', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2091', '1', '崇阳县', '305', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2092', '1', '通山县', '305', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2093', '1', '赤壁市', '305', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2094', '1', '曾都区', '306', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2095', '1', '广水市', '306', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2096', '1', '恩施市', '307', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2097', '1', '利川市', '307', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2098', '1', '建始县', '307', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2099', '1', '巴东县', '307', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2100', '1', '宣恩县', '307', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2101', '1', '咸丰县', '307', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2102', '1', '来凤县', '307', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2103', '1', '鹤峰县', '307', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2104', '1', '芙蓉区', '312', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2105', '1', '天心区', '312', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2106', '1', '岳麓区', '312', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2107', '1', '开福区', '312', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2108', '1', '雨花区', '312', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2109', '1', '长沙县', '312', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2110', '1', '望城县', '312', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2111', '1', '宁乡县', '312', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2112', '1', '浏阳市', '312', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2113', '1', '荷塘区', '313', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2114', '1', '芦淞区', '313', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2115', '1', '石峰区', '313', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2116', '1', '天元区', '313', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2117', '1', '株洲县', '313', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2118', '1', '攸县', '313', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2119', '1', '茶陵县', '313', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2120', '1', '炎陵县', '313', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2121', '1', '醴陵市', '313', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2122', '1', '雨湖区', '314', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2123', '1', '岳塘区', '314', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2124', '1', '湘潭县', '314', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2125', '1', '湘乡市', '314', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2126', '1', '韶山市', '314', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2127', '1', '珠晖区', '315', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2128', '1', '雁峰区', '315', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2129', '1', '石鼓区', '315', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2130', '1', '蒸湘区', '315', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2131', '1', '南岳区', '315', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2132', '1', '衡阳县', '315', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2133', '1', '衡南县', '315', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2134', '1', '衡山县', '315', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2135', '1', '衡东县', '315', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2136', '1', '祁东县', '315', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2137', '1', '耒阳市', '315', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2138', '1', '常宁市', '315', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2139', '1', '双清区', '316', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2140', '1', '大祥区', '316', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2141', '1', '北塔区', '316', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2142', '1', '邵东县', '316', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2143', '1', '新邵县', '316', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2144', '1', '邵阳县', '316', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2145', '1', '隆回县', '316', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2146', '1', '洞口县', '316', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2147', '1', '绥宁县', '316', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2148', '1', '新宁县', '316', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2149', '1', '城步苗族自治县', '316', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2150', '1', '武冈市', '316', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2151', '1', '岳阳楼区', '317', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2152', '1', '云溪区', '317', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2153', '1', '君山区', '317', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2154', '1', '岳阳县', '317', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2155', '1', '华容县', '317', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2156', '1', '湘阴县', '317', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2157', '1', '平江县', '317', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2158', '1', '汨罗市', '317', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2159', '1', '临湘市', '317', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2160', '1', '武陵区', '318', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2161', '1', '鼎城区', '318', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2162', '1', '安乡县', '318', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2163', '1', '汉寿县', '318', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2164', '1', '澧县', '318', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2165', '1', '临澧县', '318', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2166', '1', '桃源县', '318', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2167', '1', '石门县', '318', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2168', '1', '津市市', '318', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2169', '1', '永定区', '319', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2170', '1', '武陵源区', '319', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2171', '1', '慈利县', '319', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2172', '1', '桑植县', '319', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2173', '1', '资阳区', '320', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2174', '1', '赫山区', '320', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2175', '1', '南县', '320', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2176', '1', '桃江县', '320', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2177', '1', '安化县', '320', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2178', '1', '沅江市', '320', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2179', '1', '北湖区', '321', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2180', '1', '苏仙区', '321', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2181', '1', '桂阳县', '321', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2182', '1', '宜章县', '321', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2183', '1', '永兴县', '321', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2184', '1', '嘉禾县', '321', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2185', '1', '临武县', '321', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2186', '1', '汝城县', '321', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2187', '1', '桂东县', '321', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2188', '1', '安仁县', '321', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2189', '1', '资兴市', '321', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2190', '1', '零陵区', '322', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2191', '1', '冷水滩区', '322', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2192', '1', '祁阳县', '322', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2193', '1', '东安县', '322', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2194', '1', '双牌县', '322', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2195', '1', '道县', '322', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2196', '1', '江永县', '322', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2197', '1', '宁远县', '322', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2198', '1', '蓝山县', '322', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2199', '1', '新田县', '322', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2200', '1', '江华瑶族自治县', '322', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2201', '1', '鹤城区', '323', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2202', '1', '中方县', '323', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2203', '1', '沅陵县', '323', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2204', '1', '辰溪县', '323', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2205', '1', '溆浦县', '323', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2206', '1', '会同县', '323', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2207', '1', '麻阳苗族自治县', '323', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2208', '1', '新晃侗族自治县', '323', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2209', '1', '芷江侗族自治县', '323', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2210', '1', '靖州苗族侗族自治县', '323', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2211', '1', '通道侗族自治县', '323', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2212', '1', '洪江市', '323', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2213', '1', '娄星区', '324', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2214', '1', '双峰县', '324', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2215', '1', '新化县', '324', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2216', '1', '冷水江市', '324', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2217', '1', '涟源市', '324', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2218', '1', '吉首市', '325', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2219', '1', '泸溪县', '325', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2220', '1', '凤凰县', '325', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2221', '1', '花垣县', '325', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2222', '1', '保靖县', '325', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2223', '1', '古丈县', '325', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2224', '1', '永顺县', '325', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2225', '1', '龙山县', '325', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2226', '1', '荔湾区', '326', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2227', '1', '越秀区', '326', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2228', '1', '海珠区', '326', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2229', '1', '天河区', '326', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2230', '1', '白云区', '326', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2231', '1', '黄埔区', '326', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2232', '1', '番禺区', '326', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2233', '1', '花都区', '326', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2234', '1', '南沙区', '326', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2235', '1', '萝岗区', '326', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2236', '1', '增城市', '326', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2237', '1', '从化市', '326', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2238', '1', '武江区', '327', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2239', '1', '浈江区', '327', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2240', '1', '曲江区', '327', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2241', '1', '始兴县', '327', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2242', '1', '仁化县', '327', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2243', '1', '翁源县', '327', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2244', '1', '乳源瑶族自治县', '327', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2245', '1', '新丰县', '327', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2246', '1', '乐昌市', '327', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2247', '1', '南雄市', '327', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2248', '1', '罗湖区', '328', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2249', '1', '福田区', '328', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2250', '1', '南山区', '328', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2251', '1', '宝安区', '328', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2252', '1', '龙岗区', '328', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2253', '1', '盐田区', '328', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2254', '1', '香洲区', '329', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2255', '1', '斗门区', '329', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2256', '1', '金湾区', '329', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2257', '1', '龙湖区', '330', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2258', '1', '金平区', '330', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2259', '1', '濠江区', '330', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2260', '1', '潮阳区', '330', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2261', '1', '潮南区', '330', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2262', '1', '澄海区', '330', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2263', '1', '南澳县', '330', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2264', '1', '禅城区', '331', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2265', '1', '南海区', '331', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2266', '1', '顺德区', '331', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2267', '1', '三水区', '331', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2268', '1', '高明区', '331', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2269', '1', '蓬江区', '332', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2270', '1', '江海区', '332', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2271', '1', '新会区', '332', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2272', '1', '台山市', '332', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2273', '1', '开平市', '332', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2274', '1', '鹤山市', '332', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2275', '1', '恩平市', '332', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2276', '1', '赤坎区', '333', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2277', '1', '霞山区', '333', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2278', '1', '坡头区', '333', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2279', '1', '麻章区', '333', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2280', '1', '遂溪县', '333', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2281', '1', '徐闻县', '333', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2282', '1', '廉江市', '333', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2283', '1', '雷州市', '333', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2284', '1', '吴川市', '333', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2285', '1', '茂南区', '334', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2286', '1', '茂港区', '334', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2287', '1', '电白县', '334', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2288', '1', '高州市', '334', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2289', '1', '化州市', '334', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2290', '1', '信宜市', '334', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2291', '1', '端州区', '335', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2292', '1', '鼎湖区', '335', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2293', '1', '广宁县', '335', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2294', '1', '怀集县', '335', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2295', '1', '封开县', '335', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2296', '1', '德庆县', '335', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2297', '1', '高要市', '335', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2298', '1', '四会市', '335', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2299', '1', '惠城区', '336', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2300', '1', '惠阳区', '336', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2301', '1', '博罗县', '336', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2302', '1', '惠东县', '336', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2303', '1', '龙门县', '336', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2304', '1', '梅江区', '337', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2305', '1', '梅县', '337', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2306', '1', '大埔县', '337', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2307', '1', '丰顺县', '337', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2308', '1', '五华县', '337', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2309', '1', '平远县', '337', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2310', '1', '蕉岭县', '337', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2311', '1', '兴宁市', '337', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2312', '1', '城区', '338', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2313', '1', '海丰县', '338', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2314', '1', '陆河县', '338', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2315', '1', '陆丰市', '338', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2316', '1', '源城区', '339', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2317', '1', '紫金县', '339', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2318', '1', '龙川县', '339', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2319', '1', '连平县', '339', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2320', '1', '和平县', '339', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2321', '1', '东源县', '339', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2322', '1', '江城区', '340', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2323', '1', '阳西县', '340', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2324', '1', '阳东县', '340', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2325', '1', '阳春市', '340', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2326', '1', '清城区', '341', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2327', '1', '佛冈县', '341', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2328', '1', '阳山县', '341', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2329', '1', '连山壮族瑶族自治县', '341', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2330', '1', '连南瑶族自治县', '341', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2331', '1', '清新县', '341', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2332', '1', '英德市', '341', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2333', '1', '连州市', '341', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2334', '1', '湘桥区', '344', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2335', '1', '潮安县', '344', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2336', '1', '饶平县', '344', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2337', '1', '榕城区', '345', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2338', '1', '揭东县', '345', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2339', '1', '揭西县', '345', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2340', '1', '惠来县', '345', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2341', '1', '普宁市', '345', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2342', '1', '云城区', '346', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2343', '1', '新兴县', '346', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2344', '1', '郁南县', '346', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2345', '1', '云安县', '346', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2346', '1', '罗定市', '346', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2347', '1', '兴宁区', '347', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2348', '1', '青秀区', '347', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2349', '1', '江南区', '347', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2350', '1', '西乡塘区', '347', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2351', '1', '良庆区', '347', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2352', '1', '邕宁区', '347', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2353', '1', '武鸣县', '347', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2354', '1', '隆安县', '347', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2355', '1', '马山县', '347', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2356', '1', '上林县', '347', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2357', '1', '宾阳县', '347', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2358', '1', '横县', '347', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2359', '1', '城中区', '348', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2360', '1', '鱼峰区', '348', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2361', '1', '柳南区', '348', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2362', '1', '柳北区', '348', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2363', '1', '柳江县', '348', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2364', '1', '柳城县', '348', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2365', '1', '鹿寨县', '348', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2366', '1', '融安县', '348', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2367', '1', '融水苗族自治县', '348', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2368', '1', '三江侗族自治县', '348', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2369', '1', '秀峰区', '349', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2370', '1', '叠彩区', '349', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2371', '1', '象山区', '349', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2372', '1', '七星区', '349', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2373', '1', '雁山区', '349', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2374', '1', '阳朔县', '349', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2375', '1', '临桂县', '349', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2376', '1', '灵川县', '349', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2377', '1', '全州县', '349', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2378', '1', '兴安县', '349', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2379', '1', '永福县', '349', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2380', '1', '灌阳县', '349', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2381', '1', '龙胜各族自治县', '349', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2382', '1', '资源县', '349', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2383', '1', '平乐县', '349', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2384', '1', '荔蒲县', '349', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2385', '1', '恭城瑶族自治县', '349', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2386', '1', '万秀区', '350', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2387', '1', '蝶山区', '350', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2388', '1', '长洲区', '350', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2389', '1', '苍梧县', '350', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2390', '1', '藤县', '350', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2391', '1', '蒙山县', '350', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2392', '1', '岑溪市', '350', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2393', '1', '海城区', '351', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2394', '1', '银海区', '351', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2395', '1', '铁山港区', '351', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2396', '1', '合浦县', '351', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2397', '1', '港口区', '352', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2398', '1', '防城区', '352', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2399', '1', '上思县', '352', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2400', '1', '东兴市', '352', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2401', '1', '钦南区', '353', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2402', '1', '钦北区', '353', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2403', '1', '灵山县', '353', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2404', '1', '浦北县', '353', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2405', '1', '港北区', '354', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2406', '1', '港南区', '354', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2407', '1', '覃塘区', '354', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2408', '1', '平南县', '354', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2409', '1', '桂平市', '354', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2410', '1', '玉州区', '355', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2411', '1', '容县', '355', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2412', '1', '陆川县', '355', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2413', '1', '博白县', '355', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2414', '1', '兴业县', '355', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2415', '1', '北流市', '355', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2416', '1', '右江区', '356', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2417', '1', '田阳县', '356', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2418', '1', '田东县', '356', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2419', '1', '平果县', '356', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2420', '1', '德保县', '356', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2421', '1', '靖西县', '356', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2422', '1', '那坡县', '356', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2423', '1', '凌云县', '356', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2424', '1', '乐业县', '356', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2425', '1', '田林县', '356', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2426', '1', '西林县', '356', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2427', '1', '隆林各族自治县', '356', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2428', '1', '八步区', '357', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2429', '1', '昭平县', '357', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2430', '1', '钟山县', '357', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2431', '1', '富川瑶族自治县', '357', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2432', '1', '金城江区', '358', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2433', '1', '南丹县', '358', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2434', '1', '天峨县', '358', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2435', '1', '凤山县', '358', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2436', '1', '东兰县', '358', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2437', '1', '罗城仫佬族自治县', '358', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2438', '1', '环江毛南族自治县', '358', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2439', '1', '巴马瑶族自治县', '358', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2440', '1', '都安瑶族自治县', '358', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2441', '1', '大化瑶族自治县', '358', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2442', '1', '宜州市', '358', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2443', '1', '兴宾区', '359', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2444', '1', '忻城县', '359', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2445', '1', '象州县', '359', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2446', '1', '武宣县', '359', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2447', '1', '金秀瑶族自治县', '359', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2448', '1', '合山市', '359', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2449', '1', '江洲区', '360', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2450', '1', '扶绥县', '360', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2451', '1', '宁明县', '360', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2452', '1', '龙州县', '360', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2453', '1', '大新县', '360', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2454', '1', '天等县', '360', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2455', '1', '凭祥市', '360', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2456', '1', '秀英区', '361', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2457', '1', '龙华区', '361', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2458', '1', '琼山区', '361', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2459', '1', '美兰区', '361', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2460', '1', '锦江区', '382', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2461', '1', '青羊区', '382', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2462', '1', '金牛区', '382', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2463', '1', '武侯区', '382', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2464', '1', '成华区', '382', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2465', '1', '龙泉驿区', '382', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2466', '1', '青白江区', '382', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2467', '1', '新都区', '382', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2468', '1', '温江区', '382', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2469', '1', '金堂县', '382', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2470', '1', '双流县', '382', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2471', '1', '郫县', '382', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2472', '1', '大邑县', '382', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2473', '1', '蒲江县', '382', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2474', '1', '新津县', '382', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2475', '1', '都江堰市', '382', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2476', '1', '彭州市', '382', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2477', '1', '邛崃市', '382', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2478', '1', '崇州市', '382', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2479', '1', '自流井区', '383', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2480', '1', '贡井区', '383', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2481', '1', '大安区', '383', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2482', '1', '沿滩区', '383', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2483', '1', '荣县', '383', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2484', '1', '富顺县', '383', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2485', '1', '东区', '384', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2486', '1', '西区', '384', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2487', '1', '仁和区', '384', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2488', '1', '米易县', '384', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2489', '1', '盐边县', '384', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2490', '1', '江阳区', '385', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2491', '1', '纳溪区', '385', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2492', '1', '龙马潭区', '385', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2493', '1', '泸县', '385', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2494', '1', '合江县', '385', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2495', '1', '叙永县', '385', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2496', '1', '古蔺县', '385', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2497', '1', '旌阳区', '386', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2498', '1', '中江县', '386', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2499', '1', '罗江县', '386', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2500', '1', '广汉市', '386', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2501', '1', '什邡市', '386', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2502', '1', '绵竹市', '386', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2503', '1', '涪城区', '387', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2504', '1', '游仙区', '387', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2505', '1', '三台县', '387', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2506', '1', '盐亭县', '387', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2507', '1', '安县', '387', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2508', '1', '梓潼县', '387', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2509', '1', '北川羌族自治县', '387', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2510', '1', '平武县', '387', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2511', '1', '江油市', '387', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2512', '1', '市中区', '388', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2513', '1', '元坝区', '388', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2514', '1', '朝天区', '388', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2515', '1', '旺苍县', '388', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2516', '1', '青川县', '388', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2517', '1', '剑阁县', '388', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2518', '1', '苍溪县', '388', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2519', '1', '船山区', '389', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2520', '1', '安居区', '389', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2521', '1', '蓬溪县', '389', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2522', '1', '射洪县', '389', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2523', '1', '大英县', '389', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2524', '1', '市中区', '390', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2525', '1', '东兴区', '390', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2526', '1', '威远县', '390', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2527', '1', '资中县', '390', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2528', '1', '隆昌县', '390', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2529', '1', '市中区', '391', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2530', '1', '沙湾区', '391', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2531', '1', '五通桥区', '391', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2532', '1', '金口河区', '391', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2533', '1', '犍为县', '391', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2534', '1', '井研县', '391', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2535', '1', '夹江县', '391', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2536', '1', '沐川县', '391', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2537', '1', '峨边彝族自治县', '391', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2538', '1', '马边彝族自治县', '391', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2539', '1', '峨眉山市', '391', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2540', '1', '顺庆区', '392', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2541', '1', '高坪区', '392', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2542', '1', '嘉陵区', '392', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2543', '1', '南部县', '392', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2544', '1', '营山县', '392', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2545', '1', '蓬安县', '392', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2546', '1', '仪陇县', '392', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2547', '1', '西充县', '392', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2548', '1', '阆中市', '392', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2549', '1', '东坡区', '393', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2550', '1', '仁寿县', '393', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2551', '1', '彭山县', '393', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2552', '1', '洪雅县', '393', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2553', '1', '丹棱县', '393', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2554', '1', '青神县', '393', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2555', '1', '翠屏区', '394', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2556', '1', '宜宾县', '394', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2557', '1', '南溪县', '394', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2558', '1', '江安县', '394', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2559', '1', '长宁县', '394', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2560', '1', '高县', '394', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2561', '1', '珙县', '394', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2562', '1', '筠连县', '394', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2563', '1', '兴文县', '394', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2564', '1', '屏山县', '394', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2565', '1', '广安区', '395', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2566', '1', '岳池县', '395', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2567', '1', '武胜县', '395', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2568', '1', '邻水县', '395', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2569', '1', '华蓥市', '395', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2570', '1', '通川区', '396', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2571', '1', '达县', '396', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2572', '1', '宣汉县', '396', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2573', '1', '开江县', '396', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2574', '1', '大竹县', '396', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2575', '1', '渠县', '396', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2576', '1', '万源市', '396', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2577', '1', '雨城区', '397', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2578', '1', '名山县', '397', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2579', '1', '荥经县', '397', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2580', '1', '汉源县', '397', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2581', '1', '石棉县', '397', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2582', '1', '天全县', '397', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2583', '1', '芦山县', '397', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2584', '1', '宝兴县', '397', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2585', '1', '巴州区', '398', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2586', '1', '通江县', '398', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2587', '1', '南江县', '398', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2588', '1', '平昌县', '398', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2589', '1', '雁江区', '399', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2590', '1', '安岳县', '399', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2591', '1', '乐至县', '399', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2592', '1', '简阳市', '399', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2593', '1', '汶川县', '400', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2594', '1', '理县', '400', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2595', '1', '茂县', '400', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2596', '1', '松潘县', '400', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2597', '1', '九寨沟县', '400', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2598', '1', '金川县', '400', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2599', '1', '小金县', '400', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2600', '1', '黑水县', '400', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2601', '1', '马尔康县', '400', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2602', '1', '壤塘县', '400', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2603', '1', '阿坝县', '400', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2604', '1', '若尔盖县', '400', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2605', '1', '红原县', '400', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2606', '1', '康定县', '401', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2607', '1', '泸定县', '401', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2608', '1', '丹巴县', '401', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2609', '1', '九龙县', '401', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2610', '1', '雅江县', '401', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2611', '1', '道孚县', '401', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2612', '1', '炉霍县', '401', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2613', '1', '甘孜县', '401', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2614', '1', '新龙县', '401', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2615', '1', '德格县', '401', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2616', '1', '白玉县', '401', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2617', '1', '石渠县', '401', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2618', '1', '色达县', '401', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2619', '1', '理塘县', '401', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2620', '1', '巴塘县', '401', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2621', '1', '乡城县', '401', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2622', '1', '稻城县', '401', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2623', '1', '得荣县', '401', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2624', '1', '西昌市', '402', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2625', '1', '木里藏族自治县', '402', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2626', '1', '盐源县', '402', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2627', '1', '德昌县', '402', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2628', '1', '会理县', '402', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2629', '1', '会东县', '402', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2630', '1', '宁南县', '402', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2631', '1', '普格县', '402', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2632', '1', '布拖县', '402', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2633', '1', '金阳县', '402', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2634', '1', '昭觉县', '402', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2635', '1', '喜德县', '402', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2636', '1', '冕宁县', '402', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2637', '1', '越西县', '402', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2638', '1', '甘洛县', '402', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2639', '1', '美姑县', '402', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2640', '1', '雷波县', '402', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2641', '1', '南明区', '403', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2642', '1', '云岩区', '403', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2643', '1', '花溪区', '403', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2644', '1', '乌当区', '403', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2645', '1', '白云区', '403', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2646', '1', '小河区', '403', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2647', '1', '开阳县', '403', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2648', '1', '息烽县', '403', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2649', '1', '修文县', '403', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2650', '1', '清镇市', '403', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2651', '1', '钟山区', '404', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2652', '1', '六枝特区', '404', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2653', '1', '水城县', '404', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2654', '1', '盘县', '404', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2655', '1', '红花岗区', '405', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2656', '1', '汇川区', '405', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2657', '1', '遵义县', '405', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2658', '1', '桐梓县', '405', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2659', '1', '绥阳县', '405', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2660', '1', '正安县', '405', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2661', '1', '道真仡佬族苗族自治县', '405', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2662', '1', '务川仡佬族苗族自治县', '405', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2663', '1', '凤冈县', '405', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2664', '1', '湄潭县', '405', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2665', '1', '余庆县', '405', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2666', '1', '习水县', '405', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2667', '1', '赤水市', '405', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2668', '1', '仁怀市', '405', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2669', '1', '西秀区', '406', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2670', '1', '平坝县', '406', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2671', '1', '普定县', '406', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2672', '1', '镇宁布依族苗族自治县', '406', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2673', '1', '关岭布依族苗族自治县', '406', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2674', '1', '紫云苗族布依族自治县', '406', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2675', '1', '铜仁市', '407', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2676', '1', '江口县', '407', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2677', '1', '玉屏侗族自治县', '407', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2678', '1', '石阡县', '407', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2679', '1', '思南县', '407', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2680', '1', '印江土家族苗族自治县', '407', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2681', '1', '德江县', '407', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2682', '1', '沿河土家族自治县', '407', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2683', '1', '松桃苗族自治县', '407', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2684', '1', '万山特区', '407', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2685', '1', '兴义市', '408', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2686', '1', '兴仁县', '408', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2687', '1', '普安县', '408', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2688', '1', '晴隆县', '408', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2689', '1', '贞丰县', '408', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2690', '1', '望谟县', '408', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2691', '1', '册亨县', '408', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2692', '1', '安龙县', '408', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2693', '1', '毕节市', '409', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2694', '1', '大方县', '409', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2695', '1', '黔西县', '409', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2696', '1', '金沙县', '409', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2697', '1', '织金县', '409', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2698', '1', '纳雍县', '409', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2699', '1', '威宁彝族回族苗族自治县', '409', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2700', '1', '赫章县', '409', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2701', '1', '凯里市', '410', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2702', '1', '黄平县', '410', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2703', '1', '施秉县', '410', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2704', '1', '三穗县', '410', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2705', '1', '镇远县', '410', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2706', '1', '岑巩县', '410', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2707', '1', '天柱县', '410', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2708', '1', '锦屏县', '410', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2709', '1', '剑河县', '410', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2710', '1', '台江县', '410', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2711', '1', '黎平县', '410', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2712', '1', '榕江县', '410', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2713', '1', '从江县', '410', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2714', '1', '雷山县', '410', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2715', '1', '麻江县', '410', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2716', '1', '丹寨县', '410', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2717', '1', '都匀市', '411', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2718', '1', '福泉市', '411', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2719', '1', '荔波县', '411', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2720', '1', '贵定县', '411', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2721', '1', '瓮安县', '411', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2722', '1', '独山县', '411', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2723', '1', '平塘县', '411', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2724', '1', '罗甸县', '411', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2725', '1', '长顺县', '411', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2726', '1', '龙里县', '411', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2727', '1', '惠水县', '411', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2728', '1', '三都水族自治县', '411', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2729', '1', '五华区', '412', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2730', '1', '盘龙区', '412', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2731', '1', '官渡区', '412', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2732', '1', '西山区', '412', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2733', '1', '东川区', '412', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2734', '1', '呈贡县', '412', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2735', '1', '晋宁县', '412', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2736', '1', '富民县', '412', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2737', '1', '宜良县', '412', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2738', '1', '石林彝族自治县', '412', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2739', '1', '嵩明县', '412', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2740', '1', '禄劝彝族苗族自治县', '412', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2741', '1', '寻甸回族彝族自治县', '412', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2742', '1', '安宁市', '412', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2743', '1', '麒麟区', '413', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2744', '1', '马龙县', '413', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2745', '1', '陆良县', '413', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2746', '1', '师宗县', '413', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2747', '1', '罗平县', '413', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2748', '1', '富源县', '413', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2749', '1', '会泽县', '413', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2750', '1', '沾益县', '413', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2751', '1', '宣威市', '413', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2752', '1', '红塔区', '414', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2753', '1', '江川县', '414', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2754', '1', '澄江县', '414', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2755', '1', '通海县', '414', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2756', '1', '华宁县', '414', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2757', '1', '易门县', '414', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2758', '1', '峨山彝族自治县', '414', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2759', '1', '新平彝族傣族自治县', '414', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2760', '1', '元江哈尼族彝族傣族自治县', '414', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2761', '1', '隆阳区', '415', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2762', '1', '施甸县', '415', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2763', '1', '腾冲县', '415', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2764', '1', '龙陵县', '415', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2765', '1', '昌宁县', '415', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2766', '1', '昭阳区', '416', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2767', '1', '鲁甸县', '416', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2768', '1', '巧家县', '416', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2769', '1', '盐津县', '416', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2770', '1', '大关县', '416', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2771', '1', '永善县', '416', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2772', '1', '绥江县', '416', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2773', '1', '镇雄县', '416', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2774', '1', '彝良县', '416', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2775', '1', '威信县', '416', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2776', '1', '水富县', '416', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2777', '1', '古城区', '417', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2778', '1', '玉龙纳西族自治县', '417', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2779', '1', '永胜县', '417', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2780', '1', '华坪县', '417', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2781', '1', '宁蒗彝族自治县', '417', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2782', '1', '翠云区', '418', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2783', '1', '普洱哈尼族彝族自治县', '418', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2784', '1', '墨江哈尼族自治县', '418', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2785', '1', '景东彝族自治县', '418', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2786', '1', '景谷傣族彝族自治县', '418', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2787', '1', '镇沅彝族哈尼族拉祜族自治县', '418', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2788', '1', '江城哈尼族彝族自治县', '418', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2789', '1', '孟连傣族拉祜族佤族自治县', '418', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2790', '1', '澜沧拉祜族自治县', '418', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2791', '1', '西盟佤族自治县', '418', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2792', '1', '临翔区', '419', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2793', '1', '凤庆县', '419', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2794', '1', '云县', '419', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2795', '1', '永德县', '419', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2796', '1', '镇康县', '419', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2797', '1', '双江拉祜族佤族布朗族傣族自治县', '419', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2798', '1', '耿马傣族佤族自治县', '419', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2799', '1', '沧源佤族自治县', '420', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2800', '1', '楚雄市', '420', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2801', '1', '双柏县', '420', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2802', '1', '牟定县', '420', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2803', '1', '南华县', '420', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2804', '1', '姚安县', '420', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2805', '1', '大姚县', '420', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2806', '1', '永仁县', '420', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2807', '1', '元谋县', '420', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2808', '1', '武定县', '420', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2809', '1', '禄丰县', '420', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2810', '1', '个旧市', '421', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2811', '1', '开远市', '421', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2812', '1', '蒙自县', '421', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2813', '1', '屏边苗族自治县', '421', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2814', '1', '建水县', '421', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2815', '1', '石屏县', '421', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2816', '1', '弥勒县', '421', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2817', '1', '泸西县', '421', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2818', '1', '元阳县', '421', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2819', '1', '红河县', '421', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2820', '1', '金平苗族瑶族傣族自治县', '421', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2821', '1', '绿春县', '421', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2822', '1', '河口瑶族自治县', '421', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2823', '1', '文山县', '422', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2824', '1', '砚山县', '422', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2825', '1', '西畴县', '422', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2826', '1', '麻栗坡县', '422', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2827', '1', '马关县', '422', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2828', '1', '丘北县', '422', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2829', '1', '广南县', '422', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2830', '1', '富宁县', '422', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2831', '1', '景洪市', '423', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2832', '1', '勐海县', '423', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2833', '1', '勐腊县', '423', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2834', '1', '大理市', '424', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2835', '1', '漾濞彝族自治县', '424', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2836', '1', '祥云县', '424', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2837', '1', '宾川县', '424', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2838', '1', '弥渡县', '424', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2839', '1', '南涧彝族自治县', '424', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2840', '1', '巍山彝族回族自治县', '424', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2841', '1', '永平县', '424', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2842', '1', '云龙县', '424', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2843', '1', '洱源县', '424', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2844', '1', '剑川县', '424', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2845', '1', '鹤庆县', '424', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2846', '1', '瑞丽市', '425', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2847', '1', '潞西市', '425', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2848', '1', '梁河县', '425', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2849', '1', '盈江县', '425', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2850', '1', '陇川县', '425', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2851', '1', '泸水县', '426', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2852', '1', '福贡县', '426', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2853', '1', '贡山独龙族怒族自治县', '426', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2854', '1', '兰坪白族普米族自治县', '426', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2855', '1', '香格里拉县', '427', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2856', '1', '德钦县', '427', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2857', '1', '维西傈僳族自治县', '427', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2858', '1', '城关区', '428', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2859', '1', '林周县', '428', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2860', '1', '当雄县', '428', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2861', '1', '尼木县', '428', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2862', '1', '曲水县', '428', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2863', '1', '堆龙德庆县', '428', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2864', '1', '达孜县', '428', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2865', '1', '墨竹工卡县', '428', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2866', '1', '昌都县', '429', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2867', '1', '江达县', '429', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2868', '1', '贡觉县', '429', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2869', '1', '类乌齐县', '429', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2870', '1', '丁青县', '429', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2871', '1', '察雅县', '429', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2872', '1', '八宿县', '429', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2873', '1', '左贡县', '429', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2874', '1', '芒康县', '429', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2875', '1', '洛隆县', '429', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2876', '1', '边坝县', '429', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2877', '1', '乃东县', '430', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2878', '1', '扎囊县', '430', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2879', '1', '贡嘎县', '430', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2880', '1', '桑日县', '430', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2881', '1', '琼结县', '430', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2882', '1', '曲松县', '430', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2883', '1', '措美县', '430', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2884', '1', '洛扎县', '430', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2885', '1', '加查县', '430', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2886', '1', '隆子县', '430', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2887', '1', '错那县', '430', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2888', '1', '浪卡子县', '430', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2889', '1', '日喀则市', '431', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2890', '1', '南木林县', '431', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2891', '1', '江孜县', '431', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2892', '1', '定日县', '431', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2893', '1', '萨迦县', '431', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2894', '1', '拉孜县', '431', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2895', '1', '昂仁县', '431', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2896', '1', '谢通门县', '431', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2897', '1', '白朗县', '431', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2898', '1', '仁布县', '431', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2899', '1', '康马县', '431', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2900', '1', '定结县', '431', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2901', '1', '仲巴县', '431', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2902', '1', '亚东县', '431', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2903', '1', '吉隆县', '431', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2904', '1', '聂拉木县', '431', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2905', '1', '萨嘎县', '431', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2906', '1', '岗巴县', '431', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2907', '1', '那曲县', '432', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2908', '1', '嘉黎县', '432', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2909', '1', '比如县', '432', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2910', '1', '聂荣县', '432', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2911', '1', '安多县', '432', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2912', '1', '申扎县', '432', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2913', '1', '索县', '432', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2914', '1', '班戈县', '432', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2915', '1', '巴青县', '432', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2916', '1', '尼玛县', '432', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2917', '1', '普兰县', '433', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2918', '1', '札达县', '433', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2919', '1', '噶尔县', '433', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2920', '1', '日土县', '433', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2921', '1', '革吉县', '433', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2922', '1', '改则县', '433', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2923', '1', '措勤县', '433', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2924', '1', '林芝县', '434', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2925', '1', '工布江达县', '434', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2926', '1', '米林县', '434', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2927', '1', '墨脱县', '434', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2928', '1', '波密县', '434', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2929', '1', '察隅县', '434', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2930', '1', '朗县', '434', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2931', '1', '新城区', '435', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2932', '1', '碑林区', '435', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2933', '1', '莲湖区', '435', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2934', '1', '灞桥区', '435', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2935', '1', '未央区', '435', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2936', '1', '雁塔区', '435', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2937', '1', '阎良区', '435', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2938', '1', '临潼区', '435', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2939', '1', '长安区', '435', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2940', '1', '蓝田县', '435', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2941', '1', '周至县', '435', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2942', '1', '户县', '435', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2943', '1', '高陵县', '435', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2944', '1', '王益区', '436', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2945', '1', '印台区', '436', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2946', '1', '耀州区', '436', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2947', '1', '宜君县', '436', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2948', '1', '渭滨区', '437', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2949', '1', '金台区', '437', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2950', '1', '陈仓区', '437', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2951', '1', '凤翔县', '437', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2952', '1', '岐山县', '437', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2953', '1', '扶风县', '437', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2954', '1', '眉县', '437', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2955', '1', '陇县', '437', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2956', '1', '千阳县', '437', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2957', '1', '麟游县', '437', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2958', '1', '凤县', '437', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2959', '1', '太白县', '437', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2960', '1', '秦都区', '438', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2961', '1', '杨凌区', '438', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2962', '1', '渭城区', '438', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2963', '1', '三原县', '438', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2964', '1', '泾阳县', '438', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2965', '1', '乾县', '438', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2966', '1', '礼泉县', '438', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2967', '1', '永寿县', '438', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2968', '1', '彬县', '438', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2969', '1', '长武县', '438', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2970', '1', '旬邑县', '438', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2971', '1', '淳化县', '438', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2972', '1', '武功县', '438', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2973', '1', '兴平市', '438', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2974', '1', '临渭区', '439', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2975', '1', '华县', '439', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2976', '1', '潼关县', '439', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2977', '1', '大荔县', '439', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2978', '1', '合阳县', '439', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2979', '1', '澄城县', '439', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2980', '1', '蒲城县', '439', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2981', '1', '白水县', '439', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2982', '1', '富平县', '439', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2983', '1', '韩城市', '439', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2984', '1', '华阴市', '439', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2985', '1', '宝塔区', '440', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2986', '1', '延长县', '440', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2987', '1', '延川县', '440', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2988', '1', '子长县', '440', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2989', '1', '安塞县', '440', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2990', '1', '志丹县', '440', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2991', '1', '吴起县', '440', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2992', '1', '甘泉县', '440', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2993', '1', '富县', '440', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2994', '1', '洛川县', '440', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2995', '1', '宜川县', '440', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2996', '1', '黄龙县', '440', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2997', '1', '黄陵县', '440', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2998', '1', '汉台区', '441', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('2999', '1', '南郑县', '441', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3000', '1', '城固县', '441', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3001', '1', '洋县', '441', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3002', '1', '西乡县', '441', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3003', '1', '勉县', '441', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3004', '1', '宁强县', '441', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3005', '1', '略阳县', '441', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3006', '1', '镇巴县', '441', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3007', '1', '留坝县', '441', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3008', '1', '佛坪县', '441', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3009', '1', '榆阳区', '442', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3010', '1', '神木县', '442', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3011', '1', '府谷县', '442', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3012', '1', '横山县', '442', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3013', '1', '靖边县', '442', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3014', '1', '定边县', '442', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3015', '1', '绥德县', '442', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3016', '1', '米脂县', '442', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3017', '1', '佳县', '442', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3018', '1', '吴堡县', '442', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3019', '1', '清涧县', '442', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3020', '1', '子洲县', '442', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3021', '1', '汉滨区', '443', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3022', '1', '汉阴县', '443', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3023', '1', '石泉县', '443', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3024', '1', '宁陕县', '443', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3025', '1', '紫阳县', '443', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3026', '1', '岚皋县', '443', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3027', '1', '平利县', '443', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3028', '1', '镇坪县', '443', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3029', '1', '旬阳县', '443', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3030', '1', '白河县', '443', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3031', '1', '商州区', '444', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3032', '1', '洛南县', '444', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3033', '1', '丹凤县', '444', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3034', '1', '商南县', '444', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3035', '1', '山阳县', '444', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3036', '1', '镇安县', '444', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3037', '1', '柞水县', '444', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3038', '1', '城关区', '445', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3039', '1', '七里河区', '445', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3040', '1', '西固区', '445', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3041', '1', '安宁区', '445', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3042', '1', '红古区', '445', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3043', '1', '永登县', '445', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3044', '1', '皋兰县', '445', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3045', '1', '榆中县', '445', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3046', '1', '金川区', '447', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3047', '1', '永昌县', '447', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3048', '1', '白银区', '448', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3049', '1', '平川区', '448', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3050', '1', '靖远县', '448', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3051', '1', '会宁县', '448', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3052', '1', '景泰县', '448', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3053', '1', '秦城区', '449', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3054', '1', '北道区', '449', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3055', '1', '清水县', '449', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3056', '1', '秦安县', '449', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3057', '1', '甘谷县', '449', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3058', '1', '武山县', '449', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3059', '1', '张家川回族自治县', '449', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3060', '1', '凉州区', '450', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3061', '1', '民勤县', '450', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3062', '1', '古浪县', '450', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3063', '1', '天祝藏族自治县', '450', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3064', '1', '甘州区', '451', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3065', '1', '肃南裕固族自治县', '451', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3066', '1', '民乐县', '451', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3067', '1', '临泽县', '451', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3068', '1', '高台县', '451', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3069', '1', '山丹县', '451', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3070', '1', '崆峒区', '452', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3071', '1', '泾川县', '452', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3072', '1', '灵台县', '452', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3073', '1', '崇信县', '452', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3074', '1', '华亭县', '452', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3075', '1', '庄浪县', '452', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3076', '1', '静宁县', '452', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3077', '1', '肃州区', '453', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3078', '1', '金塔县', '453', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3079', '1', '瓜州县', '453', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3080', '1', '肃北蒙古族自治县', '453', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3081', '1', '阿克塞哈萨克族自治县', '453', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3082', '1', '玉门市', '453', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3083', '1', '敦煌市', '453', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3084', '1', '西峰区', '454', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3085', '1', '庆城县', '454', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3086', '1', '环县', '454', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3087', '1', '华池县', '454', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3088', '1', '合水县', '454', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3089', '1', '正宁县', '454', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3090', '1', '宁县', '454', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3091', '1', '镇原县', '454', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3092', '1', '安定区', '455', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3093', '1', '通渭县', '455', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3094', '1', '陇西县', '455', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3095', '1', '渭源县', '455', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3096', '1', '临洮县', '455', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3097', '1', '漳县', '455', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3098', '1', '岷县', '455', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3099', '1', '武都区', '456', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3100', '1', '成县', '456', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3101', '1', '文县', '456', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3102', '1', '宕昌县', '456', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3103', '1', '康县', '456', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3104', '1', '西和县', '456', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3105', '1', '礼县', '456', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3106', '1', '徽县', '456', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3107', '1', '两当县', '456', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3108', '1', '临夏市', '457', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3109', '1', '临夏县', '457', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3110', '1', '康乐县', '457', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3111', '1', '永靖县', '457', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3112', '1', '广河县', '457', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3113', '1', '和政县', '457', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3114', '1', '东乡族自治县', '457', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3115', '1', '积石山保安族东乡族撒拉族自治县', '457', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3116', '1', '合作市', '458', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3117', '1', '临潭县', '458', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3118', '1', '卓尼县', '458', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3119', '1', '舟曲县', '458', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3120', '1', '迭部县', '458', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3121', '1', '玛曲县', '458', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3122', '1', '碌曲县', '458', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3123', '1', '夏河县', '458', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3124', '1', '城东区', '459', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3125', '1', '城中区', '459', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3126', '1', '城西区', '459', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3127', '1', '城北区', '459', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3128', '1', '大通回族土族自治县', '459', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3129', '1', '湟中县', '459', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3130', '1', '湟源县', '459', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3131', '1', '平安县', '460', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3132', '1', '民和回族土族自治县', '460', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3133', '1', '乐都县', '460', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3134', '1', '互助土族自治县', '460', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3135', '1', '化隆回族自治县', '460', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3136', '1', '循化撒拉族自治县', '460', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3137', '1', '门源回族自治县', '461', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3138', '1', '祁连县', '461', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3139', '1', '海晏县', '461', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3140', '1', '刚察县', '461', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3141', '1', '同仁县', '462', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3142', '1', '尖扎县', '462', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3143', '1', '泽库县', '462', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3144', '1', '河南蒙古族自治县', '462', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3145', '1', '共和县', '463', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3146', '1', '同德县', '463', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3147', '1', '贵德县', '463', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3148', '1', '兴海县', '463', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3149', '1', '贵南县', '463', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3150', '1', '玛沁县', '464', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3151', '1', '班玛县', '464', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3152', '1', '甘德县', '464', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3153', '1', '达日县', '464', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3154', '1', '久治县', '464', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3155', '1', '玛多县', '464', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3156', '1', '玉树县', '465', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3157', '1', '杂多县', '465', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3158', '1', '称多县', '465', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3159', '1', '治多县', '465', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3160', '1', '囊谦县', '465', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3161', '1', '曲麻莱县', '465', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3162', '1', '格尔木市', '466', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3163', '1', '德令哈市', '466', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3164', '1', '乌兰县', '466', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3165', '1', '都兰县', '466', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3166', '1', '天峻县', '466', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3167', '1', '兴庆区', '467', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3168', '1', '西夏区', '467', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3169', '1', '金凤区', '467', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3170', '1', '永宁县', '467', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3171', '1', '贺兰县', '467', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3172', '1', '灵武市', '467', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3173', '1', '大武口区', '468', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3174', '1', '惠农区', '468', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3175', '1', '平罗县', '468', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3176', '1', '利通区', '469', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3177', '1', '盐池县', '469', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3178', '1', '同心县', '469', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3179', '1', '青铜峡市', '469', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3180', '1', '原州区', '470', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3181', '1', '西吉县', '470', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3182', '1', '隆德县', '470', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3183', '1', '泾源县', '470', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3184', '1', '彭阳县', '470', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3185', '1', '沙坡头区', '471', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3186', '1', '中宁县', '471', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3187', '1', '海原县', '471', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3188', '1', '天山区', '472', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3189', '1', '沙依巴克区', '472', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3190', '1', '新市区', '472', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3191', '1', '水磨沟区', '472', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3192', '1', '头屯河区', '472', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3193', '1', '达坂城区', '472', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3194', '1', '东山区', '472', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3195', '1', '乌鲁木齐县', '472', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3196', '1', '独山子区', '473', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3197', '1', '克拉玛依区', '473', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3198', '1', '白碱滩区', '473', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3199', '1', '乌尔禾区', '473', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3200', '1', '吐鲁番市', '474', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3201', '1', '鄯善县', '474', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3202', '1', '托克逊县', '474', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3203', '1', '哈密市', '475', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3204', '1', '巴里坤哈萨克自治县', '475', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3205', '1', '伊吾县', '475', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3206', '1', '昌吉市', '476', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3207', '1', '阜康市', '476', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3208', '1', '米泉市', '476', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3209', '1', '呼图壁县', '476', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3210', '1', '玛纳斯县', '476', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3211', '1', '奇台县', '476', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3212', '1', '吉木萨尔县', '476', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3213', '1', '木垒哈萨克自治县', '476', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3214', '1', '博乐市', '477', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3215', '1', '精河县', '477', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3216', '1', '温泉县', '477', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3217', '1', '库尔勒市', '478', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3218', '1', '轮台县', '478', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3219', '1', '尉犁县', '478', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3220', '1', '若羌县', '478', '0', '0', '', 'r', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3221', '1', '且末县', '478', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3222', '1', '焉耆回族自治县', '478', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3223', '1', '和静县', '478', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3224', '1', '和硕县', '478', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3225', '1', '博湖县', '478', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3226', '1', '阿克苏市', '479', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3227', '1', '温宿县', '479', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3228', '1', '库车县', '479', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3229', '1', '沙雅县', '479', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3230', '1', '新和县', '479', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3231', '1', '拜城县', '479', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3232', '1', '乌什县', '479', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3233', '1', '阿瓦提县', '479', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3234', '1', '柯坪县', '479', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3235', '1', '阿图什市', '480', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3236', '1', '阿克陶县', '480', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3237', '1', '阿合奇县', '480', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3238', '1', '乌恰县', '480', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3239', '1', '喀什市', '481', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3240', '1', '疏附县', '481', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3241', '1', '疏勒县', '481', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3242', '1', '英吉沙县', '481', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3243', '1', '泽普县', '481', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3244', '1', '莎车县', '481', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3245', '1', '叶城县', '481', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3246', '1', '麦盖提县', '481', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3247', '1', '岳普湖县', '481', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3248', '1', '伽师县', '481', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3249', '1', '巴楚县', '481', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3250', '1', '塔什库尔干塔吉克自治县', '481', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3251', '1', '和田市', '482', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3252', '1', '和田县', '482', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3253', '1', '墨玉县', '482', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3254', '1', '皮山县', '482', '0', '0', '', 'p', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3255', '1', '洛浦县', '482', '0', '0', '', 'l', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3256', '1', '策勒县', '482', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3257', '1', '于田县', '482', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3258', '1', '民丰县', '482', '0', '0', '', 'm', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3259', '1', '伊宁市', '483', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3260', '1', '奎屯市', '483', '0', '0', '', 'k', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3261', '1', '伊宁县', '483', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3262', '1', '察布查尔锡伯自治县', '483', '0', '0', '', 'c', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3263', '1', '霍城县', '483', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3264', '1', '巩留县', '483', '0', '0', '', 'g', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3265', '1', '新源县', '483', '0', '0', '', 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3266', '1', '昭苏县', '483', '0', '0', '', 'z', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3267', '1', '特克斯县', '483', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3268', '1', '尼勒克县', '483', '0', '0', '', 'n', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3269', '1', '塔城市', '484', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3270', '1', '乌苏市', '484', '0', '0', '', 'w', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3271', '1', '额敏县', '484', '0', '0', '', 'e', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3272', '1', '沙湾县', '484', '0', '0', '', 's', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3273', '1', '托里县', '484', '0', '0', '', 't', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3274', '1', '裕民县', '484', '0', '0', '', 'y', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3275', '1', '和布克赛尔蒙古自治县', '484', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3276', '1', '阿勒泰市', '485', '0', '0', '', 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3277', '1', '布尔津县', '485', '0', '0', '', 'b', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3278', '1', '富蕴县', '485', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3279', '1', '福海县', '485', '0', '0', '', 'f', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3280', '1', '哈巴河县', '485', '0', '0', '', 'h', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3281', '1', '青河县', '485', '0', '0', '', 'q', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3282', '1', '吉木乃县', '485', '0', '0', '', 'j', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3358', '1', '钓鱼岛', '0', '1', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3359', '1', '钓鱼岛', '3358', '0', '0', '', 'd', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3360', '1', '北京市', '2', '1', '0', '', 'b', 'bj', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3361', '1', '上海市', '3', '1', '0', null, 's', 'sh', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3362', '1', '天津市', '4', '1', '0', null, 't', 'tj', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3363', '1', '重庆市', '5', '1', '0', null, 'z', 'cq', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3364', '1', '香港', '34', '1', '0', null, 'x', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3365', '1', '澳门', '35', '1', '0', null, 'a', '', '', '', '0');
INSERT INTO `wz_linkage_data` VALUES ('3366', '2', '默认分类', '0', '0', '0', '', 'm', '', '', '', '0');

-- ----------------------------
-- Table structure for wz_logintime
-- ----------------------------
DROP TABLE IF EXISTS `wz_logintime`;
CREATE TABLE `wz_logintime` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL COMMENT '登录状态：0，后台登录失败，1后台登录成功，2，前台登录失败，3前台登录成功',
  `logintime` int(10) unsigned NOT NULL,
  `ip` char(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`status`,`logintime`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for wz_logs
-- ----------------------------
DROP TABLE IF EXISTS `wz_logs`;
CREATE TABLE `wz_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `m` varchar(20) NOT NULL,
  `f` varchar(20) NOT NULL,
  `v` varchar(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6377 DEFAULT CHARSET=utf8 COMMENT='管理员操作日志';


-- ----------------------------
-- Table structure for wz_member
-- ----------------------------
DROP TABLE IF EXISTS `wz_member`;
CREATE TABLE `wz_member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ucuid` int(10) unsigned NOT NULL,
  `username` char(20) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `factor` char(6) NOT NULL,
  `avatar` varchar(500) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL COMMENT '电子邮箱',
  `modelid` mediumint(8) unsigned NOT NULL DEFAULT 0 COMMENT '用户模型',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT 3 COMMENT '用户组',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否锁定',
  `locktime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '解锁时间',
  `regip` char(15) NOT NULL COMMENT '注册ip',
  `lastip` char(15) NOT NULL COMMENT '最后登录ip',
  `regtime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '注册时间',
  `lasttime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `loginnum` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '登录次数',
  `ischeck_email` tinyint(1) NOT NULL DEFAULT 0,
  `ischeck_mobile` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否验证过',
  `sys_name` tinyint(1) NOT NULL DEFAULT 0,
  `pw_reset` tinyint(1) NOT NULL DEFAULT 1,
  `mobile` varchar(255) NOT NULL COMMENT '手机号',
  `org_id` int(11) NOT NULL COMMENT '单位ID',
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `ucuid` (`ucuid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- ----------------------------
-- Table structure for wz_member_auth
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_auth`;
CREATE TABLE `wz_member_auth` (
  `authid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `token` char(100) NOT NULL,
  `openid` char(32) NOT NULL,
  `type` char(10) NOT NULL,
  `expires_in` int(10) unsigned NOT NULL,
  `extend` varchar(500) NOT NULL,
  PRIMARY KEY (`authid`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_member_auth
-- ----------------------------

-- ----------------------------
-- Table structure for wz_member_detail_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_detail_data`;
CREATE TABLE `wz_member_detail_data` (
  `uid` smallint(5) unsigned NOT NULL,
  `level` char(255) NOT NULL DEFAULT '',
  `manuscript` char(255) NOT NULL DEFAULT '',
  `pseudonym` char(255) NOT NULL DEFAULT '',
  `company` char(255) NOT NULL DEFAULT '',
  `placeOfOrigin` char(255) NOT NULL DEFAULT '',
  `armyDate` char(255) NOT NULL DEFAULT '',
  `job` char(255) NOT NULL DEFAULT '',
  `militaryRank` char(255) NOT NULL DEFAULT '1',
  `preference` text NOT NULL,
  `Profile` text NOT NULL,
  `linktel` char(255) NOT NULL DEFAULT '',
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_member_detail_data
-- ----------------------------
INSERT INTO `wz_member_detail_data` VALUES ('1', '', '', '', '', '', '', '', '1', '', '', '');

-- ----------------------------
-- Table structure for wz_member_group
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_group`;
CREATE TABLE `wz_member_group` (
  `groupid` tinyint(1) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员组id',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(15) NOT NULL COMMENT '组名',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是内置会员组',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最低点数',
  `upgrade` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许自主升级',
  `money_y` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '年价格',
  `money_m` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '月价格',
  `money_d` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '天价格',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `icon` varchar(10) NOT NULL COMMENT '样式',
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='会员组表';

-- ----------------------------
-- Records of wz_member_group
-- ----------------------------
INSERT INTO `wz_member_group` VALUES ('3', '0', '普通用户', '1', '0', '0', '0.00', '0.00', '0.00', '10', 'level1');
-- ----------------------------
-- Table structure for wz_member_group_extend
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_group_extend`;
CREATE TABLE `wz_member_group_extend` (
  `extid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `unit` enum('y','m','d') NOT NULL DEFAULT 'y',
  `price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `startdate` date NOT NULL DEFAULT '0000-00-00',
  `enddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`extid`),
  UNIQUE KEY `uid` (`uid`,`groupid`),
  KEY `groupid` (`groupid`,`disabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_member_group_extend
-- ----------------------------

-- ----------------------------
-- Table structure for wz_member_group_priv
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_group_priv`;
CREATE TABLE `wz_member_group_priv` (
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `value` char(15) NOT NULL,
  `priv` char(15) NOT NULL,
  PRIMARY KEY (`groupid`,`value`,`priv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for wz_member_invite
-- ----------------------------
DROP TABLE IF EXISTS `wz_member_invite`;
CREATE TABLE `wz_member_invite` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `isbuy` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是付费购买',
  `invite` char(8) NOT NULL COMMENT '邀请码',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `usingtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
  `usinguid` int(10) unsigned NOT NULL COMMENT '使用者',
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邀请码表';

-- ----------------------------
-- Table structure for wz_org
-- ----------------------------
DROP TABLE IF EXISTS `wz_org`;
CREATE TABLE `wz_org` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '单位名称',
  `pid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `org_leader` varchar(255) NOT NULL COMMENT '部门负责人',
  `org_leader_tel` varchar(255) NOT NULL COMMENT '单位负责人联系电话',
  `org_leader_email` varchar(255) NOT NULL COMMENT '单位负责人邮箱',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 正常  0 停用',
  `siteid` int(11) NOT NULL DEFAULT 1 COMMENT '站点ID',
  `child` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wz_menu
-- ----------------------------
DROP TABLE IF EXISTS `wz_menu`;
CREATE TABLE `wz_menu` (
  `menuid` mediumint(8) unsigned NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `name` char(20) NOT NULL COMMENT '菜单中文名',
  `m` char(20) NOT NULL COMMENT 'm',
  `f` char(20) NOT NULL COMMENT 'f',
  `v` char(20) NOT NULL COMMENT 'v',
  `data` char(40) NOT NULL COMMENT '附加参数',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示，隐藏的菜单不写入',
  `isopenid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of wz_menu
-- ----------------------------
INSERT INTO `wz_menu` VALUES ('1', '0', '我的面板', 'core', 'panel', '', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('2', '0', '系统设置', 'core', 'set', '', '', '6', '1', '0');
INSERT INTO `wz_menu` VALUES ('3', '0', '发布内容', 'content', 'content', '', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('221', '220', '积分兑换商品订单', 'order', 'index', 'listing', '', '221', '1', '0');
INSERT INTO `wz_menu` VALUES ('5', '0', '扩展模块', 'core', 'module', '', '', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('6', '0', '管理会员', 'member', 'index', '', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('7', '0', '维护界面', 'template', 'index', '', '', '5', '1', '0');
INSERT INTO `wz_menu` VALUES ('20', '1', '个人信息', 'core', 'panel', 'edit_info', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('67', '29', '模块配置', 'attachment', 'index', 'set', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('22', '2', '基本设置', 'core', 'set', 'basic', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('23', '2', '安全设置', 'core', 'set', 'safe', '', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('24', '2', '邮件服务器', 'core', 'set', 'sendmail', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('25', '2', '更新缓存', 'core', 'cache_all', 'index', '', '4', '0', '0');
INSERT INTO `wz_menu` VALUES ('26', '3', '内容管理', 'content', 'content', 'manage', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('28', '4', '安装应用', 'appshop', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('29', '5', '附件管理', 'attachment', 'index', 'listing', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('30', '6', '会员管理', 'member', 'index', 'listing', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('31', '7', '模板管理', 'template', 'index', 'listing', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('32', '7', '静态资源管理', 'template', 'res', 'listing', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('33', '7', '后台菜单管理', 'core', 'menu', 'listing', '', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('166', '34', '排序', 'link', 'index', 'sort', '', '166', '0', '0');
INSERT INTO `wz_menu` VALUES ('10053', '2', '绩效管理', 'credit', 'set', 'recordlist', '', '7', '1', '0');
INSERT INTO `wz_menu` VALUES ('37', '5', '手机触屏', 'mobile', 'index', 'setting', '', '2', '0', '0');
INSERT INTO `wz_menu` VALUES ('91', '29', '编辑器附件配置', 'attachment', 'index', 'ueditor', '', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('40', '5', '联动菜单', 'linkage', 'index', 'listing', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('45', '3', '模型管理', 'core', 'model', 'model_listing', 'app=content', '8', '1', '0');
INSERT INTO `wz_menu` VALUES ('46', '3', '栏目管理', 'content', 'category', 'listing', '', '7', '1', '0');
INSERT INTO `wz_menu` VALUES ('47', '45', '添加共享模型', 'core', 'model', 'model_add', 'app=content&share_model=1', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('48', '45', '添加独立模型', 'core', 'model', 'model_add', 'app=content&share_model=0', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('49', '45', '字段管理', 'core', 'model', 'field_listing', '', '0', '2', '0');
INSERT INTO `wz_menu` VALUES ('50', '49', '添加字段', 'core', 'model', 'field_add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('51', '46', '添加栏目', 'content', 'category', 'add', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('52', '29', '目录模式', 'attachment', 'index', 'dir', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('54', '3', '来源管理', 'core', 'copyfrom', 'listing', '', '10', '1', '0');
INSERT INTO `wz_menu` VALUES ('55', '1', '后台操作日志', 'core', 'logs', 'listing', '', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('56', '2', '敏感词管理', 'core', 'badword', 'listing', '', '6', '1', '0');
INSERT INTO `wz_menu` VALUES ('57', '3', '推荐位管理', 'content', 'block', 'listing', '', '5', '1', '0');
INSERT INTO `wz_menu` VALUES ('58', '55', '后台登陆日志', 'core', 'logs', 'login_listing', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('107', '36', '充值入帐', 'pay', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('61', '2', '权限管理', 'core', 'power', 'listing', '', '5', '1', '0');
INSERT INTO `wz_menu` VALUES ('62', '61', '添加管理员', 'core', 'power', 'add', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('63', '61', '添加组（角色）', 'core', 'power', 'role_add', '', '12', '1', '0');
INSERT INTO `wz_menu` VALUES ('64', '61', '组管理（角色）管理', 'core', 'power', 'role_listing', '', '10', '1', '0');
INSERT INTO `wz_menu` VALUES ('68', '54', '添加来源', 'core', 'copyfrom', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10054', '10053', '积分策略', 'credit', 'set', 'listing', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('71', '24', '邮件发送测试', 'core', 'set', 'sendmail_test', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('72', '56', '添加敏感词', 'core', 'badword', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('73', '6', '模型设置', 'core', 'model', 'model_listing', 'app=member', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('74', '30', '添加会员', 'member', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('75', '30', '编辑会员', 'member', 'index', 'edit', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('76', '30', '删除会员', 'member', 'index', 'del', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('77', '73', '添加模型', 'core', 'model', 'model_add', 'app=member&share_model=1', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('79', '40', '添加联动菜单', 'linkage', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('80', '40', '管理选项', 'linkage', 'index', 'item_listing', '', '0', '2', '0');
INSERT INTO `wz_menu` VALUES ('81', '80', '添加选项', 'linkage', 'index', 'add_item', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('82', '78', '添加搜索分类', 'search', 'index', 'add', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('83', '78', '索引配置', 'search', 'config', 'index', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('84', '78', '重建索引', 'search', 'rebuild', 'index', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('92', '1', '系统首页', 'core', 'index', 'listing', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('86', '6', '会员组管理', 'member', 'group', 'listing', '', '2', '1', '0');
INSERT INTO `wz_menu` VALUES ('87', '86', '添加会员组', 'member', 'group', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('88', '86', '编辑会员组', 'member', 'group', 'edit', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('89', '86', '删除会员组', 'member', 'group', 'del', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('90', '6', '模块设置', 'member', 'index', 'set', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('94', '57', '添加推荐位', 'content', 'block', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('102', '3', '批量更新', 'content', 'createhtml', 'listing', '', '6', '1', '0');
INSERT INTO `wz_menu` VALUES ('165', '34', '删除', 'link', 'index', 'delete', '', '165', '0', '0');
INSERT INTO `wz_menu` VALUES ('105', '46', '添加单网页', 'content', 'category', 'add', 'type=1', '3', '1', '0');
INSERT INTO `wz_menu` VALUES ('106', '46', '添加外部链接', 'content', 'category', 'add', 'type=2', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('108', '36', '支付配置', 'pay', 'pay_config', 'listing', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('109', '37', '手机导航配置', 'mobile', 'index', 'category', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('110', '5', '系统公告', 'affiche', 'index', 'listing', '', '6', '1', '0');
INSERT INTO `wz_menu` VALUES ('111', '110', '添加公告', 'affiche', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('112', '1', '编辑操作日志', 'core', 'panel', 'editor_log', '', '4', '1', '0');
INSERT INTO `wz_menu` VALUES ('171', '114', '删除', 'guestbook', 'index', 'delete', '', '171', '0', '0');
INSERT INTO `wz_menu` VALUES ('115', '114', '模型设置', 'core', 'model', 'model_listing', 'app=guestbook', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('116', '92', '后台首页', 'core', 'index', 'init', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('117', '26', '栏目树状列表', 'content', 'content', 'left', '', '117', '0', '0');
INSERT INTO `wz_menu` VALUES ('118', '26', '内容列表', 'content', 'content', 'listing', '', '118', '0', '0');
INSERT INTO `wz_menu` VALUES ('119', '26', '内容修改', 'content', 'content', 'edit', '', '119', '0', '0');
INSERT INTO `wz_menu` VALUES ('120', '26', '预览', 'content', 'content', 'view', '', '120', '0', '0');
INSERT INTO `wz_menu` VALUES ('121', '26', '彻底删除', 'content', 'content', 'delete', '', '121', '0', '0');
INSERT INTO `wz_menu` VALUES ('122', '26', '排序', 'content', 'content', 'sort', '', '122', '0', '0');
INSERT INTO `wz_menu` VALUES ('123', '26', '移动', 'content', 'content', 'move', '', '123', '0', '0');
INSERT INTO `wz_menu` VALUES ('124', '26', '高级搜索', 'content', 'content', 'search', '', '124', '0', '0');
INSERT INTO `wz_menu` VALUES ('125', '26', '删除到回收站', 'content', 'content', 'recycle_delete', '', '125', '0', '0');
INSERT INTO `wz_menu` VALUES ('126', '57', '修改', 'content', 'block', 'edit', '', '126', '0', '0');
INSERT INTO `wz_menu` VALUES ('127', '57', '删除', 'content', 'block', 'delete', '', '127', '0', '0');
INSERT INTO `wz_menu` VALUES ('128', '57', '生成静态', 'content', 'block', 'html', '', '128', '0', '0');
INSERT INTO `wz_menu` VALUES ('129', '57', '内容管理', 'content', 'block', 'item_listing', '', '129', '2', '0');
INSERT INTO `wz_menu` VALUES ('130', '57', '列表内容修改', 'content', 'block', 'item_edit', '', '130', '0', '0');
INSERT INTO `wz_menu` VALUES ('131', '57', '列表内容排序', 'content', 'block', 'item_sort', '', '131', '0', '0');
INSERT INTO `wz_menu` VALUES ('132', '26', '添加内容', 'content', 'content', 'add', '', '132', '0', '0');
INSERT INTO `wz_menu` VALUES ('133', '57', '列表内容删除', 'content', 'block', 'item_delete', '', '133', '0', '0');
INSERT INTO `wz_menu` VALUES ('134', '102', '批量生成栏目', 'content', 'createhtml', 'htmllist', '', '134', '0', '0');
INSERT INTO `wz_menu` VALUES ('135', '102', '批量生成内容', 'content', 'createhtml', 'htmlshow', '', '135', '0', '0');
INSERT INTO `wz_menu` VALUES ('136', '102', '批量更新URL', 'content', 'createhtml', 'updateurls', '', '136', '0', '0');
INSERT INTO `wz_menu` VALUES ('137', '46', '修改', 'content', 'category', 'edit', '', '137', '0', '0');
INSERT INTO `wz_menu` VALUES ('138', '46', '删除', 'content', 'category', 'delete', '', '138', '0', '0');
INSERT INTO `wz_menu` VALUES ('139', '46', '排序', 'content', 'category', 'sort', '', '139', '0', '0');
INSERT INTO `wz_menu` VALUES ('140', '46', '修复栏目', 'content', 'category', 'repair', '', '140', '0', '0');
INSERT INTO `wz_menu` VALUES ('141', '45', '字段添加', 'core', 'model', 'field_add', '', '141', '0', '0');
INSERT INTO `wz_menu` VALUES ('142', '45', '字段修改', 'core', 'model', 'field_edit', '', '142', '0', '0');
INSERT INTO `wz_menu` VALUES ('143', '45', '字段删除', 'core', 'model', 'field_delete', '', '143', '0', '0');
INSERT INTO `wz_menu` VALUES ('144', '45', '更新模型缓存', 'core', 'model', 'cache_form', '', '144', '0', '0');
INSERT INTO `wz_menu` VALUES ('145', '45', '字段排序', 'core', 'model', 'field_sort', '', '145', '0', '0');
INSERT INTO `wz_menu` VALUES ('146', '45', '字段禁用', 'core', 'model', 'field_baned', '', '146', '0', '0');
INSERT INTO `wz_menu` VALUES ('147', '54', '修改', 'core', 'copyfrom', 'edit', '', '147', '0', '0');
INSERT INTO `wz_menu` VALUES ('148', '54', '删除', 'core', 'copyfrom', 'delete', '', '148', '0', '0');
INSERT INTO `wz_menu` VALUES ('301', '2', '自定义全局变量', 'core', 'set', 'global_vars', '', '9', '1', '0');
INSERT INTO `wz_menu` VALUES ('151', '78', '删除', 'search', 'index', 'del', '', '151', '0', '0');
INSERT INTO `wz_menu` VALUES ('152', '29', '删除', 'attachment', 'index', 'del', '', '152', '0', '0');
INSERT INTO `wz_menu` VALUES ('154', '36', '查看交易详情', 'pay', 'index', 'view', '', '154', '0', '0');
INSERT INTO `wz_menu` VALUES ('155', '36', '删除支付记录', 'pay', 'index', 'delete', '', '155', '0', '0');
INSERT INTO `wz_menu` VALUES ('156', '36', '配置修改', 'pay', 'pay_config', 'edit', '', '156', '0', '0');
INSERT INTO `wz_menu` VALUES ('157', '36', '改价', 'pay', 'index', 'edit', '', '157', '0', '0');
INSERT INTO `wz_menu` VALUES ('158', '40', '添加选项', 'linkage', 'index', 'add_item', '', '158', '0', '0');
INSERT INTO `wz_menu` VALUES ('159', '40', '排序', 'linkage', 'index', 'sort', '', '159', '0', '0');
INSERT INTO `wz_menu` VALUES ('160', '40', '删除联动菜单', 'linkage', 'index', 'delete', '', '160', '0', '0');
INSERT INTO `wz_menu` VALUES ('161', '40', '删除选项', 'linkage', 'index', 'delete_item', '', '161', '0', '0');
INSERT INTO `wz_menu` VALUES ('162', '40', '修改联动菜单', 'linkage', 'index', 'edit', '', '162', '0', '0');
INSERT INTO `wz_menu` VALUES ('163', '40', '修改选项', 'linkage', 'index', 'edit_item', '', '163', '0', '0');
INSERT INTO `wz_menu` VALUES ('164', '34', '修改', 'link', 'index', 'edit', '', '164', '0', '0');
INSERT INTO `wz_menu` VALUES ('104', '34', '添加友情链接', 'link', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('34', '5', '友情链接', 'link', 'index', 'listing', '', '5', '1', '0');
INSERT INTO `wz_menu` VALUES ('167', '110', '修改', 'affiche', 'index', 'edit', '', '167', '0', '0');
INSERT INTO `wz_menu` VALUES ('168', '110', '删除', 'affiche', 'index', 'delete', '', '168', '0', '0');
INSERT INTO `wz_menu` VALUES ('169', '110', '排序', 'affiche', 'index', 'sort', '', '169', '0', '0');
INSERT INTO `wz_menu` VALUES ('170', '114', '回复', 'guestbook', 'index', 'reply', '', '170', '0', '0');
INSERT INTO `wz_menu` VALUES ('114', '5', '留言板', 'guestbook', 'index', 'listing', '', '7', '1', '0');
INSERT INTO `wz_menu` VALUES ('172', '30', '重置密码', 'member', 'index', 'password', '', '172', '0', '0');
INSERT INTO `wz_menu` VALUES ('173', '26', '检查重复标题', 'content', 'content', 'checktitle', '', '173', '0', '0');
INSERT INTO `wz_menu` VALUES ('174', '61', '工作流', 'core', 'workflow', 'listing', '', '50', '1', '0');
INSERT INTO `wz_menu` VALUES ('175', '31', '修改', 'template', 'index', 'edit', '', '175', '0', '0');
INSERT INTO `wz_menu` VALUES ('176', '31', '历史版本', 'template', 'index', 'history', '', '176', '0', '0');
INSERT INTO `wz_menu` VALUES ('177', '31', '查看', 'template', 'index', 'view', '', '177', '0', '0');
INSERT INTO `wz_menu` VALUES ('178', '31', '删除', 'template', 'index', 'delete', '', '178', '0', '0');
INSERT INTO `wz_menu` VALUES ('179', '31', '添加', 'template', 'index', 'add', '', '179', '0', '0');
INSERT INTO `wz_menu` VALUES ('180', '32', '查看', 'template', 'res', 'view', '', '180', '0', '0');
INSERT INTO `wz_menu` VALUES ('181', '32', '修改', 'template', 'res', 'edit', '', '181', '0', '0');
INSERT INTO `wz_menu` VALUES ('182', '32', '历史版本', 'template', 'res', 'history', '', '182', '0', '0');
INSERT INTO `wz_menu` VALUES ('183', '32', '删除', 'template', 'res', 'delete', '', '183', '0', '0');
INSERT INTO `wz_menu` VALUES ('184', '33', '添加', 'core', 'menu', 'add', '', '184', '0', '0');
INSERT INTO `wz_menu` VALUES ('185', '33', '修改', 'core', 'menu', 'edit', '', '185', '0', '0');
INSERT INTO `wz_menu` VALUES ('186', '33', '删除', 'core', 'menu', 'delete', '', '186', '0', '0');
INSERT INTO `wz_menu` VALUES ('187', '33', '排序', 'core', 'menu', 'sort', '', '187', '0', '0');
INSERT INTO `wz_menu` VALUES ('188', '25', '更新选中', 'core', 'cache_all', 'cache_select', '', '188', '0', '0');
INSERT INTO `wz_menu` VALUES ('189', '25', '更新全部', 'core', 'cache_all', 'cache', '', '189', '0', '0');
INSERT INTO `wz_menu` VALUES ('190', '61', '修改管理员', 'core', 'power', 'edit', '', '2', '0', '0');
INSERT INTO `wz_menu` VALUES ('191', '61', '删除管理员', 'core', 'power', 'delete', '', '2', '0', '0');
INSERT INTO `wz_menu` VALUES ('192', '61', '修改角色', 'core', 'power', 'role_edit', '', '13', '0', '0');
INSERT INTO `wz_menu` VALUES ('193', '61', '删除角色', 'core', 'power', 'role_delete', '', '14', '0', '0');
INSERT INTO `wz_menu` VALUES ('194', '61', '权限设置', 'core', 'power', 'private_set', '', '194', '0', '0');
INSERT INTO `wz_menu` VALUES ('195', '61', '登录历史查看', 'core', 'power', 'logintime', '', '2', '0', '0');
INSERT INTO `wz_menu` VALUES ('196', '61', '添加工作流权限', 'core', 'workflow', 'adduser', '', '51', '0', '0');
INSERT INTO `wz_menu` VALUES ('197', '61', '删除工作流权限', 'core', 'workflow', 'deluser', '', '52', '0', '0');
INSERT INTO `wz_menu` VALUES ('198', '61', '内容管理权限', 'content', 'category', 'private_set', '', '198', '0', '0');
INSERT INTO `wz_menu` VALUES ('199', '56', '删除', 'core', 'badword', 'delete', '', '199', '0', '0');
INSERT INTO `wz_menu` VALUES ('200', '102', '生成首页', 'content', 'createhtml', 'index', '', '200', '0', '0');
INSERT INTO `wz_menu` VALUES ('201', '92', '锁屏', 'core', 'index', 'lockscreen', '', '201', '0', '0');
INSERT INTO `wz_menu` VALUES ('202', '92', '屏幕解锁', 'core', 'index', 'unlockscreen', '', '202', '0', '0');
INSERT INTO `wz_menu` VALUES ('10055', '10053', '添加策略', 'credit', 'set', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('205', '92', '退出系统', 'core', 'index', 'logout', '', '205', '0', '0');
INSERT INTO `wz_menu` VALUES ('213', '212', '上传报告', 'medical', 'record', 'add', '', '213', '1', '0');
INSERT INTO `wz_menu` VALUES ('222', '220', '物流公司', 'order', 'express', 'listing', '', '222', '1', '0');
INSERT INTO `wz_menu` VALUES ('223', '220', '添加物流公司', 'order', 'express', 'add', '', '223', '1', '0');
INSERT INTO `wz_menu` VALUES ('225', '220', '删除物流', 'order', 'express', 'delete', '', '225', '0', '0');
INSERT INTO `wz_menu` VALUES ('231', '5', '站内短信', 'message', 'index', 'listing', '', '231', '1', '0');
INSERT INTO `wz_menu` VALUES ('232', '231', '发布站内短信', 'message', 'index', 'add', '', '232', '1', '0');
INSERT INTO `wz_menu` VALUES ('258', '29', '添加附件', 'attachment', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('239', '226', '积分入帐', 'credit', 'index', 'add', '', '239', '1', '0');
INSERT INTO `wz_menu` VALUES ('242', '46', '团购栏目', 'content', 'category', 'listing', 'modelid=2', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('243', '46', '商家栏目', 'content', 'category', 'listing', 'modelid=3', '1', '0', '0');
INSERT INTO `wz_menu` VALUES ('300', '215', '邮件模板配置', 'coupon', 'card', 'email_setting', '', '244', '1', '0');
INSERT INTO `wz_menu` VALUES ('257', '256', '添加站点', 'core', 'site', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('249', '248', '审核通过列表', 'chatroom', 'index', 'listing', 'status=9', '249', '1', '0');
INSERT INTO `wz_menu` VALUES ('256', '2', '站点管理', 'core', 'site', 'listing', '', '1', '1', '0');
INSERT INTO `wz_menu` VALUES ('268', '267', '添加广告', 'promote', 'index', 'add', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('267', '260', '管理广告', 'promote', 'index', 'listing', '', '0', '2', '0');
INSERT INTO `wz_menu` VALUES ('266', '260', '删除广告位', 'promote', 'index', 'deleteplace', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('265', '260', '删除广告', 'promote', 'index', 'delete', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('264', '260', '修改广告位', 'promote', 'index', 'editplace', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('263', '260', '修改广告', 'promote', 'index', 'edit', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('262', '260', '添加广告', 'promote', 'index', 'add', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('261', '260', '添加广告位', 'promote', 'index', 'addplace', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('260', '5', '广告管理', 'promote', 'index', 'listingplace', '', '254', '1', '0');
INSERT INTO `wz_menu` VALUES ('269', '260', '批量发布广告', 'promote', 'index', 'batch', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('270', '129', '添加自定义内容', 'content', 'block', 'add_content', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('271', '26', '全部审核', 'content', 'content', 'allcheck', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('279', '26', '移除相关内容', 'content', 'relation', 'remove_relation', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('278', '26', '推送栏目列表显示', 'content', 'category', 'load_sitecate', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('277', '92', '站点切换', 'core', 'site', 'changesite', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('276', '26', '推送内容', 'content', 'content', 'push', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('275', '26', '相关内容列表', 'content', 'relation', 'listing', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('274', '26', '相关内容', 'content', 'relation', 'manage', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('273', '57', '添加自定义内容', 'content', 'block', 'add_content', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('272', '26', '页面审核', 'content', 'content', 'check', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('302', '301', '添加自定义变量', 'core', 'set', 'add_global_vars', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('303', '301', '修改自定义变量', 'core', 'set', 'edit_global_vars', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('304', '301', '删除自定义变量', 'core', 'set', 'delete_global_vars', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('305', '6', '审批新会员', 'member', 'index', 'check_list', '', '5', '1', '0');
INSERT INTO `wz_menu` VALUES ('306', '5', '问题反馈', 'feedback', 'index', 'listing', '', '306', '1', '0');
INSERT INTO `wz_menu` VALUES ('307', '5', '模块管理', 'core', 'app', 'init', '', '307', '1', '0');
INSERT INTO `wz_menu` VALUES ('309', '308', '采集分类', 'core', 'kind', 'listing', 'keyid=collect', '309', '1', '0');
INSERT INTO `wz_menu` VALUES ('310', '308', '添加规则', 'collect', 'index', 'add', '', '310', '1', '0');
INSERT INTO `wz_menu` VALUES ('312', '308', '采集测试', 'collect', 'index', 'test', '', '312', '0', '0');
INSERT INTO `wz_menu` VALUES ('313', '34', '类别管理', 'core', 'kind', 'listing', 'keyid=link', '313', '1', '0');
INSERT INTO `wz_menu` VALUES ('314', '34', '修改类别', 'core', 'kind', 'edit', 'keyid=link', '314', '0', '0');
INSERT INTO `wz_menu` VALUES ('315', '34', '删除类别', 'core', 'kind', 'delete', 'keyid=link', '315', '0', '0');
INSERT INTO `wz_menu` VALUES ('10001', '3', '专题管理', 'topic', 'index', 'listing', '', '11', '1', '0');
INSERT INTO `wz_menu` VALUES ('10002', '10001', '专题分类', 'topic', 'kind', 'listing', '', '10002', '1', '0');
INSERT INTO `wz_menu` VALUES ('10003', '10001', '添加专题', 'topic', 'index', 'add', '', '10003', '1', '0');
INSERT INTO `wz_menu` VALUES ('10004', '10001', '修改专题', 'topic', 'index', 'edit', '', '10004', '0', '0');
INSERT INTO `wz_menu` VALUES ('10005', '10001', '删除专题', 'topic', 'index', 'delete', '', '10005', '0', '0');
INSERT INTO `wz_menu` VALUES ('10006', '7', '可视化管理', 'core', 'layout', 'init', '', '10006', '0', '0');
INSERT INTO `wz_menu` VALUES ('10007', '10006', '添加组件模版', 'core', 'layout', 'add', '', '10007', '1', '0');
INSERT INTO `wz_menu` VALUES ('10008', '10006', '组件模版列表', 'core', 'layout', 'config_listing', '', '10008', '1', '0');
INSERT INTO `wz_menu` VALUES ('10009', '10001', '专题内容管理', 'topic', 'index', 'list_manage', '', '10009', '2', '0');
INSERT INTO `wz_menu` VALUES ('10010', '10009', '导入内容', 'topic', 'index', 'import', '', '10010', '1', '0');
INSERT INTO `wz_menu` VALUES ('10011', '10009', '添加内容', 'topic', 'index', 'add_content', '', '10011', '1', '0');
INSERT INTO `wz_menu` VALUES ('5010', '5007', 'APP列表', 'comment', 'index', 'app_listing', '', '5010', '1', '0');
INSERT INTO `wz_menu` VALUES ('5011', '5007', 'APP添加', 'comment', 'index', 'add', '', '5011', '1', '0');
INSERT INTO `wz_menu` VALUES ('5012', '5007', '评论举报', 'comment', 'index', 'report', '', '5012', '1', '0');
INSERT INTO `wz_menu` VALUES ('5013', '5007', '评论审批', 'comment', 'index', 'comment_check', '', '5013', '0', '0');
INSERT INTO `wz_menu` VALUES ('10050', '10049', '数据库导入', 'database', 'index', 'import', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10051', '10049', '数据库导出', 'database', 'index', 'export_database', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('10052', '10049', '数据库修复', 'database', 'index', 'public_repair', '', '0', '0', '0');
INSERT INTO `wz_menu` VALUES ('10017', '1', '编辑在线时间统计', 'core', 'onlinetime', 'init', '', '10017', '0', '0');
INSERT INTO `wz_menu` VALUES ('10040', '10001', '专题风格管理', 'topic', 'style', 'listing', '', '10040', '1', '0');
INSERT INTO `wz_menu` VALUES ('10026', '3', '审稿权限', 'content', 'checks', 'c1', '', '12', '1', '0');
INSERT INTO `wz_menu` VALUES ('10027', '10026', '待审稿件', 'content', 'checks', 'c1', '', '10027', '1', '0');
INSERT INTO `wz_menu` VALUES ('10028', '10026', '签发稿件', 'content', 'checks', 'c2', '', '10028', '1', '0');
INSERT INTO `wz_menu` VALUES ('10029', '10026', '精编稿件', 'content', 'checks', 'c3', '', '10029', '1', '0');
INSERT INTO `wz_menu` VALUES ('10030', '10026', '进审稿件', 'content', 'checks', 'c4', '', '10030', '1', '0');
INSERT INTO `wz_menu` VALUES ('10031', '10026', '已发稿件', 'content', 'checks', 'c5', '', '10031', '1', '0');
INSERT INTO `wz_menu` VALUES ('10032', '10026', '预定', 'content', 'checks', 'check_yuding', '', '10032', '1', '0');
INSERT INTO `wz_menu` VALUES ('10033', '10026', '审核记录', 'content', 'content', 'view_checkrecords', '', '10033', '1', '0');
INSERT INTO `wz_menu` VALUES ('10034', '10026', '文章属性', 'content', 'checks', 'set_shuxing', '', '10034', '1', '0');
INSERT INTO `wz_menu` VALUES ('10035', '10026', '审核操作', 'content', 'checks', 'check_records', '', '10035', '1', '0');
INSERT INTO `wz_menu` VALUES ('10036', '10026', '退一审', 'content', 'checks', 'check_records', '', '10036', '1', '0');
INSERT INTO `wz_menu` VALUES ('10037', '10026', '一审', 'content', 'checks', 'ck1', '', '10037', '1', '0');
INSERT INTO `wz_menu` VALUES ('10038', '10026', '二审', 'content', 'checks', 'ck2', '', '10038', '1', '0');
INSERT INTO `wz_menu` VALUES ('10039', '10026', '三审', 'content', 'checks', 'ck3', '', '10039', '1', '0');
INSERT INTO `wz_menu` VALUES ('10040', '10001', '专题风格管理', 'topic', 'style', 'listing', '', '10040', '1', '0');
INSERT INTO `wz_menu` VALUES ('10041', '1', '发稿统计', 'core', 'index', 'listing_stat', '', '10041', '1', '0');
INSERT INTO `wz_menu` VALUES ('10043', '10042', '模型设置', 'core', 'model', 'field_listing', 'app=mailbox&modelid=1015', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10045', '29', '地址替换', 'attachment', 'replace_file', 'listing', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10046', '3', '编辑管理', 'content', 'editor', 'keep_watch', '', '13', '1', '0');
INSERT INTO `wz_menu` VALUES ('10047', '10046', '栏目编辑统计', 'content', 'editor', 'stats', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10048', '10046', '编稿汇总考核', 'content', 'editor', 'all_stat', '', '0', '1', '0');
INSERT INTO `wz_menu` VALUES ('10049', '2', '数据库备份', 'database', 'index', 'export', '', '8', '1', '0');
INSERT INTO `wz_menu` VALUES ('10091', '6', '单位管理', 'member', 'org', 'lists', '', '6', '1', '0');
INSERT INTO `wz_menu` VALUES ('10092', '10091', '添加单位', 'member', 'org', 'create', '', '0', '1', '0');


-- ----------------------------
-- Table structure for wz_message
-- ----------------------------
DROP TABLE IF EXISTS `wz_message`;
CREATE TABLE `wz_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgtype` tinyint(3) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL,
  `touid` int(10) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 新消息，0 已读',
  `title` varchar(80) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `touid` (`touid`),
  KEY `touid_2` (`touid`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='站内信息';

-- ----------------------------
-- Records of wz_message
-- ----------------------------

-- ----------------------------
-- Table structure for wz_model
-- ----------------------------
DROP TABLE IF EXISTS `wz_model`;
CREATE TABLE `wz_model` (
  `modelid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `m` varchar(20) NOT NULL COMMENT '所属模块',
  `name` varchar(20) NOT NULL COMMENT '模型名称',
  `master_table` varchar(20) NOT NULL COMMENT '主表名称',
  `attr_table` varchar(20) NOT NULL COMMENT '附属表名称',
  `remark` varchar(100) NOT NULL COMMENT '备注',
  `template` varchar(50) NOT NULL COMMENT '内容页默认模版',
  `css` varchar(20) NOT NULL COMMENT '附加样式',
  `share_model` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为共享模型',
  `manage_template` varchar(30) NOT NULL,
  PRIMARY KEY (`modelid`)
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8 COMMENT='模型表';

-- ----------------------------
-- Records of wz_model
-- ----------------------------
INSERT INTO `wz_model` VALUES ('1', 'content', '文章模型', 'content_share', 'news_data', '', '', 'icon-file-word-o', '1', '');
INSERT INTO `wz_model` VALUES ('5', 'content', '图片模型', 'content_share', 'picture_data', '', 'show', 'icon-file-photo-o', '1', '');
INSERT INTO `wz_model` VALUES ('6', 'content', '下载模型', 'content_share', 'download_data', '', '', 'icon-file-zip-o', '1', '');
INSERT INTO `wz_model` VALUES ('7', 'content', '视频模型', 'content_share', 'video_data', '', 'show', 'icon-file-movie-o', '1', '');
INSERT INTO `wz_model` VALUES ('10', 'member', '普通会员', 'member', 'member_detail_data', '', '', '', '1', '');

-- ----------------------------
-- Table structure for wz_model_field
-- ----------------------------
DROP TABLE IF EXISTS `wz_model_field`;
CREATE TABLE `wz_model_field` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `remark` text NOT NULL COMMENT '字段提示',
  `css` varchar(30) NOT NULL,
  `minlength` int(10) unsigned NOT NULL DEFAULT '0',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL,
  `errortips` varchar(255) NOT NULL,
  `formtype` varchar(20) NOT NULL,
  `setting` mediumtext NOT NULL,
  `ext_code` varchar(255) NOT NULL,
  `unsetgids` varchar(255) NOT NULL,
  `unsetroles` varchar(255) NOT NULL,
  `master_field` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1,主表字段',
  `ban_field` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '禁止删除的字段',
  `location` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '位置索引',
  `search_field` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '搜索字段',
  `ban_contribute` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '禁用投稿',
  `to_fulltext` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '全文索引字段',
  `to_block` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '添加到碎片',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序序列号',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `powerful_field` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为超级字段的附加字段',
  `workflow_field` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`,`disabled`),
  KEY `field` (`field`,`modelid`)
) ENGINE=InnoDB AUTO_INCREMENT=651 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_model_field
-- ----------------------------
INSERT INTO `wz_model_field` VALUES ('468', '7', 'remark', '摘要', '', '', '0', '0', '', '', 'textarea', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '1', '1', '4', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('469', '7', 'content', '正文', '', '', '0', '0', '', '', 'editor', 'a:3:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:16:\"watermark_enable\";s:1:\"0\";}', '', '', '', '0', '0', '5', '0', '1', '1', '0', '8', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('443', '6', 'addtime', '添加时间', '', '', '0', '0', '', '', 'datetime', 'a:2:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";}', '', '', '', '1', '1', '1', '0', '0', '0', '1', '12', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('442', '5', 'keywords', '关键词', '多关键词之间用半角逗号“,”隔开', '', '0', '0', '', '', 'keyword', '', '', '', '', '1', '1', '0', '1', '0', '1', '0', '3', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('440', '5', 'cid', '所属栏目', '', '', '1', '0', '', '请选择栏目', 'cid', '', '', '', '', '1', '1', '5', '0', '0', '0', '0', '1', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('441', '5', 'title', '标题', '', '', '2', '80', '', '请输入标题', 'title', '', '', '', '', '1', '1', '5', '0', '1', '1', '1', '2', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('439', '5', 'content', '正文', '', '', '0', '0', '', '', 'editor', 'a:3:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:16:\"watermark_enable\";s:1:\"0\";}', '', '', '', '0', '0', '5', '0', '1', '1', '0', '8', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('438', '5', 'remark', '摘要', '', '', '0', '0', '', '', 'textarea', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '1', '1', '4', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('437', '5', 'relation', '相关内容', '', '', '0', '0', '', '', 'relation', 'a:3:{s:8:\"formtext\";s:8:\"相关内容\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";}', '', '', '', '0', '0', '1', '0', '0', '0', '0', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('436', '5', 'thumb', '缩略图', '', '', '0', '0', '', '', 'image', 'a:4:{s:15:\"upload_allowext\";s:7:\"gif|jpg\";s:10:\"images_cut\";s:1:\"1\";s:12:\"images_width\";s:3:\"400\";s:13:\"images_height\";s:3:\"800\";}', '', '', '', '1', '1', '0', '0', '0', '0', '1', '5', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('473', '5', 'pictures', '组图', '', '', '0', '0', '', '', 'images', 'a:6:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('435', '5', 'status', '稿件状态', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:50:\"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"9\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '30', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('434', '5', 'allowcomment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:21:\"允许|1\r\n不允许|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '17', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('433', '5', 'template', '内容页模板', '', '', '0', '0', '', '', 'template', '', '', '', '', '0', '0', '1', '0', '0', '0', '0', '21', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('432', '5', 'sort', '权重', '', '', '0', '255', '', '', 'slider', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '', '', '', '1', '1', '1', '0', '0', '0', '0', '20', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('454', '6', 'content', '正文', '', '', '0', '0', '', '', 'editor', 'a:3:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:16:\"watermark_enable\";s:1:\"0\";}', '', '', '', '0', '0', '5', '0', '1', '1', '0', '8', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('455', '6', 'cid', '所属栏目', '', '', '1', '0', '', '请选择栏目', 'cid', '', '', '', '', '1', '1', '5', '0', '0', '0', '0', '1', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('456', '6', 'title', '标题', '', '', '2', '80', '', '请输入标题', 'title', '', '', '', '', '1', '1', '5', '0', '1', '1', '1', '2', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('457', '6', 'keywords', '关键词', '多关键词之间用半角逗号“,”隔开', '', '0', '0', '', '', 'keyword', '', '', '', '', '1', '1', '0', '1', '0', '1', '0', '3', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('458', '7', 'addtime', '添加时间', '', '', '0', '0', '', '', 'datetime', 'a:2:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";}', '', '', '', '1', '1', '1', '0', '0', '0', '1', '12', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('459', '7', 'block', '添加到推荐位', '', '', '0', '0', '', '', 'block', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '6', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('460', '7', 'groups', '用户组权限', '', '', '0', '0', '', '', 'group', 'a:1:{s:6:\"groups\";s:3:\"4,5\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '18', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('461', '7', 'url', '链接地址', '', '', '0', '0', '', '', 'url', '', '', '', '', '1', '1', '1', '0', '0', '0', '1', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('462', '7', 'sort', '权重', '', '', '0', '255', '', '', 'slider', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '', '', '', '1', '1', '1', '0', '0', '0', '0', '20', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('463', '7', 'template', '内容页模板', '', '', '0', '0', '', '', 'template', '', '', '', '', '0', '0', '1', '0', '0', '0', '0', '21', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('464', '7', 'allowcomment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:21:\"允许|1\r\n不允许|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '17', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('465', '7', 'status', '稿件状态', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:50:\"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"9\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '30', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('466', '7', 'thumb', '缩略图', '', '', '0', '0', '', '', 'image', 'a:6:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";}', '', '', '', '1', '1', '0', '0', '0', '0', '1', '5', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('467', '7', 'relation', '相关内容', '', '', '0', '0', '', '', 'relation', 'a:3:{s:8:\"formtext\";s:8:\"相关内容\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";}', '', '', '', '0', '0', '1', '0', '0', '0', '0', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('453', '6', 'remark', '摘要', '', '', '0', '0', '', '', 'textarea', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '1', '1', '4', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('452', '6', 'relation', '相关内容', '', '', '0', '0', '', '', 'relation', 'a:3:{s:8:\"formtext\";s:8:\"相关内容\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";}', '', '', '', '0', '0', '1', '0', '0', '0', '0', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('451', '6', 'thumb', '缩略图', '', '', '0', '0', '', '', 'image', 'a:6:{s:12:\"defaultvalue\";s:0:\"\";s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";}', '', '', '', '1', '1', '0', '0', '0', '0', '1', '5', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('450', '6', 'status', '稿件状态', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:50:\"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"9\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '30', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('449', '6', 'allowcomment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:21:\"允许|1\r\n不允许|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '17', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('448', '6', 'template', '内容页模板', '', '', '0', '0', '', '', 'template', '', '', '', '', '0', '0', '1', '0', '0', '0', '0', '21', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('447', '6', 'sort', '权重', '', '', '0', '255', '', '', 'slider', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '', '', '', '1', '1', '1', '0', '0', '0', '0', '20', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('446', '6', 'url', '链接地址', '', '', '0', '0', '', '', 'url', '', '', '', '', '1', '1', '1', '0', '0', '0', '1', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('445', '6', 'groups', '用户组权限', '', '', '0', '0', '', '', 'group', 'a:1:{s:6:\"groups\";s:3:\"4,5\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '18', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('444', '6', 'block', '添加到推荐位', '', '', '0', '0', '', '', 'block', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '6', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('39', '1', 'keywords', '关键词', '输入关键词后，请回车', '', '0', '0', '', '', 'keyword', '', '', '', '', '1', '1', '0', '1', '1', '1', '0', '1', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('56', '1', 'copyfrom', '来源', '', '', '0', '0', '', '', 'copyfrom', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '1', '0', '7', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('38', '1', 'title', '标题', '', '', '2', '80', '', '', 'title', 'a:0:{}', '', '', '', '1', '1', '5', '0', '1', '1', '1', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('40', '1', 'remark', '摘要', '', '', '0', '0', '', '', 'textarea', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '1', '1', '1', '2', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('41', '1', 'content', '正文', '', '', '0', '0', '', '', 'editor', 'a:3:{s:11:\"editor_type\";s:8:\"ckeditor\";s:7:\"toolbar\";s:6:\"normal\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '0', '0', '5', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('37', '1', 'cid', '所属栏目', '', '', '1', '0', '', '', 'cid', '', '', '', '', '1', '1', '5', '0', '0', '0', '1', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('42', '1', 'thumb', '缩略图', '', '', '0', '0', '', '', 'image', 'a:4:{s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:8:\"is_water\";s:1:\"0\";s:16:\"member_show_type\";s:1:\"0\";s:17:\"is_allow_show_img\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '1', '0', '1', '3', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('43', '1', 'relation', '相关内容', '', '', '0', '0', '', '', 'relation', 'a:0:{}', '', '', '', '0', '0', '1', '0', '0', '0', '0', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('51', '1', 'status', '稿件状态', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:50:\"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"9\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '30', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('45', '1', 'block', '添加到推荐位', '', '', '0', '0', '', '', 'block', 'a:0:{}', '', '', '', '1', '0', '0', '0', '0', '0', '0', '6', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('46', '1', 'groups', '用户组权限', '', '', '0', '0', '', '', 'group', 'a:1:{s:6:\"groups\";s:3:\"4,5\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '18', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('47', '1', 'url', '链接地址', '', '', '0', '0', '', '', 'url', '', '', '', '', '1', '1', '1', '0', '1', '0', '1', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('48', '1', 'sort', '权重', '', '', '0', '255', '', '', 'slider', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '', '', '', '1', '1', '1', '0', '0', '0', '0', '16', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('49', '1', 'template', '内容页模板', '', '', '0', '0', '', '', 'template', 'a:0:{}', '', '', '', '0', '0', '1', '0', '0', '0', '0', '21', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('50', '1', 'allowcomment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:6:{s:7:\"options\";s:21:\"允许|1\r\n不允许|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '17', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('44', '1', 'addtime', '添加时间', '', '', '0', '0', '', '', 'datetime', 'a:2:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";}', '', '', '', '1', '1', '1', '0', '0', '0', '1', '20', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('470', '7', 'cid', '所属栏目', '', '', '1', '0', '', '请选择栏目', 'cid', '', '', '', '', '1', '1', '5', '0', '0', '0', '0', '1', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('471', '7', 'title', '标题', '', '', '2', '80', '', '请输入标题', 'title', '', '', '', '', '1', '1', '5', '0', '1', '1', '1', '2', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('472', '7', 'keywords', '关键词', '多关键词之间用半角逗号“,”隔开', '', '0', '0', '', '', 'keyword', '', '', '', '', '1', '1', '0', '1', '0', '1', '0', '3', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('430', '5', 'groups', '用户组权限', '', '', '0', '0', '', '', 'group', 'a:1:{s:6:\"groups\";s:3:\"4,5\";}', '', '', '', '0', '0', '2', '0', '0', '0', '0', '18', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('431', '5', 'url', '链接地址', '', '', '0', '0', '', '', 'url', '', '', '', '', '1', '1', '1', '0', '0', '0', '1', '11', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('428', '5', 'addtime', '添加时间', '', '', '0', '0', '', '', 'datetime', 'a:2:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";}', '', '', '', '1', '1', '1', '0', '0', '0', '1', '12', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('429', '5', 'block', '添加到推荐位', '', '', '0', '0', '', '', 'block', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '6', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('474', '6', 'soft_author', '软件作者', '', '', '0', '0', '', '', 'text', 'a:4:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('475', '6', 'soft_size', '软件大小', '', '', '0', '0', '', '', 'text', 'a:4:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('476', '6', 'soft_license', '软件授权', '', '', '0', '0', '', '', 'box', 'a:5:{s:7:\"options\";s:46:\"开源软件|开源软件\r\n共享版|共享版\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"defaultvalue\";s:12:\"开源软件\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('477', '6', 'soft_language', '软件语言', '', '', '0', '0', '', '', 'box', 'a:5:{s:7:\"options\";s:34:\"简体中文|1\r\n英文|2\r\n其它|3\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('478', '6', 'soft_env', '运行环境', '', '', '0', '0', '', '', 'box', 'a:5:{s:7:\"options\";s:102:\"PHP/Mysql|PHP/Mysql\r\nASP/Access/MSSQL|ASP/Access/MSSQL\r\nXP/2003/Vista/Win7|XP/2003/Vista/Win7\r\nios|ios\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"defaultvalue\";s:9:\"PHP/Mysql\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('479', '6', 'down_numbers', '下载次数', '', '', '0', '0', '', '', 'number', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('480', '6', 'downfile', '下载地址', '', '', '0', '0', '', '', 'downfile', 'a:3:{s:15:\"upload_allowext\";s:40:\"jpg|png|gif|bmp|zip|rar|doc|docx|exe|txt\";s:8:\"linktype\";s:1:\"0\";s:12:\"downloadtype\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `wz_model_field` VALUES ('554', '10', 'level', '当前级别', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `wz_model_field` VALUES ('536', '7', 'youku', '优酷播放', '', '', '0', '0', '', '', 'video_youku', '', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('537', '7', 'tudou', '土豆播放', '', '', '0', '0', '', '', 'video_tudou', '', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('568', '1', 'typeid', '所属类别', '', '', '0', '0', '', '', 'box', 'a:5:{s:7:\"options\";s:20:\"选项1|1\r\n选项2|2\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '1', '0', '1', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('545', '1', 'attachment', '附件', '', '', '0', '0', '', '', 'downfile', 'a:3:{s:15:\"upload_allowext\";s:33:\"rar|zip|doc|ppt|xls|docx|pdf|xlsx\";s:8:\"linktype\";s:1:\"0\";s:12:\"downloadtype\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '5', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('548', '1', 'signature', '作者署名', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '8', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('555', '10', 'manuscript', '已编辑稿件', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('556', '10', 'pseudonym', '笔名', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('558', '10', 'company', '作者单位', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('559', '10', 'placeOfOrigin', '籍贯', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('560', '10', 'armyDate', '入伍年月', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('561', '10', 'job', '职务', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('562', '10', 'militaryRank', '军衔', '', '', '0', '0', '', '', 'box', 'a:5:{s:7:\"options\";s:20:\"选项1|1\r\n选项2|2\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('567', '10', 'linktel', '联系电话', '', '', '0', '0', '', '', 'text', 'a:5:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('565', '10', 'preference', '个人爱好', '', '', '0', '0', '', '', 'editor', 'a:5:{s:11:\"editor_type\";s:8:\"ckeditor\";s:7:\"toolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"0\";s:16:\"watermark_enable\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('566', '10', 'Profile', '个人简介', '', '', '0', '0', '', '', 'editor', 'a:5:{s:11:\"editor_type\";s:8:\"ckeditor\";s:7:\"toolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"0\";s:16:\"watermark_enable\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('569', '6', 'downfiles', '下载地址', '', '', '0', '0', '', '', 'downfiles', 'a:3:{s:15:\"upload_allowext\";s:40:\"jpg|png|gif|bmp|zip|rar|doc|docx|exe|txt\";s:8:\"linktype\";s:1:\"1\";s:12:\"downloadtype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('571', '6', 'tcid', '所属专题', '', '', '0', '0', '', '', 'topic', 'a:8:{s:3:\"sql\";s:69:\"SELECT `groupid`,`name` FROM `wz_member_group` ORDER BY `groupid` ASC\";s:10:\"field_name\";s:4:\"name\";s:11:\"field_value\";s:7:\"groupid\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:3:\"int\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"0\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('593', '1', 'videos', '视频', '', '', '0', '0', '', '', 'downfile', 'a:3:{s:15:\"upload_allowext\";s:3:\"mp4\";s:8:\"linktype\";s:1:\"1\";s:12:\"downloadtype\";s:1:\"1\";}', '', '', '', '1', '0', '0', '0', '1', '1', '0', '4', '0', '0', '0');
INSERT INTO `wz_model_field` VALUES ('597', '1', 'tcid', '所属专题', '', '', '0', '0', '', '', 'topic', 'a:8:{s:3:\"sql\";s:69:\"SELECT `groupid`,`name` FROM `wz_member_group` ORDER BY `groupid` ASC\";s:10:\"field_name\";s:4:\"name\";s:11:\"field_value\";s:7:\"groupid\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:3:\"int\";s:9:\"minnumber\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"0\";s:10:\"outputtype\";s:1:\"0\";}', '', '', '', '0', '0', '1', '0', '1', '1', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for wz_news_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_news_data`;
CREATE TABLE `wz_news_data` (
  `id` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groups` char(255) NOT NULL DEFAULT '',
  `template` char(255) NOT NULL DEFAULT '',
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `relation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `copyfrom` char(255) NOT NULL DEFAULT '',
  `tcid` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_news_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_picture_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_picture_data`;
CREATE TABLE `wz_picture_data` (
  `id` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groups` varchar(100) NOT NULL,
  `template` varchar(30) NOT NULL,
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `pictures` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_picture_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_promote
-- ----------------------------
DROP TABLE IF EXISTS `wz_promote`;
CREATE TABLE `wz_promote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL,
  `siteid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keyid` varchar(20) NOT NULL,
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `param1` varchar(100) NOT NULL,
  `param2` varchar(100) NOT NULL,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) NOT NULL,
  `keywords` varchar(80) NOT NULL,
  `url` varchar(200) NOT NULL,
  `file` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `template` varchar(30) NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `stat_table` mediumint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`sort`),
  KEY `keyid` (`keyid`,`sort`),
  KEY `pid_2` (`pid`,`siteid`,`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for wz_promote_place
-- ----------------------------
DROP TABLE IF EXISTS `wz_promote_place`;
CREATE TABLE `wz_promote_place` (
  `pid` smallint(5) NOT NULL AUTO_INCREMENT,
  `keyid` varchar(20) NOT NULL,
  `siteid` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(80) NOT NULL,
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of wz_promote_place
-- ----------------------------

-- ----------------------------
-- Table structure for wz_promote_stat_201804
-- ----------------------------
DROP TABLE IF EXISTS `wz_promote_stat_201804`;
CREATE TABLE `wz_promote_stat_201804` (
  `pid` int(10) NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `qkey` varchar(13) NOT NULL,
  `addtime` datetime NOT NULL,
  `referer` varchar(100) NOT NULL,
  `day` tinyint(2) unsigned NOT NULL DEFAULT '0',
  KEY `pid_2` (`pid`,`qkey`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告统计';

-- ----------------------------
-- Records of wz_promote_stat_201804
-- ----------------------------

-- ----------------------------
-- Table structure for wz_quyu
-- ----------------------------
DROP TABLE IF EXISTS `wz_quyu`;
CREATE TABLE `wz_quyu` (
  `areaid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `letter` varchar(40) NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`areaid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='区域';

-- ----------------------------
-- Records of wz_quyu
-- ----------------------------
INSERT INTO `wz_quyu` VALUES ('1', '顺义区', 'shunyiqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('2', '石景山区', 'shijingshanqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('3', '海淀区', 'haidianqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('4', '房山区 ', 'fangshanqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('5', '朝阳区 ', 'chaoyangqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('6', '东城区 ', 'dongchengqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('7', '西城区 ', 'xichengqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('8', '宣武区 ', 'xuanwuqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('9', '丰台区', 'fengtaiqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('10', '怀柔区 ', 'huairouqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('11', '昌平区 ', 'changpingqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('12', '通州区', 'tongzhouqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('13', '平谷区 ', 'pingguqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('14', '大兴区 ', 'daxingqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('15', '门头沟区 ', 'mentougouqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('16', '崇文区', 'chongwenqu', '30', '0');
INSERT INTO `wz_quyu` VALUES ('17', '海淀', 'haidian', '31', '0');
INSERT INTO `wz_quyu` VALUES ('18', '昌平', 'changping', '31', '0');
INSERT INTO `wz_quyu` VALUES ('19', '朝阳', 'chaoyang', '31', '0');
INSERT INTO `wz_quyu` VALUES ('20', '闸北区  普陀区  浦东区  虹口区  ', 'zhabeiquputuoqupudongquhongkouquxuhuiquy', '285', '0');
INSERT INTO `wz_quyu` VALUES ('21', '闸北区', 'zhabeiqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('22', '普陀区', 'putuoqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('23', '浦东区', 'pudongqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('24', '虹口区', 'hongkouqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('25', '徐汇区', 'xuhuiqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('26', '杨浦区', 'yangpuqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('27', '松江区', 'songjiangqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('28', '静安区', 'jinganqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('29', '长宁区', 'changningqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('30', '闵行区', 'minxingqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('31', '宝山区', 'baoshanqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('32', '嘉定区', 'jiadingqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('33', '青浦区', 'qingpuqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('34', '黄浦区', 'huangpuqu', '285', '0');
INSERT INTO `wz_quyu` VALUES ('35', '黄埔区', 'huangbuqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('36', '白云区', 'baiyunqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('37', '萝岗区', 'luogangqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('38', '天河区', 'tianhequ', '286', '0');
INSERT INTO `wz_quyu` VALUES ('39', '南沙区', 'nanshaqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('40', '越秀区', 'yuexiuqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('41', '荔湾区', 'liwanqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('42', '海珠区', 'haizhuqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('43', '番禺区', 'fanyuqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('44', '花都区', 'huadouqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('45', '从化区', 'conghuaqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('46', '增城区', 'zengchengqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('47', '增城市', 'zengchengshi', '286', '0');
INSERT INTO `wz_quyu` VALUES ('48', '从化市', 'conghuashi', '286', '0');
INSERT INTO `wz_quyu` VALUES ('49', '黄埔区', 'huangbuqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('50', '白云区', 'baiyunqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('51', '萝岗区', 'luogangqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('52', '天河区', 'tianhequ', '134', '0');
INSERT INTO `wz_quyu` VALUES ('53', '南沙区', 'nanshaqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('54', '越秀区', 'yuexiuqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('55', '荔湾区', 'liwanqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('56', '海珠区', 'haizhuqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('57', '番禺区', 'fanyuqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('58', '花都区', 'huadouqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('59', '从化区', 'conghuaqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('60', '增城区', 'zengchengqu', '134', '0');
INSERT INTO `wz_quyu` VALUES ('61', '增城市', 'zengchengshi', '134', '0');
INSERT INTO `wz_quyu` VALUES ('62', '从化市', 'conghuashi', '134', '0');
INSERT INTO `wz_quyu` VALUES ('63', '罗湖区', 'luohuqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('64', '宝安区', 'baoanqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('65', '南山区', 'nanshanqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('66', '龙岗区', 'longgangqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('67', '盐田区', 'yantianqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('68', '福田区', 'futianqu', '286', '0');
INSERT INTO `wz_quyu` VALUES ('69', '滨江区', 'binjiangqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('70', '江干区', 'jiangganqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('71', '拱墅区', 'gongshuqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('72', '西湖区', 'xihuqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('73', '下城区', 'xiachengqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('74', '上城区', 'shangchengqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('75', '余杭区', 'yuhangqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('76', '萧山区', 'xiaoshanqu', '144', '0');
INSERT INTO `wz_quyu` VALUES ('77', '海淀区', 'haidian', '28', '0');
INSERT INTO `wz_quyu` VALUES ('78', '昌平区', 'changping', '28', '0');

-- ----------------------------
-- Table structure for wz_route_config
-- ----------------------------
DROP TABLE IF EXISTS `wz_route_config`;
CREATE TABLE `wz_route_config` (
  `at` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `m` char(20) NOT NULL,
  `f` char(20) NOT NULL,
  `v` char(20) NOT NULL,
  `extend` char(50) NOT NULL COMMENT '扩展参数',
  PRIMARY KEY (`at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义路由表';

-- ----------------------------
-- Records of wz_route_config
-- ----------------------------

-- ----------------------------
-- Table structure for wz_search_category
-- ----------------------------
DROP TABLE IF EXISTS `wz_search_category`;
CREATE TABLE `wz_search_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置项主键',
  `m` varchar(30) DEFAULT NULL COMMENT '模块名',
  `modelid` mediumint(8) unsigned DEFAULT '0' COMMENT '模型ID',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='搜索分类表';

-- ----------------------------
-- Records of wz_search_category
-- ----------------------------

-- ----------------------------
-- Table structure for wz_search_config
-- ----------------------------
DROP TABLE IF EXISTS `wz_search_config`;
CREATE TABLE `wz_search_config` (
  `config_key` varchar(50) NOT NULL DEFAULT '' COMMENT '配置项key',
  `config_val` varchar(100) DEFAULT NULL COMMENT '配置项值',
  PRIMARY KEY (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='搜索设置表';

-- ----------------------------
-- Records of wz_search_config
-- ----------------------------
INSERT INTO `wz_search_config` VALUES ('fulltextenble', '0');
INSERT INTO `wz_search_config` VALUES ('relationenble', '0');
INSERT INTO `wz_search_config` VALUES ('suggestenable', '');
INSERT INTO `wz_search_config` VALUES ('sphinxenable', '');
INSERT INTO `wz_search_config` VALUES ('sphinxhost', '');
INSERT INTO `wz_search_config` VALUES ('sphinxport', '');

-- ----------------------------
-- Table structure for wz_search_index
-- ----------------------------
DROP TABLE IF EXISTS `wz_search_index`;
CREATE TABLE `wz_search_index` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '搜索索引主键',
  `m` varchar(30) DEFAULT NULL COMMENT '模块名',
  `keyid` varchar(20) DEFAULT NULL COMMENT '模块名或模型ID',
  `data_id` int(10) unsigned DEFAULT '0' COMMENT '搜索项标识ID',
  `full_title` varchar(255) DEFAULT NULL COMMENT '存放完整不分词的内容，如 标题',
  `data_key` text COMMENT '分词结果',
  `updatetime` datetime DEFAULT NULL COMMENT '索引更新时间',
  PRIMARY KEY (`id`),
  KEY `data_id` (`data_id`,`keyid`),
  FULLTEXT KEY `data_key` (`data_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='搜索索引表';

-- ----------------------------
-- Records of wz_search_index
-- ----------------------------

-- ----------------------------
-- Table structure for wz_search_result
-- ----------------------------
DROP TABLE IF EXISTS `wz_search_result`;
CREATE TABLE `wz_search_result` (
  `id` int(10) unsigned NOT NULL COMMENT '搜索索引ID',
  `title` varchar(80) DEFAULT NULL COMMENT '搜索结果显示标题',
  `remark` varchar(100) DEFAULT NULL COMMENT '搜索结果显示简介',
  `url` varchar(255) DEFAULT NULL COMMENT '内容的URL',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片的URL',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='搜索结果表';

-- ----------------------------
-- Records of wz_search_result
-- ----------------------------

-- ----------------------------
-- Table structure for wz_session
-- ----------------------------
DROP TABLE IF EXISTS `wz_session`;
CREATE TABLE `wz_session` (
  `sessionid` char(32) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `role` char(200) DEFAULT NULL,
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL,
  `f` char(20) NOT NULL,
  `v` char(20) NOT NULL,
  `data` char(255) NOT NULL,
  PRIMARY KEY (`sessionid`),
  KEY `lastvisit` (`lastvisit`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_session
-- ----------------------------
INSERT INTO `wz_session` VALUES ('e4ptcv8246tmfqvpq45spjanq7', '1', '127.0.0.1', '1524390496', ',1,', '0', 'core', 'index', 'keep_alive', 'code|s:0:\"\";uid|i:1;role|s:3:\",1,\";ip|s:9:\"127.0.0.1\";lock_screen|i:0;');

-- ----------------------------
-- Table structure for wz_setting
-- ----------------------------
DROP TABLE IF EXISTS `wz_setting`;
CREATE TABLE `wz_setting` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `keyid` varchar(20) NOT NULL COMMENT '主键id，例如：logo',
  `m` varchar(20) NOT NULL COMMENT '所属模块',
  `f` varchar(20) NOT NULL,
  `v` varchar(20) NOT NULL,
  `title` varchar(80) NOT NULL COMMENT '含义，标题',
  `data` text NOT NULL COMMENT '值',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `keyid` (`keyid`,`m`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='系统配置，模块配置表，其它相关配置';

-- ----------------------------
-- Records of wz_setting
-- ----------------------------
INSERT INTO `wz_setting` VALUES ('1', 'cache_all', 'core', 'template', 'cache_dir_template', '', '模板界面', '2014-07-27 04:15:00');
INSERT INTO `wz_setting` VALUES ('15', 'cache_all', 'core', 'cache_role', 'cache_all', '', '角色', '2014-11-11 13:39:58');
INSERT INTO `wz_setting` VALUES ('2', 'configs', 'core', '', '', '', 'a:8:{s:8:\"sitename\";s:33:\"五指CMS网站内容管理系统\";s:4:\"logo\";s:25:\"/res/images/head_logo.png\";s:12:\"seo_keywords\";s:52:\"五指CMS网站内容管理系统,cms,wuzhicms系统\";s:15:\"seo_description\";s:33:\"五指CMS网站内容管理系统\";s:9:\"copyright\";s:100:\"Copyright © 2017 北京五指互联科技有限公司 All Rights Reserved<br>京ICP备14036160号-1\";s:8:\"statcode\";s:0:\"\";s:5:\"close\";s:1:\"0\";s:12:\"close_reason\";s:36:\"站点升级中，请稍后访问！\";}', '2016-05-26 10:41:28');
INSERT INTO `wz_setting` VALUES ('37', 'cache_all', 'promote', 'promote_cache', 'cache_all', '', '广告位', '2016-05-18 11:55:22');
INSERT INTO `wz_setting` VALUES ('3', 'safe', 'core', '', '', '', 'a:2:{s:7:\"ban_ips\";s:0:\"\";s:14:\"adminlogin_ips\";s:0:\"\";}', '2015-05-16 11:49:48');
INSERT INTO `wz_setting` VALUES ('4', 'sendmail', 'core', '', '', '', 'a:10:{s:9:\"mail_type\";s:1:\"0\";s:11:\"smtp_server\";s:11:\"smtp.qq.com\";s:9:\"smtp_port\";s:3:\"465\";s:4:\"auth\";s:1:\"1\";s:7:\"openssl\";s:1:\"1\";s:9:\"smtp_user\";s:16:\"188434853@qq.com\";s:10:\"send_email\";s:16:\"188434853@qq.com\";s:8:\"nickname\";s:15:\"五指cms演示\";s:4:\"sign\";s:99:\"<hr />\r\n邮件签名：欢迎访问 <a href=\"http://www.wuzhicms.com\" target=\"_blank\">五指cms</a>\";s:8:\"password\";s:32:\"rGcUGkIa7lKGAv0SNxydRMPEBd0WqJVr\";}', '2016-05-18 17:29:01');
INSERT INTO `wz_setting` VALUES ('5', 'cache_all', 'content', 'category_cache', 'cache_all', '', '栏目缓存（内容模块）', '2014-08-20 07:30:45');
INSERT INTO `wz_setting` VALUES ('6', 'setting', 'member', '', '', '', 'a:28:{s:8:\"register\";s:1:\"1\";s:10:\"checkemail\";s:1:\"0\";s:11:\"checkmobile\";s:1:\"0\";s:9:\"checkuser\";s:1:\"1\";s:6:\"invite\";s:1:\"0\";s:11:\"inviteprice\";s:2:\"10\";s:9:\"invitenum\";a:9:{i:1;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:2;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:3;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:6;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:7;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:8;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:9;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:4;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}i:5;a:2:{s:4:\"free\";s:0:\"\";s:3:\"buy\";s:0:\"\";}}s:6:\"points\";s:2:\"10\";s:12:\"showprotocol\";s:1:\"0\";s:8:\"protocol\";s:8105:\"重要须知：\r\n　　本协议是您与北京五指互联有限公司及其合作单位（以下简称：“五指互联公司”）之间关于五指互联公司提供的各种产品及服务（以下统称：五指CMS）的法律协议。 五指互联在此特别提醒，您欲使用五指CMS，必须事先认真阅读本服务条款中各条款，包括免除或者限制五指互联责任的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款（未成年人审阅时应得到法定监护人的陪同）。如您不同意本服务条款及/或五指互联随时对其的修改，您应不使用或主动取消五指互联公司提供的五指CMS。否则，您的任何对五指CMS中的相关服务的登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受五指互联对服务条款随时所做的任何修改。\r\n　　本服务条款一旦发生变更, 五指互联将在网页上公布修改内容。修改后的服务条款一旦在网页上公布即有效代替原来的服务条款。您可随时登陆五指互联官方论坛查阅最新版服务条款。\r\n\r\n　　如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，五指互联公司有权随时中止或终止您对五指CMS的使用资格并保留追究相关法律责任的权利。\r\n\r\n一、产品保护条款\r\n\r\n　　1. 五指CMS是由五指互联公司版权所有。五指CMS的一切版权以及与五指CMS相关的所有信息内容，包括但不限于：文字表述及其组合、图标、图饰、图表、色彩、版面设计、数据、印刷材料、或电子文档等均受著作权法和国际著作权条约以及其他知识产权法律法规的保护。\r\n　　2. 您须明白，使用本服务产品涉及到互联网服务，可能会受到各个环节不稳定因素的影响。因此服务存在不可抗力、计算机病毒或黑客攻击、系统不稳定、用户所在位置、用户关机以及其他任何技术、互联网络、通信线路原因等造成的服务中断或不能满足用户要求的风险。您须承担以上风险，五指互联不作担保。\r\n　　3. 如五指互联的系统发生故障影响到本服务的正常运行，五指互联承诺在第一时间内与相关单位配合，及时处理进行修复。但您因此而产生的经济损失，五指互联不承担责任。此外，五指互联保留不经事先通知为维修保养、升级或其他目的暂停本服务任何部分的权利。\r\n　　4．使用本服务必须遵守国家有关法律和政策等，维护国家利益，保护国家安全，并遵守本条款，对于您违法或违反本条款的使用(包括但不限于言论发表、传送等)而引起的一切责任，由您负全部责任，概与五指互联及合作单位无关，导致五指互联及合作单位损失的，五指互联及合作单位有权要求赔偿，并有权立即停止向其提供服务，保留相关记录，并保留配合司法机关追究法律责任的权利。\r\n　　5．您同意个人隐私信息是指那些能够对您进行个人辨识或涉及个人通信的信息，包括下列信息：您的姓名，身份证号，手机号码，IP地址，电子邮件地址信息。而非个人隐私信息是指您登陆的帐号、对软件的操作状态以及使用习惯等您的操作记录信息和其他一切个人隐私信息范围外的普通信息。五指互联将会采取合理的措施保护您的个人隐私信息，除法律或有法律赋予权限的政府部门要求或您同意等原因外，五指互联未经您同意不向除合作单位以外的第三方公开、 透露您个人隐私信息。您同意，为了运营和改善五指互联的技术和服务，五指互联可以在无须再另行通知或提示您的情况下，自己收集使用或向第三方提供使用您的非个人隐私信息，以有助于五指互联及合作单位向用户提供更好的用户体验和提高服务质量。\r\n\r\n二、用户使用须知\r\n\r\n　　特别提醒您，使用互联网必须遵守国家有关的政策和法律，如刑法、国家安全法、保密法、计算机信息系统安全保护条例等，保护国家利益，保护国家安全，对于违法使用互联网络而引起的一切责任，由您负全部责任。\r\n　　1. 您不得使用五指CMS发送或传播任何妨碍社会治安或非法、虚假、骚扰性、侮辱性、恐吓性、伤害性、破坏性、挑衅性、淫秽色情性等内容的信息。\r\n　　2. 您不得使用五指互联软件产品发送或传播敏感信息和违反国家法律制度的信息。\r\n　　3. 您保证以真实的身份注册使用五指互联的软件产品，向五指互联所提供的个人身份资料信息真实、完整、有效，依据法律规定和约定对所提供的信息承担相应的法律责任。如果资料发生变化，您应及时更改。五指互联会及时、有效地提供该项服务。在安全完成本服务的登记程序后，您应维持密码及帐号的机密安全。您应对任何人利用您的密码及帐号所进行的活动负完全的责任，五指互联公司无法对非法或未经您授权使用您帐号及密码的行为作出甄别，因此五指互联公司不承担任何责任。\r\n　　4. 盗取他人号码或利用网络通讯骚扰他人，均属于非法行为。您不得采用测试、欺骗等任何非法手段，盗取其他用户的帐号和对他人进行骚扰。\r\n　　5. 五指互联在此郑重提请您注意，任何经由本服务以上传、下载、张贴、电子邮件或任何其他方式传送的资讯、资料、文字、软件、音乐、音讯、照片、图形、视讯、信息、用户的登记资料或其他资料等（以下简称“内容”），无论系公开还是私下传送，均由内容提供者承担责任。同时，为了提高、改进五指互联各种服务的用户体验，您同意五指互联对凡是您经由本服务通过上传、张贴等任何方式发布到五指CMS的任何文字、图片及其他信息资料等进行无偿的修改、复制、传播等使用。五指互联无法监控经由本服务传送之内容，也无法对用户的使用行为进行全面控制，因此不保证内容的合法性、正确性、完整性、真实性或品质等；您已预知使用本服务时，可能会接触到令人不快、不适当或令人厌恶之内容，并同意将自行加以判断并承担所有风险，而不依赖于五指互联。但在任何情况下，五指互联公司有权依法停止任何前述内容的服务并采取相应行动，包括但不限于暂停用户使用本服务的全部或部分，保存有关记录，并向有关机关报告。但五指互联有权(但无义务)依其自行之考量，拒绝和删除可经由本服务提供之违反本条款的或其他引起五指互联或其他用户反感的任何内容。\r\n　　6. 五指CMS属于群体类产品，使用五指互联软件产品服务的用户之间引发的任何纠纷五指互联公司将不负责任。\r\n\r\n\r\n\r\n三、服务声明五指互联公司特别提请您注意，五指互联公司为了保障公司业务发展和调整的自主权，五指互联公司拥有随时修改或中断服务而不需通知您的权利，五指互联公司行使修改或中断服务的权利不需对您或任何第三方负责。您必须在同意本条款的前提下，五指互联公司才开始对您提供服务。\r\n\r\n四、适用法律\r\n　　本服务条款的解释，效力及纠纷的解决，适用于中华人民共和国大陆法律。\r\n　　若您和五指互联之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，您在此完全同意将纠纷或争议提交五指互联所在地北京市海淀区人民法院管辖。五指互联公司拥有对以上各项条款内容的解释权及修改权。\r\n\r\n五指互联公司\";s:7:\"ucenter\";s:1:\"0\";s:6:\"uc_api\";s:28:\"http://bbstest.com/uc_server\";s:5:\"uc_ip\";s:9:\"127.0.0.1\";s:8:\"uc_appid\";s:1:\"2\";s:6:\"uc_key\";s:16:\"e063rbkHX22RAvIg\";s:9:\"uc_dbhost\";s:9:\"localhost\";s:9:\"uc_dbuser\";s:5:\"admin\";s:7:\"uc_dbpw\";s:5:\"admin\";s:9:\"uc_dbname\";s:7:\"bbstest\";s:13:\"uc_dbtablepre\";s:22:\"`bbstest`.pre_ucenter_\";s:17:\"discuz_dbtablepre\";s:0:\"\";s:12:\"uc_dbcharset\";s:3:\"gbk\";s:8:\"qq_appid\";s:0:\"\";s:9:\"qq_appkey\";s:0:\"\";s:8:\"sina_key\";s:0:\"\";s:11:\"sina_secret\";s:0:\"\";s:10:\"weixin_key\";s:0:\"\";s:13:\"weixin_secret\";s:0:\"\";}', '2014-08-23 08:53:34');
INSERT INTO `wz_setting` VALUES ('7', 'open', 'content', '', '', '', '1', '2014-09-14 07:00:06');
INSERT INTO `wz_setting` VALUES ('8', 'has_model', 'content', '', '', '', '1', '2014-09-14 07:05:51');
INSERT INTO `wz_setting` VALUES ('9', 'has_model', 'member', '', '', '', '1', '2014-09-16 15:35:22');
INSERT INTO `wz_setting` VALUES ('10', 'configs', 'mobile', '', '', '', 'a:5:{s:8:\"sitename\";s:21:\"五指互联手机站\";s:4:\"logo\";s:23:\"/res/t1/images/logo.jpg\";s:11:\"seo_keyword\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:9:\"copyright\";s:0:\"\";}', '2014-10-24 05:55:26');
INSERT INTO `wz_setting` VALUES ('12', 'ueditor', 'attachment', '', '', '', 'a:7:{s:15:\"imagePathFormat\";s:31:\"{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:16:\"scrawlPathFormat\";s:42:\"screenshot/{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:20:\"snapscreenPathFormat\";s:42:\"screenshot/{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:14:\"filePathFormat\";s:31:\"{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:15:\"videoPathFormat\";s:31:\"{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:17:\"catcherPathFormat\";s:31:\"{yyyy}/{mm}/{dd}/{time}{rand:6}\";s:22:\"catchRemoteImageEnable\";s:1:\"0\";}', '0000-00-00 00:00:00');
INSERT INTO `wz_setting` VALUES ('18', 'email_setting', 'coupon', '', '', '', 'a:2:{s:11:\"email_title\";s:21:\"五指cms－优惠券\";s:13:\"email_content\";s:195:\"尊敬的用户您好：\r\n五指cms 清明节立减活动，##title## ，套餐访问地址：##url##\r\n价值##money##元现金券，优惠券编号：##card_no##，截止日期：##endtime##\r\n\r\n\";}', '2015-04-17 17:17:44');
INSERT INTO `wz_setting` VALUES ('31', 'wuzhicms_token', 'core', '', '', '', '', '2015-05-16 11:49:48');
INSERT INTO `wz_setting` VALUES ('13', 'cache_all', 'core', 'cache_model', 'cache_all', '', '模型', '2014-11-11 03:02:02');
INSERT INTO `wz_setting` VALUES ('14', 'cache_all', 'core', 'badword', 'cache_all', '', '敏感词', '2014-11-11 03:02:06');
INSERT INTO `wz_setting` VALUES ('16', 'cache_all', 'linkage', 'cache_linkage', 'cache', '', '联动菜单', '2014-11-13 02:00:46');
INSERT INTO `wz_setting` VALUES ('17', 'configs', 'credit', '', '', '', 'a:7:{s:6:\"status\";s:1:\"1\";s:12:\"mobile_check\";s:1:\"5\";s:11:\"email_check\";s:2:\"10\";s:17:\"jingjia_pre_point\";s:2:\"10\";s:10:\"cominfoadd\";s:1:\"2\";s:10:\"cominfo_f5\";s:1:\"3\";s:14:\"exchange_point\";s:3:\"100\";}', '2015-04-21 13:19:28');
INSERT INTO `wz_setting` VALUES ('29', 'fullpage', 'weixin', '', '', '', 'a:6:{i:0;a:4:{s:5:\"Title\";s:12:\"爱的宣言\";s:11:\"Description\";s:60:\"对你们的喜爱和祝福我们都写在这款产品里。\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/1-3.png\";i:2;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/1-1.png\";i:3;s:0:\"\";}s:3:\"Url\";s:0:\"\";}i:1;a:4:{s:5:\"Title\";s:21:\"找到真正的自己\";s:11:\"Description\";s:184:\"现代美女宣言：把60岁的男人思想搞乱，把50岁的男人财产霸占，让40岁的男人妻离子散，把30岁的男人腰杆搞断，让20岁的男人都他妈滚蛋！\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/2-1.png\";i:2;s:0:\"\";i:3;s:0:\"\";}s:3:\"Url\";s:0:\"\";}i:2;a:4:{s:5:\"Title\";s:39:\"今年夏天，与爱轻松邂逅！！\";s:11:\"Description\";s:94:\"两人不同世界的人,却擦出了爱的火花。她努力奋斗。他天才不羁男……\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/3-1.png\";i:2;s:0:\"\";i:3;s:0:\"\";}s:3:\"Url\";s:0:\"\";}i:3;a:4:{s:5:\"Title\";s:14:\"1 + 1我和你\";s:11:\"Description\";s:94:\"两人不同世界的人,却擦出了爱的火花。她努力奋斗。他天才不羁男……\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/4-2.png\";i:2;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/4-2.png\";i:3;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/4-2.png\";}s:3:\"Url\";s:0:\"\";}i:4;a:4:{s:5:\"Title\";s:18:\"贝贝魅力四射\";s:11:\"Description\";s:94:\"两人不同世界的人,却擦出了爱的火花。她努力奋斗。他天才不羁男……\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/5-1.png\";i:2;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/5-2.png\";i:3;s:0:\"\";}s:3:\"Url\";s:0:\"\";}i:5;a:4:{s:5:\"Title\";s:15:\"女神恋爱季\";s:11:\"Description\";s:94:\"两人不同世界的人,却擦出了爱的火花。她努力奋斗。他天才不羁男……\";s:6:\"PicUrl\";a:3:{i:1;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/8-1.png\";i:2;s:53:\"http://nv.wuzhicms.com/res/nvshen/huadong/img/8-2.png\";i:3;s:0:\"\";}s:3:\"Url\";s:0:\"\";}}', '2015-04-13 10:26:20');
INSERT INTO `wz_setting` VALUES ('22', 'jsapi_ticket', 'weixin', '', '', '', 'bxLdikRXVbTPdHSM05e5u55FIme-lN9Sz64-buNG1zl9nxbA-Bm2S_jlVT_bX_TTslD_hAToz5nUMO6DRKpv-g', '2015-03-31 07:59:53');
INSERT INTO `wz_setting` VALUES ('21', 'reply_content', 'weixin', '', '', '', 'a:1:{s:13:\"reply_content\";s:126:\"~\\(≧▽≦)/~\r\n不好意思！小智暂时没办法回答您的提问！\r\n如需人工服务，请拨打电话：18911549611\";}', '2015-03-27 07:20:36');
INSERT INTO `wz_setting` VALUES ('20', 'subscribe', 'weixin', '', '', '', 'a:2:{s:7:\"msgtype\";i:1;s:7:\"content\";s:21:\"感谢您的关注！\";}', '2015-03-27 04:59:25');
INSERT INTO `wz_setting` VALUES ('30', 'access_token', 'weixin', '', '', '', 'H6Zhi61yYuzwbL6YdZJMaS_eaxFHN7Rgyownt8LIIVm51PBDH_8RCO1NZ1ldNqTvYDwurU_wZAS9OwTOzQRWMB-vQVsryyxzbFnDX4YlUVc', '2015-03-26 09:46:10');
INSERT INTO `wz_setting` VALUES ('19', 'configs', 'weixin', '', '', '', '{\r\n    \"button\": [\r\n        {\r\n            \"type\": \"view\",\r\n            \"name\": \"参与互动\",\r\n            \"url\": \"http://nv.wuzhicms.com/index.php?m=member&f=hudong\"\r\n        },\r\n        {\r\n            \"name\": \"嘉宾展示\",\r\n            \"sub_button\": [\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"围观男嘉宾\",\r\n                    \"url\": \"http://nv.wuzhicms.com/index.php?v=listing&cid=50\"\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"壁咚女神\",\r\n                    \"url\": \"http://nv.wuzhicms.com/index.php?v=listing&cid=52\"\r\n                }\r\n            ]\r\n        },\r\n         {\r\n            \"type\": \"view\",\r\n            \"name\": \"我的主页\",\r\n            \"url\": \"http://nv.wuzhicms.com/index.php?m=member&f=myhome\"\r\n        }\r\n    ]\r\n}', '2015-03-27 03:29:20');
INSERT INTO `wz_setting` VALUES ('34', 'cache_all', 'core', 'cache_global_vars', 'cache_all', '', '自定义全局变量', '2016-04-11 08:58:06');
INSERT INTO `wz_setting` VALUES ('35', 'cache_all', 'content', 'block_cache', 'cache_all', '', '推荐位', '2016-04-11 09:51:52');
INSERT INTO `wz_setting` VALUES ('38', 'install', 'core', '', '', '五指CMS核心', '0', '2017-02-24 11:32:05');
INSERT INTO `wz_setting` VALUES ('39', 'install', 'content', '', '', '内容模块', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('40', 'install', 'member', '', '', '会员模块', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('41', 'install', 'sms', '', '', '短信发送', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('42', 'install', 'template', '', '', '模版管理', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('43', 'install', 'mobile', '', '', '手机触屏', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('44', 'install', 'attachment', '', '', '附件管理', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('45', 'install', 'appupdate', '', '', '在线更新', '0', '2017-02-24 03:32:05');
INSERT INTO `wz_setting` VALUES ('50', 'install', 'affiche', '', '', '公告', '1', '2017-02-24 14:40:39');
INSERT INTO `wz_setting` VALUES ('51', 'install', 'credit', '', '', '积分模块', '1', '2017-02-24 14:55:31');
INSERT INTO `wz_setting` VALUES ('54', 'install', 'feedback', '', '', '问题反馈', '1', '2017-02-24 15:01:25');
INSERT INTO `wz_setting` VALUES ('79', 'install', 'guestbook', '', '', '留言板', '1', '2018-04-22 15:27:31');
INSERT INTO `wz_setting` VALUES ('72', 'install', 'link', '', '', '友情链接', '1', '2018-04-19 20:46:18');
INSERT INTO `wz_setting` VALUES ('57', 'install', 'linkage', '', '', '联动菜单模块', '0', '2017-02-24 11:32:05');
INSERT INTO `wz_setting` VALUES ('58', 'install', 'message', '', '', '站内消息', '1', '2017-02-24 15:05:38');
INSERT INTO `wz_setting` VALUES ('59', 'install', 'order', '', '', '订单模块', '1', '2017-02-24 15:06:30');
INSERT INTO `wz_setting` VALUES ('60', 'install', 'pay', '', '', '在线支付模块', '1', '2017-02-24 15:07:12');
INSERT INTO `wz_setting` VALUES ('61', 'install', 'promote', '', '', '广告管理模块', '1', '2017-02-24 15:11:00');
INSERT INTO `wz_setting` VALUES ('67', 'install', 'database', '', '', '数据库备份', '1', '2017-02-24 15:33:04');
INSERT INTO `wz_setting` VALUES ('69', 'member_tips', 'global_vars', '', '', '会员中心投稿提示', '投稿之后，我们会在24小时之内审批，如需加急审批，请拨打电话：010-00000000', '2017-02-27 13:06:46');
INSERT INTO `wz_setting` VALUES ('70', 'setting', 'comment', '', '', '', 'a:2:{s:4:\"open\";s:1:\"1\";s:11:\"allow_guest\";s:1:\"1\";}', '2016-06-16 06:59:27');
INSERT INTO `wz_setting` VALUES ('71', 'uploaddir', 'attachment', '', 'down', '下载模型路径替换', '/uploadfile', '2017-06-03 15:18:33');

-- ----------------------------
-- Table structure for wz_site
-- ----------------------------
DROP TABLE IF EXISTS `wz_site`;
CREATE TABLE `wz_site` (
  `siteid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `html_root` varchar(200) NOT NULL COMMENT '生成html物理路径',
  `setting` text NOT NULL COMMENT '配置文件',
  `baidu_site` varchar(50) NOT NULL COMMENT '百度站长平台自动提交site',
  `baidu_token` varchar(32) NOT NULL COMMENT '百度站长平台自动提交token',
  PRIMARY KEY (`siteid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_site
-- ----------------------------
INSERT INTO `wz_site` VALUES ('1', '默认站点', '/res/images/userimg.jpg', 'http://www.v5.com/', '', 'a:10:{s:8:\"sitename\";s:7:\"wuzhicms\";s:12:\"seo_keywords\";s:6:\"wuzhicms\";s:15:\"seo_description\";s:10:\"wuzhicms\";s:4:\"logo\";s:0:\"\";s:5:\"logo2\";s:0:\"\";s:9:\"copyright\";s:0:\"\";s:8:\"statcode\";s:0:\"\";s:16:\"access_authority\";s:1:\"0\";s:5:\"close\";s:1:\"0\";s:12:\"close_reason\";s:0:\"\";}', '', '');



-- ----------------------------
-- Table structure for wz_template_history
-- ----------------------------
DROP TABLE IF EXISTS `wz_template_history`;
CREATE TABLE `wz_template_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyid` char(32) NOT NULL COMMENT '模板md5',
  `dir` char(100) NOT NULL,
  `file` char(30) NOT NULL,
  `data` text NOT NULL COMMENT '模板内容',
  `addtime` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `username` char(20) NOT NULL COMMENT '修改人',
  PRIMARY KEY (`id`),
  KEY `keyid` (`keyid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='模版历史版本记录';

-- ----------------------------
-- Records of wz_template_history
-- ----------------------------

-- ----------------------------
-- Table structure for wz_topic
-- ----------------------------
DROP TABLE IF EXISTS `wz_topic`;
CREATE TABLE `wz_topic` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `kid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `name` varchar(200) NOT NULL COMMENT '专题名称',
  `remark` text NOT NULL COMMENT '专题描述',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `thumb` varchar(255) NOT NULL COMMENT '专题缩略图',
  `banner` varchar(255) NOT NULL COMMENT '专题banner',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `upgrade_status` tinyint(1) unsigned NOT NULL DEFAULT '9' COMMENT '9 长期更新，0 停止更新',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `index_template` varchar(80) NOT NULL,
  `list_template` varchar(80) NOT NULL,
  `show_template` varchar(100) NOT NULL,
  `styleid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '绑定风格id',
  `files` text NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='专题表';

-- ----------------------------
-- Records of wz_topic
-- ----------------------------

-- ----------------------------
-- Table structure for wz_topic_content
-- ----------------------------
DROP TABLE IF EXISTS `wz_topic_content`;
CREATE TABLE `wz_topic_content` (
  `tcid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tid` int(10) unsigned NOT NULL COMMENT '专题id',
  `kid1name` varchar(50) NOT NULL COMMENT '大栏目名称',
  `kid2name` varchar(50) NOT NULL COMMENT '子栏目名称',
  `kid1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '大栏目id',
  `kid2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '子栏目id',
  `sid` int(10) unsigned NOT NULL COMMENT '共享文章总表id',
  `importtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导入时间or添加时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `remark` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1待审核，9通过审核，0已删除',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 外链',
  PRIMARY KEY (`tcid`),
  KEY `tid` (`tid`,`sid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题对应内容表';

-- ----------------------------
-- Records of wz_topic_content
-- ----------------------------

-- ----------------------------
-- Table structure for wz_video_data
-- ----------------------------
DROP TABLE IF EXISTS `wz_video_data`;
CREATE TABLE `wz_video_data` (
  `id` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groups` varchar(100) NOT NULL,
  `template` varchar(30) NOT NULL,
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `youku` char(255) NOT NULL DEFAULT '',
  `tudou` char(255) NOT NULL DEFAULT '',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wz_video_data
-- ----------------------------

-- ----------------------------
-- Table structure for wz_workflow
-- ----------------------------
DROP TABLE IF EXISTS `wz_workflow`;
CREATE TABLE `wz_workflow` (
  `workflowid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `keyid` varchar(20) NOT NULL COMMENT '所属模块或唯一id',
  `name` varchar(20) NOT NULL COMMENT '工作流名称',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核层级数',
  `level1_user` text NOT NULL COMMENT '一审用户id',
  `level2_user` text NOT NULL COMMENT '二审用户id',
  `level3_user` text NOT NULL COMMENT '三审用户id',
  `level4_user` text NOT NULL,
  `level1_name` varchar(40) NOT NULL,
  `level2_name` varchar(40) NOT NULL,
  `level3_name` varchar(40) NOT NULL,
  `level4_name` varchar(40) NOT NULL,
  PRIMARY KEY (`workflowid`),
  KEY `keyid` (`keyid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='工作流';

-- ----------------------------
-- Records of wz_workflow
-- ----------------------------
INSERT INTO `wz_workflow` VALUES ('1', 'content', '一级审核', '1', '', '', '', '', '编辑发布', '', '', '');
INSERT INTO `wz_workflow` VALUES ('2', 'content', '二级审核', '2', '', '', '', '', '投稿待审', '编辑发布', '', '');
INSERT INTO `wz_workflow` VALUES ('3', 'content', '三级审核', '3', '', '', '', '', '投稿待审', '编辑初编', '编辑发布', 'ff');
INSERT INTO `wz_workflow` VALUES ('4', 'content', '四级审核', '4', '', '', '', '', '投稿待审', '编辑初编', '编辑复核', '编辑发布');

ALTER TABLE `wz_admin` CHANGE `role` `role` VARCHAR(200) NOT NULL;
UPDATE `wz_admin` SET `role` = REPLACE(`role`, ',', '') WHERE `role` LIKE '%,%';
UPDATE wz_admin SET `role` = concat(',',`role`,',');

ALTER TABLE `wz_session` CHANGE `role` `role` CHAR(200) NULL;
TRUNCATE TABLE `wz_session`;


DROP TABLE IF EXISTS `wz_member_group_extend`;
CREATE TABLE `wz_member_group_extend` (
  `extid` int(10) UNSIGNED NOT NULL,
  `uid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `groupid` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `unit` enum('y','m','d') NOT NULL DEFAULT 'y',
  `price` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `number` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `startdate` date NOT NULL DEFAULT '0000-00-00',
  `enddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` char(15) NOT NULL,
  `time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wz_member_group_extend`
--
ALTER TABLE `wz_member_group_extend`
  ADD PRIMARY KEY (`extid`),
  ADD UNIQUE KEY `uid` (`uid`,`groupid`),
  ADD KEY `groupid` (`groupid`,`disabled`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `wz_member_group_extend`
--
ALTER TABLE `wz_member_group_extend`
  MODIFY `extid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

DELETE FROM `wz_member_group` WHERE `wz_member_group`.`groupid` = 4;
INSERT INTO `wz_member_group` (`groupid`, `name`, `issystem`, `points`, `upgrade`, `money_y`, `money_m`, `money_d`, `sort`, `icon`) VALUES ('4', '游客', '1', '0', '0', '0.00', '0.00', '0.00', '0', '');
DELETE FROM `wz_member_group` WHERE `wz_member_group`.`groupid` = 5;
INSERT INTO `wz_member_group` (`groupid`, `pid`, `name`, `issystem`, `points`, `upgrade`, `money_y`, `money_m`, `money_d`, `sort`, `icon`) VALUES ('5', '0', '待审核', '1', '0', '0', '0.00', '0.00', '0.00', '5', '');

DROP TABLE IF EXISTS `wz_content_ids`;
CREATE TABLE `wz_content_ids` (
  `ciid` int(10) UNSIGNED NOT NULL,
  `siteid` tinyint(3) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL COMMENT '原始内容id',
  `cid` int(10) UNSIGNED NOT NULL,
  `new_id` int(10) UNSIGNED NOT NULL COMMENT '新的id',
  `new_siteid` tinyint(3) UNSIGNED NOT NULL,
  `new_cid` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站群内容对应关系';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wz_content_ids`
--
ALTER TABLE `wz_content_ids`
ADD PRIMARY KEY (`ciid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `wz_content_ids`
--
ALTER TABLE `wz_content_ids`
MODIFY `ciid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
INSERT INTO `wz_model_field` (`modelid`, `field`, `name`, `remark`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `ext_code`, `unsetgids`, `unsetroles`, `master_field`, `ban_field`, `location`, `search_field`, `ban_contribute`, `to_fulltext`, `to_block`, `sort`, `disabled`, `powerful_field`, `workflow_field`) VALUES
  (8, 'point_money', '积分＋现金', '', '', 0, 0, '', '', 'powerful', 'a:3:{s:8:"formtext";s:138:"<input type="text" name="form[point_money]" id="point_money" value="{FIELD_VALUE}" class="input-text" placeholder="积分">\r\n\r\n＋ {price}";s:9:"fieldtype";s:7:"varchar";s:9:"minnumber";s:1:"1";}', '', '', '', 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0);
UPDATE `wz_model_field` SET `field`='price',`name`='现金价',`remark`='',`ext_code`='',`minlength`='0',`maxlength`='0',`pattern`='',`errortips`='',`location`='0',`search_field`='0',`ban_contribute`='1',`to_fulltext`='1',`powerful_field`='1',`to_block`='0',`workflow_field`='0',`modelid`='8',`setting`='a:2:{s:9:\"fieldtype\";s:3:\"int\";s:12:\"defaultvalue\";s:0:\"\";}',`unsetgids`='',`unsetroles`=''  WHERE  `id` = '412';
UPDATE `wz_model_field` SET `field`='point_money',`name`='积分＋现金',`remark`='',`ext_code`='',`minlength`='0',`maxlength`='0',`pattern`='',`errortips`='',`location`='0',`search_field`='0',`ban_contribute`='1',`to_fulltext`='1',`powerful_field`='0',`to_block`='0',`workflow_field`='0',`modelid`='8',`setting`='a:3:{s:8:\"formtext\";s:138:\"<input type=\"text\" name=\"form[point_money]\" id=\"point_money\" value=\"{FIELD_VALUE}\" class=\"input-text\" placeholder=\"积分\">\r\n\r\n＋ {price}\";s:9:\"fieldtype\";s:9:\"mediumint\";s:9:\"minnumber\";s:1:\"1\";}',`unsetgids`='',`unsetroles`=''  WHERE  `field` = 'point_money';
ALTER TABLE `wz_point2goods` CHANGE `price` `price` decimal(10,2) NOT NULL default '0.00';

ALTER TABLE `wz_payment` CHANGE `id` `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT;

DELETE FROM `wz_model` WHERE  `modelid` = '2';
DELETE FROM `wz_model_field` WHERE  `modelid` = '2';


INSERT INTO `wz_model` (`modelid`, `m`, `name`, `master_table`, `attr_table`, `remark`, `template`, `css`, `share_model`, `manage_template`) VALUES
  (2, 'content', '团购', 'tuangou', 'tuangou_data', '', 'show', '', 0, '');



INSERT INTO `wz_model_field` (`modelid`, `field`, `name`, `remark`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `ext_code`, `unsetgids`, `unsetroles`, `master_field`, `ban_field`, `location`, `search_field`, `ban_contribute`, `to_fulltext`, `to_block`, `sort`, `disabled`, `powerful_field`, `workflow_field`) VALUES
  (2, 'addtime', '添加时间', '', '', 0, 0, '', '', 'datetime', 'a:2:{s:9:"fieldtype";s:3:"int";s:6:"format";s:11:"Y-m-d H:i:s";}', '', '', '', 1, 1, 1, 0, 0, 0, 1, 12, 0, 0, 0),
  (2, 'block', '添加到推荐位', '', '', 0, 0, '', '', 'block', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0),
  (2, 'groups', '用户组权限', '', '', 0, 0, '', '', 'group', 'a:1:{s:6:"groups";s:3:"4,5";}', '', '', '', 0, 0, 2, 0, 0, 0, 0, 18, 0, 0, 0),
  (2, 'url', '链接地址', '', '', 0, 0, '', '', 'url', '', '', '', '', 1, 1, 1, 0, 0, 0, 1, 11, 0, 0, 0),
  (2, 'sort', '权重', '', '', 0, 255, '', '', 'slider', 'a:1:{s:12:"defaultvalue";s:1:"0";}', '', '', '', 1, 1, 1, 0, 0, 0, 0, 20, 0, 0, 0),
  (2, 'template', '内容页模板', '', '', 0, 0, '', '', 'template', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, 21, 0, 0, 0),
  (2, 'allowcomment', '允许评论', '', '', 0, 0, '', '', 'box', 'a:6:{s:7:"options";s:21:"允许|1\r\n不允许|0";s:7:"boxtype";s:5:"radio";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";s:12:"defaultvalue";s:1:"1";s:10:"outputtype";s:1:"0";}', '', '', '', 0, 0, 2, 0, 0, 0, 0, 17, 0, 0, 0),
  (2, 'status', '稿件状态', '', '', 0, 0, '', '', 'box', 'a:6:{s:7:"options";s:50:"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6";s:7:"boxtype";s:5:"radio";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";s:12:"defaultvalue";s:1:"9";s:10:"outputtype";s:1:"0";}', '', '', '', 1, 1, 0, 0, 0, 0, 0, 30, 0, 0, 0),
  (2, 'thumb', '缩略图', '', '', 0, 0, '', '', 'image', 'a:6:{s:12:"defaultvalue";s:0:"";s:15:"upload_allowext";s:20:"gif|jpg|jpeg|png|bmp";s:9:"watermark";s:1:"0";s:13:"isselectimage";s:1:"1";s:12:"images_width";s:0:"";s:13:"images_height";s:0:"";}', '', '', '', 1, 1, 0, 0, 0, 0, 1, 5, 0, 0, 0),
  (2, 'relation', '相关内容', '', '', 0, 0, '', '', 'relation', 'a:3:{s:8:"formtext";s:8:"相关内容";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";}', '', '', '', 0, 0, 1, 0, 0, 0, 0, 11, 0, 0, 0),
  (2, 'remark', '摘要', '', '', 0, 0, '', '', 'textarea', 'a:2:{s:12:"defaultvalue";s:0:"";s:10:"enablehtml";s:1:"0";}', '', '', '', 1, 1, 0, 0, 0, 1, 1, 5, 0, 0, 0),
  (2, 'content', '活动详情', '', '', 0, 0, '', '', 'editor', 'a:1:{s:12:"defaultvalue";s:0:"";}', '', '', '', 0, 0, 0, 0, 0, 1, 0, 27, 0, 0, 0),
  (2, 'cid', '所属栏目', '', '', 1, 0, '', '请选择栏目', 'cid', '', '', '', '', 1, 1, 5, 0, 0, 0, 0, 1, 0, 0, 0),
  (2, 'title', '标题', '', '', 2, 80, '', '请输入标题', 'title', '', '', '', '', 1, 1, 5, 0, 0, 1, 1, 2, 0, 0, 0),
  (2, 'keywords', '关键词', '多关键词之间用半角逗号“,”隔开', '', 0, 0, '', '', 'keyword', '', '', '', '', 1, 1, 0, 1, 0, 1, 0, 4, 0, 0, 0),
  (2, 'endtime', '截止时间', '', '', 0, 0, '', '', 'datetime', 'a:2:{s:9:"fieldtype";s:3:"int";s:6:"format";s:11:"Y-m-d H:i:s";}', '', '', '', 1, 0, 0, 0, 1, 1, 0, 9, 0, 0, 0),
  (2, 'apply_quantity', '报名人数', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 0, 0, 0, 0, 1, 0, 7, 0, 0, 0),
  (2, 'phase', '第几场？', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0),
  (2, 'cylc', '参与流程', '', '', 0, 0, '', '', 'editor', 'a:2:{s:7:"toolbar";s:4:"full";s:12:"defaultvalue";s:0:"";}', '', '', '', 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0),
  (2, 'price', '保证金', '', '', 0, 0, '', '', 'coin', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0),
  (2, 'subtitle', '副标题', '', '', 0, 0, '', '', 'text', 'a:5:{s:4:"size";s:0:"";s:12:"defaultvalue";s:0:"";s:11:"placeholder";s:0:"";s:10:"ispassword";s:1:"0";s:10:"enablehtml";s:1:"0";}', '', '', '', 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0),
  (2, 'smalltitle', '小标题', '', '', 0, 0, '', '', 'text', 'a:5:{s:4:"size";s:0:"";s:12:"defaultvalue";s:0:"";s:11:"placeholder";s:0:"";s:10:"ispassword";s:1:"0";s:10:"enablehtml";s:1:"0";}', '', '', '', 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0),
  (2, 'advantage', '优势', '', '', 0, 0, '', '', 'editor', 'a:2:{s:7:"toolbar";s:5:"basic";s:12:"defaultvalue";s:0:"";}', '', '', '', 1, 0, 0, 0, 1, 1, 0, 25, 0, 0, 0),
  (2, 'FAQ', '常见问题', '', '', 0, 0, '', '', 'editor', 'a:2:{s:7:"toolbar";s:5:"basic";s:12:"defaultvalue";s:0:"";}', '', '', '', 1, 0, 0, 0, 1, 1, 0, 26, 0, 0, 0),
  (2, 'return_point', '返还积分', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `wz_tuangou`;
CREATE TABLE `wz_tuangou` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(80) NOT NULL DEFAULT '',
  `tuangouchexing` text NOT NULL,
  `css` char(24) NOT NULL DEFAULT '',
  `thumb` char(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `remark` char(255) NOT NULL DEFAULT '',
  `block` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `route` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `publisher` char(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `apply_quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `apply_quantity2` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '真实报名人数',
  `phase` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtitle` char(255) NOT NULL DEFAULT '',
  `smalltitle` char(255) NOT NULL DEFAULT '',
  `advantage` text NOT NULL,
  `FAQ` text NOT NULL,
  `return_point` int(10) unsigned NOT NULL DEFAULT '0',
  `cheat_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`sort`,`id`),
  KEY `sort` (`cid`,`status`,`sort`,`id`),
  KEY `cid` (`cid`,`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `wz_tuangou_data`
-- ----------------------------
DROP TABLE IF EXISTS `wz_tuangou_data`;
CREATE TABLE `wz_tuangou_data` (
  `id` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groups` varchar(100) NOT NULL,
  `pagetype` tinyint(1) NOT NULL,
  `maxchars` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `allowcomment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `cylc` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



UPDATE `wz_menu` SET `name`='团购列表',`pid`='3',`m`='content',`f`='content',`v`='manage',`data`='modelid=2&type=1',`display`='0'  WHERE  `menuid` = '206';
UPDATE `wz_menu` SET `name`='商家列表',`pid`='3',`m`='content',`f`='content',`v`='manage',`data`='modelid=3',`display`='0'  WHERE  `menuid` = '208';
UPDATE `wz_menu` SET `name`='商家栏目',`pid`='46',`m`='content',`f`='category',`v`='listing',`data`='modelid=3',`display`='0'  WHERE  `menuid` = '243' ;
UPDATE `wz_menu` SET `name`='团购栏目',`pid`='46',`m`='content',`f`='category',`v`='listing',`data`='modelid=2',`display`='0'  WHERE  `menuid` = '242' ;
DELETE FROM `wz_menu` WHERE  `menuid` = '209' ;

INSERT INTO `wz_model_field`(`master_field`,`field`,`name`,`remark`,`ext_code`,`minlength`,`maxlength`,`pattern`,`errortips`,`location`,`search_field`,`ban_contribute`,`to_fulltext`,`powerful_field`,`to_block`,`workflow_field`,`modelid`,`formtype`,`setting`,`unsetgids`,`unsetroles`) VALUES (7,'tudou','土豆播放','','','0','','','','0','0','1','1','0','0','0','7','video_tudou','','','');
INSERT INTO `wz_model_field`(`master_field`,`field`,`name`,`remark`,`ext_code`,`minlength`,`maxlength`,`pattern`,`errortips`,`location`,`search_field`,`ban_contribute`,`to_fulltext`,`powerful_field`,`to_block`,`workflow_field`,`modelid`,`formtype`,`setting`,`unsetgids`,`unsetroles`) VALUES (7,'youku','优酷播放','','','0','','','','0','0','1','1','0','0','0','7','video_youku','','','');


INSERT INTO `wz_setting` (`id`, `keyid`, `m`, `f`, `v`, `title`, `data`, `updatetime`) VALUES (NULL, 'cache_all', 'core', 'cache_global_vars', 'cache_all', '', '自定义全局变量', CURRENT_TIMESTAMP);

INSERT INTO `wz_setting` (`id`, `keyid`, `m`, `f`, `v`, `title`, `data`, `updatetime`) VALUES (NULL, 'cache_all', 'content', 'block_cache', 'cache_all', '', '推荐位', CURRENT_TIMESTAMP);
UPDATE `wz_menu` SET `name`='好友圈',`pid`='6',`m`='member',`f`='friend',`v`='listing',`data`='',`display`='0'  WHERE  `menuid` = '240';

INSERT INTO `wz_setting` (`keyid`, `m`, `f`, `v`, `title`, `data`, `updatetime`) VALUES
  ('cy_key', 'global_vars', '', '', '畅言appid_key', 'prod_51cde46e252516e5a1da7093b8db4c12', '2016-04-07 08:10:10'),
  ('cy_appid', 'global_vars', '', '', '畅言appid', 'cyrKWBFTI', '2016-04-07 08:00:45');

ALTER TABLE `wz_model` CHANGE `master_table` `master_table` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主表名称';
ALTER TABLE `wz_model` CHANGE `attr_table` `attr_table` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '附属表名称';
UPDATE `wz_block_data` SET `keyid` = REPLACE(`keyid`, '-zh', '') WHERE `keyid` LIKE '%-zh%';
UPDATE wz_block_data SET `keyid`=CONCAT(`keyid`,'-zh');
DELETE FROM `wz_model_field` WHERE `modelid`=10 and `master_field`=1;

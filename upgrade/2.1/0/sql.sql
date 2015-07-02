ALTER TABLE `wz_attachment` ADD `md5file` VARCHAR(32) NOT NULL ;
ALTER TABLE `wz_attachment` ADD `username` VARCHAR(20) NOT NULL ;

ALTER TABLE `wz_attachment` ADD `userkeys` VARCHAR(11) NOT NULL ;
ALTER TABLE `wz_attachment` ADD `isimage` TINYINT(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `wz_attachment` ADD `diycat` VARCHAR(20) NOT NULL ;

ALTER TABLE `wz_block_data` ADD `siteid` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `wz_block_data` ADD `isdiy` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `wz_category` ADD `siteid` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `cid`;
ALTER TABLE `wz_category` ADD `icon` VARCHAR(150) NOT NULL ;

CREATE TABLE IF NOT EXISTS `wz_content_stat` (
  `cid` mediumint(8) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `qkey` char(13) NOT NULL COMMENT '唯一值',
  `ip` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容模块访问统计';


ALTER TABLE `wz_copyfrom` CHANGE `logo` `logo` CHAR(250) NOT NULL;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`<36 AND `lid`>1;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`<308 AND `lid`>129;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`<342 AND `lid`>311;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`<362 AND `lid`>343;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`<486 AND `lid`>381;
UPDATE `wz_linkage_data` SET `child`=1 WHERE `lid`=3358;
UPDATE `wz_menu` SET `name` = '推荐位管理' WHERE `menuid` = 57;
UPDATE `wz_menu` SET `name` = '添加推荐位' WHERE `menuid` = 94;
UPDATE `wz_menu` SET `name` = '内容管理' WHERE `menuid` = 129;


INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(257, 256, '添加站点', 'core', 'site', 'add', '', 0, 1, 0),
(256, 2, '站点管理', 'core', 'site', 'listing', '', 7, 1, 0),
(268, 267, '添加广告', 'promote', 'index', 'add', '', 0, 1, 0),
(267, 260, '管理广告', 'promote', 'index', 'listing', '', 0, 2, 0),
(266, 260, '删除广告位', 'promote', 'index', 'deleteplace', '', 0, 0, 0),
(265, 260, '删除广告', 'promote', 'index', 'delete', '', 0, 0, 0),
(264, 260, '修改广告位', 'promote', 'index', 'editplace', '', 0, 0, 0),
(263, 260, '修改广告', 'promote', 'index', 'edit', '', 0, 0, 0),
(262, 260, '添加广告', 'promote', 'index', 'add', '', 0, 0, 0),
(261, 260, '添加广告位', 'promote', 'index', 'addplace', '', 0, 1, 0),
(260, 5, '广告管理', 'promote', 'index', 'listingplace', '', 254, 1, 0),
(269, 260, '批量发布广告', 'promote', 'index', 'batch', '', 0, 1, 0),
(270, 129, '添加自定义内容', 'content', 'block', 'add_content', '', 0, 1, 0),
(271, 26, '全部审核', 'content', 'content', 'allcheck', '', 0, 0, 0),
(279, 26, '移除相关内容', 'content', 'relation', 'remove_relation', '', 0, 0, 0),
(278, 26, '推送栏目列表显示', 'content', 'category', 'load_sitecate', '', 0, 0, 0),
(277, 92, '站点切换', 'core', 'site', 'changesite', '', 0, 0, 0),
(276, 26, '推送内容', 'content', 'content', 'push', '', 0, 0, 0),
(275, 26, '相关内容列表', 'content', 'relation', 'listing', '', 0, 0, 0),
(274, 26, '相关内容', 'content', 'relation', 'manage', '', 0, 0, 0),
(273, 57, '添加自定义内容', 'content', 'block', 'add_content', '', 0, 0, 0),
(272, 26, '页面审核', 'content', 'content', 'check', '', 0, 0, 0);



DROP TABLE IF EXISTS `wz_promote`;
CREATE TABLE IF NOT EXISTS `wz_promote` (
`id` int(10) unsigned NOT NULL,
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
  `updatetime` int(10) unsigned NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;


-- --------------------------------------------------------

--
-- 表的结构 `wz_promote_place`
--

DROP TABLE IF EXISTS `wz_promote_place`;
CREATE TABLE IF NOT EXISTS `wz_promote_place` (
`pid` smallint(5) NOT NULL,
  `keyid` varchar(20) NOT NULL,
  `siteid` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(80) NOT NULL,
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位' AUTO_INCREMENT=49 ;

ALTER TABLE `wz_promote` ADD PRIMARY KEY (`id`), ADD KEY `pid` (`pid`,`sort`), ADD KEY `keyid` (`keyid`,`sort`), ADD KEY `pid_2` (`pid`,`siteid`,`sort`);

--
-- Indexes for table `wz_promote_place`
--
ALTER TABLE `wz_promote_place` ADD PRIMARY KEY (`pid`);


DROP TABLE IF EXISTS `wz_site`;
CREATE TABLE IF NOT EXISTS `wz_site` (
  `siteid` smallint(5) unsigned NOT NULL,
  `name` varchar(80) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `wz_site` ADD PRIMARY KEY (`siteid`);

--
-- 转存表中的数据 `wz_site`
--

INSERT INTO `wz_site` (`siteid`, `name`, `logo`) VALUES
(1, '默认站点', '/res/images/userimg.jpg');

ALTER TABLE wz_attachment DROP INDEX usertimes;
ALTER TABLE wz_attachment DROP INDEX userid;
ALTER TABLE `wz_attachment` ADD KEY `usertimes` (`usertimes`) USING BTREE, ADD KEY `md5file` (`md5file`), ADD KEY `username` (`username`), ADD KEY `id` (`id`,`userkeys`);

ALTER TABLE `wz_block_data` ADD KEY `siteid` (`siteid`,`keyid`);
ALTER TABLE `wz_category` ADD KEY `siteid` (`keyid`,`siteid`);


ALTER TABLE `wz_promote` MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `wz_promote_place`
--
ALTER TABLE `wz_promote_place` MODIFY `pid` smallint(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

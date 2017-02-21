DROP TABLE IF EXISTS `wz_dianping`;
CREATE TABLE IF NOT EXISTS `wz_dianping` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `keyid` varchar(15) NOT NULL COMMENT '索引',
  `field1` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `field2` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `field3` tinyint(3) UNSIGNED NOT NULL DEFAULT '5',
  `field4` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `field5` varchar(255) NOT NULL,
  `field6` varchar(255) NOT NULL,
  `addtime` int(10) UNSIGNED NOT NULL COMMENT '评价时间',
  `ip` varchar(15) NOT NULL COMMENT 'ip地址',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属用户',
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='点评';


INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(228,5,'点评信息管理','dianping','index','listing','',228,1,0),
(229,228,'团购信息点评','dianping','index','taocan_listing','',229,1,0),
(230,228,'删除','dianping','index','delete','',230,0,0);
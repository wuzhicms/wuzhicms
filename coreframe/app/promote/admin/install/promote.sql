DROP TABLE IF EXISTS `wz_promote`;
CREATE TABLE IF NOT EXISTS `wz_promote` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) UNSIGNED NOT NULL,
  `siteid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `keyid` varchar(20) NOT NULL,
  `appid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `param1` varchar(100) NOT NULL,
  `param2` varchar(100) NOT NULL,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) NOT NULL,
  `keywords` varchar(80) NOT NULL,
  `url` varchar(200) NOT NULL,
  `file` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `template` varchar(30) NOT NULL,
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `addtime` int(10) UNSIGNED NOT NULL,
  `updatetime` int(10) UNSIGNED NOT NULL,
  `starttime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `endtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `stat_table` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`sort`),
  KEY `keyid` (`keyid`,`sort`),
  KEY `pid_2` (`pid`,`siteid`,`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wz_promote_place`;
CREATE TABLE IF NOT EXISTS `wz_promote_place` (
  `pid` smallint(5) NOT NULL AUTO_INCREMENT,
  `keyid` varchar(20) NOT NULL,
  `siteid` smallint(5) NOT NULL DEFAULT '1',
  `name` varchar(80) NOT NULL,
  `width` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `height` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `addtime` int(10) UNSIGNED NOT NULL,
  `updatetime` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='广告位';


INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(260,5,'广告管理','promote','index','listingplace','',254,1,0),
(261,260,'添加广告位','promote','index','addplace','',0,1,0),
(262,260,'添加广告','promote','index','add','',0,0,0),
(263,260,'修改广告','promote','index','edit','',0,0,0),
(264,260,'修改广告位','promote','index','editplace','',0,0,0),
(265,260,'删除广告','promote','index','delete','',0,0,0),
(266,260,'删除广告位','promote','index','deleteplace','',0,0,0),
(267,260,'管理广告','promote','index','listing','',0,2,0),
(268,267,'添加广告','promote','index','add','',0,1,0),
(269,260,'批量发布广告','promote','index','batch','',0,1,0);

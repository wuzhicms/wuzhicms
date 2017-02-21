DROP TABLE IF EXISTS `wz_link`;
CREATE TABLE IF NOT EXISTS `wz_link` (
  `linkid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kid` int(10) UNSIGNED NOT NULL COMMENT '所属类别',
  `sitename` varchar(60) NOT NULL COMMENT '站点名称',
  `remark` varchar(255) NOT NULL COMMENT '描述',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `logo` varchar(100) NOT NULL COMMENT 'logo',
  `username` varchar(20) NOT NULL COMMENT '添加人',
  `addtime` int(10) NOT NULL COMMENT '添加时间',
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`linkid`),
  KEY `kid` (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='友情链接';

INSERT INTO `wz_link` (`linkid`, `kid`, `sitename`, `remark`, `url`, `logo`, `username`, `addtime`, `sort`) VALUES
(1, 3, '五指互联网站管理系统', '', 'http://www.wuzhicms.com', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', 1431925825, 1),
(3, 1, '五指CMS论坛', '', 'http://bbs.wuzhicms.com', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', 1431925830, 2),
(5, 2, '短信通', '', 'http://sms.phpip.com/index.php?m=member', 'http://dev.wuzhicms.com/res/images/icon/wuzhilogo.gif', 'wuzhicms', 1431925841, 3);

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(34,5,'友情链接','link','index','listing','',5,1,0),
(104,34,'添加友情链接','link','index','add','',0,1,0),
(164,34,'修改','link','index','edit','',164,0,0),
(165,34,'删除','link','index','delete','',165,0,0),
(166,34,'排序','link','index','sort','',166,0,0);
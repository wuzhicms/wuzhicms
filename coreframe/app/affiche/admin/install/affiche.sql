DROP TABLE IF EXISTS `wz_affiche`;
CREATE TABLE IF NOT EXISTS `wz_affiche` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL COMMENT '标题',
  `css` varchar(30) NOT NULL,
  `publisher` varchar(20) NOT NULL COMMENT '发布人',
  `content` text NOT NULL COMMENT '公告内容',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `addtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `endtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1，会员中心，2 全站公告，3 后台公告',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='系统公告';

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(110,5,'系统公告','affiche','index','listing','',6,1,0),
(111,110,'添加公告','affiche','index','add','',0,1,0),
(167,110,'修改','affiche','index','edit','',167,0,0),
(168,110,'删除','affiche','index','delete','',168,0,0),
(169,110,'排序','affiche','index','sort','',169,0,0);
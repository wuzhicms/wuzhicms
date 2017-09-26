DROP TABLE IF EXISTS `wz_guestbook`;
CREATE TABLE IF NOT EXISTS `wz_guestbook` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '',
  `url` char(100) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `addtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `reply` mediumtext NOT NULL,
  `replytime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `linkman` char(20) NOT NULL DEFAULT '',
  `tel` char(20) NOT NULL DEFAULT '',
  `publisher` char(20) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `reply_user` varchar(10) NOT NULL COMMENT '回复人',
  `area` char(255) NOT NULL DEFAULT '',
  `category` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;


INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(114,5,'留言板','guestbook','index','listing','',7,1,0),
(170,114,'回复','guestbook','index','reply','',170,0,0),
(171,114,'删除','guestbook','index','delete','',171,0,0),
(115,114,'模型设置','core','model','model_listing','app=guestbook',0,1,0);

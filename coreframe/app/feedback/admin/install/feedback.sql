DROP TABLE IF EXISTS `wz_feedback`;
CREATE TABLE IF NOT EXISTS `wz_feedback` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` char(255) NOT NULL DEFAULT '',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '9未回复，8已回复',
  `addtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `reply` mediumtext NOT NULL,
  `replytime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `linkman` char(20) NOT NULL DEFAULT '',
  `tel` char(20) NOT NULL DEFAULT '',
  `email` char(20) NOT NULL DEFAULT '',
  `reply_user` varchar(10) NOT NULL COMMENT '回复人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(306,5,'问题反馈','feedback','index','listing','',306,1,0);
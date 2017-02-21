DROP TABLE IF EXISTS `wz_sms_checkcode`;
CREATE TABLE IF NOT EXISTS `wz_sms_checkcode` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `posttime` int(10) UNSIGNED NOT NULL,
  `code` char(8) NOT NULL,
  `ip` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信发送验证';

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(253,5,'手机短信','sms','index','init','',253,1,0);
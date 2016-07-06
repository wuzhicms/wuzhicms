# wuzhicms bakfile
# version:wuzhicms
# time:2016-05-26 09:45:46
# type:wuzhicms
# wuzhicms:http://www.wuzhicms.com
# --------------------------------------------------------


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
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `wz_admin` VALUES('1',',1,','wuzhicms','616d0fb11b63961a8e5f5a9315dd0b61','297b0a','zh-cn','','','','010-88888888','','');


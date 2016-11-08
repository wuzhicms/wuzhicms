DROP TABLE IF EXISTS `wz_feedback`;
CREATE TABLE `wz_feedback` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `reply_user` varchar(10) NOT NULL COMMENT '回复人'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `wz_feedback` ADD PRIMARY KEY (`id`);
ALTER TABLE `wz_feedback` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `wz_category` CHANGE `thumb` `thumb` VARCHAR(200) NOT NULL COMMENT '栏目图片';
ALTER TABLE `wz_category` CHANGE `icon` `icon` VARCHAR(200) NOT NULL;
ALTER TABLE `wz_copyfrom` CHANGE `logo` `logo` CHAR(200) NOT NULL;
ALTER TABLE `wz_copyfrom` CHANGE `url` `url` CHAR(200) NOT NULL;
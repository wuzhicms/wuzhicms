--当前主产品的版本安装信息
CREATE TABLE `wz_cloud_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `code` varchar(255) NOT NULL COMMENT '编码',
  `description` text NOT NULL COMMENT '描述',
  `icon` varchar(255) NOT NULL COMMENT '图标',
  `version` varchar(32) NOT NULL COMMENT '当前版本',
  `fromVersion` varchar(32) NOT NULL DEFAULT '0.0.0' COMMENT '更新前版本',
  `developerId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开发者用户ID',
  `developerName` varchar(255) NOT NULL DEFAULT '' COMMENT '开发者名称',
  `installedTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `updatedTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='已安装的应用';

--升级日志
CREATE TABLE `wz_cloud_app_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '应用编码',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '应用名称',
  `fromVersion` varchar(32) DEFAULT '' COMMENT '升级前版本',
  `toVersion` varchar(32) NOT NULL DEFAULT '' COMMENT '升级后版本',
  `type` enum('install','upgrade') NOT NULL DEFAULT 'install' COMMENT '升级类型',
  `dbBackupPath` varchar(255) NOT NULL DEFAULT '' COMMENT '数据库备份文件',
  `sourceBackupPath` varchar(255) NOT NULL DEFAULT '' COMMENT '源文件备份地址',
  `status` varchar(32) NOT NULL COMMENT '升级状态(ROLLBACK,ERROR,SUCCESS,RECOVERED)',
  `userId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '升级时的IP',
  `message` text COMMENT '失败原因',
  `createdTime` int(10) unsigned NOT NULL COMMENT '日志记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='应用升级日志';

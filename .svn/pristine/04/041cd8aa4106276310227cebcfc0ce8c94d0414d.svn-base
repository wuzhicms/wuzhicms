
-- CREATE TABLE `wz_global_config` (
-- 	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '设置项主键',
-- 	`m` VARCHAR(30) NULL DEFAULT NULL COMMENT '模块名',
-- 	`modelid` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '模块名',
-- 	`pid` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '父级主键',
-- 	`name` VARCHAR(100) NULL DEFAULT NULL COMMENT '名称',
-- 	`remark` VARCHAR(255) NULL DEFAULT NULL COMMENT '描述',
-- 	`sort` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '排序id',
-- 	`config_key` VARCHAR(50) NULL DEFAULT NULL COMMENT '配置项key',
-- 	`config_val` VARCHAR(50) NULL DEFAULT NULL COMMENT '配置项值',
-- 	PRIMARY KEY (`id`),
-- 	UNIQUE INDEX `uni_gc_config_key` (`m`, `config_key`)
-- )
-- COLLATE='gbk_chinese_ci'
-- ENGINE=MyISAM;




drop table if exists wz_search_config;
CREATE TABLE `wz_search_config` (
	`config_key` VARCHAR(50) NULL DEFAULT NULL COMMENT '配置项key',
	`config_val` VARCHAR(100) NULL DEFAULT NULL COMMENT '配置项值',
	PRIMARY KEY (`config_key`)
) COMMENT '搜索设置表'
COLLATE='gbk_chinese_ci'
ENGINE=MyISAM;


drop table if exists wz_search_category;
CREATE TABLE `wz_search_category` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '设置项主键',
	`m` VARCHAR(30) NULL DEFAULT NULL COMMENT '模块名',
	`modelid` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '模型ID',
	`name` VARCHAR(100) NULL DEFAULT NULL COMMENT '名称',
	`remark` VARCHAR(255) NULL DEFAULT NULL COMMENT '描述',
	`sort` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '排序id',
	PRIMARY KEY (`id`)
) COMMENT '搜索分类表'
COLLATE='gbk_chinese_ci'
ENGINE=MyISAM;

insert into wz_search_config (config_key,config_val)
values
('fulltextenble','0'),
('relationenble','0'),
('suggestenable','0'),
('sphinxenable','0'),
('sphinxhost','127.0.0.1'),
('sphinxport','801');





drop table if exists wz_search_index;
CREATE TABLE `wz_search_index` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '搜索索引主键',
	`m` VARCHAR(30) NULL DEFAULT NULL COMMENT '模块名',
	`modelid` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '模型ID',
	`data_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '搜索项标识ID',
	`data` VARCHAR(100) NULL DEFAULT NULL COMMENT '搜索内容',
	`data_key` VARCHAR(255) NULL DEFAULT NULL COMMENT '分词结果',
	`update_time` DATETIME NULL COMMENT '索引更新时间',
	PRIMARY KEY (`id`),
	FULLTEXT INDEX fidx_si (`data`)
) COMMENT '搜索索引表'
COLLATE='gbk_chinese_ci'
ENGINE=MyISAM;


drop table if exists wz_search_result;
CREATE TABLE `wz_search_result` (
	`id` INT(10) UNSIGNED NOT NULL COMMENT '搜索索引ID',
	`title` VARCHAR(30) NULL DEFAULT NULL COMMENT '搜索结果显示标题',
	`remark` VARCHAR(100) NULL DEFAULT NULL COMMENT '搜索结果显示简介',
	`content_url` VARCHAR(255) NULL DEFAULT NULL COMMENT '内容的URL',
	`img_url` VARCHAR(255) NULL DEFAULT NULL COMMENT '图片的URL',
	PRIMARY KEY (`id`)
) COMMENT '搜索结果表'
COLLATE='gbk_chinese_ci'
ENGINE=MyISAM;





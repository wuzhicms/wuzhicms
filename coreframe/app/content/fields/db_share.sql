-- 从表
CREATE TABLE `$att_tablename` (
  `id` int(10) unsigned default '0',
  `content` text NOT NULL,
  `coin` smallint(5) unsigned NOT NULL default '0',
  `groups` varchar(100) NOT NULL,
  `template` varchar(30) NOT NULL,
  `allowcomment` tinyint(1) unsigned NOT NULL default '1',
  `relation` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

ALTER TABLE `$att_tablename` ADD UNIQUE KEY `id` (`id`);

-- 开发手动创建共享模型表，核心模块，在安装的时候创建该数据，唯一需要做的是：需要将这些字段的配置信息添加到模型字段中。
-- INSERT INTO `$table_model_field` (`modelid`,
-- 执行完成后，通过update 将，modelid=0 的更新为当前字段的id
INSERT INTO `$table_model_field` (`modelid`, `field`, `name`, `remark`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `ext_code`, `unsetgids`, `unsetroles`, `master_field`, `ban_field`, `location`, `search_field`, `ban_contribute`, `to_fulltext`, `to_block`, `sort`, `disabled`, `powerful_field`) VALUES
  (0, 'addtime', '添加时间', '', '', 0, 0, '', '', 'datetime', 'a:2:{s:9:"fieldtype";s:3:"int";s:6:"format";s:11:"Y-m-d H:i:s";}', '', '', '', 1, 1, 1, 0, 0, 0, 1, 12, 0, 0),
  (0, 'block', '添加到区块', '', '', 0, 0, '', '', 'block', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 6, 0, 0),
  (0, 'groups', '用户组权限', '', '', 0, 0, '', '', 'group', 'a:1:{s:6:"groups";s:3:"4,5";}', '', '', '', 0, 0, 2, 0, 0, 0, 0, 18, 0, 0),
  (0, 'url', '链接地址', '', '', 0, 0, '', '', 'url', '', '', '', '', 1, 1, 1, 0, 0, 0, 1, 11, 0, 0),
  (0, 'sort', '权重', '', '', 0, 255, '', '', 'slider', 'a:1:{s:12:"defaultvalue";s:1:"0";}', '', '', '', 1, 1, 1, 0, 0, 0, 0, 20, 0, 0),
  (0, 'template', '内容页模板', '', '', 0, 0, '', '', 'template', '', '', '', '', 0, 0, 1, 0, 0, 0, 0, 21, 0, 0),
  (0, 'allowcomment', '允许评论', '', '', 0, 0, '', '', 'box', 'a:6:{s:7:"options";s:21:"允许|1\r\n不允许|0";s:7:"boxtype";s:5:"radio";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";s:12:"defaultvalue";s:1:"1";s:10:"outputtype";s:1:"0";}', '', '', '', 0, 0, 2, 0, 0, 0, 0, 17, 0, 0),
  (0, 'status', '稿件状态', '', '', 0, 0, '', '', 'box', 'a:6:{s:7:"options";s:50:"通过审核|9\r\n待审|1\r\n定时发送|8\r\n草稿|6";s:7:"boxtype";s:5:"radio";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";s:12:"defaultvalue";s:1:"9";s:10:"outputtype";s:1:"0";}', '', '', '', 1, 1, 0, 0, 0, 0, 0, 30, 0, 0),
  (0, 'thumb', '缩略图', '', '', 0, 0, '', '', 'image', 'a:6:{s:12:"defaultvalue";s:0:"";s:15:"upload_allowext";s:20:"gif|jpg|jpeg|png|bmp";s:9:"watermark";s:1:"0";s:13:"isselectimage";s:1:"1";s:12:"images_width";s:0:"";s:13:"images_height";s:0:"";}', '', '', '', 1, 1, 0, 0, 0, 0, 1, 5, 0, 0),
  (0, 'relation', '相关内容', '', '', 0, 0, '', '', 'relation', 'a:3:{s:8:"formtext";s:8:"相关内容";s:9:"fieldtype";s:7:"tinyint";s:9:"minnumber";s:1:"1";}', '', '', '', 0, 0, 1, 0, 0, 0, 0, 11, 0, 0),
  (0, 'remark', '摘要', '', '', 0, 0, '', '', 'textarea', 'a:2:{s:12:"defaultvalue";s:0:"";s:10:"enablehtml";s:1:"0";}', '', '', '', 1, 1, 0, 0, 0, 1, 1, 4, 0, 0),
  (0, 'content', '正文', '', '', 0, 0, '', '', 'editor', 'a:3:{s:12:"defaultvalue";s:0:"";s:15:"enablesaveimage";s:1:"1";s:16:"watermark_enable";s:1:"0";}', '', '', '', 0, 0, 5, 0, 0, 1, 0, 8, 0, 0),
  (0, 'cid', '所属栏目', '', '', 1, 0, '', '请选择栏目', 'cid', '', '', '', '', 1, 1, 5, 0, 0, 0, 0, 1, 0, 0),
  (0, 'title', '标题', '', '', 2, 80, '', '请输入标题', 'title', '', '', '', '', 1, 1, 5, 0, 0, 1, 1, 2, 0, 0),
  (0, 'keywords', '关键词', '多关键词之间用半角逗号“,”隔开', '', 0, 0, '', '', 'keyword', '', '', '', '', 1, 1, 0, 1, 0, 1, 0, 3, 0, 0);
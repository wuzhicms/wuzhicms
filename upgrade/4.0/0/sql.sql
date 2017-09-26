ALTER TABLE `wz_category` CHANGE `url` `url` VARCHAR(200) NOT NULL;
ALTER TABLE `wz_category` CHANGE `domain` `domain` VARCHAR(60) NOT NULL;
update `wz_block_data` SET `keyid`=CONCAT(`keyid`,'-zh') WHERE keyid!='';
update `wz_block_data` SET `keyid`=REPLACE(`keyid`,'-zh-zh','-zh');
update `wz_block_data` SET `keyid`=REPLACE(`keyid`,'--zh','-zh');
UPDATE `wz_setting` SET `data` = 'a:12:{s:5:"title";s:12:"标签首页";s:7:"keyword";s:27:"tags,标签,标签关键词";s:4:"desc";s:38:"tags标签功能,五指CMS标签功能";s:9:"show_mode";s:1:"1";s:7:"linkage";s:1:"2";s:14:"index_url_rule";s:5:"tags/";s:9:"index_tpl";s:0:"";s:15:"letter_url_rule";s:19:"tags/{$letter}.html";s:10:"letter_tpl";s:0:"";s:13:"show_url_rule";s:19:"tags/{$pinyin}.html";s:8:"show_tpl";s:0:"";s:7:"rewrite";s:1:"1";}' WHERE `id` = 11;
DELETE FROM `wz_menu` WHERE `menuid` = 98;
DELETE FROM `wz_menu` WHERE `m` = 'receipt';
DELETE FROM `wz_menu` WHERE `m` = 'dianping';
REPLACE INTO `wz_setting` (`keyid`, `m`, `f`, `v`, `title`, `data`, `updatetime`) VALUES
  ('install', 'core', '', '', '五指CMS核心', '0', '2017-02-24 03:32:05'),
  ('install', 'content', '', '', '内容模块', '0', '2017-02-23 19:32:05'),
  ('install', 'member', '', '', '会员模块', '0', '2017-02-23 19:32:05'),
  ('install', 'sms', '', '', '短信发送', '0', '2017-02-23 19:32:05'),
  ('install', 'template', '', '', '模版管理', '0', '2017-02-23 19:32:05'),
  ('install', 'mobile', '', '', '手机触屏', '0', '2017-02-23 19:32:05'),
  ('install', 'attachment', '', '', '附件管理', '0', '2017-02-23 19:32:05'),
  ('install', 'appupdate', '', '', '在线更新', '0', '2017-02-23 19:32:05'),
  ('install', 'affiche', '', '', '公告', '1', '2017-02-24 06:40:39'),
  ('install', 'credit', '', '', '积分模块', '1', '2017-02-24 06:55:31'),
  ('install', 'feedback', '', '', '问题反馈', '1', '2017-02-24 07:01:25'),
  ('install', 'guestbook', '', '', '留言板', '1', '2017-02-24 07:01:58'),
  ('install', 'link', '', '', '友情链接', '1', '2017-02-24 07:02:26'),
  ('install', 'linkage', '', '', '联动菜单模块', '0', '2017-02-24 03:32:05'),
  ('install', 'message', '', '', '站内消息', '1', '2017-02-24 07:05:38'),
  ('install', 'order', '', '', '订单模块', '1', '2017-02-24 07:06:30'),
  ('install', 'pay', '', '', '在线支付模块', '1', '2017-02-24 07:07:12'),
  ('install', 'promote', '', '', '广告管理模块', '1', '2017-02-24 07:11:00'),
  ('install', 'tags', '', '', 'tags管理', '0', '2017-02-23 19:32:05'),
  ('install', 'weixin', '', '', '微信公众号', '1', '2017-02-24 07:25:21'),
  ('install', 'database', '', '', '数据库备份', '1', '2017-02-24 07:33:04');
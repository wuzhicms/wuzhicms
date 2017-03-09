ALTER TABLE `wz_category` CHANGE `url` `url` VARCHAR(200) NOT NULL;
ALTER TABLE `wz_category` CHANGE `domain` `domain` VARCHAR(60) NOT NULL;
ALTER TABLE `wz_tag` CHANGE `linkage` `linkageid` SMALLINT(5) UNSIGNED NOT NULL COMMENT '类别';
update `wz_block_data` SET `keyid`=CONCAT(`keyid`,'-zh') WHERE keyid!='';
update `wz_block_data` SET `keyid`=REPLACE(`keyid`,'-zh-zh','-zh');
update `wz_block_data` SET `keyid`=REPLACE(`keyid`,'--zh','-zh');
UPDATE `wz_setting` SET `data` = 'a:12:{s:5:"title";s:12:"标签首页";s:7:"keyword";s:27:"tags,标签,标签关键词";s:4:"desc";s:38:"tags标签功能,五指CMS标签功能";s:9:"show_mode";s:1:"1";s:7:"linkage";s:1:"2";s:14:"index_url_rule";s:5:"tags/";s:9:"index_tpl";s:0:"";s:15:"letter_url_rule";s:19:"tags/{$letter}.html";s:10:"letter_tpl";s:0:"";s:13:"show_url_rule";s:19:"tags/{$pinyin}.html";s:8:"show_tpl";s:0:"";s:7:"rewrite";s:1:"1";}' WHERE `id` = 11;
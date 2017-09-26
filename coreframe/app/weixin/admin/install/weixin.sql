/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(244,5,'微信公众号','weixin','set','setting','',244,1,0),
(245,244,'关注自动回复设置','weixin','set','subscribe','',245,1,0),
(247,244,'自定义菜单','weixin','set','menu_setting','',247,1,0),
(252,244,'手机推广页配置','weixin','set','fullpage','',252,1,0);
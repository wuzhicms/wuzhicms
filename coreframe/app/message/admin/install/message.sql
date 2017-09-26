/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(231,5,'站内短信','message','index','listing','',231,1,0),
(232,231,'发布站内短信','message','index','add','',232,1,0);
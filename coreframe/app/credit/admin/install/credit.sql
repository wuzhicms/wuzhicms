/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(226,5,'积分管理','credit','index','listing','',226,1,0),
(237,226,'积分配置','credit','index','set','',237,1,0),
(239,226,'积分入账','credit','index','add','',239,1,0);
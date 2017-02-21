/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(217,5,'发票申请管理','receipt','receipt','listing','',217,1,0),
(218,217,'审核','receipt','receipt','check','',218,0,0);
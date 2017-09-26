/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(36,5,'在线支付','pay','index','listing','',3,1,0),
(107,36,'充值入账','pay','index','add','',0,1,0),
(108,36,'支付配置','pay','pay_config','listing','',0,1,0),
(153,36,'修改交易备注','pay','index','edit_note','',153,0,0),
(154,36,'查看交易详情','pay','index','view','',154,0,0),
(155,36,'删除支付记录','pay','index','delete','',155,0,0),
(156,36,'配置修改','pay','pay_config','edit','',156,0,0),
(157,36,'改价','pay','index','edit','',157,0,0);
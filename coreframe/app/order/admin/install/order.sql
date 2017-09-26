/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(220,5,'订单管理','order','index','listing','',220,1,0),
(221,220,'积分兑换商品订单','order','goods','listing','',221,1,0),
(222,220,'物流公司','order','express','listing','',222,1,0),
(223,220,'添加物流公司','order','express','add','',223,1,0),
(224,220,'修改物流','order','express','edit','',224,0,0),
(225,220,'删除物流','order','express','delete','',225,0,0);
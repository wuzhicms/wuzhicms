/*手动添加建立的表的sql语句，和下边在菜单表中相关的数据*/

INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(215,5,'优惠券管理','coupon','card','listing','',215,1,0),
(216,215,'生成优惠券','coupon','card','add','',216,1,0),
(300,215,'邮件模板配置','coupon','card','email_setting','',244,1,0);
INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES
(35, 5, '数据库备份', 'database', 'index', 'export', '', 4, 1, 0),
(70, 35, '数据库导入', 'database', 'index', 'import', '', 0, 1, 0),
(203, 35, '数据库导出', 'database', 'index', 'export_database', '', 203, 0, 0),
(204, 35, '数据库修复', 'database', 'index', 'public_repair', '', 204, 0, 0);
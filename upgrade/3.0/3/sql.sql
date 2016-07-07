DROP TABLE IF EXISTS `wz_key_verify`;
CREATE TABLE `wz_key_verify` ( `keyid` char(32) NOT NULL, `addtime` int(10) NOT NULL );
ALTER TABLE `wz_key_verify` ADD UNIQUE KEY `keyid` (`keyid`,`addtime`);
<?php
defined('WWW_ROOT') or exit('No direct script access allowed');

define('COREFRAME_ROOT','/workspace/wwwroot/wuzhicms_v2/src/coreframe/');//定义核心框架的路径
define('CACHE_ROOT','/workspace/wwwroot/wuzhicms_v2/src/caches/');//缓存文件目录
define('CACHE_EXT','H_1_a');

//勿忘－网站上线后，需要修改下面 3项
define('OPEN_DEBUG',0);//开启调试模式？1 开启后，将会显示页面的变量，遇到错误终止、0 关闭-网站上线后，需要关闭该项
define('AUTO_CACHE_TPL',1);//是否自动缓存模版，网站上线后，必须关闭该项
define('ERROR_REPORT',0);//错误信息现实级别：1 ，显示高级别错误，0 关闭错误提醒（上线后，使用该项） 2 显示所有错误（开发模式）

define('WWW_PATH','/');//网站安装路径，二级目录形式为：/mydemo/
define('WEBURL','http://dev.wuzhicms.com/');//网站域名

//Cookie配置
define('COOKIE_DOMAIN','');//Cookie 作用域
define('COOKIE_PATH','');//Cookie 作用路径
define('COOKIE_PRE','LRy_'); //Cookie 前缀
define('COOKIE_TTL',0); //Cookie 生命周期，0 表示随浏览器进程

//附件相关配置
define('ATTACHMENT_ROOT',WWW_ROOT.'uploadfile/');
define('ATTACHMENT_URL','http://dev.wuzhicms.com/uploadfile/');//附件路径
define('R','http://dev.wuzhicms.com/res/');//静态文件存储目录
define('_KEY','XZZJr3FS'); //密钥,最长8位
define('LANG','zh-cn');  //网站默认语言包

define('FOUNDERS','1'); //网站创始人ID，多个ID逗号分隔
define('TIME_ZONE','Etc/GMT-8');
define('CHARSET','utf-8');
define('POSTFIX','.html');//.html/.htm/.shtml
define('CLOSE',0);//关闭网站前台所有动态PHP功能，包括API
define('_SU','wuzhicms');
//开启移动页面自动识别
define('SUPPORT_MOBILE',1);//0，不支持移动页面，1，自动识别，动态，伪静态下可用，静态页面通过js判断跳转到动态地址完成识别

//默认模版配置
define('TPLID','t2');



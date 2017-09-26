<?php

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

function filesize_format($bytes, $decimals = 2)
{
	$sz = array('B','K','M','G','T','P');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).$sz[$factor];
}

function fileext($file)
{
	return pathinfo($file,PATHINFO_EXTENSION);
}

function strpos_array($haystack, $needles) 
{
    if ( is_array($needles) ) 
	{
        foreach ($needles as $str) 
		{
            if ( is_array($str) ) {
                $pos = strpos_array($haystack, $str);
            } else {
                $pos = strpos($haystack, $str);
            }
            if ($pos !== FALSE) {
                return $pos;
            }
        }
    }
	else 
	{
        return strpos($haystack, $needles);
    }
	return false;
}

	//创建目录，格式：/dirname/2014/07/07/
	function createdir($dirname = '') {
		$dirname = empty($dirname) ? '' : $dirname.'/';
		$target_dir = $dirname.date('Y/m/d').'/';
		if (!file_exists(ATTACHMENT_ROOT.$target_dir)) {
			//die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
			if(!mkdir(ATTACHMENT_ROOT.$target_dir,0777,1)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "创建目录失败:'.ATTACHMENT_ROOT.$target_dir.' "}, "id" : "id"}');
			}
		}
		return $target_dir;
	}

		//生成文件名
	function filename($name) 
	{
		$_exts =  array('php','asp','jsp','jspx','html','htm','aspx','asa','cs','cgi','js','dhtml','xhtml','vb','exe','shell','bat','php4','php4','php5','pthml','cdx','cer');
		$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
		if(in_array($ext, $_exts)) {
			return FALSE;
		}
		$rand_str = random_string('diy', 6,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		$files = date('YmdHis').$rand_str.'.'.$ext;
		return $files;
	}

/**
 * 上传的url访问安全认证
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function upload_url_safe()
{
	//TODO 删除下面注释
	//if(empty($_SERVER['HTTP_REFERER'])) MSG( L('operation_failure'), '', 3000);//上传弹窗必然由上级页面加载
}

/**
 * 上传的文件扩展名安全认证,黑白名单机制
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function upload_ext_safe()
{
	
}

?>
<?php

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

defined('IN_WZ') or exit('No direct script access allowed');
ini_set('display_errors','On'); error_reporting(E_ALL);
//ueditor编辑器相关配置处理
class WUZHI_ueditor{
	private static $CONFIG;
	public function __construct()
	{
		self::$CONFIG = self::config();
	}

/**
 * ue配置项目
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public static function config()
	{
		$config = array (
		'imageActionName' => 'uploadimage',
		'imageFieldName' => 'upfile',
		'imageMaxSize' => 2048000,
		'imageAllowFiles' => array ( 0 => '.png', 1 => '.jpg', 2 => '.jpeg', 3 => '.gif', 4 => '.bmp', ),
		'imageCompressEnable' => true,
		'imageCompressBorder' => 1600,
		'imageInsertAlign' => 'none',
		'imageUrlPrefix' => '',
		'imagePathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'scrawlActionName' => 'uploadscrawl',
		'scrawlFieldName' => 'upfile',
		'scrawlPathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'scrawlMaxSize' => 2048000,
		'scrawlUrlPrefix' => '',
		'scrawlInsertAlign' => 'none',
		'snapscreenActionName' => 'uploadimage',
		'snapscreenPathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'snapscreenUrlPrefix' => '',
		'snapscreenInsertAlign' => 'none',
		
		'catchRemoteImageEnable'=>true,
		'catcherLocalDomain' => array ( 0 => '127.0.0.1', 1 => 'localhost', 2 => 'img.baidu.com', ),
		'catcherActionName' => 'catchimage',
		'catcherFieldName' => 'source',
		'catcherPathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'catcherUrlPrefix' => '',
		'catcherMaxSize' => 2048000,
		'catcherAllowFiles' => array ( 0 => '.png', 1 => '.jpg', 2 => '.jpeg', 3 => '.gif', 4 => '.bmp', ),
		'videoActionName' => 'uploadvideo',
		'videoFieldName' => 'upfile',
		'videoPathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'videoUrlPrefix' => '',
		'videoMaxSize' => 102400000,
		'videoAllowFiles' => array ( 0 => '.flv', 1 => '.swf', 2 => '.mkv', 3 => '.avi', 4 => '.rm', 5 => '.rmvb', 6 => '.mpeg', 7 => '.mpg', 8 => '.ogg', 9 => '.ogv', 10 => '.mov', 11 => '.wmv', 12 => '.mp4', 13 => '.webm', 14 => '.mp3', 15 => '.wav', 16 => '.mid', ),
		'fileActionName' => 'uploadfile',
		'fileFieldName' => 'upfile',
		'filePathFormat' => '{yyyy}/{mm}/{dd}/{yyyy}{mm}{dd}{hh}{ii}{ss}{rand:4}',
		'fileUrlPrefix' => '',
		'fileMaxSize' => 51200000,
		'fileAllowFiles' => array ( 0 => '.png', 1 => '.jpg', 2 => '.jpeg', 3 => '.gif', 4 => '.bmp', 5 => '.flv', 6 => '.swf', 7 => '.mkv', 8 => '.avi', 9 => '.rm', 10 => '.rmvb', 11 => '.mpeg', 12 => '.mpg', 13 => '.ogg', 14 => '.ogv', 15 => '.mov', 16 => '.wmv', 17 => '.mp4', 18 => '.webm', 19 => '.mp3', 20 => '.wav', 21 => '.mid', 22 => '.rar', 23 => '.zip', 24 => '.tar', 25 => '.gz', 26 => '.7z', 27 => '.bz2', 28 => '.cab', 29 => '.iso', 30 => '.doc', 31 => '.docx', 32 => '.xls', 33 => '.xlsx', 34 => '.ppt', 35 => '.pptx', 36 => '.pdf', 37 => '.txt', 38 => '.md', 39 => '.xml', ),
		'imageManagerActionName' => 'listimage',
		'imageManagerListPath' => '/ueditor/php/upload/image/',
		'imageManagerListSize' => 20,
		'imageManagerUrlPrefix' => '',
		'imageManagerInsertAlign' => 'none',
		'imageManagerAllowFiles' => array ( 0 => '.png', 1 => '.jpg', 2 => '.jpeg', 3 => '.gif', 4 => '.bmp', ),
		'fileManagerActionName' => 'listfile',
		'fileManagerListPath' => '/ueditor/php/upload/file/',
		'fileManagerUrlPrefix' => '',
		'fileManagerListSize' => 20,
		'fileManagerAllowFiles' => array ( 0 => '.png', 1 => '.jpg', 2 => '.jpeg', 3 => '.gif', 4 => '.bmp', 5 => '.flv', 6 => '.swf', 7 => '.mkv', 8 => '.avi', 9 => '.rm', 10 => '.rmvb', 11 => '.mpeg', 12 => '.mpg', 13 => '.ogg', 14 => '.ogv', 15 => '.mov', 16 => '.wmv', 17 => '.mp4', 18 => '.webm', 19 => '.mp3', 20 => '.wav', 21 => '.mid', 22 => '.rar', 23 => '.zip', 24 => '.tar', 25 => '.gz', 26 => '.7z', 27 => '.bz2', 28 => '.cab', 29 => '.iso', 30 => '.doc', 31 => '.docx', 32 => '.xls', 33 => '.xlsx', 34 => '.ppt', 35 => '.pptx', 36 => '.pdf', 37 => '.txt', 38 => '.md', 39 => '.xml', ), );
		$ueditor_cache = get_cache('ueditor');
		if(!empty($ueditor_cache))
		{
			$config = array_merge($config,$ueditor_cache);
		}
		$config['catchRemoteImageEnable'] = (bool)$config['catchRemoteImageEnable'];
		return $config;
	}

/**
 * 上传方法
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public static function upload($action)
	{
		$CONFIG = self::$CONFIG;
		$base64 = "upload";		/* 上传配置 */
		switch (htmlspecialchars($action)) {
			case 'uploadimage':
				$config = array(
					"pathFormat" => $CONFIG['imagePathFormat'],
					"maxSize" => $CONFIG['imageMaxSize'],
					"allowFiles" => $CONFIG['imageAllowFiles']
				);
				$fieldName = $CONFIG['imageFieldName'];
				break;
			case 'uploadscrawl':
				$config = array(
					"pathFormat" => $CONFIG['scrawlPathFormat'],
					"maxSize" => $CONFIG['scrawlMaxSize'],
					"allowFiles" => $CONFIG['scrawlAllowFiles'],
					"oriName" => "scrawl.png"
				);
				$fieldName = $CONFIG['scrawlFieldName'];
				$base64 = "base64";
				break;
			case 'uploadvideo':
				$config = array(
					"pathFormat" => $CONFIG['videoPathFormat'],
					"maxSize" => $CONFIG['videoMaxSize'],
					"allowFiles" => $CONFIG['videoAllowFiles']
				);
				$fieldName = $CONFIG['videoFieldName'];
				break;
			case 'uploadfile':
			default:
				$config = array(
					"pathFormat" => $CONFIG['filePathFormat'],
					"maxSize" => $CONFIG['fileMaxSize'],
					"allowFiles" => $CONFIG['fileAllowFiles']
				);
				$fieldName = $CONFIG['fileFieldName'];
				break;
		}

		/* 生成上传实例对象并完成上传 */
		$up = load_class('Uploader', M);
		$up->set($fieldName, $config, $base64);

		/**
		 * 得到上传文件所对应的各个参数,数组结构
		 * array(
		 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
		 *     "url" => "",            //返回的地址
		 *     "title" => "",          //新文件名
		 *     "original" => "",       //原始文件名
		 *     "type" => ""            //文件类型
		 *     "size" => "",           //文件大小
		 * )
		 */

		/* 返回数据 */
		return $up->getFileInfo();
	}

/**
 * 附件列表方法
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public static function lists()
	{
		$db = load_class('db');
		$pagesize = isset($GLOBALS['size']) ? intval($GLOBALS['size']) : 20;
		$page = $GLOBALS['start']  ? intval($GLOBALS['start']) : 1;
		if($page > 1) $page = ceil($page/$pagesize);
		$q = isset($GLOBALS['q']) ? iconv('utf-8','gbk',remove_xss($GLOBALS['q'])) : '';
		$where = $q ? ' (name like "%'.$q.'%" or tags like "%'.$q.'%" )' : ' 1 ';
		$lists = $db->get_list('attachment',$where,'path,addtime,name', 0, $pagesize, $page, 'id DESC');
		$return_list = $files = array();
		foreach($lists AS $k=>$v)
		{
			$file_name =  pathinfo($v['name'], PATHINFO_FILENAME);
			$files[] = array(
			'url'=> ATTACHMENT_URL.$v['path'],
			'mtime'=> $v['addtime'],
			'title'=> $file_name,
			);
			$return_list = $files;
		}

		unset($lists,$files);
		$result = array(
		"state" => "SUCCESS",
		"list" => $return_list,
		"start" => $page,
		"total" => $db->number,
		);
		return $result;
	}

    /**
     *
     * 搜索图片
     * @return array
     */
    public static function searchimg()
    {
        $seatchtype = intval($GLOBALS['s']);
        //1 文件名搜索，2文件夹搜索
        $callback = $GLOBALS['callback'];
        if(!$callback) return '';
        $db = load_class('db');
        $pagesize = isset($GLOBALS['size']) ? intval($GLOBALS['size']) : 20;
        $page = $GLOBALS['start']  ? intval($GLOBALS['start']) : 1;
        if($page > 1) $page = ceil($page/$pagesize);
        $q = sql_replace(iconv('gbk','utf-8',$GLOBALS['word']));
        $where = '';
        if($seatchtype==1) {
            $where = "`name` like '%$q%' AND `isimage`=1";
        } elseif($seatchtype==2) {
            $where = "`diycat` like '%$q%' AND `isimage`=1";
        }

        $lists = $db->get_list('attachment',$where,'path,addtime,name', 0, $pagesize, $page, 'id DESC');
        $return_list = $files = array();
        foreach($lists AS $k=>$v)
        {
            $file_name =  pathinfo($v['name'], PATHINFO_FILENAME);
            $files[] = array(
                'url'=> ATTACHMENT_URL.$v['path'],
                'mtime'=> $v['addtime'],
                'title'=> $file_name,
            );
            $return_list = $files;
        }
        $total = $db->number;
        unset($lists,$files);
        $result = array(
            "listNum"=> 1996,
            "data"=>$return_list
        );
        return $result;
    }
/**
 * 抓取远程图片
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public static function saveRemote()
	{
		$CONFIG = self::$CONFIG;
		$config = array(
		"pathFormat" => $CONFIG['catcherPathFormat'],
		"maxSize" => $CONFIG['catcherMaxSize'],
		"allowFiles" => $CONFIG['catcherAllowFiles'],
		"oriName" => "remote.png"
		);
		$fieldName = $CONFIG['catcherFieldName'];

		//不采用ajax抓取远程图片
		if(!$CONFIG['catchRemoteImageEnable'])
		{
			return array('state'=> 'ERROR','list'=>array());
		}

		$up = load_class('Uploader', M);
		if (isset($GLOBALS[$fieldName])) 
		{
			$source = $GLOBALS[$fieldName];
		}
		$list = array();
		foreach($source AS $k=>$imgUrl)
		{
			$up->set($imgUrl, $config, 'remote');
			$info = $up->getFileInfo();
				array_push($list, array(
				"state" => $info["state"],
				"url" => $info["url"],
				"size" => $info["size"],
				"title" => htmlspecialchars($info["title"]),
				"original" => htmlspecialchars($info["original"]),
				"source" => htmlspecialchars($imgUrl),
				));
		}
		return array(
		'state'=> count($list) ? 'SUCCESS':'ERROR',
		'list'=> $list
		);
	}

}

?>
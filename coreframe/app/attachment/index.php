<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');


load_function('common','attachment');
/**
 * 附件上传
 */
class index {

    public $extImages = array('gif','bmp','jpg','jpeg','png');
    public $extCompression = array('zip','7z','rar','gz','tar');
    public $extFile = array('doc','docx','xls','xlsx','ppt','pptx','pdf');
    public $video = array('mp4','mp3');
    function __construct()
    {
        $this->db = load_class('db');
        $this->userkeys = get_cookie('userkeys');
        if(empty($this->userkeys)) {
            $this->userkeys = substr(md5(uniqid()),5,8);
            set_cookie('userkeys',$this->userkeys);
        }
    }


    //html5 上传
    public function h5upload() {

        //token 验证
        $ext = $GLOBALS['ext'];
		$token = $GLOBALS['token'];
		if($ext=='' || md5($ext._KEY)!=$token) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "token验证失败，不允许上传文件"}, "id" : "id"}');
		}
		//用户中心用户
        $_username = get_cookie('_username');
        //后台用户
        $wz_name = get_cookie('username');
        if($wz_name!='') {
            $_username = $wz_name;
        }
        //判断用户是否登录
/*        if($_username!='') {
            $mr = $this->db->get_one('member', array('username' => $_username),'uid');
            if(!$mr) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
            }
        } else {
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
        }*/
        // 获取上传文件名称
        if (isset($GLOBALS["name"])) {
            //$fileName = str_replace(",","_",$_FILES["file"]["name"]);
            $fileName = $GLOBALS['name'];
        } elseif (!empty($_FILES)) {
            $fileName = str_replace(",","_",$_FILES["file"]["name"]);
        } else {
            $fileName = uniqid("file_");
        }
        $originalName = iconv('utf-8',CHARSET,$fileName);
        //不允许上传的文件扩展
        $ext = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
        $_exts = array_merge($this->video,$this->extFile,$this->extCompression,$this->extImages);
        if(!empty($ext)){
            if(!in_array($ext, $_exts)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "Ban file name."}, "id" : "id"}');
            }
        }
        //创建新文件目录  格式：/dirname/2014/07/07/
        $fileurl = createdir();
        $targetDir = ATTACHMENT_ROOT.$fileurl;
        $targetFileName = md5($fileName) .uniqid() . '.' . $ext;
        //目标文件位置
        $targetFilePath = $targetDir .'/'. $targetFileName;
        // Chunking might be enabled
        $chunk = isset($GLOBALS["chunk"]) ? intval($GLOBALS["chunk"]) : 0;
        $chunks = isset($GLOBALS["chunks"]) ? intval($GLOBALS["chunks"]) : 0;

        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // 5 minutes execution time
        @set_time_limit(5 * 60);
        // Open temp file
        if (!empty($_FILES)) {
            $stream_input = false;
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            $stream_input = true;
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        if (!$out = @fopen("{$targetFilePath}.part", ($chunk == 0) ? "wb" : "ab")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }
        while ($buff = fread($in, 1024)) {
           fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);
        @unlink($_FILES["file"]["tmp_name"]);


        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$targetFilePath}.part", $targetFilePath);
        }

        //md5验证图片是否重复上传
        $md5file = md5_file($targetFilePath);
        if($r = $this->db->get_one('attachment', array('md5file' => $md5file))) {
            unlink($targetFilePath);
            $id = $r['id'];
            die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.$r['path'].'", "id" : "'.$id.'", "filename" : "'.$r['name'].'" }');
        }

        //缩略图不加水印
        if(isset($GLOBALS['is_thumb']) && $GLOBALS['is_thumb']) {
            $this->water_mark = false;
        } else {
            $this->water_mark = $this->setting['watermark_enable'];
        }
        //添加水印
        if($this->water_mark == true && in_array($ext,array('jpg','png','gif'))) {
            $this->image = load_class('image');
            $this->image->set_image($targetFilePath);
            $this->image->createImageFromFile();
            if($this->setting['watermark_enable']==2) {//文字水印
                $this->image->water_mark(WWW_ROOT.'res/images/watermark.png',$this->setting['watermark_pos']);
            } else {//图片水印
                $this->image->water_mark(WWW_ROOT.'res/images/watermark.png',$this->setting['watermark_pos']);
            }
            $this->image->save();
        }
        //附件url地址
        $attachmentUrl = ATTACHMENT_URL.$fileurl.$targetFileName;

        
        //信息添加到数据库
        $attachment = load_class('attachment',M);
        $insert = array();
        $insert['name'] = $originalName;
        $insert['username'] = $_username;
        $insert['path'] = $attachmentUrl;
        $insert['addtime'] = SYS_TIME;
        $insert['filesize'] = filesize($targetFilePath);
        $insert['ip'] = get_ip();
        $insert['md5file'] = $md5file;
        $id = $attachment->insert($insert);

        // Return Success JSON-RPC response
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.$attachmentUrl.'", "id" : "'.$id.'", "filename" : "'.$fileName.'" }');


    }
    //上传弹窗调用
    public function upload_dialog()
    {
		$uid = get_cookie('uid');
		if(is_numeric($uid)) {
			$is_admin = 1;
		} else {
			$is_admin = 0;
		}
        upload_url_safe();
        $callback = isset($GLOBALS['callback']) ? remove_xss($GLOBALS['callback']) : 'callback_thumb_dialog';
        $htmlid = isset($GLOBALS['htmlid']) ? remove_xss($GLOBALS['htmlid']) : 'file';
        $limit = isset($GLOBALS['limit']) ? intval($GLOBALS['limit']) : 1;
        $is_thumb = isset($GLOBALS['is_thumb']) ? intval($GLOBALS['is_thumb']) : 0;
        $htmlname= isset($GLOBALS['htmlname']) ? remove_xss($GLOBALS['htmlname']) : '';
        $cut = isset($GLOBALS['cut']) ? intval($GLOBALS['cut']) : 0;
        $width = isset($GLOBALS['width']) ? intval($GLOBALS['width']) :  0;
        $height = isset($GLOBALS['height']) ? intval($GLOBALS['height']) : 0;
        $ext = remove_xss($GLOBALS['ext']);
        $token = remove_xss($GLOBALS['token']);
        if($ext=='' || md5($ext._KEY)!=$token) {
            MSG('参数错误！');
        }
        $maxsize = ini_get('upload_max_filesize');
        $exts = explode('|',$ext);
        $extImages = upload_ext_safe($this->extImages,$exts);
        $extCompression = upload_ext_safe($this->extCompression,$exts);
        $extFile = upload_ext_safe($this->extFile,$exts);
        $extVideo = upload_ext_safe($this->video,$exts);
        include T('attachment','upload_dialog');
    }
    //删除附件，仅允许删除 $this->userkeys 的值。即当前cookie下有效
    public function remove_file() {
        $id = intval($GLOBALS['file_id']);
        $r = $this->db->get_one('attachment', array('id' => $id,'userkeys'=>$this->userkeys));
        if($r) {
            $this->db->delete('attachment', array('id' => $id,'userkeys'=>$this->userkeys));
            unlink(ATTACHMENT_ROOT.$r['path']);
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>100));
        }
    }
    //ckeditor 上传
    public function ckeditor() {
        $action = remove_xss($GLOBALS['action']);
        $ckditor = load_class('ckditor',M);
        switch($action)
        {
            case 'config':
                $config = $ckditor->config();
                $result = $config;
                break;

            case 'uploadimage':/* 上传图片 */
            case 'uploadscrawl':/* 上传涂鸦 */
            case 'uploadvideo':/* 上传视频 */
            case 'uploadfile':/* 上传文件 */
                $result = $ckditor->upload($action);
                break;


            case 'listimage':/* 列出图片 */
            case 'listfile':/* 列出文件 */
                $page = $GLOBALS['page']  ? intval($GLOBALS['page']) : 1;
                $keytype = isset($GLOBALS['keytype']) ? intval($GLOBALS['keytype']) : 0;
                $keywords = isset($GLOBALS['keywords']) ? iconv('utf-8','gbk',remove_xss($GLOBALS['keywords'])) : '';
                $username = input('username');
                $username = sql_replace($username);
                $result = $ckditor->lists($page,$keytype,$keywords,$username);
                if(isset($GLOBALS['returnjson'])) {
                    echo json_encode($result);
                } else {
                    $CKEditorFuncNum = intval($GLOBALS['CKEditorFuncNum']);
                    load_class('form');
                    $CKEditor = $GLOBALS['CKEditor'];
					$GLOBALS['start'] = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
					$GLOBALS['end'] = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';
                    include T('attachment','listimage');
                }
                exit;
                break;
            case 'searchimg':/* 搜索图片 */
                $result = $ckditor->searchimg();
                break;
            case 'catchimage':/* 抓取远程文件 */
                $result = $ckditor->saveRemote();
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }
        echo $result;
    }

    function file_brower() {
		$uid = get_cookie('uid');
		if(!is_numeric($uid)) {
			MSG('你似乎走错地方了！这是后台权限！');
		}
		$action = remove_xss($GLOBALS['action']);
		$ckditor = load_class('ckditor',M);
		switch($action)
		{
			case 'listimage':/* 列出图片 */
				$page = $GLOBALS['page']  ? intval($GLOBALS['page']) : 1;
				$keytype = isset($GLOBALS['keytype']) ? intval($GLOBALS['keytype']) : 0;
				$keywords = isset($GLOBALS['keywords']) ? iconv('utf-8','gbk',remove_xss($GLOBALS['keywords'])) : '';
				$username = input('username');
				$username = sql_replace($username);
				$result = $ckditor->lists($page,$keytype,$keywords,$username);
				if(isset($GLOBALS['returnjson'])) {
					echo json_encode($result);
				} else {
					$CKEditorFuncNum = intval($GLOBALS['CKEditorFuncNum']);
					load_class('form');
					$CKEditor = $GLOBALS['CKEditor'];
					$GLOBALS['start'] = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
					$GLOBALS['end'] = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';
					include T('attachment','file_brower');
				}
				exit;
				break;
			case 'weburl':/* 远程图片 */
				$page = $GLOBALS['page']  ? intval($GLOBALS['page']) : 1;
				$keytype = isset($GLOBALS['keytype']) ? intval($GLOBALS['keytype']) : 0;
				$keywords = isset($GLOBALS['keywords']) ? iconv('utf-8','gbk',remove_xss($GLOBALS['keywords'])) : '';
				$username = input('username');
				$username = sql_replace($username);
				$result = $ckditor->lists($page,$keytype,$keywords,$username);
				if(isset($GLOBALS['returnjson'])) {
					echo json_encode($result);
				} else {
					$CKEditorFuncNum = intval($GLOBALS['CKEditorFuncNum']);
					load_class('form');
					$CKEditor = $GLOBALS['CKEditor'];
					$GLOBALS['start'] = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
					$GLOBALS['end'] = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';
					include T('attachment','file_brower_weburl');
				}
				exit;
				break;
		}
	}
}
?>
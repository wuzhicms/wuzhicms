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
    function __construct()
    {
        $this->db = load_class('db');
        $this->userkeys = get_cookie('userkeys');
        if(empty($this->userkeys)) {
            $this->userkeys = substr(md5(uniqid()),5,8);
            set_cookie('userkeys',$this->userkeys);
        }
    }

    //ueditor百度编辑器 上传
    public function upload()
    {
        $action = remove_xss($GLOBALS['action']);
        $ueditor = load_class('ueditor',M);
        switch($action)
        {
            case 'config':
                $config = $ueditor->config();
                $result = $config;
                break;

            case 'uploadimage':/* 上传图片 */
            case 'uploadscrawl':/* 上传涂鸦 */
            case 'uploadvideo':/* 上传视频 */
            case 'uploadfile':/* 上传文件 */
                $result = $ueditor->upload($action);
                break;


            case 'listimage':/* 列出图片 */
            case 'listfile':/* 列出文件 */
                $result = $ueditor->lists();
                break;
            case 'searchimg':/* 搜索图片 */
                $result = $ueditor->searchimg();
                break;
            case 'catchimage':/* 抓取远程文件 */
                $result = $ueditor->saveRemote();
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }
        $callback = strip_tags($GLOBALS['callback']);
        if($callback) {
            exit($callback.'('.json_encode($result).')');
        } else {
            exit( json_encode($result) );
        }

    }
    //html5 上传
    public function h5upload() {

        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $fileurl = createdir();
        $target_dir = ATTACHMENT_ROOT.$fileurl;

        // Get a file name
        if (isset($GLOBALS["name"])) {
            $fileName = $GLOBALS["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $insert = array();
        $insert['name'] = iconv('utf-8',CHARSET,$fileName);

        $fileName = filename($fileName);
        //不允许上传的文件扩展
        if($fileName==FALSE) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "Ban file name."}, "id" : "id"}');
        }
        $filePath = $target_dir .'/'. $fileName;

        // Chunking might be enabled
        $chunk = isset($GLOBALS["chunk"]) ? intval($GLOBALS["chunk"]) : 0;
        $chunks = isset($GLOBALS["chunks"]) ? intval($GLOBALS["chunks"]) : 0;


        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

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

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
        

        $insert['path'] = $fileurl.$fileName;
        $insert['addtime'] = SYS_TIME;
        $insert['filesize'] = $_FILES['file']['size'] ? $_FILES['file']['size'] : filesize($filePath);
        $insert['ip'] = get_ip();
        $_username = get_cookie('_username');
        $wz_name = get_cookie('wz_name');
        $insert['username'] = $_username ? $_username : $wz_name ? $wz_name : '';
        if($insert['username']=='') die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
        $md5file = md5_file(ATTACHMENT_ROOT.$insert['path']);
        if($r = $this->db->get_one('attachment', array('md5file' => $md5file))) {
            unlink(ATTACHMENT_ROOT.$insert['path']);
            $id = $r['id'];
            die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.ATTACHMENT_URL.$r['path'].'", "id" : "'.$id.'", "filename" : "'.$r['name'].'" }');
        } else {
            $attachment = load_class('attachment',M);
            $insert['md5file'] = $md5file;
            $id = $attachment->insert($insert);

            // Return Success JSON-RPC response
            $info = pathinfo($insert['name']);
            $file_name =  basename($insert['name'], '.'.$info['extension']);
            die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.ATTACHMENT_URL.$fileurl.$fileName.'", "id" : "'.$id.'", "filename" : "'.$file_name.'" }');
        }


    }
    //上传弹窗调用
    public function upload_dialog()
    {
        upload_url_safe();
        $callback = isset($GLOBALS['callback']) ? remove_xss($GLOBALS['callback']) : 'callback_thumb_dialog';
        $htmlid = isset($GLOBALS['htmlid']) ? remove_xss($GLOBALS['htmlid']) : 'file';
        $limit = isset($GLOBALS['limit']) ? intval($GLOBALS['limit']) : '1';
        $GLOBALS['is_thumb'] = isset($GLOBALS['is_thumb']) ? intval($GLOBALS['is_thumb']) : '0';
        $GLOBALS['htmlname'] = isset($GLOBALS['htmlname']) ? remove_xss($GLOBALS['htmlname']) : '';
        $ext = $GLOBALS['ext'];
        $token = $GLOBALS['token'];
        if($ext=='' || md5($ext._KEY)!=$token) {
            MSG('参数错误！');
        }
        $maxsize = ini_get('upload_max_filesize');
        $extimg = array('gif','bmp','jpg','jpeg','png');
        $extzip = array('zip','7z','rar','gz','tar');
        $extpdf = 'pdf';
        $extword = array('doc','docx','xls','xlsx','ppt','pptx');
        $exts = explode('|',$ext);

        $extother = array_diff($exts,$extimg,$extword,$extzip);
        if($extother) {
            $extother = implode(',',$extother);
        } else {
            $extother = '';
        }

        $extimg = array_intersect($extimg,$exts);
        if($extimg) {
            $extimg = implode(',',$extimg);
        } else {
            $extimg = '';
        }

        $extzip = array_intersect($extzip,$exts);
        if($extzip) {
            $extzip = implode(',',$extzip);
        } else {
            $extzip = '';
        }

        $extword = array_intersect($extword,$exts);
        if($extword) {
            $extword = implode(',',$extword);
        } else {
            $extword = '';
        }
        if(!in_array($extpdf,$exts)) {
            $extpdf = '';
        }
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
}
?>
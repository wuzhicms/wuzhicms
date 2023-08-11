<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/22
 * Time: 19:41
 */
defined('IN_WZ') or exit('No direct script access allowed');

class article
{
    private $db;
    private $articleList;
    function __construct()
    {
        $status = load_class('authentication',M);
        if( ! $status->checkLogin() ){
            header('Location: index.php?m=member&f=sign&v=login');
        }
        $this->db = load_class('db');
        $this->Response = load_class('jsonResponse');

    }

    public function add()
    {
        try {
            //获取可投稿栏目列表
            $categorys = $this->getPostableCategorys();
            //加载编辑器组件
            $form = load_class('form');
            $editer = $form->editor();
            //加载模板
            include T('member','addArticle',TPLID);
        } catch (Exception $e) {
            exit($e->getMessage());
        }

    }

    public function listing()
    {

        include T('member','listArticle',TPLID);

    }

    public function edit()
    {
        $id = $GLOBALS['id'];
        $article = $this->db->get_one( 'content_share', array('id' => $id) );
        $content = $this->db->get_one( 'news_data', array('id' => $id) );
        $cid = $article['cid'];
        //获取可投稿栏目列表
        $categorys = $this->getPostableCategorys();
        //加载编辑器组件
        $form = load_class('form');
        $editer = $form->editor('content', 'content', $content['content'] );

        include T('member', 'editArticle', TPLID );

    }

    public function editArticle()
    {
        try {
            $id = $GLOBALS['id'];
            $formdata = [];
            //栏目相关处理
            $formdata['cid']       = $GLOBALS['cid'];
            if (!$formdata['cid'])
                throw new Exception('请选择栏目', 0);
            $category = get_cache('category_'.$formdata['cid'], 'content');
            if (!$category)
                throw new Exception("栏目不存在", 0);
            //模型相关处理
            if ($GLOBALS['modelid'] && is_numeric($GLOBALS['modelid'])) {
                $modelid = $GLOBALS['modelid'];
            } else {
                $modelid = $category['modelid'];
            }
            // 标题相关处理
            $formdata['title']     = $GLOBALS['title'];
            if (!$formdata['title'])
                throw new Exception('标题不能为空');
            //获取表单数据
            $formdata['content']   = $GLOBALS['content'];
            $formdata['remark']    = $GLOBALS['remark'];
            $formdata['thumb']     = $GLOBALS['thumb'];
            $formdata['signature'] = $GLOBALS['signature'];
            //格式化表单数据
            require_once get_cache_path('content_add', 'model');
            $formAdd = new form_add($modelid);
            $formdata = $formAdd->execute($formdata);

            //添加时间
            $updatetime    = isset($GLOBALS['updatetime']) ? strtotime($GLOBALS['updatetime']) : SYS_TIME;
            $formdata['master_data']['updatetime'] = $updatetime;

            //设定稿件审核状态
            $formdata['master_data']['status'] = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 1;

            //自动获取摘要
            if ( empty($GLOBALS['remark']) ) {
                $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
            }
            //更新主表数据
            $this->db->update($formdata['master_table'], $formdata['master_data'], array('id' => $id));
            //更新附表内容
            if(!empty($formdata['attr_table'])) {
                $this->db->update($formdata['attr_table'], $formdata['attr_data'], array('id' => $id));
            }
            //更新其他操作
            $result = $this->db->get_one('content_share', array('id' => $id), 'url');
            $formdata['master_data']['url'] = $result['url'];
            require_once get_cache_path('content_update','model');
            $form_update = new form_update($modelid);
            $data = $form_update->execute($formdata);
            //统计表加默认数据
            if(!$this->db->get_one('content_rank',array('cid'=>$formdata['cid'],'id'=>$id))) {
                $this->db->insert('content_rank',array('cid'=>$formdata['cid'],'id'=>$id,'updatetime'=>SYS_TIME));
            }
            throw new Exception('修改成功', 0);
        } catch (Exception $e) {
            $code    = $e->getCode();
            $message = $e->getMessage();
            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>'') );
        }
    }

    public function getPostableCategorys()
    {
        $uid = $_SESSION['_uid'];
        //获取可投稿栏目列表
        $user = $this->db->get_one('member', array('uid' => $uid));
        $cids = $this->db->get_list('member_group_priv', array('groupid' => $user['groupid'], 'priv' => 'add'));
        if (!$cids)
            throw new Exception('您没有投稿权限');
        $cidSting = '';
        foreach ($cids as $k => $v) {
            $cidSting .= $v['value'] . ',';
        }
        $cidSting = trim($cidSting, ',');
        $where = '`cid` IN ('. $cidSting .') AND `child` = 0';
        $categorys = $this->db->get_list('category', $where, 'cid,name');
        return $categorys;
    }

    public function getArticleList()
    {
        try {
            $uid      = $_SESSION['_uid'];
            if (!$uid)
                throw new Exception('参数错误');

            $user     = $this->db->get_one('member', array('uid'=>$uid));
            $where    = array('publisher' => $user['username']);
            $page     = isset($GLOBALS['page']) ?  intval($GLOBALS['page']) : 1;
            $page     = max($page, 1);
            $pagesize = 15;
            $data     = $this->contentList($where, $page, $pagesize);
            $list     = $data['list'];
            //转换审核状态
            foreach ($list as $k => $v) {
                $list[$k]['status'] = ($v['status'] == 9) ? '已通过' : '审核中';
            }
            $this->articleList = $list;
            $this->count = $data['number'];
            throw new Exception('successful');
        } catch (Exception $e) {

            $code    = 0;
            $message = $e->getMessage();
            $count   = $this->count;
            $data    = $this->articleList;

            $this->Response->json( array('code' => $code, 'msg' => $message, 'count' => $count, 'data' => $data) );

        }
    }

    public function search()
    {
        try {
            $title = $GLOBALS['title'];
            $uid   = $_SESSION['_uid'];
            $user  = $this->db->get_one('member', array('uid'=>$uid));
            $where = '`title` LIKE "%'. $title .'%" AND `publiser` = '. $user['username'];
            $data  = $this->contentList($where);

            $this->articleList = $data['list'];
            $this->count = $data['number'];
        } catch (Exception $e) {
            $code    = 0;
            $message = $e->getMessage();
            $count   = $this->count;
            $data    = $this->articleList;

            $this->Response->json( array('code' => $code, 'msg' => $message, 'count' => $count, 'data' => $data) );
        }

    }
    public function addArticle()
    {
        try {
            $formdata = [];
            //栏目相关处理
            $formdata['cid']       = $GLOBALS['cid'];
            if (!$formdata['cid'])
                throw new Exception('请选择栏目', 0);
            $category = get_cache('category_'.$formdata['cid'], 'content');
            if (!$category)
                throw new Exception("栏目不存在", 0);
            //模型相关处理
            if ($GLOBALS['modelid'] && is_numeric($GLOBALS['modelid'])) {
                $modelid = $GLOBALS['modelid'];
            } else {
                $modelid = $category['modelid'];
            }
            // 标题相关处理
            $formdata['title']     = $GLOBALS['title'];
            if (!$formdata['title'])
                throw new Exception('标题不能为空');
            //获取表单数据
            $formdata['content']   = $GLOBALS['content'];
            $formdata['remark']    = $GLOBALS['remark'];
            $formdata['thumb']     = $GLOBALS['thumb'];
            $formdata['signature'] = $GLOBALS['signature'];
            //格式化表单数据
            require_once get_cache_path('content_add', 'model');
            $formAdd = new form_add($modelid);
            $formdata = $formAdd->execute($formdata);

            //添加时间
            $addtime    = isset($GLOBALS['addtime']) ? strtotime($GLOBALS['addtime']) : SYS_TIME;
            $updatetime = $addtime;
            $formdata['master_data']['addtime']    = $addtime;
            $formdata['master_data']['updatetime'] = $updatetime;
            //是共享模型，添加模型Id
            if($formdata['master_table']=='content_share') {
                $formdata['master_data']['modelid'] = $modelid;
            }
            //设定稿件审核状态
            $formdata['master_data']['status'] = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 1;
            //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
            $formdata['master_data']['route'] = isset($GLOBALS['route']) ? intval($GLOBALS['route']) : 1;
            //投稿用户
            $user = $this->getUser();
            $formdata['master_data']['publisher'] = $user['username'];
            //自动获取摘要
            if ( empty($GLOBALS['remark']) ) {
                $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
            }
            //token 操作
            $formdata['master_data']['token'] = $this->md5Title($formdata['master_data']['title'], $user['username']);
            //插入主表数据
            $id = $this->db->insert($formdata['master_table'], $formdata['master_data']);
            //生成url
            $urlclass = load_class('url','content',$category);
            $categorys = get_cache('category','content');
            $urlclass->set_category($category);
            $urlclass->set_categorys($categorys);
            $route_config = array('id'=>$id,'cid'=>$formdata['cid'],'addtime'=>$addtime,'page'=>1);
            $route_config = array_merge($route_config,$formdata['master_data']);
            $urls = $urlclass->showurl($route_config);
            $this->db->update($formdata['master_table'],array('url'=>$urls['url']),array('id'=>$id));
            //更新附表内容
            if(!empty($formdata['attr_table'])) {
                $formdata['attr_data']['id'] = $id;
                $this->db->insert($formdata['attr_table'],$formdata['attr_data']);
            }
            //更新其他操作
            $formdata['master_data']['url'] = $urls['url'];
            require_once get_cache_path('content_update','model');
            $form_update = new form_update($modelid);
            $data = $form_update->execute($formdata);
            //统计表加默认数据
            if(!$this->db->get_one('content_rank',array('cid'=>$formdata['master_data']['cid'],'id'=>$id))) {
                $this->db->insert('content_rank',array('cid'=>$formdata['master_data']['cid'],'id'=>$id,'updatetime'=>SYS_TIME));
            }
            //增加积分
            $point = load_class('credit_api', 'credit');
            $point->set_credit('addnews', $_SESSION['_uid'], $formdata['master_data']['cid'], $id, '投稿');
            throw new Exception('添加成功!!', 0);
        } catch (Exception $e) {
            $code    = $e->getCode();
            $message = $e->getMessage();
            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>'') );
        }


    }

    public function delArticle()
    {
        try {
            $id = $GLOBALS['id'];
            $this->db->delete( 'content_share', array('id' => $id) );
            throw new Exception('删除成功！', 0);
        } catch (Exception $e) {
            $code    = $e->getCode();
            $message = $e->getMessage();
            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>'') );
        }



    }

    public function getUser()
    {
        $uid = $_SESSION['_uid'];
        $user = $this->db->get_one('member', array('uid' => $uid));
        return $user;
    }

    protected function contentList($where, $page = 1, $pagesize = 15)
    {
        $order    = 'addtime DESC';
        $result   = $this->db->get_list('content_share', $where, 'id,title,addtime,status', 0, $pagesize, $page, $order);
        foreach ($result as $k => $v) {
            $result[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }
        $number = $this->db->number;
        $data   = array('number' => $number, 'list' => $result);
        return $data;
    }

    public function thumbUpload()
    {
        $file = $_FILES['file'];
        //错误信息定义
        $errorMessage = array(
            0 => 'UPLOAD_ERR_OK',
            1 => 'UPLOAD_ERR_INI_SIZE',
            2 => 'UPLOAD_ERR_FORM_SIZE',
            3 => 'UPLOAD_ERR_PARTIAL',
            4 => 'UPLOAD_ERR_NO_FILE',
            6 => 'UPLOAD_ERR_NO_TMP_DIR',
            7 => 'UPLOAD_ERR_CANT_WRITE',
        );

        try {
            if ( ! $file ) {
                throw new Exception( '文件不存在', '20018' );
            }
            if ( $file['error'] ) {
                throw new Exception( $errorMessage[ $file['error'] ], '20019' );
            }

            if ( ! is_uploaded_file( $file['tmp_name'] ) ){
                throw new Exception('非法上传文件', '20020' );
            }
            $originFileName = $this->getFileName( $file['name'] );
            $originPath = $this->getFilePath();

            if ( ! file_exists( $originPath ) && ! mkdir( $originPath, 0777, true ) ) {
                chmod( $originPath, '0777' );
                throw new Exception('创建目录失败', '20021');
            }

            if ( ! move_uploaded_file( $file['tmp_name'], $originPath . $originFileName ) && ! file_exists( $originPath. $originFileName ) ) {
                throw new Exception( "文件上传失败", '20023' );
            } else {
                $url = $this->getFileUrl() . $originFileName;

                $code    = 0;
                $message = '上传成功';
                $data    = array( 'src' => $url );
                $status  = 0;
                $this->Response->json( array('code'=>$code,  'msg'=>$message, 'data'=>$data, 'status'=>$status ) );
            }

        } catch ( Exception $e ) {

            $code    = 0;
            $message = $e->getMessage();
            $data    = $e->getCode();

            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>$data) );

        }

    }
    public function getFileName($file)
    {
        $ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
        $rand_str = random_string('diy', 6,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $fileName = $_SESSION['_uid'].$rand_str.'.'.$ext;
        return $fileName;
    }
    public function getFilePath()
    {
        $date    = date("Y-m-d");
        $dateArr = explode('-', $date);
        return ATTACHMENT_ROOT . $dateArr[0] . '/' . $dateArr[1] . '/'. $dateArr[2] . '/';
    }
    public function getFileUrl()
    {
        $date    = date("Y-m-d");
        $dateArr = explode('-', $date);
        return ATTACHMENT_URL . $dateArr[0] . '/' . $dateArr[1] . '/'. $dateArr[2] . '/';
    }

    protected function md5Title($title, $uid)
    {
        $token = md5($title.$uid);
        $content = $this->db->get_one('content_share', array('token' => $token));
        if ($content) {
            throw new Exception('信息已添加，请不要重复添加！', 0);
        } else {
            return $token;
        }
    }
}
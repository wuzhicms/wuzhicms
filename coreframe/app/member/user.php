<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/22
 * Time: 20:33
 */
class user
{
    public function __construct()
    {
        $status = load_class('authentication',M);
        if( ! $status->checkLogin() ){
            header('Location: index.php?m=member&f=sign&v=login');
        }

        $this->db = load_class('db');
        $this->Response = load_class('jsonResponse');


    }

    public  function setUserInfo()
    {
        $userInfo = $this->userInfo($_SESSION['_uid']);
        include T('member','userInfo',TPLID);
    }

    public function setPassword()
    {
        include T('member','password',TPLID);
    }

    public function changePassword()
    {
        $oldPassword = $GLOBALS['oldPassword'];
        $password    = $GLOBALS['password'];
        $repassword  = $GLOBALS['repassword'];

        try{

            $userInfo = $this->userInfo( $_SESSION['uid'] );
            if( ! $userInfo){

                throw new Exception('用户不存在', '20024');

            }

            if( $userInfo['password'] !== md5(md5($oldPassword).$userInfo['factor']) ){

                throw new Exception('旧密码不正确', '20015');

            }

            if($password !== $repassword){

                throw new Exception('输入密码不一致', '20016');
            }

            $factor = random_string('diy', 6);
            $this->db->update('member', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)), '`uid`='.$userInfo['uid']);

            throw new Exception('修改成功', '20010');

        }catch (Exception $e){

            $code    = 0;
            $message = $e->getMessage();
            $data    = $e->getCode();

            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>$data) );

        }



    }

    public function userInfo($uid)
    {
        $info = $this->db->get_one( 'member',array('uid'=>$uid) );

        return $info;
    }

    public function changeUserInfo()
    {
        $uid       = $_SESSION['uid'];
        $nickname  = $GLOBALS['nickname'];
        $sex       = $GLOBALS['sex'];
        $avatar    = $GLOBALS['avatar'];
        $cellphone = $GLOBALS['cellphone'];
        $email     = $GLOBALS['email'];
        $remarks   = $GLOBALS['remarks'];

        try{
            $data = array(
                'nickname'   => $nickname,
                'sex'        => $sex,
                'avatar'     => $avatar,
                'cellphone'  => $cellphone,
                'email'      => $email,
                'remarks'     => $remarks
            );

            $condition = array(
                'uid'  => $uid,
            );

            if( $this->userInfo($uid) ) {
                $this->db->update('member', $data, $condition);
                throw new Exception('更新成功', '20010');
            }else{
                throw new Exception('更新失败', '20017');
            }

        }catch(Exception $e){
            $code    = 0;
            $message = $e->getMessage();
            $data    = $e->getCode();

            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>$data) );
        }

    }



    public function certification()
    {
        require get_cache_path('member_form','model');
        $model = $this->db->get_list('member_verify_set');
        $models = get_cache('model_member','model');
        $formData = array();
        foreach ($model as $value) {
            $modelid = $value['modelid'];
            $formData[] = new form_build($modelid);
            $attr_table = $models[$modelid]['attr_table'];
            $result[$modelid] = $this->db->get_one($attr_table, array('uid'=>$_SESSION['_uid']));
            $verifyRes[$modelid] = $this->db->get_one('member_verify', array('uid'=>$_SESSION['_uid'], 'modelid'=>$modelid));
        }
        include  T("member", "certification", TPLID);
    }

    public function applyCertification()
    {
        try{
            $modelid = intval($GLOBALS['modelid']);
            $uid = $_SESSION['_uid'];

            if(empty($modelid)) {
                throw new Exception('模型为空', '20011');
            }
            $models = get_cache('model_member','model');
            $attr_table = $models[$modelid]['attr_table'];
            $model_field = get_cache('field_' . $modelid, 'model');
            $formdata = array();
            foreach ($model_field as $field) {
                $formdata[$field['field']] = isset($GLOBALS[$field['field']]) ? $GLOBALS[$field['field']] : '';
            }

            //判断是否存在
            $where = array(
                'uid' => $uid,
                'modelid' => $modelid
            );
            $verifyModel = $this->db->get_one('member_verify', $where);
            //存在更新
            if($verifyModel) {
                $this->db->update('member_verify', array('status' => 0,'created_at' => SYS_TIME), $where);
                $this->db->update($attr_table, $formdata, array('uid' => $uid));

            } else {
                //不存在保存
                //保存扩展信息
                $formdata['uid'] = $uid;
                $this->db->insert($attr_table, $formdata);

                //保存审核表
                $data = array(
                    'uid' => $_SESSION['_uid'],
                    'modelid' => $modelid,
                    'created_at' => SYS_TIME
                );
                $this->db->insert('member_verify', $data);
            }
            throw new Exception('保存成功', '20010');
        }catch(Exception $e){
            $code    = 0;
            $message = $e->getMessage();
            $data    = $e->getCode();
            $this->Response->json( array('code'=>$code, 'msg'=>$message, 'data'=>$data) );
        }
    }

    public function setAvatar()
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

                $this->db->update( 'member', array( 'avatar' => $url ), array( 'uid' => $_SESSION['_uid'] ) );

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
        return ATTACHMENT_ROOT . 'member/' .$_SESSION['_uid'] . '/';
    }
    public function getFileUrl()
    {
        return ATTACHMENT_URL . 'member/' . $_SESSION['_uid'] . '/';
    }




}
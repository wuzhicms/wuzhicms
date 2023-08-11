<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/22
 * Time: 9:42
 */
load_class('session');
class sign
{
    private  $db, $json;

    function __construct()
    {
        $this->db = load_class('db');
        $this->json = load_class('jsonResponse');

    }

    public function login()
    {

        include T('member','login');

    }

    public function checkUser()
    {
        $username = isset($GLOBALS['username']) ? p_htmlspecialchars($GLOBALS['username']) : '';
        $password = $GLOBALS['password'];
        $code = $GLOBALS['vercode'];


        try {

            if( empty($username) || empty($password) ) {
                throw new Exception('Username or password cannot be empty', '20011');
            }

            $this->checkCode($code);

            $user = $this->db->get_one('member',array('username'=>$username));

            if($user['password'] && (md5(md5($password).$user['factor'])==$user['password']) ){

                $_SESSION['_uid'] = $user['uid'];
                set_cookie('_uid',$user['uid']);
                set_cookie('_username',$username);


                throw new Exception('登录成功',20010);

            }else{

                throw new Exception('User does not exist or password wrong', '20012');
            }

        } catch(Exception $e) {

            $message = $e->getMessage();
            $code = $e->getCode();
            $result = array(
                'code' => $code,
                'msg'  => $message,
                'data' => ''
            );

            $this->json->json( $result );

        }


    }

    public function checkCode($code){

        if (strtolower($_SESSION['code']) != strtolower($code)){

            $_SESSION['code'] = '';

            throw new Exception('验证码错误','20013');
        }

    }

    public function logout()
    {
        if(isset($_SESSION['_uid'])){
            $_SESSION = array();
        }

        set_cookie('_username','');
        set_cookie('_uid','');

        $result = array('code'=>0, 'msg'=>'退出成功', 'data'=>null);

        $this->json->json($result);

    }


}
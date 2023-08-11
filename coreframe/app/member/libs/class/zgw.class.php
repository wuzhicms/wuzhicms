<?php
/**
 * Created by PhpStorm.
 * User: zhaohongwei
 * Date: 2017-10-07
 * Time: 14:07
 */
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_zgw extends WUZHI_foreground
{
    private $username,$password,$userlastip;
    private $zgw_api = "http://21.44.44.56/api/userapi.aspx";

    public function setValue($username,$password,$userlastip){
        $this->username = $username;
        $this->password = $password;
        $this->userlastip = $userlastip;
    }

    public function checkAuthor(){
        $url = $this->zgw_api.'&username='.$this->username.'&password='.$this->password.'&UserLastIp='.$this->userlastip;
        $userInfo = json_decode(get_culr($url),true);
        /*$userInfo = array(
            'rt'=>1,
            'UserID'=>123,
            'UserName'=>'zhaoxiaolu',
            'UserTName'=>'赵大山',
            'UserIdCard'=>'123456789',
            'UserPhone'=>'18612252448',
            'UserDepart'=>'东部战区',
            'UserAddress'=>'上海市'
        );*/
        if($userInfo['rt'] == 1){
            $data = array();
            $data['ucuid'] = $userInfo['UserID'];
            $data['username'] = $userInfo['UserName'];
            $data['truename'] = $userInfo['UserTName'];
            $data['identity_card'] = $userInfo['UserIdCard'];
            $data['mobile'] = $userInfo['UserPhone'];
            $data['companyname'] = $userInfo['UserDepart'];
            $data['address'] = $userInfo['UserAddress'];
            $data['factor'] = random_string('diy',6);
            $data['password'] = md5(md5('123456').$data['factor']);
            $data['pw_reset'] = '0';
            $db = load_class('db');
            $uid = $db->insert('member',$data,true);
            if($uid){
                    //设置登录
                    $r = $db->get_one('member', array('uid' => $uid));
                    $this->create_cookie($r, SYS_TIME+604800);
                    $synlogin = '';
                    MSG('登录成功'.$synlogin,'?m=member');

            }else{
                MSG(L('register_error'));
            }
        }else{
            MSG(L('用户名或密码错误'));
        }
        $forward = empty($GLOBALS['forward']) ? 'index.php?m=member' : $GLOBALS['forward'];
        if(isset($GLOBALS['minilogin'])) {
            MSG(L('login_success').'<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>',HTTP_REFERER,3000);
        } else {
            MSG(L('login_success').$synlogin, $forward);
        }
    }

}
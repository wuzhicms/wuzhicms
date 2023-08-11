<?php
/**
 * 对接LDAP用户，实现注册，登录功能
 * @since 5.0
 */

class auth
{
    private $ldap;
    function __construct()
    {
        $this->ldap = load_class('ldap','member');
        $this->json = load_class('jsonResponse');
    }

    /**
     * Authenticate user
     * @since 5.0
     */
    function login()
    {
        $username = $GLOBALS['username'];
        $password = $GLOBALS['password'];

        $this->ldap->username = $username;
        $this->ldap->password = $password;
        $this->ldap->baseDN = 'ou=sale,dc=wuzhicms,dc=com';

        $bindDir = $this->ldap->bind();

        if ($bindDir === true) {
            $users = $this->ldap->search();
            if ($users['count'] === 1) {
                $user['uid']  =  $users[0]['uid'][0];
                $user['name']  = $users[0]['cn'][0];
              //  $user['photo'] = $users[0]['jpegphoto'][0];
            }
            $this->json->jsonOfStatus(200, 'ok',  $user);
        } else {
            $this->json->jsonOfStatus(401, '验证未通过，用户名或密码错误！',  null);
        }
    }

    /**
     * 用户注册到LDAP
     */
    function register()
    {
        $username = $GLOBALS['username'];
        $passowrd = $GLOBALS['password'];
        $sn       = $GLOBALS['sn'];
        $givenName= $GLOBALS['givenName'];
        $mail     = $GLOBALS['mail'];
        $title    = $GLOBALS['title'];
        $org        = $GLOBALS['org'];
        $telephoneNumber = $GLOBALS['telephoneNumber'];
        $postalAddress   = $GLOBALS['postalAddress'];

        $dn = 'cn=' . $username . ',ou=qjw,dc=wuzhicms,dc=com';
        $adduserAD["objectClass"][0] = "top";
        $adduserAD["objectClass"][1] = "posixAccount";
        $adduserAD["objectClass"][2] = "inetOrgPerson";
        $adduserAD["gidNumber"] = 5;
        $adduserAD["givenName"] = $givenName;  //名
        $adduserAD["sn"] = $sn; //姓
        $adduserAD["displayName"] = $sn . $givenName; //昵称
        $adduserAD["uid"] = $username;  //用户名
        $adduserAD['userPassword']= "{SHA}".base64_encode(pack("H*",sha1($passowrd))); //密码
        $adduserAD["mail"] = $mail;  //邮箱
        $adduserAD["title"] = $title;  //职位
        $adduserAD["o"] = $org;  //单位
        $adduserAD["telephoneNumber"] = $telephoneNumber;  //电话
        $adduserAD["postalAddress"] = $postalAddress;  //地址
        $adduserAD['homeDirectory']='/sbin/nologin';  //用户目录
        $adduserAD['uidNumber']=SYS_TIME . mt_rand(0,19);  //用户ID

        $result = $this->ldap->add($dn, $adduserAD);
        if ($result === true) {
            $data = array(
                'username'=>$adduserAD['uid'],
            );
            $this->json->jsonOfStatus(200, 'ok', $data);
        } else {
            $this->json->jsonOfStatus(400, '添加失败', null);
        }

    }

    function changePassword()
    {

    }



}

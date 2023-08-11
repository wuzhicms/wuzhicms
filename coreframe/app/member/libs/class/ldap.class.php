<?php
/**
 * LDAP 连接.
 * @since 5.0
 */

class WUZHI_ldap
{
    public $username;
    public $password;
    public $baseDN;
    public $adServer = 'ldap://192.144.151.6';
    private $ldap;

    function __construct()
    {

        $this->connect();
    }

    /**
     * connect to an LDAP server
     *
     */
    public function connect()
    {
        $this->ldap = @ldap_connect($this->adServer)
            or die('This LDAP_URI was not parseable');

    }

    /**
     * @return bool
     * bind to LDAP directory
     */
    public function bind()
    {
        ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);

        if ($this->ldap) {
            $userDN = 'uid='.$this->username.','.$this->baseDN;
            $ldapbind = @ldap_bind( $this->ldap, $userDN, $this->password );
            return $ldapbind;
        }
    }

    /**
     * @return array
     * search LDAP tree
     */
    public function search()
    {
        $filter = "(uid={$this->username})";
        $justthese = array(
            "ou",
            "cn",
            "givenName",
            "mail",
            "jpegPhoto",
            "uid",
        );
        $sr = ldap_search($this->ldap, $this->baseDN, $filter, $justthese);
        $info = ldap_get_entries($this->ldap, $sr);
        return $info;
    }

    public function add($adn, $adduserAD)
    {
        ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);

        if ($this->ldap) {
            $dn = 'cn=admin,dc=wuzhicms,dc=com';
            $password = '123456';
            $ldapbind = @ldap_bind( $this->ldap, $dn, $password );

            if ( ! @ldap_add( $this->ldap, $adn, $adduserAD ) ) {
                return false;
            } else {
               return true;
            }
            unbind($this->ldap);
        }

    }

}
<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 加密类
 */
class WUZHI_encrypt {
    /**
     * 判断是否支持 mcrypt 扩展
     *
     * @var bool
     */
    protected $_support_mcrypt = TRUE;

    /**
     * Initialize Encryption class
     *
     * @return	void
     */
    public function __construct()
    {
        if (($this->_support_mcrypt = function_exists('mcrypt_encrypt')) === FALSE)
        {
            $this->_support_mcrypt = FALSE;
        }
    }

    /**
     * Encode
     *
     *
     * @param	string	the string to encode
     * @param	string	the key
     * @return	string
     */
    public function encode($string, $key = '') {
        $key = $key == '' ? _KEY : $key;
        if($this->_support_mcrypt) {
            return base64_encode($this->mcrypt_encode($string, $key));
        } else {
            return $this->_authcode($string, 'ENCODE', $key);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Decode
     *
     * Reverses the above process
     *
     * @param	string
     * @param	string
     * @return	string
     */
    public function decode($string, $key = '') {
        $key = $key == '' ? _KEY : $key;
        if($this->_support_mcrypt) {
            if (preg_match('/[^a-zA-Z0-9\/\+=]/', $string) OR base64_encode(base64_decode($string)) !== $string)
            {
                return FALSE;
            }
            return $this->mcrypt_decode(base64_decode($string), $key);
        } else {
            return $this->_authcode($string, 'DECODE', $key);
        }
    }

    /**
     * Encrypt using Mcrypt
     *
     * @param	string
     * @param	string
     * @return	string
     */
    public function mcrypt_encode($data, $key)
    {
        $init_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);
        return $this->_add_cipher_noise($init_vect.mcrypt_encrypt(MCRYPT_DES, $key, $data, MCRYPT_MODE_CBC, $init_vect), $key);
    }

    // --------------------------------------------------------------------

    /**
     * Decrypt using Mcrypt
     *
     * @param	string
     * @param	string
     * @return	string
     */
    public function mcrypt_decode($data, $key)
    {
        $data = $this->_remove_cipher_noise($data, $key);
        $init_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_CBC);

        if ($init_size > strlen($data))
        {
            return FALSE;
        }

        $init_vect = substr($data, 0, $init_size);
        $data = substr($data, $init_size);
        return rtrim(mcrypt_decrypt(MCRYPT_DES, $key, $data, MCRYPT_MODE_CBC, $init_vect), "\0");
    }


    /**
     * _add_cipher_noise()
     *
     * Function description
     *
     * @param	string	$data
     * @param	string	$key
     * @return	string
     */
    protected function _add_cipher_noise($data, $key)
    {
        $key = md5($key);
        $str = '';

        for ($i = 0, $j = 0, $ld = strlen($data), $lk = strlen($key); $i < $ld; ++$i, ++$j)
        {
            if ($j >= $lk)
            {
                $j = 0;
            }

            $str .= chr((ord($data[$i]) + ord($key[$j])) % 256);
        }

        return $str;
    }

    /**
     * _remove_cipher_noise()
     *
     * Function description
     *
     * @param	string	$data
     * @param	string	$key
     * @return	string
     */
    protected function _remove_cipher_noise($data, $key)
    {
        $key = md5($key);
        $str = '';

        for ($i = 0, $j = 0, $ld = strlen($data), $lk = strlen($key); $i < $ld; ++$i, ++$j)
        {
            if ($j >= $lk)
            {
                $j = 0;
            }

            $temp = ord($data[$i]) - ord($key[$j]);

            if ($temp < 0)
            {
                $temp += 256;
            }

            $str .= chr($temp);
        }

        return $str;
    }


    private function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key != '' ? $key : _KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }

    }
}
<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 短信API
 */
class WUZHI_sms {
	public $uid;
	public $statuscode;
	private $sms_uid,$sms_pid,$sms_key,$smsapi_url;
	
	/**
	 * 
	 * 初始化接口类
	 * @param int $uid 用户id
	 * @param int $sms_pid 产品id
	 * @param string $sms_key 密钥
	 */
	public function __construct() {
		$this->smsapi_url = 'http://sms.phpip.com/api.php?';
        $sms_config = get_cache('sms_config','sms');
		$this->sms_uid = $sms_config['sms_uid'];
		$this->sms_pid = $sms_config['sms_pid'];
		$this->sms_key = $sms_config['sms_passwd'];
	}
		
	/**
	 * 
	 * 获取短信产品列表信息
	 */
	public function get_price() {
		$this->param = array('op'=>'sms_get_productlist');
		$res = $this->getinfo();
		
		return !empty($res) ? json_decode($res, 1) : array();	
	}
	
	/**
	 * 
	 * 获取短信产品购买地址
	 */
	public function get_buyurl($productid = 0) {
		return 'http://sms.phpip.com/index.php?m=sms_service&c=center&a=buy&sms_pid='.$this->sms_pid.'&productid='.$productid;
	}

	/**
	 * 获取短信剩余条数和限制短信发送ip
	 */
	public function get_smsinfo() {
		$this->param = array('op'=>'sms_get_info');
		$res = $this->getinfo();
		return !empty($res) ? json_decode($res, 1) : array();	
	}	

	/**
	 * 获取充值记录
	 */
	public function get_buyhistory() {
		$this->param = array('op'=>'sms_get_paylist');
		$res = $this->getinfo();
		return !empty($res) ? json_decode($res, 1) : array();			
	}

	/**
	 * 获取消费记录
	 * @param int $page 页码
	 */
	public function get_payhistory($page=1) {
		$this->param = array('op'=>'sms_get_report','page'=>$page);
		$res = $this->getinfo();
		return !empty($res) ? json_decode($res, 1) : array();		
	}

    /**
     * 发送短信
     *
     * @param string $mobile
     * @param string $content
     * @param string $tplid
     * @param string $send_time
     * @param int $return_code
     * @return mixed
     */
	public function send_sms($mobile='', $content='',$tplid = '', $send_time ='', $return_code = 0) {
		//短信发送状态
		$status = $this->_sms_status();
		if(is_array($mobile)){
			$mobile = implode(",", $mobile);
		}
		if(strtolower(CHARSET)=='utf-8') {
			$send_content = iconv('utf-8','gbk',$content);
		}else{
			$send_content = $content;
		}
		$send_time = strtotime($send_time);
	
		$data = array(
            'sms_pid' => $this->sms_pid,
            'sms_passwd' => $this->sms_key,
            'sms_uid' => $this->sms_uid,
            'charset' => CHARSET,
            'send_txt' => urlencode($send_content),
            'mobile' => $mobile,
            'send_time' => $send_time,
            'tplid' => $tplid,
        );
		$post = '';
		foreach($data as $k=>$v) {
			$post .= $k.'='.$v.'&';
		}

		$smsapi_senturl = $this->smsapi_url.'op=sms_service_vip';
		$return = $this->_post($smsapi_senturl, 0, $post);
		$arr = explode('#',$return);
		$this->statuscode = $arr[0];
		
		if(isset($this->statuscode)) {
 			//成功
		} else {
            //失败
		}
		if($return_code) {
			return $arr[0];
		} else {
			return isset($status[$arr[0]]) ? $status[$arr[0]] : $arr[0];
		}
	}
		
	/**
	 * 
	 * 获取远程内容
	 * @param $timeout 超时时间
	 */
	public function getinfo($timeout=30) {
		
		$this->setting = array(
							'sms_uid'=>$this->sms_uid,
							'sms_pid'=>$this->sms_pid,
							'sms_passwd'=>$this->sms_key,	
							);
									
		$this->param = array_merge($this->param, $this->setting);
		
		$url = $this->smsapi_url.http_build_query($this->param);
		$stream = stream_context_create(array('http' => array('timeout' => $timeout)));
		return @file_get_contents($url, 0, $stream);
	}
	
	/**
	 *  post数据
	 *  @param string $url		post的url
	 *  @param int $limit		返回的数据的长度
	 *  @param string $post		post数据，字符串形式username='dalarge'&password='123456'
	 *  @param string $cookie	模拟 cookie，字符串形式username='dalarge'&password='123456'
	 *  @param string $ip		ip地址
	 *  @param int $timeout		连接超时时间
	 *  @param bool $block		是否为阻塞模式
	 *  @return string			返回字符串
	 */
	
	private function _post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 30, $block = true) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
		$siteurl = URL();
		if($post) {
			$out = "POST $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n" ;
			$out .= 'Content-Length: '.strlen($post)."\r\n" ;
			$out .= "Connection: Close\r\n" ;
			$out .= "Cache-Control: no-cache\r\n" ;
			$out .= "Cookie: $cookie\r\n\r\n" ;
			$out .= $post ;
		} else {
			$out = "GET $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) return '';
	
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
	
		if($status['timed_out']) return '';	
		while (!feof($fp)) {
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
		}
		
		$stop = false;
		while(!feof($fp) && !$stop) {
			$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
			$return .= $data;
			if($limit) {
				$limit -= strlen($data);
				$stop = $limit <= 0;
			}
		}
		@fclose($fp);
		
		//部分虚拟主机返回数值有误，暂不确定原因，过滤返回数据格式
		$return_arr = explode("\n", $return);
		if(isset($return_arr[1])) {
			$return = trim($return_arr[1]);
		}
		unset($return_arr);
		
		return $return;
	}

	/**
	 * 
	 * 接口短信状态
	 */
	private function _sms_status() {
        $array = array(
            '0'=>'发送成功',
            '1'=>'手机号码非法',
            '2'=>'用户存在于黑名单列表',
            '3'=>'接入用户名或密码错误',
            '4'=>'产品代码不存在',
            '5'=>'IP非法',
            '6 '=>'源号码错误',
            '7'=>'调用网关错误',
            '8'=>'消息长度超过限制',
            '9'=>'发送短信内容参数为空',
            '10'=>'用户已主动暂停该业务',
            '11'=>'wap链接地址或域名非法',
            '12'=>'5分钟内给同一个号码发送短信超过10条',
            '13'=>'短信模版ID为空',
            '14'=>'禁止发送该消息',
            '-1'=>'每分钟发给该手机号的短信数不能超过3条',
            '-2'=>'手机号码错误',
            '-11'=>'帐号验证失败',
            '-10'=>'接口没有返回结果',
        );
		return $array;
	}
	
}
?>
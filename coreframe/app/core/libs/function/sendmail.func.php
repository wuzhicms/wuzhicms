<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
function send_mail($to,$subject,$body) {
	if($to=='') return false;
	require_once COREFRAME_ROOT.'extend/class/PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$config = get_cache('sendmail');
	
	$password = decode($config['password']);
	$smtp_server = $config['smtp_server'];
	$smtp_user = $config['smtp_user'];
	$send_email = $config['send_email'];
	if($send_email=='') return true;
	$smtp_port = $config['smtp_port'];

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->CharSet    ="UTF-8";
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $smtp_server;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $smtp_user;                 // SMTP username
	$mail->Password = $password;                           // SMTP password
	$mail->SMTPSecure = $config['openssl'] ? 'ssl' : '';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $smtp_port;                                    // TCP port to connect to

	$mail->setFrom($send_email, $config['nickname']);
	$mail->isHTML(true);
	$emails = explode(';',$to);
	foreach($emails as $_to) {
		$tmp_body = str_replace('TO_EMAIL',$_to,$body);
		$mail->addAddress($_to);
		$mail->Subject = $subject;
		$mail->Body    = $tmp_body;
		if(!$mail->send()) {
			return false;
		}
	}
}

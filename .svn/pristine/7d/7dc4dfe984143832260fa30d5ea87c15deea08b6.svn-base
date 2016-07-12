<?php
class remove_xss {
	function __construct() {

	}
	function index() {

		
		$data = '<LINK REL="stylesheet" href="javascript:alert(\'XSS\');">
<IMG src=\'vbscript:msgbox("XSS")\'>
<IMG src="mocha:[code]">
<IMG src="livescript:[code]">
<META HTTP-EQUIV="refresh" CONTENT="0;url=javascript:alert(\'XSS\');">
<IFRAME src=javascript:alert(\'XSS\')></IFRAME>
<FRAMESET><FRAME src=javascript:alert(\'XSS\')></FRAME></FRAMESET>
<TABLE BACKGROUND="javascript:alert(\'XSS\')">
<DIV STYLE="background-image: url(javascript:alert(\'XSS\'))">
<DIV STYLE="behaviour: url(\'http://www.how-to-hack.org/exploit.html\');">
<DIV STYLE="width: expression(alert(\'XSS\'));">
<STYLE>@im\port\'\ja\vasc\ript:alert("XSS")\';</STYLE>
<IMG STYLE=\'xss:expre\ssion(alert("XSS"))\'>
<STYLE TYPE="text/javascript">alert(\'XSS\');</STYLE>
<STYLE TYPE="text/css">.XSS{background-image:url("javascript:alert(\'XSS\')");}</STYLE><A class="XSS"></A>
<STYLE type="text/css">BODY{background:url("javascript:alert(\'XSS\')")}</STYLE>
<DIV STYLE="background-image: url(http://www.baidu.com)">
<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29> 

<IMG SRC="jav&#x0D;ascript:alert(\'XSS\');"> 
"<IMG SRC=java/0script:alert(\'XSS\')>";’ > out 
<IMG SRC=" javascript:alert(\'XSS\');"> 
<SCRIPT>a=/XSS/alert(a.source)</SCRIPT>

这里是中文

<IMG SRC="jav&#x09;ascript:alert(\'XSS\');">
<IMG SRC="jav&#x0A;ascript:alert(\'XSS\');">
';



		echo remove_xss($data);
	}
}
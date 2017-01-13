<?php 

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 11';
$page[ 'page_id' ] = 'ctf';
$page[ 'help_button' ] = 'audit';
$page[ 'source_button' ] = 'audit';
//
require_once '../../hackable/ctf/ctf.php';
//cookie: seclab_ctf_11=111111222222333333
//auth=1412148&encode=YzJWamJHRmllRjlqZEdaZk1URT0=
if($_POST['submit']=='check'){
	if($_COOKIE['seclab_ctf_11']=='111111222222333333'){
		if(((int)$_POST['auth'] ^ 0x1234) >> 0x6 == 0x5678){
			if(base64_decode($_POST['encode'])==base64_encode("seclabx_ctf_11")){
				$flag=$FLAG['audit'];
				$vaild=1;
			}
		}
	}
}
if(empty($vaild)){
	$flag="You have must input vaild parameter";
}

dvwaMessagePush($flag);
$page[ 'body' ] .= "
<div class=\"body_padded\">
<h1>你看的懂？</h1>
<img width=100% heigh=100% src=../../hackable/ctf/q11/bloodelves.jpg>
<!--
if(\$_POST['submit']=='check'){
	if(\$_COOKIE['seclab_ctf_11']=='111111222222333333'){
		if(((int)\$_POST['auth'] ^ 0x1234) >> 0x6 == 0x5678){
			if(base64_decode(\$_POST['encode'])==base64_encode(\"seclabx_ctf_11\")){
				\$flag=\$FLAG['audit'];
				\$vaild=1;
			}
		}
	}
}
if(empty(\$vaild)){
	\$flag=\"You have must input vaild parameter\";
}
-->
</div>
";

?>
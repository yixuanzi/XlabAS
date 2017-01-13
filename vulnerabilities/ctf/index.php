<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';
dvwaPageStartup( array( 'authenticated', 'phpids' ) );
require_once '../ainclude.php';

if(!dvwaIsCtf()){
	echo "You have must select ctf model !!!";
	exit();
}

#dvwadebug($_CTF);
if (isset( $_GET[ 'pid' ])){
	if(in_array($_GET['pid'],array('5','6'))){
		dvwaDatabaseConnect_ctf('ctf');
	}else{
		dvwaDatabaseConnect();
	}
	$pid=xlabGetSqli('pid',$_GET);
	if(!is_numeric($pid)){
		require_once 'manager/'.$pid.'.php';
	}else{
		require_once $_CTF['map'][$pid];
	}
}

dvwaHtmlEcho( $page );
?>

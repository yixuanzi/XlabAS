<?php
	if(!isset($_GET['content'])){
		dvwaRedirect("{$_DVWA['location']}/vulnerabilities/ctf/?pid=7&content=chun");
	}
	$file = $_GET['content']; //The page we wish to display 


	$page = dvwaPageNewGrab();
	$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 7';
	$page[ 'page_id' ] = 'ctf';

	
	$page[ 'help_button' ] = 'fi';
	
	$page[ 'source_button' ] = 'fi';
	
	@include($file.'.php');

?>

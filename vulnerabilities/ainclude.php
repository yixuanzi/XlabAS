<?php
if(xlabIsConfig('sectf','1') and (!xlabIsNonsec())){
	$vulnerabilityFile = 'high.php';
	$dvwaSession =& dvwaSessionGrab();
	if(!isset($_SESSION['dvwa']['php_ids'])){
		$_SESSION['dvwa']['php_ids']='enable';
	}
}
?>
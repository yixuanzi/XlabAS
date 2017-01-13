<?php 
define( 'DVWA_WEB_PAGE_TO_ROOT', '../../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';
dvwaPageStartup( array( 'authenticated', 'phpids' ) );
dvwaDatabaseConnect();

if(isset($_GET['del'])){
	$name=xlabGetSqli('del', $_GET);
	if($name==dvwaGetuser() or xlabisadmin()){
		$sql="DELETE FROM userflag WHERE user='$name'";
		$result=mysql_query($sql);
		dvwaRedirect(xlabGetLocation()."/vulnerabilities/ctf/?pid=score&msg=delete $name succfully!!!");
	}else{
		dvwaRedirect(xlabGetLocation()."/vulnerabilities/ctf/?pid=score&msg=delete $name fail!!!");
	}
}
?>
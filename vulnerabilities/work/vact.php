<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';
dvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'Work';
$page[ 'page_id' ] = 'work';

if(!dvwaIfWork()){
	exit();
}
dvwaDatabaseConnect();
$user=dvwaCurrentUser();
$html='';
if (isset($_GET['act']) && $_GET['act']=='detail'){
	$date=$_GET['date'];
	$author=$_GET['user'];
	if ($user=="admin"){
		$sql="select * from report where date='{$date}' and name='{$author}'";
	}else{
		$sql="select * from report where name='{$user}' and date='{$date}'";
	}
	#echo $sql;
	$result = mysql_query($sql);
	$num = mysql_numrows($result);
	if ($num>0){
		$date=mysql_result($result,0,"date");
		$name=mysql_result($result,0,"name");
		$report=mysql_result($result,0,"report");
	}
/*
	$sserial=sprintf("%02d",$serial)
	$date="HTJC-SL".date('Ymd')."-".$sserial;
	$sql="insert into vulns values('".$date."',"."now(),".$serial.",'".$user."','".$site."','".$vname."','".$vdesc."')";
	mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	$html="submit vulns successful!!!";
	*/
}

if(isset($_POST['submit']) && $_POST['submit']=='updata'){
	$date=$_POST['date'];
	$name=$_POST['name'];
	$report=$_POST['report'];
	
	if ($user=="admin"){
		$sql="update report set date='{$date}',name='{$name}',report='{$report}' where name='{$name}' and date='{$date}'";
	}else{
		$sql="update report set report='{$report}' where name='{$user}' and date='{$date}'";
	}
	$result=mysql_query($sql);
	if ($result){
		$html="updata sussfully!!!";
	}
	else{
		$html="updata fail!!!";
	}
}
$readonly=xlabisadmin() ? "" : "readonly=\'readonly\'";
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Report Manage</h1>

	<div class=\"vulnerable_code_area\">

		<h3>Updata Report:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		<tr>
		<td width=\"100\">Date *</td> <td>
		<input name=\"date\" type=\"text\" size=\"50\" {$readonly} value={$date}></td>
		</tr>
		<tr>
		<td width=\"100\">Name *</td> <td>
		<input name=\"name\" type=\"text\" size=\"50\" {$readonly} value={$name}></td>
		</tr>
		<tr>
		<td width=\"100\">Report *</td> <td>
		<textarea name=\"report\" cols=\"60\" rows=\"5\" >{$report}</textarea></td>
		</tr>
		<tr>
		<td width=\"100\">&nbsp;</td>
		<td>
		<input name=\"submit\" type=\"submit\" value=\"updata\" onClick=\"return checkForm();\"></td>
		</tr>
		</table>
		</form>

		{$html}

	</div>
	
</div>
";
dvwaHtmlEcho( $page );

?>
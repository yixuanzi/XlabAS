<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';

if (!xlabIsConfig('backdoor','1')){
	dvwaPageStartup( array( 'authenticated', 'phpids' ) );
}

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'Vulns';
$page[ 'page_id' ] = 'vulns';

if(!dvwaIfWork()){
	exit();
}
dvwaDatabaseConnect();
$user=dvwaCurrentUser();
$html='';
if (isset($_GET['act']) && $_GET['act']=='detail'){
	$vid=xlabGetSqli('vid',$_GET);
	if(xlabIsConfig("ultrav","1")){
		$sql="select vid,site,vname,vdesc,author,risk from vulns where vid='{$vid}'";
	}else{
		if ($user=="admin"){
			$sql="select vid,site,vname,vdesc,author,risk from vulns where vid='{$vid}'";
		}else{
			$sql="select vid,site,vname,vdesc,author,risk from vulns where author='{$user}' and vid='{$vid}'";
		}
	}
	$result = mysql_query($sql);
	$num = mysql_numrows($result);
	dvwadebug($sql);
	if ($num>0){
		$vid=mysql_result($result,0,"vid");
		$site=mysql_result($result,0,"site");
		$vname=mysql_result($result,0,"vname");
		$vdesc=mysql_result($result,0,"vdesc");
		$author=mysql_result($result,0,"author");
		$risk=mysql_result($result,0,"risk");
	}
}

if(isset($_POST['submit']) && $_POST['submit']=='updata'){
	#dvwadebug();
	$vid=xlabGetSqli('vid',$_POST);
	$site=xlabGetSqli('site',$_POST);
	$vname=xlabGetSqli('name',$_POST);
	$vdesc=xlabGetSqli('desc',$_POST);
	$author=xlabGetSqli('author',$_POST);
	$risk=xlabGetSqli('risk',$_POST);
	if ($user=="admin"){
		$sql="update vulns set site='{$site}',vname='{$vname}',vdesc='{$vdesc}',author='{$author}',risk='{$risk}' where vid='{$vid}'";
	}else{
		$sql="select vid from vulns where author='{$user}' and vid='{$vid}'";
		if(mysql_num_rows(mysql_query($sql))<1){
			$html="Can't  access ";
			$sql='';
		}else{
			$sql="update vulns set site='{$site}',vname='{$vname}',vdesc='{$vdesc}',risk='{$risk}' where author='{$user}' and vid='{$vid}'";
		}	
	}
	dvwadebug($sql);
	$result=@mysql_query($sql);
	if ($result){
		$html.="updata sussfully!!!";
	}
	else{
		$html.="updata fail!!!";
	}
}

$readonly=xlabisadmin() ? "" : "readonly=\'readonly\'";
$modifiauthor=xlabisadmin() ? "
		<tr>
		<td width=\"100\">Author *</td> <td>
		<input name=\"author\" type=\"text\" size=\"50\" value={$author}></td>
		</tr>" : "";

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability Manage</h1>

	<div class=\"vulnerable_code_area\">

		<h3>Submit Vulns:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		<tr>
		<td width=\"100\">Vid *</td> <td>
		<input name=\"vid\" type=\"text\" size=\"50\" {$readonly} value={$vid}></td>
		</tr>
		<td width=\"100\">Risk *</td> <td>".
		xlabGetRisklist($risk)."
		{$modifiauthor}
		<tr>
		<td width=\"100\">Name *</td> <td>
		<input name=\"name\" type=\"text\" size=\"50\" value={$vname}></td>
		</tr>
		<tr>
		<td width=\"100\">Site *</td> <td>
		<input name=\"site\" type=\"text\" size=\"50\" value={$site}></td>
		</tr>
		<tr>
		<td width=\"100\">Desc *</td> <td>
		<textarea name=\"desc\" cols=\"50\" rows=\"3\" >{$vdesc}</textarea></td>
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
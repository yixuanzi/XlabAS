<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';
dvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'Vulns';
$page[ 'page_id' ] = 'vulns';

if(!dvwaIfWork()){
	exit();
}
dvwaDatabaseConnect();
$dvwaSession =& dvwaSessionGrab();

function getvulns(){
	
	// Retrieve data
	$user_curr=dvwaCurrentUser();
	$name=mysql_real_escape_string($_POST['name']);
	$key=mysql_real_escape_string($_POST['key']);
	$from=mysql_real_escape_string($_POST['from']);
	$to=mysql_real_escape_string($_POST['to']);
	$risk=xlabGetSqli('risk',$_POST);
	if($name==$key and $key==$from and $form==$to and $to==''){
		$name=$user;
	}
	if(!$from){
		$from='0000-00-00';
	}
	if(!$to){
		$to=date("Y-m-d");
	}
	if($risk=='all'){
		$risk='';
	}

	if ($user=="admin"){
		$name='';
		$sql = "SELECT vid,author,vname,risk FROM vulns where date>='{$from}' and date<='{$to}' and author like '%{$name}%' and site like '%{$key}%' and risk like '%{$risk}%' order by date desc limit 50";
	}else{
		$sql = "SELECT vid,author,vname,risk FROM vulns where date>='{$from}' and date<='{$to}' and author like '%{$name}%' and site like '%{$key}%' and risk like '%{$risk}%' order by date desc limit 50";
	}
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	
	$num = mysql_numrows($result);
	$i = 0;

	while ($i < $num) {
		$risk= mysql_result($result,$i,"risk");
		$vid = mysql_result($result,$i,"vid");
		$author = mysql_result($result,$i,"author");
		$vname = htmlspecialchars(mysql_result($result,$i,"vname"));
		$act = "<a href='vact.php?act=detail&vid={$vid}'>detail </a>
				<a href='?act=delete&vid={$vid}'>delete </a>";
	
		$html .= "</tr><td>{$vid}</td><td>{$author}</td><td>{$vname}</td><td>{$risk}</td><td>{$act}</td></tr>";
		$i++;
	}
	return $html;
}

if(isset($_GET['act']) && $_GET['act']=='delete'){
	#dvwadebug();
	$user=dvwaCurrentUser();
	$vid=mysql_real_escape_string($_GET['vid']);
	if ($user=="admin"){
		$sql = "delete from vulns where vid='{$vid}'";
	}else{
		$sql="select vid from vulns where author='{$user}' and vid='{$vid}'";
		if(mysql_num_rows(mysql_query($sql))<1){
			$html="Can't  access ";
			$sql='';
		}else{
			$sql = "delete from vulns where author='{$user}' and vid='{$vid}'";
		}
	}
	$result=@mysql_query($sql);
	if ($result){
		$html.="delete sussfully!!!";
	}
	else{
		$html.="delete fail!!!";
	}
}

if (isset($_POST['submit'])){
	$vname=xlabGetSqli('name', $_POST);
	$site=xlabGetSqli('site', $_POST);
	$vdesc=xlabGetSqli('desc', $_POST);
	$risk=xlabGetSqli('risk', $_POST);
	$risk=$risk=='all'?'low':$risk;
	if ($vname=='' or $site==''or $vdesc==''){
		$html="submit vulns fail!!!";
		dvwaMessagePush($html);
	}
	else{
	$user=dvwaCurrentUser();
	$result = mysql_query("select serial from vulns where date=date(now()) order by serial desc;");
	$num = mysql_numrows($result);
	if ($num>0){
		$serial=mysql_result($result,0,"serial")+1;
	}
	else{
		$serial=1;
	}
	$sserial=sprintf("%02d",$serial);
	$vid="HTJC-SL".date('Ymd')."-".$sserial;
	if($dvwaSession['config']['vid']=='2' && isset($_POST['vid'])){
		$vid=$_POST['vid'];
	}
	$sql="insert into vulns values('{$vid}',now(),'{$serial}','{$user}','{$site}','{$vname}','{$vdesc}','{$risk}')";
	dvwadebug($sql);
	mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	$html="submit vulns successful!!!";
	}
	dvwaRedirect("{$_DVWA['location']}/vulnerabilities/vulns/");
}

$inputvid="";


if ($dvwaSession['config']['vid']=='2'){
	$inputvid="<td width=\"100\">Vid *</td> <td>
		<input name=\"vid\" type=\"text\" size=\"50\" ></td>
		</tr>";
}


$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Vulnerability Manage</h1>

	<div class=\"vulnerable_code_area\">

		<h3>Submit Vulns:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		{$inputvid}
		<tr>
		<td width=\"100\">Name *</td> <td>
		<input name=\"name\" type=\"text\" size=\"50\" ></td>
		</tr>
		<tr>
		<td width=\"100\">Risk *</td> <td>".
		xlabGetRisklist('low')."
		</td>
		</tr>
		<tr>
		<td width=\"100\">Site *</td> <td>
		<input name=\"site\" type=\"text\" size=\"50\" ></td>
		</tr>
		<tr>
		<td width=\"100\">Desc *</td> <td>
		<textarea name=\"desc\" cols=\"50\" rows=\"3\" ></textarea></td>
		</tr>
		<tr>
		<td width=\"100\">&nbsp;</td>
		<td>
		<input name=\"submit\" type=\"submit\" value=\"Submit Vulns\" onClick=\"return checkForm();\"></td>
		</tr>
		</table>
		</form>
	</div>
	
	<div class=\"vulnerable_code_area\">
	<h3>Yous Vulns:</h3>
	<form action='#' method='POST'>
	Name: <input type=text name=name value='{$name}'>&nbsp;&nbsp;
	SiteKey: <input type=text name=key value='{$key}'></br></br>
	From:<input type=text name=from value='{$from}'>&nbsp;&nbsp;&nbsp;&nbsp;
	TO:<input type=text name=to value='{$to}'></br></br>
	Risk:".xlabGetRisklist()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='Submit' value=\"Search\">
	</form></br>
	<table border=1 width=100%>
	<tr>
	<th>vid</th><th>author</th><th>name</th><th>risk</th><th>action</th>
	</tr>".getvulns()."
	</table>
	</div>
	{$html}
</div>
";


dvwaHtmlEcho( $page );
?>

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




function getreports($pre){
	
	// Retrieve data
	$user=dvwaCurrentUser();
	
	$name=mysql_real_escape_string($_POST['name']);
	$from=mysql_real_escape_string($_POST['from']);
	$to=mysql_real_escape_string($_POST['to']);
	if(!$from){
		$from='0000-00-00';
	}
	if(!$to){
		$to=date("Y-m-d");
	}
	
	if ($user=="admin"){
		$sql = "SELECT * FROM report where date>='{$from}' and date <='{$to}' and name like'{$name}%' order by date desc limit 30";
	}else{
		$sql = "SELECT * FROM report WHERE date>='{$from}' and date <='{$to}' and name='{$user}' order by date desc limit 30";
	}
	#echo $sql;
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );

	$num = mysql_numrows($result);
	$i = 0;

	while ($i < $num) {

		$date = mysql_result($result,$i,"date");
		$name = mysql_result($result,$i,"name");
		$report = htmlspecialchars(mysql_result($result,$i,"report"));
		$act = "<a href='vact.php?act=detail&date={$date}&user={$name}'>detail </a>
				<a href='?act=delete&date={$date}&user={$name}'>delete </a>";
		if (!empty($pre)){
			$html .= "</tr><td>{$date}</td><td>{$name}</td><td><pre>{$report}</pre></td><td>{$act}</td></tr>";
		}else {
			$html .= "</tr><td>{$date}</td><td>{$name}</td><td><h4>{$report}</h4></td><td>{$act}</td></tr>";
		}
		$i++;
	}
	return $html;
}

if(isset($_GET['act']) && $_GET['act']=='delete'){
	#dvwadebug();
	$user=dvwaCurrentUser();
	$date=$_GET['date'];
	$author=$_GET['user'];
	if ($user=="admin"){
		$sql = "delete from report where date='{$date}' and name='{$author}'";
	}else{
		$sql = "delete from report where name='{$user}' and date='{$date}'";
	}
	
	$result=mysql_query($sql);
	if ($result){
		$html="delete sussfully!!!";
	}
	else{
		$html="delete fail!!!";
	}
}

if (isset($_POST['submit'])){
	$report=mysql_real_escape_string($_POST['report']);
	if ($report==''){
		$html="submit report fail!!!";
	}
	else{
	$user=dvwaCurrentUser();
	$sql="insert into report values(now(),'".$user."','".$report."')";
	#echo $sql;
	$result = mysql_query($sql);
	#$num = mysql_numrows($result);
	if ($result>0){
		$html="submit report successful!!!";
	}
	else{
		$html="submit report fail!!!";
	}
	}
}


$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>Work Report</h1>

	<div class=\"vulnerable_code_area\">

		<h3>Submit Report:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		<tr>
		<td width=\"100\">Report *</td> <td>
		<textarea name=\"report\" cols=\"60\" rows=\"5\" ></textarea></td>
		</tr>
		<tr>
		<td width=\"100\">&nbsp;</td>
		<td>
		<input name=\"submit\" type=\"submit\" value=\"Submit Report\" onClick=\"return checkForm();\"></td>
		</tr>
		</table>
		</form>
	</div>
	
	<div  class=\"vulnerable_code_area\">
	<h3>Yous Reports:</h3>
	<form action='#' method='POST'>
	Name: <input type=text name=name value='{$name}'></br></br>
	From:&nbsp; <input type=text name=from value='{$from}'>&nbsp;&nbsp;&nbsp;&nbsp;
	TO:	  <input type=text name=to value='{$to}'>&nbsp;&nbsp;
	<input type='submit' name='Submit' value=\"Search\">
	</form>
	</br>
	<table border=1 width=100%>
	<tr>
	<th>date</th><th>name</th><th>report</th><th>action</th>
	</tr>".getreports(0)."
	</table>
	</div>
	
	{$html}
</div>
";

dvwaHtmlEcho( $page );
?>

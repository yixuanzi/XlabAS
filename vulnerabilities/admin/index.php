<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';
require_once '../ainclude.php';
dvwaPageStartup( array( 'authenticated', 'phpids','admin' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'Admin';
$page[ 'page_id' ] = 'admin';

dvwaDatabaseConnect();
$user=dvwaCurrentUser();
$html='';
$config='';


$sql = "SELECT * FROM config";
$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
$num = mysql_numrows($result);
$i=0;
while ($i < $num) {
    $name=mysql_result($result,$i,"name");
	$value=mysql_result($result,$i,"value");
	$desc=mysql_result($result, $i,"desc");
	$config=$config."<td width=\"100\">{$name} *</td> <td>
		<input name=\"{$name}\" type=\"text\" placeholder=\"{$desc}\" size=\"50\" value=\"{$value}\"></td>
		<td><a href='?name={$name}&submit=del'>Delete</a></td>
		</tr>\n";
    $i++;
} 

if(isset($_REQUEST['submit'])){
	if($_POST['submit']=='updata'){
		foreach($_POST as $name => $value){
			$sql="update config set value=\"{$value}\" where name=\"{$name}\"";
			$result=mysql_query($sql);
			if ($result){
				$html="updata sussfully!!!";
			}
			else{
				$html="updata fail!!!";
			}
		}
	}
	if($_REQUEST['submit']=='del'){
		$name=xlabGetSqli('name', $_GET);
		$sql="delete from config where name=\"{$name}\"";
		echo $sql;
		$result=mysql_query($sql);
		if ($result){
			$html="Delete sussfully!!!";
		}
		else{
			$html="Delete fail!!!";
		}
	}
	if($_POST['submit']=='add'){
		$name=xlabGetSqli('name', $_POST);
		$value=xlabGetSqli('value', $_POST);
		$desc=xlabGetSqli('desc', $_POST);
		$sql="insert into config values ('{$name}','{$value}','{$desc}')";
		$result=mysql_query($sql);
		if ($result){
			$html="Insert sussfully!!!";
		}
		else{
			$html="Insert fail!!!";
		}
	}
	dvwaGetconfig();
	dvwaRedirect("{$_DVWA['location']}/vulnerabilities/admin/");
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>System Manage</h1>

	<div class=\"vulnerable_code_area\">

		<h3>Setting Config:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		<tr>
		<td width=\"100\">Setting </td> 
		<td>Values</td>
		<td>Act</td>
		</tr>
		{$config}
		<tr>
		<td width=\"100\">&nbsp;</td>
		<td>
		<input name=\"submit\" type=\"submit\" value=\"updata\" onClick=\"return checkForm();\"></td>
		</tr>
		</table>
		</form>
	</div>
	
	<div class=\"vulnerable_code_area\">

		<h3>Add Config:</h3>
		<form action=\"#\" method=\"POST\">
		<table width=\"550\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">
		<tr>
		<td width=\"100\">Name *</td> <td>
		<input name=\"name\" type=\"text\" size=\"50\" ></td>
		</tr>
		<tr>
		<td width=\"100\">Value *</td> <td>
		<input name=\"value\" type=\"text\" size=\"50\" ></td>
		</tr>
		<tr>
		<td width=\"100\">Desc *</td> <td>
		<input name=\"desc\" size=60></input></td>
		</tr>
		<tr>
		<td width=\"100\">&nbsp;</td>
		<td>
		<input name=\"submit\" type=\"submit\" value=\"add\" onClick=\"return checkForm();\"></td>
		</tr>
		</table>
		</form>
	</div>
	
	{$html}
</div>
";
dvwaHtmlEcho( $page );

?>
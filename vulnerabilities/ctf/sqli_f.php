<?php	

if (isset($_GET['Submit'])) {
	
	// Retrieve data
	
	$id = $_GET['id'];
	$id=strtolower($id);
	foreach (array(' union ',' select ',' and ',' or ') as $sqlc){
		if(strpos($id,$sqlc)>=1){
			die("Found Sql inject attack,You can get reference info from ctf_5!");
		}	
	}
	$id=str_replace(' union ','',$id);
	$id=str_replace(' select ','',$id);
	$id=str_replace(' and ','',$id);
	$id=str_replace(' or ','',$id);
	

	$getid = "SELECT * FROM flag6 WHERE Id = '$id'";
	$result = mysql_query($getid) or die('<pre>tips:aSBkb24ndCBrbm93KjxfPio=</pre>' ); // Removed 'or die' to suppres mysql errors

	$num = mysql_numrows($result); // The '@' character suppresses errors making the injection 'blind'

	$i = 0;
	if($num<=0){
		$html="have no result!!!";
	}
	$id = mysql_result($result,0,"Id");
	$msg = mysql_result($result,0,"msg");
		
	$html .= '<pre>';
	$html .= 'Id: ' . $id . '<br>msg: ' . $msg; 
	$html .= '</pre>';
}


$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 6';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'sqli';
$page[ 'source_button' ] = 'sqli';

$magicQuotesWarningHtml = '';

// Check if Magic Quotes are on or off
if( ini_get( 'magic_quotes_gpc' ) == true ) {
	$magicQuotesWarningHtml = "	<div class=\"warning\">Magic Quotes are on, you will not be able to inject SQL.</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>挡不住的数据代码</h1>

	{$magicQuotesWarningHtml}

	<div class=\"vulnerable_code_area\">

		<h3>Msg ID:</h3>

		<form action=\"#\" method=\"GET\">
			<input type=\"text\" name=\"id\">
			<input type=\"hidden\" name=\"pid\" value=\"6\">
			<input type=\"submit\" name=\"Submit\" value=\"Submit\">
		</form>

		{$html}

	</div>
</div>
";

?>

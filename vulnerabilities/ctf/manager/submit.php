<?php	

$html="";
if(isset($_POST['Submit'])){
	
	// Retrieve data
	$pid = xlabGetSqli('pid', $_POST);
	$flag=xlabGetSqli('flag', $_POST);
	$user=dvwaCurrentUser();
	$sql = "SELECT * FROM userflag WHERE user = '$user' and pid='$pid' ";
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	if(dvwaisvaildflag($pid,$flag)){
		$str="Correct";
	}else{
		$str="Error";
	}
	$num = mysql_numrows($result);
	
	if($num==0){
		$insert="insert into userflag values('$pid','$user','$flag','$str')";
		$result = mysql_query($insert) or die('<pre>' . mysql_error() . '</pre>' );
		$html="flag is submit succeed";
	}
	else{
		$update="update userflag set flag='$flag',status='$str' where user='$user' and pid='$pid'";
		$result = mysql_query($update) or die('<pre>' . mysql_error() . '</pre>' );
		$html="flag is update succeed";
	}
}

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF Submit Flag';
$page[ 'page_id' ] = 'submit';

$page[ 'help_button' ] = 'submit';
$page[ 'source_button' ] = 'submit';

$magicQuotesWarningHtml = '';

// Check if Magic Quotes are on or off
if( ini_get( 'magic_quotes_gpc' ) == true ) {
	$magicQuotesWarningHtml = "	<div class=\"warning\">Magic Quotes are on, you will not be able to inject SQL.</div>";
}

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>CTF Submit Flag</h1>

	{$magicQuotesWarningHtml}

	<div class=\"vulnerable_code_area\">
	
		<form action=\"\" method=\"POST\">".
		"CTF Number:<br> <br>".dvwaGetlist().
		"<br><br>Input you flag: <br><br>
		<input type=\"text\" size=60 id='flag' name=\"flag\" >
		<br><br>
		<input type=\"submit\" name=\"Submit\" value='Sumbit'>
		</form>
	</div>
	<h3>{$html}</h3>
</div>
";

?>

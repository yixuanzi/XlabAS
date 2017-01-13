<?php	


function getuserranking(){ //group user

	// Retrieve data
	//group

	$sql="SELECT COUNT(*) AS score,USER FROM userflag WHERE STATUS='vaild' OR STATUS='Correct' GROUP BY USER ORDER BY score DESC";

	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );

	$num = mysql_numrows($result);

	$i = 0;

	while ($i < $num) {

		$ranking = $i+1;
		$name = mysql_result($result,$i,"user");
		$score = mysql_result($result,$i,"score");
		$act="<a href=?pid=score&view=$name>View</a>";
		if(xlabisadmin()){
			$act.=" <a href=manager/act.php?del=$name>Del</a>";
		}
		$html .= "</tr><td>{$ranking}</td><td>{$name}</td><td>{$score}</td><td>{$act}</td></tr>";
		$i++;
	}
	return "
	<table border=1 width=100%>
	<tr>
	<th>Ranking</th><th>Name</th><th>Score</th><th>Act</th>
	</tr>
	$html
	</table>";
}

function getuserflag($name){
	$sql="SELECT * FROM userflag WHERE USER='$name' ORDER BY pid";
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	
	$num = mysql_numrows($result);
	
	$i = 0;
	while ($i < $num) {
	
		$pid = mysql_result($result,$i,"pid");
		$user = mysql_result($result,$i,"user");
		$flag = mysql_result($result,$i,"flag");
		$status = mysql_result($result,$i,"status");
		$html .= "</tr><td>{$pid}</td><td>{$user}</td><td>{$flag}</td><td>{$status}</td></tr>";
		$i++;
	}
	return "
	<table border=1 width=100%>
	<tr>
	<th>Pid</th><th>User</th><th>Flag</th><th>Status</th>
	</tr>
	$html
	</table>";
}
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'View Score';
$page[ 'page_id' ] = 'score';

$page[ 'help_button' ] = 'score';
$page[ 'source_button' ] = 'score';

$magicQuotesWarningHtml = '';

// Check if Magic Quotes are on or off
if( ini_get( 'magic_quotes_gpc' ) == true ) {
	$magicQuotesWarningHtml = "	<div class=\"warning\">Magic Quotes are on, you will not be able to inject SQL.</div>";
}
dvwaMessagePush($_GET['msg']);
if(isset($_GET['view'])){
	if($_GET['view']==dvwaGetuser() or xlabisadmin()){
		$table=getuserflag(xlabGetSqli('view', $_GET));
	}
}else{
	$table=getuserranking();
}
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>View Score</h1>

	{$magicQuotesWarningHtml}

	<div >
	$table
	</div>
</div>
";


?>

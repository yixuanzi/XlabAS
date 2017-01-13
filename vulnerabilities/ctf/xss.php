<?php
if(!isset($_GET['pict'])){
	dvwaRedirect("{$_DVWA['location']}/vulnerabilities/ctf/?pid=4&pict=hunter");
}
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF Question 4';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'sqli';
$page[ 'source_button' ] = 'sqli';
$pict=strtolower($_GET['pict']);
$pict=str_replace("script",'*',$pict);
if(ereg("\" +onerror *= *alert\(document\.cookie\)[>| +.*]", $pict)){
	require_once '../../hackable/ctf/ctf.php';
	$html=xlabGetJs("alert('{$FLAG['xss']}')");
}
$magicQuotesWarningHtml = '';
//
$location=xlabGetLocation();
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>窃贼的密码</h1>
	<ul>
	<img src=\"../../hackable/ctf/q4/{$pict}.jpg\"></img>
	</ul>
	</br>
	<h3>
	<li>You Should Steal The Cookie</li>
	</h3>
$html
</div>
";

?>
<?php 
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 10';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'brute';
$page[ 'source_button' ] = 'brute';

if(isset($_POST['submit']) and $_POST['submit']=='Login'){
	if(!xlabautocode()){
		dvwaRedirect("./?pid=10&msg=check code error");
	}
	if($_REQUEST['username']!='super'){
		dvwaRedirect("./?pid=10&msg=uname error");
	}
	if($_REQUEST['password']!='1234qwer'){
		dvwaRedirect("./?pid=10&msg=passwd error");
	}
	require_once '../../hackable/ctf/ctf.php';
	$_GET['msg']=$FLAG['brute'];
}
dvwaMessagePush(xlabGetXss('msg', $_GET));
$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>一力降十会</h1>
	<div class=\"vulnerable_code_area\">
	<form action=\"#\" method=\"POST\">
	<label >Username:</label>
	<input type=\"text\"  name=\"username\"></br></br>
    <label >Password:</label>
    <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password\"><br></br>
    <label >Authcode:</label>
    <input type=\"text\"  name=\"authcode\"><br></br>
    <img onclick=newRandImg(); id='randImg' src=../checkcode.php><a<br></br>
    <input type=\"submit\" value=\"Login\" name=\"submit\" onclick='return checkvaild()'>
    </form>
	</div>
$html
<script>
	function newRandImg(){
		var rm= new Date().getTime();
	    document.getElementById('randImg').src='../checkcode.php?rm='+rm;
	    document.getElementById('randImg').style.display='inline';
	}
</script>
</div>
";

?>
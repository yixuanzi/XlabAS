<?php
			
	if (isset($_POST['Change'])) {
	
		$dvwaSession =& dvwaSessionGrab();
		
		$user=$dvwaSession['username'] ;
		
		if($_POST['Change']=='check'){
	
			$pass = stripslashes( $_POST['password_current']);
			$pass = mysql_real_escape_string( $pass );
			$pass = md5( $pass );

			$qry = "SELECT * FROM `users` WHERE user='$user' AND password='$pass';";

			$result = @mysql_query($qry) or die('<pre>' . mysql_error() . '</pre>' );

			if( $result && mysql_num_rows( $result ) >= 1 ) {	// Login Successful...
				echo "true";
			}else{
				echo "false";
			}
			exit();
		}
		// Checks the http referer header
		if (strpos($_SERVER['HTTP_REFERER'],"127.0.0.1")!== false && $_POST['Change']=='Change'){
	
			// Turn requests into variables
			$pass_new = $_POST['password_new'];
			$pass_conf = $_POST['password_conf'];
			
			if ($pass_new == $pass_conf){
				$pass_new = mysql_real_escape_string($pass_new);
				$pass_new = md5($pass_new);

				$insert="UPDATE `users` SET password = '$pass_new' WHERE user = '$user';";
				$result=mysql_query($insert) or die('<pre>' . mysql_error() . '</pre>' );
				require_once '../../hackable/ctf/ctf.php';
				$html .= "<pre> Password Changed </br> {$FLAG['chpwd']} </pre>";		
				mysql_close();
			}
	
			else{		
				$html .= "<pre> Passwords did not match. </pre>";			
			}	

		}
		
	}

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 9';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'chpwd';
$page[ 'source_button' ] = 'chpwd';

$page[ 'body' ] .= "
<script  src='../../vulnerabilities/ctf/js/pwdc.js' type='text/javascript' charset='utf-8'></script>
<script  src='../../vulnerabilities/ctf/js/test.js' type='text/javascript' charset='utf-8'></script>
<div class=\"body_padded\">
	<h1>妄想症</h1>

	<div class=\"vulnerable_code_area\">
	
	<h3>Change your password:</br></br>只能本地修改密码-127.0.0.1</h3>
    <br>
    <form action=\"#\" method=\"POST\">";
	
	$page[ 'body' ] .= "Current password:<br>
	<input type=\"password\" AUTOCOMPLETE=\"off\" id='oldpwd' name=\"password_current\" onblur='checkoldpwd()'><br>";

    
$page[ 'body' ] .= "    New password:<br>
    <input type=\"password\" AUTOCOMPLETE=\"off\" id='newpwd_1' name=\"password_new\"><br>
    Confirm new password: <br>
    <input type=\"password\" AUTOCOMPLETE=\"off\" id='newpwd_2' name=\"password_conf\">
    <br>
    <input type=\"submit\" value=\"Change\" name=\"Change\" onclick='return checkvaild()'>
    </form>
	
	{$html}

	</div>
</div>
";

?>
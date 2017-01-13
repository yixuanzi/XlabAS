<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '' );

require_once DVWA_WEB_PAGE_TO_ROOT.'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'phpids' ) );

dvwaDatabaseConnect();
dvwaGetconfig();
#dvwadebug();
if( isset( $_POST[ 'Login' ] ) ) {


	$user = $_POST[ 'username' ];
	$user = stripslashes( $user );
	if(!xlabIsConfig('loginsqli', '1')){
		$user = mysql_real_escape_string( $user );
	}
	$pass = $_POST[ 'password' ];
	$pass = stripslashes( $pass );
	$pass = mysql_real_escape_string( $pass );
	$pass_md5 = md5( $pass );
	$qry_md5 = "SELECT * FROM `users` WHERE user='$user' AND password='$pass_md5';";
	$result_md5 = @mysql_query($qry_md5) or die('<pre>' . mysql_error() . '</pre>' );
	dvwadebug($qry_md5);
	if( ($result_md5 && mysql_num_rows($result_md5) >= 1) /*||  ($result && mysql_num_rows($result) >= 1)*/ ) {	// Login Successful...
		
		$user= mysql_result($result_md5,0,"user");
		if(mysql_num_rows($result_md5)>1 and $user=='admin'){
			dvwaMessagePush("You can't login for admin use sql inject vuln");
			dvwaRedirect( 'index.php' );
			exit(1);
		}
		dvwaMessagePush( "You have logged in as '".$user."'" );
		dvwaLogin( $user );
		dvwaRedirect( 'index.php' );

	}

	// Login failed
	dvwaMessagePush( "Login failed" );
	dvwaRedirect( 'login.php' );
}

$messagesHtml = messagesPopAllToHtml();

Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

echo "

<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>

		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>XLABAS - Login</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/css/login.css\" />

	</head>

	<body>

	<div align=\"center\">
	
	<br />

	<p><img src=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/images/login_logo.png\" /></p>

	<br />
	
	<form action=\"login.php\" method=\"post\">
	
	<fieldset>

			<label for=\"user\">Username</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />
	
			
			<label for=\"pass\">Password</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />
			
			
			<p class=\"submit\"><input type=\"submit\" value=\"Login\" name=\"Login\"></p>

	</fieldset>

	</form>

	
	<br />

	{$messagesHtml}

	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />	

	<!-- <img src=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/images/RandomStorm.png\" /> -->
	
	<p>Damn HTJC SeclabX ASystem (XlabAS)  is a RandomStorm OpenSource project</p>
	
	</div> <!-- end align div -->

	</body>

</html>
";

?>

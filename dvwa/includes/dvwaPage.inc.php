<?php

if( !defined( 'DVWA_WEB_PAGE_TO_ROOT' ) ) {

	define( 'DVWA System error- WEB_PAGE_TO_ROOT undefined' );
	exit;

}


session_start(); // Creates a 'Full Path Disclosure' vuln.
// Include configs
require_once DVWA_WEB_PAGE_TO_ROOT.'config/config.inc.php';
require_once DVWA_WEB_PAGE_TO_ROOT.'config/config.ctf.php';
require_once( 'dvwaPhpIds.inc.php' );
xlabInit();
dvwadebug();
// Declare the $html variable
if(!isset($html)){

	$html = "";

}

// DVWA version
function dvwaVersionGet() {

	return '2.7';

}

// DVWA release date
function dvwaReleaseDateGet() {

	return '12/1/2016';

}


// Start session functions -- 

function &dvwaSessionGrab() {

	if( !isset( $_SESSION[ 'dvwa' ] ) ) {

		$_SESSION[ 'dvwa' ] = array();

	}

	return $_SESSION[ 'dvwa' ];
}

function dvwaCtfSet(){

	$dvwaSession=& dvwaSessionGrab();
	
	$dvwaSession['ctf']=1;
}

function dvwaCtfUnSet(){

	$dvwaSession=& dvwaSessionGrab();
	
	unset($dvwaSession['ctf']);
}

function dvwaIsCtf(){

	$dvwaSession =& dvwaSessionGrab();
	
	return isset( $dvwaSession['ctf'] );
}

function dvwaIfWork(){

	$dvwaSession =& dvwaSessionGrab();
	if(in_array($dvwaSession['config']['model'],array('3','4'))){
		return true;
	}
}
function dvwaIfCtf(){

	$dvwaSession =& dvwaSessionGrab();
	if(in_array($dvwaSession['config']['model'],array('2','4'))){
		return true;
	}
}
function dvwaIfAll(){
	$dvwaSession =& dvwaSessionGrab();
	if(in_array($dvwaSession['config']['model'],array('4'))){
		return true;
	}
}

function dvwaGetModel(){
	$modellist=array();
	$modellist['1']="Stduy";
	$modellist['2']='CTF';
	$modellist['3']="Work";
	$modellist['4']='ALL';
	$dvwaSession =& dvwaSessionGrab();
	return $modellist[$dvwaSession['config']['model']];
}

function dvwaPageStartup( $pActions ) {

	if( in_array( 'authenticated', $pActions ) ) {
		

		if( !dvwaIsLoggedIn()){

			dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT.'login.php' );

		}
	}

	if( in_array( 'phpids', $pActions ) ) {

		if( dvwaPhpIdsIsEnabled() ) {

			dvwaPhpIdsTrap();

		}
	}
	
	if(in_array('admin', $pActions)){
		
		if(!xlabisadmin()){
			dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT.'login.php');
		}
	}

	$setuser=xlabGetSqli('setuser',$_REQUEST);
	
	if (dvwaGetuser()=="admin" && (!empty($setuser))){
		
		$dvwasession =& dvwaSessionGrab();
		
		$dvwasession['username']=$setuser;
	}
}


function dvwaPhpIdsEnabledSet( $pEnabled ) {

	$dvwaSession =& dvwaSessionGrab();

	if( $pEnabled ) {

		$dvwaSession[ 'php_ids' ] = 'enabled';

	} else {

		unset( $dvwaSession[ 'php_ids' ] );

	}
}


function dvwaPhpIdsIsEnabled() {

	$dvwaSession =& dvwaSessionGrab();

	return isset( $dvwaSession[ 'php_ids' ] );

}


function dvwaLogin( $pUsername ) {

	$dvwaSession =& dvwaSessionGrab();

	$dvwaSession['username'] = $pUsername;

}


function dvwaIsLoggedIn() {

	$dvwaSession =& dvwaSessionGrab();

	return isset( $dvwaSession['username'] );

}

function dvwaGetuser(){

	$dvwaSession =& dvwaSessionGrab();

	return  $dvwaSession['username'];
}

function dvwaLogout() {

	$dvwaSession =& dvwaSessionGrab();

	unset( $dvwaSession['username'] );

}


function dvwaPageReload() {

	dvwaRedirect( $_SERVER[ 'PHP_SELF' ] );

}

function dvwaCurrentUser() {

	$dvwaSession =& dvwaSessionGrab();

	return ( isset( $dvwaSession['username']) ? $dvwaSession['username'] : '') ;

}

// -- END

function &dvwaPageNewGrab() {

	$returnArray = array(
		'title' => 'HTJC SeclabX ASystem (XlabAS)  v'.dvwaVersionGet().'',
		'title_separator' => ' :: ',
		'body' => '',
		'page_id' => '',
		'help_button' => '',
		'source_button' => '',
	);

	return $returnArray;
}


function dvwaSecurityLevelGet() {

	return xlabGetSecurity();

}



function dvwaSecurityLevelSet( $pSecurityLevel ) {

	xlabSetSecurity($pSecurityLevel);

}



// Start message functions -- 
function dvwaMessagePush( $pMessage ) {

	$dvwaSession =& dvwaSessionGrab();

	if( !isset( $dvwaSession[ 'messages' ] ) ) {

		$dvwaSession[ 'messages' ] = array();

	}

	$dvwaSession[ 'messages' ][] = $pMessage;
}



function dvwaMessagePop() {

	$dvwaSession =& dvwaSessionGrab();

	if( !isset( $dvwaSession[ 'messages' ] ) || count( $dvwaSession[ 'messages' ] ) == 0 ) {

		return false;

	}

	return array_shift( $dvwaSession[ 'messages' ] );
}


function messagesPopAllToHtml() {

	$messagesHtml = '';

	while( $message = dvwaMessagePop() ) {	// TODO- sharpen!

		$messagesHtml .= "<div class=\"message\">{$message}</div>";

	}

	return $messagesHtml;
}
// --END

function dvwaHtmlEcho( $pPage ) {

	$menuBlocks = array();

	$menuBlocks['home'] = array();
	$menuBlocks['home'][] = array( 'id' => 'home', 'name' => 'Home', 'url' => '.' );
	$menuBlocks['home'][] = array( 'id' => 'instructions', 'name' => 'Instructions', 'url' => 'instructions.php' );
	

	$menuBlocks['vulnerabilities'] = array();
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'brute', 'name' => 'Brute Force', 'url' => 'vulnerabilities/brute/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'exec', 'name' => 'Command Execution', 'url' => 'vulnerabilities/exec/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'csrf', 'name' => 'CSRF', 'url' => 'vulnerabilities/csrf/.' );
	#$menuBlocks['vulnerabilities'][] = array( 'id' => 'captcha', 'name' => 'Insecure CAPTCHA', 'url' => 'vulnerabilities/captcha/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'fi', 'name' => 'File Inclusion', 'url' => 'vulnerabilities/fi/.?page=include.php' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'sqli', 'name' => 'SQL Injection', 'url' => 'vulnerabilities/sqli/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'sqli_blind', 'name' => 'SQL Injection (Blind)', 'url' => 'vulnerabilities/sqli_blind/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'upload', 'name' => 'Upload', 'url' => 'vulnerabilities/upload/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'xss_r', 'name' => 'XSS reflected', 'url' => 'vulnerabilities/xss_r/.' );
	$menuBlocks['vulnerabilities'][] = array( 'id' => 'xss_s', 'name' => 'XSS stored', 'url' => 'vulnerabilities/xss_s/.' );
	
	if(dvwaIfWork()){
		$menuBlocks['vulnerabilities'][] = array( 'id' => 'vulns', 'name' => 'Vulns', 'url' => 'vulnerabilities/vulns/.' );
		$menuBlocks['vulnerabilities'][] = array( 'id' => 'work', 'name' => 'Work', 'url' => 'vulnerabilities/work/.' );
	}
	if(dvwaIsCtf()){
		$menuBlocks['vulnerabilities'][] = array( 'id' => 'ctf', 'name' => 'CTF', 'url' => 'vulnerabilities/ctf/?pid=1' );
		$menuBlocks['vulnerabilities'][] = array( 'id' => 'submit', 'name' => 'Submit', 'url' => 'vulnerabilities/ctf/?pid=submit' );
		$menuBlocks['vulnerabilities'][] = array( 'id' => 'score', 'name' => 'Score', 'url' => 'vulnerabilities/ctf/?pid=score&name='.dvwaCurrentUser());
	}

	if(xlabisadmin()){
		$menuBlocks['home'][] = array( 'id' => 'setup', 'name' => 'Setup', 'url' => 'setup.php' );
		$menuBlocks['home'][] = array( 'id' => 'admin', 'name' => 'Admin', 'url' => 'vulnerabilities/admin/.' );
		$menuBlocks['home'][] = array( 'id' => 'manager', 'name' => 'Manager', 'url' => 'vulnerabilities/admin/manager.php' );
	}
	$menuBlocks['meta'] = array();
	$menuBlocks['meta'][] = array( 'id' => 'security', 'name' => 'DVWA Security', 'url' => 'security.php' );
	$menuBlocks['meta'][] = array( 'id' => 'phpinfo', 'name' => 'PHP Info', 'url' => 'phpinfo.php' );
	$menuBlocks['meta'][] = array( 'id' => 'about', 'name' => 'About', 'url' => 'about.php' );

	$menuBlocks['logout'] = array();
	$menuBlocks['logout'][] = array( 'id' => 'logout', 'name' => 'Logout', 'url' => 'logout.php' );

	$menuHtml = '';

	foreach( $menuBlocks as $menuBlock ) {

		$menuBlockHtml = '';

		foreach( $menuBlock as $menuItem ) {

			$selectedClass = ( $menuItem[ 'id' ] == $pPage[ 'page_id' ] ) ? 'selected' : '';

			$fixedUrl = DVWA_WEB_PAGE_TO_ROOT.$menuItem['url'];

			$menuBlockHtml .= "<li onclick=\"window.location='{$fixedUrl}'\" class=\"{$selectedClass}\"><a href=\"{$fixedUrl}\">{$menuItem['name']}</a></li>";

		}

		$menuHtml .= "<ul>{$menuBlockHtml}</ul>";
	}

	
	// Get security cookie --
	$securityLevelHtml = dvwaIsCtf() ? 'CTF': dvwaSecurityLevelGet();

	// -- END
	
	$phpIdsHtml = '<b>PHPIDS:</b> '.( dvwaPhpIdsIsEnabled() ? 'enabled' : 'disabled' );

	$userInfoHtml = '<b>Username:</b> '.( dvwaCurrentUser() );
	
	$AppModel='<b>AppModel:</b> '.( dvwaGetModel());
	$messagesHtml = messagesPopAllToHtml();

	if( $messagesHtml ) {

		$messagesHtml = "<div class=\"body_padded\">{$messagesHtml}</div>";

	}
	
	$systemInfoHtml = "<div align=\"left\">{$userInfoHtml}<br />{$AppModel}<br /><b>Security Level:</b> {$securityLevelHtml}<br />{$phpIdsHtml}</div>";

	if( $pPage[ 'source_button' ] && (!dvwaIsCtf())) {

		$systemInfoHtml = dvwaButtonSourceHtmlGet( $pPage[ 'source_button' ] )." $systemInfoHtml";

	}

	if( $pPage[ 'help_button' ] && (!dvwaIsCtf())) {

		$systemInfoHtml = dvwaButtonHelpHtmlGet( $pPage[ 'help_button' ] )." $systemInfoHtml";

	}
	


	if(dvwaIsCtf()){
		$addr=xlabGetLocation();
		$systemInfoHtml="<label for=\"QNUM\">CTF Numbers:</label><form action=\"{$addr}/vulnerabilities/ctf/\" method=\"GET\">".dvwaGetlist().
		"<input type=\"submit\" name=\"select\" value='select'>
		</form>"."$systemInfoHtml";
		$value=(isset($_GET['pid']) and is_numeric($_GET['pid'])) ? $_GET['pid'] : '1';
		$ctfselect=xlabGetJs(xlabJqSelect("ctf_select",$value));
		#$ctfselect="<script>document.getElementById('ctf_select').options[5].setAttribute('selected', 'selected');</script>";
	}
	// Send Headers + main HTML code
	Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
	Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
	Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

	echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>{$pPage['title']}</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/css/main.css\" />

		<link rel=\"icon\" type=\"\image/ico\" href=\"".DVWA_WEB_PAGE_TO_ROOT."favicon.ico\" />

		<script type=\"text/javascript\" src=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/js/dvwaPage.js\"></script>

	</head>

	<body class=\"home\">
		<div id=\"container\">

			<div id=\"header\">

				<img src=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/images/logo.png\" alt=\"Damn Vulnerable Web App\" />

			</div>

			<div id=\"main_menu\">

				<div id=\"main_menu_padded\">
				{$menuHtml}
				</div>

			</div>

			<div id=\"main_body\">
				<script  src='../../dvwa/js/jquery.js' type='text/javascript' charset='utf-8'></script>
				{$pPage['body']}
			
				<br />
				<br />
				{$messagesHtml}

			</div>

			<div class=\"clear\">
			</div>

			<div id=\"system_info\">
				{$systemInfoHtml}
			</div>

			<div id=\"footer\">
				{$ctfselect}
				<p>HTJC SeclabX ASystem (XlabAS)  v".dvwaVersionGet()."</p>

			</div>

		</div>

	</body>

</html>";
}


function dvwaHelpHtmlEcho( $pPage ) {
	// Send Headers
	Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
	Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
	Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

	echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>

		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>{$pPage['title']}</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/css/help.css\" />

		<link rel=\"icon\" type=\"\image/ico\" href=\"".DVWA_WEB_PAGE_TO_ROOT."favicon.ico\" />

	</head>

	<body>
	
	<div id=\"container\">

			{$pPage['body']}

		</div>

	</body>

</html>";
}


function dvwaSourceHtmlEcho( $pPage ) {
	// Send Headers
	Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
	Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
	Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

	echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>

		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>{$pPage['title']}</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".DVWA_WEB_PAGE_TO_ROOT."dvwa/css/source.css\" />

		<link rel=\"icon\" type=\"\image/ico\" href=\"".DVWA_WEB_PAGE_TO_ROOT."favicon.ico\" />

	</head>

	<body>

		<div id=\"container\">

			{$pPage['body']}

		</div>

	</body>

</html>";
}

// To be used on all external links --
function dvwaExternalLinkUrlGet( $pLink,$text=null ) {

	if (is_null($text)){

		return '<a href="http://hiderefer.com/?'.$pLink.'" target="_blank">'.$pLink.'</a>';

	}

	else {

		return '<a href="http://hiderefer.com/?'.$pLink.'" target="_blank">'.$text.'</a>';

	}
}
// -- END

function dvwaButtonHelpHtmlGet( $pId ) {

	$security = dvwaSecurityLevelGet();

	return "<input type=\"button\" value=\"View Help\" class=\"popup_button\" onClick=\"javascript:popUp( '".DVWA_WEB_PAGE_TO_ROOT."vulnerabilities/view_help.php?id={$pId}&security={$security}' )\">";

}


function dvwaButtonSourceHtmlGet( $pId ) {

	$security = dvwaSecurityLevelGet();

	return "<input type=\"button\" value=\"View Source\" class=\"popup_button\" onClick=\"javascript:popUp( '".DVWA_WEB_PAGE_TO_ROOT."vulnerabilities/view_source.php?id={$pId}&security={$security}' )\">";

}

// Database Management --

if ($DBMS == 'MySQL') {

 $DBMS = htmlspecialchars(strip_tags($DBMS));

 $DBMS_errorFunc = 'mysql_error()';

}
elseif ($DBMS == 'PGSQL') {

 $DBMS = htmlspecialchars(strip_tags($DBMS));

 $DBMS_errorFunc = 'pg_last_error()';

}
else {

 $DBMS = "No DBMS selected.";

 $DBMS_errorFunc = '';

}

$DBMS_connError = '<div align="center">
		<img src="'.DVWA_WEB_PAGE_TO_ROOT.'dvwa/images/logo.png">
		<pre>Unable to connect to the database.<br>'.$DBMS_errorFunc.'<br /><br /></pre>
		Click <a href="'.DVWA_WEB_PAGE_TO_ROOT.'setup.php">here</a> to setup the database.
		</div>';

function dvwaDatabaseConnect() {

	global $_DVWA;
	global $DBMS;
	global $DBMS_connError;

	if ($DBMS == 'MySQL') {

		if( !@mysql_connect( $_DVWA[ 'db_server' ], $_DVWA[ 'db_user' ], $_DVWA[ 'db_password' ] )
		|| !@mysql_select_db( $_DVWA[ 'db_database' ] ) ) {
			die( $DBMS_connError );
		}

	}
	
	elseif ($DBMS == 'PGSQL') {

		$dbconn = pg_connect("host=".$_DVWA[ 'db_server' ]." dbname=".$_DVWA[ 'db_database' ]." user=".$_DVWA[ 'db_user' ]." password=".$_DVWA[ 'db_password' ])
		or die( $DBMS_connError );

	}
}
function dvwaDatabaseConnect_ctf($ctfuser) {

	global $_DVWA;
	global $DBMS;
	global $DBMS_connError;

	if ($DBMS == 'MySQL') {
		if( !mysql_connect( $_DVWA[ 'db_server' ], $ctfuser, $_DVWA[ 'ctf_password' ] )
		|| !mysql_select_db( $_DVWA[ 'db_database' ] ) ) {
			die( $DBMS_connError );
		}

	}
	
	elseif ($DBMS == 'PGSQL') {

		$dbconn = pg_connect("host=".$_DVWA[ 'db_server' ]." dbname=".$_DVWA[ 'db_database' ]." user=".$ctfuser." password=".$_DVWA[ 'ctf_password' ])
		or die( $DBMS_connError );

	}
}

// -- END


function dvwaRedirect( $pLocation ) {

	session_commit();
	header( "Location: {$pLocation}" );
	exit;

}

// XSS Stored guestbook function --
function dvwaGuestbook(){

	$query  = "SELECT name, comment FROM guestbook";
	$result = mysql_query($query);

	$guestbook = '';
	
	while($row = mysql_fetch_row($result)){	
		if (dvwaSecurityLevelGet() == 'high' || dvwaIsCtf() || dvwaIfWork()){

			$name    = htmlspecialchars($row[0]);
			$comment = htmlspecialchars($row[1]);
	
		}

		else {

			$name    = $row[0];
			$comment = $row[1];

		}
		
		$guestbook .= "<div id=\"guestbook_comments\">Name: {$name} <br />" . "Message: {$comment} <br /></div>";
	} 
	
return $guestbook;
}
// -- END

function dvwaprint($var,$prefix=NULL){
	if (!empty($prefix)){
		dvwaprint($prefix);
	}
	print_r($var);
	echo "<br>";
}
function dvwadebug($str=NULL){
	global $disabledebug;
	if(isset($disabledebug) and $disabledebug==1){
		return ;
	}
	global $_DVWA;
	if(xlabIsDebug()){
		if(empty($str)){
			dvwaprint($_REQUEST,"REQUEST:");
			dvwaprint($_SESSION,"SESSION:");
			dvwaprint($_DVWA,"DVWA:");
		}else {
			dvwaprint($str);
		}
	}
}

function dvwaGetlist($len=NULL){
	global $_CTF;
	$len=empty($len)?count($_CTF['map']):$len;
	$s="<select  id='ctf_select' style='width:60px' class='selector' name=\"pid\">";
	for($i=1;$i<=$len;$i++){
		$s=$s."<option value=$i>$i</option>";
	}
	$s=$s."</select>";
	return $s;
}

function dvwaRisklist(){
	$s="<select  name=\"risk\">";
	$s=$s."<option value=low>low</option>";


	$s=$s."</select>";

	return $s;
}

function dvwaisvaildflag($pid,$flag){
	$sql = "SELECT flag FROM flag WHERE  pid='$pid' ";
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	$num = mysql_numrows($result);
	if($num>0){
		$vaild_flag = mysql_result($result,0,"flag");
		return $vaild_flag==$flag;
	}
	return false;
}

function dvwaGetconfig(){
	$sql = "SELECT name,value FROM config";
	$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
	$num = mysql_numrows($result);
	$i=0;
	$dvwaSession=& dvwaSessionGrab();
	$dvwaSession['config']=array();
	while ($i < $num) {
        $dvwaSession['config'][mysql_result($result,$i,"name")]=mysql_result($result,$i,"value");
        $i++;
    } 
}

function xlabGetSqli($name,$space){
	if (isset($space[$name])){
		$var=$space[$name];
		$var = stripslashes($var);
		$var=mysql_escape_string($var);
		return $var;
	}
	return NULL;
}

function xlabGetXss($name,$space){
	if (isset($space[$name])){
		$message = $space[$name];
		$message = stripslashes($message);
		$message = mysql_escape_string($message);
		$message = htmlspecialchars($message);
		return $message;
	}
	return NULL;
}

function xlabisadmin(){
	if ($_SESSION['dvwa']['username']=='admin'){
		return true;
	}
	return false;
}

function xlabIsDebug(){
	if (isset($_SESSION['dvwa']['config']['debug']) and $_SESSION['dvwa']['config']['debug']=='1'){
		if(isset($_SESSION['dvwa']['config']['adminlog'])){
			if($_SESSION['dvwa']['config']['adminlog']=='1' and xlabisadmin()){
				return true;
			}else {
				return false;
			}	
		}else{
			return true;
		}
	}
	return false;
}

function xlabIsLinux(){
	if(PHP_OS=='WINNT' or PHP_OS=='WIN32'){
		return false;
	}
	return true;
}
function xlabGetLocation(){
	if(xlabIsConfig('host',$_SERVER['HTTP_HOST'])){
		return "";
	}
	$proot=dirname(dirname(dirname(__FILE__)));
	if(xlabIsLinux()){
		return  '/'.end(explode('/', $proot));
	}else {
		return  '/'.end(explode('\\', $proot));
	}
}

function xlabIsConfig($name,$value){
	if (isset($_SESSION['dvwa']['config'][$name]) and $_SESSION['dvwa']['config'][$name]==$value){
		return true;
	}
	return false;
}

function xlabIsNonsec(){
	$accesscode=isset($_SERVER['X-Forwarded-For'])?$_SERVER['X-Forwarded-For']:"";
	return xlabIsConfig("nonsec", $accesscode)?true:false;
}

function xlabGetRisklist($index='all'){
	$slow=$index=='low'?"selected = 'selected'":'';
	$smedimu=$index=='medium'?"selected = 'selected'":'';
	$shigh=$index=='high'?"selected = 'selected'":'';
	$sall=$index=='all'?"selected = 'selected'":'';
	return "<select name='risk' value={$index}>
			<option value='low' {$slow}>low</option>
			<option value='medium' {$smedimu}>medium</option>
			<option value='high' {$shigh}>high</option>
			<option value='all' {$sall}>---</option>
			</select>";
}

function xlabJqSelect($key,$value='1'){
	#return  "$(\"#{$key} option[text='{$value}']\").attr('selected',true);";
	#return "$(\".{$key}\").find(\"option[text='{$value}']\").attr(\"selected\",true);";
	$index=(int)$value-1;
	return "document.getElementById('{$key}').options[{$index}].setAttribute('selected','selected');";
	
}

function xlabGetJs($js){
	return "<script type='text/javascript' charset='utf-8'>{$js}</script>";
}


function xlabInit(){
	global $_DVWA;
	$session=& dvwaSessionGrab();
	isset($session['security'])?NULL:xlabSetSecurity();
	$security_levels = array('low', 'medium', 'high','ctf');
	isset($_DVWA['location'])?NULL:$_DVWA['location']=xlabGetLocation();
	empty($_DVWA[ 'db_server' ])?$_DVWA[ 'db_server' ]='localhost':NULL;
	empty($_DVWA[ 'db_password' ])?$_DVWA[ 'db_password' ]='864804336':NULL;
	empty($_DVWA['ctf_password'])?$_DVWA['ctf_password']='1234qwer':NULL;
}
function xlabSetSecurity($risk='high'){

	$session=& dvwaSessionGrab();
	switch ($risk){
		case 'high':
			$session['security']='high';
			break;
		case 'medium':
			$session['security']='medium';
			break;
		case 'low':
			$session['security']='low';
			break;
		case 'ctf':
			$session['security']='ctf';
			break;
		default:
			$session['security']='high';
	}
}

function xlabGetSecurity(){
	$session=& dvwaSessionGrab();
	return isset($session['security'])?$session['security']:NULL;
}

function xlabGetHtmlAnnotation($str){
	return "<!-- {$str} -->";
}

function xlabautocode(){
	$code=xlabGetSqli('authcode', $_REQUEST);
	$session=& dvwaSessionGrab();
	if(isset($session['authcode']) and (!empty($session['authcode'])) and strcasecmp($session['authcode'],$code)==0){
		return true;
	}
	return false;
}
?>

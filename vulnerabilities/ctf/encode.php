<?php
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 1';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'sqli';
$page[ 'source_button' ] = 'sqli';

$magicQuotesWarningHtml = '';


$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>数据的本质</h1>
	<h4>
	<ul>
	<li>TnpsRk5qZzRPVEUyTkVVMk9UaEJSamM1UlRkQ1FqbEVOakpGTmpsRE9VSTNPVVUzT1VFNE5EWTFSVFU0</li>
	<li>T0RnMk56WkZOVGc1UWpJMk1rVTNRa0ZDUmpjM1JUVTRSVUpDTnpWRk5qaEZPRGsyTmtVMFFqaEJSRGN3</li>
	<li>UlRZNU5qZzNOa0ZGTlVGRU9UYzJRMFUzUVVOQk5qWTNSVFZDTUVJeE56ZEZOams0UVVZMk9FVTNRVVE1</li>
	<li>TkRZM1JUWkJNVGc0TmpKRk5qazRPRVUzTmtVM09UbENSRFpFUlRVNU1EazNOalkzTURjek5rTTJRVGMwT</li>
	<li>nprMlJEWTJOemcyUmc9PQ==</li>
	</ul>
	<h4>
</div>
";



?>

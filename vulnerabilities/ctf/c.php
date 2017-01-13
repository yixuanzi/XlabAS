<?php
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 2';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'sqli';
$page[ 'source_button' ] = 'sqli';

$magicQuotesWarningHtml = '';


$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>编程的艺术</h1>
	<h3>flag就随机分布在如下的字典中，他们的位置是每16个字符的和与512的余数<h3>
	<h3>flag第二位的位置就是字典中第17个到32个字符的和与512的余数<h3>
	<h3>用任何你可以想到的方法获取到flag吧！！！</h3>
	<center>
	<pre>
mghiovaonyjfjpngtzzlxjzckkiiaknx
hcctqcqyopmcmleaeojbcdopqjbiofwm
lkfawjvyybxwxjqvcetmjxupmstqhjvo
mpiiecjobmzqgzjoegwftrpndcmfuevc
hbtkqiqqesgzcegudjxeyljtxzmiducl
ztxjmdzheizktocdoobvywbfwjpzkqpo
vvogvffsmakpvtspaxonjliexyzplmfg
ykkolbojtbhedrztkosrgganqxpcgluy
kioxkkcjljlqlaikzqbdlbbmxzliaqny
qbvpniygugcrrjfmdtyawrybtzxmrbqq
mbytbqroihkjjibshavkiwgumkcwnqgi
jctdhkgehbjyjplgyiqflfjktkbhwgpe
xlleucthhdjkvufsqygsshpwjacbgfli
tqteuddmddousbcnzsisoyeednvwveqa
icuddctclddasnyqzpzmwhbrbbqrcqib
viuxwlrttojtvahperssgrqyhacjyyqs
</pre>
</center>>
</div>
";

?>
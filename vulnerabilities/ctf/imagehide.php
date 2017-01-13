<?php 

$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 12';
$page[ 'page_id' ] = 'ctf';
$page[ 'help_button' ] = 'hide';
$page[ 'source_button' ] = 'hide';
//
require_once '../../hackable/ctf/ctf.php';

$page[ 'body' ] .= "
<div class=\"body_padded\">
<h1>图像隐写术</h1>
<img width=100% heigh=100% src=../../hackable/ctf/q12/q12.png>
<!--
图像隐写术：
		通过把数据写入图片已达到隐藏数据而在感官上又不改变图片的技术。
		
		这题的flag存储在图像的RGB通道的R通道数据的最小比特位上。
		
		通过解析图片，获取R通道的数据矩阵，从每个点阵数据的最小比特位取一比特，
		
		连接所有比特数据转换成字符数据即可获取flag，明白？？！！！
-->
</div>
";

dvwaHtmlEcho( $page );


?>
<?php

$error = "Could not connect!<br>".__FILE__;
$my_host = 'localhost';
$dbuser = 'cristina.ramira';
$my_pass = 'mapalunara77';
$mydb = 'warehouse.soft';

mysql_connect($my_host,$dbuser,$my_pass) or die('<font size = 5 color = red><b>'.$error.'</b>,<br>'.__LINE__.'. '.__FILE__.'<br>'.mysql_error());
mysql_select_db($mydb) or die('<font size = 5 color = red><b>'.$error.'</b>,<br>'.__LINE__.'. '.__FILE__.'<br>'.mysql_error());

//if(@mysql_connect($my_host,$dbuser,$my_pass) || !mysql_select_db($mydb)) die($error.'<br>User: '.$dbuser.'<br>Pass: '.$my_pass);

?>
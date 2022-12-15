<?php

$error = "Could not connect!<br>".__FILE__;
$my_host = 'localhost';
$dbuser = 'SboReader';
$my_pass = 'UZE%&)4ew$RHL8$4';
$mydb = 'SBO_RamiraTEST01';

if(mysql_connect($my_host,$dbuser,$my_pass))echo 'Connected';
else die('<font size = 5 color = red><b>'.$error.'</b>,<br>'.__LINE__.'. '.__FILE__.'<br>'.mysql_error());
if(mysql_select_db($mydb)) echo 'SAP connected!'; 
else die('<font size = 5 color = red><b>'.$error.'</b>,<br>'.__LINE__.'. '.__FILE__.'<br>'.mysql_error());

//if(@mysql_connect($my_host,$dbuser,$my_pass) || !mysql_select_db($mydb)) die($error.'<br>User: '.$dbuser.'<br>Pass: '.$my_pass);

?>
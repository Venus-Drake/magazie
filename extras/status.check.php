<?php

    require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
    $que = "SELECT * FROM `magazie_stoc` WHERE `alarma` = '1'";
    if($run = mysql_query($que))
    {
	    if(mysql_num_rows($run) > 0) echo 'Stoc alert';
	    else echo 'OK';
    }
    else echo 'MySQL Error!';

?>
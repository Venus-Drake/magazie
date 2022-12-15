<?php

    if(isset($_GET['calling']) && $_GET['calling'] == 'checksession')
	{
        $ipNOW = $_SERVER['REMOTE_ADDR'];
        if(isset($_GET['username']) && $_GET['username'] != '') 
		{
			$username = $_GET['username'];
			require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
			$que = "SELECT `IP.connect` FROM `utilizatori` WHERE `username` = '$username'";
			if($run = mysql_query($que))
			{
			    if(mysql_num_rows($run) > 0)
			    {
				    $row = mysql_fetch_assoc($run);
				    $loggedIP = $row['IP.connect'];
                    if($loggedIP != $ipNOW) echo 'disconnect';
			    }
			}
			else echo 'MYSQL ERROR!';
		}
    }

?>
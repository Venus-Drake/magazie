<?php

    global $barcode; global $userGot;
    require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
    if(isset($_GET['barcode']) && !empty($_GET['barcode'])) 
	{
		$barcode = $_GET['barcode'];
		$que = "SELECT `username`, `password` FROM `utilizatori` WHERE `barcode` = '$barcode'";
	}
    else if(isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['password']) && !empty($_GET['password']))
	{
		$userGot =  $_GET['username'];
		$passGot = $_GET['password'];
		$que = "SELECT `username`, `password` FROM `utilizatori` WHERE `username` = '$userGot'";
	}
	if($run = mysql_query($que))
	{
	    if(mysql_num_rows($run) > 0)
	    {
		    $row = mysql_fetch_assoc($run);
		    $username = $row['username'];
		    $password = $row['password'];
		    if($barcode != '') echo 'OK^'.$username.'^'.$password;
		    else if($userGot != '') 
			{
				if($password == $passGot)echo 'OK^'.$username.'^'.$password;
				else echo 'Wrong password';
			}
	    }
	    else echo 'No user found!';
	}
	else echo 'MYSQL ERROR!!\n'.mysql_error();

?>
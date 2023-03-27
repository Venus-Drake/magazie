<?php

    if(isset($_GET['oldINPUT']) && !empty($_GET['oldINPUT']) && isset($_GET['user']) && !empty($_GET['user']))
	{
		$pass = $_GET['oldINPUT'];
		if($_GET['user'] != '') $user = $_GET['user'];
		else echo 'User not set!';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		if(!$chkold = $connect -> query("SELECT `password` FROM `utilizatori` WHERE `username` = '$user'")) {
		die(__LINE__ . '. MySQL Error!');}
		if(mysqli_num_rows($chkold) > 0)
		{
			$chkrow = $chkold -> fetch_assoc();
			$chkpass = $chkrow['password'];
			if($pass == $chkpass) echo 'OK';
			else echo 'Parola veche gresita!';
		}
		else echo $user.' not found!';
	}
    else echo 'Parola gresita';

?>
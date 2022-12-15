<?php

    if(isset($_GET['oldINPUT']) && !empty($_GET['oldINPUT']) && isset($_GET['user']) && !empty($_GET['user']))
	{
		$pass = $_GET['oldINPUT'];
		if($_GET['user'] != '') $user = $_GET['user'];
		else echo 'User not set!';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		$chkold = "SELECT `password` FROM `utilizatori` WHERE `username` = '$user'";
		if($chkrun = mysql_query($chkold))
		{
		    if(mysql_num_rows($chkrun) > 0)
			{
				$chkrow = mysql_fetch_assoc($chkrun);
				$chkpass = $chkrow['password'];
				if($pass == $chkpass) echo 'OK';
				else echo 'Parola veche gresita!';
			}
			else echo $user.' not found!';
		}
		else echo 'MySQL Error!';
	}
    else echo 'Parola gresita';

?>
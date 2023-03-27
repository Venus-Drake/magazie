<?php

    if(isset($_GET['calling']) && $_GET['calling'] == 'checksession')
	{
        $ipNOW = $_SERVER['REMOTE_ADDR'];
        if(isset($_GET['username']) && $_GET['username'] != '') 
		{
			$username = $_GET['username'];
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			if(!$que = $connect -> query("SELECT `IP.connect` FROM `utilizatori` WHERE `username` = '$username'")) {
			die(__LINE__.'. MYSQL ERROR!');}
			if(mysqli_num_rows($que) > 0)
			{
				$row = $que -> fetch_assoc($run);
				$loggedIP = $row['IP.connect'];
				if($loggedIP != $ipNOW) echo 'disconnect';
			}
		}
    }

?>
<?php

    global $barcode; global $userGot;
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(isset($_GET['barcode']) && !empty($_GET['barcode'])) 
	{
		$barcode = $_GET['barcode'];
		$que = $connect -> query("SELECT `username`, `password` FROM `utilizatori` WHERE `barcode` = '$barcode'");
	}
    else if(isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['password']) && !empty($_GET['password']))
	{
		$userGot =  $_GET['username'];
		$passGot = $_GET['password'];
		$que = $connect -> query("SELECT `username`, `password` FROM `utilizatori` WHERE `username` = '$userGot'");
	}
	$row = $que->fetch_assoc();
	$username = $row['username'];
	$password = $row['password'];
	if($barcode != '') echo 'OK^'.$username.'^'.$password;
	else if($userGot != '') 
	{
		if($password == $passGot)echo 'OK^'.$username.'^'.$password;
		else echo 'Wrong password';
	}
	//}
	//else echo 'MYSQL ERROR!!\n'.$que_error();
$connect->close();

?>
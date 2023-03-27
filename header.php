<?php

	date_default_timezone_set('Europe/Bucharest');
	$date = date('d M Y', time());
	$dateDB = date('Y-m-d',time());
	$hour = date('h:i:s', time());
	$mailerror = '';
	$warning = '';
	$datetime = date('Y/m/d h:i:s',time());
	//echo __FILE__.' called.';
	if(isset($_POST['mailtoME']) && $_POST['mailtoME'] != '')
	{
		$mailerror = $_POST['mailtoME'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$erradd = $connect -> query("INSERT INTO `error.warnings` VALUES('','$mailerror','1','0','$datetime')"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong:<BR>'.mysqli_error($connect).'<BR>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong:<BR>'.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
			mysqli_close($connect);
		}
		echo '<DIALOG OPEN ID = "confirm"><font size = 4><B>Eroarea a fost inregistrata!<BR>Vom face tot posibilul pentru a o remedia.<BR><BR><RIGHT>Multumesc!</font></RIGHT><BR><CENTER><BR><BUTTON ID = "confirm">OK</BUTTON></CENTER></DIALOG>';
		 
	}
	if(isset($_POST['mailtoME2']) && $_POST['mailtoME2'] != '')
	{
		$warning = $_POST['mailtoME2'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$erradd = $connect -> query("INSERT INTO `error.warnings` VALUES('','$warning','0','0','$datetime')"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong:<BR>'.mysqli_error($connect).'<BR>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong:<BR>'.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
			mysqli_close($connect);
		}
		echo '<DIALOG OPEN ID = "confirm"><font size = 4><B>Avertismentul a fost inregistrat!<BR><BR><RIGHT>Multumesc!</font></RIGHT><BR><CENTER><BR><BUTTON ID = "confirm">OK</BUTTON></CENTER></DIALOG>';
	}

?>

<SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
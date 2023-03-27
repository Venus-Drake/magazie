<?php

global $endMaxDate;

if($endMaxDate == 0) $endMaxDate = $endDate;

$marca = (string) $marca;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if(!$serialGrab = $connect -> query("SELECT `nr.crt`, `serial.nr` FROM `declaratie_storno` WHERE `marca` = '$marca' AND `processed` = '0'"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
	mysqli_close($connect);
}
if(mysqli_num_rows($serialGrab) > 0)
{
	$rowGrab = $serialGrab -> fetch_assoc();
	if($rowGrab['serial.nr'] != '0') 
	{
		$seria = $rowGrab['serial.nr'];
		if(!$serialUp = $connect -> query("UPDATE `declaratie_storno` SET `serial.nr` = '$seria', `gestionar` = '$nume' WHERE `marca` = '$marca' AND `processed` = '0'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
			mysqli_close($connect);		
		}
	}
	else 
	{
		$nrMake = $rowGrab['nr.crt'];
		$seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
		if(!$serialUp = $connect -> query("UPDATE `declaratie_storno` SET `serial.nr` = '$seria', `gestionar` = '$nume' WHERE `marca` = '$marca' AND `processed` = '0'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
			mysqli_close($connect);		
		}
	}
}
else 
{
	if(!$serialMake = $connect -> query("SELECT `nr.crt` FROM `declaratie_storno` ORDER BY `nr.crt` DESC"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
		mysqli_close($connect);		
	}
	$rowMake = $serialMake -> fetch_assoc();
	$nrMake = $rowMake['nr.crt'];
	$nrMake++;
	$seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
	$endMaxDate = $endDate;
}

?>
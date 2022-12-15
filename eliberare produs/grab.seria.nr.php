<?php

global $marca;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
if(!$serialGrab = $connect -> query("SELECT `nr.crt`, `serial.nr`, `data` FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `processed` = '0' ORDER BY `data` DESC, `ora` DESC"))
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5VW;"><CENTER><B>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	die();
}
if(mysqli_num_rows($serialGrab) > 0)
{
	$rowGrab = $serialGrab -> fetch_assoc();
	if($rowGrab['serial.nr'] != '0') 
	{
		$seria = $rowGrab['serial.nr'];
		if(!$serialUp = $connect -> query("UPDATE `bon_consum_tmp` SET `serial.nr` = '$seria', `gestionar` = '$nume', `data` = '$dateDB', `ora` = '$hour' WHERE `marca` = '$marca' AND `processed` = '0'"))
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5VW;"><CENTER><B>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
	}
	else 
	{
		$nrMake = $rowGrab['nr.crt'];
		$seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
		if(!$serialUp = $connect -> query("UPDATE `magazie_imprumuturi` SET `serial.nr` = '$seria', `gestionar` = '$nume', `data` = '$dateDB', `ora` = '$hour' WHERE `marca` = '$marca' AND `processed` = '0'"))
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5VW;"><CENTER><B>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
	}
}
else 
{
	if(!$serialMake = $connect -> query("SELECT `nr.crt` FROM `magazie_imprumuturi` ORDER BY `nr.crt` DESC"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5VW;"><CENTER><B>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		die();
	}
	$rowMake = $serialMake -> fetch_assoc();
	$nrMake = $rowMake['nr.crt'];
	$nrMake++;
	$seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
}

?>
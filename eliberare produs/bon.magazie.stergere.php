<?php

global $marca;
global $observatii;

if(!$REM = $connect -> query("SELECT `valoare`, `stoc`,`cantitate` FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	die();
}
if(mysqli_num_rows($REM) > 0)
{
	$remrow = $REM -> fetch_assoc();
	$valBON = $remrow['valoare'];
	$stocBON = $remrow['stoc'];
	$remam = $remrow['cantitate'];
	if($amount <= $remam) 
	{
		//echo '<font color = bgreen>Cantitatea de scos de pe bon este corecta. Efectuam operatia.';
		$amount = $remam - $amount;
		if($amount == 0)
		{
			if(!$remout = $connect -> query("DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				die();
			}
		}
		else
		{
			$valBON = $valBON * $amount;
			$stocBON = $stocBON - $amount;
			if(!$remout = $connect -> query("UPDATE `bon_consum_tmp` SET `cantitate` = '$amount', `stoc.final` = '$stocBON', `val.prod` = '$valBON' WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				die();
			}
		}
	}
	else
	{
		echo '<SCRIPT>flashQuantity();</SCRIPT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
	}
}
else 
{
	echo '<SCRIPT>flashPRODUCT();</SCRIPT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
}

?>
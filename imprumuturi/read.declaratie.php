<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';

global $readSAPCODE; global $readVALBON; global $readSAPCODE; global $tableROW;

if ($worker != 0)
	$worker = (string) $worker;

if(!$read = $connect -> query("SELECT * FROM `magazie_imprumuturi` WHERE `worker` = '$worker' ORDER BY `sap.code`, `furnizor`, `price`, `end.loan`, `motiv`, `stoc` DESC, `observatii`, `order.closed`"))
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
}
if(mysqli_num_rows($read) > 0 && ($worker == '' || $worker == 'Angajat INEXISTENT'))
{
	if(!$readgo = $connect -> query("DELETE FROM `magazie_imprumuturi` WHERE `worker` = '$worker'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	echo '<TR>';
}
else
{
	while($readrow = $read -> fetch_assoc())
	{
		$tableROW++;
		if($readrow['sap.code'] != $readSAPCODE) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.sap.nou.php';
		else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.sap.continue.php';
		if($readVALBON != $readVALTOT)
		{
			//DACA VALOAREA BONULUI NU CADE PE VALOAREA PE CARE O AVEM NOI, RECALCULAM SI FACEM MODIFICARILE IN TABEL
			if(!$readfix = $connect -> query("UPDATE `magazie_imprumuturi` SET `val.tot` = '$readVALBON' WHERE `sap.code` = '$readSAPCODE' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'"))
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
		}
	}
}

?>

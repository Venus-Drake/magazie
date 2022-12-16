<?php

global $nrCRT;
	$readAMOUNT = $readAMOUNT + $readrow['amount'];
	$readVAL = $readAMOUNT * $readPRICE;
	$readSTOCKend = $readSTOCK - $readAMOUNT;
	$nrCRTtmp = $readrow['nr.crt'];
	
	if(!$remPOS = $connect -> query("DELETE FROM `magazie_imprumuturi` WHERE `nr.crt` = '$nrCRTtmp'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
	}
	if(!$updatePOS = $connect -> query("UPDATE `magazie_imprumuturi` SET `amount` = '$readAMOUNT', `stoc.final` = '$readSTOCKend', `value` = '$readVAL' WHERE `nr.crt` = '$nrCRT'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
	}
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
	echo '<SCRIPT>document.getElementById("bon.magazie.imprumut").deleteRow('.$tableROWtmp.');</SCRIPT>';
	

?>
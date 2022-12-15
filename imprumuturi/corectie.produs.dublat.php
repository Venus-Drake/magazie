<?php

    //echo 'Product doubled. Amount: '.$readrow['amount'].'. My position: '.$readrow['nr.crt'].'. We add it to position '.$nrCRT.' and calculate stocks and values. <BR>';
	$readAMOUNT = $readAMOUNT + $readrow['amount'];
	$readVAL = $readAMOUNT * $readPRICE;
	$readSTOCKend = $readSTOCK - $readAMOUNT;
	$nrCRTtmp = $readrow['nr.crt'];
	//echo 'We come out with an amount of '.$readAMOUNT.', a final stock of '.$readSTOCKend.' and a value of '.$readVAL.' RON. We delete position '.$nrCRTtmp.'<BR>';
	$remPOS = "DELETE FROM `magazie_imprumuturi` WHERE `nr.crt` = '$nrCRTtmp'";
	if($remPOSrun = mysql_query($remPOS))
	{
	    //echo 'Deleted position '.$nrCRTtmp.'. We update position '.$nrCRT.'<BR>';
		$updatePOS = "UPDATE `magazie_imprumuturi` SET `amount` = '$readAMOUNT', `stoc.final` = '$readSTOCKend', `value` = '$readVAL' WHERE `nr.crt` = '$nrCRT'";
		if($updatePOSrun = mysql_query($updatePOS)) 
		{
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
			echo '<SCRIPT>document.getElementById("bon.magazie.imprumut").deleteRow('.$tableROWtmp.');</SCRIPT>';
		}
		else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
 	else
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
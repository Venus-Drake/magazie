<?php

    $valPRODUS = $price * $amount;
    $data_bon = date('Y/m/d h:i:s',time());
	$ora_bon = date('h:i:s', time());
	$stareTRANS = 'Pentru reascutire';
    $arhive = "INSERT INTO `arhiva_miscari_magazie` VALUES('','Pentru reascutire','$worker','$marca','$sectia','$product','$SAPcode','$furnizor','$price','$amount','$stock','$valPRODUS','$data_bon','$ora_bon','$observatii')";
	if($arhiveRUN = mysql_query($arhive))
	{
		$grabBARCODE = "SELECT `WORKER_barcode` FROM `pworker` WHERE `WORKER_ID` = '$marca'";
		if($grabBARCODErun = mysql_query($grabBARCODE))
		{
		    if(mysql_num_rows($grabBARCODErun) > 0)
		    {
			    $grabBARCODErow = mysql_fetch_assoc($grabBARCODErun);
			    $barcode = $grabBARCODErow['WORKER_barcode'];
		    }
		    else echo '<SCRIPT>alert("Storno Reascutire nu a putut fi efectuat!\nNumar marca invalid!\n'.$marca.'");</SCRIPT>';
		}
		else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	    $uzura = "INSERT INTO `magazie_uzate` VALUES('','$data_bon','$worker','$marca','$SAPcode','$product','$amount','$units','$magazie','$grupaMAT','$nume','$price','','$sectia','$masina','$barcode','$stareTRANS','','','')";
	    if($uzuraRUN = mysql_query($uzura)) echo '<SCRIPT>alert("Storno Reascutire pentru codul '.$SAPcode.' a fost efectuat cu succes!");</SCRIPT>';
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
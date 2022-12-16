<?php

global $marca;
global $product;
global $furnizor;
global $observatii;
global $grupaMAT;
global $masina;

$worker = (string) $worker;

$valPRODUS = $price * $amount;
$data_bon = date('Y/m/d h:i:s',time());
$ora_bon = date('h:i:s', time());
$stareTRANS = 'Pentru reascutire';
$SAPcode = (string) $SAPcode;
    if(!$arhive = $connect -> query("INSERT INTO `arhiva_miscari_magazie` VALUES('','Pentru reascutire','$worker','$marca','$sectia','$product','$SAPcode','$furnizor','$price','$amount','$stock','$valPRODUS','$data_bon','$ora_bon','$observatii')"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(!$grabBARCODE = $connect -> query("SELECT `WORKER_barcode` FROM `pworker` WHERE `WORKER_ID` = '$marca'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($grabBARCODE) > 0)
	{
		$grabBARCODErow = $grabBARCODE -> fetch_assoc();
		$barcode = $grabBARCODErow['WORKER_barcode'];
	}
	else echo '<SCRIPT>alert("Storno Reascutire nu a putut fi efectuat!\nNumar marca invalid!\n'.$marca.'");</SCRIPT>';
	if(!$uzura = $connect -> query("INSERT INTO `magazie_uzate` VALUES('','$data_bon','$worker','$marca','$SAPcode','$product','$amount','$units','$magazie','$grupaMAT','$nume','$price','','$sectia','$masina','$barcode','$stareTRANS','','','')"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	echo '<SCRIPT>alert("Storno Reascutire pentru codul '.$SAPcode.' a fost efectuat cu succes!");</SCRIPT>';


?>
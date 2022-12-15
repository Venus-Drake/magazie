<?php

global $observatii;

$addAMOUNT = $addrow['cantitate'] + $addAMOUNT;
$stocEND = $stock - $addAMOUNT;
$amountUPDATE = $addrow['cantitate'] + $amount;
$valUPDATE = $price * $amountUPDATE;
$stocUPDATE = $addrow['stoc'] - $addAMOUNT;
if(!$addUPDATE = $connect -> query("UPDATE `bon_consum_tmp` SET `cantitate` = '$amountUPDATE', `stoc.final` = '$stocUPDATE', `val.prod` = '$valUPDATE' WHERE `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii' AND `marca` = '$marca'"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
}
$updated = TRUE;

?>
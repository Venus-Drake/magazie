<?php

$readPRICE = (string) $readPRICE;
$readSAPCODE = (string) $readSAPCODE;
$readFURNIZOR = (string) $readFURNIZOR;
    if(!$stocCHK = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `pret` = '$readPRICE'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
   	if(mysqli_num_rows($stocCHK) > 0)
	{
		$stocCHKrow = $stocCHK -> fetch_assoc();
		if($readSTOCK != $stocCHKrow['cantitate']) $readSTOCK = $stocCHKrow['cantitate'];
	}
	

?>
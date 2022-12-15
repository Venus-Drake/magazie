<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
if(!$pchk = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode' ORDER BY `cantitate` DESC"))
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
}
if(mysqli_num_rows($pchk) != 0)
{
	$pchkrow = $pchk -> fetch_assoc();
	$stock = $pchkrow['cantitate'];
//CAUTAM PRODUSUL INCLUSIV PE BONUL DE COMANDA, SA ACTUALIZAM STOCUL, IN CAZ CA AM BAGAT DEJA O CANTITATE DE PRODUS PE BON
	if(!$pchkBON = $connect -> query("SELECT `stoc.final` FROM `bon_consum_tmp` WHERE `cod.SAP` = '$SAPcode' AND `marca` = '$marca' AND `processed` = '0' ORDER BY `stoc.final`"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($pchkBON) > 0)
	{
		$pchkBONrow = $pchkBON -> fetch_assoc();
		$stock = $pchkBONrow['stoc.final'];
	}
	$product = $pchkrow['denumire'];
	$magazie = $pchkrow['magazie'];
	$grupaMAT = $pchkrow['grupa_MAT'];
	$price = $pchkrow['pret'];
	$furnizor = $pchkrow['furnizor'];
	$units = $pchkrow['UM'];
}
else 
{
	$product = '';
	$SAPcode = '';
	$price = '0.00';
}

?>
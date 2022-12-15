<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
$pchk = "SELECT * FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode' ORDER BY `cantitate` DESC";
if($pchkrun = mysql_query($pchk))
{
     if(mysql_num_rows($pchkrun) != 0)
	 {
	 	$pchkrow = mysql_fetch_assoc($pchkrun);
	 	$stock = $pchkrow['cantitate'];
//CAUTAM PRODUSUL INCLUSIV PE BONUL DE COMANDA, SA ACTUALIZAM STOCUL, IN CAZ CA AM BAGAT DEJA O CANTITATE DE PRODUS PE BON
        $pchkBON = "SELECT `stoc.final` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `marca` = '$marca' AND `order.closed` = '0' ORDER BY `stoc.final`";
        if($pchkBONrun = mysql_query($pchkBON))
        {
		    if(mysql_num_rows($pchkBONrun) > 0)
		    {
			    $pchkBONrow = mysql_fetch_assoc($pchkBONrun);
			    $stock = $pchkBONrow['stoc.final'];
		    }
        }
        else
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
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
}
else
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
<?php

if ($readSAPCODE != 0)
	$readSAPCODE = (string) $readSAPCODE;
if ($readFURNIZOR != 0)
	$readFURNIZOR = (string) $readFURNIZOR;
    $stocCHK = "SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `pret` = '$readPRICE'";
   	if($stocCHKrun = mysql_query($stocCHK))
   	{
	    if(mysql_num_rows($stocCHKrun) > 0)
	    {
		    $stocCHKrow = mysql_fetch_assoc($stocCHKrun);
		    if($readSTOCK != $stocCHKrow['cantitate']) $readSTOCK = $stocCHKrow['cantitate'];
	    }
    }
    else
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
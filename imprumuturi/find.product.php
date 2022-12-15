<?php

if(isset($_GET['product']) && $_GET['product'] != '')
{
	$SAPcode = $_GET['product'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	$pchk = "SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%'";
	if($prun = mysql_query($pchk))
	{
	    while($prow = mysql_fetch_assoc($prun))
	    {
		    $mySAP = $prow['cod_SAP'];
		    if($mySAP != $SAPcode) echo '<OPTION VALUE = "'.$mySAP.'">'.$prow['denumire'].'</OPTION>';
	    }
	}
	else
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}
}

?>
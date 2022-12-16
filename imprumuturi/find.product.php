<?php

if(isset($_GET['product']) && $_GET['product'] != '')
{
	$SAPcode = $_GET['product'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	if(!$pchk = $connect -> query("SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	while($prow = $pchk -> fetch_assoc())
	{
		$mySAP = $prow['cod_SAP'];
		if($mySAP != $SAPcode) echo '<OPTION VALUE = "'.$mySAP.'">'.$prow['denumire'].'</OPTION>';
	}
}

?>
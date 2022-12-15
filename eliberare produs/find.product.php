<?php

if(isset($_POST['product']) && !empty($_POST['product']))
{
	$SAPcode = $_POST['product'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	$pchk = "SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%'";
	if($prun = mysql_query($pchk))
	{
		if(mysql_num_rows($prun) > 0)
		{
			echo 'OK^';
		    while($prow = mysql_fetch_assoc($prun))
		    {
			    $mySAP = $prow['cod_SAP'];
			    if(strtolower($mySAP) != strtolower($SAPcode)) echo '<OPTION VALUE = "'.$mySAP.'">'.$prow['denumire'].'</OPTION>';
		    }
		}
		else echo 'Not found!';
	}
	else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
}

?>
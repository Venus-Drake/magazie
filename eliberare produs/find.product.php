<?php

if(isset($_POST['product']) && !empty($_POST['product']))
{
	$SAPcode = $_POST['product'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	if(!$pchk = $connect -> query("SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%'"))
	{
		die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
	}
	if(mysqli_num_rows($pchk) > 0)
	{
		echo 'OK^';
		while($prow = $pchk -> fetch_assoc())
		{
			$mySAP = $prow['cod_SAP'];
			if(strtolower($mySAP) != strtolower($SAPcode)) echo '<OPTION VALUE = "'.$mySAP.'">'.$prow['denumire'].'</OPTION>';
		}
	}
	else echo 'Not found!';
}

?>
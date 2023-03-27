<?php

	if(isset($_GET['codSAP']) && $_GET['codSAP'] != '')
	{
		$grabSAP = $_GET['codSAP'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$wchk = $connect -> query("SELECT `denumire`, `cantitate`, `UM`, `furnizor` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$grabSAP'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			mysqli_close($connect);
		}
		if(mysqli_num_rows($wchk) > 0)
		{
			$wrow = $wchk -> fetch_assoc();
			$namegrab = $wrow['denumire'];
			$furgrab = $wrow['furnizor'];
			$stocgrab = $wrow['cantitate'];
			$units = $wrow['UM'];
			echo $namegrab.'^'.$furgrab.'^'.$stocgrab.'^'.$units;
		}
		
	}
?>
<?php

	if(isset($_GET['codSAP']) && $_GET['codSAP'] != '')
	{
		$grabSAP = $_GET['codSAP'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $wchk = "SELECT `denumire`, `cantitate`, `UM`, `furnizor` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$grabSAP'";
		if($wrun = mysql_query($wchk))
		{
		    if(mysql_num_rows($wrun) > 0)
		    {
			    $wrow = mysql_fetch_assoc($wrun);
			    $namegrab = $wrow['denumire'];
			    $furgrab = $wrow['furnizor'];
			    $stocgrab = $wrow['cantitate'];
			    $units = $wrow['UM'];
				echo $namegrab.'^'.$furgrab.'^'.$stocgrab.'^'.$units;
		    }
		}
		else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
?>
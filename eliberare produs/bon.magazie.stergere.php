<!
* AICI SCOATEM DE PE BON UN PRODUS PE CARE L-AM INTRODUS ORI MANUAL, ORI SELECTAT DIN BONUL DE COMANDA
* PENTRU ASTA, VERIFICAM DACA AVEM PRODUSUL PE BON SI DACA CANTITATEA DE PRODUS DE SCOS DE PE BON ESTE MAI MICA SAU EGALA CU CEA DE PE BON
* SE FACE UPDATE-UL NECESAR AL BONULUI SI SALVAM BONUL
>

<?php

$REM = "SELECT `valoare`, `stoc`,`cantitate` FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'";
if($remrun = mysql_query($REM))
{
    if(mysql_num_rows($remrun) > 0)
    {
		//ECHO '<font color = "darkblue">'.$SAPcode.' a fost gasit pe bonul de comanda! Il scoatem?<BR></font>';
		$remrow = mysql_fetch_assoc($remrun);
		$valBON = $remrow['valoare'];
		$stocBON = $remrow['stoc'];
		$remam = $remrow['cantitate'];
		if($amount <= $remam) 
		{
			//echo '<font color = bgreen>Cantitatea de scos de pe bon este corecta. Efectuam operatia.';
			$amount = $remam - $amount;
			if($amount == 0)
			{
			    $remout = "DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'";
			    if($outrun = mysql_query($remout)){}
                else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}
			else
			{
				$valBON = $valBON * $amount;
				$stocBON = $stocBON - $amount;
			    $remout = "UPDATE `bon_consum_tmp` SET `cantitate` = '$amount', `stoc.final` = '$stocBON', `val.prod` = '$valBON' WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode' AND `observatii` = '$observatii'";
			    if($outrun = mysql_query($remout)){}//{echo '<font color = red size = 5><B>Nu uita sa calculezi stocul si pretul total la produse!';}
			    else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}
		}
		else
		{
			echo '<SCRIPT>flashQuantity();</SCRIPT>';
	    	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
	    }
    }
    else 
	{
		echo '<SCRIPT>flashPRODUCT();</SCRIPT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
	}
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
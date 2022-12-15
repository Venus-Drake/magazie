<!
* ADAUGAM PRODUSELE CERUTE DE CATRE ANGAJAT LA BONUL DE COMANDA DACA AVEM PRODUSUL PE STOC
* PENTRU ASTA, VERIFICAM MAI INTAI DACA NU CUMVA AM BAGAT DEJA PRODUSUL PE BON
* DACA AVEM DEJA PE BON, ADAUGAM PRODUSUL, FACAND UPDATE LA CANTITATEA DE PE BON
* ATENTIE LA RUBRICA DE OBSERVATII!!
>

<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
global $updated;
require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/grab.seria.nr.php';

//MAI AVEM PRODUSUL PE BON SI LA ALTE POZITII/ BONURI RAMASE IN DB?

$addchk = "SELECT * FROM `bon_consum_tmp` WHERE `cod.SAP` = '$SAPcode' AND `marca` = '$marca' AND `processed` = '0' ORDER BY `val.tot` DESC";
if($addchkrun = mysql_query($addchk))
{
    if(mysql_num_rows($addchkrun) > 0)
	{
		$addAMOUNT = $amount;
	    while($addrow = mysql_fetch_assoc($addchkrun))
	    {
			if($stock - ($addrow['cantitate'] + $addAMOUNT) >= 0)
            {
			    if($addrow['observatii'] == $observatii)
			    {
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/update.product.php';
					break;
			    }
            }
            else 
			{
				echo "<SCRIPT>flashQuantity();</SCRIPT>";
				break;
			}
	    }
	    if($updated == FALSE)
	    {
		    $valINSERT = $price * $amount;
	     	$grabValBON = "SELECT `val.tot` FROM `bon_consum_tmp` ORDER BY `val.tot` DESC";
		    if($grabValRUN = mysql_query($grabValBON))
		    {
			    if(mysql_num_rows($grabValRUN) > 0)
			    {
				    $grabValROW = mysql_fetch_assoc($grabValRUN);
				    $valBON = $grabValROW['val.tot'];
			    }
			    else $valBON = 0;
			    $stocINSERT = $stock - $amount;
			    if($stocINSERT < 0) echo "<SCRIPT>flashQuantity();</SCRIPT>";
			    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/insert.product.php';
		    }
		    else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
	    }
	}
	else
	{
		$addchk = "SELECT `val.tot` FROM `bon_consum_tmp` ORDER BY `val.tot` DESC";
		if($addchkrun = mysql_query($addchk))
		{
			if(mysql_num_rows($addchkrun) > 0)
			{
			    $addrow = mysql_fetch_assoc($addchkrun);
			    $valBON = $addrow['val.tot'];
			}
			else $valBON = 0;
		    $stocINSERT = $stock - $amount;
		    if($stocINSERT < 0) echo "<SCRIPT>flashQuantity();</SCRIPT>";
		    else
		    {
				$valINSERT = $price * $amount;
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/insert.product.php';
		    }
	    }
	    else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}


?>
<SCRIPT src='/ramira/magazie/eliberare produs/eliberare.script.js'></SCRIPT>
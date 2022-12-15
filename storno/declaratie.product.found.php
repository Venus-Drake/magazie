<?php

    $addrow = mysql_fetch_assoc($loanchkrun);
    $sapread = $addrow['cod.SAP'];
    $furnizorREAD = $addrow['furnizor'];
    $amountREAD = $addrow['cantitate'];
    $priceREAD = $addrow['valoare'];
	$valBon = $addrow['val.tot'];
	//VERIFICAM CANTITATEA PE CARE O AVEM LA ANGAJAT, IN ARHIVA_MISCARI_MAGAZIE
	$qSTOCKchk = "SELECT `cantitate` FROM `arhiva_miscari_magazie` WHERE `tip.miscare` = 'Imprumut produs' AND `cod_SAP` = '$SAPcode' AND `furnizor` = '$furnizorREAD' AND `valoare` = '$price'";
	if($qSTOCKrun = mysql_query($qSTOCKchk))
	{
	    if(mysql_num_rows($qSTOCKrun) > 0)
	    {
		    $qSTOCKrow = mysql_fetch_assoc($qSTOCKrun);
		    $qSTOCK = $qSTOCKrow['cantitate'];
		    //VERIFICAM DACA NU CUMVA MAI AVEM ACEST PRODUS IN COMANDA, DAR CU ALTA DATA/ MOTIV/ OBSERVATII SI CALCULAM STOCUL FINAL AL PRODUSULUI IN FUNCTIE SI DE ACELE POZITII
			$amountChk = "SELECT `cantitate` FROM `declaratie_storno` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `furnizor` = '$furnizorREAD' AND `valoare` = '$priceREAD' AND `processed` = '0'";
			if($amountRun = mysql_query($amountChk))
			{
				$amountTotal = 0;
				if(mysql_num_rows($amountRun) > 0)
				{
				    while($amountRow = mysql_fetch_assoc($amountRun))
				    {
					    $amountTotal = $amountTotal + $amountRow['cantitate'];
				    }
				    $amountTotal = $amountTotal + $amount;
				}
				else $amountTotal = $amount; 
			}
	        else
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
			$stockFinal = $qSTOCK - $amountTotal;
	    	if($stockFinal < 0)
			{
			    //require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.php';
				echo '<SCRIPT>flashStock();</SCRIPT>';
		    }
		    else
		    {
				$amountREAD = $amountREAD + $amount;
		   		$valtot = $price*$amountREAD;
		   		$add = "UPDATE `declaratie_storno` SET `gestionar` = '$nume', `cantitate` = '$amountREAD', `val.prod` = '$valtot' WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `end.loan` = '$endDate' AND `motiv` = '$motiv' AND `order.closed` = '0' AND `observatii` = '$observatii'";
			 	if($addrun = mysql_query($add)){$stock = $stockFinal;}
			 	else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
		    }
	    }
	    else echo "<SCRIPT>flashQuantity();</SCRIPT>";
	}
	else
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
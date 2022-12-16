<?php

global $motiv;
global $observatii;

    $addrow = $loanchk -> fetch_assoc();
    $sapread = $addrow['sap.code'];
    $furnizorREAD = $addrow['furnizor'];
    $amountREAD = $addrow['amount'];
    $priceREAD = $addrow['price'];
	$valBon = $addrow['val.tot'];
	//VERIFICAM CANTITATEA PE CARE O AVEM PE STOC, INAINTE DE TOATE, IN MAGAZIE_STOC
	if(!$qSTOCKchk = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `furnizor` = '$furnizorREAD' AND `cod_SAP` = '$SAPcode' AND `pret` = '$price'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($qSTOCKchk) > 0)
	{
		$qSTOCKrow = $qSTOCKchk -> fetch_assoc();
		$qSTOCK = $qSTOCKrow['cantitate'];
		//VERIFICAM DACA NU CUMVA MAI AVEM ACEST PRODUS IN COMANDA, DAR CU ALTA DATA/ MOTIV/ OBSERVATII SI CALCULAM STOCUL FINAL AL PRODUSULUI IN FUNCTIE SI DE ACELE POZITII
		if(!$amountChk = $connect -> query("SELECT `amount` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `furnizor` = '$furnizorREAD' AND `price` = '$priceREAD' AND `order.closed` = '0'"))
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			mysqli_close($connect);
		}
		$amountTotal = 0;
		if(mysqli_num_rows($amountChk) > 0)
		{
			while($amountRow = $amountChk -> fetch_assoc())
			{
				$amountTotal = $amountTotal + $amountRow['amount'];
			}
			$amountTotal = $amountTotal + $amount;
		}
		else $amountTotal = $amount;
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
			if(!$add = $connect -> query("UPDATE `magazie_imprumuturi` SET `gestionar` = '$nume', `amount` = '$amountREAD', `stoc.final` = '$stockFinal', `value` = '$valtot' WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `end.loan` = '$endDate' AND `motiv` = '$motiv' AND `order.closed` = '0' AND `observatii` = '$observatii'"))
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			$stock = $stockFinal;
		}
	}
	else echo "<SCRIPT>flashQuantity();</SCRIPT>";

?>
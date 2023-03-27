<?php

global $furnizor;
global $motiv;
global $product;
global $observatii;
$worker = (string) $worker;
$nume = (string) $nume;
$sectia = (string) $sectia;

$datetime = (string) $datetime;

    //VERIFICAM DACA NU MAI AVEM PRODUSUL IN DECLARATIE, CU ALTA DATA/ MOTIV/ OBSERVATII ETC.
    if(!$decPRODchk = $connect -> query("SELECT * FROM `magazie_imprumuturi` WHERE `furnizor` = '$furnizor' AND `sap.code` = '$SAPcode' AND `price` = '$price' ORDER BY `stoc` DESC"))
    {
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	$amountREAD = 0;
	if(mysqli_num_rows($decPRODchk) > 0)
	{
		while($decPRODrow = $decPRODchk -> fetch_assoc())
		{
			$amountREAD = $amountREAD + $decPRODrow['amount'];
		}
		$amountTotal = $amountREAD + $amount;
	}
	else $amountTotal = $amount;
//VERIFICAM STOCUL DIN MAGAZIE_STOC
	if(!$qSTOCKchk = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `furnizor` = '$furnizor' AND `cod_SAP` = '$SAPcode' AND `pret` = '$price'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($qSTOCKchk) > 0)
	{
		$qSTOCKrow = $qSTOCKchk -> fetch_assoc();
		$qSTOCK = $qSTOCKrow['cantitate'];
		if($qSTOCK - $amountTotal >= 0)
		{
			$stockFinal = $qSTOCK - $amountTotal;
			$stockINIT = $stockFinal - $amount;
			$valtot = $price * $amount;
//EXTARGEM VALOAREA BONULUI
			if(!$bonGRAB = $connect -> query("SELECT `val.tot` FROM `magazie_imprumuturi` WHERE `worker` = '$worker' AND `order.closed` = '0' ORDER BY `val.tot` DESC"))
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			if(mysqli_num_rows($bonGRAB) > 0)
			{
				$bonGRABrow = $bonGRAB -> fetch_assoc();
				$valBon = $bonGRABrow['val.tot'] + $valtot;
			}
			else $valBon = $valtot;
			$endLoanDate = date('Y/m/d h:i:s',strtotime($endDate));
			if(!$add = $connect -> query("INSERT INTO `magazie_imprumuturi` VALUES('','$seria','$datetime','$marca','$worker','$sectia','$nume','$endLoanDate','$motiv','$SAPcode','$product','$furnizor','$stockINIT','$amount','$units','$stockFinal','$price','$valtot','$valBon','0','$observatii')"))
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			$stock = $stockFinal;
		}
		else echo '<SCRIPT>flashQuantity();</SCRIPT>';
	}
	else echo '<SCRIPT>flashProduct();</SCRIPT>';

?>
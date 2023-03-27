<?php

    //VERIFICAM DACA NU MAI AVEM PRODUSUL IN DECLARATIE, CU ALTA DATA/ MOTIV/ OBSERVATII ETC.
$furnizor = (string) $furnizor;
$SAPcode = (string) $SAPcode;
$observatii = (string) $observatii;
$motiv = (string) $motiv;
$product = (string) $product;
$price = (float) $price;
$seria = (string) $seria;

    if(!$decPRODchk = $connect -> query("SELECT * FROM `declaratie_storno` WHERE `furnizor` = '$furnizor' AND `cod.SAP` = '$SAPcode' AND `valoare` = '$price'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}
    $amountREAD = 0;
	if(mysqli_num_rows($decPRODchk) > 0)
	{
		while($decPRODrow = $decPRODchk -> fetch_assoc())
		{
			$amountREAD = $amountREAD + $decPRODrow['cantitate'];
		}
		$amountTotal = $amountREAD + $amount;
	}
	else $amountTotal = $amount;
//VERIFICAM INVENTARUL ANGAJATULUI DIN ARHIVA_MISCARI_MAGAZIE
	if(!$qSTOCKchk = $connect -> query("SELECT `cantitate` FROM `arhiva_miscari_magazie` WHERE `tip.miscare` = 'Imprumut produs' AND `furnizor` = '$furnizor' AND `cod.SAP` = '$SAPcode' AND `valoare` = '$price'"))
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
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
			$endLoanDate = date('Y/m/d h:i:s',strtotime($endDate));
			if(!$add = $connect -> query("INSERT INTO `declaratie_storno` VALUES('','$seria','$datetime','$worker','$marca','$sectia','$nume','$endLoanDate','$product','$SAPcode','$furnizor','$uzura','$motiv','$units','$price','$amount','$valtot','0','$observatii')"))
			{
				$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
			$stock = $stockFinal;
		}
		else echo '<SCRIPT>flashQuantity();</SCRIPT>';
	}
	else echo '<SCRIPT>flashProduct();</SCRIPT>';

?>
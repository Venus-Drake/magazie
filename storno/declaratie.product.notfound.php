<?php

    //VERIFICAM DACA NU MAI AVEM PRODUSUL IN DECLARATIE, CU ALTA DATA/ MOTIV/ OBSERVATII ETC.
    $decPRODchk = "SELECT * FROM `declaratie_storno` WHERE `furnizor` = '$furnizor' AND `cod.SAP` = '$SAPcode' AND `valoare` = '$price'";
    if($decPRODrun = mysql_query($decPRODchk))
    {
		$amountREAD = 0;
	    if(mysql_num_rows($decPRODrun) > 0)
	    {
		    while($decPRODrow = mysql_fetch_assoc($decPRODrun))
		    {
			    $amountREAD = $amountREAD + $decPRODrow['cantitate'];
		    }
		    $amountTotal = $amountREAD + $amount;
	    }
	    else $amountTotal = $amount;
	//VERIFICAM INVENTARUL ANGAJATULUI DIN ARHIVA_MISCARI_MAGAZIE
	    $qSTOCKchk = "SELECT `cantitate` FROM `arhiva_miscari_magazie` WHERE `tip.miscare` = 'Imprumut produs' AND `furnizor` = '$furnizor' AND `cod.SAP` = '$SAPcode' AND `valoare` = '$price'";
	    if($qSTOCKrun = mysql_query($qSTOCKchk))
	    {
		    if(mysql_num_rows($qSTOCKrun) > 0)
		    {
				$qSTOCKrow = mysql_fetch_assoc($qSTOCKrun);
			    $qSTOCK = $qSTOCKrow['cantitate'];
			    if($qSTOCK - $amountTotal >= 0)
			    {
				    $stockFinal = $qSTOCK - $amountTotal;
				    $stockINIT = $stockFinal - $amount;
				    $valtot = $price * $amount;
				    $endLoanDate = date('Y/m/d h:i:s',strtotime($endDate));
			    	$add = "INSERT INTO `declaratie_storno` VALUES('','$seria','$datetime','$worker','$marca','$sectia','$nume','$endLoanDate','$product','$SAPcode','$furnizor','$uzura','$motiv','$units','$price','$amount','$valtot','0','$observatii')";
			    	if($addrun = mysql_query($add)){$stock = $stockFinal;}
				    else
					{
						$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
						require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					}
			    }
			    else echo '<SCRIPT>flashQuantity();</SCRIPT>';
		    }
		    else echo '<SCRIPT>flashProduct();</SCRIPT>';
	    }
	    else
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
    }
    else
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
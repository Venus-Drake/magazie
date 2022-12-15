<?php

    //VERIFICAM DACA NU MAI AVEM PRODUSUL IN DECLARATIE, CU ALTA DATA/ MOTIV/ OBSERVATII ETC.
    $decPRODchk = "SELECT * FROM `magazie_imprumuturi` WHERE `furnizor` = '$furnizor' AND `sap.code` = '$SAPcode' AND `price` = '$price' ORDER BY `stoc` DESC";
    if($decPRODrun = mysql_query($decPRODchk))
    {
		$amountREAD = 0;
	    if(mysql_num_rows($decPRODrun) > 0)
	    {
		    while($decPRODrow = mysql_fetch_assoc($decPRODrun))
		    {
			    $amountREAD = $amountREAD + $decPRODrow['amount'];
		    }
		    $amountTotal = $amountREAD + $amount;
	    }
	    else $amountTotal = $amount;
	//VERIFICAM STOCUL DIN MAGAZIE_STOC
	    $qSTOCKchk = "SELECT `cantitate` FROM `magazie_stoc` WHERE `furnizor` = '$furnizor' AND `cod_SAP` = '$SAPcode' AND `pret` = '$price'";
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
    //EXTARGEM VALOAREA BONULUI
                    $bonGRAB = "SELECT `val.tot` FROM `magazie_imprumuturi` WHERE `worker` = '$worker' AND `order.closed` = '0' ORDER BY `val.tot` DESC";
                    if($bonGRABrun = mysql_query($bonGRAB))
                    {
					    if(mysql_num_rows($bonGRABrun) > 0)
					    {
						    $bonGRABrow = mysql_fetch_assoc($bonGRABrun);
						    $valBon = $bonGRABrow['val.tot'] + $valtot;
					    }
					    else $valBon = $valtot;
                    }
                    else
					{
						$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
						require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					}
				    $endLoanDate = date('Y/m/d h:i:s',strtotime($endDate));
			    	$add = "INSERT INTO `magazie_imprumuturi` VALUES('','$seria','$datetime','$marca','$worker','$sectia','$nume','$endLoanDate','$motiv','$SAPcode','$product','$furnizor','$stockINIT','$amount','$units','$stockFinal','$price','$valtot','$valBon','0','$observatii')";
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
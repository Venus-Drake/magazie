<!
* AICI SCOATEM DE PE BON UN PRODUS PE CARE L-AM INTRODUS ORI MANUAL, ORI SELECTAT DIN BONUL DE COMANDA
* PENTRU ASTA, VERIFICAM DACA AVEM PRODUSUL PE BON SI DACA CANTITATEA DE PRODUS DE SCOS DE PE BON ESTE MAI MICA SAU EGALA CU CEA DE PE BON
* SE FACE UPDATE-UL NECESAR AL BONULUI SI SALVAM BONUL
>
<HTML>
    <HEAD>
        <SCRIPT src='/ramira/magazie/imprumuturi/imprumut.script.js'></SCRIPT>
    </HEAD>
    <BODY>

<?php

//echo __FILE__.' called';
$tempDate = date('Y-m-d h:i:s', strtotime($endDate));
$REM = "SELECT `stoc`, `amount`, `price`, `value`, `val.tot` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `end.loan` = '$tempDate' AND `motiv` = '$motiv' AND `observatii` = '$observatii'";
if($remrun = mysql_query($REM))
{
    if(mysql_num_rows($remrun) > 0)
    {
		$remrow = mysql_fetch_assoc($remrun);
		$valPrice = $remrow['price'];
		$valBON = $remrow['val.tot'];
		$stocBON = $remrow['stoc'];
		$remam = $remrow['amount'];
		if($amount <= $remam) 
		{
			//echo '<font color = bgreen>Cantitatea de scos de pe bon este corecta. Efectuam operatia.';
			$remam = $remam - $amount;
			if($remam == 0)
			{
			    $remout = "DELETE FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `end.loan` = '$tempDate' AND `motiv` = '$motiv' AND `observatii` = '$observatii'";
			    if($outrun = mysql_query($remout))
				{
					$amount = 1;
					$endDate = $date;
					//CAUTAM IN COMANDA SA VEDEM DACA MAI AVEM PRODUSUL SI PE ALTE POZITII; DACA IL AVEM, RECALCULAM STOCUL FINAL PE FIECARE POZITIE
					$remChk = "SELECT `date`, `stoc`, `amount`, `stoc.final` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'";
					if($remChkrun = mysql_query($remChk))
					{
					    if(mysql_num_rows($remChkrun) > 0)
					    {
							$remAmount = 0;
						    while($remChkrow = mysql_fetch_assoc($remChkrun))
						    {
								$remDate = $remChkrow['date'];
							    $remStock = $remChkrow['stoc'];
							    $remAmount = $remAmount + $remChkrow['amount'];
							    $remStockFinal = $remChkrow['stoc.final'];
							    $remStockChk = $remStock - $remAmount;
								if($remStockChk != $remStockFinal)
								{
								    $remChkUp = "UPDATE `magazie_imprumuturi` SET `stoc.final` = '$remStockChk' WHERE `date` = '$remDate' AND `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'";
								    if($remUp = mysql_query($remChkUp)){}
								    else
									{
										$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
										require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
									}
								}
						    }
					    }
					}
					else
					{
						$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
						require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					}
                }
                else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}
			else
			{
				$valValue = $valPrice * $remam;
				$stocBON = $stocBON - $amount;
			    $remout = "UPDATE `magazie_imprumuturi` SET `amount` = '$remam', `value` = '$valValue', `stoc.final` = '$stocBON' WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `observatii` = '$observatii'";
			    if($outrun = mysql_query($remout))
				{
					$amount = 1;
					//CAUTAM IN COMANDA SA VEDEM DACA MAI AVEM PRODUSUL SI PE ALTE POZITII; DACA IL AVEM, RECALCULAM STOCUL FINAL PE FIECARE POZITIE
					$remChk = "SELECT `date`, `stoc`, `amount`, `stoc.final` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'";
					if($remChkrun = mysql_query($remChk))
					{
					    if(mysql_num_rows($remChkrun) > 0)
					    {
							$remAmount = 0;
						    while($remChkrow = mysql_fetch_assoc($remChkrun))
						    {
								$remDate = $remChkrow['date'];
							    $remStock = $remChkrow['stoc'];
							    $remAmount = $remAmount + $remChkrow['amount'];
							    $remStockFinal = $remChkrow['stoc.final'];
							    $remStockChk = $remStock - $remAmount;
								if($remStockChk != $remStockFinal)
								{
								    $remChkUp = "UPDATE `magazie_imprumuturi` SET `stoc.final` = '$remStockChk' WHERE `date` = '$remDate' AND `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'";
								    if($remUp = mysql_query($remChkUp)){}
								    else
									{
										$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
										require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
									}
								}
						    }
					    }
					}
					else
					{
						$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
						require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					}
				}//{echo '<font color = red size = 5><B>Nu uita sa calculezi stocul si pretul total la produse!';}
			    else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}
		}
		else echo '<SCRIPT>flashQuantity();</SCRIPT>';
    }
    else echo '<SCRIPT>flashProduct();</SCRIPT>';
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
    </BODY>
</HTML>
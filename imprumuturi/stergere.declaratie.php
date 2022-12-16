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
$SAPcode = (string) $SAPcode;
$motiv = (string) $motiv;

if(!$REM = $connect -> query("SELECT `stoc`, `amount`, `price`, `value`, `val.tot` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `end.loan` = '$tempDate' AND `motiv` = '$motiv' AND `observatii` = '$observatii'"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
}
if(mysqli_num_rows($REM) > 0)
{
	$remrow = $REM -> fetch_assoc();
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
			if(!$remout = $connect -> query("DELETE FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `end.loan` = '$tempDate' AND `motiv` = '$motiv' AND `observatii` = '$observatii'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			$amount = 1;
			$endDate = $date;
			//CAUTAM IN COMANDA SA VEDEM DACA MAI AVEM PRODUSUL SI PE ALTE POZITII; DACA IL AVEM, RECALCULAM STOCUL FINAL PE FIECARE POZITIE
			if(!$remChk = $connect -> query("SELECT `date`, `stoc`, `amount`, `stoc.final` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			if(mysqli_num_rows($remChk) > 0)
			{
				$remAmount = 0;
				while($remChkrow = $remChk -> fetch_assoc())
				{
					$remDate = $remChkrow['date'];
					$remStock = $remChkrow['stoc'];
					$remAmount = $remAmount + $remChkrow['amount'];
					$remStockFinal = $remChkrow['stoc.final'];
					$remStockChk = $remStock - $remAmount;
					if($remStockChk != $remStockFinal)
					{
						if(!$remChkUp = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc.final` = '$remStockChk' WHERE `date` = '$remDate' AND `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);
						}
					}
				}
			}
		}
		else
		{
			$valValue = $valPrice * $remam;
			$stocBON = $stocBON - $amount;
			if(!$remout = $connect -> query("UPDATE `magazie_imprumuturi` SET `amount` = '$remam', `value` = '$valValue', `stoc.final` = '$stocBON' WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0' AND `observatii` = '$observatii'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			$amount = 1;
			//CAUTAM IN COMANDA SA VEDEM DACA MAI AVEM PRODUSUL SI PE ALTE POZITII; DACA IL AVEM, RECALCULAM STOCUL FINAL PE FIECARE POZITIE
			if(!$remChk = $connect -> query("SELECT `date`, `stoc`, `amount`, `stoc.final` FROM `magazie_imprumuturi` WHERE `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			if(mysqli_num_rows($remChk) > 0)
			{
				$remAmount = 0;
				while($remChkrow = $remChk -> fetch_assoc())
				{
					$remDate = $remChkrow['date'];
					$remStock = $remChkrow['stoc'];
					$remAmount = $remAmount + $remChkrow['amount'];
					$remStockFinal = $remChkrow['stoc.final'];
					$remStockChk = $remStock - $remAmount;
					if($remStockChk != $remStockFinal)
					{
						if(!$remChkUp = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc.final` = '$remStockChk' WHERE `date` = '$remDate' AND `sap.code` = '$SAPcode' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);
						}
					}
				}
			}
		}
	}
	else echo '<SCRIPT>flashQuantity();</SCRIPT>';
}
else echo '<SCRIPT>flashProduct();</SCRIPT>';

?>
    </BODY>
</HTML>
<?php

$worker = (string) $worker;
$readSTOCK = (string)$readSTOCK;
$readPRICE = (string) $readPRICE;
$readMOTIV = (string) $readMOTIV;
$readFURNIZOR = (string) $readFURNIZOR;


    if($readrow['end.loan'] != $endLOAN || $readrow['motiv'] != $readMOTIV || $readrow['furnizor'] != $readFURNIZOR || $readrow['price'] != $readPRICE || $readrow['observatii'] != $readObs)
    {
		if($readrow['furnizor'] != $readFURNIZOR)
		{
		    $tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['sap.code'];
		   	$readPRODUCT = $readrow['item.name'];
		   	$readFURNIZOR = $readrow['furnizor'];
		   	$readPRICE = $readrow['price'];
		   	$readSTOCK = $readrow['stoc'];       //VERIFICAM STOCUL DIN MAGAZIE
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/verificare.stoc.magazie.php';
		   	$readAMOUNT = $readrow['amount'];
		   	$readUM = $readrow['unitate.mas'];
		   	$readObs = $readrow['observatii'];
		   	if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				if(!$readSTOCKupdate = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' "))
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
			}
		   	$readVAL = $readrow['value'];
		   	$readVALTOT = $readrow['val.tot'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
		}
		else if($readrow['price'] != $readPRICE)
		{
		    $tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['sap.code'];
		   	$readPRODUCT = $readrow['item.name'];
		   	$readPRICE = $readrow['price'];
		   	$readSTOCK = $readrow['stoc'];       //VERIFICAM STOCUL DIN MAGAZIE
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/verificare.stoc.magazie.php';
		   	$readAMOUNT = $readrow['amount'];
		   	$readUM = $readrow['unitate.mas'];
		   	$readObs = $readrow['observatii'];
		   	if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
			if ($readFURNIZOR != 0)
				$readFURNIZOR = (string) $readFURNIZOR;
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				if(!$readSTOCKupdate = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' "))
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
			}
		   	$readVAL = $readrow['value'];
		   	$readVALTOT = $readrow['val.tot'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
		}
		else if($readrow['end.loan'] != $endLOAN)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['sap.code'];
		   	$readPRODUCT = $readrow['item.name'];
		   	if($readrow['stoc'] != $readSTOCKend) $readSTOCK = $readSTOCKend;
		   	$readAMOUNT = $readrow['amount'];
		   	$readUM = $readrow['unitate.mas'];
		   	$readObs = $readrow['observatii'];
		   	if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				if(!$readSTOCKupdate = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' "))
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
			}
		   	$readVAL = $readrow['value'];
		   	$readVALTOT = $readrow['val.tot'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
		}
		else if($readrow['motiv'] != $readMOTIV)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['sap.code'];
		   	$readPRODUCT = $readrow['item.name'];
		   	if($readrow['stoc'] != $readSTOCKend) $readSTOCK = $readSTOCKend;
		   	$readAMOUNT = $readrow['amount'];
		   	$readUM = $readrow['unitate.mas'];
		   	$readObs = $readrow['observatii'];
		   	if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				if(!$readSTOCKupdate = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' "))
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
			}
		   	$readVAL = $readrow['value'];
		   	$readVALTOT = $readrow['val.tot'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
		}
		else if($readrow['observatii'] != $readObs)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		   	$readSAPCODE = $readrow['sap.code'];
		   	$readPRODUCT = $readrow['item.name'];
		   	if($readrow['stoc'] != $readSTOCKend) $readSTOCK = $readSTOCKend;
		   	$readAMOUNT = $readrow['amount'];
		   	$readUM = $readrow['unitate.mas'];
		   	$readObs = $readrow['observatii'];
		   	if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				if(!$readSTOCKupdate = $connect -> query("UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' "))
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
			}
		   	$readVAL = $readrow['value'];
		   	$readVALTOT = $readrow['val.tot'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/read.declaratie.echo.php';
		}
    }
    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/corectie.produs.dublat.php';

?>
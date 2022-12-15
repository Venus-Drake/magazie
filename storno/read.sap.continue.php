<?php

    if($readrow['end.loan'] != $endLOAN || $readrow['motiv'] != $readMOTIV || $readrow['furnizor'] != $readFURNIZOR || $readrow['valoare'] != $readPRICE || $readrow['observatii'] != $readObs)
    {
		if($readrow['furnizor'] != $readFURNIZOR)
		{
		    $tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['cod.SAP'];
		   	$readPRODUCT = $readrow['produs'];
		   	$readFURNIZOR = $readrow['furnizor'];
		   	$readPRICE = $readrow['valoare'];
		   	//$readSTOCK = $readrow['stoc'];       //VERIFICAM STOCUL DIN MAGAZIE
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/verificare.stoc.magazie.php';
		   	$readAMOUNT = $readrow['cantitate'];
		   	$readUM = $readrow['unit'];
		   	$readObs = $readrow['observatii'];
		   	/*if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				$readSTOCKupdate = "UPDATE `magazie_imprumuturi` SET `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' ";
				if($readSTOCKrun = mysql_query($readSTOCKupdate)){}
				else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}*/
		   	$readVALTOT = $readrow['val.prod'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';
		}
		else if($readrow['valoare'] != $readPRICE)
		{
		    $tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['cod.SAP'];
		   	$readPRODUCT = $readrow['produs'];
		   	$readPRICE = $readrow['valoare'];
		   	//$readSTOCK = $readrow['stoc'];       //VERIFICAM STOCUL DIN MAGAZIE
		   	//require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/verificare.stoc.magazie.php';
		   	$readAMOUNT = $readrow['cantitate'];
		   	$readUM = $readrow['unit'];
		   	$readObs = $readrow['observatii'];
		   	/*if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				$readSTOCKupdate = "UPDATE `magazie_imprumuturi` SET `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' ";
				if($readSTOCKrun = mysql_query($readSTOCKupdate)){}
				else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			} */
		   	$readVALTOT = $readrow['val.prod'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';
		}
		else if($readrow['end.loan'] != $endLOAN)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $endLOAN = $readrow['end.loan'];
		    $readEND = date('d M Y',strtotime($endLOAN));
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['cod.SAP'];
		   	$readPRODUCT = $readrow['produs'];
		   	$readAMOUNT = $readrow['cantitate'];
		   	$readUM = $readrow['unit'];
		   	$readObs = $readrow['observatii'];
		   	/*if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				$readSTOCKupdate = "UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' ";
				if($readSTOCKrun = mysql_query($readSTOCKupdate)){}
				else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}*/
		   	$readVALTOT = $readrow['val.prod'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';
		}
		else if($readrow['motiv'] != $readMOTIV)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		    $readMOTIV = $readrow['motiv'];
		   	$readSAPCODE = $readrow['cod.SAP'];
		   	$readPRODUCT = $readrow['item.name'];
		   	//if($readrow['stoc'] != $readSTOCKend) $readSTOCK = $readSTOCKend;
		   	$readAMOUNT = $readrow['cantitate'];
		   	$readUM = $readrow['unit'];
		   	$readObs = $readrow['observatii'];
		   	/*if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				$readSTOCKupdate = "UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' ";
				if($readSTOCKrun = mysql_query($readSTOCKupdate)){}
				else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}*/
		   	$readVALTOT = $readrow['val.prod'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';
		}
		else if($readrow['observatii'] != $readObs)
		{
			$tableROWtmp = $tableROW;
			$nrCRT = $readrow['nr.crt'];
		   	$readSAPCODE = $readrow['cod.SAP'];
		   	$readPRODUCT = $readrow['produs'];
		   	//if($readrow['stoc'] != $readSTOCKend) $readSTOCK = $readSTOCKend;
		   	$readAMOUNT = $readrow['cantitate'];
		   	$readUM = $readrow['unit'];
		   	$readObs = $readrow['observatii'];
		   	/*if($readrow['stoc.final'] == ($readSTOCK - $readAMOUNT)) $readSTOCKend = $readrow['stoc.final'];
		   	else 
		 	{
				$readSTOCKend = $readSTOCK - $readAMOUNT;	//FACEM UPDATE LA STOC IN TABEL
				$readSTOCKupdate = "UPDATE `magazie_imprumuturi` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend' WHERE `worker` = '$worker' AND `sap.code` = '$readSAPCODE' AND `furnizor` = '$readFURNIZOR' AND `price` = '$readPRICE' AND `amount` = '$readAMOUNT' AND `motiv` = '$readMOTIV' AND `order.closed` = '0' AND `observatii` = '$readObs' ";
				if($readSTOCKrun = mysql_query($readSTOCKupdate)){}
				else
				{
					$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}*/
		   	$readVALTOT = $readrow['val.prod'];
		   	$readVALBON = $readVALBON + $readVAL;
		   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';
		}
    }
    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/corectie.produs.dublat.php';

?>
<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

if(!$read = $connect -> query("SELECT * FROM `bon_consum_tmp` WHERE `nume` = '$worker' ORDER BY `cod.SAP` ASC, `observatii` ASC"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	die();
}
if(mysqli_num_rows($read) > 0 && ($worker == '' || $worker == 'Angajat INEXISTENT'))
{
	if(!$readgo = $connect -> query("DELETE FROM `bon_consum_tmp` WHERE `numer` = '$worker'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
	}
	echo '<TR>';
}
else
{
	$readVALBON = 0; $readSAPCODE = '';
	while($readrow = $read -> fetch_assoc())
	{
		$readWORKER = $readrow['nume'];
		$readPRODUCT = $readrow['produs'];
//APLICAM UN FIX LA STOC, DE ASEMENEA, SA ORDONAM FRUMOS POZITIILE PE BON; PENTRU ASTA, EXTRAGEM STOCUL INITIAL DIN STOCUL MAGAZIEI
		if($readrow['cod.SAP'] != $readSAPCODE)
		{
			$readSAPCODE = $readrow['cod.SAP'];
			if(!$grabSTOC = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$readSAPCODE'"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				die();
			}
			if(mysqli_num_rows($grabSTOC) > 0)
			{
				$grabSTOCrow = $grabSTOC -> fetch_assoc();
				$readSTOCK = $grabSTOCrow['cantitate'];
			}
		}
		$readFURNIZOR = $readrow['furnizor'];
		$readUZURA = $readrow['uzura'];
		$readUNIT = $readrow['unit'];
		$readPRICE = $readrow['valoare'];
		$readAMOUNT = $readrow['cantitate'];
		$readSTOCKend = $readSTOCK - $readAMOUNT;
		$readVALTOT = $readrow['val.prod'];
		$readOBS = $readrow['observatii'];
		$readVALBON = $readVALBON + $readVALTOT;
		$readSTOCKdisplay = $readSTOCK;
		if(!$readfix = $connect -> query("UPDATE `bon_consum_tmp` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend', `val.tot` = '$readVALBON' WHERE `cod.SAP` = '$readSAPCODE' AND `nume` ='$worker' AND `observatii` = '$readOBS'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.'. '.__FILE__.':<br>'.mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
		$readSTOCK = $readSTOCKend;
		echo '
		<TR CLASS = "ROW">
			<TD CLASS = "BON">'.$readPRODUCT.'</TD>
			<TD CLASS = "BON2">'.$readSAPCODE.'</TD>
			<TD CLASS = "BON2">'.$readFURNIZOR.'</TD>
			<TD CLASS = "BON2">'.$readUZURA.'</TD>
			<TD CLASS = "BON2">'.$readUNIT.'</TD>
			<TD CLASS = "BON2">'.$readPRICE.'</TD>
			<TD CLASS = "BON2">'.$readSTOCKdisplay.'</TD>
			<TD CLASS = "BON2">'.$readAMOUNT.'</TD>
			<TD CLASS = "BON2">'.$readSTOCKend.'</TD>
			<TD CLASS = "BON2">'.$readVALTOT.'</TD>
			<TD CLASS = "BON2">'.$readOBS.'</TD>
		</TR>';
	}
}

?>
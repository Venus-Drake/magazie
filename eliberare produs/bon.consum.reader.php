<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

$read = "SELECT * FROM `bon_consum_tmp` WHERE `nume` = '$worker' ORDER BY `cod.SAP` ASC, `observatii` ASC";
if($readrun = mysql_query($read))
{
	if(mysql_num_rows($readrun) > 0 && ($worker == '' || $worker == 'Angajat INEXISTENT'))
	{
	    $readgo = "DELETE FROM `bon_consum_tmp` WHERE `nume` = '$worker'";
	    if($gorun = mysql_query($readgo)) echo '<TR>';
	    else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
    else
	{
		$readVALBON = 0; $readSAPCODE = '';
		while($readrow = mysql_fetch_assoc($readrun))
	    {
		    $readWORKER = $readrow['nume'];
		    $readPRODUCT = $readrow['produs'];
//APLICAM UN FIX LA STOC, DE ASEMENEA, SA ORDONAM FRUMOS POZITIILE PE BON; PENTRU ASTA, EXTRAGEM STOCUL INITIAL DIN STOCUL MAGAZIEI
		    if($readrow['cod.SAP'] != $readSAPCODE)
		    {
			    $readSAPCODE = $readrow['cod.SAP'];
			    $grabSTOC = "SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$readSAPCODE'";
			    if($grabSTOCrun = mysql_query($grabSTOC))
			    {
				    if(mysql_num_rows($grabSTOCrun) > 0)
				    {
					    $grabSTOCrow = mysql_fetch_assoc($grabSTOCrun);
					    $readSTOCK = $grabSTOCrow['cantitate'];
				    }
			    }
			    else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
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
			$readfix = "UPDATE `bon_consum_tmp` SET `stoc` = '$readSTOCK', `stoc.final` = '$readSTOCKend', `val.tot` = '$readVALBON' WHERE `cod.SAP` = '$readSAPCODE' AND `nume` = '$worker' AND `observatii` = '$readOBS'";
		    if($fixrun = mysql_query($readfix))
			{
				$readSTOCK = $readSTOCKend;
            }
                else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
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
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
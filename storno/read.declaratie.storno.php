<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

global $readSAPCODE; global $readVALBON; global $readSAPCODE; global $tableROW;

$read = "SELECT * FROM `declaratie_storno` WHERE `nume` = '$worker' ORDER BY `cod.SAP`, `furnizor`, `valoare`, `motiv`, `observatii`, `processed`";
if($readrun = mysql_query($read))
{
	if(mysql_num_rows($readrun) > 0 && ($worker == '' || $worker == 'Angajat INEXISTENT'))
	{
	    $readgo = "DELETE FROM `declaratie_storno` WHERE `nume` = '$worker'";
	    if($gorun = mysql_query($readgo)) echo '<TR>';
	    else
		{
			$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
    else
	{
		while($readrow = mysql_fetch_assoc($readrun))
	    {
			$tableROW++;
			if($readrow['cod.SAP'] != $readSAPCODE) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.sap.nou.php';
			else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.sap.continue.php';
			/*if($readVALBON != $readVALTOT)
			{
				//DACA VALOAREA BONULUI NU CADE PE VALOAREA PE CARE O AVEM NOI, RECALCULAM SI FACEM MODIFICARILE IN TABEL
			    $readfix = "UPDATE `declaratie_storno` SET `val.tot` = '$readVALBON' WHERE `sap.code` = '$readSAPCODE' AND `worker` = '$worker' AND `gestionar` = '$nume' AND `order.closed` = '0'";
			    if($fixrun = mysql_query($readfix)) {}
                else
				{
    			    $mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			}*/
	    }
	}
}
else
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>

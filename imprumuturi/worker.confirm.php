<?php

if(isset($_GET['barcode']) && !empty($_GET['barcode'])) 
{
	$barcode = $_GET['barcode'];
	if(isset($_GET['marca']) && !empty($_GET['marca'])) $marca = $_GET['marca'];
	if(isset($_GET['seria']) && !empty($_GET['seria'])) $seria = $_GET['seria'];
}

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
$wor = "SELECT `WORKER_ID` FROM `pworker` WHERE `WORKER_Barcode` = '$barcode' AND `WORKER_ID` = '$marca'";
if($worun = mysql_query($wor))
{
    if(mysql_num_rows($worun) > 0)
    {
	    $worow = mysql_fetch_assoc($worun);
	    $woid = $worow['WORKER_ID'];
	    if($woid == $marca)
	    {
		    $upbon = "UPDATE `magazie_imprumuturi` SET `order.closed` = '1' WHERE `marca` = '$woid' AND `order.closed` = '0' AND `serial.nr` = '$seria'";
		    if($upbonrun = mysql_query($upbon))
		    {
			    echo '';
		    }
            else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
	    }
	    else
	    {
		    $warning = '<FONT SIZE = 5><CENTER><B>Something unexpected went wrong!<BR>Cod bare gresit: '.$woid.' pentru '.$marca.'!</B></FONT>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	    }
    }
    else echo 'Cartela angajat gresita!!\nVa rog, introduceti un cod valid!';
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	$_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
<?php

if(isset($_GET['barcode']) && !empty($_GET['barcode'])) 
{
	$barcode = $_GET['barcode'];
	if(isset($_GET['marca']) && !empty($_GET['marca'])) $marca = $_GET['marca'];
	if(isset($_GET['seria']) && !empty($_GET['seria'])) $seria = $_GET['seria'];
}

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if(!$wor = $connect -> query("SELECT `WORKER_ID` FROM `pworker` WHERE `WORKER_Barcode` = '$barcode' AND `WORKER_ID` = '$marca'"))
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
	$_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	mysqli_close($connect);
}
if(mysqli_num_rows($wor) > 0)
{
	$worow = $wor -> fetch_assoc();
	$woid = $worow['WORKER_ID'];
	if($woid == $marca)
	{
		if(!$upbon = $connect -> query("UPDATE `magazie_imprumuturi` SET `order.closed` = '1' WHERE `marca` = '$woid' AND `order.closed` = '0' AND `serial.nr` = '$seria'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			$_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			mysqli_close($connect);
		}
	}
	else
	{
		$warning = '<FONT SIZE = 5><CENTER><B>Something unexpected went wrong!<BR>Cod bare gresit: '.$woid.' pentru '.$marca.'!</B></FONT>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}
}
else echo 'Cartela angajat gresita!!\nVa rog, introduceti un cod valid!';

?>
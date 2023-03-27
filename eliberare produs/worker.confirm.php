<?php

global $marca; global $barcode;

if(isset($_POST['barcode']) && !empty($_POST['barcode']))
{
	$barcode = $_POST['barcode'];
	if(isset($_POST['marca']) && !empty($_POST['marca'])) $marca = $_POST['marca'];
}

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if(!$wor = $connect -> query("SELECT `WORKER_ID` FROM `pworker` WHERE `WORKER_Barcode` = '$barcode' AND `WORKER_ID` = '$marca'"))
{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
if(mysqli_num_rows($wor) > 0)
{
	if(!$upbon = $connect -> query("UPDATE `bon_consum_tmp` SET `processed` = '1' WHERE `marca` = '$marca'"))
	{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	echo 'OK';
}
else echo 'Cartela angajat gresita!!\nVa rog, introduceti un cod valid!';

?>
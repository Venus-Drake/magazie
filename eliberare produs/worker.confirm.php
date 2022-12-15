<?php

global $marca; global $barcode;

if(isset($_POST['barcode']) && !empty($_POST['barcode']))
{
	$barcode = $_POST['barcode'];
	if(isset($_POST['marca']) && !empty($_POST['marca'])) $marca = $_POST['marca'];
}

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
$wor = "SELECT `WORKER_ID` FROM `pworker` WHERE `WORKER_Barcode` = '$barcode' AND `WORKER_ID` = '$marca'";
if($worun = mysql_query($wor))
{
    if(mysql_num_rows($worun) > 0)
    {
	    $upbon = "UPDATE `bon_consum_tmp` SET `processed` = '1' WHERE `marca` = '$marca'";
	    if($upbonrun = mysql_query($upbon))echo 'OK';
     	else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
    else echo 'Cartela angajat gresita!!\nVa rog, introduceti un cod valid!';
}
else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();

?>
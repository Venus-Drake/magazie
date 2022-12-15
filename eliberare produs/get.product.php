<?php

global $stocgrab; global $namegrab;
$other = '-';

if(isset($_POST['prodCHK']) && !empty($_POST['prodCHK']))
{
    $codSAP = $_POST['prodCHK'];
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    $que = "SELECT `denumire`, `cantitate`,`unit_mas`,`detalii`,`stare_transfer` FROM `magazie_uzate` WHERE `cod_sap` = '$codSAP' AND `stare_transfer` != 'Pentru reascutire'";
    if($run = mysql_query($que))
    {
	    if(mysql_num_rows($run) > 0)
	    {
			echo 'OK';
		    while($row = mysql_fetch_assoc($run))
		    {
			    $name = $row['denumire'];
			    $amount = $row['cantitate'];
			    $um = $row['unit_mas'];
			    $detalii = $row['detalii'];
			    $stare = $row['stare_transfer'];
			    echo '^'.$name.'^'.$amount.'^'.$um.'^'.$stare.'^'.$detalii.'^'.$other;
		    }
	    }
	    else 
		{
		    $que = "SELECT `denumire`, `cantitate`, `UM`, `size` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP' AND `cantitate` > '0' ORDER BY `lastRECEIVED` DESC";
		    if($run = mysql_query($que))
		    {
			    if(mysql_num_rows($run) > 0)
			    {
				    echo 'OK';
				    $name = '';
				    $amount = 0;
				    $um = '';
				    $stare = 'Nou';
				    $detalii = '';
				    $other = '';
				    while($row = mysql_fetch_assoc($run))
				    {
					    if($row['denumire'] != $name) $name = $row['denumire'];
					    if($detalii != $row['size']) $detalii = $row['size'];
					    if($um != $row['UM'] && $row['UM'] != '') $um = $row['UM'];
					    $amount = $amount + $row['cantitate'];
				    }
				    if($um == '')$um = 'N.A.';
				    echo '^'.$name.'^'.$amount.'^'.$um.'^'.$stare.'^'.$detalii.'^'.$other;
			    }
			    else echo 'Not found';
		    }
		    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		}
    }
    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
}
else if(isset($_POST['codSAP']) && $_POST['codSAP'] != '')
{
	$grabSAP = $_POST['codSAP'];
	if(isset($_POST['marca']) && $_POST['marca'] != '') $marca = $_POST['marca'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    $wchk = "SELECT `denumire`, `cantitate`, `UM`, `furnizor` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$grabSAP' ORDER BY 'lastRECEIVED' DESC";
	if($wrun = mysql_query($wchk))
	{
	    if(mysql_num_rows($wrun) > 0)
	    {
		    while($wrow = mysql_fetch_assoc($wrun))
		    {
				if($wrow['denumire'] != $namegrab)
				{
					$namegrab = $wrow['denumire'];
		    		$furgrab = $wrow['furnizor'];
		        }
		    	$stocgrab = $stocgrab + $wrow['cantitate'];
		    }
//CAUTAM PRODUSUL INCLUSIV PE BONUL DE COMANDA, SA ACTUALIZAM STOCUL, IN CAZ CA AM BAGAT DEJA O CANTITATE DE PRODUS PE BON
	        $pchkBON = "SELECT `stoc.final` FROM `bon_consum_tmp` WHERE `cod.SAP` = '$grabSAP' AND `marca` = '$marca' AND `processed` = '0' ORDER BY `stoc.final`";
	        if($pchkBONrun = mysql_query($pchkBON))
	        {
			    if(mysql_num_rows($pchkBONrun) > 0)
			    {
				    $pchkBONrow = mysql_fetch_assoc($pchkBONrun);
				    $stocgrab = $pchkBONrow['stoc.final'];
			    }
	        }
	        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    $units = $wrow['UM'];
			echo 'OK^'.$namegrab.'^'.$furgrab.'^'.$stocgrab.'^'.$units.'^6H7^8H7^10H7^'.$marca;
	    }
	    else echo 'Not found';
	}
	else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
}
?>
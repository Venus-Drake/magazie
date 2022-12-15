<?php

global $stocgrab; global $namegrab;
$other = '-';

if(isset($_POST['prodCHK']) && !empty($_POST['prodCHK']))
{
    $codSAP = $_POST['prodCHK'];
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    if(!$que = $connect -> query("SELECT `denumire`, `cantitate`,`unit_mas`,`detalii`,`stare_transfer` FROM `magazie_uzate` WHERE `cod_sap` = '$codSAP' AND `stare_transfer` != 'Pentru reascutire'"))
	{
		die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));
	}
    if(mysqli_num_rows($que) > 0)
	{
		echo 'OK';
		while($row = $que -> fetch_assoc())
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
		if(!$que = $connect -> query("SELECT `denumire`, `cantitate`, `UM`, `size` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP' AND `cantitate` > '0' ORDER BY `lastRECEIVED` DESC"))
		{
			die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
		}
		if(mysqli_num_rows($que) > 0)
		{
			echo 'OK';
			$name = '';
			$amount = 0;
			$um = '';
			$stare = 'Nou';
			$detalii = '';
			$other = '';
			while($row = $que -> fetch_assoc())
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
}
else if(isset($_POST['codSAP']) && $_POST['codSAP'] != '')
{
	$grabSAP = $_POST['codSAP'];
	if(isset($_POST['marca']) && $_POST['marca'] != '') $marca = $_POST['marca'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    if(!$wchk = $connect -> query("SELECT `denumire`, `cantitate`, `UM`, `furnizor` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$grabSAP' ORDER BY 'lastRECEIVED' DESC"))
	{
		die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
	}
	if(mysqli_num_rows($wchk) > 0)
	{
		while($wrow = $wchk -> fetch_assoc())
		{
			if($wrow['denumire'] != $namegrab)
			{
				$namegrab = $wrow['denumire'];
				$furgrab = $wrow['furnizor'];
			}
			$stocgrab = $stocgrab + $wrow['cantitate'];
		}
//CAUTAM PRODUSUL INCLUSIV PE BONUL DE COMANDA, SA ACTUALIZAM STOCUL, IN CAZ CA AM BAGAT DEJA O CANTITATE DE PRODUS PE BON
		if(!$pchkBON = $connect -> query("SELECT `stoc.final` FROM `bon_consum_tmp` WHERE `cod.SAP` = '$grabSAP' AND `marca` = '$marca' AND `processed` = '0' ORDER BY `stoc.final`"))
		{
			die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
		}
		if(mysqli_num_rows($pchkBON) > 0)
		{
			$pchkBONrow = $pchkBON -> fetch_assoc();
			$stocgrab = $pchkBONrow['stoc.final'];
		}
		$units = $wrow['UM'];
		echo 'OK^'.$namegrab.'^'.$furgrab.'^'.$stocgrab.'^'.$units.'^6H7^8H7^10H7^'.$marca;
	}
	else echo 'Not found';
}
?>
<?php

if(isset($_GET['marca']) && !empty($_GET['marca'])) 
{
	$marca = $_GET['marca'];
	if(isset($_GET['seria']) && !empty($_GET['seria'])) $seria = $_GET['seria'];
}
else echo 'Eroare!! Marca nu este setata!';

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';

global $num;

if(!$fin = $connect -> query("SELECT * FROM `magazie_imprumuturi` WHERE `marca` = '$marca' AND `order.closed` = '1'"))
{
	die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');
}
$numfin = mysqli_num_rows($fin);
if($numfin > 0)
{
	while($finrow = $fin -> fetch_assoc())
	{
		$nrCRT = $finrow['nr.crt'];
		$serieBON = $finrow['serial.nr'];
		$motiv = $finrow['motiv'];
		$angajat = $finrow['worker'];
		$sectia = $finrow['sectia'];
		$prod = $finrow['item.name'];
		$sap = $finrow['sap.code'];
		$furnizor = $finrow['furnizor'];
		$val = $finrow['price'];
		$cantitate = $finrow['amount'];
		$units = $finrow['unitate.mas'];
		$val_prod = $finrow['value'];
		$data_bon = date('Y-m-d', strtotime($finrow['date']));
		$ora_bon = date('h:i:s', strtotime($finrow['date']));
		$dataLIMITA = $finrow['end.loan'];
		$obs = $finrow['observatii'];
		if(!$stocout = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$sap'"))
		{die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');}
		if(mysqli_num_rows($stocout) > 0)
		{
			$stocrow = $stocout -> fetch_assoc();	
			$stoc = $stocrow['cantitate'];
			$stoc = $stoc - $cantitate;
			if($stoc >= 0)  
			{
				//FACEM UPDATE LA STOC IN MAGAZIE

				if(!$stocup = $connect -> query("UPDATE `magazie_stoc` SET `cantitate` = '$stoc' WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor' AND `pret` = '$val'"))
				{die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');}
				//INREGISTRAM MISCAREA IN ARHIVA

				if(!$reg = $connect -> query("INSERT INTO `arhiva_miscari_magazie` VALUES('','$serieBON','Imprumut produs','$motiv','$dataLIMITA','$angajat','$marca','$sectia','$prod','$sap','$furnizor','$val','$cantitate','$units','$stoc','$val_prod','$data_bon','$ora_bon','$obs')"))
				{die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');}
				//SCOATEM MISCAREA DE PE BONUL DE COMANDA
				
				if(!$rem = $connect -> query("DELETE FROM `magazie_imprumuturi` WHERE `nr.crt` = '$nrCRT'"))
				{die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');}
				$num++;
				if($num == $numfin) echo 'OK';
			}
			else die('Operatiunea nu poate fi efectuata!%0AStoc negativ pentru '.$sap.'!!');
		}
		else die('Codul '.$sap.' nu a fost gasit!');
	}
}
else
{
	if(!$dchk = $connect -> query("SELECT * FROM `magazie_imprumuturi` WHERE `marca` = '$marca' AND `order.closed` = '0'"))
	{die('MySQL Error: %0A'.__LINE__.". ".__FILE__.":%0A".mysqli_error($connect).'%0APlease, contact program administrator!');}
	if(mysqli_num_rows($dchk) > 0) die('Comanda nu a fost confirmata de catre angajat.%0AVa rog, solicitati confirmarea comenzii!');
	else die('Nu a fost gasita nici o comanda pentru '.$marca.'!');
}

?>
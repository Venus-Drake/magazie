<?php

	if(isset($_GET['codSAP']) && $_GET['codSAP'] != '')
	{
		$grabSAP = $_GET['codSAP'];
		if(isset($_GET['marca']) && $_GET['marca'] != '') $marca = $_GET['marca'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$wchk = $connect -> query("SELECT * FROM `arhiva_miscari_magazie` WHERE `cod.SAP` = '$grabSAP' AND `tip.miscare` = 'Imprumut produs' AND `marca` = '$marca' ORDER BY `data_LIMITA`"))
		{die(__LINE__.'. MySQL error!');}
		if(mysqli_num_rows($wchk) > 0)
		{
			while($wrow = $wchk -> fetch_assoc())
			{
				$product = $wrow['produs'];
				$seria = $wrow['serie_BON'];
				$motiv = $wrow['motiv'];
				$dataEnd = $wrow['data_LIMITA'];
				$furnizor = $wrow['furnizor'];
				$cantitate = $wrow['cantitate'];
				$units = $wrow['units'];
				$pret = $wrow['valoare'];
				$observatii = $wrow['observatii'];
				echo $product.'^'.$seria.'^'.$furnizor.'^'.$cantitate.'^'.$units.'^'.$pret.'^'.$motiv.'^'.$observatii.'^'.$dataEnd.'^';
			}
		}
	}
?>
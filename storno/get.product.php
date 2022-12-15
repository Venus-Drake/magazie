<?php

	if(isset($_GET['codSAP']) && $_GET['codSAP'] != '')
	{
		$grabSAP = $_GET['codSAP'];
		if(isset($_GET['marca']) && $_GET['marca'] != '') $marca = $_GET['marca'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $wchk = "SELECT * FROM `arhiva_miscari_magazie` WHERE `cod.SAP` = '$grabSAP' AND `tip.miscare` = 'Imprumut produs' AND `marca` = '$marca' ORDER BY `data_LIMITA`";
		if($wrun = mysql_query($wchk))
		{
		    if(mysql_num_rows($wrun) > 0)
		    {
			    while($wrow = mysql_fetch_assoc($wrun))
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
		else echo __LINE__.'. MySQL error!';
	}
?>
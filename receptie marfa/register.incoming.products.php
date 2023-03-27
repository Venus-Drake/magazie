<?php

    date_default_timezone_set('Europe/Bucharest');
	 $date = date('Y-m-d', time());
	 $hour = date('h:i:s', time());

    if(isset($_POST['codSAP']) && !empty($_POST['codSAP']) && isset($_POST['furnizor']) && !empty($_POST['furnizor']) && isset($_POST['factura']) && !empty($_POST['factura']) && isset($_POST['facDATE']) && !empty($_POST['facDATE']) && isset($_POST['codFURNIZOR']) && isset($_POST['denumire']) && !empty($_POST['denumire']) && isset($_POST['pret']) && !empty($_POST['pret']) && isset($_POST['cantitate']) && !empty($_POST['cantitate']) && isset($_POST['detalii']) && isset($_POST['units']) && !empty($_POST['units']) && isset($_POST['seriaNOTA']) && !empty($_POST['seriaNOTA']) && isset($_POST['dataNOTA']) && !empty($_POST['dataNOTA']) && isset($_POST['gestionar']) && !empty($_POST['gestionar']) && isset($_POST['magazie']) && !empty($_POST['magazie']) && isset($_POST['grupa']) && !empty($_POST['grupa']) && isset($_POST['cantMIN']) && isset($_POST['cantOPT']))
	{
		$codSAP = strtoupper($_POST['codSAP']);
		$furnizor = $_POST['furnizor'];
		$factura = strtoupper($_POST['factura']);
		$dataFACT = $_POST['facDATE'];
		$codFURNIZOR = strtoupper($_POST['codFURNIZOR']);
		$denumire = strtoupper($_POST['denumire']);
		$pret = $_POST['pret'];
		$cantitate = $_POST['cantitate'];
		$units = strtoupper($_POST['units']);
		$detalii = $_POST['detalii'];
		$magazie = strtoupper($_POST['magazie']);
		$grupa = strtoupper($_POST['grupa']);
		$serieNOTA = strtoupper($_POST['seriaNOTA']);
		$dataNOTA = date('Y-m-d', strtotime($_POST['dataNOTA']));
		$gestionar = strtoupper($_POST['gestionar']);
		$valoare = $pret*$cantitate;
		$cantMIN = $_POST['cantMIN'];
		$cantOPT = $_POST['cantOPT'];
		$dataRECEPTIE = date('Y-m-d h:i:s', strtotime($dataNOTA.' '.$hour));
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		if(!$grab = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		$stoc = 0;
		if(mysqli_num_rows($grab) > 0)
		{
			while($grabROW = $grab -> fetch_assoc())
			{
				$stoc = $grabROW['cantitate'] + $stoc;
			}
			$stoc = $stoc + $cantitate;
		}
		if(!$que = $connect -> query("INSERT INTO `arhiva_miscari_magazie` VALUES('','$serieNOTA','$gestionar','Receptie produs','','','$gestionar','0','MAGAZIE','$denumire','$codSAP','$furnizor','$factura','$dataFACT','$pret','$cantitate','$units','$stoc','$valoare','$dataNOTA','$hour','')"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		if(!$upSTOC = $connect -> query("UPDATE `magazie_stoc` SET `cantitate` = `cantitate` + '$cantitate', `gestionar` = '$gestionar', `lastRECEIVED` = '$dataRECEPTIE' WHERE `size` = '$detalii' AND `furnizor` = '$furnizor' AND `cod_SAP` = '$codSAP' AND `pret` = '$pret'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		if(mysqli_affected_rows($connect) > 0)echo 'OK^'.$codSAP.'^'.$furnizor.'^'.$factura.'^'.$dataFACT.'^'.$codFURNIZOR.'^'.$denumire.'^'.$pret.'^'.$cantitate.'^'.$detalii;
		else
		{
			if(!$inSTOC = $connect -> query("INSERT INTO `magazie_stoc` VALUES('','$denumire','$detalii','$cantitate','$cantMIN','$cantOPT','$units','$furnizor','$magazie','$codSAP','$codFURNIZOR','$grupa','$pret','Receptionat in $dataRECEPTIE','$dataRECEPTIE','$gestionar','0')"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			echo 'OK^'.$codSAP.'^'.$furnizor.'^'.$factura.'^'.$dataFACT.'^'.$codFURNIZOR.'^'.$denumire.'^'.$pret.'^'.$cantitate.'^'.$detalii;
		}
	}
	else echo 'Something is terribly wrong, missy!';

?>
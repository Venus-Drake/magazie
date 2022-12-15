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
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		$grab = "SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP'";
		if($grabRUN = mysql_query($grab))
		{
			$stoc = 0;
			if(mysql_num_rows($grabRUN) > 0)
			{
			    while($grabROW = mysql_fetch_assoc($grabRUN))
			    {
				    $stoc = $grabROW['cantitate'] + $stoc;
			    }
			    $stoc = $stoc + $cantitate;
			}
			$que = "INSERT INTO `arhiva_miscari_magazie` VALUES('','$serieNOTA','$gestionar','Receptie produs','','','$gestionar','0','MAGAZIE','$denumire','$codSAP','$furnizor','$factura','$dataFACT','$pret','$cantitate','$units','$stoc','$valoare','$dataNOTA','$hour','')";
			if($run = mysql_query($que))
			{
				$upSTOC = "UPDATE `magazie_stoc` SET `cantitate` = `cantitate` + '$cantitate', `gestionar` = '$gestionar', `lastRECEIVED` = '$dataRECEPTIE' WHERE `size` = '$detalii' AND `furnizor` = '$furnizor' AND `cod_SAP` = '$codSAP' AND `pret` = '$pret'";
				if($upSTOCrun = mysql_query($upSTOC))
				{
				    if(mysql_affected_rows() > 0)echo 'OK^'.$codSAP.'^'.$furnizor.'^'.$factura.'^'.$dataFACT.'^'.$codFURNIZOR.'^'.$denumire.'^'.$pret.'^'.$cantitate.'^'.$detalii;
					else
					{
					    $inSTOC = "INSERT INTO `magazie_stoc` VALUES('','$denumire','$detalii','$cantitate','$cantMIN','$cantOPT','$units','$furnizor','$magazie','$codSAP','$codFURNIZOR','$grupa','$pret','Receptionat in $dataRECEPTIE','$dataRECEPTIE','$gestionar','0')";
					    if($inSTOCrun = mysql_query($inSTOC))echo 'OK^'.$codSAP.'^'.$furnizor.'^'.$factura.'^'.$dataFACT.'^'.$codFURNIZOR.'^'.$denumire.'^'.$pret.'^'.$cantitate.'^'.$detalii;
                        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					}
				}
				else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			}
			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		}
	}
	else echo 'Something is terribly wrong, missy!';

?>
<?php

global $markNAME;
global $gestionar;

$gestionar = (string) $gestionar;

date_default_timezone_set('Europe/Bucharest');
$Dates = date('Y/m/d h:i:s',time());
$Time = date('h:i:s', time());

if(isset($_POST['numeworker']) && $_POST['numeworker'] != '')
{
	$numeworker = $_POST['numeworker'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$wchk = $connect -> query("SELECT `WORKER_ID`, `WORKER_Name` FROM `pworker` WHERE `WORKER_Name` LIKE '$numeworker%' LIMIT 20"))
	{
		die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
	}
	if(mysqli_num_rows($wchk) > 0)
	{
		echo 'OK^';
		while($wrow = $wchk -> fetch_assoc())
		{
			$mymark = $wrow['WORKER_ID'];
			$myname = $wrow['WORKER_Name'];
			if($myname != $numeworker) echo '<OPTION VALUE = "'.$myname.'">'.$mymark.'</OPTION>';
		}
	}
	else echo 'Name '.$numeworker.' not found!';
}
else if(isset($_POST['workerNAME']) && !empty($_POST['workerNAME']))
{
    $name = $_POST['workerNAME'];
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$que = $connect -> query("SELECT `WORKER_ID`, `sectie` FROM `pworker` WHERE `WORKER_Name` LIKE '$name'"))
	{
		die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
	}
    if(mysqli_num_rows($que) > 0)
	{
		$row = $que -> fetch_assoc();
		$workerID = $row['WORKER_ID'];
		$sectia = $row['sectie'];
		echo 'OK^'.$workerID.'^'.$sectia;
	}
	else echo __LINE__.'. Worker mark for '.$name.' was not found!';
}
else if(isset($_POST['workerID']) && !empty($_POST['workerID']))
{
    $marca = $_POST['workerID'];
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$que = $connect -> query("SELECT `WORKER_Name`, `sectie` FROM `pworker` WHERE `WORKER_ID` = '$marca'"))
	{
		die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
	}
    if(mysqli_num_rows($que) > 0)
	{
		$row = $que -> fetch_assoc();
		$marcNAME = $row['WORKER_Name'];
		$sectia = $row['sectie'];
		if(!$chkORDER  = $connect -> query("SELECT * FROM `bon_consum_tmp` WHERE `marca` = '$marca'"))
		{
			die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
		}
		echo 'OK^'.$marcNAME.'^'.$sectia;
		if(mysqli_num_rows($chkORDER) > 0)
		{
			$seria = '';
			while($chkROW = $chkORDER -> fetch_assoc())
			{
				if($seria == '')
				{
					$seria = $chkROW['serial.nr'];
					echo '^'.$seria;
				}
				$produs = $chkROW['produs'];
				$codeSAP = $chkROW['cod.SAP'];
				$furnizor = $chkROW['furnizor'];
				$uzura = $chkROW['uzura'];
				$unit = $chkROW['unit'];
				$value = $chkROW['valoare'];
				$stocINIT = $chkROW['stoc'];
				$amount = $chkROW['cantitate'];
				$stocEND = $chkROW['stoc.final'];
				$valTOT = $chkROW['val.tot'];
				$obs = $chkROW['observatii'];
				//TREBUIE VERFICAT DACA MAI AVEM PRODUSUL PE STOC, CAUTAT IN FUNCTIE DE NOU SAU UZAT, APOI CAUTATE RESTUL DATELOR(DACA MAI ESTE LA ACELASI PRET, ACELASI FURNIZOR; DACA NU MAI ESTE, TREBUIE CAUTAT IN STOC SI FACUT UPDATE LA RESPECTIVELE VALORI); DACA NU MAI AVEM SUFICIENTA CANTITATE IN STOCURI, FACEM UPDATE LA CANTITATI SI STOCURI, CU MODIFICARILE DE RIGOARE; DACA ESTE NECESARA DEFALCAREA PRODUSULUI PE MAI MULTE POZITII IN URMA MODIFICARILOR, O FACEM ACUM
				if($uzura == 'Nou')
				{
					if(!$chkPROD = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE  `cod_SAP` = '$codeSAP' AND `cantitate` > '0' AND `furnizor` = '$furnizor' AND `pret` = '$value'"))
					{
						die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect))	;
					}
					if(mysqli_num_rows($chkPROD) == 0)
					{
						//NU AM MAI GASIT PRODUSUL LA ACELASI FURNIZOR SI PRET; CAUTAM ALTE VARIANTE
						if(!$chkPROD = $connect -> query("SELECT `cantitate`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$codeSAP' AND `cantitate` > '0' ORDER BY `cantitate` DESC"))
						{
							die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));
						}
						if(mysqli_num_rows($chkPROD) > 0)
						{
							//RECALCULAM STOCUL
							$stocINIT = 0;
							$valBON = 0;
							while($chkPRODrow = $chkPROD -> fetch_assoc())
							{
								$stocDB = $chkPRODrow['cantitate'];
								$stocINIT = $stocINIT + $stocDB;
								if($stocINIT >= $amount)
								{
									//1. AVEM SUFICIENT PRODUS LA ACEST FURNIZOR;
									//2. VERIFICAM PRETUL; DACA ESTE ACELASI IL LASAM IN PACE, DACA NU, IL MODIFICAM
									//3. MODIFICAM FURNIZORUL INITIAL DIN BONUL DE CONSUM SI PRETUL
								}
								else
								{
									//1. NU AVEM SUFICIENT PRODUS LA ACEST FURNIZOR/ PRET
									//2. CALCULAM CANTITATEA DE SCAZUT DIN CANTITATEA DE ELIBERAT
									//3. CALCULAM CAT PRODUS MAI AVEM DE ELIBERAT
									//4. VERIFICAM PRETUL; DACA ESTE ACELASI, IL LASAM IN PACE SI RECALCULAM DOAR VALOAREA TOTALA A POZITIEI SI A BONULUI; DACA NU, IL MODIFICAM SI MODIFICAM INCLUSIV VALOAREA TOTALA A POZITIEI SI A BONULUI;
									$furDB = $chkPRODrow['furnizor'];
									$amountDB = $stocDB;
									$amountREM = $amount - $amountDB;
									if($value != $chkPRODrow['pret']) 
									{
										$valueDB = $chkPRODrow['pret'];
										$valTOT = $value * $amountDB;
										$valBON = $valBON + $valTOT;
									}
									else 
									{
										$valTOT = $valueDB * $amountDB;
										$valBON = $valBON + $valTOT;
									}
									//5. INCERCAM SA FACEM UPDATE LA FURNIZORUL INITIAL
									if(!$upPROD = $connect -> query("UPDATE `bon_consum_tmp` SET `furnizor` = '$furDB', `cantitate` = '$amountDB', `pret` = '$valueDB', `val.prod` = '$valTOT' WHERE `cod.SAP` = '$codeSAP' AND `furnizor` = '$furnizor' AND `pret` = '$value'"))
									{
										die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));
									}
									if(mysqli_affected_rows($connect) == 0)
									{
										//6. FURNIZORUL INITIAL NU MAI EXISTA; INSERAM O POZITIE NOUA
										if(!$upPROD = $connect -> query("INSERT INTO `bon_consum_tmp` VALUES('','$seria','$markNAME','$marca','$sectia','$gestionar','$produs','$codeSAP','$furDB','$uzura','$unit','$valueDB','$stocDB','$amountDB','0','$valTOT','$valBON','0','$Dates','$Time','$obs')"))
										{
											die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
										}
										$value = $valueDB;
									}
									else
									{
										//6. AM FACUT UPDATE LA FURNIZORUL INITIAL
									}
								}
							}
						}
						else
						{
							//NU AM MAI GASIT PRODUSUL PE STOC; STERGEM POZITIA DE PE BON
							if(!$delPROD = $connect -> query("DELETE FROM `bon_consum_tmp` WHERE `cod.SAP` = '$codeSAP'"))
							{
								die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
							}
						}
					}
				}
				echo '^'.$produs.'^'.$codeSAP.'^'.$furnizor.'^'.$uzura.'^'.$unit.'^'.$value.'^'.$stocINIT.'^'.$amount.'^'.$stocEND.'^'.$valTOT.'^'.$obs;
			}
		}
	}
	else echo __LINE__.'. Worker mark '.$marca.' not found!';
}
else if(isset($_POST['worker']) && $_POST['worker'] != '')
{
	$marca = $_POST['worker'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	if(!$wchk = $connect -> query("SELECT `WORKER_ID`, `WORKER_Name` FROM `pworker` WHERE `WORKER_ID` LIKE '$marca%' LIMIT 20"))
	{
		die(__LINE__ . '. MySQL error in ' . __FILE__ . ': ' . mysqli_error($connect));	
	}
	if(mysqli_num_rows($wchk) > 0)
	{
		echo 'OK^';
		while($wrow = $wchk -> fetch_assoc())
		{
			$mymark = $wrow['WORKER_ID'];
			$myname = $wrow['WORKER_Name'];
			if($mymark != $marca) echo '<OPTION VALUE = "'.$mymark.'">'.$myname.'</OPTION>';
		}
	}
}

?>
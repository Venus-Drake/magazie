<?php

if(isset($_POST['marca']) && !empty($_POST['marca'])) $marca = $_POST['marca'];
else echo 'Error!!';

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

global $num; global $stoc; global $tmpAMOUNT;

if(!$que = $connect -> query("SELECT * FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `processed` = '1'"))
{
	die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
}
if(mysqli_num_rows($que) > 0)
{
	while($row = $que -> fetch_assoc())
	{
		$seria = $row['serial.nr'];
		$nume = $row['gestionar'];
		$angajat = $row['nume'];
		$sectia = $row['sectia'];
		$prod = $row['produs'];
		$sap = $row['cod.SAP'];
		$furnizor = $row['furnizor'];
		$uzura = $row['uzura'];
		$units = $row['unit'];
		$value = $row['valoare'];
		$cantitate = $row['cantitate'];
		$val_prod = $row['val.prod'];
		$data_bon = $row['data'];
		$ora_bon = $row['ora'];
		$obs = $row['observatii'];
		if($uzura == 'Nou') 
		{
			$getMAIN = "SELECT `cantitate`, `lastRECEIVED` FROM `magazie_stoc` WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor' AND `pret` = '$value' AND `cantitate` > '0' ORDER BY `lastRECEIVED`";
			if($getMAINrun = mysql_query($getMAIN))
			{
				if(mysql_num_rows($getMAINrun) > 0)
				{
					while($getMAINrow = mysql_fetch_assoc($getMAINrun))
					{
						$baseSTOCK = $getMAINrow['cantitate'];
						if($baseSTOCK >= $cantitate)
						{
							$endSTOCK = $baseSTOCK - $cantitate;
							$receptionat = $getMAINrow['lastRECEIVED'];
							$updateMAG = "UPDATE `magazie_stoc` SET `cantitate` = '$endSTOCK' WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor' AND `pret` = '$value' AND `lastRECEIVED` = '$receptionat'";
							if($magRUN = mysql_query($updateMAG))
							{
								if(mysql_affected_rows() > 0)
								{
									$reg = "INSERT INTO `arhiva_miscari_magazie` VALUES('','$seria','$nume','Eliberare produs','','','$angajat','$marca','$sectia','$prod','$sap','$furnizor','','','$value','$cantitate','$units','$endSTOCK','$val_prod','$data_bon','$ora_bon','$obs')";
									if($regrun = mysql_query($reg))
									{
										$rem = "DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$sap' AND `data` = '$data_bon' AND `ora` = '$ora_bon'";
										if($remrun = mysql_query($rem))
										{
											if(mysql_affected_rows() == 0) die('Product could not be removed from receipt.');
										}
										else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());
									}
									else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());
								}
							}
							else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());
						}
						else
						{
							echo 'We have a problem! Stock has changed';
							break;
						}
					}
				}
				else
				{
					echo 'Product not found';
					break;
				}
			}
			else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());
		}
		else 
		{
			die('Extragem produsul din magazia uzate');
		}
		/*$stocout = "SELECT `cantitate`, `furnizor` FROM `magazie_stoc` WHERE `cod_SAP` = '$sap' ORDER BY `cantitate` DESC";
		if($stocrun = mysql_query($stocout))
		{
			if(mysql_num_rows($stocrun) > 0)
			{
				while($stocrow = mysql_fetch_assoc($stocrun))
				{
					$stoc = $stoc + $stocrow['cantitate'];
					if($furnizor == $stocrow['furnizor'])
					{
						if($stoc >= $cantitate)
						{
							$stoc = $stoc - $cantitate;
							$stocup = "UPDATE `magazie_stoc` SET `cantitate` = '$stoc' WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor'";
							if($stocuprun = mysql_query($stocup))
							{
								//INREGISTRAM MISCAREA IN ARHIVA
								$reg = "INSERT INTO `arhiva_miscari_magazie` VALUES('','$seria','$nume','Eliberare produs','','','$angajat','$marca','$sectia','$prod','$sap','$furnizor','','','$val','$cantitate','$units','$stoc','$val_prod','$data_bon','$ora_bon','$obs')";
								if($regrun = mysql_query($reg))
								{
									//SCOATEM MISCAREA DE PE BONUL DE COMANDA
									$rem = "DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$sap' AND `data` = '$data_bon' AND `ora` = '$ora_bon'";
									if($remrun = mysql_query($rem))
									{
										$num++;
										if($num == $numfin) echo 'OK';
									}
									else{echo 'MySQL Error:'.__LINE__.". ".__FILE__.":".mysql_error().'Please, contact program administrator!';break;}
								}
								else{echo 'MySQL Error:'.__LINE__.". ".__FILE__.":".mysql_error().'Please, contact program administrator!';break;}
							}
							else{echo'MySQL Error:'.__LINE__.". ".__FILE__.":".mysql_error().'Please, contact program administrator!';break;}
						}
						else
						{
							$tmpAMOUNT = $cantitate - $stoc;
							$stoc = $stoc - $cantitate;
							$stocup = "UPDATE `magazie_stoc` SET `cantitate` = '0' WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor'";
							if($stocUPrun = mysql_query($stocup))
							{
								echo 'My new stock: '.$stoc;	
							}
							else{echo'MySQL Error:'.__LINE__.". ".__FILE__.":".mysql_error().'Please, contact program administrator!';break;}
						}
					}
				if($stoc >= 0)  //FACEM UPDATE LA STOC IN MAGAZIE
				{
					$stocup = "UPDATE `magazie_stoc` SET `cantitate` = '$stoc' WHERE `cod_SAP` = '$sap'";
					if($stocuprun = mysql_query($stocup))
					{
						$reg = "INSERT INTO `arhiva_miscari_magazie` VALUES('','$seria','$nume','Eliberare produs','','','$angajat','$marca','$sectia','$prod','$sap','$furnizor','','','$val','$cantitate','$units','$stoc','$val_prod','$data_bon','$ora_bon','$obs')";
						if($regrun = mysql_query($reg))
						{
							//SCOATEM MISCAREA DE PE BONUL DE COMANDA
							$rem = "DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` = '$sap' AND `data` = '$data_bon' AND `ora` = '$ora_bon'";
							if($remrun = mysql_query($rem))
							{
								$num++;
								if($num == $numfin) echo 'OK';
							}
							else{echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();break;}
						}
						else{echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();break;}
					}
					else{echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();break;}
				}
				else{echo 'Operatiunea nu poate fi efectuata! Stoc negativ pentru '.$sap.'!!';break;}
			}
		}
		else {echo 'Codul '.$sap.' nu a fost gasit!';break;}
		}
		else{else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();break;} */
	}
	echo 'OK';
}
else
{
	$dchk = "SELECT * FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `processed` = '0'";
	if($dchkrun = mysql_query($dchk))
	{
		if(mysql_num_rows($dchkrun) > 0)echo 'Worker confirm';
	}
	else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
}

?>
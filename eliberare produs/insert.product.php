<?php

global $amountREM;

if(isset($_POST['sapTOadd']) && !empty($_POST['sapTOadd']) && isset($_POST['prodNAME']) && !empty($_POST['prodNAME']) && isset($_POST['furnizor']) && isset($_POST['stoc']) && !empty($_POST['stoc']) && isset($_POST['units']) && !empty($_POST['units']) && isset($_POST['amount']) && !empty($_POST['amount']) && isset($_POST['marca']) && !empty($_POST['marca']) && isset($_POST['nume']) && !empty($_POST['nume']) && isset($_POST['uzura']) && !empty($_POST['uzura']) && isset($_POST['serieBON']) && !empty($_POST['serieBON']) && isset($_POST['sectia']) && !empty($_POST['sectia']) && isset($_POST['gestionar']) && !empty($_POST['gestionar']) && isset($_POST['observatii']))
{
	date_default_timezone_set('Europe/Bucharest');
	$Dates = date('Y/m/d h:i:s',time());
	$Time = date('h:i:s', time());
	$marca = $_POST['marca'];
	$worker = $_POST['nume'];
	$sapCODE = strtoupper($_POST['sapTOadd']);
	$sapNAME = $_POST['prodNAME'];
	$furnizor = $_POST['furnizor'];
	$stock = $_POST['stoc'];
	$units = $_POST['units'];
	$amount = $_POST['amount'];
	$uzura = $_POST['uzura'];
	$seria = $_POST['serieBON'];
	$stocINSERT = $stock - $amount;           //!!!!!!!!!!!!!!
	$sectia = $_POST['sectia'];
	$gestionar = $_POST['gestionar'];
	$observatii = $_POST['observatii'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	//AM MAI INTRODUS PRODUSUL PE BON?
	$bonCHK = "SELECT `cantitate`, `valoare` FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` LIKE '$sapCODE' AND `furnizor` = '$furnizor' AND `uzura` = '$uzura' AND `observatii` = '$observatii'";
	if($bonCHKrun = mysql_query($bonCHK))
	{
	    if(mysql_num_rows($bonCHKrun) > 0)
	    {
			//PRODUSUL A FOST INREGISTRAT, DEJA, CU DATELE FURNIZATE; VERIFICAM DACA MAI AVEM PE STOC, LA ACELASI FURNIZOR, PRET, TINAND CONT DE METODA FIFO;
			$bonCHKrow = mysql_fetch_assoc($bonCHKrun);
			$foundAMOUNT = $bonCHKrow['cantitate'];
			$foundPRICE = $bonCHKrow['valoare'];
			$prodCHK = "SELECT `cantitate`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' AND `cantitate` > '0' ORDER BY `lastRECEIVED`";
			if($prodCHKrun = mysql_query($prodCHK))
			{
				if(mysql_num_rows($prodCHKrun) > 0)
				{
					//INCA AVEM PRODUSUL PE STOC; ESTE ACELASI FURNIZOR SI ACELASI PRET?
					while($prodCHKrow = mysql_fetch_assoc($prodCHKrun))
					{
						$prodAMOUNT = $prodCHKrow['cantitate'];
						$prodFUR = $prodCHKrow['furnizor'];
						$prodPRET = $prodCHKrow['pret'];
						if($prodFUR == $furnizor && $prodPRET == $foundPRICE)
						{
						    //INCA MAI AVEM LA ACEST FURNIZOR SI ACEST PRET; CANTITATEA ESTE SUFICIENTA?
							if($prodAMOUNT >= $foundAMOUNT + $amount)
							{
							    //AVEM SUFICIENTA CANTITATE IN STOC, INCAT SA ACOPERIM TOATA CANTITATEA DE ELIBERAT; FACEM UPDATE LA BAZA DE DATE
							    $prodTOTAL = $foundAMOUNT + $amount;
							    $prodFIN = $stock - $prodTOTAL;
							    $pretTOTAL = $prodTOTAL * $prodPRET;
							    $updateDB = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
							    if($upRUN = mysql_query($updateDB))
							    {
								    if(mysql_affected_rows() > 0)echo 'OK^updated';
								    else echo __LINE__.'. Product not updated^';
							    }
                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
							    break;
							}
							else if($prodAMOUNT > $foundAMOUNT && $prodAMOUNT < $foundAMOUNT + $amount)
							{
							    //AVEM SUFICIENTA CANTITATE IN STOC PENTRU A ACOPERI ELIBERAREA PRODUSULUI DEJA INREGISTRAT, DAR NU SI PE CEL NOU;
							    //FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA DE ACEST FURNIZOR
								$prodTOTAL = $prodAMOUNT;
								$prodFIN = $stock - $prodAMOUNT;
								$pretTOTAL = $prodAMOUNT * $prodPRET;
								$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
							    if($upRUNsec = mysql_query($updateDBsec))
							    {
								    if(mysql_affected_rows() > 0)
									{
										$amountREM = ($foundAMOUNT + $amount) - $prodAMOUNT;
									}
								    else echo __LINE__.'. Product not updated^';
							    }
                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
							}
							else if($prodAMOUNT < $foundAMOUNT)
							{
							    //NU MAI AVEM SUFICIENTA CANTITATE IN STOC, NICI MACAR PENTRU A ACOPERI CANTITATEA DEJA INTRODUSA.
								//FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA SI LASAM LOOP-UL SA MEARGA MAI DEPARTE, SA ACOPERIM DE LA ALTI FURNIZORI, CREAND NOI POZITII IN TABEL
								$prodTOTAL = $prodAMOUNT;
								$prodFIN = $stock - $prodAMOUNT;
                                $pretTOTAL = $prodAMOUNT * $prodPRET;
								$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
							    if($upRUNsec = mysql_query($updateDBsec))
							    {
								    if(mysql_affected_rows() > 0)
								    {
										$amountREM = ($foundAMOUNT + $amount) - $prodAMOUNT;
									}
								    else echo __LINE__.'. Product not updated';
							    }
                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
							}
							else if($prodAMOUNT == $foundAMOUNT) $amountREM = $amount;
						}
						else if($prodFUR != $furnizor)
						{
						    //NU MAI AVEM LA ACEST FURNIZOR; TRECEM LA URMATOAREA POZITIE 
						    //VERIFICAM DACA AVEM PRODUS RAMAS DE ADAUGAT
						    if($amountREM > 0)
						    {
							    die(__LINE__.'. We have more '.$amountREM.' product to add');
							    if($amountREM == $amount)
							    if($prodAMOUNT >= $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC, INCAT SA ACOPERIM TOATA CANTITATEA DE ELIBERAT; FACEM UPDATE LA BAZA DE DATE
								    $prodTOTAL = $foundAMOUNT + $amountREM;
								    $prodFIN = $stock - $prodTOTAL;
								    $pretTOTAL = $prodTOTAL * $prodPRET;
								    $bonVALUE = "SELECT `val.tot` FROM `bon_consum_tmp` WHERE `serial.nr` = '$seria' ORDER BY `val.tot` DESC";
									if($bonVALUErun = mysql_query($bonVALUE))
									{
										$valINSERT = $amount * $prodPRET;
									    if(mysql_num_rows($bonVALUErun) > 0)
									    {
										    $bonVALUErow = mysql_fetch_assoc($bonVALUErun);
										    $valBON = $bonVALUErow['val.tot'] + $pretTOTAL;
									    }
									    else $valBON = $valINSERT;
									}
									else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								    $newINSERT = "INSERT INTO `bon_consum_tmp` VALUES('','$seria','$worker','$marca','$sectia','$gestionar','$sapNAME','$sapCODE','$prodFUR','$uzura','$units','$prodPRET','$stock','$amountREM','$prodFIN','$pretTOTAL','$valBON','0','$Dates','$Time','$observatii')";
									if($newINSERTrun = mysql_query($newINSERT))
									{
										echo 'OK^updated';
									}
					    			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								    break;
								}
								else if($prodAMOUNT >= $foundAMOUNT && $prodAMOUNT < $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC PENTRU A ACOPERI ELIBERAREA PRODUSULUI DEJA INREGISTRAT, DAR NU SI PE CEL NOU;
								    //FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA DE ACEST FURNIZOR
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
									$pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
										{
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
								else if($prodAMOUNT < $foundAMOUNT)
								{
								    //NU MAI AVEM SUFICIENTA CANTITATE IN STOC, NICI MACAR PENTRU A ACOPERI CANTITATEA DEJA INTRODUSA.
									//FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA SI LASAM LOOP-UL SA MEARGA MAI DEPARTE, SA ACOPERIM DE LA ALTI FURNIZORI, CREAND NOI POZITII IN TABEL
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
	                                $pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
									    {
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
						    }
						    else
						    {
							    die(__LINE__.'. Switching supplier to '.$prodFUR);
							    //ASTA NU ESTE CONTINUARE DE INSERARE; TREBUIE VERIFICATI FURNIZORII INSERATI DEJA, SA VEDEM DACA PRODUSELE INSERATE INCA EXISTA IN MAGAZIE
							    if($prodAMOUNT >= $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC, INCAT SA ACOPERIM TOATA CANTITATEA DE ELIBERAT; FACEM UPDATE LA BAZA DE DATE
								    $prodTOTAL = $foundAMOUNT + $amountREM;
								    $prodFIN = $stock - $prodTOTAL;
								    $pretTOTAL = $prodTOTAL * $prodPRET;
								    $newINSERT = "INSERT INTO `bon_consum_tmp` VALUES('','$seria','$worker','$marca','$sectia','$gestionar','$sapNAME','$sapCODE','$prodFUR','$uzura','$units','$prodPRET','$stock','$amountREM','$stocINSERT','$valINSERT','$valBON','0','$Dates','$Time','$observatii')";
									if($newINSERTrun = mysql_query($newINSERT))
									{
										echo 'OK^updated';
									}
					    			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								    break;
								}
								else if($prodAMOUNT >= $foundAMOUNT && $prodAMOUNT < $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC PENTRU A ACOPERI ELIBERAREA PRODUSULUI DEJA INREGISTRAT, DAR NU SI PE CEL NOU;
								    //FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA DE ACEST FURNIZOR
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
									$pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
										{
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
								else if($prodAMOUNT < $foundAMOUNT)
								{
								    //NU MAI AVEM SUFICIENTA CANTITATE IN STOC, NICI MACAR PENTRU A ACOPERI CANTITATEA DEJA INTRODUSA.
									//FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA SI LASAM LOOP-UL SA MEARGA MAI DEPARTE, SA ACOPERIM DE LA ALTI FURNIZORI, CREAND NOI POZITII IN TABEL
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
	                                $pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
									    {
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
						    }
						    if($prodPRET == $foundPRICE)
						    {
							    if($prodAMOUNT >= $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC, INCAT SA ACOPERIM TOATA CANTITATEA DE ELIBERAT; FACEM UPDATE LA BAZA DE DATE
								    $prodTOTAL = $foundAMOUNT + $amount;
								    $prodFIN = $stock - $prodTOTAL;
								    $pretTOTAL = $prodTOTAL * $prodPRET;
								    $updateDB = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUN = mysql_query($updateDB))
								    {
									    if(mysql_affected_rows() > 0)echo 'OK^updated';
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								    break;
								}
								else if($prodAMOUNT >= $foundAMOUNT && $prodAMOUNT < $foundAMOUNT + $amount)
								{
								    //AVEM SUFICIENTA CANTITATE IN STOC PENTRU A ACOPERI ELIBERAREA PRODUSULUI DEJA INREGISTRAT, DAR NU SI PE CEL NOU;
								    //FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA DE ACEST FURNIZOR
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
									$pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
										{
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
								else if($prodAMOUNT < $foundAMOUNT)
								{
								    //NU MAI AVEM SUFICIENTA CANTITATE IN STOC, NICI MACAR PENTRU A ACOPERI CANTITATEA DEJA INTRODUSA.
									//FACEM UPDATE LA BAZA DE DATE PE CANTITATEA ACOPERITA SI LASAM LOOP-UL SA MEARGA MAI DEPARTE, SA ACOPERIM DE LA ALTI FURNIZORI, CREAND NOI POZITII IN TABEL
									$prodTOTAL = $prodAMOUNT;
									$prodFIN = $stock - $prodAMOUNT;
	                                $pretTOTAL = $prodAMOUNT * $prodPRET;
									$updateDBsec = "UPDATE `bon_consum_tmp` SET `cantitate` = '$prodTOTAL', `val.prod` = '$pretTOTAL', `stoc.final` = '$prodFIN' WHERE `marca` = '$marca' AND `cod.SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `valoare` LIKE '$foundPRICE' AND `observatii` = '$observatii'";
								    if($upRUNsec = mysql_query($updateDBsec))
								    {
									    if(mysql_affected_rows() > 0)
									    {
											$amount = ($foundAMOUNT + $amount) - $prodAMOUNT;
										}
									    else echo __LINE__.'. Product not updated';
								    }
	                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
						    }
						}
	  			    }
		        }
		    }
		    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
		else
		{
		    //PRODUSUL NU A FOST INREGISTRAT CU DATELE FURNIZATE; A FOST INSERAT CU ALTE DATE?
		    $sapCHK = "SELECT `cantitate` FROM `bon_consum_tmp` WHERE `marca` = '$marca' AND `cod.SAP` LIKE '$sapCODE'";
		    if($sapCHKrun = mysql_query($sapCHK))
		    {
				$foundAMOUNT = 0;
			    if(mysql_num_rows($sapCHKrun) > 0)
			    {
				    while($sapCHKrow = mysql_fetch_assoc($sapCHKrun))
				    {
				        $foundAMOUNT = $foundAMOUNT + $sapCHKrow['cantitate'];
				    }
				    $prodTOTAL = $foundAMOUNT + $amount;
				    if($stock - $prodTOTAL >= 0)
				    {
					    $prodCHK = "SELECT `cantitate`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' AND `cantitate` > '0' ORDER BY `lastRECEIVED`";
	                	if($prodCHKrun = mysql_query($prodCHK))
	                	{
						    if(mysql_num_rows($prodCHKrun) > 0)
							{
							    	
							}
							else echo __LINE__.'. Not enough';
                        }
                        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
				    }
				    else echo __LINE__.'. Not enough';
			    }
			    else 
				{
					$foundAMOUNT = $amount;
					$prodTOTAL = $amount;
				}

			    //MAI AVEM SUFICIENT PE STOC?
			    if($stock - $prodTOTAL >= 0)
			    {
	                if($uzura == 'Nou')
					{
						$prodCHK = "SELECT `cantitate`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' AND `cantitate` > '0' ORDER BY `lastRECEIVED`";
		                if($prodCHKrun = mysql_query($prodCHK))
		                {
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/get.bon.value.php';
						    if(mysql_num_rows($prodCHKrun) > 0)
						    {
								$foundSTOC = 0;
								while($prodCHKrow = mysql_fetch_assoc($prodCHKrun))
								{
								    $furSTOC = $prodCHKrow['cantitate'];
									$furnizor = $prodCHKrow['furnizor'];
								    $prodPRET = $prodCHKrow['pret'];
								    $valINSERT = $amount * $prodPRET;
								    $stock = $stock - $foundAMOUNT;
								    $stocINSERT = $stock - $amount;
								    $valBON = $valBON + $valINSERT;
								    $newINSERT = "INSERT INTO `bon_consum_tmp` VALUES('','$seria','$worker','$marca','$sectia','$gestionar','$sapNAME','$sapCODE','$furnizor','$uzura','$units','$prodPRET','$stock','$amount','$stocINSERT','$valINSERT','$valBON','0','$Dates','$Time','$observatii')";
									if($newINSERTrun = mysql_query($newINSERT))
									{
										if($furSTOC >= $prodTOTAL || $foundSTOC >= $prodTOTAL) die('OK^');
									}
					    			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
						    }
						    else echo 'Not enough';
		                }
		                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		            }
		            //PRODUS UZAT
		            else
		            {
					    $prodCHK = "SELECT `cantitate`, `pret` FROM `magazie_uzate` WHERE `cod_sap` = '$sapCODE' AND `cantitate` > '0' ORDER BY `data_transfer`";
		                if($prodCHKrun = mysql_query($prodCHK))
		                {
						    if(mysql_num_rows($prodCHKrun) > 0)
						    {
								$foundSTOC = 0;
								require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/get.bon.value.php';
								while($prodCHKrow = mysql_fetch_assoc($prodCHKrun))
								{
								    $furSTOC = $prodCHKrow['cantitate'];
								    $prodPRET = $prodCHKrow['pret'];
								    if($furSTOC - $amount >= 0)
								    {
									    $stocINSERT = $stock - $amount;
									    $valINSERT = $amount * $prodPRET;
									    $valBON = $valBON + $valINSERT;
									    $newINSERT = "INSERT INTO `bon_consum_tmp` VALUES('','$seria','$worker','$marca','$sectia','$gestionar','$sapNAME','$sapCODE','$furnizor','$uzura','$units','$prodPRET','$stock','$amount','$stocINSERT','$valINSERT','$valBON','0','$Dates','$Time','$observatii')";
										if($newINSERTrun = mysql_query($newINSERT))
										{
											if($furSTOC >= $prodTOTAL || $foundSTOC >= $prodTOTAL) die('OK^');
										}
						    			else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());
									}
									else die('Not done yet!');
								}
						    }
						    else echo 'Not enough';
		                }
		                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
                    }
                }
                else echo 'Not enough';
		    }
		    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();

		}
	}
	else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	/*//CAUTAM PRETUL / PRETURILE
	$VALchk = "SELECT `cantitate`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' AND `furnizor` = '$furnizor' AND `cantitate` > '0' ORDER BY `lastRECEIVED`";
	if($VALchkRUN = mysql_query($VALchk))
	{
		//1. VERIFICAM DACA AVEM PRODUSUL LA FURNIZORUL SETAT IN FORMULAR
		//    - DACA AVEM PRODUSUL:
		
		if(mysql_num_rows($VALchkRUN) > 0)
		{
			$VALchkROW = mysql_fetch_assoc($VALchkRUN);
			$cant = $VALchkROW['cantitate'];
			$price = $VALchkROW['pret'];
			if($amount <= $cant)
			{
			    $valINSERT = $price * $amount;
			    $bonVALUE = "SELECT `val.tot` FROM `bon_consum_tmp` WHERE `serial.nr` = '$seria' ORDER BY `val.tot` DESC";
				if($bonVALUErun = mysql_query($bonVALUE))
				{
				    if(mysql_num_rows($bonVALUErun) > 0)
				    {
					    $bonVALUErow = mysql_fetch_assoc($bonVALUErun);
					    $valBON = $bonVALUErow['val.tot'] + $valINSERT;
				    }
				    else $valBON = $valINSERT;
				}
				else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			}
			else 
			{
				$valINSERT = $price * $cant;
				$bonVALUE = "SELECT `val.tot` FROM `bon_consum_tmp` WHERE `serial.nr` = '$seria' ORDER BY `val.tot` DESC";
				if($bonVALUErun = mysql_query($bonVALUE))
				{
				    if(mysql_num_rows($bonVALUErun) > 0)
				    {
					    $bonVALUErow = mysql_fetch_assoc($bonVALUErun);
					    $valBON = $bonVALUErow['val.tot'] + $valINSERT;
				    }
				    else $valBON = $valINSERT;
				}
				else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			}
		    $que = "SELECT * FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
		    if($run = mysql_query($que))
		    {
			    $queBONchk = "SELECT * FROM `bon_consum_tmp` WHERE `cod.SAP` = '$sapCODE'";
			    if($queBONchkRUN = mysql_query($queBONchk))
			    {
					if(mysql_num_rows($queBONchkRUN) > 0)
					{
				        echo 'OK^';
				    }
				    else
				    {
					    $newINSERT = "INSERT INTO `bon_consum_tmp` VALUES('','$seria','$worker','$marca','$sectia','$gestionar','$sapNAME','$sapCODE','$furnizor','$uzura','$units','$price','$stock','$amount','$stocINSERT','$valINSERT','$valBON','0','$Dates','$Time','$observatii')";
						if($newINSERTrun = mysql_query($newINSERT)){echo 'OK^';}
		    			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
				    }
			    }
		        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
		    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
    }
    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error(); */
}
else die(__LINE__.'. Something is wrong...');

?>
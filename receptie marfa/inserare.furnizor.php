<?php
	//email='+document.getElementById('emailFURNIZORnou').value+'&departament
    if(isset($_POST['numeFURNIZOR']) && !empty($_POST['numeFURNIZOR']))
    {
		if(isset($_POST['codFURNIZOR']) && !empty($_POST['codFURNIZOR']))
		{
  		    if(isset($_POST['locFURNIZOR']) && !empty($_POST['locFURNIZOR']))
  			{
				if(isset($_POST['codPOSTAL']) && !empty($_POST['codPOSTAL']))
				{
					if(isset($_POST['strada']) && !empty($_POST['strada']))
					{
						if(isset($_POST['nrSTR']) && !empty($_POST['nrSTR']))
						{
							if(isset($_POST['judet']) && !empty($_POST['judet']))
							{
								if(isset($_POST['tara']) && !empty($_POST['tara']))
								{
									if(isset($_POST['apelativ']) && !empty($_POST['apelativ']))
									{
										if(isset($_POST['persoana']) && !empty($_POST['persoana']))
										{
											if(isset($_POST['telefon']) && !empty($_POST['telefon']))
											{
												if(isset($_POST['email']) && !empty($_POST['email']))
												{
													if(isset($_POST['departament']) && !empty($_POST['departament']))
													{
														$numeFUR = strtoupper($_POST['numeFURNIZOR']);
														$index = strpos($numeFUR,' ');
														$chkFUR = substr($numeFUR,0,$index);
														$codFUR = $_POST['codFURNIZOR'];
														$locFUR = ucwords(strtolower($_POST['locFURNIZOR']));
														$cpFUR = $_POST['codPOSTAL'];
														$strFUR = ucwords(strtolower($_POST['strada']));
														$nrstrFUR = strtoupper($_POST['nrSTR']);
														$judFUR = ucwords(strtolower($_POST['judet']));
														$taraFUR = ucwords(strtolower($_POST['tara']));
														$apelFUR = $_POST['apelativ'];
														$persFUR = ucwords(strtolower($_POST['persoana']));
														$telFUR = $_POST['telefon'];
														$mailFUR = $_POST['email'];
														$depFUR = ucwords(strtolower($_POST['departament']));
														require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
														$chk = "SELECT `furnizor` FROM `furnizori_materiale` WHERE `furnizor` LIKE '$chkFUR%'";
														if($chkRUN = mysql_query($chk))
														{
														    if(mysql_num_rows($chkRUN) > 0) echo 'Furnizor already registered.';
														    else
														    {
															    $que = "INSERT INTO `furnizori_materiale` VALUES('','$numeFUR','$judFUR','$locFUR','$strFUR','$nrstrFUR','$cpFUR','$taraFUR','$mailFUR','$telFUR','$persFUR','$depFUR','$apelFUR','$codFUR')";
															    if($run = mysql_query($que))
															    {
																    if(mysql_affected_rows() > 0) echo 'OK^';
																    else echo __LINE__.'. MySQL error in '.__FILE__.': Nici un furnizor nu a fost inserat. Va rog verificati datele introduse!';
															    }
                                                                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
														    }
														}
                                                        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
													}
													else echo 'Departament missing';
												}
												else echo 'Email missing';
											}
											else echo 'Phone missing';
										}
										else echo 'Persoana missing';
									}
									else echo 'Apelativ missing';
								}
								else echo 'Tara missing';
							}
							else echo 'Judet missing';
						}
						else echo 'Numar strada missing.';
					}
					else echo 'Strada not set';
				}
				else echo 'Cod postal missing';
 	        }
 	        else echo 'Localitate furnizor missing.';
        }
        else echo('Cod furnizor not set.');
    }
	else if(isset($_POST['numeFURNIZORset']) && !empty($_POST['numeFURNIZORset']))
    {
		$furnizor = $_POST['numeFURNIZORset'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		$chk = "SELECT `furnizor` FROM `furnizori_materiale` WHERE `furnizor` = '$furnizor'";
		if($chkRUN = mysql_query($chk))
		{
		    if(mysql_num_rows($chkRUN) > 0)echo 'Furnizor already registered';
		    else
		    {
			    $grab = "SELECT `cod.FURNIZOR` FROM `furnizori_materiale` ORDER BY `cod.FURNIZOR` DESC";
			    if($grabRUN = mysql_query($grab))
			    {
				    if(mysql_num_rows($grabRUN) > 0)
				    {
					    $grabROW = mysql_fetch_assoc($grabRUN);
					    $codFUR = $grabROW['cod.FURNIZOR'];
					    if($codFUR == '')$codFUR = 'F0001';
					    else 
						{
							$codLENGTH = strlen($codFUR);
							$trimmed = substr($codFUR,1,($codLENGTH - 1));
							$codFUR = (int)$trimmed + 1;
							$codFUR = 'F'.$codFUR;
							$newLENGTH = strlen($codFUR);
							if($newLENGTH < $codLENGTH)
							{
							    $dif = $codLENGTH - $newLENGTH;
								for($i = 0; $i < $dif; $i++)
								{
								    $codFUR = substr_replace($codFUR,'0',1,0);
								}
							}
						}
					    echo 'OK^'.$codFUR;
				    }
			    }
			    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
		}
		else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }

?>
<?php

    if(isset($_POST['detailsCHK']) && !empty($_POST['detailsCHK']) && isset($_POST['SAPcode']) && !empty($_POST['SAPcode']))
    {
	    $detalii = $_POST['detailsCHK'];
	    $codSAP = $_POST['SAPcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $que = "SELECT `size` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP'";
        if($run = mysql_query($que))
        {
		    if(mysql_num_rows($run) > 0)
		    {
			    $row = mysql_fetch_assoc($run);
			    $size = $row['size'];
			    if($size == $detalii) echo 'OK';
			    else
			    {
				    $update = "UPDATE `magazie_stoc` SET `size` = '$detalii' WHERE `cod_SAP` = '$codSAP'";
				    if($runup = mysql_query($update))
				    {
					    echo 'New';
				    }
				    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			    }
		    }
        }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else if(isset($_POST['codFURNIZOR']) && !empty($_POST['codFURNIZOR']) && isset($_POST['codSAPfix']) && !empty($_POST['codSAPfix']) && isset($_POST['furnizorFIX']) && !empty($_POST['furnizorFIX']))
    {
		$codFUR = strtoupper($_POST['codFURNIZOR']);
		$codSAP = $_POST['codSAPfix'];
		$furnizor = $_POST['furnizorFIX'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		$que = "UPDATE `magazie_stoc` SET `codFURNIZOR` = '$codFUR' WHERE `cod_SAP` = '$codSAP' AND `furnizor` = '$furnizor'";
		if($run = mysql_query($que))
		{
		    if(mysql_affected_rows() > 0)echo 'OK^'.$codFUR.'^'.$codSAP.'^'.$furnizor;
		    else echo 'Not found^';
		}
		else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else if(isset($_POST['checkSAP']) && !empty($_POST['checkSAP']))
    {
		if(isset($_POST['furnizor']) && isset($_POST['seria']) && !empty($_POST['seria']) && isset($_POST['facDATE']) && !empty($_POST['facDATE']))
		{
			$furnizor = $_POST['furnizor'];
		    $sapCODE = $_POST['checkSAP'];
		    $seria = $_POST['seria'];
		    $facDATE = date('Y-m-d',strtotime($_POST['facDATE']));
	        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	        $chk = "SELECT `serie_BON` FROM `arhiva_miscari_magazie` WHERE `cod.SAP` = '$sapCODE' AND `serieFACTURA` = '$seria' AND `furnizor` = '$furnizor' AND DATE(`dataFACTURA`) = '$facDATE' ";
	        if($chkRUN = mysql_query($chk))
	        {
				if(mysql_num_rows($chkRUN) > 0) echo 'Already registered';
				else
				{
					//echo $sapCODE.'^'.$seria.'^'.$furnizor.'^'.$facDATE.'^';
			        $que = "SELECT `codFURNIZOR`, `denumire`, `size`, `magazie`, `grupa_MAT`, `cantitate`, `cantitate.minima`, `cantitate.optima`, `UM`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' ORDER BY `lastRECEIVED` DESC";
			        if($run = mysql_query($que))
			        {
						$num = mysql_num_rows($run);
						//echo $num.' results';
						if($num == 0) echo 'New SAP code^';
					    else
					    {
						    echo 'OK^';
						    $codFUR = 0;
						    $amount = 0;
						    while($row = mysql_fetch_assoc($run))
						    {
							    if($row['furnizor'] == $furnizor) $codFUR = $row['codFURNIZOR'];
							    $denumire = $row['denumire'];
							    $details = $row['size'];
							    $magazie = $row['magazie'];
							    $grupa = $row['grupa_MAT'];
							    $amount = $row['cantitate'] + $amount;
							    $amountMIN = $row['cantitate.minima'];
							    $amountOPT = $row['cantitate.optima'];
							    $units = $row['UM'];
							    $grabFurnizor = $row['furnizor'];
							    $pret = $row['pret'];
						    }
						    echo $codFUR.'^'.$denumire.'^'.$details.'^'.$magazie.'^'.$grupa.'^'.$amount.'^'.$amountMIN.'^'.$amountOPT.'^'.$pret.'^'.$grabFurnizor.'^'.$units;
					    }
			        }
			        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			    }
	        }
	        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
    }
	else if(isset($_POST['grabSAP']) && !empty($_POST['grabSAP']))
    {
		$sapCODE = $_POST['grabSAP'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$sapCODE%'";
	    if($run = mysql_query($que))
	    {
			echo 'OK^';
		    if(mysql_num_rows($run) > 1)
		    {
			    while($row = mysql_fetch_assoc($run))
			    {
				    $name = $row['denumire'];
					$codSAP = $row['cod_SAP'];
				    echo '<OPTION VALUE = '.$codSAP.'>'.$name.'</OPTION>';
			    }
		    }
	    }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else if(isset($_POST['furnizorname']))
    {
		if(!empty($_POST['furnizorname']))
		{
		    $furnizorNAME = $_POST['furnizorname'];
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		    $que = "SELECT `furnizor` FROM `furnizori_materiale` WHERE `furnizor` LIKE '$furnizorNAME%' GROUP BY `furnizor`";
		    if($run = mysql_query($que))
		    {
				echo 'OK^';
			    if(mysql_num_rows($run) > 0)
			    {
				    while($row = mysql_fetch_assoc($run))
				    {
						if($row['furnizor'] != $furnizorNAME)
						{
					        $furnizor = $row['furnizor'];
					        echo '<OPTION>'.$furnizor.'</OPTION>';
					    }
				    }
			    }
		    }
		    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		}
    }
    else if(isset($_POST['furnizorcheck']) && !empty($_POST['furnizorcheck']))
    {
		$furnizor = $_POST['furnizorcheck'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `furnizor`, `judet`, `oras`, `strada`, `str.nr`, `cod.postal`, `tara`, `email`, `telefon`, `pers.contact`, `departament`, `apelativ` FROM `furnizori_materiale` WHERE `furnizor` = '$furnizor'";
	    if($run = mysql_query($que))
	    {
			echo 'OK furnizor^';
		    if(mysql_num_rows($run) == 0) echo 'Furnizor nou';
		    else 
			{
				echo 'Continue^';
				$row = mysql_fetch_assoc($run);
				$judet = $row['judet'];
				$oras = $row['oras'];
				$strada = $row['strada'];
				$strNR = $row['str.nr'];
				$codpostal = $row['cod.postal'];
				$tara = $row['tara'];
				$email = $row['email'];
				$tel = $row['telefon'];
				$pers = $row['pers.contact'];
				$depart = $row['departament'];
				$apel = $row['apelativ'];
				echo $judet.'^'.$oras.'^'.$strada.'^'.$strNR.'^'.$codpostal.'^'.$tara.'^'.$email.'^'.$tel.'^'.$pers.'^'.$depart.'^'.$apel;
				if(isset($_POST['facturaCHK']) && !empty($_POST['facturaCHK']) && isset($_POST['dataCHK']) && !empty($_POST['dataCHK']))
				{
					$factura = $_POST['facturaCHK'];
					$data2CHK = date('Y-m-d',strtotime($_POST['dataCHK']));
				    $factCHK = "SELECT `serieFACTURA` FROM `arhiva_miscari_magazie` WHERE `serieFACTURA` = '$factura' AND `furnizor` = '$furnizor' AND `dataFACTURA` = '$data2CHK'";
				    if($factRUN = mysql_query($factCHK))
				    {
					    if(mysql_num_rows($factRUN) > 0) echo '^Found invoice';
					    else
					    {
						    $secondCHK = "SELECT `dataFACTURA` FROM `arhiva_miscari_magazie` WHERE `serieFACTURA` = '$factura' AND `furnizor` = '$furnizor'";
						    if($sCHKrun = mysql_query($secondCHK))
						    {
							    if(mysql_num_rows($sCHKrun) > 0)
							    {
								    $sCHKrow = mysql_fetch_assoc($sCHKrun);
								    $dataFACTURA = $sCHKrow['dataFACTURA'];
								    echo '^Wrong date';
							    }
							    else echo '^New invoice';
						    }
                            else echo __LINE__.'. MySQL Error in '.__FILE__.': '.mysql_error();
					    }
				    }
                    else echo __LINE__.'. MySQL Error in '.__FILE__.': '.mysql_error();
				}
			}
	    }
        else echo __LINE__.'. MySQL Error in '.__FILE__.': '.mysql_error();
    }

?>
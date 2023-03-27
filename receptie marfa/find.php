<?php

    if(isset($_POST['detailsCHK']) && !empty($_POST['detailsCHK']) && isset($_POST['SAPcode']) && !empty($_POST['SAPcode']))
    {
	    $detalii = $_POST['detailsCHK'];
	    $codSAP = $_POST['SAPcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$que = $connect -> query("SELECT `size` FROM `magazie_stoc` WHERE `cod_SAP` = '$codSAP'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
        if(mysqli_num_rows($que) > 0)
		{
			$row = $que -> fetch_assoc();
			$size = $row['size'];
			if($size == $detalii) echo 'OK';
			else
			{
				if(!$update = $connect -> query("UPDATE `magazie_stoc` SET `size` = '$detalii' WHERE `cod_SAP` = '$codSAP'"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				echo 'New';
			}
		}
    }
	else if(isset($_POST['codFURNIZOR']) && !empty($_POST['codFURNIZOR']) && isset($_POST['codSAPfix']) && !empty($_POST['codSAPfix']) && isset($_POST['furnizorFIX']) && !empty($_POST['furnizorFIX']))
    {
		$codFUR = strtoupper($_POST['codFURNIZOR']);
		$codSAP = $_POST['codSAPfix'];
		$furnizor = $_POST['furnizorFIX'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		if(!$que = $connect -> query("UPDATE `magazie_stoc` SET `codFURNIZOR` = '$codFUR' WHERE `cod_SAP` = '$codSAP' AND `furnizor` = '$furnizor'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		if(mysqli_affected_rows($connect) > 0)echo 'OK^'.$codFUR.'^'.$codSAP.'^'.$furnizor;
		else echo 'Not found^';
    }
	else if(isset($_POST['checkSAP']) && !empty($_POST['checkSAP']))
    {
		if(isset($_POST['furnizor']) && isset($_POST['seria']) && !empty($_POST['seria']) && isset($_POST['facDATE']) && !empty($_POST['facDATE']))
		{
			$furnizor = $_POST['furnizor'];
		    $sapCODE = $_POST['checkSAP'];
		    $seria = $_POST['seria'];
		    $facDATE = date('Y-m-d',strtotime($_POST['facDATE']));
	        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	        if(!$chk = $connect -> query("SELECT `serie_BON` FROM `arhiva_miscari_magazie` WHERE `cod.SAP` = '$sapCODE' AND `serieFACTURA` = '$seria' AND `furnizor` = '$furnizor' AND DATE(`dataFACTURA`) = '$facDATE' "))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	        if(mysqli_num_rows($chk) > 0) echo 'Already registered';
			else
			{
				if(!$que = $connect -> query("SELECT `codFURNIZOR`, `denumire`, `size`, `magazie`, `grupa_MAT`, `cantitate`, `cantitate.minima`, `cantitate.optima`, `UM`, `furnizor`, `pret` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE' ORDER BY `lastRECEIVED` DESC"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				$num = mysqli_num_rows($que);
				if($num == 0) echo 'New SAP code^';
				else
				{
					echo 'OK^';
					$codFUR = 0;
					$amount = 0;
					while($row = $que -> fetch_assoc())
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
	    }
    }
	else if(isset($_POST['grabSAP']) && !empty($_POST['grabSAP']))
    {
		$sapCODE = $_POST['grabSAP'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `denumire`, `cod_SAP` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$sapCODE%'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	    echo 'OK^';
		if(mysqli_num_rows($que) > 1)
		{
			while($row = $que -> fetch_assoc())
			{
				$name = $row['denumire'];
				$codSAP = $row['cod_SAP'];
				echo '<OPTION VALUE = '.$codSAP.'>'.$name.'</OPTION>';
			}
		}
    }
	else if(isset($_POST['furnizorname']))
    {
		if(!empty($_POST['furnizorname']))
		{
		    $furnizorNAME = $_POST['furnizorname'];
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		    if(!$que = $connect -> query("SELECT `furnizor` FROM `furnizori_materiale` WHERE `furnizor` LIKE '$furnizorNAME%' GROUP BY `furnizor`"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		    echo 'OK^';
			if(mysqli_num_rows($que) > 0)
			{
				while($row = $que -> fetch_assoc())
				{
					if($row['furnizor'] != $furnizorNAME)
					{
						$furnizor = $row['furnizor'];
						echo '<OPTION>'.$furnizor.'</OPTION>';
					}
				}
			}
		}
    }
    else if(isset($_POST['furnizorcheck']) && !empty($_POST['furnizorcheck']))
    {
		$furnizor = $_POST['furnizorcheck'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `furnizor`, `judet`, `oras`, `strada`, `str.nr`, `cod.postal`, `tara`, `email`, `telefon`, `pers.contact`, `departament`, `apelativ` FROM `furnizori_materiale` WHERE `furnizor` = '$furnizor'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	    echo 'OK furnizor^';
		if(mysqli_num_rows($que) == 0) echo 'Furnizor nou';
		else 
		{
			echo 'Continue^';
			$row = $que -> fetch_assoc();
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
				if(!$factCHK = $connect -> query("SELECT `serieFACTURA` FROM `arhiva_miscari_magazie` WHERE `serieFACTURA` = '$factura' AND `furnizor` = '$furnizor' AND `dataFACTURA` = '$data2CHK'"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				if(mysqli_num_rows($factCHK) > 0) echo '^Found invoice';
				else
				{
					if(!$secondCHK = $connect -> query("SELECT `dataFACTURA` FROM `arhiva_miscari_magazie` WHERE `serieFACTURA` = '$factura' AND `furnizor` = '$furnizor'"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					if(mysqli_num_rows($secondCHK) > 0)
					{
						$sCHKrow = $secondCHK -> fetch_assoc();
						$dataFACTURA = $sCHKrow['dataFACTURA'];
						echo '^Wrong date';
					}
					else echo '^New invoice';
				}
			}
		}
    }

?>
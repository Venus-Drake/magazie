<?php

if(isset($_GET['marca']) && !empty($_GET['marca'])) 
{
	$marca = $_GET['marca'];
	if(isset($_GET['seria']) && !empty($_GET['seria'])) $seria = $_GET['seria'];
}
else echo 'Eroare!! Marca nu este setata!';

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

global $num;

$fin = "SELECT * FROM `magazie_imprumuturi` WHERE `marca` = '$marca' AND `order.closed` = '1'";
if($finrun = mysql_query($fin))
{
	$numfin = mysql_num_rows($finrun);
    if($numfin > 0)
    {
		while($finrow = mysql_fetch_assoc($finrun))
		{
			$nrCRT = $finrow['nr.crt'];
			$serieBON = $finrow['serial.nr'];
			$motiv = $finrow['motiv'];
			$angajat = $finrow['worker'];
			$sectia = $finrow['sectia'];
		    $prod = $finrow['item.name'];
		    $sap = $finrow['sap.code'];
		    $furnizor = $finrow['furnizor'];
		    $val = $finrow['price'];
		    $cantitate = $finrow['amount'];
		    $units = $finrow['unitate.mas'];
		    $val_prod = $finrow['value'];
		    $data_bon = date('Y-m-d', strtotime($finrow['date']));
		    $ora_bon = date('h:i:s', strtotime($finrow['date']));
		    $dataLIMITA = $finrow['end.loan'];
		    $obs = $finrow['observatii'];
		    $stocout = "SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$sap'";
		    if($stocrun = mysql_query($stocout))
		    {
			    if(mysql_num_rows($stocrun) > 0)
			    {
				    $stocrow = mysql_fetch_assoc($stocrun);	
				    $stoc = $stocrow['cantitate'];
				    $stoc = $stoc - $cantitate;
				    if($stoc >= 0)  //FACEM UPDATE LA STOC IN MAGAZIE
				    {
				        $stocup = "UPDATE `magazie_stoc` SET `cantitate` = '$stoc' WHERE `cod_SAP` = '$sap' AND `furnizor` = '$furnizor' AND `pret` = '$val'";
				        if($stocuprun = mysql_query($stocup))
				        {
						    //INREGISTRAM MISCAREA IN ARHIVA
							$reg = "INSERT INTO `arhiva_miscari_magazie` VALUES('','$serieBON','Imprumut produs','$motiv','$dataLIMITA','$angajat','$marca','$sectia','$prod','$sap','$furnizor','$val','$cantitate','$units','$stoc','$val_prod','$data_bon','$ora_bon','$obs')";
							if($regrun = mysql_query($reg))
							{
							    //SCOATEM MISCAREA DE PE BONUL DE COMANDA
							    $rem = "DELETE FROM `magazie_imprumuturi` WHERE `nr.crt` = '$nrCRT'";
							    if($remrun = mysql_query($rem))
							    {
								    $num++;
									if($num == $numfin) echo 'OK';
							    }
                                else 
{
	echo
'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';
break;
}
							}
							else 
{
	echo
'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';
break;
}
		                }
                        else
{
echo'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';
break;
}
				    }
					else 
{
echo 'Operatiunea nu poate fi efectuata!
Stoc negativ pentru '.$sap.'!!';
break;
}
			    }
			    else 
{
echo 'Codul '.$sap.' nu a fost gasit!';
break;
}
		    }
            else 
{
echo'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';
break;
}
		}
    }
    else
    {
		$dchk = "SELECT * FROM `magazie_imprumuturi` WHERE `marca` = '$marca' AND `order.closed` = '0'";
		if($dchkrun = mysql_query($dchk))
		{
		    if(mysql_num_rows($dchkrun) > 0) 
echo 'Comanda nu a fost confirmata de catre angajat.
Va rog, solicitati confirmarea comenzii!';
		    else 
echo 'Nu a fost gasita nici o comanda pentru '.$marca.'!';
		}
else echo'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';
    }
}
else echo'MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator!';

?>
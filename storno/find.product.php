<?php

if(isset($_GET['product']) && $_GET['product'] != '')
{
	$SAPcode = $_GET['product'];
	if(isset($_GET['marca']) && $_GET['marca'] != '') $marca = $_GET['marca'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	$pchk = "SELECT `serie_BON`, `motiv`, `data_LIMITA`, `produs`, `furnizor`, `valoare`, `cantitate`, `cod.SAP` FROM `arhiva_miscari_magazie` WHERE `cod.SAP` LIKE '$SAPcode%' AND `tip.miscare` = 'Imprumut produs' AND `marca` = '$marca' ORDER BY `data_LIMITA`";
	if($prun = mysql_query($pchk))
	{
		if(mysql_num_rows($prun) > 0)
		{
		    while($prow = mysql_fetch_assoc($prun))
		    {
				$serie = $prow['serie_BON'];
				$motiv = $prow['motiv'];
				$endDATE = $prow['data_LIMITA'];
				$produs = $prow['produs'];
				$furnizor = $prow['furnizor'];
				$imprumutate = $prow['cantitate'];
				$pret = $prow['valoare'];
			    $mySAP = $prow['cod.SAP'];
			    if($mySAP != $SAPcode) 
				{
					$ver = "SELECT `cantitate` FROM `arhiva_miscari_magazie` WHERE `serie_BON` = '$serie' AND `tip.miscare` = 'Produs returnat' AND `motiv` = '$motiv' AND `data_LIMITA` = '$endDATE' AND `marca` = '$marca' AND `cod.SAP` = '$mySAP' AND `furnizor` = '$furnizor' AND `valoare` = '$pret'";
					if($verRUN = mysql_query($ver))
					{
					    if(mysql_num_rows($verRUN) > 0)
					    {
							$amount = 0;
						    while($verROW = mysql_fetch_assoc($verRUN))
						    {
							    $amount = $amount + $verROW['cantitate'];
						    }
						    $imprumutate = $imprumutate - $amount;
						    if($imprumutate > 0) echo '<OPTION VALUE = "'.$mySAP.'">'.$produs.'</OPTION>';
					    }
					    else echo '<OPTION VALUE = "'.$mySAP.'">'.$produs.'</OPTION>';
					}
					else echo __LINE__.'. MySQL error in find.product.php!';
				}
		    }
		}
		else echo 'Product NOT found';
	}
	else echo __LINE__.'. MySQL error in find.product.php!';
}

?>
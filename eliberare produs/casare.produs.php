<?php

global $marca;
global $product;
global $furnizor;
global $stornoAmount;
global $observatii;
$sectia = (string) $sectia;

$SAPcode = (string) $SAPcode;

    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$casget = $connect -> query("SELECT `cantitate`, `tip.miscare` FROM `arhiva_miscari_magazie` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode'"))
	{
		$mailerror = 'MYSQL ERROR<br><font size = 2>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect);
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
    if(mysqli_num_rows($casget) > 0)
	{
		$casAmount = 0;
		while($casgetrow = $casget -> fetch_assoc())
		{
			$miscare = $casgetrow['tip.miscare'];
			$quantity = $casgetrow['cantitate'];
			if($miscare == 'Eliberare produs') $casAmount = $casAmount + $quantity;
			else if($miscare == 'Casare produs' || $miscare == 'Pentru reascutire') $casAmount = $casAmount - $quantity;
		}
		if($casAmount > 0)
		{
			if($casAmount >= $stornoAmount)
			{
				$val_prod = $price * $stornoAmount;
				$data_bon = date('Y/m/d h:i:s',time());
				$ora_bon = date('h:i:s', time());
				if(!$casare = $connect -> query("INSERT INTO `arhiva_miscari_magazie` VALUES('','Casare produs','$worker','$marca','$sectia','$product','$SAPcode','$furnizor','$price','$stornoAmount','$stock','$val_prod','$data_bon','$ora_bon','$observatii')"))
				{
					$mailerror = 'MYSQL ERROR<br><font size = 2>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect);
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				    mysqli_close($connect);
				}
				echo '<SCRIPT>alert("Casarea a '.$stornoAmount.' '.$units.' de\n'.$product.' de la\n'.$worker.'\na fost efectuata cu succes!");</SCRIPT>';
			}
			else echo '<SCRIPT>alert("Cantitatea de casat este prea mare!\nVa rog, nu casati o cantitate mai mare de '.$casAmount.' '.$units.'!");</SCRIPT>';
		}
		else echo '<SCRIPT>alert("Casarea nu poate fi efectuata!\nNu s-a gasit nici un '.$SAPcode.' la \nangajatul '.$worker.'!");</SCRIPT>';
	}
	else echo '<SCRIPT>alert("Casarea nu poate fi efectuata!\nNu s-a gasit nici un '.$SAPcode.' la \nangajatul '.$worker.'!");</SCRIPT>';

?>
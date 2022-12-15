<?php

    //echo '<SCRIPT>alert("Storno option set: '.$stornoOption.'\nScadem produsul din inventarul angajatului\nSi cu asta, BASTA!");</SCRIPT>';
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    $casget = "SELECT `cantitate`, `tip.miscare` FROM `arhiva_miscari_magazie` WHERE `marca` = '$marca' AND `cod.SAP` = '$SAPcode'";
    if($casgetrun = mysql_query($casget))
    {
	    if(mysql_num_rows($casgetrun) > 0)
	    {
			$casAmount = 0;
		    while($casgetrow = mysql_fetch_assoc($casgetrun))
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
					$casare = "INSERT INTO `arhiva_miscari_magazie` VALUES('','Casare produs','$worker','$marca','$sectia','$product','$SAPcode','$furnizor','$price','$stornoAmount','$stock','$val_prod','$data_bon','$ora_bon','$observatii')";
					if($casarerun = mysql_query($casare))
					{
			            echo '<SCRIPT>alert("Casarea a '.$stornoAmount.' '.$units.' de\n'.$product.' de la\n'.$worker.'\na fost efectuata cu succes!");</SCRIPT>';
			        }
			        else
					{
						$mailerror = 'MYSQL ERROR<br><font size = 2>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error();
						require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					}
			    }
			    else echo '<SCRIPT>alert("Cantitatea de casat este prea mare!\nVa rog, nu casati o cantitate mai mare de '.$casAmount.' '.$units.'!");</SCRIPT>';
		    }
		    else echo '<SCRIPT>alert("Casarea nu poate fi efectuata!\nNu s-a gasit nici un '.$SAPcode.' la \nangajatul '.$worker.'!");</SCRIPT>';
	    }
	    else echo '<SCRIPT>alert("Casarea nu poate fi efectuata!\nNu s-a gasit nici un '.$SAPcode.' la \nangajatul '.$worker.'!");</SCRIPT>';
    }
    else
	{
		$mailerror = 'MYSQL ERROR<br><font size = 2>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error();
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
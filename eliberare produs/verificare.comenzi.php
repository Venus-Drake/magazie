<?PHP

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
//AM DESCHIS PAGINA NOUA; INCA NU AM INTRODUS NICI O DATA. VERIFICAM EXISTENTA VREUNEI COMENZI RAMASA DESCHISA.
if(empty($worker) || $worker == 'NUME ANGAJAT')
{
	if(!$chk = $connect -> query("SELECT `nume`, `marca`, `sectia`, `data`, `ora` FROM `bon_consum_tmp` WHERE `processed` = '0'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		die();
	}
	if(mysqli_num_rows($chk) != 0) //AVEM COMENZI NEFINALIZATE
	{
		$chkrow = $chk -> fetch_assoc();
		$workerchk = $chkrow['nume'];
		$marcachk = $chkrow['marca'];
		$sectiachk = $chkrow['sectia'];
		$datechk = $chkrow['data'];
		$timechk = $chkrow['ora'];
		$alert_bon = 'Avem o comanda deschisa pe numele: '.$workerchk.',<BR>din '.$datechk.' '.$timechk.'.<BR>O anulam?';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}
	else //AVEM VREO COMANDA RAMASA DESCHISA?
	{
		if(!$chk_p = $connect -> query("SELECT `nume`, `marca`, `sectia`, `data`, `ora` FROM `bon_consum_tmp` WHERE `processed` = '1'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
		if(mysqli_num_rows($chk_p) != 0)
		{
			$chkrow_p = $chk_p -> fetch_assoc();
			$workerchk = $chkrow_p['nume'];
			$marcachk = $chkrow_p['marca'];
			$sectiachk = $chkrow_p['sectia'];
			$datechk = $chkrow_p['data'];
			$timechk = $chkrow_p['ora'];
			$alert_bon = 'Avem o comanda nesalvata pe numele: '.$workerchk.',<BR>din '.$datechk.' '.$timechk.'.<BR>Va rog folositi butonul Printeaza/ Finalizeaza pentru a incheia comanda inainte de a incepe o comanda noua!';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
		else
		{
			$worker = 'NUME ANGAJAT';
			$marca = 'NR. MARCA';
			$sectia = '<font style = "text-decoration: underline dotted;"><i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSECTIA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></font>';
		}
	}
}
//S-A INTRODUS NUMELE UNUI NOU ANGAJAT; VERIFICAM EXISTENTA VREUNEI COMENZI, PE UN ALT NUME
else if(empty($SAPcode) && empty($amount) && empty($action))
{
	//echo '<B>'.__LINE__.'. '.__FILE__.':<BR>I am HERE!<BR>Worker received: '.$worker.'</B><BR>';
    if(!$chk = $connect -> query("SELECT `nume`, `marca`, `sectia`, `data`, `ora` FROM `bon_consum_tmp` WHERE `processed` = '0' AND `nume` != '$worker'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		die();
	}
	if(mysqli_num_rows($chk) != 0) //AVEM COMENZI NECONFIRMATE PE ALT ANGAJAT; AM INTRODUS DEJA VREO COMANDA PE NUMELE NOU?
	{
		if(!$chk2 = $connect -> query("SELECT `nume` FROM `bon_consum_tmp` WHERE `nume` = '$worker'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
		if(mysqli_num_rows($chk2) == 0)
		{
			$chkrow = $chk -> fetch_assoc();
			$workerchk = $chkrow['nume'];
			$marcachk = $chkrow['marca'];
			$sectiachk = $chkrow['sectia'];
			$datechk = $chkrow['data'];
			$timechk = $chkrow['ora'];
			$alert_bon = 'Avem o comanda deschisa pe numele: '.$workerchk.',<BR>din '.$datechk.' '.$timechk.'.<BR>O anulam?';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
	else //NU AVEM COMENZI NECONFIRMATE; AVEM VREO COMANDA RAMASA NESALVATA?
	{
		if(!$chk_p = $connect -> query("SELECT `nume`, `marca`, `sectia`, `data`, `ora` FROM `bon_consum_tmp` WHERE `processed` = '1'"))
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			die();
		}
		if(mysqli_num_rows($chk_p) != 0)  //AVEM COMANDA NESALVATA; CEREM SALVAREA EI, INAINTE DE A CONTINUA.
		{
			$chkrow_p = $chk_p -> fetch_assoc();
			$workerchk = $chkrow_p['nume'];
			$marcachk = $chkrow_p['marca'];
			$sectiachk = $chkrow_p['sectia'];
			$datechk = $chkrow_p['data'];
			$timechk = $chkrow_p['ora'];
			$proc = 1;
			$alert_bon = 'Avem o comanda nesalvata pe numele: '.$workerchk.',<BR>din '.$datechk.' '.$timechk.'.<BR>Va rog folositi butonul Printeaza/ Finalizeaza pentru a incheia comanda inainte de a incepe o comanda noua!';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
		else   //NU AVEM COMENZI RAMASE IN BONUL TEMPORAR; CONTINUAM.
		{
			$marca = 'NR. MARCA';
			$sectia = '<font style = "text-decoration: underline dotted;"><i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSECTIA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></font>';
		}
	}
}

?>
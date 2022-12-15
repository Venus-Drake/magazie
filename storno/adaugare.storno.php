<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/grab.seria.nr.php';

$endDate = date('Y-m-d 12:i:s',strtotime($endDate));

//IN PRIMUL RAND VERIFICAM DACA NU CUMVA AM MAI INTRODUS PRODUSUL, CU EXACT ACELEASI DATE
if ($SAPcode != 0)
	$SAPcode = (string) $SAPcode;
if ($motiv != 0)
	$motiv = (string) $motiv;
if ($furnizor != 0)
	$furnizor = (string) $furnizor;
if ($observatii != 0)
	$observatii = (string) $observatii;

if(!$storno = $connect -> query("SELECT * FROM `declaratie_storno` WHERE `nume` = '$worker'  AND `cod.SAP` = '$SAPcode' AND `end.loan` = '$endDate' AND `motiv` = '$motiv' AND `furnizor` = '$furnizor' AND `valoare` = '$price' AND `processed` = '0' AND `observatii` = '$observatii'"))
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}
if(mysqli_num_rows($storno) > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/declaratie.product.found.php';
else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/declaratie.product.notfound.php';


?>
<SCRIPT src='/ramira/magazie/imprumuturi/imprumut.script.js'></SCRIPT>
<SCRIPT>
    function flashStock()
    {
	    setTimeout(flashS,1000);
	    function flashS()
	    {
		    if(document.getElementByID("stockImprumut").style.background != "red")
			{
			    document.getElementById("stockImprumut").style.background = "red";
			}
			else
			{
			    document.getElementById("stockImprumut").style.background = "white";
			}
	    }
    }
</SCRIPT>
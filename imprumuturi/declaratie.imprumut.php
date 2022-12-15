<?php

//CAUTAM IMPRUMUTURILE EFECTUATE DE MUNCITOR PE ACTUALA DECLARATIE.
global $SAPcode;
global $motiv;
global $furnizor;
global $observatii;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/grab.seria.nr.php';

$endDate = date('Y-m-d 12:i:s',strtotime($endDate));

//IN PRIMUL RAND VERIFICAM DACA NU CUMVA AM MAI INTRODUS PRODUSUL, CU EXACT ACELEASI DATE

$loanchk = "SELECT * FROM `magazie_imprumuturi` WHERE `worker` = '$worker'  AND `sap.code` = '$SAPcode' AND `end.loan` = '$endDate' AND `motiv` = '$motiv' AND `furnizor` = '$furnizor' AND `price` = '$price' AND `order.closed` = '0' AND `observatii` = '$observatii'";
if($loanchkrun = mysql_query($loanchk))
{
    if(mysql_num_rows($loanchkrun) > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/declaratie.product.found.php';
	else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/declaratie.product.notfound.php';
}
else
{
	$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a></FONT>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}


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
<HTML>
<HEAD>
    <STYLE>
    </STYLE>
</HEAD>

<?php

//ECHO '<TD>ACUM AR TREBUI SA EXTRAGEM DIN MAGAZIE STOC, TOT CE AVEM SI CUM. <BR> HAI SA VEDEM!</TD>';
require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
if($clasa == 'GENERALA') $stoc = "SELECT * FROM `magazie_stoc` ORDER BY `cod_SAP`";
else $stoc = "SELECT * FROM `magazie_stoc` WHERE `grupa_MAT` = '$clasa' ORDER BY `cod_SAP`";
if($stocrun = mysql_query($stoc))
{
    if(mysql_num_rows($stocrun) > 0)
    {
		$nr = 0;
	    while($stocrow = mysql_fetch_assoc($stocrun))
	    {
		    $denumire = $stocrow['denumire'];
		    $cant = $stocrow['cantitate'];
	     	$um = $stocrow['UM'];
	     	$furnizor = $stocrow['furnizor'];
	     	$magazie = $stocrow['magazie'];
	     	$sap = $stocrow['cod_SAP'];
	     	$grupa = $stocrow['grupa_MAT'];
	     	$pret = $stocrow['pret'];
	     	$obs = $stocrow['observatii'];
	     	if($obs == '') $obs = 'none';
	     	$nr++;
	     	echo '<TR CLASS = "ROW"><TD ALIGN = CENTER>'.$nr.'</TD><TD>'.$sap.'</TD><TD>'.$denumire.'</TD><TD ALIGN = CENTER>'.$cant.'</TD><TD ALIGN = CENTER>'.$um.'</TD><TD>'.$furnizor.'</TD><TD ALIGN = CENTER>'.$magazie.'</TD><TD ALIGN = CENTER>'.$grupa.'</TD><TD ALIGN = CENTER>0</TD><TD ALIGN = CENTER>0</TD><TD>'.$obs.'</TD>';
	    }
	    echo '</TABLE><BR><BR>';
    }
    else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: RED; BACKGROUND-COLOR: BLACK;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>Nu s-a gasit nici un produs in magazie!<BR><BUTTON CLASS = "OK" ID = "OK" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
}
else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: RED; BACKGROUND-COLOR: BLACK;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error().'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';

?>

</HTML>

<SCRIPT>

    var errdia = document.getElementById("errdia");
    function closeDialog()
	{
 	    errdia.close();
    }

</SCRIPT>
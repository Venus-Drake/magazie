<HTML>
<HEAD>
    <STYLE>
    </STYLE>
</HEAD>

<?php

//ECHO '<TD>ACUM AR TREBUI SA EXTRAGEM DIN MAGAZIE STOC, TOT CE AVEM SI CUM. <BR> HAI SA VEDEM!</TD>';
require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if (!$stoc = $connect->query("SELECT * FROM `magazie_stoc` WHERE `magazie` = 'S' ORDER BY `cod_SAP`")) 
{
	echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: RED; BACKGROUND-COLOR: BLACK;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect).'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
	mysqli_close($connect);
}
if(mysqli_num_rows($stoc) > 0)
{
	$nr = 0;
	while($stocrow = $stoc -> fetch_assoc())
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

?>

</HTML>

<SCRIPT>

    var errdia = document.getElementById("errdia");
    function closeDialog()
	{
 	    errdia.close();
    }

</SCRIPT>
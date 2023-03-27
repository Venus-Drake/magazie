<HTML>
<HEAD>
    <STYLE>
    </STYLE>
</HEAD>

<?php

global $clasa;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if ($clasa == 'GENERALA') {
	if(!$stoc = $connect -> query("SELECT * FROM `magazie_stoc` ORDER BY `cod_SAP`"))
	{
		echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: RED; BACKGROUND-COLOR: BLACK;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect).'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
	}
} else {
	if(!$stoc = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `grupa_MAT` = '$clasa' ORDER BY `cod_SAP`"))
	{
		echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: RED; BACKGROUND-COLOR: BLACK;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect).'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
	}
}
if(mysqli_num_rows($stoc) > 0)
{
	$nr = 0;
	while($stocrow = $stoc -> fetch_assoc($stocrun))
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

<SCRIPT>

    var errdia = document.getElementById("errdia");
    function closeDialog()
	{
 	    errdia.close();
    }

</SCRIPT>

</HTML>
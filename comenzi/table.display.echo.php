<?php

global $cantitate; global $codSAP; global $produs; global $furnizor; global $magazie; global $grupa;

echo '
<HEAD>
    <link rel="stylesheet" href="/ramira/magazie/comenzi/styling.css">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

</HEAD>
<BODY STYLE = "OVERFLOW: HIDDEN;">
<DIV WIDTH = 100%>
    <DIV ID = "declarationINTRO" STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; BACKGROUND-COLOR: WHITE;">
          <IMG SRC = "logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;"><BR>
		  <B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">';
    if($alarm == 'showSTOCKS' || $alarm == 'sortTABLE') echo 'Stoc general produse magazie la '.$date;
    else if($alarm == 'displaySAP') echo 'Stoc '.$SAPcode.' la '.$date;
	else if($alarm == 'displayMAGAZIE') echo 'Stocuri in magazia '.$magazie.' la '.$date;
	else if($alarm == 'displayGRUPA') echo 'Stocuri in grupa '.$grupa.' la '.$date;
	else if($alarm == 'displayFURNIZOR') echo 'Stocuri de la furnizorul '.$FURNIZOR.' la '.$date;
	else if($alarm == 'displayNAME') echo 'Stoc '.$PRODname.' la '.$date;
	else if($alarm == 'showALARMprod') echo 'Stocuri epuizate sau ajunse la limita de alerta la '.$date;
	echo '</FONT></CENTER></B><BR><BR>
              </DIV>
              <DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 40vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK;">
      <TABLE ID = "displayTABLE" class="table table-striped table-bordered" ALIGN = CENTER WIDTH = 100% STYLE = "BORDER-COLLAPSE: SEPARATE; MARGIN-TOP: 12vw; MARGIN: 0; BORDER-SPACING: 0;">
          <THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY; BORDER: 2px SOLID BLACK;">
              <TR><TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cod SAP</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 15%;">Denumire</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cantitate</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">U.M.</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Detalii</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cant. Min.</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cant. Optima</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Magazie</TH>
              <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Grupa Mat.</TH>
		  </THEAD></TR>';
    if(mysqli_num_rows($que) > 0)
    {
	    while($row = $que -> fetch_assoc())
	    {
			if($alarm == 'showSTOCKS' || $alarm == 'showALARMprod' || $alarm == 'sortTABLE')
			{
				if($row['cod_SAP'] != $codSAP)
				{
					if($codSAP != '' && ($alarm == 'showSTOCKS' || $alarm == 'sortTABLE' || ($alarm == 'showALARMprod' && $cantitate <= $cantMIN))) echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
				    $codSAP = $row['cod_SAP'];
				    $produs = $row['denumire'];
				    $cantitate = $row['cantitate'];
				    $UM = $row['UM'];
				    $detalii = $row['size'];
				    $cantMIN = $row['cantitate.minima'];
				    $cantOPT = $row['cantitate.optima'];
				    $magazie = $row['magazie'];
				    $grupa = $row['grupa_MAT'];
				}
				else $cantitate = $cantitate + $row['cantitate'];
			}
			else if($alarm == 'displaySAP')
			{
				if($codSAP != $row['cod_SAP'])
				{
				    $codSAP = $row['cod_SAP'];
				    $produs = $row['denumire'];
				    $cantitate = $row['cantitate'];
				    $UM = $row['UM'];
				    $detalii = $row['size'];
				    $cantMIN = $row['cantitate.minima'];
				    $cantOPT = $row['cantitate.optima'];
				    $magazie = $row['magazie'];
				    $grupa = $row['grupa_MAT'];
				}
				else $cantitate = $cantitate + $row['cantitate'];
			}
			else if($alarm == 'displayNAME')
			{
			    if($produs != $row['denumire'])
			    {
				    $codSAP = $row['cod_SAP'];
				    $produs = $row['denumire'];
				    $cantitate = $row['cantitate'];
				    $UM = $row['UM'];
				    $detalii = $row['size'];
				    $cantMIN = $row['cantitate.minima'];
				    $cantOPT = $row['cantitate.optima'];
				    $magazie = $row['magazie'];
				    $grupa = $row['grupa_MAT'];
			    }
			    else $cantitate = $cantitate + $row['cantitate'];
			}
			else if($alarm == 'displayFURNIZOR')
			{
			    if($furnizor != $row['furnizor'])
			    {
					$furnizor = $row['furnizor'];
					if($codSAP != $row['cod_SAP'])
					{
      				    if($codSAP != '')echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
				        $codSAP = $row['cod_SAP'];
					    $produs = $row['denumire'];
					    $cantitate = $row['cantitate'];
					    $UM = $row['UM'];
					    $detalii = $row['size'];
					    $cantMIN = $row['cantitate.minima'];
					    $cantOPT = $row['cantitate.optima'];
					    $magazie = $row['magazie'];
					    $grupa = $row['grupa_MAT']; 
					}
					else $cantitate = $cantitate + $row['cantitate'];
			    }
			    else
			    {
				    if($codSAP != $row['cod_SAP'])
					{
						echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
				        $codSAP = $row['cod_SAP'];
					    $produs = $row['denumire'];
					    $cantitate = $row['cantitate'];
					    $UM = $row['UM'];
					    $detalii = $row['size'];
					    $cantMIN = $row['cantitate.minima'];
					    $cantOPT = $row['cantitate.optima'];
					    $magazie = $row['magazie'];
					    $grupa = $row['grupa_MAT'];
					}
					else $cantitate = $cantitate + $row['cantitate'];
			    }
			}
			else if($alarm == 'displayMAGAZIE')
			{
			    if($row['cod_SAP'] != $codSAP)
				{
					if($codSAP != '') echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
				    $codSAP = $row['cod_SAP'];
				    $produs = $row['denumire'];
				    $cantitate = $row['cantitate'];
				    $UM = $row['UM'];
				    $detalii = $row['size'];
				    $cantMIN = $row['cantitate.minima'];
				    $cantOPT = $row['cantitate.optima'];
				    $magazie = $row['magazie'];
				    $grupa = $row['grupa_MAT'];
				}
				else $cantitate = $cantitate + $row['cantitate'];
			}
			else if($alarm == 'displayGRUPA')
			{
			    if($row['cod_SAP'] != $codSAP)
				{
					if($codSAP != '') echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
						  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
				    $codSAP = $row['cod_SAP'];
				    $produs = $row['denumire'];
				    $cantitate = $row['cantitate'];
				    $UM = $row['UM'];
				    $detalii = $row['size'];
				    $cantMIN = $row['cantitate.minima'];
				    $cantOPT = $row['cantitate.optima'];
				    $magazie = $row['magazie'];
				    $grupa = $row['grupa_MAT'];
				}
				else $cantitate = $cantitate + $row['cantitate'];
			}
	    }
	    if(($alarm == 'displaySAP' && $codSAP != '') || ($alarm == 'displayNAME' && $produs != '') || ($alarm == 'displayFURNIZOR' && $furnizor != '') || ($alarm == 'displayMAGAZIE' && $magazie != '') || ($alarm == 'displayGRUPA' && $grupa != ''))
	    {
		    echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTMIN(this);"><P CONTENTEDITABLE = false ID = "cantMIN">'.$cantMIN.'</P></TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;" ONDBLCLICK = "editCANTOPT(this);"><P CONTENTEDITABLE = false ID = "cantOPT">'.$cantOPT.'</P></TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
					  <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
	    }
    }
    echo '</TABLE>
</DIV>
<DIV STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; POSITION: FIXED; BOTTOM: 0;">
    <DIV STYLE = "WIDTH: 10%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
        <BUTTON ID = "printBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goPRINT();"><B>Printeaza</BUTTON><BR><BR>
        <BUTTON ID = "exportBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goEXPORT(this);"><B>Exporta</BUTTON>
	</DIV>
    <DIV STYLE = "WIDTH: 40%; HEIGHT: 8vw; MARGIN: 0; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
        <P STYLE = "MARGIN-TOP: 0; MARGIN-LEFT: 2vw; TEXT-ALIGN: CENTER; WIDTH: 50%;">Data:<BR>'.$date.'</P>
	</DIV>
	<DIV STYLE = "WIDTH: 49%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
	    <P STYLE = "MARGIN-TOP: 0">Gestionar:<BR>'.$nume.'<P>
	</DIV>
        </DIV>
</DIV>';

?>
<SCRIPT>
    function goPRINT()
    {
	    document.getElementById("printBUTTON").style.visibility = "hidden";
	    document.getElementById("exportBUTTON").style.visibility = "hidden";
	    window.print();
	    document.getElementById("printBUTTON").style.visibility = "visible";
	    document.getElementById("exportBUTTON").style.visibility = "visible";
    }
    function goEXPORT()
    {
        var data = document.getElementById('displayTABLE');

        var file = XLSX.utils.table_to_book(data, {sheet: "Produse Alarma"});

        XLSX.write(file, { bookType: 'ods', bookSST: true, type: 'base64' });

        XLSX.writeFile(file, "<?php
                                  if($alarm == 'showSTOCKS') echo 'Stoc Magazie RAMIRA SA.ods';
							      else if($alarm == 'displaySAP') echo 'Stoc '.$SAPcode.'.ods';
								  else if($alarm == 'displayMAGAZIE') echo 'Stocuri_Magazie '.$magazie.'.ods';
								  else if($alarm == 'displayGRUPA') echo 'Stocuri_Grupa '.$grupa.'.ods';
								  else if($alarm == 'displayFURNIZOR') echo 'Stocuri_Furnizor '.$FURNIZOR.'.ods';
								  else if($alarm == 'displayNAME') echo 'Stoc '.$PRODname.'.ods';
								  else if($alarm == 'showALARMprod') echo 'Stocuri_Epuizate.ods';
		                      ?>");
    }
    function editCANTMIN(x)
    {
		console.log(x.rowIndex+' content is editable: '+document.getElementById("cantMIN").contentEditable);
	    if(document.getElementById("cantMIN").contentEditable == 'false')
		{
			console.log('Turn conteneditable true');
			document.getElementById("cantMIN").contentEditable = 'true';
		}
    }
    function editCANTOPT(cantOPT)
    {
	    console.log('Turn conteneditable true');
    }
</SCRIPT>
<?php

    echo '<BUTTON ID = "showSTOCK" ONCLICK = "showSTOCKS()" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;">Arata stocurile</BUTTON><BR>
	<DIV ID = "showSTOCKoptions" STYLE = "DISPLAY: NONE; BORDER: 2px SOLID BLACK; BACKGROUND-COLOR: WHITE; BORDER-RADIUS: 20px; MARGIN-LEFT: 1vw; WIDTH: 18vw; MARGIN-TOP: 0.5vw;"><BR>
	    <TABLE STYLE = "MARGIN-LEFT: 1vw;">
	        <TD STYLE = "WIDTH: 6vw; FONT-WEIGHT: BOLD;">
	            Cautare:&nbsp&nbsp
	        </TD>
	        <TD>
		        <INPUT ID = "inputSAP" ONFOCUS = "clearFORM();" LIST = "SAPinputs" PLACEHOLDER = "COD SAP" ONKEYUP = "searchSAP();" ONCHANGE = "displaySAP();" STYLE = "WIDTH: 9.2vw; FONT-SIZE: 0.7vw;"></INPUT><BR>
		            <DATALIST ID = "SAPinputs"></DATALIST>
		        <INPUT ID = "inputNAME" ONFOCUS = "clearFORM();" LIST = "NAMEinputs" ONKEYUP = "searchNAME();" ONCHANGE = "displayNAME();" STYLE = "MARGIN-TOP: 0.5vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "NUME PRODUS"></INPUT><BR>
		            <DATALIST ID = "NAMEinputs"></DATALIST>
		        <INPUT ID = "inputFURNIZOR" ONFOCUS = "clearFORM();" LIST = "FURNIZORinputs" ONKEYUP = "searchFURNIZOR();" ONCHANGE = "displayFURNIZOR();" STYLE = "MARGIN-TOP: 0.5vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "FURNIZOR"></INPUT><BR>
		            <DATALIST ID = "FURNIZORinputs"></DATALIST>
		        <SELECT ID = "inputMAGAZIE" ONFOCUS = "clearFORM();" ONCHANGE = "displayMagazie();" STYLE = "MARGIN-TOP: 0.5vw; HEIGHT: 1.2vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;">
				    <OPTION>MAGAZIE</OPTION>';
				$qmag = "SELECT `magazie` FROM `magazie_stoc` GROUP BY `magazie`";
				if($qmagRUN = mysql_query($qmag))
				{
				    if(mysql_num_rows($qmagRUN) > 0)
				    {
					    while($qmagROW = mysql_fetch_assoc($qmagRUN))
					    {
						    $magazie = $qmagROW['magazie'];
						    echo '<OPTION>'.$magazie.'</OPTION>';
					    }
				    }
				}
				else
				{
					$mailerror = '<font STYLE = "FONT-SIZE: 1.5vw;"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
                              echo '</SELECT><BR>
		        <SELECT ID = "inputGRUPA" ONFOCUS = "clearFORM();" ONCHANGE = "displayGRUPA();" STYLE = "MARGIN-TOP: 0.5vw; HEIGHT: 1.2vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;">
		            <OPTION>GRUPA MATERIALE</OPTION>';
                        $qGRUP = "SELECT `grupa_MAT` FROM `magazie_stoc` GROUP BY `grupa_MAT`";
				if($qGRUPrun = mysql_query($qGRUP))
				{
				    if(mysql_num_rows($qGRUPrun) > 0)
				    {
					    while($qGRUProw = mysql_fetch_assoc($qGRUPrun))
					    {
						    $grupa = $qGRUProw['grupa_MAT'];
						    echo '<OPTION>'.$grupa.'</OPTION>';
					    }
				    }
				}
				else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
	      echo '</SELECT><BR>
		        <INPUT STYLE = "MARGIN-TOP: 0.5vw; MARGIN-BOTTOM: 0.5vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "DETALII"></INPUT><BR>
		    </TD><TR>
		    <TD STYLE = "FONT-WEIGHT: BOLD;">
		        Sortare:&nbsp&nbsp
		    </TD>
		    <TD STYLE = "MARGIN-TOP: 0.5vw;">
		        <SELECT ID = "tableSORTING" ONCHANGE = "sortTABLE();" STYLE = "HEIGHT: 1.2vw; WIDTH: 9.2vw; FONT-SIZE: 0.7vw;">
		            <OPTION VALUE = "cod_SAP">Cod SAP</OPTION>
		            <OPTION VALUE = "denumire">Denumire</OPTION>
		            <OPTION VALUE = "furnizor">Furnizor</OPTION>
		            <OPTION VALUE = "pret">Pret</OPTION>
		            <OPTION VALUE = "size">Detalii</OPTION>
		            <OPTION VALUE = "cantitate.minima">Cantitate minima</OPTION>
		            <OPTION VALUE = "magazie">Magazie</OPTION>
		            <OPTION VALUE = "grupa_MAT">Grupa materiale</OPTION>
		        </SELECT><BR>
		    </TD>
		</TABLE><BR>
	</DIV><BR>
	<BUTTON ID = "showPROVIDERS" ONCLICK = "showPROVIDE()" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;">Arata furnizori</BUTTON><BR><BR>
	<BUTTON ID = "droppingSTOCKS" ONCLICK = "showDROPPINGstocks()" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;">Stocuri in scadere</BUTTON><BR><BR>
	<BUTTON ID = "orderSET" ONCLICK = "createORDERS()" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;">Efectueaza comanda</BUTTON>
</DIV>';

?>
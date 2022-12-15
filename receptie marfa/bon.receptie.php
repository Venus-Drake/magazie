<HTML>
    <HEAD>
        <link rel="stylesheet" href="/ramira/magazie/receptie marfa/styling.css">
        <STYLE>
            THEAD
	  		{
				DISPLAY:TABLE-HEADER-GROUP;
			}
            .scrollableDIV
	  		{
				PAGE-BREAK-INSIDE: AUTO;
	  		}
            @PAGE
	        {
				SIZE: A4;
			    MARGIN-LEFT: 2CM;
				MARGIN-BOTTOM: 1.5CM;
	        }
        </STYLE>
    </HEAD>
    <BODY>
        <?php 
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/receptie marfa/seria.grab.php';
		    $nume = '<SCRIPT> document.writeln(window.parent.document.getElementById("numeGESTIONAR").innerHTML);</SCRIPT>';
		?>
		<DIV STYLE = "OVERFLOW: HIDDEN; WIDTH: 100%; HEIGHT: 100%;">
		    <DIV ID = "declarationINTRO" STYLE = "MARGIN: 0 AUTO; WIDTH: 100%;">
		        <IMG SRC = "logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;"><BR>
		        <B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">NOTA INTRARE RECEPTIE</FONT>
				    <FONT STYLE = "FONT-SIZE: 1.3vw;"><br>Seria: <?php echo $seria; ?><DIV ID = "seriaNOTA" STYLE = "DISPLAY: NONE;"><?php echo $seria; ?></DIV> / <?php echo $date;?><DIV STYLE = "DISPLAY: NONE;" ID = "dataNOTA"><?php echo $date;?></DIV></CENTER></FONT>
				<BR><BR><BR>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSe primesc de la&nbsp&nbsp</DIV>
				<DIV ID = "furnizorFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspfurnizor&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, cu sediul in:&nbsp&nbsp</DIV>
				<DIV ID = "orasFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsporas&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, str. :&nbsp&nbsp</DIV>
				<DIV ID = "stradaFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspnumele strazii&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, nr. :&nbsp&nbsp</DIV>
				<DIV ID = "nrstrFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>nr. str. </i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, judet:&nbsp&nbsp</DIV>
				<DIV ID = "judetFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspjudetul&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, in baza facturii:&nbsp&nbsp</DIV>
				<DIV ID = "facseriaFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT; TEXT-TRANSFORM: UPPERCASE;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">&nbsp&nbspdin&nbsp&nbsp</DIV>
				<DIV ID = "facdateFRAME" STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">
				    <u><i></b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdata&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></u><b>
				</DIV>
				<DIV STYLE = "WIDTH: MAX-CONTENT; FLOAT: LEFT;">, urmatoarele produse:</LEFT></B><BR><BR></DIV>
		    </DIV>
		    <DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 40vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK; MARGIN-TOP: 10vh;">
		        <TABLE ID = "bonTABLE" class="table table-striped table-bordered" ALIGN = CENTER WIDTH = 100% STYLE = "BORDER-COLLAPSE: SEPARATE; MARGIN-TOP: 12vw; MARGIN: 0; BORDER-SPACING: 0; FONT-SIZE: 1.5vw">
  		 	        <THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY; BORDER: 2px SOLID BLACK; FONT-SIZE: 1.5vw;">
	              	    <TR><TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Cod SAP</TH>
	              	    <TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Cod Furnizor</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 15%;">Denumire</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Pret</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Cantitate</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">U.M.</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Detalii</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Magazie</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Grupa</TH>
	              		<TH STYLE = "BORDER-BOTTOM: 2px SOLID BLACK; WIDTH: 5%;">Valoare</TH></TR>
		    		</THEAD>
		    		<TBODY>
		    		</TBODY>
      		    </TABLE>
		    </DIV>
		    <DIV STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; POSITION: FIXED; BOTTOM: 0;">
				<DIV STYLE = "WIDTH: 50%; HEIGHT: 8vw; MARGIN: 0; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
    			   <P STYLE = "MARGIN-TOP: 0; MARGIN-LEFT: 2vw; TEXT-ALIGN: CENTER; WIDTH: 50%;">Data:<BR><?php echo $date;?></P>
    			   <BUTTON CLASS = "PRINT" ID = "RECprintBUTTON" STYLE = "MARGIN-LEFT: 5vw; FONT-WEIGHT: BOLD;" ONCLICK = "goPRINTrec();"><B>Printeaza / Finalizeaza</BUTTON>
		        </DIV>
				<DIV STYLE = "WIDTH: 49%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
			 	    <P STYLE = "MARGIN-TOP: 0">Gestionar:<BR><?php echo $nume;?><P>
			 	    <BUTTON CLASS = "EXPORT" ID = "exportBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goCANCEL();"><B>Anuleaza</BUTTON>
				</DIV>
            </DIV>
		</DIV>
<?php

	$seria = 'RAMWARtemporar';
	if(isset($_POST['alarm']) && !empty($_POST['alarm']))
	{
	    $alarm = $_POST['alarm'];
	    if($alarm == 'showINVOICE')
	    {
			if(isset($_POST['name']) && !empty($_POST['name']))
			{
			    $nume = $_POST['name'];
			}
			else $nume = 'Undefined user';
	    }
	}
?>
        <SCRIPT src="/ramira/magazie/receptie marfa/receptie.script.js"></SCRIPT>
    </BODY>
</HTML>
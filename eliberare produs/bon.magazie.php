<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
    <SCRIPT src="/ramira/magazie/eliberare produs/eliberare.script.js"></SCRIPT>
    <STYLE>
        BODY
        {
		    ANIMATION: ALL NONE;
		    BACKGROUND-COLOR: WHITE; OPACITY: 1;
        }
    </STYLE>
</HEAD>

<BODY ID = "bon_magazie_rs"  ONLOAD = "inserareGESTIONAR()">

	<?php

    global $amount;
    global $proc;
    global $unit;
    global $seria;

	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
	
	$valtot = '0.00';
	$worker = 'NUME ANGAJAT';
	$marca = 'NR. MARCA';
	if(isset($_GET['nume']) && !empty($_GET['nume'])) $nume = $_GET['nume'];
	else $nume = "Unknown User";
	if(isset($_GET['angajat']) && !empty($_GET['angajat'])) 
	{
		$worker = $_GET['angajat'];     //NE ASIGURAM CA NU AVEM VREO COMANDA PE ALT NUME RAMASA DESCHISA
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/verificare.comenzi.php';
	}
	else if(empty($_GET['angajat']))    //VERIFICAM DACA AVEM, CUMVA, VREO COMANDA NEFINALIZATA RAMASA DIN URMA
	{
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/verificare.comenzi.php';
	}
	else $worker = 'Angajat INEXISTENT';
	if(isset($_POST['sapcode']) && !empty($_POST['sapcode'])) $SAPcode = $_POST['sapcode'];
	if(isset($_POST['amount']) && !empty($_POST['amount'])) $amount = $_POST['amount'];
	if(isset($_POST['stock']) && !empty($_POST['stock'])) $stock = $_POST['stock'];
	if(isset($_POST['action']) && !empty($_POST['action'])) $action = $_POST['action'];
	else $action = 'Adauga';
	if(isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'];
	else $date = date('d M Y', time());
	if(isset($_GET['rekrow']) && !empty($_GET['rekrow'])) $marca = $_GET['rekrow'];
	if(isset($_GET['sectia']) && !empty($_GET['sectia'])) $sectia = $_GET['sectia'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/grab.seria.nr.php';

	?>

    <DIV STYLE = "WIDTH: 100%; MARGIN: 20px AUTO; BACKGROUND-COLOR: WHITE;">
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO;">
  		    <IMG SRC = "logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
        	<B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">BON DE CONSUM MAGAZIE</FONT><BR>Seria: <SPAN ID = "seriaBON"><?php echo $seria;?></SPAN></CENTER><BR><BR><BR>
			<LEFT><FONT STYLE = "FONT-SIZE: 1.5VW">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Se elibereaza catre 
				<SPAN ID = "numeANGAJATbon" STYLE = "BORDER-BOTTOM: 1PX DOTTED BLACK; MIN-WIDTH: 20vw; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"> </SPAN> 
				(marca: 
				<SPAN ID = "marcaANGAJATbon" STYLE = "BORDER-BOTTOM: 1PX DOTTED BLACK; MIN-WIDTH: 7vw; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"></SPAN>
				), angajat al sectiei 
				<SPAN ID = "sectiaBON" STYLE = "BORDER-BOTTOM: 1PX DOTTED BLACK; MIN-WIDTH: 7vw; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"></SPAN>
				, urmatoarele produse:<BR><BR>
			    <TABLE WIDTH = 100% STYLE = "BORDER: 2px SOLID BLACK; TEXT-ALIGN: CENTER; MARGIN: 0 AUTO;">
		            <TD>
		                <TABLE ID = "bon.magazie" WIDTH = 100% BORDER = 1 ALIGN = CENTER>
		                    <TR>
			                    <TH WIDTH = 15% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Produs</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Cod SAP</TH>
			                    <TH WIDTH = 10% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Furnizor</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Uzura</TH>
			                    <TH WIDTH = 3% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">U.M.</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Valoare</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Stoc initial</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Cantitate</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Stoc final</TH>
			                    <TH WIDTH = 5% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Val. tot.</TH>
			                    <TH WIDTH = 10% FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">Observatii</TH>
							</TR>
							<?php 
							    if($action == 'Adauga') 
								{
									if($amount > 0 && $worker != '' && $SAPcode != '' && $stock != '' && $marca != '' && $sectia != '') require 'C:\xampp\htdocs\ramira\magazie\eliberare produs\bon.magazie.adaugare.php';
									else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
								}
							    else if($action == 'Sterge') require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.magazie.stergere.php';
							    else if($action == 'Anulare') echo 'Actiune anulata.';
							    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.consum.reader.php';
							?>
		                </TABLE>
		            </TD><TR>
		            <TD STYLE = "TEXT-ALIGN: RIGHT; HEIGHT: 20px; FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">
		                <SPAN ID = "totalBON">0.00</SPAN>&nbspRON&nbsp&nbsp&nbsp&nbsp
		            </TD>
	            </TABLE>
            </TABLE>
        </DIV>
		<DIV STYLE = "POSITION: FIXED; BOTTOM : 0; MARGIN: 0 AUTO; ALIGN-ITEMS: CENTER; WIDTH: 100%;">
            <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%">
                <B>DATA<BR><SPAN STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 20VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"><?php echo $date;?></SPAN><BR>
                <?php if($proc == 0) echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" ONCLICK = "confirmare()">CONFIRMARE ANGAJAT</BUTTON>';
                      else echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" STYLE = "BACKGROUND-COLOR: LIGHTGREEN;">CONFIRMARE ANGAJAT</BUTTON>';?>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FONT-SIZE: 1.5VW">
                <B>SEMNATURA GESTIONAR<BR><SPAN ID = "semnaturaGESTIONAR" STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 20VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"></SPAN><BR>
                <?php if($proc == 0) echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()">PRINTEAZA/FINALIZEAZA</BUTTON>';
                      else echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()" STYLE = "BACKGROUND-COLOR: #ff3300">PRINTEAZA/FINALIZEAZA</BUTTON>';?>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 100%;" ID = "FOOT_NOTE">
	        <FONT STYLE = "FONT-SIZE: 1.2VW"><BR><CENTER>BONURILE DE COMANDA SE SALVEAZA AUTOMAT, ODATA CU CONFIRMAREA COMENZII DE CATRE ANGAJAT. PENTRU O NOUA COMANDA, FOLOSITI BUTONUL PRINTEAZA/FINALIZEAZA.</FONT>
	        </DIV>
        </DIV>
    </DIV>
    <DIV ID = "confModal" class="confModal"><BR><BR><BR><BR><BR>
	    <DIV ONLOAD = "loadFOCUS();" class = "modal-content" STYLE = "background-color: gray; font-weight: bold; HEIGHT: 100px; MARGIN-TOP: 300px; MARGIN-LEFT: 110px;">
            <span ID = "c_close" CLASS = "close">&#x2623;</span>
                <INPUT TYPE = "password" ID = "worker_confirm" ONCHANGE = "salveaza_comanda()" AUTOSUGEST = "OFF" TITLE = ></INPUT>
			    <CENTER><BUTTON ID = "c_setoff" CLASS = "setoff"><B>Anuleaza</BUTTON>
            </DIV>
		<BR><BR>
    </DIV>
        <SCRIPT src="/ramira/magazie/eliberare produs/eliberare.script.js"></SCRIPT>
    </BODY>
</HTML>
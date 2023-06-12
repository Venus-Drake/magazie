<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <link href='https://fonts.googleapis.com/css?family=Libre Barcode 39' rel='stylesheet'>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
    <STYLE>
        BODY
        {
		    ANIMATION: ALL NONE;
		    BACKGROUND-COLOR: WHITE; OPACITY: 1;
        }
        .modal_content
        {}
    </STYLE>
</HEAD>

<BODY ID = "bon_magazie_rs">

	<?php

    global $amount;
    global $proc;
    global $unit;

	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';

    $seria = 'RAMIRA S.A. - Productie';
    if(isset($_GET['mysector']) && !empty($_GET['mysector'])) $mysector = $_GET['mysector'];

	?>

    <DIV STYLE = "WIDTH: 100%; MARGIN: 20px AUTO; BACKGROUND-COLOR: WHITE;">
        <DIV ID = "Busy" STYLE = "DISPLAY: NONE;">0</DIV>
    <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 9%; HEIGHT:4.5%; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1%;">
        <B><CENTER><FONT STYLE = "FONT-SIZE: 1.5vw">RAPORT PRODUCTIE</FONT><BR><FONT STYLE = "FONT-SIZE: 1vw">Sectia: <SPAN ID = "sectieRaport"><?php echo $seria;?></SPAN></CENTER><BR></FONT>
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 63%; OVERFLOW: AUTO; BORDER: 2px SOLID BLACK;">
            <TABLE ID = "OrdersDisplayTable" STYLE = "WIDTH: 100%; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; BORDER-COLLAPSE: SEPARATE; PADDING: 0; MARGIN: 0; BORDER-SPACING: 0;">
                <TR><THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY;">
                    <TH ID = "selectImp" STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 5%;" TITLE = "Importanta">Imp.
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "OrdersFiltering();"></DIV></TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 7%;" TITLE = 'Production Job'>P.J.
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "OrdersFiltering();"></DIV></TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 6%;" TITLE = "Production Order">P.O.
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "OrdersFiltering();"></DIV></TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 4%;" TITLE = "Numarul operatiei">Op.<BR>Nr.</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 4%;" TITLE = "Total bucati">Total<br>Buc.</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 5%;" TITLE = "Bucati efectuate">Buc.<BR>Efectuate</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 7%;" TITLE = "Sectorul repartizat">Sector
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "OrdersFiltering();"></DIV></TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 8%;">Timp<BR>Normat (min)</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 8%;">Timp<BR>Executat (min)</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 5%;" TITLE = "Grupul de masini repartizat">Grup</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 10%;" TITLE = "Masina repartizata">Masina
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "OrdersFiltering();"></DIV></TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW; WIDTH: 15%;" TITLE = "Angajat repartizat">Angajat</TH>
                </THEAD></TR>
            </TABLE>
			
        </DIV>
		<DIV STYLE = "POSITION: FIXED; BOTTOM : 0; MARGIN: 0 AUTO; ALIGN-ITEMS: CENTER; WIDTH: 100%; HEIGHT: 10%">
            <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FONT-SIZE: 1.1VW">
                <B>DATA<BR><SPAN STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 10VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER; FONT-SIZE: 1.1VW"><?php echo $date;?></SPAN><BR>
                    <BUTTON CLASS = "CONFIRM" ID = "CONFIRM" ONCLICK = "confirmare()" STYLE = "WIDTH: 10vw; FONT-SIZE: 1vw; HEIGHT: 30%;">EXPORTA</BUTTON>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FONT-SIZE: 1.1VW">
                <B>SEMNATURA UTILIZATOR<BR><SPAN ID = "semnaturaGESTIONAR" STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 10VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"><SCRIPT>inserareGESTIONAR();</SCRIPT></SPAN><BR>
                    <BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()" STYLE = "WIDTH: 10vw; FONT-SIZE: 1vw; HEIGHT: 30%;">PRINTEAZA</BUTTON>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 100%;" ID = "FOOT_NOTE">
	        <FONT STYLE = "FONT-SIZE: 1.2VW"><BR><CENTER>Pentru a evita incarcarea foarte grea a listei, va rugam, utilizati formularul de selectare inaintea afisarii comenzilor!</FONT>
	        </DIV>
        </DIV>
    </DIV>
    <DIV ID = "setupModal" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; background-color: gray; font-weight: bold; HEIGHT: 85vh; WIDTH: 80vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: BLOCK; Z-INDEX: 1;">
        <span ID = "c_close" CLASS = "close" ONCLICK = "closeMAINoptions();">Inchide &#x2623;</span><BR><BR>
        <CENTER><SPAN STYLE = "FONT-SIZE: 1.5vw">Setari afisaj</SPAN></CENTER><BR><BR>
        <DIV STYLE = "HEIGHT: 73%;">
            <DIV ID = "emergency" STYLE = "WIDTH: 33%;">
                <SPAN ID = "emergency" STYLE = "MARGIN-LEFT: 3.5vw;">Urgenta</SPAN><BR>
                <P>
                    <INPUT TYPE = "checkbox" ID = "impSelect1" STYLE = "BORDER: 1px SOLID BLACK;"></INPUT><LABEL for = "impSelect1"> Comenzi in intarziere</LABEL><BR>
                    <INPUT TYPE = "checkbox" ID = "impSelect2" STYLE = "BORDER: 1px SOLID BLACK;"></INPUT><LABEL for = "impSelect2"> Comenzi foarte urgente</LABEL><BR>
                    <INPUT TYPE = "checkbox" ID = "impSelect3" STYLE = "BORDER: 1px SOLID BLACK;""></INPUT><LABEL for = "impSelect3"> Comenzi urgente</LABEL><BR>
                    <INPUT TYPE = "checkbox" ID = "impSelect4" STYLE = "BORDER: 1px SOLID BLACK;"></INPUT><LABEL for = "impSelect4"> Nu foarte urgente</LABEL><BR>
                </P>
            </DIV>
            <DIV ID = "sectorOPTIONS" STYLE = "WIDTH: 33%;">
                <SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Sector</SPAN><BR><BR>
                <DIV ID = "sectorSELECTORS" STYLE = "WIDTH: 50%;">
                </DIV>
                <DIV ID = "sectorSELECTORS2" STYLE = "WIDTH: 50%; DISPLAY: NONE;">
                </DIV>
            </DIV>
            <DIV ID = "machineGROUPS" STYLE = "WIDTH: 33%;">
                <SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Grup Masini</SPAN><BR><BR>
                <DIV ID = "machGROUPS1" STYLE = "WIDTH: 33%; HEIGHT: 45%;"></DIV>
                <DIV ID = "machGROUPS2" STYLE = "WIDTH: 33%; HEIGHT: 45%;"></DIV>
                <DIV ID = "machGROUPS3" STYLE = "WIDTH: 33%; HEIGHT: 45%;"></DIV>
            </DIV>
            <DIV STYLE = "WIDTH: 100%;">
                <CENTER><BR><SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Masina (selectati sectorul pentru a putea selecta masina)</SPAN><BR>
                <P>
                    <SELECT ID = "selectareMasina" STYLE = "WIDTH: 20vw;">
                        <OPTION></OPTION>
                    </SELECT>
                </P></CENTER>
            </DIV>
            <DIV STYLE = "WIDTH: 100%;">
                <CENTER><SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Angajat (selectati sectorul pentru a putea selecta angajatul)</SPAN><BR>
                <P>
                    <SELECT ID = "selectareAngajat" STYLE = "WIDTH: 20vw;">
                        <OPTION></OPTION>
                    </SELECT>
                </P></CENTER><BR>
            </DIV>
        </DIV>
        <BUTTON ID = "impSelection" ONCLICK = "comenziShow();" STYLE = "WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw; FONT-WEIGHT: BOLD;">Afiseaza</BUTTON><BR>
        <DIV ID = "SetupMessage" STYLE = "WIDTH: 100%; HEIGHT: 3VH;BACKGROUND-COLOR: YELLOW;POSITION: ABSOLUTE; MARGIN: 0 AUTO; BOTTOM: 0; LEFT: 0;BORDER-BOTTOM-LEFT-RADIUS: 20px;BORDER-BOTTOM-RIGHT-RADIUS: 20px;DISPLAY: NONE; TEXT-ALIGN: CENTER;"></DIV>
        <DIV ID = "confDIALOG" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; BORDER: 2px SOLID BLACK; background-color: YELLOW; font-weight: bold; HEIGHT: 15vh; WIDTH: 40vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: NONE; Z-INDEX: 1; FONT-WEIGHT: BOLD;">
            Ati selectat toate optiunile de urgenta!<BR>
            Acest lucru ar putea crea un raport foarte mare, care s-ar incarca un pic cam incet si ar incarca pagina.<BR>
            Sunteti sigur/a ca doriti sa mergeti mai departe?<BR><BR>
            <BUTTON ID = "confYES" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw;" ONCLICK = "userAccept(this);">Da</BUTTON><BUTTON ID = "confNO" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw;" ONCLICK = "userAccept(this);">Nu</BUTTON>
        </DIV>
        <SCRIPT>loadSELECTORS();</SCRIPT>
    </DIV>
    <DIV ID = "AfisareComanda" class = "modal-content" STYLE = "POSITION: ABSOLUTE; FLOAT: NONE; background-color: white; font-weight: bold; HEIGHT: 85vh; WIDTH: 70vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 10vw; FONT-SIZE: 1.2vw; DISPLAY: NONE; Z-INDEX: 10;">
        <DIV ID = "DraggableHeader" STYLE = "BACKGROUND-COLOR: LIGHTGREY; CURSOR: MOVE; WIDTH: 87%; HEIGHT: 3vh; MARGIN: 0 AUTO; TOP: 0;"></DIV>
        <span CLASS = "close" ONCLICK = "CloseDetails();">Inchide &#x2623;</span>
            <DIV STYLE = "WIDTH: 95%; HEIGHT: 94%; FLOAT: NONE; MARGIN: 0 AUTO; MARGIN-LEFT: 5%; MARGIN-TOP: 5vh;">
            <DIV STYLE = "BORDER: 2px SOLID BLACK; WIDTH: 98%; HEIGHT: 8%; FLOAT: NONE; MARGIN: 0 AUTO;FONT-SIZE: 1.5vw; FONT-WEIGHT: BOLD;">
                <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 12%; HEIGHT:60%; MARGIN-TOP: 1.1vh; MARGIN-LEFT: 1vw; FLOAT: LEFT;">
                <DIV STYLE = "BORDER-LEFT: 2px SOLID BLACK; HEIGHT: 100%; MARGIN-LEFT: 3vw;">
                    <SPAN STYLE = "HEIGHT: 60%; FLOAT: LEFT; MARGIN: 0 AUTO; MARGIN-LEFT: 2vw; MARGIN-TOP: 1.3vh;">Detalii comanda</SPAN>
                </DIV>
            </DIV>
            <DIV STYLE = "WIDTH: 98%; HEIGHT: 15%; FLOAT: NONE; MARGIN: 0 AUTO;">
                <TABLE STYLE = "BORDER: 2px SOLID BLACK; WIDTH: 100%; HEIGHT: 100%; MARGIN: 0 AUTO; MARGIN-TOP: 3vh; FONT-SIZE: 1.2vw;">
                    <TR STYLE = "HEIGHT: 50%;">
                        <TD STYLE = "WIDTH: 20%; BORDER-RIGHT: 2px SOLID BLACK;">Production Job</TD>
                        <TD STYLE = "WIDTH: 5%; BORDER-RIGHT: 2px SOLID BLACK;">Op. Nr.</TD>
                        <TD STYLE = "WIDTH: 15%; BORDER-RIGHT: 2px SOLID BLACK;">Production Order</TD>
                        <TD STYLE = "WIDTH: 5%; BORDER-RIGHT: 2px SOLID BLACK;">Cantitate</TD>
                        <TD>Data finalizarii</TD>
                    </TR>
                    <TR STYLE = "FONT-WEIGHT: BOLD; BORDER-TOP: 2px SOLID BLACK; HEIGHT: 50%;">
                        <TD STYLE = "BORDER-RIGHT: 2px SOLID BLACK;" ID = "DetaliiPJ_Number"></TD>
                        <TD STYLE = "BORDER-RIGHT: 2px SOLID BLACK;" ID = "DetaliiOpNr_Number"></TD>
                        <TD STYLE = "BORDER-RIGHT: 2px SOLID BLACK;" ID = "DetaliiPO_Number"></TD>
                        <TD STYLE = "BORDER-RIGHT: 2px SOLID BLACK;" ID = "DetaliiAmount_Number"></TD>
                        <TD ID = "DetaliiFinalDate"></TD>
                    </TR>
                </TABLE>
            </DIV>
            <DIV STYLE = "BORDER: 2px SOLID BLACK; WIDTH: 98%; HEIGHT: 18%; FLOAT: NONE; MARGIN: 0 AUTO; MARGIN-TOP: 3vh;">
                <DIV STYLE = "WIDTH: 100%; MARGIN: 0 AUTO; HEIGHT: 40%; FONT-WEIGHT: NORMAL;">
                    <DIV STYLE = "WIDTH: 8%; FLOAT: LEFT; TEXT-ALIGN: CENTER;">
                        Operatia
                    </DIV>
                    <DIV STYLE = "WIDTH: 8%; FLOAT: LEFT; TEXT-ALIGN: CENTER;">
                        Grup Masina
                    </DIV>
                    <DIV STYLE = "WIDTH: 60%; FLOAT: LEFT; TEXT-ALIGN: CENTER;">
                        COD de bare
                    </DIV>
                    <DIV STYLE = "WIDTH: 22%; FLOAT: LEFT; TEXT-ALIGN: CENTER;">
                        Angajat
                    </DIV>
                </DIV>
                <DIV STYLE = "WIDTH: 100%; MARGIN: 0 AUTO;">
                    <DIV ID = "OpNr_Number" STYLE = "WIDTH: 8%; FLOAT: LEFT; TEXT-ALIGN: CENTER;"></DIV>
                    <DIV ID = "Group_Code" STYLE = "WIDTH: 8%; FLOAT: LEFT; TEXT-ALIGN: CENTER;"></DIV>
                    <DIV ID = "Bar_Code" STYLE = "WIDTH: 60%; FLOAT: LEFT; TEXT-ALIGN: CENTER; FONT-SIZE: 6VW; FONT-FAMILY: 'Libre Barcode 39'; FONT-WEIGHT: NORMAL;"></DIV>
                    <DIV ID = "Employee_Name" STYLE = "WIDTH: 22%; FLOAT: LEFT; TEXT-ALIGN: CENTER;"></DIV>
                </DIV>
            </DIV>
            <DIV>

            </DIV>
            <SCRIPT>dragElement(document.getElementById('AfisareComanda'));</SCRIPT>
        </DIV>
    </DIV> 
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
</BODY>
</HTML>
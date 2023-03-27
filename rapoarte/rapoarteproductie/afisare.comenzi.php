<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
    <STYLE>
        BODY
        {
		    ANIMATION: ALL NONE;
		    BACKGROUND-COLOR: WHITE; OPACITY: 1;
        }
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
        <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
        <B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">RAPORT PRODUCTIE</FONT><BR>Sectia: <SPAN ID = "sectieRaport"><?php echo $seria;?></SPAN></CENTER><BR><BR>
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 63vh; OVERFLOW: AUTO;">
            <TABLE STYLE = "WIDTH: 98%; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO;">
                <THEAD STYLE = "POSITION: STICKY;">
                    <TH ID = "selectImp" STYLE = "BORDER: 1px SOLID BLACK; CURSOR: POINTER;" ONCLICK = "importanceSelect();">Importance</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Production<BR>Job</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Production<BR>Order</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Operation<BR>Nr.</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Pieces</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Pieces<BR>Done</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Assigned<BR>Sector</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Normed<BR>Time (min)</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Executed<BR>Time (min)</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Machine<BR>Group</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Machine</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK;">Employee<BR>Running</TH><TR>
                </THEAD>

            <?php
                
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                if($mysector == 'MANAPROD' || $mysector == 'MANAGEMENT')
                {
                    if(!$searchDB = $connect -> query("SELECT * FROM `production.queue` ORDER BY `importance`")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                    else
                    {
                        if(mysqli_num_rows($searchDB) > 0)
                        {
                            //echo 'Found '.mysqli_num_rows($searchDB).' orders';
                            while($row = $searchDB -> fetch_assoc())
                            {
                                $importance = $row['importance'];
                                $PJ = $row['productionJOB'];
                                $PO = $row['productionORDER'];
                                $operation = $row['POoperation'];
                                $pieces = $row['pieces'];
                                $piecesDone = $row['piecesDONE'];
                                $sector = $row['sector'];
                                $normTime = $row['executionTIME'];
                                $realTime = $row['executedTIME'];
                                $machineGroup = $row['machineGROUP'];
                                $machine = $row['machine'];
                                $employee = $row['employee'];
                                if($importance <= 0)$indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: BROWN;"></DIV>';
                                else if($importance > 0 && $importance <= 5)$indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: RED;"></DIV>';
                                else if($importance > 5 && $importance < 10)$indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: YELLOW;"></DIV>';
                                else $indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: GREEN;"></DIV>';

                                echo '
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$importance.' '.$indicator.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$PJ.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$PO.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$operation.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$pieces.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$piecesDone.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$sector.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$normTime.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$realTime.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$machineGroup.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$machine.'</TD>
                                <TD STYLE = "BORDER: 1px SOLID BLACK;">'.$employee.'</TD>
                                <TR>';
                            }
                        }
                        //else echo 'Something not OK';
                    }
                }
            ?>
            </TABLE>
			
        </DIV>
		<DIV STYLE = "POSITION: FIXED; BOTTOM : 0; MARGIN: 0 AUTO; ALIGN-ITEMS: CENTER; WIDTH: 100%;">
            <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%">
                <B>DATA<BR><SPAN STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 20VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"><?php echo $date;?></SPAN><BR>
                <?php if($proc == 0) echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" ONCLICK = "confirmare()">EXPORTA</BUTTON>';
                      else echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" STYLE = "BACKGROUND-COLOR: LIGHTGREEN;">CONFIRMARE ANGAJAT</BUTTON>';?>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FONT-SIZE: 1.5VW">
                <B>SEMNATURA GESTIONAR<BR><SPAN ID = "semnaturaGESTIONAR" STYLE = "BORDER-BOTTOM: 1px DOTTED BLACK; MIN-WIDTH: 20VW; DISPLAY: INLINE-BLOCK; TEXT-ALIGN: CENTER;"><SCRIPT>inserareGESTIONAR();</SCRIPT></SPAN><BR>
                <?php if($proc == 0) echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()">PRINTEAZA</BUTTON>';
                      else echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()" STYLE = "BACKGROUND-COLOR: #ff3300">PRINTEAZA/FINALIZEAZA</BUTTON>';?>
	        </DIV>
	        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 100%;" ID = "FOOT_NOTE">
	        <FONT STYLE = "FONT-SIZE: 1.2VW"><BR><CENTER>Pentru a evita incarcarea foarte grea a listei, va rugam, utilizati formularul de selectare inaintea afisarii comenzilor!</FONT>
	        </DIV>
        </DIV>
    </DIV>
    <DIV ID = "setupModal" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; background-color: gray; font-weight: bold; HEIGHT: 85vh; WIDTH: 80vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: BLOCK; Z-INDEX: 1;">
        <span ID = "c_close" CLASS = "close" ONCLICK = "closeMAINoptions();">Inchide &#x2623;</span><BR><BR>
        <CENTER><SPAN STYLE = "FONT-SIZE: 1.5vw">Setari afisaj</SPAN></CENTER><BR><BR>
        <DIV STYLE = "HEIGHT: 80%;">
            <DIV STYLE = "WIDTH: 33%;">
                <SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Urgenta</SPAN><BR>
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
                <CENTER><BR><BR><SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Masina (selectati sectorul pentru a putea selecta masina)</SPAN><BR>
                <P>
                    <SELECT ID = "selectareMasina" STYLE = "WIDTH: 20vw;">
                        <OPTION></OPTION>
                    </SELECT>
                </P></CENTER><BR><BR>
            </DIV>
            <DIV STYLE = "WIDTH: 100%;">
                <CENTER><SPAN STYLE = "MARGIN-LEFT: 3.5vw;">Angajat (selectati sectorul pentru a putea selecta angajatul)</SPAN><BR>
                <P>
                    <SELECT ID = "selectareAngajat" STYLE = "WIDTH: 20vw;">
                        <OPTION></OPTION>
                    </SELECT>
                </P></CENTER><BR><BR>
            </DIV>
        </DIV>
        <BUTTON ID = "impSelection" ONCLICK = "comenziSetup(this);" STYLE = "BOTTOM: 7vh; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw; FONT-WEIGHT: BOLD;">Afiseaza</BUTTON>
        <DIV ID = "confDIALOG" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; BORDER: 2px SOLID BLACK; background-color: YELLOW; font-weight: bold; HEIGHT: 15vh; WIDTH: 40vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: NONE; Z-INDEX: 1; FONT-WEIGHT: BOLD;">
            Ati selectat toate optiunile de urgenta!<BR>
            Acest lucru ar putea crea un raport foarte mare, care s-ar incarca un pic cam incet si ar incarca pagina.<BR>
            Sunteti sigur/a ca doriti sa mergeti mai departe?<BR><BR>
            <BUTTON ID = "confYES" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw;" ONCLICK = "comenziSetup(this);">Da</BUTTON><BUTTON ID = "confNO" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw;" ONCLICK = "comenziSetup(this);">Nu</BUTTON>
        </DIV>
        <SCRIPT>loadSELECTORS();</SCRIPT>
    </DIV>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
</BODY>
</HTML>
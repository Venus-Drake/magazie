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
        <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 9%; HEIGHT:4.5%; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1%;">
        <B><CENTER><FONT STYLE = "FONT-SIZE: 1.5vw">AFISARE MASINI</FONT><BR><FONT STYLE = "FONT-SIZE: 1vw">Sectia: <SPAN ID = "sectieRaport"><?php echo $mysector;?></SPAN></CENTER><BR></FONT>
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 63%; OVERFLOW: AUTO; BORDER: 2px SOLID BLACK;">
            <TABLE ID = "MachinesDisplayTable"  STYLE = "WIDTH: 100%; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; BORDER-COLLAPSE: SEPARATE; PADDING: 0; MARGIN: 0; BORDER-SPACING: 0;">
                <TR><THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY;">
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;">Nr.<br>crt.</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = 'Sector masina'>Sector</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Operatiune scanata pe msina">Grup</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Numele complet al masinii">Denumire Masina</TH>
                    <TH ID = "selectImp" STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Masina activa / inactiva">Masina<BR>Activa</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = 'Motiv inactivitate masina'>Motiv</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Durata inactivitate estimata">Durata</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Incarcarea maxima admisa a masinii (minute)">Incarcare<BR>Maxima</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Incarcarea efectiva a masinii (minute)">Incarcare<BR>Efectiva</TH>
                </THEAD></TR>

            <?php
                
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                $NrCrt = 0;
                if($mysector == 'MANAGEMENT' || $mysector == 'ERP') $myQuery = "SELECT * FROM `sectors.machines.groups` ORDER BY `sector`";
                else $myQuery = "SELECT * FROM `sectors.machines.groups` WHERE `sector` = '$mysector' ORDER BY `machine`";
                if(!$searchDB = $connect -> query($myQuery)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                else
                {
                    if(mysqli_num_rows($searchDB) > 0)
                    {
                        //echo 'Found '.mysqli_num_rows($searchDB).' orders';
                        while($row = $searchDB -> fetch_assoc())
                        {
                            $NrCrt++;
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$NrCrt.'</TD>';
                            $sector = $row['sector'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$sector.'</TD>';
                            $grup = $row['group'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$grup.'</TD>';
                            $machine = $row['machine'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$machine.'</TD>';;
                            $active = $row['MachineACTIVE'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" contenteditable = "true">'.$active.'</TD>';
                            $reason = $row['motiv'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" contenteditable = "true">'.$reason.'</TD>';
                            
                            $InactiveTime = $row['timpInactiv'];
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" contenteditable = "true">'.$InactiveTime.'</TD>';
                            $MaxLoad = $row['TotalLOAD'];
                            if(!$MaxLoadChk = $connect -> query("SELECT `workerHoursDefault` FROM `pworker` WHERE ((`masina` = '$machine' OR `masina_SEC` = '$machine') AND (`clasa_MASINA` = '$grup' OR `clasa_SEC` = '$grup')) AND `workerACTIVE` = '1' AND `workerHoursDefault` > '0'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($MaxLoadChk) > 0)
                                {
                                    $MaxLoad = 0;
                                    //echo 'Found: '.$grup.'<BR>';
                                    while($MaxLoadRow = $MaxLoadChk -> fetch_assoc())
                                    {
                                        $MaxLoad = $MaxLoad + $MaxLoadRow['workerHoursDefault'];
                                    }
                                }
                                else $MaxLoad = 0;
                                $MaxLoad = $MaxLoad * 120;
                                if(!$MaxLoadUpd = $connect -> query("UPDATE `sectors.machines.groups` SET `TotalLOAD` = '$MaxLoad' WHERE `sector` = '$sector' AND `machine` = '$machine' AND `group` = '$grup'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            }
                            echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$MaxLoad.'</TD>';
                            $Loaded = $row['TimeLOADED'];
                            if(!$LoadChk = $connect -> query("SELECT `executionTIME`, `executedTIME` FROM `production.queue` WHERE `piecesDONE` < `pieces` AND `sector` = '$sector' AND `machineGROUP` = '$grup' AND `machine` = '$machine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($LoadChk) > 0)
                                {
                                    $Loaded = 0;
                                    while($LoadRow = $LoadChk -> fetch_assoc())
                                    {
                                        if($sector != '')
                                        {
                                            $NormTime = $LoadRow['executionTIME'];
                                            $ExeTime = $LoadRow['executedTIME'];
                                            if($ExeTime == 0 || $NormTime == $ExeTime) $Loaded = $Loaded + $NormTime;
                                            else if($ExeTime > $NormTime) $Loaded = $Loaded + $ExeTime;
                                            else if($ExeTime < $NormTime) $Loaded = $Loaded + ($NormTime - $ExeTime);
                                        }
                                    }
                                }
                                else 
                                {
                                    if($Loaded != 0) $Loaded = 0;
                                }
                                if(!$LoadUpd = $connect -> query("UPDATE `sectors.machines.groups` SET `TotalLOAD` = '$MaxLoad', `TimeLOADED` = '$Loaded' WHERE `sector` = '$sector' AND `machine` = '$machine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                else echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$Loaded.'</TD><TR>';
                            }
                        }
                    }
                    //else echo 'Something not OK';
                }
            ?>
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
    <DIV ID = "setupModal" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; background-color: gray; font-weight: bold; HEIGHT: 85vh; WIDTH: 80vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: NONE; Z-INDEX: 1;">
        <span ID = "c_close" CLASS = "close" ONCLICK = "closeMAINoptions();">Inchide &#x2623;</span><BR><BR>
        <CENTER><SPAN STYLE = "FONT-SIZE: 1.5vw">Setari afisaj</SPAN></CENTER><BR><BR>
        <DIV STYLE = "HEIGHT: 80%;">
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
        <BUTTON ID = "impSelection" ONCLICK = "comenziShow();" STYLE = "BOTTOM: 7vh; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw; FONT-WEIGHT: BOLD;">Afiseaza</BUTTON>
        <DIV ID = "confDIALOG" class = "modal-content" STYLE = "POSITION: FIXED; FLOAT: NONE; BORDER: 2px SOLID BLACK; background-color: YELLOW; font-weight: bold; HEIGHT: 15vh; WIDTH: 40vw; MARGIN-TOP: 5vh; MARGIN-LEFT: 8vw; FONT-SIZE: 1.2vw; DISPLAY: NONE; Z-INDEX: 1; FONT-WEIGHT: BOLD;">
            Ati selectat toate optiunile de urgenta!<BR>
            Acest lucru ar putea crea un raport foarte mare, care s-ar incarca un pic cam incet si ar incarca pagina.<BR>
            Sunteti sigur/a ca doriti sa mergeti mai departe?<BR><BR>
            <BUTTON ID = "confYES" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw;" ONCLICK = "userAccept(this);">Da</BUTTON><BUTTON ID = "confNO" STYLE = "FONT-WEIGHT: BOLD; WIDTH: 10vw; HEIGHT: 4vh; FONT-SIZE: 1.5vw; MARGIN-LEFT: 3vw;" ONCLICK = "userAccept(this);">Nu</BUTTON>
        </DIV>
    </DIV>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
</BODY>
</HTML>
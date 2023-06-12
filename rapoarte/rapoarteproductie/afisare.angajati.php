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
        <DIV ID = "Busy" STYLE = "DISPLAY: NONE;">0</DIV>
        <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 9%; HEIGHT:4.5%; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1%;">
        <B><CENTER><FONT STYLE = "FONT-SIZE: 1.5vw">AFISARE ANGAJATI</FONT><BR><FONT STYLE = "FONT-SIZE: 1vw">Sectia: <SPAN ID = "sectieRaport"><?php echo $mysector;?></SPAN></CENTER><BR></FONT>
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 63%; OVERFLOW: AUTO; BORDER: 2px SOLID BLACK;">
            <TABLE ID = "OrdersDisplayTable"  STYLE = "WIDTH: 100%; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; BORDER-COLLAPSE: SEPARATE; PADDING: 0; MARGIN: 0; BORDER-SPACING: 0;">
                <TR><THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY;">
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;">Nr.<br>crt.</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Marca angajat (cod SAP atribuit)">Marca
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH ID = "selectImp" STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Nume angajat">Nume
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = 'Sector angajat'>Sector
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = 'Postul pe care este incadrat angajatul'>Incadrare
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Masina principala angajat">Masina
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Operatiune scanata principala">Oper.
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Masina secundara angajat">Masina 2
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Operatiune scanata secundara">Oper. 2
                        <DIV STYLE = "WIDTH: 1.5vw; HEIGHT: 60%; FLOAT: RIGHT;"><IMG SRC = "../Sorting.png" STYLE = "WIDTH: 100%; HEIGHT: 100%; CURSOR: POINTER;" ONCLICK = "EmployeeFiltering();"></DIV>
                    </TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Angajat activ sau nu">Prezent</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Motiv absenta">Motiv</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Durata absentei (zile; 0 = absenta definitiva)">Durata</TH>
                    <TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1VW;" TITLE = "Motiv absenta definitiva">Remarca</TH></TR>
                </THEAD></TR>

            <?php
                
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                $NrCrt = 0;
                if($mysector == 'MANAGEMENT' || $mysector == 'ERP') $myQuery = "SELECT * FROM `pworker` WHERE `workerACTIVE` = '1' ORDER BY `WORKER_Name`";
                else $myQuery = "SELECT * FROM `pworker` WHERE `workerACTIVE` = '1' AND `sectie` = '$mysector' ORDER BY `masina`, `WORKER_Name`";
                if(!$searchDB = $connect -> query($myQuery)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                else
                {
                    if(mysqli_num_rows($searchDB) > 0)
                    {
                        $UserFullName = explode('=',$_SERVER['HTTP_REFERER']);
                        $UserName = $UserFullName[2];
                        $TmpTableName = 'employees_'.$UserName;
                        if(!$EmployeesTableDrop = $connect -> query("DROP TABLE IF EXISTS `$TmpTableName`")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                        else
                        {
                            if(!$EmployeesTableCreate = $connect -> query("CREATE TABLE `$TmpTableName`(`WORKER_ID` int(6) NOT NULL,
                            `WORKER_Name` varchar(200) NOT NULL,
                            `sectie` varchar(80) NOT NULL,
                            `incadrare` text NOT NULL,
                            `masina` varchar(255) NOT NULL,
                            `clasa_MASINA` varchar(10) NOT NULL,
                            `masina_SEC` varchar(255) NOT NULL,
                            `clasa_SEC` varchar(10) NOT NULL,
                            `workerACTIVE` int(11) NOT NULL,
                            `motivINACTIV` varchar(100) NOT NULL,
                            `daysINACTIVE` int(11) NOT NULL,
                            `remarcaINACTIV` varchar(100) NOT NULL,PRIMARY KEY (`WORKER_ID`))")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                while($row = $searchDB -> fetch_assoc())
                                {
                                    $NrCrt++;
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$NrCrt.'</TD>';
                                    $marca = $row['WORKER_ID'];
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$marca.'</TD>';
                                    $nume = $row['WORKER_Name'];
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$nume.'</TD>';
                                    $sector = $row['sectie'];
                                    echo '<TD ID = "EmSector'.$NrCrt.'" STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" ONCLICK = "SectorChange(this);">'.$sector.'</TD>';
                                    $incadrare = $row['incadrare'];
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$incadrare.'</TD>';
                                    $masina = $row['masina'];
                                    $grup = $row['clasa_MASINA'];
                                    if(!$MachineChk = $connect -> query("SELECT `machine` FROM `sectors.machines.groups` WHERE `machine` = '$masina' AND `group` = '$grup'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                    else
                                    {
                                        if(mysqli_num_rows($MachineChk) > 0) echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" ONDBLCLICK = "EmployeeEdit();">'.$masina.'</TD>
                                        <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$grup.'</TD>';
                                        else
                                        {
                                            if(!$GrabMachine = $connect -> query("SELECT `machine` FROM `sectors.machines.groups` WHERE `sector` = '$sector' AND `group` = '$grup'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else
                                            {
                                                if(mysqli_num_rows($GrabMachine) > 0)
                                                {
                                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;"><SELECT ONCHANGE = "UpdateEmployeeMachine()"; STYLE = "WIDTH: 100%"><OPTION></OPTION>';
                                                    while($GrabMachineRow = $GrabMachine -> fetch_assoc())
                                                    {
                                                        $Masina = $GrabMachineRow['machine'];
                                                        echo '<OPTION>'.$Masina.'</OPTION>';
                                                    }
                                                    echo '</SELECT></TD>
                                                    <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$grup.'</TD>';
                                                }
                                                else echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$masina.'</TD>
                                                <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$grup.'</TD>';
                                            }
                                        }
                                    }
                                    $masina2 = $row['masina_SEC'];
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$masina2.'</TD>';
                                    $grupSEC = $row['clasa_SEC'];
                                    echo '<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">'.$grupSEC.'</TD>';
                                    $prezent = $row['workerHoursDefault'];
                                    if($prezent != 0) echo '
                                    <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">
                                        <SELECT ID = "AngajatPrezent'.$NrCrt.'" STYLE = "BACKGROUND-COLOR: GREEN" ONCHANGE = "UpdateEmployee(this);">
                                            <OPTION STYLE = "BACKGROUND-COLOR: GREEN">DA</OPTION>
                                            <OPTION STYLE = "BACKGROUND-COLOR: RED">NU</OPTION>
                                        </SELECT>
                                    </TD>';
                                    else echo '
                                    <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">
                                        <SELECT ID = "AngajatPrezent'.$NrCrt.'" STYLE = "BACKGROUND-COLOR: RED" ONCHANGE = "UpdateEmployee(this);">
                                            <OPTION STYLE = "BACKGROUND-COLOR: RED">NU</OPTION>
                                            <OPTION STYLE = "BACKGROUND-COLOR: GREEN">DA</OPTION>
                                        </SELECT>
                                    </TD>';
                                    $motiv = $row['motivINACTIV'];
                                    echo '
                                    <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">
                                        <SELECT ID = "Motivare'.$NrCrt.'" disabled = "true" ONCHANGE = "UpdateEmployee(this);">
                                            <OPTION>'.$motiv.'</OPTION>
                                            <OPTION>NEMOTIVAT</OPTION>
                                            <OPTION>INVOIT</OPTION>
                                            <OPTION>MEDICAL</OPTION>
                                            <OPTION>ODIHNA</OPTION>
                                            <OPTION>INGRIJIRE COPIL</OPTION>
                                        </SELECT>
                                    </TD>';
                                    $durata = $row['daysINACTIVE'];
                                    echo '<TD ID =  "durata'.$NrCrt.'" STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;" ONKEYDOWN = "ImputCheck();">'.$durata.'</TD>';
                                    echo '
                                    <TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 0.8VW;">
                                        <SELECT ID = "Remarca'.$NrCrt.'" disabled = "true" ONCHANGE = "UpdateEmployee(this);">
                                            <OPTION>'.$motiv.'</OPTION>
                                            <OPTION>DEMISIE</OPTION>
                                            <OPTION>PENSIE</OPTION>
                                            <OPTION>DECES</OPTION>
                                            <OPTION>RESTRUCTURARE</OPTION>
                                            <OPTION>DISCIPLINAR</OPTION>
                                        </SELECT>
                                    </TD>
                                    <TR>';
                                    if(!$EmployeeTableInsert = $connect -> query("INSERT INTO `$TmpTableName` VALUES('$marca','$nume','$sector','$incadrare','$masina','$grup','$masina2','$grupSEC','$prezent','$motiv','$durata','$motiv')")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                }
                            }
                        }
                    }
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
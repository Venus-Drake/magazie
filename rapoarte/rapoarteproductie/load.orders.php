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
	if(isset($_GET['nume']) && !empty($_GET['nume'])) $nume = $_GET['nume'];
	else $nume = "Unknown User";
    require_once $_SERVER['DOCUMENT_ROOT'].'/ramira/spout-3.3.0/src/Spout/Autoloader/autoload.php';

	?>

    <DIV STYLE = "WIDTH: 100%; MARGIN: 20px AUTO; BACKGROUND-COLOR: WHITE;">
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 70vh; OVERFLOW: AUTO;">
  		    <IMG SRC = "../logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
        	<B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">RAPORT PRODUCTIE</FONT><BR>Sectia: <SPAN ID = "sectieRaport"><?php echo $seria;?></SPAN></CENTER><BR><BR><BR>
            <?php
                //$readData = file('Report Test.ods');
                use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

                $reader = ReaderEntityFactory::createReaderFromFile('Report Test.ods');

                $reader->open('Report Test.ods');

                foreach ($reader->getSheetIterator() as $sheet) {
                    if($sheet->getIndex() == 0) $rowCount = 0;
                    //echo 'Sheet '.$sheet->getName();
                    foreach ($sheet->getRowIterator() as $row) 
                    {
                        $value = array_slice($row->toArray(),0,23);
                        //echo print_r($value).'<BR><BR>';
                        //$cells = $row->getCells();
                        if($rowCount > 0)
                        {
                            $valLong = count($value);
                            $executedTime = $value[16] - $value[17];
                            $requiredDate = date('Y-m-d',($value[4] - 25569) * 86400);
                            $PJ = $value[0];
                            $PO = $value[8];
                            $machGROUP = $value[13];
                            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                            if(!$searchDB = $connect -> query("SELECT `productionJOB` FROM `production.queue` WHERE `productionJOB` = '$PJ' AND `productionORDER` = '$PO' AND `machineGROUP` = '$machGROUP'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                            else
                            {
                                if(mysqli_num_rows($searchDB) == 0)
                                {
                                    if(!$addTOdb = $connect -> query("INSERT INTO `production.queue` VALUES('','$datetime','$datetime','$value[0]','$value[8]','$value[12]','$value[19]','$value[20]','Released','$value[16]','$executedTime','$value[14]','$requiredDate','$value[13]','','','')")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                    //else echo ' - OK!<BR>';
                                }
                            }
                        }
                        $rowCount++;
                    }
                }

                $reader->close();
            ?>
			
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
	        <FONT STYLE = "FONT-SIZE: 1.2VW"><BR><CENTER>AICI O FI CEVA SCRIS SAU NU...VEDEM...</FONT>
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
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
</BODY>
</HTML>
<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
    <STYLE>
        BODY
        {
		    ANIMATION: ALL NONE;
		    BACKGROUND-COLOR: BLACK; OPACITY: 1;
            BACKGROUND-IMAGE: URL("/ramira/magazie/images/Working.gif");
            BACKGROUND-REPEAT: no-repeat;
            background-position: center;
            COLOR: WHITE;
            FONT-WEIGHT: BOLD;
        }
    </STYLE>
</HEAD>

<BODY ID = "bon_magazie_rs">

	<?php
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';

        $seria = 'Incarcare comenzi '.$datetime;
        require_once($_SERVER['DOCUMENT_ROOT'].'/ramira/PHPExcel-develop/Classes/PHPExcel.php');
        convertXLStoCSV('OrdersReport.xls','OrdersReport.csv');
        
        function convertXLStoCSV($infile,$outfile)
        {
            $fileType = PHPExcel_IOFactory::identify($infile);
            $objReader = PHPExcel_IOFactory::createReader($fileType);
        
            $objReader->setReadDataOnly(true);   
            $objReader->setLoadSheetsOnly('Detail');
            $objPHPExcel = $objReader->load($infile);  
        
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $objWriter->save($outfile);
        }
        //die('DONE');
        require_once $_SERVER['DOCUMENT_ROOT'].'/ramira/spout-3.3.0/src/Spout/Autoloader/autoload.php';
	?>

    <DIV STYLE = "WIDTH: 100%; MARGIN: 20px AUTO; BACKGROUND-COLOR: RGBA(0,0,0,0);">
        <DIV STYLE = "WIDTH: 99%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 99%; OVERFLOW: AUTO;">
        	<B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw"><BR><BR>INCARCARE COMENZI - <?php echo $datetime;?></FONT></SPAN></CENTER><BR><BR><BR>
            <DIV ID = "loadingTEXT" STYLE = "WIDTH: 100%; MARGIN-TOP: 20%; FONT-SIZE: 2.5vw; FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER;"></DIV>
            <?php
                //$readData = file('Report Test.ods');
                use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

                $reader = ReaderEntityFactory::createReaderFromFile('OrdersReport.csv');

                $reader->open('OrdersReport.csv');

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
                            if(!$searchDB = $connect -> query("SELECT `productionJOB`, `piecesDONE`, `operationSTATUS`, `executedTIME`, `importance` FROM `production.queue` WHERE `productionJOB` = '$PJ' AND `productionORDER` = '$PO' AND `POoperation` = '$value[12]' AND `machineGROUP` = '$machGROUP'")) 
                            {
                                echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                mysqli_close($connect);
                            }
                            else
                            {
                                if(mysqli_num_rows($searchDB) == 0)
                                {
                                    if(!$addTOdb = $connect -> query("INSERT INTO `production.queue` VALUES('','$datetime','$datetime','$value[0]','$value[8]','$value[12]','$value[19]','$value[20]','Released','$value[16]','$executedTime','$value[14]','$requiredDate','$value[13]','','','')")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                    else echo '<SCRIPT>LoadOrdersText("Inserted new Production Job: '.$PJ.' (PO: '.$PO.') for '.$machGROUP.'");</SCRIPT>';
                                }
                                else
                                {
                                    $DbRow = $searchDB -> fetch_assoc();
                                    $doneParts = $DbRow['piecesDONE'];
                                    $status = $DbRow['operationSTATUS'];
                                    $doneTime = $DbRow['executedTIME'];
                                    $importance = $DbRow['importance'];
                                    if($doneParts != $value[20] || $status != 'Released' || $doneTime != $executedTime || $importance != $value[14])
                                    {
                                        if($doneParts < $value[20]) $doneParts = $value[20];
                                        if($doneTime < $executedTime) $doneTime = $executedTime;
                                        if($importance != $value[14]) $importance = $value[14];
                                        if(!$UpdateOrder = $connect -> query("UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `piecesDONE` = '$doneParts', `operationSTATUS` = '$status', `executedTIME` = '$doneTime', `importance` = '$importance' WHERE `productionJOB` = '$PJ' AND `productionORDER` = '$PO' AND `POoperation` = '$value[12]' AND `machineGROUP` = '$machGROUP'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                        else echo '<SCRIPT>LoadOrdersText("Updated Production Job: '.$PJ.' (PO: '.$PO.') for '.$machGROUP.'");</SCRIPT>';
                                    }
                                }
                            }
                        }
                        $rowCount++;
                        echo '<SCRIPT>LoadOrdersText("Loaded '.$rowCount.' lines");</SCRIPT>';
                    }
                }
                echo '<SCRIPT>LoadOrdersText("Done loading '.$rowCount.' lines");</SCRIPT>';
                $reader->close();
            ?>
			
        </DIV>
		
    </DIV>
    <SCRIPT src="/ramira/magazie/rapoarte/rapoarteproductie/scripts.js"></SCRIPT>
</BODY>
</HTML>
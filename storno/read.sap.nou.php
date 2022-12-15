<?php

    $tableROWtmp = $tableROW;
	$nrCRT = $readrow['nr.crt'];
    $endLOAN = $readrow['end.loan'];
    $readEND = date('d M Y',strtotime($endLOAN));
    $readMOTIV = $readrow['motiv'];
   	$readSAPCODE = $readrow['cod.SAP'];
   	$readPRODUCT = $readrow['produs'];
   	$readFURNIZOR = $readrow['furnizor'];
   	$readUZURA = $readrow['uzura'];
   	$readPRICE = $readrow['valoare'];
   	//$readSTOCK = $readrow['stoc'];
   	$readAMOUNT = $readrow['cantitate'];
   	$readUM = $readrow['unit'];
   	$readObs = $readrow['observatii'];
   	$readVAL = $readrow['val.prod'];
   	//$readVALBON = $readVALBON + $readVAL;
   	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.echo.php';

?>
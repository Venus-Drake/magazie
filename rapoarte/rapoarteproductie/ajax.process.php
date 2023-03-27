<?php
    if(isset($_POST['managerREQ']) && !empty($_POST['managerREQ']))
    {
        $request = $_POST['managerREQ'];
        if($request == 'giveSECTORS')
        {
            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
            if(!$que = $connect -> query("SELECT `sectie` FROM `pworker` GROUP BY `sectie`")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
            else
            {
                if(mysqli_num_rows($que) > 0)
                {
                    echo 'OK';
                    while($row = $que -> fetch_assoc())
                    {
                        $sectie = $row['sectie'];
                        echo '^'.$sectie;
                    }
                }
                else echo 'No row found.';
            }
        }
        else echo 'Whaaa?....';
    }
    else if(isset($_POST['alarm']) && !empty($_POST['alarm']))
    {
        $alarm = $_POST['alarm'];
        if($alarm == 'getEmployees')
        {
            if(isset($_POST['sector']) && !empty($_POST['sector']))
            {
                $sector = $_POST['sector'];
                if(isset($_POST['machineGroups']) && !empty($_POST['machineGroups']))
                {
                    $groups = explode(',',$_POST['machineGroups']);
                    $extraQuery = '';
                    $myQuery = "SELECT `WORKER_name`, `masina` FROM `pworker` WHERE `sectie` = '$sector' AND `workerACTIVE` = 1";
                    for($i = 0; $i < count($groups); $i++)
                    {
                        if($i == 0)
                        {
                            $myQuery = $myQuery." AND (`clasa_MASINA` = '".$groups[$i]."'";
                            if(count($groups) == 2) $myQuery = $myQuery.")";
                        }
                        else if($i < (count($groups) - 1)) 
                        {
                            $myQuery = $myQuery." || `clasa_MASINA` = '".$groups[$i]."'";
                            if(count($groups) == $i + 2) $myQuery = $myQuery.")";
                        }
                    }
                    $myQuery = $myQuery." ORDER BY `clasa_MASINA`, `masina`, `WORKER_Name`";
                    //echo $myQuery;
                }
            }
            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
            if(!$que = $connect -> query($myQuery)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
            else
            {
                if(mysqli_num_rows($que) > 0)
                {
                    echo 'OK';
                    while($row = $que -> fetch_assoc())
                    {
                        $employee = $row['WORKER_name'];
                        $machine = $row['masina'];
                        echo ','.$employee.','.$machine;
                    }
                }
            }
        }
    }
    else if(isset($_POST['userNAME']) && !empty($_POST['userNAME']))
    {
        $myuserNAME = $_POST['userNAME'];
        //echo 'Got the username: '.$myuserNAME;
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$que = $connect -> query("SELECT `sector` FROM `utilizatori` WHERE `username` = '$myuserNAME' AND `nivel_ACCES` = 'MANAPROD' OR `nivel_ACCES` = 'ADMIN' OR `nivel_ACCES` = 'DEVELOPER'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
        else
        {
            if(mysqli_num_rows($que) > 0)
            {
                $row = $que -> fetch_assoc();
                $sector = $row['sector'];
                if(!$sectorchk = $connect -> query("SELECT * FROM `production.buttons.assign` WHERE `sector` LIKE '$sector'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                else
                {
                    if(mysqli_num_rows($sectorchk) > 0)
                    {
                        echo 'OK,'.$sector;
                        $sectorrow = $sectorchk -> fetch_assoc();
                        $button1 = $sectorrow['button1'];
                        $button2 = $sectorrow['button2'];
                        $button3 = $sectorrow['button3'];
                        $button4 = $sectorrow['button4'];
                        $button5 = $sectorrow['button5'];
                        $button6 = $sectorrow['button6'];
                        echo ','.$button1.','.$button2.','.$button3.','.$button4.','.$button5.','.$button6;
                    }
                    //else{echo 'OK,no access';}
                    else{echo __LINE__.'. OK,no access,'.$sector;}
                }
            }
            else{echo 'OK,no access';}
        }
    }
    else if(isset($_POST['mysector']) && !empty($_POST['mysector']))
    {
        $mysector = $_POST['mysector'];
        if(isset($_POST['request']) && !empty($_POST['request']))
        {
            $request = $_POST['request'];
            if($request == 'updateORDERS' && $mysector == 'ERP')
            {
                require_once $_SERVER['DOCUMENT_ROOT'].'/ramira/spout-3.3.0/src/Spout/Autoloader/autoload.php';
                
                use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

                $reader = ReaderEntityFactory::createReaderFromFile('Report Test.ods');

                $reader->open('Report Test.ods');

                foreach ($reader->getSheetIterator() as $sheet) 
                {
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

                $reader->close('OK^update done');
            }
            echo '^Requested '.$request.' for '.$mysector;
        }
    }
    else if(isset($_POST['myUSERsector']) && !empty($_POST['myUSERsector']))
    {
        $sector = $_POST['myUSERsector'];
        if(isset($_POST['request']) && !empty($_POST['request']))
        {
            $request = $_POST['request'];
            if($request == 'myMACHINESgroups')
            {
                //echo 'Looking for the machine groups related to sector:'.$sector.'\n';
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                if(!$que = $connect -> query("SELECT `group` FROM `sectors.machines.groups` WHERE `sector` LIKE '$sector' GROUP BY `group`")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                else
                {
                    echo 'OK';
                    if(mysqli_num_rows($que) > 0)
                    {
                        while($row = $que -> fetch_assoc())
                        {
                            $group = $row['group'];
                            echo '^'.$group;
                        }
                    }
                }
            }
        }
    }
    else echo '???';
?>
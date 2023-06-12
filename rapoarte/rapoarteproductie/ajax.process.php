<?php
    date_default_timezone_set('Europe/Bucharest');
    $datetime = date('Y-m-d H:i:s',time());
    $Time = time();

    if(isset($_POST['managerREQ']) && !empty($_POST['managerREQ']))
    {
        $request = $_POST['managerREQ'];
        if($request == 'giveSECTORS')
        {
            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
            if(!$que = $connect -> query("SELECT `sector` FROM `sectors.machines.groups` GROUP BY `sector`")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
            else
            {
                if(mysqli_num_rows($que) > 0)
                {
                    echo 'OK';
                    while($row = $que -> fetch_assoc())
                    {
                        $sectie = $row['sector'];
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
        if($alarm == 'GrabSectors')
        {
            if(isset($_POST['exclude'])) $ExcludeData = $_POST['exclude'];
            else $ExcludeData = '';
            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
            if(!$Query_Sectors = $connect -> query("SELECT `sector` FROM `nomenclator.functii` WHERE `sector` != '$ExcludeData' GROUP BY `sector`")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
            else
            {
                if(mysqli_num_rows($Query_Sectors) > 0)
                {
                    echo 'OK';
                    while($Sectors_Row = $Query_Sectors -> fetch_assoc())
                    {
                        $Sector = $Sectors_Row['sector'];
                        echo '^'.$Sector;
                    }
                }
            }
        }
        else if($alarm == 'MachineChange')
        {
            if(isset($_POST['employee']) && !empty($_POST['employee']))
            {
                $employee = $_POST['employee'];
                if(isset($_POST['oldMachine']))
                {
                    $oldMachine = $_POST['oldMachine'];
                    if(isset($_POST['newMachine']) && !empty($_POST['newMachine'])) $newMachine = $_POST['newMachine'];
                    else die(__LINE__.'. No new machine set!');
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$que = $connect -> query("SELECT `workerHoursDefault` FROM `pworker` WHERE `WORKER_Name` = '$employee'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        if(mysqli_num_rows($que) > 0)
                        {
                            $row = $que -> fetch_assoc();
                            $WorkerHours = $row['workerHoursDefault']*60;
                            if($oldMachine != '')
                            {
                                if(!$RemLoad = $connect -> query("UPDATE `sectors.machines.groups` SET `TotalLOAD` = (`TotalLOAD` - $WorkerHours) WHERE `machine` = '$oldMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                else
                                {
                                    if(!$GetNewLoad = $connect -> query("SELECT `TotalLOAD` FROM `sectors.machines.groups` WHERE `machine` = '$oldMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                    else
                                    {
                                        $machineRow = $GetNewLoad -> fetch_assoc();
                                        if($machineRow['TotalLOAD'] == 0)
                                        {
                                            if(!$UpdateMachine = $connect -> query("UPDATE `sectors.machines.groups` SET `MachineACTIVE` = '0', `TimeLOADED` = '0' WHERE `machine` = '$oldMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else
                                            {
                                                if(!$UpdateOrdersFromMachine = $connect -> query("UPDATE `production.queue` SET `sector` = '', `machine` = '', `employee` = '' WHERE `machine` = '$oldMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            }
                                        }
                                        if(!$UpdateNewMachine = $connect -> query("UPDATE `sectors.machines.groups` SET `MachineACTIVE` = '1', `TotalLOAD` = (`TotalLOAD` + $WorkerHours) WHERE `machine` = '$newMachine'"))die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else 
                                        {
                                            if(!$GrabNewGroup = $connect -> query("SELECT `group` FROM `sectors.machines.groups` WHERE `machine` = '$newMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else
                                            {
                                                if(mysqli_num_rows($GrabNewGroup) > 0)
                                                {
                                                    $NewGroupRow = $GrabNewGroup -> fetch_assoc();
                                                    $NewGroup = $NewGroupRow['group'];
                                                }
                                            }
                                            if(!$UpdateEmployeeMachine = $connect -> query("UPDATE `pworker` SET `masina` = '$newMachine', `clasa_MASINA` = '$NewGroup' WHERE `WORKER_Name` = '$employee'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else echo 'OK';
                                        }
                                    }
                                }
                            }
                        }
                        else die(__LINE__.'. Worker not found: '.$employee);
                    }
                }
                else die(__LINE__.'. No machine set at all!');
            }
            else die(__LINE__.'. No employee set!');
        }
        else if($alarm == 'MachineOptions')
        {
            if(isset($_POST['sector']) && !empty($_POST['sector']))
            {
                $sector = $_POST['sector'];
                if(isset($_POST['exception']))
                {
                    $exception = $_POST['exception'];
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$que = $connect -> query("SELECT `machine` FROM `sectors.machines.groups` WHERE `machine` != '$exception' AND `sector` = '$sector'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        echo 'OK';
                        if(mysqli_num_rows($que) > 0)
                        {
                            while($row = $que -> fetch_assoc())
                            {
                                $machine = $row['machine'];
                                echo '^'.$machine;
                            }
                        }
                    }
                }
            }
            else die(__LINE__.'. No sector set!');
        }
        else if($alarm == 'SortEmployees')
        {
            if(isset($_POST['user']) && !empty($_POST['user']))
            {
                if(isset($_POST['sorter']) && !empty($_POST['sorter']))
                {
                    $sorter = $_POST['sorter'];
                    $UserFullName = explode(' ',$_POST['user']);
                    $UserName = trim($UserFullName[0]);
                    $SurName = trim(str_replace($UserName.' ','',$_POST['user']));
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$UserGrab = $connect -> query("SELECT `username` FROM `utilizatori` WHERE `nume` LIKE '$UserName' AND `prenume` LIKE '$SurName'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        if(mysqli_num_rows($UserGrab) > 0)
                        {
                            $UserRow = $UserGrab -> fetch_assoc();
                            $UserEmployeesTable = 'employees_'.$UserRow['username'];
                            $TableQuery = "SELECT * FROM `$UserEmployeesTable` ORDER BY $sorter";
                            if(!$que = $connect -> query($TableQuery)) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($que) > 0)
                                {
                                    echo 'OK';
                                    while($row = $que -> fetch_assoc())
                                    {
                                        $Employee_ID = $row['WORKER_ID'];
                                        $Employee_Name = $row['WORKER_Name'];
                                        $Employee_Sector = $row['sectie'];
                                        $Employee_Job = $row['incadrare'];
                                        $Employee_Machine = $row['masina'];
                                        $Employee_MachineGroup = $row['clasa_MASINA'];
                                        $Employee_Sec_Machine = $row['masina_SEC'];
                                        $Employee_Sec_MachineGroup = $row['clasa_SEC'];
                                        $Employee_Presence = $row['workerACTIVE'];
                                        $Employee_Reason = $row['motivINACTIV'];
                                        $Employee_Absence_Time = $row['daysINACTIVE'];
                                        $Employee_Remark = $row['remarcaINACTIV'];
                                        echo '^'.$Employee_ID.'^'.$Employee_Name.'^'.$Employee_Sector.'^'.$Employee_Job.'^'.$Employee_Machine.'^'.$Employee_MachineGroup.'^'.$Employee_Sec_Machine.'^'.$Employee_Sec_MachineGroup.'^'.$Employee_Presence.'^'.$Employee_Reason.'^'.$Employee_Absence_Time.'^'.$Employee_Remark;
                                    }
                                }
                            }
                        }
                    }
                }
                else die(__LINE__.'. No sorting set!');
            }
            else die(__LINE__.'. No user set!');
        }
        else if($alarm == 'SortOrders')
        {
            if(isset($_POST['user']) && !empty($_POST['user']))
            {
                if(isset($_POST['sorter']) && !empty($_POST['sorter']))
                {
                    $sorter = $_POST['sorter'];
                    $UserFullName = explode(' ',$_POST['user']);
                    $UserName = trim($UserFullName[0]);
                    $SurName = trim(str_replace($UserName.' ','',$_POST['user']));
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$UserGrab = $connect -> query("SELECT `username` FROM `utilizatori` WHERE `nume` LIKE '$UserName' AND `prenume` LIKE '$SurName'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        if(mysqli_num_rows($UserGrab) > 0)
                        {
                            $UserRow = $UserGrab -> fetch_assoc();
                            $UserOrdersTable = 'orders_'.$UserRow['username'];
                            $TableQuery = "SELECT * FROM `$UserOrdersTable` ORDER BY $sorter";
                            if(!$que = $connect -> query($TableQuery)) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($que) > 0)
                                {
                                    echo 'OK';
                                    while($row = $que -> fetch_assoc())
                                    {
                                        $importance = $row['importance'];
                                        $PJ = $row['productionJob'];
                                        $PO = $row['productionOrder'];
                                        $OpNr = $row['operation'];
                                        $pieces = $row['pieces'];
                                        $piecesDone = $row['piecesDone'];
                                        $sector = $row['sector'];
                                        $NormTime = $row['normTime'];
                                        $DoneTime = $row['doneTime'];
                                        $group = $row['group'];
                                        $machine = $row['machine'];
                                        $employee = $row['employee'];
                                        echo '^'.$importance.'^'.$PJ.'^'.$PO.'^'.$OpNr.'^'.$pieces.'^'.$piecesDone.'^'.$sector.'^'.$NormTime.'^'.$DoneTime.'^'.$group.'^'.$machine.'^'.$employee;
                                    }
                                }
                            }
                        }
                    }
                }
                else die(__LINE__.'. No sorting set!');
            }
            else die(__LINE__.'. No user set!');
        }
        if($alarm == 'AtribuieComandapeMasina')
        {
            if(isset($_POST['sector']) && !empty($_POST['sector']))
            {
                $sector = $_POST['sector'];
                if(isset($_POST['masina']) && !empty($_POST['masina']))
                {
                    $masina = $_POST['masina'];
                    if(isset($_POST['comanda']) && !empty($_POST['comanda']))
                    {
                        $comanda = explode('.',$_POST['comanda']);
                        $PO = $comanda[0];
                        $OpNr = $comanda[1];
                        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                        if(!$SearchPreviousOperations = $connect -> query("SELECT `lastUPDATED`, `POoperation`, `executionTIME`, `machineGROUP`, `sector`, `machine`, `employee` FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` < '$OpNr' ORDER BY `POoperation` ASC")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                        else
                        {
                            if(mysqli_num_rows($SearchPreviousOperations) > 0)
                            {
                                while($SearchPrevOpRow = $SearchPreviousOperations -> fetch_assoc())
                                {
                                    $PrevOpNr = $SearchPrevOpRow['POoperation'];
                                    $PrevOpNormTime = $SearchPrevOpRow['executionTIME'];
                                    $PrevOpGroup = $SearchPrevOpRow['machineGROUP'];
                                    $PrevOpSector = $SearchPrevOpRow['sector'];
                                    $PrevOpMachine = $SearchPrevOpRow['machine'];
                                    $PrevOpExeTime = (time() - strtotime($SearchPrevOpRow['lastUPDATED'])) / 60;
                                    if($PrevOpSector == '')
                                    {
                                        if(!$SearchAttr = $connect -> query("SELECT `sector`, `machine` FROM `sectors.machines.groups` WHERE `group` = '$PrevOpGroup' ORDER BY `MachineACTIVE` DESC")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else
                                        {
                                            if(mysqli_num_rows($SearchAttr) > 0)
                                            {
                                                $SearchAttrRow = $SearchAttr -> fetch_assoc();
                                                $AttrSector = $SearchAttrRow['sector'];
                                                $AttrMachine = $SearchAttrRow['machine'];
                                                if(!$UpdPrevOperations = $connect -> query(
                                                    "UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `piecesDONE` = `pieces`, `operationSTATUS` = 'Closed', `executedTIME` = '$PrevOpExeTime', `sector` = '$AttrSector', `machine` = '$AttrMachine' WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr';
                                                    ")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                else 
                                                {
                                                    if(!$CopyPrevOperations = $connect -> query("INSERT INTO `production.archive` SELECT * FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                    else 
                                                    {
                                                        if(!$RemovePrevOperations = $connect -> query("DELETE FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if(!$GetMachineTime = $connect -> query("SELECT `TimeLOADED` FROM `sectors.machines.groups` WHERE `machine` = '$PrevOpMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else
                                        {
                                            if(mysqli_num_rows($GetMachineTime) > 0)
                                            {
                                                $RowMachineTime = $GetMachineTime -> fetch_assoc();
                                                $MachineLoad = $RowMachineTime['TimeLOADED'] - $PrevOpNormTime;
                                                if($MachineLoad < 0) $MachineLoad = 0;
                                                if(!$UpdPrevOperations = $connect -> query(
                                                    "UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `piecesDONE` = `pieces`, `operationSTATUS` = 'Closed', `executedTIME` = '$PrevOpExeTime' WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr';
                                                    ")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                else
                                                {
                                                    if(!$CopyPrevOperations = $connect -> query("INSERT INTO `production.archive` SELECT * FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                    else
                                                    {
                                                        if(!$RemovePrevOperations = $connect -> query("DELETE FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //die(__LINE__.'. Done closing previous operations');
                        if(!$que = $connect -> query("SELECT `executionTIME`, `machineGROUP`, `sector`, `machine`, `employee` FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$OpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                        else
                        {
                            if(mysqli_num_rows($que) > 0)
                            {
                                $row = $que -> fetch_assoc();
                                $NormTime = $row['executionTIME'];
                                $OPgroup = $row['machineGROUP'];
                                $POsector = $row['sector'];
                                if($POsector != '') die('NO^Comanda este deja atribuita!');
                                if(!$MachineChk = $connect -> query("SELECT `group`, `totalLOAD`, `timeLOADED` FROM `sectors.machines.groups` WHERE `machine` = '$masina' AND `sector` = '$sector'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                else
                                {
                                    if(mysqli_num_rows($MachineChk) > 0)
                                    {
                                        $MachRow = $MachineChk -> fetch_assoc();
                                        if($MachRow['group'] != $OPgroup) die('NO^Operatia nu poate fi executata pe aceasta masina!');
                                        $TotalLoad = $MachRow['totalLOAD'];
                                        $TimeLoaded = $MachRow['timeLOADED'];
                                        if($TimeLoaded + $NormTime <= $TotalLoad)
                                        {
                                            if(!$EmployeeChk = $connect -> query("SELECT `WORKER_Name` FROM `pworker` WHERE (`masina` = '$masina' OR `masina_SEC` = '$masina') AND `workerHoursDefault` > '0'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else
                                            {
                                                if(mysqli_num_rows($EmployeeChk) > 0)
                                                {
                                                    if(mysqli_num_rows($EmployeeChk) == 1) 
                                                    {
                                                        $EmployeeRow = $EmployeeChk -> fetch_assoc();
                                                        $Employee = $EmployeeRow['WORKER_Name'];
                                                    }
                                                    else $Employee = '';
                                                    $MachineLoad = $TimeLoaded + $NormTime;
                                                    if(!$UpdateMachine = $connect -> query("UPDATE `sectors.machines.groups` SET `timeLOADED` = '$MachineLoad' WHERE `machine` = '$masina'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                    else
                                                    {
                                                        if(!$UpdateOrder = $connect -> query("UPDATE `production.queue` SET `sector` = '$sector', `machine` = '$masina', `employee` = '$Employee' WHERE `productionORDER` = '$PO' AND `POoperation` = '$OpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                        else echo 'OK';
                                                    }
                                                }
                                                else die('NO^Nu avem angajati activi pe aceasta masina. Ar trebui sa trecem masina pe inactiv!');
                                            }
                                        }
                                        else die("NO^Comanda depaseste incarcarea maxima pe utilajul ".$masina.'. Va rog, alegeti alta masina!');
                                    }
                                }
                            }
                            else die('NO^Comanda nu este inregistrata in baza de date!');
                        }
                    }
                    else die('NO^Order not set!');
                }
                else die('NO^Machine not set!');
            }
        }
        else if($alarm == 'AttribuireComanda')
        {
            if(isset($_POST['PJ']) && !empty($_POST['PJ']))
            {
                $PJ = $_POST['PJ'];
                if(isset($_POST['PO']) && !empty($_POST['PO']))
                {
                    $PO = $_POST['PO'];
                    if(isset($_POST['operation']) && !empty($_POST['operation']))
                    {
                        $operation = $_POST['operation'];
                        if(isset($_POST['myuser']) && !empty($_POST['myuser']))
                        {
                            $UserFullName = explode(' ',$_POST['myuser']);
                            $UserName = trim($UserFullName[0]);
                            $SurName = trim(str_replace($UserName.' ','',$_POST['myuser']));
                            require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                            if(!$UserGrab = $connect -> query("SELECT `username` FROM `utilizatori` WHERE `nume` LIKE '$UserName' AND `prenume` LIKE '$SurName'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($UserGrab) > 0)
                                {
                                    $UserRow = $UserGrab -> fetch_assoc();
                                    $UserOrdersTable = 'orders_'.$UserRow['username'];
                                }
                            }
                        }
                        else die('User name NOT set!');
                        if(!$SearchPreviousOperations = $connect -> query("SELECT `lastUPDATED`, `POoperation`, `executionTIME`, `machineGROUP`, `sector`, `machine`, `employee` FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` < '$operation' ORDER BY `POoperation` ASC")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                        else
                        {
                            if(mysqli_num_rows($SearchPreviousOperations) > 0)
                            {
                                while($SearchPrevOpRow = $SearchPreviousOperations -> fetch_assoc())
                                {
                                    $PrevOpNr = $SearchPrevOpRow['POoperation'];
                                    $PrevOpNormTime = $SearchPrevOpRow['executionTIME'];
                                    $PrevOpGroup = $SearchPrevOpRow['machineGROUP'];
                                    $PrevOpSector = $SearchPrevOpRow['sector'];
                                    $PrevOpMachine = $SearchPrevOpRow['machine'];
                                    $PrevOpExeTime = (time() - strtotime($SearchPrevOpRow['lastUPDATED'])) / 60;
                                    if($PrevOpSector == '')
                                    {
                                        if(!$SearchAttr = $connect -> query("SELECT `sector`, `machine` FROM `sectors.machines.groups` WHERE `group` = '$PrevOpGroup' ORDER BY `MachineACTIVE` DESC")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else
                                        {
                                            if(mysqli_num_rows($SearchAttr) > 0)
                                            {
                                                $SearchAttrRow = $SearchAttr -> fetch_assoc();
                                                $AttrSector = $SearchAttrRow['sector'];
                                                $AttrMachine = $SearchAttrRow['machine'];
                                                if(!$UpdPrevOperations = $connect -> query(
                                                    "UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `piecesDONE` = `pieces`, `operationSTATUS` = 'Closed', `executedTIME` = '$PrevOpExeTime', `sector` = '$AttrSector', `machine` = '$AttrMachine' WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr';
                                                    ")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            }
                                            if(!$CopyPrevOperations = $connect -> query("INSERT INTO `production.archive` SELECT * FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else 
                                            {
                                                if(!$RemovePrevOperations = $connect -> query("DELETE FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if(!$GetMachineTime = $connect -> query("SELECT `TimeLOADED` FROM `sectors.machines.groups` WHERE `machine` = '$PrevOpMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else
                                        {
                                            if(mysqli_num_rows($GetMachineTime) > 0)
                                            {
                                                $RowMachineTime = $GetMachineTime -> fetch_assoc();
                                                $MachineLoad = $RowMachineTime['TimeLOADED'] - $PrevOpNormTime;
                                                if($MachineLoad < 0) $MachineLoad = 0;
                                                if(!$UpdateMachineLoad = $connect -> query("UPDATE `sectors.machines.groups` SET `TimeLOADED` = '$MachineLoad' WHERE `machine` = '$PrevOpMachine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                else
                                                {
                                                    if(!$UpdPrevOperations = $connect -> query("UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `piecesDONE` = `pieces`, `operationSTATUS` = 'Closed', `executedTIME` = '$PrevOpExeTime' WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr';
                                                    ")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                                }
                                            }
                                            if(!$CopyPrevOperations = $connect -> query("INSERT INTO `production.archive` SELECT * FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else
                                            {
                                                if(!$RemovePrevOperations = $connect -> query("DELETE FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$PrevOpNr'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($_POST['sector']) && !empty($_POST['sector']))
                            {
                                $sector = $_POST['sector'];
                                if(isset($_POST['masina']) && !empty($_POST['masina']))
                                {
                                    $masina = $_POST['masina'];
                                    if(isset($_POST['employee']) && !empty($_POST['employee'])) $employee = $_POST['employee'];
                                    else $employee = '';
                                    if(!$Update_Production = $connect -> query("UPDATE `production.queue` SET `lastUPDATED` = '$datetime', `sector` = '$sector', `machine` = '$masina', `employee` = '$employee' WHERE `productionJOB` = '$PJ' AND `productionORDER` = '$PO' AND `POoperation` = '$operation'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                    else 
                                    {
                                        if(!$Update_UserTable = $connect -> query("UPDATE `$UserOrdersTable` SET `sector` = '$sector', `machine` = '$masina', `employee` = '$employee' WHERE `productionJob` = '$PJ' AND `productionOrder` = '$PO' AND `operation` = '$operation'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else
                                        {
                                            if(!$LoadTimeOnMachine = $connect -> query("UPDATE `sectors.machines.groups` SET `TimeLOADED` = (`TimeLOADED` + (SELECT `executionTIME` FROM `production.queue` WHERE `productionORDER` = '$PO' AND `POoperation` = '$operation')) WHERE `machine` = '$masina'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            else echo 'OK';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else if($alarm == 'GiveSectorMachines')
        {
            if(isset($_POST['sector']) && !empty($_POST['sector']))
            {
                $sector = $_POST['sector'];
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                if(!$que = $connect -> query("SELECT `machine`, `group` FROM `sectors.machines.groups` WHERE `sector` = '$sector' AND `MachineACTIVE` = '1'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                else
                {
                    echo 'OK';
                    if(mysqli_num_rows($que) > 0)
                    {
                        while($row = $que -> fetch_assoc())
                        {
                            $machine = $row['machine'];
                            $group = $row['group'];
                            if(!$queue = $connect -> query("SELECT `executionTIME` FROM `production.queue` WHERE `machineGROUP` = '$group' AND `operationSTATUS` = 'Released' GROUP BY `machineGROUP`")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            {
                                if(mysqli_num_rows($queue) > 0) echo '^'.$machine;
                            }
                        }
                    }
                }
            }
        }
        else if($alarm == 'UpdateEmployeeMachine')
        {
            if(isset($_POST['employee']) && !empty($_POST['employee']))
            {
                $employee = $_POST['employee'];
                if(isset($_POST['newmachine']) && !empty($_POST['newmachine']))
                {
                    $machine = $_POST['newmachine'];
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$EmplChk = $connect -> query("SELECT `workerHoursDefault` FROM `pworker` WHERE `WORKER_Name` = '$employee'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        if(mysqli_num_rows($EmplChk) > 0)
                        {
                            $EmplRow = $EmplChk -> fetch_assoc();
                            $WorkerHours = $EmplRow['workerHoursDefault'];
                            if(!$que = $connect -> query("UPDATE `pworker` SET `masina` = '$machine' WHERE `WORKER_Name` = '$employee'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                            else
                            { 
                                if(!$MachineChk = $connect -> query("SELECT `TotalLOAD` FROM `sectors.machines.groups` WHERE `machine` = '$machine'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                else
                                {
                                    if(mysqli_num_rows($MachineChk) > 0)
                                    {
                                        $MachChkRow = $MachineChk -> fetch_assoc();
                                        $MachLoad = $MachChkRow['TotalLOAD'] + $WorkerHours;
                                        if(!$MachUpd = $connect -> query("UPDATE `sectors.machines.groups` SET `TotalLOAD` = '$MachLoad' WHERE `machine` = '$machine'"))  die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                        else echo 'OK';
                                    }
                                }
                            }
                        }
                        else echo 'Worker '.$employee.' not found!';
                    }
                }
                else echo 'No machine set';
            }
            else echo 'No employee set';
        }
        else if($alarm == 'AngajatPeLeave')
        {
            if(isset($_POST['numeAngajat']) && !empty($_POST['numeAngajat']))
            {
                $numeAngajat = $_POST['numeAngajat'];
                if(isset($_POST['Reason']) && !empty($_POST['Reason']))
                {
                    $reason = $_POST['Reason'];
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$que = $connect -> query("UPDATE `pworker` SET `workerACTIVE` = '0', `worker_BARCODE` = '0', `workerHoursDefault` = '0', `motivINACTIV` = '$reason' WHERE `WORKER_Name` = '$numeAngajat'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else echo 'OK';
                }
            }
        }
        else if($alarm == 'AtribuireAngajat')
        {
            if(isset($_POST['masina']) && !empty($_POST['masina']))
            {
                $masina = $_POST['masina'];
                if(isset($_POST['sector']) && !empty($_POST['sector']))
                {
                    $sector = $_POST['sector'];
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$que = $connect -> query("SELECT `WORKER_Name` FROM `pworker` WHERE `workerACTIVE` = '1' AND `sectie` = '$sector' AND (`masina` = '$masina' OR `masina_SEC` = '$masina') AND `workerHoursDefault` > 0")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                    else
                    {
                        echo 'OK';
                        if(mysqli_num_rows($que) > 0)
                        {
                            $employee = '';
                            while($row = $que -> fetch_assoc())
                            {
                                if($row['WORKER_Name'] != $employee)
                                {
                                    $employee = $row['WORKER_Name'];
                                    echo '^'.$employee;
                                }
                            }
                        }
                    }
                }
            }
        }
        else if($alarm == 'AtribuireMasina')
        {
            if(isset($_POST['grupMasina']) && !empty($_POST['grupMasina']))
            {
                $grup = $_POST['grupMasina'];
                if(isset($_POST['sector']) && !empty($_POST['sector']))
                {
                    $sector = $_POST['sector'];
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$que = $connect -> query("SELECT `machine`, `TotalLOAD`, `TimeLOADED` FROM `sectors.machines.groups` WHERE `group` = '$grup' AND `sector` = '$sector'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                    else
                    {
                        echo 'OK';
                        if(mysqli_num_rows($que) > 0)
                        {
                            $machine = '';
                            while($row = $que -> fetch_assoc())
                            {
                                if($row['machine'] != $machine)
                                {
                                    $machine = $row['machine'];
                                    $Load = $row['TotalLOAD'];
                                    $Loaded = $row['TimeLOADED'];
                                    if(($Loaded*100)/$Load <= 75) $color = 'green';
                                    else if(($Loaded*100)/$Load > 75 && ($Loaded*100)/$Load <= 100) $color = 'yellow';
                                    else $color = 'red';
                                    echo '^'.$machine.'^'.$color;
                                }
                            }
                        }
                    }
                }
            }
        }
        else if($alarm == 'AtribuireSector')
        {
            if(isset($_POST['grupMasina']) && !empty($_POST['grupMasina']))
            {
                $grup = $_POST['grupMasina'];
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                if(!$que = $connect -> query("SELECT `sector` FROM `sectors.machines.groups` WHERE `group` = '$grup'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                else
                {
                    echo 'OK';
                    if(mysqli_num_rows($que) > 0)
                    {
                        $sector = '';
                        while($row = $que -> fetch_assoc())
                        {
                            if($row['sector'] != $sector)
                            {
                                $sector = $row['sector'];
                                echo '^'.$sector;
                            }
                        }
                    }
                }
            }
        }
        else if($alarm == 'ordersDisplay')
        {
            //echo __LINE__.'. What is wrong?';
            if(isset($_POST['importance']) && !empty($_POST['importance']))
            {
                //echo __LINE__.'. What is wrong?';
                $ImpArray = explode(',',$_POST['importance']);
                if(isset($_POST['queryuser']) && !empty($_POST['queryuser'])) 
                {
                    $UserFullName = explode(' ',$_POST['queryuser']);
                    $UserName = trim($UserFullName[0]);
                    $SurName = trim(str_replace($UserName.' ','',$_POST['queryuser']));
                    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                    if(!$UserGrab = $connect -> query("SELECT `username` FROM `utilizatori` WHERE `nume` LIKE '$UserName' AND `prenume` LIKE '$SurName'")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                    else
                    {
                        if(mysqli_num_rows($UserGrab) > 0)
                        {
                            $UserRow = $UserGrab -> fetch_assoc();
                            $TmpTableName = 'orders_'.$UserRow['username'];
                            if(!$OrdersTableCreate = $connect -> multi_query("DROP TABLE IF EXISTS `$TmpTableName`;CREATE TABLE `$TmpTableName`(`id` int(11) NOT NULL AUTO_INCREMENT,
                                                                            `importance` float(10,2) NOT NULL,
                                                                            `productionJob` varchar(20) NOT NULL,
                                                                            `productionOrder` int(11) NOT NULL,
                                                                            `operation` int(11) NOT NULL,
                                                                            `pieces` int(11) NOT NULL,
                                                                            `piecesDone` int(11) NOT NULL,
                                                                            `sector` varchar(20) NOT NULL,
                                                                            `normTime` int(11) NOT NULL,
                                                                            `doneTime` int(11) NOT NULL,
                                                                            `group` varchar(10) NOT NULL,
                                                                            `machine` varchar(45) NOT NULL,
                                                                            `employee` text NOT NULL,PRIMARY KEY (`id`))"))  die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                        }
                        else die('User not found^'.$UserName.';'.$SurName.'!');
                    }
                }
                else die('No user set!');
                $queBody = "SELECT * FROM `production.queue` WHERE (";
                $ImpCount = 0;
                for($k = 0; $k < count($ImpArray); $k++)
                {
                    if($ImpArray[$k] == 'Comenzi in intarziere') 
                    {
                        $queBody = $queBody." (`importance` < '-10')";
                        $ImpCount++;
                    }
                    else if($ImpArray[$k] == 'Comenzi foarte urgente') 
                    {
                        if($ImpCount != 0) $queBody = $queBody." OR";
                        $queBody = $queBody." (`importance` >= '-10' AND `importance` < '0') ";
                        $ImpCount++;
                    }
                    else if($ImpArray[$k] == 'Comenzi urgente') 
                    {
                        if($ImpCount != 0) $queBody = $queBody." OR";
                        $queBody = $queBody." (`importance` >= '0' AND `importance` < '10')";
                        $ImpCount++;
                    }
                    else if($ImpArray[$k] == 'Nu foarte urgente') 
                    {
                        if($ImpCount != 0) $queBody = $queBody." OR";
                        $queBody = $queBody." (`importance` >= '10')";
                    }
                }
                if(isset($_POST['sector']) && !empty($_POST['sector']))
                {
                    $sector = $_POST['sector'];
                    $queBody = $queBody.") AND `sector` = '".$sector."' AND (";
                    if(isset($_POST['group']) && !empty($_POST['group']))
                    {
                        $group = explode(',',$_POST['group']);
                        //print_r($group);
                        for($g = 0; $g < count($group); $g++)
                        {
                            if($g > 0) $queBody = $queBody." OR";
                            $queBody = $queBody." `machineGROUP` = '".$group[$g]."'";
                        }
                        $queBody = $queBody.")";
                        if(isset($_POST['machine']) && !empty($_POST['machine']))
                        {
                            $machine = $_POST['machine'];
                            $queBody = $queBody." AND `machine` = '".$machine."'";
                        }
                        if(isset($_POST['angajat']) && !empty($_POST['angajat']))
                        {
                            $angajat = $_POST['angajat'];
                            $queBody = $queBody." AND `employee` = '".$angajat."'";
                        }
                        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
                        //die($queBody);
                        if(!$que = $connect -> query($queBody)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                        else
                        {
                            if(mysqli_num_rows($que) > 0)
                            {
                                echo 'OK';
                                while($row = $que -> fetch_assoc())
                                {
                                    $impo = $row['importance'];
                                    $pj = $row['productionJOB'];
                                    $po = $row['productionORDER'];
                                    $OpNr = $row['POoperation'];
                                    $buc = $row['pieces'];
                                    $bucDone = $row['piecesDONE'];
                                    $sectie = $row['sector'];
                                    $timpNorm = $row['executionTIME'];
                                    $timpDone = $row['executedTIME'];
                                    $grup = $row['machineGROUP'];
                                    $mach = $row['machine'];
                                    $ang = $row['employee'];
                                    //die($queBody);
                                    if(!$InsertUserTable = $connect -> query("INSERT INTO `$TmpTableName` VALUES('','$impo','$pj','$po','$OpNr','$buc','$bucDone','$sectie','$timpNorm','$timpDone','$grup','$mach','$ang')")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                    //else die('My table: '.$TmpTableName);
                                    else echo '^'.$impo.'^'.$pj.'^'.$po.'^'.$OpNr.'^'.$buc.'^'.$bucDone.'^'.$sectie.'^'.$timpNorm.'^'.$timpDone.'^'.$grup.'^'.$mach.'^'.$ang;
                                }
                                $queBody = str_replace("AND `sector` = '".$sector."'","AND `sector` = ''",$queBody);
                                //die($queBody);
                                if(!$que2 = $connect -> query($queBody)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                else 
                                {
                                    if(mysqli_num_rows($que2) > 0)
                                    {
                                        while($row2 = $que2 -> fetch_assoc())
                                        {
                                            $impo = $row2['importance'];
                                            $pj = $row2['productionJOB'];
                                            $po = $row2['productionORDER'];
                                            $OpNr = $row2['POoperation'];
                                            $buc = $row2['pieces'];
                                            $bucDone = $row2['piecesDONE'];
                                            $timpNorm = $row2['executionTIME'];
                                            $timpDone = $row2['executedTIME'];
                                            $sectie = $row2['sector'];
                                            $grup = $row2['machineGROUP'];
                                            $mach = $row2['machine'];
                                            $ang = $row2['employee'];
                                            if(!$InsertUserTable = $connect -> query("INSERT INTO `$TmpTableName` VALUES('','$impo','$pj','$po','$OpNr','$buc','$bucDone','$sectie','$timpNorm','$timpDone','$grup','$mach','$ang')")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            //else die('My table: '.$TmpTableName);
                                            else echo '^'.$impo.'^'.$pj.'^'.$po.'^'.$OpNr.'^'.$buc.'^'.$bucDone.'^'.$sectie.'^'.$timpNorm.'^'.$timpDone.'^'.$grup.'^'.$mach.'^'.$ang;
                                            //echo '^'.$impo.'^'.$pj.'^'.$po.'^'.$OpNr.'^'.$buc.'^'.$bucDone.'^'.$sectie.'^'.$timpNorm.'^'.$timpDone.'^'.$grup.'^'.$mach.'^'.$ang;
                                        }
                                    }
                                    //else echo __LINE__.' No result found for '.$queBody;
                                }
                            }
                            else 
                            { 
                                $queBody = str_replace("AND `sector` = '".$sector."'","",$queBody);
                                if(!$que2 = $connect -> query($queBody)) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                                else 
                                {
                                    if(mysqli_num_rows($que2) > 0)
                                    {
                                        echo 'OK';
                                        while($row2 = $que2 -> fetch_assoc())
                                        {
                                            $impo = $row2['importance'];
                                            $pj = $row2['productionJOB'];
                                            $po = $row2['productionORDER'];
                                            $OpNr = $row2['POoperation'];
                                            $buc = $row2['pieces'];
                                            $bucDone = $row2['piecesDONE'];
                                            $timpNorm = $row2['executionTIME'];
                                            $timpDone = $row2['executedTIME'];
                                            $sectie = $row2['sector'];
                                            $grup = $row2['machineGROUP'];
                                            $mach = $row2['machine'];
                                            $ang = $row2['employee'];
                                            if(!$InsertUserTable = $connect -> query("INSERT INTO `$TmpTableName` VALUES('','$impo','$pj','$po','$OpNr','$buc','$bucDone','$sectie','$timpNorm','$timpDone','$grup','$mach','$ang')")) die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));
                                            //else die('My table: '.$TmpTableName);
                                            else echo '^'.$impo.'^'.$pj.'^'.$po.'^'.$OpNr.'^'.$buc.'^'.$bucDone.'^'.$sectie.'^'.$timpNorm.'^'.$timpDone.'^'.$grup.'^'.$mach.'^'.$ang;
                                            //echo '^'.$impo.'^'.$pj.'^'.$po.'^'.$OpNr.'^'.$buc.'^'.$bucDone.'^'.$sectie.'^'.$timpNorm.'^'.$timpDone.'^'.$grup.'^'.$mach.'^'.$ang;
                                        }
                                    }
                                    else echo 'No result found^ on line '.__LINE__.' for '.$queBody;
                                }
                                //echo __LINE__.' No result found for '.$queBody;
                            }
                        }
                    }
                    else echo 'No group set!';
                }
                else echo 'No sector set!';
            }
            else echo 'No importance set!';
        }
        else if($alarm == 'getEmployees')
        {
            //echo __LINE__.'. What is wrong?';
            if(isset($_POST['sector']) && !empty($_POST['sector']))
            {
                $sector = $_POST['sector'];
                if(isset($_POST['machineGroups']) && !empty($_POST['machineGroups']))
                {
                    $groups = explode(',',$_POST['machineGroups']);
                    $extraQuery = '';
                    $myQuery = "SELECT `WORKER_name`, `masina`, `masina_SEC`, `clasa_SEC` FROM `pworker` WHERE `sectie` = '$sector' AND `workerACTIVE` = 1";
                    for($i = 0; $i < count($groups); $i++)
                    {
                        if($i == 0)
                        {
                            $myQuery = $myQuery." AND (`clasa_MASINA` = '".$groups[$i]."' || `clasa_SEC` = '".$groups[$i]."'";
                            if(count($groups) == 2) $myQuery = $myQuery.")";
                        }
                        else if($i < (count($groups) - 1)) 
                        {
                            $myQuery = $myQuery." || `clasa_MASINA` = '".$groups[$i]."' || `clasa_SEC` = '".$groups[$i]."'";
                            if(count($groups) == $i + 2) $myQuery = $myQuery.")";
                        }
                    }
                    $myQuery = $myQuery." ORDER BY `clasa_MASINA`, `masina`, `WORKER_Name`";
                    //echo $myQuery;
                }
                else die('No machine group set');
            }
            else die('No sector set');
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
                        $clasaSEC = $row['clasa_SEC'];
                        $machine = $row['masina'];
                        $machSEC = $row['masina_SEC'];
                        if(!$QueChk = $connect -> query("SELECT `executionTIME` FROM `production.queue` WHERE `employee` = '$employee'")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
                        else
                        {
                            if(mysqli_num_rows($QueChk) > 0) echo ','.$employee.','.$machine;
                        }
                    }
                }
                else die('Nu s-a gasit nici un angajat!,for: '.$myQuery);
            }
        }
    }
    else if(isset($_POST['userNAME']) && !empty($_POST['userNAME']))
    {
        $myuserNAME = $_POST['userNAME'];
        //echo 'Got the username: '.$myuserNAME;
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$que = $connect -> query("SELECT `sector` FROM `utilizatori` WHERE `username` = '$myuserNAME' AND (`nivel_ACCES` = 'MANAPROD' OR `nivel_ACCES` = 'ADMIN' OR `nivel_ACCES` = 'DEVELOPER')")) echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
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
            if($request == 'updateORDERS' && $mysector == 'ERP') echo 'OK^update done';
            else echo 'OK';
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
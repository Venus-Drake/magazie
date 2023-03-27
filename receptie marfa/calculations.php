<?php

    if(isset($_POST['cantOPT']) && !empty($_POST['cantOPT']) && isset($_POST['sapcode']) && !empty($_POST['sapcode']))
    {
	    $cantOPT = $_POST['cantOPT'];
	    $sapCODE = $_POST['sapcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$chk = $connect -> query("SELECT `cantitate.minima`, `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'"))
		{
			echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
			mysqli_close($connect);
		}
        if(mysqli_num_rows($chk) > 0)
		{
			$chkrow = $chk -> fetch_assoc();
			$cantMIN = $chkrow['cantitate.minima'];
			$cantOPTgrab = $chkrow['cantitate.optima'];
			if($cantOPT < $cantMIN) die('OK^'.$cantOPTgrab);
			if(!$que = $connect -> query("UPDATE `magazie_stoc` SET `cantitate.optima` = '$cantOPT' WHERE `cod_SAP` = '$sapCODE'"))
			{
				echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
				mysqli_close($connect);
			}
			if(mysqli_affected_rows($connect) > 0) 
			{
				if(!$sel = $connect -> query("SELECT `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'"))
				{
					echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
					mysqli_close($connect);
				}
				if(mysqli_num_rows($sel) > 0)
				{
					$rowsel = $sel -> fetch_assoc();
					$cantOPT = $rowsel['cantitate.optima'];
					echo 'OK^'.$cantOPT;
				}
			}
			else echo 'No lines affected.';
		}
    }
	else if(isset($_POST['cantMIN']) && !empty($_POST['cantMIN']) && isset($_POST['sapcode']) && !empty($_POST['sapcode']))
    {
	    $cantMIN = $_POST['cantMIN'];
	    $sapCODE = $_POST['sapcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$chk = $connect -> query("SELECT `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'"))
		{
			echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
			mysqli_close($connect);
		}
        if(mysqli_num_rows($chk) > 0)
		{
			$rowchk = $chk -> fetch_assoc();
			$cantOPT = $rowchk['cantitate.optima'];
			if($cantOPT < $cantMIN) $que = $connect -> query("UPDATE `magazie_stoc` SET `cantitate.minima` = '$cantMIN', `cantitate.optima` = '$cantMIN' WHERE `cod_SAP` = '$sapCODE'");
			else $que = $connect -> query("UPDATE `magazie_stoc` SET `cantitate.minima` = '$cantMIN' WHERE `cod_SAP` = '$sapCODE'");
			if(!$que)
			{
				echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
				mysqli_close($connect);	
			}
			if(mysqli_affected_rows($connect) > 0) 
			{
				if(!$sel = $connect -> query("SELECT `cantitate.minima`, `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'"))
				{
					echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
					mysqli_close($connect);	
				}
				if(mysqli_num_rows($sel) > 0)
				{
					$rowsel = $sel -> fetch_assoc();
					$cantMIN = $rowsel['cantitate.minima'];
					$cantOPT = $rowsel['cantitate.optima'];
					echo 'OK^'.$cantMIN.'^'.$cantOPT;
				}
			}
			else echo 'No lines affected.';
		}
    }
	else if(isset($_POST['stocSUM']) && !empty($_POST['stocSUM']) && isset($_POST['amountSUM']) && !empty($_POST['amountSUM']))
    {
	    $sapCODE = $_POST['stocSUM'];
	    $amount = $_POST['amountSUM'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'"))
		{
			echo __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect);
			mysqli_close($connect);	
		}
	    if(mysqli_num_rows($que) > 0)
		{
			$stoc = 0;
			while($row = $que -> fetch_assoc())
			{
				$stoc = $stoc + $row['cantitate'];
			}
			$stoc = $stoc + $amount;
			echo 'OK^'.$stoc;
		}
		else echo __LINE__.'. SAP code '.$sapCODE.' not found in '.__FILE__;
    }
	else echo 'No known combinations of variables have been received.';
?>
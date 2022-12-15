<?php

    if(isset($_POST['cantOPT']) && !empty($_POST['cantOPT']) && isset($_POST['sapcode']) && !empty($_POST['sapcode']))
    {
	    $cantOPT = $_POST['cantOPT'];
	    $sapCODE = $_POST['sapcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $chk = "SELECT `cantitate.minima`, `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
        if($chkrun = mysql_query($chk))
        {
			if(mysql_num_rows($chkrun) > 0)
			{
				$chkrow = mysql_fetch_assoc($chkrun);
				$cantMIN = $chkrow['cantitate.minima'];
				$cantOPTgrab = $chkrow['cantitate.optima'];
				if($cantOPT >= $cantMIN) $que = "UPDATE `magazie_stoc` SET `cantitate.optima` = '$cantOPT' WHERE `cod_SAP` = '$sapCODE'";
				else die('OK^'.$cantOPTgrab);
		        if($run = mysql_query($que))
		        {
				    if(mysql_affected_rows() > 0) 
					{
						$sel = "SELECT `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
						if($runsel = mysql_query($sel))
						{
						    if(mysql_num_rows($runsel) > 0)
							{
								$rowsel = mysql_fetch_assoc($runsel);
								$cantOPT = $rowsel['cantitate.optima'];
								echo 'OK^'.$cantOPT;
							}
						}
						else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					}
				    else echo 'No lines affected.';
		        }
		        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
        }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else if(isset($_POST['cantMIN']) && !empty($_POST['cantMIN']) && isset($_POST['sapcode']) && !empty($_POST['sapcode']))
    {
	    $cantMIN = $_POST['cantMIN'];
	    $sapCODE = $_POST['sapcode'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $chk = "SELECT `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
        if($chkrun = mysql_query($chk))
        {
			if(mysql_num_rows($chkrun) > 0)
			{
				$rowchk = mysql_fetch_assoc($chkrun);
				$cantOPT = $rowchk['cantitate.optima'];
				if($cantOPT < $cantMIN) $que = "UPDATE `magazie_stoc` SET `cantitate.minima` = '$cantMIN', `cantitate.optima` = '$cantMIN' WHERE `cod_SAP` = '$sapCODE'";
		        else $que = "UPDATE `magazie_stoc` SET `cantitate.minima` = '$cantMIN' WHERE `cod_SAP` = '$sapCODE'";
		        if($run = mysql_query($que))
		        {
				    if(mysql_affected_rows() > 0) 
					{
						$sel = "SELECT `cantitate.minima`, `cantitate.optima` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
						if($runsel = mysql_query($sel))
						{
						    if(mysql_num_rows($runsel) > 0)
							{
								$rowsel = mysql_fetch_assoc($runsel);
								$cantMIN = $rowsel['cantitate.minima'];
								$cantOPT = $rowsel['cantitate.optima'];
								echo 'OK^'.$cantMIN.'^'.$cantOPT;
							}
						}
						else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					}
				    else echo 'No lines affected.';
		        }
		        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
        }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else if(isset($_POST['stocSUM']) && !empty($_POST['stocSUM']) && isset($_POST['amountSUM']) && !empty($_POST['amountSUM']))
    {
	    $sapCODE = $_POST['stocSUM'];
	    $amount = $_POST['amountSUM'];
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `cantitate` FROM `magazie_stoc` WHERE `cod_SAP` = '$sapCODE'";
	    if($run = mysql_query($que))
	    {
		    if(mysql_num_rows($run) > 0)
		    {
				$stoc = 0;
			    while($row = mysql_fetch_assoc($run))
			    {
				    $stoc = $stoc + $row['cantitate'];
			    }
			    $stoc = $stoc + $amount;
			    echo 'OK^'.$stoc;
		    }
		    else echo __LINE__.'. SAP code '.$sapCODE.' not found in '.__FILE__;
	    }
	    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
	else echo 'No known combinations of variables have been received.';
?>
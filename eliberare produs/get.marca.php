<?php

	if(isset($_GET['numeworker']) && $_GET['numeworker'] != '')
	{
		$numeworker = $_GET['numeworker'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $wchk = "SELECT `WORKER_ID` FROM `pworker` WHERE `WORKER_Name` LIKE '$numeworker'";
		if($wrun = mysql_query($wchk))
		{
		    if(mysql_num_rows($wrun) > 0)
		    {
			    $wrow = mysql_fetch_assoc($wrun);
			    $mymark = $wrow['WORKER_ID'];
				echo $mymark;
		    }
		}
		else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
?>
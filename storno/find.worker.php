<?php

if(isset($_GET['numeworker']) && $_GET['numeworker'] != '')
{
	$numeworker = $_GET['numeworker'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$wchk = $connect -> query("SELECT `WORKER_ID`, `WORKER_Name` FROM `pworker` WHERE `WORKER_Name` LIKE '$numeworker%' LIMIT 20"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($wchk) > 0)
	{
		while($wrow = $wchk -> fetch_assoc())
		{
			$mymark = $wrow['WORKER_ID'];
			$myname = $wrow['WORKER_Name'];
			if($myname != $numeworker) echo '<OPTION VALUE = "'.$myname.'">'.$mymark.'</OPTION>';
		}
	}
}
else if(isset($_GET['worker']) && $_GET['worker'] != '')
{
	$marca = $_GET['worker'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	if(!$wchk = $connect -> query("SELECT `WORKER_ID`, `WORKER_Name` FROM `pworker` WHERE `WORKER_ID` LIKE '$marca%' LIMIT 20"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($wchk) > 0)
	{
		while($wrow = $wchk -> fetch_assoc())
		{
			$mymark = $wrow['WORKER_ID'];
			$myname = $wrow['WORKER_Name'];
			if($mymark != $marca) echo '<OPTION VALUE = "'.$mymark.'">'.$myname.'</OPTION>';
		}
	}
}

?>
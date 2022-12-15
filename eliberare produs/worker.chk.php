<SCRIPT src='/ramira/magazie/eliberare produs/eliberare.script.js'></SCRIPT>
<?php

global $marca;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';

if($marca != '')
{
	if(!$wchk = $connect -> query("SELECT `WORKER_Name`, `sectie`, `WORKER_ID`, `masina` FROM `pworker` WHERE `WORKER_ID` = '$marca'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($wchk) != 0)
	{
		$wchkrow = $wchk -> fetch_assoc();
		$sectia = $wchkrow['sectie'];
		$worker = $wchkrow['WORKER_Name'];
		$masina = $wchkrow['masina'];
	}//echo 'Worker found!';
	else
	{
		$worker = "";
		$sectia = '';
		$marca = '';
		echo '<SCRIPT>flashWORKER();</SCRIPT>';
	}
}
else if($worker != '')
{
	if(!$wchk = $connect -> query("SELECT `WORKER_Name`, `sectie`, `WORKER_ID` FROM `pworker` WHERE `WORKER_Name` = '$worker'"))
	{
		$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		mysqli_close($connect);
	}
	if(mysqli_num_rows($wchk) != 0)
	{
		$wchkrow = $wchk -> fetch_assoc();
		$sectia = $wchkrow['sectie'];
		$marca = $wchkrow['WORKER_ID'];
	}//echo 'Worker found!';
	else
	{
		$worker = "";
		$sectia = '';
		$marca = '';
		$warning = '<FONT STYLE = "FONT-SIZE: 1.5VW"><center>Angajat inexistent!<BR>Worker name: '.$worker.'.<BR>Marca: '.$marca.'.<BR>'.__LINE__.'. '.__FILE__;
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}
}
else
{
    $warning = '<FONT STYLE = "FONT-SIZE: 1.5VW"><center>No worker data received!<BR>'.__LINE__.'. '.__FILE__;
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
<SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
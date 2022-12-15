<?php

global $endMaxDate;

if($endMaxDate == 0) $endMaxDate = $endDate;

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
$serialGrab = "SELECT `nr.crt`, `serial.nr`, `end.loan` FROM `magazie_imprumuturi` WHERE `marca` = '$marca' AND `order.closed` = '0' ORDER BY `end.loan` DESC";
if($runGrab = mysql_query($serialGrab))
{
    if(mysql_num_rows($runGrab) > 0)
    {
	    $rowGrab = mysql_fetch_assoc($runGrab);
	    if(strtotime($rowGrab['end.loan']) > strtotime($endMaxDate))
		{
			$endMaxDate = $rowGrab['end.loan'];
		}
		else $endMaxDate = $endDate;
	    if($rowGrab['serial.nr'] != '0') 
		{
			$seria = $rowGrab['serial.nr'];
			$serialUp = "UPDATE `magazie_imprumuturi` SET `serial.nr` = '$seria', `gestionar` = '$nume' WHERE `marca` = '$marca' AND `order.closed` = '0'";
			if($runUp = mysql_query($serialUp)){}
            else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
		}
	    else 
		{
			$nrMake = $rowGrab['nr.crt'];
   			$seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
  	   		$serialUp = "UPDATE `magazie_imprumuturi` SET `serial.nr` = '$seria', `gestionar` = '$nume' WHERE `marca` = '$marca' AND `order.closed` = '0'";
			if($runUp = mysql_query($serialUp)){}
            else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}
		}
    }
    else 
	{
		$serialMake = "SELECT `nr.crt` FROM `magazie_imprumuturi` ORDER BY `nr.crt` DESC";
		if($runMake = mysql_query($serialMake))
		{
			$rowMake = mysql_fetch_assoc($runMake);
			$nrMake = $rowMake['nr.crt'];
			$nrMake++;
		    $seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
		    $endMaxDate = $endDate;
		}
   		else
		{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
		}
	}
}
else
{
	$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}

?>
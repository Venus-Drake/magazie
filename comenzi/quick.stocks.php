<?php

	$qSTOCKchk = "SELECT `alarma` FROM `magazie_stoc` WHERE `cantitate` <= `cantitate.minima`";
	if($qSTOCKrun = mysql_query($qSTOCKchk))
	{
	    if(mysql_num_rows($qSTOCKrun) > 0)
		{
		    $qSTOCKupdate = "UPDATE `magazie_stoc` SET `alarma` = '1' WHERE `cantitate` <= `cantitate.minima`";
		    if($qSTOCKupRUN = mysql_query($qSTOCKupdate)){}
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
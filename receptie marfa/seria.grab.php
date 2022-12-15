<?php

    $seria = 'RAM-WS/1/'.date('dmyhi',strtotime($datetime));
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    $grabseria = "SELECT `serie_BON` FROM `arhiva_miscari_magazie` WHERE `tip.miscare` = 'Receptie produs' ORDER BY `data` DESC, `ora` DESC";
    if($grabRUN = mysql_query($grabseria))
    {
	    if(mysql_num_rows($grabRUN) > 0)
	    {
			$grabROW = mysql_fetch_assoc($grabRUN);
			$lastSERIA = $grabROW['serie_BON'];
			$seriaARRAY = explode("/",$lastSERIA);
			$nrMake = $seriaARRAY[1] + 1;
	        $seria = 'RAM-WS/'.$nrMake.'/'.date('dmyhi',strtotime($datetime));
	    }
    }
    else
	{
		$mailerror = '<FONT STYLE = "FONT-SIZE: 1.5vw"><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
	}

?>
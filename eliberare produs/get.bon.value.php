<?php

    $bonVALUE = "SELECT `val.tot` FROM `bon_consum_tmp` WHERE `serial.nr` = '$seria' ORDER BY `val.tot` DESC";
	if($bonVALUErun = mysql_query($bonVALUE))
	{
		$valBON = 0;
    	if(mysql_num_rows($bonVALUErun) > 0)
    	{
	        $bonVALUErow = mysql_fetch_assoc($bonVALUErun);
	        $valBON = $bonVALUErow['val.tot'];
        }
    }
    else die( __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error());

?>
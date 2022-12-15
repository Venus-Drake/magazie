<?php

    if(!$bonVALUE = $connect -> query("SELECT `val.tot` FROM `bon_consum_tmp` WHERE `serial.nr` = '$seria' ORDER BY `val.tot` DESC"))
	{die( __LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	$valBON = 0;
	if(mysqli_num_rows($bonVALUE) > 0)
	{
		$bonVALUErow = $bonVALUE -> fetch_assoc();
		$valBON = $bonVALUErow['val.tot'];
	}

?>
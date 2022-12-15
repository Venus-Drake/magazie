<?php

	$qSTOCKchk = $connect -> query("SELECT `alarma` FROM `magazie_stoc` WHERE `cantitate` <= `cantitate.minima`");
	if(mysqli_num_rows($qSTOCKchk) > 0)
	{
		if(!$qSTOCKupdate = $connect -> query("UPDATE `magazie_stoc` SET `alarma` = '1' WHERE `cantitate` <= `cantitate.minima`"))
		{
			echo __LINE__.'. Could not update magazie_stoc in '.__FILE__;
		}
	}

?>
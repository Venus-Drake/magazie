<?php

    if(isset($_POST['alarm']) && !empty($_POST['alarm']))
	{
		$alarm = $_POST['alarm'];
		if($alarm == 'stopALARMS')
		{
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
    		if(!$que = $connect -> query("UPDATE `magazie_stoc` SET `alarma` = '0' WHERE `alarma` = '1'"))
			{
				die('MySQL error in /ramira/magazie/comenzi/buttons.actions.php!');
			}
    		echo 'OK';
		}
	}

?>
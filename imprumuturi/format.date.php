<?php

    if(isset($_GET['dateFormat']) && !empty($_GET['dateFormat']))
    {
	    $dateToFormat = $_GET['dateFormat'];
	    $newDate = date('d M Y', strtotime($dateToFormat,time()));
	    echo $newDate;
    }

?>
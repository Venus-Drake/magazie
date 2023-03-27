<?php

    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `alarma` = '1'")) {
    die('MySQL Error!');}
    if(mysqli_num_rows($que) > 0) echo 'Stoc alert';
    else echo 'OK';

?>
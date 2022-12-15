<?php

$error = "Could not connect!<br>".__FILE__;
$my_host = 'localhost';
$dbuser = 'cristina.ramira';
$my_pass = 'mapalunara77';
$mydb = 'warehouse.soft';

$connect = new mysqli($my_host,$dbuser,$my_pass,$mydb);
if($connect -> connect_error)
{
    echo $error;
    exit();
}

?>
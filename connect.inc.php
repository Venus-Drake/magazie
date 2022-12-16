<?php

$error = "Could not connect!<br>".__FILE__;
$my_host = 'localhost';
$dbuser = '*********';
$my_pass = '**********';
$mydb = '************';

$connect = new mysqli($my_host,$dbuser,$my_pass,$mydb);
if($connect -> connect_error)
{
    echo $error;
    exit();
}

?>

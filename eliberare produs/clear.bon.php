<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
if(isset($_GET['agreed_bon']) && !empty($_GET['agreed_bon'])) $marcadel = $_GET['agreed_bon'];
else echo 'Nu avem nici o marca inregistrata pentru bon.';

$clear = "DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marcadel' AND `processed` = '0'";
if($clearrun = mysql_query($clear))
{
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.magazie.php';
}
else echo 'FATAL ERROR!
Something unexpected went wrong!
MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysql_error().'
Please, contact program administrator at
warehouse-soft@ramira.ro';

?>
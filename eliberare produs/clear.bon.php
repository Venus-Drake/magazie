<?php

require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
if(isset($_GET['agreed_bon']) && !empty($_GET['agreed_bon'])) $marcadel = $_GET['agreed_bon'];
else echo 'Nu avem nici o marca inregistrata pentru bon.';

if(!$clear = $connect -> query("DELETE FROM `bon_consum_tmp` WHERE `marca` = '$marcadel' AND `processed` = '0'"))
{
    echo 'FATAL ERROR!
Something unexpected went wrong!
MySQL Error:
'.__LINE__.". ".__FILE__.":
".mysqli_error($connect).'
Please, contact program administrator at
warehouse-soft@ramira.ro';
    mysqli_close($connect);
}
require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.magazie.php';

?>
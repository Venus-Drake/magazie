<?php

    if(isset($_POST['sapcode']) && $_POST['sapcode'] != '' && $_POST['sapcode'] != ' ')
    {
		$SAPcode = $_POST['sapcode'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `cod_SAP`, `denumire` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%' AND `cod_SAP` != '$SAPcode' GROUP BY `cod_SAP`";
	    if($run = mysql_query($que))
	    {
		    if(mysql_num_rows($run) > 0)
		    {
				echo 'OK^';
			    while($row = mysql_fetch_assoc($run))
			    {
					if($row['cod_SAP'] != $SAPcode)
					{
				        $SAPread = $row['cod_SAP'];
				        $name = $row['denumire'];
					    echo '<OPTION VALUE = '.$SAPread.'>'.$name.'</OPTION>';
					}
			    }
		    }
	    }
	    else echo __LINE__.'. MySQL error in '.__FILE__;
    }
    else if(isset($_POST['productname']) && $_POST['productname'] != '' && $_POST['productname'] != ' ')
    {
		$product = $_POST['productname'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `cod_SAP`, `denumire` FROM `magazie_stoc` WHERE `denumire` LIKE '$product%' AND `denumire` != '$product' GROUP BY `denumire`";
	    if($run = mysql_query($que))
	    {
		    if(mysql_num_rows($run) > 0)
		    {
				echo 'OK^';
			    while($row = mysql_fetch_assoc($run))
			    {
					if($row['denumire'] != $product)
					{
				        $SAPread = $row['cod_SAP'];
				        $name = $row['denumire'];
					    echo '<OPTION VALUE = "'.$name.'">'.$SAPread.'</OPTION>';
					}
			    }
		    }
	    }
	    else echo __LINE__.'. MySQL error in '.__FILE__;
    }
    else if(isset($_POST['furnizor']) && $_POST['furnizor'] != '' && $_POST['furnizor'] != ' ')
    {
		$furnizor = $_POST['furnizor'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    $que = "SELECT `furnizor` FROM `magazie_stoc` WHERE `furnizor` LIKE '$furnizor%' AND `furnizor` != '$furnizor' GROUP BY `furnizor`";
	    if($run = mysql_query($que))
	    {
		    if(mysql_num_rows($run) > 0)
		    {
				echo 'OK^';
			    while($row = mysql_fetch_assoc($run))
			    {
					if($row['furnizor'] != $furnizor)
					{
				        $furnizorREAD = $row['furnizor'];
					    echo '<OPTION VALUE = "'.$furnizorREAD.'"></OPTION>';
					}
			    }
		    }
	    }
	    else echo __LINE__.'. MySQL error in '.__FILE__;
    }

?>
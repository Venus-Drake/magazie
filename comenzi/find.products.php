<?php

    if(isset($_POST['sapcode']) && $_POST['sapcode'] != '' && $_POST['sapcode'] != ' ')
    {
		$SAPcode = $_POST['sapcode'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `cod_SAP`, `denumire` FROM `magazie_stoc` WHERE `cod_SAP` LIKE '$SAPcode%' AND `cod_SAP` != '$SAPcode' GROUP BY `cod_SAP`"))
		{
		die(__LINE__ . '. MySQL error in ' . __FILE__);
		}
	    if(mysqli_num_rows($que) > 0)
		{
			echo 'OK^';
			while($row = $que -> fetch_assoc())
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
    else if(isset($_POST['productname']) && $_POST['productname'] != '' && $_POST['productname'] != ' ')
    {
		$product = $_POST['productname'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `cod_SAP`, `denumire` FROM `magazie_stoc` WHERE `denumire` LIKE '$product%' AND `denumire` != '$product' GROUP BY `denumire`"))
		{
			die(__LINE__.'. MySQL error in '.__FILE__);
		}
	    if(mysqli_num_rows($que) > 0)
		{
			echo 'OK^';
			while($row = $que -> fetch_assoc())
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
    else if(isset($_POST['furnizor']) && $_POST['furnizor'] != '' && $_POST['furnizor'] != ' ')
    {
		$furnizor = $_POST['furnizor'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	    if(!$que = $connect -> query("SELECT `furnizor` FROM `magazie_stoc` WHERE `furnizor` LIKE '$furnizor%' AND `furnizor` != '$furnizor' GROUP BY `furnizor`"))
		{
			die(__LINE__.'. MySQL error in '.__FILE__);
		}
	    if(mysqli_num_rows($que) > 0)
		{
			echo 'OK^';
			while($row = $que -> fetch_assoc())
			{
				if($row['furnizor'] != $furnizor)
				{
					$furnizorREAD = $row['furnizor'];
					echo '<OPTION VALUE = "'.$furnizorREAD.'"></OPTION>';
				}
			}
		}
    }

?>
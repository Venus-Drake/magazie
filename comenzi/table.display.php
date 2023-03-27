<?php

    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
    if(isset($_GET['alarm']) && $_GET['alarm'] != '')
    {
	    $alarm = $_GET['alarm'];
	    if($alarm == '1') echo '<CENTER><IMG SRC="/ramira/magazie/images/emptywarehouse.jpg" alt="Poor empty warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 25VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
	    else if($alarm == 'showSTOCKS')
	    {
			if(isset($_GET['nume']) && !empty($_GET['nume'])) $nume = $_GET['nume'];
			else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` ORDER BY `cod_SAP`"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
			if(mysqli_num_rows($que) > 0)
			{
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/table.display.echo.php';
			}
			else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
	    }
	    else if($alarm == 'sortTABLE')
	    {
		    if(isset($_GET['nume']) && !empty($_GET['nume'])) 
			{
				$nume = $_GET['nume'];
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
				if(isset($_GET['reference']) && !empty($_GET['reference']) && isset($_GET['column']) && !empty($_GET['column']))
				{
					$reference = $_GET['reference'];
					$column = $_GET['column'];
					if(isset($_GET['sortby']) && !empty($_GET['sortby'])) 
					{
						$sortby = $_GET['sortby'];
						if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `$column` = '$reference' ORDER BY `$sortby`"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);	
						}
					}
					else
					{
						if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `$column` = '$reference'"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);		
						}
					}
					if(mysqli_num_rows($que) > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/table.display.echo.php';
					else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
				}
				else
				{
				    if(isset($_GET['sortby']) && !empty($_GET['sortby'])) 
					{
						$sortby = $_GET['sortby'];
						if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` ORDER BY `$sortby`"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);		
						}
						if(mysqli_num_rows($que) > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/table.display.echo.php';
						else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
					}
				}
			}
			else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
	    }
	    else if($alarm == 'displaySAP' || $alarm == 'displayMAGAZIE' || $alarm == 'displayGRUPA' || $alarm == 'displayFURNIZOR' || $alarm == 'displayNAME' || $alarm == 'showALARMprod')
	    {
			if(isset($_GET['nume']) && !empty($_GET['nume'])) $nume = $_GET['nume'];
			else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
		    if(isset($_GET['SAPcode']) && $_GET['SAPcode'] != '') $SAPcode = $_GET['SAPcode'];
		    else if(isset($_GET['magazie']) && $_GET['magazie'] != '') $magazie = $_GET['magazie'];
		    else if(isset($_GET['grupa']) && $_GET['grupa'] != '') $grupa = $_GET['grupa'];
		    else if(isset($_GET['FURNIZOR']) && $_GET['FURNIZOR'] != '') $FURNIZOR = $_GET['FURNIZOR'];
		    else if(isset($_GET['PRODUCTname']) && $_GET['PRODUCTname'] != '') $PRODname = $_GET['PRODUCTname'];
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			if($alarm == 'displaySAP') $que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `cod_SAP` = '$SAPcode'");
			else if($alarm == 'displayMAGAZIE') $que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `magazie` = '$magazie' ORDER BY 'cod_SAP'");
			else if($alarm == 'displayGRUPA') $que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `grupa_MAT` = '$grupa'");
			else if($alarm == 'displayFURNIZOR') $que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `furnizor` = '$FURNIZOR' ORDER BY `cod_SAP`");
			else if($alarm == 'displayNAME') $que = $connect -> query("SELECT * FROM `magazie_stoc` WHERE `denumire` = '$PRODname'");
			else if($alarm == 'showALARMprod') $que = $connect -> query("SELECT * FROM `magazie_stoc` ORDER BY `cod_SAP`, `cantitate.minima` DESC");
			if(!$que)
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);		
			}
			if(mysqli_num_rows($que) > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/table.display.echo.php';
			else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
	    }
	    else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';
    }
    else echo '<CENTER><IMG SRC="/ramira/magazie/images/warehouse_full.jpg" alt="My happy warehouse" style=" WIDTH:100%; HEIGHT:100%;MARGIN-TOP: 15VW; OVERFLOW: HIDDEN; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20PX"></CENTER>';

?>

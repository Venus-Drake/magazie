<HTML>

<HEAD>
    <STYLE>
        BODY
        {
            FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
            FONT-SIZE: 1.5vw;
            WIDTH: 100%;
        }
        .comenzi
        {
		    background-color: RGBA(237,28,36);
        }

    </STYLE>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>

</HEAD>
<BODY>
    <?php
	    if(isset($_GET['nume']) && !empty($_GET['nume']))
		{
			$nume = $_GET['nume'];
			if(isset($_GET['userid']) && !empty($_GET['userid'])) $user = $_GET['userid'];
			else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
		}
	    else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
	?>

<DIV CLASS = "container">
    <DIV CLASS = "LEFT_BAR"><BR><BR>
	    <?php
		
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		    $stocCHK = "SELECT * FROM `magazie_stoc` WHERE `cantitate` <= `cantitate.minima` AND `alarma` = '1'";
		    if($stocCHKrun = mysql_query($stocCHK))
		    {
			    if(mysql_num_rows($stocCHKrun) > 0)
			    {
					$stocALARM = TRUE;
				    echo '<DIV ID = "headTEXT" STYLE = "WIDTH: 100%; HEIGHT: 5vw;"><CENTER>S-au detectat produse cu stoc zero sau la limita!</CENTER><BR></DIV>
					<DIV ID = "alarmsON" STYLE = "DISPLAY: BLOCK;">';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/alarmson.buttons.php';
					echo'<DIV ID = "alarmsOFF" STYLE = "DISPLAY: NONE;">';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/alarmsoff.buttons.php';
			    }
			    else
				{
					$stocALARM = FALSE;
					echo '<DIV ID = "headTEXT" STYLE = "WIDTH: 100%; HEIGHT: 5vw;"><CENTER>Nu s-au gasit alerte de stoc active in magazie</CENTER><BR></DIV>
					<DIV ID = "alarmsON" STYLE = "DISPLAY: NONE;">';
	    			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/alarmson.buttons.php';
					echo '<DIV ID = "alarmsOFF" STYLE = "DISPLAY: BLOCK;">';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/alarmsoff.buttons.php';
				}
		    }
		    else
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			}

		?>
    </DIV>
    <DIV ID = "numeGESTIONAR" STYLE = "DISPLAY: NONE"><?php echo $nume;?></DIV>
    <DIV CLASS = "bon_magazie">
        <IFRAME ID = "displaySECTION" NAME = "displaySECTION" SRC = "/ramira/magazie/comenzi/table.display.php?alarm=<?php echo $stocALARM;?>" CLASS = "bon_magazie_frame"></IFRAME>
    </DIV>
</DIV>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			display_ct();
		}
    </SCRIPT>
    <SCRIPT src="/ramira/magazie/comenzi/comenzi.script.js"></SCRIPT>
</BODY>

</HTML>
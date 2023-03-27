<HTML STYLE = "HEIGHT: 100%;">
    <HEAD>
        <link rel="stylesheet" href="\ramira\magazie\styles.css">
    	<STYLE>
            BODY
			{
			    MIN-HEIGHT: 100VH;
			    MARGIN: 0 AUTO;
			    WIDTH: 100%;
			    DISPLAY: INLINE-BLOCK;
			    OVERFLOW: AUTO;
			    BACKGROUND-COLOR: BLACK;
			    OPACITY: 0;
			    FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
			    FONT-SIZE: 1.5vw;
			    ANIMATION: PAGE-LOAD 1.5s FORWARDS;
			}
            @KEYFRAMES PAGE-LOAD
			{
			    FROM {BACKGROUND-COLOR: BLACK; OPACITY: 0}
			   	TO {BACKGROUND-COLOR: RGB(0,73,123,.3); OPACITY: 1}
			}
        </STYLE>
        <SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
    </HEAD>

<HEADER>
    <title>Ramira Warehouse</title>
    <link rel="icon" type="image/x-icon" href="/ramira/magazie/images/favicon.ico">

    <?php
        require 'C:\xampp\htdocs\ramira\magazie\header.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/ramira/spout-3.3.0/src/Spout/Autoloader/autoload.php';
		$iplog = $_SERVER['REMOTE_ADDR'];
	 	require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		if($ipchk = $connect -> query("UPDATE `utilizatori` SET `IP.connect` = '' WHERE `IP.connect` = '$iplog'")){}
	 	else
	 	{
			$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
			require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
		}
	 	$user = '';
	 	$pass = '';
	?>

</HEADER>

    <BODY onbeforeunload="return pageReload()">
        <?php 
		    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'chrome') == 0){
				die('<DIV STYLE = "WIDTH: 100%; HEIGHT: 100%; FONT-SIZE: 3VW; BACKGROUND-COLOR: WHITE;"><CENTER><P STYLE = "MARGIN: 0 AUTO; MARGIN-TOP: 20VH; WIDTH: 90%;">Pentru o buna vizualizare a paginii, va rugam, folositi Google Chrome sau o varianta actualizata Microsoft Edge!</CENTER><BR><BR><BR><FONT STYLE = "FONT-SIZE: 2VW;"><P STYLE = "MARGIN: 0 AUTO;WIDTH: 90%;">Va multumim!</DIV>');
		    }
        ?>
        <IFRAME ID = "programBODY" SRC="/ramira/magazie/login.php" STYLE = "WIDTH: 100%; MIN-HEIGHT: 100VH; MARGIN: 0 AUTO; FLOAT: NONE; BORDER: 0;"></IFRAME>
    </BODY>
</HTML>

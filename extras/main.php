<HTML>
<HEAD>
    <STYLE>
        BODY
        {
            FONT-FAMILY: 'DOSIS',CALIBRI,ARIAL,SANS-SERIF;
            FONT-SIZE: 24px;
            WIDTH: 100%;
        }
        .extras
        {
		    background-color: RGBA(237,28,36);
        }
        DIV
        {
		    FLOAT: LEFT;
        }
        .SITUATII
        {
		    BACKGROUND-COLOR: ORANGE;
		    BORDER-COLOR: BLACK;
		    FONT-WEIGHT: BOLD;
		    WIDTH: 350px;
		    HEIGHT: 50px;
		    MARGIN: 5px;
        }
        SELECT
		{
		    BACKGROUND-COLOR: ORANGE;
		    BORDER-COLOR: BLACK;
		    BORDER-RADIUS: 20px;
		    FONT-FAMILY: 'DOSIS',CALIBRI,ARIAL,SANS-SERIF;
            FONT-SIZE: 20px;
		    WIDTH: 350px;
		    HEIGHT: 50px;
		    MARGIN: 5px;
		}
        table tr:not(:first-child)
	    {
	        cursor: pointer; transition: all .15s ease-in-out;
	    }
	    .ROW:hover{background-color: DARKGREY;}
        .OPTIONS
        {
		    WIDTH: 30%;
		    HEIGHT: 800px;
		    BORDER: 2px SOLID #999;
			BORDER-RADIUS: 20px;
        }
        .DISPLAY
        {
		    WIDTH: 69%;
		    HEIGHT: 800px;
			BACKGROUND-COLOR: WHITE;
			BORDER: 2px SOLID #999;
			BORDER-RADIUS: 20px;
        }
        .OK
        {
		    WIDTH: 35px;
			HEIGHT: 35px;
			BACKGROUND-COLOR: GRAY;
			BORDER-RADIUS: 5px;
			BOX-SHADOW: none;
			FLOAT: RIGHT;
			TEXT-ALIGN: CENTER;
        }
        .OK:hover
		{
			background-color: none;
		}
        .OK:active
		{
		  background-color: none;
		  box-shadow: none;
		  transform: none;
		}
    </STYLE>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
    <?php
    if(isset($_GET['nume']) && !empty($_GET['nume']))
	{
		$nume = $_GET['nume'];
		if(isset($_GET['userid']) && !empty($_GET['userid'])) $user = $_GET['userid'];
		else $user = 'Unknown User';
	}
    else die("<font color = red size = 5><center><b>Something unexpected went wrong!<br>Please, contact program administrator! Nume inregistrat: $nume");
    require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';
?>
</HEAD>
<BODY>
    
    <DIV CLASS = "OPTIONS">
	    <BR><BR><BR>
	    <!--<BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/build.magazie.stoc.php?nume=<?php echo $nume; ?>'" TARGET = "_SELF"><B>MAGAZIE STOC BUILDING</BUTTON><BR>--!>
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/display.furnizori.php?nume=<?php echo $nume; ?>'" TARGET = "_SELF"><B>AFISARE FURNIZORI</BUTTON><BR>
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/display.grupe.mat.php?nume=<?php echo $nume; ?>'" TARGET = "_SELF"><B>AFISARE GRUPE MATERIALE</BUTTON><BR>
    </DIV>
    <DIV CLASS = "DISPLAY">
        <BR><BR><BR><CENTER>VA ROG, ALEGETI O OPTIUNE DIN BARA DIN STANGA!
    </DIV>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			display_ct();
		}
    </SCRIPT>
</BODY>
</HTML>

<SCRIPT>

    var errdia = document.getElementById("errdia");
    function closeDialog()
	{
 	    errdia.close();
    }

</SCRIPT>
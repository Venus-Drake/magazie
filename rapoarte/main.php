<HTML>
<HEAD>
    <STYLE>
        BODY
        {
            FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
            FONT-SIZE: 1.5vw;
            WIDTH: 100%;
        }
        .rapoarte
        {
		    background-color: RGBA(237,28,36);
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
	    else die("<font color = red size = 5><center><b>Something unexpected went wrong!<br>Please, contact program administrator!");
	    require 'C:\xampp\htdocs\ramira\magazie\header.php';
	    require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';
	?>
</HEAD>
<BODY>
    <table width = 100% border=0>
	   <TD ALIGN = CENTER VALIGN = CENTER HEIGHT = 730><font size = 5 color = black><b>Aici vom avea sectiunea de afisare/ printare diverse rapoarte necesare</TD>
    </table>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			display_ct();
		}
    </SCRIPT>
</BODY>
</HTML>
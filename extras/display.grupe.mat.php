<?php

$nume = (string) $nume;
    if(isset($_GET['nume']) && $_GET['nume'] != '') 
	{
		$nume = $_GET['nume'];
		if(isset($_GET['userid']) && !empty($_GET['userid'])) 
		{
			$user = $_GET['userid'];
			require 'C:\xampp\htdocs\ramira\magazie\header.php';
		}	
		else $user = 'Unknown User';
	}
    else die("<font color = red size = 5><center><b>Something unexpected went wrong!<br>Please, contact program administrator! Nume inregistrat: $nume");
    require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';

?>
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
		    background-color: #b8913e;
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
	    TH, TR, TD
	    {
		    BORDER: 2px SOLID BLACK;
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
			OVERFLOW: AUTO;
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
			OVERFLOW-WRAP: NORMAL;
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
</HEAD>
<BODY>
    
    <DIV CLASS = "OPTIONS">
	    <BR><BR><BR>
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/display.furnizori.php?nume=<?php echo $nume.'&userid='.$user; ?>'" TARGET = "_SELF"><B>AFISARE FURNIZORI</BUTTON><BR>
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/display.grupe.mat.php?nume=<?php echo $nume.'&userid='.$user; ?>'" TARGET = "_SELF"><B>AFISARE GRUPE MATERIALE</BUTTON><BR>
    </DIV>
    <DIV CLASS = "DISPLAY">
        <!--EXTRAGEM FURNIZORII, PENTRU A FOLOSI, PE VIITOR, DATELE FIECARUIA, CU CE PRODUSE AU SI LA CE PRETURI, ETC...-->
        <?PHP
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		    echo '<BR><BR><BR><CENTER><B><U>GRUPE MATERIALE LA '.$datetime.'</U></B><BR><BR>';
		    if(!$mag = $connect -> query("SELECT `grupa_MAT` FROM `magazie` GROUP BY `grupa_MAT` ORDER BY `grupa_MAT`"))
			{die('<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED; WIDTH: 400px; BORDER: 3px SOLID BLACK; OVERFLOW-WRAP: BREAK-WORD;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysqli_error($connect).'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>');}
		    ECHO('<TABLE STYLE = "WIDTH: 80%; BORDER: 3px SOLID BLACK;BORDER-COLLAPSE: COLLAPSE;">
						<TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">Nr.Crt.</TH><TH STYLE = "WIDTH: 96%; TEXT-ALIGN = CENTER">Grupa materiale si produse</TH><TR>');
			if(mysqli_num_rows($mag) > 0)
			{
				$nrcrt = 0;
				while($magrow = $mag -> fetch_assoc())
				{
					$nrcrt++;
					$grupaMAT = $magrow['grupa_MAT'];
					if($grupaMAT == '') continue;
					echo '<TR CLASS = "ROW"><TD>'.$nrcrt.'</TD><TD>'.$grupaMAT.'</TD>';
				}
				echo '</TABLE><BR><BR>';
			}
			else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>Something is not right!<BR>Nu avem data despre nici un furnizor?!!<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
		?>
    </DIV>

</BODY>
</HTML>

<SCRIPT>

    var errdia = document.getElementById("errdia");
    function closeDialog()
	{
 	    errdia.close();
    }

</SCRIPT>
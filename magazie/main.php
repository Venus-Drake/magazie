<HTML>
<HEAD>
    <STYLE>
        BODY
        {
            FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
            FONT-SIZE: 1.5vw;
            WIDTH: 100%;
        }
        .status
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
		    BORDER-TOP: 1px SOLID BLACK;
			BORDER-LEFT: 1px SOLID BLACK;
			BORDER-BOTTOM: 3px SOLID BLACK;
			BORDER-RIGHT: 3px SOLID BLACK;
		    FONT-WEIGHT: BOLD;
		    WIDTH: 350px;
		    HEIGHT: 50px;
		    MARGIN: 5px;
		    BOX-SHADOW: 0 4px #999;
        }
        .SITUATII:HOVER
		{
			BACKGROUND-COLOR: #FFD503;
		}
        SELECT
		{
		    BACKGROUND-COLOR: ORANGE;
		    BORDER-COLOR: BLACK;
		    BORDER-RADIUS: 20px;
		    FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
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
			OVERFLOW: AUTO;
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
	    else die("<font color = red size = 5><center><b>Something unexpected went wrong!<br>Please, contact program administrator!");
	    require 'C:\xampp\htdocs\ramira\magazie\header.php';
	    require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';
	    if(isset($_GET['option']) && $_GET['option'] != '')
		{
			$option = $_GET['option'];
			//echo 'Setting new warehouse: '.$option;
		}
		else $option = 'GLOBALA';
		if(isset($_GET['clasa']) && $_GET['clasa'] != '')
		{
			$clasa = $_GET['clasa'];
			//echo 'Setting new warehouse: '.$option;
		}
		else $clasa = 'GENERALA';
	
	?>
</HEAD>
<BODY>
    <!--EXTRAGEM DIN BAZA DE DATE SITUATIA LA ZI PE TOATE MAGAZIILE, DEOCAMDATA; SETAM, INSA, OPTIUNI SA EXTRAGEM SITUATII PE MAGAZII, PE CLASE DE SCULE, ETC.--!>
    
    <DIV CLASS = "OPTIONS">
	    <BR><BR><BR>
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Magazie/main.php?option=GLOBALA&nume=<?php echo $nume;?>'" STYLE = "MARGIN-BOTTOM: 15px;"><B>SITUATIE GENERALA</BUTTON><BR>
	    <FORM ACTION = "" METHOD = "GET" STYLE = "HEIGHT: 57px;">
	        <INPUT HIDDEN = HIDDEN NAME = 'nume' VALUE = "<?php echo $nume;?>"></INPUT>
		    <SELECT ONCHANGE = "this.form.submit()" CLASS = "SITUATII" STYLE = "FONT-WEIGHT: BOLD;" NAME = "option">
		        <OPTION ALIGN = CENTER STYLE = "FONT-WEIGHT: BOLD" VALUE = <?php echo $option;?>>SITUATIE PE MAGAZII</OPTION>
			    <OPTION ALIGN = CENTER STYLE = "FONT-WEIGHT: BOLD" VALUE = 'A'>MAGAZIA A</OPTION>
				<OPTION ALIGN = CENTER STYLE = "FONT-WEIGHT: BOLD" VALUE = 'S'>MAGAZIA S</OPTION>
	        </SELECT>
        </FORM>
        <BR>
        <FORM ACTION = "" METHOD = "GET"  STYLE = "HEIGHT: 50px;">
	        <INPUT HIDDEN = HIDDEN NAME = 'nume' VALUE = "<?php echo $nume;?>"></INPUT>
		    <SELECT ONCHANGE = "this.form.submit()" CLASS = "SITUATII" STYLE = "FONT-WEIGHT: BOLD;" NAME = "clasa">
		        <OPTION ALIGN = CENTER STYLE = "FONT-WEIGHT: BOLD" VALUE = <?php echo $clasa;?>>SITUATIE PE GRUPE SCULE SI PRODUSE</OPTION>
		        <?php
		            require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
		            $grup = "SELECT `grupa_MAT` FROM `magazie` GROUP BY `grupa_MAT` ORDER BY `grupa_MAT`";
		            if($gruprun = mysql_query($grup))
		            {
					    if(mysql_num_rows($gruprun) > 0)
					    {
						    while($gruprow = mysql_fetch_assoc($gruprun))
						    {
							    $grup = $gruprow['grupa_MAT'];
							    if($grup == '') continue;
							    echo '<OPTION ALIGN = CENTER STYLE = "FONT-WEIGHT: BOLD" VALUE = '.$grup.'>GRUPA '.$grup.'</OPTION>';
						    }
					    }
					    else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED; WIDTH: 400px; BORDER: 3px SOLID BLACK; OVERFLOW-WRAP: BREAK-WORD;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>ATENTIE!! NICI O GRUPA DE MATERIALE NU ESTE AFISATA!<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
 					}
		            else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED; WIDTH: 400px; BORDER: 3px SOLID BLACK; OVERFLOW-WRAP: BREAK-WORD;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error().'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
				?>
	        </SELECT>
        </FORM>
	    <BUTTON CLASS = "SITUATII">ALTE SITUATII( DE ADAUGAT)</BUTTON>
    </DIV>
    <DIV CLASS = "DISPLAY">
        <?PHP
		    require 'C:\xampp\htdocs\ramira\magazie\Magazie\situatie.display.html';
		?>
    </DIV>
    <DIALOG ID = "optionsDialog">
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
<?php

global $nume;
    if(isset($_GET['nume']) && $_GET['nume'] != '') $nume = $_GET['nume'];
    else die("<font color = red size = 5><center><b>Something unexpected went wrong!<br>Please, contact program administrator! Nume inregistrat: $nume");
    require 'C:\xampp\htdocs\ramira\magazie\navigation.html';

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
	    <BUTTON CLASS = "SITUATII" ONCLICK = "location.href='http://localhost/ramira/magazie/Extras/build.magazie.stoc.php?nume=<?php echo $nume;?>'" TARGET = "_SELF"><B>MAGAZIE STOC BUILDING</BUTTON><BR>
    </DIV>
    <DIV CLASS = "DISPLAY">
        <!--AICI FACEM UN BUILD AL MAGAZIEI. FOARTE POSIBIL SA NU MAI FIE NECESAR PE VIITOR...DAR PANA ATUNCI, EU AM NEVOIE DE EL.--!>
        <?PHP
		    //EXTRAGEM PRODUSELE DIN TABELUL magazie SI VERIFICAM DACA LE AVEM IN magazie_stoc; DACA NU LE AVEM, LE ADAUGAM. FAC SI NISTE STOCURI EMPIRICE, CU OCAZIA ASTA.
		    require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
		    echo '<BR><BR><BR><CENTER><B><U>STOC MAGAZIE IN '.$datetime.'</U></B><BR><BR>';
		    $mag = "SELECT * FROM `magazie` GROUP BY `cod_sap` ORDER BY `cod_sap`";
		    if($marun = mysql_query($mag))
			{
				ECHO('<TABLE STYLE = "WIDTH: 98%; BORDER: 3px SOLID BLACK;BORDER-COLLAPSE: COLLAPSE;">
				         <TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">Nr.Crt.</TH><TH STYLE = "WIDTH: 5%; TEXT-ALIGN = CENTER">Cod SAP</TH><TH STYLE = "WIDTH: 3%;">Denumire produs</TH><TH STYLE = "WIDTH: 5%;">Cantitate</TH><TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">U.M.</TH><TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">Magazie</TH><TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">Grupa materiale</TH><TH STYLE = "WIDTH: 3%; TEXT-ALIGN = CENTER">Pret</TH><TH STYLE = "WIDTH: 20%;">Furnizor</TH><TH STYLE = "WIDTH: 25%;">Observatii</TH><TR>');
				if(mysql_num_rows($marun) > 0)
				{
					$nrcrt = 0;
				    while($magrow = mysql_fetch_assoc($marun))
				    {
					    $cod_sap = $magrow['cod_sap'];
					    if($cod_sap == '') continue;
					    //VERIFICAM PRODUSUL IN magazie_stoc
					    $mver = "SELECT * FROM `magazie_stoc` WHERE `cod_SAP` = '$cod_sap'";
					    if($verrun = mysql_query($mver))
					    {
						    if(mysql_num_rows($verrun) > 0)
						    {
								//PRODUSUL ESTE IN MAGAZIE; PUR SI SIMPLU, AFISAM DATELE DESPRE EL.
								while($verrow = mysql_fetch_assoc($verrun))
								{
									$nrcrt++;
									$denumire = $verrow['denumire'];
									$cantitate = $verrow['cantitate'];
									$unit_mas = $verrow['UM'];
									$furnizor = $verrow['furnizor'];
									$magazie = $verrow['magazie'];
									$grupa_mat = $verrow['grupa_MAT'];
									$pret = $verrow['pret'];
									$observatii = $verrow['observatii'];
							        echo '<TR CLASS = "ROW"><TD>'.$nrcrt.'</TD><TD>'.$cod_sap.'</TD><TD>'.$denumire.'</TD><TD>'.$cantitate.'</TD><TD>'.$unit_mas.'</TD><TD>'.$magazie.'</TD><TD>'.$grupa_mat.'</TD><TD>'.$pret.'</TD><TD>'.$furnizor.'</TD><TD>'.$observatii.'</TD>';
							    }
						    }
						    else
						    {
							    //PRODUSUL NU ESTE IN magazie_stoc; IL INTRODUCEM
							    $denumire = mysql_real_escape_string($magrow['denumire']);
							    $cantitate = $magrow['cantitate'];
							    $unit_mas = $magrow['unit_mas'];
							    $furnizor = $magrow['furnizor'];
							    $magazie = $magrow['magazie'];
							    $grupa_mat = $magrow['grupa_mat'];
							    $observatii = $magrow['observatii'];
							    $pret = $magrow['pret'];
							    if($pret > 1000) $cantitate = rand(5,20);
							    else if($pret >= 500 && $pret <= 1000) $cantitate = rand(20,100);
							    else if($pret >= 50 && $pret < 500) $cantitate = rand(50,300);
							    else if($pret >= 1 && $pret < 50) $cantitate = rand(100,500);
							    else $cantitate = rand(200,1000);
								$magadd = "INSERT INTO `magazie_stoc` VALUES('','$denumire','$cantitate','$unit_mas','$furnizor','$magazie','$cod_sap','$grupa_mat','$pret','Added $datetime')";
								if($addrun = mysql_query($magadd))
								{
									$nrcrt++;
								    echo '<TR CLASS = "ROW"><TD>'.$nrcrt.'</TD><TD>'.$cod_sap.'</TD><TD>'.$denumire.'</TD><TD>'.$cantitate.'</TD><TD>'.$unit_mas.'</TD><TD>'.$magazie.'</TD><TD>'.$grupa_mat.'</TD><TD>'.$pret.'</TD><TD>'.$furnizor.'</TD><TD>'.$observatii.'</TD>';
								}
                                else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED; WIDTH: 400px; BORDER: 3px SOLID BLACK; OVERFLOW-WRAP: BREAK-WORD;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error().'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
						    }
					    }
					    else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error().'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
				    }
				}
				else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>Something is not right!<BR>Table magazie is EMPTY!<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
            }
		    else echo '<DIALOG OPEN ID = "errdia" STYLE = "COLOR: WHITE; BACKGROUND-COLOR: RED; WIDTH: 400px; BORDER: 3px SOLID BLACK; OVERFLOW-WRAP: BREAK-WORD;">MYSQL ERROR!!<BR>'.__LINE__.'. '.__FILE__.'<BR>'.mysql_error().'<BR><BUTTON CLASS = "OK" ID = "cancel" ONCLICK = "closeDialog()"><B>OK</BUTTON><DIALOG>';
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
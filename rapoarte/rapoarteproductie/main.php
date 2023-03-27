<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <?php

		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/form.reading.php';

	?>
    <STYLE>
        .rapoarte
		{
		    BACKGROUND-COLOR: RGBA(237,28,36);
		}
		.check
		{
			FLOAT: RIGHT;
			DISPLAY: BLOCK;
	  		POSITION: RELATIVE;
	  		CURSOR: POINTER;
	  		FONT-SIZE: 1.5vw;
	  		USER-SELECT: NONE;
		}
		.check input
		{
  		    POSITION: ABSOLUTE;
  			OPACITY: 0;
  			CURSOR: POINTER;
  			HEIGHT: 0;
  			WIDTH: 0;
        }
        .checkmark 
		{
  		    POSITION: ABSOLUTE;
  			RIGHT: 0;
  			HEIGHT: 1.8vw;
  			WIDTH: 1.8vw;
  			BACKGROUND-COLOR: WHITE;
  			BORDER: 1px SOLID BLACK;
        }
        .check:hover input ~ .checkmark 
		{
  		    BACKGROUND-COLOR: #CCC;
        }
        .container input:checked ~ .checkmark 
		{
  		    BACKGROUND-COLOR: #67FF75;
        }
        .checkmark:after 
		{
	  		CONTENT: "";
	  		POSITION: ABSOLUTE;
	  		DISPLAY: NONE;
		}
		.check input:checked ~ .checkmark:after
		{
	 	    DISPLAY: BLOCK;
		}
		.container .checkmark:after 
		{
		    LEFT: 0.2vw;
		  	TOP: -0.25vw;
		  	WIDTH: 1.2vw;
		  	HEIGHT: 1.2vw;
		  	BORDER: SOLID WHITE;
		  	BORDER-WIDTH: 0 0.3vw 0.3vw 0;
		  	TRANSFORM: ROTATE(45deg);
		}
    </STYLE>
	<SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
	<SCRIPT src='/ramira/magazie/rapoarte/rapoarteproductie/scripts.js'></SCRIPT>
</HEAD>

<BODY>
    <DIV CLASS = "container">
        <?php
        global $marca;
        $amount = (string) $amount;
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
		?>
		
	   <DIV CLASS = "LEFT_BAR"><BR><BR>
	       <DIV STYLE = "WIDTH: 50%; MARGIN: 0 AUTO; FLOAT: NONE; DISPLAY: NONE;">Sectia: <SPAN ID = "sectieDISPLAY"><SCRIPT>grabUserSector();</SCRIPT></SPAN></DIV><BR>
			<BUTTON ID = "displayORDERS" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;" ONCLICK = "productionDISPLAY(this.id)">Afisare comenzi</BUTTON><BR><BR>
			<BUTTON ID = "displayWORKERS" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw; MARGIN-TOP: 1VH;" ONCLICK = "productionDISPLAY(this.id)">Afisare angajati</BUTTON><BR><BR>
			<BUTTON ID = "displayMACHINES" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw; MARGIN-TOP: 1VH;" ONCLICK = "productionDISPLAY(this.id)">Afisare utilaje</BUTTON><BR><BR>
			<BUTTON ID = "updateORDERS" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw; MARGIN-TOP: 1VH; DISPLAY: NONE;" ONCLICK = "productionDISPLAY(this.id)">Update Comenzi</BUTTON><BR><BR>
			<BUTTON ID = "updateWORKERS" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw; MARGIN-TOP: 1VH; DISPLAY: NONE;" ONCLICK = "productionDISPLAY(this.id)">Update Angajati</BUTTON><BR><BR>
	       
	   	</DIV>
	   	<DIV ID = "bonMagazie" CLASS = "bon_magazie">
	       <IFRAME ID = "bonFRAME" SRC = "/ramira/magazie/rapoarte/rapoarteproductie/display.init.php" CLASS = "bon_magazie_frame" STYLE = "BACKGROUND-COLOR: RGB(0, 0, 0);"></IFRAME>
       	</DIV>
		   
	   	
    </DIV>
	<DIV ID = "noACCESS" CLASS = "confModal" STYLE = "WIDTH: 50vw; HEIGHT: 40vh; BACKGROUND-COLOR: GRAY ; BORDER-RADIUS: 20px; BORDER: 2px SOLID BLACK; POZITION: FIXED; MARGIN: 0 AUTO; MARGIN-TOP: 25vh; MARGIN-LEFT: 25vw; DISPLAY: NONE; OVERFLOW: NONE;">
			<BR><BR><P STYLE = "MARGIN: 0 AUTO; MARGIN-TOP: 5vh; WIDTH: 100%; FONT-SIZE: 2vw; TEXT-ALIGN: CENTER;">Ne pare rau, dar nu aveti acces la aceasta sectiune!</P><BR><BR>
			<P STYLE = "MARGIN: 0 AUTO; WIDTH: 90%; TEXT-ALIGN: CENTER;">Daca considerati ca aceasta este o greseala, va rugam, contactati administratorul!</P>
		</DIV>
    
    <SCRIPT src='/ramira/magazie/rapoarte/rapoarteproductie/scripts.js'></SCRIPT>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			display_ct();
		}
    </SCRIPT>

</BODY>
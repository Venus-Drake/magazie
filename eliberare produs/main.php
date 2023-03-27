<HTML>

<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <?php

		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/form.reading.php';

	?>
    <STYLE>
        .eliberareprod
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
</HEAD>

<BODY>
    <DIV CLASS = "container">
        <?php
        global $marca;
        global $product;
        global $furnizor;
        global $stornoAmount;
        global $observatii;
        $amount = (string) $amount;
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
		?>
	   <DIV CLASS = "LEFT_BAR"><BR><BR>
	       <TABLE BORDER = 0 WIDTH = 95% ALIGN = CENTER STYLE = "FONT-SIZE: 1.5vw; FONT-WEIGHT: BOLD;">
	           <TD STYLE = "TEXT-ALIGN: RIGHT;" WIDTH = 35%>Marca angajat:&nbsp&nbsp&nbsp</TD>
	           <TD  STYLE = "TEXT-ALIGN: LEFT;" VALIGN = CENTER WIDTH = 65%>
			       <BR><INPUT CLASS = "rekrow" LIST = "marci" TYPE = "text" ID = "rekrow" NAME = "rekrow" ONKEYUP = "findworker()" ONKEYDOWN = "keyCHECK()" ONCHANGE = "moveON()" VALUE = "<?php echo $marca; ?>" PLACEHOLDER = "MARCA" AUTOSUGEST = OFF></INPUT>
          	   	       <DATALIST ID = "marci" HEIGHT = 250px WIDTH = 150px></DATALIST>
    			   <BR><INPUT TYPE = "TEXT" ID = "nameResults" NAME = "nume_angajat" LIST = "numeworker" CLASS = "rekrown" ONKEYUP = "findworkerbyname()" ONKEYDOWN = "keyCHECK()"  ONCHANGE = "moveON()" STYLE = "FONT-SIZE: 1.2vw; HEIGHT: 1.3vw; MARGIN-TP: 0.5vh; WIDTH: 20vw;" VALUE = "<?php echo $worker;?>" PLACEHOLDER = "NUME ANGAJAT"></INPUT>
			           <DATALIST ID = "numeworker" HEIGHT = 250px WIDTH = 150px></DATALIST>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT;">
			       <DIV STYLE = "WIDTH: 100%;">Produs eliberat:&nbsp&nbsp&nbsp</DIV>
			       <DIV STYLE = "WIDTH: 50%; MARGIN: 0 AUTO; TEXT-ALIGN: CENTER;"><INPUT NAME = "autoINPUT" STYLE = "WIDTH: 1vw; HEIGHT: 1vw;" TYPE = "RADIO" ID = "autoOFF" CHECKED = "true"></INPUT></DIV>
				   <DIV STYLE = "WIDTH: 50%; MARGIN: 0 AUTO; TEXT-ALIGN: CENTER;"><INPUT NAME = "autoINPUT" STYLE = "WIDTH: 1vw; HEIGHT: 1vw;" TYPE = "RADIO" ID = "autoON" ONCHANGE = "setAUTO();"></INPUT></DIV>
                   <DIV STYLE = "WIDTH: 50%; MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; FONT-SIZE: 0.9VW; MARGIN-TOP: 0.2vh;">Auto OFF&nbsp&nbsp&nbsp</DIV>
				   <DIV STYLE = "WIDTH: 50%; MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; FONT-SIZE: 0.9VW; MARGIN-TOP: 0.2vh;">Auto ON&nbsp&nbsp&nbsp</DIV>
	           </TD>
			   <TD STYLE = "TEXT-ALIGN: LEFT;">
      		       <BR><INPUT ID = "product" CLASS = "product" LIST = "results" NAME = "product"  ONKEYDOWN = "keyCHECK()" ONKEYUP = "findproduct()" ONCHANGE = "updateprod()" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw;" PLACEHOLDER = "COD SAP" VALUE = "<?php echo $SAPcode; ?>"></INPUT>&nbsp&nbsp&nbsp
      		           <DATALIST ID = "results" HEIGHT = 250px WIDTH = 100px STYLE = "BACKGROUND-COLOR: YELLOW;"></DATALIST>
      			       <SELECT ID = "size" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw; COLOR: <?php if($size == '') echo '#696969'; else echo 'BLACK';?>" ONCHANGE = "colorChange()">
				           <OPTION VALUE = "<?php echo $size;?>"><?php if($size == '') echo 'DETALIU'; else echo $size;?></OPTION>
					   </SELECT>
					   <LABEL CLASS = "CHECK"><FONT STYLE = "FONT-SIZE: .9vw;">Storno?</FONT>&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE = "CHECKBOX" ID = "RETURN" ONCLICK = "stornoprod()"></INPUT><SPAN CLASS="CHECKMARK"></SPAN></LABEL><BR>
	              <INPUT TYPE = "text" ID = "productName" STYLE = "FONT-SIZE: 0.6vw; FONT-WEIGHT: BOLD; WIDTH: 20vw; HEIGHT: 1.3vw;" value = "<?php echo $product;?>" READONLY PLACEHOLDER = "DENUMIRE PRODUS" TITLE = "<?php echo $product;?>"></INPUT><BR>
	       		  <INPUT TYPE = "text" NAME = "furnizor" STYLE = "FONT-SIZE: 0.6vw; FONT-WEIGHT: BOLD; WIDTH: 20vw;" ID = "furnizor" READONLY PLACEHOLDER = "FURNIZOR" VALUE = "<?php echo $furnizor;?>" TITLE = "<?php echo $furnizor;?>"></INPUT>
	            </TD><TR STYLE = "VISIBILITY: COLLAPSE" ID = "stornoField">
	            <TD STYLE = "TEXT-ALIGN: RIGHT;" ID = "stornoText">Produs returnat:&nbsp&nbsp&nbsp</TD>
                <TD STYLE = "TEXT-ALIGN: LEFT;" ID = "stornoInput">
		            <SELECT ID = "stornoOption" NAME = "stornoOption" STYLE="FONT-SIZE:1.3vw; WIDTH: 8vw;">
                        <OPTION VALUE = "Usor uzat">Usor uzat</OPTION>
		       		    <OPTION VALUE = "Reascutire">Reascutire</OPTION>
		       		    <OPTION VALUE = "Casare">Casare</OPTION>
				    </SELECT>
				    <INPUT TYPE = "TEXT" NAME = "stornoAmount" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" VALUE = <?php echo $stornoAmount;?>></INPUT>&nbsp&nbsp
				    <INPUT CLASS = "units" TYPE = "TEXT" STYLE="FONT-SIZE:1.3vw; WIDTH: 5vw;" READONLY PLACEHOLDER = "U.M." VALUE = "<?php echo $units;?>"></INPUT>
		        </TD><TR STYLE = "VISIBILITY: COLLAPSE" ID = "uzura">
	            <TD STYLE = "TEXT-ALIGN: RIGHT; FONT-SIZE: .6VW">Produs uzat disponibil!<BR>(bifati casuta alaturata, daca eliberati produsul uzat)</TD>
	            <TD STYLE = "TEXT-ALIGN: LEFT;">
		      	    <INPUT TYPE = "CHECKBOX" STYLE = "WIDTH: 1.5VW; HEIGHT: 1.5VW;" NAME = "uzura"></INPUT>
		        </TD><TR>
	           	<TD STYLE = "TEXT-ALIGN: RIGHT;">Stoc magazie:&nbsp&nbsp&nbsp</TD>
	           	<TD STYLE = "TEXT-ALIGN: LEFT;">
		      	    <INPUT ID = "stock" NAME = "stock" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" VALUE = "<?php echo $stock; ?>" READONLY></INPUT>
				  	<INPUT CLASS = "units" TYPE = "text" STYLE="font-size:0.9vw; font-weight: bold; WIDTH: 5.3vw; background-color: transparent; border: 0vw;" VALUE = "<?php echo $units; ?>" READONLY></INPUT><FONT SIZE = 5>
     		    </TD><TR>
       			<TD STYLE = "TEXT-ALIGN: RIGHT;">Cantitate:&nbsp&nbsp&nbsp</TD>
       			<TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "amount" NAME = "amount" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" ONKEYDOWN = "keyCHECK();" VALUE = "<?php echo $amount; ?>" TITLE = "<?php echo $amount; ?>" REQUIRED></INPUT>
				      <INPUT ID = "units" CLASS = "units" TYPE = "text" STYLE="font-size:0.9vw; font-weight: bold; WIDTH: 5.3vw; background-color: transparent; border: 0vw;" VALUE = "<?php echo $units; ?>" READONLY></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Gestionar:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "nume" NAME = "nume" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 20vw;" VALUE = "<?php echo $nume; ?>" READONLY></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Observatii:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "observatii" NAME = "observatii" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 20vw;" VALUE = "<?php echo $observatii;?>" TITLE = "<?php echo $observatii;?>" PLACEHOLDER = "OBSERVATII"></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Actiune:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <SELECT ONKEYDOWN = "keyCHECK();" ID = "action" NAME = "action" STYLE="font-size: 1.3vw; BACKGROUND-COLOR: #67FF75; WIDTH: 7vw">
	  			          <OPTION WIDTH = 100 VALUE = "Adauga">Adauga</OPTION>
	              		  <OPTION WIDTH = 100 VALUE = "Sterge">Sterge</OPTION>
	                	  <OPTION WIDTH = 100 VALUE = "Anuleaza">Anuleaza</OPTION>
					  </SELECT>
			   </TD><TR>

	       </TABLE>
	       <DIV ID = "produsUZATfield" STYLE = "BORDER-BOTTOM-LEFT-RADIUS: 20px; BORDER-BOTTOM-RIGHT-RADIUS: 20px; BORDER: 2px SOLID RGBA(0,73,123); WIDTH: 35vw; HEIGHT: 30vh; BACKGROUND-COLOR: WHITE; MARGIN-LEFT: 2vw; POSITION: FIXED; TOP: 38%; COLOR: BLACK; FONT-SIZE: 1VW; DISPLAY: NONE;">
	           <span ID = "uzuraCLOSE" CLASS = "close" STYLE = "FLOAT: RIGHT; TEXT-ALIGN: RIGHT; MARGIN-RIGHT: 1vw; FONT-SIZE: 1vw;" ONCLICK = "closeUZURA();">&#187;&#187;&#187;</span><BR>
	           <CENTER>Produs uzat disponibil</CENTER><BR>
	           <DIV STYLE = "WIDTH: 100%; MARGIN: 0 AUTO; OVERFLOW: AUTO; HEIGHT: 80%;">
		           <TABLE ID = "prodUZAT" STYLE = "WIDTH: 98%; MARGIN: 0 AUTO; MARGIN-TOP: 1VW; BORDER: 2px SOLID BLACK;">
		               <THEAD STYLE = "POSITION: STICKY; TOP = 0;">
		                   <TR><TH STYLE = "WIDTH: 10%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">Cod</TH>
						   <TH STYLE = "WIDTH: 30%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">Denumire</TH>
						   <TH STYLE = "WIDTH: 10%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">Cant.</TH>
						   <TH STYLE = "WIDTH: 5%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">UM</TH>
		                   <TH STYLE = "WIDTH: 10%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">Detalii</TH>
		                   <TH STYLE = "WIDTH: 25%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-RIGHT: 2px SOLID BLACK; BORDER-BOTTOM: 2px SOLID BLACK;">Uzura</TH>
		                   <TH STYLE = "WIDTH: 15%; TEXT-ALIGN: CENTER; TEXT-WEIGHT: BOLD; FONT-SIZE: .9VW; BORDER-BOTTOM: 2px SOLID BLACK;">Altele</TH>
					   </THEAD>
				   </TABLE>
			   </DIV>
		   </DIV>
	   </DIV>
	   <DIV ID = "bon_magazie" CLASS = "bon_magazie">
	       <IFRAME ID = "bonFRAME" SRC = "/ramira/magazie/eliberare produs/bon.magazie.php?nume=<?php echo $nume;?>&rekrow=<?php echo $marca?>&angajat=<?php echo $worker?>&sectia=<?php echo (string)$sectia?>" CLASS = "bon_magazie_frame"></IFRAME>
       </DIV>
    </DIV>
    
    <SCRIPT src='/ramira/magazie/eliberare produs/eliberare.script.js'></SCRIPT>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			var rek = document.getElementById('rekrow').value;
			var prod = document.getElementById('product').value;
			var amount = document.getElementById('amount').value;
			if(rek == ''){ document.getElementById('rekrow').focus();}
			else if(prod == ''){ document.getElementById('product').focus();}
			else if(amount == ''){ document.getElementById('amount').focus();}
			else
			{
				document.getElementById('product').focus();
				document.getElementById('product').select();
			}
			display_ct();
		}
		function colorChange()
		{
		    document.getElementById('size').style.color = 'BLACK';
		}
    </SCRIPT>

</BODY>
</HTML>
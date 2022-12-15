<HTML>
<HEAD>
    <link rel="stylesheet" href="/ramira/magazie/styles.css">
    <STYLE>
        .stornoprod
        {
		    background-color: RGBA(237,28,36);
        }
        .formPOP
        {
		    WIDTH: 80%; 
			HEIGHT: 0;
			MARGIN-LEFT: 10vw; 
			MARGIN-TOP: 1.8vw; 
			BACKGROUND-COLOR: RGBA(1,1,1);
			COLOR: RGB(102,252,3); 
			DISPLAY: NONE;
			POSITION: FIXED; 
			BORDER: 1PX SOLID RGB(102,252,3);
			BORDER-RADIUS: 20px;
			TEXT-ALIGN: CENTER;
			ANIMATION: POP-LOAD 0.2s FORWARDS,
                       BORDER-BLINK 0.75s INFINITE LINEAR;
        }
        .formPOPtable
        {
			WIDTH: 98%;
			MARGIN: 0 AUTO;
		    BORDER: 1px SOLID RGB(102,252,3);
			COLOR: RGB(102,252,3);
			FONT-SIZE: 1vw;
        }
        .formPOPtable tr:not(:first-child)
		{
		    cursor: pointer; 
			transition: all .15s ease-in-out;
		}
		@KEYFRAMES POP-LOAD
		{
		    FROM{HEIGHT: 0%; MARGIN-TOP: 19vw;}
		    TO{HEIGHT: 80%; MARGIN-TOP: 1.8vw;}
		}
		@KEYFRAMES BORDER-BLINK
		{
		    FROM { BORDER-COLOR: TRANSPARENT; }
      		TO { BORDER-COLOR: RGBA(102.252.3); }
		}
		.formPOPtable tr:not(:first-child):hover
		{
			background-color: RGB(102,252,3,.5);
		}
    </STYLE>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
</HEAD>

<BODY>
<?php
    
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/form.reading.php';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
$SAPcode = (string) $SAPcode;
$product = (string) $product;
$furnizor = (string) $furnizor;
$observatii = (string) $observatii;
$action = (string) $action;

?>


<DIV CLASS = "container">
    <DIV CLASS = "formPOP" ID = "formPOP">
        <span ID = "POPclose" CLASS = "close" STYLE = "POSITION: FIXED; MARGIN-LEFT: 36vw; COLOR: RGB(102,252,3);">&#187;&#187;&#187;</span>
        <BR><BR>
        <DIV STYLE = "OVERFLOW: AUTO; WIDTH: 100%; HEIGHT: 85%">
	        <TABLE CLASS = "formPOPtable" ID = "formPOPtable">
	            <THEAD STYLE = "POSITION: STICKY; TOP: 0;">
	                <TR>
	                <TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Nr. Crt</TH>
					<TH WIDTH = 15% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Produs</TH>
					<TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Cod SAP</TH>
					<TH WIDTH = 10% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Serie declaratie</TH>
					<TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Cantitate</TH>
					<TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">U.M.</TH>
					<TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Pret</TH>
					<TH WIDTH = 10% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Furnizor</TH>
					<TH WIDTH = 5% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Motiv</TH>
					<TH WIDTH = 15% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Observatii</TH>
					<TH WIDTH = 7% STYLE = "BORDER: 1px SOLID RGB(102,252,3); FONT-SIZE: 1vw;">Data limita</TH>
				    </TR>
	            </THEAD>
	        </TABLE>
        </DIV>
	</DIV>
	   <DIV CLASS = "LEFT_BAR"><BR><BR>
	       <TABLE BORDER = 0 WIDTH = 95% ALIGN = CENTER STYLE = "FONT-SIZE: 1.4vw; FONT-WEIGHT: BOLD;">
	           <TD STYLE = "TEXT-ALIGN: RIGHT;" WIDTH = 35%>Marca angajat:&nbsp&nbsp&nbsp</TD>
	           <TD  STYLE = "TEXT-ALIGN: LEFT;" VALIGN = CENTER WIDTH = 65%>
	               <BR><FORM ID = "worker_form_storno" ACTION = "" METHOD = "POST" ALIGN = LEFT VALIGN = CENTER>
	                   <INPUT CLASS = "rekrow" LIST = "marciStorno" TYPE = "text" ID = "rekrowStorno" NAME = "rekrowStorno" ONKEYUP = "findworkerStorno()" ONCHANGE = "this.form.submit()" VALUE = "<?php echo $marca; ?>" PLACEHOLDER = "NR. MARCA" AUTOSUGEST = OFF></INPUT><BR>
       		           	   <DATALIST ID = "marciStorno" HEIGHT = 250px WIDTH = 150px>
				   	       </DATALIST>
	   	               <INPUT TYPE = "TEXT" ID = "nameResultsStorno" NAME = "nume_angajat" LIST = "numeworkerStorno" CLASS = "rekrownStorno" ONKEYUP = "findworkerbynameStorno()"  ONCHANGE = "updateformStorno()" STYLE = "FONT-SIZE: 1.2vw; HEIGHT: 1.3vw; WIDTH: 20vw;" VALUE = "<?php echo $worker;?>" PLACEHOLDER = "NUME ANGAJAT"></INPUT><BR>
           			       <DATALIST ID = "numeworkerStorno" HEIGHT = 250px WIDTH = 150px>
				   	   	   </DATALIST>
	   	   	       </FORM>
	   	       </TD><TR>
	   	       <TD STYLE = "TEXT-ALIGN: RIGHT;">Produs returnat:&nbsp&nbsp&nbsp</TD>
	   	       <TD STYLE = "TEXT-ALIGN: LEFT;">
			       <FORM ACTION = "" METHOD = "POST" ID = "product_form_storno" ALIGN = LEFT>
				       <BR><INPUT ID = "productStorno" CLASS = "product" LIST = "resultsStorno" NAME = "product"  ONKEYUP = "findproductStorno()" ONCHANGE = "updateprodStorno()" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw;" PLACEHOLDER = "COD SAP" VALUE = "<?php echo $SAPcode; ?>"></INPUT>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				       <DATALIST ID = "resultsStorno" HEIGHT = 250px WIDTH = 100px STYLE = "BACKGROUND-COLOR: YELLOW;">
					   </DATALIST>
				       <SELECT ID = "size" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw; COLOR: <?php if($size == '') echo '#696969'; else echo 'BLACK';?>" ONCHANGE = "colorChange()">
				           <OPTION VALUE = "<?php echo $size;?>"><?php if($size == '') echo 'MARIME'; else echo $size;?></OPTION>
					   </SELECT>
					   <INPUT TYPE = "text" ID = "productNameStorno" STYLE = "FONT-SIZE: .6vw; WIDTH: 20vw; HEIGHT: 1.3vw;" value = "<?php echo $product;?>" READONLY PLACEHOLDER = "DENUMIRE PRODUS" TITLE = "<?php echo $product;?>"></INPUT>
					   <INPUT TYPE = "text" NAME = "furnizor" STYLE = "FONT-SIZE: .6vw; WIDTH: 20vw;" ID = "furnizorStorno" READONLY PLACEHOLDER = "FURNIZOR" VALUE = "<?php echo $furnizor;?>" TITLE = "<?php echo $furnizor;?>"></INPUT><BR>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT; WHITE-SPACE: NOWRAP;">Motivul imprumutului:&nbsp&nbsp&nbsp</TD>
	           <TD STYLE = "TEXT-ALIGN: LEFT;">
	               <INPUT TYPE = "TEXT" NAME = "motiv" ID = "motivStorno" STYLE="font-size: 1.3vw; WIDTH: 12vw" READONLY PLACEHOLDER = "MOTIV IMPRUMUT"></INPUT>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT;">Data limita:&nbsp&nbsp&nbsp</TD>
	           <TD STYLE = "TEXT-ALIGN: LEFT;">
	               <INPUT ID = "dataEnd" NAME = "dataEnd" ONCHANGE = "formatDateSTORNO()" TYPE = "TEXT" STYLE="font-size:1.3vw; WIDTH: 9.3vw; HEIGHT: 2vw; BORDER: 1px SOLID BLACK; BORDER-RADIUS: 5px;" VALUE = "<?php echo $date;?>" READONLY></INPUT>
               </TD><TR>
               <TD STYLE = "TEXT-ALIGN: RIGHT;">Stare produs:&nbsp&nbsp&nbsp</TD>
               <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <SELECT ID = "stockStorno" NAME = "stock" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 9.3vw;" VALUE = "<?php echo $stock; ?>" READONLY>
				          <OPTION VALUE = "casabil">Casabil</OPTION>
				          <OPTION VALUE = "reutilizabil">Reutilizabil</OPTION>
				          <OPTION VALUE = "uzat">Uzat</OPTION>
					  </SELECT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Cantitate:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "amountStorno" NAME = "amount" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" VALUE = "<?php echo $amount; ?>" TITLE = "<?php echo $amount; ?>" REQUIRED></INPUT>
				      <INPUT ID = "unitsStorno" CLASS = "unitsStorno" TYPE = "text" STYLE="font-size:0.9vw; font-weight: bold; WIDTH: 5.3vw; background-color: transparent; border: 0vw;" VALUE = "<?php echo $units; ?>" READONLY></INPUT>
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
				      <INPUT ID = "rekrowStorno" NAME = "rekrowStorno" TYPE = "text" VALUE = "<?php echo $marca; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "nume_angajat" NAME = "nume_angajat" TYPE = "text" VALUE = "<?php echo $worker; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "date" NAME = "date" TYPE = "text" VALUE = "<?php echo $date; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "sectia" NAME = "sectia" TYPE = "text" VALUE = "<?php echo $sectia; ?>" HIDDEN = "hidden"></INPUT>
				      <SELECT ONCHANGE = "this.form.submit()" ID = "action" NAME = "action" TYPE = "submit" STYLE="font-size: 1.3vw; BACKGROUND-COLOR: #67FF75; WIDTH: 7vw">
				          <OPTION WIDTH = 100 VALUE = "<?php echo $action;?>"><?php echo $action;?></OPTION>
	  			          <OPTION WIDTH = 100 VALUE = "Adauga">Adauga</OPTION>
	              		  <OPTION WIDTH = 100 VALUE = "Sterge">Sterge</OPTION>
	                	  <OPTION WIDTH = 100 VALUE = "Anuleaza">Anuleaza</OPTION>
					  </SELECT>
                  </FORM>
			   </TD><TR>
	       </TABLE>
	   </DIV>
	   <DIV CLASS = "bon_magazie">
	       <IFRAME SRC = "/ramira/magazie/storno/declaratie.storno.php?nume=<?php echo $nume;?>&rekrow=<?php echo $marca?>&angajat=<?php echo $worker?>&sectia=<?php echo $sectia?>" CLASS = "bon_magazie_frame"></IFRAME>
       </DIV>
    </DIV>

    <SCRIPT src='/ramira/magazie/storno/storno.script.js'></SCRIPT>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			var rekStorno = document.getElementById('rekrowStorno').value;
			var prodStorno = document.getElementById('productStorno').value;
			var amStorno = document.getElementById('amountStorno').value;
			if(rekStorno == ''){ document.getElementById('rekrowStorno').focus();}
			else if(prodStorno == ''){ document.getElementById('productStorno').focus();}
			else if(amStorno == '0' || document.getElementById('amountStorno').style.backgroundColor == "red")
			{ 
				document.getElementById('amountStorno').focus();
				document.getElementById('amountStorno').select();
			}
			else
			{
				document.getElementById('productStorno').focus();
				document.getElementById('productStorno').select();
			}
			display_ct();
		}
		document.getElementById("POPclose").onclick = function()
		{
			var POProws = document.getElementById("formPOPtable").rows.length;
			document.getElementById("formPOP").style.display = "none";
			for(var i = POProws - 1; i > 0; i--)
			{
			    document.getElementById("formPOPtable").deleteRow(i);
			}
		}
    </SCRIPT>
</BODY>
</HTML>
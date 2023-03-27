<HTML>

<HEAD>
    <link rel="stylesheet" href="/ramira/magazie/styles.css">
    <STYLE>
        .imprumutprod
        {
		    background-color: RGBA(237,28,36);
        }
    </STYLE>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
</HEAD>

<BODY>

<?php
    
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/form.reading.php';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
	$date = (string) $date;
$nume = (string) $nume;
	

?>

<DIV CLASS = "container">
	   <DIV CLASS = "LEFT_BAR"><BR><BR>
	       <TABLE BORDER = 0 WIDTH = 95% ALIGN = CENTER STYLE = "FONT-SIZE: 1.4vw; FONT-WEIGHT: BOLD;">
	           <TD STYLE = "TEXT-ALIGN: RIGHT;" WIDTH = 35%>Marca angajat:&nbsp&nbsp&nbsp</TD>
	           <TD  STYLE = "TEXT-ALIGN: LEFT;" VALIGN = CENTER WIDTH = 65%>
			       <BR><FORM ID = "worker_form_imprumut" ACTION = "" METHOD = "POST" ALIGN = LEFT VALIGN = CENTER>
          		       <INPUT CLASS = "rekrow" LIST = "marciImprumut" TYPE = "text" ID = "rekrowImprumut" NAME = "rekrowImprumut" ONKEYUP = "findworkerImprumut()" ONCHANGE = "this.form.submit()" VALUE = "<?php echo $marca; ?>" PLACEHOLDER = "NR. MARCA" AUTOSUGEST = OFF></INPUT><BR>
       		           	   <DATALIST ID = "marciImprumut" HEIGHT = 250px WIDTH = 150px>
				   	       </DATALIST>
           			   <INPUT TYPE = "TEXT" ID = "nameResultsImprumut" NAME = "nume_angajat" LIST = "numeworkerImprumut" CLASS = "rekrownImprumut" ONKEYUP = "findworkerbynameImprumut()"  ONCHANGE = "updateformImprumut()" STYLE = "FONT-SIZE: 1.2vw; HEIGHT: 1.3vw; WIDTH: 20vw;" VALUE = "<?php echo $worker;?>" PLACEHOLDER = "NUME ANGAJAT"></INPUT><BR>
           			       <DATALIST ID = "numeworkerImprumut" HEIGHT = 250px WIDTH = 150px>
				   	   	   </DATALIST>
                   </FORM>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT;">Produs imprumutat:&nbsp&nbsp&nbsp</TD>
			   <TD STYLE = "TEXT-ALIGN: LEFT;">
			       <FORM ACTION = "" METHOD = "POST" ID = "product_form_imprumut" ALIGN = LEFT>
				       <BR><INPUT ID = "productImprumut" CLASS = "product" LIST = "resultsImprumut" NAME = "product"  ONKEYUP = "findproductImprumut()" ONCHANGE = "updateprodImprumut()" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw;" PLACEHOLDER = "COD SAP" VALUE = "<?php echo $SAPcode; ?>"></INPUT>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			           <DATALIST ID = "resultsImprumut" HEIGHT = 250px WIDTH = 100px STYLE = "BACKGROUND-COLOR: YELLOW;">
					   </DATALIST>
					   <SELECT ID = "size" TYPE = "text" STYLE="font-size: 1.3vw; WIDTH: 7vw; COLOR: <?php if($size == '') echo '#696969'; else echo 'BLACK';?>" ONCHANGE = "colorChange()">
				           <OPTION VALUE = "<?php echo $size;?>"><?php if($size == '') echo 'MARIME'; else echo $size;?></OPTION>
					   </SELECT>
          		       <INPUT TYPE = "text" ID = "productNameImprumut" STYLE = "FONT-SIZE: 0.6vw; WIDTH: 20vw; HEIGHT: 1.3vw;" value = "<?php echo (string)$product;?>" READONLY PLACEHOLDER = "DENUMIRE PRODUS" TITLE = "<?php echo (string)$product;?>"></INPUT>
          		       <INPUT TYPE = "text" NAME = "furnizor" STYLE = "FONT-SIZE: 0.6vw; WIDTH: 11.7vw; WIDTH: 20vw;" ID = "furnizorImprumut" READONLY PLACEHOLDER = "FURNIZOR" VALUE = "<?php echo (string)$furnizor;?>" TITLE = "<?php echo (string)$furnizor;?>"></INPUT><BR>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT; WHITE-SPACE: NOWRAP;">Motivul imprumutului:&nbsp&nbsp&nbsp</TD>
	           <TD STYLE = "TEXT-ALIGN: LEFT;">
	               <SELECT TYPE = "SUBMIT" NAME = "motiv" ID = "motivImprumut" STYLE="font-size: 1.3vw; WIDTH: 12vw">
	                   <OPTION WIDTH = 100 VALUE = "<?php echo (string)$motiv;?>"><?php echo (string)$motiv;?></OPTION>
  			           <OPTION WIDTH = 100 VALUE = "Uz temporar">Uz temporar</OPTION>
              		   <OPTION WIDTH = 100 VALUE = "Studiu">Studiu</OPTION>
                	   <OPTION WIDTH = 100 VALUE = "Instruire">Instruire</OPTION>
                	   <OPTION WIDTH = 100 VALUE = "Reascutire">Reascutire</OPTION>
				   </SELECT>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT;">Perioada:&nbsp&nbsp&nbsp</TD>
	           <TD STYLE = "TEXT-ALIGN: LEFT;">
	               <INPUT ID = "dataStart" NAME = "dataStart" TYPE = "TEXT" STYLE="font-size:1.3vw; WIDTH: 9.3vw; HEIGHT: 2vw; BORDER: 1px SOLID BLACK; BORDER-RADIUS: 5px;" VALUE = "<?php echo $date;?>" READONLY></INPUT>
	               <SELECT ID = "dataEnd" NAME = "dataEnd" ONCHANGE = "formatDate()" TYPE = "SUBMIT" STYLE="font-size:1.3vw; WIDTH: 10.3vw; BACKGROUND-COLOR: YELLOW; HEIGHT: 2.05vw; BORDER-RADIUS: 5px; BORDER: 1px SOLID BLACK;">
	                   <OPTION VALUE = "<?php if($endDate != 0) echo date('d M Y',strtotime($endDate));?>" ID = "dataDisplay" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;"><?php if($endDate != 0) echo date('d M Y',strtotime($endDate));?></OPTION>
	                   <OPTION VALUE = "+1 day" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">1 ZI</OPTION>
	                   <OPTION VALUE = "+2 days" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">2 ZILE</OPTION>
	                   <OPTION VALUE = "+3 days" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">3 ZILE</OPTION>
	                   <OPTION VALUE = "+4 days" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">4 ZILE</OPTION>
	                   <OPTION VALUE = "+5 days" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">5 ZILE</OPTION>
	                   <OPTION VALUE = "+1 week" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">1 SAPTAMANA</OPTION>
	                   <OPTION VALUE = "+2 weeks" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">2 SAPTAMANI</OPTION>
	                   <OPTION VALUE = "+3 weeks" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">3 SAPTAMANI</OPTION>
	                   <OPTION VALUE = "+1 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">1 LUNA</OPTION>
	                   <OPTION VALUE = "+2 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">2 LUNI</OPTION>
	                   <OPTION VALUE = "+3 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">3 LUNI</OPTION>
	                   <OPTION VALUE = "+4 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">4 LUNI</OPTION>
	                   <OPTION VALUE = "+5 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">5 LUNI</OPTION>
	                   <OPTION VALUE = "+6 month" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">6 LUNI</OPTION>
	                   <OPTION VALUE = "+1 year" STYLE = "HEIGHT: 1vw; FONT-SIZE: .9vw;">1 AN</OPTION>
				   </SELECT>
	           </TD><TR>
	           <TD STYLE = "TEXT-ALIGN: RIGHT;">Stoc magazie:&nbsp&nbsp&nbsp</TD>
	           <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "stockImprumut" NAME = "stock" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" VALUE = "<?php echo $stock; ?>" READONLY></INPUT>
				      <INPUT ID = "unitsImprumut" CLASS = "unitsImprumut" TYPE = "text" STYLE="font-size:0.9vw; font-weight: bold; WIDTH: 5.3vw; background-color: transparent; border: 0vw;" VALUE = "<?php echo $units; ?>" READONLY></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Cantitate:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "amountImprumut" NAME = "amount" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 5.3vw;" VALUE = "<?php echo $amount; ?>" TITLE = "<?php echo $amount; ?>" REQUIRED></INPUT>
				      <INPUT ID = "unitsImprumut" CLASS = "unitsImprumut" TYPE = "text" STYLE="font-size:0.9vw; font-weight: bold; WIDTH: 5.3vw; background-color: transparent; border: 0vw;" VALUE = "<?php echo $units; ?>" READONLY></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Gestionar:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "nume" NAME = "nume" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 20vw;" VALUE = "<?php echo $nume; ?>" READONLY></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Observatii:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "observatii" NAME = "observatii" TYPE = "text" STYLE="font-size:1.3vw; WIDTH: 20vw;" VALUE = "<?php echo (string)$observatii;?>" TITLE = "<?php echo (string)$observatii;?>" PLACEHOLDER = "OBSERVATII"></INPUT>
		       </TD><TR>
		       <TD STYLE = "TEXT-ALIGN: RIGHT;">Actiune:&nbsp&nbsp&nbsp</TD>
		       <TD STYLE = "TEXT-ALIGN: LEFT;">
				      <INPUT ID = "rekrowImprumut" NAME = "rekrowImprumut" TYPE = "text" VALUE = "<?php echo $marca; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "nume_angajat" NAME = "nume_angajat" TYPE = "text" VALUE = "<?php echo $worker; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "date" NAME = "date" TYPE = "text" VALUE = "<?php echo $date; ?>" HIDDEN = "hidden"></INPUT>
				      <INPUT ID = "sectia" NAME = "sectia" TYPE = "text" VALUE = "<?php echo $sectia; ?>" HIDDEN = "hidden"></INPUT>
				      <SELECT ONCHANGE = "this.form.submit()" ID = "action" NAME = "action" TYPE = "submit" STYLE="font-size: 1.3vw; BACKGROUND-COLOR: #67FF75; WIDTH: 7vw">
				          <OPTION WIDTH = 100 VALUE = "<?php echo (string)$action;?>"><?php echo (string)$action;?></OPTION>
	  			          <OPTION WIDTH = 100 VALUE = "Adauga">Adauga</OPTION>
	              		  <OPTION WIDTH = 100 VALUE = "Sterge">Sterge</OPTION>
	                	  <OPTION WIDTH = 100 VALUE = "Anuleaza">Anuleaza</OPTION>
					  </SELECT>
                  </FORM>
			   </TD><TR>

	       </TABLE>
	   </DIV>
	   <DIV CLASS = "bon_magazie">
	       <IFRAME SRC = "/ramira/magazie/imprumuturi/bon.imprumut.php?nume=<?php echo $nume;?>&rekrow=<?php echo $marca?>&angajat=<?php echo $worker?>&sectia=<?php echo $sectia?>" CLASS = "bon_magazie_frame"></IFRAME>
       </DIV>
    </DIV>
    <SCRIPT src='/ramira/magazie/imprumuturi/imprumut.script.js'></SCRIPT>
    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			var rekImprumut = document.getElementById('rekrowImprumut').value;
			var prodImprumut = document.getElementById('productImprumut').value;
			var amImprumut = document.getElementById('amountImprumut').value;
			if(rekImprumut == ''){ document.getElementById('rekrowImprumut').focus();}
			else if(prodImprumut == ''){ document.getElementById('productImprumut').focus();}
			else if(amImprumut == '0' || document.getElementById('amountImprumut').style.backgroundColor == "red")
			{ 
				document.getElementById('amountImprumut').focus();
				document.getElementById('amountImprumut').select();
			}
			else
			{
				document.getElementById('productImprumut').focus();
				document.getElementById('productImprumut').select();
			}
			display_ct();
		}
    </SCRIPT>
    
</BODY>
</HTML>
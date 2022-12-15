<HTML>

<!
*AICI ELIBERAM PRODUSE DIN MAGAZIE CATRE ANGAJATI
*PENTRU ASTA: * VERIFICAM ANGAJATUL
			  * VERIFICAM DACA AVEM PRODUSUL PE STOC
			  * DACA AVEM PRODUSUL PE STOC, VERIFICAM FURNIZORUL, PRETUL ACESTUIA, ETC.
			  * ADAUGAM PRODUSUL IN STOCUL ANGAJATULUI
			  * SCOATEM PRODUSUL DIN STOCUL MAGAZIEI
			  * NE MULTUMIM FRUMOS PENTRU CA NE-AM DESCURCAT ATAT DE BINE :P:P
>

<HEAD>
    <STYLE>
        .eliberareprod
		{
		    BACKGROUND-COLOR: #B8913E;
		}
    </STYLE>
	<link rel="stylesheet" href="\ramira\magazie\styles.css">
</HEAD>

<BODY>

<?php

	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/form.reading.php';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/navigation.html';

?>

<DIV CLASS = "container">
	   <DIV CLASS = "LEFT_BAR">
	       <DIV STYLE = "WIDTH: 100%;">
	           <DIV CLASS = "DESCRIPTION" STYLE = "WIDTH: 32%; MARGIN-LEFT: 20px">
	               <BR>
	               Marca angajat:<BR><BR>
	               Produs eliberat:<BR><BR>
	               Stoc magazie:<BR><BR>
	               Cantitate:<BR><BR>
	               Gestionar:<BR><BR>
	               Actiune:
	           </DIV>
	           <DIV CLASS = "FORM" STYLE = "WIDTH: 65%;">
	               <BR>
	               <DIV STYLE = "WIDTH: 100%; FONT-SIZE: 40px">
				       <FORM ACTION = "" METHOD = "POST">
	          		       <INPUT CLASS = "rekrow" LIST = "marci" TYPE = "text" ID = "rekrow" NAME = "rekrow" ONKEYUP = "findworker()" ONCHANGE = "this.form.submit()" VALUE = "<?php echo $marca; ?>" PLACEHOLDER = "NR. MARCA" AUTOSUGEST = OFF></INPUT><BR>
       		           	   <DATALIST ID = "marci" HEIGHT = 250px WIDTH = 150px>
					   	   </DATALIST>
	           			   <INPUT TYPE = "TEXT" READONLY ID = "resultsS" CLASS = "rekrown" STYLE = "HEIGHT: 15px; WIDTH: 300px;" VALUE = "<?php echo $worker;?>" PLACEHOLDER = "NUME ANGAJAT"></INPUT>
	                   </FORM>
                   </DIV>
                   <DIV STYLE = "WIDTH: 100%; FONT-SIZE: 20px">
					   <FORM ACTION = "" METHOD = "POST" ID = "product_form">
				           <INPUT ID = "product" LIST = "results" NAME = "product"  ONKEYUP = "findproduct()" ONCHANGE = "this.form.submit()" TYPE = "text" STYLE="font-size:24; WIDTH: 150px;" PLACEHOLDER = "COD SAP" VALUE = "<?php echo $SAPcode; ?>"></INPUT><BR>
				           <DATALIST ID = "results" HEIGHT = 250px WIDTH = 100px STYLE = "BACKGROUND-COLOR: YELLOW;">
						   </DATALIST>
						   <INPUT NAME = "nume" TYPE = "text" VALUE = "<?php echo $nume; ?>" HIDDEN = "hidden"></INPUT>
				           <INPUT NAME = "rekrow" TYPE = "text" VALUE = "<?php echo $marca; ?>" HIDDEN = "hidden"></INPUT>
	          		       <INPUT TYPE = "text" ID = "productName" STYLE = "font-size: 15px; WIDTH: 350px; HEIGHT: 15px;" value = "<?php echo $product;?>" READONLY PLACEHOLDER = "DENUMIRE PRODUS" TITLE = "<?php echo $product;?>">
	                   </FORM>
                   </DIV>
                   <DIV STYLE = "WIDTH: 100%; FONT-SIZE: 20px">
					   <FORM ACTION = "" METHOD = "POST">
					      <INPUT ID = "stock" NAME = "stock" TYPE = "text" STYLE="font-size:24; WIDTH: 100px;" VALUE = "<?php echo $stock; ?>" READONLY></INPUT><FONT SIZE = 5><BR><BR>
					      <INPUT ID = "amount" NAME = "amount" TYPE = "text" STYLE="font-size:24; WIDTH: 100px;" VALUE = "<?php echo $amount; ?>" TITLE = "<?php echo $amount; ?>" REQUIRED></INPUT><BR><BR>
					      <INPUT ID = "nume" NAME = "nume" TYPE = "text" STYLE="font-size:24; WIDTH: 350px;" VALUE = "<?php echo $nume; ?>" READONLY></INPUT><BR><BR>
					      <INPUT ID = "rekrow" NAME = "rekrow" TYPE = "text" VALUE = "<?php echo $marca; ?>" HIDDEN = "hidden"></INPUT>
					      <INPUT ID = "product" NAME = "product" TYPE = "text" VALUE = "<?php echo $SAPcode; ?>" HIDDEN = "hidden"></INPUT>
					      <INPUT ID = "stock" NAME = "stoc" TYPE = "text" VALUE = "<?php echo $stock; ?>" HIDDEN = "hidden"></INPUT>
					      <INPUT ID = "angajat" NAME = "angajat" TYPE = "text" VALUE = "<?php echo $worker; ?>" HIDDEN = "hidden"></INPUT>
					      <INPUT ID = "date" NAME = "date" TYPE = "text" VALUE = "<?php echo $date; ?>" HIDDEN = "hidden"></INPUT>
					      <INPUT ID = "sectia" NAME = "sectia" TYPE = "text" VALUE = "<?php echo $sectia; ?>" HIDDEN = "hidden"></INPUT>
					      <SELECT ONCHANGE = "this.form.submit()" ID = "action" NAME = "action" TYPE = "text" WIDTH = 100 STYLE="font-size:24">
					          <OPTION WIDTH = 100 VALUE = "<?php echo $action;?>"><?php echo $action;?></OPTION>
		  			          <OPTION WIDTH = 100 VALUE = "Adauga">Adauga</OPTION>
		              		  <OPTION WIDTH = 100 VALUE = "Sterge">Sterge</OPTION>
		                	  <OPTION WIDTH = 100 VALUE = "Anuleaza">Anuleaza</OPTION>
						  </SELECT>
	                  </FORM>
                   </DIV>
               </DIV>
		  </DIV>
	   </DIV>
	   <DIV ID = "bon_magazie" CLASS = "bon_magazie">
	       <IFRAME SRC = "http://localhost/ramira/magazie/eliberare produs/bon.magazie.php?nume=<?php echo $nume;?>&rekrow=<?php echo $marca?>&angajat=<?php echo $worker?>&sectia=<?php echo $sectia?>" CLASS = "bon_magazie_frame"></IFRAME>
       </DIV>
    </DIV>
    
    <SCRIPT src='/ramira/magazie/eliberare produs/eliberare.script.js'></SCRIPT>
    <SCRIPT TYPE = "text/javascript">

        function noPRODUCT()
		{
 	        alert("Va rog, introduceti un produs valid!");
		}
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
		}
    </SCRIPT>

</BODY>
</HTML>
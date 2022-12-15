<HTML>
<HEAD>
    <link rel="stylesheet" href="/ramira/magazie/imprumuturi/styling.css">
    <STYLE>
  		THEAD
  		{ 
			DISPLAY:TABLE-HEADER-GROUP;
		}
  		.scrollableDIV
  		{
			PAGE-BREAK-INSIDE: AUTO;
  		}
        @PAGE
        {
			SIZE: A4;
		    MARGIN-LEFT: 2CM;
			MARGIN-BOTTOM: 1.5CM;
        }
    </STYLE>
</HEAD>
<BODY CLASS = "printableSPACE" ID = "printableSPACE">
<?php

	global $amount;global $proc;global $seria;
	
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
	
	$valtot = '0.00';
	$readVALBON = '0.00';
	$worker = 'NUME ANGAJAT';
	$marca = 'NR. MARCA';
	$sectia = '<font style = "text-decoration: underline dotted;"><i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSECTIA&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></font>';
	
	if(isset($_GET['nume']) && !empty($_GET['nume'])) $nume = $_GET['nume'];
	else $nume = "Unknown User";
	if(isset($_GET['angajat']) && !empty($_GET['angajat']))
	{
		$worker = $_GET['angajat'];     //NE ASIGURAM CA NU AVEM VREO COMANDA PE ALT NUME RAMASA DESCHISA
		//require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi\verificare.comenzi.php';
	}
	else if(empty($_GET['angajat']))    //VERIFICAM DACA AVEM, CUMVA, VREO COMANDA NEFINALIZATA RAMASA DIN URMA
	{
		//require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi\verificare.comenzi.php';
	}
	
	if(isset($_POST['action']) && !empty($_POST['action'])) $action = $_POST['action'];
	else $action = 'Adauga';
	if(isset($_POST['amount']) && !empty($_POST['amount'])) $amount = $_POST['amount'];
	if(isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'];
	else $date = date('d M Y', time());
	if(isset($_GET['rekrow']) && !empty($_GET['rekrow'])) $marca = $_GET['rekrow'];
	if(isset($_GET['sectia']) && !empty($_GET['sectia'])) $sectia = $_GET['sectia'];
	if(isset($_POST['endDate']) && !empty($_POST['endDate'])) $endDate = $_POST['endDate'];
	else $endDate = date('Y/m/d h:i:s',strtotime($date));
	//IN grab.seria.nr.php EXTRAGEM/ CREAM NUMARUL SERIEI BONULUI SI DATA LIMITA A BONULUI; ACEASTA VA FI DATA CEA MAI INAINTATA PANA LA CARE POATE FI ADUS UNUL DINTRE PRODUSELE DE PE BON; DATELE LIMITA ALE PRODUSELOR NU SE SCHIMBA; DOAR A BONULUI
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/grab.seria.php';

?>

<DIV STYLE = "WIDTH: 100%; MARGIN: 20px AUTO;">
    <DIV ID = "declarationINTRO" STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; BACKGROUND-COLOR: WHITE;">
        <IMG SRC = "logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
       	<B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">DECLARATIE PRIMIRE PRODUS RETURNAT<BR></FONT>Seria: <?php echo $seria;?></CENTER><BR><BR><BR><LEFT><FONT STYLE = "FONT-SIZE: 1.5VW">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Se primesc de la <?php if($worker != '' && $worker != 'NUME ANGAJAT')echo $worker; else if($worker == 'NUME ANGAJAT') echo '<font style = "text-decoration: underline dotted;"><i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNUME ANGAJAT&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></font>';else echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';?> (marca: <?php if($marca != '' && $marca != 'NR. MARCA') echo $marca; else if($marca == 'NR. MARCA') echo '<font style = "text-decoration: underline dotted;"><i>'.$marca.'</i></font>'; else echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';?>), angajat al sectiei <?php if($sectia != '') echo $sectia; else echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; ?>,  urmatoarele produse,care au fost eliberate cu titlu provizoriu si acum sunt returnate:<BR><BR>
   	</DIV>
   	<DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 30vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK;">
        <TABLE WIDTH = 100% STYLE = "TEXT-ALIGN: CENTER;">
            <TD>
                <TABLE ID = "bon.magazie.storno" WIDTH = 100% BORDER = 1 ALIGN = CENTER STYLE = "BORDER-COLLAPSE: SEPARATE; PADDING: 0; MARGIN: 0; BORDER-SPACING: 0;">
                    <THEAD BORDER = 1 STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY;">
                        <TR BORDER = 1>
		                    <TH WIDTH = 15% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Produs</TH>
		                    <TH WIDTH = 5% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Cod SAP</TH>
		                    <TH WIDTH = 10% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Furnizor</TH>
		                    <TH WIDTH = 5% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Valoare</TH>
		                    <TH WIDTH = 5% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Cantitate</TH>
		                    <TH WIDTH = 5% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">U.M.</TH>
		                    <TH WIDTH = 5% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Val. tot.</TH>
		                    <TH WIDTH = 10% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Data limita</TH>
		                    <TH WIDTH = 10% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Motiv eliberare</TH>
		                    <TH WIDTH = 10% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Stare</TH>
		                    <TH WIDTH = 10% HEIGHT = 20 ALIGN = CENTER FONT STYLE = "FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">Observatii</TH>
						</TR>
					</THEAD>
					<?php 
					    if($action == 'Adauga') 
						{
							if($amount > 0) require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/adaugare.storno.php';
							else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.storno.php';
						}
					    else if($action == 'Sterge') require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/stergere.declaratie.php';
					    else if($action == 'Anulare') echo 'Actiune anulata.';
					    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/storno/read.declaratie.storno.php';
					?>
                </TABLE>
            </TD><TR>
            <TD STYLE = "TEXT-ALIGN: RIGHT; HEIGHT: 20px; FONT-SIZE: 1.5VW;FONT-WEIGHT: BOLD;">
                <?php echo $readVALBON.' RON'; ?>
            </TD>
        </TABLE>
    </DIV>
    <DIV ID = "declaratieFOOTER" STYLE = "POSITION: FIXED; BOTTOM : 0; MARGIN: 0 AUTO; ALIGN-ITEMS: CENTER; WIDTH: 100%; BACKGROUND-COLOR: WHITE; FLOAT: LEFT;"><BR>
        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FLOAT: LEFT;">
            <B>DATA<BR><?php echo $date;?><BR>
            <?php if($proc == 0) echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" ONCLICK = "confirmare()">CONFIRMARE ANGAJAT</BUTTON>';
                  else echo '<BUTTON CLASS = "CONFIRM" ID = "CONFIRM" STYLE = "BACKGROUND-COLOR: LIGHTGREEN;">CONFIRMARE ANGAJAT</BUTTON>';?><BR><BR>
        </DIV>
        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 50%; FONT-SIZE: 1.5VW; FLOAT: LEFT;">
            <B>SEMNATURA GESTIONAR<BR><?php echo $nume;?><BR>
            <?php if($proc == 0) echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()">PRINTEAZA/FINALIZEAZA</BUTTON>';
                  else echo '<BUTTON CLASS = "PRINT" ID = "PRINTER" ONCLICK = "close_print()" STYLE = "BACKGROUND-COLOR: #ff3300">PRINTEAZA/FINALIZEAZA</BUTTON>';?><BR><BR>
        </DIV>
        <DIV STYLE = "MARGIN: 0 AUTO; TEXT-ALIGN: CENTER; WIDTH: 100%;" ID = "FOOT_NOTE">
            <FONT STYLE = "FONT-SIZE: 1.2VW"><CENTER>BONURILE DE COMANDA SE SALVEAZA AUTOMAT, ODATA CU CONFIRMAREA COMENZII DE CATRE ANGAJAT. PENTRU O NOUA COMANDA, FOLOSITI BUTONUL PRINTEAZA/FINALIZEAZA.</FONT>
        </DIV>
    </DIV>
    <DIV ID = "confModal" class="confModal"><BR><BR><BR><BR><BR>
	    <DIV class = "modal-content" STYLE = "background-color: gray; font-weight: bold; HEIGHT: 100px; MARGIN-TOP: 300px; MARGIN-LEFT: 110px;">
            <span ID = "c_close" CLASS = "close">&#x2623;</span>
                <INPUT TYPE = "password" ID = "worker_confirm" ONCHANGE = "salveaza_comanda()" AUTOSUGEST = "OFF" TITLE = ></INPUT>
			    <CENTER><BUTTON ID = "c_setoff" CLASS = "setoff"><B>Anuleaza</BUTTON>
            </DIV>
		<BR><BR>
    </DIV>
</DIV>
<SCRIPT>

    var table = document.getElementById('bon.magazie.storno'),rIndex;
    var c_modal = document.getElementById("confModal");
    var c_span = document.getElementById("c_close");
	var c_setoff = document.getElementById("c_setoff");
	var bar_code = document.getElementById("worker_confirm");
	function close_print()
	{
	    if(document.getElementById("PRINTER").style.background != 'lightgreen')
		{
			document.getElementById("PRINTER").style.background = 'lightgreen';
			if(window.XMLHttpRequest)
			{
			    xmlhttp = new XMLHttpRequest();
			}
			else
			{
			    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xmlhttp.onreadystatechange = function()
			{
			    if(xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
					if(xmlhttp.responseText == 'OK')
					{
                        document.getElementById("printableSPACE").style.overflow = 'visible';
						document.getElementById("declaratieFOOTER").style.position = 'relative';
						document.getElementById("declarationINTRO").style.position = 'static';
						document.getElementById("scrollableDIV").style.maxHeight = 'none';
						document.getElementById("scrollableDIV").style.overflow = 'visible';
						document.getElementById("PRINTER").style.visibility = 'hidden';
						document.getElementById("CONFIRM").style.visibility = 'hidden';
						document.getElementById("FOOT_NOTE").style.visibility = 'hidden';
						window.print();
						document.getElementById("declarationINTRO").style.position = 'fixed';
						document.getElementById("declaratieFOOTER").style.position = 'fixed';
						document.getElementById("scrollableDIV").style.maxHeight = '30vw';
						document.getElementById("scrollableDIV").style.overflow = 'auto';
						document.getElementById("PRINTER").style.visibility = 'visible';
						document.getElementById("CONFIRM").style.visibility = 'visible';
						document.getElementById("FOOT_NOTE").style.visibility = 'visible';
						document.getElementById("PRINTER").style.background = 'orange';
						document.getElementById("CONFIRM").style.background='orange';
						location.reload();
					}
					else 
					{
						alert('Something went wrong!\n'+xmlhttp.responseText);
						document.getElementById("PRINTER").style.background = 'orange';
					}
			    }
			}
			xmlhttp.open('GET','finalizare.comanda.php?marca=<?php echo $marca;?>&seria=<?php echo $seria?>', true);
			xmlhttp.send();
		}
	}
    for(var i = 1; i < table.rows.length; i++)
    {
	    table.rows[i].onclick = function()
	    {
		    rIndex = this.rowsIndex;
		    window.parent.document.getElementById("productNameStorno").value = this.cells[0].innerHTML;
		    window.parent.document.getElementById("productStorno").value = this.cells[1].innerHTML;
		    window.parent.document.getElementById("furnizorStorno").value = this.cells[2].innerHTML;
			window.parent.document.getElementById("amountStorno").value = this.cells[4].innerHTML;
			var units = window.parent.document.getElementsByClassName("unitsStorno");
			for(var i = 0; i < units.length; i++)
			{
			    if(this.cells[5].innerHTML != '') units[i].value = this.cells[5].innerHTML;
			    else units[i].value = 'N.A.';
			}
			window.parent.document.getElementById("dataEnd").value = this.cells[7].innerHTML;
			window.parent.document.getElementById("motivStorno").value = this.cells[8].innerHTML;
            window.parent.document.getElementById("dataEnd").onchange();
			if(new Date(window.parent.document.getElementById("dataEnd").value) < new Date(window.parent.document.getElementById("dataEnd").value))
			{
			    window.parent.document.getElementById("dataEnd").style.backgroundColor = "red";
			}
			else 
			{
				window.parent.document.getElementById("dataEnd").style.backgroundColor = "yellow";
			}
			window.parent.document.getElementById("observatii").value = this.cells[10].innerHTML;
			window.parent.document.getElementById("action").value = null;
	    }
    }
    function confirmare()
    {
		document.getElementById("CONFIRM").style.background='#ff3300';
		document.getElementById("c_setoff").style.background='orange';
	    c_modal.style.display = "block";
	    document.getElementById('worker_confirm').focus();
	    document.getElementById('worker_confirm').select();
    }
    function salveaza_comanda()
    {
	    if(bar_code != null && bar_code.value.length > 0)
		{
			document.getElementById("c_setoff").style.background='lightgreen';
			if(window.XMLHttpRequest)
			{
			    xmlhttp = new XMLHttpRequest();
			}
			else
			{
			    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xmlhttp.onreadystatechange = function()
			{
			    if(xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
					if(xmlhttp.responseText == '')
					{
						document.getElementById('worker_confirm').select();
					    document.getElementById('worker_confirm').innerHTML = xmlhttp.responseText;
					    document.getElementById("worker_confirm").value = xmlhttp.responseText;
					    c_modal.style.display = "none";
					    document.getElementById("CONFIRM").style.background='lightgreen';
					    document.getElementById("PRINTER").style.background = '#ff3300';
					}
					else
					{
					    alert(xmlhttp.responseText);
					    document.getElementById("c_setoff").style.background='red';
					}
			    }
			}
			xmlhttp.open('GET','worker.confirm.php?barcode='+document.getElementById("worker_confirm").value+'&marca='+<?php echo "$marca";?>+'&seria=<?php echo $seria;?>', true);
			xmlhttp.send();
		}
    }
    if(c_span != null)
	{
		c_span.onclick = function()
		{
		    c_modal.style.display = "none";
		    document.getElementById("worker_confirm").value = "";
		    document.getElementById("CONFIRM").style.background='orange';
		}
	}
	if(c_setoff != null)
	{
		c_setoff.onclick = function()
		{
		    c_modal.style.display = "none";
		    document.getElementById("worker_confirm").value = "";
		    document.getElementById("CONFIRM").style.background='orange';
		}
	}
    window.onload=function()
	{
		var confirm = document.getElementById('worker_confirm').value;
		if(confirm == '')
		{ 
			document.getElementById('worker_confirm').focus();
			document.getElementById('worker_confirm').select();
		}
	}

</SCRIPT>
</BODY>
</HTML>
var marcaW = document.getElementById('rekrow');
var marcaLIST = document.getElementById('marci');
var nameW = document.getElementById('nameResults');
var workerLIST = document.getElementById('numeworker');
var codSAP = document.getElementById('product');
var prodPICK = document.getElementById('results');
var prodNAME = document.getElementById("productName");
var amount = document.getElementById('amount');
var stock = document.getElementById("stock");
var furnizor = document.getElementById("furnizor");
var units = document.getElementsByClassName("units");
var actionBUTTON = document.getElementById('action');
var observatii = document.getElementById('observatii');
var autoOFF = document.getElementById('autoOFF');
var autoON = document.getElementById('autoON');
var box = document.getElementById("RETURN");
var stornoText = document.getElementById("stornoField");
var stornoOption = document.getElementById("stornoOption");
var uzatFIELD = document.getElementById("produsUZATfield");
var uzatTABLE = document.getElementById("prodUZAT");
var bonFRAME = document.getElementById('bonFRAME');
var gestionar = document.getElementById('numeGESTIONAR');
var c_modal = document.getElementById("confModal");
var c_span = document.getElementById("c_close");
var c_setoff = document.getElementById("c_setoff");
var bar_code = document.getElementById("worker_confirm");
var bonTABLE = document.getElementById('bon.magazie');

function inserareGESTIONAR()
{
    document.getElementById("semnaturaGESTIONAR").innerHTML = parent.gestionar.innerHTML;
}

function passDATA2FORM()
{
	for(var i = 1; i < bonTABLE.rows.length; i++)
	{
	    table.rows[i].onclick = function()
		{
		    rIndex = this.rowsIndex;
			window.parent.codSAP.value = this.cells[1].innerHTML;
			window.parent.prodNAME.value = this.cells[0].innerHTML;
			window.parent.furnizor.value = this.cells[2].innerHTML;
			var units = window.parent.document.getElementsByClassName("units");
			for(var i = 0; i < units.length; i++)
			{
	    	    units[i].value = this.cells[4].innerHTML;
			}
			window.parent.stock.value = this.cells[6].innerHTML;
			window.parent.amount.value = this.cells[7].innerHTML;
			window.parent.observatii.value = this.cells[10].innerHTML;
	    }
	}
}

function loadFOCUS()
{
	var confirm = document.getElementById('worker_confirm').value;
	if(confirm == '')
	{ 
		document.getElementById('worker_confirm').focus();
		document.getElementById('worker_confirm').select();
	}
}


function close_print()
{
    if(document.getElementById("PRINTER").style.background != 'lightgreen')
	{
		if(window.XMLHttpRequest){xmlhttp = new XMLHttpRequest();}
		else{xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');}
		xmlhttp.onreadystatechange = function()
		{
		    if(xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
				if(xmlhttp.responseText == 'OK')
				{
					document.getElementById("PRINTER").style.background = 'lightgreen';
					document.getElementById("PRINTER").style.visibility = 'hidden';
					document.getElementById("CONFIRM").style.visibility = 'hidden';
					document.getElementById("FOOT_NOTE").style.visibility = 'hidden';
					window.print();
					document.getElementById("PRINTER").style.visibility = 'visible';
					document.getElementById("CONFIRM").style.visibility = 'visible';
					document.getElementById("FOOT_NOTE").style.visibility = 'visible';
					document.getElementById("PRINTER").style.background = 'orange';
					document.getElementById("CONFIRM").style.background='orange';
					location.reload();
				}
				else if(xmlhttp.responseText == 'Worker confirm')
				{
				    confirmare();
				}
				else
				{
					if(xmlhttp.responseText != '')console.log(xmlhttp.responseText);
					document.getElementById("PRINTER").style.background = 'orange';
				}
		    }
		}
		var marcaW = document.getElementById('marcaANGAJATbon').innerHTML;
		xmlhttpPARAMS = 'marca='+marcaW;
		xmlhttp.open('POST','finalizare.comanda.php', true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(xmlhttpPARAMS);
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
		if(window.XMLHttpRequest){xmlhttp = new XMLHttpRequest();}
		else{xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');}
		xmlhttp.onreadystatechange = function()
		{
		    if(xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
				if(xmlhttp.responseText == 'OK')
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
				    console.log(xmlhttp.responseText);
				    document.getElementById("c_setoff").style.background='red';
				}
		    }
		}
		var marcaW = document.getElementById('marcaANGAJATbon').innerHTML;
		xmlhttpPARAMS = 'barcode='+document.getElementById("worker_confirm").value+'&marca='+marcaW;
		xmlhttp.open('POST','worker.confirm.php', true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(xmlhttpPARAMS);
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

function setAUTO()
{
    if(box.checked == true && autoON.checked == true)
    {
		stornoField.style.visibility = "collapse";
	    box.checked = false;
    }
    else if(autoON.checked == true && uzatFIELD.style.display == 'block')
    {
	    if(uzatTABLE.rows.length > 1)
	    {
		    for(i = (uzatTABLE.rows.length - 1); i > 0; i--)
		    {
			    uzatTABLE.deleteRow(i);
		    }
		    uzatFIELD.style.display = 'none';
	    }
    }
}

function closeUZURA()
{
    uzatFIELD.style.display = 'none';
	if(uzatTABLE.rows.length > 1)
	{
		var uzLONG = uzatTABLE.rows.length;
		for(i = (uzLONG -1); i > 0; i--)
		{
		    uzatTABLE.deleteRow(i);
		}
		console.log('Grab data for product and insert it, from main warehouse.');
		if(window.XMLHttpRequest){closeINSERT = new XMLHttpRequest();}
		else{closeINSERT = new ActiveXObject('Microsoft.XMLHTTP');}
		closeINSERT.onreadystatechange = function()
		{
	 	    if(closeINSERT.readyState==4 && closeINSERT.status==200)
	 	    {
			    closeINSERTLIST = closeINSERT.responseText.split('^');
			    if(closeINSERTLIST[0] == 'OK')
			    {
				    prodNAME.value = closeINSERTLIST[1];
				    furnizor.value = closeINSERTLIST[2];
				    stock.value = closeINSERTLIST[3];
				    if(closeINSERTLIST[4] == '')
				    {
					    closeINSERTLIST[4] = 'N.A.';
				    }
					for(var i = 0; i < units.length; i++)
					{
					    units[i].value = closeINSERTLIST[4];
					}
				    if(closeINSERTLIST[5] != null)
					{
						for(var i = 5; i < closeINSERTLIST.length; i++)
						{
						    if(closeINSERTLIST[i] != null)
							{
								var option = document.createElement("option");
								option.value = closeINSERTLIST[i];
								option.text = closeINSERTLIST[i];
								document.getElementById('size').appendChild(option);
							}
						}
				    }
			    }
			    else{console.log(closeINSERT.responseText)}
	        }
	    }
		closeINSERTparams = 'codSAP='+codSAP.value+'&marca='+marcaW.value;
		closeINSERT.open('POST','get.product.php',true);
		closeINSERT.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		closeINSERT.send(closeINSERTparams);
	}
	else {console.log('My table length: '+uzatTABLE.rows.length);}
}

function stornoprod()
{
	if(box.checked == true)
    {
		if(autoOFF.checked == true)
		{
	        stornoField.style.visibility = "initial";
	    }
	    else
	    {
		    alert('Nu se poate reliza storno produs in modul Auto On.\nSchimbati modul de lucru inainte de a efectua storno.');
			box.checked = false;
	    }
    }
    else
    {
	    stornoField.style.visibility = "collapse";
    }
}
function moveON()
{
    if(document.activeElement == marcaW && marcaW.value != '')
    {
	    if(window.XMLHttpRequest){nameXML = new XMLHttpRequest();}
		else{nameXML = new ActiveXObject('Microsoft.XMLHTTP');}
		nameXML.onreadystatechange = function()
		{
		    if(nameXML.readyState==4 && nameXML.status==200)
		    {
				var namesLIST = nameXML.responseText.split('^');
				if(namesLIST[0] == 'OK')
				{         
			        nameW.value = namesLIST[1];
           			nameW.style.textTransform = "capitalize";
           			bonFRAME.contentWindow.document.getElementById('numeANGAJATbon').innerHTML = nameW.value;
           			bonFRAME.contentWindow.document.getElementById('marcaANGAJATbon').innerHTML = marcaW.value;
           			bonFRAME.contentWindow.document.getElementById('sectiaBON').innerHTML = namesLIST[2];
           			if(namesLIST.length > 3)
           			{
						bonFRAME.contentWindow.document.getElementById('seriaBON').innerHTML = namesLIST[3];
						var valueBON = bonFRAME.contentWindow.document.getElementById('totalBON').innerHTML;
						var bonTABLE = bonFRAME.contentWindow.document.getElementById('bon.magazie');
						var bonLENGTH = bonTABLE.rows.length;
						if(bonLENGTH > 1)
						{
						    for(k = bonLENGTH - 1; k > 0; k--)
						    {
							    bonTABLE.deleteRow(k);
						    }
						    bonLENGTH = bonTABLE.rows.length;
						    valueBON = 0;
						}
					    for(i = 4; i < namesLIST.length - 10; i = i + 11)
					    {
						    var prodROW = bonTABLE.insertRow(bonLENGTH);
						    var bonCELL1 = prodROW.insertCell(0);
						    bonCELL1.innerHTML = namesLIST[i];
						    var bonCELL2 = prodROW.insertCell(1);
						    bonCELL2.innerHTML = namesLIST[i + 1];
						    var bonCELL3 = prodROW.insertCell(2);
						    bonCELL3.innerHTML = namesLIST[i + 2];
						    var bonCELL4 = prodROW.insertCell(3);
						    bonCELL4.innerHTML = namesLIST[i + 3];
						    var bonCELL5 = prodROW.insertCell(4);
						    bonCELL5.innerHTML = namesLIST[i + 4];
						    var bonCELL6 = prodROW.insertCell(5);
						    bonCELL6.innerHTML = namesLIST[i + 5];
						    var bonCELL7 = prodROW.insertCell(6);
						    bonCELL7.innerHTML = namesLIST[i + 6];
						    var bonCELL8 = prodROW.insertCell(7);
						    bonCELL8.innerHTML = namesLIST[i + 7];
						    var bonCELL9 = prodROW.insertCell(8);
						    bonCELL9.innerHTML = namesLIST[i + 8];
						    var bonCELL10 = prodROW.insertCell(9);
						    bonCELL10.innerHTML = namesLIST[i + 9];
						    var bonCELL11 = prodROW.insertCell(10);
						    bonCELL11.innerHTML = namesLIST[i + 10];
						    valueBON = (parseFloat(valueBON) + parseFloat(bonCELL10.innerHTML)).toFixed(2);
				        }
				        bonFRAME.contentWindow.document.getElementById('totalBON').innerHTML = valueBON;
                    }
			        codSAP.focus();
			    }
			    else
			    {
					console.log(nameXML.responseText);
					flashWORKER();
		        }
		    }
		}
		nameXmlPARAMS = 'workerID='+marcaW.value;
		nameXML.open('POST','find.worker.php', true);
		nameXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		nameXML.send(nameXmlPARAMS);
    }
    else if(document.activeElement == nameW && nameW.value != '')
    {
	    if(window.XMLHttpRequest){marcaXML = new XMLHttpRequest();}
		else{marcaXML = new ActiveXObject('Microsoft.XMLHTTP');}
		marcaXML.onreadystatechange = function()
		{
		    if(marcaXML.readyState==4 && marcaXML.status==200)
		    {
				var marcaLIST = marcaXML.responseText.split('^');
				if(marcaLIST[0] == 'OK')
				{         
			        marcaW.value = marcaLIST[1];
			        bonFRAME.contentWindow.document.getElementById('numeANGAJATbon').innerHTML = nameW.value;
           			bonFRAME.contentWindow.document.getElementById('marcaANGAJATbon').innerHTML = marcaW.value;
           			bonFRAME.contentWindow.document.getElementById('sectiaBON').innerHTML = marcaLIST[2];
			        codSAP.focus();
			    }
			    else
			    {
					console.log(marcaXML.responseText);
					flashWORKER();
		        }
		    }
		}
		marcaXmlPARAMS = 'workerNAME='+nameW.value;
		marcaXML.open('POST','find.worker.php', true);
		marcaXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		marcaXML.send(marcaXmlPARAMS);
    }
}

function bonTABLEload()
{
    if(window.XMLHttpRequest){bonLOAD = new XMLHttpRequest();}
	else{bonLOAD = new ActiveXObject('Microsoft.XMLHTTP');}
	bonLOAD.onreadystatechange = function()
	{
	    if(bonLOAD.readyState==4 && bonLOAD.status==200)
	    {
			console.log(bonLOAD.responseText);
			var bonLIST = bonLOAD.responseText.split('^');
			if(bonLIST[0] == 'OK')
			{         
		        if(bonLIST.length > 3)
       			{
				    var valueBON = bonFRAME.contentWindow.document.getElementById('totalBON').innerHTML;
					var bonTABLE = bonFRAME.contentWindow.document.getElementById('bon.magazie');
					var bonLENGTH = bonTABLE.rows.length;
					if(bonLENGTH > 1)
					{
					    for(k = bonLENGTH - 1; k > 0; k--)
					    {
						    bonTABLE.deleteRow(k);
					    }
					    bonLENGTH = bonTABLE.rows.length;
					    valueBON = 0;
					}
			    	for(i = 4; i < bonLIST.length - 10; i = i + 11)
				    {
					    var prodROW = bonTABLE.insertRow(bonLENGTH);
					    var bonCELL1 = prodROW.insertCell(0);
					    bonCELL1.innerHTML = bonLIST[i];
					    var bonCELL2 = prodROW.insertCell(1);
					    bonCELL2.innerHTML = bonLIST[i + 1];
					    var bonCELL3 = prodROW.insertCell(2);
					    bonCELL3.innerHTML = bonLIST[i + 2];
					    var bonCELL4 = prodROW.insertCell(3);
					    bonCELL4.innerHTML = bonLIST[i + 3];
					    var bonCELL5 = prodROW.insertCell(4);
					    bonCELL5.innerHTML = bonLIST[i + 4];
					    var bonCELL6 = prodROW.insertCell(5);
					    bonCELL6.innerHTML = bonLIST[i + 5];
					    var bonCELL7 = prodROW.insertCell(6);
					    bonCELL7.innerHTML = bonLIST[i + 6];
					    var bonCELL8 = prodROW.insertCell(7);
					    bonCELL8.innerHTML = bonLIST[i + 7];
					    var bonCELL9 = prodROW.insertCell(8);
					    bonCELL9.innerHTML = bonLIST[i + 8];
					    var bonCELL10 = prodROW.insertCell(9);
					    bonCELL10.innerHTML = bonLIST[i + 9];
					    var bonCELL11 = prodROW.insertCell(10);
					    bonCELL11.innerHTML = bonLIST[i + 10];
					    valueBON = (parseFloat(valueBON) + parseFloat(bonCELL10.innerHTML)).toFixed(2);
			        }
			        bonFRAME.contentWindow.document.getElementById('totalBON').innerHTML = valueBON;
                }
		        codSAP.focus();
		    }
		    else{console.log(bonLOAD.responseText);}
	    }
	}
	bonLOADPARAMS = 'workerID='+marcaW.value;
	bonLOAD.open('POST','find.worker.php', true);
	bonLOAD.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	bonLOAD.send(bonLOADPARAMS);
}

function formACTION()
{
    if(actionBUTTON.value == 'Adauga')
    {
		if(furnizor.value != 'Magazie uzate'){var uzura = 'Nou';}
		else{var uzura = 'Uzat'}
		var serieBON = bonFRAME.contentWindow.document.getElementById('seriaBON');
		var sectieANGAJAT = bonFRAME.contentWindow.document.getElementById('sectiaBON');
	    if(marcaW.value != '' && nameW.value != '' && codSAP.value != '' && prodNAME.value != '' && stock.value != 0.00 && (parseFloat(stock.value).toFixed(2) - parseFloat(amount.value).toFixed(2)) >= 0 && amount.value > 0 && serieBON.innerHTML != '' && sectieANGAJAT.innerHTML != '' && gestionar.innerHTML != '')
	    {
			if(window.XMLHttpRequest){addITEM = new XMLHttpRequest();}
			else{addITEM = new ActiveXObject('Microsoft.XMLHTTP');}
			addITEM.onreadystatechange = function()
			{
			    if(addITEM.readyState==4 && addITEM.status==200)
			    {
					console.log('Got reply: '+addITEM.responseText);
				    addITEMReply = addITEM.responseText.split('^');
				    if(addITEMReply[0] == 'OK')
				    {
						bonTABLEload();
						codSAP.select();
				    }
				    else{console.log(addITEM.responseText);}
			    }
			}
			addITEMparams = 'sapTOadd='+codSAP.value+'&prodNAME='+prodNAME.value+'&furnizor='+furnizor.value+'&stoc='+stock.value+'&units='+document.getElementById('units').value+'&amount='+amount.value+'&marca='+marcaW.value+'&nume='+nameW.value+'&uzura='+uzura+'&serieBON='+serieBON.innerHTML+'&sectia='+sectieANGAJAT.innerHTML+'&gestionar='+gestionar.innerHTML+'&observatii='+observatii.value;
			addITEM.open('POST','insert.product.php',true);
			addITEM.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			addITEM.send(addITEMparams);
	    }
	    else
	    {
     	    if(marcaW.value == '' || nameW.value == ''){flashWORKER();}
     	    else if(codSAP.value == '' || prodNAME.value == ''){flashPRODUCT();}
		    else if(stock.value == 0.00 || ((parseFloat(stock.value).toFixed(2) - parseFloat(amount.value).toFixed(2)) < 0) || amount.value == 0){flashQuantity();}
	    }
    }
    else if(actionBUTTON.value == 'Sterge')
    {
	    console.log('Must remove item from receipt.');
    }
    else if(actionBUTTON.value == 'Anuleaza')
    {
	    codSAP.value = '';
	    codSAP.focus();
	    prodNAME.value = '';
	    furnizor.value = '';
	    stock.value = '0.00';
	    amount.value = '1';
	    observatii.value = '';
		autoOFF.checked = true;
		box.checked = false;
		stornoField.style.visibility = "collapse";
		if(size.options.length > 1)
		{
		    for(i = size.options.length - 1; i > 0; i--)
			{
			    size.remove(i);
			}
		}
		for(var i = 0; i < units.length; i++)
		{
		    units[i].value = '';
		}
		actionBUTTON.value = 'Adauga';
    }
}

function keyCHECK()
{
    var pressed = event.key;
    //console.log(pressed);
	if(pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace' && pressed != 'ArrowDown' && pressed != 'ArrowUp')
	{
		if(document.activeElement == marcaW)
		{
	        if(/[0-9]/i.test(event.key)){marcaW.style.textTransform = "capitalize";}
  			else{event.preventDefault();}
        }
        else if(document.activeElement == nameW)
        {
		    if(/[a-z\' '\.]/i.test(event.key)){}
  			else{event.preventDefault();}
        }
        else if(document.activeElement == codSAP)
        {
		    if(/[a-z0-9]/i.test(event.key)){codSAP.style.textTransform = "uppercase";}
		    else{event.preventDefault();}
        }
        else if(document.activeElement == amount)
        {
		    if(/[0-9]/i.test(event.key)){}
		    else{event.preventDefault();}
		}
	}
	else if(pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    if((document.activeElement == marcaW && marcaW.value != '') || (document.activeElement == nameW && nameW.value != ''))
	    {
	        moveON();
	    }
	    else if(document.activeElement == codSAP && uzatFIELD.style.display == 'none')
	    {
			if(marcaW.value != '' && nameW.value != '')
			{
		        updateprod();
		    }
		    else{flashWORKER();}
	    }
	    else if(document.activeElement == amount)
	    {
		    actionBUTTON.focus();
	    }
	    else if(document.activeElement == actionBUTTON)
	    {
		    formACTION();
	    }
	}
	else if(pressed == 'ArrowUp' || pressed == 'ArrowDown')
	{
	    if(document.activeElement == actionBUTTON)
	    {
		    if(pressed == 'ArrowDown')
		    {
				if(actionBUTTON.selectedIndex == 2)
				{
					event.preventDefault();
			        actionBUTTON.selectedIndex = '0';
				}
		    }
		    else if(pressed == 'ArrowUp')
		    {
				if(actionBUTTON.selectedIndex == 0)
				{
					event.preventDefault();
			        actionBUTTON.selectedIndex = '2';
				}
		    }
	    }
	}
}



function findproduct()
{
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
			PPlist = xmlhttp.responseText.split('^');
			if(PPlist[0] == 'OK')
			{
		        prodPICK.innerHTML = PPlist[1];;
		    }
		    else 
		    {
			    if(xmlhttp.responseText != ''){console.log(xmlhttp.responseText);}
		    }
	    }
	}
	xmlPARAMSprod = 'product='+codSAP.value
	xmlhttp.open('POST','find.product.php', true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(xmlPARAMSprod);
}

function useUZAT(x)
{
	var prodROW = x.rowIndex;
	var prodUZAT = uzatTABLE.rows[prodROW].cells[0].innerHTML;
	var amPRODuzat = uzatTABLE.rows[prodROW].cells[2].innerHTML;
	var prodUNITS = uzatTABLE.rows[prodROW].cells[3].innerHTML;
	furnizor.value = 'Magazie uzate';
	stock.value = amPRODuzat;
	for(var i = 0; i < units.length; i++)
	{
	    units[i].value = prodUNITS;
	}
	amount.focus();
	amount.select();
	uzatFIELD.style.display = "none";
}
function updateprod()
{
	if(marcaW.value != '' && nameW.value != '')
	{
		if(window.XMLHttpRequest){xmlprod = new XMLHttpRequest();}
		else{xmlprod = new ActiveXObject('Microsoft.XMLHTTP');}
		xmlprod.onreadystatechange = function()
		{
	 	    if(xmlprod.readyState==4 && xmlprod.status==200)
  			{
			    const prodesc = xmlprod.responseText.split('^');
				if(prodesc[0] == 'OK')
		  		{
					if(autoON.checked == false)
					{
	                    if(window.XMLHttpRequest){prodCHK = new XMLHttpRequest();}
						else{prodCHK = new ActiveXObject('Microsoft.XMLHTTP');}
						prodCHK.onreadystatechange = function()
						{
	                        if(prodCHK.readyState==4 && prodCHK.status==200)
	                        {
								console.log(prodCHK.responseText);
							    chkREPLY = prodCHK.responseText.split('^');
							    if(chkREPLY[0] == 'OK')
							    {
								    if(chkREPLY[4] != 'Nou')
								    {
									    uzatFIELD.style.display = 'block';
									    prodNAME.value = prodesc[1];
									    if(uzatTABLE.rows.length > 1)
									    {
										    for(i = uzatTABLE.rows.length - 1; i > 1; i--)
										    {
											    uzatTABLE.deleteRow(i);
										    }
									    }
									    for(i = 1; i < chkREPLY.length; i = i + 6)
									    {
									        var newROW = uzatTABLE.insertRow(uzatTABLE.rows.length);
									        newROW.addEventListener('click',function(){useUZAT(this);});
									        var SAPcell = newROW.insertCell(0);
									        SAPcell.style.fontSize = '0.8vw';
									        SAPcell.style.border = '1px SOLID BLACK';
									        SAPcell.id = 'SAPcell'+(uzatTABLE.rows.length-1);
									        SAPcell.innerHTML = codSAP.value;
									        var NOMcell = newROW.insertCell(1);
									        NOMcell.style.fontSize = '0.8vw';
									        NOMcell.style.border = '1px SOLID BLACK';
									        NOMcell.innerHTML = chkREPLY[1];
									        NOMcell.id = 'NOMcell'+(uzatTABLE.rows.length-1);
									        var CANTcell = newROW.insertCell(2);
									        CANTcell.style.fontSize = '0.8vw';
									        CANTcell.style.border = '1px SOLID BLACK';
									        CANTcell.id = 'CANTcell'+(uzatTABLE.rows.length-1);
									        CANTcell.innerHTML = chkREPLY[2];
									        var UMcell = newROW.insertCell(3);
									        UMcell.style.fontSize = '0.8vw';
									        UMcell.style.border = '1px SOLID BLACK';
									        UMcell.id = 'UMcell'+(uzatTABLE.rows.length-1);
									        UMcell.innerHTML = chkREPLY[3];
									        var DETcell = newROW.insertCell(4);
									        DETcell.style.fontSize = '0.8vw';
									        DETcell.style.border = '1px SOLID BLACK';
									        DETcell.id = 'DETcell'+(uzatTABLE.rows.length-1);
									        DETcell.innerHTML = chkREPLY[5];
									        var STATcell = newROW.insertCell(5);
									        STATcell.style.fontSize = '0.8vw';
									        STATcell.style.border = '1px SOLID BLACK';
									        STATcell.id = 'STATcell'+(uzatTABLE.rows.length-1);
									        STATcell.innerHTML = chkREPLY[4];
									        var OTHERcell = newROW.insertCell(6);
									        OTHERcell.style.fontSize = '0.8vw';
									        OTHERcell.style.border = '1px SOLID BLACK';
									        OTHERcell.id = 'OTHERcell'+(uzatTABLE.rows.length-1);
									        OTHERcell.innerHTML = chkREPLY[6];
									    }
								    }
								    else
								    {
										console.log('Here');
									    prodNAME.value = prodesc[1];
									    furnizor.value = prodesc[2];
									    stock.value = prodesc[3];
									    if(prodesc[4] == ''){prodesc[4] = 'N.A.'}
										for(var i = 0; i < units.length; i++)
										{
										    units[i].value = prodesc[4];
										}
									    if(prodesc[5] != null)
										{
											for(var i = 5; i < prodesc.length; i++)
											{
											    if(prodesc[i] != null)
												{
													var option = document.createElement("option");
													option.value = prodesc[i];
													option.text = prodesc[i];
													document.getElementById('size').appendChild(option);
												}
											}
							
									    }
									    amount.focus();
									    amount.select();
								    }
							    }
							    else if(chkREPLY[0] == 'Not found')
							    {
								    codSAP.focus();
								    codSAP.select();
							    }
							    else
							    {
								    if(prodCHK.responseText != '')
									{
										console.log(prodCHK.responseText);
									}
									else
									{
									    console.log('Empty response from get.product.php; params: prodCHK = '+codSAP.value);
									}
							    }
	                        }
						}
						pchkPARAMS = 'prodCHK='+codSAP.value;
						prodCHK.open('POST','get.product.php',true);
						prodCHK.setRequestHeader('Content-type','application/x-www-form-urlencoded');
						prodCHK.send(pchkPARAMS);
					}
					else //AUTO INERT MODE
					{
					    prodNAME.value = prodesc[1];
					    furnizor.value = prodesc[2];
					    stock.value = prodesc[3];
					    if(prodesc[4] == '')
					    {
						    prodesc[4] = 'N.A.';
					    }
						for(var i = 0; i < units.length; i++)
						{
						    units[i].value = prodesc[4];
						}
					    if(prodesc[5] != null)
						{
							for(var i = 5; i < prodesc.length; i++)
							{
							    if(prodesc[i] != null)
								{
									var option = document.createElement("option");
									option.value = prodesc[i];
									option.text = prodesc[i];
									document.getElementById('size').appendChild(option);
								}
							}
					    }
						if(window.XMLHttpRequest){addPROD = new XMLHttpRequest();}
						else{addPROD = new ActiveXObject('Microsoft.XMLHTTP');}
						addPROD.onreadystatechange = function()
						{
						    if(addPROD.readyState==4 && addPROD.status==200)
						    {
								console.log('Got reply: '+addPROD.responseText);
							    addProdReply = addPROD.responseText.split('^');
							    if(addProdReply[0] == 'OK')
							    {
									var bonTABLE = bonFRAME.contentWindow.document.getElementById('bon.magazie');
									var bonLENGTH = bonTABLE.rows.length;
									for(i = 1; i < bonLENGTH; i++)
									{
									    	
									}
									codSAP.select();
								    console.log('I should add to the table in bon consum now. We have '+bonLENGTH+' rows in table.');
							    }
							    else{console.log(addPROD.responseText);}
						    }
						}
						if(furnizor.value != 'Magazie uzate'){var uzura = 'Nou';}
						else{var uzura = 'Uzat'}
						var serieBON = bonFRAME.contentWindow.document.getElementById('seriaBON');
						var sectieANGAJAT = bonFRAME.contentWindow.document.getElementById('sectiaBON');
						addPRODparams = 'sapTOadd='+codSAP.value+'&prodNAME='+prodNAME.value+'&furnizor='+furnizor.value+'&stoc='+stock.value+'&units='+document.getElementById('units').value+'&amount='+amount.value+'&marca='+marcaW.value+'&nume='+nameW.value+'&uzura='+uzura+'&serieBON='+serieBON.innerHTML+'&sectia='+sectieANGAJAT.innerHTML+'&gestionar='+gestionar.innerHTML+'&observatii='+observatii.value;
						addPROD.open('POST','insert.product.php',true);
						addPROD.setRequestHeader('Content-type','application/x-www-form-urlencoded');
						addPROD.send(addPRODparams);
					}
			    }
			    else
				{
				    if(prodesc[0] != ''){console.log(prodesc[0]);}
				    else{if(codSAP.value != '' && marcaW.value != ''){console.log('Empty response from get.product.php; params: codSAP='+codSAP.value+'&marca='+marcaW.value);}}
				}
			}
		}
		xmlparams = 'codSAP='+codSAP.value+'&marca='+marcaW.value;
		xmlprod.open('POST','get.product.php',true);
		xmlprod.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlprod.send(xmlparams);
	}
	else{flashWORKER();}
}

function findworker()
{
	if(marcaW != '')
	{
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
				var xmlLIST = xmlhttp.responseText.split('^');
				if(xmlLIST[0] == 'OK')
				{
			        marcaLIST.innerHTML = xmlLIST[1];
			    }
			    else
			    {
					if(xmlhttp.responseText != ''){console.log(xmlhttp.responseText);}
		        }
		    }
		}
		xmlhttpPARAMS = 'worker='+marcaW.value;
		xmlhttp.open('POST','find.worker.php', true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(xmlhttpPARAMS);
	}
}
function findworkerbyname()
{
	if(nameW.value != '')
	{
	    if(window.XMLHttpRequest)
		{
		    bynameXML = new XMLHttpRequest();
		}
		else
		{
		    bynameXML = new ActiveXObject('Microsoft.XMLHTTP');
		}
		bynameXML.onreadystatechange = function()
		{
		    if(bynameXML.readyState==4 && bynameXML.status==200)
		    {
				xmlLISTname = bynameXML.responseText.split('^');
				if(xmlLISTname[0] == 'OK')
				{
			        workerLIST.innerHTML = xmlLISTname[1];
			    }
			    else
			    {
				    console.log(bynameXML.responseText);
			    }
		    }
		}
		xmlhttpPARname = 'numeworker='+nameW.value;
		bynameXML.open('POST','find.worker.php', true);
		bynameXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		bynameXML.send(xmlhttpPARname);
	}
}

function getprodname()
{
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
		    prodNAME.innerHTML = xmlhttp.responseText;
	    }
	}
	xmlPARAMSpname = 'prod='+codSAP.value;
	xmlhttp.open('POST','find.product.php', true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(xmlPARAMSpname);
}
function load()
{
	var worker = document.getElementById('rekrow').value;
	var sapcode = document.getElementById('product').value;
	var amount = document.getElementById('amount').value;
	var stock = document.getElementById('stock').value;
	var action = document.getElementById('action').value;
	var date = document.getElementById('date').value;
	var marca = document.getElementById('marca').value;
	var sectia = document.getElementById('sectia').value;
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
		    document.getElementById('bon_magazie').innerHTML = xmlhttp.responseText;
	    }
	}
	parameters = "worker="+worker+"&sapcode="+sapcode+"&amount="+amount+"&stock="+stock+"&action="+action+"&date="+date+"&marca="+marca+"&sectia="+sectia;
	xmlhttp.open('POST', 'bon.magazie.php', true);
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhttp.send(parameters);
}

function flashPRODUCT()
{
    var flashProd = setInterval(flashP,500);
    function flashP()
    {
        if(codSAP.style.background != 'red')
	    {
	        codSAP.style.background = 'red';
	        if(document.activeElement != codSAP)
			{
				codSAP.focus();
				codSAP.select();
			}
			else{codSAP.select();}
		}
	 	else
		{
	        codSAP.style.background = 'white';
	        if(document.activeElement != codSAP)
			{
				codSAP.focus();
				codSAP.select();
			}
			else{codSAP.select();}
		}
        codSAP.onkeydown = function()
        {
			if(flashProd == 1)
			{
	        	clearInterval(flashProd);
	        	flashProd = null;
	        	codSAP.style.background = 'white';
	        	updateprod();
	        }
        }
    }
}

function flashQuantity()
{
    var flashAmount = setInterval(flashA,500);
    function flashA()
    {
        if(amount.style.background != 'red')
	    {
	        amount.style.background = 'red';
	        if(document.activeElement != amount)
			{
				amount.focus();
				amount.select();
			}
		}
	 	else
		{
	        amount.style.background = 'white';
	        if(document.activeElement != amount)
			{
				amount.focus();
				amount.select();
			}
		}
        amount.onkeydown = function()
        {
			if(flashAmount != null)
			{
				console.log('Hmmmm');
	        	clearInterval(flashAmount);
	        	flashAmount = null;
	        	amount.style.background = 'white';
	        }
        }
    }
}

function flashWORKER()
{
    var flashWork = setInterval(flashW,500);
    function flashW()
    {
        if(marcaW.style.background != 'red')
	    {
	        marcaW.style.background = 'red';
	        if(document.activeElement != marcaW)
			{
				marcaW.focus();
				marcaW.select();
			}
		}
	 	else
		{
	        marcaW.style.background = 'white';
	        if(document.activeElement != marcaW)
			{
				marcaW.focus();
				marcaW.select();
			}
		}
        marcaW.onkeydown = function()
        {
			if(flashWork != null)
			{
	        	clearInterval(flashWork);
	        	flashWork = null;
	        	marcaW.style.background = 'white';
	        }
        }
    }
}
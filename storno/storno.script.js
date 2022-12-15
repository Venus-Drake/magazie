function formatDateSTORNO()
{
    var formatDate = document.getElementById("dataEnd").value;
    if(window.XMLHttpRequest)
	{
	    xmlFD = new XMLHttpRequest();
	}
	else
	{
	    xmlFD = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlFD.onreadystatechange = function()
	{
	    if(xmlFD.readyState==4 && xmlFD.status==200)
	    {
		    document.getElementById('dataEnd').value = xmlFD.responseText;
	    }
	}
	xmlFD.open('GET','format.date.php?dateFormat='+formatDate, true);
	xmlFD.send();
}
function findproductStorno()
{
	var pressedStorno = event.key;
	if(pressedStorno == 'Enter' && document.getElementById("productStorno").value != '' && document.getElementById("productStorno").value != 0)
	{
	    document.getElementById("product_form_storno").submit();
	}
	else
	{
		var productStorno = document.getElementById("productStorno").value;
		var marcaStorno = document.getElementById("rekrowStorno").value;
		if(marcaStorno != '')
		{
			//alert(productImprumut);
		    if(window.XMLHttpRequest)
			{
			    xmlFPS = new XMLHttpRequest();
			}
			else
			{
			    xmlFPS = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xmlFPS.onreadystatechange = function()
			{
			    if(xmlFPS.readyState==4 && xmlFPS.status==200)
			    {
				    document.getElementById('resultsStorno').innerHTML = xmlFPS.responseText;
			    }
			}
			xmlFPS.open('GET','find.product.php?product='+productStorno+'&marca='+marcaStorno, true);
			xmlFPS.send();
		}
	}
}
function findworkerStorno()
{
	if(document.getElementById("rekrowStorno").value != null && document.getElementById("rekrowStorno").value != ''){
		var worker = document.getElementById("rekrowStorno").value;
	}
    if(window.XMLHttpRequest)
	{
	    xmlFWS = new XMLHttpRequest();
	}
	else
	{
	    xmlFWS = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlFWS.onreadystatechange = function()
	{
	    if(xmlFWS.readyState==4 && xmlFWS.status==200)
	    {
		    document.getElementById('marciStorno').innerHTML = xmlFWS.responseText;
	    }
	}
	xmlFWS.open('GET','find.worker.php?worker='+worker, true);
	xmlFWS.send();
}
function findworkerbynameStorno()
{
	if(document.getElementById("nameResultsStorno").value != null){
		var workername = document.getElementById("nameResultsStorno").value;
	}
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
		    document.getElementById('numeworkerStorno').innerHTML = xmlhttp.responseText;
	    }
	}
	xmlhttp.open('GET','find.worker.php?numeworker='+workername, true);
	xmlhttp.send();
}
function updateSTORNOform()
{
	var myPOPtable = document.getElementById("formPOPtable"),rIndex;
	for(var i = 1; i < myPOPtable.rows.length; i++)
    {
	    rIndex = this.rowsIndex;
	    document.getElementById("productNameStorno").value = this.cells[1].innerHTML;
	    document.getElementById("productStorno").value = this.cells[2].innerHTML;
	    document.getElementById("furnizorStorno").value = this.cells[7].innerHTML;
		document.getElementById("amountStorno").value = this.cells[4].innerHTML;
		var units = document.getElementsByClassName("unitsStorno");
		for(var i = 0; i < units.length; i++)
		{
		    if(this.cells[5].innerHTML != '') units[i].value = this.cells[5].innerHTML;
		    else units[i].value = 'N.A.';
		}
		document.getElementById("dataEnd").value = this.cells[10].innerHTML;
		document.getElementById("motivStorno").value = this.cells[8].innerHTML;
		if(new Date(document.getElementById("dataEnd").value) < Date.now())
		{
		    document.getElementById("dataEnd").style.backgroundColor = "red";
		    document.getElementById("dataEnd").onchange();
		}
		else
		{
			document.getElementById("dataEnd").style.backgroundColor = "yellow";
			document.getElementById("dataEnd").onchange();
		}
		document.getElementById("observatii").value = this.cells[9].innerHTML;
		document.getElementById("action").value = null;
		var POProws = document.getElementById("formPOPtable").rows.length;
		document.getElementById("formPOP").style.display = "none";
		for(var i = POProws - 1; i > 0; i--)
		{
		    document.getElementById("formPOPtable").deleteRow(i);
	    }
    }
}
function updateprodStorno()
{
	var prodStorno = document.getElementById('productStorno').value;
	var marcaStorno = document.getElementById('rekrowStorno').value;
	if(marcaStorno != '')
	{
		if(window.XMLHttpRequest)
		{
		    xmlUPS = new XMLHttpRequest();
		}
		else
		{
		    xmlUPS = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlUPS.onreadystatechange = function()
		{
		    if(xmlUPS.readyState==4 && xmlUPS.status==200)
		    {
				const prodesc = xmlUPS.responseText.split('^');
				if(prodesc.length <= 9)
				{
			        document.getElementById("productNameStorno").value = prodesc[0];
			    	document.getElementById("furnizorStorno").value = prodesc[1];
			    	document.getElementById("stockStorno").value = prodesc[2];
			    	var units = document.getElementsByClassName("unitsStorno");
					for(var i = 0; i < units.length; i++)
					{
				        if(prodesc[3] != '') units[i].value = prodesc[3];
				    	else units[i].value = 'N.A.';
					}
				}
				else
				{
					document.getElementById("formPOP").style.display = "block";
					var POPtable = document.getElementById("formPOPtable");
					var count = 0;
					for(var i = 0; i < prodesc.length; i = i + 9)
					{
					 	if(prodesc[i] != '')
					 	{
						 	count++;
			     			var POProw = POPtable.insertRow();
			     			POProw.style.borderStyle = "2px solid RGB(102,252,3)";
			     			POProw.addEventListener("click", updateSTORNOform);
					     	var POPcell = POProw.insertCell(0);
					     	POPcell.style.borderStyle = "1px solid RGB(102,252,3)";
					     	POPcell.style.fontSize = 12;
				 			POPcell.innerHTML = count;
					     	POPcell = POProw.insertCell(1);
					     	POPcell.style.borderStyle = "solid RGB(102,252,3)";
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i];
					     	POPcell = POProw.insertCell(2);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodStorno;
					     	POPcell = POProw.insertCell(3);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+1];
					     	POPcell = POProw.insertCell(4);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+3];
					     	POPcell = POProw.insertCell(5);
					     	POPcell.style.fontSize = 12;
					     	if(prodesc[i+4] == '') {prodesc[i+4] = 'N.A.';}
					     	POPcell.innerHTML = prodesc[i+4];
	                        POPcell = POProw.insertCell(6);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+5];
					     	POPcell = POProw.insertCell(7);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+2];
					     	POPcell = POProw.insertCell(8);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+6];
					     	POPcell = POProw.insertCell(9);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+7];
					     	POPcell = POProw.insertCell(10);
					     	POPcell.style.fontSize = 12;
					     	POPcell.innerHTML = prodesc[i+8];
					    }
				    }
				}
		    }
		}
		xmlUPS.open('GET','get.product.php?codSAP='+prodStorno+'&marca='+marcaStorno,true);
		xmlUPS.send();
	}
}
function updateformStorno()
{
	var workern = document.getElementById('nameResultsStorno').value;
	if(window.XMLHttpRequest)
	{
	    xmlUFS = new XMLHttpRequest();
	}
	else
	{
	    xmlUFS = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlUFS.onreadystatechange = function()
	{
	    if(xmlUFS.readyState==4 && xmlUFS.status==200)
	    {
		    document.getElementById("rekrowStorno").value = xmlUFS.responseText;
		    document.getElementById("worker_form_storno").submit();
	    }
	}
	xmlUFS.open('GET','get.marca.php?numeworker='+workern,true);
	xmlUFS.send();
}
function getprodname()
{
    var prod = document.getElementById('product').value;
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
		    document.getElementById('productName').innerHTML = xmlhttp.responseText;
	    }
	    //else alert('Again stuck...: '+xmlhttp.readyState);
	}
	xmlhttp.open('GET','find.product.php?prod='+prod, true);
	xmlhttp.send();
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
function flashQuantity()
{
    var flash_Q = setInterval(flashQ,500);
    function flashQ()
    {
	    if(document.getElementById('amountImprumut').style.background != 'red')
		{
		    document.getElementById('amountImprumut').style.background = 'red';
		    if(document.activeElement != document.getElementById('amountImprumut'))
			{
				document.getElementById('amountImprumut').focus();
				document.getElementById('amountImprumut').select();
			}
		}
		else
		{
		    document.getElementById('amountImprumut').style.background = 'white';
		    if(document.activeElement != document.getElementById('amountImprumut'))
			{
				document.getElementById('amountImprumut').focus();
				document.getElementById('amountImprumut').select();
			}
		}
		document.getElementById('amountImprumut').onkeydown = function()
	 	{
			if(flash_Q == 1)
			{
		        clearInterval(flash_Q);
		        flash_Q = null;
		    	document.getElementById('amountImprumut').style.background = 'white';
                document.getElementById('action').value = null;
            }
	    }
    }
}
function flashProduct()
{
    var flashProd = setInterval(flashP,500);
    function flashP()
    {
        if(document.getElementById('productImprumut').style.background != 'red')
	    {
	        document.getElementById('productImprumut').style.background = 'red';
	        if(document.activeElement != document.getElementById('productImprumut'))
			{
				document.getElementById('productImprumut').focus();
				document.getElementById('productImprumut').select();
			}
		}
	 	else
		{
	        document.getElementById('productImprumut').style.background = 'white';
	        if(document.activeElement != document.getElementById('productImprumut'))
			{
				document.getElementById('productImprumut').focus();
				document.getElementById('productImprumut').select();
			}
		}
        document.getElementById('productImprumut').onkeydown = function()
        {
			if(flashProd == 1)
			{
	        	clearInterval(flashProd);
	        	flashProd = null;
	        	document.getElementById('productImprumut').style.background = 'white';
	        	document.getElementById('action').value = null;
	        	updateprodImprumut();
	        }
        }
    }
}
function formatDate()
{
    var formatDate = document.getElementById("dataEnd").value;
    console.log(formatDate);
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
		    document.getElementById('dataDisplay').innerHTML = xmlFD.responseText;
		    document.getElementById('dataDisplay').value = xmlFD.responseText;
		    document.getElementById('dataEnd').value = xmlFD.responseText;
	    }
	}
	xmlFD.open('GET','format.date.php?dateFormat='+formatDate, true);
	xmlFD.send();
}
function findproductImprumut()
{
	var pressedImprumut = event.key;
	if(pressedImprumut == 'Enter' && document.getElementById("productImprumut").value != '' && document.getElementById("productImprumut").value != 0)
	{
	    document.getElementById("product_form_imprumut").submit();
	}
	else
	{
		var productImprumut = document.getElementById("productImprumut").value;
		//alert(productImprumut);
	    if(window.XMLHttpRequest)
		{
		    xmlFPI = new XMLHttpRequest();
		}
		else
		{
		    xmlFPI = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlFPI.onreadystatechange = function()
		{
		    if(xmlFPI.readyState==4 && xmlFPI.status==200)
		    {
			    document.getElementById('resultsImprumut').innerHTML = xmlFPI.responseText;
		    }
		}
		xmlFPI.open('GET','find.product.php?product='+productImprumut, true);
		xmlFPI.send();
	}
}
function findworkerImprumut()
{
	if(document.getElementById("rekrowImprumut").value != null && document.getElementById("rekrowImprumut").value != ''){
		var worker = document.getElementById("rekrowImprumut").value;
	}
    if(window.XMLHttpRequest)
	{
	    xmlFWI = new XMLHttpRequest();
	}
	else
	{
	    xmlFWI = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlFWI.onreadystatechange = function()
	{
	    if(xmlFWI.readyState==4 && xmlFWI.status==200)
	    {
		    document.getElementById('marciImprumut').innerHTML = xmlFWI.responseText;
	    }
	}
	xmlFWI.open('GET','find.worker.php?worker='+worker, true);
	xmlFWI.send();
}
function findworkerbyname()
{
	if(document.getElementById("nameResults").value != null){
		var workername = document.getElementById("nameResults").value;
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
		    document.getElementById('numeworker').innerHTML = xmlhttp.responseText;
	    }
	}
	xmlhttp.open('GET','find.worker.php?numeworker='+workername, true);
	xmlhttp.send();
}
function updateprodImprumut()
{
	var prodImprumut = document.getElementById('productImprumut').value;
	if(window.XMLHttpRequest)
	{
	    xmlUPI = new XMLHttpRequest();
	}
	else
	{
	    xmlUPI = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlUPI.onreadystatechange = function()
	{
	    if(xmlUPI.readyState==4 && xmlUPI.status==200)
	    {
			//alert(xmlUPI.responseText);
			const prodesc = xmlUPI.responseText.split('^');
		    document.getElementById("productNameImprumut").value = prodesc[0];
		    document.getElementById("furnizorImprumut").value = prodesc[1];
		    document.getElementById("stockImprumut").value = prodesc[2];
		    var units = document.getElementsByClassName("unitsImprumut");
			for(var i = 0; i < units.length; i++)
			{
			    if(prodesc[3] != '') units[i].value = prodesc[3];
			    else units[i].value = 'N.A.';
			}
	    }
	}
	xmlUPI.open('GET','get.product.php?codSAP='+prodImprumut,true);
	xmlUPI.send();
}
function updateformImprumut()
{
	var workern = document.getElementById('nameResultsImprumut').value;
	if(window.XMLHttpRequest)
	{
	    xmlUFI = new XMLHttpRequest();
	}
	else
	{
	    xmlUFI = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlUFI.onreadystatechange = function()
	{
	    if(xmlUFI.readyState==4 && xmlUFI.status==200)
	    {
		    document.getElementById("rekrowImprumut").value = xmlUFI.responseText;
		    document.getElementById("worker_form_imprumut").submit();
	    }
	}
	xmlUFI.open('GET','get.marca.php?numeworker='+workern,true);
	xmlUFI.send();
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
	    else alert('Again stuck...: '+xmlhttp.readyState);
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
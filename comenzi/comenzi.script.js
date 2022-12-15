var gestionar = document.getElementById("numeGESTIONAR").innerHTML;

function displaySAP()
{
	if(document.getElementById('inputSAP').value != '')
	{
 	    document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=displaySAP&SAPcode="+document.getElementById('inputSAP').value+"&nume="+gestionar;
    }
}
function displayNAME()
{
    if(document.getElementById('inputNAME').value != '')
	{
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=displayNAME&PRODUCTname="+document.getElementById('inputNAME').value+"&nume="+gestionar;
	}
}
function displayFURNIZOR()
{
    if(document.getElementById('inputFURNIZOR').value != '')
	{
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=displayFURNIZOR&FURNIZOR="+encodeURIComponent(document.getElementById('inputFURNIZOR').value)+"&nume="+gestionar;
	}
}
function displayMagazie()
{
    if(document.getElementById('inputMAGAZIE').value != '')
	{
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=displayMAGAZIE&magazie="+document.getElementById('inputMAGAZIE').value+"&nume="+gestionar;
	}
}
function displayGRUPA()
{
    if(document.getElementById('inputGRUPA').value != '')
	{
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=displayGRUPA&grupa="+document.getElementById('inputGRUPA').value+"&nume="+gestionar;
	}
}
function searchFURNIZOR()
{
    var whoFURNIZOR = document.getElementById("inputFURNIZOR").value;
	if(window.XMLHttpRequest)
	{
	    xmlWHOfurnizor = new XMLHttpRequest();
	}
	else
	{
	    xmlWHOfurnizor = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlWHOfurnizor.onreadystatechange = function()
	{
	    if(xmlWHOfurnizor.readyState==4 && xmlWHOfurnizor.status==200)
	    {
			const responseLISTfurnizor = xmlWHOfurnizor.responseText.split('^');
			if(responseLISTfurnizor[0] == 'OK')
			{
			    document.getElementById("FURNIZORinputs").innerHTML = responseLISTfurnizor[1];
			}
			else{console.log(xmlWHOfurnizor.responseText);}
	    }
	}
	xmlWHOparams = 'furnizor='+whoFURNIZOR;
	xmlWHOfurnizor.open('POST','/ramira/magazie/comenzi/find.products.php', true);
	xmlWHOfurnizor.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlWHOfurnizor.send(xmlWHOparams);

}
function searchSAP()
{
    var whoSAP = document.getElementById("inputSAP").value;
	if(window.XMLHttpRequest)
	{
	    xmlWHOsap = new XMLHttpRequest();
	}
	else
	{
	    xmlWHOsap = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlWHOsap.onreadystatechange = function()
	{
	    if(xmlWHOsap.readyState==4 && xmlWHOsap.status==200)
	    {
			const responseLIST = xmlWHOsap.responseText.split('^');
			if(responseLIST[0] == 'OK')
			{
			    document.getElementById("SAPinputs").innerHTML = responseLIST[1];
			}
			else{console.log(xmlWHOsap.responseText);}
	    }
	}
	xmlWHOsapPARAMS = 'sapcode='+whoSAP;
	xmlWHOsap.open('POST','/ramira/magazie/comenzi/find.products.php', true);
	xmlWHOsap.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlWHOsap.send(xmlWHOsapPARAMS);

}
function searchNAME()
{
    var whoNAME = document.getElementById("inputNAME").value;
	if(window.XMLHttpRequest)
	{
	    xmlWHOname = new XMLHttpRequest();
	}
	else
	{
	    xmlWHOname = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlWHOname.onreadystatechange = function()
	{
	    if(xmlWHOname.readyState==4 && xmlWHOname.status==200)
	    {
			const responseLISTnames = xmlWHOname.responseText.split('^');
			if(responseLISTnames[0] == 'OK')
			{
			    document.getElementById("NAMEinputs").innerHTML = responseLISTnames[1];
			}
			else{console.log(xmlWHOname.responseText);}
	    }
	}
	WHOnamePARAMS = 'productname='+whoNAME;
	xmlWHOname.open('POST','/ramira/magazie/comenzi/find.products.php', true);
	xmlWHOname.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlWHOname.send(WHOnamePARAMS);

}
function shutALARM()
{
    if(window.XMLHttpRequest)
	{
	    xmlSA = new XMLHttpRequest();
	}
	else
	{
	    xmlSA = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlSA.onreadystatechange = function()
	{
	    if(xmlSA.readyState==4 && xmlSA.status==200)
	    {
			//console.log(verifyRAP.responseText);
			if(xmlSA.responseText == 'OK')
			{
				document.getElementById("alarmsOFF").style.display = "BLOCK";
				document.getElementById("alarmsON").style.display = "NONE";
				document.getElementById("headTEXT").innerHTML = '<CENTER>Alarmele de stoc au fost suspendate cu succes!<FONT STYLE = "FONT-SIZE: 0.9vw; COLOR: BLACK;"><BR>Daca nu sunt solutionate pana la urmatoarea logare, acestea vor fi activate din nou.</FONT><BR><BR></CENTER>';
				document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=0";
			}
			else {console.log(xmlSA.responseText)}
	    }
	}
	xmlSAparams = 'alarm=stopALARMS'
	xmlSA.open('POST','/ramira/magazie/comenzi/buttons.actions.php', true);
	xmlSA.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlSA.send(xmlSAparams);
}
function showALARMprod()
{
    document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=showALARMprod&nume="+gestionar;
}
function createORDERS()
{
    alert('Trebuie sa deschid formular de creere comenzi.');
}
function showSTOCKS()
{
	if(document.getElementById("showSTOCKoptions").style.display == "none")
	{
		document.getElementById("inputSAP").value = '';
		document.getElementById("inputNAME").value = '';
		document.getElementById("inputFURNIZOR").value = '';
		document.getElementById("inputMAGAZIE").value = 'MAGAZIE';
		document.getElementById("inputGRUPA").value = 'GRUPA MATERIALE';
		document.getElementById("showSTOCKoptions").style.display = "BLOCK";
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=showSTOCKS&nume="+gestionar;
	}
	else
	{
		document.getElementById("showSTOCKoptions").style.display = "NONE";
		document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=0&nume="+gestionar;
	}
}
function showPROVIDE()
{
    document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/providers.low.stocks.php?alarm=showPROVIDERS&nume="+gestionar;
}
function showDROPPINGstocks()
{
    document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/providers.low.stocks.php?alarm=showDROPPINGstocks&nume="+gestionar;
}
function sortTABLE()
{
    var sortVAL = document.getElementById("tableSORTING").value;
    var refVAL = ''; var tableCOL = '';
    if(document.getElementById("inputSAP").value != '')
	{
		refVAL = document.getElementById("inputSAP").value;
		tableCOL = 'cod_SAP';
	}
    if(document.getElementById("inputNAME").value != '')
	{
		refVAL = document.getElementById("inputNAME").value;
		tableCOL = 'denumire';
	}
    if(document.getElementById("inputFURNIZOR").value != '')
	{
		refVAL = encodeURIComponent(document.getElementById("inputFURNIZOR").value);
		tableCOL = 'furnizor';
	}
    if(document.getElementById("inputMAGAZIE").value != 'MAGAZIE')
	{
		refVAL = document.getElementById("inputMAGAZIE").value;
		tableCOL = 'magazie';
	}
    if(document.getElementById("inputGRUPA").value != 'GRUPA MATERIALE')
	{
		refVAL = document.getElementById("inputGRUPA").value;
		tableCOL = 'grupa_MAT';
	}
	document.getElementById("displaySECTION").src = "/ramira/magazie/comenzi/table.display.php?alarm=sortTABLE&column="+tableCOL+"&reference="+refVAL+"&sortby="+sortVAL+"&nume="+gestionar;
}
function clearFORM()
{
    if(document.getElementById("inputSAP") == document.activeElement)
    {
		document.getElementById("inputNAME").value = '';
		document.getElementById("inputFURNIZOR").value = '';
		document.getElementById("inputMAGAZIE").value = 'MAGAZIE';
		document.getElementById("inputGRUPA").value = 'GRUPA MATERIALE';
    }
    else if(document.getElementById("inputNAME") == document.activeElement)
    {
	    document.getElementById("inputSAP").value = '';
		document.getElementById("inputFURNIZOR").value = '';
		document.getElementById("inputMAGAZIE").value = 'MAGAZIE';
		document.getElementById("inputGRUPA").value = 'GRUPA MATERIALE';
    }
    else if(document.getElementById("inputFURNIZOR") == document.activeElement)
    {
	    document.getElementById("inputSAP").value = '';
		document.getElementById("inputNAME").value = '';
		document.getElementById("inputMAGAZIE").value = 'MAGAZIE';
		document.getElementById("inputGRUPA").value = 'GRUPA MATERIALE';
    }
    else if(document.getElementById("inputMAGAZIE") == document.activeElement)
    {
	    document.getElementById("inputSAP").value = '';
		document.getElementById("inputNAME").value = '';
		document.getElementById("inputFURNIZOR").value = '';
		document.getElementById("inputGRUPA").value = 'GRUPA MATERIALE';
    }
    else if(document.getElementById("inputGRUPA") == document.activeElement)
    {
	    document.getElementById("inputSAP").value = '';
		document.getElementById("inputNAME").value = '';
		document.getElementById("inputFURNIZOR").value = '';
		document.getElementById("inputMAGAZIE").value = 'MAGAZIE';
    }
    else
    {
	    console.log(document.activeElement);
    }
}
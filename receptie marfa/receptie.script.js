var receptieTABLE = document.getElementById('formRECEPTIEtable');
var receptieFORM = document.getElementById('receptieFORM');
var formBUTTON = document.getElementById('formBUTTON');
var factura = document.getElementById('facturaFIELD');
var dataFIELD = document.getElementById('invoicedateFIELD');
var furnizor = document.getElementById('furnizorFIELD');
var invoiceDATE = document.getElementById('invoicedateFIELD');
var codSAP = document.getElementById('codsapFIELD');
var codfurnizor = document.getElementById('codfurnizorFIELD');
var denumire = document.getElementById('denumireFIELD');
var detalii = document.getElementById('detaliiFIELD');
var magazie = document.getElementById('magazieFIELD');
var grupa = document.getElementById('grupaFIELD');
var amount = document.getElementById('amountFIELD');
var stocfinal = document.getElementById('stocfinalFIELD');
var cantmin = document.getElementById('cantminFIELD');
var cantopt = document.getElementById('cantoptFIELD');
var pret = document.getElementById('pretFIELD');
var totalprice = document.getElementById('valueFIELD');
var oras = document.getElementById('adLOCFIELD');
var strada = document.getElementById('adSTRFIELD');
var nrSTR = document.getElementById('adNRFIELD');
var codPOSTAL = document.getElementById('adCPFIELD');
var judet = document.getElementById('adJUDFIELD');
var tara = document.getElementById('adTARAFIELD');
var telefon = document.getElementById('telFIELD');
var mail = document.getElementById('mailFIELD');
var contact = document.getElementById('persFIELD');
var departament = document.getElementById('departFIELD');
var apel = document.getElementById('apelFIELD');
var invoice = document.getElementById('recINVOICE');
if(document.getElementById('numeGESTIONAR') != null)
{
    var gestionar = document.getElementById('numeGESTIONAR').innerHTML;
}
else if(window.parent.document.getElementById('numeGESTIONAR') != null)
{
    var gestionar = window.parent.document.getElementById('numeGESTIONAR').innerHTML;
}
var workingIMG = document.getElementById('workingIMAGE');

function chkINPUTdepart()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('departFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' '\.]/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('departFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    if(document.getElementById('departFURNIZORnou').value != '' && document.getElementById('emailFURNIZORnou').value != '' && document.getElementById('telFURNIZORnou').value != '' && document.getElementById('persoanaFURNIZORnou').value != '' && document.getElementById('apelativFURNIZORnou').value != '' && document.getElementById('taraFURNIZORnou').value != '' && document.getElementById('judetFURNIZORnou').value != '' && document.getElementById('nrstrFURNIZORnou').value != '' && document.getElementById('stradaFURNIZORnou').value != '' && document.getElementById('codpostalFURNIZORnou').value != '' && document.getElementById('locFURNIZORnou').value != '' && document.getElementById('numeFURNIZORnou').value != '')
	    {
		    if(window.XMLHttpRequest)
			{
			    furIN = new XMLHttpRequest();
			}
			else
			{
			    furIN = new ActiveXObject('Microsoft.XMLHTTP');
			}
			furIN.onreadystatechange = function()
			{
			    if(furIN.readyState==4 && furIN.status==200)
			    {
					furINreply = furIN.responseText.split('^');
					if(furINreply[0] == 'OK')
					{
						furnizor.value = furINreply[1];
						oras.value = furINreply[2];
						strada.value = furINreply[3];
						nrSTR.value = furINreply[4];
						codPOSTAL.value = furINreply[5];
						judet.value = furINreply[6];
						tara.value = furINreply[7];
						telefon.value = furINreply[8];
						mail.value = furINreply[9];
						contact.value = furINreply[10];
						departament.value = furINreply[11];
						apel.value = furINreply[12];
						codSAP.focus();
						document.getElementById('furnizorFORM').style.display = 'none';
					}
					else if(furINreply[0] == 'Furnizor already registered')
					{
					    alert('Acest furnizor este deja inregistrat.\nPentru modificari, folositi optiunea Modificare Furnizor din sectiunea Extras.\n(optiune inca inexistenta, de altfel...)');
						document.getElementById('furnizorFORM').style.display = 'none';
					}
					else{console.log(furIN.responseText);}
			    }
			}
			furINparams = 'numeFURNIZOR='+encodeURIComponent(document.getElementById('numeFURNIZORnou').value)+'&codFURNIZOR='+document.getElementById('codFURNIZORnou').value+'&locFURNIZOR='+document.getElementById('locFURNIZORnou').value+'&codPOSTAL='+document.getElementById('codpostalFURNIZORnou').value+'&strada='+document.getElementById('stradaFURNIZORnou').value+'&nrSTR='+document.getElementById('nrstrFURNIZORnou').value+'&judet='+document.getElementById('judetFURNIZORnou').value+'&tara='+document.getElementById('taraFURNIZORnou').value+'&apelativ='+document.getElementById('apelativFURNIZORnou').value+'&persoana='+document.getElementById('persoanaFURNIZORnou').value+'&telefon='+document.getElementById('telFURNIZORnou').value+'&email='+document.getElementById('emailFURNIZORnou').value+'&departament='+document.getElementById('departFURNIZORnou').value;
			furIN.open('POST','/ramira/magazie/receptie marfa/inserare.furnizor.php', true);
			furIN.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			furIN.send(furINparams);
	    }
	    else
	    {
		    console.log('Something\'s wrong in Argentina!');
	    }
	}
}

function chkINPUTmail()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('emailFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\@\.\_\-]/i.test(event.key)){document.activeElement.style.textTransform = "none";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('emailFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('departFURNIZORnou').focus();
	}
}

function chkINPUTtel()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('telFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\+\.\' ']/i.test(event.key)){document.activeElement.style.textTransform = "none";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('telFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('emailFURNIZORnou').focus();
	}
}

function chkINPUTpers()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('persoanaFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('persoanaFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('telFURNIZORnou').focus();
	}
}

function moveFOCUSapelativ()
{
    document.getElementById('persoanaFURNIZORnou').focus();
}

function chkINPUTtara()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('taraFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('taraFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('apelativFURNIZORnou').focus();
	}
}

function chkINPUTjudet()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('judetFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('judetFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('taraFURNIZORnou').focus();
	}
}

function chkINPUTnrstr()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('nrstrFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "uppercase";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('nrstrFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('judetFURNIZORnou').focus();
	}
}
function chkINPUTstrada()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('stradaFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('stradaFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('nrstrFURNIZORnou').focus();
	}
}

function chkINPUTpost()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('codpostalFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[0-9]/i.test(event.key)){document.activeElement.style.textTransform = "uppercase";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('codpostalFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('stradaFURNIZORnou').focus();
	}
}

function chkINPUTlocalitate()
{
    var pressed = event.key;
	if(document.activeElement == document.getElementById('locFURNIZORnou') && pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
		if(/[a-z0-9\' ']/i.test(event.key)){document.activeElement.style.textTransform = "capitalize";}
  		else{event.preventDefault();}
	}
	else if(document.activeElement == document.getElementById('locFURNIZORnou') && pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
	    document.getElementById('codpostalFURNIZORnou').focus();
	}
}

function chkINPUTfurnizor()
{
    var pressed = event.key;
	if(pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
	{
	    if(document.activeElement == document.getElementById('numeFURNIZORnou'))
	    {
		    if(/[a-z0-9\&\' '\.]/i.test(event.key)){document.activeElement.style.textTransform = "uppercase";}
		    else{event.preventDefault();}
	    }
	}
	else if(pressed == 'Enter' || pressed == 'Tab')
	{
	    event.preventDefault();
        if(window.XMLHttpRequest)
		{
		    newFUR = new XMLHttpRequest();
		}
		else
		{
		    newFUR = new ActiveXObject('Microsoft.XMLHTTP');
		}
		newFUR.onreadystatechange = function()
		{
		    if(newFUR.readyState==4 && newFUR.status==200)
		    {
				newFURreply = newFUR.responseText.split('^');
				if(newFURreply[0] == 'OK')
				{
					document.getElementById('codFURNIZORnou').value = newFURreply[1];
					document.getElementById('locFURNIZORnou').focus();
				}
				else if(newFURreply[0] == 'Furnizor already registered')
				{
				    alert('Acest furnizor este deja inregistrat.\nPentru modificari, folositi optiunea Modificare Furnizor din sectiunea Extras.\n(optiune inca inexistenta, de altfel...)');
					document.getElementById('furnizorFORM').style.display = 'none';
				}
				else{console.log(newFUR.responseText);}
		    }
		}
		newFURparams = 'numeFURNIZORset='+encodeURIComponent(document.getElementById('numeFURNIZORnou').value);
		newFUR.open('POST','/ramira/magazie/receptie marfa/inserare.furnizor.php', true);
		newFUR.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		newFUR.send(newFURparams);
	}
}

function goPRINTrec()
{
    if(document.getElementById('bonTABLE').rows.length > 1)
	{
		window.parent.workingIMG.style.display = 'block';
		var rowsNUM = document.getElementById('bonTABLE').rows.length;
		for(i=1; i < rowsNUM; i++)
		{
			if(window.XMLHttpRequest)
			{
			    regREC = new XMLHttpRequest();
			}
			else
			{
			    regREC = new ActiveXObject('Microsoft.XMLHTTP');
			}
			regREC.onreadystatechange = function()
			{
			    if(regREC.readyState==4 && regREC.status==200)
			    {
					regRECreply = regREC.responseText.split('^');
					if(regRECreply[0] == 'OK')
					{
						//console.log(regREC.responseText);
						if(i == rowsNUM)
						{
						    document.getElementById('RECprintBUTTON').style.visibility = 'hidden';
					    	document.getElementById('exportBUTTON').style.visibility = 'hidden';
					    	window.print();
					    	document.getElementById('RECprintBUTTON').style.visibility = 'visible';
					    	document.getElementById('exportBUTTON').style.visibility = 'visible';
					    	for(k = (rowsNUM - 1); k > 0; k--)
					    	{
							    document.getElementById('bonTABLE').deleteRow(k);
						    }
							window.parent.factura.value = '';
						    window.parent.invoiceDATE.value = '';
						    window.parent.furnizor.value = '';
						    window.parent.codSAP.value = '';
						    window.parent.codfurnizor.value = '';
						    window.parent.denumire.value = '';
						    window.parent.detalii.value = '';
						    window.parent.magazie.value = '';
						    window.parent.grupa.value = '';
						    window.parent.amount.value = '';
						    window.parent.stocfinal.value = '';
						    window.parent.cantmin.value = '';
						    window.parent.cantopt.value = '';
						    window.parent.pret.value = '';
						    window.parent.totalprice.value = '';
						    window.parent.oras.value = '';
						    window.parent.strada.value = '';
						    window.parent.nrSTR.value = '';
						    window.parent.codPOSTAL.value = '';
						    window.parent.judet.value = '';
						    window.parent.tara.value = '';
						    window.parent.telefon.value = '';
						    window.parent.mail.value = '';
						    window.parent.contact.value = '';
						    window.parent.departament.value = '';
						    window.parent.apel.value = '';
						    if(window.parent.receptieTABLE.rows.length > 2)
						    {
								var tableROWS = window.parent.receptieTABLE.rows.length;
							    for(i = tableROWS - 1; i > 1; i--)
							    {
								    window.parent.receptieTABLE.deleteRow(i);
							    }
						    }
						    window.parent.workingIMG.style.display = 'none';
							window.parent.invoice.src = "/ramira/magazie/receptie marfa/funny.php";
							window.parent.formBUTTON.style.display = 'block';
						}
					}
					else
					{
						console.log(regREC.responseText);
						if(window.parent.workingIMG.style.display != 'none'){window.parent.workingIMG.style.display = 'none';}
					}
			    }
			}
			codulSAP = document.getElementById('codsapCELL' + i).innerHTML;
			furnizor = document.getElementById('furnizorFRAME').innerHTML;
			seria = document.getElementById('facseriaFRAME').innerHTML;
			facDATE = document.getElementById('facdateFRAME').innerHTML;
			codFURNIZOR = document.getElementById('codfurnizorCELL' + i).innerHTML;
			denumirePROD = document.getElementById('denumireCELL' + i).innerHTML;
			pretPROD = document.getElementById('pretCELL' + i).innerHTML;
			cantitatePROD = document.getElementById('amountCELL' + i).innerHTML;
			detaliiPROD = document.getElementById('detailsCELL' + i).innerHTML;
			seriaNOTA = document.getElementById('seriaNOTA').innerHTML;
			dataNOTA = document.getElementById('dataNOTA').innerHTML;
			prodUNITS = document.getElementById('unitsCELL' + i).innerHTML;
			magPROD = document.getElementById('magazieCELL' + i).innerHTML;
			grupPROD = document.getElementById('grupaCELL' + i).innerHTML;
			cantMINprod = document.getElementById('cantminCELL' + i).innerHTML;
			cantOPTprod = document.getElementById('cantoptCELL' + i).innerHTML
			regRECparams = 'codSAP='+encodeURIComponent(codulSAP)+'&furnizor='+encodeURIComponent(furnizor)+'&factura='+seria+'&facDATE='+facDATE+'&codFURNIZOR='+codFURNIZOR+'&denumire='+encodeURIComponent(denumirePROD)+'&pret='+pretPROD+'&cantitate='+cantitatePROD+'&detalii='+detaliiPROD+'&units='+prodUNITS+'&seriaNOTA='+encodeURIComponent(seriaNOTA)+'&dataNOTA='+dataNOTA+'&gestionar='+gestionar+'&magazie='+magPROD+'&grupa='+grupPROD+'&cantMIN='+cantMINprod+'&cantOPT='+cantOPTprod;
			regREC.open('POST','/ramira/magazie/receptie marfa/register.incoming.products.php', true);
			regREC.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			regREC.send(regRECparams);
		}
    }
}

function recordRECEPTIE()
{
    if(factura.value != '' && dataFIELD.value != '' && furnizor.value != '' && oras.value != '' && strada.value != '' && nrSTR.value != '' && codPOSTAL.value != '' && judet.value != '' && tara.value != '' && telefon.value != '' && mail.value != '' && contact.value != '' && departament.value != '' && apel.value != '' && codSAP.value != '' && codfurnizor.value != '' && denumire.value != '' && magazie.value != '' && grupa.value != '' && amount.value != '' && stocfinal.value != '' && cantmin.value != '' && cantopt.value != '' && pret.value != '' && totalprice.value != '')
    {
		workingIMG.style.display = 'block';
	    invoice.contentWindow.document.getElementById('furnizorFRAME').innerHTML = furnizor.value;
	    invoice.contentWindow.document.getElementById('orasFRAME').innerHTML = oras.value;
	    invoice.contentWindow.document.getElementById('stradaFRAME').innerHTML = strada.value;
	    invoice.contentWindow.document.getElementById('nrstrFRAME').innerHTML = nrSTR.value;
	    invoice.contentWindow.document.getElementById('judetFRAME').innerHTML = judet.value;
	    invoice.contentWindow.document.getElementById('facseriaFRAME').innerHTML = factura.value;
	    invoice.contentWindow.document.getElementById('facdateFRAME').innerHTML = dataFIELD.value;
	    var tabelBON = invoice.contentWindow.document.getElementById('bonTABLE');
	    var recLONG = receptieTABLE.rows.length;
		for(i=1; i < (recLONG); i++)
	    {
			var bonLONG = tabelBON.rows.length;
			if(bonLONG == 1)
			{
				sapTOchk = codSAP.value;
			}
			else
			{
				//console.log(document.getElementById('codsapFIELD' + (bonLONG - 1)).id);
			    sapTOchk = document.getElementById('codsapFIELD' + (bonLONG - 1)).value;
			}
			if(sapTOchk != '')
		    {
			    var bonROW = tabelBON.getElementsByTagName('tbody')[0].insertRow();
			    var bonCELL = bonROW.insertCell(0);
			    bonCELL.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					sapVALUE = codSAP.value
				}
				else 
				{
				    sapVALUE = document.getElementById('codsapFIELD' + (bonCELL.parentNode.rowIndex - 1)).value;
				}
			    bonCELL.innerHTML = sapVALUE;
			    bonCELL.id = 'codsapCELL' + bonLONG;
			    var bonCELL2 = bonROW.insertCell(1);
			    bonCELL2.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					cfVALUE = document.getElementById('codfurnizorFIELD').value
				}
				else 
				{
				    cfVALUE = document.getElementById('codfurnizorFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL2.innerHTML = cfVALUE;
			    bonCELL2.id = 'codfurnizorCELL' + bonLONG;
			    var bonCELL3 = bonROW.insertCell(2);
			    bonCELL3.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					denumireVALUE = document.getElementById('denumireFIELD').value
				}
				else 
				{
				    denumireVALUE = document.getElementById('denumireFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL3.innerHTML = denumireVALUE;
			    bonCELL3.id = 'denumireCELL' + bonLONG;
			    var bonCELL4 = bonROW.insertCell(3);
			    bonCELL4.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					pretVALUE = document.getElementById('pretFIELD').value
				}
				else 
				{
				    pretVALUE = document.getElementById('pretFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL4.innerHTML = pretVALUE;
			    bonCELL4.id = 'pretCELL' + bonLONG;
			    var bonCELL5 = bonROW.insertCell(4);
			    bonCELL5.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					cantVALUE = document.getElementById('amountFIELD').value
				}
				else
				{
				    cantVALUE = document.getElementById('amountFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL5.innerHTML = cantVALUE;
			    bonCELL5.id = 'amountCELL' + bonLONG;
			    var bonCELL6 = bonROW.insertCell(5);
			    bonCELL6.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					umVALUE = document.getElementById('unit').value
				}
				else 
				{
				    umVALUE = document.getElementById('unit' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL6.innerHTML = umVALUE;
			    bonCELL6.id = 'unitsCELL' + bonLONG;
			    var bonCELL7 = bonROW.insertCell(6);
			    bonCELL7.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					detVALUE = document.getElementById('detaliiFIELD').value
				}
				else 
				{
				    detVALUE = document.getElementById('detaliiFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL7.innerHTML = detVALUE;
			    bonCELL7.id = 'detailsCELL' + bonLONG;
			    var bonCELL8 = bonROW.insertCell(7);
			    bonCELL8.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					magVALUE = document.getElementById('magazieFIELD').value
				}
				else 
				{
				    magVALUE = document.getElementById('magazieFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL8.innerHTML = magVALUE;
			    bonCELL8.id = 'magazieCELL' + bonLONG;
			    var bonCELL9 = bonROW.insertCell(8);
			    bonCELL9.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					grupVALUE = document.getElementById('grupaFIELD').value
				}
				else 
				{
				    grupVALUE = document.getElementById('grupaFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				}
			    bonCELL9.innerHTML = grupVALUE;
			    bonCELL9.id = 'grupaCELL' + bonLONG;
			    var bonCELL10 = bonROW.insertCell(9);
			    bonCELL10.style.borderBottom = '1px SOLID RGB(0,0,0)';
			    if(bonLONG == 1)
				{
					valVALUE = document.getElementById('valueFIELD').value;
					minCANT = document.getElementById('cantminFIELD').value;
					optCANT = document.getElementById('cantoptFIELD').value;
				}
				else 
				{
				    valVALUE = document.getElementById('valueFIELD' + (bonCELL.parentNode.rowIndex - 1)).value
				    minCANT = document.getElementById('cantminFIELD' + (bonCELL.parentNode.rowIndex - 1)).value;
					optCANT = document.getElementById('cantoptFIELD' + (bonCELL.parentNode.rowIndex - 1)).value;
				}
			    bonCELL10.innerHTML = valVALUE+'<DIV ID = "cantminCELL'+bonLONG+'" STYLE = "DISPLAY: NONE">' + minCANT + '</DIV><DIV ID = "cantoptCELL'+ bonLONG +'" STYLE = "DISPLAY: NONE">' + optCANT + '</DIV>';
			    bonCELL10.id = 'valueCELL' + bonLONG;
	        }
	    }
        receptieFORM.style.display = 'none';
	    workingIMG.style.display = 'none';
	    invoice.contentWindow.document.getElementById('RECprintBUTTON').focus();
    }
}

function SAPprocess()
{
    var sapROW = document.activeElement.parentNode.parentNode.rowIndex;
    if(window.XMLHttpRequest)
	{
	    procSAP = new XMLHttpRequest();
	}
	else
	{
	    procSAP = new ActiveXObject('Microsoft.XMLHTTP');
	}
	procSAP.onreadystatechange = function()
	{
	    if(procSAP.readyState==4 && procSAP.status==200)
	    {
			procSAPreply = procSAP.responseText.split('^');
			if(procSAPreply[0] == 'OK')
			{
				if(document.activeElement.id == codSAP.id)
				{
				    codfurnizor.value = procSAPreply[1];
				    denumire.value = procSAPreply[2];
				    detalii.value = procSAPreply[3];
				    magazie.value = procSAPreply[4];
				    grupa.value = procSAPreply[5];
				    amount.value = '0.00';
				    stocfinal.value = procSAPreply[6];
				    cantmin.value = procSAPreply[7];
				    cantopt.value = procSAPreply[8];
				    pret.value = procSAPreply[9];
				    totalprice.value = '0.00';
				    if(furnizor.value == '')
				    {
					    furnizor.value = procSAPreply[10];
					    if(window.XMLHttpRequest)
						{
						    addFUR = new XMLHttpRequest();
						}
						else
						{
						    addFUR = new ActiveXObject('Microsoft.XMLHTTP');
						}
						addFUR.onreadystatechange = function()
						{
						    if(addFUR.readyState==4 && addFUR.status==200)
						    {
								//console.log('moveON function response: '+chkFUR.responseText);
								addFURreply = addFUR.responseText.split('^');
								if(addFURreply[0] == 'OK furnizor')
								{
								   //alert('Received data: '+chkFURreply[1]);
								   if(addFURreply[1] == 'Continue')
								   {
									   judet.value = addFURreply[2];
									   oras.value = addFURreply[3];
									   strada.value = addFURreply[4];
									   nrSTR.value = addFURreply[5];
									   codPOSTAL.value = addFURreply[6];
									   tara.value = addFURreply[7];
									   mail.value = addFURreply[8];
									   telefon.value = addFURreply[9];
									   contact.value = addFURreply[10];
									   departament.value = addFURreply[11];
									   apel.value = addFURreply[12];
									   if(receptieTABLE.rows.length == 2)
									   {
									       amount.focus();
									       amount.select();
									   }
								   }
								   else if(addFURreply[1] == 'Furnizor nou')
								   {
								   	   document.getElementById('furnizorFORM').style.display = 'block';
			   	   					   document.getElementById('numeFURNIZORnou').focus();
								   }
								}
								else{console.log(addFUR.responseText);}
						    }
						}
						addFURparams = 'furnizorcheck='+encodeURIComponent(furnizor.value);
						addFUR.open('POST','/ramira/magazie/receptie marfa/find.php', true);
						addFUR.setRequestHeader('Content-type','application/x-www-form-urlencoded');
						addFUR.send(addFURparams);
				    }
				    document.getElementById('unit').value = procSAPreply[11];
				    document.getElementById('unitSTOC').value = procSAPreply[11];
				    document.getElementById('unitMIN').value = procSAPreply[11];
				    document.getElementById('unitOPT').value = procSAPreply[11];
				    amount.focus();
				    amount.select();
				}
				else
				{
				    document.getElementById('codfurnizorFIELD'+(sapROW-1)).value = procSAPreply[1];
				    document.getElementById('denumireFIELD'+(sapROW-1)).value = procSAPreply[2];
				    document.getElementById('detaliiFIELD'+(sapROW-1)).value = procSAPreply[3];
				    document.getElementById('magazieFIELD'+(sapROW-1)).value = procSAPreply[4];
				    document.getElementById('grupaFIELD'+(sapROW-1)).value = procSAPreply[5];
				    document.getElementById('amountFIELD'+(sapROW-1)).value = '0.00';
				    document.getElementById('stocfinalFIELD'+(sapROW-1)).value = procSAPreply[6];
				    document.getElementById('cantminFIELD'+(sapROW-1)).value = procSAPreply[7];
				    document.getElementById('cantoptFIELD'+(sapROW-1)).value = procSAPreply[8];
				    document.getElementById('pretFIELD'+(sapROW-1)).value = procSAPreply[9];
				    document.getElementById('valueFIELD'+(sapROW-1)).value = '0.00';
				    document.getElementById('unit'+(sapROW-1)).value = procSAPreply[11];
				    document.getElementById('unitSTOC'+(sapROW-1)).value = procSAPreply[11];
				    document.getElementById('unitMIN'+(sapROW-1)).value = procSAPreply[11];
				    document.getElementById('unitOPT'+(sapROW-1)).value = procSAPreply[11];
	    			document.getElementById('amountFIELD'+(sapROW-1)).focus();
	    			document.getElementById('amountFIELD'+(sapROW-1)).select();
				}
			   //console.log(chkSAP.responseText);
			}
			else if(procSAPreply[0] == 'Already registered')
			{
			    if(document.activeElement.id == codSAP.id)
				{
				    codSAP.focus();
					codSAP.select();
				}
				else
				{
				    document.getElementById('codsapFIELD'+(sapROW-1)).focus();
					document.getElementById('codsapFIELD'+(sapROW-1)).select();
				}
				alert('Acest produs a fost receptionat deja!');
			}
			else if(procSAPreply[0] == 'New SAP code')
			{
				
			}
			else{console.log(procSAP.responseText);}
	    }
	}
	if(document.activeElement == codSAP){var codulSAP = codSAP.value;}
	else if((document.activeElement.id).search("codsapFIELD") != -1){var codulSAP = document.activeElement.value}
	SAPparams = 'checkSAP='+encodeURIComponent(codulSAP)+'&furnizor='+encodeURIComponent(furnizor.value)+'&seria='+factura.value+'&facDATE='+dataFIELD.value;
	procSAP.open('POST','/ramira/magazie/receptie marfa/find.php', true);
	procSAP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	procSAP.send(SAPparams);

}

function findSAP()
{
	if(codSAP.value != '' && document.activeElement.value != '')
	{
	    if(window.XMLHttpRequest)
		{
		    chkSAP = new XMLHttpRequest();
		}
		else
		{
		    chkSAP = new ActiveXObject('Microsoft.XMLHTTP');
		}
		chkSAP.onreadystatechange = function()
		{
		    if(chkSAP.readyState==4 && chkSAP.status==200)
		    {
				chkSAPreply = chkSAP.responseText.split('^');
				if(chkSAPreply[0] == 'OK')
				{
					if(document.activeElement.id == codSAP.id)
					{
					    document.getElementById('sapRESULTS').innerHTML = chkSAPreply[1];
					}
					else if((document.activeElement.id).search("codsapFIELD") != -1)
					{
					    var sapROW = document.activeElement.parentNode.parentNode.rowIndex;
	    				document.getElementById('sapRESULTS'+(sapROW-1)).innerHTML = chkSAPreply[1];
					}
				}
				else{console.log(chkSAP.responseText);}
		    }
		}
		SAPparams = 'grabSAP='+encodeURIComponent(document.activeElement.value);
		chkSAP.open('POST','/ramira/magazie/receptie marfa/find.php', true);
		chkSAP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		chkSAP.send(SAPparams);
    }
}
function sapKEYSchk()
{
    var pressed = event.key;
    if(pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
    {
	    if(document.activeElement == codSAP || (document.activeElement.id).search("codsapFIELD") != -1)
	    {
		    if(/[a-z0-9]/i.test(event.key))
		    {
			    caps();
		    }
		    else
		    {
				event.preventDefault();
		    }
	    }
    }
    else if(pressed != 'Backspace')
    {
		event.preventDefault();
	    moveON();
    }
}
function cffKEYSchk()
{
    var pressed = event.key;
    if(pressed != 'Enter' && pressed != 'Tab' && pressed != 'Backspace')
    {
	    if(document.activeElement == codfurnizor || (document.activeElement.id).search("codfurnizorFIELD") != -1)
	    {
		    if(/[a-z0-9]/i.test(event.key))
		    {
			    caps();
		    }
		    else
		    {
				event.preventDefault();
		    }
	    }
    }
    else if(pressed == 'Enter' || pressed == 'Tab')
    {
		event.preventDefault();
		if(document.activeElement.id == codfurnizor.id)
		{
		    var SAPupgraded = codSAP.value;
		}
		else if((document.activeElement.id).search("codfurnizorFIELD") != -1)
		{
			var myROW = document.activeElement.parentNode.parentNode.rowIndex;
		    var SAPupgraded = document.getElementById('codsapFIELD'+(myROW-1)).value;
		}
		var furnizor2FIX = furnizor.value;
		if(furnizor2FIX != '')
		{
		    if(window.XMLHttpRequest)
			{
			    CFFkc = new XMLHttpRequest();
			}
			else
			{
			    CFFkc = new ActiveXObject('Microsoft.XMLHTTP');
			}
			CFFkc.onreadystatechange = function()
			{
			    if(CFFkc.readyState==4 && CFFkc.status==200)
			    {
					CFFkcreply = CFFkc.responseText.split('^');
					if(CFFkcreply[0] == 'OK')
					{
						alert('Codul a fost actualizat cu succes!');
					}
					else if(CFFkcreply[0] == 'Not found')
					{
					    alert('Nu s-a gasit in magazie produsul la acest furnizor.\nCodul va fi actualizat la finalizarea receptiei.');
					}
					else{console.log(CFFkc.responseText);}
			    }
			}
			CFFkcparams = 'codFURNIZOR='+encodeURIComponent(document.activeElement.value)+'&codSAPfix='+encodeURIComponent(SAPupgraded)+'&furnizorFIX='+encodeURIComponent(furnizor2FIX);
			CFFkc.open('POST','/ramira/magazie/receptie marfa/find.php', true);
			CFFkc.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			CFFkc.send(CFFkcparams);
		 }
    }
}
function processFUR()
{
    if(window.XMLHttpRequest)
	{
	    chkFUR = new XMLHttpRequest();
	}
	else
	{
	    chkFUR = new ActiveXObject('Microsoft.XMLHTTP');
	}
	chkFUR.onreadystatechange = function()
	{
	    if(chkFUR.readyState==4 && chkFUR.status==200)
	    {
			//console.log('processFUR function response: '+chkFUR.responseText);
			chkFURreply = chkFUR.responseText.split('^');
			if(chkFURreply[0] == 'OK furnizor')
			{
			   //alert('Received data: '+chkFURreply[1]);
			   if(chkFURreply[1] == 'Continue')
			   {
				   judet.value = chkFURreply[2];
				   if(judet.value == ''){judet.value = '-';}
				   oras.value = chkFURreply[3];
				   if(oras.value == ''){oras.value = '-';}
				   strada.value = chkFURreply[4];
				   if(strada.value == ''){strada.value = '-';}
				   nrSTR.value = chkFURreply[5];
				   if(nrSTR.value == ''){nrSTR.value = '-';}
				   codPOSTAL.value = chkFURreply[6];
				   if(codPOSTAL.value == ''){codPOSTAL.value = '-';}
				   tara.value = chkFURreply[7];
				   if(tara.value == ''){tara.value = '-';}
				   mail.value = chkFURreply[8];
				   if(mail.value == ''){mail.value = '-';}
				   telefon.value = chkFURreply[9];
				   if(telefon.value == ''){telefon.value = '-';}
				   contact.value = chkFURreply[10];
				   if(contact.value == ''){contact.value = '-';}
				   departament.value = chkFURreply[11];
				   if(departament.value == ''){departament.value = '-';}
				   apel.value = chkFURreply[12];
				   if(apel.value == ''){apel.value = '-';}
				   if(chkFURreply[13] == 'Found invoice' || chkFURreply[13] == 'New invoice')
				   {
					   if(receptieTABLE.rows.length == 2)
					   {
					       codSAP.focus();
					   }
				   }
				   else if(chkFURreply[13] == 'Wrong date')
				   {
				   	   factura.focus();
				   	   factura.select();
				   }
			   }
			   else if(chkFURreply[1] == 'Furnizor nou')
			   {
			   	   document.getElementById('furnizorFORM').style.display = 'block';
			   	   document.getElementById('numeFURNIZORnou').focus();
			   }
			}
			else{console.log(chkFUR.responseText);}
	    }
	}
	FURparams = 'furnizorcheck='+encodeURIComponent(furnizor.value)+'&facturaCHK='+encodeURIComponent(factura.value)+'&dataCHK='+dataFIELD.value;
	chkFUR.open('POST','/ramira/magazie/receptie marfa/find.php', true);
	chkFUR.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	chkFUR.send(FURparams);
}
function moveON()
{
    var pressed = event.key;
    furnizor.onchange = function()
    {
	    processFUR();
    }
    if(pressed == 'Enter' || pressed == 'Tab')
    {

	    if(factura == document.activeElement && factura.value != '')
	    {
			dataFIELD.focus();
	    }
	    else if(dataFIELD == document.activeElement && dataFIELD.value != '')
	    {
		    furnizor.focus();
	    }
	    else if(furnizor == document.activeElement && furnizor.value != '')
	    {
            processFUR();
	    }
	    else if((codSAP == document.activeElement && codSAP.value != '') || ((document.activeElement.id).search("codsapFIELD") != -1 && document.activeElement.value != ''))
	    {
			SAPprocess();
	    }
	    else if((detalii == document.activeElement && detalii.value != '') || ((document.activeElement.id).search("detaliiFIELD") != -1 && document.activeElement.value != ''))
	    {
			if(detalii == document.activeElement)
			{
			    var myDET = detalii.value;
				var mySAP = codSAP.value;
			}
			else
			{
				var detaliiROW = event.target.parentNode.parentNode.rowIndex;
			    var myDET = document.activeElement.value;
			    var mySAP = document.getElementById('codsapFIELD'+(detaliiROW-1)).value;
			}
			if(window.XMLHttpRequest)
			{
			    detCHK = new XMLHttpRequest();
			}
			else
			{
			    detCHK = new ActiveXObject('Microsoft.XMLHTTP');
			}
			detCHK.onreadystatechange = function()
			{
			    if(detCHK.readyState==4 && detCHK.status==200)
			    {
					//console.log('moveON function response: '+chkFUR.responseText);
					detCHKreply = detCHK.responseText.split('^');
					if(detCHKreply[0] == 'OK')
					{
						if(detalii == document.activeElement)
					   	{
        			        amount.focus();
        			        amount.select();
  	   			        }
				       	else
				       	{
					    	document.getElementById('amountFIELD'+(detaliiROW-1)).focus();
					    	document.getElementById('amountFIELD'+(detaliiROW-1)).select();
			    	    }
					}
					else if(detCHKreply[0] == 'New')
					{
					    alert('Detaliile produsului '+mySAP+' au fost modificate cu succes!');
					    if(detalii == document.activeElement)
					   	{
        			        amount.focus();
        			        amount.select();
  	   			        }
				       	else
				       	{
					    	document.getElementById('amountFIELD'+(detaliiROW-1)).focus();
					    	document.getElementById('amountFIELD'+(detaliiROW-1)).select();
			    	    }
					}
					else{console.log(detCHK.responseText);}
			    }
			}
			detCHKpar = 'detailsCHK='+encodeURIComponent(myDET)+'&SAPcode='+encodeURIComponent(mySAP);
			detCHK.open('POST','/ramira/magazie/receptie marfa/find.php', true);
			detCHK.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			detCHK.send(detCHKpar);
	    }
	    else if((amount == document.activeElement && amount.value != '') || ((document.activeElement.id).search("amountFIELD") != -1 && document.activeElement.value != ''))
	    {
			var amountROW = event.target.parentNode.parentNode.rowIndex;
			if(amount == document.activeElement)
			{
			    var mysap = codSAP.value;
			    var myamount = amount.value;
			}
			else
			{
			    var mysap = document.getElementById('codsapFIELD'+(amountROW-1)).value;
				var myamount = document.getElementById('amountFIELD' + (amountROW-1)).value;
			}
   			if(window.XMLHttpRequest)
			{
			    stocSUM = new XMLHttpRequest();
			}
			else
			{
			    stocSUM = new ActiveXObject('Microsoft.XMLHTTP');
			}
			stocSUM.onreadystatechange = function()
			{
			    if(stocSUM.readyState==4 && stocSUM.status==200)
			    {
					//console.log('moveON function response: '+chkFUR.responseText);
					stocSUMreply = stocSUM.responseText.split('^');
					if(stocSUMreply[0] == 'OK')
					{
						if(amount == document.activeElement)
						{
							stocfinal.value = stocSUMreply[1];
							totalprice.value = myamount*pret.value;
							cantmin.focus();
	        				cantmin.select();
						}
						else
						{
							document.getElementById('stocfinalFIELD'+(amountROW-1)).value = stocSUMreply[1];
							document.getElementById('valueFIELD' + (amountROW-1)).value = myamount*document.getElementById('pretFIELD' + (amountROW-1)).value;
							document.getElementById('cantminFIELD'+(amountROW-1)).focus();
							document.getElementById('cantminFIELD'+(amountROW-1)).select();
						}
					}
					else{console.log(detCHK.responseText);}
			    }
			}
			stocSUMpar = 'stocSUM='+encodeURIComponent(mysap)+'&amountSUM='+myamount;
			stocSUM.open('POST','/ramira/magazie/receptie marfa/calculations.php', true);
			stocSUM.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			stocSUM.send(stocSUMpar);
	    }
	    else if((cantmin == document.activeElement && cantmin.value != '') || ((document.activeElement.id).search("cantminFIELD") != -1 && document.activeElement.value != ''))
	    {
			var cantMINrow = document.activeElement.parentNode.parentNode.rowIndex;
   			if(window.XMLHttpRequest)
			{
			    cminUP = new XMLHttpRequest();
			}
			else
			{
			    cminUP = new ActiveXObject('Microsoft.XMLHTTP');
			}
			cminUP.onreadystatechange = function()
			{
			    if(cminUP.readyState==4 && cminUP.status==200)
			    {
					cminUPreply = cminUP.responseText.split('^');
					if(cminUPreply[0] == 'OK')
					{
						if(document.activeElement == cantmin)
						{
						    cantmin.value = cminUPreply[1];
						    cantopt.value = cminUPreply[2];
						    cantopt.focus();
		        			cantopt.select();
						}
						else
						{
						    document.getElementById('cantminFIELD' + (cantMINrow-1)).value = cminUPreply[1];
						    document.getElementById('cantoptFIELD' + (cantMINrow-1)).value = cminUPreply[2];
						    document.getElementById('cantoptFIELD'+(cantMINrow-1)).focus();
							document.getElementById('cantoptFIELD'+(cantMINrow-1)).select();
						}
					}
					else if(cminUPreply[0] == 'No lines affected.')
					{
						if(document.activeElement == cantmin)
						{
						    cantopt.focus();
		        			cantopt.select();
						}
						else
						{
						    document.getElementById('cantoptFIELD'+(cantMINrow-1)).focus();
							document.getElementById('cantoptFIELD'+(cantMINrow-1)).select();
						}
					}
					else{console.log(cminUP.responseText);}
			    }
			}
			if(document.activeElement == cantmin) 
			{
			    var myMINcant = cantmin.value;
			    var mySAPcode = codSAP.value;
			}
			else if((document.activeElement.id).search("cantminFIELD") != -1)
			{
			    var myMINcant = document.getElementById('cantminFIELD' + (cantMINrow-1)).value;
			    var mySAPcode = document.getElementById('codsapFIELD' + (cantMINrow-1)).value;
			}
			cminUPpar = 'cantMIN='+myMINcant+'&sapcode='+mySAPcode;
			cminUP.open('POST','/ramira/magazie/receptie marfa/calculations.php', true);
			cminUP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			cminUP.send(cminUPpar);
	    }
	    else if((cantopt == document.activeElement && cantopt.value != '') || ((document.activeElement.id).search("cantoptFIELD") != -1 && document.activeElement.value != ''))
	    {
			var cantoptROW = event.target.parentNode.parentNode.rowIndex;
   			if(window.XMLHttpRequest)
			{
			    coptUP = new XMLHttpRequest();
			}
			else
			{
			    coptUP = new ActiveXObject('Microsoft.XMLHTTP');
			}
			coptUP.onreadystatechange = function()
			{
			    if(coptUP.readyState==4 && coptUP.status==200)
			    {
					coptUPreply = coptUP.responseText.split('^');
					if(coptUPreply[0] == 'OK')
					{
						if(document.activeElement == cantopt)
						{
						    cantopt.value = coptUPreply[1];
						    pret.focus();
		        			pret.select();
						}
						else
						{
						    document.getElementById('cantoptFIELD' + (cantoptROW-1)).value = coptUPreply[1];
						    document.getElementById('pretFIELD'+(cantoptROW-1)).focus();
							document.getElementById('pretFIELD'+(cantoptROW-1)).select();
						}
					}
					else if(coptUPreply[0] == 'No lines affected.')
					{
					    if(document.activeElement == cantopt)
						{
						    pret.focus();
		        			pret.select();
						}
						else
						{
						    document.getElementById('pretFIELD'+(cantoptROW-1)).focus();
							document.getElementById('pretFIELD'+(cantoptROW-1)).select();
						}
					}
					else{console.log(coptUP.responseText);}
			    }
			}
			if(document.activeElement == cantopt)
			{
			    var myOPTcant = cantopt.value;
			    var mySAPcode = codSAP.value;
			}
			else if((document.activeElement.id).search("cantoptFIELD") != -1)
			{
			    var myOPTcant = document.getElementById('cantoptFIELD' + (cantoptROW-1)).value;
			    var mySAPcode = document.getElementById('codsapFIELD' + (cantoptROW-1)).value;
			}
			coptUPpar = 'cantOPT='+myOPTcant+'&sapcode='+mySAPcode;
			coptUP.open('POST','/ramira/magazie/receptie marfa/calculations.php', true);
			coptUP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			coptUP.send(coptUPpar);
	    }
	    else if((pret == document.activeElement && pret.value != '') || ((document.activeElement.id).search("pretFIELD") != -1 && document.activeElement.value != ''))
	    {
			var myROW = event.target.parentNode.parentNode.rowIndex;
			if(pret == document.activeElement)
			{
				totalprice.value = amount.value*pret.value;
		        cantmin.focus();
		    }
		    else
		    {
                document.getElementById('valueFIELD'+(myROW-1)).value = document.getElementById('amountFIELD'+(myROW-1)).value*document.getElementById('pretFIELD'+(myROW-1)).value
				document.getElementById('cantminFIELD'+(myROW-1)).focus();
		    }
			var rowsLONG = receptieTABLE.rows.length;
			if(rowsLONG == myROW + 1)
			{
			    var recROW = receptieTABLE.insertRow(rowsLONG);
			    var recCELL1 = recROW.insertCell(0);
			    recCELL1.style.border = '1px SOLID RGB(102,252,3)';
			    cell1ID = 'codsapFIELD'+(rowsLONG-1);
			    recCELL1.innerHTML = '<INPUT ID = "'+cell1ID+'" LIST = "sapRESULTS'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "COD SAP" ONKEYDOWN = "sapKEYSchk();" ONKEYUP = "findSAP();" ONCHANGE = "SAPprocess();" REQUIRED></INPUT><DATALIST ID = "sapRESULTS'+(rowsLONG-1)+'"></DATALIST></TD>';
			    document.getElementById(cell1ID).focus();
			    var recCELL2 = recROW.insertCell(1);
			    recCELL2.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL2.innerHTML = '<INPUT ID = "codfurnizorFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 6vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "COD FURNIZOR" ONKEYDOWN = "cffKEYSchk();"></INPUT>';
			    var recCELL3 = recROW.insertCell(2);
			    recCELL3.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL3.innerHTML = '<INPUT ID = "denumireFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 9.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "DENUMIRE" READONLY></INPUT>';
			    var recCELL4 = recROW.insertCell(3);
			    recCELL4.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL4.innerHTML = '<INPUT ID = "detaliiFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 3.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "DETALII" ONKEYDOWN = "moveON();"></INPUT>';
			    var recCELL5 = recROW.insertCell(4);
			    recCELL5.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL5.innerHTML = '<INPUT ID = "magazieFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 3.5vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "MAGAZIE" READONLY></INPUT>';
			    var recCELL6 = recROW.insertCell(5);
			    recCELL6.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL6.innerHTML = '<INPUT ID = "grupaFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 3.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "GRUPA" READONLY></INPUT>';
			    var recCELL7 = recROW.insertCell(6);
			    recCELL7.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL7.innerHTML = '<INPUT ID = "amountFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE" ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unit' + (rowsLONG - 1) + '" CLASS = "unit" READONLY VALUE = "N.A."></INPUT>';
			    var recCELL8 = recROW.insertCell(7);
			    recCELL8.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL8.innerHTML = '<INPUT ID = "stocfinalFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "STOC" READONLY></INPUT><INPUT ID = "unitSTOC' + (rowsLONG - 1) + '" CLASS = "unit" READONLY VALUE = "N.A."></INPUT>';
			    var recCELL9 = recROW.insertCell(8);
			    recCELL9.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL9.innerHTML = '<INPUT ID = "cantminFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE MIN." ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unitMIN' + (rowsLONG - 1) + '" CLASS = "unit" READONLY VALUE = "N.A."></INPUT>';
			    var recCELL10 = recROW.insertCell(9);
			    recCELL10.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL10.innerHTML = '<INPUT ID = "cantoptFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE OPT." ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unitOPT' + (rowsLONG - 1) + '" CLASS = "unit" READONLY VALUE = "N.A."></INPUT>';
			    var recCELL11 = recROW.insertCell(10);
			    recCELL11.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL11.innerHTML = '<INPUT ID = "pretFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "PRET/UNIT" ONKEYDOWN = "moveON();"></INPUT>';
			    var recCELL12 = recROW.insertCell(11);
			    recCELL12.style.border = '1px SOLID RGB(102,252,3)';
			    recCELL12.innerHTML = '<INPUT ID = "valueFIELD'+(rowsLONG-1)+'" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "VALOARE" READONLY></INPUT>';
			}
	    }
	    //else {console.log('Active element: '+document.activeElement.id)}
    }
}
function caps()
{
    if(factura == document.activeElement || (document.activeElement.id).search("codsapFIELD") != -1 || (document.activeElement.id).search("codfurnizorFIELD") != -1)
    {
	    document.activeElement.style.textTransform = "uppercase";
    }
}
function showReceptieFORM()
{
    if(receptieFORM.style.display == 'none')
    {
		invoice.src = "/ramira/magazie/receptie marfa/bon.receptie.php";
	    receptieFORM.style.display = 'block';
	    formBUTTON.style.display = 'none';
	    factura.focus();
    }
    else
    {
		invoice.src = "/ramira/magazie/receptie marfa/funny.php";
	    receptieFORM.style.display = 'none';
	    formBUTTON.style.display = 'block';
	    factura.value = '';
	    invoiceDATE.value = '';
	    furnizor.value = '';
	    codSAP.value = '';
	    codfurnizor.value = '';
	    denumire.value = '';
	    detalii.value = '';
	    magazie.value = '';
	    grupa.value = '';
	    amount.value = '';
	    stocfinal.value = '';
	    cantmin.value = '';
	    cantopt.value = '';
	    pret.value = '';
	    totalprice.value = '';
	    oras.value = '';
	    strada.value = '';
	    nrSTR.value = '';
	    codPOSTAL.value = '';
	    judet.value = '';
	    tara.value = '';
	    telefon.value = '';
	    mail.value = '';
	    contact.value = '';
	    departament.value = '';
	    apel.value = '';
	    if(receptieTABLE.rows.length > 2)
	    {
			var tableROWS = receptieTABLE.rows.length;
		    for(i = tableROWS - 1; i > 1; i--)
		    {
			    receptieTABLE.deleteRow(i);
		    }
	    }
    }
}
function cautareFURNIZOR()
{
	var pressed = event.key;
	//console.log(pressed);
	if(pressed != 'Enter' && pressed != 'undefined' && pressed != 'Tab')
	{
		if(window.XMLHttpRequest)
		{
		    xmlFURName = new XMLHttpRequest();
		}
		else
		{
		    xmlFURName = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlFURName.onreadystatechange = function()
		{
		    if(xmlFURName.readyState==4 && xmlFURName.status==200)
		    {
				//console.log(xmlFURName.responseText);
				const responseLISTnames = xmlFURName.responseText.split('^');
				if(responseLISTnames[0] == 'OK')
				{
				    document.getElementById("resultsFURNIZOR").innerHTML = responseLISTnames[1];
				}
				else if(xmlFURName.responseText == '')
				{
					document.getElementById("resultsFURNIZOR").innerHTML = '';
				}
				else {console.log(xmlFURName.responseText);}
		    }
		}
		parameters = 'furnizorname='+furnizor.value;
		xmlFURName.open('POST','/ramira/magazie/receptie marfa/find.php', true);
		xmlFURName.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlFURName.send(parameters);
	}
}

function hideSapFORM()
{
    if(document.getElementById('sapcodeFORM').style.display != 'none')
    {
	    document.getElementById('sapcodeFORM').style.display = 'none';
    }
}
function hideIntroFORM()
{
    if(document.getElementById('furnizorFORM').style.display != 'none')
    {
	    document.getElementById('furnizorFORM').style.display = 'none';
	    document.getElementById('numeFURNIZORnou').value = '';
        document.getElementById('codFURNIZORnou').value = '';
        document.getElementById('locFURNIZORnou').value = '';
        document.getElementById('codpostalFURNIZORnou').value = '';
        document.getElementById('stradaFURNIZORnou').value = '';
        document.getElementById('nrstrFURNIZORnou').value = '';
        document.getElementById('judetFURNIZORnou').value = '';
        document.getElementById('taraFURNIZORnou').value = '';
        document.getElementById('apelativFURNIZORnou').value = '';
        document.getElementById('persoanaFURNIZORnou').value = '';
        document.getElementById('telFURNIZORnou').value = '';
        document.getElementById('emailFURNIZORnou').value = '';
        document.getElementById('departFURNIZORnou').value = '';
    }
}
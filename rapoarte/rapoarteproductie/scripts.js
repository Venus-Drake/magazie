var gestionar = document.getElementById('numeGESTIONAR');
var displayORDERS = document.getElementById('displayORDERS');
var displayWORKERS = document.getElementById('displayWORKERS');
var displayMACHINES = document.getElementById('displayMACHINES');
var mysector = document.getElementById('sectieDISPLAY');

function inserareGESTIONAR()
{
    document.getElementById("semnaturaGESTIONAR").innerHTML = parent.gestionar.innerHTML;
}

function importanceSelect()
{
    var selection = document.getElementById('selectImp').innerHTML;
    console.log('Selected '+selection);
}

function loadGROUPS(sectorCHECK)
{
    var sectorSET = document.querySelector("label[for='" + sectorCHECK.id + "']").innerHTML.trimStart();
    document.getElementById('machGROUPS1').innerHTML = '';
    document.getElementById('machGROUPS2').innerHTML = '';
    document.getElementById('machGROUPS3').innerHTML = '';
    document.getElementById('selectareMasina').innerHTML = '';
    document.getElementById('selectareAngajat').innerHTML = '';
    if(window.XMLHttpRequest){sectorOP = new XMLHttpRequest();}
    else{sectorOP = new ActiveXObject('Microsoft.XMLHTTP');}
    sectorOP.onreadystatechange = function()
    {
        if(sectorOP.readyState==4 && sectorOP.status==200)
        {
            sectorOPRESPONSElist = sectorOP.responseText.split('^');
            //console.log(pdis.responseText);
            if(sectorOPRESPONSElist[0] == 'OK')
            {
                if(sectorOPRESPONSElist.length > 1)
                {
                    var machineGROUPS = '<BR>';
                    for(i = 1; i < sectorOPRESPONSElist.length; i++)
                    {
                        machineGROUPS = machineGROUPS + "<INPUT TYPE = 'checkbox' ID = 'grupSelect" + i + "' STYLE = 'BORDER: 1px SOLID BLACK;' ONCLICK = 'comenziSetup(this);'></INPUT><LABEL for = 'grupSelect" + i + "'> " + sectorOPRESPONSElist[i]+ "</LABEL><BR>";
                        if(i <= 5)
                        {
                            document.getElementById('machGROUPS1').innerHTML = machineGROUPS;
                            if(i == 5)
                            {
                                machineGROUPS = machineGROUPS + '<BR><BR>';
                                machineGROUPS = '<BR>';
                            }
                        }
                        else if(i <= 10)
                        {
                            document.getElementById('machGROUPS2').innerHTML = machineGROUPS;
                        }
                    }
                }
                //console.log(sectorOP.responseText);
            }
            else{console.log(sectorOP.responseText);}
        }
    }
    sectorOPPARAMS = 'myUSERsector='+sectorSET+'&request=myMACHINESgroups';
    sectorOP.open('POST','ajax.process.php', true);
    sectorOP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    sectorOP.send(sectorOPPARAMS);
}

function loadSELECTORS()
{
    var USERsector = parent.mysector.innerHTML;
    if(USERsector != 'MANAGEMENT' && USERsector != 'ERP')
    {
        document.getElementById('sectorSELECTORS').innerHTML = "<INPUT TYPE = 'radio' ID = 'sectorSelect' STYLE = 'BORDER: 1px SOLID BLACK;'></INPUT>&nbsp<LABEL for = 'sectorSelect'> " + USERsector+ "</LABEL><BR>";
        var labels = document.getElementsByTagName('label');
        for(i = 0; i < labels.length; i++)
        {
            //console.log('.' + labels[i].innerHTML+'; My sector: '+USERsector);
            if(labels[i].innerHTML.trimStart() == USERsector)
            {
                document.getElementById(labels[i].htmlFor).checked = true;
                //alert('Cautam grupurile de masini aferente sectorului '+USERsector+', inclusiv masinile si angajatii, pentru a popula listele de filtrare.');
                //console.log(document.getElementById(labels[i].htmlFor));
                loadGROUPS(document.getElementById(labels[i].htmlFor));
                break;
            }
            else
            {
                //console.log(labels[i].htmlFor);
            }
        }
        //alert(document.querySelector("label[for='" + setOPTION.id + "']").innerHTML);
    }
    else
    {
        //alert('Displaying all sectors to choose from!');
        if(window.XMLHttpRequest){sectOPT = new XMLHttpRequest();}
        else{sectOPT = new ActiveXObject('Microsoft.XMLHTTP');}
        sectOPT.onreadystatechange = function()
        {
            if(sectOPT.readyState==4 && sectOPT.status==200)
            {
                sectOPTRESPONSElist = sectOPT.responseText.split('^');
                //console.log(pdis.responseText);
                if(sectOPTRESPONSElist[0] == 'OK')
                {
                    if(sectOPTRESPONSElist.length > 1)
                    {
                        var sectorsTOdis = '';
                        for(i = 1; i < sectOPTRESPONSElist.length; i++)
                        {
                            sectorsTOdis = sectorsTOdis + "<INPUT TYPE = 'radio' ID = 'sectorSelect" + i + "' NAME = 'sectorSelection' STYLE = 'BORDER: 1px SOLID BLACK;' ONCLICK = 'loadGROUPS(this);'></INPUT>&nbsp<LABEL for = 'sectorSelect" + i + "'> " + sectOPTRESPONSElist[i] + "</LABEL><BR>";
                            if(sectOPTRESPONSElist.length > 10)
                            {
                                if(i == 10)
                                {
                                    document.getElementById('sectorSELECTORS').innerHTML = sectorsTOdis;
                                    sectorsTOdis = '';
                                }
                            }
                        }
                        if(sectOPTRESPONSElist.length <= 10)
                        {
                            document.getElementById('sectorSELECTORS').innerHTML = sectorsTOdis;
                        }
                        else
                        {
                            document.getElementById('sectorSELECTORS2').style.display = 'block';
                            document.getElementById('sectorSELECTORS2').innerHTML = sectorsTOdis;
                        }
                    }
                    //console.log(sectOPT.responseText);
                }
                else{console.log(sectOPT.responseText);}
            }
        }
        sectOPTPARAMS = 'managerREQ=giveSECTORS';
        sectOPT.open('POST','ajax.process.php', true);
        sectOPT.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        sectOPT.send(sectOPTPARAMS);
    }
}

function closeMAINoptions()
{
    document.getElementById('setupModal').style.display = 'none';
}

function comenziSetup(setOPTION)
{
    var machineSET = document.querySelector("label[for='" + setOPTION.id + "']").innerHTML;
    mysector = parent.mysector.innerHTML;
    if((setOPTION.id.indexOf('sectorSelect') != -1) && setOPTION.checked == true)
    {
        if(mysector != 'MANAGEMENT')
        {
            sectorDISPLAY = mysector;
            alert('Nu aveti autorizatia pentru a vizualiza/modifica date de la alte sectoare!');
            setOPTION.checked = false;
            var sectorsGroups = document.getElementById('sectorSELECTORS').querySelectorAll('label');
            {
                for(var h = 0; h < sectorsGroups.length; h++)
                {
                    if(sectorsGroups[h].innerHTML.trimStart() == mysector)
                    {
                        document.getElementById(sectorsGroups[h].htmlFor).checked = true;
                        break;
                    }
                }
            }
        }
        if(window.XMLHttpRequest){setOPT = new XMLHttpRequest();}
        else{setOPT = new ActiveXObject('Microsoft.XMLHTTP');}
        var sectorul = setOPTION.id;
        setOPT.onreadystatechange = function()
        {
            if(setOPT.readyState==4 && setOPT.status==200)
            {
                setOPTRESPONSElist = setOPT.responseText.split(',');
                //console.log(pdis.responseText);
                if(setOPTRESPONSElist[0] == 'OK')
                {
                    console.log(setOPT.responseText);
                }
                else{console.log(setOPT.responseText);}
            }
        }
        setOPTPARAMS = 'sectorSET='+mysector+'&request='+setOPTION.id;
        setOPT.open('POST','ajax.process.php', true);
        setOPT.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        setOPT.send(setOPTPARAMS);
    }
    else if(setOPTION.id == 'sectorSelect' && setOPTION.checked == true)
    {
        console.log('Check if machine groups are selected. If none, check the machine and employee lists; if not empty, clear them. If empty, do nothing.');
    }
    else if((setOPTION.id.indexOf('grupSelect') != -1) && setOPTION.checked == true)
    {
        var machineSET = document.querySelector("label[for='" + setOPTION.id + "']").innerHTML;
        var sectorsLIST = document.getElementById('sectorOPTIONS').querySelectorAll('label');
        //console.log('Avem ' +sectorsLIST.length + ' optiuni de selectat, ca si sectoare.\nCautam sectorul bifat.');
        for(i = 0; i < sectorsLIST.length; i++)
        {
            if(document.getElementById(sectorsLIST[i].htmlFor).checked == true)
            {
                var options2SEND = "alarm=getEmployees&sector=" + sectorsLIST[i].innerHTML.trimStart() + "&machineGroups=";
                //console.log('Var to send: ' + options2SEND + '. Now we look for the checked boxes at machine groups.');
                var machineGroups = document.getElementById('machineGROUPS').querySelectorAll('label');
                for(k = 0; k < machineGroups.length; k++)
                {
                    if(document.getElementById(machineGroups[k].htmlFor).checked == true)
                    {
                        options2SEND = options2SEND + machineGroups[k].innerHTML.trimStart() + ',';
                        //console.log(options2SEND);
                        if(window.XMLHttpRequest){opSEND = new XMLHttpRequest();}
                        else{opSEND = new ActiveXObject('Microsoft.XMLHTTP');}
                        opSEND.onreadystatechange = function()
                        {
                            if(opSEND.readyState==4 && opSEND.status==200)
                            {
                                opSENDRESPONSElist = opSEND.responseText.split(',');
                                //console.log(pdis.responseText);
                                if(opSENDRESPONSElist[0] == 'OK')
                                {
                                    if(opSENDRESPONSElist.length > 1)
                                    {
                                        document.getElementById('selectareMasina').innerHTML = '';
                                        document.getElementById('selectareAngajat').innerHTML = '';
                                        var mch2SET = '';
                                        for(k=1; k < opSENDRESPONSElist.length; k = k + 2)
                                        {
                                            //document.getElementById('selectareMasina').innerHTML = '';
                                            if(opSENDRESPONSElist[k+1] != mch2SET)
                                            {
                                                mch2SET = opSENDRESPONSElist[k+1];
                                                var optionMCH = document.createElement("option");
                                                optionMCH.value = opSENDRESPONSElist[k+1];
                                                optionMCH.text = opSENDRESPONSElist[k+1];
                                                document.getElementById('selectareMasina').appendChild(optionMCH);
                                            }
                                            var optionEmployee = document.createElement("option");
                                            optionEmployee.value = opSENDRESPONSElist[k];
                                            optionEmployee.text = opSENDRESPONSElist[k];
                                            document.getElementById('selectareAngajat').appendChild(optionEmployee);
                                        }
                                    }
                                    //console.log('Got: '+ opSEND.responseText);
                                }
                                else{console.log(opSEND.responseText);}
                            }
                        }
                        opSEND.open('POST','ajax.process.php', true);
                        opSEND.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                        opSEND.send(options2SEND);
                    }
                }
                break;
            }
        }
    }
    else if((setOPTION.id == 'grupSelect1' || setOPTION.id == 'grupSelect2' ||setOPTION.id == 'grupSelect3') && setOPTION.checked == false)
    {
        console.log('Check if we have any sector selected. Check if we have any other machine grup selection. Setting options for machine and employee fields, according to sector selection, removing THIS grup filter.');
    }
    else if(setOPTION.id == 'impSelection')
    {
        console.log('Check all the options selected and send them to be processed.');
        if(document.getElementById('impSelect1').checked == true && document.getElementById('impSelect2').checked == true && document.getElementById('impSelect3').checked == true && document.getElementById('impSelect4').checked == true)
        {
            document.getElementById('confDIALOG').style.display = "BLOCK";
        }
        else{sendSelections();}
    }
    else if(setOPTION.id == 'confYES')
    {
        console.log('User agreed to load all importance reports.<BR>Check all the options selected and send them to be processed.');
        document.getElementById('confDIALOG').style.display = "NONE";
        sendSelections();
    }
    else if(setOPTION.id == 'confNO')
    {
        document.getElementById('confDIALOG').style.display = "NONE";
    }
    function sendSelections()
    {
        if(document.getElementById('impSelect1').checked == true)
        {
            var2Send = 'urgent1=yes';
        }
        else
        {
            var2Send = 'urgent1=no';
        }
        if(document.getElementById('impSelect2').checked == true)
        {
            var2Send = var2Send + '&urgent2=yes';
        }
        if(document.getElementById('impSelect3').checked == true)
        {
            var2Send = var2Send + '&urgent3=yes';
        }
        if(document.getElementById('impSelect4').checked == true)
        {
            var2Send = var2Send + '&urgent4=yes';
        }
        console.log(var2Send);
    }
}

function productionDISPLAY(clicked_id)
{
    if(clicked_id == displayORDERS.id || clicked_id == displayWORKERS.id || clicked_id == displayMACHINES.id)
    {
        if(window.XMLHttpRequest){pdis = new XMLHttpRequest();}
        else{pdis = new ActiveXObject('Microsoft.XMLHTTP');}
        var mysector = document.getElementById('sectieDISPLAY').innerHTML;
        pdis.onreadystatechange = function()
        {
            if(pdis.readyState==4 && pdis.status==200)
            {
                pdisRESPONSElist = pdis.responseText.split(',');
                //console.log(pdis.responseText);
                if(pdisRESPONSElist[0] == 'OK')
                {
                    document.getElementById('bonFRAME').style.backgroundImage = "url('/ramira/magazie/images/Working.gif')";
                    document.getElementById('bonFRAME').style.backgroundRepeat = 'NO-repeat';
                    //document.getElementById('bonFRAME').style.backgroundColor = 'RGB(0,0,0)';
                    document.getElementById('bonFRAME').style.backgroundPosition = 'Center';
                    if(clicked_id == displayORDERS.id)document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/afisare.comenzi.php?mysector="+mysector;
                    else if(clicked_id == displayWORKERS.id) {alert('Aici vom afisa angajatii.');}
                    else if(clicked_id == displayMACHINES.id) {alert('Aici vom afisa utilajele.');}
                }
                else{console.log(pdis.responseText);}
            }
        }
        pdisPARAMS = 'mysector='+mysector+'&request='+clicked_id;
        pdis.open('POST','ajax.process.php', true);
        pdis.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        pdis.send(pdisPARAMS);
    }
    else if(clicked_id == 'updateORDERS' || clicked_id == 'updateWORKERS')
    {
        console.log('Doing update on ' + clicked_id);
        if(window.XMLHttpRequest){pdisADMIN = new XMLHttpRequest();}
        else{pdisADMIN = new ActiveXObject('Microsoft.XMLHTTP');}
        var mysector = document.getElementById('sectieDISPLAY').innerHTML;
        pdisADMIN.onreadystatechange = function()
        {
            if(pdisADMIN.readyState==4 && pdisADMIN.status==200)
            {
                pdisADMINRESPONSElist = pdisADMIN.responseText.split('^');
                //console.log(pdis.responseText);
                if(pdisADMINRESPONSElist[0] == 'OK')
                {
                    document.getElementById('bonFRAME').style.backgroundImage = "url('/ramira/magazie/images/Working.gif')";
                    document.getElementById('bonFRAME').style.backgroundRepeat = 'NO-repeat';
                    document.getElementById('bonFRAME').style.backgroundPosition = 'Center';
                    if(pdisADMINRESPONSElist[1] == 'update done')document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/afisare.comenzi.php?mysector="+mysector;
                    else 
                    {
                        alert('Update did not finish correctly.');
                        console.log(pdisADMIN.responseText);
                    }
                }
                else{console.log(pdisADMIN.responseText);}
            }
        }
        pdisADMINPARAMS = 'mysector='+mysector+'&request='+clicked_id;
        pdisADMIN.open('POST','ajax.process.php', true);
        pdisADMIN.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        pdisADMIN.send(pdisADMINPARAMS);
    }
}

function grabUserSector()
{
    if(window.XMLHttpRequest){usector = new XMLHttpRequest();}
    else{usector = new ActiveXObject('Microsoft.XMLHTTP');}
    usector.onreadystatechange = function()
    {
        if(usector.readyState==4 && usector.status==200)
        {
            //console.log('Got reply: '+usector.responseText);
            usectorRESPONSElist = usector.responseText.split(',');
            if(usectorRESPONSElist[0] == 'OK')
            {
                if(usectorRESPONSElist[1] != 'no access')
                {
                    document.getElementById('sectieDISPLAY').innerHTML = usectorRESPONSElist[1];
                    for(i = 2; i < usectorRESPONSElist.length; i++)
                    {
                        var activeBUTTON = usectorRESPONSElist[i];
                        if(document.getElementById(activeBUTTON) != null)
                        {
                            document.getElementById(activeBUTTON).style.display = 'block';
                        }
                    }
                }
                else
                {
                    document.getElementById('noACCESS').style.display = 'block';
                    displayORDERS.disabled = true;
                    displayWORKERS.disabled = true;
                    displayMACHINES.disabled = true;
                }
            }
            else{console.log(usector.responseText);}
        }
    }
    var userNAME = document.getElementById('marcaUSER').innerHTML;
    sectorPARAMS = 'userNAME='+userNAME;
    usector.open('POST','ajax.process.php', true);
    usector.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    usector.send(sectorPARAMS);
}
var gestionar = document.getElementById('numeGESTIONAR');
var displayORDERS = document.getElementById('displayORDERS');
var displayWORKERS = document.getElementById('displayWORKERS');
var displayMACHINES = document.getElementById('displayMACHINES');
var mysector = document.getElementById('sectieDISPLAY');
var showPARAMS;

function EmployeeChangeMachine(machine)
{
    var pressed = event.key;
    if(pressed == 'Escape' || pressed == 'Enter' || event.type == 'change')
    {
        event.preventDefault();
        var EmplMachine = event.target.value;
        var MachineCell = event.target.parentNode;
        MachineCell.innerHTML = EmplMachine;
        if(window.XMLHttpRequest){MachineChangeXml = new XMLHttpRequest();}
        else{MachineChangeXml = new ActiveXObject('Microsoft.XMLHTTP');}
        MachineChangeXml.onreadystatechange = function()
        {
            if(MachineChangeXml.readyState==4 && MachineChangeXml.status==200)
            {
                if(MachineChangeXml.responseText != 'OK')
                {
                    console.log(MachineChangeXml.responseText);
                }
            }
        }
        var MachineChangeData = 'alarm=MachineChange&employee='+MachineCell.parentNode.cells[2].innerHTML+'&oldMachine='+machine+'&newMachine=' + EmplMachine;
        MachineChangeXml.open('POST','ajax.process.php', true);
        MachineChangeXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        MachineChangeXml.send(MachineChangeData);
    }
}

function EmployeeEdit()
{
    var EmplField = event.target;
    if(EmplField.cellIndex == 5 || EmplField.cellIndex == 7) 
    {
        var OldMachine = EmplField.innerHTML;
        EmplField.innerHTML = '';
        var Mach1Select = document.createElement('select');
        Mach1Select.addEventListener('change',function(){EmployeeChangeMachine(OldMachine);},true);
        Mach1Select.addEventListener('keydown',function(){EmployeeChangeMachine(OldMachine);},true);
        Mach1Select.style.width = '100%';
        Mach1Select.style.backgroundColor = 'yellow';
        EmplField.appendChild(Mach1Select);
        var EmployeeMainOption = document.createElement('option');
        EmployeeMainOption.value = OldMachine;
        EmployeeMainOption.innerHTML = OldMachine;
        EmployeeMainOption.style.display = 'none';
        Mach1Select.appendChild(EmployeeMainOption);
        if(window.XMLHttpRequest){MachineOptionsXml = new XMLHttpRequest();}
        else{MachineOptionsXml = new ActiveXObject('Microsoft.XMLHTTP');}
        MachineOptionsXml.onreadystatechange = function()
        {
            if(MachineOptionsXml.readyState==4 && MachineOptionsXml.status==200)
            {
                MachineOptionsXmlRespList = MachineOptionsXml.responseText.split('^');
                //console.log(AttrHml.responseText);
                if(MachineOptionsXmlRespList[0] == 'OK')
                {
                    if(MachineOptionsXmlRespList.length > 1)
                    {
                        for(var i = 1; i < MachineOptionsXmlRespList.length; i++)
                        {
                            var SelectOption = document.createElement('option');
                            SelectOption.value = MachineOptionsXmlRespList[i];
                            SelectOption.innerHTML = MachineOptionsXmlRespList[i];
                            Mach1Select.appendChild(SelectOption);
                        }
                        Mach1Select.focus();
                    }
                }
                else
                {
                    console.log(MachineOptionsXml.responseText);
                }
            }
        }
        var MachineOptionsData = 'alarm=MachineOptions&sector='+window.parent.document.getElementById('sectieDISPLAY').innerHTML+'&exception='+OldMachine;
        MachineOptionsXml.open('POST','ajax.process.php', true);
        MachineOptionsXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        MachineOptionsXml.send(MachineOptionsData);
    }
}

function CloseDetails()
{
    document.getElementById('AfisareComanda').style.display = 'none';
    document.getElementById('AfisareComanda').style.top = '0';
    document.getElementById('AfisareComanda').style.left = '0';
}
function ShowOrderDetails()
{
    var Order2Show = event.target;
    var Op2Show = Order2Show.parentNode.cells[3].innerHTML;
    var DetailsWindow = document.getElementById('AfisareComanda');
    if(DetailsWindow.style.display != 'block') DetailsWindow.style.display = 'block';
    document.getElementById('DetaliiPJ_Number').innerHTML = Order2Show.parentNode.cells[1].innerHTML;
    document.getElementById('DetaliiPO_Number').innerHTML = Order2Show.parentNode.cells[2].innerHTML;
    document.getElementById('DetaliiOpNr_Number').innerHTML = Order2Show.parentNode.cells[3].innerHTML;
    document.getElementById('DetaliiAmount_Number').innerHTML = Order2Show.parentNode.cells[4].innerHTML;
    document.getElementById('DetaliiFinalDate').innerHTML = '';
    document.getElementById('OpNr_Number').innerHTML = Order2Show.parentNode.cells[3].innerHTML;
    document.getElementById('Group_Code').innerHTML = Order2Show.parentNode.cells[9].innerHTML;
    document.getElementById('Bar_Code').innerHTML = '*' + Order2Show.parentNode.cells[2].innerHTML + '.' + Order2Show.parentNode.cells[3].innerHTML + '*';
    document.getElementById('Employee_Name').innerHTML = Order2Show.parentNode.cells[11].innerHTML;
    if(window.parent.document.getElementById('scanareComenzi').style.display != 'none')
    {
        window.parent.document.getElementById('ScanOrderInput').focus();
        window.parent.document.getElementById('ScanOrderInput').select();
    }
}

function dragElement(elmnt) 
{
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    var OffsetTop = elmnt.offsetTop;
    var OffsetLeft = elmnt.offsetLeft;
    if (document.getElementById(elmnt.id + "DraggableHeader")) 
    {
        document.getElementById(elmnt.id + "DraggableHeader").onmousedown = dragMouseDown;
    } 
    else 
    {
        elmnt.onmousedown = dragMouseDown;
    }
    function dragMouseDown(e) 
    {
        e = e || window.event;
        e.preventDefault();
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
    }
    function elementDrag(e) 
    {
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        //console.log('Y = ' + e.clientY + '; X = ' + e.clientX)
        //pos3 = e.clientX;
        //pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (OffsetTop - pos2) + "px";
        //console.log('Top: '+elmnt.style.top);
        elmnt.style.left = (OffsetLeft - pos1) + "px";
    }

    function closeDragElement() 
    {
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

function IncheieAtribuireAutomata()
{
    document.getElementById('ScanOrderInput').value = '';
    document.getElementById('SelectareUtilajpentruScanare').innerHTML = '<OPTION></OPTION>';
    document.getElementById('SelectareUtilajpentruScanare').value = '';
    document.getElementById('ErrorDisplay').style.backgroundColor = 'RGBA(1,1,1,0)';
    document.getElementById('ErrorDisplay').innerHTML = '';
    document.getElementById('scanareComenzi').style.display = "none";
}

function selectareUtilajScanari()
{
    document.getElementById('ScanOrderInput').focus();
}

function IncarcareListaUtilaje()
{
    var mysector = document.getElementById('sectieDISPLAY').innerHTML;
    if(window.XMLHttpRequest){UploadMachXml = new XMLHttpRequest();}
    else{UploadMachXml = new ActiveXObject('Microsoft.XMLHTTP');}
    UploadMachXml.onreadystatechange = function()
    {
        if(UploadMachXml.readyState==4 && UploadMachXml.status==200)
        {
            UploadMachXmlRespList = UploadMachXml.responseText.split('^');
            //console.log(AttrHml.responseText);
            if(UploadMachXmlRespList[0] == 'OK')
            {
                if(UploadMachXmlRespList.length > 1)
                {
                    for(var i = 1; i < UploadMachXmlRespList.length; i++)
                    {
                        var SelectOption = document.createElement('option');
                        SelectOption.value = UploadMachXmlRespList[i];
                        SelectOption.innerHTML = UploadMachXmlRespList[i];
                        document.getElementById('SelectareUtilajpentruScanare').appendChild(SelectOption);
                    }
                }
            }
            else
            {
                console.log(UploadMachXml.responseText);
            }
        }
    }
    var UploadMachData = 'alarm=GiveSectorMachines&sector='+mysector;
    UploadMachXml.open('POST','ajax.process.php', true);
    UploadMachXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    UploadMachXml.send(UploadMachData);
}

function AtribuireSectorScanat()
{
    var mysector = document.getElementById('sectieDISPLAY').innerHTML;
    if(window.XMLHttpRequest){AttrMachXml = new XMLHttpRequest();}
    else{AttrMachXml = new ActiveXObject('Microsoft.XMLHTTP');}
    AttrMachXml.onreadystatechange = function()
    {
        if(AttrMachXml.readyState==4 && AttrMachXml.status==200)
        {
            AttrMachXmlRespList = AttrMachXml.responseText.split('^');
            //console.log(AttrHml.responseText);
            if(AttrMachXmlRespList[0] == 'OK')
            {
                document.getElementById('ScanOrderInput').select();
                document.getElementById('ErrorDisplay').innerHTML = 'Comanda atribuita!';
                document.getElementById('ErrorDisplay').style.backgroundColor = 'lightgreen';
            }
            else if(AttrMachXmlRespList[0] == 'NO')
            {
                document.getElementById('ScanOrderInput').select();
                document.getElementById('ErrorDisplay').innerHTML = AttrMachXmlRespList[1];
                document.getElementById('ErrorDisplay').style.backgroundColor = 'red';
            }
            else
            {
                document.getElementById('ScanOrderInput').select();
                document.getElementById('ErrorDisplay').innerHTML = 'Atribuirea nu a putut fi efectuata!';
                document.getElementById('ErrorDisplay').style.backgroundColor = 'red';
                console.log(AttrMachXml.responseText);
            }
        }
    }
    var AttrMachData = 'alarm=AtribuieComandapeMasina&sector='+mysector+'&masina='+document.getElementById('SelectareUtilajpentruScanare').value+'&comanda='+document.getElementById('ScanOrderInput').value;
    AttrMachXml.open('POST','ajax.process.php', true);
    AttrMachXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    AttrMachXml.send(AttrMachData);
}

function scanCheck()
{
    var ScanKey = event.key;
    //console.log(ScanKey);
    if(ScanKey != 'Enter' && ScanKey != 'Tab' && document.getElementById('SelectareUtilajpentruScanare').value != '')
    {
        if(/[0-9\'.']/i.test(event.key)){document.activeElement.style.textTransform = "uppercase";}
        else{event.preventDefault();}
    }
    else if(ScanKey == 'Enter' || ScanKey == 'Tab' && document.getElementById('SelectareUtilajpentruScanare').value != '')
    {
        event.preventDefault();
        AtribuireSectorScanat();
    }
    else
    {
        event.preventDefault();
    }
}
function atribuireAutomata()
{
    var bonFrame = document.getElementById('bonFRAME');
    var setupFrame = bonFrame.contentWindow.document.getElementById('setupModal');
    if(document.getElementById('scanareComenzi').style.display != "block")
    {
        document.getElementById('scanareComenzi').style.display = "block";
        setupFrame.style.display = "none";
        document.getElementById('SelectareUtilajpentruScanare').focus();
        IncarcareListaUtilaje()
    }
    else
    {
        document.getElementById('scanareComenzi').style.display = "none";
        setupFrame.style.display = "block";
        document.getElementById('SelectareUtilajpentruScanare').innerHTML = '';
        document.getElementById('ScanOrderInput').innerHTML = '';
        var EmptyOption = document.createElement('option');
        EmptyOption.value = '';
        EmptyOption.innerHTML = '';
        document.getElementById('SelectareUtilajpentruScanare').appendChild(EmptyOption);
    }
}

function UpdateEmployeeMachine()
{
    var EmplMachChoice = event.target;
    var MyEmployee = EmplMachChoice.parentNode.parentNode.cells[2].innerHTML;
    if(EmplMachChoice.value != '')
    {
        if(window.XMLHttpRequest){EmplMachHml = new XMLHttpRequest();}
        else{EmplMachHml = new ActiveXObject('Microsoft.XMLHTTP');}
        EmplMachHml.onreadystatechange = function()
        {
            if(EmplMachHml.readyState==4 && EmplMachHml.status==200)
            {
                EmplMachHmlRespList = EmplMachHml.responseText.split('^');
                //console.log(AttrHml.responseText);
                if(EmplMachHmlRespList[0] == 'OK')
                {
                    EmplMachChoice.style.backgroundColor = 'green';
                }
                else
                {
                    console.log(EmplMachHml.responseText);
                }
            }
        }
        var EmplMachData = 'alarm=UpdateEmployeeMachine&employee='+MyEmployee+'&newmachine='+EmplMachChoice.value;
        EmplMachHml.open('POST','ajax.process.php', true);
        EmplMachHml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        EmplMachHml.send(EmplMachData);
    }
}
function GoBack()
{
    if(event.key == 'Escape' || event.key == 'Backspace')
    {
        if(event.target.parentNode.cellIndex == 11)
        {
            event.target.parentNode.parentNode.cells[10].querySelector('select').disabled = false;
            event.target.parentNode.parentNode.cells[10].querySelector('select').addEventListener('keydown',GoBack);
            event.target.parentNode.parentNode.cells[10].querySelector('select').focus();
            event.target.parentNode.innerHTML = '';
        }
        else if(event.target.parentNode.cellIndex == 10)
        {
            event.target.parentNode.parentNode.cells[6].querySelector('select').disabled = false;
            event.target.parentNode.parentNode.cells[6].querySelector('select').addEventListener('keydown',GoBack);
            event.target.parentNode.parentNode.cells[6].querySelector('select').focus();
            event.target.parentNode.innerHTML = '';
        }
        else if(event.target.parentNode.cellIndex == 6)
        {
            event.target.parentNode.addEventListener('click',SetSector);
            document.getElementById('Busy').innerHTML = '0';
            event.target.parentNode.innerHTML = '';
        }
        else if(event.target.cellIndex == 11)
        {
            event.target.querySelector('select').disabled = false;
        }
    }
    else if(event.key == 'Enter' && event.target.parentNode.cellIndex == 11)
    {
        event.target.disabled = true;
        if(event.target.value == '')
        {
            event.target.parentNode.addEventListener('click',GoBack,true);
        }
        AttribFinish();
    }
    else if(event.type == 'click' && event.target.parentNode.cellIndex == 11 && event.target.tagName == 'SELECT')
    {
        event.target.disabled = false;
    }
}

function AttribFinish(EmploCell)
{
    var OrdersUser = document.getElementById('semnaturaGESTIONAR').innerHTML;
    if(event.type == 'readystatechange')
    {
        var Ending = EmploCell;
        var EndingRow = Ending.parentNode;
        var AttrAngajat = Ending.innerHTML;
    }
    else
    {
        var Ending = event.target;
        var EndingRow = Ending.parentNode.parentNode;
        var AttrAngajat = Ending.value;
    }
    var AttrMachine = EndingRow.cells[10].querySelector('select').value;
    var AttrSector = EndingRow.cells[6].querySelector('select').value;
    var AttrPJ = EndingRow.cells[1].innerHTML;
    var AttrPO = EndingRow.cells[2].innerHTML;
    var AttrPos = EndingRow.cells[3].innerHTML;
    var AttrData = 'alarm=AttribuireComanda&PJ=' + AttrPJ + '&PO=' + AttrPO + '&operation=' + AttrPos + '&sector=' + AttrSector + '&masina=' + AttrMachine + '&employee=' + AttrAngajat + '&myuser=' + OrdersUser;
    if(window.XMLHttpRequest){AttrHml = new XMLHttpRequest();}
    else{AttrHml = new ActiveXObject('Microsoft.XMLHTTP');}
    AttrHml.onreadystatechange = function()
    {
        if(AttrHml.readyState==4 && AttrHml.status==200)
        {
            AttrHmlRespList = AttrHml.responseText.split('^');
            //console.log(AttrHml.responseText);
            if(AttrHmlRespList[0] == 'OK')
            {
                EndingRow.cells[11].innerHTML = AttrAngajat;
                EndingRow.cells[10].innerHTML = AttrMachine;
                EndingRow.cells[6].innerHTML = AttrSector;
                document.getElementById('Busy').innerHTML = '0';
            }
            else
            {
                console.log(AttrHml.responseText);
                document.getElementById('Busy').innerHTML = '0';
                Ending.parentNode.innerHTML = '';
                EndingRow.cells[10].innerHTML = '';
                EndingRow.cells[6].innerHTML = '';
            }
        }
    }
    AttrHml.open('POST','ajax.process.php', true);
    AttrHml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    AttrHml.send(AttrData);
}

function AttribMasina()
{
    var myMachine = event.target;
    if(myMachine.value != '')
    {
        myMachine.disabled = true;
        var EmploCell = event.target.parentNode.parentNode.cells[11];
        if(window.XMLHttpRequest){SetEmplo = new XMLHttpRequest();}
        else{SetEmplo = new ActiveXObject('Microsoft.XMLHTTP');}
        SetEmplo.onreadystatechange = function()
        {
            if(SetEmplo.readyState==4 && SetEmplo.status==200)
            {
                SetEmploRESPONSElist = SetEmplo.responseText.split('^');
                //console.log(pdis.responseText);
                if(SetEmploRESPONSElist[0] == 'OK')
                {
                    //console.log(SetEmplo.responseText);
                    if(SetEmploRESPONSElist.length > 1)
                    {
                        if(SetEmploRESPONSElist.length > 2)
                        {
                            var EmploSelect = document.createElement("select");
                            EmploSelect.addEventListener('keydown',GoBack);
                            EmploSelect.style.width = '100%';
                            EmploSelect.addEventListener('change',AttribFinish);
                            EmploSelect.value = grupMasina;
                            EmploCell.appendChild(EmploSelect);
                            var BlankOptionEmplo = document.createElement("option");
                            BlankOptionEmplo.value = '';
                            EmploSelect.appendChild(BlankOptionEmplo);
                            for(x = 1; x < SetEmploRESPONSElist.length; x++)
                            {
                                var EmploOption = document.createElement("option");
                                EmploOption.value = SetEmploRESPONSElist[x];
                                EmploOption.innerHTML = SetEmploRESPONSElist[x];
                                EmploSelect.appendChild(EmploOption);
                            }
                            EmploSelect.focus();
                        }
                        else
                        {
                            EmploCell.innerHTML = SetEmploRESPONSElist[1];
                            AttribFinish(EmploCell);
                        }
                    }
                }
                else{console.log(SetEmplo.responseText);}
            }
        }
        SetEmploPARAMS = 'alarm=AtribuireAngajat&masina='+myMachine.value+'&sector='+myMachine.parentNode.parentNode.cells[6].querySelector('select').value;
        SetEmplo.open('POST','ajax.process.php', true);
        SetEmplo.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        SetEmplo.send(SetEmploPARAMS);

    }
    else
    {

    }
}

function AttribSector()
{
    var mySelect = event.target;
    mySelect.disabled = true;
    var MachineCell = event.target.parentNode.parentNode.cells[10];
    if(window.XMLHttpRequest){SetMach = new XMLHttpRequest();}
        else{SetMach = new ActiveXObject('Microsoft.XMLHTTP');}
        SetMach.onreadystatechange = function()
        {
            if(SetMach.readyState==4 && SetMach.status==200)
            {
                SetMachRESPONSElist = SetMach.responseText.split('^');
                //console.log(pdis.responseText);
                if(SetMachRESPONSElist[0] == 'OK')
                {
                    //console.log(SetMach.responseText);
                    if(SetMachRESPONSElist.length > 1)
                    {
                        var MachineSelect = document.createElement("select");
                        MachineSelect.style.width = '100%';
                        MachineSelect.addEventListener('change',AttribMasina);
                        MachineSelect.addEventListener('keydown',GoBack);
                        MachineSelect.value = grupMasina;
                        MachineCell.appendChild(MachineSelect);
                        var BlankOptionMachine = document.createElement("option");
                        BlankOptionMachine.value = '';
                        MachineSelect.appendChild(BlankOptionMachine);
                        for(x = 1; x < SetMachRESPONSElist.length; x = x + 2)
                        {
                            var MachineOption = document.createElement("option");
                            var color = SetMachRESPONSElist[x+1];
                            MachineOption.style.backgroundColor = color;
                            MachineOption.value = SetMachRESPONSElist[x];
                            MachineOption.innerHTML = SetMachRESPONSElist[x];
                            MachineSelect.appendChild(MachineOption);
                        }
                        MachineSelect.focus();
                    }
                    else
                    {
                        mySelect.disabled = false;
                    }
                }
                else{console.log(SetMach.responseText);}
            }
        }
        SetMachPARAMS = 'alarm=AtribuireMasina&grupMasina='+grupMasina + '&sector=' + mySelect.value;
        SetMach.open('POST','ajax.process.php', true);
        SetMach.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        SetMach.send(SetMachPARAMS);
}

function SetSector()
{
    if(document.getElementById('Busy').innerHTML == '0')
    {
        document.getElementById('Busy').innerHTML = '1';
        var clickedSectorCell = event.target;
        grupMasina = event.target.parentNode.cells[9].innerHTML;
        //console.log('Setam sectorul pentru masina: ' + grupMasina);
        if(window.XMLHttpRequest){SetSec = new XMLHttpRequest();}
        else{SetSec = new ActiveXObject('Microsoft.XMLHTTP');}
        SetSec.onreadystatechange = function()
        {
            if(SetSec.readyState==4 && SetSec.status==200)
            {
                SetSecRESPONSElist = SetSec.responseText.split('^');
                //console.log(pdis.responseText);
                if(SetSecRESPONSElist[0] == 'OK')
                {
                    if(SetSecRESPONSElist.length > 1)
                    {
                        var SectorSelect = document.createElement("select");
                        SectorSelect.style.width = '100%';
                        SectorSelect.addEventListener('change',AttribSector);
                        SectorSelect.addEventListener('keydown',GoBack);
                        SectorSelect.value = grupMasina;
                        clickedSectorCell.appendChild(SectorSelect);
                        var BlankOption = document.createElement("option");
                        BlankOption.value = '';
                        SectorSelect.appendChild(BlankOption);
                        for(x = 1; x < SetSecRESPONSElist.length; x++)
                        {
                            var SectorOption = document.createElement("option");
                            SectorOption.value = SetSecRESPONSElist[x];
                            SectorOption.innerHTML = SetSecRESPONSElist[x];
                            SectorSelect.appendChild(SectorOption);
                        }
                        clickedSectorCell.removeEventListener('click',SetSector);
                    }
                }
                else{console.log(SetSec.responseText);}
            }
        }
        SetSecPARAMS = 'alarm=AtribuireSector&grupMasina='+grupMasina;
        SetSec.open('POST','ajax.process.php', true);
        SetSec.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        SetSec.send(SetSecPARAMS);
    }
}

function EmployeeSectorChange()
{
    console.log('Changing employee sector. New function,too?');
}

function EmployeeSectorReject()
{
    var Pressed = event.key;
    var DefaultValue = event.target.options[0].value;
    var SectorCell = event.target.parentNode;
    if(Pressed == 'Escape' || Pressed == 'Backspace')
    {
        event.preventDefault();
        SectorCell.innerHTML = DefaultValue;
        document.getElementById("Busy").innerHTML = "0";
    }
    else if(Pressed == 'Enter')
    {
        event.preventDefault();
        if(event.target.selectedIndex == '0')
        {
            SectorCell.innerHTML = DefaultValue;
            document.getElementById("Busy").innerHTML = "0";
        }
        else EmployeeSectorChange();
    }
}

function SectorChange(Box)
{
    if((window.parent.mysector.innerHTML == 'MANAGEMENT' || window.parent.mysector.innerHTML == 'ERP') && document.getElementById("Busy").innerHTML == '0')
    {
        document.getElementById("Busy").innerHTML = '1';
        var BoxValue = Box.innerHTML;
        Box.innerHTML = '';
        var SectorChoice = document.createElement('select');
        SectorChoice.style.width = '100%';
        SectorChoice.addEventListener('change',EmployeeSectorChange);
        SectorChoice.addEventListener('keydown',EmployeeSectorReject);
        var SectorChoice_Option = document.createElement('option');
        SectorChoice_Option.value = BoxValue;
        SectorChoice_Option.innerHTML = BoxValue;
        SectorChoice.appendChild(SectorChoice_Option);
        Box.appendChild(SectorChoice);
        if(window.XMLHttpRequest){GetSectors = new XMLHttpRequest();}
        else{GetSectors = new ActiveXObject('Microsoft.XMLHTTP');}
        GetSectors.onreadystatechange = function()
        {
            if(GetSectors.readyState==4 && GetSectors.status==200)
            {
                GetSectorsRESPONSElist = GetSectors.responseText.split('^');
                //console.log(GetSectors.responseText);
                if(GetSectorsRESPONSElist[0] == 'OK')
                {
                    if(GetSectorsRESPONSElist.length > 1)
                    {
                        for(i = 1; i < GetSectorsRESPONSElist.length; i++)
                        {
                            var NewOption = document.createElement('option');
                            NewOption.value = GetSectorsRESPONSElist[i];
                            NewOption.innerHTML = GetSectorsRESPONSElist[i];
                            SectorChoice.appendChild(NewOption);
                        } 
                    }
                }
                else{console.log(GetSectors.responseText);}
            }
        }
        GetSectorsPARAMS = 'alarm=GrabSectors&exclude='+BoxValue;
        GetSectors.open('POST','ajax.process.php', true);
        GetSectors.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        GetSectors.send(GetSectorsPARAMS);
        Box.focus();
        Box.select;
    }
}
function ImputCheck()
{
    var MyKey = event.key;
    if(MyKey != 'Backspace' && MyKey != 'Enter' && MyKey != 'Tab')
    {
        if(/[0-9]/i.test(event.key)){document.activeElement.style.textTransform = "uppercase";}
        else{event.preventDefault();}
    }
    else if(MyKey == 'Enter' || MyKey == 'Tab' )
    {
        event.preventDefault();
        if(document.activeElement.innerHTML == '0')
        {
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).disabled = false;
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).disabled = true;
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).focus();
        }
        else if(document.activeElement.innerHTML != '')
        {
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).disabled = false;
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).disabled = true;
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).focus();
        }
        else
        {
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Remarca' + (document.activeElement.parentNode.rowIndex - 1)).disabled = true;
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Motivare' + (document.activeElement.parentNode.rowIndex - 1)).disabled = true;
            document.getElementById('AngajatPrezent' + (document.activeElement.parentNode.rowIndex - 1)).value = 'DA';
            document.getElementById('AngajatPrezent' + (document.activeElement.parentNode.rowIndex - 1)).style.backgroundColor = 'green';
            document.activeElement.contentEditable = false;
        }
    }
}

function UpdateEmployee(UpdatingField)
{
    console.log('Updating employee data at ' + UpdatingField.id);
    if(UpdatingField.id.indexOf('AngajatPrezent') != -1)
    {
        if(UpdatingField.value == 'DA')
        {
            UpdatingField.style.backgroundColor = 'green';
            document.getElementById('durata'+(UpdatingField.parentNode.parentNode.rowIndex - 1)).innerHTML = '';
            document.getElementById('durata'+(UpdatingField.parentNode.parentNode.rowIndex - 1)).contentEditable = false;
            document.getElementById('Remarca' + (document.activeElement.parentNode.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Remarca' + (document.activeElement.parentNode.parentNode.rowIndex - 1)).disabled = true;
            document.getElementById('Motivare' + (document.activeElement.parentNode.parentNode.rowIndex - 1)).value = '';
            document.getElementById('Motivare' + (document.activeElement.parentNode.parentNode.rowIndex - 1)).disabled = true;
        }
        else if(UpdatingField.value == 'NU')
        {
            UpdatingField.style.backgroundColor = 'red';
            document.getElementById('durata'+(UpdatingField.parentNode.parentNode.rowIndex - 1)).contentEditable = true;
            document.getElementById('durata'+(UpdatingField.parentNode.parentNode.rowIndex - 1)).focus();
        }
    }
    else if(UpdatingField.id.indexOf('Motivare') != -1)
    {
        console.log('Angajat absent. Facem update!');
        if(window.XMLHttpRequest){AbsenceXml = new XMLHttpRequest();}
        else{AbsenceXml = new ActiveXObject('Microsoft.XMLHTTP');}
        AbsenceXml.onreadystatechange = function()
        {
            if(AbsenceXml.readyState==4 && AbsenceXml.status==200)
            {
                AbsenceXmlRespList = AbsenceXml.responseText.split('^');
                //console.log(pdis.responseText);
                if(AbsenceXmlRespList[0] == 'OK')
                {
                    console.log(AbsenceXml.responseText);
                }
                else{console.log(AbsenceXml.responseText);}
            }
        }
        AbsenceXmlParams = 'alarm=AngajatAbsent&numeAngajat='+numeAngajat+'&Reason='+AbsenceReason;
        AbsenceXml.open('POST','ajax.process.php', true);
        AbsenceXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        AbsenceXml.send(AbsenceXmlParams);
    }
    else if(UpdatingField.id.indexOf('Remarca') != -1)
    {
        console.log('Angajat plecat din firma. Facem update!');
        var numeAngajat = UpdatingField.parentNode.parentNode.cells[2].innerHTML;
        var LeaveReason = UpdatingField.value;
        console.log(numeAngajat);
        if(window.XMLHttpRequest){LeaveXml = new XMLHttpRequest();}
        else{LeaveXml = new ActiveXObject('Microsoft.XMLHTTP');}
        LeaveXml.onreadystatechange = function()
        {
            if(LeaveXml.readyState==4 && LeaveXml.status==200)
            {
                LeaveXmlRespList = LeaveXml.responseText.split('^');
                //console.log(pdis.responseText);
                if(LeaveXmlRespList[0] == 'OK')
                {
                    console.log(LeaveXml.responseText);
                    UpdatingField.disabled = true;
                }
                else{console.log(LeaveXml.responseText);}
            }
        }
        LeaveXmlParams = 'alarm=AngajatPeLeave&numeAngajat='+numeAngajat+'&Reason='+LeaveReason;
        LeaveXml.open('POST','ajax.process.php', true);
        LeaveXml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        LeaveXml.send(LeaveXmlParams);
    }
}

function LoadOrdersText(myText)
{
    document.getElementById('loadingTEXT').innerHTML = myText;
}
function confirmare()
{
    alert('Functia inca nu a fost implementata!');
}

function close_print()
{
    window.print();
}

function comenziShow()
{
    var impLIST = document.getElementById('emergency').querySelectorAll('input');
    var queryuser = document.getElementById("semnaturaGESTIONAR").innerHTML;
    showPARAMS = 'alarm=ordersDisplay&queryuser=' + queryuser + '&importance=';
    var impCount = 0;
    for(x = 0; x < impLIST.length; x++)
    {
        if(impLIST[x].checked == true) 
        {
            if(x > 0) showPARAMS = showPARAMS + ',';
            impCount++;
            showPARAMS = showPARAMS  + document.querySelector("label[for='" + impLIST[x].id + "']").innerHTML.trimStart();
        }
    }
    if(impCount == 0)
    {
        document.getElementById("SetupMessage").innerHTML = 'Trebuie sa selectati cel putin o importanta!';
        document.getElementById("SetupMessage").style.display = "BLOCK";
    }
    else
    {
        showPARAMS = showPARAMS + '&sector=';
        var sectorLIST = document.getElementById('sectorOPTIONS').querySelectorAll('input');
        var sectorCount = 0;
        for(s = 0; s < sectorLIST.length; s++)
        {
            if(sectorLIST[s].checked == true)
            {
                sectorCount++;
                showPARAMS = showPARAMS  + document.querySelector("label[for='" + sectorLIST[s].id + "']").innerHTML.trimStart();
            }
        }
        showPARAMS = showPARAMS + '&group=';
        if(sectorCount == 0) 
        {
            document.getElementById("SetupMessage").innerHTML = 'Nu a fost selectat un sector!';
            document.getElementById("SetupMessage").style.display = "BLOCK";
        }
        else
        {
            var grupLIST = document.getElementById('machineGROUPS').querySelectorAll('input');
            var grupCount = 0;
            for(g= 0; g < grupLIST.length; g++)
            {
                if(grupLIST[g].checked == true)
                {
                    if(grupCount > 0) showPARAMS = showPARAMS + ',';
                    grupCount++;
                    showPARAMS = showPARAMS  + document.querySelector("label[for='" + grupLIST[g].id + "']").innerHTML.trimStart();
                }
            }
            showPARAMS = showPARAMS + '&machine=';
            if(grupCount == 0)
            {
                document.getElementById("SetupMessage").innerHTML = 'Trebuie sa selectati cel putin un grup de masini!';
                document.getElementById("SetupMessage").style.display = "BLOCK";
            }
            else
            {
                if(document.getElementById('selectareMasina').value != '')
                {
                    showPARAMS = showPARAMS + document.getElementById('selectareMasina').value + '&angajat=';
                }
                else
                {
                    showPARAMS = showPARAMS + '&angajat=';
                }
                if(document.getElementById('selectareAngajat').value != '')
                {
                    showPARAMS = showPARAMS + document.getElementById('selectareAngajat').value;
                }
                //console.log(showPARAMS);
                if(impCount == impLIST.length) 
                {
                    document.getElementById('confDIALOG').style.display = "BLOCK";
                }
                else
                {
                    sendData();
                }
            }
        }
    }
}

function sendData()
{
    if(window.XMLHttpRequest){setupXML = new XMLHttpRequest();}
    else{setupXML = new ActiveXObject('Microsoft.XMLHTTP');}
    setupXML.onreadystatechange = function()
    {
        if(setupXML.readyState==4 && setupXML.status==200)
        {
            setupXMLRESPONSElist = setupXML.responseText.split('^');
            //console.log(pdis.responseText);
            if(setupXMLRESPONSElist[0] == 'OK')
            {
                document.getElementById('setupModal').style.display = 'none';
                if(setupXMLRESPONSElist.length > 1)
                {
                    var OrdersTable = document.getElementById('OrdersDisplayTable');
                    for(i = 1; i < setupXMLRESPONSElist.length; i = i + 12)
                    {
                        var rows = OrdersTable.rows.length;
                        var newRow = OrdersTable.insertRow(rows);
                        var ImpCell = newRow.insertCell(0);
                        ImpCell.style.border = '1px SOLID BLACK';
                        if(setupXMLRESPONSElist[i] <= 0)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: BROWN;"></DIV>';}
                        else if(setupXMLRESPONSElist[i] > 0 && setupXMLRESPONSElist[i] <= 5)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: RED;"></DIV>';}
                        else if(setupXMLRESPONSElist[i] > 5 && setupXMLRESPONSElist[i] < 10)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: YELLOW;"></DIV>';}
                        else
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: GREEN;"></DIV>';}
                        ImpCell.style.fontSize = '0.8vw';
                        ImpCell.innerHTML = indicator+' '+setupXMLRESPONSElist[i];
                        var PJCell = newRow.insertCell(1);
                        PJCell.style.border = '1px SOLID BLACK';
                        PJCell.style.fontSize = '0.8vw';
                        PJCell.addEventListener('click',ShowOrderDetails);
                        PJCell.innerHTML = setupXMLRESPONSElist[i+1];
                        var POCell = newRow.insertCell(2);
                        POCell.style.border = '1px SOLID BLACK';
                        POCell.style.fontSize = '0.8vw';
                        POCell.addEventListener('click',ShowOrderDetails);
                        POCell.innerHTML = setupXMLRESPONSElist[i+2];
                        var OPCell = newRow.insertCell(3);
                        OPCell.style.border = '1px SOLID BLACK';
                        OPCell.style.fontSize = '0.8vw';
                        OPCell.innerHTML = setupXMLRESPONSElist[i+3];
                        var BucCell = newRow.insertCell(4);
                        BucCell.style.border = '1px SOLID BLACK';
                        BucCell.style.fontSize = '0.8vw';
                        BucCell.innerHTML = setupXMLRESPONSElist[i+4];
                        var DoneCell = newRow.insertCell(5);
                        DoneCell.style.border = '1px SOLID BLACK';
                        DoneCell.style.fontSize = '0.8vw';
                        DoneCell.innerHTML = setupXMLRESPONSElist[i+5];
                        var SectorCell = newRow.insertCell(6);
                        SectorCell.style.border = '1px SOLID BLACK';
                        SectorCell.style.fontSize = '0.8vw';
                        SectorCell.innerHTML = setupXMLRESPONSElist[i+6];
                        if(setupXMLRESPONSElist[i+6] == '')
                        {
                            SectorCell.addEventListener('click',SetSector);
                        }
                        var NormCell = newRow.insertCell(7);
                        NormCell.style.border = '1px SOLID BLACK';
                        NormCell.style.fontSize = '0.8vw';
                        NormCell.innerHTML = setupXMLRESPONSElist[i+7];
                        var ExeCell = newRow.insertCell(8);
                        ExeCell.style.border = '1px SOLID BLACK';
                        ExeCell.style.fontSize = '0.8vw';
                        ExeCell.innerHTML = setupXMLRESPONSElist[i+8];
                        var GrupCell = newRow.insertCell(9);
                        GrupCell.style.border = '1px SOLID BLACK';
                        GrupCell.style.fontSize = '0.8vw';
                        GrupCell.innerHTML = setupXMLRESPONSElist[i+9];
                        var MachCell = newRow.insertCell(10);
                        MachCell.style.border = '1px SOLID BLACK';
                        MachCell.style.fontSize = '0.8vw';
                        MachCell.innerHTML = setupXMLRESPONSElist[i+10];
                        var EmployeeCell = newRow.insertCell(11);
                        EmployeeCell.style.border = '1px SOLID BLACK';
                        EmployeeCell.style.fontSize = '0.8vw';
                        EmployeeCell.innerHTML = setupXMLRESPONSElist[i+11];
                    }
                }
            }
            else
            {
                document.getElementById("SetupMessage").innerHTML = setupXMLRESPONSElist[0];
                document.getElementById("SetupMessage").style.display = "BLOCK";
                console.log(setupXML.responseText);
            }
        }
    }
    setupXML.open('POST','ajax.process.php', true);
    setupXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    setupXML.send(showPARAMS);
}

function userAccept(chosenBUTTON)
{
    if(chosenBUTTON.id == 'confYES')
    {
        document.getElementById('confDIALOG').style.display = "NONE";
        sendData();
    }
    else if(chosenBUTTON.id == 'confNO')
    {
        document.getElementById('confDIALOG').style.display = "NONE";
    }
}

function inserareGESTIONAR()
{
    document.getElementById("semnaturaGESTIONAR").innerHTML = parent.gestionar.innerHTML;
}

function EmployeeFiltering()
{
    var selection = event.target;
    var MyTable = selection.parentNode.parentNode.parentNode.parentNode.parentNode;
    var RowsCount = MyTable.rows.length;
    var Sorter = '';
    if(RowsCount > 2)
    {
        var EmployeesUser = document.getElementById('semnaturaGESTIONAR').innerHTML;
        var MyCell = selection.parentNode.parentNode.cellIndex;
        var Employee = selection.alt;
        if(Employee == '' || Employee == 'ASC'){selection.alt = 'DESC';}
        else{selection.alt = 'ASC';}
        if(MyCell == 1) Sorter = 'WORKER_ID';
        else if(MyCell == 2) Sorter = 'WORKER_Name';
        else if(MyCell == 3) Sorter = 'sectie';
        else if(MyCell == 4) Sorter = 'incadrare';
        else if(MyCell == 5) Sorter = 'masina';
        else if(MyCell == 6) Sorter = 'clasa_MASINA';
        else if(MyCell == 7) Sorter = 'masina_SEC';
        else if(MyCell == 8) Sorter = 'clasa_SEC';
        var SortTableData = 'alarm=SortEmployees&user='+EmployeesUser+'&sorter='+Sorter+' '+selection.alt;
        if(window.XMLHttpRequest){SortEmplXML = new XMLHttpRequest();}
        else{SortEmplXML = new ActiveXObject('Microsoft.XMLHTTP');}
        SortEmplXML.onreadystatechange = function()
        {
            if(SortEmplXML.readyState==4 && SortEmplXML.status==200)
            {
                SortEmplXMLRespList = SortEmplXML.responseText.split('^');
                if(SortEmplXMLRespList[0] == 'OK')
                {
                    //console.log(SortEmplXML.responseText);
                    var RowWrite = 2;
                    //console.log(MyRow.cells);
                    for(i = 1; i < SortEmplXMLRespList.length; i = i + 12)
                    {
                        var MyRow = MyTable.rows[RowWrite];
                        MyRow.cells[1].innerHTML = SortEmplXMLRespList[i];
                        MyRow.cells[2].innerHTML = SortEmplXMLRespList[i+1];
                        MyRow.cells[3].innerHTML = SortEmplXMLRespList[i+2];
                        MyRow.cells[4].innerHTML = SortEmplXMLRespList[i+3];
                        MyRow.cells[5].innerHTML = SortEmplXMLRespList[i+4];
                        MyRow.cells[6].innerHTML = SortEmplXMLRespList[i+5];
                        MyRow.cells[6].addEventListener('click',SetSector);
                        MyRow.cells[7].innerHTML = SortEmplXMLRespList[i+6];
                        MyRow.cells[8].innerHTML = SortEmplXMLRespList[i+7];
                        MyRow.cells[9].innerHTML = SortEmplXMLRespList[i+8];
                        MyRow.cells[10].innerHTML = SortEmplXMLRespList[i+9];
                        MyRow.cells[11].innerHTML = SortEmplXMLRespList[i+10];
                        RowWrite++;
                    }
                }
                else console.log(SortEmplXML.responseText);
            }
        }
        SortEmplXML.open('POST','ajax.process.php', true);
        SortEmplXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        SortEmplXML.send(SortTableData);
    }
}

function OrdersFiltering()
{
    document.getElementById("Busy").innerHTML = "0";
    var selection = event.target;
    var MyTable = selection.parentNode.parentNode.parentNode.parentNode.parentNode;
    var RowsCount = MyTable.rows.length;
    var Sorter = '';
    if(RowsCount > 2)
    {
        var OrdersUser = document.getElementById('semnaturaGESTIONAR').innerHTML;
        var MyCell = selection.parentNode.parentNode.cellIndex;
        var Order = selection.alt;
        if(Order == '' || Order == 'ASC'){selection.alt = 'DESC';}
        else{selection.alt = 'ASC';}
        if(MyCell == 0) Sorter = 'importance';
        else if(MyCell == 1) Sorter = 'productionJob';
        else if(MyCell == 2) Sorter = 'productionOrder';
        else if(MyCell == 6) Sorter = 'sector';
        else if(MyCell == 10) Sorter = 'machine';
        /*for(i = 2; i < RowsCount; i++)
        {
            var SortData = MyTable.rows[i].cells[MyCell].innerHTML;
            var StrIndex = SortData.indexOf('</div>');
            SortData = SortData.substring(StrIndex + 6);
            console.log(SortData);
        }*/
        var SortTableData = 'alarm=SortOrders&user='+OrdersUser+'&sorter='+Sorter+' '+selection.alt;
        if(window.XMLHttpRequest){SortOrXML = new XMLHttpRequest();}
        else{SortOrXML = new ActiveXObject('Microsoft.XMLHTTP');}
        SortOrXML.onreadystatechange = function()
        {
            if(SortOrXML.readyState==4 && SortOrXML.status==200)
            {
                SortOrXMLRespList = SortOrXML.responseText.split('^');
                if(SortOrXMLRespList[0] == 'OK')
                {
                    //console.log(SortOrXML.responseText);
                    var RowWrite = 2;
                    //console.log(MyRow.cells);
                    for(i = 1; i < SortOrXMLRespList.length; i = i + 12)
                    {
                        var MyRow = MyTable.rows[RowWrite];
                        if(SortOrXMLRespList[i] <= 0)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: BROWN;"></DIV>';}
                        else if(SortOrXMLRespList[i] > 0 && SortOrXMLRespList[i] <= 5)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: RED;"></DIV>';}
                        else if(SortOrXMLRespList[i] > 5 && SortOrXMLRespList[i] < 10)
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: YELLOW;"></DIV>';}
                        else
                        {indicator = '<DIV STYLE = "WIDTH: 7px; HEIGHT: 7px; BORDER-RADIUS: 50px; BORDER: 1px SOLID BLACK; BACKGROUND-COLOR: GREEN;"></DIV>';}
                        MyRow.cells[0].innerHTML = indicator + SortOrXMLRespList[i];
                        MyRow.cells[1].innerHTML = SortOrXMLRespList[i+1];
                        MyRow.cells[2].innerHTML = SortOrXMLRespList[i+2];
                        MyRow.cells[3].innerHTML = SortOrXMLRespList[i+3];
                        MyRow.cells[4].innerHTML = SortOrXMLRespList[i+4];
                        MyRow.cells[5].innerHTML = SortOrXMLRespList[i+5];
                        MyRow.cells[6].innerHTML = SortOrXMLRespList[i+6];
                        MyRow.cells[6].addEventListener('click',SetSector);
                        MyRow.cells[7].innerHTML = SortOrXMLRespList[i+7];
                        MyRow.cells[8].innerHTML = SortOrXMLRespList[i+8];
                        MyRow.cells[9].innerHTML = SortOrXMLRespList[i+9];
                        MyRow.cells[10].innerHTML = SortOrXMLRespList[i+10];
                        MyRow.cells[11].innerHTML = SortOrXMLRespList[i+11];
                        RowWrite++;
                    }
                }
                else console.log(SortOrXML.responseText);
            }
        }
        SortOrXML.open('POST','ajax.process.php', true);
        SortOrXML.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        SortOrXML.send(SortTableData);
    }
}

function loadGROUPS(sectorCHECK)
{
    var sectorSET = document.querySelector("label[for='" + sectorCHECK.id + "']").innerHTML.trimStart();
    document.getElementById('machGROUPS1').innerHTML = '';
    document.getElementById('machGROUPS2').innerHTML = '';
    document.getElementById('machGROUPS3').innerHTML = '';
    document.getElementById('selectareMasina').innerHTML = '<OPTION></OPTION>';
    document.getElementById('selectareAngajat').innerHTML = '<OPTION></OPTION>';
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
            if(labels[i].innerHTML.trimStart() == USERsector)
            {
                document.getElementById(labels[i].htmlFor).checked = true;
                loadGROUPS(document.getElementById(labels[i].htmlFor));
                break;
            }
        }
    }
    else
    {
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
    else if((setOPTION.id.indexOf('grupSelect') != -1))
    {
        var machineSET = document.querySelector("label[for='" + setOPTION.id + "']").innerHTML;
        var sectorsLIST = document.getElementById('sectorOPTIONS').querySelectorAll('label');
        document.getElementById('selectareMasina').innerHTML = '<OPTION></OPTION>';
        document.getElementById('selectareAngajat').innerHTML = '<OPTION></OPTION>';
        for(i = 0; i < sectorsLIST.length; i++)
        {
            if(document.getElementById(sectorsLIST[i].htmlFor).checked == true)
            {
                var options2SEND = "alarm=getEmployees&sector=" + sectorsLIST[i].innerHTML.trimStart() + "&machineGroups=";
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
                                        document.getElementById('selectareMasina').innerHTML = '<OPTION></OPTION>';
                                        document.getElementById('selectareAngajat').innerHTML = '<OPTION></OPTION>';
                                        var mch2SET = '';
                                        for(k=1; k < opSENDRESPONSElist.length; k = k + 2)
                                        {
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
                                    else
                                    {
                                        document.getElementById('selectareMasina').innerHTML = '<OPTION></OPTION>';
                                        document.getElementById('selectareAngajat').innerHTML = '<OPTION></OPTION>';
                                    }
                                    //console.log('Got: '+ opSEND.responseText);
                                }
                                else
                                {
                                    console.log(opSEND.responseText);
                                    document.getElementById("SetupMessage").innerHTML = opSENDRESPONSElist[0];
                                    document.getElementById("SetupMessage").style.display = "BLOCK";
                                }
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
}

function productionDISPLAY(clicked_id)
{
    if(clicked_id == displayORDERS.id || clicked_id == displayWORKERS.id || clicked_id == displayMACHINES.id)
    {
        document.getElementById('scanareComenzi').style.display = "none";
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
                    if(clicked_id == displayORDERS.id && mysector != 'ERP' && mysector != 'MANAGEMENT') document.getElementById('AtribuireAutomata').style.display = 'block';
                    else  document.getElementById('AtribuireAutomata').style.display = 'none';
                    document.getElementById('bonFRAME').style.backgroundImage = "url('/ramira/magazie/images/Working.gif')";
                    document.getElementById('bonFRAME').style.backgroundRepeat = 'NO-repeat';
                    document.getElementById('bonFRAME').style.backgroundPosition = 'Center';
                    if(clicked_id == displayORDERS.id)document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/afisare.comenzi.php?mysector="+mysector;
                    else if(clicked_id == displayWORKERS.id) document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/afisare.angajati.php?mysector="+mysector;
                    else if(clicked_id == displayMACHINES.id) document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/afisare.masini.php?mysector="+mysector;
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
        document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/loading.page.php";
        document.getElementById('bonFRAME').style.backgroundImage = "url('/ramira/magazie/images/Working.gif')";
        document.getElementById('bonFRAME').style.backgroundRepeat = 'NO-repeat';
        document.getElementById('bonFRAME').style.backgroundPosition = 'Center';
        if(window.XMLHttpRequest){pdisADMIN = new XMLHttpRequest();}
        else{pdisADMIN = new ActiveXObject('Microsoft.XMLHTTP');}
        var mysector = document.getElementById('sectieDISPLAY').innerHTML;
        pdisADMIN.onreadystatechange = function()
        {
            if(pdisADMIN.readyState==4 && pdisADMIN.status==200)
            {
                pdisADMINRESPONSElist = pdisADMIN.responseText.split('^');
                //console.log(pdisADMIN.responseText);
                if(pdisADMINRESPONSElist[0] == 'OK')
                {
                    if(pdisADMINRESPONSElist[1] == 'update done')document.getElementById('bonFRAME').src = "/ramira/magazie/rapoarte/rapoarteproductie/load.orders.php";
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
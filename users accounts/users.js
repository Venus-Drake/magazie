var tabelSUGESTII = document.getElementById('sugestionsTABLE');
var formularSUGEST = document.getElementById('formularSUGESTII');
var sugestie = document.getElementById('sugestieINPUT');
var textSUGESTIE = document.getElementById("sugestionTEXT");
var userNAME = document.getElementById('userNAME');
var numeUSER = document.getElementById('numeUSER');
var statusIN = document.getElementById("statusINSERTED");
var statVIEW = document.getElementById("statusVIEWED");
var statDONE = document.getElementById("statusSOLVED");
var acesLEV = document.getElementById("accesLEVEL");
var chestionarDIV = document.getElementById("chestionar");
var analizaDIV = document.getElementById("analiza");
var anaTABLE = document.getElementById("analiza_TABLE");
var mailDIV = document.getElementById("mailLIST");
var ziar = document.getElementById("ziar");
var cheTABLE = document.getElementById("chestionar_TABLE");
var user = document.getElementById("numeGESTIONAR").innerHTML;

function Q1_FUNCTION()
{
	var cheROW = cheTABLE.insertRow(0);
	cheROW.style.border = "2px SOLID BLACK";
	var cell1 = cheROW.insertCell(0);
	cell1.style.width = "50%";
	cell1.style.color = "black";
	cell1.style.fontSize = "1vw";
	cell1.style.textAlign = "left";
	var cell2 = cheROW.insertCell(1);
	cell2.style.color = "black";
	cell2.style.fontSize = "1vw";
	cell2.style.textAlign = "left";
	if(window.XMLHttpRequest){cheREQ = new XMLHttpRequest();}
	else{cheREQ = new ActiveXObject('Microsoft.XMLHTTP');}
	cheREQ.onreadystatechange = function()
	{
	    if(cheREQ.readyState==4 && cheREQ.status==200)
	    {
			//console.log(cheREQ.responseText);
		    cheLIST = cheREQ.responseText.split('^');
		    if(cheLIST[0] == 'OK')
		    {
				//console.log(cheLIST[1]);
				cell1.innerHTML = '1.&nbsp'+cheLIST[1];
				if(cheLIST[2] == "SELECT")
				{
					var mySELECT = document.createElement("SELECT");
					mySELECT.setAttribute("id", "mySelect");
					mySELECT.style.marginLeft = "2vw";
					mySELECT.style.width = cheLIST[3] + "vw";
					mySELECT.addEventListener("change",Q_PROCESS);
					var option = document.createElement("option");
					option.text = '';
					mySELECT.add(option);
				    for(k = 5; k < cheLIST.length; k = k + 5)
					{
						var option = document.createElement("option");
						option.text = cheLIST[k];
						mySELECT.add(option);
					}
					cell2.appendChild(mySELECT);
				}
				else{console.log('Answer type: '+cheLIST[2]);}
		    }
		    else{console.log(cheREQ.responseText);}
	    }
	}
	cheREQparams = 'chestionar=open';
	cheREQ.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	cheREQ.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	cheREQ.send(cheREQparams);
}

function Q_PROCESS()
{
	var myQUEST = event.target;
	var myLENGTH = cheTABLE.rows.length;
	var question = myQUEST.parentNode.parentNode.rowIndex + 1;
	var questTEXT = cheTABLE.rows[myQUEST.parentNode.parentNode.rowIndex].cells[0].innerHTML;
	if(myLENGTH >= 1)
	{
        if(document.getElementById("mySelect").value != '')
		{
			var answer = myQUEST.selectedIndex;
			if(answer == undefined && myQUEST.innerHTML == 'Trimite'){answer = 1;}
			if(window.XMLHttpRequest){proREQ = new XMLHttpRequest();}
			else{proREQ = new ActiveXObject('Microsoft.XMLHTTP');}
			proREQ.onreadystatechange = function()
			{
			    if(proREQ.readyState==4 && proREQ.status==200)
			    {
				    proLIST = proREQ.responseText.split('^');
				    if(proLIST[0] == 'OK')
				    {
						if(question < myLENGTH)
						{
						    for(i = myLENGTH-1; i > question-1; i--)
						    {
							    cheTABLE.deleteRow(i);
						    }
						    myLENGTH = cheTABLE.rows.length;
						    document.getElementById("endFORM").style.visibility = "collapse";
						}
						var cheROW = cheTABLE.insertRow(myLENGTH);
						cheROW.style.border = "2px SOLID BLACK";
						var cell1 = cheROW.insertCell(0);
						cell1.style.width = "50%";
						cell1.style.color = "black";
						cell1.style.fontSize = "1vw";
						cell1.style.textAlign = "left";
						var cell2 = cheROW.insertCell(1);
						cell2.style.color = "black";
						cell2.style.fontSize = "1vw";
						cell2.style.textAlign = "left";
						cell1.innerHTML = cheTABLE.rows.length+'.&nbsp'+proLIST[1];
						if(proLIST[2] == "SELECT")
						{
							var mySELECT = document.createElement("SELECT");
							mySELECT.setAttribute("id", "mySelect"+cheTABLE.rows.length);
							mySELECT.style.marginLeft = "2vw";
							mySELECT.style.width = proLIST[3] + "vw";
							mySELECT.addEventListener("change",Q_PROCESS);
							var option = document.createElement("option");
							option.text = '';
							mySELECT.add(option);
						    for(k = 5; k < proLIST.length; k = k + 5)
							{
								var option = document.createElement("option");
								option.text = proLIST[k];
								mySELECT.add(option);
							}
							cell2.appendChild(mySELECT);
						}
						else if(proLIST[2] == "BUTTON")
					    {
							cell2.style.textAlign = "center";
						    var myBUTTON = document.createElement("BUTTON");
						    myBUTTON.setAttribute("id", "myButton"+cheTABLE.rows.length);
						    myBUTTON.style.float = "none";
						    myBUTTON.style.margin = "0 auto";
						    myBUTTON.style.marginBottom = "1vh";
						    myBUTTON.style.width = proLIST[3]+"vw";
						    myBUTTON.style.height = proLIST[4]+"vh";
						    myBUTTON.style.fontWeight = "BOLD";
						    myBUTTON.addEventListener("click",END_FUNCTION);
						    myBUTTON.innerHTML = proLIST[5];
						    cell2.appendChild(myBUTTON);
					    }
					    else if(proLIST[2] == "TEXTAREA")
					    {
							var myTEXT = document.createElement("TEXTAREA");
							myTEXT.setAttribute("id","myInput"+cheTABLE.rows.length);
							myTEXT.style.marginLeft = "2vw";
							myTEXT.style.resize = "none";
							myTEXT.style.width = proLIST[3]+"vw";
							myTEXT.style.height = proLIST[4]+"vh";
							cell2.appendChild(myTEXT);
							var myBUTTON = document.createElement("BUTTON");
						    myBUTTON.setAttribute("id", "myButton"+cheTABLE.rows.length);
						    myBUTTON.style.float = "none";
						    myBUTTON.style.marginLeft = "2vw";
						    myBUTTON.style.marginBottom = "1vh";
						    myBUTTON.style.width = "4.5vw";
						    myBUTTON.style.height = "2.5vh";
						    myBUTTON.style.fontWeight = "BOLD";
						    myBUTTON.addEventListener("click",Q_PROCESS);
						    myBUTTON.innerHTML = "Trimite";
						    cell2.appendChild(myBUTTON);
						    myTEXT.focus();
					    }
				    }
				    else{console.log(proREQ.responseText);}
			    }
			}
			proREQparams = 'chestionar=running&quest='+question+'&answer='+answer+'&question='+encodeURIComponent(questTEXT);
			proREQ.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
			proREQ.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			proREQ.send(proREQparams);
		}
    }
}
function END_FUNCTION()
{
	var chestionarNR = document.getElementById("numarCHESTIONAR").innerHTML;
	if(cheTABLE.rows.length > 1)
	{
		for(k = 1; k <= cheTABLE.rows.length; k++)
		{
			queNR = k;
			questTEXT = cheTABLE.rows[k-1].cells[0].innerHTML;
			var answerTYPE = cheTABLE.rows[k-1].cells[1].childNodes[0];
			if(answerTYPE.tagName == 'SELECT'){answer = answerTYPE.value;}
			else{answer = answerTYPE.innerHTML;}
			if(window.XMLHttpRequest){cheEND = new XMLHttpRequest();}
			else{cheEND = new ActiveXObject('Microsoft.XMLHTTP');}
			cheEND.onreadystatechange = function()
			{
				if(cheEND.readyState==4 && cheEND.status==200)
		  		{
					cheENDLIST = cheEND.responseText.split('^');
					if(cheENDLIST[0] == 'DONE')
					{
		                document.getElementById("endFORM").style.visibility = "visible";
		            }
		            else if(cheENDLIST[0] == 'RECORDED')
		            {
					    document.getElementById("endFORM").style.visibility = "hidden";
		            }
		            else {console.log(cheEND.responseText);}
		        }
		    }
		    if(k < cheTABLE.rows.length){cheENDparams = 'alarm=record&user='+user+'&chestionar='+chestionarNR+'&queNR='+queNR+'&question='+encodeURIComponent(questTEXT)+'&answer='+encodeURIComponent(answer);}
		    else if(k == cheTABLE.rows.length){cheENDparams = 'alarm=done&user='+user+'&chestionar='+chestionarNR+'&queNR='+queNR+'&question='+encodeURIComponent(questTEXT)+'&answer='+encodeURIComponent(answer);}
			cheEND.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
			cheEND.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			cheEND.send(cheENDparams);
		}
	}
	else{console.log('Chestionar incorect! Va rugam, anuntati administratorul!');}
}
function analizaCHESTIONAR()
{
    if(window.getComputedStyle(analizaDIV).display == 'none')
    {
	    analizaDIV.style.display = 'block';
	    analizaFUNCTION();
    }
    else
    {
	    analizaDIV.style.display = 'none';
    }
}
function analizaFUNCTION()
{
    if(window.XMLHttpRequest){cheANA = new XMLHttpRequest();}
	else{cheANA = new ActiveXObject('Microsoft.XMLHTTP');}
	cheANA.onreadystatechange = function()
	{
		if(cheANA.readyState==4 && cheANA.status==200)
  		{
			cheANALIST = cheANA.responseText.split('^');
			if(cheANALIST[0] == 'OK')
			{
				if(cheANALIST[1] != 'Nothing')
				{
					var newUSER = ''; var totalPOINTS = 0;
				    for(k = 1; k < cheANALIST.length; k = k+24)
				    {
					    if(cheANALIST[k] != newUSER && cheANALIST[k] != '')
					    {
						    newUSER = cheANALIST[k];
						    totalPOINTS = 0;
							var newROW = anaTABLE.insertRow(anaTABLE.rows.length);
							var cell1 = newROW.insertCell(0);
							cell1.style.border = "1px SOLID BLACK";
							cell1.style.fontSize = "1vw";
							cell1.innerHTML = newUSER;
							var cell2 = newROW.insertCell(1);
							cell2.style.border = "1px SOLID BLACK";
							cell2.style.fontSize = "1vw";
							cell2.innerHTML = cheANALIST[k+1];
							var cell3 = newROW.insertCell(2);
							cell3.style.border = "1px SOLID BLACK";
							cell3.style.fontSize = "1vw";
							cell3.innerHTML = cheANALIST[k+2];
							var cell4 = newROW.insertCell(3);
							cell4.style.border = "1px SOLID BLACK";
							cell4.style.fontSize = "1vw";
							cell4.innerHTML = cheANALIST[k+3];
							var cell5 = newROW.insertCell(4);
							cell5.style.border = "1px SOLID BLACK";
							cell5.style.fontSize = "1vw";
							var point = document.createElement("INPUT");
							point.style.width = "5vw";
							cell5.appendChild(point);
							point.addEventListener("keydown",pointsKEYCHK);
							if(cheANALIST[k+4] != '')
							{
								newROW = anaTABLE.insertRow(anaTABLE.rows.length);
								var cell1 = newROW.insertCell(0);
								cell1.style.border = "1px SOLID BLACK";
								cell1.style.fontSize = "1vw";
								var cell2 = newROW.insertCell(1);
								cell2.style.border = "1px SOLID BLACK";
								cell2.style.fontSize = "1vw";
								cell2.innerHTML = cheANALIST[k+1];
								var cell3 = newROW.insertCell(2);
								cell3.style.border = "1px SOLID BLACK";
								cell3.style.fontSize = "1vw";
								cell3.innerHTML = cheANALIST[k+4];
								var cell4 = newROW.insertCell(3);
								cell4.style.border = "1px SOLID BLACK";
								cell4.style.fontSize = "1vw";
								cell4.innerHTML = cheANALIST[k+5];
								var cell5 = newROW.insertCell(4);
								cell5.style.border = "1px SOLID BLACK";
								cell5.style.fontSize = "1vw";
								var point = document.createElement("INPUT");
								point.style.width = "5vw";
								cell5.appendChild(point);
								point.addEventListener("keydown",pointsKEYCHK);
								if(cheANALIST[k+6] != '')
								{
								    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
									var cell1 = newROW.insertCell(0);
									cell1.style.border = "1px SOLID BLACK";
									cell1.style.fontSize = "1vw";
									var cell2 = newROW.insertCell(1);
									cell2.style.border = "1px SOLID BLACK";
									cell2.style.fontSize = "1vw";
									cell2.innerHTML = cheANALIST[k+1];
									var cell3 = newROW.insertCell(2);
									cell3.style.border = "1px SOLID BLACK";
									cell3.style.fontSize = "1vw";
									cell3.innerHTML = cheANALIST[k+6];
									var cell4 = newROW.insertCell(3);
									cell4.style.border = "1px SOLID BLACK";
									cell4.style.fontSize = "1vw";
									cell4.innerHTML = cheANALIST[k+7];
									var cell5 = newROW.insertCell(4);
									cell5.style.border = "1px SOLID BLACK";
									cell5.style.fontSize = "1vw";
									var point = document.createElement("INPUT");
									point.style.width = "5vw";
									cell5.appendChild(point);
									point.addEventListener("keydown",pointsKEYCHK);
									if(cheANALIST[k+8] != '')
									{
									    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
										var cell1 = newROW.insertCell(0);
										cell1.style.border = "1px SOLID BLACK";
										cell1.style.fontSize = "1vw";
										var cell2 = newROW.insertCell(1);
										cell2.style.border = "1px SOLID BLACK";
										cell2.style.fontSize = "1vw";
										cell2.innerHTML = cheANALIST[k+1];
										var cell3 = newROW.insertCell(2);
										cell3.style.border = "1px SOLID BLACK";
										cell3.style.fontSize = "1vw";
										cell3.innerHTML = cheANALIST[k+8];
										var cell4 = newROW.insertCell(3);
										cell4.style.border = "1px SOLID BLACK";
										cell4.style.fontSize = "1vw";
										cell4.innerHTML = cheANALIST[k+9];
										var cell5 = newROW.insertCell(4);
										cell5.style.border = "1px SOLID BLACK";
										cell5.style.fontSize = "1vw";
										var point = document.createElement("INPUT");
										point.style.width = "5vw";
										cell5.appendChild(point);
										point.addEventListener("keydown",pointsKEYCHK);
										if(cheANALIST[k+10] != '')
										{
										    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
											var cell1 = newROW.insertCell(0);
											cell1.style.border = "1px SOLID BLACK";
											cell1.style.fontSize = "1vw";
											var cell2 = newROW.insertCell(1);
											cell2.style.border = "1px SOLID BLACK";
											cell2.style.fontSize = "1vw";
											cell2.style.fontSize = "1vw";
											cell2.innerHTML = cheANALIST[k+1];
											var cell3 = newROW.insertCell(2);
											cell3.style.border = "1px SOLID BLACK";
											cell3.style.fontSize = "1vw";
											cell3.innerHTML = cheANALIST[k+10];
											var cell4 = newROW.insertCell(3);
											cell4.style.border = "1px SOLID BLACK";
											cell4.style.fontSize = "1vw";
											cell4.innerHTML = cheANALIST[k+11];
											var cell5 = newROW.insertCell(4);
											cell5.style.border = "1px SOLID BLACK";
											cell5.style.fontSize = "1vw";
											var point = document.createElement("INPUT");
											point.style.width = "5vw";
											cell5.appendChild(point);
											point.addEventListener("keydown",pointsKEYCHK);
											if(cheANALIST[k+12] != '')
											{
											    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
												var cell1 = newROW.insertCell(0);
												cell1.style.border = "1px SOLID BLACK";
												cell1.style.fontSize = "1vw";
												var cell2 = newROW.insertCell(1);
												cell2.style.border = "1px SOLID BLACK";
												cell2.style.fontSize = "1vw";
												cell2.innerHTML = cheANALIST[k+1];
												var cell3 = newROW.insertCell(2);
												cell3.style.border = "1px SOLID BLACK";
												cell3.style.fontSize = "1vw";
												cell3.innerHTML = cheANALIST[k+12];
												var cell4 = newROW.insertCell(3);
												cell4.style.border = "1px SOLID BLACK";
												cell4.style.fontSize = "1vw";
												cell4.innerHTML = cheANALIST[k+13];
												var cell5 = newROW.insertCell(4);
												cell5.style.border = "1px SOLID BLACK";
												cell5.style.fontSize = "1vw";
												var point = document.createElement("INPUT");
												point.style.width = "5vw";
												cell5.appendChild(point);
												point.addEventListener("keydown",pointsKEYCHK);
												if(cheANALIST[k+14] != '')
												{
												    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
													var cell1 = newROW.insertCell(0);
													cell1.style.border = "1px SOLID BLACK";
													cell1.style.fontSize = "1vw";
													var cell2 = newROW.insertCell(1);
													cell2.style.border = "1px SOLID BLACK";
													cell2.style.fontSize = "1vw";
													cell2.innerHTML = cheANALIST[k+1];
													var cell3 = newROW.insertCell(2);
													cell3.style.border = "1px SOLID BLACK";
													cell3.style.fontSize = "1vw";
													cell3.innerHTML = cheANALIST[k+14];
													var cell4 = newROW.insertCell(3);
													cell4.style.border = "1px SOLID BLACK";
													cell4.style.fontSize = "1vw";
													cell4.innerHTML = cheANALIST[k+15];
													var cell5 = newROW.insertCell(4);
													cell5.style.border = "1px SOLID BLACK";
													cell5.style.fontSize = "1vw";
													var point = document.createElement("INPUT");
													point.style.width = "5vw";
													cell5.appendChild(point);
													point.addEventListener("keydown",pointsKEYCHK);
													if(cheANALIST[k+16] != '')
													{
													    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
														var cell1 = newROW.insertCell(0);
														cell1.style.border = "1px SOLID BLACK";
														cell1.style.fontSize = "1vw";
														var cell2 = newROW.insertCell(1);
														cell2.style.border = "1px SOLID BLACK";
														cell2.style.fontSize = "1vw";
														cell2.innerHTML = cheANALIST[k+1];
														var cell3 = newROW.insertCell(2);
														cell3.style.border = "1px SOLID BLACK";
														cell3.style.fontSize = "1vw";
														cell3.innerHTML = cheANALIST[k+16];
														var cell4 = newROW.insertCell(3);
														cell4.style.border = "1px SOLID BLACK";
														cell4.style.fontSize = "1vw";
														cell4.innerHTML = cheANALIST[k+17];
														var cell5 = newROW.insertCell(4);
														cell5.style.border = "1px SOLID BLACK";
														cell5.style.fontSize = "1vw";
														var point = document.createElement("INPUT");
														point.style.width = "5vw";
														cell5.appendChild(point);
														point.addEventListener("keydown",pointsKEYCHK);
														if(cheANALIST[k+18] != '')
														{
														    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
															var cell1 = newROW.insertCell(0);
															cell1.style.border = "1px SOLID BLACK";
															cell1.style.fontSize = "1vw";
															var cell2 = newROW.insertCell(1);
															cell2.style.border = "1px SOLID BLACK";
															cell2.style.fontSize = "1vw";
															cell2.innerHTML = cheANALIST[k+1];
															var cell3 = newROW.insertCell(2);
															cell3.style.border = "1px SOLID BLACK";
															cell3.style.fontSize = "1vw";
															cell3.innerHTML = cheANALIST[k+18];
															var cell4 = newROW.insertCell(3);
															cell4.style.border = "1px SOLID BLACK";
															cell4.style.fontSize = "1vw";
															cell4.innerHTML = cheANALIST[k+19];
															var cell5 = newROW.insertCell(4);
															cell5.style.border = "1px SOLID BLACK";
															cell5.style.fontSize = "1vw";
															var point = document.createElement("INPUT");
															point.style.width = "5vw";
															cell5.appendChild(point);
															point.addEventListener("keydown",pointsKEYCHK);
															if(cheANALIST[k+20] != '')
															{
															    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
																var cell1 = newROW.insertCell(0);
																cell1.style.border = "1px SOLID BLACK";
																cell1.style.fontSize = "1vw";
																var cell2 = newROW.insertCell(1);
																cell2.style.border = "1px SOLID BLACK";
																cell2.style.fontSize = "1vw";
																cell2.innerHTML = cheANALIST[k+1];
																var cell3 = newROW.insertCell(2);
																cell3.style.border = "1px SOLID BLACK";
																cell3.style.fontSize = "1vw";
																cell3.innerHTML = cheANALIST[k+20];
																var cell4 = newROW.insertCell(3);
																cell4.style.border = "1px SOLID BLACK";
																cell4.style.fontSize = "1vw";
																cell4.innerHTML = cheANALIST[k+21];
																var cell5 = newROW.insertCell(4);
																cell5.style.border = "1px SOLID BLACK";
																cell5.style.fontSize = "1vw";
																var point = document.createElement("INPUT");
																point.style.width = "5vw";
																cell5.appendChild(point);
																point.addEventListener("keydown",pointsKEYCHK);
																if(cheANALIST[k+22] != '')
																{
																    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
																	var cell1 = newROW.insertCell(0);
																	cell1.style.border = "1px SOLID BLACK";
																	cell1.style.fontSize = "1vw";
																	var cell2 = newROW.insertCell(1);
																	cell2.style.border = "1px SOLID BLACK";
																	cell2.style.fontSize = "1vw";
																	cell2.innerHTML = cheANALIST[k+1];
																	var cell3 = newROW.insertCell(2);
																	cell3.style.border = "1px SOLID BLACK";
																	cell3.style.fontSize = "1vw";
																	cell3.innerHTML = cheANALIST[k+22];
																	var cell4 = newROW.insertCell(3);
																	cell4.style.border = "1px SOLID BLACK";
																	cell4.style.fontSize = "1vw";
																	cell4.innerHTML = cheANALIST[k+23];
																	var cell5 = newROW.insertCell(4);
																	cell5.style.border = "1px SOLID BLACK";
																	cell5.style.fontSize = "1vw";
																	var point = document.createElement("INPUT");
																	point.style.width = "5vw";
																	cell5.appendChild(point);
																	point.addEventListener("keydown",pointsKEYCHK);
																}
																else
																{
																    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
																	var cell1 = newROW.insertCell(0);
																	var cell2 = newROW.insertCell(1);
																	var cell3 = newROW.insertCell(2);
																	var cell4 = newROW.insertCell(3);
																	cell4.style.borderRight = "1px SOLID BLACK";
																	cell4.style.textAlign = "RIGHT";
																	cell4.innerHTML = 'Total points:&nbsp&nbsp';
																	var cell5 = newROW.insertCell(4);
																	cell5.innerHTML = totalPOINTS+'&nbsppoints';
																}
															}
															else
															{
															    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
																var cell1 = newROW.insertCell(0);
																var cell2 = newROW.insertCell(1);
																var cell3 = newROW.insertCell(2);
																var cell4 = newROW.insertCell(3);
																cell4.style.borderRight = "1px SOLID BLACK";
																cell4.style.textAlign = "RIGHT";
																cell4.innerHTML = 'Total points:&nbsp&nbsp';
																var cell5 = newROW.insertCell(4);
																cell5.innerHTML = totalPOINTS+'&nbsppoints';
															}
														}
														else
														{
														    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
															var cell1 = newROW.insertCell(0);
															var cell2 = newROW.insertCell(1);
															var cell3 = newROW.insertCell(2);
															var cell4 = newROW.insertCell(3);
															cell4.style.borderRight = "1px SOLID BLACK";
															cell4.style.textAlign = "RIGHT";
															cell4.innerHTML = 'Total points:&nbsp&nbsp';
															var cell5 = newROW.insertCell(4);
															cell5.innerHTML = totalPOINTS+'&nbsppoints';
														}
													}
													else
													{
													    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
														var cell1 = newROW.insertCell(0);
														var cell2 = newROW.insertCell(1);
														var cell3 = newROW.insertCell(2);
														var cell4 = newROW.insertCell(3);
														cell4.style.borderRight = "1px SOLID BLACK";
														cell4.style.textAlign = "RIGHT";
														cell4.innerHTML = 'Total points:&nbsp&nbsp';
														var cell5 = newROW.insertCell(4);
														cell5.innerHTML = totalPOINTS+'&nbsppoints';
													}
												}
												else
												{
												    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
													var cell1 = newROW.insertCell(0);
													var cell2 = newROW.insertCell(1);
													var cell3 = newROW.insertCell(2);
													var cell4 = newROW.insertCell(3);
													cell4.style.borderRight = "1px SOLID BLACK";
													cell4.style.textAlign = "RIGHT";
													cell4.innerHTML = 'Total points:&nbsp&nbsp';
													var cell5 = newROW.insertCell(4);
													cell5.innerHTML = totalPOINTS+'&nbsppoints';
												}
											}
											else
											{
											    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
												var cell1 = newROW.insertCell(0);
												var cell2 = newROW.insertCell(1);
												var cell3 = newROW.insertCell(2);
												var cell4 = newROW.insertCell(3);
												cell4.style.borderRight = "1px SOLID BLACK";
												cell4.style.textAlign = "RIGHT";
												cell4.innerHTML = 'Total points:&nbsp&nbsp';
												var cell5 = newROW.insertCell(4);
												cell5.innerHTML = totalPOINTS+'&nbsppoints';
											}
										}
										else
										{
										    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
											var cell1 = newROW.insertCell(0);
											var cell2 = newROW.insertCell(1);
											var cell3 = newROW.insertCell(2);
											var cell4 = newROW.insertCell(3);
											cell4.style.borderRight = "1px SOLID BLACK";
											cell4.style.textAlign = "RIGHT";
											cell4.innerHTML = 'Total points:&nbsp&nbsp';
											var cell5 = newROW.insertCell(4);
											cell5.innerHTML = totalPOINTS+'&nbsppoints';
										}
									}
									else
									{
									    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
										var cell1 = newROW.insertCell(0);
										var cell2 = newROW.insertCell(1);
										var cell3 = newROW.insertCell(2);
										var cell4 = newROW.insertCell(3);
										cell4.style.borderRight = "1px SOLID BLACK";
										cell4.style.textAlign = "RIGHT";
								  		cell4.innerHTML = 'Total points:&nbsp&nbsp';
										var cell5 = newROW.insertCell(4);
										cell5.innerHTML = totalPOINTS+'&nbsppoints';
									}
								}
								else
								{
								    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
									var cell1 = newROW.insertCell(0);
									var cell2 = newROW.insertCell(1);
									var cell3 = newROW.insertCell(2);
									var cell4 = newROW.insertCell(3);
									cell4.style.borderRight = "1px SOLID BLACK";
									cell4.style.textAlign = "RIGHT";
									cell4.innerHTML = 'Total points:&nbsp&nbsp';
									var cell5 = newROW.insertCell(4);
									cell5.innerHTML = totalPOINTS+'&nbsppoints';
								}
							}
							else
							{
							    newROW = anaTABLE.insertRow(anaTABLE.rows.length);
								var cell1 = newROW.insertCell(0);
								var cell2 = newROW.insertCell(1);
								var cell3 = newROW.insertCell(2);
								var cell4 = newROW.insertCell(3);
								cell4.style.borderRight = "1px SOLID BLACK";
								cell4.style.textAlign = "RIGHT";
								cell4.innerHTML = 'Total points:&nbsp&nbsp';
								var cell5 = newROW.insertCell(4);
								cell5.innerHTML = totalPOINTS+'&nbsppoints';
							}
					    }
					    else{}
				    }
				}
            }
            else {console.log(cheANA.responseText);}
        }
    }
    cheANAparams = 'analiza=show';
	cheANA.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	cheANA.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	cheANA.send(cheANAparams);
}
function pointsKEYCHK()
{
    var pressed = event.key;
	console.log(pressed);
}
function mailingLIST()
{
    if(window.getComputedStyle(mailDIV).display == 'none')
    {
	    mailDIV.style.display = 'block';
	    mailingFUNCTION();
    }
    else
    {
	    mailDIV.style.display = 'none';
    }
}
function mailingFUNCTION()
{
    if(window.XMLHttpRequest){mailF = new XMLHttpRequest();}
	else{mailF = new ActiveXObject('Microsoft.XMLHTTP');}
	mailF.onreadystatechange = function()
	{
	    if(mailF.readyState==4 && mailF.status==200)
	    {
		    mailFLIST = mailF.responseText.split('^');
		    if(mailFLIST[0] == 'OK')
		    {
				var mailTABLE = document.getElementById("mail_TABLE");
			    for(x = 1; x < mailFLIST.length; x = x + 5)
			    {
				    var mailROW = mailTABLE.insertRow(mailTABLE.rows.length);
				    var mailCELL1 = mailROW.insertCell(0);
				    mailCELL1.style.border = "1px SOLID BLACK";
				    mailCELL1.style.fontSize = "1vw";
				    mailCELL1.innerHTML = mailFLIST[x];
				    var mailCELL2 = mailROW.insertCell(1);
				    mailCELL2.style.border = "1px SOLID BLACK";
				    mailCELL2.style.fontSize = "1vw";
				    mailCELL2.innerHTML = mailFLIST[x + 1];
				    var mailCELL3 = mailROW.insertCell(2);
				    mailCELL3.style.border = "1px SOLID BLACK";
				    mailCELL3.style.fontSize = "1vw";
				    mailCELL3.innerHTML = mailFLIST[x + 2];
				    var mailCELL4 = mailROW.insertCell(3);
				    mailCELL4.style.border = "1px SOLID BLACK";
				    mailCELL4.style.fontSize = "1vw";
				    mailCELL4.innerHTML = mailFLIST[x + 3];
				    var mailCELL5 = mailROW.insertCell(4);
				    mailCELL5.style.border = "1px SOLID BLACK";
				    mailCELL5.style.fontSize = "1vw";
				    var mailBUTTON = document.createElement("BUTTON");
				    mailBUTTON.style.fontWeight = "bold";
				    mailBUTTON.style.height = "2.5vh";
				    mailBUTTON.style.marginLeft = "1vw";
				    mailBUTTON.innerHTML = "Trimite";
				    mailBUTTON.addEventListener("click",mailSENDING);
				    if(mailFLIST[x + 4] == 1){mailBUTTON.disabled = true;}
				    mailCELL5.appendChild(mailBUTTON);
			    }
		    }
		    else{console.log(mailF.responseText);}
	    }
	}
	mailFparams = 'command=showmails';
	mailF.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	mailF.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	mailF.send(mailFparams);
}

function mailSENDING()
{
	var clickedBUTTON = event.target;
	var rowINDEX = clickedBUTTON.parentNode.parentNode.rowIndex;
	var user2SEND = document.getElementById("mail_TABLE").rows[rowINDEX].cells[0].innerHTML
    if(window.XMLHttpRequest){mailSND = new XMLHttpRequest();}
	else{mailSND = new ActiveXObject('Microsoft.XMLHTTP');}
	mailSND.onreadystatechange = function()
	{
	    if(mailSND.readyState==4 && mailSND.status==200)
	    {
		    mailSNDLIST = mailSND.responseText.split('^');
		    if(mailSNDLIST[0] == 'OK')
		    {
				clickedBUTTON.disabled = true;
			    window.open('mailto:'+ document.getElementById("mail_TABLE").rows[rowINDEX].cells[1].innerHTML + '?subject=' + document.getElementById("mail_TABLE").rows[rowINDEX].cells[2].innerHTML + '&body=' + document.getElementById("mail_TABLE").rows[rowINDEX].cells[3].innerHTML);
		    }
		    else{console.log(mailSND.responseText);}
	    }
	}
	mailSNDparams = 'command=sendingMAIL&myuser='+user2SEND;
	mailSND.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	mailSND.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	mailSND.send(mailSNDparams);
}
function chestionarul()
{
    if(window.getComputedStyle(chestionarDIV).display == 'none')
    {
	    chestionarDIV.style.display = 'block';
	    Q1_FUNCTION();
    }
    else
    {
	    chestionarDIV.style.display = 'none';
	    if(cheTABLE.rows.length > 0)
	    {
		    for(i = cheTABLE.rows.length -1; i >=0; i--)
		    {
			    cheTABLE.deleteRow(i);
		    }
	    }
    }
}

function ziarulZILEI()
{
    if(window.getComputedStyle(ziar).display != 'block')
    {
	    ziar.style.display = 'block';
    }
    else
    {
	    ziar.style.display = 'none';
    }
}

function bifaSUGESTIE(clicked)
{
    var bifROW = event.target.parentNode.parentNode.rowIndex;
    var bifDATE = document.getElementById('sugestionDATE'+bifROW).innerHTML;
    var bifMESS = document.getElementById('sugestionTEXT' + bifROW).innerHTML;
    var bifUSER = document.getElementById('sugestionNAME' + bifROW).innerHTML;
    var solvedBUTTON = event.target;
	//console.log('Date: '+bifDATE+'; Message: '+bifMESS+'; User: '+bifUSER+'; button color: '+event.target.style.backgroundColor);
	if(solvedBUTTON.style.backgroundColor != 'green' && acesLEV.innerHTML == 'Developer')
	{
	    if(window.XMLHttpRequest)
		{
		    bifCLICK = new XMLHttpRequest();
		}
		else
		{
		    bifCLICK = new ActiveXObject('Microsoft.XMLHTTP');
		}
		bifCLICK.onreadystatechange = function()
		{
		    if(bifCLICK.readyState==4 && bifCLICK.status==200)
		    {
				//console.log('Clicked response: '+bifCLICK.responseText);
			    bifLIST = bifCLICK.responseText.split('^');
			    if(bifLIST[0] == 'OK')
			    {
				    solvedBUTTON.style.backgroundColor = 'green';
				    document.getElementById("insertDEVELOPING").click();
			    }
			    else
			    {
				    console.log(bifCLICK.responseText);
			    }
		    }
		}
		bifCLICKparams = 'sugestion='+bifMESS+'&name='+bifUSER+'&date='+bifDATE;
		bifCLICK.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
		bifCLICK.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		bifCLICK.send(bifCLICKparams);
	}
	else
	{
	    alert('Problema a fost solutionata! Va rog, verificati tabelul de Operatiuni de Dezvoltare!');
	}
}

function displaySUGESTII()
{
    if(window.XMLHttpRequest)
	{
	    tableSUGGEST = new XMLHttpRequest();
	}
	else
	{
	    tableSUGGEST = new ActiveXObject('Microsoft.XMLHTTP');
	}
	tableSUGGEST.onreadystatechange = function()
	{
	    if(tableSUGGEST.readyState==4 && tableSUGGEST.status==200)
	    {
			//console.log(tableSUGGEST.responseText);
		    TSlist = tableSUGGEST.responseText.split('^');
		    if(TSlist[0] == 'OK')
		    {
				for(i = 1; i <= (TSlist.length - 5); i = i + 4)
				{
					//console.log('My data: '+TSlist[i+1]);
				    var rows = tabelSUGESTII.rows.long;
				    var myROW = tabelSUGESTII.insertRow(rows);
				    var Scell1 = myROW.insertCell(0);
				    Scell1.style.border = '1px SOLID RGB(0,0,0)';
				    Scell1.style.fontSize = '0.7vw';
				    Scell1.style.textAlign = 'LEFT';
				    Scell1.innerHTML = '<DIV ID = "sugestionDATE'+ (myROW.rowIndex) +'" STYLE = "WIDTH: 100%">' + TSlist[i + 3] + '</DIV><DIV ID = "sugestionTEXT'+ myROW.rowIndex +'" STYLE = "WIDTH: 100%">' + TSlist[i + 1] + '</DIV><DIV ID = "sugestionNAME'+ myROW.rowIndex +'">' + TSlist[i] + '</DIV>';
				    Scell2 = myROW.insertCell(1);
				    Scell2.style.border = '1px SOLID RGB(0,0,0)';
				    Scell2.style.fontSize = '0.7vw';
				    Scell2.style.textAlign = 'LEFT';
				    if(TSlist[i + 2] == 2 || TSlist[i + 2] == 3)
				    {
				        var statVIEW = 'STYLE = "BACKGROUND-COLOR: GREEN;"'
				    }
					else if(TSlist[i + 2] == 1 && acesLEV.innerHTML == 'Developer')
					{

					    if(window.XMLHttpRequest)
						{
						    statUP = new XMLHttpRequest();
						}
						else
						{
						    statUP = new ActiveXObject('Microsoft.XMLHTTP');
						}
						statUP.onreadystatechange = function()
						{
						    if(statUP.readyState==4 && statUP.status==200)
						    {
							    statUPlist = statUP.responseText.split('^');
							    if(statUPlist[0] == 'OK')
								{
								    var statVIEW = 'STYLE = "BACKGROUND-COLOR: GREEN;"'
								}
								else if(statUPlist[0] == '')
								{
								    console.log('Empty response from ajax.process.php for: '+TSlist[i + 1]);
								}
								else
								{
									var statVIEW = '';
								    console.log(statUP.responseText);
								}
						    }
						}
						statUPparams = 'statUP='+TSlist[i + 1]+'&userNAME='+TSlist[i];
						statUP.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
						statUP.setRequestHeader('Content-type','application/x-www-form-urlencoded');
						statUP.send(statUPparams);
					}
				    Scell2.innerHTML = '<DIV CLASS = "statusBUTTON" ID = "statusINSERTED'+ myROW.rowIndex +'" STYLE = "BACKGROUND-COLOR: GREEN"></DIV><DIV CLASS = "statusBUTTON" ID = "statusVIEWED'+ myROW.rowIndex +'" ' + statVIEW + '></DIV><DIV CLASS = "statusBUTTON" ID = "statusSOLVED'+ myROW.rowIndex +'" ONCLICK = "bifaSUGESTIE(this.id);"></DIV>';
				    if(TSlist[i + 2] == 1)
				    {
						document.getElementById('statusINSERTED'+ myROW.rowIndex).style.backgroundColor = 'green';
				    }
				    else if(TSlist[i + 2] == 2)
				    {
					    document.getElementById('statusVIEWED'+ myROW.rowIndex).style.backgroundColor = 'green';
				    }
				    else if(TSlist[i + 2] == 3)
				    {
						document.getElementById('statusSOLVED'+ myROW.rowIndex).style.backgroundColor = 'green';
				    }
				}
		    }
	    }
	}
	tableSUGGESTparams = 'tableACTION=show';
	tableSUGGEST.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	tableSUGGEST.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	tableSUGGEST.send(tableSUGGESTparams);
}
function golireTABELsugestii()
{
    if(tabelSUGESTII.rows.length > 1)
    {
	    for(i = (tabelSUGESTII.rows.length - 1); i > 0; i--)
	    {
		    tabelSUGESTII.deleteRow(i);
	    }
    }
}

function adaugaSUGESTIE()
{
    if(window.XMLHttpRequest)
	{
	    textIN = new XMLHttpRequest();
	}
	else
	{
	    textIN = new ActiveXObject('Microsoft.XMLHTTP');
	}
	textIN.onreadystatechange = function()
	{
	    if(textIN.readyState==4 && textIN.status==200)
	    {
		    textINlist = textIN.responseText.split('^');
		    if(textINlist[0] == 'Inserted')
			{
			    sugestie.value = '';
			    golireTABELsugestii();
			    displaySUGESTII();
			}
			else if(textINlist[0] == 'Registered')
			{
				alert('Aceasta sugestie / eroare a mai fost inregistrata.\nEa va fi solutionata in curand\nVa multumim pentru intelegere!');
				sugestie.value = '';
			    console.log(textIN.responseText);
			}
			else 
			{
			    console.log(textIN.responseText);
			}
	    }
	}
	textINparams = 'sugestie='+sugestie.value+'&username='+numeUSER.innerHTML;
	textIN.open('POST','/ramira/magazie/users accounts/ajax.process.php', true);
	textIN.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	textIN.send(textINparams);
}

function formularSUGESTII()
{
    if(window.getComputedStyle(formularSUGEST).display == 'none')
    {
		golireTABELsugestii();
		displaySUGESTII();
	    formularSUGEST.style.display = 'block';
    }
    else
    {
		golireTABELsugestii();
		sugestie.value = '';
	    formularSUGEST.style.display = 'none';
    }
}

function checkOldINPUT()
{
	oldINPUT = document.getElementById('oldpass').value;
    if(window.XMLHttpRequest)
	{
	    OldHTTP = new XMLHttpRequest();
	}
	else
	{
	    OldHTTP = new ActiveXObject('Microsoft.XMLHTTP');
	}
	OldHTTP.onreadystatechange = function()
	{
	    if(OldHTTP.readyState==4 && OldHTTP.status==200)
	    {
		    document.getElementById('opWARNING').innerHTML = OldHTTP.responseText;
		    if(OldHTTP.responseText != 'OK')
		    {
			    document.getElementById('oldpass').focus();
       			document.getElementById('oldpass').select();
		    }
		    else
		    {
			    document.getElementById('newpass').focus();
				document.getElementById('newpass').select();
		    }
	    }
	}
	OldHTTP.open('GET','oldinputchk.php?oldINPUT='+oldINPUT+'&user='+userNAME, true);
	OldHTTP.send();
}
function checkNewINPUT()
{
	var newpass = document.getElementById('newpass');
    var input = document.getElementById('newpass').value;
    if(input != null && input.length > 0)
	{
		if(input.length < 8){newpass.style.background = "red";}
		else {newpass.style.background = "white";}
	}
	else {newpass.style.background = "white";}
}
function checkNewINPUTrepeat()
{
	var newpassrepeat = document.getElementById('newpassrepeat');
    var inputrepeat = document.getElementById('newpassrepeat').value;
    if(inputrepeat != null && inputrepeat.length > 0)
	{
		if(inputrepeat.length < 8 || inputrepeat != document.getElementById('newpass').value){newpassrepeat.style.background = "red";}
		else {newpassrepeat.style.background = "white";}
	}
	else {newpassrepeat.style.background = "white";}
}
function validareParola()
{
    document.getElementById("validator").addEventListener("click", function(event){event.preventDefault()});
    if(document.getElementById('newpass').value != document.getElementById('oldpass').value && document.getElementById('newpass').value == document.getElementById('newpassrepeat').value && document.getElementById('newpass').value != '')
    {
	    document.getElementById('passCHANGER').submit();
    }
}
function comparePasswords()
{
    if(document.getElementById('newpass').value == document.getElementById('oldpass').value)
	{
		alert('Va rog, alegeti o parola diferita de cea veche!');
		document.getElementById('newpass').focus();
		document.getElementById('newpass').select();
	}
	else
	{
	    document.getElementById('newpassrepeat').focus();
		document.getElementById('newpassrepeat').select();
	}
}
function compareRepeat()
{
    if(document.getElementById('newpass').value == document.getElementById('newpassrepeat').value)
    {
	    document.getElementById('validator').focus();
    }
}
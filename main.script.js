var span = document.getElementById("close");
var setoff = document.getElementById("setoff");
var setsend = document.getElementById("setsend");
var conf = document.getElementById("confirm");
var errdia = document.getElementById("errdia");
var agreed_bon = document.getElementById("agreed_bon");
var setoff_bon = document.getElementById("setoff_bon");
var modal = document.getElementById("myModal");
var navigBAR = null;

if(errdia != null)
{
	function closeDialog()
	{
	    errdia.close();
	}
}
if(conf != null)
{
	conf.onclick = function()
	{
        conf.close();
	}
}
if(agreed_bon != null)
{
	agreed_bon.onclick = function()
	{
		var workerok = document.getElementById("agreed_bon").value;
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
			    alert("Stergerea bonului neprocesat inregistrat pentru "+workerok+" a fost efectuata cu succes. Multumesc!");
			    document.getElementById('bon_magazie_rs').innerHTML = xmlhttp.responseText;
		    }
		}
		xmlhttp.open('GET','clear.bon.php?agreed_bon='+workerok, true);
		xmlhttp.send();
	}
}
function modalShow()
{
	if(modal != null){
		modal.style.display = "block";
	}
}
if(span != null)
{
	span.onclick = function()
	{
	    modal.style.display = "none";
	}
}
if(setoff_bon != null)
{
    setoff_bon.onclick = function()
	{
	    modal.style.display = "none";
	    if(window.parent.document.getElementById('rekrow').value != '')
		{
			window.parent.document.getElementById('product').focus();
	    	window.parent.document.getElementById('product').select();
	    }
	    else
	    {
		    window.parent.document.getElementById('rekrow').focus();
	    	window.parent.document.getElementById('rekrow').select();
	    }
	}
}
if(setoff != null)
{
	setoff.onclick = function()
	{
	    modal.style.display = "none";
	}
}
if(setsend != null)
{
	setsend.onclick = function()
	{
	    alert('Sending message to developer has not been implemented, yet! \nPlease, make a copy of the message and present it to the developer, instead, at warehouse-soft@ramira.ro');
		modal.style.display = "none";
	}
}
function pageReload()
{
    return 'Reincarcarea paginii va duce la pierderea datelor. \nSunteti sigur/a ca doriti sa continuati?';
}
function display_c()
{
	mytime = setTimeout(function(){verify_RAP();display_ct();},1000)
}
function verify_RAP()
{
	var comButt = document.getElementById('comenziStatus');
	if(comButt != null)
	{
	    if(window.XMLHttpRequest)
		{
		    verifyRAP = new XMLHttpRequest();
		}
		else
		{
		    verifyRAP = new ActiveXObject('Microsoft.XMLHTTP');
		}
		verifyRAP.onreadystatechange = function()
		{
		    if(verifyRAP.readyState==4 && verifyRAP.status==200)
		    {
				//console.log(verifyRAP.responseText);
				if(verifyRAP.responseText == 'Stoc alert')
				{
					var cssObj = window.getComputedStyle(comButt,null);
					var baCK = cssObj.getPropertyValue("background-color");
					if(baCK != 'rgb(237, 28, 36)')
					{
				        if(document.getElementById('alertaCOMENZI').style.display == 'none'){document.getElementById('alertaCOMENZI').style.display = 'block';}
				    	else {document.getElementById('alertaCOMENZI').style.display = 'none';}
				    }
				    else 
					{
						document.getElementById('alertaCOMENZI').style.display = 'none';
					}
				}
		    }
		}
		verifyRAP.open('GET','/ramira/magazie/extras/status.check.php', true);
		verifyRAP.send();
	}
}
function display_ct() 
{
	if(document.getElementById('eliberareprod') != null)
	{
		var button = document.getElementById('eliberareprod');
		const hrefLINK = button.getAttribute("onclick").split('=');
		var userNAME = hrefLINK[hrefLINK.length - 1].slice(0,-1);
		var homepage = window.location.href;
		if(window.XMLHttpRequest)
		{
		    USERsession = new XMLHttpRequest();
		}
		else
		{
		    USERsession = new ActiveXObject('Microsoft.XMLHTTP');
		}
		USERsession.onreadystatechange = function()
		{
		    if(USERsession.readyState==4 && USERsession.status==200)
		    {
			    if(USERsession.responseText == 'disconnect'){window.location = '/ramira/magazie/index.php/';}
		    }
		}
		USERsession.open('GET','/ramira/magazie/users%20accounts/user.login.session.php?calling=checksession&username='+ userNAME, true);
		USERsession.send();
	}
    const month = ["Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","August","Septembrie","Octombrie","Noiembrie","Decembrie"];
    var x = new Date();
    var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
	hours = x.getHours( ) % 12;
	hours = hours ? hours : 12;
	hours=hours.toString().length==1? 0+hours.toString() : hours;
	var minutes=x.getMinutes().toString()
	minutes=minutes.length==1 ? 0+minutes : minutes;
	
	var seconds=x.getSeconds().toString()
	seconds=seconds.length==1 ? 0+seconds : seconds;
	let monthName = month[x.getMonth()];
	
	var dt=x.getDate().toString();
	day=dt.length==1 ? 0+dt : dt;
	
	var x1=day+" "+monthName+" "+ x.getFullYear();
	x1 = "<BR>"+hours + ":" +  minutes + ":" +  seconds + " " + ampm +"<BR>"+x1;
	if(document.getElementById('todayNow') != null)
	{
		document.getElementById('todayNow').innerHTML = x1;
	}	
	display_c();
}


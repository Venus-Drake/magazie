<HTML>
<HEAD>
    <link rel="stylesheet" href="\ramira\magazie\styles.css">
    <SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
    <STYLE>
	    BODY
	    {
	        WIDTH: 100%;
	        MIN-HEIGHT: 100%;
	        MARGIN: 0 AUTO;
	        BACKGROUND-COLOR:BLACK;
	        FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
	        TEXT-TRANSFORM: UPPERCASE;
	        OVERFLOW: AUTO;
	        ANIMATION: PAGE-LOAD 1.5s FORWARDS;
	    }
	    .MAIN
	    {
		    WIDTH:100%;
      		HEIGHT:100vw;
        	MARGIN:0 AUTO;
         	DISPLAY:INLINE-BLOCK;
          	COLOR: RGBA(0,73,123,.2);
          	FONT-SIZE: 3VW;
	    }
	    .WELCOME_SCREEN
	    {
          	WIDTH: 70%;
		  	HEIGHT: 70%;
		  	BACKGROUND-COLOR: RGBA(0,0,0,.3);
		  	COLOR: RGB(102,252,3);
		  	FONT-SIZE: 2VW;
			OPACITY: 0;
		  	MARGIN: 0 AUTO; 
  			BORDER-RADIUS: 20PX; 
		  	MARGIN-TOP: 15VH;
		  	BORDER: 1PX SOLID RGB(102,252,3);
		  	ANIMATION: LOAD_SCREEN 1.5S 2.5S LINEAR FORWARDS,
		  	           BORDER-BLINK 0.75s INFINITE LINEAR;
	    }
	    .LOGO
	    {
		    WIDTH: 15vw; 
			HEIGHT:4vw; 
			MARGIN-RIGHT: 1.8vw; 
			MARGIN-BOTTOM: 1.6vw; 
			PADDING:5px; 
			FLOAT: LEFT;
			OPACITY: 0;
			ANIMATION: LOGO_FLASH 2s LINEAR FORWARDS;
	    }
	    @KEYFRAMES LOGO_FLASH
	    {
		    FROM{OPACITY: 0; WIDTH: 0; HEIGHT: 0}
		    TO{OPACITY: 1; WIDTH: 15VW; HEIGHT: 4VW;}
	    }
	    @KEYFRAMES LOAD_SCREEN
	    {
		    FROM{OPACITY: 0;}
		    TO{OPACITY: 1;}
	    }
	    @KEYFRAMES PAGE-LOAD
		{
		    FROM {BACKGROUND-COLOR: BLACK; OPACITY: 0}
		   	TO {BACKGROUND-COLOR: RGB(0,73,123); OPACITY: 1}
		}
		@KEYFRAMES BORDER-BLINK
		{
		    FROM { BORDER-COLOR: TRANSPARENT; }
      		TO { BORDER-COLOR: RGBA(102.252.3); }
		}
    </STYLE>
</HEAD>

<BODY>
    <?php
	    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
		$user = '';
		$pass = '';
		if(isset($_GET['user']) && $_GET['user'] != '')
		{
  		    $user = $_GET['user'];
  			if(isset($_GET['pass']) && $_GET['pass'] != '') 
  			{
				$pass = $_GET['pass'];
                require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	 			$que = "SELECT * FROM `utilizatori` WHERE `username` = '$user' AND `password` = '$pass'";
	 			if($run = mysql_query($que))
	 			{
				    if(mysql_num_rows($run) != 0)
					{
						$row = mysql_fetch_assoc($run);
						$nume = $row['nume'].' '.$row['prenume'];
						$IP = $row['IP.connect'];
						$iplog = $_SERVER['REMOTE_ADDR'];
						$loginTIME = date('Y-m-d h:i:s',time());
		    			$upque = "UPDATE `utilizatori` SET `IP.connect` = '$iplog', `lastLOGIN` = '$loginTIME' WHERE `username` = '$user'";
					    if($runup = mysql_query($upque))
						{
						    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
						    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/comenzi/quick.stocks.php';
						    echo '<IFRAME src="/ramira/magazie/images/main.menu.image.php" STYLE = "WIDTH: 100%; HEIGHT: 70%; MARGIN: 0 AUTO; MARGIN-TOP: 10VH; FLOAT: NONE; BORDER-RADIUS: 20px; BORDER: 2px SOLID #999; OVERFLOW: CLIP; BACKGROUND-COLOR: RGBA(0,73,123)"></IFRAME>';
                        }
         				else
	                    {
						    $mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
                        }
					}
					else
					{
					    echo '
						<IMG CLASS = "LOGO" SRC = "logo.PNG" STYLE = "">
					    <DIV CLASS = "WELCOME_SCREEN">
					        <BR><center>Bine ati venit in magazia RAMIRA S.A.!<br><BR>Va rog sa va autentificati, pentru a putea continua!<br><BR><br><br>
					        <FORM ID = "loginForm" METHOD = "GET" ONSUBMIT = "event.preventDefault()">
						        <TABLE STYLE = "WIDTH: 50%;">
						            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Utilizator:&nbsp&nbsp&nbsp&nbsp</TD>
									<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
									    <INPUT TYPE = "text" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" ONKEYUP = "starttyping();"  ONCHANGE = "checkuser();" PLACEHOLDER = "Nume utilizator" ID = "userBox" NAME = "user" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" VALUE = "'.$user.'" AUTOFILL = "OFF" REQUIRED></INPUT>
									</TD><TR>
						            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Parola:&nbsp&nbsp&nbsp&nbsp</TD>
									<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
									    <INPUT TYPE = "PASSWORD" ID = "pass_box" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" PLACEHOLDER = "Parola" NAME = "pass" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" VALUE = "'.$pass.'" AUTOFILL = "OFF" REQUIRED></INPUT>
									</TD>
						        </TABLE>
						        <BR><INPUT TYPE = "SUBMIT" CLASS: "loginBUTTON" ID = "my_button" STYLE = "BACKGROUND-COLOR:RGB(255,255,255);COLOR:RGB(0,73,123); FONT-SIZE:1.2vw; FONT-WEIGHT:BOLD; BORDER-RADIUS: 20px; CURSOR: POINTER; HEIGHT: 2VW; WIDTH: 15VW; BORDER-TOP: 3PX SOLID RGBA(237,28,36,.8); BORDER-LEFT: 3PX SOLID RGBA(237,28,36,.8);" VALUE = "DESCHIDE APLICATIA"></INPUT>
					        </FORM>
					    </DIV>';
					}
				}
				else
		        {
				    $mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
                }
	        }
		}
		else echo '
             <IMG CLASS = "LOGO" SRC = "logo.PNG" STYLE = "">
		    <DIV CLASS = "WELCOME_SCREEN">
		        <BR><center>Bine ati venit in magazia RAMIRA S.A.!<br><BR>Va rog sa va autentificati, pentru a putea continua!<br><BR><br><br>
		        <FORM ID = "loginForm" METHOD = "GET" ONSUBMIT = "event.preventDefault()" AUTOCOMPLETE = "off" AUTOSUGGEST = "off">
			        <TABLE STYLE = "WIDTH: 50%;">
			            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Utilizator:&nbsp&nbsp&nbsp&nbsp</TD>
						<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
						    <INPUT TYPE = "text" ROLE = "PRESENTATION" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" ONKEYUP = "starttyping();" ONFOCUS = "select();" ONCHANGE = "checkuser();" PLACEHOLDER = "Nume utilizator" ID = "userBox" NAME = "user" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" VALUE = "'.$user.'" AUTOFILL = "OFF" AUTOCOMPLETE = "new-user" REQUIRED></INPUT>
						</TD><TR>
			            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Parola:&nbsp&nbsp&nbsp&nbsp</TD>
						<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
						    <INPUT TYPE = "PASSWORD" ROLE = "PRESENTATION" ID = "pass_box" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" ONCHANGE = "checkuser();" ONKEYUP = "resetColorPASS();" PLACEHOLDER = "Parola" NAME = "pass" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" VALUE = "'.$pass.'" AUTOFILL = "OFF" AUTOCOMPLETE = "new-password" REQUIRED></INPUT>
						</TD>
			        </TABLE>
			        <BR><INPUT TYPE = "SUBMIT" CLASS: "loginBUTTON" ID = "my_button" STYLE = "BACKGROUND-COLOR:RGB(255,255,255);COLOR:RGB(0,73,123); FONT-SIZE:1.2vw; FONT-WEIGHT:BOLD; BORDER-RADIUS: 20px; CURSOR: POINTER; HEIGHT: 2VW; WIDTH: 15VW; BORDER-TOP: 3PX SOLID RGBA(237,28,36,.8); BORDER-LEFT: 3PX SOLID RGBA(237,28,36,.8);" VALUE = "DESCHIDE APLICATIA"></INPUT>
		        </FORM>
		    </DIV>';
    ?>



	<script type='text/javascript'>
	    window.onload=function()
		{
			if(document.getElementById('userBox') != null)
			{
				document.getElementById('userBox').focus();
				document.getElementById('userBox').select();
				var userBox = document.getElementById('userBox');
				var pass_box = document.getElementById('userBox');
				userBox.value = '';
				userBox.innerHTML = '';
				pass_box.value = '';
				pass_box.innerHTML = '';
			}
			display_ct();
		}
		function resetColorPASS()
		{
		    if(document.getElementById('pass_box').style.background != "white" && document.getElementById('pass_box').value.length > 1){document.getElementById('pass_box').style.background = "white";}
		}
	    function starttyping()
	    {
		    if(userBox.value.length <= 2)
		    {
				started = Date.now();
		    }
		    else
		    {
			    if(document.getElementById('userBox').style.background != "white" && document.getElementById('userBox').value.length > 1){document.getElementById('userBox').style.background = "white";}
		    }
	    }
	    function checkuser()
	    {
			document.getElementById("userBox").addEventListener("change", function(event){event.preventDefault()});
		    if(userBox.value.length >= 6)
			{
				rightnow = Date.now();
				elapsed = rightnow - started;
				if(window.XMLHttpRequest)
				{
				    userchk = new XMLHttpRequest();
				}
				else
				{
				    userchk = new ActiveXObject('Microsoft.XMLHTTP');
				}
				userchk.onreadystatechange = function()
				{
				    if(userchk.readyState==4 && userchk.status==200)
				    {
						var loginData = userchk.responseText.split('^');
						if(loginData.length > 1)
						{
						    userBox.value = loginData[1];
						    document.getElementById('pass_box').value = loginData['2'];
                            document.getElementById('loginForm').submit();
						}
						else
						{
						    if(userchk.responseText == 'Wrong password')
						    {
								document.getElementById('pass_box').style.backgroundColor = "red";
								document.getElementById('pass_box').value = '';
							    document.getElementById('pass_box').focus();
								document.getElementById('pass_box').select();
						    }
						    else if(userchk.responseText == 'No user found!')
						    {
								document.getElementById('userBox').style.backgroundColor = "red";
								document.getElementById('userBox').value = '';
							    document.getElementById('userBox').focus();
								document.getElementById('userBox').select();
						    }
						    else alert(userchk.responseText);
						}
				    }
				}
				if(elapsed <= 300)
				{
					userchk.open('GET','/ramira/magazie/userchk.php?barcode='+userBox.value, true);
					userchk.send();
				}
				else if(document.getElementById("pass_box").value != '')
				{
				    userchk.open('GET','/ramira/magazie/userchk.php?username='+userBox.value+'&password='+document.getElementById("pass_box").value, true);
				    userchk.send();
				}
			}
	    }
	</script>
    <BODY>
</HTML>
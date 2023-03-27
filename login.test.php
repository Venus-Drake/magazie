<HTML>

<!
* NE CONECTAM LA SISTEM SI VERIFICAM USER, PAROLA SI IP, PENTRU A ASIGURA CONTINUITATEA CONEXIUNII PENTRU FIECARE USER.
* DACA AVEM USER CONECTAT DEJA, MERGEM MAI DEPARTE
>
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
	    require 'C:\xampp\htdocs\ramira\magazie\header.php';
		$user = '';
		$pass = '';
		if(isset($_GET['user']) && $_GET['user'] != '')
		{
  		    $user = $_GET['user'];
  			if(isset($_GET['pass']) && $_GET['pass'] != '') 
  			{
				$pass = $_GET['pass'];
	        }
		}
    ?>
    <IMG CLASS = "LOGO" SRC = "logo.PNG" STYLE = "">
    <DIV CLASS = "WELCOME_SCREEN">
        <BR><center>Bine ati venit in magazia RAMIRA S.A.!<br><BR>Va rog sa va autentificati, pentru a putea continua!<br><BR><br><br>
        <FORM ID = "loginForm" METHOD = "GET" ONSUBMIT = "event.preventDefault();">
	        <TABLE STYLE = "WIDTH: 50%;">
	            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Utilizator:&nbsp&nbsp&nbsp&nbsp</TD>
				<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
				    <INPUT TYPE = "text" PLACEHOLDER = "Nume utilizator" ID = "userBox" NAME = "user" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" autoComplete = "new-user" autofill = "off" ONKEYUP = "starttyping();" ONCHANGE = "checkuser();" VALUE = "<?php echo $user;?>"></INPUT>
				</TD><TR>
	            <TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: RIGHT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">Parola:&nbsp&nbsp&nbsp&nbsp</TD>
				<TD STYLE = "WIDTH: 50%; COLOR: RGB(1.2,252,3); HEIGHT: 3VW; TEXT-ALIGN: LEFT; FONT-SIZE: 2VW; LINE-HEIGHT: 3VW">
				    <INPUT TYPE = "TEXT" ID = "pass_box" PLACEHOLDER = "Parola" NAME = "pass" STYLE = "font-size:2VW;HEIGHT: 2.1VW; WIDTH: 20VW" autoComplete = "new-password" autofill = "off" VALUE = "<?php echo $pass;?>"></INPUT>
				</TD>
	        </TABLE>
	        <BR><INPUT TYPE = "SUBMIT" CLASS: "loginBUTTON" ID = "my_button" STYLE = "BACKGROUND-COLOR:RGB(255,255,255);COLOR:RGB(0,73,123); FONT-SIZE:1.2vw; FONT-WEIGHT:BOLD; BORDER-RADIUS: 20px; CURSOR: POINTER; HEIGHT: 2VW; WIDTH: 15VW; BORDER-TOP: 3PX SOLID RGBA(237,28,36,.8); BORDER-LEFT: 3PX SOLID RGBA(237,28,36,.8);" VALUE = "DESCHIDE APLICATIA"></INPUT>
        </FORM>
    </DIV>

    <?php
	    /*require 'C:\xampp\htdocs\ramira\magazie\header.php';
		$user = '';
		$pass = '';
		if(isset($_GET['user']) && $_GET['user'] != '')
		{
  		    $user = $_GET['user'];
  			if(isset($_GET['pass']) && $_GET['pass'] != '') $pass = $_GET['pass'];
  			else $pass = "none";
		}
		else
		{
  		    $user = ' ';
			$pass = 'none';
		}
		if($user == '' || $user == ' ')
		{
		    echo '<DIV WIDTH = 100% ALIGN = CENTER STYLE = "FLOAT: NONE;">
			<DIV WIDTH = 100% STYLE = "MARGIN: 3 AUTO;">

			</DIV>
			<BR><BR>
		    <DIV WIDTH = 100% ALIGN = CENTER STYLE = "MARGIN: 0 AUTO; FLOAT: NONE;">

		    </DIV>
		    <BR>
			<DIV WIDTH = 100% STYLE = "MARGIN: 0 AUTO; FLOAT: NONE;">
			    <form action = "" method = "GET" autosugest = "off" aucomplete = "off">
				    <LABEL><font size = 6 color = blue><center><b>Utilizator : </LABEL>
				        <input type="text" name="user" HIDDEN = "hidden">
						<input role = "presentation" type = "text" placeholder = "Nume utilizator" id = "user_box" name = "user" style = "font-size:20;" autoComplete = "new-user" autofill = "off" />
				  	<LABEL><font size = 6 color = blue><center><b>Parola : </LABEL>
				  	    <input type="password" name="hidden" HIDDEN = "hidden">
					    <input role = "presentation" type = "password" id = "pass_box" placeholder = "Parola" name = "pass" style = "font-size:20" autoComplete = "new-password" autofill = "off" /><BR><BR>
		 				<br><input type = "submit" id = "my_button" value = "Deschide Aplicatia" style = "background-color:pink;color:blue;font-size:30;font-weight:bold">
			    </form>
			</DIV></DIV>';
		}
		else
		{
		    if($pass != '')
		    {
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	 			$que = "SELECT * FROM `utilizatori` WHERE `username` = '$user' AND `password` = '$pass'";
	 			if($run = mysql_query($que))
			 	{
					if(mysql_num_rows($run) != 0)
					{
						$row = mysql_fetch_assoc($run);
						$nume = $row['nume'].' '.$row['prenume'];
						$IP = $row['IP.connect'];
						$iplog = $_SERVER['REMOTE_ADDR'];
						if($IP != $iplog && $iplog != '')
						{
						    $upque = "UPDATE `utilizatori` SET `IP.connect` = '$iplog' WHERE `username` = '$user'";
						    if($runup = mysql_query($upque)){}
		                    else
		                    {
							    $mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
								require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
                            }
						}
						require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';
						echo '<DIV WIDTH = 100% STYLE = "FLOAT: NONE; OVERFLOW: HIDDEN;">
						          <IFRAME src="/ramira/magazie/images/main.menu.image.php" STYLE = "WIDTH: 100%; HEIGHT: 42vw; MARGIN: 0 AUTO; FLOAT: NONE; BORDER-RADIUS: 20px; BORDER: 2px SOLID #999; OVERFLOW: CLIP; BACKGROUND-COLOR: #D4CFB6"></IFRAME>
		                      </DIV>';
		
		            }
		            else
		            {
					    $warning = '<font size = 5><center><b>Wrong password or username!<BR>Please, try again!<BR>Forgot account data?<BR>Contact program administrator, at:<BR><a href = "mailto: warehouse-soft@ramira.ro?subject=Warehouse account issues&body=I need some help with my credentials! (please, enter your name below!)">warehouse-soft@ramira.ro</a>';
						require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
						die('<DIV WIDTH = 100% STYLE = "BACKGROUND-COLOR: LIGHTGREEN; MARGIN: 0 AUTO;">
					        <IMG SRC = "logo.jpg" STYLE="width:200px;height:50px;BORDER: 2px solid #555;PADDING:5px; FLOAT: LEFT;">
						</DIV>
						<BR>
					    <DIV WIDTH = 100% ALIGN = CENTER STYLE = "BACKGROUND-COLOR: YELLOW;">
					        <BR><font size = 10 style = "color:blue"><center><b><br><br>Bine ati venit in magazia RAMIRA S.A.!<br><font style = "color:magenta">Va rog sa va autentificati, pentru a putea continua!</font><br><br><br><br>
					    </DIV>
						<DIV WIDTH = 100%>
						    <form action = "" method = "GET" autosugest = "off" aucomplete = "off">
							    <LABEL><font size = 6 color = blue><center><b>Utilizator : </LABEL>
							        <input type="text" name="user" id="hidden" style="width: 0; height: 0; border: 0; padding: 0" />
									<input role = "presentation" type = "text" placeholder = "Nume utilizator" id = "user_box" name = "user" style = "font-size:20;" autoComplete = "new-user" autofill = "off" />
							  	<LABEL><font size = 6 color = blue><center><b>Parola : </LABEL>
							  	    <input type="password" name="hidden" id="hidden" style="width: 0; height: 0; border: 0; padding: 0" />
								    <input role = "presentation" type = "password" id = "pass_box" placeholder = "Parola" name = "pass" style = "font-size:20" autoComplete = "new-password" autofill = "off" /><BR><BR>
					 				<br><input type = "submit" id = "my_button" value = "Deschide Aplicatia" style = "background-color:pink;color:blue;font-size:30;font-weight:bold">
						    </form>
						</DIV>');
                    }

		        }
		        else
		        {
				    $mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
                }
		    }
		    else die('<DIV WIDTH = 100% STYLE = "BACKGROUND-COLOR: LIGHTGREEN; MARGIN: 0 AUTO;">
		        <IMG SRC = "logo.jpg" STYLE="width:200px;height:50px;BORDER: 2px solid #555;PADDING:5px; FLOAT: LEFT;">
			</DIV>
			<BR>
		    <DIV WIDTH = 100% ALIGN = CENTER STYLE = "BACKGROUND-COLOR: YELLOW;">
		        <BR><font size = 10 style = "color:blue"><center><b><br><br>Bine ati venit in magazia RAMIRA S.A.!<br><font style = "color:magenta">Va rog sa va autentificati, pentru a putea continua!</font><br><br><br><br>
		    </DIV>
			<DIV WIDTH = 100%>
			    <form action = "" method = "GET" autosugest = "off" aucomplete = "off">
				    <LABEL><font size = 6 color = blue><center><b>Utilizator : </LABEL>
				        <input type="text" name="user" id="hidden" style="width: 0; height: 0; border: 0; padding: 0" />
						<input role = "presentation" type = "text" placeholder = "Nume utilizator" id = "user_box" name = "user" style = "font-size:20;" autoComplete = "new-user" autofill = "off" />
				  	<LABEL><font size = 6 color = blue><center><b>Parola : </LABEL>
				  	    <input type="password" name="hidden" id="hidden" style="width: 0; height: 0; border: 0; padding: 0" />
					    <input role = "presentation" type = "password" id = "pass_box" placeholder = "Parola" name = "pass" style = "font-size:20" autoComplete = "new-password" autofill = "off" /><BR><BR>
		 				<br><input type = "submit" id = "my_button" value = "Deschide Aplicatia" style = "background-color:pink;color:blue;font-size:30;font-weight:bold">
			    </form>
			</DIV>');
		}*/
    ?>

	<script type='text/javascript'>
	    window.onload=function()
		{
			if(document.getElementById('userBox') != null)
			{
				document.getElementById('userBox').focus();
				document.getElementById('userBox').select();
				var userBox = document.getElementById('userBox');
			}
			display_ct();
		}
	    function starttyping()
	    {
		    if(userBox.value.length <= 2)
		    {
				started = Date.now();
		    }
	    }
	    function checkuser()
	    {
		    if(userBox.value.length >= 8)
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
						alert(userchk.responseText);
						var loginData = userchk.responseText.split('^');
						if(loginData.length > 1)
						{
						    userBox.value = loginData[0];
						    document.getElementById('pass_box').value = loginData['1'];
						    document.getElementById('loginForm').submit();
						}
				    }
				}
				if(elapsed <= 200)
				{
					userchk.open('GET','/ramira/magazie/userchk.php?barcode='+userBox.value, true);
				}
				else
				{
				    userchk.open('GET','/ramira/magazie/userchk.php?username='+userBox.value, true);
				}
				userchk.send();
			}
	    }
	</script>
    <BODY>
</HTML>
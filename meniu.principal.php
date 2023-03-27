<HTML>

<HEAD>

	<link rel="stylesheet" href="\ramira\magazie\styles.css">
	<SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
	<SCRIPT>
		function disableBUTTONS() {
			document.getElementById("eliberareprod").disabled = true;
			document.getElementById("imprumutprod").disabled = true;
			document.getElementById("stornoprod").disabled = true;
			document.getElementById("receptie").disabled = true;
			document.getElementById("rapoarteProductie").disabled = true;
			document.getElementById("status").disabled = true;
			document.getElementById("comenziStatus").disabled = true;
			document.getElementById("extras").disabled = true;
		}
		function productionManagerBUTTONS(){
			document.getElementById("rapoarteProductie").disabled = false;
			document.getElementById("eliberareprod").disabled = true;
			document.getElementById("imprumutprod").disabled = true;
			document.getElementById("stornoprod").disabled = true;
			document.getElementById("receptie").disabled = true;
			document.getElementById("status").disabled = true;
			document.getElementById("comenziStatus").disabled = true;
			document.getElementById("extras").disabled = true;
		}
	</SCRIPT>

</HEAD>

<BODY STYLE="BACKGROUND-COLOR: RGB(255,255,255)">
	<DIV ID="scriptMSS"
		STYLE="POSITION: FIXED; BOTTOM: 0.3VH; WIDTH: 100%; FLOAT: NONE; MARGIN: 0 AUTO; HEIGHT: 5%; BORDER-RADIUS: 20px; BORDER: 2PX SOLID RGBA(0, 73, 123); FONT-SIZE: 1vw; TEXT-ALIGN: CENTER; TEXT-TRANSFORM: NONE;">
	</DIV>
	<NAV ID="navBAR">
		<DIV
			STYLE="background-color:RGBA(255,255,255);  WIDTH: 46%; HEIGHT: 4VW; MARGIN-TOP: .25VW; MARGIN-LEFT: .25VW; FLOAT: LEFT; BORDER-RIGHT: 1px SOLID GRAY; BORDER-RADIUS: 15px;">
			<button ID="eliberareprod" CLASS="eliberareprod" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/eliberare%20produs/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Eliberare Produs</button>
			<button ID="imprumutprod" CLASS="imprumutprod" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/imprumuturi/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Imprumut Produs</button>
			<button ID="stornoprod" CLASS="stornoprod" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/storno/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Returnare Produs</button>
			<button ID="receptie" CLASS="receptie" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/receptie%20marfa/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Receptie Marfa</button>
			<DIV><button ID = "rapoarteProductie" CLASS="rapoarte" STYLE="MARGIN-LEFT: .23VW;"
					onclick="location.href='/ramira/magazie/rapoarte/rapoarteproductie/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
					target="_self"><B>Rapoarte Productie</button>
				<DIV ID="alertaRAPOARTE"
					STYLE="BORDER-RADIUS: 20px; BACKGROUND-COLOR: BLUE; HEIGHT: 1vw; WIDTH: 1vw; POSITION: ABSOLUTE; MARGIN-TOP: 0; FLOAT: RIGHT; MARGIN-LEFT: 4.6vw; BORDER: 2px SOLID BLACK; DISPLAY: NONE;">
				</DIV>
			</DIV>
			<button ID="status" CLASS="status" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/magazie/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Status Magazie</button>
			<DIV><button ID="comenziStatus" CLASS="comenzi" STYLE="MARGIN-LEFT: .23VW;"
					onclick="location.href='/ramira/magazie/comenzi/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
					target="_self"><B>Comenzi</button>
				<DIV ID="alertaCOMENZI"
					STYLE="BORDER-RADIUS: 20px; BACKGROUND-COLOR: RED; HEIGHT: .8vw; WIDTH: .8vw; POSITION: ABSOLUTE; MARGIN-TOP: 0; FLOAT: RIGHT; MARGIN-LEFT: 4.6vw; BORDER: 1px SOLID WHITE; DISPLAY: NONE;">
				</DIV>
			</DIV>
			<button ID = "extras" CLASS="extras" STYLE="MARGIN-LEFT: .23VW;"
				onclick="location.href='/ramira/magazie/extras/main.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
				target="_self"><B>Extras</button>
		</DIV>
		<DIV
			STYLE="WIDTH: 43%; HEIGHT: 4VW; MARGIN-TOP: .25VW; BACKGROUND-COLOR: RGBA(255,255,255); COLOR: RGBA(237,28,36); FLOAT: LEFT; TEXT-ALIGN: CENTER; BORDER-LEFT: 1px SOLID GRAY; BORDER-RIGHT: 1px SOLID GRAY; BORDER-RADIUS: 15px; FONT-SIZE: 1.4vw;">
			<DIV
				STYLE="COLOR: RGBA(237,28,36)); FLOAT: LEFT; TEXT-ALIGN: CENTER; MARGIN-TOP: .25VW; WIDTH: 80%; TEXT-TRANSFORM: NONE;">
				<b>Bine ai venit,<BR><SPAN ID="numeGESTIONAR">
						<?php if($nume)echo $nume; else echo 'Unknown user'; ?>
					</SPAN>!<SPAN ID = "marcaUSER" STYLE = "DISPLAY: NONE;"><?php echo $user; ?></SPAN>
			</DIV>
			<DIV>
				<?php 
					if($nume)
             	    {
	                global $user;
		   	   		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		       			if(!$gengrab = $connect -> query("SELECT `gender` FROM `utilizatori` WHERE `username` = '$user'"))
						{
							$filelist = explode(DIRECTORY_SEPARATOR,__FILE__);
		   	   				$length = count($filelist);
		   	   				$file = $filelist[$length - 1];
		   	   				$line = __LINE__;
		   	   				$error = mysqli_error($connect);
		   	   				$mailing = str_replace("'","%27",$error);
		   	   				$mailerror = "<b>FATAL ERROR! MySQL Error: $line. $file: $error. Please, contact program administrator at <a href = 'mailto: warehouse-soft@ramira.ro?subject=Error feedback&body=The program has returned a fatal error:%0A$line. $file:%0AMySQL error: $mailing'>warehouse-soft@ramira.ro</a>";
						   	die('<SCRIPT>document.getElementById("scriptMSS").innerHTML = "'.$mailerror.'";</SCRIPT>');
						}
						if(mysqli_num_rows($gengrab) > 0)
						{
							$genrow = $gengrab -> fetch_assoc();
							$gender = $genrow['gender'];
							if($gender == 0) echo '<IMG SRC = "/ramira/magazie/images/FemaleAvatarIcon.jpg" STYLE = "HEIGHT: 3.2vw; WIDTH: 3.2vw; FLOAT: LEFT; BORDER-RADIUS: 20px">';
							else if($gender == 1) echo '<IMG SRC = "/ramira/magazie/images/MaleAvatarIcon.png" STYLE = "HEIGHT: 3.2vw; WIDTH: 3.2vw; FLOAT: LEFT; BORDER-RADIUS: 20px">';
							else echo '<IMG SRC = "/ramira/magazie/images/NeuterAvatarIcon.png" STYLE = "HEIGHT: 3.2vw; WIDTH: 3.2vw; FLOAT: LEFT; BORDER-RADIUS: 20px">';
					 	}
						else echo '<IMG SRC = "/ramira/magazie/images/NeuterAvatarIcon.png" STYLE = "HEIGHT: 3.2vw; WIDTH: 3.2vw; FLOAT: LEFT; BORDER-RADIUS: 20px">';
                    }
                ?>
				<DIV STYLE="POSITION: ABSOLUTE; MARGIN-TOP: 2.5vw; HEIGHT: 3.5vw; WIDTH: 3.5vw; MARGIN: 0 AUTO; COLOR: BLACK; FONT-SIZE: 0.61vw; FLOAT: NONE; CURSOR: POINTER;"
					ONCLICK="location.href='/ramira/magazie/users%20accounts/myaccount.php?nume=<?php echo $nume.'&userid='.$user; ?>'"
					target="_self" TITLE="CONTUL MEU"><BR><BR><BR><BR><BR>
					<FONT STYLE="FONT-SIZE: .6vw; TEXT-TRANSFORM: NONE;">Contul Meu</FONT>
				</DIV>
			</DIV>
			<IMG SRC="/ramira/magazie/images/logout.jpg"
				STYLE="HEIGHT: 3.2vw; WIDTH: 3.2vw; CURSOR: POINTER; BORDER-RADIUS: 50%; MARGIN-TOP: .2vw; MARGIN-LEFT: .2vw;"
				ONCLICK="window.location = '/ramira/magazie/index.php/';">
		</DIV>
		<DIV STYLE="WIDTH: 10%; HEIGHT: 4VW; MARGIN-TOP: .25VW; BACKGROUND-COLOR:RGBA(255,255,255); COLOR: RGBA(237,28,36); TEXT-ALIGN: CENTER; FLOAT: LEFT; BORDER-LEFT: 1px SOLID GRAY; BORDER-RADIUS: 15px; FONT-SIZE: 1vw;"
			ID="todayNow">
			<?php echo '<BR><b>'.$date.'<br>'.$hour;?>
		</DIV>
	</NAV>
	<BR><BR><BR>
	<?php
	        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	        if(!$accLVL = $connect -> query("SELECT `nivel_ACCES` FROM `utilizatori` WHERE `username` = '$user'"))
			{
				$filelist = explode(DIRECTORY_SEPARATOR,__FILE__);
		   	   	$length = count($filelist);
		   	   	$file = $filelist[$length - 1];
		   	   	$line = __LINE__;
		   	   	$error = mysqli_error($connect);
		   	   	$mailing = str_replace("'","%27",$error);
		   	   	$mailerror = "<b>FATAL ERROR! MySQL Error: $line. $file: $error. Please, contact program administrator at <a href = 'mailto: warehouse-soft@ramira.ro?subject=Error feedback&body=The program has returned a fatal error:%0A$line. $file:%0AMySQL error: $mailing'>warehouse-soft@ramira.ro</a>";
			   	die('<SCRIPT>document.getElementById("scriptMSS").innerHTML = "'.$mailerror.'";</SCRIPT>');
			}
	        if(mysqli_num_rows($accLVL) > 0)
			{
				$accLVLrow = $accLVL -> fetch_assoc();
				$acces = $accLVLrow['nivel_ACCES'];
				if($acces == "GUEST") echo '<SCRIPT>disableBUTTONS()</SCRIPT>';
				else if($acces == "MANAPROD") echo '<SCRIPT>productionManagerBUTTONS()</SCRIPT>';
				else echo '<SCRIPT>
								document.getElementsByClassName("eliberareprod").disabled = false;
								document.getElementsByClassName("imprumutprod").disabled = false;
								document.getElementsByClassName("stornoprod").disabled = false;
								document.getElementsByClassName("receptie").disabled = false;
							</SCRIPT>';
			}
		?>
	<SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
</BODY>
</HTML>